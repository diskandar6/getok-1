<?php
 /**
 * Description:  This file contains the following class:<br>
 * CustomPoint class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */  
/**
 * CustomPoint class
 *
 * Description: Base Series class inherited by a number of TeeChart
  * series styles.
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 
 class CustomPoint extends BaseLine {

    protected $point;
    protected $iStacked = 0; // CustomStack::$NONE;
    private $styleResolver;

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
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->point);
        unset($this->iStacked);
        unset($this->styleResolver);
    }         

    public function assign($source) {
        if ($source instanceof CustomPoint) {
            $tmp = $source;
            if ($tmp->point != null) {
                $this->getPointer()->assign($tmp->point);
            }
            $this->iStacked = $tmp->iStacked;
        }
        parent::assign($source);
    }

    /* TODO
    public function addSeriesMouseListener($l) {
        $this->listenerList->add($this->SeriesMouseListener->class, $l);
    }

    public function removeSeriesMouseListener($l) {
        $this->listenerList->remove($this->SeriesMouseListener->class, $l);
    }
    */
    
    public function setPointerStyleResolver($resolver) {
        $this->styleResolver = $resolver;
    }

    public function removePointerStyleResolver() {
        $this->styleResolver = null;
    }

    private function setOtherStacked() {
        if ($this->chart != null) {
            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                 $s = $this->chart->getSeries($t);
                if ($s instanceof CustomPoint) {
                    $s->iStacked = $this->iStacked;
                }
            }
        }
    }

    /**
      * Defines how multiple series will be displayed.<br><br>
      * Stacking options of Points series are:<br> <br>
      * CustomSeriesStack.None: No overlap action. All Series displayed in
      * individual Z space <br>
      * CustomSeriesStack.Overlap: Series displayed in same Z space (all Series
      * take same ZOrder position). This will result in overpainting of equal
      * Series points. <br>
      * CustomSeriesStack.Stack: Stack Series one above the other. Series begin
      * with lowest index order at bottom, further Series are then plotted above
      * in their respective indexed order with each point taking the cumulative
      * value of lower points as their starting value. <br>
      * CustomSeriesStack.Stack100: Plots take up full Bottom to Top space of
      * the Chart Area resulting in a percentage division by Area to reflect
      * Series values. The Y displacement below each line equates to its
      * percentage value of total. Thus the Last Line will be parallel with/at
      * the top of the Chart and the area below that line reflects its
      * percentage proportion. <br>
      * Default value: CustomStack::$NONE
      *
      * @return CustomStack
      */
    public function getStacked() {
        return $this->iStacked;
    }

    /**
      * Defines how multiple series will be displayed.
      * Default value: CustomStack::$NONE
      *
      * @param value CustomStack
      */
    public function setStacked($value) {
        if ($this->iStacked != $value) {
            $this->iStacked = $value;
            $this->setOtherStacked();
            $this->invalidate();
        }
    }

    /**
      * Defines all necessary properties of the Series Pointer.<br>
      * It is a subclass of Points series, Line series and all other derived
      * Points series classes like Bubble series.<br>
      * Each point in a Points series is drawn using the Pointer properties.<br>
      * Pointer contains several methods to control the formatting attributes of
      * Points like Pen, Brush, Draw3D, Visible, etc. <br>
      * Default value: Null
      *
      * @return SeriesPointer
      */
    public function getPointer() {
        if ($this->point == null) {
            $this->point = new SeriesPointer($this->chart, $this);
        }
        return $this->point;
    }

    //MM Jan04 set { point=value; }
    public function setChart($c) {
        parent::setChart($c);
        if ($this->point != null) {
            $this->point->setChart($this->chart);
        }
    }

    protected function onGetPointerStyle($valueIndex, $style) {
        $s=$style;
        if ($this->styleResolver != null) {
            $s = $this->styleResolver->getStyle($this, $valueIndex, $s);
        }
        return $s;
    }

    private function axisPosition() {
        if ($this->getYMandatory()) {
            return $this->getVertAxis()->iEndPos;
        } else {
            return $this->getHorizAxis()->iEndPos;
        }
    }

    private function calcStackedPos($valueIndex, $value) {
        $value += $this->pointOrigin($valueIndex, false);
        if ($this->iStacked == CustomStack::$STACK) {
            return min($this->axisPosition(), $this->calcPosValue($value));
        } else {
             $tmp = $this->pointOrigin($valueIndex, true);
            return ($tmp != 0) ? $this->calcPosValue($value * 100.0 / $tmp) :
                    $this->axisPosition();
        }
    }

    /**
      * For stacked series, PointOrigin returns the sum of ValueIndex values of
      * all series, until this series in the Chart.Series collection order.<br>
      *
      * @param valueIndex int the point index
      * @param sumAll boolean when true, all series are taken into calculation
      * @return double point origin value
      */
    private function pointOrigin($valueIndex, $sumAll) {
         $result = 0;

        for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
            $s = $this->chart->getSeries($t);
            if ((!$sumAll) && ($s === $this)) {
                break;
            } else
            if ($s->getActive() && ($s instanceof CustomPoint) &&
                ($s->getCount() > $valueIndex)) {
                 $tmp = $s->getOriginValue($valueIndex);
                if ($tmp > 0) {
                    $result += $tmp;
                }
            }
        }
        return $result;
    }

    public function calcHorizMargins($margins) {
        parent::calcHorizMargins($margins);
        $this->getPointer()->calcHorizMargins($margins);
    }

    public function calcVerticalMargins($margins) {
        parent::calcVerticalMargins($margins);
        $this->getPointer()->calcVerticalMargins($margins);
    }

    public function calcZOrder() {
        if ($this->iStacked == CustomStack::$NONE) {
            parent::calcZOrder();
        } else {
            $this->iZOrder = $this->chart->getMaxZOrder();
        }
    }

    /**
      * For internal use
      *
      * @param valueIndex int
      * @param tmpX int
      * @param tmpY int
      * @param x int
      * @param y int
      * @return boolean
      */
    public function clickedPointer($valueIndex, $tmpX, $tmpY, $x, $y) {
        return ($this->point != null) && (abs($tmpX - $x) < $this->point->getHorizSize()) &&
                (abs($tmpY - $y) < $this->point->getVertSize());
    }

    protected function drawLegendShape($g, $valueIndex, $rect) {
        if ($this->getPointer()->getVisible()) {
             $tmpColor = ($valueIndex == -1) ? $this->getColor() :
                             $this->getValueColor($valueIndex);
            $this->point->drawLegendShape($g, $tmpColor, $rect, false);
        } else {
            parent::drawLegendShape($g, $valueIndex, $rect);
        }
    }

    protected function drawMark($valueIndex, $s, $position) {
        $this->getMarks()->setZPosition($this->getStartZ());
        if ($this->getYMandatory()) {
            $position = $this->getMarks()->applyArrowLength($position);
        }

        parent::drawMark($valueIndex, $s, $position);
    }

    /**
      * Draws series pointer to the Canvas.
      * It displays a pointer at the specified px and py screen pixel
      * coordinates with the tmpHoriz and tmpVert size dimensions.
      *
      * @param aX int
      * @param aY int
      * @param aColor Color
      * @param valueIndex int
      */
    public function drawPointer($aX, $aY, $aColor, $valueIndex) {
        $this->point->prepareCanvas($this->chart->getGraphics3D(), $aColor);
        $tmpStyle = $this->onGetPointerStyle($valueIndex, $this->point->getStyle());
        $this->point->draw($aX, $aY, $aColor, $tmpStyle);
    }

    /**
      * Returns vertical screen position for a given point.
      * This coordinate is calculated using the Series associated Vertical Axis.
      *
      * @param valueIndex int
      * @return int
      */
    public function calcYPos($valueIndex) {
        if ((!$this->getYMandatory()) || ($this->iStacked == CustomStack::$NONE) ||
            ($this->iStacked == CustomStack::$OVERLAP)) {
            return parent::calcYPos($valueIndex);
        } else {
            return $this->calcStackedPos($valueIndex, $this->vyValues->value[$valueIndex]);
        }
    }

    /**
      * Returns horizontal screen position for a given point.
      * This coordinate is calculated using the Series associated Horizontal
      * Axis.
      *
      * @param valueIndex int
      * @return int
      */
    public function calcXPos($valueIndex) {
        if (($this->getYMandatory()) || ($this->iStacked == CustomStack::$NONE) ||
            ($this->iStacked == CustomStack::$OVERLAP)) {
            return parent::calcXPos($valueIndex);
        } else {
            return $this->calcStackedPos($valueIndex, $this->vxValues->value[$valueIndex]);
        }
    }

    protected function getOriginPos($valueIndex) {
        if (($this->iStacked == CustomStack::$NONE) ||
            ($this->iStacked == CustomStack::$OVERLAP)) {
            if ($this->yMandatory) {
                return $this->getVertAxis()->getInverted() ? $this->getVertAxis()->iStartPos :
                        $this->getVertAxis()->iEndPos;
            } else {
                return $this->getHorizAxis()->getInverted() ? $this->getHorizAxis()->iEndPos :
                        $this->getHorizAxis()->iStartPos;
            }
        } else {
            return $this->calcStackedPos($valueIndex, 0);
        }
    }

    /**
      * Called internally. Draws the "ValueIndex" point of the Series.
      *
      * @param valueIndex int
      */
    public function drawValue($valueIndex) {
        $this->drawPointer($this->calcXPos($valueIndex), $this->calcYPos($valueIndex),
                    $this->getValueColor($valueIndex), $valueIndex);
    }

    /**
      * Returns the ValueIndex of the "clicked" point in the Series.
      *
      * @param x int
      * @param y int
      * @return int
      */
    /* TODO
    public function clicked($x, $y) {
        if ($this->chart != null) {
             $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y, $this->getStartZ());
            $x = $p->x;
            $y = $p->y;
        }

         $result = parent::clicked($x, $y);

        if (($result == -1) && ($this->firstVisible > -1) && ($this->lastVisible > -1)) {
            for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {
                if ($this->clickedPointer($t, $this->calcXPos($t), $this->calcYPos($t), $x, $y)) {
                    $this->doClickPointer($t, $x, $y);
                    return $t;
                }
            }
        }

        return $result;
    }
    */

    /**
      * Returns the Maximum Value of the Series X Values List.
      *
      * @return double
      */
    public function getMaxXValue() {
         $result = 0;
        if ($this->yMandatory) {
            $result = parent::getMaxXValue();
        } else {
            if ($this->iStacked == CustomStack::$STACK100) {
                $result = 100;
            } else {
                $result = parent::getMaxXValue();
                if ($this->iStacked == CustomStack::$STACK) {
                    for ( $t = 0; $t < $this->getCount(); $t++) {
                        $result = max($result,
                                          $this->pointOrigin($t, false) +
                                          $this->getXValues()->value[$t]);
                    }
                }
            }
        }
        return $result;
    }

    /**
      * Returns the Minimum Value of the Series X Values List.
      *
      * @return double
      */
    public function getMinXValue() {
        if ((!$this->getYMandatory()) && ($this->iStacked == CustomStack::$STACK100)) {
            return 0;
        } else {
            return parent::getMinXValue();
        }
    }

    /**
      * Returns the Maximum Value of the Series Y Values List.
      *
      * @return double
      */
    public function getMaxYValue() {
        if ($this->getYMandatory()) {
            $tmpCustomStack = new CustomStack();
            if ($this->iStacked == CustomStack::$STACK100) {
                return 100;
            } else {
                 $result = parent::getMaxYValue();
                if ($this->iStacked == CustomStack::$STACK) {
                    for ( $t = 0; $t < $this->getCount(); $t++) {
                        $result = max($result,
                                          $this->pointOrigin($t, false) +
                                          $this->vyValues->value[$t]);
                    }
                }
                return $result;
            }
        } else {
            return parent::getMaxYValue();
        }
    }

    /**
      * Returns the Minimum Value of the Series Y Values List.
      *
      * @return double
      */
    public function getMinYValue() {
        return ($this->getYMandatory() && ($this->iStacked == CustomStack::$STACK100)) ? 0 :
                parent::getMinYValue();
    }
}
?>