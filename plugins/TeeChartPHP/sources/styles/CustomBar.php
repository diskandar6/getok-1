<?php
 /**
 * Description:  This file contains the following class:<br>
 * CustomBar class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * CustomBar Class
 *
 * Description: Custom Bar Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class CustomBar extends Series {

    //private boolean autoBarSize;
    private $autoMarkPosition = true;
    private $barStyle;
    private $gradientRelative;
    private $depthPercent = 100;
    private $offsetPercent;
    private $sideMargins = true;
    private $stackGroup;
    private $iMaxBarPoints;
    private $groups;
    private $numGroups;
    private $styleResolver;

    protected $iBarBounds;
    protected $iNumBars;
    protected $iOrderPos;
    protected $iPreviousCount;
    protected $barSizePercent = 70;
    protected $conePercent;
    protected $bDark3D = true;
    protected $iMultiBar;
    protected $bUseOrigin = true;
    protected $dOrigin;
    protected $pPen;
    protected $iBarSize;
    protected $customBarSize;
    protected $normalBarColor;

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

        $this->iMultiBar = MultiBars::$SIDE;
        $this->barStyle = BarStyle::$RECTANGLE;
        $this->iBarBounds = new Rectangle();

        $this->groups = array();  // TODO review before int[100];

        parent::__construct($c);
        
        $this->getMarks()->setDefaultVisible(true);
        $this->getMarks()->getCallout()->setDefaultLength(20);
    }
    
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->autoMarkPosition);
        unset($this->barStyle);
        unset($this->gradientRelative);
        unset($this->depthPercent);
        unset($this->offsetPercent);
        unset($this->sideMargins);
        unset($this->stackGroup);
        unset($this->iMaxBarPoints);
        unset($this->groups);
        unset($this->numGroups);
        unset($this->styleResolver);
        unset($this->iBarBounds);
        unset($this->iNumBars);
        unset($this->iOrderPos);
        unset($this->iPreviousCount);
        unset($this->barSizePercent);
        unset($this->conePercent);
        unset($this->bDark3D);
        unset($this->iMultiBar);
        unset($this->bUseOrigin);
        unset($this->dOrigin);
        unset($this->pPen);
        unset($this->iBarSize);
        unset($this->customBarSize);
        unset($this->normalBarColor);    
   }      

    public function setBarStyleResolver($resolver) {
        $this->styleResolver = $resolver;
    }

    public function removeBarStyleResolver() {
        $this->styleResolver = null;
    }

        /**
          * Defines the color Gradient used to fill the Bars.<br>
          * These can be filled with these three colors: StartColor, MidColor,
          * EndColor. You can control the drawing output by setting the Direction
          * method.<br> Use the Visible property to show / hide filling. <br>
          *
          * <p>Example:
          * <pre><font face="Courier" size="4">
          *  $barSeries = new Bar(myChart->getChart());
          *  $barSeries->getMarks()->setVisible(true);
          *  $barSeries->fillSampleValues(6);
          *  $barSeries->setColor(new Color(255,0,0));
          *  $barSeries->setBarStyle(BarStyle::$RECTGRADIENT);
          *  $barSeries->getGradient()->setDirection(GradientDirection::$VERTICAL);
          *  $barSeries->getGradient()->setStartColor(Color.GREEN);
          *  $barSeries->getGradient()->setUseMiddle(false);
          *  $barSeries->getGradient()->setMiddleColor(Color.YELLOW);
          * </font></pre></p>
          *
          * @return Gradient
          */
    public function getGradient() {
        return $this->getBrush()->getGradient();
    }

        /**
          * Calculates Colors based on highest bar when Gradient is Visible.<br>
          * Default value: false
          *
          * @return boolean
          */
    public function getGradientRelative() {
        return $this->gradientRelative;
    }

        /**
          * Calculates Colors based on highest bar when Gradient is Visible.<br>
          * Default value: false
          *
          * @param value boolean
          */
    public function setGradientRelative($value) {
        $this->gradientRelative = $this->setBooleanProperty($this->gradientRelative, $value);
    }

        /**
          * Allows stacking independent Series within the same Chart, in
          * series groups.<br>
          * Default value: 0
          *
          * @return int
          */
    public function getStackGroup() {
        return $this->stackGroup;
    }

        /**
          * Allows stacking independent Series within the same Chart, in
          * series groups.<br>
          * Default value: 0 <br>
          *
          * <p>Example:
          * <pre><font face="Courier" size="4">
          * bar1Series.setStackGroup(0);
          * bar2Series.setStackGroup(1);
          * </font></pre></p>
          *
          * @param value int
          */
    public function setStackGroup($value) {
        $this->stackGroup = $this->setIntegerProperty($this->stackGroup, $value);
    }

    public function setZPositions() {
        parent::setZPositions();

        if ($this->depthPercent != 0) {
             $tmp = (($this->getEndZ() - $this->getStartZ()) * (100 - $this->depthPercent) *
                             0.005);
            $this->setStartZ($this->getStartZ() + $tmp);
            $this->setEndZ($this->getEndZ() - $tmp);
        }
    }

        /**
          * Determines the percent amount of bar size in "z" depth direction.
          * Default value: 100%
          *
          * @return int
          */
    public function getDepthPercent() {
        return $this->depthPercent;
    }

        /**
          * Determines the percent amount of bar size in "z" depth direction.
          * Default value: 100%
          *
          * <p>Example:
          * <pre><font face="Courier" size="4">
          * series.setDepthPercent(50) ; // % of 3D depth
          * </font></pre></p>
          *
          * @param value int
          */
    public function setDepthPercent($value) {
        $this->depthPercent = $this->setIntegerProperty($this->depthPercent, $value);
    }

        /**
          * Darkens sides of bars to enhance 3D effect.<br>
          * This has effect only when Chart.Aspect.View3D is true.
          * High color video modes (greater than 256 colors) will show dark colors
          * much better than 256 or 16 color modes. <br>
          * Default value: true
          *
          * @return boolean
          */
    public function getDark3D() {
        return $this->bDark3D;
    }

        /**
          * Darkens sides of bars to enhance 3D effect.<br>
          * Default value: true
          *
          * @param value boolean
          */
    public function setDark3D($value) {
        $this->bDark3D = $this->setBooleanProperty($this->bDark3D, $value);
    }

    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);
        $this->barSizePercent = 85;
        $this->setMultiBar(MultiBars::$NONE);
    }

    protected function setBarSizePercent($value) {
        $this->barSizePercent = $this->setIntegerProperty($this->barSizePercent, $value);
    }

    private function setOtherBars($setOthers) {
        if ($this->chart != null) {
            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {

                 $s = $this->chart->getSeries($t);

                if ($this->sameClass($s)) {
                     $tmpBar = $s;

                    if ($setOthers) {
                        $tmpBar->iMultiBar = $this->iMultiBar;
                        $tmpBar->sideMargins = $this->sideMargins;
                    } else {
                        $this->iMultiBar = $tmpBar->iMultiBar;
                        $this->sideMargins = $tmpBar->sideMargins;
                        break;
                    }

                    $tmpBar->calcVisiblePoints = $this->iMultiBar != MultiBars::$SELFSTACK;
                }
            }
        }
    }

    /**
      * Margin between Chart rectangle and Bars.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getSideMargins() {
        return $this->sideMargins;
    }

    /**
      * Sets a margin between Chart rectangle and Bars.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setSideMargins($value) {
        $this->sideMargins = $this->setBooleanProperty($this->sideMargins, $value);
        $this->setOtherBars(true);
    }

    protected function shouldSerializeYOrigin() {
        return false;
    }

    /**
      * Obsolete.&nbsp;Please use CustomBar.<!-- -->Origin instead.
      *
      * @return double
      */
    public function getYOrigin() {
        return $this->dOrigin;
    }

    /**
      * Obsolete.&nbsp;Please use CustomBar.<!-- -->Origin instead.
      *
      * @param value double
      */
    public function setYOrigin($value) {
        $this->setOrigin($value);
    }

    /**
      * Bars to be bottom aligned at the Origin method value. <br>
      * When false, the minimum of all Bar values is used as the Bar origins
      * value. <br>
      * When true, the Origin property is used as the start point for Bars. <br>
      * Default value: true
      *
      * @return boolean
      */
    public function getUseOrigin() {
        return $this->bUseOrigin;
    }

    /**
      * Allows Bars to be bottom aligned at the Origin method value. <br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setUseOrigin($value) {
        $this->bUseOrigin = $this->setBooleanProperty($this->bUseOrigin, $value);
    }

    /**
      * The common bottom value used for all Bar points.<br>
      * UseOrigin must be true (the default) to use the Origin property. <br>
      * Bars with a value bigger than Origin are drawn in one direction and
      * Bars with a lower value are drawn in the opposite direction.
      * This applies both to Bar series and HorizBar series classes.<br>
      * Default value: 0
      *
      * @return double
      */
    public function getOrigin() {
        return $this->dOrigin;
    }

    /**
      * Sets the common bottom value used for all Bar points.<br>
      * Default value: 0
      *
      * @param value double
      */
    public function setOrigin($value) {
        $this->dOrigin = $this->setDoubleProperty($this->dOrigin, $value);
    }

    /**
      * Repositions Marks on BarSeries to prevent overlapping.<br>
      * Marks are displaced to the top of the Bars to minimize the overlapping
      * effect of Marks with long text or big font sizes.<br>
      * When false, no checking is performed and all Marks are drawn at their
      * Mark.ArrowLength distance to the top of the Bar.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getAutoMarkPosition() {
        return $this->autoMarkPosition;
    }

    /**
      * Repositions Marks on BarSeries to prevent overlapping.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setAutoMarkPosition($value) {
        $this->autoMarkPosition = $this->setBooleanProperty($this->autoMarkPosition, $value);
    }

    /**
      * The apex size as percentage of the base.<br>
      * Default value: 0
      *
      * @return int
      */
    public function getConePercent() {
        return $this->conePercent;
    }

    /**
      * Sets the apex size as a percentage of the base.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setConePercent($value) {
        $this->conePercent = $this->setIntegerProperty($this->conePercent, $value);
    }

    /**
      * The Bar displacement as percentage of Bar size.<br>
      * Displacement is horizontal for Bar series and vertical for HorizBar
      * series. It can be used to create "overlayed" Bar charts.
      * You can specify positive or negative values. <br>
      * Default value: 0
      *
      * @return int
      */
    public function getOffsetPercent() {
        return $this->offsetPercent;
    }

    /**
      * Sets the Bar displacement as percentage of Bar size.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setOffsetPercent($value) {
        $this->offsetPercent = $this->setIntegerProperty($this->offsetPercent, $value);
    }

    /**
      * Defines the Bar shape used to draw Bars.<br>
      * Default value: BarStyle.Rectangle
      *
      *
      * @return BarStyle
      */
    public function getBarStyle() {
        return $this->barStyle;
    }

    /**
      * Defines the Bar shape used to draw Bars.<br>
      * Default value: BarStyle.Rectangle
      *
      *
      * @param value BarStyle
      */
    public function setBarStyle($value) {
        if ($this->barStyle != $value) {
            $this->barStyle = $value;
            /* TODO if ($this->barStyle == BarStyle::$RECTGRADIENT) {
                $this->getGradient()->setVisible(true);
            } else {
                $this->getGradient()->setVisible(false);
            }
            */            
            $this->invalidate();
        }
    }

    /**
      * Defines the Brush used to fill Bars.<br>
      * When BarBrush.Style is different than bsSolid, the Series.Color color
      * is the background bar color.
      *
      * @return ChartBrush
      */
    public function getBrush() {
        return $this->bBrush;
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->pPen != null) {
            $this->pPen->setChart($this->chart);
        }
        if ($this->bBrush != null) {
            $this->bBrush->setChart($this->chart);
        }
        $this->setOtherBars(false);
    }

    /**
      * Determines how multiple BarSeries will be displayed in the same
      * Chart.<br>
      * If you have more than one Bar series in the same Chart, then you can
      * choose if they will be drawn side-by-side, back-to-front or Stacked.<br>
      * Side-by-side means the Bar width will be divided by the number of Bar
      * Series. <br>
      * Default value: MultiBars.Side
      *
      * @return MultiBars
      */
    public function getMultiBar() {
        return $this->iMultiBar;
    }

    /**
      * Determines how multiple BarSeries will be displayed in the same
      * Chart.<br>
      * Default value: MultiBars.Side
      *
      * @param value MultiBars
      */
    public function setMultiBar($value) {
        if ($this->iMultiBar != $value) {
            $this->iMultiBar = $value;
            $this->setOtherBars(true);
            $this->invalidate();
        }
    }

    /**
      * Pen used to draw the Bar rectangles.<br>
      * You can set BarPen.Visible = false to hide these lines.
      *
      * @return ChartPen
      */
    public function getPen() {
        if ($this->pPen == null) {
            $tmpColor = new Color(0,0,0);
            $this->pPen = new ChartPen($this->chart, $tmpColor);
            
            unset($tmpColor);
        }
        return $this->pPen;
    }

    /**
      * Coordinates of current Bar point being displayed.<br>
      * Run-time and read-only. <br>
      * This function returns an internal variable, that is calculated only
      * when the Bar Series DrawValue method is called.<br>
      * You should only use BarBounds in custom-derived series, after
      * calling the "inherited DrawValue" method.
      *
      * @return Rectangle
      */
    public function getBarBounds() {
        return $this->iBarBounds;
    }

    protected function getBarBoundsMidX() {
        return ($this->iBarBounds->getLeft() + $this->iBarBounds->getRight()) / 2;
    }

    private function calcGradientColor($valueIndex) {
         $g = $this->getGradient();

        if ($this->gradientRelative) {
             $tmp = $this->bUseOrigin ? $this->dOrigin : $this->mandatory->getMinimum();
             $tmpRatio = ($this->mandatory->value[$valueIndex] - $tmp) /
                              ($this->mandatory->getMaximum() - $tmp);

             $t0 = $g->getStartColor()->getRed();
             $t1 = $g->getStartColor()->getGreen();
             $t2 = $g->getStartColor()->getBlue();

/* TODO            $g->setEndColor($this->Color->fromArgb(
                    $g->getStartColor()->getAlpha(),
                    ($this->t0 +
                     MathUtils::round($tmpRatio * ($this->normalBarColor->getRed() - $t0))),
                    ($this->t1 +
                     MathUtils::round($tmpRatio *
                                     ($this->normalBarColor->getGreen() - $t1))),
                    ($this->t2 +
                     MathUtils::round($tmpRatio * ($this->normalBarColor->getBlue() - $t2))))
                    );*/

        } else {
            $g->setEndColor($this->normalBarColor);
        }
    }

    protected function doGetBarStyle($valueIndex) {
         $style = $this->barStyle;
        if ($this->styleResolver != null) {
            $style = $this->styleResolver->getStyle($this, $valueIndex, $style);
        }
        return $style;
    }

    protected function internalCalcMarkLength($valueIndex) { // abstract
        return 0;
    }

    private function internalPointOrigin($valueIndex, $sumAll) {
         $result = 0;
         $tmpValue = $this->mandatory->value[$valueIndex];

        if ($this->chart != null) {
            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                 $s = $this->chart->getSeries($t);
                if ((!$sumAll) && ($s === $this)) {
                    break;
                } else
                if ($s->getActive() && $this->sameClass($s) && ($s->getCount() > $valueIndex)
                    && ($s->stackGroup == $this->stackGroup)) {

                     $tmp = $s->getOriginValue($valueIndex);
                    if ($tmpValue < 0) {
                        if ($tmp < 0) {
                            $result += $tmp;
                        }
                    } else
                    if ($tmp > 0) {
                        $result += $tmp; /* 5.01 */
                    }
                }
            }
        }
        return $result;
    }

    protected function doGradient3D($valueIndex, $p0, $p1) {
        if ($this->pPen->getVisible()) {
            $p0->x++;
            $p0->y++;
             $w = MathUtils::round($this->pPen->getWidth()) - 1;
            $p1->x -= $w;
            $p1->y -= $w;
        }

        $this->calcGradientColor($valueIndex);
        $this->getGradient()->draw($this->chart->getGraphics3D(), $p0->x, $p0->y, $p1->x, $p1->y);
    }

    /**
      * For internal use.<br>
      * Displays a Bar or HorizBar point using the parameter coordinates and
      * the BarColor parameter. <br>
      * It is internally called for each point in the Series. <br>
      * The BarStyle property determines the type of graphical representation
      * of every point (ie: Rectangle, Ellipse, Pyramid, etc).
      *
      * @param barColor Color
      * @param r Rectangle
      */
    public function barRectangle($barColor, $r) {
        $this->_barRectangle($barColor, $r->x, $r->y, $r->getRight(), $r->getBottom());
    }

    /**
      * For internal use.<br>
      * Displays a Bar or HorizBar point using the parameter coordinates and
      * the BarColor parameter. <br>
      * It is internally called for each point in the Series. <br>
      * The BarStyle property determines the type of graphical representation
      * of every point (ie: Rectangle, Ellipse, Pyramid, etc).
      *
      * @param barColor Color
      * @param aLeft int
      * @param aTop int
      * @param aRight int
      * @param aBottom int
      */
    public function _barRectangle($barColor, $aLeft, $aTop, $aRight, $aBottom) {
         $g = $this->chart->getGraphics3D();
        if ($this->bBrush->getSolid()) {
            if (($aRight == $aLeft) || ($aTop == $aBottom)) {
                $g->getPen()->setColor($g->getBrush()->getColor());
                $g->getPen()->setVisible(true);
                $g->line($aLeft, $aTop, $aRight, $aBottom);
            } else
            if ((abs($aRight - $aLeft) < $g->getPen()->getWidth()) ||
                (abs($aBottom - $aTop) < $g->getPen()->getWidth())) {
                $g->getPen()->setColor($g->getBrush()->getColor());
                $g->getPen()->setVisible(true);
                $g->getBrush()->setVisible(false);
            }
        }
        $tmpR = new Rectangle();
        $tmpR->x=$aLeft;
        $tmpR->y=$aTop;
        $tmpR->setRight($aRight);
        $tmpR->setBottom($aBottom);

        $g->rectangle($tmpR);
    }

    protected function doBarGradient($valueIndex, $rect) {
        $this->calcGradientColor($valueIndex);
        $this->getGradient()->draw($this->chart->getGraphics3D(), $rect);
        if ($this->pPen->getVisible()) {
            $this->chart->getGraphics3D()->getBrush()->setVisible(false);
            $this->barRectangle($this->normalBarColor, $this->iBarBounds);
        }
    }

    public function getCustomBarWidth() {
        return $this->customBarSize;
    }

    public function setCustomBarWidth($value) {
        $this->customBarSize = $value;
        $this->chart->invalidate();
    }

    private function doCalcBarWidth() {

        if ($this->customBarSize != 0) {
            $this->iBarSize = $this->customBarSize;
        } else
        if ($this->iMaxBarPoints > 0) {
             $tmpAxis = $this->yMandatory ? $this->getHorizAxis() : $this->getVertAxis();

             $tmp = 0;

            //				if ( autoBarSize )
            //					tmp=MathUtils.round(tmpAxis.IAxisSize/(2.0+tmpAxis.Maximum-tmpAxis.Minimum));
            //				else
            {
                if ($this->sideMargins) {
                    $this->iMaxBarPoints++;
                }
                $tmp = $tmpAxis->iAxisSize / $this->iMaxBarPoints;
            }

            $this->iBarSize = MathUtils::round(($this->barSizePercent * 0.01) * $tmp) /
                       max(1, $this->iNumBars);
            if (($this->iBarSize % 2) == 1) {
                $this->iBarSize++;
            }
        } else {
            $this->iBarSize = 0;
        }
    }

    /**
      * Returns side margin amount in pixels.
      *
      * @return int
      */
    public function barMargin() {
        $result = $this->iBarSize;
        if ($this->iMultiBar != MultiBars::$SIDEALL) {
            $result *= $this->iNumBars;
        }
        if (!$this->sideMargins) {
            $result /= 2;
        }
        return $result;
    }

    protected function internalApplyBarMargin($margins) {
        $this->doCalcBarWidth();
         $tmp = $this->barMargin();
        $margins->min += $tmp;
        $margins->max += $tmp;
    }

    protected function internalGetOriginPos($valueIndex, $defaultOrigin) {
         $result = 0;

         $tmpValue = $this->pointOrigin($valueIndex, false);

        if (($this->iMultiBar == MultiBars::$STACKED) |
            ($this->iMultiBar == MultiBars::$SELFSTACK)) {
            $result = $this->calcPosValue($tmpValue);
        } else
        if ($this->iMultiBar == MultiBars::$STACKED100) {
             $tmp = $this->pointOrigin($valueIndex, true);
            $result = ($tmp != 0) ? $this->calcPosValue($tmpValue * 100.0 / $tmp) : 0;
        } else {
            $result = $this->bUseOrigin ? $this->calcPosValue($tmpValue) : $defaultOrigin;
        }

        return $result;
    }

    protected function maxMandatoryValue($value) {
        $result = 0;

        if ($this->iMultiBar == MultiBars::$STACKED100) {
            $result = 100;
        } else {
            $result = $value;

            if ($this->iMultiBar == MultiBars::$SELFSTACK) {
                $result = $this->mandatory->getTotal();
            } else
            if ($this->iMultiBar == MultiBars::$STACKED) {
                for ( $t = 0; $t < $this->getCount(); $t++) {
                     $tmp = $this->pointOrigin($t, false) + $this->mandatory->value[$t];
                    if ($tmp > $result) {
                        $result = $tmp;
                    }
                }
            }
            if ($this->bUseOrigin && ($result < $this->dOrigin)) {
                $result = $this->dOrigin;
            }
        }
        return $result;
    }

    /**
      * For Internal Use.<br>
      * The PointOrigin function returns the summed values of more than one
      * Series point.<br>
      * It's only used by Series types with Stacked or Stacked 100% styles such
      * as BarSeries, HorizBar series and Area series.
      *
      * @param valueIndex int
      * @param sumAll boolean
      * @return double
      */
    public function pointOrigin($valueIndex, $sumAll) {
        if (($this->iMultiBar == MultiBars::$STACKED) ||
            ($this->iMultiBar == MultiBars::$STACKED100)) {
            return $this->internalPointOrigin($valueIndex, $sumAll);
        } else
        if ($this->iMultiBar == MultiBars::$SELFSTACK) {
             $result = 0;
            for ( $t = 0; $t < $valueIndex; $t++) {
                $result += $this->mandatory->value[$t];
            }
            return $result;
        } else {
            return $this->dOrigin;
        }
    }

    protected function minMandatoryValue($value) {
        $result = 0;

        if ($this->iMultiBar == MultiBars::$STACKED100) {
            $result = 0;
        } else {
            $result = $value;
            if (($this->iMultiBar == MultiBars::$STACKED) ||
                ($this->iMultiBar == MultiBars::$SELFSTACK)) {
                for ( $t = 0; $t < $this->getCount(); $t++) {
                     $tmp = $this->pointOrigin($t, false) + $this->mandatory->value[$t];
                    if ($tmp < $result) {
                        $result = $tmp;
                    }
                }
            }
            if ($this->bUseOrigin && ($result > $this->dOrigin)) {
                $result = $this->dOrigin;
            }
        }
        return $result;
    }

    public function calcZOrder() {

        if ($this->iMultiBar == MultiBars::$NONE) {
            parent::calcZOrder();
        } else {
             $tmpZOrder = -1;
            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                 $s = $this->chart->getSeries($t);
                if ($s->getActive()) {
                    if ($s === $this) {
                        break;
                    } else
                    if ($this->sameClass($s)) {
                        $tmpZOrder = $s->getZOrder();
                        break;
                    }
                }
            }

            if ($tmpZOrder == -1) {
                parent::calcZOrder();
            } else {
                $this->iZOrder = $tmpZOrder;
            }
        }
    }

    private function newGroup($aGroup) {
        for ( $t = 0; $t < $this->numGroups; $t++) {
            if ($this->groups[$t] == $aGroup) {
                return false;
            }
        }

        $this->groups[$this->numGroups] = $aGroup;
        $this->numGroups++;
        return true;
    }

    // if more than one bar series exists in chart,
    // which position are we? the first, the second, the third?
    public function doBeforeDrawChart() {

        parent::doBeforeDrawChart();

        $this->iOrderPos = 1;
        $this->iPreviousCount = 0;
        $this->iNumBars = 0;
        $this->iMaxBarPoints = -1;
        $this->numGroups = 0;

        $stop = false;

        for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
             $s = $this->chart->getSeries($t);
            if ($s->getActive() && $this->sameClass($s)) {

                $stop |= ($s === $this);

                 $tmp = $s->getCount();

                if (($this->iMaxBarPoints == -1) || ($tmp > $this->iMaxBarPoints)) {
                    $this->iMaxBarPoints = $tmp;
                }

                if ($this->iMultiBar == MultiBars::$NONE) {
                    $this->iNumBars = 1;
                } else
                if (($this->iMultiBar == MultiBars::$SIDE) |
                    ($this->iMultiBar == MultiBars::$SIDEALL)) {
                    $this->iNumBars++;
                    if (!$stop) {
                        $this->iOrderPos++;
                    }
                } else
                if (($this->iMultiBar == MultiBars::$STACKED) |
                    ($this->iMultiBar == MultiBars::$STACKED100)) {
                    if ($this->newGroup($s->stackGroup)) {
                        $this->iNumBars++;
                        if (!$stop) {
                            $this->iOrderPos++;
                        }
                    }
                } else
                if ($this->iMultiBar == MultiBars::$SELFSTACK) {
                    $this->iNumBars = 1;
                }

                if (!$stop) {
                    $this->iPreviousCount += $tmp;
                }
            }

            for ( $tt = 0; $tt < $this->numGroups; $tt++) {
                if ($this->groups[$tt] == $this->stackGroup) {
                    $this->iOrderPos = $tt + 1;
                    break;
                }
            }

            // this should be done after calculating INumBars
            if ($this->chart->getPage()->getMaxPointsPerPage() > 0) {
                $this->iMaxBarPoints = $this->chart->getPage()->getMaxPointsPerPage();
            }
        }
    }

    protected function drawLegendShape($g, $valueIndex, $rect) {
        if ($this->getBrush()->getImage() != null) {
            $g->getBrush()->setImage($this->bBrush->getImage());
        }
        parent::drawLegendShape($g, $valueIndex, $rect);
    }

    protected function applyBarOffset($position) {
        $result = $position;
        if ($this->offsetPercent != 0) {
            $result += MathUtils::round($this->offsetPercent * $this->iBarSize * 0.01);
        }
        return $result;
    }

    protected function calcMarkLength($valueIndex) {
        if (($this->getCount() > 0) && $this->getMarks()->getVisible()) {
             $this->chart->getGraphics3D()->setFont($this->getMarks()->getFont());
             $result = $this->getMarks()->getArrowLength() +
                         $this->internalCalcMarkLength($valueIndex);
            if ($this->getMarks()->getPen()->getVisible()) {
                $result += MathUtils::round(2 * $this->getMarks()->getPen()->getWidth());
            }
            return $result;
        } else {
            return 0;
        }
    }

    protected function internalClicked($valueIndex, $point) {
        return false;
    }

    /**
      * Returns the ValueIndex of the "clicked" point in the Series.<br>
      * Clicked means the X and Y coordinates are in the point screen region
      * bounds. If no point is "touched", Clicked returns -1
      *
      * @param x int
      * @param y int
      * @return int
      */
      /* TODO          
    public function clicked($x, $y) {
        if ($this->chart != null) {
             $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y,
                    $this->getStartZ());
            $x = $p->x;
            $y = $p->y;
        }

        if (($this->firstVisible > -1) && ($this->lastVisible > -1)) {
             $p = new TeePoint($x, $y);
            for ( $t = $this->firstVisible;
                         $t <= min($this->lastVisible, $this->getCount() - 1);
                         $t++) {
                if ($this->internalClicked($t, $p)) {
                    return $t;
                }
            }
        }
        
        return -1;
    }
    */

    protected function numSampleValues() {
        if (($this->chart != null) && ($this->chart->getSeriesCount() > 1)) {
            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                 $s = $this->chart->getSeries($t);
                if (($s != $this) && ($s instanceof CustomBar) &&
                    ($s->getCount() > 0)) {
                    return $s->getCount();
                }
            }
        }
        return 6;
    }

    protected function setPenBrushBar($barColor) {
        $this->chart->getGraphics3D()->setPen($this->pPen);
/* todo change the isnull         if ($barColor->isNull()) {
            $this->chart->getGraphics3D()->getPen()->setColor($barColor);
        }                 */
        if ($this->getBrush()->getColor()->isEmpty()) {
            $this->getBrush()->setColor($this->getColor());
        }
        $this->chart->setBrushCanvas($barColor, $this->getBrush(), $this->getColor()); // $TTrack //#1482
    }

    protected function subGalleryStack() {
        return true;
    }

