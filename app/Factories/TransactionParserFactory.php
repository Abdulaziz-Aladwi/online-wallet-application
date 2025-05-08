<?php

namespace App\Factories;

use App\Parsers\Webhooks\AcmeBankTransactionParser;
use App\Parsers\Webhooks\FoodicsBankTransactionParser;
use App\Parsers\Webhooks\TransactionParserInterface;

class TransactionParserFactory
{
    public function make(string $transaction): TransactionParserInterface
    {
        $transaction = trim($transaction);

        return match(true) {
            str_contains($transaction, '#') => new FoodicsBankTransactionParser(),
            str_contains($transaction, '//') => new AcmeBankTransactionParser(),
            default => throw new \InvalidArgumentException('Unknown bank format for transaction: ' . $transaction)
        };
    }
}
