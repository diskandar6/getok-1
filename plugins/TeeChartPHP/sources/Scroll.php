<?php
 /**
 * Description:  This file contains the following class:<br>
 * Scroll class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: Scroll class</p>
  *
  * <p>Description: Used at tChart1.Scroll property, determines mouse
  * scroll attributes.</p>
  *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
 class Scroll extends ZoomScroll {

    protected $mouseButton=0;
    protected $direction;
    
    /**
    * Creates a new Scroll instance.
    *
    * @param c IBaseChart
    */
    public function __construct($c) {
        parent::__construct($c);
        
        $this->mouseButton=0;
        $this->direction=ScrollDirections::$HORIZONTAL;
    }
    
   public function __destruct()    
   {        
        parent::__destruct();
       
        unset($this->mouseButton);
        unset($this->direction);
   }       

    public function getMouseButton() {
        return $this->mouseButton;
    }
    
    public function setMouseButton($value) {
        $this->mouseButton=$value;
    }
    
    /**
    * The direction of the zoom on a selected area.<br><br>
    * Example. Horizontal will zoom only on a horizontal plane although the
    * mouse is dragged across a vertical and horizontal plane.<br>
    * Default value: Both
    *
    * @return ZoomDirections
    */
    public function getDirection() {
        return $this->direction;
    }

    /**
    * Sets the direction of the zoom on a selected area.<br><br>
    * Default value: Both
    *
    * @param value ZoomDirections
    */
    public function setDirection($value) {
        $this->direction = $value;
    }
}
?>