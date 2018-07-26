<?php

namespace App\Repositories;
use App\Transaction;
use App\User;
use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Carbon;

class TransactionsRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Transaction::class;
    }

    public function findByFilter(array $filter)
    {
        $qb = Transaction::where('customer_id', $filter['customerId']);

        if (isset($filter['date'])) {
            $qb->whereDate('created_at', '=', $filter['date']);
        }

        if (isset($filter['offset'])) {
            $qb->skip($filter['offset']);
        }

        if (isset($filter['limit'])) {
            $qb->take($filter['limit']);
        }

        if (isset($filter['amount'])) {
            $qb->where('amount', $filter['amount']);
        }

        return $qb->get();
    }

    public function getPreviousDaySummary()
    {
        return Transaction::whereDate('created_at', '=', Carbon::yesterday()->toDateString())->sum('amount');
    }

    public function getByUser(User $user)
    {
        $transactions = [];

        foreach ($user->customers as $customer) {
            foreach ($customer->transactions as $transaction) {
                $transactions[] = $transaction;
            }
        }

        return $transactions;
    }
}