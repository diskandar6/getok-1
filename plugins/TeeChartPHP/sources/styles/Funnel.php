<?php
 /**
 * Description:  This file contains the following class:<br>
 * Funnel class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 * <p>Title: Funnel class</p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Funnel extends Series {

    private $aboveColor; 
    private $autoUpdate = true;
    private $belowColor;
    private $differenceLimit = 30;
    private $pen;
    private $linesPen;
    private $opportunityValues;
    private $quotesSorted=false;
    private $withinColor;

    private $iPolyCount;
    private $iPolyPoints = Array(); 
    private $boundingPoints = Array();
    private $iSorted;
    private $iMin=0;
    private $iMax=0;
    private $iSlope=0;
    private $iDiff;
    
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

        $this->opportunityValues = new ValueList($this, Language::getString("OpportunityValues"));
        $this->opportunityValues->setOrder(ValueListOrder::$NONE);
        $this->vxValues->setOrder(ValueListOrder::$NONE);
        $this->setPercentFormat(Language::getString("FunnelPercent"));
        $this->getQuoteValues()->setOrder(ValueListOrder::$DESCENDING);
        $this->getYValues()->setName(Language::getString("QuoteValues"));
        $this->useSeriesColor = false;
        $this->aboveColor = Color::GREEN();
        $this->belowColor = Color::RED();
        $this->withinColor = Color::YELLOW();
        $this->quotesSorted = false;
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->aboveColor);
        unset($this->autoUpdate);
        unset($this->belowColor);
        unset($this->differenceLimit);
        unset($this->pen);
        unset($this->linesPen);
        unset($this->opportunityValues);
        unset($this->quotesSorted);
        unset($this->withinColor);
        unset($this->iPolyCount);
        unset($this->iPolyPoints);
        unset($this->boundingPoints);
        unset($this->iSorted);
        unset($this->iMin);
        unset($this->iMax);
        unset($this->iSlope);
        unset($this->iDiff);
    }     

    /**
     * The ValueIndex of the "clicked" point in the Series.<br>
     *
     * @param x int
     * @param y int
     * @return int
     */
    public function clicked($x, $y) {
        $result = parent::clicked($x, $y);
        if (($result == -1) && ($this->firstVisible > -1) && ($this->lastVisible > -1)) {
            for ($t = $this->firstVisible; $t <= $this->lastVisible; $t++) {
                $this->defineFunnelRegion($t);                
                if (GraphicsGD::pointInPolygon(new TeePoint($x,$y), $this->iPolyPoints)) {
                    return $t;
                }
            }
        }
        return $result;
    }

    protected function readResolve() {
        $this->iPolyPoints = Array(); // new Point[5];
        $this->boundingPoints = Array(); //new Point[4];

        return parent::readResolve(); 
    }

    private function defineFunnelRegion($index) {
        // Calculate multiplying factor
        if ($this->getQuoteValues()->getValue($index) == 0) {
            $this->iDiff = 0;
        } else {
            $this->iDiff = $this->opportunityValues->getValue($index) /
                    $this->getQuoteValues()->getValue($index);
        }

        for ($t = 0; $t < 4; $t++) {
            if (empty($this->boundingPoints[$t])) {
                $this->boundingPoints[$t] = new TeePoint();
            }
        }

        for ($t = 0; $t < 5; $t++) {
            if (empty($this->iPolyPoints[$t])) {
                $this->iPolyPoints[$t] = new TeePoint();
            }
        }

        // calculate bouding rectangle
        $this->boundingPoints[0]->x = $this->calcXPosValue($index - 0.5);
        $this->boundingPoints[0]->y = $this->calcYPosValue($this->iMax - $this->iSlope * $index);
        $this->boundingPoints[1]->x = $this->calcXPosValue($index + 0.5);
        $this->boundingPoints[1]->y = $this->calcYPosValue($this->iMax - $this->iSlope * ($index + 1));
        $this->boundingPoints[2]->x = $this->boundingPoints[1]->x;
        $this->boundingPoints[2]->y = $this->calcYPosValue($this->iSlope * ($index + 1));
        $this->boundingPoints[3]->x = $this->boundingPoints[0]->x;
        $this->boundingPoints[3]->y = $this->calcYPosValue($this->iSlope * $index);

        $tmpY = $this->calcYPosValue(($this->iMax - 2 * $this->iSlope * $index) * $this->iDiff +
                                 $this->iSlope * $index);
        // Actual value, expressed in axis scale

        if ($tmpY <= $this->boundingPoints[0]->y) { // IDiff >= 1
            $this->iPolyCount = 4;
            $this->iPolyPoints[0] = $this->boundingPoints[0];
            $this->iPolyPoints[1] = $this->boundingPoints[1];
            $this->iPolyPoints[2] = $this->boundingPoints[2];
            $this->iPolyPoints[3] = $this->boundingPoints[3];
        } else
        if (($tmpY > $this->boundingPoints[0]->y) && ($tmpY <= $this->boundingPoints[1]->y)) {
            $this->iPolyCount = 5;
            $this->iPolyPoints[0]->x = $this->boundingPoints[0]->x;
            $this->iPolyPoints[0]->y = $tmpY;
            $tmpX = $this->calcXPosValue(($this->iMax - 2 * $this->iSlope * $index) * (1 - $this->iDiff) /
                                     $this->iSlope + $index - 0.5);
            if ($this->iPolyPoints[1] == null) {
                $this->iPolyPoints[1] = new TeePoint();
            }
            $this->iPolyPoints[1]->x = $tmpX;
            $this->iPolyPoints[1]->y = $tmpY;
            $this->iPolyPoints[2] = $this->boundingPoints[1];
            $this->iPolyPoints[3] = $this->boundingPoints[2];
            $this->iPolyPoints[4] = $this->boundingPoints[3];
        } else if ($tmpY > $this->boundingPoints[2]->y) {
            $this->iPolyCount = 3;
            for ($t = 0; $t < 2; $t++) {
                if ($this->iPolyPoints[$t] == null) {
                    $this->iPolyPoints[$t] = new TeePoint();
                }
            }
            $this->iPolyPoints[0]->x = $this->boundingPoints[0]->x;
            $this->iPolyPoints[0]->y = $tmpY;
            $tmpX = $this->calcXPosValue(($this->iMax - 2 * $this->iSlope * $index) * $this->iDiff /
                                     $this->iSlope + $index - 0.5);
            $this->iPolyPoints[1]->x = $tmpX;
            $this->iPolyPoints[1]->y = $tmpY;
            $this->iPolyPoints[2] = $this->boundingPoints[3];
        } else {
            $this->iPolyCount = 4;
            $this->iPolyPoints[0]->x = $this->boundingPoints[0]->x;
            $this->iPolyPoints[0]->y = $tmpY;
            $this->iPolyPoints[1]->x = $this->boundingPoints[1]->x;
            $this->iPolyPoints[1]->y = $tmpY;
            $this->iPolyPoints[2] = $this->boundingPoints[2];
            $this->iPolyPoints[3] = $this->boundingPoints[3];
        }

        if ($this->iDiff >= 1) {
            return $this->aboveColor;
        } else
        if ((1 - $this->iDiff) * 100 > $this->differenceLimit) {
            return $this->belowColor;
        } else {
            return $this->withinColor;
        }
    }

    /**
     * Funnel segment color if Opportunity value is greater than Quote
     * value.<br>
     * Default value: GREEN
     *
     *
     * @return Color
     */
    public function getAboveColor() {
        return $this->aboveColor;
    }

    /**
     * Funnel segment color if Opportunity value is greater than Quote
     * value.<br>
     * Default value: GREEN
     *
     *
     * @param value Color
     */
    public function setAboveColor($value) {
        $this->aboveColor = $this->setColorProperty($this->aboveColor, $value);
    }

    /**
     * Funnel segment color if Opportunity value is within DifferenceLimit %
     * below the Quote value.<br>
     * Default value: YELLOW
     *
     *
     * @return Color
     */
    public function getWithinColor() {
        return $this->withinColor;
    }

    /**
     * Funnel segment color if Opportunity value is within DifferenceLimit %
     * below the Quote value.<br>
     * Default value: YELLOW
     *
     *
     * @param value Color
     */
    public function setWithinColor($value) {
        $this->withinColor = $this->setColorProperty($this->withinColor, $value);
    }

    /**
     * Funnel segment color if Opportunity value is more than the
     * DifferenceLimit % below the Quote value.<br>
     * Default value: RED
     *
     *
     * @return Color
     */
    public function getBelowColor() {
        return $this->belowColor;
    }

    /**
     * Funnel segment color if Opportunity value is more than the
     * DifferenceLimit % below the Quote value.<br>
     * Default value: RED
     *
     *
     * @param value Color
     */
    public function setBelowColor($value) {
        $this->belowColor = $this->setColorProperty($this->belowColor, $value);
    }

    /**
     * Define Pen to draw the Funnel Chart.
     *
     * @return ChartPen
     */
    public function getPen() {
        if ($this->pen == null) {
            $this->pen = new ChartPen($this->chart, Color::BLACK());
        }
        return $this->pen;
    }

    /**
     * Defines Pen to draw FunnelSeries bounding polygon.
     *
     * @return ChartPen
     */
    public function getLinesPen() {
        if ($this->linesPen == null) {
            $this->linesPen = new ChartPen($this->chart, Color::BLACK());
        }
        return $this->linesPen;
    }

    /**
     * Defines Brush to fill Funnel Series.
     *
     * @return ChartBrush
     */
    public function getBrush() {
        return $this->bBrush;
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->linesPen != null) {
            $this->linesPen->setChart($this->chart);
        }
        if ($this->pen != null) {
            $this->pen->setChart($this->chart);
        }
    }

    public function getMarkText($valueIndex) {        
        /* TODO
        return $this->getPercentDecimal.format(100 *
                                     opportunityValues.getValue(valueIndex) /
                                     getQuoteValues().getValue(valueIndex));
        */                             
        return (100 *
                                     $this->opportunityValues->getValue($valueIndex) /
                                     $this->getQuoteValues()->getValue($valueIndex));
    }


    public function doBeforeDrawChart() {
        parent::doBeforeDrawChart();
        if ($this->getVisible() && ($this->getVertAxis() != null)) {
            $this->getVertAxis()->setVisible(false);
        }
        
        if ($this->iSlope==0)
            if ($this->autoUpdate)
                $this->reCalc();        
    }

    public function getCountLegendItems() {
        return 3;
    }

    public function legendItemColor($legendIndex) {
        switch ($legendIndex) {
        case 0:
            return $this->aboveColor;
            break;
        case 1:
            return $this->withinColor;
            break;
        default:
            return $this->belowColor;
            break;
        }
    }

    /**
     * Returns LegendString for LegendIndex'th item.
     *
     *
     * @param legendIndex int
     * @param legendTextStyle LegendTextStyle
     * @return String
     */
    public function getLegendString($legendIndex,
                               $legendTextStyle) {
        switch ($legendIndex) {
        case 0:
            return Language::getString("FunnelExceed");
            break;
        case 1:
            /* TODO 
            return percentDecimal.format(getDifferenceLimit()) +
                    Language.getString("FunnelWithin");
                    */
            return $this->getDifferenceLimit() .
                    Language::getString("FunnelWithin");
            break;
        default:
            /* TODO 
            return percentDecimal.format(getDifferenceLimit()) +
                    Language.getString("FunnelBelow");
                    */
            return $this->getDifferenceLimit() .
                    Language::getString("FunnelBelow");
            break;
        }
    }

    //CDI - interesting ... boolean needed as method will otherwise take the slot for add(double, double, string, color)
    //in net we have the 'new' keyword for member hiding
    public function addFunnel($aQuote, $aOpportunity, $aLabel, $aColor) {
        $this->opportunityValues->tempValue = $aOpportunity;
        $result = $this->addYTextColor($aQuote, $aLabel, $aColor);
        if(!$this->quotesSorted) {
            $this->getYValues()->sort();
            $this->getXValues()->fillSequence();
            $this->iSorted = true;
        }
        return $result;

    }

    protected function addSampleValues($numValues) {
        $r = $this->randomBounds($numValues);

        for ($t = 0; $t < $numValues; $t++) {
            $tt = $t + 1;
            $this->addSegment(2.3 * $numValues * ($t + 1),
                (2.3 - (2 * $r->Random())) * $numValues * ($t + 2),
                Language::getString("FunnelSegment") . $tt, Color::EMPTYCOLOR(), true);
        }
        $this->reCalc();
    }

    protected function drawMark($valueIndex, $st, $aPosition) {
        $aPosition->leftTop->x = $this->calcXPosValue($valueIndex) - $aPosition->width / 2;
        $aPosition->leftTop->y = $this->calcYPosValue($this->iMax * 0.5) - $aPosition->height / 2;
        parent::drawMark($valueIndex, $st, $aPosition);
    }

    /**
     * Accesses the quote values of the FunnelSeries.
     *
     * @return ValueList
     */
    public function getQuoteValues() {
        return $this->mandatory;
    }

    /**
     * The difference (expressed in Quote %) used to define the Funnel
     * segment color.<br>
     * If the Opportunity value falls below (100-Difference)*Quote/100 then
     * the BelowColor will be used to paint the Funnel segment.<br>
     * If the Opportunity value falls between (100-Difference)*Quote/100 and
     * Quote, then the WithinColor will be used to paint the Funnel segment.<br>
     * Otherwise (if Opportunity > Quote) the AboveColor will be used to paint
     * the Funnel segment. <br>
     * Default value: 30
     *
     * @return double
     */
    public function getDifferenceLimit() {
        return $this->differenceLimit;
    }


    /**
     * Sets the difference (expressed in Quote %) used to define the Funnel
     * segment color.<br>
     * Default value: 30
     *
     * @param value double
     */
    public function setDifferenceLimit($value) {
        $this->differenceLimit = $value;
        if ($this->autoUpdate) {
            $this->reCalc();
        }
        $this->invalidate();
    }

    /**
     * Returns the Minimum Value of the Series Y Values List.<br>
     * As some Series have more than one Y Values List, this Minimum Value is
     * the "Minimum of Minimums" of all Series Y Values lists.
     *
     * @return double
     */
    public function getMinYValue() {
        return 0;
    }

    /**
     * Returns the Maximum Value of the Series X Values List.
     *
     * @return double
     */
    public function getMaxXValue() {
        return $this->getCount() - 0.5;
    }

    /**
     * Returns the Minimum Value of the Series X Values List.<br>
     * As some Series have more than one Y Values List, this Minimum Value is
     * the "Minimum of Minimums" of all Series Y Values lists.
     *
     * @return double
     */
    public function getMinXValue() {
        return -0.5;
    }

    /**
     * Called internally. Draws the "ValueIndex" point of the Series.
     *
     * @param valueIndex int
     */
    public function drawValue($valueIndex) {
        
        $g = $this->getChart()->getGraphics3D();
        $g->setBrush($this->getBrush());
        $g->getBrush()->setColor($this->defineFunnelRegion($valueIndex));

        $g->getBrush()->setVisible(true);

        $a = $this->iPolyPoints;

        if ($this->chart->getAspect()->getView3D()) {
            $g->polygonZ($this->getStartZ(), $g->sliceArray($a, $this->iPolyCount));
        } else {
            $g->polygon($g->sliceArray($a, $this->iPolyCount));
        }
    }

    /**
     * Sorts added segments by QuoteValues in descending order.<br>
     * Setting QuotesSorted to false will enable the internal sorting
     * algorithm. <br>
     * Default value: false
     *
     * @return boolean
     */
    public function getQuotesSorted() {
        return $this->quotesSorted;
    }

    /**
     * Sorts added segments by QuoteValues in descending order.<br>
     * Default value: false
     *
     * @param value boolean
     */
    public function setQuotesSorted($value) {
        $this->quotesSorted = $value;
        $this->iSorted = $this->quotesSorted;
    }

    public function setOpportunityValues($value) {
        $this->opportunityValues=$value;
    }

    public function getOpportunityValues() {
        return $this->opportunityValues;
    }

    /**
     * Reconstructs FunnelSeries with every added point.<br>
     * To speed up the drawing of Funnel series, set the AutoUpdate to false
     * and call the Recalculate method when all points are added.<br>
     * Default value: true
     *
     * @return boolean
     */
    public function getAutoUpdate() {
        return $this->autoUpdate;
    }

    /**
     * Reconstructs FunnelSeries with every added point.<br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setAutoUpdate($value) {
        $this->autoUpdate = $value;
        if ($this->autoUpdate) {
            $this->reCalc();
        }
    }

    /**
     * Uses all Quote and Opportunity values to restatic finalruct the Funnel
     * chart.
     */
    public function reCalc() {
        if (!$this->iSorted) {
            $this->getQuoteValues()->sort();
            $this->getXValues()->fillSequence();
            $this->iSorted = true;
        }

        if ($this->getCount() > 0) {
            $this->iMax = $this->getQuoteValues()->getFirst();
            $this->iMin = $this->getQuoteValues()->getLast();
            $this->iSlope = 0.5 * ($this->iMax - $this->iMin) / $this->getCount();
        }
    }

    /**
     * Adds new Funnel segment to the Series.
     *
     * @param aQuote double
     * @param aOpportunity double
     * @param aLabel String
     * @param aColor Color
     * @return int
     */
    public function addSegment($aQuote, $aOpportunity, $aLabel,
                          $aColor) { //TODO there must be a correct way to use overload of add method
        $this->opportunityValues->tempValue = $aOpportunity;
        $result = $this->addYTextColor($aQuote, $aLabel, $aColor);
        if (!$this->quotesSorted) {
            $this->getYValues()->sort();
            $this->getXValues()->fillSequence();
            $this->iSorted = true;
        }
        return $result;
    }

    protected function draw() {
        parent::draw();

        $g = $this->chart->getGraphics3D();
        $g->setPen($this->getPen());

        $g->getBrush()->setVisible(false);
        $this->boundingPoints[0]->x = $this->calcXPosValue( -0.5);
        $this->boundingPoints[0]->y = $this->calcYPosValue($this->iMax);
        $this->boundingPoints[1]->x = $this->calcXPosValue($this->getCount() - 0.5);
        $this->boundingPoints[1]->y = $this->calcYPosValue(($this->iMax + $this->iMin) * 0.5);
        $this->boundingPoints[2]->x = $this->boundingPoints[1]->x;
        $this->boundingPoints[2]->y = $this->calcYPosValue(($this->iMax - $this->iMin) * 0.5);
        $this->boundingPoints[3]->x = $this->boundingPoints[0]->x;
        $this->boundingPoints[3]->y = $this->calcYPosValue(0.0);

        $g->polygon($this->getStartZ(), $this->boundingPoints);

        if (($this->linesPen != null) && ($this->linesPen->getVisible())) {
            $g->setPen($this->linesPen);
            for ($t = $this->firstVisible; $t < $this->lastVisible; $t++) {
                $g->verticalLine($this->calcXPosValue($t + 0.5),
                               $this->calcYPosValue($this->iMax - $this->iSlope * ($t + 1)),
                               $this->calcYPosValue($this->iSlope * ($t + 1)), $this->getStartZ());
            }
        }
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return Language::getString("FunnelSeries");
    }
}
?>