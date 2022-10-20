<?php

 /**
 * Description:  This file contains the following class:<br>
 * Volume class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Volume class
 *
 * Description: Volume Series
 *
 * Example:
 * $volumeSeries = new Volume($myChart->getChart());
 * $volumeSeries->getMarks()->setVisible(false);
 * $volumeSeries->setColor(Color::getRed());
 * $volumeSeries->fillSampleValues(50);
 * $volumeSeries->setUseOrigin(true);
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Volume extends Custom {

    private $useYOrigin = false;
    private $origin;
    private $iColor;

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

        $this->drawArea = false;
        $this->drawBetweenPoints = false;
        $this->setClickableLine(false);
        $this->getPointer()->setDefaultVisible(false);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->useYOrigin);
        unset($this->origin);
        unset($this->iColor);
    }               

    private function prepareCanvas($g, $forced, $aColor) {
        if ($forced || ($aColor != $this->iColor)) {
            $g->setPen($this->getLinePen());
            $g->getPen()->setColor($aColor);
        }
    }

    /**
      * Enables/Disables the Y value that defines the bottom position for Volume
      * points.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getUseOrigin() {
        return $this->useYOrigin;
    }

    /**
      * Enables/Disables the Y value that defines the bottom position for Volume
      * points.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setUseOrigin($value) {
        $this->useYOrigin = $this->setBooleanProperty($this->useYOrigin, $value);
    }

    /**
      * Defines the YValue used as the origin for the specified Volume Series.
      * <br>
      * Default value: 0
      *
      * @return double
      */
    public function getOrigin() {
        return $this->origin;
    }

    /**
      * Defines the YValue used as the origin for the specified Volume Series.
      * <br>
      * Default value: 0
      *
      * @param value double
      */
    public function setOrigin($value) {
        $this->origin = $this->setDoubleProperty($this->origin, $value);
    }

    protected function addSampleValues($numValues) {
        $r = $this->randomBounds($numValues);

        for ( $t = 1; $t <= $numValues; $t++) {
            $this->addXY($r->tmpX, MathUtils::round($r->DifY / 15) * $r->Random());
            $r->tmpX += $r->StepX;
        }
    }

    public function createSubGallery($addSubChart) {
        parent::createSubGallery($addSubChart);
        $addSubChart->createSubChart(Language::getString("Dotted"));
        $addSubChart->createSubChart(Language::getString("Colors"));
        $addSubChart->createSubChart(Language::getString("Origin")); // 5.02
    }

    public function setSubGallery($index) {
        switch ($index) {
        case 1:
            $tmpDashStyle = new DashStyle();
            $this->getLinePen()->setStyle($tmpDashStyle->DOT);
            break;
        case 2:
            $this->setColorEach(true);
            break;
        case 3:
            $this->setUseOrigin(true);
            break;
        default:
            parent::setSubGallery($index);
        }
    }

    protected function drawLegendShape($g, $valueIndex,$r) {
        $this->prepareCanvas($g, true, $this->getValueColor($valueIndex)); //$this->CDI
        $g->horizontalLine($r->x, $r->getRight(), ($r->y + $r->getBottom()) / 2);
    }

    /**
      * Called internally. Draws the "ValueIndex" point of the Series.
      *
      * @param valueIndex int
      */
    public function drawValue($valueIndex) {
         $g = $this->chart->getGraphics3D();
        $g->setPen($this->getLinePen());
        $this->prepareCanvas($this->chart->getGraphics3D(), $valueIndex == $this->firstVisible, $this->getValueColor($valueIndex));

        // moves to x,y coordinates and draws a vertical bar to top or bottom,
        // depending on the vertical Axis.Inverted property

        if ($this->useYOrigin) {
            $tmpY = $this->calcYPosValue($this->origin); /* 5.02 */
        } else
        if ($this->getVertAxis()->getInverted()) {
            $tmpY = $this->getVertAxis()->iStartPos;
        } else {
            $tmpY = $this->getVertAxis()->iEndPos;
        }

        if ($this->chart->getAspect()->getView3D()) {
            $g->verticalLine($this->calcXPos($valueIndex), $this->calcYPos($valueIndex), $tmpY,
                           $this->getMiddleZ());
        } else {
            $g->verticalLine($this->calcXPos($valueIndex), $tmpY, $this->calcYPos($valueIndex));
            /* 5.02 */
        }
    }

    /**
      * Returns the ValueIndex of the "clicked" point in the Series.
      *
      * @param x int
      * @param y int
      * @return int
      */
    public function clicked($x, $y) {
        if ($this->chart != null) {
            $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y, $this->getStartZ());
            $x = $p->getX();
            $y = $p->getY();

            $tmpOrigin=$this->originPosition();
            $tmpX;

            if (($this->firstVisible > -1) && ($this->lastVisible > -1)) {
                for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {
                    $tmpX=$this->calcXPos($t);

                    if (MathUtils::pointInLineTolerance($p,$tmpX,$tmpOrigin,
                            $tmpX,$this->calcYPos($t),$this->getLinePen()->getWidth()))
                    {
                        $this->doClickPointer($t, $x, $y);
                        return $t;
                    }
                }
            }
        }
        return -1;
    }

    public function originPosition()
        {
              if (useYOrigin)
                  return calcYPosValue(this.getOrigin());
            else
              if (getVertAxis().getInverted())
                  return (int)Math.round(getVertAxis().iStartPos);
              else return (int)Math.round(getVertAxis().iEndPos);
        }

    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);
        $this->fillSampleValues(26);
        $this->point->setInflateMargins(true);
    }

    public function setColor($color) {
        parent::setColor($color);
        $this->getLinePen()->setColor($color);
    }

    protected function numSampleValues() {
        return 40;
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return Language::getString("GalleryVolume");
    }
}

?>