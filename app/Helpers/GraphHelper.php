<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Helpers\AccountsHistoryContainer;
use Illuminate\Http\Request;

class GraphHelper
{
    /** @var int Min interval when graph will be displayed in years */
    const YEAR_INTERVAL = 2;
    /** @var int Min interval when graph will be displayed in months */
    const MONTH_INTERVAL = 2;
    /** @var int Number of last six months */
    const LAST_SIX_MONTH = 6;
    /** @var int Number of months to increment */
    const NEXT_DATE = 1;
    /** @var string Format for interval splitting by year */
    const FORMAT_YEAR_INTERVAL = 'Y';
    /** @var string Format for interval splitting by month */
    const FORMAT_MONTH_INTERVAL = 'Y-m';
    /** @var string Format for interval splitting by day */
    const FORMAT_DAY_INTERVAL = self::FORMAT_FULL_DATE;
    /** @var string Format for date */
    const FORMAT_FULL_DATE = 'Y-m-d';
    /** @var string Format for date */
    const FORMAT_MONTH_OUTPUT = 'F Y';
    /** @var string Format for date */
    const FORMAT_DAY_OUTPUT = 'F d';

    /** @var null Interval for graph data */
    private $interval = null;
    /** @var string Name of method for setting transaction dates */
    protected $settingTransactionMethod = null;
    /** @var string Name of method for calculating difference between dates */
    protected $differenceInDatesMethod = null;
    /** @var string Name of method for formatting date output */
    protected $formatDateToOutputMethod = null;
    /** @var string Name of method for getting next date */
    protected $nextDateMethod = null;
    /** @var string Format date type */
    protected $formatDate = null;

    /**
     * Get transactions data by interval and formatting there to display in the view
     *
     * @param $accountId
     * @param Request $request
     *
     * @return array
     */
    public function getGraphData($accountId, Request $request = null)
    {
        $this->interval = $this->setInterval($request->all());
        $transactions = AccountsHistoryContainer::getTransactionsByInterval($accountId, $this->interval);
        $this->chooseSettingMethod();
        return $this->formattingTransactionsForGraph($transactions, $this->settingTransactionMethod);
    }

    /**
     * Set a new one transaction to array by month
     *
     * @param $array array Array for inserting
     * @param $transaction object Inserting transaction
     *
     * @return mixed Array with the new transaction
     */
    private function setTransactionForMonths(array $array, $transaction)
    {
        $array[Carbon::parse($transaction->created_at)
            ->format(self::FORMAT_MONTH_INTERVAL)][] = $transaction->money;

        return $array;
    }

    /**
     * Set a new one transaction to array by day
     *
     * @param $array array Array for inserting
     * @param $transaction object Inserting transaction
     *
     * @return mixed Array with the new transaction
     */
    private function setTransactionForDays(array $array, $transaction)
    {
        $array[Carbon::parse($transaction->created_at)
            ->format(self::FORMAT_DAY_INTERVAL)][] = $transaction->money;

        return $array;
    }

    /**
     * Set a new one transaction to array by year
     *
     * @param $array array Array for inserting
     * @param $transaction object Inserting transaction
     *
     * @return mixed Array with the new transaction
     */
    private function setTransactionForYears(array $array, $transaction)
    {
        $array[Carbon::parse($transaction->created_at)
            ->format(self::FORMAT_YEAR_INTERVAL)][] = $transaction->money;
        echo '<pre>'; // TODO
//        var_dump($array);

        return $array;
    }

    /**
     * Choose the method for splitting data
     * @return string The name of chosen method
     */
    private function chooseSettingMethod()
    {
        $difference = Carbon::parse($this->interval['from'])->diff(Carbon::parse($this->interval['to']));
        if ($difference->y < self::YEAR_INTERVAL) {
            if ($difference->m < self::MONTH_INTERVAL && $difference->y == 0) {
                $this->setMethods('setTransactionForDays', 'formatDays', 'diffInDays', 'addDays',
                    self::FORMAT_DAY_INTERVAL);
            } else {
                $this->setMethods('setTransactionForMonths', 'formatMonths', 'diffInMonths', 'addMonths',
                    self::FORMAT_MONTH_INTERVAL);
            }
        } else {
            $this->setMethods('setTransactionForYears', 'formatYears', 'diffInYears', 'addYears',
                self::FORMAT_YEAR_INTERVAL);
        }
//        echo '<pre>';
//        var_dump($this->settingTransactionMethod);
//        var_dump($this->formatDateToOutputMethod);
//        var_dump($this->differenceInDatesMethod);
//        var_dump($this->nextDateMethod);
//        var_dump($this->formatDate);die;
    }

    private function setMethods($settingTransactionMethod, $formatDateToOutputMethod,
                                $differenceInDatesMethod, $nextDateMethod, $formatDate)
    {
        $this->settingTransactionMethod = $settingTransactionMethod;
        $this->formatDateToOutputMethod = $formatDateToOutputMethod;
        $this->differenceInDatesMethod = $differenceInDatesMethod;
        $this->nextDateMethod = $nextDateMethod;
        $this->formatDate = $formatDate;
    }

    /**
     * Forming an array ordered by date
     *
     * @param \Illuminate\Database\Eloquent\Collection|static[] $transactions
     * @param string $settingMethod The name of using method
     *
     * @return array
     */
    private function formattingTransactionsForGraph($transactions, $settingMethod)
    {
        $result = [];
        if (!$transactions->isEmpty()) {
            foreach ($transactions as $transaction) {
                echo '<pre>';
                $a = ['1007' => [1]];
                $b = [];
                var_dump($this->$settingMethod($result, $transaction));
                var_dump($a);
                var_dump($result);
                var_dump($b);
                var_dump(array_merge($result, $this->$settingMethod($result, $transaction)));
                var_dump(array_merge($b, $a));
                die;
                $result = array_merge($result, $this->$settingMethod($result, $transaction));
//                var_dump(array_merge([], $a));
                die;
            }
        }
        die;
        return $this->calcMoneyOfEachDate($result);
    }

