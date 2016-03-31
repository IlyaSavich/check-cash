<?php

namespace App\Components;

use App\Http\Requests\SetIntervalRequest;
use Carbon\Carbon;
use App\Components\AccountsHistoryContainer;
use Illuminate\Support\Facades\Redirect;

class GraphDirector
{
    /** @var array Result array container */
    protected $resultContainer = null;

    /**
     * Get transactions data by interval and formatting there to display in the view
     *
     * @param $accountId
     * @param SetIntervalRequest $request
     *
     * @return array
     */
    public function getGraphData($accountId, SetIntervalRequest $request = null)
    {
        $this->createResultDataContainer();
        $this->setIntervalForGraphics($request->all());
        $this->setDataForGraphics($accountId);
        $this->chooseFormatting();

        return $this->formattingTransactionsForGraph();
    }

    /**
     * Forming result data container
     * @return array
     */
    public function createResultDataContainer()
    {
        $this->resultContainer = [
            'income' => new GraphBuilder(),
            'receipt' => new GraphBuilder(),
            'expense' => new GraphBuilder(),
        ];

        return $this->resultContainer;
    }

    /**
     * Choose the method for splitting data
     * @return string The name of chosen method
     */
    private function chooseFormatting()
    {
        foreach ($this->resultContainer as $graphBuilder) {
            /* @var $graphBuilder GraphBuilder */
            $difference = Carbon::parse($graphBuilder->getInterval()['from'])
                ->diff(Carbon::parse($graphBuilder->getInterval()['to']));

            if ($difference->y < DateFormatter::YEAR_INTERVAL) {
                if ($difference->m < DateFormatter::MONTH_INTERVAL && $difference->y == 0) {

                    $graphBuilder->setMethods(DateFormatter::FORMAT_DAY_OUTPUT, 'diffInDays', 'addDays',
                        DateFormatter::FORMAT_DAY_INTERVAL);
                } else {

                    $graphBuilder->setMethods(DateFormatter::FORMAT_MONTH_OUTPUT, 'diffInMonths', 'addMonths',
                        DateFormatter::FORMAT_MONTH_INTERVAL);
                }
            } else {

                $graphBuilder->setMethods(DateFormatter::FORMAT_YEAR, 'diffInYears', 'addYears',
                    DateFormatter::FORMAT_YEAR);
            }
        }

        return $this->resultContainer;
    }

    /**
     * Forming an array ordered by date
     * @return array
     */
    private function formattingTransactionsForGraph()
    {
        foreach ($this->resultContainer as $value) {
            $this->calcMoneyOfEachDate($this->setTransactionsByDate($value));
        }

        return $this->formatDataForOutput($this->resultContainer);
    }

    /**
     * Set a new transaction to data array
     *
     * @param GraphBuilder $object
     *
     * @return GraphBuilder
     */
    private function setTransactionsByDate(GraphBuilder $object)
    {
        $result = [];
        if (!$object->data->isEmpty()) {
            foreach ($object->data as $transaction) {
                $result[Carbon::parse($transaction->created_at)->format($object->dateFormat)][] =
                    $transaction->money;
            }
        }
        $object->data = $result;

        return $object;
    }

    /**
     * Calculate income, receipt and expense for each date
     *
     * @param GraphBuilder $object
     *
     * @return array
     */
    private function calcMoneyOfEachDate(GraphBuilder $object)
    {
        $result = [];
        foreach ($object->data as $key => $value) {
            $result[$key] = 0;
            foreach ($value as $item) {
                $result[$key] += $item;
            }
        }
        $object->data = $result;

        return $this->fillDatesWithoutTransactions($object);
    }

    /**
     * In given object formatting it data keys that represent dates to output it on graphics
     *
     * @param GraphBuilder $object
     *
     * @return array Date after formatting
     */
    private function formattingDatesArrayToOutput(GraphBuilder $object)
    {
        $objectData = [];
        foreach ($object->data as $date => $money) {
            $objectData[] = $this->formatDateToOutput($object, $date);
        }

        return $objectData;
    }

    /**
     * Get formatted date for output
     *
     * @param GraphBuilder $object
     * @param $value
     *
     * @return string
     */
    private function formatDateToOutput(GraphBuilder $object, $value)
    {
        return Carbon::createFromFormat($object->dateFormat, $value)
            ->format($object->outputDateFormat);
    }

