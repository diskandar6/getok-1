<?php
 /**
 * Description:  This file contains the following class:<br>
 * Highlow class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: Highlow class</p>
 *
 * <p>Description: HighLow Series.</p>
 * 
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class HighLow extends Series {

    private $pen;
    private $highPen;
    private $low;
    private $lowPen;
    private $OldX;
    private $OldY0;
    private $OldY1;
    private $highBrush;
    private $lowBrush;

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
    
    public function __construct($c) {
        parent::__construct($c);
        $this->calcVisiblePoints = false;
        $this->getPen()->setColor(Color::EMPTYCOLOR());
        $this->low = new ValueList($this, Language::getString("ValuesLow"));
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->pen);
        unset($this->highPen);
        unset($this->low);
        unset($this->lowPen);
        unset($this->OldX);
        unset($this->OldY0);
        unset($this->OldY1);
        unset($this->highBrush);
        unset($this->lowBrush);
    }           

    public function setChart($c) {
        parent::setChart($c);

        if ($this->pen != null) {
            $this->pen->setChart($c);
        }
        if ($this->highPen != null) {
            $this->highPen->setChart($c);
        }
        if ($this->lowPen != null) {
            $this->lowPen->setChart($c);
        }
        if ($this->highBrush != null) {
            $this->highBrush->setChart($c);
        }
        if ($this->lowBrush != null) {
            $this->lowBrush->setChart($c);
        }
    }

    /**
     * Sets the Pen to draw the vertical dividing lines of the HighLow series.
     *
     * @return ChartPen
     */
    public function getPen() {
        if ($this->pen == null) {
            $this->pen = new ChartPen($this->chart);
        }
        return $this->pen;
    }

    /**
     * Defines the Pen for the High value.
     *
     * @return ChartPen
     */
    public function getHighPen() {
        if ($this->highPen == null) {
            $this->highPen = new ChartPen($this->chart, Color::BLACK());
        }
        return $this->highPen;
    }

    /**
     * Defines the Pen for the Low value.

     * @return ChartPen
     */
    public function getLowPen() {
        if ($this->lowPen == null) {
            $this->lowPen = new ChartPen($this->chart, Color::BLACK());
        }
        return $this->lowPen;
    }

    /**
     * Defines the Brush for the Low value.
     *
     * @return ChartBrush
     */
    public function getLowBrush() {
        if ($this->lowBrush == null) {
            $this->lowBrush = new ChartBrush($this->chart, Color::EMPTYCOLOR(), false);
        }
        return $this->lowBrush;
    }

    /**
     * Defines the Brush for the High value.
     *
     * @return ChartBrush
     */
    public function getHighBrush() {
        if ($this->highBrush == null) {
            $this->highBrush = new ChartBrush($this->chart, Color::EMPTYCOLOR(), false);
        }
        return $this->highBrush;
    }

    public function getHighValues() {
        return $this->vyValues;
    }

    public function getLowValues() {
        return $this->low;
    }

    protected function addSampleValues($numValues) {
        $r = $this->randomBounds($numValues);
        $tmp = $r->DifY * $r->Random();

        for ($t = 1; $t <= $numValues; $t++) {
            $tmp += $r->Random() * (MathUtils::round($r->DifY / 5.0)) -
                    ($r->DifY / 10.0);
            $this->AddXHL($r->tmpX, $tmp, $tmp - $r->Random() * (MathUtils::round($r->DifY / 5.0)));
            $r->tmpX += $r->StepX;
        }
    }

    /**
     * Adds a new High and Low value to a HighLow series.
     *
     * @param x double
     * @param h double
     * @param l double
     * @return int
     */
    public function AddXHL($x, $h, $l) {
        return $this->AddXHLTextColor($x, $h, $l, "", Color::EMPTYCOLOR());
    }

    /**
     * Adds a new High and Low value to a HighLow series.
     *
     * @param x double
     * @param h double
     * @param l double
     * @param color Color
     * @return int
     */
    public function AddXHLColor($x, $h, $l, $color) {
        return AddXHLTextColor($x, $h, $l, "", $color);
    }

    /**
     * Adds a new High and Low value to a HighLow series and label.
     *
     * @param x double
     * @param h double
     * @param l double
     * @param text String
     * @return int
     */
    public function AddXHLText($x, $h, $l, $text) {
        return $this->AddXHLTextColor($x, $h, $l, $text, Color::EMPTYCOLOR());
    }

    /**
     * Adds a new High and Low value to a HighLow series with label and color.
     *
     * @param x double
     * @param h double
     * @param l double
     * @param text String
     * @param color Color
     * @return int
     */
    public function AddXHLTextColor($x, $h, $l, $text, $color) {
        $this->low->tempValue = $l;
        return $this->addXYTextColor($x, $h, $text, $color);
    }

    private function DrawLine($APen, $BeginY, $EndY, $x) {
        $g = $this->chart->getGraphics3D();

        if ($APen->getVisible()) {
            $g->setPen($APen);
            if ($this->chart->getAspect()->getView3D()) {
                $g->moveToXYZ($OldX, $BeginY, $this->getMiddleZ());
                $g->___lineTo($x, $EndY, $this->getMiddleZ());
            } else {
                $g->moveToXY($this->OldX, $BeginY);
                $g->___lineTo($x, $EndY);
            }
        }
    }

    /**
     * Called internally. Draws the "ValueIndex" point of the Series.
     *
     * @param valueIndex int
     */
    public function drawValue($valueIndex) {
        $g = $this->chart->getGraphics3D();

        $x = $this->calcXPos($valueIndex);
        $y0 = $this->calcYPos($valueIndex);
        $y1 = $this->calcYPosValue($this->low->getValue($valueIndex));
        $tmpColor = $this->getValueColor($valueIndex);

        if ($valueIndex != $this->getFirstVisible()) {
            $b = ($this->low->getValue($valueIndex) <
                            $this->getHighValues()->getValue($valueIndex)) ?
                           $this->highBrush :
                           $this->lowBrush;

            if (($b != null) && ($b->getVisible())) {
                $g->getPen()->setVisible(false);

                $tmpX = $this->OldX;
                if ($this->getPen()->getVisible()) {
                    $tmpX += $this->getPen()->getWidth();
                }

                $g.setBrush($b);

                if ($g->getBrush()->getColor()->isEmpty()) {
                    $g->getBrush()->setColor($tmpColor);
                }

                $g->plane(new TeePoint($tmpX, $this->OldY0), new TeePoint($tmpX, $this->OldY1),
                        new TeePoint($x, $y1), new TeePoint($x, $y0), $this->getMiddleZ());
            }

            $this->DrawLine($this->getHighPen(), $this->OldY0, $y0, $x);
            $this->DrawLine($this->getLowPen(), $this->OldY1, $y1, $x);
        }

        if ($this->getPen()->getVisible()) {
            $tmp = $this->pen->getColor();
            if ($tmp->isEmpty()) {
                $tmp = $tmpColor;
            }

            $g->setPen($this->pen);
            $g->getPen()->setColor($tmp);

            if ($this->chart->getAspect()->getView3D()) {
                $g->verticalLine($x, $y0, $y1, $this->getMiddleZ());
            } else {
                $g->verticalLine($x, $y0, $y1);
            }
        }

        $this->OldX = $x;
        $this->OldY0 = $y0;
        $this->OldY1 = $y1;
    }

    /**
     * True if Series source is HighLow.<br>
     * Returns false if the Value parameter is the same as Self. <br>
     * It's used to validate the DataSource method both at design and run-time.
     *
     * @param value ISeries
     * @return boolean
     */
    public function isValidSourceOf($value) {
        return $value instanceof HighLow;
    }

    /**
     * The Maximum Value of the Series Y Values List.
     *
     * @return double
     */
    public function getMaxYValue() {
        return max(parent::getMaxYValue(), $this->low->getMaximum());
    }

    /**
     * The Minimum Value of the Series Y Values List.
     *
     * @return double
     */
    public function getMinYValue() {
        return min(parent::getMinYValue(), $this->low->getMinimum());
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return Language::getString("GalleryHighLow");
    }
}
?>