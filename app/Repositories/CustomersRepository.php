<?php

namespace App\Repositories;
use App\Customer;
use Bosnadev\Repositories\Eloquent\Repository;

class CustomersRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Customer::class;
    }
}