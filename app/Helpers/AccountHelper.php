<?php

namespace App\Helpers;


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
            $account->balance = AccountsHistoryHelper::getAccountBalance($account->id);
        }

        return $accounts;
    }
}