<?php
 /**
 * Description:  This file contains the following class:<br>
 * Bubble class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Bubble class
 *
 * Description: Bubble Series
 *
 * Example:
 *
 * $bubbleSeries = new Bubble($myChart->getChart());
 * $bubbleSeries->getXValues().setDateTime(true);
 * $bubbleSeries->getRadiusValues()->setDateTime(false);
 * $bubbleSeries->getRadiusValues()->setName("Radius");
 * $bubbleSeries->getRadiusValues()->setOrder(ValueListOrder::$NONE);
 * $bubbleSeries->setHorizontalAxis(HorizontalAxis::$TOP);
 * $bubbleSeries->getMarks()->setArrowLength(0);
 * $bubbleSeries->getMarks()->setClip(true);
 * $bubbleSeries->getMarks()->getFont().setColor(Color::getWhite);
 * $bubbleSeries->getMarks()->getFont().setSize(16);
 * $bubbleSeries->getMarks()->getFont().setItalic(true);
 * $bubbleSeries->getMarks()->getFrame().setVisible(false);
 * $bubbleSeries->getMarks()->setTransparent(true);
 * $bubbleSeries->getMarks()->setVisible(false);
 * $bubbleSeries->getPointer()->setHorizSize(14);
 * $bubbleSeries->getPointer()->setVertSize(14);
 * $bubbleSeries->getPointer()->setInflateMargins(false);
 * $bubbleSeries->setVisible(true);
 * 
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class Bubble extends Points
{

   private $squared = true;
   private $radiusValues;

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
      parent::__construct($c);
      
      if ($this->radiusValues==null) {
         $this->radiusValues = new ValueList($this, Language::getString("ValuesBubbleRadius"));
      }

      $this->point->setInflateMargins(false);
      $this->point->setStyle(PointerStyle::$CIRCLE);      
      // TODO $point->allowChangeSize = false;
      $this->getMarks()->getPen()->setDefaultVisible(false);
      $this->getMarks()->setArrowLength(0-($this->getChart()->getGraphics3D()->getFontHeight() /2));
      $this->getMarks()->setTransparent(true);
      $this->getMarks()->getArrow()->setVisible(false);
      $this->bColorEach = true;
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->squared);
        unset($this->radiusValues);
    }    

   /**
   * Determines how the Bubble size is calculated.<br>
   * By default, the horizontal and vertical Bubble sizes are equal to the
   * radius of each bubble. When Squared is false, Bubble horizontal and
   * vertical sizes are calculated independently based on Series axis scales.
   * <br>
   * Default value: true
   *
   * @return boolean
   */
   public function getSquared()
   {
      return $this->squared;
   }

   /**
   * Determines how the Bubble size is calculated.<br>
   * Default value: true
   *
   * @param value boolean
   */
   public function setSquared($value)
   {
      $this->squared = $this->setBooleanProperty($this->squared, $value);
   }

   private function applyRadius($value, $aList, $increment)
   {
      $result = $value;
      for($t = 0; $t < $this->getCount() - 1; $t++)
      {
         if($increment)
         {
            $result = max($result, $aList->value[$t] + $this->radiusValues->value[$t]);
         }
         else
         {
            $result = min($result, $aList->value[$t] - $this->radiusValues->value[$t]);
         }
      }
      return $result;
   }

   protected function numSampleValues()
   {
      return 8;
   }

   protected function addSampleValues($numValues)
   {
      $r = $this->randomBounds($numValues);

      // some sample values to see something in design mode...
      for($t = 1; $t <= $numValues; $t++)
      {
         $this->__add($r->tmpX, // $this->X
         MathUtils::round($r->DifY * $r->Random()), // $this->Y
         ($r->DifY / 15.0) + MathUtils::round($r->DifY / (10 + 15 * $r->Random())));// $this->Radius
         $r->tmpX += $r->StepX;
      }
   }

   protected function drawLegendShape($g, $valueIndex, $r)
   {
      $tmp = min($r->width, $r->height);
      $this->point->setHorizSize($tmp);
      $this->point->setVertSize($tmp);
      parent::drawLegendShape($g, $valueIndex, $r);
   }

   /**
   * Called internally. Draws the "ValueIndex" point of the Series.
   *
   * @param valueIndex int
   */
   public function drawValue($valueIndex)
   {

      /* This overrided method is the main paint for bubble points.
      The bubble effect is achieved by changing the Pointer.Size based
      for    $the $this->series->  */

      $tmpSize = $this->calcYSizeValue($this->radiusValues->value[$valueIndex]);
      $this->point->setHorizSize($this->squared ? $tmpSize :
      $this->calcXSizeValue($this->radiusValues->value[$valueIndex]));
      $this->point->setVertSize($tmpSize);
      $this->drawPointer($this->calcXPos($valueIndex), $this->calcYPos($valueIndex),
      $this->getValueColor($valueIndex), $valueIndex);

      /* dont call inherited to avoid drawing the "pointer" */
   }

   /**
   * Adds a new Bubble point to the Series Points List and color.<br>
   * The Bubble point is assigned to be at AX, AY coordinates and have
   * ARadius and Color parameters. The Label parameter is used to
   * draw Axis Labels, Bubble Marks and Legend.
   *
   * @param x double x coordinate of bubble point.
   * @param y double y coordinate of bubble point.
   * @param radius double
   * @param color Color
   * @return int
   */

   public function ___add($x, $y, $radius, $color = null)
   {
      return $this->addBubble($x, $y, $radius, "", $color);
   }

   /**
   * Adds a new Bubble point to the Series Points List.<br>
   * The Bubble point is assigned to be at AX, AY coordinates and has
   * ARadius  parameter. The Label parameter is used to
   * draw Axis Labels, Bubble Marks and Legend.
   *
   * @param x double x coordinate of bubble point.
   * @param y double y coordinate of bubble point.
   * @param radius double
   * @return int
   */
   public function __add($x, $y, $radius)
   {
      $tmpColor = new Color(0, 0, 0, 0, true);// EMPTY color
      return $this->addBubble($x, $y, $radius, "", $tmpColor);
      
      unset($tmpColor);
   }

   /**
   * Adds a new Bubble point to the Series Points List and label.<br>
   * The Bubble point is assigned to be at AX, AY coordinates and have
   * ARadius and Label parameters. The Label parameter is used to
   * draw Axis Labels, Bubble Marks and Legend.
   *
   * @param x double x coordinate of bubble point.
   * @param y double y coordinate of bubble point.
   * @param radius double
   * @param text String
   * @return int
   */
   public function _add($x, $y, $radius, $text)
   {
      $tmpColor = new Color(0, 0, 0, 0, true);// EMPTY color
      return $this->addBubble($x, $y, $radius, $text, $tmpColor);
      
      unset($tmpColor);
   }

   /**
   * Adds a new Bubble point to the Series Points List, label and color.<br>
   * The Bubble point is assigned to be at AX, AY coordinates and have
   * ARadius, Label and Color parameters. The Label parameter is used to
   * draw Axis Labels, Bubble Marks and Legend.
   *
   * @param x double x coordinate of bubble point.
   * @param y double y coordinate of bubble point.
   * @param radius double
   * @param text String
   * @param color Color
   * @return int
   */

   public function addBubble($x, $y, $radius, $text="", $color=null)
   {
      $this->radiusValues->tempValue = $radius;
      return $this->addXYTextColor($x, $y, $text, $color);
   }

   /**
   * It's used to validate the DataSource property both at design and
   * run-time. <br>
   * It returns false if the Value parameter is the same as Self.
   *
   * @param value ISeries
   * @return boolean
   */
   public function isValidSourceOf($value)
   {
      return $value instanceof Bubble;//      $to $this->Bubbles->
   }

   /**
   * The Maximum Value of the Series Y Values List.
   *
   * @return double
   */
   public function getMaxYValue()
   {
      return $this->applyRadius(parent::getMaxYValue(), $this->vyValues, true);
   }

   /**
   * The Minimum Value of the Series Y Values List.
   *
   * @return double
   */
   public function getMinYValue()
   {
      return $this->applyRadius(parent::getMinYValue(), $this->vyValues, false);
   }

   /**
   * The maximum Z value.
   *
   * @return double
   */
   public function getMaxZValue()
   {
      if($this->point->getDraw3D())
      {
         return $this->radiusValues->getMaximum();
      }
      else
      {
         return parent::getMaxZValue();
      }
   }

   /**
   * The minimum Z value.
   *
   * @return double
   */
   public function getMinZValue()
   {
      if($this->point->getDraw3D())
      {
         return - $this->getRadiusValues()->getMaximum();
      }
      else
      {
         return parent::getMinZValue();
      }
   }

   /**
   * A TList object that stores each Bubble point Radius value.<br>
   * You can change Radius values by using the RadiusValues.Value[] array
   * of doubles method
   *
   * @return ValueList
   */
   public function getRadiusValues()
   {
      if ($this->radiusValues==null)
      {
           $this->radiusValues = new ValueList($this, Language::getString("ValuesBubbleRadius"));
      }

      return $this->radiusValues;
   }

   /**
   * A TList object that stores each Bubble point Radius value.<br>
   *
   * @param value ValueList
   */
   public function setRadiusValues($value)
   {
      $this->setValueList($this->radiusValues, $value);
   }

   /**
   * Controls which color will be drawn on the bubbles.<br>
   * If false, all points will be drawn using Series Series.Color.
   * If true, each Series point will be "colored" with its corresponding
   * point color. <br>
   * You can change this property both at design and runtime.<br>
   * Default value: true
   *
   * @return boolean
   */
   public function getColorEach()
   {
      return $this->bColorEach;
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("GalleryBubble");
   }
}

?>
