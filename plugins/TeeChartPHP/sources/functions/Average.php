<?php
  /**
 * Description:  This file contains the following class:<br>
 * Average class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 * Average class
 *
 * Description: Average (mean) Function
 *
 * Example:
 * $avgFunction = new Average();
 * $avgFunction->setChart($myChart->getChart());
 * $avgFunction->setPeriod(0); //all points
 * $avgFunction->setIncludeNulls(false);
 *
 * $lineSeries->setDataSource($barSeries);
 * $lineSeries->setFunction($avgFunction);
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 2013
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
 class Average extends Functions {
     
    private $includeNulls = true;

    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }

    /**
    * If UseNulls is true, null values will be treated as zero in average
    * calculation.
    *
    * @param useNulls boolean
    */
    public function __construct($useNulls=true) {
        parent::__construct();
        
        $this->includeNulls = $useNulls;
    }
    
    public function __destruct()    
    {        
        parent::__destruct();                
        unset($this->includeNulls);
    }  
    
    /**
    * Calculates the average using only the non-null points of a series, or
    * not.
    * @return boolean
    */
    public function getIncludeNulls() {
        return $this->includeNulls;
    }

    /**
    * Calculates the average using only the non-null points of a series, or
    * not.
    *
    * @param value boolean
    */
    public function setIncludeNulls($value) {
        if ($this->includeNulls != $value) {
            $this->includeNulls = $value;
            $this->recalculate();
        }
    }

    /**
    * Performs function operation on SourceSeries series.<br>
    * First and Last parameters are ValueIndex of first and last point used
    * in calculation. <br>
    * You can override Calculate function to perform customized calculation
    * on one SourceSeries. <br>
    *
    * @param sourceSeries Series
    * @param firstIndex int
    * @param lastIndex int
    * @return double
    */
    public function calculate($sourceSeries, $firstIndex, $lastIndex) {
        if (($firstIndex == -1) && $this->includeNulls) {
            return ($sourceSeries->getCount() > 0) ?
                    $this->valueList($sourceSeries)->getTotal() / $sourceSeries->getCount() : 0;
        } else {
            if ($firstIndex == -1) {
                $firstIndex = 0;
                $lastIndex = $sourceSeries->getCount() - 1;
            }

             $result = 0;
             $tmpCount = 0;
             $v = $this->valueList($sourceSeries);

            for ( $t = $firstIndex; $t <= $lastIndex; $t++) {
                if ($this->includeNulls || (!$sourceSeries->isNull($t))) {
                    $result += $v->value[$t];
                    $tmpCount++;
                }
            }

            return ($tmpCount == 0) ? 0 : $result / $tmpCount;
        }
    }

    /**
    * Performs function operation on list of series (SourceSeriesList).<br>
    * The ValueIndex parameter defines ValueIndex of point in each Series
    * in list. <br>
    * You can override CalculateMany function to perform customized
    * calculation on list of SourceSeries. <br>
    *
    * @param sourceSeriesList ArrayList
    * @param valueIndex int
    * @return double
    */
    public function calculateMany($sourceSeriesList, $valueIndex) {
        if ($sourceSeriesList->size() > 0) {
             $v;
             $result = 0;
             $counter = 0;
            for ( $t = 0; $t < sizeof($sourceSeriesList); $t++) {
                $s = $sourceSeriesList->get($t);
                $v = $this->valueList($s);
                if (($v->count > $valueIndex) && ($this->includeNulls || (!$s->isNull($t)))) {
                    $counter++;
                    $result += $v->value[$valueIndex];
                }
            }
            return ($counter == 0) ? 0 : $result / $counter;
        } else {
            return 0;
        }
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("FunctionAverage");
    }
}

?>