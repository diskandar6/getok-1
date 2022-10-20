<?php
 /**
 * Description:  This file contains the following class:<br>
 * TeeBase class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * TeeBase class
 *
 * Description: Non-visible class for Chart element common characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class TeeBase {

   public $chart;

   public function __destruct()
   {        
        unset($this->chart);
   }
    
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

    function __construct($_chart) {
        $this->chart = $_chart;
    }

    /**
     * Chart associated with this object.
     *
     * @return IBaseChart
     */
    public function getChart() {
        return $this->chart;
    }

    /**
     * Chart associated with this object.
     *
     * @param value IBaseChart
     */
    public function setChart($value) {
        $this->chart = $value;
    }

    protected function setColorProperty($variable,$value) {
        if ($variable != $value) {
            $variable = $value;
            $this->invalidate();
        }
        return $variable;
    }

    protected function _setColorProperty($variable, $value) {
        if ($variable != $value) {
            $variable = $value;
            $this->invalidate();
        }
        return new Color($variable);
    }

    protected function setIntegerProperty($variable, $value) {
        if ($variable != $value) {
            $variable = $value;
            $this->invalidate();
        }
        return $variable;
    }

    protected function setDoubleProperty($variable, $value) {
        if ($variable != $value) {
            $variable = $value;
            $this->invalidate();
        }
        return $variable;
    }

    /**
     *
     *
     * @param variable boolean. Boolean variable to change.
     * @param value boolean. New value.
     * @return boolean
     */
    protected function setBooleanProperty($variable, $value) {
        if ($variable != $value) {
            $variable = $value;
            $this->invalidate();
        }
        return $variable;
    }

    protected function setStringProperty($variable, $value) {
        if ($variable !=$value) {
            $variable = $value;
            $this->invalidate();
        }
        return $variable;
    }

    /**
     * Use invalidate when the entire canvas needs to be repainted.
     *
     */
    public function invalidate() {
        if ($this->chart != null) {
            $this->chart->doBaseInvalidate();
        }
    }
}

?>