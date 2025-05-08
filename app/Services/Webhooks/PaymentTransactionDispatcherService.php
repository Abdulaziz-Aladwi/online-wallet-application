<?php

namespace App\Services\Webhooks;

use App\Jobs\Webhooks\ProcessTransactionJob;
use Illuminate\Support\Facades\Log;

class PaymentTransactionDispatcherService
{
    /**
     * Dispatch the transactions to the job.
     * 
     * @param array $transactions
     * @return void
     */
    public function dispatch(array $transactions): void
    {
        foreach ($transactions as $transaction) {
            Log::info('Dispatching transaction', ['transaction' => $transaction]);
            ProcessTransactionJob::dispatch($transaction);
        }
    }
}
