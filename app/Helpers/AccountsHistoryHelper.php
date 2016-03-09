<?php

namespace App\Helpers;

use App\Models\accounts\AccountsHistory;

class AccountsHistoryHelper
{
    /**
     * Get account balance by id
     * @param $id int Account id
     *
     * @return int Balance
     */
    public static function getAccountBalance($id)
    {
        $transactions = AccountsHistory::where('account_id', $id)->get();
        if (empty($transactions->getDictionary())) {
            $money = 0;
        } else {
            $money = 0;
            foreach ($transactions as $item) {
                $money += $item->money;
            }
        }

        return $money;
    }

    /**
     * Check the type of transaction. If `expense` than change the money sign
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
}