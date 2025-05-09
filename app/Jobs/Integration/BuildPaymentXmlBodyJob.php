<?php

namespace App\Jobs\Integration;

use App\DTOs\PaymentRequestDto;
use App\Services\Integration\BuildPaymentXmlBodyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BuildPaymentXmlBodyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param PaymentRequestDto $paymentDto
     */
    public function __construct(
        private readonly PaymentRequestDto $paymentDto
    ) {}

    /**
     * Execute the job.
     * 
     * @param BuildPaymentXmlBodyService $buildPaymentXmlBodyService
     * @return void
     */
    public function handle(BuildPaymentXmlBodyService $buildPaymentXmlBodyService): void
    {
        $paymentDto = $buildPaymentXmlBodyService->execute($this->paymentDto);
        $xml =  $paymentDto->xml->asXML();
    
        # Just logging the XML for now
        Log::info('Payment XML body built', ['xml' => $xml]);
    }
}
