<?php

namespace App\Parsers\Webhooks;

use App\Constants\BankType;
use App\DTOs\ParsedTransactionDto;
use App\Parsers\Webhooks\TransactionParserInterface;
use DateTime;
use Illuminate\Support\Facades\Log;

class FoodicsBankTransactionParser implements TransactionParserInterface
{
    const STARTING_INDEX = 0;
    const DATE_LENGTH = 8;
    const EXPLODE_LIMIT = 3;

    /**
     * Parse the transaction and return ParsedTransactionDto
     * 
     * @param string $transaction
     * @return ParsedTransactionDto
     */
    public function parse(string $transaction): ParsedTransactionDto
    {
        [$dateAmount, $reference, $rawMetaData] = explode('#', $transaction, self::EXPLODE_LIMIT);
        
        $amount = $this->getAmount($dateAmount);
        $date = $this->getDate($dateAmount);
        $metaData = $this->getMetaData($rawMetaData);
        
        $parsedTransactionDto = ParsedTransactionDto::fromArray([
            'amount' => $amount,
            'reference' => $reference,
            'date' => $date,
            'meta' => $metaData,
            'bank_type' => BankType::FOODICS_BANK_TYPE
        ]);  

        Log::info('Parsed transaction', ['parsedTransactionDto' => $parsedTransactionDto]);

        return $parsedTransactionDto;
    }

    /**
     * Get the date from the transaction
     * 
     * @param string $dateAmount
     * @return string
     */
    private function getDate(string $dateAmount): string
    {
        $dateString = substr($dateAmount, self::STARTING_INDEX, self::DATE_LENGTH);
        return DateTime::createFromFormat('Ymd', $dateString)->format('Y-m-d');
    }

    /**
     * Get the amount from the transaction
     * 
     * @param string $dateAmount
     * @return string
     */
    private function getAmount(string $dateAmount): string
    {
        return str_replace(',', '.', substr($dateAmount, self::DATE_LENGTH));
    }

    private function getMetaData(string $rawMetaData): array
    {
        $parsedMetaData = [];
        $rawMetaData = explode('/', $rawMetaData);
        
        for ($i = 0; $i < count($rawMetaData); $i += 2) {
            if (isset($rawMetaData[$i + 1])) {
                $key = $rawMetaData[$i];
                $value = $rawMetaData[$i + 1];
                $parsedMetaData[$key] = $value;
            }
        }

        return $parsedMetaData;
    }
}
