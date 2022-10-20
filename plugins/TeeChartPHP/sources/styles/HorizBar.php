<?php
 /**
 * Description:  This file contains the following class:<br>
 * HorizBar class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * HorizBar Class
 *
 * Description: Horizontal Bar Series
 * bars
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

  class HorizBar extends CustomBar {

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

        $this->setHorizontal();
        $this->notMandatory->setOrder(ValueListOrder::$ASCENDING);
        $this->mandatory->setOrder(ValueListOrder::$NONE);
        // TODO $tmpGradientDirection = new GradientDirection();
        // TODO $this->getGradient()->setDirection($tmpGradientDirection->HORIZONTAL);
    }

        /**
          * Gets descriptive text.
          *
          * @return String
          */
    public function getDescription() {
        return Language::getString("GalleryHorizBar");
    }

        /**
          * Defines the percent of bar Height, from 0 to 100.<br>
          * Default value: 70
          *
          * @return int
          */
    public function getBarHeightPercent() {
        return $this->barSizePercent;
    }

        /**
          * Defines the percent of bar Height, from 0 to 100.<br>
          * Default value: 70
          *
          * @param value int
          */
    public function setBarHeightPercent($value) {
        $this->setBarSizePercent($value);
    }

    protected function internalCalcMarkLength($valueIndex) {
        if ($valueIndex == -1) {
            return $this->maxMarkWidth();
        } else {
            return $this->getMarks()->textWidth($valueIndex);
        }
    }

    private function otherClicked($p, $tmpX, $endX, $tmpY) {
        if ($this->getBarStyle() == BarStyle::$ELLIPSE) {
            return GraphicsGD::pointInEllipse($p, new Rectangle($tmpX, $tmpY, $endX,
                                             $tmpY + $this->iBarSize));
        } else {
            return ($p->x >= $tmpX) && ($p->x <= $endX);
        }
    }

    private function inTriangle($x1, $x2, $tmpY, $p) {
        $this->triP = array();
        $this->iPoints= array();
        $this->triP[0]=new TeePoint();
        $this->triP[1]=new TeePoint();
        $this->triP[2]=new TeePoint();
        $this->triP[3]=new TeePoint();

        //$this->Point[] $this->triP = new TeePoint[3];
        $g = $this->chart->getGraphics3D();
        if ($this->chart->getAspect()->getView3D()) {
            $this->triP[0] = $g->calc3DPoint($x1, $tmpY, $this->getStartZ());
            $this->triP[1] = $g->calc3DPoint($x2, $tmpY + ($this->iBarSize / 2), $this->getMiddleZ());
            $this->triP[2] = $g->calc3DPoint($x1, $tmpY + $this->iBarSize, $this->getStartZ());
            return GraphicsGD::pointInPolygon($p, $this->triP);
        } else {
            return GraphicsGD::pointInHorizTriangle($p, $tmpY, $tmpY +
                        $this->iBarSize, $x1, $x2);
        }
    }

    protected function internalClicked($valueIndex, $point) {
        $tmpY = $this->calcYPos($valueIndex);

        if ((!$this->chart->getAspect()->getView3D()) &&
            (($point->y < $tmpY) || ($point->y > ($tmpY + $this->iBarSize)))) {
            return false;
        }

        $tmpX = $this->calcXPos($valueIndex);
        $endX = $this->getOriginPos($valueIndex);

        if ($endX < $tmpX) {
            $tmp = $tmpX;
            $tmpX = $endX;
            $endX = $tmp;
        }

        $tmpStyle = $this->getBarStyle();

        if ($tmpStyle == BarStyle::$INVPYRAMID) {
            return $this->inTriangle($endX, $tmpX, $tmpY, $point);
        } else
        if (($tmpStyle == BarStyle::$PYRAMID) | ($tmpStyle == BarStyle::$CONE)) {
            return $this->inTriangle($tmpX, $endX, $tmpY, $point);
        } else {
            if ($this->chart->getAspect()->getView3D()) {
                 $x = $point->x;
                 $y = $point->y;
                 $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y,
                        $this->getStartZ());
                $point->x = $p->x;
                $point->y = $p->y;
                if (($point->y >= $tmpY) && ($point->y <= ($tmpY + $this->iBarSize))) {
                    return $this->otherClicked($point, $tmpX, $endX, $tmpY);
                }
            } else {
                return $this->otherClicked($point, $tmpX, $endX, $tmpY);
            }
        }

        return false;
    }

    public function calcHorizMargins($margins) {
        parent::calcHorizMargins($margins);
        $tmp = $this->calcMarkLength( -1);
        if ($tmp > 0) {
            $tmp++;
        }
        if ($this->bUseOrigin && (parent::getMinXValue() < $this->dOrigin)) {
            $margins->min += $tmp;
        }
        if ((!$this->bUseOrigin) || (parent::getMaxXValue() > $this->dOrigin)) {
            if ($this->getHorizAxis()->getInverted()) {
                $margins->min += $tmp;
            } else {
                $margins->max += $tmp;
            }
        }
    }

    public function calcVerticalMargins($margins) {
        parent::calcVerticalMargins($margins);
        $this->internalApplyBarMargin($margins);
    }

        /**
          * Called internally. Draws the "ValueIndex" point of the Series.
          *
          * @param valueIndex int
          */
    public function drawValue($valueIndex) {
        parent::drawValue($valueIndex);
        $this->normalBarColor = $this->getValueColor($valueIndex);

         $r = new Rectangle();

        if ($this->normalBarColor != Color::EMPTYCOLOR()) {
            $r->y = $this->calcYPos($valueIndex);
        }

        if (($this->barSizePercent == 100) && ($valueIndex > 0)) {
            $r->height = $this->calcYPos($valueIndex - 1) - $r->y;
        } else {
            $r->height = $this->iBarSize + 1; // 5.02
        }

        $r->x = $this->getOriginPos($valueIndex);
        $r->width = $this->calcXPos($valueIndex) - $r->x;

        if (!$this->getPen()->getVisible()) {
            if ($r->getRight() > $r->x) {
                $r->width++;
            } else {
                $r->x++;
                //r.Right--;
            }
            $r->height++; // 5.02
        }

        $this->iBarBounds = $r;

        if ($r->getRight() > $r->x) {
            $this->drawBar($valueIndex, $r->x, $r->getRight());
        } else {
            $this->drawBar($valueIndex, $r->getRight(), $r->x);
        }
    }

    protected function drawMark($valueIndex, $s, $position) {
        $difH = $this->iBarSize / 2;
        $difW = $this->getMarks()->getCallout()->getLength() +
                   $this->getMarks()->getCallout()->getDistance();
        $tmp = ($position->arrowFrom->getX() < $this->getOriginPos($valueIndex));
        if ($tmp) {
            $difW = -$difW - $position->width;
        }

        $position->leftTop->setX($position->leftTop->getX() + $difW + ($position->width / 2));
        $position->leftTop->setY($position->leftTop->getY() + $difH + ($position->height / 2));
        $position->arrowTo->setX($position->arrowTo->getX() + $difW);
        $position->arrowTo->setY($position->arrowTo->getY() + $difH);
        $position->arrowFrom->setY($position->arrowFrom->getY() + $difH);

        if ($tmp) {
            $position->arrowFrom->setX($position->arrowFrom->getX() - $this->getMarks()->getCallout()->getDistance());
        } else {
            $position->arrowFrom->setX($position->arrowFrom->getX() + $this->getMarks()->getCallout()->getDistance());
        }

        parent::drawMark($valueIndex, $s, $position);
    }

        /**
          * The pixel Screen Horizontal coordinate of the ValueIndex Series
          * value.<br>
          * This coordinate is calculated using the Series associated Horizontal
          * Axis.
          *
          * @param valueIndex int
          * @return int
          */
    public function calcXPos($valueIndex) {
        if (($this->iMultiBar == MultiBars::$NONE) || ($this->iMultiBar == MultiBars::$SIDE) ||
            ($this->iMultiBar == MultiBars::$SIDEALL)) {
            return parent::calcXPos($valueIndex);
        } else {
            $tmpValue = $this->vxValues->value[$valueIndex] +
                              $this->pointOrigin($valueIndex, false);
            if (($this->iMultiBar == MultiBars::$STACKED) ||
                ($this->iMultiBar == MultiBars::$SELFSTACK)) {
                return $this->calcXPosValue($tmpValue);
            } else {
                $tmp = $this->pointOrigin($valueIndex, true);
                return ($tmp != 0) ? $this->calcXPosValue($tmpValue * 100.0 / $tmp) : 0;
            }
        }
    }

        /**
          * The vertical Bar position is the "real" Y pos plus the Barwidth by our
          * BarSeries order.<br>
          * This coordinate is calculated using the Series associated Vertical Axis.
          *
          * @param valueIndex int
          * @return int
          */
    public function calcYPos($valueIndex) {
        (int) $result=0;

        if ($this->iMultiBar == MultiBars::$SIDEALL) {
            $result = $this->getVertAxis()->calcYPosValue($this->iPreviousCount + $valueIndex) -
                     ($this->iBarSize / 2);
        } else
        if ($this->iMultiBar == MultiBars::$SELFSTACK) {
            $result = (parent::calcYPosValue($this->getMinYValue())) - ($this->iBarSize / 2);
        } else {
            $result = parent::calcYPos($valueIndex);
            if ($this->iMultiBar != MultiBars::$NONE) {
                $result += MathUtils::round($this->iBarSize *
                                         ((($this->iNumBars * 0.5) -
                                           (1 + $this->iNumBars - $this->iOrderPos))));
            } else {
                $result -= ($this->iBarSize / 2);
            }
        }

        return $this->applyBarOffset($result);
    }

    private function drawBar($barIndex, $startPos, $endPos) {
        $g = $this->chart->getGraphics3D();

        $this->setPenBrushBar($this->normalBarColor);
        $r = $this->iBarBounds;

        $tmpMidY = ($r->y + $r->getBottom()) / 2;
        $tmp = $this->doGetBarStyle($barIndex);
        if ($this->chart->getAspect()->getView3D()) {

            if ($tmp == BarStyle::$RECTANGLE) {
                $g->cube($startPos, $r->y, $endPos, $r->getBottom(), $this->getStartZ(), $this->getEndZ(),
                       $this->bDark3D);
            } else
            if ($tmp == BarStyle::$PYRAMID) {
                $g->pyramid(false, $startPos, $r->y, $endPos, $r->getBottom(), $this->getStartZ(),
                          $this->getEndZ(),
                          $this->bDark3D);
            } else
            if ($tmp == BarStyle::$INVPYRAMID) {
                $g->pyramid(false, $endPos, $r->y, $startPos, $r->getBottom(), $this->getStartZ(),
                          $this->getEndZ(),
                          $this->bDark3D);
            } else
            if ($tmp == BarStyle::$CYLINDER) {
                $g->cylinder(false, $r, $this->getStartZ(), $this->getEndZ(), $this->bDark3D);
            } else
            if ($tmp == BarStyle::$ELLIPSE) {
                $g->ellipse($this->iBarBounds, $this->getMiddleZ());
            } else
            if ($tmp == BarStyle::$ARROW) {
                $g->arrow(true, new TeePoint($startPos, $tmpMidY),
                        new TeePoint($endPos, $tmpMidY),
                        $r->height, $r->height / 2, $this->getMiddleZ());
            } else
            if ($tmp == BarStyle::$RECTGRADIENT) {
                $g->cube($startPos, $r->y, $endPos, $r->getBottom(), $this->getStartZ(), $this->getEndZ(),
                       $this->bDark3D);
                if ($g->getSupportsFullRotation() ||
                    $this->chart->getAspect()->getOrthogonal()) {
                    $this->doGradient3D($barIndex,
                                 $g->calc3DPoint($startPos, $r->y, $this->getStartZ()),
                                 $g->calc3DPoint($endPos, $r->getBottom(), $this->getStartZ()));
                }
            } else
            if ($tmp == BarStyle::$CONE) {
                $g->cone(false, $this->iBarBounds, $this->getStartZ(), $this->getEndZ(), $this->bDark3D,
                       $this->conePercent);
            }
        } else {
            if (($tmp == BarStyle::$RECTANGLE) |
                ($tmp == BarStyle::$CYLINDER)) {
                $this->barRectangle($this->normalBarColor, $this->iBarBounds);
            } else
            if (($tmp == BarStyle::$PYRAMID) |
                ($tmp == BarStyle::$CONE)) {
                $this->pCone=array();
                /*$this->Point[]*/ $this->pCone[0] = new TeePoint($startPos, $r->y);
                    $this->pCone[1] = new TeePoint($endPos, $tmpMidY);
                    $this->pCone[2] = new TeePoint($startPos, $r->getBottom());
                $g->polygon($this->pCone);
            } else
            if ($tmp == BarStyle::$INVPYRAMID) {
                $this->pInv=array();
                /*$this->Point[]*/ $this->pInv[0] = new TeePoint($endPos, $r->y);
                    $this->pInv[0] = new TeePoint($startPos, $tmpMidY);
                    $this->pInv[0] = new TeePoint($endPos, $r->getBottom());
                $g->polygon($this->pInv);
            } else
            if ($tmp == BarStyle::$ELLIPSE) {
                $g->ellipse($this->iBarBounds);
            } else
            if ($tmp == BarStyle::$ARROW) {
                $g->arrow(true, new TeePoint($startPos, $tmpMidY),
                        new TeePoint($endPos, $tmpMidY),
                        $r->height, $r->height / 2, $this->getMiddleZ());
            } else
            if ($tmp == BarStyle::$RECTGRADIENT) {
                $this->doBarGradient($barIndex,
                              new Rectangle($startPos, $r->y, $endPos - $startPos,
                                            $r->height));
            }
        }
    }

    protected function drawSeriesForward($valueIndex) {
        if ($this->iMultiBar == MultiBars::$NONE) {
            return true;
        } else
        if (($this->iMultiBar == MultiBars::$NONE) | ($this->iMultiBar == MultiBars::$SIDEALL)) {
            return false;
        } else
        if (($this->iMultiBar == MultiBars::$STACKED) |
            ($this->iMultiBar == MultiBars::$SELFSTACK)) {
            $result = $this->mandatory->value[$valueIndex] >= 0; /* 5.01 */
            if ($this->getHorizAxis()->getInverted()) {
                $result = !$result;
            }
            return $result;
        } else {
            return!$this->getHorizAxis()->getInverted();
        }
    }

    protected function getOriginPos($valueIndex) {
        return $this->internalGetOriginPos($valueIndex, $this->getHorizAxis()->iStartPos);
    }

        /**
          * The Maximum Value of the Series X Values List.
          *
          * @return double
          */
    public function getMaxXValue() {
        return $this->maxMandatoryValue(parent::getMaxXValue());
    }

        /**
          * The Minimum Value of the Series X Values List.
          *
          * @return double
          */
    public function getMinXValue() {
        return $this->minMandatoryValue(parent::getMinXValue());
    }

        /**
          * The Minimum Value of the Series Y Values Lists.<br>
          * As some Series have more than one Y Values List, this Minimum Value is
          * the "Minimum of Minimums" of all Series Y Values lists. <br>
          *
          * @return double
          */
    public function getMinYValue() {
        if ($this->iMultiBar == MultiBars::$SELFSTACK) {
            return $this->getChart()->getSeriesIndexOf($this);
        } else {
            return parent::getMinYValue();
        }
    }

        /**
          * The Maximum Value of the Series Y Values List.
          *
          * @return double
          */
    public function getMaxYValue() {
        if ($this->iMultiBar == MultiBars::$SELFSTACK) {
            return $this->getMinYValue();
        } else {
            return ($this->iMultiBar == MultiBars::$SIDEALL) ?
                    $this->iPreviousCount + $this->getCount() - 1 :
                    parent::getMaxYValue();
        }
    }
}

?>