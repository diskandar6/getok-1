<?php
 /**
 * Description:  This file contains the following class:<br>
 * ColorList class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * ColorList class
 *
 * Description:The ColorList class is manipulated via Series->Colors
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class ColorList extends ArrayObject {

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
    public function __construct($capacity) {
    }

    public function getCount() {
        return sizeof($this);
    }

    public function getColor($index) {
        $tmpColor = new Color(0,0,0,0,true);
        return ($index < $this->getCount()) ? $this->offsetGet($index) : $tmpColor;
        unset($tmpColor);
    }

    public function setColor($index, $value) {
        while ($this->getCount() <= $index) {
            $tmpColor = new Color(0,0,0,0,true);
            $this->append($tmpColor);
            unset($tmpColor);
        }
        $this->offsetSet($index, $value);
    }

    public function removeRange($startIndex, $count) {
 // TODO       parent::removeRange($startIndex, $startIndex + $count - 1);
    }

    function exchange($a, $b) {
                $c = $this->getColor($a);
                $this->setColor($a, $this->getColor($b));
                $this->setColor($b, $c);
    }
}
?>