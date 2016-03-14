<?php

namespace App\Helpers;

use App\Models\accounts\AccountsHistory;
use Carbon\Carbon;
use Faker\Provider\zh_TW\DateTime;

class AccountsHistoryHelper
{
    /** Min interval when graph will be displayed in years */
    const YEAR_INTERVAL = 2;
    /** Min interval when graph will be displayed in months */
    const MONTH_INTERVAL = 2;
    /** Number of last six months */
    const LAST_SIX_MONTH = 6;
    /** Number of months to increment */
    const NEXT_MONTH = 1;

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

    public static function getGraphData($accountId, $interval = null)
    {
        $helper = new AccountsHistoryHelper();
        if (is_null($interval)) {
            $interval = $helper->getLastSixMonthInterval();
        }

        $transactions = AccountsHistory::select(['money', 'created_at'])->where('account_id', $accountId)
            ->whereBetween('created_at', [$interval['from'], $interval['to']])->orderBy('created_at')->get();

        $income = $receiptExpense['receipt'] = $receiptExpense['expense'] = [];
        if (!empty($transactions->getDictionary())) {
            $result = $helper->orderTransactionsByDate($transactions, $helper->chooseSettingMethod($interval));

            $income = $helper->calcIncomeOfEachDate($result);
            $income = $helper->fillDatesWithoutTransactions($income, $interval);

            $receiptExpense = $helper->calcReceiptExpenseOfEachDate($result);
            $receiptExpense = [
                'receipt' => $helper->fillDatesWithoutTransactions($receiptExpense['receipt'], $interval),
                'expense' => $helper->fillDatesWithoutTransactions($receiptExpense['expense'], $interval),
            ];
        }

        return [
            'keys' => $helper->formattingDates(array_keys($income)),
            'income' => array_values($income),
            'receipt' => array_values($receiptExpense['receipt']),
            'expense' => array_values($receiptExpense['expense']),
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
    public function setTransactionForMonths($array, $transaction)
    {
        $date = date_parse_from_format('Y-m-d', $transaction->created_at);
        $array[Carbon::parse($transaction->created_at)->format('Y-m')][] = $transaction->money;

        return $array;
    }

    /**
     * Choose the method for splitting data
     *
     * @param array $interval Date interval
     *
     * @return string The name of chosen method
     */
    public function chooseSettingMethod(array $interval)
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

    /**
     * Forming an array ordered by date
     *
     * @param $transactions
     * @param $settingMethod
     *
     * @return array
     */
    public function orderTransactionsByDate($transactions, $settingMethod)
    {
        $result = [];
        foreach ($transactions as $transaction) {
            $result = array_merge($result, self::$settingMethod($result, $transaction));
        }

        return $result;
    }

    /**
     * Summing money for each interval
     *
     * @param array $result
     *
     * @return mixed
     */
    public function calcIncomeOfEachDate($result)
    {
        foreach ($result as $key => $value) {
            $result[$key] = 0;
            foreach ($value as $item) {
                $result[$key] += $item;
            }
        }

        return $result;
    }

    /**
     * Calculate receipt and expense for each date
     *
     * @param $source
     *
     * @return array
     */
    public function calcReceiptExpenseOfEachDate($source)
    {
        $result = [];
        foreach ($source as $key => $value) {
            $result['expense'][$key] = 0;
            $result['receipt'][$key] = 0;
            foreach ($value as $item) {
                if ($item < 0) {
                    $result['expense'][$key] += abs($item);
                } else {
                    $result['receipt'][$key] += $item;
                }
            }
        }

        return $result;
    }

    /**
     * Formatting date to `MonthName Year` format
     *
     * @param array $dates Dates to be formatted
     *
     * @return array Date after formatting
     */
    public function formattingDates(array $dates)
    {
        foreach ($dates as $key => $value) {
            $dates[$key] = Carbon::parse($value)->format('F Y');
        }

        return $dates;
    }

    /**
     * Get interval in last six months
     * @return array Interval
     */
    public function getLastSixMonthInterval()
    {
        return [
            'from' => Carbon::now()->addMonths(-self::LAST_SIX_MONTH)->toDateString(),
            'to' => Carbon::now()->toDateString(),
        ];
    }

    public function fillDatesWithoutTransactions($source, $interval)
    {
        $currentDate = Carbon::parse($interval['from']);
        $to = Carbon::parse($interval['to']);

        while ($currentDate->diffInMonths($to) != 0) {
            if (!array_key_exists($currentDate->format('Y-m'), $source)) {
                $source[$currentDate->format('Y-m')] =
                    empty($source[(new Carbon('last month ' . $currentDate))->format('Y-m')]) ?
                        0 : $source[(new Carbon('last month ' . $currentDate))->format('Y-m')];
            }
            $currentDate = $currentDate->addMonths(self::NEXT_MONTH);
        }
        ksort($source);

        return $source;
    }

    public function formingReceiptExpenseArray()
    {

    }
}