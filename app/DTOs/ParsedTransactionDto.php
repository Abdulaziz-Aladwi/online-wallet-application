<?php

namespace App\DTOs;

use DateTime;

class ParsedTransactionDto
{
    public function __construct(
        public readonly float $amount,
        public readonly string $reference,
        public readonly DateTime $date,
        public readonly array $meta = [],
        public readonly int $bank_type
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data['amount'],
            reference: $data['reference'],
            date: DateTime::createFromFormat('Y-m-d', $data['date']),
            meta: $data['meta'] ?? [],
            bank_type: $data['bank_type']
        );
    }
}
