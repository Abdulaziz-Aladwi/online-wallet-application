<?php

namespace App\Pipes\PaymentXmlBody;

use Closure;
use App\DTOs\PaymentRequestDto;

class BuildTransferInfo implements XmlBuilderInterface
{
    /**
     * Build transfer info element.
     * 
     * @param PaymentRequestDto $paymentDto
     * @param Closure $next
     * @return PaymentRequestDto
     */
    public function handle(PaymentRequestDto $paymentDto, Closure $next): PaymentRequestDto
    {
        $xml = $paymentDto->xml;
        $transferInfo = $xml->addChild('TransferInfo');
        $transferInfo->addChild('Reference', $paymentDto->reference);
        $transferInfo->addChild('Date', $paymentDto->date);
        $transferInfo->addChild('Amount', $paymentDto->amount);
        $transferInfo->addChild('Currency', $paymentDto->currency);

        return $next($paymentDto);
    }
}
