<?php

namespace App\Helpers;


use App\Models\accounts\AccountsHistory;

class AccountHelper
{
    /**
     * Add `balance` field to each account
     * @param $accounts array
     *
     * @return array Modified accounts
     */
    public static function mergeAccountWithMoney($accounts)
    {
        foreach($accounts as $account) {
            $account->balance = AccountsHistory::where('account_id', $account->id)->sum('money');
        }

        return $accounts;
    }
}