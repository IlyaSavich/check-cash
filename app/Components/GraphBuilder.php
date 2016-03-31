<?php

namespace App\Components;

/**
 * Class GraphBuilder
 * 
 * @property array $interval
 * @property mixed $data
 * @property string $differenceInDatesMethod
 * @property string $nextDateMethod
 * @property string $dateFormat
 * @property string $outputDateFormat
 * @package App\Components
 */
class GraphBuilder extends Object
{
    /** @var array Interval for transactions */
    protected $interval;
    
    /** @var mixed Data for graph array */
    protected $data;
    
    /** @var string Name of method for calculating difference between dates */
    protected $differenceInDatesMethod;
    
    /** @var string Name of method for getting next date */
    protected $nextDateMethod;
    
    /** @var string Format date type */
    protected $dateFormat;
    
    /** @var string Format date type to output on graph */
    protected $outputDateFormat;

    /**
     * GraphBuilder constructor.
     *
     * @param null $interval
     * @param null $dateFormat
     * @param null $outputDateFormat
     * @param null $differenceInDatesMethod
     * @param null $nextDateMethod
     */
    public function __construct($interval = null, $dateFormat = null, $outputDateFormat = null,
                                   $differenceInDatesMethod = null, $nextDateMethod = null)
    {
        $this->interval = $interval;
        $this->dateFormat = $dateFormat;
        $this->outputDateFormat = $outputDateFormat;
        $this->differenceInDatesMethod = $differenceInDatesMethod;
        $this->nextDateMethod = $nextDateMethod;
    }

    /**
     * Get interval value
     * @return mixed
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * Set interval value
     *
     * @param mixed $interval
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    /**
     * Get method name to calculate difference between dates
     * @return string
     */
    public function getDifferenceInDatesMethod()
    {
        return $this->differenceInDatesMethod;
    }

    /**
     * Set method name to calculate difference between dates
     *
     * @param string $differenceInDatesMethod
     */
    public function setDifferenceInDatesMethod($differenceInDatesMethod)
    {
        $this->differenceInDatesMethod = $differenceInDatesMethod;
    }

    /**
     * Get method name to calculate next date
     * @return string
     */
    public function getNextDateMethod()
    {
        return $this->nextDateMethod;
    }

    /**
     * Set method name to calculate next date
     *
     * @param string $nextDateMethod
     */
    public function setNextDateMethod($nextDateMethod)
    {
        $this->nextDateMethod = $nextDateMethod;
    }

    /**
     * Get format of date for splitting transactions
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * Set format of date for splitting transactions
     *
     * @param string $dateFormat
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * Get format of date to output in graph
     * @return string
     */
    public function getOutputDateFormat()
    {
        return $this->outputDateFormat;
    }

    /**
     * Set format of date to output in graph
     *
     * @param string $outputDateFormat
     */
    public function setOutputDateFormat($outputDateFormat)
    {
        $this->outputDateFormat = $outputDateFormat;
    }

    /**
     * Get graph data
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set graph data
     *
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Setting formats and methods for forming result array
     *
     * @param $outputDateFormat
     * @param $differenceInDatesMethod
     * @param $nextDateMethod
     * @param $formatDate
     */
    public function setMethods($outputDateFormat,
                                $differenceInDatesMethod, $nextDateMethod, $formatDate)
    {
        $this->outputDateFormat = $outputDateFormat;
        $this->differenceInDatesMethod = $differenceInDatesMethod;
        $this->nextDateMethod = $nextDateMethod;
        $this->dateFormat = $formatDate;
    }
}