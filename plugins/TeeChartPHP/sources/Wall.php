<?php
 /**
 * Description:  This file contains the following class:<br>
 * Wall class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Wall class
 *
 * Description: Characteristics of Wall Panel that complements an Axis
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Wall extends TeeShape {

    protected $iSize=0;
    protected $bApplyDark = true;

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

    protected function getShouldDark() {
        return $this->bApplyDark && ($this->bBrush != null) && $this->getBrush()->getVisible();
    }

    /**
     * Applies a darker shade to 3D Chart Walls when true.<br>
     * Default value: true
     *
     * @return boolean
     */
    public function getApplyDark() {
        return $this->bApplyDark;
    }

    /**
     * Applies a darker shade to 3D Chart Walls when true.<br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setApplyDark($value) {
        $this->bApplyDark = $this->setBooleanProperty($this->bApplyDark, $value);
    }

    function __construct($c=null) {
        parent::__construct($c);       
    }

    public function __destruct()    
    {        
        parent::__destruct();

        unset($this->iSize);
        unset($this->bApplyDark);
    }  
        
    /**
     * The Chart Wall thickness.<br>
     * Default value: 0
     *
     * @return int
     */
    public function getSize() {
        return $this->iSize;
    }

    /**
     * Sets the Chart Wall thickness.<br>
     * Default value: 0
     *
     * @param value int
     */
    public function setSize($value) {
        $this->iSize = $this->setIntegerProperty($this->iSize, $value);
    }

    protected function prepareGraphics($g) {
        if ($this->bTransparent) {
            $g->getBrush()->setVisible(false);
        } else {
            $g->setBrush($this->getBrush());
        }
        $g->setPen($this->getPen());
    }
}

?>