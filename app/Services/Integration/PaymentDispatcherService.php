<?php

namespace App\Services\Integration;

use App\DTOs\PaymentRequestDto;
use App\Jobs\Integration\BuildPaymentXmlBodyJob;
use Illuminate\Support\Facades\Log;

class PaymentDispatcherService
{
    /**
     * Dispatch the payment to the job.
     * 
     * @param PaymentRequestDto $paymentDto
     * @return void
     */
    public function dispatch(PaymentRequestDto $paymentDto): void
    {
        BuildPaymentXmlBodyJob::dispatch($paymentDto);
        Log::info('Payment Xml data builder dispatched', ['paymentDto' => $paymentDto]);
    }
}
