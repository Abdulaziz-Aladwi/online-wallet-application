<?php

namespace App\Pipes\PaymentXmlBody;

use Closure;
use App\DTOs\PaymentRequestDto;

class BuildReceiverInfo implements XmlBuilderInterface
{
    /**
     * Build receiver info element.
     * 
     * @param PaymentRequestDto $paymentDto
     * @param Closure $next
     * @return PaymentRequestDto
     */
    public function handle(PaymentRequestDto $paymentDto, Closure $next): PaymentRequestDto
    {
        $xml = $paymentDto->xml;
        $receiver = $xml->addChild('ReceiverInfo');
        $receiver->addChild('BankCode', $paymentDto->beneficiaryBankCode);
        $receiver->addChild('AccountNumber', $paymentDto->beneficiaryAccountNumber);
        $receiver->addChild('BeneficiaryName', $paymentDto->beneficiaryName);

        return $next($paymentDto);
    }
}
