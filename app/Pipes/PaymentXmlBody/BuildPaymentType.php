<?php

namespace App\Pipes\PaymentXmlBody;

use Closure;
use App\DTOs\PaymentRequestDto;

class BuildPaymentType implements XmlBuilderInterface
{
    public const SPECIAL_PAYMENT_TYPE = 99;

    /**
     * Build payment type element.
     * 
     * @param PaymentRequestDto $paymentDto
     * @param Closure $next
     * @return PaymentRequestDto
     */
    public function handle(PaymentRequestDto $paymentDto, Closure $next): PaymentRequestDto
    {
        if ($paymentDto->paymentType == self::SPECIAL_PAYMENT_TYPE) {
            return $next($paymentDto);
        }

        $xml = $paymentDto->xml;
        $xml->addChild('PaymentType', $paymentDto->paymentType);

        return $next($paymentDto);
    }
}
