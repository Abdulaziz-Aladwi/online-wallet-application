<?php

namespace App\Services\Webhooks;

use App\DTOs\ParsedTransactionDto;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Cache\CacheManager;

class CreateTransactionService
{
    private const LOCK_TIMEOUT = 10;
    private const BLOCK_TIMEOUT = 5;

    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private CacheManager $cacheManager,
        private UserRepositoryInterface $userRepository
    ) {}

    /**
     * Create a transaction.
     * 
     * @param ParsedTransactionDto $transaction
     * @return Transaction
     */
    public function execute(ParsedTransactionDto $transaction): Transaction
    {
        # Assuming that user is the owner of the transaction, for simplicity, get first user
        $defaultUser = $this->userRepository->first();
        $lockKey = "transaction:{$transaction->reference}";

        # Locking the transaction on app level to avoid race conditions, also handled on database level with unique index on reference
        return $this->cacheManager->lock($lockKey, self::LOCK_TIMEOUT)->block(self::BLOCK_TIMEOUT, function () use ($transaction, $defaultUser) {
            return $this->transactionRepository->firstOrCreate(
                ['user_id' => $defaultUser->id, 'reference' => $transaction->reference],
                [
                    'amount' => $transaction->amount,
                    'date' => $transaction->date,
                    'meta' => $transaction->meta,
                    'bank_type' => $transaction->bank_type,
                ]
            );
        });
    }
}
