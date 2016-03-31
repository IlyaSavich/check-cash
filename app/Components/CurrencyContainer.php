<?php

namespace App\Components;

use App\Currency;

class CurrencyContainer
{
    /**
     * Get currency name by id
     * @param $currencyId
     *
     * @return mixed
     */
    public static function getCurrencyName($currencyId)
    {
        return Currency::select('name')->where('id', $currencyId)->get()->get(0)->name;
    }
}