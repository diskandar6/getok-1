<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: LegendSymbol class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: LegendSymbol class</p>
  *
  * <p>Description: Legend item symbol characteristics</p>
  *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */

  class LegendSymbol extends TeeBase {

    /**
    * Determines if legend symbol should display without separation from other
    * legend item symbols.
    */

    /* todo review protected*/ public $continuous=false;

    /**
    * Controls where to display the legend symbol related to symbol item.
    */
    /* todo review protected*/ public $position;

    /**
    * Internal field pointing to parent legend class
    */
    public $legend;
    private $defaultPen=true;
    private $width = 20;
    private $widthUnits;
    private $iPen;
    private $squared=false;
    private $visible=true;


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
    * The class constructor.
    */
    public function __construct($legend) {

        $this->position = LegendSymbolPosition::$LEFT;
        $this->widthUnits = LegendSymbolSize::$PERCENT;

        parent::__construct($legend->chart);
       
        $this->readResolve();
        $this->legend = $legend;
    }

    
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->continuous);
        unset($this->position);
        unset($this->legend);
        unset($this->defaultPen);
        unset($this->width);
        unset($this->widthUnits);
        unset($this->iPen);
        unset($this->squared);
        unset($this->visible);
   }       
   
    protected function readResolve() {
        $this->defaultPen=true;
        return $this;
    }

    /**
      * Defines the width of the color rectangles (symbols).<br>
      * Default value: 20
      *
      * @return int
      */
    public function getWidth() {
        return $this->width;
    }

    public function setWidth($value) {
        $this->width = $this->setIntegerProperty($this->width, $value);
    }

    /**
      * The position of the Legend color rectangles. <br>
      * It can have one of the following values: <br>
      * Left      The color rectangles are placed left of the legend items <br>
      * Right    The color rectangles are placed right of the legend items <br>
      * Default value: Left
      *
      * @return LegendSymbolPosition
      */
    public function getPosition() {
        return $this->position;
    }

    /**
      * Sets the position of the Legend color rectangles. <br>
      * Default value: Left
      *
      * @param value LegendSymbolPosition
      */
    public function setPosition($value) {
        if ($this->position != $value) {
            $this->position = $value;
            $this->invalidate();
        }
    }

    /**
      * Defines the Width units for the width of Symbol.<br><br>
      * - Percent is percentage of Legend box width <br>
      * - Pixels is the width in standard pixels <br>
      * Default value: Percent
      *
      * @return LegendSymbolSize
      */
    public function getWidthUnits() {
        return $this->widthUnits;
    }

    /**
      * Sets the Width units for the width of Symbol.<br><br>
      * Default value: Percent
      *
      * @param value LegendSymbolSize
      */
    public function setWidthUnits($value) {
        if ($this->widthUnits != $value) {
            $this->widthUnits = $value;
            $this->invalidate();
        }
    }

    /**
      * Adjoins the different legend color rectangles when true.<br> The color
      * rectangles of the different items are drawn attached to each other
      * (no vertical spacing). When false, the color rectangles are drawn as
      * seperate rectangles. <br>
      * Default value: false
      *
      * @return boolean
      */
    public function getContinuous() {
        return $this->continuous;
    }

    /**
      * Adjoins the different legend color rectangles when true.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setContinuous($value) {
        $this->continuous = $this->setBooleanProperty($this->continuous, $value);
    }

    /**
      * Uses series pen properties to draw a border around the coloured box
      * legend symbol, when true. When false, the Legend will use the legend
      * symbol Pen property. <br>
      * Default value: true
      *
      * @return boolean
      */
    public function getDefaultPen() {
        return $this->defaultPen;
    }

    /**
      * Uses series pen properties to draw a border around the coloured box
      * legend symbol, when true. When false, the Legend will use the legend
      * symbol Pen property. <br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setDefaultPen($value) {
        $this->defaultPen = $this->setBooleanProperty($this->defaultPen, $value);
    }

    /*todo review protected*/ public function calcWidth($value) {
        if ($this->visible) {
            if ($this->squared) {
                return $this->legend->calcItemHeight() - 5;
            } else
            if ($this->widthUnits == LegendSymbolSize::$PERCENT) {
                return MathUtils::round($this->width * $value * 0.01);
            } else {
                return $this->width;
            }
        } else {
            return 0;
        }
    }

    /**
      * pen used to draw a border around the color box legend symbols. <br>
      * By default this pen is not used. Instead, the appropiate Series pen is
      * used to draw the symbols borders.<br>
      * To use this Pen, first set DefaultPen to false.
      *
      * @return ChartPen
      */
    public function getPen() {
        if ($this->iPen == null) {
            $this->iPen = new ChartPen($this->legend->chart);
        }
        return $this->iPen;
    }

    /**
      * Resizes the legend symbol to square shaped, when true.<br>
      * When false, the legend symbol height is determined by the legend font
      * size, and the symbol width is calculated using the Width and WidthUnits
      * properties.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getSquared() {
        return $this->squared;
    }

    /**
      * Resizes the legend symbol to square shaped, when true.<br>
      *
      * @param value boolean
      */
    public function setSquared($value) {
        $this->squared = $this->setBooleanProperty($this->squared, $value);
    }

    /**
      * Shows or hides Legend symbols.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getVisible() {
        return $this->visible;
    }

    /**
      * Shows or hides Legend symbols.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setVisible($value) {
        $this->visible = $this->setBooleanProperty($this->visible, $value);
    }
}

?>