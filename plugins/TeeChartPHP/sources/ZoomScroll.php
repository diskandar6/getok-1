<?php
 /**
 * Description:  This file contains the following class:<br>
 * ZoomScroll class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * <p>Title: ZoomScroll class</p>
 * <p>Description: Internal use. Zoom and scroll support.</p>
 * 
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

 class ZoomScroll extends TeeBase {

    /**
    * Determines if the user is currently zooming or scrolling contents
    * by mouse dragging.
    */
    private $active=true;

    /**
    * Creates a new ZoomScroll class that is asociated to chart parameter.
    *
    * @param value IBaseChart
    */
    public function __construct($c=null) {
        parent::__construct($c);   
        $this->active=true;                 
    }
    
    public function __destruct()    
    {        
        parent::__destruct();

        unset($this->active);
    }          
        
    /**
    * Returns the active state of Chart Zoom and Scroll.<br>
    * In other words, during the act of zooming or scrolling returns true.<br>
    * Default value: false
    *
    * @return boolean
    */
    public function getActive() {
        return $this->active;
    }

    /**
    * Sets the active state of Chart Zoom and Scroll.<br>
    * Default value: false
    *
    * @param value boolean
    */
    public function setActive($boolean) {
        $this->active = $this->value;
    }

    /**
    * Makes sure x0 and y0 coordinates are lower than x1 and y1 respectively.
    */
    public function check() {

        if ($this->x0 > $this->x1) {
            $tmp = $this->x0;
            $this->x0 = $this->x1;
            $this->x1 = $tmp;
        }

        if ($this->y0 > $this->y1) {
            $tmp = $this->y0;
            $this->y0 = $this->y1;
            $this->y1 = $tmp;
        }
    }

    /**
    * Initializes a Zoom or Scroll operation starting at Point p coordinates.
    *
    * @param p Point
    */
    public function activate($p) {
        $this->activateXY($p->x, $p->y);
    }

    /**
    * Internal use. Starts a Zoom or Scroll from the co-ordinates x and y.
    *
    * @param x int
    * @param y int
    */
    public function activateXY($x, $y) {
        $this->x0 = $x;
        $this->y0 = $y;
        $this->x1 = $x;
        $this->y1 = $y;
        $this->active = true;
    }

    /**
    * Starting horizontal coordinate.
    */
    public $x0;

    /**
    * Starting vertical coordinate.
    */
    public $y0;

    /**
    * Ending horizontal coordinate.
    */
    public $x1;

    /**
    * Ending vertical coordinate.
    */
    public $y1;
}
?>