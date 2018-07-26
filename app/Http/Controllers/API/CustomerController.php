<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\DTO\ApiResponses\StoredCustomer;
use App\Http\Requests\StoreCustomer;
use App\User;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Illuminate\Http\Response;

class CustomerController extends BaseApiController
{
    /**
     * @var RepositoryInterface
     */
    private $customers;

    public function __construct(RepositoryInterface $customers)
    {
        $this->customers = $customers;
        $this->middleware('auth:api');
    }


    /**
     * Store a newly created customer in storage.
     *
     * @param  StoreCustomer  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request)
    {
        $input = $request->validated();
        /** @var User $user */
        $user = $this->getAuth()->user();
        $input['user_id'] = $user ? $user->getId(): null;

        /** @var Customer $customer */
        $customer = $this->customers->create($input);

        return new Response(new StoredCustomer($customer));
    }


}
