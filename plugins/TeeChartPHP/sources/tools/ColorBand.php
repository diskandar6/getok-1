<?php
 /**
 * Description:  This file contains the following class:<br>
 * ColorBand class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * ColorBand class
 *
 * Description: Color band tool, use it to display a coloured rectangle
 * (band) at the specified axis and position
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

 class ColorBand extends ToolAxis {

    private $drawBehind = true;
    private $end;
    private $start;

    private $boundsRect;
    private $fLineEnd;
    private $fLineStart;


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

        $this->fLineEnd = $this->newColorLine();
        $this->fLineStart = $this->newColorLine();
        $this->setLines();
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->drawBehind);
        unset($this->end);
        unset($this->start);
        unset($this->boundsRect);
        unset($this->fLineEnd);
        unset($this->fLineStart);
    }         

    private function newColorLine() {
        $result = new ColorLine();
        $result->setActive(false);
        $result->setDragRepaint(true);
        $result->setDraw3D(false);
        $result->setDrawBehind(true);

        return $result;
    }

    private function setLines() {
        $this->fLineEnd->setValue($this->getEnd());
        $this->fLineStart->setValue($this->getStart());
        $this->invalidate();
    }

    public function mouseEvent($e, $c) {
        if($this->fLineEnd->getActive()) {
            $c = $this->fLineEnd->mouseEvent($e, $c);
        }
        if($this->fLineStart->getActive()) {
            $c = $this->fLineStart->mouseEvent($e, $c);
        }

        return $c;
    }

     public function setAxis($value) {
         parent::setAxis($value);
         $this->fLineEnd->setAxis($value);
         $this->fLineStart->setAxis($value);

     }


        /**
          * Gets descriptive text.
          *
          * @return String
          */
    public function getDescription() {
        return Language::getString("ColorBandTool");
    }

        /**
          * Gets detailed descriptive text.
          *
          * @return String
          */
    public function getSummary() {
        return Language::getString("ColorBandSummary");
    }

        /**
          * Draws the Colorband behind the series values when true.<br>
          * Default value: true
          *
          * @return boolean
          */
    public function getDrawBehind() {
        return $this->drawBehind;
    }

        /**
          * Draws the Colorband behind the series values when true.<br>
          * Default value: true
          *
          * @param value boolean
          */
    public function setDrawBehind($value) {
        $this->drawBehind = $this->setBooleanProperty($this->drawBehind, $value);
        $this->fLineEnd->setDrawBehind($value);
        $this->fLineStart->setDrawBehind($value);
    }

        /**
          * The Start Axis value of colorband.
          *
          * @return double
          */
    public function getStart() {
        return $this->start;
    }

        /**
          * Sets Start Axis value of colorband.
          *
          * @param value double
          */
    public function setStart($value) {
        $this->start = $this->setDoubleProperty($this->start, $value);
        $this->setLines();
    }

        /**
          * The End Axis value of colorband.
          *
          * @return double
          */
    public function getEnd() {
        return $this->end;
    }

        /**
          * Sets End Axis value of colorband.
          *
          * @param value double
          */
    public function setEnd($value) {
        $this->end = $this->setDoubleProperty($this->end, $value);
        $this->setLines();
    }

        /**
          * The Transparency of ColorBand as percentage.<br>
          * Default value: 0
          *
          * @return int
          */
    public function getTransparency() {
        return $this->getBrush()->getTransparency();
    }

        /**
          * Sets the Transparency of ColorBand as percentage.<br>
          * Default value: 0
          *
          * @param value int
          */
    public function setTransparency($value) {
        $this->getBrush()->setTransparency($value);
    }

        /**
          * Sets Band colour gradient.
          *
          * @return Gradient
          */
    public function getGradient() {
        return $this->bBrush->getGradient();
    }

        /**
          * SThe Band Color.
          *
          * @return Color
          */
    public function getColor() {
        return $this->bBrush->getColor();
    }

        /**
          * Sets Band Color.
          *
          * @param value Color
          */
    public function setColor($value) {
        $this->bBrush->setColor($value);
    }

        /**
          * Element Brush characteristics.
          *
          * @return ChartBrush
          */
    public function getBrush() {
        if ($this->bBrush == null) {
            $this->bBrush = new ChartBrush($this->chart);
        }
        return $this->bBrush;
    }

        /**
          * Contains formatting properties for the automatic line used to drag the start value of the ColorBand tool at runtime.
          *
          * @return ColorLine
          */
    public function getStartLine() {
            return $this->fLineStart;
    }

        /**
          * Contains formatting properties for the automatic line used to drag the end value of the ColorBand tool at runtime.
          *
          * @return ColorLine
          */
    public function getEndLine() {
            return $this->fLineEnd;
    }

        /**
        * Gets or sets if the ColorBand tool allows mouse dragging of the edge corresponding to the end value.
        *
      * @return boolean
      * */
    public function getResizeEnd() {
            return $this->getEndLine()->getActive();
    }

    public function setResizeEnd($value)
        {
                getEndLine().setChart(chart);
                getEndLine().setActive(value);
                this.invalidate();
        }

        /*
        * Gets or sets if the ColorBand tool allows mouse dragging of the edge corresponding to the start value.
        *
        * @return boolean
        */
    public function getResizeStart() {
        return $this->getStartLine()->getActive();
    }

    public function setResizeStart($value)
        {
                getStartLine().setChart(chart);
                getStartLine().setActive(value);
                this.invalidate();
        }

        /*
        * Pen used to draw the starting line of the color band tool.
        *
        * @return ChartPen
        */
    public function getStartLinePen() {
            return $this->getStartLine()->getPen();
    }

        /*
        * Pen used to draw the ending line of the color band tool.
        *
        * @return ChartPen
        */
    public function getEndLinePen() {
            return $this->getEndLine()->getPen();
    }

    private function paintBand() {
        if ($this->iAxis != null) {
            $tmpRect = $this->chart->getChartRect();
            $r = new Rectangle($tmpRect->getX(),$tmpRect->getY(),$tmpRect->getWidth(),$tmpRect->getHeight());
            $tmp0 = $this->start;
            $tmp1 = $this->end;

            if ($this->iAxis->getInverted()) {
                if ($tmp0 < $tmp1) {
                    $tmp = $tmp0;
                    $tmp0 = $tmp1;
                    $tmp1 = $tmp;
                }
                $tmpDraw = ($tmp1 <= $this->iAxis->getMaximum()) && ($tmp0 >= $this->iAxis->getMinimum());
            } else {
                if ($tmp0 > $tmp1) {
                    $tmp = $tmp0;
                    $tmp0 = $tmp1;
                    $tmp1 = $tmp;
                }
                $tmpDraw = ($tmp0 <= $this->iAxis->getMaximum()) && ($tmp1 >= $this->iAxis->getMinimum());
            }

            if ($tmpDraw) {
                if ($this->iAxis->getHorizontal()) {
                    $r->x = max($this->iAxis->iStartPos, $this->iAxis->calcPosValue($tmp0));
                    $r->width = min($this->iAxis->iEndPos, $this->iAxis->calcPosValue($tmp1)) -
                              $r->x;
                    if (!$this->getPen()->getVisible()) {
                        $r->width++;
                    }
                } else {
                    $r->y = max($this->iAxis->iStartPos, $this->iAxis->calcPosValue($tmp1));
                    $r->height = min($this->iAxis->iEndPos, $this->iAxis->calcPosValue($tmp0)) -
                               $r->y;
                    $r->x++;
                    if (!$this->getPen()->getVisible()) {
                        $r->height++;
                        $r->width++;
                    }
                }

                $g = $this->chart->getGraphics3D();
                $g->setBrush($this->getBrush());
                $g->setPen($this->getPen());

                if ( $this->getGradient()->getVisible() && $this->chart->getAspect()->getOrthogonal() ) {
                  $this->tmpR=$r;
                  $this->tmpR->width--;
                  $this->tmpR->height--;
                  $this->getGradient()->draw($g,$g->calcRect3D($this->tmpR,$this->chart->getAspect()->getWidth3D()));
                  $this->getBrush()->setVisible(false);
                }


                if (($this->chart->getAspect()->getView3D()) && ($this->drawBehind)) {
                    $g->rectangle($r, $this->chart->getAspect()->getWidth3D());
                } else {
                    $g->rectangle($r);
                }
            }
        }
    }

    public function chartEvent($e) {
        parent::chartEvent($e);
        if (((/*($e->getID()==$tmpChartDrawEvent->PAINTING) &&*/
              ($e->getDrawPart()==ChartDrawEvent::$SERIES)) && $this->drawBehind) ||
            ((/* TODO ($e->getID()==ChartDrawEvent::$PAINTED) &&*/
              ($e->getDrawPart()==ChartDrawEvent::$CHART)) && (!$this->drawBehind))) {
            $this->paintBand();
        }
    }
}

?>