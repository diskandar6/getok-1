<?php
 /**
 * Description:  This file contains the following class:<br>
 * AnnotationCallout class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * AnnotationCallout class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

class AnnotationCallout extends Callout
{

   private $x = 0;
   private $y = 0;
   private $z = 0;

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

   public function __construct($s)
   {
      parent::__construct($s);
      $this->getArrow()->setVisible(false);
      $this->setVisible(false);
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->x);
        unset($this->y);
        unset($this->z);
    }     

   protected function closerPoint($r, $p)
   {
      if($p->getX() > $r->getRight())
      {
         $this->tmpX = $r->getRight();
      }
      else
         if($p->getX() < $r->getLeft())
         {
            $this->tmpX = $r->getLeft();
         }
         else
         {
            $this->tmpX = ($r->getLeft() + $r->getRight()) / 2;
         }

      if($p->getY() > $r->getBottom())
      {
         $this->tmpY = $r->getBottom();
      }
      else
         if($p->getY() < $r->getTop())
         {
            $this->tmpY = $r->getTop();
         }
         else
         {
            $this->tmpY = ($r->getTop() + $r->getBottom()) / 2;
         }

      return new TeePoint($this->tmpX, $this->tmpY);
   }

   /**
   * The X pixel coordinate of the ending point of the annotation callout
   * line.
   *
   * @return int
   */
   public function getXPosition()
   {
      return $this->x;
   }

   /**
   * Sets the X pixel coordinate of the ending point of the annotation callout
   * line.
   *
   * @param value int
   */
   public function setXPosition($value)
   {
      if($this->x != $value)
      {
         $this->x = $value;
         $this->invalidate();
      }
   }

   /**
   * The Y pixel coordinate of the ending point of the annotation callout
   * line.
   *
   * @return int
   */
   public function getYPosition()
   {
      return $this->y;
   }

   /**
   * Sets the Y pixel coordinate of the ending point of the annotation callout
   * line.
   *
   * @param value int
   */
   public function setYPosition($value)
   {
      if($this->y != $value)
      {
         $this->y = $value;
         $this->invalidate();
      }
   }

   /**
   * The Z pixel coordinate of the ending point of the annotation callout
   * line.
   *
   * @return int
   */
   public function getZPosition()
   {
      return $this->z;
   }

   /**
   * Sets the Z pixel coordinate of the ending point of the annotation callout
   * line.
   *
   * @param value int
   */
   public function setZPosition($value)
   {
      if($this->z != $value)
      {
         $this->z = $value;
         $this->invalidate();
      }
   }
}

?>