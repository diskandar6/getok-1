<?php
 /**
 * Description:  This file contains the following class:<br>
 * Pie class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Pie class
 *
 * Description: Pie Series
 * Example:
 *  $pieSeries = new Pie($myChart->getChart());
 *  $pieSeries->getMarks()->setVisible(true);
 *  $pieSeries->getShadow()->setVisible(true);
 *  $pieSeries->getShadow()->setHorizSize(20);
 *  $pieSeries->getShadow()->setVertSize(20);
 *  $pieSeries->fillSampleValues(8);
 *
 *  $myChart->getHeader()->setVisible(true);
 *  $myChart->getHeader()->setText("Pie");
 *  $myChart->getAspect()->setElevation(315);
 *  $myChart->getAspect()->setOrthogonal(false);
 *  $myChart->getAspect()->setPerspective(0);
 *  $myChart->getAspect()->setRotation(360);
 *
 * @author
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Pie extends Circular {

    private $OtherFlag;
    private $angleSize = 360;
    private $dark3D = true;
    private $darkPen=null;
    private $explodedSlice=null;
    private $explodeBiggest=0;
    private $otherSlice=null;
    private $shadow=null;
    private $usePatterns=false;
    private $pen=null;
    private $autoMarkPosition = true;
    private $sortedSlice=null;
    private $isExploded=false;
    private $bevelPercent=0;
    private $edgeStyle=2; // EdgeStyles::$NONE
    private $multiPie=0;   // MultiPies::AUTOMATIC
    private $pieMarks=null;
    private $iOldChartRect;
    private $sliceHeight;

    protected $iDonutPercent=0;
    protected $iniX;
    protected $iniY;

    public $BelongsToOther = -1;
    public $angles=null;

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
    public function __construct($c=null) {

        $this->OtherFlag = intval('1000000000000'); // Integer.MAX_VALUE
        $this->explodedSlice = new ExplodedSliceList();
        $this->sliceHeight = new SliceValueList();

        parent::__construct($c);

        $this->setColorEach(true);
        $tmpColor = new Color(0,0,0);  // Black
        $this->pen = new ChartPen($this->chart, $tmpColor);
        $this->getMarks()->setDefaultVisible(true);
        $this->marks->getArrow()->setDefaultColor($tmpColor);
        $this->marks->getCallout()->setDefaultLength(8);
        $this->useSeriesColor = false;
        
        unset($tmpColor);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->OtherFlag);
        unset($this->angleSize);
        unset($this->dark3D);
        unset($this->darkPen);
        unset($this->explodedSlice);
        unset($this->explodeBiggest);
        unset($this->otherSlice);
        unset($this->shadow);
        unset($this->usePatterns);
        unset($this->pen);
        unset($this->autoMarkPosition);
        unset($this->sortedSlice);
        unset($this->isExploded);
        unset($this->bevelPercent);
        unset($this->edgeStyle);
        unset($this->multiPie);
        unset($this->pieMarks);
        unset($this->iOldChartRect);
        unset($this->sliceHeight);
        unset($this->iDonutPercent);
        unset($this->iniX);
        unset($this->iniY);
        unset($this->BelongsToOther);
        unset($this->angles);
    }       

    /**
      * Stores the Pie slice values.
      *
      * @return ValueList
      */
    public function getPieValues() {
        return $this->vyValues;
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->pen != null) {
            $this->pen->setChart($this->chart);
        }
        if ($this->shadow != null) {
            $this->shadow->setChart($this->chart);
        }
    }

    protected function setDonutPercent($value) {
        $this->iDonutPercent = $this->setIntegerProperty($this->iDonutPercent, $value);
    }

    /**
      * Draws points with different preset Colors.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getColorEach() {
        return parent::getColorEach();
    }

    /**
      * Draws points with different preset Colors.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setColorEach($value) {
        parent::setColorEach($value);
    }

    /**
      * Total angle in degrees (0 to 360) for all slices.<br>
      * Default value: 360
      *
      * @return int
      */
    public function getAngleSize() {
        return $this->angleSize;
    }

    /**
      * Total angle in degrees (0 to 360) for all slices.<br>
      * Default value: 360<br>
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * pieSeries = new com.steema.teechart.styles.Pie(myChart.getChart());
      * pieSeries.getMarks().setVisible(true);
      * pieSeries.getMarks().setStyle(MarksStyle.LABELPERCENT);
      * pieSeries.fillSampleValues(5);
      * pieSeries.setAngleSize(180);
      * pieSeries.setRotationAngle(90);
      * </font></pre></p>
      *
      * @param value int
      */
    public function setAngleSize($value) {
        $this->angleSize = $this->setIntegerProperty($this->angleSize, $value);
    }

    /**
      * Darkens side of 3D pie section to add depth.<br>
      * When true, it fills the Pie 3D effect screen areas with darker colors
      * than their corresponding Pie sectors. These colors look much better
      * with 16k colors video mode or greater. <br>
      * The Pie sector RGB color is increased to 40 units to obtain the darker
      * color. <br>
      * Default value: true
      *
      * @return boolean
      */
    public function getDark3D() {
        return $this->dark3D;
    }

    /**
      * Darkens side of 3D pie section to add depth.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setDark3D($value) {
        $this->dark3D = $this->setBooleanProperty($this->dark3D, $value);
    }


    /**
     * The Transparency level from 0 to 100%.<br>
     * Transparency is a value between 0 and 100 which sets the transparency
     * percentage with respect to foreground versus background.<br>
     * Default value: 0

     * @return int
     */
    public function getTransparency() {
        return $this->getBrush()->getTransparency();
    }

    /**
     * Sets Transparency level from 0 to 100%.<br>
     * Default value: 0
     *
     * @param value int
     */
    public function setTransparency($value) {
        $this->getBrush()->setTransparency($value);
    }

    /*
    ** Gets and sets the EdgeStyle of the bevel.
    */
    public function getEdgeStyle()
    {
      return $this->edgeStyle;
    }

    public function setEdgeStyle($value)
    {
      if ($this->edgeStyle != $value)
      {
        $this->edgeStyle = $value;
        $this->refreshSeries();
      }
    }

    /*
    ** Gets and sets the bevel as a percentage of the pie's depth.
    */
    public function getBevelPercent()
    {
      return $this->bevelPercent;
    }

    public function setBevelPercent($value)
    {
      if ($this->bevelPercent != $value)
      {
        $this->bevelPercent = $value;
        $this->refreshSeries();
      }
    }

    /**
      * Darkens pie slice borders.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getDarkPen() {
        return $this->darkPen;
    }

    /**
      * Darkens pie slice borders.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setDarkPen($value) {
        $this->darkPen = $this->setBooleanProperty($this->darkPen, $value);
    }

    /**
      * Displaces the biggest slice from centre by value set.<br>
      * Default value: 0
      *
      * @return int
      */
    public function getExplodeBiggest() {
        return $this->explodeBiggest;
    }

    /**
      * Displaces the biggest slice from centre by value set.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setExplodeBiggest($value) {
        $this->explodeBiggest = $this->setIntegerProperty($this->explodeBiggest, $value);
        $this->calcExplodeBiggest();
    }

    /**
      * Accesses the OtherSlice properties.<br>
      * For example, you can use it to define the grouping size for the
      * 'Other' slice of the Pie.<br>
      * Grouping may be expressed as a percentage or value.<br>
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * pieSeries.getOtherSlice().getLegend().setVisible(isSelected);
      * </font></pre></p>
      *
      * @see com.steema.teechart.styles.Pie.PieOtherSlice#getStyle
      * @return PieOtherSlice
      */
    public function getOtherSlice() {
        if ($this->otherSlice == null) {
            $this->otherSlice = new PieOtherSlice($this->chart, $this);
        }
        return $this->otherSlice;
    }

    /**
      * Line pen for Pie.<br>
      *
      * @return ChartPen
      */
    public function getPen() {
        return $this->pen;
    }

    /**
      * Brush fill for PieSeries.
      *
      * @return ChartBrush
      */
    public function getBrush() {
        return $this->bBrush;
    }

    /**
      * Defines the offset shadow of the PieSeries.
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * pieSeries = new com.steema.teechart.styles.Pie(myChart.getChart());
      * pieSeries.getMarks().setVisible(true);
      * pieSeries.getShadow().setVisible(true);
      * pieSeries.getShadow().setWidth(30);
      * pieSeries.getShadow().setHeight(50);
      * pieSeries.getShadow().setColor(Color.SILVER);
      * pieSeries.fillSampleValues(9);
      *
      * </font></pre></p>
      *
      * @return PieShadow
      */
    public function getShadow() {
        if ($this->shadow == null) {
            $this->shadow = new PieShadow($this->chart);
        }
        return $this->shadow;
    }

    /**
      * Fills Pie Sectors with different Brush pattern styles.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getUsePatterns() {
        return $this->usePatterns;
    }

    /**
      * Fills Pie Sectors with different Brush pattern styles.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setUsePatterns($value) {
        $this->usePatterns = $this->setBooleanProperty($this->usePatterns, $value);
    }

    /**
      * If true, marks will be displayed trying to not overlap one to each
      * other.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getAutoMarkPosition() {
        return $this->autoMarkPosition;
    }

    /**
      * If true, marks will be displayed trying to not overlap one to each
      * other.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setAutoMarkPosition($value) {
        $this->autoMarkPosition = $this->setBooleanProperty($this->autoMarkPosition, $value);
    }

    private function calcExplodeBiggest() {
        $tmp = $this->getYValues()->indexOf($this->getYValues()->getMaximum());
        if ($tmp != -1) {
            $this->getExplodedSlice()->setSlice($tmp, $this->explodeBiggest);
        }
    }

    private function calcExplodedOffset($valueIndex) {
         $offset = new TeePoint();

        if ($this->isExploded) {
            $tmpExp = $this->getExplodedSlice()->getSlice($valueIndex);
            if ($tmpExp > 0) {
                // Apply exploded % to radius
                $tmp = $this->angles[$valueIndex]->MidAngle;
                if ($this->chart->getGraphics3D()->getSupportsFullRotation()) {
                    $tmp += (0.25 * 2.0 * M_PI * $this->angleSize / 360.0) +
                            $tmpMath->PI;
                }

                $tmpSin = sin($tmp + $this->rotDegree);
                $tmpCos = cos($tmp + $this->rotDegree);

                $tmpExp *= 0.01;
                $offset->setX(round($this->iXRadius * $tmpExp * $tmpCos));
                $offset->setY(round($this->iYRadius * $tmpExp * $tmpSin));
            }
        }

        return $offset;
    }

    public function galleryChanged3D($is3D) {
        parent::galleryChanged3D($is3D);
        $this->disableRotation();
        $this->setCircled((!$this->chart->getAspect()->getView3D()));
    }

    private function getAngleSlice($index, $totalAngle) {
        $result = $this->angles[$index]->MidAngle + $this->rotDegree;
        if ($result > $totalAngle) {
            $result -= $totalAngle;
        }
        if ($result > (0.25 * $totalAngle)) {
            $result -= (0.25 * $totalAngle);

            if ($result > M_PI) {
                $result = $totalAngle - $result;
            }
        } else {
            $result = (0.25 * $totalAngle) - $result;
        }
        return $result;
    }

    private function disableRotation() {
        $a = $this->chart->getAspect();
        $a->setOrthogonal(false);
        $a->setRotation(0);
        $a->setElevation(305);
    }

    protected function swapValueIndex($a, $b) {
        parent::swapValueIndex($a, $b);
        $this->getExplodedSlice()->exchange($a, $b);
    }

    protected function addSampleValues($numValues) {
        $pieSampleStr = Array(Language::getString("PieSample1"),
                Language::getString("PieSample2"),
                Language::getString("PieSample3"),
                Language::getString("PieSample4"),
                Language::getString("PieSample5"),
                Language::getString("PieSample6"),
                Language::getString("PieSample7"),
                Language::getString("PieSample8"));

        $r = $this->randomBounds($numValues);
        for ( $t = 0; $t < $numValues; $t++) {
            $this->addYText(/*1+*/round(1000 * $r->Random()), // <-- Value
                $pieSampleStr[$t % 8]); // <-- Label
        }
    }

    private function SliceEndZ($valueIndex)
    {
      if (sizeof($this->sliceHeight) > $valueIndex)
        $result = $this->getStartZ() + round(($this->getEndZ() -
            $this->getStartZ()) * $this->sliceHeight->getSlice($valueIndex) * 0.01);
      else
        $result = $this->getEndZ();

      return $result;
    }

    private function calcAngles() {
        $totalAngle = 2.0 * M_PI * $this->angleSize / 360.0;

        if ($this->getOtherSlice()->getStyle() == PieOtherStyles::$NONE && $this->firstVisible != -1)
        {
          $tmpSumAbs = 0;
          for ($i = $this->firstVisible; $i <= $this->lastVisible; $i++)
          {
            $tmpSumAbs += abs($this->mandatory->getValue($i));
          }
        }
        else
        {
          $tmpSumAbs = $this->mandatory->getTotalABS();
        }

        $piPortion = ($tmpSumAbs != 0) ? $totalAngle / $tmpSumAbs : 0;
        $this->angles =  Array();
        $acumValue = 0;

        for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {
            $this->angles[$t] = new PieAngle();
            $this->angles[$t]->StartAngle = ($t == $this->firstVisible) ? 0 : $this->angles[$t - 1]->EndAngle;

            if ($tmpSumAbs != 0) {
                if (!$this->belongsToOtherSlice($t)) {
                    $acumValue += abs($this->mandatory->getValue($t));
                }
                if ($acumValue == $tmpSumAbs) {
                    $this->angles[$t]->EndAngle = $totalAngle;
                } else {
                    $this->angles[$t]->EndAngle = $acumValue * $piPortion;
                }

                /* prevent small pie sectors */
                if (($this->angles[$t]->EndAngle - $this->angles[$t]->StartAngle) >
                    $totalAngle) {
                    $this->angles[$t]->EndAngle = $this->angles[$t]->StartAngle + $totalAngle;
                }
            } else {
                $this->angles[$t]->EndAngle = $totalAngle;
            }

            $this->angles[$t]->MidAngle = ($this->angles[$t]->StartAngle + $this->angles[$t]->EndAngle) *
                                 0.5;
        }
    }

    protected function calcExplodedRadius($valueIndex) {
        $tmpExp = 1.0 + $this->getExplodedSlice()->getSlice($valueIndex) * 0.01;
        return new TeePoint(round($this->iXRadius * $tmpExp),
                round($this->iYRadius * $tmpExp));
    }

    protected function clearLists() {
        parent::clearLists();
        $this->explodedSlice = new ExplodedSliceList();  // Clears the array
    }

    public function doBeforeDrawChart() {
        parent::doBeforeDrawChart();

        /* re-order values */
        if ($this->getPieValues()->getOrder() != ValueListOrder::$NONE) {
            $this->getPieValues()->sort();
        }

        $this->removeOtherSlice();
        $tmpOtherMark= $this->otherMarkCustom();

        /* reset X order... */
        $this->getXValues()->fillSequence();

        /* calc "Other" slice... */
        if (($this->otherSlice != null) &&
            ($this->otherSlice->getStyle() != PieOtherStyles::$NONE) &&
            ($this->getYValues()->getTotalABS() > 0)) {
            $tmpHasOther = false;
            $tmpValue = 0;
            for ( $t = 0; $t < $this->getCount(); $t++) {
                $tmp = $this->getYValues()->value[$t];
                if ($this->otherSlice->getStyle() == PieOtherStyles::$BELOWPERCENT) {
                    $tmp = $tmp * 100.0 / $this->getYValues()->getTotalABS();
                }
                if ($tmp < $this->otherSlice->getValue()) {
                    $tmpValue += $this->getYValues()->value[$t];
                    $this->getXValues()->value[$t] = $this->BelongsToOther;
                    /* <-- belongs to "other" */
                    $tmpHasOther = true;
                }
            }

            // Add "Other" slice
            if ($tmpHasOther) {
                // 5.02
                $t= $this->add($this->OtherFlag, $tmpValue, $this->otherSlice->text, $this->otherSlice->getColor());

                $this->getYValues()->totalABS -= $tmpValue; /*   $total */
                $this->getYValues()->statsOk = true;

                if ($tmpOtherMark != null)
                {
                  $this->getMarks()->getPositions()->setPosition($t,$tmpOtherMark);
                }
            }
        }
    }

    // Returns index of "this" into all visible Pie series
    private function pieIndex()
    {
      $result = 0;

      for ($i=0; $i<$this->getChart()->getSeriesCount();$i++)
      {
        if ($this->chart->getSeries($i) === $this)
          break;
        else
          if ($this->chart->getSeries($i)->getActive() && $this->sameClass($this->chart->getSeries($i)))
            $result++;
      }

      return $result;
    }

    // Returns number of visible Pie series
    private function pieCount()
    {
      $result = 0;
      for ($i=0; $i<$this->chart->getSeriesCount();$i++)
      {
        if (($this->chart->getSeries($i)->getActive()) && ($this->sameClass($this->chart->getSeries($i))))
          $result++;
      }

      return $result;
    }

    private function guessRectangle()
    {
      $tmpCount = $this->pieCount();

      if ($tmpCount > 1)
      {
        $tmpIndex = $this->pieIndex();

        $tmpR = $this->chart->getChartRect();
        $tmpW = $tmpR->getWidth();
        $tmpH = $tmpR->getHeight();
        $tmpCols = round(sqrt($tmpCount));

        $tmpR->setX($tmpR->getX() + ($tmpIndex % $tmpCols) * ($tmpW / $tmpCols));
        $tmpR->setWidth(($tmpW / $tmpCols));

        $tmpRows = round(0.5 + sqrt($tmpCount));

        $tmpR->setY($tmpR->getY() + (($tmpIndex / $tmpCols)) * ($tmpH / $tmpRows));
        $tmpR->setHeight(($tmpH / $tmpRows));

        $this->chart->setChartRect($this->chart->getGraphics3D()->calcRect3D($tmpR, 0));
      }
    }

    // Calculate "this" Pie rectangle, when multiple pie series exist.
    protected function DoBeforeDrawValues()
    {
      $this->iOldChartRect =  new Rectangle($this->chart->getChartRect()->getX(),$this->chart->getChartRect()->getY(),$this->chart->getChartRect()->getWidth(),$this->chart->getChartRect()->getHeight());

      if ($this->multiPie == MultiPies::$AUTOMATIC)
        $this->guessRectangle();

      parent::doBeforeDrawValues();
    }

    // Resets back old chart rectangle
    protected function DoAfterDrawValues()
    {
      $this->chart->setChartRect($this->iOldChartRect);
      parent::doAfterDrawValues();      
    }

    private function removeOtherSlice()
		{
			/* remove "other" slice, if exists... */
			for ($t = 0; $t < $this->getCount(); $t++)
				if ($this->vxValues->getValue($t) == $this->OtherFlag)
				{
					$this->delete($t);
					break;
				}
		}

    private function otherMarkCustom()
	{
		for ($i = 0; $i < $this->getCount(); $i++)
		{
			if ($this->vxValues->getValue($i) == $this->OtherFlag)
			{
				$tmp = $this->getMarks()->getPositions()->getPosition($i);
				if ($tmp != null && $tmp->custom)
				{
					$result = new SeriesMarksPosition();
					$tmp->assign($result);
                    return $result;
                }
			    break;
		    }
		}
		return null;
	}

    protected function draw() 
    {
        if ($this->explodeBiggest > 0) {
            $this->calcExplodeBiggest();
        }

        $maxExplodedIndex = -1;
        $maxExploded = 0;
        $tmpCount = $this->getCount();

        // calc biggest exploded index
        for ( $t = 0; $t < sizeof($this->getExplodedSlice()); $t++) {
            if ($this->getExplodedSlice()->getSlice($t) > $maxExploded) {
                $maxExploded = round($this->getExplodedSlice()->getSlice($t));
                $maxExplodedIndex = $t;
            }
        }

        // calc each slice angles
        $this->calcAngles();

        //adjust circle rectangle
        $this->isExploded = ($maxExplodedIndex != -1);
        if ($this->isExploded) {
            $tmpOff = $this->calcExplodedOffset($maxExplodedIndex);

            $this->getCircleRect()->grow( -abs($tmpOff->getX()) / 2,
                                    -abs($tmpOff->getY()) / 2);

            //InflateRect(circleRect,-Math.abs(tmpOffX) /2 ,-Math.abs(tmpOffY) / 2);

            $this->adjustCircleRect();
            $this->calcRadius();
        }

        /* start xy pos */
        $ini = $this->angleToPos(0, $this->iXRadius, $this->iYRadius);

        $g = $this->chart->getGraphics3D();

        /* TODO
        if (($this->shadow != null) && ($this->shadow->getVisible()) &&
            (!$this->shadow->getColor()->isEmpty()) &&
            (($this->shadow->getWidth() != 0) || ($this->shadow->getHeight() != 0))) {
            $g->setBrush($this->shadow->getBrush());
            $g->getPen()->setVisible(false);
             $r = $this->rCircleRect;
            $r->offset($this->shadow->getWidth(), $this->shadow->getHeight());
            $g->ellipse($r, $this->getEndZ() - 10);
        } */

        //CDI PieOtherSlice Legend
        $rect = $this->chart->getChartRect();

        if ($this->getOtherSlice()->getLegend() != null &&
            $this->getOtherSlice()->getLegend()->getVisible()) {
            $tmp = $this->chart->getLegend();
            $this->chart->setLegend($this->getOtherSlice()->getLegend());
            $rect = $this->chart->doDrawLegend($g, $rect);
            $this->chart->setLegend($tmp);
        }

        if ($this->shouldDrawShadow())
        {                      // TODO review rect params
          $this->shadow->draw($g, new Rectangle($this->iCircleXCenter - $this->iXRadius,
                                       ($this->iCircleYCenter - $this->iYRadius) + ($this->endZ - $this->startZ),
                                       $this->iCircleXCenter + $this->iXRadius,
                                       ($this->iCircleYCenter + $this->iYRadius) + ($this->endZ - $this->startZ)),0,
                                       $this->endZ - $this->startZ);
        }

        /* exploded slices drawing order... */
        if ($this->chart->getAspect()->getView3D() && ($this->isExploded || ($this->iDonutPercent > 0))
            && (!$g->getSupportsFullRotation())) {
            if ($this->sortedSlice == null) {
                $this->sortedSlice = Array(); // TODO remove int[$tmpCount];
            }

            for ( $t = 0; $t < $tmpCount; $t++) {
                $this->sortedSlice[$t] = $t;
            }

            Utils::sort($this->sortedSlice, 0, $tmpCount-1, new CompareSlice());

            for ( $t = 0; $t < $tmpCount; $t++) {
                $this->drawValue($this->sortedSlice[$t]);
            }
        } else {
            parent::draw();
        }

        if ($this->getOtherSlice()->getLegend() != null &&
            $this->getOtherSlice()->getLegend()->getVisible()) {
            $tmp = $this->chart->getLegend();
            $this->chart->setLegend($this->getOtherSlice()->getLegend());
            $rect = $this->chart->doDrawLegend($g, $rect);
            $this->chart->setLegend($tmp);
        }
    }

    private function shouldDrawShadow()
    {
      return ($this->shadow != null) && ($this->shadow->bVisible) &&
        (!Utils::colorIsEmpty($this->shadow->getColor())) && (($this->shadow->getWidth() != 0) ||
        ($this->shadow->getHeight() != 0));
    }

    /*protected boolean drawMarksSeries(Series s, boolean activeRegion)
    {
      //OpenGL only
      IGraphics3D g = chart.getGraphics3D();
      g.elevate(90);
      return super.drawMarksSeries(s, activeRegion);
    }*/

    protected function drawMark($valueIndex, $s, $position) {

        if (!$this->belongsToOtherSlice($valueIndex)) {

             $tmpRadius = $this->calcExplodedRadius($valueIndex);

//            if ($this->chart->getGraphics3D()->getSupportsFullRotation()) {
//                $tmp = $this->angles[$valueIndex]->MidAngle + M_PI + 0.5 * M_PI;
//                $this->getMarks()->setZPosition($this->getStartZ());
//            } else {
//                $tmp = $this->angles[$valueIndex]->MidAngle;
//                $this->getMarks()->setZPosition($this->getEndZ());
//            }

             $tmp = $this->angles[$valueIndex]->MidAngle;
             $this->getMarks()->setZPosition($this->SliceEndZ($valueIndex));

             $position->arrowFix = true;
             $tmpLength = $this->getMarks()->getCallout()->getLength() +
                            $this->getMarks()->getCallout()->getDistance();
             $tmpXY = $this->angleToPos($tmp,
                                     $tmpRadius->x
                                     /*+Drawing.TextWidth(TeeCharForHeight)*/
                                     +
                                     $tmpLength,
                                     $tmpRadius->y
                                     /*+Drawing.FontHeight*/+ $tmpLength
                          );

            $position->arrowTo = $tmpXY;

            $tmpLength = $this->getMarks()->getCallout()->getDistance();
            $tmpXY = $this->angleToPos($tmp, $tmpRadius->x + $tmpLength,
                               $tmpRadius->y + $tmpLength);
            $position->arrowFrom = $tmpXY;

            if ($position->arrowTo->x > $this->iCircleXCenter) {
                $position->leftTop->x = $position->arrowTo->x;
            } else {
                $position->leftTop->x = $position->arrowTo->x - $position->width;
            }

            if ($position->arrowTo->y > $this->iCircleYCenter) {
                $position->leftTop->y = $position->arrowTo->y;
            } else {
                $position->leftTop->y = $position->arrowTo->y - $position->height;
            }

            if ($this->getMarksPie()->getVertCenter())
            {
              $tmpypos = $position->height / 2;
              if ($position->arrowTo->y > $this->iCircleYCenter) $position->arrowTo->y += $tmpypos;
              else $position->arrowTo->y -= $tmpypos;
            }

            if ($this->getMarksPie()->getLegSize() == 0)
            {
            /* TODO
              $position->hasMid = false;
              $position->midPoint->x = 0;
              $position->midPoint->y = 0;
              */
            }
            else
            {
              $position->hasMid = true;
              if ($position->arrowTo->x > $this->iCircleXCenter)
              {
                if (($position->arrowTo->x - $this->getMarksPie()->getLegSize()) < $position->arrowFrom->x)
                {
                  $position->midPoint->x = $position->arrowFrom->x;
                  $position->arrowTo->x = $position->arrowTo->x + $this->getMarksPie()->getLegSize();
                  $position->leftTop->x = $position->arrowTo->x;
                }
                else
                  $position->midPoint->x = $position->arrowTo->x - $this->getMarksPie()->getLegSize();
              }
              else
              {
                if (($position->arrowTo->x + $this->getMarksPie()->getLegSize()) > $position->arrowFrom->x)
                {
                  $position->midPoint->x = $position->arrowFrom->x;
                  $position->arrowTo->x = $position->arrowFrom->x - $this->getMarksPie()->getLegSize();
                  $position->leftTop->x = $position->arrowTo->x - $position->width;
                }
                else
                  $position->midPoint->x = $position->arrowTo->x + $this->getMarksPie()->getLegSize();
              }
              $position->midPoint->y = $position->arrowTo->y;
            }

            if ($this->getAutoMarkPosition()) {
                $this->getMarks()->antiOverlap($this->firstVisible, $valueIndex, $position);
            }

            parent::drawMark($valueIndex, $s, $position);
        }
    }

    public function getMarksPie()
    {
        if ($this->pieMarks == null) {
          $this->pieMarks = new PieMarks($this->chart, $this);
        }

        return $this->pieMarks;
    }

    public function setMarksPie($value)
    {
        $this->pieMarks = $value;
    }
    
    public function getMultiPie()
    {
        if ($this->multiPie == null) {
                return $this->multiPie;            
        }
    }

    public function setMultiPie($value)
    {
        $this->multiPie = $value;
    }
    

    public function drawOutlineSlice($valueIndex) {
        //TJ71012746 pending checks at
        //Graphics finishSide(endAngle, z0);
        $tmpOff = $this->calcExplodedOffset($valueIndex);

        $g = $this->chart->getGraphics3D();

        if (($this->chart->getAspect()->getView3D()) || ($this->iDonutPercent == 0)) {
            $g->pie($this->iCircleXCenter + $tmpOff->getX(),
                  $this->iCircleYCenter - $tmpOff->getY(), 0,0,
                  $this->iXRadius, $this->iYRadius, $this->getStartZ(), $this->SliceEndZ($valueIndex),
                  $this->angles[$valueIndex]->StartAngle + $this->rotDegree,
                  $this->angles[$valueIndex]->EndAngle + $this->rotDegree,
                  $this->dark3D,
                  false,
                  $this->iDonutPercent, $this->bevelPercent, $this->edgeStyle, false);
        } else {
            //if ( donutPercent>0 )
            $g->donut($this->iCircleXCenter + $tmpOff->getX(), $this->iCircleYCenter - $tmpOff->getY(),
                    $this->iXRadius, $this->iYRadius,
                    $this->angles[$valueIndex]->StartAngle + $this->rotDegree,
                    $this->angles[$valueIndex]->EndAngle + $this->rotDegree,
                    $this->iDonutPercent);
        }
    }

    public function drawPie($valueIndex,$last) 
    {
        $tmpOff = $this->calcExplodedOffset($valueIndex);
        $g = $this->chart->getGraphics3D();
//
//        if ((chart.getAspect().getView3D()) || (iDonutPercent == 0)) {
//            g.pie(iCircleXCenter + tmpOff.x,
//                  iCircleYCenter - tmpOff.y,
//                  iXRadius, iYRadius, getStartZ(), SliceEndZ(valueIndex),
//                  angles[valueIndex].StartAngle + rotDegree,
//                  angles[valueIndex].EndAngle + rotDegree,
//                  dark3D,
//                  isExploded,
//                  iDonutPercent);
//        } else {
//            //if ( donutPercent>0 )
//            g.donut(iCircleXCenter + tmpOff.x, iCircleYCenter - tmpOff.y,
//                    iXRadius, iYRadius,
//                    angles[valueIndex].StartAngle + rotDegree,
//                    angles[valueIndex].EndAngle + rotDegree,
//                    iDonutPercent);
//
//        }

//      int tmpOffX;
//			int tmpOffY;
//			CalcExplodedOffset(valueIndex, out tmpOffX, out tmpOffY);
//
			if ($this->angleSize < 360)
			{
				$this->isExploded = true;
			}

			$g->pie($this->iCircleXCenter,
					$this->iCircleYCenter, $tmpOff->getX(), $tmpOff->getY(),
					$this->iXRadius, $this->iYRadius, $this->startZ, $this->SliceEndZ($valueIndex),
					$this->angles[$valueIndex]->StartAngle + $this->rotDegree,
					$this->angles[$valueIndex]->EndAngle + $this->rotDegree,
					$this->dark3D,
					$this->isExploded,
					$this->iDonutPercent, $this->bevelPercent, $this->edgeStyle,$last);
    }

    /**
      * Called internally. Draws the "ValueIndex" point of the Series.
      *
      * @param valueIndex int
      */
    public function drawValue($valueIndex) {
        if (($this->getCircleWidth() > 4) && ($this->getCircleHeight() > 4)) {
            if (!$this->belongsToOtherSlice($valueIndex)) {
                // Slice pattern
                if ($this->usePatterns || $this->chart->getGraphics3D()->getMonochrome()) {
                    $this->bBrush->setStyle(GraphicsGD::getDefaultPattern($valueIndex));
                } else {
                    $this->bBrush->setSolid(true);
                }

                 $tmpColor = $this->chart->getGraphics3D()->getMonochrome() ?
                                 new Color(0,0,0) :
                                 $this->getValueColor($valueIndex);

                // Set slice back color
                $this->chart->setBrushCanvas($tmpColor, $this->bBrush, $this->calcCircleBackColor());
                $this->preparePiePen($this->chart->getGraphics3D(), $valueIndex);
                $this->drawPie($valueIndex, $valueIndex==$this->getCount()-1);
            }
        }
    }

    protected function numSampleValues() {
        return 8;
    }

    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);
        $this->fillSampleValues(8);
        $this->chart->getAspect()->setChart3DPercent(75);
        $this->getMarks()->getCallout()->setLength(0);
        $this->getMarks()->setDrawEvery(1);
        $this->disableRotation();
        $this->setColorEach($isEnabled);
    }

    //CDI PieOtherSlice.Legend
    public function legendToValueIndex($legendIndex) {
         $num = -1;

         $tmpIsOther = $this->chart->getLegend() != null &&
                     $this->chart->getLegend() == $this->getOtherSlice()->getLegend();

        for ( $t = 0; $t < $this->getCount(); $t++) {
             $tmp = $this->belongsToOtherSlice($t);
            if (($tmpIsOther && $tmp) || ((!$tmpIsOther) && (!$tmp))) {
                $num++;
                if ($num == $legendIndex) {
                    return $t;
                }
            }
        }
        return $legendIndex;
    }

    private function preparePiePen($g, $valueIndex) {
        $g->setPen($this->pen);
        if ($this->darkPen) {
            $tmpGraphics3D = new Graphics3D();
            $g->getPen()->setColor(GraphicsGD::applyDark($this->getValueColor($valueIndex),
                    $tmpGraphics3D->DARKERCOLORQUANTITY));
        }
    }

    protected function prepareLegendCanvas($g, $valueIndex, $backColor, $aBrush) {

        parent::prepareLegendCanvas($g, $valueIndex, $backColor, $aBrush);
        $this->preparePiePen($g, $valueIndex);

        // Slice pattern
        if ($this->usePatterns || $g->getMonochrome()) {
            $aBrush->setStyle(GraphicsGD::getDefaultPattern($valueIndex));
        } else {
            $aBrush->setSolid(true);
        }
    }

    /**
      * Returns true if indexed Slice belongs to the Otherslice.<br>
      * The "other" slice is controlled by the OtherSlice method, and is used
      * to join several small slices into a single bigger one.
      *
      * @param valueIndex int
      * @return boolean
      */
    public function belongsToOtherSlice($valueIndex) {
        return $this->vxValues->value[$valueIndex] == $this->BelongsToOther;
    }

    /**
      * Returns the pixel Screen Horizontal coordinate of the ValueIndex Series value.
      *
      * @param valueIndex int
      * @return int
      */
    public function calcXPos($valueIndex) {
        if ($this->vxValues->value[$valueIndex] == $this->OtherFlag) {
            return 0;
        } else {
            return parent::calcXPos($valueIndex);
        }
    }

    public function clicked($x, $y) {
        $tmpResult = parent::clicked($x, $y);
        if ($tmpResult == -1) {
            $tmpResult = $this->calcClickedPie($x, $y);
        }
        return $tmpResult;
    }

    private function calcClickedPie($x, $y) {
        if ($this->chart != null) {
             $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y,
                    $this->chart->getAspect()->getWidth3D());

            $x = $p->x;
            $y = $p->y;
        }

        $tmpAngle = $this->pointToAngle($x, $y);

        for ( $result = 0; $result < $this->getCount(); $result++) {
             $tmpOff = $this->calcExplodedOffset($result);

            if ((abs($x - $this->getCircleXCenter()) <= ($this->getXRadius() + $tmpOff->x)) &&
                (abs($y - $this->getCircleYCenter()) <= ($this->getYRadius() + $tmpOff->y))) {
                if ($this->angles[$result]->contains($tmpAngle)) {
                    return $result;
                }
            }
        }
        return -1;
    }

    public function getCountLegendItems() {
         $result = 0;
        for ( $t = 0; $t < $this->getCount(); $t++) {
            if ($this->belongsToOtherSlice($t)) {
                $result++;
            }
        }

        if ($this->chart->getLegend() != null &&
            $this->chart->getLegend() == $this->getOtherSlice()->getLegend()) {
            return $result;
        } else {
            return $this->getCount() - $result;
        }
    }

    public function createSubGallery($addSubChart) {
        parent::createSubGallery($addSubChart);
        $addSubChart->createSubChart($this->Language->getString("Patterns"));
        $addSubChart->createSubChart($this->Language->getString("Exploded"));
        $addSubChart->createSubChart($this->Language->getString("Shadow"));
        $addSubChart->createSubChart($this->Language->getString("Marks"));
        $addSubChart->createSubChart($this->Language->getString("SemiPie"));
        $addSubChart->createSubChart($this->Language->getString("NoBorder"));
        $addSubChart->createSubChart($this->Language->getString("DarkPen"));
    }

    public function setSubGallery($index) {
        switch ($index) {
        case 1:
            $this->setUsePatterns(true);
            break;
        case 2:
            $this->setExplodeBiggest(30);
            break;
        case 3: {
            $this->getShadow()->setVisible(true);
            $this->getShadow()->setWidth(10);
            $this->getShadow()->setHeight(10);
        }
        break;
        case 4: {
            $this->getMarks()->setVisible(true);
            $this->clear();
            $this->add(30, "A");
            $this->add(70, "B");
        }
        break;
        case 5:
            $this->setAngleSize(180);
            break;
        case 6:
            $this->getPen()->setVisible(false);
            break;
        case 7:
            $this->setDarkPen(true);
            break;
        default: break;
        }
    }

    /**
     * Accesses the properties for exploding any Pie slice.
     *
     * @return ExplodedSliceList
     */
    public function getExplodedSlice() {
      if ($this->explodedSlice==null)
      {
         $this->explodedSlice = new ExplodedSliceList();
      }

      return $this->explodedSlice;
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return $this->Language->getString("GalleryPie");
    }
}

 /**
 *
 * <p>Title: PieOtherSlice class</p>
 *
 * <p>Description: Pie series uses this class in its Pie.OtherSlice.</p>
 *
 * <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 *
 * @see Pie#getOtherSlice
 */
 class PieOtherSlice extends TeeBase {

    private $color;
    private $text;
    private $aValue;
    private $legend;
    private $series;
    private $style;


    public function __construct($c, $s) {
        $this->style = PieOtherStyles::$NONE;

        parent::__construct($c);
        $this->text = "Other";
        $tmpColor = new Color(0,0,0,0,true);  // EMPTY black
        $this->color = $tmpColor;
        if ($this->series == null) {
            $this->series = $s;
        }
        
        unset($tmpColor);
    }

    /**
    * The Color of the OtherSlice.
    *
    * @return Color
    */
    public function getColor() {
        return $this->color;
    }

    /**
    * Sets the Color of the OtherSlice.
    *
    * @param value Color
    */
    public function setColor($value) {
        $this->color = $this->setColorProperty($this->color, $value);
    }

    private function setLegend($value) {
        if ($this->legend != null) {
            $this->legend = $value;
            $this->legend->setSeries($this->series);
        }
    }

            /**
              * Sets the properties of the PieOtherSlice Legend.<br><br>
              *
              * Example This sample shows how to use PieOtherSlice Legend:<br><br>
              *
              * prepare "Other" to group values below 10<br>
              * pie1.getOtherSlice().setStyle(PieOtherStyles.BELOWVALUE);<br>
              * pie1.getOtherSlice().setValue(10);<br>
              * pie1.getOtherSlice().setText("Other");<br>
              * pie1.getOtherSlice().getLegend().setVisible( true );<br>
              * pie1.getOtherSlice().getLegend().setCustomPosition( true );<br>
              * pie1.getOtherSlice().getLegend().setLeft( 350 );<br>
              * pie1.getOtherSlice().getLegend().setTop( 150 );<br>
              *
              *
              * @return Legend
              */
    public function getLegend() {
        if ($this->legend == null) {
            $this->legend = new Legend($this->series->getChart());
            $this->legend->setVisible(false);
            $this->legend->setSeries($this->series);
        }
        return $this->legend;
    }

    /**
    * Title for otherSlice.<br>
    * Default value: Other
    *
    * @return String
    */
    public function getText() {
        return $this->text;
    }

    /**
    * Title for otherSlice.<br>
    * Default value: Other
    *
    * @param value String
    */
    public function setText($value) {
        $this->text = $this->setStringProperty($this->text, $value);
    }

    /**
    * Value (value or percentage) for Otherslice grouping.
    *
    * @return double
    */
    public function getValue() {
        return $this->aValue;
    }

    /**
    * Value (value or percentage) for Otherslice grouping.
    *
    * @param value double
    */
    public function setValue($value) {
        $this->aValue = $this->setDoubleProperty($this->aValue, $value);
    }

    /**
    * Either value or percentage to group the 'other' Pie slice.
    *
    *
    * @return PieOtherStyles
    */
    public function getStyle() {
        return $this->style;
    }

    /**
    * Sets either value or percentage to group the 'other' Pie slice.
    *
    *
    * @param value PieOtherStyles
    */
    public function setStyle($value) {
        if ($this->style != $value) {
            $this->style = $value;
            $this->invalidate();
        }
    }
 }

 /**
 *
 * <p>Title: PieShadow class</p>
 *
 * <p>Description: Pie series uses this class in its Pie.Shadow.</p>
 *
 * <p>Copyright (c) 2005-2007 by Steema Software SL. All Rights Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 *
 * @see Pie#getShadow
 */
 class PieShadow extends Shadow {

    public function __construct($c) {
        parent::Shadow($c);

        $tmpColor = new Color(120,120,120);  // DARK_GRAY
        $this->bBrush->setDefaultColor($tmpColor);
        $this->setDefaultVisible(false);
        $this->setDefaultSize(20);
        
        unset($tmpColor);
    }
 }

 /**
 *
 * <p>Title: ExplodedSliceList class</p>
 *
 * <p>Description: List to hold percents of exploding effect, one per each
 * Pie slice.</p>
 *
 * <p>Copyright (c) 2005-2007 by Steema Software SL. All Rights Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 *
 */