    /**
     * Get interval in last six months if it not specified.
     * If interval setting return formatting date range else null
     *
     * @param array $request
     * @param $requestParameterKey
     *
     * @return array|null
     */
    private function chooseInterval(array $request, $requestParameterKey)
    {
        return $this->checkDateRangeRequest($request, $requestParameterKey) ? $this->getHalfYearInterval()
            : $this->intervalToArray($request, $requestParameterKey);
    }

    /**
     * Set interval for each graphics
     *
     * @param array $request
     *
     * @return mixed
     */
    private function setIntervalForGraphics($request)
    {
        $this->resultContainer['income']->interval = $this->chooseInterval($request, 'income');
        $this->resultContainer['receipt']->interval = $this->resultContainer['expense']->interval =
            $this->chooseInterval($request, 'recexp');

        return $this->resultContainer;
    }

    /**
     * Set transactions data for each graphics
     *
     * @param $accountId
     *
     * @return mixed
     */
    private function setDataForGraphics($accountId)
    {
        $this->resultContainer['income']->data = AccountsHistoryContainer::getTransactionsByInterval($accountId,
                $this->resultContainer['income']->interval);

        $this->resultContainer['receipt']->data = AccountsHistoryContainer::getReceiptByInterval($accountId,
                $this->resultContainer['receipt']->interval);

        $this->resultContainer['expense']->data = AccountsHistoryContainer::getExpenseByInterval($accountId,
                $this->resultContainer['expense']->interval);

        return $this->resultContainer;
    }

    /**
     * Explode string interval to array
     *
     * @param array $request
     * @param $requestParameterKey
     *
     * @return mixed
     */
    private function intervalToArray($request, $requestParameterKey) // TODO validate
    {
        $interval = explode(' - ', $request[$requestParameterKey]);

        return $this->formattingInterval($interval);
    }

    /**
     * Getting formatted interval
     *
     * @param $interval
     *
     * @return mixed
     */
    private function formattingInterval($interval)
    {
        $result['from'] = Carbon::parse($interval[0])->format(DateFormatter::FORMAT_DAY_INTERVAL);
        $result['to'] = Carbon::parse($interval[1])->format(DateFormatter::FORMAT_DAY_INTERVAL);

        return $result;
    }

    /**
     * Fill dates without transactions with values of previous dates or zero if there no previous data
     *
     * @param GraphBuilder $object
     *
     * @return array
     */
    private function fillDatesWithoutTransactions(GraphBuilder $object)
    {
        $diffMethod = $object->differenceInDatesMethod;
        $nextDateMethod = $object->nextDateMethod;
        $objectData = $object->data;

        $currentDate = Carbon::parse($object->interval['from']);
        $to = Carbon::parse($object->interval['to']);

        while ($currentDate->$diffMethod($to) != 0) {

            if (!array_key_exists($currentDate->format($object->dateFormat), $objectData)) {

                $objectData[$currentDate->format($object->dateFormat)] =
                    empty($objectData[DateFormatter::getPreviousDate($currentDate, $nextDateMethod)->
                    format($object->dateFormat)]) ? 0 :
                        $objectData[DateFormatter::getPreviousDate($currentDate, $nextDateMethod)->
                        format($object->dateFormat)];

            }
            $currentDate->$nextDateMethod(DateFormatter::NEXT_DATE);
        }

        ksort($objectData);
        $object->data = $objectData;

        return $object;
    }

    /**
     * Formatting data to display there in the view
     *
     * @param $result
     *
     * @return array
     */
    private function formatDataForOutput($result)
    {
        return json_encode([
            'keys' => [
                'income' => $this->formattingDatesArrayToOutput($result['income']),
                'receipt' => $this->formattingDatesArrayToOutput($result['receipt']),
                'expense' => $this->formattingDatesArrayToOutput($result['expense']),
            ],
            'values' => [
                'income' => array_values($result['income']->data),
                'receipt' => array_values($result['receipt']->data),
                'expense' => $this->absValues(array_values($result['expense']->data)),
            ],
        ]);
    }

    private function absValues($array)
    {
        foreach ($array as $key => $item) {
            $array[$key] = abs($item);
        }

        return $array;
    }

    /**
     * Check is date range setting
     *
     * @param array $request
     * @param $keyName
     *
     * @return bool
     */
    private function checkDateRangeRequest(array $request, $keyName)
    {
        return empty($request) ? true : empty($request[$keyName]);
    }

    private function getHalfYearInterval()
    {
        return [
            'from' => Carbon::now()->addMonths(-DateFormatter::LAST_SIX_MONTH)->toDateString(),
            'to' => Carbon::now()->toDateTimeString(),
        ];
    }
}