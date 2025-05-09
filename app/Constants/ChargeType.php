<?php

namespace App\Constants;

class ChargeType
{
    public const RB = 'RB';
    public const SHA = 'SHA';

    /**
     * Get all the values of the charge type
     *
     * @return array
     */
    public static function values(): array
    {
        return [
            self::RB,
            self::SHA,
        ];
    }
}
