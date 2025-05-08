<?php

namespace App\Parsers\Webhooks;

use App\Constants\BankType;
use App\DTOs\ParsedTransactionDto;
use App\Parsers\Webhooks\TransactionParserInterface;
use DateTime;
use Illuminate\Support\Facades\Log;

class AcmeBankTransactionParser implements TransactionParserInterface
{
    const EXPLODE_LIMIT = 3;

    /**
     * Parse the transaction and return ParsedTransactionDto
     * 
     * @param string $transaction
     * @return ParsedTransactionDto
     */
    public function parse(string $transaction): ParsedTransactionDto
    {

        [$amount, $reference, $date] = explode('//', $transaction, self::EXPLODE_LIMIT);
        
        $amount = $this->getAmount($amount);
        $date = $this->getDate($date);
        
        $parsedTransactionDto = ParsedTransactionDto::fromArray([
            'amount' => $amount,
            'reference' => $reference,
            'date' => $date,
            'bank_type' => BankType::ACME_BANK_TYPE
        ]);

        Log::info('Parsed transaction', ['parsedTransactionDto' => $parsedTransactionDto]);
        return $parsedTransactionDto;
    }
    
    /**
     * Get the amount from the transaction
     * 
     * @param string $amount
     * @return string
     */
    private function getAmount(string $amount): string
    {
        return str_replace(',', '.', $amount);
    }

    /**
     * Get the date from the transaction
     * 
     * @param string $date
     * @return string
     */
    private function getDate(string $date): string
    {
        return DateTime::createFromFormat('Ymd', $date)->format('Y-m-d');
    }
}
