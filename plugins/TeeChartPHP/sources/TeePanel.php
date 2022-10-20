<?php
 /**
 * Description:  This file contains the following class:<br>
 * TeePanel class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * TeePanel class
 *
 * Description: Chart background panel characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class TeePanel extends TeeShape {

    private $marginLeft = 3;
    private $marginTop = 4;
    private $marginRight = 3;
    private $marginBottom = 4;
    private $backInside=false;
    private $marginUnits=null;

    protected $internalCanvas;

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

    function __construct($c=null) {
        $this->marginUnits = PanelMarginUnits::$PERCENT;

        parent::__construct($c);
               
        $this->getPen()->setDefaultVisible(false);
        $this->getBrush()->setDefaultColor(new Color(220,220,220));  // defaultColor
        $this->getBevel()->setOuter(BevelStyle::$RAISED);
        $this->getBevel()->defaultOuter=BevelStyle::$RAISED;
    }
    
    public function __destruct()    
    {        
        parent::__destruct();
       
        unset($this->marginLeft);
        unset($this->marginTop);
        unset($this->marginRight);
        unset($this->marginBottom);
        unset($this->backInside);
        unset($this->marginUnits);
        unset($this->internalCanvas);    
    }          

    /**
     * Obsolete.&nbsp;Please use the Pen method instead.
     *
     * @return ChartPen
     */
    public function getBorderPen() {
        return $this->getPen();
    }

    /**
     * Shows or hides the Panel.
     *
     * @return boolean
     */
    public function getVisible() {
        return parent::getVisible();
    }

    /**
     * Shows or hides the Panel.
     *
     * @param value boolean
     */
    public function setVisible($value) {
        parent::setVisible($value);
    }

    public function setTransparent($value) {
    }

    /**
     * Paints the Chart in your preferred Canvas and region.
     *
     * @param g IGraphics3D
     * @param r Rectangle
     * @return Rectangle
     */
    public function draw($g, $r) {
        
      if ($this->chart->canDrawPanelBack()) {
            if ($this->getShadow()->getVisible()) {

                $w = $this->getShadow()->getWidth();
                if ($w > 0) {
                    $r->width -= $w;
                } else {
                    $r->x += $w;
                }
                $h = $this->getShadow()->getHeight();
                if ($h > 0) {
                    $r->height -= $h;
                } else {
                    $r->y += $h;
                }
            }

            $r->setWidth($r->getWidth()-$this->getPen()->getWidth());
            $r->setHeight($r->getHeight()-$this->getPen()->getWidth());
            
            $this->paint($g, $r);
        }

        return $this->applyMargins($r);
    }

    public function applyMargins($r) {
        // Apply panel margins
        $tmpH = $r->getHeight();

        if ($this->marginTop != 0) {
            $tmp = ($this->marginUnits == PanelMarginUnits::$PERCENT) ?
                      MathUtils::round($tmpH * $this->marginTop * 0.01) :
                      MathUtils::round($this->marginTop);
            $r->y += $tmp;
            $r->height -= $tmp;
        }

        if ($this->marginBottom != 0) {
            $tmp = ($this->marginUnits == PanelMarginUnits::$PERCENT) ?
                      MathUtils::round($tmpH * $this->marginBottom * 0.01) :
                      MathUtils::round($this->marginBottom);
            $r->height -= $tmp;
        }

        $tmpW = $r->getWidth();

        if ($this->marginLeft != 0) {
            $tmp = ($this->marginUnits == PanelMarginUnits::$PERCENT) ?
                      MathUtils::round($tmpW * $this->marginLeft * 0.01) :
                      MathUtils::round($this->marginLeft);
            $r->x += $tmp;
            $r->width -= $tmp;
        }

        if ($this->marginRight != 0) {
            $tmp = ($this->marginUnits == PanelMarginUnits::$PERCENT) ?
                      MathUtils::round($tmpW * $this->marginRight * 0.01) :
                      MathUtils::round($this->marginRight);
            $r->width -= $tmp;
        }

        return $r;
    }

    /**
     * Obsolete.&nbsp;Please Set Panel.<!-- -->Image=null.
     */
    public function backImageClear() {
        $this->setImage(null);
    }

    /**
     * The units in which the Margins are expressed.<br>
     * Either as a percentage of the pixel height and width of the Chart
     * Drawing Canvas, or in pixels from the panel borders.<br>
     * Default value: Percent
     *
     * @return PanelMarginUnits
     */
    public function getMarginUnits() {
        return $this->marginUnits;
    }

    /**
     * Sets the units in which the Margins are expressed.<br>
     * Default value: Percent
     *
     * @param value PanelMarginUnits
     */
    public function setMarginUnits($value) {
        if ($this->marginUnits != $value) {
            $this->marginUnits = $value;
            $this->invalidate();
        }
    }

    /**
     * Left margin expressed as percentage of Chart Drawing.<br>
     * Each Chart.Panel class has four margin parameters: LeftMargin,
     * RightMargin, TopMargin, BottomMargin. These properties are expressed as
     * a percentage of the pixel height (for top and bottom margins) and width
     * (for left and right margins) of the Chart Drawing Canvas. Default values
     * are 8 for top and bottom margins and 12 for left and right margins.
     * Or they can be expressed in pixels by changing the MarginUnits from
     * percentage (default) to pixels.<br>
     * Default value: 12
     *
     * @return double
     */
    public function getMarginLeft() {
        return $this->marginLeft;
    }

    /**
     * Sets Left margin as percentage of Chart Drawing.<br>
     * Default value: 12
     *
     * @see Panel#getMarginLeft
     * @param value double
     */
    public function setMarginLeft($value) {
        $this->marginLeft = $this->setDoubleProperty($this->marginLeft, $value);
    }


    /**
     * Top margin  expressed as percentage of Chart Drawing.<br>
     * Each Chart.Panel class has four margin properties: LeftMargin,
     * RightMargin, TopMargin, BottomMargin. These properties are expressed as
     * a percentage of the pixel height (for top and bottom margins) and width
     * (for left and right margins) of the Chart Drawing Canvas. Default values
     * are 8 for top and bottom margins and 12 for left and right margins.
     * Or they can be expressed in pixels by changing the MarginUnits from
     * percentage (default) to pixels.<br>
     * Default value: 8
     *
     * @return double
     */
    public function getMarginTop() {
        return $this->marginTop;
    }

    /**
     * Sets Top margin as percentage of Chart Drawing.<br>
     * Default value: 8
     *
     * @see Panel#getMarginTop
     * @param value double
     */
    public function setMarginTop($value) {
        $this->marginTop = $this->setDoubleProperty($this->marginTop, $value);
    }

    /**
     * Right margin expressed as percentage of Chart Drawing.<br>
     * Each Chart.Panel class has four margin properties: LeftMargin,
     * RightMargin, TopMargin, BottomMargin. These properties are expressed as
     * a percentage of the pixel height (for top and bottom margins) and width
     * (for left and right margins) of the Chart Drawing Canvas. Default values
     * are 8 for top and bottom margins and 12 for left and right margins.
     * Or they can be expressed in pixels by changing the MarginUnits from
     * percentage (default) to pixels.<br>
     * Default value: 12
     *
     * @return double
     */
    public function getMarginRight() {
        return $this->marginRight;
    }

    /**
     * Sets Right margin as percentage of Chart Drawing.<br>
     * Default value: 12
     *
     * @see Panel#getMarginRight
     * @param value double
     */
    public function setMarginRight($value) {
        $this->marginRight = $this->setDoubleProperty($this->marginRight, $value);
    }

    /**
     * Bottom margin expressed as percentage of Chart Drawing.<br>
     * Each Chart.Panel class has four margin properties: LeftMargin,
     * RightMargin, TopMargin, BottomMargin. These properties are expressed as
     * a percentage of the pixel height (for top and bottom margins) and width
     * (for left and right margins) of the Chart Drawing Canvas. Default values
     * are 8 for top and bottom margins and 12 for left and right margins.
     * Or they can be expressed in pixels by changing the MarginUnits from
     * percentage (default) to pixels.<br>
     * Default value: 8
     *
     * @return double
     */
    public function getMarginBottom() {
        return $this->marginBottom;
    }

    /**
     * Sets Bottom margin as percentage of Chart Drawing.<br>
     * Default value: 8
     *
     * @see Panel#getMarginBottom
     * @param value double
     */
    public function setMarginBottom($value) {
        $this->marginBottom = $this->setDoubleProperty($this->marginBottom, $value);
    }


    /**
     * Obsolete.&nbsp;Please use Walls.<!-- -->Back.<!-- -->Image instead.
     *
     * @return boolean
     */
    public function getBackImageInside() {
        return $this->backInside;
    }

    /**
     * Obsolete.&nbsp;Please use Walls.<!-- -->Back.<!-- -->Image instead.
     *
     * @param value boolean
     */
    public function setBackImageInside($value) {
        $this->backInside = $this->setBooleanProperty($this->backInside, $value);
    }
}

?>