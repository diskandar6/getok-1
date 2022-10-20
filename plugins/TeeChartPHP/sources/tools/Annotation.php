<?php
 /**
 * Description:  This file contains the following class:<br>
 * Annotation class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * Annotation class
 *
 * Description: Annotation tool
 *
 * @author
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

class Annotation extends Tool
{
   private $position;
   private $shape;
   private $textAlign;
   private $cursor;
   private $callout;
   private $customSize;

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

   public function __construct($c = null , $text = "")
   {
      $this->position = AnnotationPosition::$LEFTTOP;
      $this->textAlign = Array(StringAlignment::$HORIZONTAL_LEFT_ALIGN);
      parent::__construct($c);
      $this->setText($text);
      $this->getShape()->setDrawText(false);
      $this->shape->getShadow()->setVisible(true);
      $this->getCallout()->setChart($this->chart);
   }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->position);
        unset($this->shape);
        unset($this->textAlign);
        unset($this->cursor);
        unset($this->callout);
        unset($this->customSize);
    }  
       
   public function addToolMouseListener($l)
   {
      $this->listenerList->add($this->ToolMouseListener->class , $l);
   }

   public function removeToolMouseListener($l)
   {
      $this->listenerList->remove($this->ToolMouseListener->class , $l);
   }

   public function getCallout()
   {
      if($this->callout == null)
      {
         $this->callout = new AnnotationCallout(null);
      }
      return $this->callout;
   }

   /**
   * The Cursor type for when the user moves the mouse over the
   * Annotation bounds. <br>
   * Default value: Default
   *
   * @return Cursor
   */
   public function getCursor()
   {
      return $this->cursor;
   }

   /**
   * Selects the Cursor type for when the user moves the mouse over the
   * Annotation bounds. <br>
   * Default value: Default
   *
   * @param value Cursor
   */
   public function setCursor($value)
   {
      $this->cursor = $value;
   }

   public function setChart($c)
   {
      parent::setChart($c);
      $this->getShape()->setChart($this->chart);
      $this->getCallout()->setChart($this->chart);
   }

   /**
   * Horizontal alignment of displayed text.<br>
   * Default value: StringAlignment.Near
   *
   * @return StringAlignment
   */
   public function getTextAlign()
   {
      return $this->textAlign;
   }

   /**
   * Sets the horizontal alignment of displayed text.<br>
   * Default value: StringAlignment.Near
   *
   * @param value StringAlignment
   */
   public function setTextAlign($value)
   {
      if($this->textAlign != $value)
      {
         $this->textAlign = $value;
         $this->invalidate();
      }
   }

   /**
   * The horizontal displacement in pixels of text box from Chart's left
   * edge.
   *
   * @return int
   */
   public function getLeft()
   {
      return $this->shape->getLeft();
   }

   /**
   * Sets horizontal displacement in pixels of text box from Chart's left
   * edge.
   *
   * @param value int
   */
   public function setLeft($value)
   {
      $this->shape->setLeft($value);
      $this->shape->setCustomPosition(true);
   }

   /**
   * The vertical displacement in pixels of text box from Chart's top edge.
   *
   * @return int
   */
   public function getTop()
   {
      return $this->shape->getTop();
   }

   /**
   * Sets vertical displacement in pixels of text box from Chart's top edge.
   *
   * @param value int
   */
   public function setTop($value)
   {
      $this->shape->setTop($value);
      $this->shape->setCustomPosition(true);
   }

   /**
   * The default position for the Annotation Tool text box and text.
   * <br>
   * Default value: AnnotationPosition.LeftTop
   *
   *
   * @return AnnotationPosition
   */
   public function getPosition()
   {
      return $this->position;
   }

   /**
   * Defines a default position for the Annotation Tool text box and text.
   * <br>
   * Default value: AnnotationPosition.LeftTop
   *
   *
   * @param value AnnotationPosition
   */
   public function setPosition($value)
   {
      if($this->position != $value)
      {
         $this->position = $value;
         $this->shape->setCustomPosition(false);
         $this->invalidate();
      }
   }

   /**
   * The characteristics of the Annotation Tool text and text box Shape.
   *
   * @return TextShapePosition
   */
   public function getShape()
   {
      if($this->shape == null)
      {
         $this->shape = new TextShapePosition($this->chart);
      }
      return $this->shape;
   }

   protected function getInnerText()
   {
      return $this->shape->getText();
   }

   /**
   * The text for the Annotation Tool.<br>
   * Default value: ""
   *
   * @return String
   */
   public function getText()
   {
      return $this->getInnerText();
   }

   /**
   * Defines the text for the Annotation Tool.<br>
   * Default value: ""
   *
   * @param value String
   */
   public function setText($value)
   {
      $this->getShape()->setText($value);
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("AnnotationTool");
   }

   /**
   * Gets detailed descriptive text.
   *
   * @return String
   */
   public function getSummary()
   {
      return Language::getString("AnnotationSummary");
   }

   /**
   * Returns the annotation height in pixels
   * @return int
   */
   public function getHeight()
   {
      return $this->shape->getHeight();
   }

   /**
   * Sets the annotation height in pixels
   * @param value int
   */
   public function setHeight($value)
   {
      $this->shape->setHeight($value);
   }

   /**
   * Returns the annotation width in pixels
   * @return int
   */
   public function getWidth()
   {
      return $this->shape->getWidth();
   }

   /**
   * Sets the annotation width in pixels
   * @param value int
   */
   public function setWidth($value)
   {
      $this->shape->setWidth($value);
   }

   /// Set to true to permit custom sizing of TextShape.
   public function getCustomSize()
   {
      return $this->customSize;
   }

   public function setCustomSize($value)
   {
      $this->customSize = $value;
   }

   private function drawText()
   {
      $tmp = $this->getText();

      if(strlen($tmp) == 0)
         $tmp = " ";

      $g = $this->chart->getGraphics3D();

      $g->setFont($this->shape->getFont());
      $tmpHeight =$this->shape->getFont()->getSize();

      $m = $this->chart->multiLineTextWidth($tmp);
      $tmpW = $m->width-$tmpHeight;
      $tmpN = $m->count;
      $tmpH = $tmpN * $tmpHeight;

      $x = 0;
      $y = 0;

      if($this->shape->getCustomPosition())
      {
         $x = $this->shape->getShapeBounds()->getLeft() + 4;
         $y = $this->shape->getShapeBounds()->getTop() + 4;
      }
      else
      {
         $tmpX = $this->chart->getWidth() - $tmpW - 8;
         $tmpY = $this->chart->getHeight() - $tmpH - 8;

         if($this->position == AnnotationPosition::$LEFTTOP)
         {
            $x = 10;
            $y = 10;
         }
         else
            if($this->position == AnnotationPosition::$LEFTBOTTOM)
            {
               $x = 10;
               $y = $tmpY;
            }
            else
               if($this->position == AnnotationPosition::$RIGHTTOP)
               {
                  $x = $tmpX;
                  $y = 10;
               }
               else
               {
                  $x = $tmpX;
                  $y = $tmpY;
               }
      }

      $this->shape->setShapeBounds(new Rectangle($x - 4, $y - 4, $tmpW + 4,
      4 + ($tmpHeight * 1.20) + 4));

      if($this->shape->getVisible())
      {
         $oldname = TChart::$controlName;
         TChart::$controlName = 'Annotation'; 
         $this->shape->paint();
         TChart::$controlName=$oldname;
      }

      $g->getBrush()->setVisible(false);
      $g->setTextAlign($this->textAlign);

      /* TODO
      if($this->textAlign == StringAlignment::$CENTER)
      {
         $x = 2 +
         (($this->shape->getShapeBounds()->x + $this->shape->getShapeBounds()->getRight()) /
         2);
      }
      else
         if($this->textAlign == StringAlignment::$FAR)
         {
            $x = $this->shape->getShapeBounds()->getRight() - 2;
         }
      */
      $s = Array();// Array of String
      $s = StringFormat::split($tmp, Language::getString("LineSeparator"));

      for($t = 1; $t <= $tmpN; $t++)
      {
         $g->textOut($x, $y + ($t * $tmpHeight),0, $s[$t - 1]);
      }

      // Draw callout
      if($this->getCallout()->getVisible() || $this->callout->getArrow()->getVisible())
      {
         $tmpTo = new TeePoint($this->callout->getXPosition(),
         $this->callout->getYPosition());
         $tmpFrom = $this->callout->closerPoint($this->shape->getShapeBounds(), $tmpTo);

         if($this->callout->getDistance() != 0)
         {
            $tmpTo = MathUtils::pointAtDistance($tmpFrom, $tmpTo,
            $this->callout->getDistance());
         }

         $this->callout->draw(Color::EMPTYCOLOR() , $tmpTo, $tmpFrom, $this->callout->getZPosition());
      }
   }

   public function chartEvent($e)
   {
      parent::chartEvent($e);
      //$tmpChartDrawEvent = new ChartDrawEvent();
      if(/*($e->getID() == ChartDrawEvent::$PAINTED) &&*/ ($e->getDrawPart() == ChartDrawEvent::$CHART))
      {
         $this->drawText();
      }
   }

   /**
   * Returns true is point parameter is inside annotation bounds
   * @param p Point
   * @return boolean
   */
   public function clicked($p)
   {
      return $this->getShape()->getShapeBounds()->contains($p);
   }

   public function mouseEvent($e, $c)
   {
      $tmpMouseEvent = new MouseEvent();
      if($e->getID() == $tmpMouseEvent->MOUSE_PRESSED)
      {
         if($this->clicked($e->getPoint()))
         {
            $e->setSource($this);
            $this->fireClicked($e);
         }
      }
      else
      {
         if(($e->getID() == $tmpMouseEvent->MOUSE_MOVED) &&
         ($this->cursor != $this->Cursor->getDefaultCursor()))
         {
            if($this->clicked($e->getPoint()))
            {
               $c = $this->cursor;
            }
         }
      }
      return $c;
   }
}
?>