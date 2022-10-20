<?php
  /**
 * Description:  This file contains the following class:<br>
 * Variance class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
* <p>Title: Variance class</p>
*
* <p>Description: Variance function.</p>
*
* <p>Example:
* <pre><font face="Courier" size="4">
* $function = Variance();
* $function->setChart($myChart->getChart());
* $function->setPeriod(0); //all points
*
* $functionSeries = new Line($myChart->getChart());
* $functionSeries->setTitle("Variance");
* $functionSeries->setDataSource($series);
* $functionSeries->setVerticalAxis(VerticalAxis::$RIGHT);
* $functionSeries->setFunction($function);
* </font></pre></p>
*
*  @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
*/
class Variance extends Functions
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
   * Performs function operation on s series.
   *
   * @param s Series
   * @param firstIndex int
   * @param lastIndex int
   * @return double
   */
   public function calculate($s, $firstIndex, $lastIndex)
   {
      if($firstIndex == - 1)
      {
         $firstIndex = 0;
      }
      if($lastIndex == - 1)
      {
         $lastIndex = $s->getCount() - 1;
      }

      $count = $lastIndex - $firstIndex + 1;

      if($count > 0)
      {
         $mean = $s->getMandatory()->getTotal() / $count;

         if($count != $s->getCount())
         {
            $mean = 0.0;

            for($t = $firstIndex; $t <= $lastIndex; $t++)
            {
               $mean += $s->getMandatory()->value[$t];
            }
            $mean /= $count;
         }

         $sum = 0 . 0;
         for($t = $firstIndex; $t <= $lastIndex; $t++)
            $sum += ($s->getMandatory()->value[$t] - $mean) * ($s->getMandatory()->value[$t] - $mean);

         return $sum / $count;
      }
      else
      {
         return 0 . 0;
      }
   }

   /**
   * Performs function operation on all sourceSeries series.
   *
   * @param sourceSeries ArrayList
   * @param valueIndex int
   * @return double
   */
   public function calculateMany($sourceSeries, $valueIndex)
   {
      $count = sizeof($sourceSeries);
      if($count > 0)
      {
         $mean = 0.0;
         for($t = 0; $t < $count; $t++)
         {
            $tmpSeries = $sourceSeries->offsetget($t);
            $mean += $tmpSeries->getMandatory()->value[$valueIndex];
         }
         $mean /= $count;

         $sum = 0.0;
         for($t = 0; $t < $count; $t++)
         {
            $tmpSeries = $sourceSeries->offsetget($t);
            $sum += sqr($tmpSeries->getMandatory()->value[$valueIndex] -
            $mean);
         }

         return $sum / $count;

      }
      else
      {
         return 0.0;
      }
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("FunctionVariance");
   }
}
?>