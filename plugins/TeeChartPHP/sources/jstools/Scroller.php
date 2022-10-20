<?php
  /**
 * Description:  This file contains the following class:<br>
 * Scroller class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */
/**
 * Scroller class
 *
 * Description: Scroller jstool
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */

class Scroller extends Slider
{
   private $margin=0;
   private $lock=false;   
   private $thumb;
   protected $bounds;
   

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
      $this->useRange=true;
      $this->thunbSize=100;
      $this->horizontal=true;
      $this->margin=0;
      $this->lock=false;
      
      parent::__construct($c);
      
      $this->getThumb()->setChart($this->chart);
   }

   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->margin);
        unset($this->lock);
        unset($this->thumb);
        unset($this->bounds);
   } 
       
   public function setChart($c)
   {
      parent::setChart($c);
      $this->getThumb()->setChart($this->chart);
   }
      
   public function getThumb()
   {
      if($this->thumb == null)
         $this->thumb = new ScrollerThumb(null);
         
      return $this->thumb;
   }

   public function getBounds()
   {
      if($this->bounds == null)
         $this->bounds = new Rectangle(0,0,$this->getChart()->getWidth(),$this->getChart()->getHeight()); 
         
      return $this->bounds;
   }

   public function setBounds($value)
   {
      if($this->bounds != $value)
         $this->bounds = $value;
   }

   public function getMargin()
   {
      return $this->margin;
   }

   public function setMargin($value)
   {
      if($this->margin != $value)
         $this->margin = $value;
   }

   public function getLock()
   {
      return $this->lock;
   }

   public function setLock($value)
   {
      if($this->lock != $value)
         $this->lock = $value;
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
      return Language::getString("ScrollerTool");
   }

   /**
   * Gets detailed descriptive text.
   *
   * @return String
   */
   public function getSummary()
   {
      return Language::getString("ScrollerSummary");
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
}
?>