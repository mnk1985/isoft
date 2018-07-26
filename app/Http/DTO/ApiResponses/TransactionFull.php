<?php

namespace App\Http\DTO\ApiResponses;

use App\Transaction;

class TransactionFull extends TransactionShort
{
    public $customerId;

    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
        $this->customerId = $transaction->getCustomerId();
    }
}