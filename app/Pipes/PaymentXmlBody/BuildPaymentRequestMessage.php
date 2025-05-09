<?php

namespace App\Pipes\PaymentXmlBody;

use App\DTOs\PaymentRequestDto;
use Closure;

class BuildPaymentRequestMessage implements XmlBuilderInterface
{
    /**
     * Build payment request message (root) element.
     * 
     * @param PaymentRequestDto $paymentDto
     * @param Closure $next
     * @return PaymentRequestDto
     */
    public function handle(PaymentRequestDto $paymentDto, Closure $next): PaymentRequestDto
    {
        $xml = new \SimpleXMLElement('<PaymentRequestMessage/>');
        $paymentDto->xml = $xml;

        return $next($paymentDto);
    }
}
