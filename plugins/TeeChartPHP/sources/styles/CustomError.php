<?php
 /**
 * Description:  This file contains the following class:<br>
 * CustomError class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * CustomError Class
 *
 * Description: Custom Error Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class CustomError extends Bar {

    private static $serialVersionUID = 1;
    protected $iErrorStyle = 5; // TOPBOTTOM;
    protected $bDrawBar = false;

    private $errorPen;
    private $errorValues;
    private $errorWidth = 100;
    private $errorWidthUnits = 0; // PERCENT;

    private $d;

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
        
    public function __construct($c=null) {
        parent::__construct($c);        
        
        $this->d = new Drawer();

        $this->errorValues = new ValueList($this, Language::getString("ValuesStdError")); // <-- Std Error storage
        $this->getMarks()->setDefaultVisible(false);
    }

    
    protected function readResolve() {
       $this->d = new Drawer();
       return parent::readResolve();
    }

    /**
     * Gets and sets the corresponding Error value for each Bar.<br>
     * The Error value will be displayed as a "T" on top of each Bar.
     *
     * @return ValueList
     */
    public function getErrorValues() {
        return $this->errorValues;
    }

    /**
     * Defines Pen to draw Error "T" on top of Error Bars.<br>
     *
     * @return ChartPen
     */
    public function getErrorPen() {
        if ($this->errorPen == null) {
            $this->errorPen = new ChartPen($this->chart, Color::BLACK(), true);
        }
        return $this->errorPen;
    }

    /**
     * Defines the Error Series Style according to EErrorSeriesStyle.<br>
     * Default value: ErrorStyle.TopBottom
     *
     *
     * @return ErrorStyle
     */
    public function getErrorStyle() {
        return $this->iErrorStyle;
    }

    /**
     * Defines the Error Series Style according to EErrorSeriesStyle.<br>
     * Default value: ErrorStyle.TopBottom
     *
     *
     * @param value ErrorStyle
     */
    public function setErrorStyle($value) {
        if ($this->iErrorStyle != $value) {
            $this->iErrorStyle = $value;
            $this->invalidate();
        }
    }

    /**
     * The ErrorWidth in pixels or percentage of Bar width.<br>
     * By default, the Error "T" width is 100% of Bar width. <br>
     * Default value: ErrorWidthUnit.Percent
     *
     *
     * @return ErrorWidthUnit
     */
    public function getErrorWidthUnits() {
        return $this->errorWidthUnits;
    }

    /**
     * Sets ErrorWidth in pixels or percentage of Bar width.<br>
     * Default value: ErrorWidthUnit.Percent
     *
     *
     * @param value ErrorWidthUnit
     */
    public function setErrorWidthUnits($value) {
        if ($this->errorWidthUnits != $value) {
            $this->errorWidthUnits = $value;
            $this->invalidate();
        }
    }

    /**
     * Determines the horizontal size of the Error "T".<br>
     * Size is expressed either in pixels or in percent of Bar width depending
     * on ErrorWidthUnit property. <br<
     * By default, Error's "T" width is 100% of Bar width.<br>
     * Default value: 100
     *
     *
     * @return int
     */
    public function getErrorWidth() {
        return $this->errorWidth;
    }

    /**
     * Determines the horizontal size of the Error "T".<br>
     * Default value: 100
     *
     * @param value int
     */
    public function setErrorWidth($value) {
        $this->errorWidth = $this->setIntegerProperty($this->errorWidth, $value);
    }

    protected function addSampleValues($numValues) {
        
        $r = $this->randomBounds($numValues);
        for ($t = 1; $t <= $numValues; $t++) {
            $this->addXYErrorColor($r->tmpX, MathUtils::round($r->DifY * $r->Random()),
                $r->DifY / (20 + $r->Random()));
            $r->tmpX += $r->StepX;
        }
    }

    private function prepareErrorPen($g, $valueIndex) {
        $pen = Color::EMPTYCOLOR();
        $g->setPen($this->getErrorPen());

        if (($valueIndex != -1) && (!$this->bDrawBar)) {
            $g->getPen()->setColor($this->getValueColor($valueIndex));
        }
    }

    public function calcHorizMargins($margins) {
        parent::calcHorizMargins($margins);

        $tmp = MathUtils::round($this->getErrorPen()->getWidth());
        if (($this->iErrorStyle == ErrorStyle::$LEFT) ||
            ($this->iErrorStyle == ErrorStyle::$LEFTRIGHT)) {
            $margins->min = max($margins->min, $tmp);
        }
        if (($this->iErrorStyle == ErrorStyle::$RIGHT) ||
            ($this->iErrorStyle == ErrorStyle::$LEFTRIGHT)) {
            $margins->max = max($margins->max, $tmp);
        }
    }

    public function calcVerticalMargins($margins) {
        parent::calcVerticalMargins($margins);

        $tmp = MathUtils::round($this->getErrorPen()->getWidth());
        if (($this->iErrorStyle == ErrorStyle::$TOP) ||
            ($this->iErrorStyle == ErrorStyle::$TOPBOTTOM)) {
            $margins->min = max($margins->min, $tmp);
        }
        if (($this->iErrorStyle == ErrorStyle::$BOTTOM) ||
            ($this->iErrorStyle == ErrorStyle::$TOPBOTTOM)) {
            $margins->max = max($margins->max, $tmp);
        }
    }

    private function drawError($g, $x, $y, $aWidth, $aHeight, $draw3D) {

        $this->d->g = $g;
        $this->d->x = $x;
        $this->d->y = $y;
        $this->d->middleZ = $this->getMiddleZ();
        $this->d->aWidth = $aWidth;
        $this->d->draw3D = $draw3D;

       // g.getPen().setColor(Color.BLACK);

        if ($this->iErrorStyle == ErrorStyle::$LEFT) {
            $this->d->drawHoriz($x - $aHeight);
        } else
        if ($this->iErrorStyle == ErrorStyle::$RIGHT) {
            $this->d->drawHoriz($x + $aHeight);
        } else
        if ($this->iErrorStyle == ErrorStyle::$LEFTRIGHT) {
            $this->d->drawHoriz($x - $aHeight);
            $this->d->drawHoriz($x + $aHeight);
        } else
        if ($this->iErrorStyle == ErrorStyle::$TOP) {
            $this->d->drawVert($y - $aHeight);
        } else
        if ($this->iErrorStyle == ErrorStyle::$BOTTOM) {
            $this->d->drawVert($y + $aHeight);
        } else
        if ($this->iErrorStyle == ErrorStyle::$TOPBOTTOM) {
            $this->d->drawVert($y - $aHeight);
            $this->d->drawVert($y + $aHeight);
        }
    }

    protected function drawLegendShape($g, $valueIndex, $r) {
        $this->prepareErrorPen($g, $valueIndex);
        $this->drawError($g, ($r->x + $r->getRight()) / 2, ($r->y + $r->getBottom()) / 2, $r->width,
                  ($r->height / 2) - 1, false);
    }

    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);

        $this->getErrorPen()->setColor($isEnabled ? Color::RED() : Color::WHITE());
        $this->setColor($isEnabled ? Color::BLUE() : Color::SILVER());
    }

    public function setColor($c) {
        parent::setColor($c);
    }

    /**
     * Adds a new Error Bar point in selected color and with label.
     *
     * @param x double
     * @param y double
     * @param errorValue double
     * @param text String
     * @param color Color
     * @return int
     */
    public function addXYErrorTextColor($x, $y, $errorValue, $text="", $color=null) {
        $this->errorValues->tempValue = $errorValue;
        if ($color == null)
            $color = Color::EMPTYCOLOR();
            
        return $this->addXYTextColor($x, $y, $text, $color);
    }

    /**
     * Adds a new Error Bar point to the Series in selected color.
     *
     * @param x double
     * @param y double
     * @param errorValue double
     * @param color Color
     * @return int
     */
    public function addXYErrorColor($x, $y, $errorValue, $color=null) {
        if ($color == null)
            $color = Color::EMPTYCOLOR();
            
        return $this->addXYErrorTextColor($x, $y, $errorValue, "", $color);
    }

    // Problem: Conflict with Add(x,y). Solution: Renamed to AddValue.
    /**
     * Adds a new Error Bar point with y value and error Value only.
     * @param y double
     * @param errorValue double
     * @return int index of added point
     */
    public function addValue($y, $errorValue) {
        return $this->addXYErrorTextColor($this->getCount(), $y, $errorValue, "", Color::EMPTYCOLOR());
    }

    /**
     * Displays an ErrorBar point ( BarIndex point ) using the Start and
     * End pixel coordinates.<br>
     *
     * @param barIndex int
     * @param startPos int
     * @param endPos int
     */
    public function drawBar($barIndex, $startPos, $endPos) {

        if ($this->bDrawBar) {
            parent::drawBar($barIndex, $startPos, $endPos);
        }

        if ($this->getErrorPen()->getVisible()) {

            $tmpError = abs($this->errorValues->value[$barIndex]);

            if ($tmpError != 0) {

                $tmpBarWidth = $this->getBarBounds()->width;

                $tmpWidth=0.0;

                if ($this->errorWidth == 0) {
                    $tmpWidth = $tmpBarWidth;
                } else
                if ($this->errorWidthUnits == ErrorWidthUnit::$PERCENT) {
                    $tmpWidth = MathUtils::round($this->errorWidth * $tmpBarWidth * 0.01);
                } else {
                    $tmpWidth = $this->errorWidth;
                }

                $tmp = $this->calcYPosValue($this->vyValues->value[$barIndex]);

                $tmpHeight=0.0;

                /* MS   simplified and allows vertical/horizontal style 5.01 */
                if (($this->iErrorStyle == ErrorStyle::$LEFT) |
                    ($this->iErrorStyle == ErrorStyle::$RIGHT) |
                    ($this->iErrorStyle == ErrorStyle::$LEFTRIGHT)) {
                    $tmpHeight = $this->calcXSizeValue($tmpError);
                } else {
                    $tmpHeight = $this->calcYSizeValue($tmpError);
                }

                if ($this->bDrawBar && ($this->vyValues->value[$barIndex] < $this->getOrigin())) {
                    $tmpHeight = ( -$tmpHeight);
                }

                $this->prepareErrorPen($this->chart->getGraphics3D(), $barIndex);

                $this->drawError($this->chart->getGraphics3D(),
                          ($this->getBarBounds()->getRight() + $this->getBarBounds()->getLeft()) / 2,
                          $tmp, $tmpWidth, $tmpHeight,
                          $this->chart->getAspect()->getView3D());
            }
        }
    }

    /**
     * Returns the Maximum Value of the Series Y Values List.
     *
     * @return double
     */
    public function getMaxYValue() {
        $result = ($this->bDrawBar) ? parent::getMaxYValue() : 0;

        $tmp=0.0;

        for ($t = 0; $t < $this->getCount(); $t++) {
            if ($this->bDrawBar) {
                $tmpErr = $this->errorValues->value[$t];
                $tmp = $this->vyValues->value[$t];
                if ($tmp < 0) {
                    $tmp -= $tmpErr;
                } else {
                    $tmp += $tmpErr;
                }
                if ($tmp > $result) {
                    $result = $tmp;
                }
            } else {
                $tmp = $this->vyValues->value[$t] + $this->errorValues->value[$t];
                $result = ($t == 0) ? $tmp : max($result, $tmp);
            }
        }

        return $result;
    }

    /**
     * Returns the Minimum Value of the Series Y Values List.
     *
     * @return double
     */
    public function getMinYValue() {
        $result = ($this->bDrawBar) ? parent::getMinYValue() : 0;

        for ($t = 0; $t < $this->getCount(); $t++) {
            if ($this->bDrawBar) {
                $tmpErr = $this->errorValues->value[$t];
                $tmp = $this->vyValues->value[$t];
                if ($tmp < 0) {
                    $tmp -= $tmpErr;
                } else {
                    $tmp += $tmpErr;
                }
                if ($tmp < $result) {
                    $result = $tmp;
                }
            } else {
                $tmp = $this->vyValues->value[$t] - $this->errorValues->value[$t];
                $result = ($t == 0) ? $tmp : min($result, $tmp);
            }
        }

        return $result;
    }
}


    class Drawer {
        public $x;
        public $y;
        public $middleZ;
        public $aWidth;
        public $draw3D;
        public $g;

        public function drawHoriz($xPos) {
            if ($this->draw3D) {
                $this->g->horizontalLine($this->x, $xPos, $this->y, $this->middleZ);
                $this->g->verticalLine($xPos, ($this->y - $this->aWidth / 2), $this->y + ($this->aWidth / 2),
                               $this->middleZ); // 5.01
            } else {
                $this->g->horizontalLine($this->x, $xPos, $this->y);
                $this->g->verticalLine($xPos, ($this->y - $this->aWidth / 2), $this->y + ($this->aWidth / 2)); // 5.01
            }
        }

        public function drawVert($yPos) {
            if ($this->draw3D) {
                $this->g->verticalLine($this->x, $this->y, $yPos, $this->middleZ);
                $this->g->horizontalLine($this->x - ($this->aWidth / 2), $this->x + ($this->aWidth / 2), $yPos,
                                 $this->middleZ);
            } else {
                $this->g->verticalLine($this->x, $this->y, $yPos);
                $this->g->horizontalLine($this->x - ($this->aWidth / 2), $this->x + ($this->aWidth / 2), $yPos);
            }
        }
    }  
?>