/* class ExplodedSliceList extends ArrayObject {

    public function ExplodedSliceList($capacity) {
        // TODO remove ? parent::ExplodedSliceList($capacity);
    }

    public function getSlice($index) {
        if ($index < sizeof($this)) {
            return ((int)parent::get($index));
        } else {
            return 0;
        }
    }

    public function setSlice($index, $value) {
        while (sizeof($this) <= $index) {
            $this->add(new Integer(0));
        }
        $this->set($index, new Integer($value));
    }

    private function exchange($a, $b) {
         $s = $this->getSlice($a);
        $this->setSlice($a, $this->getSlice($b));
        $this->setSlice($b, $s);
    }
 }
  */
class CompareSlice implements Comparator {
    public function compare($a, $b) {
        $totalAngle = 2.0 * M_PI * $this->angleSize / 360.0;
        $tmpA = $this->getAngleSlice($this->sortedSlice[$a], $totalAngle);
        $tmpB = $this->getAngleSlice($this->sortedSlice[$b], $totalAngle);
        if ($tmpA < $tmpB) {
            return -1;
        } else if ($tmpA > $tmpB) {
            return 1;
        } else {
            return 0;
        }
    }
}

/**
 *
 * <p>Title: SliceValueList class</p>
 *
 * <p>Description: List to hold percents of height for each Pie slice.</p>
 *
 * <p>Copyright (c) 2005-2007 by Steema Software SL. All Rights Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 *
 */
