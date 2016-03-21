<?php

namespace App\Helpers;

use App\Currency;

class CurrencyContainer
{
    public static function getCurrencyName($currencyId)
    {
        return Currency::select('name')->where('id', $currencyId)->get()->get(0)->name;
    }
}