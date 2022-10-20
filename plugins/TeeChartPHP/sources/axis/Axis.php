<?php
/** 
 * Description: Axis Class 
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Axis Class
 *
 * Description: Accesses all Axis characteristics
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

class Axis extends TeeBase {

    // Private properties
    private $automatic = true;
    private $automaticMaximum = true;
    private $automaticMinimum = true;
    private $desiredIncrement=0;
    private $maximumvalue=0;
    private $minimumvalue=0;
    private $logarithmic=0;
    private $logarithmicBase = 10;
    private $maximumOffset=0;
    private $minimumOffset=0;
    private $minorTickCount = 3;
    private $minorTicks;
    private $ticks;
    private $ticksInner;
    private $tickonlabelsonly = true;
    private $startPosition=0;
    private $endPosition = 100;
    private $relativePosition=0;
    private $positionUnits;
    private $labels;
    private $otherSide=false;
    private static $MAXPIXELPOS = 32767;

    // Protected properties
    protected $minorGrid;
    protected $axisTitle;
    protected $axispen;
    protected $grid;
    protected $inverted=false;
    protected $horizontal=false;
    protected $bVisible = true;
    protected $zPosition=0;

    // Public properties
    public $axisDraw;
    public $iMinAxisIncrement=0;
    public static $MINAXISRANGE = 0.0000000001;
    public static $AXISCLICKGAP = 3; // min pixels distance to trigger axis click
    public $posAxis=0;
    public $posTitle=0;
    public $hideBackGrid;

    // internal
    public $iAxisDateTime;
    public $iAxisLogSizeRange;
    public $iAxisSizeRange;
    public $iCenterPos=0;
    public $iLogMax;
    public $iLogMin;
    public $iMaximum=0.0;
    public $iMinimum=0.0;
    public $iRange=0.0;
    public $iRangelog=0.0;
    public $iRangezero=false;
    public $iSeriesList;
    public $iStartPos=0.0;
    public $iEndPos=0.0;
    public $iAxisSize;
    public $isDepthAxis=false;
    public $iZPos;
    public $labelIndex;


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
    
    public function __destruct()    
    {        
        parent::__destruct();        
        unset($this->left);
        unset($this->automatic);
        unset($this->automaticMaximum);
        unset($this->automaticMinimum);
        unset($this->desiredIncrement);
        unset($this->maximumvalue);
        unset($this->minimumvalue);
        unset($this->logarithmic);
        unset($this->logarithmicBase);
        unset($this->maximumOffset);
        unset($this->minimumOffset);
        unset($this->minorTickCount);
        
        if (isset($this->minorTicks))
        {   
            $this->minorTicks->__destruct();                 
            unset($this->minorTicks);
        }
        
        if (isset($this->ticks))
        {   
            $this->ticks->__destruct();                 
            unset($this->ticks);
        }
       
        if (isset($this->ticksInner))
        {   
            $this->ticksInner->__destruct();                 
            unset($this->ticksInner);
        }
        
        unset($this->tickonlabelsonly);
        unset($this->startPosition);
        unset($this->endPosition);
        unset($this->relativePosition);
        unset($this->positionUnits);
        if (isset($this->labels))
        {   
            $this->labels->__destruct();     
            unset($this->labels);
        }
        unset($this->otherSide);

        if (isset($this->minorGrid))
        {   
            $this->minorGrid->__destruct();     
            unset($this->minorGrid);
        }
        
        if (isset($this->axisTitle))
        {   
            $this->axisTitle->__destruct();                 
            unset($this->axisTitle);
        }
        
        if (isset($this->axispen))
        {   
            $this->axispen->__destruct();                 
            unset($this->axispen);
        }

        if (isset($this->grid))
        {   
            $this->grid->__destruct();                 
            unset($this->grid);
        }
        
        unset($this->inverted);
        unset($this->horizontal);
        unset($this->bVisible);
        unset($this->zPosition);

        unset($this->axisDraw);
        unset($this->iMinAxisIncrement);
        unset($this->posAxis);
        unset($this->posTitle);
        unset($this->hideBackGrid);

        // internal
        unset($this->iAxisDateTime);
        unset($this->iAxisLogSizeRange);
        unset($this->iAxisSizeRange);
        unset($this->iCenterPos);
        unset($this->iLogMax);
        unset($this->iLogMin);
        unset($this->iMaximum);
        unset($this->iMinimum);
        unset($this->iRange);
        unset($this->iRangelog);
        unset($this->iRangezero);
        unset($this->iSeriesList);
        unset($this->iStartPos);
        unset($this->iEndPos);
        unset($this->iAxisSize);
        unset($this->isDepthAxis);
        unset($this->iZPos);
        unset($this->labelIndex);
    }
    
    public function internalSetInverted($value) {
        $this->inverted = $value;
    }

    /**
    * The class constructor.
    */
    public function __construct($horiz=false, $isOtherSide=false, $chart=null) {
        $this->positionUnits = PositionUnits::$PERCENT;

        parent::__construct($chart);
               
        $this->labels = new AxisLabels($this);
        $this->axispen = new AxisLinePen($chart);
        $this->readResolve();

        $this->horizontal = $horiz;
        $this->otherSide = $isOtherSide;
        $this->labeIndex = 0;
    }

    protected function readResolve() {
        $this->iMinAxisIncrement = 0.000000000001;
        return $this;
    }

    private function internalSetMaximum($value) {
        $this->maximumvalue = $this->setDoubleProperty($this->maximumvalue, $value);
    }

    private function internalSetMinimum($value) {
        $this->minimumvalue = $this->setDoubleProperty($this->minimumvalue, $value);
    }

    public function getRange() {
        return $this->iRange;
    }

    /**
     * Accesses the Label characteristics of Axis Labels.
     *
     * @return AxisLabels
     */
    public function getLabels() {
        return $this->labels;
    }

    /**
     * Returns the custom labels
     *
     * @return AxisLabelsItems
     */
    public function getCustomLabels() {
        return $this->labels->getItems();
    }

    /**
     * Calculates Max and Min of axis scale based on associated Series.
     *
     * @return boolean
     */
    public function getAutomatic() {
        return $this->automatic;
    }

    /**
    * Description Max and Min of axis scale based on associated Series.
    * @param boolean $value
    */
    public function setAutomatic($value) {
        $this->automatic = $this->setBooleanProperty($this->automatic, $value);
        $this->automaticMinimum = $value;
        $this->automaticMaximum = $value;
    }

    protected function shouldSerializeHorizontal() {
        return $this->isCustom();
    }

    /**
     * Determines the Custom axis to be drawn horizontally.
     *
     * @return boolean
     */
    public function getHorizontal() {
        return $this->horizontal;
    }

    /**
     * Sets a custom axis to be drawn horizontally.
     *
     * @param $value boolean
     */
    public function setHorizontal($value) {
        $this->horizontal = $this->setBooleanProperty($this->horizontal, $value);
    }

    protected function shouldSerializeOtherSide() {
        return $this->isCustom();
    }

    /**
     * Positions the Axis labels to the Otherside of the axis.<br> For instance,
     * moves labels on a vertical Axis to the right of the Axis. This is
     * useful when adding a Custom Axis, to place the labelling to the Right
     * for a right vertical Axis, or to the Top for a Top Axis.
     *
     * @return boolean
     */
    public function getOtherSide() {
        return $this->otherSide;
    }

    /**
     * Sets the Axis labels to the Otherside of the axis.
     *
     * @param $value boolean
     */
    public function setOtherSide($value) {
        $this->otherSide = $this->setBooleanProperty($this->otherSide, $value);
    }

    /**
     * Internal use.
     */
    public function internalCalcRange() {
        $this->iRange = $this->iMaximum - $this->iMinimum;
        $this->iRangezero = $this->iRange == 0;
        $this->iAxisSizeRange = $this->iRangezero ? 0 : $this->iAxisSize / $this->iRange;

        if ($this->logarithmic) {
            $this->iLogMin = ($this->iMinimum <= 0) ? 0 : log($this->iMinimum);
            $this->iLogMax = ($this->iMaximum <= 0) ? 0 : log($this->iMaximum);
            $this->iRangelog = $this->iLogMax - $this->iLogMin;
            $this->iAxisLogSizeRange = ($this->iRangelog == 0) ? 0 :
                                $this->iAxisSize / $this->iRangelog;
        }

        $this->iZPos = $this->calcZPos();
    }

    // Returns FloatRange
    private function reCalcAdjustedMinMax($pos1, $pos2) {
        $oldStart = $this->iStartPos;
        $oldEnd = $this->iEndPos;
        $this->iStartPos += $pos1;
        $this->iEndPos -= $pos2;
        $this->iAxisSize = $this->iEndPos - $this->iStartPos;

        return new FloatRange($this->calcPosPoint($oldStart), $this->calcPosPoint($oldEnd));
    }

    /**
     * Called internally to recalculate the max and min $values using the
     * Rect parameter positions.<br>
     * The Rect parameter determines in pixels the margins to apply to
     * ChartRect. The Axis recalculates the appropiate maximum and minimum
     * $values using the Rect parameter positions.
     *
     * @param rect Rectangle
     */
    public function adjustMaxMinRect($rect) {
        $tmp=new FloatRange();

        if ($this->horizontal) {
            $tmp = $this->reCalcAdjustedMinMax($rect->x, $rect->getRight());
        } else {
            $tmp = $this->reCalcAdjustedMinMax($rect->y, $rect->getBottom());
        }

        $this->internalCalcPositions();
        $this->iMaximum = $tmp->max;
        $this->iMinimum = $tmp->min;

        if ($this->iMinimum > $this->iMaximum) { // swap
            $tmp2 = $this->iMinimum;
            $this->iMinimum = $this->iMaximum;
            $this->iMaximum = $tmp2;
        }

        $this->internalCalcRange();
    }

    /**
     * Returns true if Axis is a Custom Axis
     *
     * @return boolean
     */
    public function isCustom() {
        return $this->chart->isAxisCustom($this);
    }

    /**
     * Calculates Maximum and Minimum $values based on Max and Min $values of
     * the dependent Series.<br>
     * AdjustMaxMin is automatically called if Axis.Automatic is true.
     * The Chart Zoom.Undo method calls AdjustMaxMin for Left, Right,Top
     * and Bottom axis.
     */
    public function adjustMaxMin() {
        $tmp = new FloatRange();
        $this->calcMinMax($tmp);
        $this->minimumvalue = $tmp->min;
        $this->maximumvalue = $tmp->max;
        $this->iMaximum = $this->maximumvalue;
        $this->iMinimum = $this->minimumvalue;
        $this->internalCalcRange();
    }

    private function setAutoMinMax($variable, $var2,  $value) {
        $variable = $this->setBooleanProperty($variable, $value);
        if ($value) {
            // if both are automatic, then Automatic should be True too
            if ($var2) {
                $this->automatic = true;
            }
        } else {
            $this->automatic = false;
        }
        return $variable;
    }

    /**
     * Controls if Axis will adjust the Maximum $value automatically based on
     * the maximum $value of its associated Series.<br>
     * Default $value: true
     *
     * @return boolean
     */
    public function getAutomaticMaximum() {
        return $this->automaticMaximum;
    }

    /**
     * The Axis adjusts the Maximum $value automatically based on the maximum
     * $value of its associated Series when true.<br>
     * Default $value: true
     *
     * @param $value boolean
     */
    public function setAutomaticMaximum($value) {
        $this->automaticMaximum = $this->setAutoMinMax($this->automaticMaximum, $this->automaticMinimum,
                                         $value);
    }

    /**
     * Controls minimum $value automatically based on the minimum $value of
     * its associated Series.<br>
     * Default $value: true
     *
     * @return boolean
     */
    public function getAutomaticMinimum() {
        return $this->automaticMinimum;
    }

    /**
     * The Axis adjusts the Minimum $value automatically based on the maximum
     * $value of its associated Series when true.<br>
     * Default $value: true
     *
     * @param $value boolean
     */
    public function setAutomaticMinimum($value) {
        $this->automaticMinimum = $this->setAutoMinMax($this->automaticMinimum, $this->automaticMaximum,
                                         $value);
    }

    /**
     * Determines the kind of pen used to draw the major Axis lines.<br>
     * These are the lines which go from Axis Minimum to Axis Maximum screen
     * positions.
     *
     * @return AxisLinePen
     */
    public function getAxisPen() {
        return $this->axispen;
    }

    /**
     * Determines the kind of pen used to draw the Grid lines at every Axis
     * Label position.<br> These are the lines which go from "cousin Axis"
     * Minimum to "cousin Axis" Maximum screen positions for each Label
     * position.<br>
     * Use the MinorGrid property to make the Grid from Minor Ticks visible.
     *
     * @return GridPen
     */
    public function getGrid() {
        if ($this->grid == null) {
            $this->grid = new GridPen($this->chart);
        }
        return $this->grid;
    }

    /**
     * Obsolete.&nbsp;Please use Labels.<!-- -->OnAxis instead.
     *
     * @return boolean
     */
    public function getLabelsOnAxis() {
        return $this->labels->bOnAxis;
    }

    /**
     * Obsolete.&nbsp;Please use Labels.<!-- -->OnAxis instead.
     *
     * @param $value boolean
     */
    public function setLabelsOnAxis($value) {
        $this->labels->bOnAxis = $value;
    }

   /**
     * Returns if the Axis dependent $values are DateTime or not. <br>
     * Each Chart Axis can consider $values to be normal numbers or DateTime
     * $values. An axis is "DateTime" if at least one Active Series with
     * datetime $values is associated to it.<br>
     * Default $value: false
     *
     * @return boolean
     */
    public function isDateTime() {
        for ($t = 0; $t < $this->chart->getSeriesCount(); $t++) {
            $s = $this->chart->getSeries($t);
            if ($s->getActive()) {
                if ($s->associatedToAxis($this)) {
                    return $this->getHorizontal() ? $s->getXValues()->getDateTime() :
                            $s->getYValues()->getDateTime();
                }
            }
        }
        return false;
    }

    /**
     * Determines the minimum step between axis labels.<br>
     * Can use DateTimeStep for date-time axis. It must be a positive number
     * or DateTime $value. TChart will use this $value as the inicial axis label
     * step. If there is not enough space for all labels, TChart will calculate
     * a bigger one. You can use the DateTimeStep constant array for DateTime
     * increments.
     *
     *
     * @return double
     */
    public function getIncrement() {
        return $this->desiredIncrement;
    }

    /**
     * Sets the minimum step between axis labels.
     *
     * @param $value double
     */
    public function setIncrement($value) {

        /** @todo RAISING EXCEPTIONS HERE FORCES DECLARING "THROW" EVERYWHERE!  */
//        if ($value < 0) {
//            throw new TeeChartException(Language.getString("AxisIncrementNeg"));
//        }

        //if (isDateTime()) System.Convert.ToDateTime($value).ToString();
        $this->desiredIncrement = $this->setDoubleProperty($this->desiredIncrement, $value);
    }

    /**
     * Swaps the Axis Minimum and Maximum scales.<br>
     * When true, Axis Minimum and Maximum scales will be swapped. Axis labels
     * and Series points will be displayed accordingly. This applies both to
     * vertical and horizontal axis.<br>
     * Default $value: false
     *
     * @return boolean
     */
    public function getInverted() {
        return $this->inverted;
    }

    /**
     * Swaps the Axis Minimum and Maximum scales when true.<br>
     * Default $value: false
     *
     * @param $value boolean
     */
    public function setInverted($value) {
        $this->inverted = $this->setBooleanProperty($this->inverted, $value);
        if ($this->isDepthAxis) {
            if ($this == $this->getChart()->getAxes()->getDepth())
                $this->chart->getAxes()->getDepthTop()->inverted = $this->getInverted();
            else
                $this->chart->getAxes()->getDepth()->inverted = $this->getInverted();
        }
    }

    /**
     * Scales the Axis Logarithmically when true.<br>
     * Axis Minimum and Maximum $values should be greater than 0, and Axis
     * cannot be of DateTime type.<br>
     * Default $value: false
     *
     * @return boolean
     */
    public function getLogarithmic() {
        return $this->logarithmic;
    }

    /**
     * Scales the Axis Logarithmically when true.<br>
     * Default $value: false
     *
     * @param $value boolean
     * @throws TeeChartException
     */
    public function setLogarithmic($value) /*throws ChartException*/ {
        if ($this->chart != null) { //CDI for custom axes at designtime this $value is
            //sometimes null.
            if (($value) && ($this->isDateTime())) {
                throw new ChartException(Language::getString("AxisLogDateTime"));
            }

            if ($value) {
                $this->adjustMaxMin();
                if (($this->iMinimum < 0) || ($this->iMaximum < 0)) {
                    throw new ChartException(Language::getString("AxisLogNotPositive"));
                }
            }
        }

        $this->logarithmic = $this->setBooleanProperty($this->logarithmic, $value);
    }

    protected function shouldSerializeMaximum() {
        return (!$this->automatic) && (!$this->automaticMaximum);
    }

    /**
     * Amount of pixels that will be left as a margin at axis maximum
     * position.<br>
     * It is useful when you don't want the series to display points very
     * close to axis boundaries. <br>
     * Default $value: 0
     * <br><br>
     * Example:
     * <pre><font face="Courier" size="4">
     * myChart.getAxes().getBottom().setMaximumOffset(4);
     * myChart.getAxes().getBottom().setMinimumOffset(4);
     * </font></pre>
     *
     * @return int
     */
    public function getMaximumOffset() {
        return $this->maximumOffset;
    }

    /**
     * Sets the amount of pixels that will be left as a margin at axis maximum
     * position.<br>
     * Default $value: 0
     *
     * @param $value int
     */
    public function setMaximumOffset($value) {
        $this->maximumOffset = $this->setIntegerProperty($this->maximumOffset, $value);
    }

    /**
     * The highest $value an Axis will use to scale their dependent Series
     * posvalues.<br>
     * It can be any number or DateTime $value. It must be greater than the
     * Axis.Minimum $value.<br><br>
     * VERY IMPORTANT: <br>
     * Axis.Automatic property must be FALSE. If Axis.Automatic is true,
     * the Axis will set Maximum and Minimum $values to Maximum and Minimum
     * dependent Series $values.
     *
     * @return double
     */
    public function getMaximum() {
        return $this->maximumvalue;
    }

    /**
     * Sets the highest $value an Axis will use to scale their dependent Series
     * posvalues.<br>
     *
     * @param $value double
     */
    public function setMaximum($value) {
        $this->internalSetMaximum($value);
    }

    protected function shouldSerializeMinimum() {
        return (!$this->automatic) && (!$this->automaticMinimum);
    }

    /**
     * Advanced use. Smallest Axis calculation increment.<br>
     * Default $value: 1e-12
     *
     * @return double
     */
    public function getMinAxisIncrement() {
        return $this->iMinAxisIncrement;
    }

    /**
     * Advanced use. Determines the smallest Axis calculation increment.<br>
     * Default $value: 1e-12
     *
     * @param $value double
     */
    public function setMinAxisIncrement($value) {
        $this->iMinAxisIncrement = $value;
    }

    /**
     * The lowest $value an Axis will use to scale their dependent Series
     * povalues.<br>
     * It can be any number or DateTime $value. It must be lower than the
     * Axis.Maximum $value. <br><br>
     * VERY IMPORTANT: <br>
     * Axis.Automatic property must be FALSE. If Axis.Automatic is true,
     * the Axis will set Maximum and Minimum $values to Maximum and Minimum
     * dependent Series $values.
     *
     * @return double
     */
    public function getMinimum() {
        return $this->minimumvalue;
    }

    /**
     * Sets the lowest $value an Axis will use to scale their dependent Series
     * possvalues.<br>
     *
     * @param $value double
     */
    public function setMinimum($value) {
        $this->internalSetMinimum($value);
    }

    /**
     * The number of pixels that will be left as a margin at axis minimum
     * position.<br>
     * It is useful when you don't want the series to display points very close
     * to axis boundaries.<br>
     * Default $value: 0 <br>
     *
     * @return int
     */
    public function getMinimumOffset() {
        return $this->minimumOffset;
    }

    /**
     * Determines the number of pixels that will be left as a margin at axis
     * minimum position.<br>
     * Default $value: 0 <br>
     *
     * @param $value int
     */
    public function setMinimumOffset($value) {
        $this->minimumOffset = $this->setIntegerProperty($this->minimumOffset, $value);
    }

    /**
     * The number of Axis minor ticks between major ticks.<br>
     * Axis minor ticks are the Axis sub-ticks between major ticks. It should
     * be a positive number greater than zero and less than half the number
     * of pixels between major ticks, otherwise Minor ticks will "overlap".<br>
     * Default $value: 3
     *
     * @return int
     */
    public function getMinorTickCount() {
        return $this->minorTickCount;
    }

    /**
     * Determines the number of Axis minor ticks between major ticks.<br>
     * Default $value: 3
     *
     * @param $value int
     */
    public function setMinorTickCount($value) {
        $this->minorTickCount = $this->setIntegerProperty($this->minorTickCount, $value);
    }

    /**
     * Determines the Pen used to draw the Axis Minor ticks.<br>
     * Minor ticks will only be displayed if MinorTicks.Visible is true.<br>
     *
     * @return TicksPen
     */
    public function getMinorTicks() {
        if ($this->minorTicks == null) {
            $this->minorTicks = new TicksPen($this->chart);
            $this->minorTicks->length = 2;
            $this->minorTicks->defaultLength = 2;
        }
        return $this->minorTicks;
    }

    public function setMinorTicks($value) {
            $this->minorTicks=$value;
    }
    /**
     * Obsolete.&nbsp;Please use Position instead.
     *
     * @return int
     */
    public function getPosAxis() {
        return $this->posAxis;
    }

    /**
     * Determines the screen co-ordinate where axis is drawn.<br>
     * It returns the position of the Axis in pixels relative to the Chart
     * Panel. For horizontal axes the number is a Y position, for vertical
     * axes an X position. <br>
     * Default $value: 0
     *
     * @return int
     */
    public function getPosition() {
        return $this->posAxis;
    }

    /**
     * The Axis Ticks and Axis Grid to be drawn only coincide at Labels.<br>
     * Otherwise, they will be drawn at all axis increment positions.
     * When the Axis.Labels.Separation property is greater than 0 (default 10),
     * Axis increases the increment property to afunction Axis Label overlap.<br>
     * Default $value: true
     *
     * @return boolean
     */
    public function getTickOnLabelsOnly() {
        return $this->tickonlabelsonly;
    }

    /**
     * Sets the Axis Ticks and Axis Grid to be drawn to only coincide at
     * Labels.<br>
     * Default $value: true
     *
     * @param $value boolean
     */
    public function setTickOnLabelsOnly($value) {
        $this->tickonlabelsonly = $this->setBooleanProperty($this->tickonlabelsonly, $value);
    }

    /**
     * Determines the kind of Pen used to draw Axis marks along the Axis line.
     * <br>
     * Ticks position is calculated based on Axis.Increment,
     * Axis.Labels.Separation and Axis.Label.Style methods.<br>
     * There are three kind of ticks available:  Ticks, MinorTicks and
     * TicksInner.<br> You can show or hide any of them of have all of them
     * Visible. Ticks.Length defines the length of Axis Ticks in logical pixels.
     *
     * @return TicksPen
     */
    public function getTicks() {
        if ($this->ticks == null) {
            $this->ticks = new TicksPen($this->chart);
            $this->ticks->length=4;
            $this->ticks->defaultLength = 4;
        }

        return $this->ticks;
    }

    public function setTicks($value) {
            $this->ticks=$value;
    }

    /**
     * Determines the kind of Pen used to draw Axis marks along the Axis line.
     * <br>
     * This does the same as Ticks, but lines are drawn inside Chart boundaries
     * instead. TicksInner position is calculated based on Axis.Increment,
     * Axis.Labels.Separation and Axis.Label.Style.<br> There are three kind of
     * ticks available:  Ticks, MinorTicks and TicksInner.<br> You can show or
     * hide any of them of have all of them Visible. TickInnerLength defines
     * the length of Axis TicksInner in logical pixels.
     *
     * @return TicksPen
     */
    public function getTicksInner() {
        if ($this->ticksInner == null) {
            $this->ticksInner = new TicksPen($this->chart);
        }
        return $this->ticksInner;
    }

    /**
     * An Axis sub-class used to define Title attributes.<br>
     * Axis Titles are a string of text drawn near Axes. Use Text to specify
     * Axis Title text.<br>
     * Use Font and Angle to set the format desired.
     *
     * @return AxisTitle
     */
    public function getTitle() {
        if ($this->axisTitle == null) {
            $this->axisTitle = new AxisTitle($this->chart);
            if ($this->horizontal)
               $this->axisTitle->setAngle(0);
            else
               $this->axisTitle->setAngle(90);            
        }
        return $this->axisTitle;
    }

    public function setTitle($value) {
        $this->axisTitle = $value;
    }

    /**
     * Obsolete.&nbsp;Please use Axis.<!-- -->Title.<!-- -->CustomSize
     *
     * @return int
     */
    public function getTitleSize() {
        return $this->getTitle()->getCustomSize();
    }

    /**
     * Obsolete.&nbsp;Please use Axis.<!-- -->Title.<!-- -->CustomSize
     *
     * @param $value int
     */
    public function setTitleSize($value) {
        $this->getTitle()->setCustomSize($value);
    }

    /**
     * Shows or hides the Axis lines, ticks, grids, labels and title.<br>
     * You can change it both at design and runtime.<br>
     * Default $value: true
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->bVisible;
    }

    /**
     * Shows the Axis lines, ticks, grids, labels and title when true.<br>
     * Default $value: true
     *
     * @param $value boolean
     */
    public function setVisible($value) {
        $this->bVisible = $this->setBooleanProperty($this->bVisible, $value);
    }

    protected function shouldSerializeZPosition() {
        return (!$this->isDepthAxis) &&
                (
                        ($this->getOtherSide() && ($this->zPosition != 100)) ||
                        ((!$this->getOtherSide()) && ($this->zPosition != 0))
                );
    }

    /**
     * Determines the Z axis position along chart Depth as a percentage of the
     * total depth.<br>
     * It can even be set to negative $values to place the axis in front of the
     * Chart, or $values greater than 100% to place the axis behind the Chart.
     * In 3D or orthogonal display modes, ZPosition controls where to display
     * the axis line. It useful if you want to move axis to front or to back
     * in 3D view.<br>
     *
     * @return double
     */
    public function getZPosition() {
        return $this->zPosition;
    }

    /**
     * Sets the Z axis position along chart Depth as a percentage of the
     * total depth.<br>
     *
     * @param $value double
     */
    public function setZPosition($value) {
        $this->zPosition = $this->setDoubleProperty($this->zPosition, $value);
    }

    /**
     * Obsolete.&nbsp;Please use Axis.<!-- -->Grid.<!-- -->Centered property
     *
     * @return boolean
     */

    public function getGridCentered() {
        return $this->getGrid()->centered;
    }

    /**
     * Obsolete.&nbsp;Please use Axis.<!-- -->Grid.<!-- -->Centered property
     *
     * @param $value boolean
     */
    public function setGridCentered($value) {
        $this->getGrid()->setCentered($value);
    }

    /**
     * Determines the Axis position as percentage 0-100% of the Chart.<br>
     * 0 being Top for a horizontal Axis and Left for a vertical Axis.
     *
     * @return double
     */
    public function getRelativePosition() {
        return $this->relativePosition;
    }

    /**
     * Determines the Axis position as percentage 0-100% of the Chart.<br>
     *
     * @param $value double
     */
    public function setRelativePosition($value) {
        $this->relativePosition = $this->setDoubleProperty($this->relativePosition, $value);
    }

    /**
     * Defines axis Position units (pixels or percentage).<br>
     * When PositionUnits is Percent, Position $value is a percentage of total
     * chart size. <br>
     * When PositionUnits is Pixels, Position is considered in pixels. <br>
     * Default $value: Percent
     *
     * @return PositionUnits
     */
    public function getPositionUnits() {
        return $this->positionUnits;
    }

    /**
     * Determines the axis Position units (pixels or percentage).<br>
     * Default $value: Percent
     *
     * @param $value PositionUnits
     */
    public function setPositionUnits($value) {
        if ($this->positionUnits != $value) {
            $this->positionUnits = $value;
            $this->invalidate();
        }
    }

    /**
     * Axis Start position on its own Axis expressed as a percentage.<br>
     * For a vertical Axis a StartPosition of 75 would place the top of
     * the Axis 75% down the Chart.<br>
     * Default $value: 0%
     *
     * @return double
     */
    public function getStartPosition() {
        return $this->startPosition;
    }

    /**
     * Sets the Axis Start position on its own Axis expressed as a percentage.
     * <br>
     * Default $value: 0%
     *
     * @param $value double
     */
    public function setStartPosition($value) {
        $this->startPosition = $this->setDoubleProperty($this->startPosition, $value);
    }

    /**
     * Axis End Position on its own Axis expressed as a percentage (0-100%).<br>
     * For a Vertical Axis a $value of 75% would place the beginning of the
     * scale at 75% down from Top.<br>
     * Default $value: 100%
     *
     * @return double
     */
    public function getEndPosition() {
        return $this->endPosition;
    }

    /**
     * Sets the Axis End Position on its own Axis expressed as a percentage.<br>
     * Default $value: 100%
     *
     * @param $value double
     */
    public function setEndPosition($value) {
        $this->endPosition = $this->setDoubleProperty($this->endPosition, $value);
    }

    /**
     * The base for the Logarithmic scale when Axis Logarithmic = true.
     *
     * @return double
     */
    public function getLogarithmicBase() {
        return $this->logarithmicBase;
    }

    /**
     * Sets the base for the Logarithmic scale when Axis Logarithmic = true.
     *
     * @param $value double
     */
    public function setLogarithmicBase($value) {
        $this->logarithmicBase = $this->setDoubleProperty($this->logarithmicBase, $value);
    }

    /**
     * Characteristics of the Grid coincidental to Minor Ticks.<br>
     * The Minor Grid.Visible is false as default.
     *
     * @return ChartPen
     */
    public function getMinorGrid() {
        if ($this->minorGrid == null) {
            $this->minorGrid = new ChartPen($this->chart, new Color(0,0,0), false);
            $this->minorGrid->setDefaultStyle(DashStyle::$DOT);
        }
        return $this->minorGrid;
    }

    //methods
    // Returns string
    public function titleOrName() {
        $tmpResult = $this->getTitle()->getCaption();
        if ($tmpResult->length() == 0) {
            if ($this->isDepthAxis) {
                if ($this== $this->getChart()->getAxes()->getDepth())
                    return Language::getString("DepthAxis");
                else
                if ($this == $this->getChart()->getAxes()->getDepthTop())
                    return Language::getString("DepthTopAxis");
            } else {
                if ($this->horizontal) {
                    if ($this->otherSide) {
                        return Language::getString("TopAxis");
                    } else {
                        return Language::getString("BottomAxis");
                    }
                } else {
                    if ($this->otherSide) {
                        return Language::getString("RightAxis");
                    } else {
                        return Language::getString("LeftAxis");
                    }
                }
            }
        }
        return $tmpResult;
    }

    /**
     * Returns the minimum and maximum $values of the associated Series.
     *
     * @param tmp FloatRange
     */
    public function calcMinMax($tmp) {

        if ($this->automatic || $this->automaticMaximum) {
            $tmp->max = $this->chart->internalMinMax($this, false, $this->horizontal);
        } else {
            $tmp->max = $this->maximumvalue;
        }

        if ($this->automatic || $this->automaticMinimum) {
            $tmp->min = $this->chart->internalMinMax($this, true, $this->horizontal);
        } else {
            $tmp->min = $this->minimumvalue;
        }
    }

    private function maxLabelsValueWidth() {
        if (($this->isDateTime() && $this->labels->getExactDateTime()) ||
            $this->labels->getRoundFirstLabel()) {
            $tmp = $this->getCalcIncrement();
            $tmpA = round($tmp * (($this->iMinimum / $tmp)));
            $tmpB = round($tmp * (($this->iMaximum / $tmp))); //MM error on 'small'(20x20) chart with int32
        } else {
            $tmpA = $this->iMinimum;
            $tmpB = $this->iMaximum;
        }

        //MM pending
        //            GetAxisLabelEventHandler oldGetAxisLabel;
        //            if (chart.getParent()!=null) oldGetAxisLabel=chart.getParent().GetAxisLabel;
        //            GetAxisLabel=null;

        $tmpResult = ($this->chart->getGraphics3D()->textWidth(" ") +
                         max($this->chart->multiLineTextWidth(
                                 $this->labels->labelValue($tmpA))->width,
                                  $this->chart->multiLineTextWidth($this->labels->labelValue($tmpB))->width));

        return $tmpResult;
    }

    /**
     * Returns the maximum width in pixels of all Axis Labels.
     *
     * @return int
     */
    public function maxLabelsWidth() {
        if ($this->getLabels()->getItems()->count() == 0) {
            $tmpStyle = $this->calcLabelStyle();
            if ($tmpStyle == AxisLabelStyle::$VALUE) {
                return $this->maxLabelsValueWidth();
            } else
            if ($tmpStyle == AxisLabelStyle::$MARK) {
                return $this->chart->maxMarkWidth();
            } else
            if ($tmpStyle == AxisLabelStyle::$TEXT) {
                return $this->chart->maxTextWidth();
            } else {
                return 0;
            }

        } else {
            $result = 0;
            $g=$this->chart->getGraphics3D();
            $items = $this->getLabels()->getItems();
            for ($t = 0; $t < sizeof($items); $t++) {
                $g->setFont($items->getItem($t)->getFont());
                $result = max($result,
                    $this->chart->multiLineTextWidth($items->getItem($t)->getText())->width);
            }
            return $result;
        }
    }

    private function internalCalcSize($tmpFont, $tmpAngle, $tmpText, $tmpSize) {
        if ($tmpSize != 0) {
            return $tmpSize;
        } else {
            $g = $this->chart->getGraphics3D();
            if ($this->horizontal) {
                switch ($tmpAngle) {
                case 0:
                case 180:
                    return $g->fontTextHeight($tmpFont);
                default: // optimized for speed
                    if (strlen($tmpText) == 0) {
                        $g->setFont($tmpFont);
                        return $this->maxLabelsWidth();
                    } else {
                        return $g->textWidth($tmpText,$tmpFont);
                    }
                }
            } else {
                switch ($tmpAngle) {
                case 90:
                case 270:
                    return $g->fontTextHeight($tmpFont);
                default: // optimized for speed
                    if (strlen($tmpText) == 0) {
                        $g->setFont($tmpFont);
                        return $this->maxLabelsWidth();
                    } else {
                        return $g->textWidth($tmpText,$tmpFont);
                    }
                }
            }
        }
    }

    public function getSizeLabels() {
        $result=$this->internalCalcSize($this->labels->getFont(), $this->labels->getAngle(), "",
                                $this->labels->getCustomSize());
        if ($this->labels->getAlternate())
            $result=$result*2;
        return $result;
    }

    private function internalCalcDepthPosValue($value) {
        if ($this->iRangezero) {
            return $this->iCenterPos;
        } else {
            return ($this->iAxisSizeRange *
                          ($this->inverted ? $this->iMaximum - $value :
                           $value - $this->iMinimum));
        }
    }

    private function internalCalcLogPosValue($isx, $value) {
        if ($this->iRangelog == 0) {
            return $this->iCenterPos;
        } else
        if ($value <= 0) {
            return (($isx && $this->inverted) || (!$isx && !$this->inverted)) ?
                    $this->iEndPos : $this->iStartPos;
        } else {
            $tmpResult = MathUtils::round($this->inverted ?
                                              (($this->iLogMax - log($value)) *
                                               $this->iAxisLogSizeRange)
                                              :
                                              (log($value) - $this->iLogMin) *
                                              $this->iAxisLogSizeRange);

            return $isx ? $this->iStartPos + $tmpResult :
                    $this->iEndPos - $tmpResult;
        }
    }

    /**
     * Returns the corresponding $value of a Screen position in pixels.
     *
     * @param $value Screen $value
     * @return Position on screen in pixels
     */
    public function calcPosValue($value) {
        return $this->horizontal ? $this->calcXPosValue($value) : $this->calcYPosValue($value);
    }

    /**
    * Description Calculates the Horizontal coordinate in pixels of $value parameter
     * You can use CalcXPos$value when requiring pixel positions from which
     * to plot Drawing output.
    * @param double $value
    * @return int
    */

    public function calcXPosValue($value) {
        if ($this->isDepthAxis) {
            return $this->internalCalcDepthPosValue($value);
        } else
        if ($this->logarithmic) {
            return $this->internalCalcLogPosValue(true, $value);
        } else
        if ($this->iRangezero) {
            return $this->iCenterPos;
        } else {
            $tmp = ($value - $this->iMinimum) * $this->iAxisSizeRange;
            $tmp = $this->inverted ? $this->iEndPos - $tmp : $this->iStartPos + $tmp;
            if ($tmp > self::$MAXPIXELPOS) {
                $tmp = self::$MAXPIXELPOS;
            } else
            if ($tmp < -self::$MAXPIXELPOS) {
                $tmp = -self::$MAXPIXELPOS;
            }
            return $tmp;
        }
    }

    /**
     * Calculates the Vertical coordinate in pixels of $value parameter.
     *
     * @param $value $value Parameter
     * @return $Vertical coordinate in pixels
     */
    public function calcYPosvalue($value) {
        if ($this->isDepthAxis) {
            return $this->internalCalcDepthPosValue($value);
        } else
        if ($this->logarithmic) {
            return $this->internalCalcLogPosValue(false, $value);
        } else
        if ($this->iRangezero) {
            return $this->iCenterPos;
        } else {

            // compile with //#define CHECKOVER
            // if you wish to afunction axis coordinates overflow when zooming,
            // specially in Windows 95, 98 or Me.

//#if CHECKOVER
            $tmp = ($value - $this->iMinimum) * $this->iAxisSizeRange;
            $tmp = $this->inverted ? $this->iStartPos + $tmp : $this->iEndPos - $tmp;
            if ($tmp > self::$MAXPIXELPOS) {
                $tmp = self::$MAXPIXELPOS;
            } else
            if ($tmp < -self::$MAXPIXELPOS) {
                $tmp = -self::$MAXPIXELPOS;
            }
            return (int) $tmp;

//#else  // faster version (no checking)...

//            $tmp = (int) (($value - iMinimum) * iAxisSizeRange);
//            return inverted ? IStartPos + tmp : IEndPos - tmp;

//#endif
        }
    }

    public function calcZPos() {
        $result = $this->isDepthAxis ? $this->chart->getHeight() :
                     $this->chart->getAspect()->getWidth3D();
        return MathUtils::round($result * $this->zPosition * 0.01); // 6.0
    }

    /**
     * Returns the amount in pixels that corresponds to a portion of the axis
     * of size "$value" in axis scales.
     *
     * @param $value double
     * @return $Potrtion of axis in pixels
     */
    public function calcSizeValue($value) {
        if ($value > 0) {
            if ($this->logarithmic) {
                return ($this->iRangelog != 0) ?
                        MathUtils::round(log($value) *
                                         $this->iAxisLogSizeRange) : 0;
            } else {
                return ($this->iRange != 0) ?
                        MathUtils::round($value * $this->iAxisSizeRange) : 0;
            }
        } else {
            return 0;
        }
    }

    private function internalCalcPos($a, $b) {
        return ((($this->horizontal) && ($this->inverted)) ||
                ((!$this->horizontal) && (!$this->inverted))) ? $a : $b;
    }

    /**
     * Returns the corresponding $value of a Screen position.
     *
     * @param $value $Screen $value
     * @return double Position on screen in pixels
     */
    public function calcPosPoint($value) {

        if ($this->logarithmic) {
            if ($value == $this->iStartPos) {
                return $this->internalCalcPos($this->iMaximum, $this->iMinimum);
            } else if ($value == iEndPos) {
                return $this->internalCalcPos($this->iMinimum, $this->iMaximum);
            } else {
                $tmp = $this->iRangelog;
                if ($tmp == 0) {
                    return $this->iMinimum;
                } else {
                    if ($this->inverted) {
                        $tmp = (($this->iEndPos - $value) * $tmp / $this->iAxisSize);
                    } else {
                        $tmp = (($value - $this->iStartPos) * $tmp / $this->iAxisSize);
                    }

                    return MathUtils::exp($this->horizontal ? $this->iLogMin + $tmp :
                                    $this->iLogMax - $tmp);
                }
            }
        } else
        if ($this->iAxisSize > 0) {

            $tmp = $this->inverted ? $this->iEndPos - $value : $value - $this->iStartPos;
            $tmp *= $this->iRange / $this->iAxisSize;
            return $this->horizontal ? $this->iMinimum + $tmp : $this->iMaximum - $tmp;

        } else {
            return 0;
        }
    }

    private function axisRect() {
        $tmpPos1=0;
        $pos1=0;
        $tmpPos2=0;
        $pos2=0;

        if ($this->iStartPos > $this->iEndPos) {
            $tmpPos1 = $this->iEndPos;
            $tmpPos2 = $this->iStartPos;
        } else {
            $tmpPos1 = $this->iStartPos;
            $tmpPos2 = $this->iEndPos;
        }

        if ($this->posAxis > $this->labels->position) {
            $pos1 = $this->labels->position;
            $pos2 = $this->posAxis + self::$AXISCLICKGAP;
        } else {
            $pos1 = $this->posAxis - self::$AXISCLICKGAP;
            $pos2 = $this->labels->position;
        }

        if ($this->horizontal) {
            return Rectangle::fromLTRB($tmpPos1, $pos1, $tmpPos2, $pos2);
        } else {
            return Rectangle::fromLTRB($pos1, $tmpPos1, $pos2, $tmpPos2);
        }
    }

    /**
     * Returns if X and Y coordinates are close to the Axis position.
     *
     * @param xy Po$(X and Y coordinates)
     * @return boolean - X and Y coordinates as integer
     */
