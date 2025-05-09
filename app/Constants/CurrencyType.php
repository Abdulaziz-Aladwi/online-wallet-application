<?php

namespace App\Constants;

class CurrencyType
{
    public const SAR = 'SAR';

    public static function values(): array
    {
        return [
            self::SAR,
        ];
    }
}
