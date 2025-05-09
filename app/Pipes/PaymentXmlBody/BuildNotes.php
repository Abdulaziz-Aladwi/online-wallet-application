<?php

namespace App\Pipes\PaymentXmlBody;

use Closure;
use App\DTOs\PaymentRequestDto;

class BuildNotes implements XmlBuilderInterface
{
    /**
     * Build notes element.
     * 
     * @param PaymentRequestDto $paymentDto
     * @param Closure $next
     * @return PaymentRequestDto
     */
    public function handle(PaymentRequestDto $paymentDto, Closure $next): PaymentRequestDto
    {
        if (empty($paymentDto->notes)) {
            return $next($paymentDto);
        }

        $xml = $paymentDto->xml;
        $notesElement = $xml->addChild('Notes');
        foreach ($paymentDto->notes as $note) {
            $notesElement->addChild('Note', $note);
        }

        return $next($paymentDto);
    }
}
