<?php

namespace App\Components;

use App\Http\Requests\CreateAccountRequest;
use App\Models\accounts\Account;

class AccountContainer
{
    /**
     * Get all accounts and add `balance` field to each account
     * @return array Account accounts
     */
    public static function getAllAccounts()
    {
        /** @var Account $accounts */
        $accounts = Account::all();
        foreach($accounts as $account) {
            $account->balance = AccountsHistoryContainer::getAccountBalance($account->id);
        }

        return $accounts;
    }

    /**
     * Store new account in database and return it instance
     * @param CreateAccountRequest $request
     * @return Account
     */
    public static function storeNewAccount(CreateAccountRequest $request)
    {
        return Account::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));
    }

    /**
     * Get account by id and set the balance field to the collection
     * @param $accountId
     *
     * @return Account
     */
    public static function getFullInfoAboutAccount($accountId)
    {
        /* @var $account Account */
        $account = Account::findOrFail($accountId);
        $account->balance = AccountsHistoryContainer::getAccountBalance($accountId);
        $account->currentMonthIncome = AccountsHistoryContainer::getIncomeForCurrentMonth($accountId);

        return $account;
    }

    /**
     * Get account by id
     * @param $accountId
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function getAccount($accountId)
    {
        return Account::findOrFail($accountId);
    }

    /**
     * Update account
     * @param $accountId
     * @param CreateAccountRequest $request
     *
     * @return Account
     */
    public static function updateAccount($accountId, CreateAccountRequest $request)
    {
        $account = Account::findOrFail($accountId);
        $account->update(array_merge($request->all(), ['user_id' => \Auth::user()->id]));

        return $account;
    }

    /**
     * Delete account
     * @param $accountId
     *
     * @return int
     */
    public static function deleteAccount($accountId)
    {
        return Account::destroy($accountId);
    }
}