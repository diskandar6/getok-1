<?php
 /**
 * Description:  This file contains the following class:<br>
 * Pyramid class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Pyramid class
 *
 * Description: Pyramid Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Pyramid extends Series {

    private $size = 50;
    private $pen;

    public function __construct($c=null) {
        parent::__construct($c);
        
        $this->calcVisiblePoints = false;
        $this->setColorEach(true);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->size);
        unset($this->pen);
    }      

    /**
    * The size of Pyramid base relative to Chart Axis bounding width.<br>
    * Default value: 50
    *
    * <p>Example:
    * <pre><font face="Courier" size="4">
    * series.setSizePercent(60);
    * </font></pre></p>
    *
    * @return int
    */
    public function getSizePercent() {
        return $this->size;
    }

    /**
    * Sets size of Pyramid base relative to Chart Axis bounding width.<br>
    * Default value: 50
    *
    * @param value int
    */
    public function setSizePercent($value) {
        $this->size = $this->setIntegerProperty($this->size, $value);
    }

    /**
    * Element Pen characteristics.
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
    * Sets Brush characteristics for the Pyramid Series.
    *
    * @return ChartBrush
    */
    public function getBrush() {
        return $this->bBrush;
    }

    private function acumUpTo($upToIndex) {
        $result = 0;
        for ( $t = 0; $t <= $upToIndex; $t++) {
            $result += $this->mandatory->value[$t];
        }
        return $result;
    }

    public function calcHorizMargins($margins) {
        $margins->min = 20;
        $margins->max = 20;
    }

    protected function drawMark($valueIndex, $s, $position) {
        $position->leftTop->y = $this->getVertAxis()->calcPosValue($this->acumUpTo($valueIndex));
        parent::drawMark($valueIndex, $s, $position);
    }

    /**
    * Called internally. Draws the "ValueIndex" point of the Series.
    *
    * @param valueIndex int
    */
    public function drawValue($valueIndex) {
        if (!$this->isNull($valueIndex)) {
            $this->chart->setBrushCanvas($this->getValueColor($valueIndex), $this->getBrush(),
                                 $this->getBrush()->getColor());

            $this->chart->getGraphics3D()->setPen($this->getPen());

            $tmp = $this->acumUpTo($valueIndex - 1);
            $tmpTrunc = 100.0 - ($tmp * 100.0 / $this->getMandatory()->getTotal());

            $tmpSize = round($this->getSizePercent() * $this->getHorizAxis()->iAxisSize * 0.005);
            $tmpX = round($tmpTrunc * $tmpSize * 0.01);

            $r = new Rectangle();
            $r->x = $this->getHorizAxis()->calcPosValue($this->getMinXValue()) - $tmpX;
            $r->width = 2 * $tmpX;

            $tmpTruncZ = 100.0 - $tmpTrunc;
            $tmpZ = ($tmpTruncZ > 0) ?
                   round($tmpTruncZ * ($this->getEndZ() - $this->getStartZ()) *
                                       0.005) : 0;

            $r->height = $this->getVertAxis()->calcPosValue($tmp);

            $tmp += $this->mandatory->value[$valueIndex];
            $r->y = $this->getVertAxis()->calcPosValue($tmp);

            $r->height -= $r->y;

            $tmpTrunc = 100.0 - ($tmp * 100.0 / $this->mandatory->getTotal());

            $tmpZ2 = ($tmpTrunc < 100) ?
                    round($tmpTrunc * ($this->getEndZ() - $this->getStartZ()) *
                                        0.005) : 0;

            $this->chart->getGraphics3D()->pyramidTrunc($r, $this->getStartZ() + $tmpZ,
               $this->getEndZ() - $tmpZ, round($tmpTrunc * $tmpSize * 0.01), $tmpZ2);
        }
    }

    /**
    * Returns whether the Series needs to draw points in ascending/descending
    * order.<br>
    * Some Series need to draw their points in descending order (starting
    * from the last point to the first) depending on certain situations.
    * For example, when the horizontal axis Inverted property is true.
    *
    * @return boolean
    */
    public function drawValuesForward() {
        return!$this->getVertAxis()->getInverted();
    }

    /**
    * The Maximum Value of the Series X Values List.
    *
    * @return double
    */
    public function getMaxXValue() {
        return $this->getMinXValue();
    }

    /**
    * The Maximum Value of the Series Y Values List.
    *
    * @return double
    */
    public function getMaxYValue() {
        return $this->mandatory->getTotalABS();
    }

    /**
    * The Minimum Value of the Series X Values List.
    *
    * @return double
    */
    public function getMinXValue() {
        return $this->chart->getSeriesIndexOf($this);
    }

    /**
    * The Minimum Value of the Series Y Values List.
    *
    * @return double
    */
    public function getMinYValue() {
        return 0;
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("GalleryPyramid");
    }
}

?>