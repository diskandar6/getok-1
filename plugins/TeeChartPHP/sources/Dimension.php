<?php
 /**
 * Description:  This file contains the following class:<br>
 * Dimension class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
 /**
 * Dimension class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Dimension {

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
     * The width dimension; negative values can be used.
     *
     * @see #getSize
     * @see #setSize
     */
    public $width;

    /**
     * The height dimension; negative values can be used.
     *
     * @see #getSize
     * @see #setSize
     */
    public $height;

    /**
     * Constructs a <code>Dimension</code> and initializes
     * it to the specified width and specified height.
     *
     * @param width the specified width
     * @param height the specified height
     */
    public function __construct($width=0,$height=0) {
        $this->width=$width;
        $this->height=$height;
    }

    /**
     * Returns the width of this dimension in double precision.
     * @return the width of this dimension in double precision
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Returns the height of this dimension in double precision.
     * @return the height of this dimension in double precision
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Sets the size of this <code>Dimension</code> object to
     * the specified width and height in double precision.
     * Note that if <code>width</code> or <code>height</code>
     * are larger than <code>Integer.MAX_VALUE</code>, they will
     * be reset to <code>Integer.MAX_VALUE</code>.
     *
     * @param width  the new width for the <code>Dimension</code> object
     * @param height the new height for the <code>Dimension</code> object
     */
    public function setSize($width, $height) {
        $this->width = ceil($width);
        $this->height = ceil($height);
    }

    /**
     * Gets the size of this <code>Dimension</code> object.
     * This method is included for completeness, to parallel the
     * <code>getSize</code> method defined by <code>Component</code>.
     *
     * @return   the size of this dimension, a new instance of
     *           <code>Dimension</code> with the same width and height
     */
    public function getSize() {
        return new Dimension($this->width, $this->height);
    }

    /**
     * Checks whether two dimension objects have equal values.
     */
    public function equals($obj) {
        if ($obj instanceof Dimension) {
            $d = $obj;
            return ($this->width == $d->width) && ($this->height == $d->height);
        }
        return false;
    }

    /**
     * Returns the hash code for this <code>Dimension</code>.
     *
     * @return    a hash code for this <code>Dimension</code>
     */
    public function hashCode() {
        $sum = $this->width + $this->height;
        return $sum * ($sum + 1)/2 + $this->width;
    }
    
    function __destruct()
    {
        unset($this->width);
        unset($this->height);
    }    
}
?>