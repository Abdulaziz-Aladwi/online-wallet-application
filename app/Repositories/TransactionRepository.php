<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Create a new transaction.
     * 
     * @param array $uniqueData
     * @param array $data
     * @return Transaction
     */
    public function firstOrCreate(array $uniqueData, array $data): Transaction
    {
        return Transaction::firstOrCreate($uniqueData, $data);
    }
}
