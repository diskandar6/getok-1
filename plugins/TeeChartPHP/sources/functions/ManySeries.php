<?php
  /**
 * Description:  This file contains the following class:<br>
 * ManySeries class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
*
* <p>Title: ManySeries class</p>
*
* <p>Description: Internal use. Base class for multiple Series function
* calculations</p>
*
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
*/
class ManySeries extends Functions
{

   protected function calculateValue($result, $value) {
      return 0;
   }


   /**
   * Performs function operation on list of series (SourceSeriesList).<br>
   * The ValueIndex parameter defines ValueIndex of point in each Series
   * in list. <br>
   * You can override CalculateMany function to perform customized
   * calculation on list of SourceSeries. <br>
   *
   * @param sourceSeries ArrayList
   * @param valueIndex int
   * @return double
   */
   public function calculateMany($sourceSeries, $valueIndex) {
      $tmpFirst = true;
      $result = 0;

      for($t = 0; $t < sizeof($sourceSeries); $t++) {
         $v = $this->valueList($sourceSeries[$t]);
         if($v->count > $valueIndex){
            if($tmpFirst) {
               $result = $v->value[$valueIndex];
               $tmpFirst = false;
            }
            else {
               $result = $this->calculateValue($result, $v->value[$valueIndex]);
            }
         }
      }
      return $result;
   }
}

?>