/* TODO    public function createSubGallery(
                                                                  addSubChart) {
                super.createSubGallery(addSubChart);
                addSubChart.createSubChart(Language.getString("Colors"));
                addSubChart.createSubChart(Language.getString("Pyramid"));
                addSubChart.createSubChart(Language.getString("Ellipse"));
                addSubChart.createSubChart(Language.getString("InvPyramid"));
                addSubChart.createSubChart(Language.getString("Gradient"));

                if (subGalleryStack()) {
                        addSubChart.createSubChart(Language.getString("Stack"));
                        addSubChart.createSubChart(Language.getString("Stack"));
                        addSubChart.createSubChart(Language.getString("SelfStack"));
                }

                addSubChart.createSubChart(Language.getString("Sides"));
                addSubChart.createSubChart(Language.getString("SideAll"));
        }
*/

/*    public function setSubGallery($index) {
        switch ($index) {
        case 0:
            break;
        case 1:
            $this->setColorEach(true);
            break;
        case 2:
            $this->setBarStyle(BarStyle::$PYRAMID);
            break;
        case 3:
            $this->setBarStyle(BarStyle::$ELLIPSE);
            break;
        case 4:
            $this->setBarStyle(BarStyle::$INVPYRAMID);
            break;
        case 5:
            $this->setBarStyle(BarStyle::$RECTGRADIENT);
            break;
        default: {

            if (($this->chart != null) &&
                ($this->chart->getSeriesCount() == 1)) {
                $this->fillSampleValues(2);

                try {
                    try {
                         $tmp = ($this->Series) $this->getClass()->newInstance();
                        $this->getChart()->addSeries($tmp);
                        $tmp->setTitle(""); // <--      $and $this->others
                        $tmp->fillSampleValues(2);
                        $tmp->getMarks()->setVisible(false);
                        (($this->CustomBar) ($tmp))->barSizePercent = $this->barSizePercent;
                        $this->getMarks()->setVisible(false);
                        $tmp->setSubGallery($index);
                    } catch ( $e) {
                    }
                } catch ( $e) {
                }
            }

            if (!$subGalleryStack()) {
                $index += 3;
            }

            switch ($index) {
            case 6:
                $this->setMultiBar(MultiBars::$STACKED);
                break;
            case 7:
                $this->setMultiBar(MultiBars::$STACKED100);
                break;
            case 8:
                $this->setMultiBar(MultiBars::$SELFSTACK);
                break;
            case 9:
                $this->setMultiBar(MultiBars::$SIDE);
                break;
            case 10:
                $this->setMultiBar(MultiBars::$SIDEALL);
                break;
            default:
                parent::setSubGallery($index);
            }
            break;
        }
        }
    }
  */
    /* tODO public $BarStyleResolver ${
        public function getStyle($series, $valueIndex, $style);
        }
        */
}

?>