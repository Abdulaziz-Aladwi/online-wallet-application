<?php

namespace App\Constants;

class BankType  
{
    public const FOODICS_BANK_NAME = 'Foodics Bank';
    public const FOODICS_BANK_TYPE = 1;

    public const ACME_BANK_NAME = 'Acme Bank';
    public const ACME_BANK_TYPE = 2;

    public static function getBankNameByType(int $type): string
    {
        $banks = [
            self::FOODICS_BANK_TYPE => self::FOODICS_BANK_NAME,
            self::ACME_BANK_TYPE => self::ACME_BANK_NAME,
        ];

        return $banks[$type];
    }
}
