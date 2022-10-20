<?php
  /**
 * Description:  This file contains the following class:<br>
 * Subtract class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: Subtract class</p>
  *
  * <p>Description: Subtract Function.</p>
  *
  * <p>Example:
  * <pre><font face="Courier" size="4">
  * subtractFunction = new com.steema.teechart.functions.Subtract();
  * subtractFunction.setChart(myChart.getChart());
  * subtractFunction.setPeriod(0); //all points
  * </font></pre></p>
  *
*  @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
*/
 class Subtract extends ManySeries {

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

    protected function calculateValue($result, $value) {
        return $result - $value;
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return Language::getString("FunctionSubtract");
    }
}

?>