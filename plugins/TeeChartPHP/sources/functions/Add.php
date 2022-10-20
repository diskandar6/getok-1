<?php
  /**
 * Description:  This file contains the following class:<br>
 * Add class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 * Add class
 *
 * Description: Add Function
 *
 * Example:
 * $addFunction = new Add();
 * $addFunction->setChart($myChart->getChart());
 * $addFunction->setPeriod(0); //all points
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 2013.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
class Add extends Functions
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
   * Performs function operation on SourceSeries series.
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
         return $v->getTotal();
      }
      else
      {
         $result = 0;
         for($t = $firstIndex; $t <= $lastIndex; $t++)
         {
            $result += $v->value[$t];
         }
         return $result;
      }
   }

   /**
   * Performs function operation on list of series (SourceSeriesList).
   *
   * @param sourceSeriesList ArrayList
   * @param valueIndex int
   * @return double
   */
   public function calculateMany($sourceSeriesList, $valueIndex)
   {
      $result = 0;

      for($t = 0; $t < sizeof($sourceSeriesList); $t++)
      {
         $v = $this->valueList($sourceSeriesList->offsetget($t));
         if(sizeof($v) > $valueIndex)
         {
            $result += $v->value[$valueIndex];
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
      return Language::getString("FunctionAdd");
   }
}

?>