/*    public function clicked($xy) {
        return $this->clicked($xy->x, $xy->y);
    }
  */
    /**
     * Returns if X and Y coordinates are close to the Axis position.
     *
     * @param x Pixel location
     * @param y Pixel location
     * @return boolean - true if X and Y coordinates are
     * on or near to Axis
     * @see Axes
     */
    public function clicked($x, $y) {
        return $this->chart->isAxisVisible($this) && $this->axisRect()->contains($x, $y);
    }

    /**
     * Returns the calculated Maximum Horizontal $value for the specified AAxis.
     * <br>
     * AAxis can be Axis.Top or Axis.Bottom. Calculated means that the return
     * $value will be the Maximum $value of the Maximum Series X $values.
     * Only Series with the HorizontalAxis equal to AAxis will be considered.
     *
     * @return double
     * @see Axes
     * @see Axis#getMinX$value
     * @see Axis#getMinY$value
     * @see Axis#getMaxY$value
     */
    public function getMaxXValue() {
        return $this->chart->getMaxXValue($this);
    }

    /**
     * Returns the calculated Maximum Vertical $value for the specified AAxis.
     * <br>
     * AAxis can be Axis.Left or Axis.Right. Calculated means that the return
     * $value will be the Maximum $value of the Maximum Series Y $values. Only
     * Series with the VerticalAxis equal to AAxis will be considered.
     *
     * @return double
     * @see Axes
     * @see Axis#getMinX$value
     * @see Axis#getMaxX$value
     * @see Axis#getMinY$value
     */
    public function getMaxYValue() {
        return $this->chart->getMaxYValue($this);
    }

    /**
     * Returns the calculated Minimum Horizontal $value for the specified AAxis.
     * <br>
     * AAxis can be Axis.Top or Axis.Bottom. Calculated means that the return
     * $value will the Minimum $value of the Minimum Series X $values. Only
     * Series with the HorizontalAxis equal to AAxis will be considered.
     *
     * @return double
     * @see Axes
     * @see Axis#getMaxX$value
     * @see Axis#getMinY$value
     * @see Axis#getMaxY$value
     */
    public function getMinXValue() {
        return $this->chart->getMinXValue($this);
    }

    /**
     * Returns the calculted Minimum Vertical $value for the specified AAxis.
     * <br>
     * AAxis can be Axis.Left or Axis.Right. Calculated means that the return
     * $value will the Minimum $value of the Minimum Series Y $values. Only
     * Series with the VerticalAxis equal to AAxis will be considered.
     *
     * @return double
     * @see Axes
     * @see Axis#getMinX$value
     * @see Axis#getMaxX$value
     * @see Axis#getMaxY$value
     */
    public function getMinYValue() {
        return $this->chart->getMinYValue($this);
    }

    /**
     * Returns either a Time or Date format depending if the astep parameter
     * is lower than one day (time) or greater (date).
     *
     * @param astep double
     * @return DateFormat
     */
    public function dateTimeDefaultFormat($astep) {
        return ($astep <= 1) ?
                "d/m/y" : "d/m/y";
    }

    private function nextStep($oldStep) {
        if ($oldStep >= 10) {
            return 10 * $this->nextStep(0.1 * $oldStep);
        } else if ($oldStep < 1) {
            return 0.1 * $this->nextStep($oldStep * 10);
        } else if ($oldStep < 2) {
            return 2;
        } else if ($oldStep < 5) {
            return 5;
        } else {
            return 10;
        }
    }

    // returns AxisLabelStyle
    private function internalCalcLabelStyle() {
        $tmpResult = AxisLabelStyle::$NONE;

        if ($this->isDepthAxis) {
            $tmpResult = AxisLabelStyle::$TEXT;
            for ($t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                $s = $this->chart->getSeries($t);
                if ($s->getActive()) {
                    if ($s->getHasZValues() ||
                        ($s->getMinZValue() != $s->getMaxZValue())) {
                        return AxisLabelStyle::$VALUE;
                    }
                }
            }
        } else {
            for ($t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                $tmpSeries = $this->chart->getSeries($t);

                if (($tmpSeries->getActive()) &&
                    ($tmpSeries->associatedToAxis($this))) {

                    $tmpResult = AxisLabelStyle::$VALUE;
                    if ((($this->horizontal) && ($tmpSeries->getYMandatory())) ||
                        ((!$this->horizontal) && (!$tmpSeries->getYMandatory()))) {
                        if (($tmpSeries->getLabels() != null) &&
                            (strlen($tmpSeries->getLabels[0]) != 0)) {
                            return AxisLabelStyle::$TEXT;
                        }
                    }
                }
            }
        }
        return $tmpResult;
    }

    private function internalCalcLabelsIncrement($maxNumLabels) {

        if ($this->desiredIncrement <= 0) {
            if ($this->iRange == 0) {
                $tmpResult = 1;
            } else {
                $tmpResult = abs($this->iRange) / ($maxNumLabels + 1);
                if ($this->anySeriesHasLessThan($maxNumLabels)) {
                    $tmpResult = max(1, $tmpResult);
                }
            }
        } else {
            $tmpResult = $this->desiredIncrement;
        }

        $tempNumLabels = $maxNumLabels + 1;

        $inf = false;

        if (is_Infinite($this->iRange)) {
            return 1;
        }

        if ($this->labels->getSeparation() >= 0) {

            do {
                $tmp = $this->iRange / $tmpResult;
                if (abs($tmp) < intval('1000000000000')) {   // Int MAX_VALUE
                    $tempNumLabels = (MathUtils::round($tmp));
                    if ($tempNumLabels > $maxNumLabels) {
                        $tmpResult = $this->nextStep($tmpResult);
                    }
                } else {
                    $tmpResult = $this->nextStep($tmpResult);
                }
                $inf = is_Infinite($tmpResult);

            } while (($tempNumLabels > $maxNumLabels) &&
                     ($tmpResult <= $this->iRange) && (!$inf));
        }
        return $inf ? $this->iRange : max($tmpResult, $this->iMinAxisIncrement);
    }

    static private function nextDateTimeStep($aStep) {
        $tmpDateTimeStep = new DateTimeStep();

        for ($t = DateTimeStep::$ONEYEAR - 1;
             $t >= DateTimeStep::$ONEMILLISECOND; $t--) {
            if ($aStep >= ($tmpDateTimeStep->STEP[$t])) {
                return $tmpDateTimeStep->STEP[$t + 1];
            }
        }
        return $tmpDateTimeStep->STEP[DateTimeStep::$ONEYEAR];
    }


    private function calcDateTimeIncrement($maxNumLabels) {

        $tmpDateTimeStep = new DateTimeStep();
        $tmpResult = max($this->desiredIncrement,
                                    $tmpDateTimeStep->STEP[
                                    DateTimeStep::$ONEMILLISECOND]);

        if (($tmpResult > 0) && ($maxNumLabels > 0)) {
            if (($this->iRange / $tmpResult) > 1000000) {
                $tmpResult = $this->iRange / 1000000;
            }

            do {
                $tempNumLabels = MathUtils::round($this->iRange / $tmpResult);
                if ($tempNumLabels > $maxNumLabels) {
                    if ($tmpResult < $tmpDateTimeStep->STEP[
                        DateTimeStep::$ONEYEAR]) {
                        $tmpResult = self::nextDateTimeStep($tmpResult);
                    } else {
                        $tmpResult *= 2;
                    }
                }
            } while ($tempNumLabels > $maxNumLabels);
        }

        return max($tmpResult, $tmpDateTimeStep->STEP[DateTimeStep::$ONEMILLISECOND]);
    }

    private function anySeriesHasLessThan($num) {
        $result = false;
        for ($t = 0; $t < $this->chart->getSeriesCount(); $t++) {
            $s = $this->chart->getSeries($t);
            if ($s->getActive()) {
                if (($s->getYMandatory() && $this->getHorizontal()) ||
                    ((!$s->getYMandatory()) && (!$this->getHorizontal()))) {
                    if ($s->associatedToAxis($this)) {
                        $result = $s->getCount() <= $num;
                        if ($result) {
                            break;
                        }
                    }
                }
            }
        }
        return $result;
    }

    private function calcLabelsIncrement($maxNumLabels) {

    if ($maxNumLabels > 0) {
            if ($this->iAxisDateTime) {
                $tmpResult = $this->calcDateTimeIncrement($maxNumLabels);
            } else {
                $tmpResult = $this->internalCalcLabelsIncrement($maxNumLabels);
            }
        } else {
            if ($this->iAxisDateTime) {
                $tmpDateTimeStep = new DateTimeStep();
                $tmpResult = $tmpDateTimeStep->STEP[DateTimeStep::$ONEMILLISECOND];
            } else {
                $tmpResult = $this->iMinAxisIncrement;
            }
        }
        return $tmpResult;
    }

    /**
     * Returns the calculated Axis Label increment.
     *
     * @param maxLabelSize $The maximum allowable LabelSize in pixels.
     * @return double Size of increment in Axis units.
     */
    public function calcXYIncrement($maxLabelSize) {
        if ($maxLabelSize > 0) {
            if ($this->labels->getSeparation() > 0) {
                $maxLabelSize = ($maxLabelSize +
                                      MathUtils::round(0.01 *
                                                 $this->labels->getSeparation() *
                                                 $maxLabelSize));
            }
            $tmp = (MathUtils::round((1.0 * $this->iAxisSize) /
                                    $maxLabelSize));
        } else {
            $tmp = 1;
        }
        return $this->calcLabelsIncrement($tmp);
    }

    /**
     * Returns the calculated Axis Label increment and serves as a useable
     * measure when Labelling is set to manual or automatic increments.<br>
     * Please note that the related Increment property only returns the
     * increment $value when those increments are manually set via the same
     * property.
     *
     * @return double calculated Axis Label increment.
     */
    public function getCalcIncrement() {

        if ($this->horizontal) {
            $tmp = max($this->labels->labelWidth($this->iMinimum),
                           $this->labels->labelWidth($this->iMaximum));
        } else {
            $tmp = max($this->labels->labelHeight($this->iMinimum),
                           $this->labels->labelHeight($this->iMaximum));
        }

        $result=$this->calcXYIncrement($tmp);

        if ($this->labels->getAlternate())
            if ($this->getLogarithmic())
                $result=$result/$this->logarithmicBase;
            else
                $result=$result/2;

        return $result;
    }

    /**
     *
     *
     * @return int
     */
    public function getSizeTickAxis() {
        $tmpResult = 0;
        if ($this->getVisible()) {
            $tmpResult = $this->axispen->getWidth() + 1;
        }

        if ($this->getTicks()->getVisible()) {
            $tmpResult += $this->ticks->length;
        }
        if ($this->getMinorTicks()->getVisible()) {
            $tmpResult = max($tmpResult, $this->minorTicks->length);
        }
        return $tmpResult;
    }

    function getRectangleEdge($r) {
        if ($this->otherSide) {
            return $this->horizontal ? $r->y : $r->getRight();
        } else {
            return $this->horizontal ? $r->getBottom() : $r->x;
        }
    }

    private function inflateAxisRect($value, $r) {
        $tmpL = $r->x;
        $tmpT = $r->y;
        $tmpR = $r->getRight();
        $tmpB = $r->getBottom();
        if ($this->horizontal) {
            if ($this->otherSide) {
                $tmpT += $value;
            } else {
                $tmpB -= $value;
            }
        } else
        if ($this->otherSide) {
            $tmpR -= $value;
        } else {
            $tmpL += $value;
        }

        $r->x = $tmpL;
        $r->y = $tmpT;
        $r->width = $tmpR - $tmpL;
        $r->height = $tmpB - $tmpT;
        return $r;
    }

    private function inflateAxisPos($value, $amount) {
        $tmpResult = $value;
        if ($this->horizontal) {
            if ($this->otherSide) {
                $tmpResult -= $amount;
            } else {
                $tmpResult += $amount;
            }
        } else {
            if ($this->otherSide) {
                $tmpResult += $amount;
            } else {
                $tmpResult -= $amount;
            }
        }
        return $tmpResult;
    }

    // returns CalcLabelsResults
    private function calcLabelsRect($tmpSize, $r) {
        $result = new CalcLabelsResults();
        $result->rect = $this->inflateAxisRect($tmpSize, $r);
        $result->position = $this->getRectangleEdge($result->rect);
        return $result;
    }

    /**
     * Used internally by Chart when creating Axes
     *
     * @param r Chart Rectangle
     * @param inflateChartRectangle boolean Wall allowance (standard Axes only)
     * @return Rectangle
     */
    public function calcRect($r, $inflateChartRectangle) {
        $this->iAxisDateTime = $this->isDateTime();

        if ($inflateChartRectangle) {
            // new? todo  CalcLabelsResults tmpRes;

            if ($this->isDepthAxis) {
                if ($this->otherSide) {
                    $this->posTitle = $r->getRight();
                } else {
                    $this->posTitle = $r->getLeft();
                }
            } else {
                if (($this->axisTitle != null) && $this->axisTitle->getVisible() &&
                    (strlen($this->axisTitle->getCaption()) != 0)) {

                    $tmpRes = $this->calcLabelsRect($this->internalCalcSize(
                            $this->axisTitle->getFont(), $this->axisTitle->getAngle(),
                            $this->axisTitle->getCaption(), $this->axisTitle->getCustomSize()),
                                            $r);

                    $this->posTitle = $tmpRes->position;
                }
            }

            if ($this->labels->getVisible()) {
                $tmpRes = $this->calcLabelsRect($this->getSizeLabels()+10, $r);  // Rev aded +10
                $this->labels->position = $tmpRes->position;
            }


            $tmp = $this->getSizeTickAxis() + $this->chart->getWalls()->calcWallSize($this);
            if ($tmp > 0) {
                $r = $this->inflateAxisRect($tmp, $r);
            }
            $this->posTitle = $this->applyPosition($this->posTitle, $r);
            $this->labels->position = $this->applyPosition($this->labels->position, $r);
        } else {
            $this->posAxis = $this->applyPosition($this->getRectangleEdge($r), $r);
            $this->labels->position = $this->inflateAxisPos($this->posAxis, $this->getSizeTickAxis());
            $this->posTitle = $this->inflateAxisPos($this->labels->position, $this->getSizeLabels());
        }

        return $r;
    }

    function applyPosition($apos, $r) {

        if ($this->relativePosition != 0) {
            if ($this->positionUnits == PositionUnits::$PERCENT) {
                $tmpsize = $this->horizontal ? $r->height : $r->width;
                $tmpsize = MathUtils::round(0.01 * $this->relativePosition *
                                           $tmpsize);
            } else {
                $tmpsize = MathUtils::round($this->relativePosition); // pixels
            }

            if ($this->otherSide) {
                $tmpsize = -$tmpsize;
            }
            if ($this->horizontal) {
                $tmpsize = -$tmpsize;
            }

            return $apos + $tmpsize;
        } else {
            return $apos;
        }
    }

    /**
     * Used internally to return Axis Datetime step.
     *
     * @param step$value double Desired increment
     * @return int
     */
    static public function findDateTimeStep($stepValue) {
        $tmpDateTimeStep = new DateTimeStep();
        for ($t = DateTimeStep::$ONEYEAR - 1;
                     $t >= DateTimeStep::$ONEMILLISECOND; $t--) {
            if ((abs($tmpDateTimeStep->STEP[$t] - $stepValue)) <
                ($tmpDateTimeStep->STEP[DateTimeStep::$ONEMILLISECOND])) {
                return $t;
            }
        }
        return DateTimeStep::$NONE;
    }

    // returns String
    private function drawExponentLabel($x, $y, $tmpZ, $tmpSt2) {
        $g = $this->chart->getGraphics3D();
        $i = $tmpSt2->toUpperCase()->indexOf('E');
        if ($i == -1) {
            $g->textOut($x, $y, $tmpZ, $tmpSt2);
        } else {
            //CDI TTrack //#1525
            $tmp = "";
            $tmpSub = "";
            if (($i - 1) < 0) {
                $tmp = substr($tmpSt2, 0, 1);
                $tmpSub = $tmpSt2[1];
            } else {
                $tmp = substr($tmpSt2, 0, $i - 1);
                $tmpSub = $tmpSt2[$i + 1];
            }

            $font = $g->getFont();
            $oldSize = $font->getSize();
            $tmpH = $oldSize - 1;

            if (in_array(StringAlignment::$NEAR,$g->getTextAlign())) {
                $g->textOut($x, $y, $tmpZ, $tmp);
                $tmpW = $g->textWidth($tmp) + 1;
                $font->setSize($font->getSize() - ($oldSize * 0.25));
                $g->textOut( ($x + $tmpW),
                           ($y - ($tmpH * 0.5)) + 2, $tmpZ,
                          $tmpSub);
                $font->setSize($oldSize);
            } else {
                $font->setSize($font->getSize() -
                                     ($oldSize * 0.25));
                $g->textOut($x, $y - ($tmpH * 0.5) + 2, $tmpZ,
                          $tmpSub);
                $tmpW = $g->textWidth($tmpSub) + 1;
                $font->setSize($oldSize);
                $g->textOut(($x - $tmpW), $y, $tmpZ, $tmp);
            }
        }
        return $tmpSt2;
    }

    static private function numTextLines($st) {
        $i = strpos($st,"\n");

        if ($i === FALSE) {
            return 1;
        } else {
            $tmpResult = 0;
            while ($i !==FALSE) {
                $tmpResult++;
                $st = substr($st,$i + 1);
                $i = strpos($st,"\n");
            }
            if (strlen($st) != 0) {
                $tmpResult++;
            }
            return $tmpResult;
        }
    }

    /**
     * Draws Axis Label (String) at specified X,Y co-ordinate at Angle.
     *
     * @param x $x coordinate
     * @param y $y coordinate
     * @param angle $Angle at which Label is drawn
     * @param st String asociated to Label
     * @param labelItem TextShape
     */
    public function _drawAxisLabel($x, $y, $angle, $st, $labelItem) {
        $this->drawAxisLabel($this->labels->getFont(), $x, $y, $angle, $st, $labelItem);
    }

    /**
     * Draws Axis Label (String) in font f at specified X,Y co-ordinate at
     * Angle.
     *
     * @param f ChartFont
     * @param x $x coordinate
     * @param y $y coordinate
     * @param angle $Angle at which Label is drawn
     * @param st String asociated to Label
     * @param format TextShape
     */
    public function drawAxisLabel($f, $x, $y, $angle, $st, $format) {
        $old_name = TChart::$controlName;
        TChart::$controlName .='AxisLabel';
        
        // TODO
        /*StringAlignment[][] aligns =
                new StringAlignment[][] { {StringAlignment.FAR,
                StringAlignment.NEAR}, {StringAlignment.CENTER,
                StringAlignment.CENTER}
        };

        StringAlignment tmpAlign, tmpAlign2;
        */
        $g = $this->chart->getGraphics3D();

        $oldStrAlign = $g->getTextAlign();

        if ($format == null) {
            $format = $this->getLabels();
        } else {
            $f = $format->getFont();
        }

        $g->setFont($f);

        $tmpFontH = $g->getFontHeight();

        $tmpH = $tmpFontH / 2;

        $intHorizontal = $this->horizontal ? 1 : 0;
        $intOtherSide = $this->otherSide ? 1 : 0;
        $notIntOtherSide = $this->otherSide ? 0 : 1;

        $tmpZ = $this->iZPos;

        $n = self::numTextLines($st);
        $delta = $tmpFontH;
        $textWidth = $g->textWidth($st);

        if ($this->horizontal && $this->otherSide) {
            if (($angle > 90) && ($angle <= 180)) {
//                $y += $delta; //1st line
                $y += ($delta * ($n) / 2);
                $x += ($textWidth);
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            } else if (($angle > 0) && ($angle < 90)) {
                $x -= ($delta * ($n) / 2);
                $x -= (($delta) / 2);
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_BOTTOM_ALIGN);
                } else {
                    $y -= $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                StringAlignment::$VERTICAL_TOP_ALIGN);
                }
            } else if ($angle == 90) {
                $x -= ($delta * ($n) / 2);
                $x -= (($delta /2)/2);
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $tmpAlign = array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_BOTTOM_ALIGN);
                } else {
                    $y -= $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                StringAlignment::$VERTICAL_TOP_ALIGN);
                }
            } else if (($angle > 180) && ($angle <= 270)) {
                $x = $x + $delta + ($delta * ($n) / 2);
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_TOP_ALIGN);
                } else {
                    $y -= $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_BOTTOM_ALIGN);
                }
            } else {
                $y -= $delta * ($n + 1);
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            }
        } else if ($this->horizontal) {
            if (($angle > 90) && ($angle <= 180)) {
                $y += $delta; //1st line
                $x += ($textWidth);
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            } else if (($angle > 0) && ($angle < 90)) {
                $x -= ($delta * ($n) / 2);
                $x -= ($delta);
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $y += $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                } else {
                    //$y += $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_BOTTOM_ALIGN);
                }
            } else if ($angle == 90) {
                $x -= ($delta * ($n) / 2);
                $x -= (($delta /2)/2);
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $mlv = $this->maxLabelsWidth();
                    $y += $mlv + (0.10 * $mlv);
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_BOTTOM_ALIGN);
                } else {
                    // $y -= $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_TOP_ALIGN);
                }
            } else if (($angle > 180) && ($angle <= 270)) {
                $x += $delta + ($delta * ($n) / 2);
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_TOP_ALIGN);
                } else {
                    $y += $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_BOTTOM_ALIGN);
                }
            } else {
                $y -= ($delta);
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            }
        } else if ($this->otherSide) {
            if ((($angle > 270) && ($angle <= 360)) || ($angle == 0)) {
                $y -= $delta; //1st line
                $y -= ($delta * ($n)) / 2;
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_LEFT_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                } else {
                    $x += $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_RIGHT_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                }
            } else if (($angle > 90) && ($angle <= 180)) {
                $y += 100+$delta; //1st line
                $y += ($delta * ($n)) / 2;
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_RIGHT_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                } else {
                    $x += $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_LEFT_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                }
            } else if (($angle > 0) && ($angle <= 90)) {
                $x -= ($delta / 2);
                $y += ($delta * ($n)) / 2;
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            } else {
                $x += $delta * ($n + 1);
                $y -= ($textWidth / 2);
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            }
        } else {
            if ((($angle > 270) && ($angle <= 360)) || ($angle == 0)) {
                $y -= $delta; //1st line
                $y -= ($delta * ($n)) / 2;
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $x -= 2;
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_RIGHT_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                } else {
                    $x -= $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_LEFT_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                }
            } else if (($angle > 90) && ($angle <= 180)) {
                $y += $delta; //1st line
                $y += ($delta * ($n)) / 2;
                if ($this->getLabels()->getAlign() == AxisLabelAlign::$DEF) {
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                } else {
                    $x -= $this->maxLabelsWidth();
                    $tmpAlign = Array(StringAlignment::$HORIZONTAL_RIGHT_ALIGN,
                                      StringAlignment::$VERTICAL_CENTER_ALIGN);
                }
            } else if (($angle > 0) && ($angle < 90)) {
                $x -= $delta * ($n+1);
                $x += (($delta/2)/2);
                $y += ($textWidth / 2);
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_RIGHT_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            } else if ($angle==90) {
                $x -= $delta * ($n+1) ;
                $y += ($textWidth / 2) + 2;
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_RIGHT_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            } else {
                $x += $delta;
                $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,
                                  StringAlignment::$VERTICAL_CENTER_ALIGN);
            }
        }

        if (!$format->getTransparent()) {
            $tmpSize = $g->textWidth("W") / 4; //4 instead 2 so the margin don't be so high

            $format->setLeft($x);
            $format->setTop($y + $delta);

            $tmp = $this->chart->multiLineTextWidth($st);
            $tmpW = $tmp->width;
            $tmpNum = $tmp->count;

            $tmpH = $tmpFontH * $tmpNum;

            $tmpAlign2 = $tmpAlign;

            $format->setBottom($format->getTop() + $tmpH);
            $format->setRight($format->getLeft() + $tmpW);

            if (in_array(StringAlignment::$FAR,$tmpAlign2)) {
                $tmpW = ($format->getRight() - $format->getLeft());
                $format->setLeft($format->getLeft() - $tmpW);
                $format->setRight($format->getLeft() + $tmpW);

            } else if (in_array(StringAlignment::$CENTER,$tmpAlign2)) {
                $tmpW = ($format->getRight() - $format->getLeft()) / 2;
                $format->setLeft($format->getLeft() - $tmpW);
                $format->setRight($format->getRight() + $tmpW);
            }

            $format->setLeft($format->getLeft() - $tmpSize);
            $format.setRight($format->getRight() + $tmpSize);

            if ($tmpZ != 0) {
                $format->setShapeBounds($g->calcRect3D($format->getShapeBounds(),
                        $tmpZ));
            }

            $format->drawRectRotated($g, $format->getShapeBounds(),
                                   $this->getLabels()->getAngle(), $tmpZ);

            $g->getBrush()->setVisible(false);
        }

        $g->setTextAlign($tmpAlign);

        $tmpD = $delta * $n;

        $tmpSt = $st;
        $tmpSt2 = "";
        $is3D = $this->chart->getAspect()->getView3D();
        
        ++$this->labelIndex;

        for ($tt = 1; $tt <= $n; $tt++) {
            $i = strpos($tmpSt,"\n");
            $tmpSt2 = ($i != FALSE) ? substr($tmpSt,0, $i) : $tmpSt;

            if ($angle == 0) {
                $y += $delta;
                $g->setFont($f);
                if ($this->labels->getExponent()) {
                    $tmpSt2 = $this->drawExponentLabel($x, $y, $tmpZ, $tmpSt2);
                } else {
                  if ($is3D) {
                    $g->textOut($x, $y, $tmpZ, $tmpSt2);
                  }
                  else {
                    $g->textOut($x, $y, 0, $tmpSt2);
                  }
                }
            } else {
                if (($angle >= 0) && ($angle <= 90)) {
                    $x += $delta;
                } else if (($angle > 90) && ($angle <= 180)) {
                    $y -= $delta;
                } else if (($angle > 180) && ($angle <= 270)) {
                    $x -= $delta;
                } else if (($angle > 270) && ($angle < 360)) {
                    $y += $delta;
                }
                $g->rotateLabel($x, $y, $tmpZ, $tmpSt2, $angle);
            }

            if ($i >= 0) {
                $tmpSt = substr($tmpSt,$i + 1);
            }
        }

        $g->setTextAlign($oldStrAlign);
        TChart::$controlName=$old_name;
    }

    protected function getDepthAxisAlign() {
        if ($this->otherSide) {
            return StringAlignment::$NEAR;
        } else {
            return StringAlignment::$FAR;
        }
    }

    private function getDepthAxisPos() {
        if ($this->otherSide) {
            return $this->chart->getChartRect()->getBottom()->calcZPos();
        } else {
            return $this->chart->getChartRect()->getTop()+$this->calcZPos();
        }
    }

    /**
     * TeeChart internal use. Outputs the title during the chart painting
     * procedure.
     *
     * @param x $x coordinate
     * @param y $y coordinate
     */
    public function drawTitle($x, $y) {
        $old_name = TChart::$controlName;
        
        TChart::$controlName .='Axis_Title_';           
        
        if ($this->isDepthAxis) {
            $g = $this->chart->getGraphics3D();
            $g->setTextAlign($this->getDepthAxisAlign());
            $g->setFont($this->axisTitle->getFont());
            $g->textOut($x, $y, $this->chart->getAspect()->getWidth3D() / 2,
                      $this->axisTitle->getCaption());
        } else {
            $old = $this->labels->getExponent();
            $this->labels->setExponent(false);
            $this->drawAxisLabel($this->axisTitle->getFont(), $x, $y, $this->axisTitle->getAngle(),
                          $this->axisTitle->getCaption(), null);
            $this->labels->setExponent($old);
        }
        
        TChart::$controlName=$old_name;
    }

    private function _decMonths($howMany, $date) {
        return $this->decMonths($howMany, $date->day, $date->month, $date->year);
    }

    private function decMonths($howMany, $day, $month, $year) {
        $day = 1;
        if ($month > $howMany) {
            $month -= $howMany;
        } else {
            $year--;
            $month = 12 - ($howMany - $month);
        }
        return new DateParts($year, $month, $day);
    }

    private function /*DateParts*/ _incMonths($howMany, /*DateParts*/ $date) {
        return $this->incMonths($howMany, $date->year, $date->month, $date->day);
    }

    private function /*DateParts*/ incMonths($howMany, $day, $month, $year) {
        $day = 1;
        $month += $howMany;
        if ($month > 12) {
            $year++;
            $month -= 12;
        }
        return new DateParts($year, $month, $day);
    }

    /*protected*/ public function incDecDateTime($increment,
                                    $value,
                                    $anIncrement,
                                    $tmpWhichDatetime) {
        return $this->dateTimeIncrement($this->labels->getExactDateTime() &&
                                 $this->iAxisDateTime &&
                                 ($tmpWhichDatetime >= DateTimeStep::$HALFMONTH),
                                 $increment, $value, $anIncrement,
                                 $tmpWhichDatetime);
    }

    private function incDecMonths($howMany, /*DateParts*/ $date, $increment) {
        if ($increment) {
            $this->incMonths($howMany, $date);
        } else {
            $this->decMonths($howMany, $date);
        }
    }

    /**
     * Is a set of constants used to specify a date time increment.
     *
     * @param isDateTime boolean
     * @param increment boolean
     * @param $value double
     * @param anIncrement double
     * @param tmpWhichDatetime int
     * @return double date time increment $value
     */
    public function dateTimeIncrement($isDateTime, $increment, $value,
                                    $anIncrement, $tmpWhichDatetime) {

        if ($isDateTime) {
            // TODO get the format from ... ??
            $tmpArrayDateTime=date('Y-m-d',$value);

            $d = new DateParts(date("Y", $value),
                                date("m", $value),
                                date("d", $value));

            switch ($tmpWhichDatetime) {
            case DateTimeStep::$HALFMONTH:
                if ($d->day > 15) {
                    $d->day = 15;
                } else if ($d->day > 1) {
                    $d->day = 1;
                } else {
                    $this->incDecMonths(1, $d, $increment);
                    $d->day = 15;
                }
                break;
            case DateTimeStep::$ONEMONTH:
                $this->incDecMonths(1, $d, $increment);
                break;
            case DateTimeStep::$TWOMONTHS:
                $this->incDecMonths(2, $d, $increment);
                break;
            case DateTimeStep::$THREEMONTHS:
                $this->incDecMonths(3, $d, $increment);
                break;
            case DateTimeStep::$FOURMONTHS:
                $this->incDecMonths(4, $d, $increment);
                break;
            case DateTimeStep::$SIXMONTHS:
                $this->incDecMonths(6, $d, $increment);
                break;
            case DateTimeStep::$ONEYEAR:
                if ($increment) {
                    $d->year++;
                } else {
                    $d->year--;
                }

                break;
            default:
                if ($increment) {
                    $value += $anIncrement;
                } else {
                    $value -= $anIncrement;
                }
                return $value;
            }
            (Double) $value = $d;
        } else {
            $value += $increment ? $anIncrement : -$anIncrement;
        }

        return $value;
    }

    /**
     * Returns the most logical Axis Label style.<br>
     * It calculates the "best candidate" label style based on how many Active
     * Series are in the Chart and if the Series has po$labels. The
     * LabelStyle property must be set to talAuto for this function to work.<br>
     * If LabelStyle is not talAuto, the LabelStyle property $value is returned.
     *
     * @return AxisLabelStyle
     */
    public function calcLabelStyle() {
        return ($this->getLabels()->iStyle == AxisLabelStyle::$AUTO) ?
                $this->internalCalcLabelStyle() : $this->labels->iStyle;
    }

    public function _draw($g, $calcPosAxis) {
        $old = $this->chart->getGraphics3D();
        $this->chart->setGraphics3D($g);
        $this->draw($calcPosAxis);
        $this->chart->setGraphics3D($old);
    }

    /**
     * Displays an Axis at the specified screen positions with the current
     * axis scales.<br>
     * Normally you do not need to call the Draw method directly.
     *
     * @param calcPosAxis boolean True if space allowance for Axis Labelling
     * required
     */
    public function draw($calcPosAxis) {
        if ($this->axisDraw==null) {
            $this->axisDraw = new AxisDraw($this);
        }

        $this->axisDraw->draw($calcPosAxis);
    }

    private function reCalcSizeCenter() {
        $this->iAxisSize = $this->iEndPos - $this->iStartPos;
        $this->iCenterPos = ($this->iStartPos + $this->iEndPos) / 2;
        $this->internalCalcRange();
    }

    private function doCalculation($aStartPos, $aSize) {
        $this->iStartPos = $aStartPos +
                    MathUtils::round(0.01 * $aSize * $this->startPosition);
        $this->iEndPos = $aStartPos +
                  MathUtils::round(0.01 * $aSize * $this->endPosition);
    }

    /*protected*/ public function internalCalcPositions() {
        if ($this->isDepthAxis) {
            $this->doCalculation(0, $this->chart->getAspect()->getWidth3D());
        } else {
            $r = $this->chart->getChartRect();
            if ($this->horizontal) {
                $this->doCalculation($r->x, $this->chart->getChartRect()->width);
            } else {
                $this->doCalculation($r->y, $this->chart->getChartRect()->height);
            }
        }
        $this->reCalcSizeCenter();
    }

    /**
     * Displays an Axis at the specified screen positions with the current
     * axis scales.<br>
     * Main drawing method. Custom draw methods can be overloads.
     *
     * @param posLabels int
     * @param posTitle int
     * @param posAxis int
     * @param gridVisible boolean
     */
    public function __draw($posLabels, $posTitle, $posAxis,
                     $gridVisible) {
        $this->internalCalcPositions();
        $this->___draw($posLabels, $posTitle, $posAxis, $gridVisible, $this->iStartPos, $this->iEndPos);
    }

    /**
     * Displays an Axis at the specified screen positions with the current
     * axis scales.<br>
     * Main drawing method. Custom draw methods can be overloads.
     *
     * @param posLabels int
     * @param posTitle int
     * @param posAxis int
     * @param gridVisible boolean
     * @param aStartPos int
     * @param aEndPos int
     */
    public function ___draw($posLabels, $posTitle, $posAxis,
                     $gridVisible, $aStartPos,
                     $aEndPos) {
        $this->getLabels()->position = $posLabels;
        $this->posTitle = $posTitle;
        $this->posAxis = $posAxis;
        $this->iStartPos = $aStartPos;
        $this->iEndPos = $aEndPos;
        $this->reCalcSizeCenter();

        $oldgridvisible = $this->getGrid()->getVisible();
        $this->grid->setVisible($gridVisible);
        $this->draw(false);
        $this->grid->setVisible($oldgridvisible);
    }

    /**
     * Scrolls or displaces the Axis Maximum and Minimum $values by the Offset
     * parameter.<br>
     * If you want to scroll the Axis outside Series limits,
     * CheckLimits must be false.
     *
     * @param offset double
     * @param checkLimits boolean
     */
    public function scroll($offset, $checkLimits) {
        if ((!$checkLimits) ||
            ((($offset > 0) &&
              ($this->maximumvalue < $this->chart->internalMinMax($this, false,
                $this->getHorizontal()))) ||
             (($offset < 0) &&
              ($this->minimumvalue >
               $this->chart->internalMinMax(this, true, $this->getHorizontal()))))
                ) {
            $this->automatic = false;
            $this->automaticMaximum = false;
            $this->maximumvalue += $offset;
            $this->automaticMinimum = false;
            $this->minimumvalue += $offset;
            $this->invalidate();
        }
    }

    /**
     * Changes the current Axis Minimum and Maximum scales.<br>
     * Axis.Automatic must be set to false.
     *
     * @param minDate DateTime Axis Minimum scale
     * @param maxDate DateTime Axis Maximum scale
     */
    public function setMinMaxDate($minDate, $maxDate) {
        $this->setMinMax($minDate->toDouble(), $maxDate->toDouble());
    }

    /**
     * Changes the current Axis Minimum and Maximum scales.<br>
     * Axis.Automatic must be set to false.
     *
     * @param min double Axis Minimum scale
     * @param max double Axis Maximum scale
     */
    public function setMinMax($min, $max) {
        $this->automatic = false;
        $this->automaticMinimum = false;
        $this->automaticMaximum = false;

        if ($min > $max) { // swap
            $tmp = $min;
            $min = $max;
            $max = $tmp;
        }

        $this->internalSetMinimum($min);
        $this->internalSetMaximum($max);
        if (($this->maximumvalue - $this->minimumvalue) < self::$MINAXISRANGE) {
            $this->internalSetMaximum($this->minimumvalue + self::$MINAXISRANGE);
        }
    }

    public function setChart($c) {
        parent::setChart($c);

        $this->labels->setChart($this->chart);
        $this->labels->axis=$this;

        if ($this->axisDraw!=null) {
            $this->axisDraw->setChart($this->chart);
        }
    }

    private function setInternals() {
        $this->iMaximum = $this->maximumvalue;
        $this->iMinimum = $this->minimumvalue;
        $this->internalCalcRange();
    }

    /**
     * Displays an Axis at the specified screen positions with the current
     * axis scales.<br>
     * Main drawing method. Custom draw methods can be overloads.
     *
     * @param posLabels int
     * @param posTitle int
     * @param posAxis int
     * @param gridVisible boolean
     * @param aMinimum double
     * @param aMaximum double
     * @param aStartPosition int
     * @param aEndPosition int
     */
    public function ____draw($posLabels, $posTitle, $posAxis,
                     $gridVisible, $aMinimum,
                     $aMaximum,
                     $aStartPosition, $aEndPosition) {
        $this->_____draw($posLabels, $posTitle,
             $posAxis, $gridVisible,
             $aMinimum, $aMaximum,
             $this->desiredIncrement,
             $aStartPosition, $aEndPosition);
    }

    /**
     * Displays an Axis at the specified screen positions with the current
     * axis scales.<br>
     * Main drawing method. Custom draw methods can be overloads.
     *
     * @param posLabels int
     * @param posTitle int
     * @param posAxis int
     * @param gridVisible boolean
     * @param aMinimum double
     * @param aMaximum double
     * @param aIncrement double
     * @param aStartPos int
     * @param aEndPos int
     */
    public function _____draw($posLabels, $posTitle,
                     $posAxis, $gridVisible,
                     $aMinimum,
                     $aMaximum,
                     $aIncrement, $aStartPos, $aEndPos) {
        $oldMin = $this->minimumvalue;
        $oldMax = $this->maximumvalue;
        $oldIncrement = $this->desiredIncrement;
        $oldAutomatic = $this->automatic;
        $this->automatic = false;
        $this->minimumvalue = $aMinimum;
        $this->maximumvalue = $aMaximum;
        $this->desiredIncrement = $aIncrement;
        $this->setInternals();
        $this->___draw($posLabels, $posTitle, $posAxis, $gridVisible, $aStartPos,
             $aEndPos);
        $this->minimumvalue = $oldMin;
        $this->maximumvalue = $oldMax;
        $this->desiredIncrement = $oldIncrement;
        $this->automatic = $oldAutomatic;
        $this->setInternals();
    }
}

/** 
 * Description: CalcLabelsResults Class 
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
/**
 * CalcLabelsResults Class
 *
 * Description: 
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
class CalcLabelsResults {
    public $position;
    public $rect;

    public function __construct() {
    }
}

/** 
 * Description: DateParts Class 
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
/**
 * DateParts Class
 *
 * Description: 
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
final class DateParts {
    private $year;
    private $month;
    private $day;

    public function __construct($year=0, $month=0, $day=0) {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    public function toDouble() {
       // TODO return (new DateTime($this->year, $this->month, $this->day))->toDouble();
    }
    
    public function __destruct() {        
        unset($this->year);
        unset($this->month);
        unset($this->day);
    }      
}
?>