<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\DTO\ApiResponses\ErrorResponse;
use App\Http\DTO\ApiResponses\StatusResponse;
use App\Http\DTO\ApiResponses\TransactionListResponse;
use App\Http\DTO\ApiResponses\TransactionShort;
use App\Http\DTO\ApiResponses\TransactionFull;
use App\Http\Requests\FilterTransaction;
use App\Http\Requests\StoreTransaction;
use App\Http\Requests\UpdateTransaction;
use App\Repositories\CustomersRepository;
use App\Repositories\TransactionsRepository;
use App\Transaction;
use Illuminate\Http\Response;

class TransactionController extends BaseApiController
{
    /**
     * @var TransactionsRepository
     */
    private $transactions;
    /**
     * @var CustomersRepository
     */
    private $customers;

    public function __construct(TransactionsRepository $transactions, CustomersRepository $customers)
    {
        $this->transactions = $transactions;
        $this->customers = $customers;
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the transactions
     *
     * @return \Illuminate\Http\Response
     */
    public function filterPost(FilterTransaction $request)
    {
        $filter = $request->validated();

        return $this->findTransactionsByFilter($filter);
    }

    /**
     * @param $customerId
     * @param float|null $amount
     * @param string|null $date
     * @param int|null $offset
     * @param int|null $limit
     * @return Response
     */
    public function filterGet($customerId, float $amount = null, string $date = null, int $offset = null, int $limit = null)
    {
        $filter = [
            'customerId' => $customerId,
            'amount' => $amount,
            'date' => $date,
            'offset' => $offset,
            'limit' => $limit,
        ];

        return $this->findTransactionsByFilter($filter);
    }

    /**
     * @param array $filter
     * @return Response
     */
    private function findTransactionsByFilter(array $filter)
    {
        $transactions = $this->transactions->findByFilter($filter);

        return new Response(new TransactionListResponse($transactions));
    }

    /**
     * Store a newly created transactions in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransaction $request)
    {
        $input = $request->validated();
        /** @var Customer $customer */
        $customer = $this->customers->find($input['customerId']);

        if (!$customer) {
            return new Response(new ErrorResponse('customer not found'), 400);
        }

        $user = $this->getUser();

        if($user->cant('create', [Transaction::class, $customer])) {
            return new Response(new ErrorResponse('permission denied'), 400);
        }

        $input['customer_id'] = $customer->getId();

        /** @var Transaction $transaction */
        $transaction = $this->transactions->create($input);

        return new Response(new TransactionFull($transaction));
    }

    /**
     * Display the specified transaction.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$transaction = $this->transactions->find($id)) {
            return new Response(new ErrorResponse('transaction not found'), 400);
        }

        if ($this->getUser()->cant('view', $transaction)) {
            return new Response(new ErrorResponse('permission denied'), 401);
        }

        return new Response(new TransactionShort($transaction));
    }

    /**
     * @param $customerId
     * @param $transactionId
     * @return Response
     */
    public function showGet($customerId, $transactionId)
    {
        if (!$transaction = $this->transactions->find($transactionId)) {
            return new Response(new ErrorResponse('transaction not found'), 400);
        }

        if ($transaction->customer->getId() != $customerId) {
            return new Response(new ErrorResponse('permission denied'), 401);
        }

        return new Response(new TransactionShort($transaction));
    }

    /**
     * Update the specified transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransaction $request, $id)
    {
        $input = $request->validated();

        if (!$transaction = $this->transactions->find($id)) {
            return new Response(new ErrorResponse('transaction not found'), 400);
        }

        if ($this->getUser()->cant('update', $transaction)) {
            return new Response(new ErrorResponse('permission denied'), 401);
        }

        if (!$this->transactions->update($input, $id)) {
            return new Response(new ErrorResponse('failed to update'), 400);
        }

        return new Response(new TransactionFull($this->transactions->find($id)));
    }

    /**
     * Remove the specified transaction from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$transaction = $this->transactions->find($id)) {
            return new Response(new ErrorResponse('transaction not found'), 400);
        }

        if ($this->getUser()->cant('delete', $transaction)) {
            return new Response(new ErrorResponse('permission denied'), 401);
        }

        return new Response(new StatusResponse($this->transactions->delete( $id)));
    }
}
