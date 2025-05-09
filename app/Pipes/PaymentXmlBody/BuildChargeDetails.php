<?php

namespace App\Pipes\PaymentXmlBody;

use App\Constants\ChargeType;
use Closure;
use App\DTOs\PaymentRequestDto;

class BuildChargeDetails implements XmlBuilderInterface
{
    /**
     * Build charge details element.
     * 
     * @param PaymentRequestDto $paymentDto
     * @param Closure $next
     * @return PaymentRequestDto
     */ 
    public function handle(PaymentRequestDto $paymentDto, Closure $next): PaymentRequestDto
    {
        if ($paymentDto->chargeDetails == ChargeType::SHA) {
            return $next($paymentDto);
        }

        $xml = $paymentDto->xml;
        $xml->addChild('ChargeDetails', $paymentDto->chargeDetails);

        return $next($paymentDto);
    }
}
