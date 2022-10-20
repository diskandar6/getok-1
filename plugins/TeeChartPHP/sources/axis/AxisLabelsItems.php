<?php
 /**
 * Description:  This file contains the following class:<br>
 * AxisLabelsItems class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * AxisLabelsItems class
 *
 * Description: Custom labels list
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

 class AxisLabelsItems extends ArrayObject {

    protected $iAxis;

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
    * The class constructor.
    */
    public function __construct($a) {
        parent::__construct();
        $this->iAxis = $a;
    }
    
    public function __destruct()    
    {        
        unset($this->iAxis);
    }

    /**
    * Accesses indexed Label characteristics
    *
    * @param index int
    * @return AxisLabelItem
    */
    public function getItem($index) {
        return $this->offsetget($index);
    }

    /**
    * Adds new label
    *
    * @param value double The axis data value
    * @return  new AxisLabelItem
    */
    public function add($value, $text=null) {

        $result = new AxisLabelItem($this->iAxis->chart);
        $result->iAxisLabelsItems = $this;
        $result->setTransparent(true);
        $result->setValue($value);

        parent::append($result);

        if ($text != null) {
          $result->setText($text);
        }
        return $result;
    }

    public function copyFrom($source) {
        $this->clear();

        for ( $t = 0; $t < sizeof($source); $t++) {
            $this->offsetset($source->getItem($t)->getValue(), $source->getItem($t)->getText());
        }
    }

    /**
    * Clears custom labels list
    *
    */
    public function clear() {
        $this->iAxis->chart->invalidate();
    }
}
?>