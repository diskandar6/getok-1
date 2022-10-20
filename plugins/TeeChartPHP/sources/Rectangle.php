<?php
 /**
 * Description:  This file contains the following class:<br>
 * Rectangle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Rectangle class
 *
 * Description: Class to create the Rectangle object
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Rectangle  
{

   public $height;
   public $width;
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

   function __construct($x = 0, $y = 0, $width = 0.0, $height = 0.0)
   {
      $this->x = $x;
      $this->y = $y;
      $this->width = $width;
      $this->height = $height;
      $this->setBounds($x, $y, $width, $height);
   }

   
   public function __destruct()    
   {        
        unset($this->x);
        unset($this->y);
        unset($this->height);
        unset($this->width);
   }        
       
   function setRectangle(&$rect)
   {
      $this->setBounds(
      $rect->getX(),
      $rect->getY(),
      $rect->getWidth(),
      $rect->getHeight()
      );
   }

   function setBounds($x, $y, $width, $height)
   {
      $this->setSize($width, $height);
      $this->setLocation($x, $y);
   }

   function setLocation($x, $y)
   {
      $this->x = $x;
      $this->y = $y;
   }

   function setSize($w, $h)
   {
      $this->width = $w;
      $this->height = $h;
   }

   function setX($x)
   {
      $this->x = $x;
   }

   function setY($y)
   {
      $this->y = $y;
   }

   function getCenterX()
   {
      return $this->x + $this->width / 2.0;
   }

   function getCenterY()
   {
      return $this->y + $this->height / 2.0;
   }

   function getX()
   {
      return $this->x;
   }

   function getY()
   {
      return $this->y;
   }

   function toString()
   {
      return "Rectangle(" .
      $this->x . "," .
      $this->y . "," .
      $this->width . "," .
      $this->height . ")";
   }

   public function copy()
   {
      return new Rectangle($this->x, $this->y, $this->width, $this->height);
   }

   public function getArea()
   {
      return $this->height * $this->width;
   }

   static public function fromLTRB($x, $y, $right, $bottom)
   {
      return new Rectangle($x, $y, $right - $x + 1, $bottom - $y + 1);
   }

   /**
   * Gets rectangle Right coordinate.
   *
   * @return int
   */
   public function getRight()
   {
      return $this->x + $this->width;
   }

   /**
   * Gets rectangle Bottom coordinate.
   *
   * @return int
   */
   public function getBottom()
   {
      return $this->y + $this->height;
   }

   /**
   * Gets rectangle Left coordinate.
   *
   * @return int
   */
   public function getLeft()
   {
      return $this->x;
   }

   /**
   * Sets rectangle Left coordinate.
   *
   */
   public function setLeft($value)
   {
      $this->width += $this->x - $value;
      $this->x = $value;
   }

   /**
   * Sets rectangle Right coordinate.
   *
   */
   public function setRight($value)
   {
      $this->width = $value - $this->x;
   }

   /**
   * Gets rectangle Top coordinate.
   *
   * @return int
   */
   public function getTop()
   {
      return $this->y;
   }

   /**
   * Sets rectangle Top coordinate.
   *
   */
   public function setTop($value)
   {
      $this->height += $this->y - $value;
      $this->y = $value;
   }

   /**
   * Sets rectangle Bottom coordinate.
   *
   */
   public function setBottom($value)
   {
      $this->height = $value - $this->y;
   }

   public function intersect($value)
   {
      self::__intersect($this, $value, $this);
   }

   public static function __intersect($src1, $src2, $dest)
   {
      $x1 = max($src1->getX(), $src2->getX());
      $y1 = max($src1->getY(), $src2->getY());
      $x2 = min($src1->getX() + $src1->getWidth(), $src2->getX() + $src2->getWidth());
      $y2 = min($src1->getY() + $src1->getHeight(), $src2->getY() + $src2->getHeight());
      $dest->setFrame($x1, $y1, $x2 - $x1, $y2 - $y1);
   }

   /**
   * Determines whether or not this <code>Rectangle</code> and the specified
   * <code>Rectangle</code> intersect. Two rectangles intersect if
   * their intersection is nonempty.
   *
   * @param r the specified <code>Rectangle</code>
   * @return    <code>true</code> if the specified <code>Rectangle</code>
   *            and this <code>Rectangle</code> intersect;
   *            <code>false</code> otherwise.
   */
   public function intersects($r)
   {
      (int)$tw = $this->width;
      (int)$th = $this->height;
      (int)$rw = $r->width;
      (int)$rh = $r->height;
      if($rw <= 0 || $rh <= 0 || $tw <= 0 || $th <= 0)
      {
         return false;
      }
      (int)$tx = $this->x;
      (int)$ty = $this->y;
      (int)$rx = $r->x;
      (int)$ry = $r->y;
      $rw += $rx;
      $rh += $ry;
      $tw += $tx;
      $th += $ty;

      return(($rw < $rx || $rw > $tx) &&
      ($rh < $ry || $rh > $ty) &&
      ($tw < $tx || $tw > $rx) &&
      ($th < $ty || $th > $ry));
   }

   public function setFrame($x, $y, $w, $h)
   {
      $this->setX($x);
      $this->setY($y);
      $this->setWidth($w);
      $this->setHeight($h);
   }

   public function getWidth()
   {
      return $this->width;
   }

   public function setWidth($value)
   {
      $this->width = $value;
   }

   public function getHeight()
   {
      return $this->height;
   }

   public function setHeight($value)
   {
      $this->height = $value;
   }

   public function center()
   {
      return new TeePoint($this->x + ($this->width / 2), $this->y + ($this->height / 2));
   }

   /**
   * Returns the location of this <code>Rectangle</code>.
   * <p>
   * This method is included for completeness, to parallel the
   * <code>getLocation</code> method of <code>Component</code>.
   * @return the <code>Point</code> that is the top-left corner of
   *			this <code>Rectangle</code>.
   */
   public function getLocation()
   {
      return new TeePoint($this->x, $this->y);
   }

   /**
   * Moves this <code>Rectangle</code> to the specified location.
   * <p>
   * This method is included for completeness, to parallel the
   * <code>setLocation</code> method of <code>Component</code>.
   * @param p the <code>Point</code> specifying the new location
   *                for this <code>Rectangle</code>
   */
   public function _setLocation($p)
   {
      $this->setLocation($p->getX(), $p->getY());
   }

   /**
   * Determines whether or not this <code>Rectangle</code> is empty. A
   * <code>Rectangle</code> is empty if its width or its height is less
   * than or equal to zero.
   * @return     <code>true</code> if this <code>Rectangle</code> is empty;
   *             <code>false</code> otherwise.
   */
   public function isEmpty()
   {
      return($this->width <= 0) || ($this->height <= 0);
   }

   public function inflate($horizontal, $vertical)
   {
      $this->width += $horizontal;
      $this->height += $vertical;
   }

   public function offset($w, $h)
   {
      $this->x += $w;
      $this->y += $h;
   }

   /**
    * Resizes the <code>Rectangle</code> both horizontally and vertically.
    * <p>
    * This method modifies the <code>Rectangle</code> so that it is
    * <code>h</code> units larger on both the left and right side,
    * and <code>v</code> units larger at both the top and bottom.
    * <p>
    * The new <code>Rectangle</code> has (<code>x&nbsp;-&nbsp;h</code>,
    * <code>y&nbsp;-&nbsp;v</code>) as its top-left corner, a
    * width of
    * <code>width</code>&nbsp;<code>+</code>&nbsp;<code>2h</code>,
    * and a height of
    * <code>height</code>&nbsp;<code>+</code>&nbsp;<code>2v</code>.
    * <p>
    * If negative values are supplied for <code>h</code> and
    * <code>v</code>, the size of the <code>Rectangle</code>
    * decreases accordingly.
    * The <code>grow</code> method does not check whether the resulting
    * values of <code>width</code> and <code>height</code> are
    * non-negative.
    * @param h the horizontal expansion
    * @param v the vertical expansion
    */
   public function grow($h, $v)
   {
	    $this->x -= $h;
	    $this->y -= $v;
	    $this->width += $h * 2;
	    $this->height += $v * 2;
   }

}

/**
 * Square class
 *
 * Description: Class to create the Rectangle object
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
class Square extends Rectangle
{
   public function __construct($size)
   {
      $this->height = $size;
      $this->width = $size;
   }

   public function getArea()
   {
      return pow($this->height, 2);
   }
   
    public function __destruct()    
    {        
        parent::__destruct();   
    }   
}
?>