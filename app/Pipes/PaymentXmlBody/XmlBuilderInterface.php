<?php

namespace App\Pipes\PaymentXmlBody;

use App\DTOs\PaymentRequestDto;
use Closure;

interface XmlBuilderInterface
{
    /**
     * Build the XML body.
     * 
     * @param PaymentRequestDto $paymentDto
     * @param Closure $next
     * @return PaymentRequestDto
     */
    public function handle(PaymentRequestDto $paymentDto, Closure $next): PaymentRequestDto;
}
