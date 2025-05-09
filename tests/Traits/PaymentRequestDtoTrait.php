<?php

namespace Tests\Traits;

use App\DTOs\PaymentRequestDto;

trait PaymentRequestDtoTrait
{
    /**
     * Get a payment request DTO without any conditions
     *
     * @return PaymentRequestDto
     */
    private function getPaymentRequestDto(): PaymentRequestDto
    {
        return new PaymentRequestDto(
            amount: 20,
            currency: 'SAR',
            accountNumber: 'SA6980000204608016212908',
            beneficiaryName: 'Jane Doe',
            beneficiaryBankCode: 'FDCSSARI',
            beneficiaryAccountNumber: 'SA6980000204608016211111',
            paymentType: 421,
            chargeDetails: 'RB',
            notes: ['test1', 'test2'],
        );
    }

    /**
     * Get a payment request DTO with empty notes
     *
     * @return PaymentRequestDto
     */
    private function getPaymentRequestDtoWithEmptyNotes(): PaymentRequestDto
    {
        return new PaymentRequestDto(
            amount: 20,
            currency: 'SAR',
            accountNumber: 'SA6980000204608016212908',
            beneficiaryName: 'Jane Doe',
            beneficiaryBankCode: 'FDCSSARI',
            beneficiaryAccountNumber: 'SA6980000204608016211111',
            paymentType: 421,
            chargeDetails: 'RB',
            notes: [],
        );
    }

    /**
     * Get a payment request DTO with payment type not equals 421
     *
     * @return PaymentRequestDto
     */
    private function getPaymentRequestDtoWithPaymentTypeNotEquals421(): PaymentRequestDto
    {
        return new PaymentRequestDto(
            amount: 20,
            currency: 'SAR',
            accountNumber: 'SA6980000204608016212908',
            beneficiaryName: 'Jane Doe',
            beneficiaryBankCode: 'FDCSSARI',
            beneficiaryAccountNumber: 'SA6980000204608016211111',
            paymentType: 300,
            chargeDetails: 'RB',
            notes: [],
        );
    }

    /**
     * Get a payment request DTO with charge details not equals SHA
     *
     * @return PaymentRequestDto
     */
    private function getPaymentRequestDtoWithChargeDetailsNotEqualsSHA(): PaymentRequestDto
    {
        return new PaymentRequestDto(
            amount: 20,
            currency: 'SAR',
            accountNumber: 'SA6980000204608016212908',
            beneficiaryName: 'Jane Doe',
            beneficiaryBankCode: 'FDCSSARI',
            beneficiaryAccountNumber: 'SA6980000204608016211111',
            paymentType: 300,
            chargeDetails: 'RB',
            notes: [],
        );
    }
}