final class SliceValueList extends ArrayObject {
    public $OwnerSeries;

    public function getSlice($index) {
        if ($index < sizeof($this)) {
            return ((int)parent::offsetGet($index));
        } else {
            return 0;
        }
    }

    public function setSlice($index, $value) {
        while ($index >= sizeof($this)) {

            parent::append(0);
        }

        if ( ((int)parent::offsetGet($index)) != $value) {
            parent::offsetSet($index, $value);
            $this->OwnerSeries->repaint();
        }
    }

    private function exchange($a, $b) {
        $s = $this->getSlice($a);
        $this->setSlice($a, $this->getSlice($b));
        $this->setSlice($b, $s);
    }
}

/**
 *
 * <p>Title: ExplodedSliceList class</p>
 *
 * <p>Description: List to hold percents of exploding effect, one per each
 * Pie slice.</p>
 *
 * <p>Copyright (c) 2005-2007 by Steema Software SL. All Rights Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 *
 */
final class ExplodedSliceList extends ArrayObject {
    /**
    * The class constructor.
    */
    public function __construct() {
        parent::__construct();
    }

    public function getSlice($index) {
        if ($index < sizeof($this)) {
            return ((int)parent::offsetGet($index));
        } else {
            return 0;
        }
    }

    public function setSlice($index, $value) {
        while (sizeof($this) <= $index) {
            parent::append(0);
        }
        parent::offsetSet($index, $value);
    }

    private function exchange($a, $b) {
        $s = $this->getSlice($a);
        $this->setSlice($a, $this->getSlice($b));
        $this->setSlice($b, $s);
    }
}
?>