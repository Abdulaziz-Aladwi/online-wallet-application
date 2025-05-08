<?php

namespace App\Jobs\Webhooks;

use App\Factories\TransactionParserFactory;
use App\Services\Webhooks\CreateTransactionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessTransactionJob implements ShouldQueue
{
    use Queueable;

    private string $transaction;

    /**
     * Create a new job instance.
     */
    public function __construct(string $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     * 
     * @param TransactionParserFactory $transactionParserFactory
     * @param CreateTransactionService $createTransactionService
     * @return void
     * 
     * @throws Throwable
     */
    public function handle(TransactionParserFactory $transactionParserFactory, CreateTransactionService $createTransactionService): void
    {
        try {
            $transactionParser = $transactionParserFactory->make($this->transaction);
            $transactionDto = $transactionParser->parse($this->transaction);
            $createTransactionService->execute($transactionDto);
        } catch (Throwable $e) {
            Log::error('Error in processing transaction', [
                'transaction' => $this->transaction,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
