<?php

namespace App\Repositories\Contracts;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    /**
     * Get a transaction by reference.
     * 
     * @param array $uniqueData
     * @param array $data
     * @return Transaction
     */
    public function firstOrCreate(array $uniqueData, array $data): Transaction;
}
