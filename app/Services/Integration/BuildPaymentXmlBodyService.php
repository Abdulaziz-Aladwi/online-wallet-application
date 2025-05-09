<?php

namespace App\Services\Integration;

use App\DTOs\PaymentRequestDto;
use App\Pipes\PaymentXmlBody\BuildChargeDetails;
use App\Pipes\PaymentXmlBody\BuildNotes;
use App\Pipes\PaymentXmlBody\BuildPaymentRequestMessage;
use App\Pipes\PaymentXmlBody\BuildPaymentType;
use App\Pipes\PaymentXmlBody\BuildReceiverInfo;
use App\Pipes\PaymentXmlBody\BuildSenderInfo;
use App\Pipes\PaymentXmlBody\BuildTransferInfo;
use Illuminate\Pipeline\Pipeline;

class BuildPaymentXmlBodyService
{
    public function __construct(
        private readonly Pipeline $pipeline
    ) {}

    /**
     * Build payment XML using pipeline pattern
     *
     * @param PaymentRequestDto $paymentDto
     * @return PaymentRequestDto
     */
    public function execute(PaymentRequestDto $paymentDto): PaymentRequestDto
    {
        return $this->pipeline
            ->send($paymentDto)
            ->through([
                BuildPaymentRequestMessage::class,
                BuildTransferInfo::class,
                BuildSenderInfo::class,
                BuildReceiverInfo::class,
                BuildNotes::class,
                BuildPaymentType::class,
                BuildChargeDetails::class
            ])
            ->thenReturn();
    }
}
