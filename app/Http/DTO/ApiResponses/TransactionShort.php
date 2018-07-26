<?php

namespace App\Http\DTO\ApiResponses;

use App\Transaction;

class TransactionShort extends BaseResponse
{
    public $transactionId;
    public $amount;
    public $date;

    public function __construct(Transaction $transaction)
    {
        $this->transactionId = $transaction->getId();
        $this->date = $transaction->getCreatedAt()->format('Y-m-d');
        $this->amount = $transaction->getAmount();
    }
}