<?php

namespace App\Parsers\Webhooks;

use App\DTOs\ParsedTransactionDto;

interface TransactionParserInterface
{
    /**
     * Parse the transaction and return an array of data.
     *
     * @param string $transaction
     * @return ParsedTransactionDto
     */
    public function parse(string $transaction): ParsedTransactionDto;
}
