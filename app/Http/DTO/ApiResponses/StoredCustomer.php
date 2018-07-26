<?php

namespace App\Http\DTO\ApiResponses;

class StoredCustomer extends BaseResponse
{
    public $customerId;

    public function __construct(\App\Customer $customer)
    {
        $this->customerId = $customer->getId();
    }
}