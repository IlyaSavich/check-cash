<?php

namespace App\Helpers;

use App\Currency;
use App\Http\Requests\CreateTransactionRequest;
use App\Models\accounts\AccountsHistory;

class AccountsHistoryContainer
{
    const HISTORY_LIMIT = 5;
    /**
     * Check the type of transaction. If `expense` than change the money sign
     *
     * @param $transactionData array of input transaction data
     *
     * @return mixed array of edit transaction data
     */
    public static function checkTransactionType($transactionData)
    {
        $transactionData['money'] = $transactionData['transaction_type'] ?
            $transactionData['money'] * (-1) : $transactionData['money'];

        return $transactionData;
    }

    /**
     * Select all transaction for an account on the given range
     *
     * @param $accountId
     * @param $interval
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getTransactionsByInterval($accountId, $interval)
    {
        return AccountsHistory::select(['money', 'created_at'])->where('account_id', $accountId)
            ->whereBetween('created_at', [$interval['from'], $interval['to']])->orderBy('created_at')->get();
    }

    /**
     * Get account balance by account id
     *
     * @param $accountId
     *
     * @return float|int
     */
    public static function getAccountBalance($accountId)
    {
        return AccountsHistory::where('account_id', $accountId)->sum('money');
    }

    /**
     * Store new transaction
     *
     * @param CreateTransactionRequest $request
     *
     * @return AccountsHistory
     */
    public static function storeNewTransaction(CreateTransactionRequest $request)
    {
        return AccountsHistory::create(self::checkTransactionType($request->all()));
    }

    /**
     * @param $accountId
     *
     * @return AccountsHistory
     */
    public static function getLastFiveAccountTransactions($accountId)
    {
        return AccountsHistory::where('account_id', $accountId)->orderBy('created_at', 'desc')
            ->limit(self::HISTORY_LIMIT)->get();
    }

    /**
     * Get account history
     * @param $accountId
     *
     * @return AccountsHistory
     */
    public static function getHistory($accountId)
    {
        $transactions = AccountsHistoryContainer::getLastFiveAccountTransactions($accountId);
        foreach ($transactions as $transaction) {
            $transaction->currency = CurrencyContainer::getCurrencyName($transaction->currency_id);
        }

        return $transactions;
    }
}