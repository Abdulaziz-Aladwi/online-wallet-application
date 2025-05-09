<?php

namespace App\Pipes\PaymentXmlBody;

use Closure;
use App\DTOs\PaymentRequestDto;

class BuildSenderInfo implements XmlBuilderInterface
{
    /**
     * Build sender info element.
     * 
     * @param PaymentRequestDto $paymentDto
     * @param Closure $next
     * @return PaymentRequestDto
     */
    public function handle(PaymentRequestDto $paymentDto, Closure $next): PaymentRequestDto
    {
        $xml = $paymentDto->xml;
        $sender = $xml->addChild('SenderInfo');
        $sender->addChild('AccountNumber', $paymentDto->accountNumber);

        return $next($paymentDto);
    }
}