    /**
     * Calculate income, receipt and expense for each date
     *
     * @param $data
     *
     * @return array
     */
    private function calcMoneyOfEachDate($data)
    {
        $result = [];
        $result['expense'] = [];
        $result['receipt'] = [];
        $result['income'] = [];
        foreach ($data as $key => $value) {
            $result['expense'][$key] = 0;
            $result['receipt'][$key] = 0;
            $result['income'][$key] = 0;
            foreach ($value as $item) {
                if ($item < 0) {
                    $result['expense'][$key] += abs($item);
                } else {
                    $result['receipt'][$key] += $item;
                }
                $result['income'][$key] += $item;
            }
        }

        return $this->fillDatesWithoutTransactions($result, $this->differenceInDatesMethod,
            $this->nextDateMethod);
    }

    /**
     * Formatting date to output in graph
     *
     * @param array $dates Dates to be formatted
     *
     * @param string $formatDateToOutputMethod
     *
     * @return array Date after formatting
     */
    private function formattingDatesToOutput(array $dates, $formatDateToOutputMethod)
    {
        foreach ($dates as $key => $value) {
            $dates[$key] = $this->$formatDateToOutputMethod($value);
        }

        return $dates;
    }

    /**
     * Get formatted month for output
     * @param $value
     *
     * @return string
     */
    private function formatMonths($value)
    {
        return Carbon::parse($value)->format(self::FORMAT_MONTH_OUTPUT);
    }

    /**
     * Get formatted day for output
     * @param $value
     *
     * @return string
     */
    private function formatDays($value)
    {
        return Carbon::parse($value)->format(self::FORMAT_DAY_OUTPUT);
    }

    /**
     * Get formatted year for output
     * @param $value
     *
     * @return string
     */
    private function formatYears($value)
    {
        return $value;
    }

    /**
     * Get interval in last six months if it not specified.
     * If interval setting return formatting date range else null
     *
     * @param array $request
     *
     * @return null|array
     */
    public function setInterval(array $request)
    {
        return $this->checkDateRangeRequest($request) ? $this->getHalfYearInterval()
            : $this->intervalToArray($request['daterange']);
    }

    /**
     * Explode string interval to array
     * @param $interval
     *
     * @return mixed
     */
    public function intervalToArray($interval)
    {
        $interval = explode(' - ', $interval);

        return $this->formattingInterval($interval);
    }

    /**
     * Getting formatted interval
     * @param $interval
     *
     * @return mixed
     */
    public function formattingInterval($interval)
    {
        $result['from'] = Carbon::parse($interval[0])->format(self::FORMAT_FULL_DATE);
        $result['to'] = Carbon::parse($interval[1])->format(self::FORMAT_FULL_DATE);

        return $result;
    }

    /**
     * Fill dates without transactions with values of previous dates or zero if there no previous data
     *
     * @param $data
     *
     * @param $diffMethod
     *
     * @param $nextDateMethod
     *
     * @return array
     */
    private function fillDatesWithoutTransactions($data, $diffMethod, $nextDateMethod)
    {
        foreach ($data as $key => $value) {
            $currentDate = Carbon::parse($this->interval['from']);
            $to = Carbon::parse($this->interval['to']);
            echo '<pre>';
            var_dump($data);die;
            while ($currentDate->$diffMethod($to) != 0) {
                if (!array_key_exists($currentDate->format($this->formatDate), $value)) {
                    $value[$currentDate->format($this->formatDate)] =
                        empty($value[$this->getPreviousDate($currentDate, $nextDateMethod)->
                        format($this->formatDate)]) ?
                            0 : $value[$this->getPreviousDate($currentDate, $nextDateMethod)->
                        format($this->formatDate)];
                    echo '<pre>';
                    var_dump($value[$currentDate->format($this->formatDate)]);die;
                }
                $currentDate->$nextDateMethod(self::NEXT_DATE);
            }
            ksort($value);
            echo '<pre>';
            var_dump($value);die;
            $data[$key] = $value;
        }

        return $this->formatDataForOutput($data);
    }

    /**
     * @param Carbon $date
     * @param $nextDateMethod
     *
     * @return Carbon
     */
    private function getPreviousDate(Carbon $date, $nextDateMethod)
    {
        $prevDate = clone $date->$nextDateMethod(-self::NEXT_DATE);
        $date->$nextDateMethod(self::NEXT_DATE);

        return $prevDate;
    }

    /**
     * Formatting data to display there in the view
     *
     * @param $data
     *
     * @return array
     */
    private function formatDataForOutput($data)
    {
        return json_encode([
            'keys' => $this->formattingDatesToOutput(array_keys($data['income']),
                $this->formatDateToOutputMethod),
            'income' => array_values($data['income']),
            'receipt' => array_values($data['receipt']),
            'expense' => array_values($data['expense']),
        ]);
    }

    /**
     * Check is date range setting
     *
     * @param array $request
     *
     * @return bool
     */
    private function checkDateRangeRequest(array $request)
    {
        return empty($request) ? true : empty($request['daterange']) ? true : false;
    }

    private function getHalfYearInterval()
    {
        return [
            'from' => Carbon::now()->addMonths(-self::LAST_SIX_MONTH)->toDateString(),
            'to' => Carbon::now()->toDateTimeString(),
        ];
    }
}