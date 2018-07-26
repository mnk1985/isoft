<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Transaction extends Model
{
    const AMOUNT_MIN_VALUE = 0;

    protected $primaryKey = 'id';
    protected $table = 'transactions';
    protected $fillable = [
        'customer_id',
        'amount',
    ];
    protected $dates = [
        'created_at',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
