<?php
 /**
 * Description:  This file contains the following class:<br>
 * Area class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Area Class
 *
 * Description: Area Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 class Area extends Custom {

    private $useOrigin;
    private $origin;

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
       
        $this->drawArea = true;
        $this->allowSinglePoint=false;
        $this->getPointer()->setDefaultVisible(false);

        $tmpColor = new Color(0,0,0);  // Black
        $this->pAreaLines = new ChartPen($this->chart, $tmpColor);
        $this->pAreaLines->setVisible(false);
        //$tmpColor->setEmpty(true);
        $this->bAreaBrush = new ChartBrush($this->chart, $this->bBrush->getColor(), true); // TODO review $tmpColor->getEmpty());
        
        unset($tmpColor);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->useOrigin);
        unset($this->origin);
    }           

    /**
      * Determines how Multi-AreaSeries are displayed.<br>
      * Determines the kind of displayed Area when there's more than one Area
      * Series with the same ParentChart. The default value is None, meaning all
      * Areas will be drawn one behind the other. <br>
      * Stacked and Stacked100 modes will draw each Area on top of previous one.
      * <br>
      * Stacked100 adjusts each individual point to a common 0..100 axis scale.
      * <br>
      * The order which Series are accumulated depends on the Chart.SeriesList
      * method.<br>
      * Default value: None
      *
      * @see #setMultiArea
      *
      * @return MultiAreas
      */
    public function getMultiArea() {
        if ($this->iStacked == CustomStack::$STACK) {
            return MultiAreas::$STACKED;
        } else
        if ($this->iStacked == CustomStack::$STACK100) {
            return MultiAreas::$STACKED100;
        } else {
            return MultiAreas::$NONE;
        }
    }

    /**
      * Sets how multiple areas are displayed.
      *
      * @see #getMultiArea
      * @param value MultiAreas
      */
    public function setMultiArea($value) {
        if ($value != $this->getMultiArea()) {
            if ($value == MultiAreas::$NONE) {
                $this->setStacked( CustomStack::$NONE);
            } else
            if ($value == MultiAreas::$STACKED) {
                $this->setStacked( CustomStack::$STACK);
            } else
            if ($value == MultiAreas::$STACKED100) {
                $this->setStacked( CustomStack::$STACK100);
            }
        }
    }

    /**
      * Determines the Brush used to fill the background Area region.<br>
      * You can control the Area background color by using the Series.Color
      * method. <br>
      * Default value: Solid
      *
      * @return ChartBrush
      */
    public function getAreaBrush() {
        return $this->bAreaBrush;
    }

    /**
      *Determines how to fill the top 3D Area region.
      *
      * @return Gradient
      */
    public function getTopGradient() {
        return $this->bBrush->getGradient();
    }

    /**
      * Determines Gradient to fill the background Area region.
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * areaSeries = new Area(myChart.getChart());
      * areaSeries.getMarks().setVisible(false);
      * areaSeries.setColor(Color.RED);
      * areaSeries.fillSampleValues(10);
      * areaSeries.setTransparency(0);
      * areaSeries.setStacked(CustomStack.NONE);
      *
      * com.steema.teechart.drawing.Gradient tmpGradient = areaSeries.getGradient();
      * tmpGradient.setVisible(true);
      * tmpGradient.setUseMiddle(true);
      * tmpGradient.setDirection(GradientDirection.HORIZONTAL);
      * tmpGradient.setStartColor(Color.RED);
      * tmpGradient.setMiddleColor(Color.BLUE);
      * tmpGradient.setEndColor(Color.GREEN);
      * tmpGradient.setTransparency(0);
      * </font></pre></p>
      *
      * @return Gradient
      */
    public function getGradient() {
        return $this->getAreaBrush()->getGradient();
    }

    /**
      * Obsolete.&nbsp;Please use AreaLines instead.
      * @return ChartPen
      */
    public function getAreaLinesPen() {        
        return $this->getAreaLines();        
    }

    /**
      * Determines Pen to draw AreaLines.<br>
      * By default AreaLines .Visible is false, so you need first to set it to
      * true. You can control the Area Brush style by using AreaBrush.<br>
      * Default value: null
      *
      * @return ChartPen
      */
    public function getAreaLines() {
        return $this->pAreaLines;
    }

    /**
      * Aligns bottom of AreaSeries to the Origin property value.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getUseOrigin() {
        return $this->useOrigin;
    }

    /**
      * Enables/disables the setting of the Y value (via the Origin
      * property) that defines the bottom position for area points.
      * Default value: false
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * areaSeries = new Area(myChart.getChart());
      * areaSeries.getMarks().setVisible(false);
      * areaSeries.fillSampleValues(20);
      * areaSeries.setStacked(CustomStack.NONE);
      * areaSeries.setUseOrigin(false);
      * areaSeries.setOrigin(200);
      * </font></pre></p>
      *
      * @see #getOrigin
      * @param value boolean
      */
    public function setUseOrigin($value) {
        $this->useOrigin = $this->setBooleanProperty($this->useOrigin, $value);
    }

    /**
      * The axis value as a common bottom for all AreaSeries points.<br>
      * Default value: O
      *
      * @return double
      */
    public function getOrigin() {
        return $this->origin;
    }

    /**
      * Sets axis value as a common bottom for all AreaSeries points.<br>
      * Default value: O
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * areaSeries = new Area(myChart.getChart());
      * areaSeries.getMarks().setVisible(false);
      * areaSeries.fillSampleValues(20);
      * areaSeries.setStacked(CustomStack.NONE);
      * areaSeries.setUseOrigin(false);
      * areaSeries.setOrigin(200);
      * </font></pre></p>
      *
      * @param value double
      */
    public function setOrigin($value) {
        $this->origin = $this->setDoubleProperty($this->origin, $value);
    }

    /**
      * Returns the highest of all the current Series Y point values.
      *
      * @return double
      */
    public function getMaxYValue() {
         $result = parent::getMaxYValue();
        if ($this->yMandatory && $this->useOrigin && ($result < $this->origin)) {
            $result = $this->origin;
        }
        return $result;
    }

    /**
      * Returns the Minimum Value of the Series Y Values List.<br>
      * As some Series have more than one Y Values List, this Minimum Value is
      * the "Minimum of Minimums" of all Series Y Values lists.
      *
      * @return double
      */
    public function getMinYValue() {
         $result = parent::getMinYValue();
        if ($this->yMandatory && $this->useOrigin && ($result > $this->origin)) {
            $result = $this->origin;
        }
        return $result;
    }

    /**
      * The Maximum Value of the Series X Values List.
      *
      * @return double
      */
    public function getMaxXValue() {
         $result = parent::getMaxXValue();
        if ((!$this->yMandatory) && $this->useOrigin && ($result < $this->origin)) {
            $result = $this->origin;
        }
        return $result;
    }

    /**
      * The Minimum Value of the Series X Values List.
      *
      * @return double
      */
    public function getMinXValue() {
         $result = parent::getMinXValue();
        if ((!$this->yMandatory) && $this->useOrigin && ($result > $this->origin)) {
            $result = $this->origin;
        }
        return $result;
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return Language::getString("GalleryArea");
    }

    protected function getOriginPos($valueIndex) {
        if ($this->useOrigin) {
            return $this->calcPosValue($this->origin);
        } else {
            return parent::getOriginPos($valueIndex);
        }
    }

    protected function prepareLegendCanvas($g, $valueIndex, $backColor,$aBrush) {
        $backColor = $this->getAreaBrushColor($g->getBrush()->getForegroundColor());
        $g->setPen($this->getAreaLines());
        $aBrush = $this->getAreaBrush();
    }

    public function createSubGallery($addSubChart) {
        parent::createSubGallery($addSubChart);
        $addSubChart->createSubChart(Language::getString("Stairs"));
        $addSubChart->createSubChart(Language::getString("Marks"));
        $addSubChart->createSubChart(Language::getString("Colors"));
        $addSubChart->createSubChart(Language::getString("Hollow"));
        $addSubChart->createSubChart(Language::getString("NoLines"));
        //  AType.NumGallerySeries:=2;
        $addSubChart->createSubChart(Language::getString("Stack"));
        $addSubChart->createSubChart(Language::getString("Stack"));
        //  AType.NumGallerySeries:=1;
        $addSubChart->createSubChart(Language::getString("Points"));
        $addSubChart->createSubChart(Language::getString("Gradient"));
    }

    public function setSubGallery($index) {
        switch ($index) {
        case 1:
            $this->setStairs(true);
            break;
        case 2:
            $this->getMarks()->setVisible(true);
            break;
        case 3:
            $this->setColorEach(true);
            break;
        case 4:
            $this->getAreaBrush()->setVisible(false);
            break;
        case 5:
            $this->getAreaLines()->setVisible(false);
            break;
        case 6:
            $this->setMultiArea(MultiAreas::$STACKED);
            break;
        case 7:
            $this->setMultiArea(MultiAreas::$STACKED100);
            break;
        case 8:
            $this->getPointer()->setVisible(true);
            break;
        case 9:
            $this->getGradient()->setVisible(true);
            break;
        default: break;
        }
    }
}
?>