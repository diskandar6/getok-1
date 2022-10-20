<?php
 /**
 * Description:  This file contains the following class:<br>
 * High class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
*
* Title: High class</p>
*
* Description: High Function. Returns highest value.
*
* <p>Example:
* <pre><font face="Courier" size="4">
* $highFunction = new High();
* $highFunction->setChart($myChart->getChart());
* $highFunction->setPeriod(0); //all points
*
* $lineSeries->setDataSource($barSeries);
* $lineSeries->setFunction($highFunction);
* </font></pre></p>
*
*  @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
*/
class High extends Functions
{

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
   * Performs function operation on SourceSeries series.<br>
   * First and Last parameters are ValueIndex of first and last point used
   * in calculation. <br<
   * You can override Calculate function to perform customized calculation
   * on one SourceSeries.
   *
   * @param sourceSeries Series
   * @param firstIndex int
   * @param lastIndex int
   * @return double
   */
   public function calculate($sourceSeries, $firstIndex, $lastIndex)
   {
      $v = $this->valueList($sourceSeries);
      if($firstIndex == - 1)
      {
         return $v->getMaximum();
      }
      else
      {
         $result = $v->getValue($firstIndex);
         for($t = $firstIndex + 1; $t <= $lastIndex; $t++)
         {
            $tmp = $v->value[$t];
            if($tmp > $result)
            {
               $result = $tmp;
            }
         }
         return $result;
      }
   }


   /**
   * Performs function operation on list of series (SourceSeriesList).<br>
   * The ValueIndex parameter defines ValueIndex of point in each Series in
   * list. <br>
   * You can override CalculateMany function to perform customized
   * calculation on list of SourceSeries. <br>
   *
   * @param sourceSeriesList ArrayList
   * @param valueIndex int
   * @return double
   */
   public function calculateMany($sourceSeriesList, $valueIndex)
   {
      $v;
      $result = 0;

      for($t = 0; $t < sizeof($sourceSeriesList); $t++)
      {
         $v = $this->valueList($sourceSeriesList->offsetget($t));
         if(sizeof($v) > $valueIndex)
         {
            $tmp = $v->value[$valueIndex];
            if(($t == 0) || ($tmp > $result))
            {
               $result = $tmp;
            }
         }
      }
      return $result;
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("FunctionHigh");
   }
}

?>