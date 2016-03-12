<?php

namespace App\Helpers;

use App\Models\accounts\AccountsHistory;
use Faker\Provider\zh_TW\DateTime;

class AccountsHistoryHelper
{
    const YEAR_INTERVAL = 2;
    const MONTH_INTERVAL = 2;

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

    public static function getIncomeForInterval($accountId, $interval = null)
    {
        $interval = [
            'from' => '2016-01-01',
            'to' => '2016-03-29',
        ];

        $transactions = AccountsHistory::select(['money', 'created_at'])->where('account_id', $accountId)
            ->whereBetween('created_at', $interval)->orderBy('created_at')->get();

        $result = self::orderTransactionsByDate($transactions, self::methodChoosingDispatcher($interval));

        $result = self::calcIncomeOfEachDate($result);

        return [
            'keys' => self::formattingDates(array_keys($result)),
            'values' => array_values($result),
        ];
    }

    /**
     * Set a new one transaction to array
     *
     * @param $array array Array for inserting
     * @param $transaction object Inserting transaction
     *
     * @return mixed Array with the new transaction
     */
    public static function setTransactionForMonths($array, $transaction)
    {
        $date = date_parse_from_format('Y-m-d', $transaction->created_at);
        $array[$date['year'] . '-' . $date['month']][] = $transaction->money;

        return $array;
    }

    public static function methodChoosingDispatcher(array $interval)
    {
        $from = date_parse_from_format('Y-m-d', $interval['from']);
        $to = date_parse_from_format('Y-m-d', $interval['to']);
        if (abs($to['year'] - $from['year']) < self::YEAR_INTERVAL) {
            if (abs($to['month'] - $from['month']) < self::MONTH_INTERVAL) {
                return 'setTransactionForDays';
            } else {
                return 'setTransactionForMonths';
            }
        } else {
            return 'setTransactionForYears';
        }
    }

    public static function orderTransactionsByDate($transactions, $settingMethod)
    {
        $result = [];
        foreach ($transactions as $transaction) {
            $result = array_merge($result, self::$settingMethod($result, $transaction));
        }

        return $result;
    }

    public static function calcIncomeOfEachDate($result)
    {
        foreach ($result as $key => $value) {
            $result[$key] = 0;
            foreach ($value as $item) {
                $result[$key] += $item;
            }
        }

        return $result;
    }

    public static function formattingDates(array $dates)
    {
        foreach ($dates as $key => $value) {
            $dates[$key] = date_format(date_create($value), 'F Y');
        }
        return $dates;
    }
}