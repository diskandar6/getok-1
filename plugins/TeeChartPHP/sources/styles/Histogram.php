<?php
 /**
 * Description:  This file contains the following class:<br>
 * Histogram class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Histogram class
 *
 * Description: Histogram Series
 *
 * Example:
 * $series = new Histogram($myChart->getChart());
 * $series->fillSampleValues(10);
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Histogram extends BaseLine {

    private $linesPen;
    private $previous;

    public function __construct($c=null) {
        parent::__construct($c);
        
        $this->calcVisiblePoints = false;
        $this->getLinePen()->setColor(new Color(0,0,0));
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->linesPen);
        unset($this->previous);
    }          

    /**
    * Determines the pen to be used for drawing the line connecting all
    * points.
    *
    * @return ChartPen
    */
    public function getLinesPen() {
        if ($this->linesPen == null) {
            $this->linesPen = new ChartPen($this->chart, new Color(0,0,0));
        }
        return $this->linesPen;
    }

    /**
    * Defines the Brush fill for the Histogram series.
    *
    * @return ChartBrush
    */
    public function getBrush() {
        return $this->bBrush;
    }

    public function setChart($c) {
        parent::setChart($c);

        if ($this->linesPen != null) {
            $this->linesPen->setChart($c);
        }

        if ($this->bBrush != null) {
            $this->bBrush->setChart($c);
        }
    }

    /**
    * The Transparency level from 0 to 100%.
    * Default value: 0
    *
    * @return int
    */
    public function getTransparency() {
        return $this->bBrush->getTransparency();
    }

    /**
    * Sets Transparency level from 0 to 100%.
    * Default value: 0
    *
    * @param int $value
    */
    public function setTransparency($value) {
        $this->bBrush->setTransparency($value);
        $this->repaint();
    }

    private function visiblePoints() {
        $result = $this->chart->getPage()->getMaxPointsPerPage();
        return ($result == 0) ? $this->getCount() : $result;
    }

    public function calcHorizMargins($margins) {
        parent::calcHorizMargins($margins);
        $tmp = $this->visiblePoints();
        if ($tmp > 0) {
            $tmp = ($this->getHorizAxis()->iAxisSize / $this->visiblePoints()) / 2;
        }

        $margins->min += $tmp;
        $margins->max += $tmp;

        if ($this->getLinePen()->getVisible()) {
            $margins->max += $this->getLinePen()->getWidth();
        }
    }

    public function calcVerticalMargins($margins) {
        parent::calcVerticalMargins($margins);
        if ($this->getLinePen()->getVisible()) {
            $margins->min += $this->getLinePen()->getWidth();
        }
    }

    private function verticalLine($x, $y0, $y1) {
        if ($this->chart->getAspect()->getView3D()) {
            $this->chart->getGraphics3D()->verticalLine($x, $y0, $y1, $this->getMiddleZ());
        } else {
            $this->chart->getGraphics3D()->verticalLine($x, $y0, $y1);
        }
    }

    private function horizLine($x0, $x1, $y) {
        if ($this->chart->getAspect()->getView3D()) {
            $this->chart->getGraphics3D()->horizontalLine($x0, $x1, $y, $this->getMiddleZ());
        } else {
            $this->chart->getGraphics3D()->horizontalLine($x0, $x1, $y);
        }
    }

    /**
    * Called internally. Draws the "ValueIndex" point of the Series.
    *
    * @param int $valueIndex
    */
    public function drawValue($valueIndex) {
        $r = new Rectangle();

        $tmp = ($this->getHorizAxis()->iAxisSize / $this->visiblePoints()) / 2;
        if ($valueIndex == $this->firstVisible) {
            $r->x = $this->calcXPos($valueIndex) - $tmp;
            $r->width = 2 * $tmp;
        } else {
            $r->x = $this->previous;
            $r->width = $this->calcXPos($valueIndex) + $tmp - $r->x;
        }
        $this->previous = $r->getRight();
        $r->y = $this->calcYPos($valueIndex);
        $r->height = $this->getVertAxis()->getInverted() ? $this->getVertAxis()->iStartPos - $r->y :
                   $this->getVertAxis()->iEndPos - $r->y;
        $g = $this->chart->getGraphics3D();
        $g->getPen()->setVisible(false);

        if ($this->getBrush()->getVisible()) {
            $g->setBrush($this->getBrush());
            $g->getBrush()->setColor($this->getValueColor($valueIndex));

            if ($this->getVertAxis()->getInverted()) {
                $r->y++;
            }

            if ($this->chart->getAspect()->getView3D()) {
                $g->rectangleWithZ(Rectangle::fromLTRB($r->x, $r->y, $r->getRight() - 1, $r->getBottom()),
                            $this->getMiddleZ());

            } else {
                $g->rectangle($r);
            }

            if ($this->getVertAxis()->getInverted()) {
                $r->y--;
            }
        }

        if ($this->getLinePen()->getVisible()) {
            $g->setPen($this->getLinePen());

            if ($valueIndex == $this->firstVisible) {
                $this->verticalLine($r->x, $r->getBottom(), $r->y);
            } else {
                $this->verticalLine($r->x, $r->y, $this->calcYPos($valueIndex - 1));
            }

            $this->horizLine($r->x, $r->getRight(), $r->y);
            if ($valueIndex == $this->lastVisible) {
                $this->verticalLine($r->getRight() - 1, $r->y, $r->getBottom());
            }
        }
        if (($valueIndex > $this->firstVisible) && ($this->linesPen != null) &&
            $this->linesPen->getVisible()) {
            $tmp = $this->calcYPos($valueIndex - 1);
            $tmp = $this->getVertAxis()->getInverted() ? $this->min($r->y, $tmp) :
                  $this->max($r->y, $tmp);
            if (!$this->getLinePen()->getVisible()) {
                $tmp--;
            }
            $g->setPen($this->linesPen);
            $this->verticalLine($r->x, $r->getBottom(), $tmp);
        }
    }

    public function createSubGallery($addSubChart) {
        parent::createSubGallery($addSubChart);
        $addSubChart->createSubChart(Language::getString("Hollow"));
        $addSubChart->createSubChart(Language::getString("NoBorder"));
        $addSubChart->createSubChart(Language::getString("Lines"));
        $addSubChart->createSubChart(Language::getString("Transparency")); // 5.02
    }

    public function setSubGallery($index) {
        switch ($index) {
        case 1:
            $this->getBrush()->setVisible(false);
            break;
        case 2:
            $this->getLinePen()->setVisible(false);
            break;
        case 3:
            $this->getLinesPen()->setVisible(true);
            break;
        case 4:
            $this->setTransparency(30);
            break;
        default:
            parent::setSubGallery($index);
        }
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("GalleryHistogram");
    }
}

?>
