<?php
 /**
 * Description:  This file contains the following class:<br>
 * ColorLine class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * ColorLine class
 *
 * Description: Color Line tool. To draw custom lines at a axis value
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

class ColorLine extends ToolAxis
{

   private $allowDrag = true;
   private $dragRepaint = false;
   private $noLimitDrag = false;
   private $draw3D = true;
   private $drawBehind = false;
   private $style;
   private $lineValue = 0;
   private $dragging = false;

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

   public function __construct($c = null)
   {
      $this->style = ColorLineStyle::$CUSTOM;
      parent::__construct($c);
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->allowDrag);
        unset($this->dragRepaint);
        unset($this->noLimitDrag);
        unset($this->draw3D);
        unset($this->drawBehind);
        unset($this->style);
        unset($this->lineValue);
        unset($this->dragging);     
    }        

   public function addDragListener($l)
   {
      $this->listenerList->add($this->DragListener->class , $l);
   }

   public function removeDragListener($l)
   {
      $this->listenerList->remove($this->DragListener->class , $l);
   }

   /**
   *
   * Default value: ColorLineStyle.CUSTOM
   *
   * @return ColorLineStyle
   */
   public function getStyle()
   {
      return $this->style;
   }

   /**
   *
   * Default value: ColorLine.CUSTOM
   *
   * @param value ColorLineStyle
   */
   public function setStyle($value)
   {
      if($this->style != $value)
      {
         $this->style = $value;
         $this->invalidate();
      }
   }

   protected function calcValue()
   {
      if($this->style == ColorLineStyle::$MAXIMUM)
      {
         return $this->iAxis->getMaximum();
      }
      else
         if($this->style == ColorLineStyle::$CENTER)
         {
            return($this->iAxis->getMaximum() + $this->iAxis->getMinimum()) * 0 . 5;
         }
         else
            if($this->style == ColorLineStyle::$MINIMUM)
            {
               return $this->iAxis->getMinimum();
            }
      ;
      return $this->lineValue;
   }

   private function drawColorLine($back)
   {
      $g = $this->chart->getGraphics3D();
      $r = $this->chart->getChartRect();

      if(!$g->getPen()->getVisible())
      {
         $tmpColor = new Color(0, 0, 0);
         $tmpColor->setEmpty(true);
         $g->getPen()->color = $tmpColor;
      }

      $w = $this->chart->getAspect()->getWidth3D();

      $tmp = $this->iAxis->calcPosValue($this->calcValue());

      if($back)
      {
         if($this->iAxis->getHorizontal())
         {
            if($this->draw3D)
            {
               $g->zLine($tmp, $r->getBottom(), 0, $w);
            }
            if($this->draw3D || $this->drawBehind)
            {
               $g->verticalLine($tmp, $r->y, $r->getBottom(), $w);
            }
         }
         else
         {
            if($this->draw3D)
            {
               $g->zLine($r->x, $tmp, 0, $w);
            }
            if($this->draw3D || $this->drawBehind)
            {
               $g->horizontalLine($r->x, $r->getRight(), $tmp, $w);
            }
         }
      }
      else
         if($this->chart->getAspect()->getView3D() || ((!$this->dragging) || $this->dragRepaint))
         {
            if($this->iAxis->getHorizontal())
            {
               if($this->draw3D)
               {
                  $g->zLine($tmp, $r->y, 0, $w);
               }
               if(!$this->drawBehind)
               {
                  $g->verticalLine($tmp, $r->y, $r->getBottom(), 0);
               }
            }
            else
            {
               if($this->draw3D)
               {
                  $g->zLine($r->getRight(), $tmp, 0, $w);
               }
               if(!$this->drawBehind)
               {
                  $g->horizontalLine($r->x, $r->getRight(), $tmp, 0);
               }
            }
         }
   }

   public function chartEvent($e)
   {
      parent::chartEvent($e);
      if(($this->iAxis != null) &&
      ((/* TODO ($e->getID() == ChartDrawEvent::$PAINTING) &&*/
      ($e->getDrawPart() == ChartDrawEvent::$SERIES)) ||
      (/* TODO ($e->getID() == ChartDrawEvent::$PAINTED) &&*/
      ($e->getDrawPart() == ChartDrawEvent::$CHART))))
      {
         $this->chart->getGraphics3D()->setPen($this->getPen());
         $this->drawColorLine(/* TODO ($e->getID() == ChartDrawEvent::$PAINTING) &&*/
         ($e->getDrawPart() == ChartDrawEvent::$SERIES));
      }
   }

   public function mouseEvent($e, $c)
   {
      $tmpLimit;

      $tmpDoDraw = false;

      if($this->allowDrag && ($this->iAxis != null))
      {
         $tmpMouseEvent = new MouseEvent();
         if($e->getID() == $tmpMouseEvent->MOUSE_RELEASED)
         {
            $this->dragging = false;
            // force repaint
            if(!$this->dragRepaint)
            {
               $this->invalidate();
            }
            // call event
            $this->doEndDragLine();
         }
         else
            if($e->getID() == $tmpMouseEvent->MOUSE_MOVED || $e->getID() == $tmpMouseEvent->MOUSE_DRAGGED)
            {
               if($this->dragging)
               {
                  //MM force repaint could vary
                  if(!$this->dragRepaint)
                  {
                     $this->invalidate();
                  }

                  $tmp = $this->iAxis->getHorizontal() ? $e->getX() : $e->getY();

                  // calculate new position
                  $tmpNew = $this->getAxis()->calcPosPoint($tmp);

                  // check inside axis limits
                  if(!$this->noLimitDrag)
                  {
                     // do not use Axis Minimum & Maximum, we need the "real" min && max
                     if($this->iAxis->getHorizontal())
                     {
                        $tmpLimit = $this->iAxis->calcPosPoint($this->iAxis->iStartPos);
                        if($tmpNew < $tmpLimit)
                        {
                           $tmpNew = $tmpLimit;
                        }
                        else
                        {
                           $tmpLimit = $this->iAxis->calcPosPoint($this->iAxis->iEndPos);
                           if($tmpNew > $tmpLimit)
                           {
                              $tmpNew = $tmpLimit;
                           }
                        }
                     }
                     else
                     {
                        $tmpLimit = $this->iAxis->calcPosPoint($this->iAxis->iEndPos);
                        if($tmpNew < $tmpLimit)
                        {
                           $tmpNew = $tmpLimit;
                        }
                        else
                        {
                           $tmpLimit = $this->iAxis->calcPosPoint($this->iAxis->iStartPos);
                           if($tmpNew > $tmpLimit)
                           {
                              $tmpNew = $tmpLimit;
                           }
                        }
                     }
                  }

                  if($this->dragRepaint)
                  {
                     // call set_Value to force repaint whole chart
                     $this->setValue($tmpNew);
                  }
                  else
                  {

                     $tmpDoDraw = $this->lineValue != $tmpNew;
                     if($tmpDoDraw)
                     {
                        // draw line in xor mode, to avoid repaint the whole chart

                        $this->chart->getGraphics3D()->setPen($this->getPen());
                        //Pen.Mode=pmNotXor;

                        /* hide previous line */
                        $this->drawColorLine(true);
                        $this->drawColorLine(false);

                        /* set new value */
                        $this->lineValue = $tmpNew;
                     }
                  }

                  $this->chart->setCancelMouse(true);

                  /* call event, allow event to change Value */
                  $this->doDragLine();

                  if($tmpDoDraw)
                  {
                     /* draw at new position */
                     $this->drawColorLine(true);
                     $this->drawColorLine(false);
                     /* reset pen mode */
                     //chart.graphics3D.getPen().Mode=pmCopy;
                  }
               }
               else
               {
                  /* is mouse on line? */
                  if($this->clicked($e->getX(), $e->getY()))
                  {
                     /* 5.02 */
                     /* show appropiate cursor */
                     $tmpCursor = $this->iAxis->getHorizontal() ?
                     "VSPLIT" : "HSPLIT";
                     try
                     {
                        $c = $this->Cursor->getSystemCustomCursor($tmpCursor);
                     }
                     catch(Exception $exception)
                     {
                        /** @todo DO NOTHING? */
                     }

                     $this->chart->setCancelMouse(true);
                  }
               }
            }
            else
               if($e->getID() == $tmpMouseEvent->MOUSE_PRESSED)
               {
                  // is mouse over line ?
                  $this->dragging = $this->clicked($e->getX(), $e->getY());
                  $this->chart->setCancelMouse($this->dragging);
               }
      }

      return $c;
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("ColorLineTool");
   }

   /**
   * Gets detailed descriptive text.
   *
   * @return String
   */
   public function getSummary()
   {
      return Language::getString("ColorLineSummary");
   }

   protected function doEndDragLine()
   {
      $this->fireDragged(new ChangeEvent($this));
   }

   protected function doDragLine()
   {
      $this->fireDragging(new ChangeEvent($this));
   }

   private function clicked($x, $y)
   {
      $tmp = $this->iAxis->getHorizontal() ? $x : $y;
      if(abs($tmp - $this->iAxis->calcPosValue($this->calcValue())) < $this->clickTolerance)
      {
         $r = $this->chart->getChartRect();
         return $this->iAxis->getHorizontal() ? ($y >= $r->y) && ($y <= $r->getBottom()) :
         ($this->x >= $r->x) && ($x <= $r->getRight());
      }
      else
      {
         return false;
      }
   }

   /**
   * Allows mousedrag of Line when true. <br>
   * Default value: true
   *
   * @return boolean
   */
   public function getAllowDrag()
   {
      return $this->allowDrag;
   }

   /**
   * Allows mousedrag of Line when true. <br>
   * Default value: true
   *
   * @param value boolean
   */
   public function setAllowDrag($value)
   {
      $this->allowDrag = $this->setBooleanProperty($this->allowDrag, $value);
   }

   /**
   * Repaints the Chart while moving the ColorLine when true.<br>
   * Set to true to repaint the Chart while moving the ColorLine. <br>
   * Default value: false
   *
   * @return boolean
   */
   public function getDragRepaint()
   {
      return $this->dragRepaint;
   }

   /**
   * Set to true to repaint the Chart while moving the ColorLine. <br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setDragRepaint($value)
   {
      $this->dragRepaint = $this->setBooleanProperty($this->dragRepaint, $value);
   }

   /**
   * Draws ColorLine in 3D when true.<br>
   * Default value: true
   *
   * @return boolean
   */
   public function getDraw3D()
   {
      return $this->draw3D;
   }

   /**
   * Draws ColorLine in 3D when true.<br>
   * Default value: true
   *
   * @param value boolean
   */
   public function setDraw3D($value)
   {
      $this->draw3D = $this->setBooleanProperty($this->draw3D, $value);
   }

   /**
   * Draws the ColorLine behind the series values.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getDrawBehind()
   {
      return $this->drawBehind;
   }

   /**
   * Draws the ColorLine behind the series values.<br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setDrawBehind($value)
   {
      $this->drawBehind = $this->setBooleanProperty($this->drawBehind, $value);
   }

   /**
   * Allows drag of ColorLine outside of the Chart rectangle.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getNoLimitDrag()
   {
      return $this->noLimitDrag;
   }

   /**
   * Allows drag of ColorLine outside of the Chart rectangle.<br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setNoLimitDrag($value)
   {
      $this->noLimitDrag = $this->setBooleanProperty($this->noLimitDrag, $value);
   }

   /**
   * Determines Axis position where the ColorLine has to be drawn.<br>
   * Default value: 0
   *
   * @return double
   */
   public function getValue()
   {
      return $this->lineValue;
   }

   /**
   * Sets the Axis position where the ColorLine has to be drawn.<br>
   * Default value: 0
   *
   * @param value double
   */
   public function setValue($value)
   {
      $this->lineValue = $this->setDoubleProperty($this->lineValue, $value);
   }
}

?>