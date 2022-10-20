<?php
 /**
 * Description:  This file contains the following class:<br>
 * PointDouble class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * PointDouble class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class PointDouble {

    public $x;
    public $y;

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
     * Constructs and initializes a point at the origin
     * (0,&nbsp;0) of the coordinate space.
     * @since       1.1
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
     * The X location in pixels.
     *
     * @return double
     */
    public function getX() {
        return $this->x;
    }

    /**
     * Sets the X location in pixels.
     *
     * @param value double
     */
    public function setX($value) {
        $this->x = $value;
    }

    /**
     * The Y location in pixels.
     *
     * @return double
     */
    public function getY() {
        return $this->y;
    }

    /**
     * Sets the Y location in pixels.
     *
     * @param value double
     */
    public function setY($value) {
        $this->y = $value;
    }

    /*
     * convert PointDouble to rounded value Point
     */
    public static function round($value)
    {
      return new TeePoint((int)MathUtils::round($value->getX()), (int)MathUtils::round($value->getY()));
    }

    /*
     * convert PointDouble[] to rounded value Point[]
     */
    public static function  roundPointArray(/*PointDouble[]*/ $value)
    {
      $result = Array(); // Array of TeePoint new TeePoint[value.length];
      for ($i = 0; $i < sizeof($value); $i++)
      {
        $result[$i] = PointDouble::round($value[$i]);
      }
      return $result;
    }
}

?>