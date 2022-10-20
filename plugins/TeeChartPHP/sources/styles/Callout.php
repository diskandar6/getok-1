<?php
 /**
 * Description:  This file contains the following class:<br>
 * Callout class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Callout class
 *
 * Description: Mark Callout pointer characteristics
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class Callout extends SeriesPointer
{

   // when True, the Marks arrow pen
   // color is changed if the point has
   // the same color.

   private $CHECKMARKARROWCOLOR = false;

   private $arrow;
   private $arrowHead = 0; // ArrowHeadStyle::$NONE;
   private $distance = 0;
   private $arrowHeadSize = 8;

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

   public function __construct($s = null)
   {
      parent::__construct(($s != null) ? $s->getChart() : null , $s);

      $this->setStyle(PointerStyle::$RECTANGLE);
      $tmpColor = new Color(0,0,0);  // BLACK
      $this->getBrush()->setDefaultColor($tmpColor);
      $this->draw3D = false;
      $this->bVisible = true;
      
      unset($tmpColor);
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->CHECKMARKARROWCOLOR);
        unset($this->arrow);
        unset($this->arrowHead);
        unset($this->distance);
        unset($this->arrowHeadSize);
    }       

   public function drawCallout($c, $pFrom, $pTo, $z)
   {
      $tmpGra = $this->chart->getGraphics3D();

      if($this->getArrow()->getVisible())
      {
         $this->prepareCanvas($tmpGra, $this->getColor());

         $tmpGra->setPen($this->getArrow());

         if($this->CHECKMARKARROWCOLOR &&
         (($this->getArrow()->getColor() == $c) ||
         ($this->getArrow()->getColor() == $this->chart->getPanel()->getColor())))
         {
            $tmpGra->getPen()->setColor(($this->chart->getPanel()->getColor() ==
            new Color(0, 0, 0) ? new Color(255, 255, 255) : new Color(0, 0, 0)));
         }

         if($this->arrowHead == ArrowHeadStyle::$LINE)
         {
            $tmpGra->arrow(false, $pFrom, $pTo, $this->arrowHeadSize, $this->arrowHeadSize, $z);
         }
         else
            if($this->arrowHead == ArrowHeadStyle::$SOLID)
            {
               $tmpGra->arrow(true, $pFrom, $pTo, $this->arrowHeadSize, $this->arrowHeadSize, $z);
            }
            else
               if($this->arrowHead == ArrowHeadStyle::$NONE)
               {
                  if($this->chart->getAspect()->getView3D())
                  {
                     $tmpGra->moveToZ($pFrom, $z);
                     $tmpGra->lineTo($pTo, $z);
                  }
                  else
                  {
                     $tmpGra->__line($pFrom, $pTo);
                  }
               }
      }

      if($this->arrowHead == ArrowHeadStyle::$NONE && $this->getVisible())
      {
         $this->prepareCanvas($tmpGra, $this->getColor());

         $tmpFrom = $pFrom;

         if($this->chart->getAspect()->getView3D())
         {
            $tmpFrom = $tmpGra->calc3DPoint($pFrom, $z);
         }

         parent::draw($tmpGra, $this->chart->getAspect()->getView3D(),
         $tmpFrom->x, $tmpFrom->y, $this->getHorizSize(), $this->getVertSize(),
         $this->getColor(), $this->getStyle());
      }
   }

   /**
   * Arrow line between a Series Mark and a Series point.<br>
   * It is also used by Annotation tool to draw a line connecting the
   * annotation and the series point.
   *
   * @return ChartPen
   */
   public function getArrow()
   {
      if($this->arrow == null)
      {
         $tmpColor = new Color(255, 255, 255);
         $this->arrow = new ChartPen($this->chart, $tmpColor);
         
         unset($tmpColor);
      }
      return $this->arrow;
   }

   /**
   * Sets the Arrow line between a Series Mark and a Series point.<br>
   * It is also used by Annotation tool to draw a line connecting the
   * annotation and the series point.
   *
   * @param value ChartPen
   */
   public function setArrow($value)
   {
      $this->getArrow()->assign($value);
   }

   /**
   * Determines if callout line will display an "arrow" head at the end or
   * not. <br>
   * See TArrowHeadStyle enumerated values for options.
   *
   *
   * @return ArrowHeadStyle
   */
   public function getArrowHead()
   {
      return $this->arrowHead;
   }

   /**
   * Determines if callout line will display an "arrow" head at the end or
   * not. <br>
   *
   *
   * @param value ArrowHeadStyle
   */
   public function setArrowHead($value)
   {
      if($this->arrowHead != $value)
      {
         $this->arrowHead = $value;
         $this->invalidate();
      }
   }

   /**
   * The size in pixels to display the arrow head at the end of the
   * callout line.
   *
   * @return int
   */
   public function getArrowHeadSize()
   {
      return $this->arrowHeadSize;
   }

   /**
   * Sets the size in pixels of the arrow head at the end of the
   * callout line.
   *
   * @param value int
   */
   public function setArrowHeadSize($value)
   {
      if($this->arrowHeadSize != $value)
      {
         $this->arrowHeadSize = $value;
         $this->invalidate();
      }
   }

   /**
   * The length in pixels between a series point and the line connecting the
   * series mark or annotation.
   *
   * @return int
   */
   public function getDistance()
   {
      return $this->distance;
   }

   /**
   * The length in pixels between a series point and the line connecting the
   * series mark or annotation.
   *
   * @param value int
   */
   public function setDistance($value)
   {
      if($this->distance != $value)
      {
         $this->distance = $value;
         $this->invalidate();
      }
   }
}

?>
