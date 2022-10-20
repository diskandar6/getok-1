<?php
/**
 * Description:  This file contains the following classes:<br>
 * AxisDraw class<br>
 * TicksGridDraw class<br>
 * IntRange class<br>
 * GetAxisSeriesLabelResults class
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
/**
 * AxisDraw class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 class AxisDraw {

    private static $DIFFLOAT = 0.0000001;
    private static $MAXAXISTICKS = 2000;
    private $chart;
    private $tmpNumTicks;
    private $drawTicksAndGrid;
    private $tmpLabelStyle;
    private $iIncrement;
    private $tmpWhichDatetime; // DateTimeStep

    protected $axis;
    protected $tmpValue=0;

    public $tmpAlternate;
    public $ticks;

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
    public function __construct($a=null) {

        if ($a != null) {
            $this->axis = $a;
            $this->setChart($this->axis->getChart());
        }

        $this->drawTicksAndGrid = new TicksGridDraw($this->axis);
    }
    
    public function __destruct()    
    {        
        unset($this->chart);
        unset($this->tmpNumTicks);
        unset($this->drawTicksAndGrid);
        unset($this->tmpLabelStyle);
        unset($this->iIncrement);
        unset($this->tmpWhichDatetime);

        unset($this->axis);
        unset($this->tmpValue);

        unset($this->tmpAlternate);
        unset($this->ticks);
    }

    public function getNumTicks() {
        return $this->tmpNumTicks;
    }

    private function getDepthAxisPos() {
         $result;
        if($this->axis->getOtherSide())
            $result = $this->chart->getChartRect()->getBottom() - $this->axis->calcZPos();
        else
            $result = $this->chart->getChartRect()->getTop() + $this->axis->calcZPos();

        return $result;
    }

    private function drawAxisTitle() {
        if (($this->axis->getTitle() != null) && $this->axis->getTitle()->getVisible() &&
            (strlen($this->axis->getTitle()->getCaption()) != 0)) {
            $tmp=$this->axis->getChart()->getChartRect();
            if ($this->axis->isDepthAxis) {
                $this->axis->drawTitle($this->axis->posTitle,$tmp->getBottom());
            } else
            if ($this->axis->getHorizontal()) {
                $this->axis->drawTitle($this->axis->iCenterPos, $this->axis->posTitle);
            } else {
                $this->axis->drawTitle($this->axis->posTitle, $this->axis->iCenterPos);
            }
        }
    }

    private function addTick($aPos) {
        $this->ticks[$this->tmpNumTicks] = $aPos;
        $this->tmpNumTicks++;
    }

    private function internalDrawLabel($decValue) {
        $tmp = $this->axis->calcPosValue($this->tmpValue);
        $axislabels=$this->axis->getLabels();
        if ($axislabels->getOnAxis() ||
            (($tmp > $this->axis->iStartPos) && ($tmp < $this->axis->iEndPos))) {
            if (!$this->axis->getTickOnLabelsOnly()) {
                $this->addTick($tmp);
            }
            if ($axislabels->getVisible()) {
                $this->drawThisLabel($tmp,$axislabels->labelValue($this->tmpValue), null);
            }
        }
        if ($decValue) {
            $this->tmpValue = $this->axis->incDecDateTime(false, $this->tmpValue, $this->iIncrement,
                           $this->tmpWhichDatetime);
        }
    }

    private function drawThisLabel($labelPos, $tmpSt, $labelItem) {

        $old_name = TChart::$controlName;        
        TChart::$controlName .= 'Axis_Label_';        
        
        if ($this->axis->getTickOnLabelsOnly()) {
            $this->addTick($labelPos);
        }

        $c = $this->axis->chart;
        $g = $c->getGraphics3D();
        $axisLabels = $this->axis->getLabels();
        $g->setFont(($labelItem == null) ? $axisLabels->getFont() :
                     $labelItem->getFont());

        $g->getBrush()->setVisible(false);

        if ($this->axis->isDepthAxis) {
            $g->setTextAlign($this->axis->getDepthAxisAlign());

            $tmpZ = $labelPos;

            $aspect=$c->getAspect();
            if (($aspect->getRotation() == 360) ||
                $aspect->getOrthogonal()) {
                $tmpZ += ($g->getFontHeight() / 2);
            }

            if ($this->axis->getOtherSide()) {
                $tmpPos = $axisLabels->position;
            } else {
                $tmpPos = $axisLabels->position-2-($this->chart->getGraphics3D()->textWidth("W") / 2);
            }

            $g->textOut($tmpPos,$this->getDepthAxisPos(),
                      $tmpZ, $tmpSt);
        } else {
            if ($axisLabels->getAlternate()) {
                if ($this->tmpAlternate) {
                    $tmpPos = $axisLabels->position;
                } else {
                    if ($this->axis->getHorizontal()) {
                        if ($this->axis->getOtherSide()) {
                            $tmpPos = $axisLabels->position -
                                     $g->getFontHeight();
                        } else {
                            $tmpPos = $axisLabels->position +
                                     $g->getFontHeight();
                        }
                    } else {
                        if ($this->axis->getOtherSide()) {
                            $tmpPos = $axisLabels->position +
                                     $this->axis->maxLabelsWidth();
                        } else {
                            $tmpPos = $axisLabels->position -
                                     $this->axis->maxLabelsWidth();
                        }
                    }
                }
                $this->tmpAlternate = !$this->tmpAlternate;
            } else {
                $tmpPos = $axisLabels->position;
            }

            if ($this->axis->getHorizontal()) {
                $this->axis->_drawAxisLabel($labelPos,
                                   $tmpPos,
                                   $axisLabels->getAngle(), $tmpSt, $labelItem);
            } else {
               $this->axis->_drawAxisLabel($tmpPos,
                                   $labelPos, $axisLabels->getAngle(), $tmpSt,
                                   $labelItem);
            }
        }
        
        TChart::$controlName=$old_name;   
    }

    private function intPower($numBase, $exponent) {
        return pow($numBase, $exponent);
    }

    private function logBaseN($numBase, $x) {
        return log($x, $numBase);
    }

    private function roundDate($aDate, $aStep) {
        $tmpDateTime = new DateTime();
        if ($aDate->toDouble() <= $tmpDateTime->MINVALUE) {
            return $aDate;
        } else {
             $year = $aDate->getYear();
             $month = $aDate->getMonth();
             $day = $aDate->getDay();

            switch ($aStep) {
            case DateTimeStep::$HALFMONTH:
                if ($day >= 15) {
                    $day = 15;
                } else {
                    $day = 1;
                }
                break;
            case DateTimeStep::$ONEMONTH:
            case DateTimeStep::$TWOMONTHS:
            case DateTimeStep::$THREEMONTHS:
            case DateTimeStep::$FOURMONTHS:
            case DateTimeStep::$SIXMONTHS:
                $day = 1;
                break;
            case DateTimeStep::$ONEYEAR:
                $day = 1;
                $month = 1;
                break;
            default:
                break;
            }
            return new $tmpDateTime($year, $month, $day);
        }
    }

    private function doDefaultLabels() {
        $tmp = 0;

        $this->tmpValue = MathUtils::round($this->axis->iMaximum / $this->iIncrement);
        if (abs($this->axis->iRange / $this->iIncrement) < 10000) {
            /* if less than 10000 labels... */
            /* calculate the maximum value... */

            if ($this->axis->iAxisDateTime &&
                $this->axis->getLabels()->getExactDateTime() &&
                ($this->tmpWhichDatetime != DateTimeStep::$NONE) &&
                ($this->tmpWhichDatetime > DateTimeStep::$ONEDAY)) {
                $this->tmpValue = $this->roundDate(new DateTime($this->axis->iMaximum),
                                     $this->tmpWhichDatetime)->toDouble();
            } else
            if (((string)$this->axis->iMinimum==(string)$this->axis->iMaximum)
                || (!$this->axis->getLabels()->getRoundFirstLabel())) {
                $this->tmpValue = $this->axis->iMaximum;
            } else {
                $this->tmpValue = $this->iIncrement * $this->tmpValue;
            }

            /* adjust the maximum value to be inside "IMinimum" and "IMaximum" */
            while ($this->tmpValue > $this->axis->iMaximum) {
                $this->tmpValue = $this->axis->incDecDateTime(false, $this->tmpValue,
                                               $this->iIncrement, $this->tmpWhichDatetime);
            }

            /* Draw the labels... */
            if ($this->axis->iRangezero) {
                $this->internalDrawLabel(false);
            }
            /* Maximum is equal to Minimum. Draw one label */
            else {
                /* do the loop and draw labels... */
                //if ((Math.abs(axis.iMaximum-axis.iMinimum)<1e-10) || (tmpValue.ToString()==(tmpValue-iIncrement).ToString()))
                if ((abs($this->axis->iMaximum - $this->axis->iMinimum) <
                     $this->axis->iMinAxisIncrement) ||
                    ((string)$this->tmpValue==(string)($this->tmpValue - $this->iIncrement))) {
                    /* fix zooming when axis Max=Min */
                    $this->internalDrawLabel(false);
                } else {
                    /* draw labels until "tmpVale" is less than minimum */
                    $tmp = ($this->axis->iMinimum -
                           $this->axis->iMinAxisIncrement) /
                          (1.0 + $this->axis->iMinAxisIncrement);

                    while ($this->tmpValue >= $tmp) {
                        $this->internalDrawLabel(true);
                    }
                }
            }
        }
    }

    private function doDefaultLogLabels() {

        if ($this->axis->iMinimum != $this->axis->iMaximum) {
            if ($this->axis->iMinimum <= 0) {
                if ($this->axis->iMinimum == 0) {
                    $this->axis->iMinimum = 0.1;
                } else {
                    $this->axis->iMinimum = Axis::$MINAXISRANGE;
                }
                $this->tmpValue = $this->axis->iMinimum;
            } else {
                $this->tmpValue = $this->intPower($this->axis->getLogarithmicBase(),
                                    MathUtils::round($this->logBaseN($this->axis->
                        $this->getLogarithmicBase(),
                        $this->axis->iMinimum)));
            }

            // speed optimization
            $showMinorGrid = ($this->axis->minorGrid != null) &&
                                    ($this->axis->minorGrid->getVisible());

            if ($showMinorGrid) {

                $tmpValue2 = $this->tmpValue;

                if ($tmpValue2 >= $this->axis->iMinimum) {
                    $tmpValue2 = $this->intPower($this->axis->getLogarithmicBase(),
                                         MathUtils::round($this->logBaseN($this->axis->
                            $this->getLogarithmicBase(),
                            $this->axis->iMinimum)) - 1);
                }

                if ($tmpValue2 < $this->axis->iMinimum) {
                    $this->addTick($this->axis->calcPosValue($tmpValue2));
                }
            }

            if ($this->axis->getLogarithmicBase() > 1) {
                while ($this->tmpValue <= $this->axis->iMaximum) {
                    if ($this->tmpValue >= $this->axis->iMinimum) {
                        $this->internalDrawLabel(false);
                    }
                    $this->tmpValue *= $this->axis->getLogarithmicBase();
                }
            }

            // For minor grids only...
            if ($showMinorGrid && ($this->tmpValue > $this->axis->iMaximum)) {
                $this->addTick($this->axis->calcPosValue($this->tmpValue));
            }
        }
    }

    private function doNotCustomLabels() {
        if ($this->axis->getLogarithmic() && ($this->axis->getIncrement() == 0)) {
            $this->doDefaultLogLabels();
        } else {
            $this->doDefaultLabels();
        }
    }

    private function doCustomLabels() {
        $labelInside = false;

        $this->tmpValue = $this->axis->iMinimum;

        $labelIndex = 0;
        $r = new NextAxisLabelValue();
        $r->setStop(true);

        // maximum 2000 labels...
        do {
            if ($this->axis->chart->getParent() != null) {
                /* Add this check ?? TODO 
                   $this->labelText = $tmpResult;  
                   // Args  : Axis, valueindex display order, label
                     $parent->TriggerEvent('OnGetAxisLabel', array($this->axis,$this->axis->labelIndex, $this->labelText));
            
                   if ($this->labelText != $tmpResult)
                      $tmpResult = $this->labelText;                
                */
            }

            if ($r->getStop()) {
                if ($labelIndex == 0) {
                    $this->doNotCustomLabels();
                }
                return;
            } else {
                $labelInside = (($this->tmpValue >=
                                ($this->axis->iMinimum - self::$DIFFLOAT)) &&
                               ($this->tmpValue <=
                                ($this->axis->iMaximum + self::$DIFFLOAT)));
                if ($labelInside) {
                    $this->internalDrawLabel(false);
                }
                $labelIndex++;
            }
        } while ($labelInside || ($labelIndex < 2000) || (!$r->getStop()));
    }


    private function calcFirstLastAllSeries($rect) {
        $tmp = new IntRange(intval('1000000000000'), -1);  // MAX_VALUE

        for ( $t = 0; $t < sizeof($this->axis->iSeriesList); $t++) {
            $s = $this->axis->iSeriesList->getSeries($t);
            if (isset($s))
            {
              $s->calcFirstLastVisibleIndex();

              if (($s->getFirstVisible() < $tmp->first) &&
                  ($s->getFirstVisible() != -1)) {
                  $tmp->first = $s->getFirstVisible();
              }

              if ($s->getLastVisible() > $tmp->last) {
                  $tmp->last = $s->getLastVisible();
              }
            }
        }

        return $tmp;
    }

    private function calcAllSeries() {
        if ($this->axis->iSeriesList == null) {
            $this->axis->iSeriesList = new SeriesCollection($this->chart);
        }
        else
        {
          $this->axis->iSeriesList->clear();
        }

        for ( $t = 0; $t < $this->axis->chart->getSeriesCount(); $t++) {
            $s = $this->axis->chart->getSeries($t);
            if ($s->getActive() && $s->associatedToAxis($this->axis)) {
                $this->axis->iSeriesList->internalAdd($s);
            }
        }
    }

    private function getAxisSeriesLabel($aIndex) {
        $result = new GetAxisSeriesLabelResults();
        $result->result = false;

        for ( $t = 0; $t < sizeof($this->axis->iSeriesList); $t++) {

            $tmpSeries = $this->axis->iSeriesList->getSeries($t);

            if (($aIndex >= $tmpSeries->getFirstVisible()) &&
                ($this->aIndex <= $tmpSeries->getLastVisible())) {

                // even if the series has no text labels
                if ($this->tmpLabelStyle == AxisLabelStyle::$MARK) {
                    $result->label = $tmpSeries->getValueMarkText($aIndex);
                } else
                if ($this->tmpLabelStyle == AxisLabelStyle::$TEXT) {
                    $labels = $tmpSeries->getLabels();
                    $result->label = $labels[$aIndex];
                }

                /* TODO remove
                if ($this->axis->chart->getParent() != null) {
                    $result->label = $this->axis->chart->getParent()->getAxisLabelResolver()->
                                   $this->getLabel(
                                           $this->axis,
                                           $tmpSeries,
                                           $aIndex,
                                           $result->label);
                }
                */

                if (strlen($result->label) != 0) {
                    $result->result = true;

                    if ($this->axis->getHorizontal()) {
                        $result->value = $tmpSeries->getXValues()->value[$aIndex];
                    } else {
                        $result->value = $tmpSeries->getYValues()->value[$aIndex];
                    }
                }
            }
        }

        return $result;
    }

    private function depthAxisLabels() {

        if ($this->axis->chart->countActiveSeries() > 0) {
            $axisLabels = $this->axis->getLabels();
            for ( $t = (int) $this->axis->iMinimum; $t <= $this->axis->iMaximum; $t++) {

                $tmp = $this->axis->calcYPosValue($this->axis->iMaximum - $t - 0.5);

                if (!$this->axis->getTickOnLabelsOnly()) {
                    $this->addTick($tmp);
                }
                if ($axisLabels->getVisible()) {
                    $tmpSt = $this->axis->chart->getSeriesTitleLegend($t, true);

                    if ($this->axis->chart->getParent() != null) {
                        // Args  : Axis, valueindex display order, label
                        $this->labelText = $tmpSt;  
                        $this->axis->chart->getParent()->TriggerEvent('OnGetAxisLabel', 
                                    array($this->axis, $t, $this->labelText));
            
                        if ($this->labelText != $tmpSt)
                            $tmpSt = $this->labelText;                        
                    }

                    $this->drawThisLabel($tmp, $tmpSt, null);
                }
            }
        }
    }

    private function axisLabelsSeries($rect) {
        /* Select all active Series that have "Labels" */
        $tmpNum = 0;
        $tmpSt = "";
        $tmpValue = 0;

        $this->calcAllSeries();
        $tmpRange = $this->calcFirstLastAllSeries($rect);

        if ($tmpRange->first != intval('1000000000000')) {  // MAX_VALUE
             $oldPosLabel = -1;
             $oldSizeLabel = 0;
             $tmpLabelW = $this->axis->getHorizontal();
            switch ($this->axis->getLabels()->iAngle) {
            case 90:
            case 270:
                $tmpLabelW = !$tmpLabelW;
                break;
            default:
                break;
            }

            $axisLabels = $this->axis->getLabels();
            for ( $t = $tmpRange->first; $t <= $tmpRange->last; $t++) {
                $r = $this->getAxisSeriesLabel($t);
                if ($r->result) {
                    $tmpValue = $r->value;
                    $tmpSt = $r->label;

                    if (($tmpValue >= $this->axis->iMinimum) &&
                        ($this->tmpValue <= $this->axis->iMaximum)) {
                        $tmp = $this->axis->calcPosValue($tmpValue);
                        if (!$this->axis->getTickOnLabelsOnly()) {
                            $this->addTick($tmp);
                        }

                        if ($axisLabels->getVisible() &&
                            (strlen($tmpSt) != 0)) {

                            $tmpMulti = $this->axis->chart->multiLineTextWidth($tmpSt);

                            $tmpLabelSize = $tmpMulti->width;
                            $tmpNum = $tmpMulti->count;                            
                            if (!$tmpLabelW) {
                                $tmpLabelSize = $this->chart->getGraphics3D()->getFontHeight() * $tmpNum;
                            }
                            if (($axisLabels->iSeparation != 0) &&
                                ($this->oldPosLabel != -1)) {
                                $tmpLabelSize += (int) (0.02 * $tmpLabelSize *
                                        $axisLabels->iSeparation);
                                $tmpLabelSize *= 0.5;

                                if ($tmp >= $oldPosLabel) {
                                    $tmpDraw = (($tmp -
                                                $tmpLabelSize) >=
                                               ($this->oldPosLabel +
                                                $oldSizeLabel));
                                } else {
                                    $tmpDraw = (($tmp +
                                                $tmpLabelSize) <=
                                               ($this->oldPosLabel -
                                                $oldSizeLabel));
                                }

                                if ($tmpDraw) {
                                    $this->drawThisLabel($tmp, $tmpSt, null);
                                    $oldPosLabel = $tmp;
                                    $oldSizeLabel = $tmpLabelSize;
                                }
                            } else {
                                $this->drawThisLabel($tmp, $tmpSt, null);
                                $oldPosLabel = $tmp;
                                $oldSizeLabel = $tmpLabelSize / 2;
                            }
                        }
                    }
                }
            }

            $this->axis->iSeriesList->clear(false);
        }
    }

    private function drawCustomLabels() {

        $axisLabels = $this->axis->getLabels();
        for ( $t = 0; $t < sizeof($axisLabels->getItems()); $t++) {

            $tmpItem = $axisLabels->getItems()->getItem($t);

            if ($tmpItem->getValue() >= $this->axis->getMinimum() &&
                $tmpItem->getValue() <= $this->axis->getMaximum()) {

                $tmp = $this->axis->calcPosValue($tmpItem->getValue());

                if (!$this->axis->getTickOnLabelsOnly()) {
                    $this->addTick($tmp);
                }
                if ($tmpItem->getVisible()) {
                    $tmpSt = $tmpItem->getText();
                    if ($tmpSt=="") {
                        $tmpSt = $axisLabels->labelValue($tmpItem->getValue());
                    }

                    $this->drawThisLabel($tmp, $tmpSt, $tmpItem);
                }
            }
        }
    }

    public function draw($calcPosAxis) {
        $this->axis->iAxisDateTime = $this->axis->isDateTime();

        if ($calcPosAxis) {
            $this->axis->posAxis = $this->axis->applyPosition($this->axis->
                    getRectangleEdge($this->axis->chart->getChartRect()),
                                              $this->axis->chart->getChartRect());
        }

        $this->drawAxisTitle();

        $this->tmpNumTicks = 0;
        $this->ticks = Array();  // [self::$MAXAXISTICKS];

        $this->tmpAlternate = $this->axis->getHorizontal();

        $axisLabels = $this->axis->getLabels();
        if ($axisLabels->getItems()->count() == 0) {
            $this->tmpLabelStyle = $this->axis->calcLabelStyle();

            if ($this->tmpLabelStyle != AxisLabelStyle::$NONE) {
                // Assign font before CalcIncrement !
                $this->chart->getGraphics3D()->setFont($axisLabels->getFont());
                $this->iIncrement = $this->axis->getCalcIncrement();

                if ($this->axis->iAxisDateTime &&
                    $axisLabels->getExactDateTime() &&
                    ($this->axis->getIncrement() != 0)) {
                    $this->tmpWhichDatetime = Axis::findDateTimeStep(
                            $this->axis->getIncrement());

                    $tmpDateTimeStep = new DateTimeStep();

                    if ($this->tmpWhichDatetime != DateTimeStep::$NONE) {
                        while (($this->iIncrement >
                                ($tmpDateTimeStep->STEP[$this->tmpWhichDatetime])) &&
                               ($this->tmpWhichDatetime !=
                                DateTimeStep::$ONEYEAR)) {
                            $this->tmpWhichDatetime += 1;
                        }
                    }
                } else {
                    $this->tmpWhichDatetime = DateTimeStep::$NONE;
                }

                if ((($this->iIncrement > 0) ||
                     (($this->tmpWhichDatetime >=
                       DateTimeStep::$HALFMONTH) &&
                      ($this->tmpWhichDatetime <=
                       DateTimeStep::$ONEYEAR)))
                    && ($this->axis->iMaximum >= $this->axis->iMinimum)) {

                    if ($this->tmpLabelStyle == AxisLabelStyle::$VALUE) {
                        $this->doCustomLabels();
                        /*if ((axis.chart.getParent() != null) && --> doNotCustomLabels is called from doCustomLabels
                            (axis.chart.getParent().
                             checkGetAxisLabelAssigned())) {
                            doCustomLabels();
                                                 } else {
                            doNotCustomLabels();
                                                 }*/
                    } else
                    if ($this->tmpLabelStyle == AxisLabelStyle::$MARK) {
                        $this->axisLabelsSeries($this->axis->chart->getChartRect());
                    } else
                    if ($this->tmpLabelStyle == AxisLabelStyle::$TEXT) {
                        if ($this->axis->isDepthAxis) {
                            $this->depthAxisLabels();
                        } else {
                            $this->axisLabelsSeries($this->axis->chart->getChartRect());
                        }
                    }
                }
            }
        } else {
            $this->drawCustomLabels();
        }

        $this->drawTicksAndGrid->drawTicksGrid($this->ticks, $this->tmpNumTicks, $this->tmpValue);
    }

        function setChart($chart) {
                $this->chart = $chart;

                if ($this->drawTicksAndGrid != null) {
                        $this->drawTicksAndGrid->setChart($chart);
                }
        }
}

 /**
 * TicksGridDraw class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage Axis
 * @link http://www.steema.com
 */

 class TicksGridDraw {
    private $axis;
    private $tmpNumTicks;
    private $tmpTicks;
    private $tmpWallSize;
    private $c;
    private $g;
    private $a;
    private $is3D;
    private $r;

    /**
    * The class constructor.
    */
    public function __construct($a=null) {

        if ($a != null) {
            $this->axis = $a;
            $this->setChart($this->axis->chart);
        }
    }
    
    public function __destruct() {        
        unset($this->axis);
        unset($this->tmpNumTicks);
        unset($this->tmpTicks);
        unset($this->tmpWallSize);
        unset($this->c);
        unset($this->g);
        unset($this->a);
        unset($this->is3D);
        unset($this->r);
    }      
    

    public function setChart($chart) {
        $this->c = $chart;
    }

    private function getZGridPosition() {
        return (int) ($this->a->getWidth3D() * $this->axis->getGrid()->getZPosition() * 0.01); // 6.0
    }

    private function drawGridLine($tmp) {
        if (($tmp > $this->axis->iStartPos) && ($tmp < $this->axis->iEndPos)) {
            if ($this->axis->isDepthAxis) {
                $this->g->verticalLine($this->r->x, $this->r->y, $this->r->getBottom(), $tmp);
                $this->g->horizontalLine($this->r->x, $this->r->getRight(), $this->r->getBottom(),
                                 $tmp);
            } else if ($this->axis->getHorizontal()) {
                if ($this->is3D) {
                    if ($this->axis->getOtherSide()) {
                        $this->g->verticalLine($tmp, $this->r->y, $this->r->getBottom(),
                                       $this->a->getWidth3D());
                    } else {
                        if ($this->c->getAxes()->getDrawBehind()) {

                            $this->g->zLine($tmp, $this->axis->posAxis, $this->getZGridPosition(),
                                    $this->a->getWidth3D());

                            $this->g->verticalLine($tmp, $this->r->y,
                                           $this->r->getBottom(), $this->a->getWidth3D());
                        } else {
                            $this->g->verticalLine($tmp, $this->r->y,
                                           $this->r->getBottom(), 0);
                        }
                    }
                } else {
                    $this->g->verticalLine($tmp, $this->r->y + 1, $this->r->getBottom(),0);
                }
            } else
            if ($this->is3D) {
                if ($this->axis->getOtherSide()) {
                    $this->g->horizontalLine($this->r->x, $this->r->getRight(), $tmp, $this->a->getWidth3D());
                } else {
                    if ($this->c->getAxes()->getDrawBehind()) {

                        $this->g->zLine($this->axis->posAxis, $tmp, $this->getZGridPosition(),
                                $this->a->getWidth3D());

                        if (!$this->axis->hideBackGrid) {
                            if ($this->axis->getHorizontal()) {
                                $this->g->verticalLine($tmp, $this->r->getTop(), $this->r->getBottom(),
                                        $this->a->getWidth3D());
                            } else {
                                $this->g->horizontalLine($this->r->x, $this->r->getRight(), $tmp,
                                        $this->a->getWidth3D());
                            }
                        }
                    }
                }
            } else {
                $this->g->horizontalLine($this->r->x + 1, $this->r->getRight(), $tmp,0);
            }
        }
    }

    private function drawGrids() {
        $old_name=TChart::$controlName;               
        TChart::$controlName .='Axis_Grid_';
        
        $this->g->setPen($this->axis->getGrid());
        // TODO if ($this->g->getPen()->getColor()->isEmpty()) {
            $this->g->getPen()->setColor(new Color(128,128,128));
        //}

        for ( $t = 0; $t < $this->tmpNumTicks; $t++) {
            if ($this->axis->getGrid()->getCentered()) {
                if ($t > 0) {
                    $this->drawGridLine((int) (0.5 *
                       ($this->tmpTicks[$t] + $this->tmpTicks[$t - 1])));
                }
            } else {
                $this->drawGridLine($this->tmpTicks[$t]);
            }
        }
        TChart::$controlName=$old_name;   
    }

    private function internalDrawTick($tmp, $delta, $tmpTickLength) {
        if ($this->axis->isDepthAxis) {
            if ($this->axis->getOtherSide()) {
                if ($this->is3D) {
                    $this->g->horizontalLine($this->axis->posAxis + $delta,
                            $this->axis->posAxis + $delta + $tmpTickLength,
                            $this->getDepthAxisPos(), $tmp);
                } else {
                    $this->g->horizontalLine($this->axis->posAxis + $delta,
                            $this->axis->posAxis + $delta + $tmpTickLength,
                            $this->getDepthAxisPos(),0);
                }
            } else {
                if ($this->is3D) {
                    $this->g->horizontalLine($this->axis->posAxis - $delta,
                            $this->axis->posAxis - $delta - $tmpTickLength,
                            $this->getDepthAxisPos(), $tmp);
                } else {
                    $this->g->horizontalLine($this->axis->posAxis - $delta,
                            $this->axis->posAxis - $delta - $tmpTickLength,
                            $this->getDepthAxisPos(),0);
                }

            }
        } else
        if ($this->axis->getOtherSide()) {
            if ($this->axis->getHorizontal()) {
                if ($this->is3D) {
                    $this->g->verticalLine($tmp,
                                   $this->axis->posAxis - $delta,
                                   $this->axis->posAxis - $delta -
                                   $tmpTickLength, $this->axis->iZPos);
                } else {
                    $this->g->verticalLine($tmp,
                                   $this->axis->posAxis - $delta,
                                   $this->axis->posAxis - $delta -
                                   $tmpTickLength,0);
                }
            } else
            if ($this->is3D) {
                $this->g->horizontalLine($this->axis->posAxis + $delta,
                                 $this->axis->posAxis + $delta +
                                 $tmpTickLength, $tmp, $this->axis->iZPos);
            } else {
                $this->g->horizontalLine($this->axis->posAxis + $delta,
                                 $this->axis->posAxis + $delta +
                                 $tmpTickLength, $tmp,0);
            }
        } else {
            $delta += $this->tmpWallSize;
            if ($this->axis->getHorizontal()) {
                if ($this->is3D) {
                    $this->g->verticalLine($tmp,
                                   $this->axis->posAxis + $delta,
                                   $this->axis->posAxis + $delta +
                                   $tmpTickLength, $this->axis->iZPos);
                } else {
                    $this->g->verticalLine($tmp,
                                   $this->axis->posAxis + $delta,
                                   $this->axis->posAxis + $delta +
                                   $tmpTickLength,0);
                }
            } else
            if ($this->is3D) {
                $this->g->horizontalLine($this->axis->posAxis - $delta,
                                 $this->axis->posAxis - $delta -
                                 $tmpTickLength, $tmp, $this->axis->iZPos);
            } else {
                $this->g->horizontalLine($this->axis->posAxis - $delta,
                                 $this->axis->posAxis - $delta -
                                 $tmpTickLength, $tmp, 0);
            }
        }
    }

    private function drawAxisLine() {
        $old_name=TChart::$controlName;                           
        TChart::$controlName .='Axis_';            
        
        if ($this->axis->isDepthAxis) {
            $tmp;
           if ($this->axis->getOtherSide()) {
               $tmp = $this->r->getBottom() +
                     $this->c->getWalls()->calcWallSize($this->c->getAxes()->getBottom()) -
                     $this->axis->iZPos;
           } else {
               $tmp = $this->r->getTop() - $this->axis->iZPos;
           }
           $this->g->line($this->axis->posAxis, $tmp, $this->axis->iStartPos,
                  $this->axis->posAxis, $tmp, $this->axis->iEndPos);
        } else
        if ($this->axis->getHorizontal()) {
            if ($this->axis->getOtherSide()) {
                $this->g->horizontalLine($this->axis->iStartPos,
                                 $this->axis->iEndPos, $this->axis->posAxis,
                                 $this->axis->iZPos);
            } else {
                $this->g->horizontalLine($this->axis->iStartPos -
                        $this->c->getWalls()->calcWallSize($this->c->getAxes()->getLeft()),
                                 $this->axis->iEndPos,
                                 $this->axis->posAxis + $this->tmpWallSize,
                                 $this->axis->iZPos);
            }
        } else {
             $tmp = $this->axis->getOtherSide() ? $this->tmpWallSize :
                      -$this->tmpWallSize;
            $this->g->verticalLine($this->axis->posAxis + $tmp,
                           $this->axis->iStartPos,
                           $this->axis->iEndPos +
                           $this->c->getWalls()->calcWallSize($this->c->getAxes()->getBottom()),
                           $this->axis->iZPos);
        }
        TChart::$controlName=$old_name;
    }

    private function aProc($aPos, $isGrid) {
        if (($aPos > $this->axis->iStartPos) && ($aPos < $this->axis->iEndPos)) {
            if ($isGrid) {
                $pen = $this->axis->getMinorGrid();
                $this->drawGridLine($aPos);
            } else {
                $this->internalDrawTick($aPos, 1,
                                 $this->axis->getMinorTicks()->length);
            }
        }
    }

    private function processMinorTicks($isGrid) {
         $tmpInvCount = 1.0 / ($this->axis->getMinorTickCount() + 1);

        if ($this->tmpNumTicks > 1) {
            if (!$this->axis->getLogarithmic()) {
                $tmpDelta = 1.0 * ($this->tmpTicks[1] - $this->tmpTicks[0]) *
                           $tmpInvCount;
                for ( $t = 1; $t <= $this->axis->getMinorTickCount(); $t++) {
                    $this->aProc($this->tmpTicks[0] - (int) ($t * $tmpDelta),
                          $isGrid);
                    $this->aProc($this->tmpTicks[$this->tmpNumTicks - 1] +
                          (int) ($t * $tmpDelta), $isGrid);
                }
            }

            for ( $t = 1; $t <= $this->tmpNumTicks - 1; $t++) {
                if ($this->axis->getLogarithmic()) {

                     $tmpValue = $this->axis->calcPosPoint($this->tmpTicks[$t - 1]);
                     $tmpDelta = (($tmpValue *
                                 $this->axis->getLogarithmicBase()) -
                                $tmpValue) * $tmpInvCount;

                    for ( $tt = 1; $tt < $this->axis->getMinorTickCount(); $tt++) {
                        $tmpValue += $tmpDelta;
                        if ($tmpValue <= $this->axis->iMaximum) {
                            $this->aProc($this->axis->calcPosValue($tmpValue), $isGrid);
                        } else {
                            break;
                        }
                    }
                } else {
                    $tmpDelta = 1.0 *
                               ($this->tmpTicks[$t] - $this->tmpTicks[$t - 1]) *
                               $tmpInvCount;
                    for ( $tt = 1; $tt <= $this->axis->getMinorTickCount(); $tt++) {
                        $this->aProc($this->tmpTicks[$t] -
                              (int) ($tt * $tmpDelta), $isGrid);
                    }
                }
            }
        }
    }

    private function processTicks($aPen, $aOffset, $aLength) {
        if ($aPen->getVisible() && ($aLength != 0)) {
            $old_name=TChart::$controlName;                                           
            TChart::$controlName .='Axis_Ticks_';                
            $this->g->setPen($aPen);
            for ( $t = 0; $t < $this->tmpNumTicks; $t++) {
                $this->internalDrawTick($this->tmpTicks[$t], $aOffset,
                                 $aLength);
            }
            TChart::$controlName=$old_name;
        }
    }

    private function processMinor($aPen, $isGrid) {
        if (($this->tmpNumTicks > 0) && $aPen->getVisible()) {
            $this->g->setPen($aPen);
            $this->processMinorTicks($isGrid);
        }
    }

    public function drawTicksGrid($tempTicks, $tempNumTicks, $tempValue) {
        $this->c = $this->axis->chart;
        $this->g = $this->c->getGraphics3D();
        $this->a = $this->c->getAspect();
        $this->is3D = $this->a->getView3D();
        $this->tmpTicks = $tempTicks;
        $this->tmpNumTicks = $tempNumTicks;
        $this->r = $this->c->getChartRect();

        $this->g->getBrush()->setVisible(false);

        $this->tmpWallSize = $this->c->getWalls()->calcWallSize($this->axis);
        if ($this->axis->getAxisPen()->getVisible()) {
            $this->g->setPen($this->axis->getAxisPen());

            $this->drawAxisLine();
        }
        $this->processTicks($this->axis->getTicks(), 1, $this->axis->getTicks()->length);

        if ($this->axis->getGrid()->getVisible()) {
            $this->drawGrids();
        }

        $this->processTicks($this->axis->getTicksInner(), -1, -$this->axis->getTicksInner()->length);
        $this->processMinor($this->axis->getMinorTicks(), false);

        // speed optimization
        if ($this->axis->getMinorGrid() != null) {
            $this->processMinor($this->axis->getMinorGrid(), true);
        }
    }
}

/**
 * IntRange class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */      
class IntRange {
    public $first;
    public $last;

    /**
    * The class constructor.
    */
    public function __construct($first=0, $last=0) {
        $this->first = $first;
        $this->last = $last;
    }
    
    public function __destruct() {        
        unset($this->first);
        unset($this->last);
    }      
}

/**
 * GetAxisSeriesLabelResults class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */   
class GetAxisSeriesLabelResults {
    public $result;
    public $value;
    public $label;

    /**
    * The class constructor.
    */
    public function __construct() {
    }
    
    public function __destruct() {        
        unset($this->result);
        unset($this->value);
        unset($this->label);
    }      
    
}
?>