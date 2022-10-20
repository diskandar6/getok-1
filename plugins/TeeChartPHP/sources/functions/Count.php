<?php
  /**
 * Description:  This file contains the following class:<br>
 * Count class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 * Count class
 *
 * Description: Count Function
 *
 * Example:
 * $countFunction = new Count();
 * $countFunction->setChart($myChart->getChart());
 * $countFunction->setPeriod(0); //all points
 *
 * $lineSeries->setDataSource($barSeries);
 * $lineSeries->setFunction($countFunction);
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 2013.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
class Count extends Functions
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
   * in calculation. <br>
   * You can override Calculate function to perform customized calculation
   * on one SourceSeries. <br>
   *
   * @param sourceSeries Series
   * @param firstIndex int
   * @param lastIndex int
   * @return double
   */
   public function calculate($sourceSeries, $firstIndex, $lastIndex)
   {
      return($firstIndex == - 1) ? $this->valueList($sourceSeries)->count :
      $lastIndex - $firstIndex + 1;
   }

   /**
   * Performs function operation on list of series (SourceSeriesList).<br>
   * The ValueIndex parameter defines ValueIndex of point in each Series in
   * list. You can override CalculateMany function to perform customized
   * calculation on list of SourceSeries. <br>
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
         if($this->valueList($sourceSeriesList->get($t))->count > $valueIndex)
         {
            $result++;
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
      return Language::getString("FunctionCount");
   }
}

?>