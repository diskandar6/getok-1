<?php
  /**
 * Description:  This file contains the following class:<br>
 * Functions class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 * Functions class
 *
 * Description: Basic abstract function class.
 * Examples of derived functions are: Add, Subtract, High, Low, Average and
 * Count.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 2013.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
 class Functions extends TeeBase {

    private $periodStyle;
    private $periodAlign;

    protected $dPeriod;
    protected $series;
    protected $updating;
    protected $canUsePeriod;

    public $SingleSource;
    public $HideSourceList;
    public $noSourceRequired; // For "Custom" function


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
        
        $this->initFields();
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->periodStyle);
        unset($this->periodAlign);
        unset($this->dPeriod);
        unset($this->series);
        unset($this->updating);
        unset($this->canUsePeriod);
        unset($this->SingleSource);
        unset($this->HideSourceList);
        unset($this->noSourceRequired);
    }  
    
    private function initFields() {
        $this->canUsePeriod = true;

        $this->periodStyle = PeriodStyle::$NUMPOINTS;
        $this->periodAlign = PeriodAlign::$CENTER;
    }

    protected function readResolve() {
        $this->initFields();
        return $this;
    }

    public function newInstance($f) {
        return $f->newInstance();
    }

    /**
      * Controls how many points or X range will trigger a new point
      * calculation.<br>
      * Zero means all source points.<br>
      * For example, Average function uses the Period property to calculate a
      * new average point each time the "Period" number of points or X range is
      * exceed. <br><br>
      * <b>NOTE:</b> You may switch between number of points or X range by using
      * the Function PeriodStyle property. <br>
      * Default value: 0D
      *
      * @return double
      */
    public function getPeriod() {
        return $this->dPeriod;
    }

    public function setPeriod($value) {
        /** @todo ELIMINATE EXCEPTION HERE ! */
//        if (value < 0) {
//            throw new TeeChartException(Language.getString("FunctionPeriod"));
//        }
        if ($this->dPeriod != $value) {
            $this->dPeriod = $value;
            $this->recalculate();
        }
    }

    /**
      * Returns the Series parent of Function.<br>
      * Run-time and read only. <br>
      * The Series property returns the Series parent of this Function.<br>
      * TChart uses Series to do the actual drawing.
      *
      * @return Series
      */
    public function getSeries() {
        return $this->series;
    }

    public function setSeries($value) {
        if ($this->series != $value) {

            if ($this->series != null)
              $this->series->setFunction(null);
            $this->series = $value;
            if ($value != null)
              $value->setFunction($this);
        }
    }

    /**
      * Controls how the Period property is interpreted.<br>
      * Either as number of points or as range.<br>
      * Range means Period property is specified in a range of values. <br>
      * Being able to define Period as a range can be very useful when using
      * Date-Time series and when you want to express the  Period  of the
      * function in a date-time step like  OneMonth  or  OneDay.<br>
      * So, for example you can now plot the monthly average of sales function
      * just using a normal Average function on a date-time source series and
      * setting the function period to one month :<br>
      * { Place a series1 and fill it with datetime data values at runtime
      * (or from a database) } <br>
      * series2.setFunction( new Average() ); <br>
      * series2.getFunction().setPeriodStyle( Range); series2.getFunction().setPeriod(
      * DateTimeStep[ dtOneMonth ]); series2.setDataSource(series1);<br><br>
      * This will result in several points, each one showing the  average of
      * each month of data in Series1. <br>
      * It's mandatory that points in the source Series1 should be sorted by
      * date when calculating functions on datetime periods. <br><br>
      * The range can also be used for non-datetime series: <br><br>
      * series2.setFunction( new Average() ) ; <br>
      * series2.getFunction().setPeriodStyle(Range); <br>
      * series2.getFunction().setPeriod(100); <br>
      * series2.setDataSource(series1) ; <br>>br>
      * This will calculate an average for each group of points inside every
      * 100 interval. <br><br>
      * (Points with X >=0, X<100 will be used to calculate the first average,
      * points with X >=100, X<200 will be used to calculate the second average
      * and so on... ) <br>
      * Notice this is different than calculating an average for every 100
      * points. <br>
      * Default value: PeriodStyle.NumPoints
      *
      *
      * @return PeriodStyle
      */
    public function getPeriodStyle() {
        return $this->periodStyle;
    }

    public function setPeriodStyle($value) {
        if ($this->periodStyle != $value) {
            $this->periodStyle = $value;
            $this->recalculate();
        }
    }

    /**
      * Controls where to place function calculations inside the full period
      * space.<br>
      * The position of calculation output points within range.<br>
      * When the function Period is greater than zero (so it calculates by
      * groups of points), the function results are added to the series by
      * default at the center position of the Function Period. You can change
      * this by setting PeriodAlign to  <br><br>
      * - First (function result will be added to series at start of each
      * period),  <br>
      * - Center (function result will be added to series at center of each
      * period) <br>
      * - Last (function result will be added to series at end of each period)
      * <br><br>
      * Example <br><br>
      * <code>function1.setPeriodAlign(Center);
      * // <-- by default is centered</code> <br>
      * The  First  and  Last  constants will plot calculations at the start and
      * end  X  coordinates of each  Period .<br>
      * Default value: PeriodAlign.Centre
      *
      *
      * @return PeriodAlign
      */
    public function getPeriodAlign() {
        return $this->periodAlign;
    }

    public function setPeriodAlign($value) {
        if ($this->periodAlign != $value) {
            $this->periodAlign = $value;
            $this->recalculate();
        }
    }

    protected function addFunctionXY($yMandatorySource, $tmpX, $tmpY) {
        if ($yMandatorySource) {
            $this->series->addXY($tmpX, $tmpY);
        } else {
            $this->series->addXY($tmpY, $tmpX);
        }
    }

    // MS : added to allow overrides in curve fitting functions
    protected function calculatePeriod($source, $tmpX, $firstIndex, $lastIndex) {
        $this->addFunctionXY($source->getYMandatory(), $tmpX,
                      $this->calculate($source, $firstIndex, $lastIndex));
    }

    // abstract
    /**
      * Performs function operation on SourceSeries series.<br>
      * First and Last parameters are ValueIndex of first and last point used
      * in calculation. <br>
      * You can override Calculate function to perform customized calculation
      * on one SourceSeries.
      *
      * @param source Series
      * @param first int
      * @param last int
      * @return double
      */
    public function calculate($source, $first, $last) {
        return 0;
    }

    // abstract
    /**
      * Performs function operation on list of series (SourceSeriesList).<br>
      * The ValueIndex parameter defines ValueIndex of point in each Series in
      * list. <br>
      * You can override CalculateMany function to perform customized
      * calculation on list of SourceSeries.
      *
      * @param sourceSeries ArrayList
      * @param valueIndex int
      * @return double
      */
    public function calculateMany($sourceSeries, $valueIndex) {
        return 0;
    }

    // MS : added to allow overrides in curve fitting functions
    protected function calculateAllPoints($source, $notMandatorySource) {
                $tmpY = $this->calculate($source, -1, -1);

                if (!$this->series->getAllowSinglePoint()) {
                        $tmpX = $notMandatorySource->getMinimum();
                        $this->addFunctionXY($source->getYMandatory(), $tmpX, $tmpY);
                        $tmpX = $notMandatorySource->getMaximum();
                        $this->addFunctionXY($source->getYMandatory(), $tmpX, $tmpY);
                } else
                /* centered point */
                if ((!$source->getYMandatory()) && $this->series->getYMandatory()) {
                        $tmpX = $notMandatorySource->getMinimum() +
                                      0.5 * $notMandatorySource->getRange();
                        $this->series->addXY($tmpX, $tmpY);
                } else {
                        $tmpX = $notMandatorySource->getMinimum() +
                                      0.5 * $notMandatorySource->getRange();
                        if ($this->series->getYMandatory()) {
                                $this->addFunctionXY($source->getYMandatory(), $tmpX, $tmpY);
                        } else {
                                $this->series->addXY($tmpY, $tmpX);
                        }
                }
        }

    protected function calculateByPeriod($source, $notMandatorySource) {
         $tmpFirst = 0;
         $tmpCount = $source->getCount();
         $tmpBreakPeriod = $notMandatorySource->value[$tmpFirst];
         $tmpStep = DateTimeStep::find($this->dPeriod);

         do {
            $posLast = 0;
            if ($this->periodStyle == PeriodStyle::$NUMPOINTS) {
                $tmpLast = $tmpFirst + MathUtils::round($this->dPeriod) - 1;
                $posFirst = $notMandatorySource->value[$tmpFirst];

                if ($tmpLast < $tmpCount) {
                    $posLast = $notMandatorySource->value[$tmpLast];
                }
            } else {
                $tmpLast = $tmpFirst;
                $posFirst = $tmpBreakPeriod;

                /** @todo FINISH !! */
//                tmpBreakPeriod = series.horizAxis().IncDecDateTime(true,
//                        tmpBreakPeriod, dPeriod, tmpStep);


                $posLast = $tmpBreakPeriod - ($this->dPeriod * 0.001);

                while ($tmpLast < $tmpCount - 1) {
                    if ($notMandatorySource->value[$tmpLast + 1] < $tmpBreakPeriod) {
                        $tmpLast++;
                    } else {
                        break;
                    }
                }
            }
            $tmpCalc = false;

            if ($tmpLast < $tmpCount) {

                /* align periods */
                if ($this->periodAlign == PeriodAlign::$FIRST) {
                    $tmpX = $posFirst;
                } else
                if ($this->periodAlign == PeriodAlign::$LAST) {
                    $tmpX = $posLast;
                } else {
                    $tmpX = ($posFirst + $posLast) * 0.5;
                }

                if (($this->periodStyle == PeriodStyle::$RANGE) &&
                    ($this->notMandatorySource->value[$tmpFirst] < $tmpBreakPeriod)) {
                    $tmpCalc = true;
                }

                if (($this->periodStyle == PeriodStyle::$NUMPOINTS) || $tmpCalc) {
                    $this->calculatePeriod($source, $tmpX, $tmpFirst, $tmpLast);
                } else {
                    $this->addFunctionXY($source->getYMandatory(), $tmpX, 0);
                }
            }
            if (($this->periodStyle == PeriodStyle::$NUMPOINTS) || $tmpCalc) {
                $tmpFirst = $tmpLast + 1;
            }
        } while ($tmpFirst <= $tmpCount - 1);
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return Language::getString("GalleryFunctions");
    }

    protected function doCalculation($source, $notMandatorySource) {
        if ($this->dPeriod == 0) {
            $this->calculateAllPoints($source, $notMandatorySource);
        } else {
            $this->calculateByPeriod($source, $notMandatorySource);
        }
    }

    protected function valueList($s) {
        $tmp = ($this->series != null) ? $this->series->getMandatory()->getDataMember() : "";
        if (strlen($tmp) == 0) {
            return $s->getMandatory();
        } else {
            return $s->getValueList($tmp);
        }
    }

    private function calculateFunctionMany($source) {

        $s = $source[0];
        $xList = $s->getNotMandatory();

        // Find datasource with bigger number of points... 5.02
        for ( $t = 0; $t < sizeof($source); $t++) {
             $o = $source[$t];
            if (($o != null) && ($o->getCount() > $s->getCount())) {
                $s = $o;
                $xList = $s->getNotMandatory();
            }

            // use source to calculate points...
            if ($xList != null) {
                $tmpList = Array();

                for ( $tt = 0; $tt < sizeof($source); $tt++) {
                    $tmpList[]=$source[$tt];
                }

                for ( $tt = 0; $tt < $s->getCount(); $tt++) {
                    $tmpX = $xList->value[$tt];
                    $tmpY = $this->calculateMany($tmpList, $tt);

                    if (!$s->getYMandatory()) { // $this->swap
                        $tmp = $tmpX;
                        $tmpX = $tmpY;
                        $tmpY = $tmp;
                    }

                    $this->series->addXYText($tmpX, $tmpY, $s->getLabels($tt));
                }
            }
        }
    }

    /**
      * Gets all points from Source series, performs a function operation and
      * stores results in ParentSeries.<br>
      *
      * @param source ArrayList
      */
    public function addPoints($source) {
        if (!$this->updating) { // 5.02
            if ($source != null) {
                if (sizeof($source) > 1) {
                    $this->calculateFunctionMany($source);
                } else {
                    if (sizeof($source) > 0) {
                         $s = $source[0];
                        if ($s->getCount() > 0) {
                            $this->doCalculation($s, $s->getNotMandatory());
                        }
                    }
                }
            }
        }
    }

    private function beginUpdate() {
        $this->updating = true;
    }

    private function endUpdate() {
        if ($this->updating) {
            $this->updating = false;
            $this->recalculate();
        }
    }

    /**
      * Performs a checkDataSource method call on parent Series.<br>
      * Basically, all points in parent Series are recalculated.<br>
      * The recalculating is performed only if internal updating flag is set to
      * false.<br>
      * To make sure updating is set to false, you can call Function
      * endUpdate() method prior to calling Function recalculate.
      */
    public function recalculate() {
        if ((!$this->updating) && ($this->series != null)) {
            $this->series->checkDataSource();
        }
    }

    public function clear(){
        /** Does nothing, used only by Bollinger and Stochastic **/
    }
}
?>