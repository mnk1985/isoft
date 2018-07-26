<?php

namespace App\Http\Controllers;

use App\Repositories\TransactionsRepository;
use Bosnadev\Repositories\Contracts\RepositoryInterface;

class TransactionController extends Controller
{
    /**
     * @var TransactionsRepository
     */
    private $transactions;

    public function __construct(RepositoryInterface $transactions)
    {
        $this->transactions = $transactions;
    }

    public function index()
    {
        $transactions = $this->transactions->getByUser(\Auth::user());

        return view('transactions.index', [
            'transactions' => $transactions,
        ]);
    }
}