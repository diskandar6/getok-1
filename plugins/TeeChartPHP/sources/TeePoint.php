<?php
 /**
 * Description:  This file contains the following class:<br>
 * TeePoint class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * TeePoint class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class TeePoint {

	private $x;
	private $y;

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
	 * Creates a new point of coordinates (x, y)
	 *
	 * @param integer x coordinate
	 * @param integer y coordinate
	 */
	public function __construct($x=0, $y=0) {
		$this->x = $x;
		$this->y = $y;
	}
    
    public function __destruct()    
    {        
        unset($this->x);
        unset($this->y);    
    }          
    
	/**
	 * Gets the x coordinate.
	 *
	 * @return integer x coordinate
	 */
	public function getX() {
		return $this->x;
	}

	/**
	 * Sets the x coordinate.
	 *
	 * @return integer x coordinate
	 */
	public function setX($value) {
		$this->x=$value;
	}


	/**
	 * Gets the y coordinate.
	 *
	 * @return integer y coordinate
	 */
	public function getY() {
		return $this->y;
	}

	/**
	 * Sets the y coordinate.
	 *
	 * @return integer y coordinate
	 */
	public function setY($value) {
		$this->y=$value;
	}
}
?>