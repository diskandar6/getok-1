<?php
 /**
 * Description:  This file contains the following class:<br>
 * SeriesPointer class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: SeriesPointer class</p>
  *
  * <p>Description: Some Series have a Pointer method which returns a
  * SeriesPointer class. Pointers are shape figures drawn on each Y point
  * coordinate.</p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class SeriesPointer extends TeeBase {

    private $dark3D = true;
    private $inflate = true;
    private $horizSize = 4;
    private $vertSize = 4;
    private $style = 0;
    private $pen=null;
    private $bBrush=null;
    private $xMinus, $xPlus, $yMinus, $yPlus;
    private $series=null;

    protected $bVisible = true;
    protected $defaultVisible=true;
    protected $allowChangeSize=true;
    protected $draw3D = true;

    // Class Definition

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

    // Constructor
    public function __construct($c, $s) {
        $this->style = PointerStyle::$RECTANGLE;

        parent::__construct($c);

        $this->readResolve();
        $this->series = $s;
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->dark3D);
        unset($this->inflate);
        unset($this->horizSize);
        unset($this->vertSize);
        unset($this->style);
        unset($this->pen);
        unset($this->bBrush);
        unset($this->xMinus);
        unset($this->xPlus);
        unset($this->yMinus);
        unset($this->yPlus);
        unset($this->series);
        unset($this->bVisible);
        unset($this->defaultVisible);
        unset($this->allowChangeSize);
        unset($this->draw3D);
    }     
        
    public function assign($source) {
        if ($source->bBrush != null) {
            $this->getBrush()->assign($source->bBrush);
        }
        if ($source->pen != null) {
            $this->getPen()->assign($source->pen);
        }

        $this->style = $source->style;
        $this->vertSize = $source->vertSize;
        $this->horizSize = $source->horizSize;
        $this->dark3D = $source->dark3D;
        $this->draw3D = $source->draw3D;
        $this->inflate = $source->inflate;
        $this->bVisible = $source->bVisible;
        $this->allowChangeSize = $source->allowChangeSize;
        $this->defaultVisible = $source->defaultVisible;
    }

    protected function readResolve() {
        $this->defaultVisible = true;
        return $this;
    }

    /**
      * Fills pointer sides in 3D mode with darker color.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getDark3D() {
        return $this->dark3D;
    }

    /**
      * Fills pointer sides in 3D mode with darker color.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setDark3D($value) {
        $this->dark3D = $this->setBooleanProperty($this->dark3D, $value);
    }

    /**
      * Draws pointer in 3D mode.<br>
      * Currently only rectangle points have 3D capability. <br>
      * Default value: true
      *
      * @return boolean
      */
    public function getDraw3D() {
        return $this->draw3D;
    }

    /**
      * Draws pointer in 3D mode.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setDraw3D($value) {
        $this->draw3D = $this->setBooleanProperty($this->draw3D, $value);
    }

    /**
      * Shows or hides the pointer.<br>
      * When using a Points series (or any Series class derived from Points
      * series), setting Visible to false will not display anything. <br>
      * Pointers can be useful with Line series or Area series. <br>
      * When points are Visible, extra margins are applied to the four chart
      * axes (Left, Right, Top and Bottom). This is to make points just at axis
      * limits to be shown. <br>
      * You can deactivate these extra margins by setting
      * IPointer.InflateMargins to false. <br><br>
      * Points are filled using IPointer.Brush.
      *
      * @return boolean
      */
    public function getVisible() {
        return $this->bVisible;
    }

    /**
      * Shows or hides the pointer.<br>
      *
      * @param value boolean
      */
    public function setVisible($value) {
        $this->bVisible = $this->setBooleanProperty($this->bVisible, $value);
    }

    /**
      * Horizontal size of pointer in pixels.<br>
      * Series that derive from Points series usually override the HorizSize
      * and VertSize methods. <br>
      * For example, Bubble series uses the Radius method to determine the
      * correct HorizSize and VertSize, so these methods have no effect in
      * that Series. <br>
      * Default value: 4
      *
      * @return int
      */
    public function getHorizSize() {
        return $this->horizSize;
    }

    /**
      * Horizontal size of pointer in pixels.<br>
      * Default value: 4
      *
      * @param value int
      */
    public function setHorizSize($value) {
        $this->horizSize = $this->setIntegerProperty($this->horizSize, $value);
    }

    /**
      * Expands axes to fit pointers.<br>
      * When false, Chart Axis scales will be preserved and points close to the
      * Axis limits will be partially displayed. <br>
      * Default value: true
      *
      * @return boolean
      */
    public function getInflateMargins() {
        return $this->inflate;
    }

    /**
      * Expands axes to fit pointers.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setInflateMargins($value) {
        $this->inflate = $this->setBooleanProperty($this->inflate, $value);
    }

    /**
      * The Pointer style.<br>
      * It defines the shape used to display the Series Points.<br>
      * The default Rectangle style can be optionally in 3D mode by setting
      * Pointer.Draw3D to true. <br>
      * Series Pointer.Visible should be true.<br>
      * Default value: rectangle
      *
      *
      * @return PointerStyle
      */
    public function getStyle() {
        return $this->style;
    }

    /**
      * Sets the Pointer style.<br>
      * Default value: rectangle
      *
      *
      * @param value PointerStyle
      */
    public function setStyle($value) {
        if ($this->style != $value) {
            $this->style = $value;
            $this->invalidate();
        }
    }
    
    public function getSeries() {
        return $this->series;
    }

    /**
      * The Horizontal size of pointer in pixels.<br>
      * Series that derive from PointSeries usually override the HorizontalSize
      * and VerticalSize methods. <br>
      * For example, Bubble series uses the Radius property to determine the
      * correct HorizSize and VertSize, so these methods have no effect in
      * that Series. <br>
      * Default value: 4
      *
      * @return int
      */
    public function getVertSize() {
        return $this->vertSize;
    }

    /**
      * Sets Horizontal size of pointer in pixels.<br>
      * Default value: 4
      *
      * @param value int
      */
    public function setVertSize($value) {
        $this->vertSize = $this->setIntegerProperty($this->vertSize, $value);
    }

    /**
      * The Percent of semiglass effect.<br>
      * Default valuie: 0
      *
      * @return int
      */
    public function getTransparency() {
        return $this->getBrush()->getTransparency();
    }

    /**
      * Sets Percent of semiglass effect.<br>
      * Default valuie: 0
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * bubbleSeries.getPointer().setTransparency(50); // -- 50 %
      * </font></pre></p>
      *
      * @param value int
      */
    public function setTransparency($value) {
        $this->getBrush()->setTransparency($value);
    }

    /**
      * Configures Gradient filling attributes.<br>
      * Default value: null
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      *   bubbleSeries.getPointer().getGradient().setVisible(true);
      * </font></pre></p>
      *
      * @return Gradient
      */
    public function getGradient() {
        return $this->getBrush()->getGradient();
    }

    private function drawDiagonalCross($g, $is3D, $colorValue) {
        //g.AssignVisiblePenColor(Pen,ColorValue);
        if ($is3D) {
            $g->line($this->xMinus, $this->yMinus, $this->xPlus + 1, $this->yPlus + 1, $this->getStartZ());
            $g->line($this->xPlus, $this->yMinus, $this->xMinus - 1, $this->yPlus + 1, $this->getStartZ());
        } else {
            $g->line($this->xMinus, $this->yMinus, $this->xPlus + 1, $this->yPlus + 1);
            $g->line($this->xPlus, $this->yMinus, $this->xMinus - 1, $this->yPlus + 1);
        }
    }

    private function drawCross($g, $is3D, $px, $py, $colorValue) {
        //g.AssignVisiblePenColor(Pen,ColorValue);      
        if ($is3D) {
            $g->verticalLine($px, $this->yMinus, $this->yPlus + 1, $this->getStartZ());
            $g->horizontalLine($this->xMinus, $this->xPlus + 1, $py, $this->getStartZ());
        } else {
            $g->verticalLine($px, $this->yMinus, $this->yPlus + 1);
            $g->horizontalLine($this->xMinus, $this->xPlus + 1, $py);
        }
    }

    private function doTriangle3D($g, $deltaY, $px, $py) {
        if ($this->draw3D) {
            $g->pyramid(true, $this->xMinus, $py - $deltaY, $this->xPlus, $py + $deltaY,
                      $this->getStartZ(),
                      $this->getEndZ(), $this->dark3D);
        } else {
            $g->triangle(new TeePoint($this->xMinus, $py + $deltaY),
                       new TeePoint($this->xPlus, $py + $deltaY),
                       new TeePoint($px, $py - $deltaY), $this->getStartZ());
        }
    }

    private function doHorizTriangle3D($g, $deltaX, $px, $py) {
        if ($this->draw3D) {
            $g->pyramid(false, $px + $deltaX, $this->yMinus, $px - $deltaX, $this->yPlus,
                      $this->getStartZ(),
                      $this->getEndZ(), $this->dark3D);
        } else {
            $g->triangle(new TeePoint($px + $deltaX, $this->yMinus),
                       new TeePoint($px + $deltaX, $this->yPlus),
                       new TeePoint($px - $deltaX, $py), $this->getStartZ());
        }
    }

    /**
      * For internal use.
      *
      * @return int
      */
    public function getStartZ() {
        if ($this->series != null) {
            return $this->series->getStartZ();
        } else {
            return 0;
        }
    }

    /**
      * For internal use.
      *
      * @return int
      */
    public function getMiddleZ() {
        if ($this->series != null) {
            return $this->series->getMiddleZ();
        } else {
            return 0;
        }
    }

    /**
      * For internal use.
      *
      * @return int
      */
    public function getEndZ() {
        if ($this->series != null) {
            return $this->series->getEndZ();
        } else {
            return 0;
        }
    }

    /**
      * The pointer color.
      *
      * @return Color
      */
    public function getColor() {
        return $this->getBrush()->getColor();
    }

    /**
      * Sets the pointer color.
      *
      * @param value Color
      */
    public function setColor($value) {
        $this->getBrush()->setColor($value);
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->pen != null) {
            $this->pen->setChart($c);
        }
        if ($this->bBrush != null) {
            $this->bBrush->setChart($c);
        }
    }

    /**
      * Internal use. Draw Pointer
      *
      *
      * @param g IGraphics3D
      * @param is3D boolean
      * @param px int
      * @param py int
      * @param tmpHoriz int
      * @param tmpVert int
      * @param colorValue Color
      * @param aStyle PointerStyle
      */
    public function intDraw($g, $is3D, $px, $py, $tmpHoriz,$tmpVert,
                                  $colorValue, $aStyle=0) {

        $old_name = TChart::$controlName;
        TChart::$controlName .= 'SeriesPointer_';     
                                              
        /* TODO                                                
        $g->getBrush()->setTransparency($this->getBrush()->getTransparency());
        $g->getBrush()->setColor($colorValue->transparentColor($g->getBrush()->
                $this->getTransparency()));
        */

        $this->xMinus = $px - $tmpHoriz;
        $this->xPlus = $px + $tmpHoriz;
        $this->yMinus = $py - $tmpVert;
        $this->yPlus = $py + $tmpVert;

        if ($is3D) {
            if ($aStyle == PointerStyle::$RECTANGLE) {
                if ($this->draw3D) {
                    $g->cube($this->xMinus, $this->yMinus, $this->xPlus, $this->yPlus, $this->getStartZ(),
                           $this->getEndZ(),
                           $this->dark3D);
                } else {
                    $g->rectangleWithZ(new Rectangle($this->xMinus, $this->yMinus, $this->xPlus + 1, $this->yPlus + 1),
                                $this->getStartZ());
                }
            } else
            if ($aStyle == PointerStyle::$CIRCLE) {
                if ($this->draw3D && $g->getSupportsFullRotation()) {
                    $g->sphere($px, $py, $this->getMiddleZ(), $tmpHoriz);
                } else {
                    $g->ellipse($this->xMinus, $this->yMinus, $this->xPlus, $this->yPlus, $this->getStartZ());
                }
            } else
            if ($aStyle == PointerStyle::$SPHERE) {
                $g->sphere(Rectangle::fromLTRB($this->xMinus, $this->yMinus, $this->xPlus, $this->yPlus),
                         $this->getStartZ(), false);
            } else
            if ($aStyle == PointerStyle::$POLISHEDSPHERE) {
                $g->ellipse($this->xMinus, $this->yMinus, $this->xPlus, $this->yPlus, $this->getStartZ(), true);
            } else
            if ($aStyle == PointerStyle::$TRIANGLE) {
                $this->doTriangle3D($g, $tmpVert, $px, $py);
            } else
            if ($aStyle == PointerStyle::$DOWNTRIANGLE) {
                $this->doTriangle3D($g, -$tmpVert, $px, $py);
            } else
            if ($aStyle == PointerStyle::$LEFTTRIANGLE) {
                $this->doHorizTriangle3D($g, $tmpHoriz, $px, $py);
            } else
            if ($aStyle == PointerStyle::$RIGHTTRIANGLE) {
                $this->doHorizTriangle3D($g, -$tmpHoriz, $px, $py);
            } else
            if ($aStyle == PointerStyle::$CROSS) {
                $this->drawCross($g, true, $px, $py, $colorValue);
            } else
            if ($aStyle == PointerStyle::$DIAGCROSS) {
                $this->drawDiagonalCross($g, true, $colorValue);
            } else
            if ($aStyle == PointerStyle::$STAR) {
                $this->drawCross($g, true, $px, $py, $colorValue);
                $this->drawDiagonalCross($g, true, $colorValue);
            } else
            if ($aStyle == PointerStyle::$DIAMOND) {
                $g->plane(new TeePoint($this->xMinus, $py),
                        new TeePoint($px, $this->yMinus),
                        new TeePoint($this->xPlus, $py),
                        new TeePoint($px, $this->yPlus), $this->getStartZ());
            } else
            if ($aStyle == PointerStyle::$SMALLDOT) {
                $g->setPixel($px, $py, $this->getMiddleZ(), $colorValue);
            }
        } else {
            if ($aStyle == PointerStyle::$RECTANGLE) {
                $g->rectangle(new Rectangle($this->xMinus, $this->yMinus, ($tmpHoriz*2) + 1, ($tmpVert*2) + 1));
            } else
            if ($aStyle == PointerStyle::$CIRCLE) {
                $g->ellipse($this->xMinus, $this->yMinus, $this->xPlus, $this->yPlus);
            } else
            if ($aStyle == PointerStyle::$SPHERE) {
                $g->sphere($this->xMinus, $this->yMinus, $this->xPlus, $this->yPlus, true);
            } else
            if ($aStyle == PointerStyle::$POLISHEDSPHERE) {
                $g->ellipse($this->xMinus, $this->yMinus, $this->xPlus, $this->yPlus, true);
            } else
            if ($aStyle == PointerStyle::$TRIANGLE) {
                $p = Array(new TeePoint($this->xMinus, $this->yPlus),
                            new TeePoint($this->xPlus, $this->yPlus),
                            new TeePoint($px, $this->yMinus));
                $g->polygon($p);
            } else
            if ($aStyle == PointerStyle::$DOWNTRIANGLE) {
                $p = Array(new TeePoint($this->xMinus, $this->yMinus),
                            new TeePoint($this->xPlus, $this->yMinus),
                            new TeePoint($px, $this->yPlus));
                $g->polygon($p);
            } else
            if ($aStyle == PointerStyle::$LEFTTRIANGLE) {
                $p = Array(new TeePoint($this->xMinus, $py),
                            new TeePoint($this->xPlus, $this->yMinus),
                            new TeePoint($this->xPlus, $this->yPlus));
                $g->polygon($p);
            } else
            if ($aStyle == PointerStyle::$RIGHTTRIANGLE) {
                $p = Array(new TeePoint($this->xMinus, $this->yMinus),
                            new TeePoint($this->xMinus, $this->yPlus),
                            new TeePoint($this->xPlus, $py));
                $g->polygon($p); 
            } else
            if ($aStyle == PointerStyle::$CROSS) {
                $this->drawCross($g, false, $px, $py, $colorValue);                
            } else
            if ($aStyle == PointerStyle::$DIAGCROSS) {
                $this->drawDiagonalCross($g, false, $colorValue);
            } else
            if ($aStyle == PointerStyle::$STAR) {
                $this->drawCross($g, false, $px, $py, $colorValue);
                $this->drawDiagonalCross($g, false, $colorValue);
            } else
            if ($aStyle == PointerStyle::$DIAMOND) {
                $p = Array(new TeePoint($this->xMinus, $py),
                            new TeePoint($px, $this->yMinus),
                            new TeePoint($this->xPlus, $py),
                            new TeePoint($px, $this->yPlus));
                $g->polygon($p);
            } else
            if ($aStyle == PointerStyle::$SMALLDOT) {
                $g->SetPixel3D($px, $py, $this->getMiddleZ(), $colorValue);
            }
        }
        
        TChart::$controlName=$old_name;
    }

    public function draw($px, $py, $colorValue, $aStyle=0) {
        $this->intDraw($this->chart->getGraphics3D(), $this->chart->getAspect()->getView3D(), $px, $py,
             $this->horizSize,
             $this->vertSize,
             $colorValue, $aStyle);
    }

    public /* todo review protected*/ function prepareCanvas($g, $colorValue) {
        $g->setPen($this->getPen());
        $tmpColor = new Color(0,0,0); // Todo TransparentColor
        if ($this->pen->getColor()->isEmpty() || $colorValue == $tmpColor) {
            $g->getPen()->setColor($colorValue);
        }
        $g->setBrush($this->getBrush());

        if ($this->bBrush->getColor()->isEmpty()) {
            $g->getBrush()->setForegroundColor($this->bBrush->getSolid() ? $colorValue :
                                            Color::BLACK());
            $g->getBrush()->setColor($colorValue);
        } else if ($this->series != null) {
            if ($this->series->getColorEach() || $colorValue == Color::TRANSPARENT()) {
                $g->getBrush()->setColor($colorValue);
            } else {
                $g->getBrush()->setColor($this->bBrush->getColor());
            }
        } else {
            $g->getBrush()->setColor($colorValue);
        }
    }

    /**
      * Pen used to draw a frame around Series Pointers.
      *
      * @return ChartPen
      */
    public function getPen() {
        if ($this->pen == null) {
            $tmpColor = new Color(0,0,0);
            $this->pen = new ChartPen($this->chart, $tmpColor);
        }
        return $this->pen;
    }

    /**
      * Brush used to fill Series Pointers.
      *
      * @return ChartBrush
      */
    public function getBrush() {
        if ($this->bBrush == null) {
            $this->bBrush = new ChartBrush($this->chart);
            if ($this->series != null) {
                $this->bBrush->setColor($this->series->getColor());
            }
        }
        return $this->bBrush;
    }

    /* TODO
    protected function drawLegendShape($color, $rect, $drawPen) {
        $this->drawLegendShape($this->chart->getGraphics3D(), $color, $rect, $drawPen);
    }
    */

    public function drawLegendShape($g, $color, $rect, $drawPen) {
        $tmpHoriz=0;
        $tmpVert=0;

        $this->prepareCanvas($g, $color);

        if ($drawPen) {
            $tmpHoriz = $rect->width / 3;
            $tmpVert = $rect->height / 3;
        } else {
            $tmpHoriz = 1 + ($rect->width / 2);
            $tmpVert = 1 + ($rect->height / 2);
        }

       $this->intDraw($g, false, ($rect->x + $rect->getRight()) / 2,
             ($rect->y + $rect->getBottom()) / 2,
             min($this->horizSize, $tmpHoriz),
             min($this->vertSize, $tmpVert), $color, $this->style);

    }

    public function calcHorizMargins($margins) {
        if ($this->bVisible && $this->inflate) {
            $margins->min = max($margins->min, $this->horizSize + 1);
            $margins->max = max($margins->max, $this->horizSize + 1);
        }
    }

    public function calcVerticalMargins($margins) {
        if ($this->bVisible && $this->inflate) {
            $margins->min = max($margins->min, $this->vertSize + 1);
            $margins->max = max($margins->max, $this->vertSize + 1);
        }
    }

    function setDefaultVisible($value) {
            $this->defaultVisible = $value;
            $this->bVisible = $value;
    }
}

?>