<?php
 /**
 * Description:  This file contains the following class:<br>
 * TextShapePosition class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * TextShapePosition class
 *
 * Description: Shape Custom Position
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class TextShapePosition extends TextShape {

    protected $bCustomPosition=false;

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

    public function __construct($c) {
        parent::__construct($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();

        unset($this->bCustomPosition);
    }        

    /**
     * Allows custom positioning of TextShape when true.<br>
     * Default value: false
     *
     * @return boolean
     */
    public function getCustomPosition() {
        return $this->bCustomPosition;
    }

    /**
     * Set to true to permit custom positioning of TextShape.<br>
     * Default value: false
     *
     * @param value boolean
     */
    public function setCustomPosition($value) {
        $this->bCustomPosition = $this->setBooleanProperty($this->bCustomPosition, $value);
    }

    protected function shouldSerializeLeft() {
        return $this->bCustomPosition;
    }

    protected function shouldSerializeTop() {
        return $this->bCustomPosition;
    }

    protected function shouldSerializeRight() {
        return $this->bCustomPosition;
    }

    protected function shouldSerializeBottom() {
        return $this->bCustomPosition;
    }
}

?>