<?php

namespace App\Helpers;

class Utilities
{
    public static function moneyFormat($value): string
    {
        return isset($value) ? '$' . number_format($value, 2) : '--';
    }
}
