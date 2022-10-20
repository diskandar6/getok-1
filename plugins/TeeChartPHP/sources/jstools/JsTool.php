<?php
  /**
 * Description:  This file contains the following class:<br>
 * JsTool class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */
/**
 * JsTool class
 *
 * Description: Base JsTool class
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */

 class JsTool extends TeeBase {

    private $active = true;
    protected $listenerList;

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

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->active);
        unset($this->listenerList);
    }   
       
    protected function readResolve() {
      $this->listenerList = new EventListenerList();
      return $this;
    }

    public function __construct($c=null) {
      parent::__construct($c);
       
      if ($this->chart != null) {
        $this->chart->getJsTools()->internalAdd($this);
      }

      $this->readResolve();
    }

    public function toString() {
        return $this->getDescription();
    }

    /**
      * Enables/Disables the indexed JsTool.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setActive($value) {
        $this->active = $this->setBooleanProperty($this->active, $value);
    }

    /**
      * Enables/Disables the indexed Tool.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getActive() {
        return $this->active;
    }

    public function setChart($value) {
        if (!($this->chart === $value)) {
            if ($this->chart != null) {
                $this->chart->getJsTools()->remove($this);
            }

            parent::setChart($value);

            if ($this->chart != null) {
                $this->chart->getJsTools()->add($this);
            }
            
            /*
            if ($this->chart != null) {
                $this->chart->invalidate();
            }
            */
        }
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return "";
    }

    /**
      * Gets detailed descriptive text.
      *
      * @return String
      */
    public function getSummary() {
        return "";
    }
}
?>