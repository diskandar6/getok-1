<?php
/**
 * Description:  This file contains the following class:<br>
 * SeriesBand class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * SeriesBand class
 *
 * Description: Series Band tool.
 * method
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
 
class SeriesBand extends ToolSeries {

    private $boundValue;
    private $drawBehindSeries;
    private $series2;

    private $iSerie1Drawed;
    private $iSerie2Drawed;
    
    public function __construct($c=null) {
        parent::__construct($c);
        
        $this->drawBehindSeries = true;
    
        $this->getBrush()->setColor(Color::getWhite());
        $this->getPen()->setVisible(false);
    }    
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->boundValue);
        unset($this->drawBehindSeries);
        unset($this->series2);
        unset($this->iSerie1Drawed);
        unset($this->iSerie2Drawed);
    }       
    
    /**
     * Constant value to be used as one of the limits of band filled areas. <br>
     * Note: BoundValue property is only used when the <see cref="Series2"/> 
     * property is not set (ie: is null). <br>
     *
     * @return double
     */
    public function getBoundValue() {
        return (double) $this->boundValue; 
    }
    
    /**
     * Sets a constant value to be used as one of the limits of band 
     * filled areas. <br>
     * Note: BoundValue property is only used when the <see cref="Series2"/> 
     * property is not set (ie: is null). <br> 
     *
     * @param value double
     */
    public function setBoundValue($value){ 
        $this->boundValue = $value; 
    }

   /**
     * Flag which causes filling to occur before or after the series are 
     * displayed. <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getDrawBehindSeries() {
        return $this->drawBehindSeries; 
    }
    
    /**
     * Sets a flag which causes filling to occur before or after the series are 
     * displayed. <br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setDrawBehindSeries($value){
        if ($this->drawBehindSeries != $value) {
            $this->drawBehindSeries = $value;
            $this->invalidate();
        }
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() { 
        return Language::getString("SeriesBandTool");
    }
    
    /**
     * Gets detailed descriptive text.
     *
     * @return String
     */
    public function getSummary() { 
        return Language::getString("SeriesBandSummary");
    }

    /**
     * Second series associated to this tool. <br>
     * SeriesBand tool needs two series to fill the area in between them. <br>
     *
     * @return Series
     */
    public function getSeries2() {
        return $this->series2;
    }
    
   
    /**
     * Element Brush characteristics.
     * @return ChartBrush
     */
    public function getBrush() {
        if ($this->bBrush == null) {
            $this->bBrush = new ChartBrush($this->chart);
        }
        return $this->bBrush;
    }
    
    /**
     * Set Brush characteristics.
     *
     * @param value ChartBrush
     */
    public function setBrush($value) {
        $this->bBrush = $value;
    }
    
    /**
     * Indicates the kind of pen used to draw Series Band.
     *
     * @return ChartPen
     */
    public function getPen() {
        if ($this->pPen == null) {
            $this->pPen = new ChartPen($this->chart, Color::BLACK());
        }        
        return $this->pPen;
    }

    /**
     * Determines the kind of pen used to draw Series Band.
     *
     * @param value ChartPen
     */
    public function setPen($value) {
    	if ($value!=null) {
            $this->pPen->assign($value);
        }
    }

    /**
     * The amount of semi-glass effect (opacity) to apply when filling the area
     * between the two series as percentage.
     * Default value: 0
     *
     * @return int
     */
    public function getTransparency() {
        return $this->getBrush()->getTransparency();
    }

    /**
     * Sets the amount of semi-glass effect (opacity) to apply when filling the 
     * area between the two series as percentage.
     * Default value: 0
     *
     * @param value int
     */
    public function setTransparency($value) {
        $this->getBrush()->setTransparency($value);
    }
    
    /**
     * The gradient colors used to fill the area between the two series.
     *
     * @return Gradient
     */
    public function getGradient() {
        return $this->bBrush->getGradient();
    }
    
    /**
     * Sets the gradient colors used to fill the area between the two series.
     *
     * @param value Gradient
     */
    public function setGradient($value) {
        $this->bBrush->setGradient($value);
    }

    //private members
    private function setEvents($aSeries) {        
        if ($aSeries != null) {
            /* TODO
            $aSeries->removeSeriesPaintListener( new SeriesPaintAdapter() {
                public void seriesPainting(ChartDrawEvent e) {  */
                    $this->doBeforeDrawValues($aSeries);
            /*    };

                public void seriesPainted(ChartDrawEvent e) {*/
                    $this->doAfterDrawValues($aSeries);
            /*    };
            });
            
            aSeries.addSeriesPaintListener( new SeriesPaintAdapter() {
                public void seriesPainting(ChartDrawEvent e) {
                    doBeforeDrawValues(aSeries);
                };

                public void seriesPainted(ChartDrawEvent e) {
                    doAfterDrawValues(aSeries);
                };
            }); */
        }
    }

    //protected and internal members
    public function chartEvent(/*ChartDrawEvent*/ $ce) {        
        parent::chartEvent($ce);
        if (/*(ce.getID()==ChartDrawEvent.PAINTING) &&*/
              ($ce->getDrawPart() == ChartDrawEvent::$SERIES)) {
            $this->iSerie1Drawed = false;
            $this->iSerie2Drawed = false;
            $this->doBeforeDrawValues($this->iSeries);            
        }                
        else
        {
            $this->doAfterDrawValues($this->iSeries);            
        }    
    }

    public function setSeries($value)
    {
        parent::setSeries($value);
        $this->setEvents($this->iSeries);
    }

    /**
     * Sets the second series associated to this tool.<br> 
     * SeriesBand tool needs two series to fill the area in between them. <br>
     *
     * @param value Series
     */    
    public function setSeries2($value) {
        if ($this->series2 != $value) {
            $this->series2 = $value;
            $this->setEvents($this->series2);
        }
    }

    protected function doBeforeDrawValues($sender) {
        if ($this->drawBehindSeries) {
            if ($this->iSeries != null && $sender === $this->iSeries) {
                $this->iSerie1Drawed = true;
            }
            if ($this->series2 != null && $sender === $this->series2) {
                $this->iSerie2Drawed = true;
            }

            if ($this->series2 != null) {
                if (!($this->iSerie1Drawed && $this->iSerie2Drawed)) {
                    $this->drawBandTool();
                }
            }
            else {
                $this->drawBandTool();
            }
        }
    }

    protected function doAfterDrawValues($sender) {
        if (!$this->drawBehindSeries) {
            if ($this->iSeries != null && $sender === $this->iSeries) { 
                $this->iSerie1Drawed = true;
            }
            if ($this->series2 != null && $sender === $this->series2) {
                $this->iSerie2Drawed = true;
            }

            if ($this->iSerie1Drawed && ($this->iSerie2Drawed || $this->series2 === null)) {
                $this->drawBandTool();
            }
        }
    }

    protected function drawBandTool() {
        $l1=0;
        $l2=0;
        $i=0;
        $tmpZ=0;
       
        $tmpPoints=Array();        
        $g = $this->getChart()->getGraphics3D();
        
        $tmpMax=0;
        
        if ($this->getActive() && $this->chart != null && $this->iSeries != null) {
            $this->iSeries->calcFirstLastVisibleIndex();
            if ($this->series2 != null) {
                $this->series2->calcFirstLastVisibleIndex();
            }

            if (($this->series2 != null && $this->iSeries->getFirstVisible() != -1 && 
                    $this->series2->getFirstVisible() != -1) || 
                    $this->iSeries->getFirstVisible() != -1) {
                $l1 = ($this->iSeries->getLastVisible() - $this->iSeries->getFirstVisible()) + 1;

                if ($this->iSeries->drawBetweenPoints && $this->iSeries->getFirstVisible() > 0) {
                        ++$l1;
                }

                if ($this->series2 != null) {
                    $l2 = ($this->series2->getLastVisible() - 
                            $this->series2->getFirstVisible()) + 1;

                    if ($this->iSeries->drawBetweenPoints && 
                            $this->series2->getFirstVisible() > 0) {
                            ++$l2;
                    }
                }
                else {
                    $l2 = 2;
                }

                $tmpPoints = Array(); //new Point[l1 + l2];
                for ($ii=0;$ii< ($l1+$l2);$ii++)
                    $tmpPoints[]=null;

                if (sizeof($tmpPoints)>0) {                    
                    $i = 0;
                    if ($this->iSeries->getFirstVisible() != -1) {
                        $tmpMax = max(0, $this->iSeries->getFirstVisible() - 1);
                        for ($t = $tmpMax; $t <= $this->iSeries->getLastVisible(); $t++) 
                        {
                            $tmpPoints[$i] = new TeePoint($this->iSeries->calcXPos($t), 
                                    $this->iSeries->calcYPos($t));
                            $i++;
                        }
                    }

                    if ($this->series2 != null) {
                        if ($this->series2->getFirstVisible() != -1) {
                            $tmpMax = max(0, $this->series2->getFirstVisible() - 1);
                            for ($t = $this->series2->getLastVisible(); $t >= $tmpMax; 
                            $t--) {
                                $tmpPoints[$i] = new TeePoint($this->series2->calcXPos($t),
                                        $this->series2->calcYPos($t));
                                $i++;
                            }
                        }
                    }
                    else {                        
                        $tmpPoints[$i] = new TeePoint($tmpPoints[$i - 1]->x, 
                                $this->iSeries->calcYPosValue($this->boundValue));
                        $tmpPoints[$i + 1] = new TeePoint($tmpPoints[0]->x, 
                                $tmpPoints[$i]->y);
                    }

                    if ($this->series2 != null) {
                        $tmpZ = max($this->iSeries->getStartZ(), 
                                $this->series2->getStartZ());
                    }
                    else {
                        $tmpZ = $this->iSeries->getStartZ();
                    }
                    
                    $g->setBrush($this->bBrush);
                    $g->setPen($this->pPen);
                    $g->clipCube($this->chart->getChartRect(), 0, 
                            $this->chart->getAspect()->getWidth3D());
                    $g->polygonZ($tmpZ, $tmpPoints);
                    $g->unClip();
                }                
            }
        }
    }   
}
?>