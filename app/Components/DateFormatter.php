<?php

namespace App\Components;


use Carbon\Carbon;

class DateFormatter
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
    const FORMAT_YEAR = 'Y';
    /** @var string Format for interval splitting by month */
    const FORMAT_MONTH_INTERVAL = 'Y-m';
    /** @var string Format full date */
    const FORMAT_DAY_INTERVAL = 'Y-m-d';
    /** @var string Format date for months */
    const FORMAT_MONTH_OUTPUT = 'F Y';
    /** @var string Format date for days */
    const FORMAT_DAY_OUTPUT = 'F d';
    
    /**
     * Get interval for current month from begin to now
     * @return array
     */
    public static function getCurrentMonthInterval()
    {
        return [
            'from' => Carbon::now()->firstOfMonth()->toDateTimeString(),
            'to' => Carbon::now()->toDateTimeString(),
        ];
    }

    /**
     * @param Carbon $date
     * @param $nextDateMethod
     *
     * @return Carbon
     */
    public static function getPreviousDate(Carbon $date, $nextDateMethod)
    {
        $prevDate = clone $date->$nextDateMethod(-DateFormatter::NEXT_DATE);
        $date->$nextDateMethod(DateFormatter::NEXT_DATE);

        return $prevDate;
    }
}