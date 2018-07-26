<?php

namespace App\Http\DTO\ApiResponses;

use Illuminate\Support\Collection;

class TransactionListResponse
{
    public $transactions = [];

    public function __construct(Collection $transactions)
    {
        foreach ($transactions as $transaction){
            $this->transactions[] = new TransactionShort($transaction);
        }
    }

    public function __toString()
    {
        return '{'.json_encode($this->transactions).'}';
    }
}