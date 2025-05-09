<?php

namespace App\DTOs;

use Illuminate\Support\Str;

class PaymentRequestDto
{
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $accountNumber,
        public readonly string $beneficiaryName,
        public readonly string $beneficiaryAccountNumber,
        public readonly string $beneficiaryBankCode,
        public readonly array $notes = [],
        public readonly string $paymentType,
        public readonly string $chargeDetails,
        public readonly ?\DateTime $date = null,
        public readonly ?string $reference = null,
        public ?\SimpleXMLElement $xml = null,
    ) {
    }

    /**
     * Create a new instance from an array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data['amount'],
            currency: $data['currency'],
            accountNumber: $data['account_number'],
            beneficiaryName: $data['beneficiary_name'],
            beneficiaryAccountNumber: $data['beneficiary_account_number'],
            beneficiaryBankCode: $data['beneficiary_bank_code'],
            notes: $data['notes'] ?? [],
            paymentType: $data['payment_type'],
            chargeDetails: $data['charge_details'],
            date: $data['date'] ?? now(),
            reference: $data['reference'] ?? Str::random(10),
            xml: $data['xml'] ?? null,
        );
    }

    /**
     * Convert the DTO to an array.
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'account_number' => $this->accountNumber,
            'beneficiary_name' => $this->beneficiaryName,
            'beneficiary_account_number' => $this->beneficiaryAccountNumber,
            'beneficiary_bank_code' => $this->beneficiaryBankCode,
            'notes' => $this->notes,
            'payment_type' => $this->paymentType,
            'charge_details' => $this->chargeDetails,
            'date' => $this->date?->format('Y-m-d H:i:sP'),
            'reference' => $this->reference,
            'xml' => $this->xml,
        ];
    }
}
