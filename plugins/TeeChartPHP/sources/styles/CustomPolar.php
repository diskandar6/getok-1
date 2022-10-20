<?php
 /**
 * Description:  This file contains the following class:<br>
 * CustomPolar class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: CustomPolar class</p>
  *
  * <p>Description: CustomPolar Series.</p>
  *
  * <p>Example:
  * <pre><font face="Courier" size="4">
  * $series = new Polar($myChart->getChart());
  * $series->FillSampleValues(10);
  * $series->setCircleLabels(true);
  * $series->setCircleLabelsInside(true);
  * $series->setClockWiseLabels(true);
  * $series->setCircled(true);
  * $series->setCircleBackColor(Color::$EMPTY);
  * $series->getCircleLabelsFont().setColor(Color::$NAVY);
  * $series->setTransparency(35);
  * $series->getBrush().setColor(Color::$WHITE);
  * </font></pre></p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 class CustomPolar extends Circular {

    protected $iPointer;
    protected $iMaxValuesCount = 0;

    private $font;
    private $pen;
    private $circleLabels = false;
    private $circleLabelsFont;
    private $circleLabelsInside = false;
    private $circleLabelsRot = false;
    private $circlePen;
    private $clockWiseLabels = false;
    private $closeCircle = true;
    private $transparency;

    private $oldX;
    private $oldY;

    public function __construct($c=null) {
        parent::__construct($c);

        $this->iPointer = new SeriesPointer($this->chart, $this);
        $this->circleLabelsFont = new ChartFont($this->chart);
        $this->circlePen = new ChartPen($this->chart, Color::BLACK());
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->iPointer);
        unset($this->iMaxValuesCount);
        unset($this->font);
        unset($this->pen);
        unset($this->circleLabels);
        unset($this->circleLabelsFont);
        unset($this->circleLabelsInside);
        unset($this->circleLabelsRot);
        unset($this->circlePen);
        unset($this->clockWiseLabels);
        unset($this->closeCircle);
        unset($this->transparency);
        unset($this->oldX);
        unset($this->oldY);
    } 
        
    /**
    * The Font characteristics for the labels of a circular TeeChart.<br>
    *
    * @return ChartFont
    */
    public function getCircleLabelsFont() {
        return $this->circleLabelsFont;
    }

    public function getCircleCenter() {
        return new TeePoint($this->getCircleXCenter(), $this->getCircleYCenter());
    }

    protected function clickedSegment($p, $tmp, $old) {
        return (
                ($this->getBrush()->getVisible() && GraphicsGD::pointInTriangle($p, $tmp->x, $tmp->y, $old->x, $old->y)) ||
                ($this->getPen()->getVisible() && MathUtils::pointInLineTolerance($p, $tmp->x, $tmp->y, $old->x, $old->y, 0))
               );
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
            $p = new TeePoint($x,$y);
            $tmp = new TeePoint(0,0);
            $old = new TeePoint(0,0);
            $center = new Point($this->iCircleXCenter, $this->iCircleYCenter);
             
            if ($this->chart != null) {
                $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y, $this->getStartZ());
            }
            for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {
                $tmp->x = $this->calcXPos($t);
                $tmp->y = $this->calcYPos($t);
                if (($tmp->x==$x) && ($tmp->y==$y)) { //  $on $this->point
                    return $t;
                }                
                else if ($this->getPointer()->getVisible() && ($this->getPointer()->getStyle() != PointerStyle::$NOTHING)) {
                    if (($this->abs($tmp->x - $x) < $this->getPointer()->getHorizSize()) &&
                        ($this->abs($tmp->y - $y) < $this->getPointer()->getVertSize())) {
                             return $t;
                    }
                }
                else if (($t > $this->firstVisible) && $this->clickedSegment($p, $tmp, $old)) {
                    return $t-1;
                }
                $old = $tmp;
            }
            // Finally, check if point p is over the last segment (only if closeCircle = True)
            if (($result == -1) && $this->getCloseCircle() && ($this->lastVisible > $this->firstVisible)) {
                $old->x = $this->calcXPos($this->firstVisible);
                $old->y = $this->calcYPos($this->firstVisible);
                if ($this->clickedSegment($p, $tmp, $old)) {
                    return $this->lastVisible;
                }
            }
        }
        return $result;
    }

    private function calcXYPos($valueIndex, $aRadius) {
         $tmp = $this->getVertAxis()->getMaximum() - $this->getVertAxis()->getMinimum();
         $tmpDif = $this->vyValues->value[$valueIndex] - $this->getVertAxis()->getMinimum();

         $p = new TeePoint();

        if (($tmp == 0) || ($tmpDif < 0)) {
            $p->x = $this->getCircleXCenter();
            $p->y = $this->getCircleYCenter();
        } else {
            $tmpRadius = $tmpDif * $aRadius / $tmp;
            $p = $this->angleToPos(MathUtils::getPiStep() * $this->getXValue($valueIndex), $tmpRadius, $tmpRadius);
        }

        return $p;
    }

    protected function getXValue($valueIndex) {
        return $this->vxValues->value[$valueIndex];
    }

    private function setGridCanvas($axis) {

        $g = $this->chart->getGraphics3D();
        $g->getBrush()->setVisible(false);
        //g.BackMode=cbmTransparent;
        $g->setPen($axis->getGrid());
        //chart.CheckPenWidth(Pen);        
        if ($g->getPen()->getColor()->isEmpty()) {
            $g->getPen()->setColor(Color::GRAY());
        }
    }

    private function drawYGrid() {

        $MAX_VALUE = intval('1000000000000');        
        if ($this->getVertAxis()->getGrid()->getVisible()) {
            $tmpIncrement = $this->getVertAxis()->getCalcIncrement();
            if ($tmpIncrement > 0) {
                $this->setGridCanvas($this->getVertAxis());
                $tmpValue = $this->getVertAxis()->getMaximum() / $tmpIncrement;
                if ((abs($tmpValue) < $MAX_VALUE) &&
                    (abs(($this->getVertAxis()->getMaximum() -
                               $this->getVertAxis()->getMinimum()) /
                              $tmpIncrement) < 10000)) {
                    if ($this->getVertAxis()->getLabels()->getRoundFirstLabel()) {
                        $tmpValue = $tmpIncrement * (int) ($tmpValue);
                    } else {
                        $tmpValue = $this->getVertAxis()->getMaximum();
                    }
                    if ($this->getVertAxis()->getLabels()->getOnAxis()) {
                        while ($tmpValue > $this->getVertAxis()->getMaximum()) {
                            $tmpValue -= $tmpIncrement;
                        } while ($tmpValue >= $this->getVertAxis()->getMinimum()) {
                            $this->drawRing($tmpValue, $this->getEndZ());
                            $tmpValue -= $tmpIncrement;
                        }
                    } else {
                        while ($tmpValue >= $this->getVertAxis()->getMaximum()) {
                            $tmpValue -= $tmpIncrement;
                        } while ($tmpValue > $this->getVertAxis()->getMinimum()) {
                            $this->drawRing($tmpValue, $this->getEndZ());
                            $tmpValue -= $tmpIncrement;
                        }
                    }
                }
            }
        }
    }

    private function drawAngleLabel($angle, $index) {
        $g = $this->chart->getGraphics3D();

        $g->setFont($this->circleLabelsFont);
        $tmpHeight = $g->getFontHeight();        
                
        if ($angle >= 360) {
            $angle -= 360;
        }

         $tmpSt = $this->getCircleLabel($angle, $index);

         $tmpXRad = $this->getXRadius();
         $tmpYRad = $this->getYRadius();

        if ($this->getCircleLabelsInside()) {
            $tmpXRad -= MathUtils::round($g->textWidth("   "));
            $tmpYRad -= MathUtils::round($g->textHeight($tmpSt));
        }

        $p = $this->angleToPos($angle * (M_PI / 180) , $tmpXRad, $tmpYRad);

        $angle += $this->getRotationAngle();
        $angleRad = $angle * (M_PI / 180);

        if ($this->circleLabelsRot) {

            if (($angle > 90) && ($angle < 270)) {
                /* right aligned */                
                $p->x += (int)(0.5 * $tmpHeight * sin($angle * Circular::$PIDEGREE));
                $p->y += (int)(0.5 * $tmpHeight * cos($angle * Circular::$PIDEGREE));
            } else {
                /* left aligned */
                $p->x -= (int)(0.5 * $tmpHeight * sin($angleRad));
                $p->y -= (int)(0.5 * $tmpHeight * cos($angleRad));
            }
        }

        if ($angle >= 360) {
            $angle -= 360;
        }
        if ($this->circleLabelsRot) {
            if (($angle == 90) || ($angle == 270)) {                
               $g->setTextAlign(Array(StringAlignment::$HORIZONTAL_LEFT_ALIGN,StringAlignment::$VERTICAL_CENTER_ALIGN));
               $tmpWidth = MathUtils::round($g->textWidth("0"));
               if ($angle == 90) {
                 $p->x += $tmpWidth; 
               }
               else
               {
                   if ($angle == 270)
                   {
                     $p->x -= $tmpWidth;                        
                   }
               }     
            } else {        
              if (($angle > 90) && ($angle < 270)) {
                $g->setTextAlign(Array(StringAlignment::$VERTICAL_CENTER_ALIGN));
              //    $angle += 180;
              } else {
                $g->setTextAlign(Array(StringAlignment::$VERTICAL_CENTER_ALIGN));
              }
            }
            $g->rotateLabel($p->x, $p->y, $this->getEndZ(), $tmpSt, $angle);
        } else {
            if (($angle == 0) || ($angle == 180)) {
                $p->y -= $tmpHeight / 2;
            } else
            if (($angle > 0) && ($angle < 180)) {
                $p->y -= $tmpHeight;
            }
            if (($angle == 90) || ($angle == 270)) {
                $g->setTextAlign(Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,StringAlignment::$VERTICAL_CENTER_ALIGN));
            } else {
                if ($this->circleLabelsInside) {
                    if (($angle > 90) && ($angle < 270)) {
                        $g->setTextAlign(Array(StringAlignment::$HORIZONTAL_LEFT_ALIGN,StringAlignment::$VERTICAL_CENTER_ALIGN));
                    } else {
                        $g->setTextAlign(Array(StringAlignment::$HORIZONTAL_RIGHT_ALIGN,StringAlignment::$VERTICAL_CENTER_ALIGN));
                    }
                } else
                if (($angle > 90) && ($angle < 270)) {
                    $g->setTextAlign(Array(StringAlignment::$HORIZONTAL_RIGHT_ALIGN,StringAlignment::$VERTICAL_CENTER_ALIGN));
                } else {
                    $g->setTextAlign(Array(StringAlignment::$HORIZONTAL_LEFT_ALIGN,StringAlignment::$VERTICAL_CENTER_ALIGN));
                }
            }

            $tmpWidth = MathUtils::round($g->textWidth("0") / 2);

            if ($angle == 0) {
                $p->x += $tmpWidth;
            } else if ($angle == 180) {
                $p->x -= $tmpWidth;
            }

            $g->textOut($p->x, $p->y, $this->getEndZ(), $tmpSt);
        }
    }

    private function drawXGrid() {

        //int tmpX;
        //int tmpY;

        if ($this->getHorizAxis()->getGrid()->getVisible() || $this->circleLabels) {
            $tmpIncrement = $this->getHorizAxis()->getIncrement();
            if ($tmpIncrement <= 0) {
                $tmpIncrement = 10.0;
            }

            $this->setGridCanvas($this->getHorizAxis());
            $tmpIndex = 0;
            $tmpValue = 0;

            while ($tmpValue < 360) {
                if ($this->circleLabels) {
                    $this->drawAngleLabel($tmpValue, $tmpIndex);
                }                                    
                if ($this->getHorizAxis()->getGrid()->getVisible()) {
                    $p = $this->angleToPos(MathUtils::getPISTEP() * $tmpValue,
                                         $this->getXRadius(),
                                         $this->getYRadius());
                    $this->chart->getGraphics3D()->line($this->getCircleCenter()->getX(),$this->getCircleCenter()->getY(), $p->getX(), $p->getY(), $this->getEndZ());
                }
                $tmpValue += $tmpIncrement;
                $tmpIndex++;
            }
        }
    }

    private function drawAxis() {
        $this->drawXGrid();
        $this->drawYGrid();

        $tmp = 0;

        if ($this->chart->getAxes()->getVisible()) {
            if ($this->chart->getAxes()->getRight()->getVisible()) {
                $tmp = $this->getCircleXCenter() + $this->chart->getAxes()->getRight()->getSizeTickAxis();
                $this->chart->getAxes()->getRight()->_____draw($tmp,
                                                $tmp +
                                                $this->chart->getAxes()->getRight()->getSizeLabels(),
                                                $this->getCircleXCenter(), false,
                                                $this->chart->getAxes()->getLeft()->getMinimum(),
                                                $this->chart->getAxes()->getLeft()->getMaximum(),
                                                $this->chart->getAxes()->getLeft()->getIncrement(),
                                                $this->getCircleYCenter() - $this->getYRadius(),
                                                $this->getCircleYCenter());
            }
            if ($this->iMaxValuesCount == 0) {

                $l = $this->chart->getAxes()->getLeft();

                if ($l->getVisible()) {
                    $l->internalSetInverted(true);
                    $tmp = $this->getCircleXCenter() - $l->getSizeTickAxis();
                    $l->___draw($tmp, $tmp - $l->getSizeLabels(), $this->getCircleXCenter(), false,
                           $this->getCircleYCenter(), $this->getCircleYCenter() + $this->getYRadius());
                    $l->internalSetInverted(false);
                }

                if ($this->chart->getAxes()->getTop()->getVisible()) {
                    $this->chart->getAxes()->getTop()->internalSetInverted(true);
                    $tmp = $this->getCircleYCenter() -
                          $this->chart->getAxes()->getTop()->getSizeTickAxis();
                    $this->chart->getAxes()->getTop()->_____draw($tmp,
                                                  $tmp -
                                                  $this->chart->getAxes()->getTop()->getSizeLabels(),
                                                  $this->getCircleYCenter(), false,
                                                  $l->getMinimum(), $l->getMaximum(),
                                                  $l->getIncrement(),
                                                  $this->getCircleXCenter() -
                                                  $this->getXRadius(),
                                                  $this->getCircleXCenter());
                    $this->chart->getAxes()->getTop()->internalSetInverted(false);
                }

                if ($this->chart->getAxes()->getBottom()->getVisible()) {
                    $tmp = $this->getCircleYCenter() +
                          $this->chart->getAxes()->getBottom()->getSizeTickAxis();
                    $this->chart->getAxes()->getBottom()->_____draw($tmp,
                            $tmp + $this->chart->getAxes()->getBottom()->getSizeLabels(),
                            $this->getCircleYCenter(), false,
                            $l->getMinimum(), $l->getMaximum(), $l->getIncrement(),
                            $this->getCircleXCenter(),
                            $this->getCircleXCenter() + $this->getXRadius());                            
                }
            }
        }
    }

    private function fillTriangle($aX, $aY, $bX, $bY, $z) {
        $tmpStyle = $this->chart->getGraphics3D()->getPen()->getStyle();
        $this->chart->getGraphics3D()->getPen()->setVisible(false);
        $this->chart->getGraphics3D()->triangle(new TeePoint($aX, $aY), new TeePoint($bX, $bY),
                                       new TeePoint($this->getCircleXCenter(),
                                                 $this->getCircleYCenter()), $z);
        $this->chart->getGraphics3D()->getPen()->setStyle($tmpStyle);
    }

    private $MINANGLE = 10;

    /**
      * The Bottom Axis is used as Angle axis.<br>
      * Gets angle in degrees used to draw the dividing grid lines in
      * anti-clockwise direction.<br>
      * The 0 starting angle is located at rightmost Polar coordinate.
      * Valid increments are between 0 and 359 degree. <br>
      * You can control the grid lines pen by using Chart.Axes.Bottom.Grid.
      *
      * @return double
      */
    public function getAngleIncrement() {
        if ($this->chart == null) {
            return $this->MINANGLE;
        } else {
             $result = $this->getHorizAxis()->getIncrement();
            if ($result == 0) {
                $result = $this->MINANGLE;
            }
            return $result;
        }
    }

    /**
      * Gets list of angle values for each polar point.<br>
      * It is a TList object that stores each Polar point Angle value.
      * You can change angle values by using AngleValues.Value[ ] array of
      * doubles.
      *
      * @return ValueList
      */
    public function getAngleValues() {
        return $this->vxValues;
    }

    /**
      * Gets list of radius values for each polar point.<br>
      * It is a TList object that stores each Polar point Radius value.
      * You can change Radius values by using RadiusValues.Value[] array of
      * doubles.
      *
      * @return ValueList
      */
    public function getRadiusValues() {
        return $this->vyValues;
    }

    protected function doAfterDrawValues() {
        if (!$this->chart->getAxes()->getDrawBehind()) {
            $tmp = false;
            for ( $t = $this->chart->getSeriesIndexOf($this) + 1;
                         $t < $this->chart->getSeriesCount();
                         $t++) {
                if ($this->chart->getSeries($t) instanceof CustomPolar) {
                    $tmp = true;
                    break;
                }
            }
            if (!$tmp) {
                $this->drawAxis();
            }
        }
        parent::doAfterDrawValues();
    }

    private function drawCircle() {
         $g = $this->chart->getGraphics3D();

        //CDI CircleGradient
        if ($this->getCircleBackColor()->isEmpty() && $this->calcCircleGradient() == null)
        /* 5.02 */
        {
            $g->getBrush()->setVisible(false);
        } else {
            $g->getBrush()->setVisible(true);
            $g->getBrush()->setSolid(true);
            $g->getBrush()->setColor($this->calcCircleBackColor());
            $g->getBrush()->setGradient($this->getCircleGradient());
        }

        $g->setPen($this->getCirclePen());
        $this->drawPolarCircle($this->getCircleWidth() / 2, $this->getCircleHeight() / 2, $this->getEndZ());
    }

    protected function doBeforeDrawValues() {
        $first = false;

        for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
            if (($this->chart->getSeries($t)->getActive()) &&
                ($this->chart->getSeries($t) instanceof CustomPolar)) {

                if ($this->chart->getSeries($t) === $this) {
                    if (!$first) {
                        if ($this->circleLabels && (!$this->circleLabelsInside)) {

                            $this->chart->getGraphics3D()->setFont($this->circleLabelsFont);
                            $tmp = $this->chart->getGraphics3D()->getFontHeight() + 2;

                            $r = new Rectangle();
                            $r = $this->chart->getChartRect();

                            $r->y += $tmp;
                            $r->height -= 2 * $tmp;
                            $tmp = MathUtils::round($this->chart->getGraphics3D()->textWidth("360"));
                            $r->x += $tmp;
                            $r->width -= 2 * $tmp;

                            $this->chart->setChartRect($r);
                        }
                    }
                    break;
                }

                $first = true;
            }
        }

        parent::doBeforeDrawValues();

        $first = false;

        for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
            if (($this->chart->getSeries($t)->getActive()) &&
                ($this->chart->getSeries($t) instanceof CustomPolar)) {
                if ($this->chart->getSeries($t) === $this) {
                    if (!$first) {
                        $this->drawCircle();
                        if ($this->chart->getAxes()->getDrawBehind()) {
                            $this->drawAxis();
                        }
                    }
                    break;
                }
                $first = true;
            }
        }
    }


    protected function draw() {
        parent::draw();

        if ($this->iPointer->getVisible()) {
            for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {
                (int)$X=$this->calcXPos($t);
                (int)$Y=$this->calcYPos($t);                
                
                $tmpColor = $this->getValueColor($t);
                $this->iPointer->prepareCanvas($this->chart->getGraphics3D(), $tmpColor);
                $this->iPointer->draw($X, $Y, $tmpColor);
//                $this->iPointer->draw($this->calcXPos($t), $this->calcYPos($t), $tmpColor);
            }
        }
    }

    protected function drawLegendShape($g, $valueIndex, $rect) {
        if ($this->getPen()->getVisible()) {
            $this->linePrepareCanvas($valueIndex);
            $g->horizontalLine($rect->x, $rect->getRight(), ($rect->y + $rect->getBottom()) / 2);
        }
        if ($this->iPointer->getVisible()) {
            $tmpColor = ($valueIndex == -1) ? $this->getColor() :
                             $this->getValueColor($valueIndex);
            $this->iPointer->drawLegendShape($g, $tmpColor, $rect, $this->getPen()->getVisible());
        } else
        if (!$this->getPen()->getVisible()) {
            parent::drawLegendShape($g, $valueIndex, $rect);
        }
    }

    protected function drawMark($valueIndex, $s, $position) {
        $position = $this->getMarks()->applyArrowLength($position);
        parent::drawMark($valueIndex, $s, $position);
    }

    private function drawPolarCircle($halfWidth, $halfHeight, $z) {
        if ($this->iMaxValuesCount == 0) {
            $this->chart->getGraphics3D()->ellipse($this->getCircleXCenter() - $halfWidth,
                                          $this->getCircleYCenter() - $halfHeight,
                                          $this->getCircleXCenter() + $halfWidth,
                                          $this->getCircleYCenter() + $halfHeight, $z);
        } else {
            $tmp = MathUtils::getPiStep() * 360.0 / $this->iMaxValuesCount;

            $oldP = $this->angleToPos(0, $halfWidth, $halfHeight);
            $this->chart->getGraphics3D()->moveTo($oldP, $z);

            for ( $t = 0; $t <= $this->iMaxValuesCount; $t++) {

                $p = $this->angleToPos($t * $tmp, $halfWidth, $halfHeight);
                if ($this->chart->getGraphics3D()->getBrush()->getVisible()) {
                    $this->fillTriangle($oldP->x, $oldP->y, $p->x, $p->y, $z);
                }
                $this->chart->getGraphics3D()->lineTo($p, $z);
                $oldP = $p;
            }
        }
    }

    private function tryFillTriangle($valueIndex, $x, $y) {
        //Blender tmpBlend;
        //Rectangle R=new Rectangle();

        if ($this->getBrush()->getVisible()) {
            $this->chart->setBrushCanvas($this->getValueColor($valueIndex), $this->getBrush(),
                                 $this->getBrush()->getColor());

            /*
                      if (Transparency>0) {
                          R.X  =Math.min(getCircleXCenter(),Math.min(OldX,X));
                          R.y   =Math.min(getCircleYCenter(),Math.min(OldY,y));
             R.width =Math.max(getCircleXCenter(),Math.max(OldX,X))-R.x;
             R.height=Math.max(getCircleYCenter(),Math.max(OldY,Y))-R.y;

                          tmpBlend=new Blender(chart.getGraphics3D(),R);
                          FillTriangle(OldX,OldY,x,y,getStartZ());
                          tmpBlend.DoBlend(Transparency);
                      }
                      else
             */

            //if (transparency>0)
            //    chart.getGraphics3D().SetTransparency(transparency);

            $this->fillTriangle($this->oldX, $this->oldY, $x, $y, $this->getStartZ());
            $this->linePrepareCanvas($valueIndex);
        }
    }

    /**
      * Called internally. Draws the "ValueIndex" point of the Series.
      *
      * @param valueIndex int
      */
    public function drawValue($valueIndex) {
        $x = $this->calcXPos($valueIndex);
        $y = $this->calcYPos($valueIndex);
        $this->linePrepareCanvas($valueIndex);
        if ($valueIndex == $this->firstVisible) {
            $this->chart->getGraphics3D()->moveToXYZ($x, $y, $this->getStartZ()); // $this->first $this->point
        } else {
            if (($x != $this->oldX) || ($y != $this->oldY)) {
                $this->tryFillTriangle($valueIndex, $x, $y);
                if ($this->getPen()->getVisible()) {
                    $this->chart->getGraphics3D()->___lineTo($x, $y, $this->getStartZ());
                }
            }
            if (($valueIndex == $this->lastVisible) && $this->getCloseCircle()) {
                if ($this->getColorEach()) {
                    $this->getPen()->setColor($this->getValueColor(0));
                }
                $this->oldX = $x;
                $this->oldY = $y;
                $x = $this->calcXPos(0);
                $y = $this->calcYPos(0);
                $this->tryFillTriangle($valueIndex, $x, $y);
                if ($this->getPen()->getVisible()) {
                    $this->chart->getGraphics3D()->___lineTo($x, $y, $this->getStartZ());
                }
                $x = $this->oldX;
                $y = $this->oldY;
            }
        }
        $this->oldX = $x;
        $this->oldY = $y;
    }

    protected function getCircleLabel($angle, $index) {
        $tmp = $this->clockWiseLabels ? 360 - $angle : $angle;
        if ($tmp == 360) {
            $tmp = 0;
        }
        return $tmp . Language::getString("POLAR_DEGREE_SYMBOL");
        
    }

    private function linePrepareCanvas($valueIndex) {
        if ($this->getPen()->getVisible()) {

            if ($valueIndex == -1) {
                $tmpColor = $this->getColor();
            } else
            if ($this->getPen()->getColor()->isEmpty()) {
                $tmpColor = $this->getValueColor($valueIndex);
            } else {
                $tmpColor = $this->getPen()->getColor();
            }

            $this->chart->getGraphics3D()->setPen($this->getPen());
            $this->chart->getGraphics3D()->getPen()->setColor($tmpColor);
        } else {
            $this->chart->getGraphics3D()->getPen()->setVisible(false);
        }
    }

    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);
        $this->setCircled(true);
        $this->getHorizAxis()->setIncrement(90);
        $this->chart->getAspect()->setChart3DPercent(5);
        $this->chart->getAxes()->getRight()->getLabels()->setVisible(false);
        $this->chart->getAxes()->getTop()->getLabels()->setVisible(false);
        $this->chart->getAspect()->setOrthogonal(false);
        $this->chart->getAspect()->setElevation(360);
        $this->chart->getAspect()->setZoom(90);
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->iPointer != null) {
            $this->iPointer->setChart($this->chart);
        }
        if (($this->chart != null) && $this->Beans->isDesignTime()) {
            $this->chart->getAspect()->setView3D(false);
        }
        if ($this->font != null) {
            $this->font->setChart($this->chart);
        }
        if ($this->pen != null) {
            $this->pen->setChart($this->chart);
        }
        if ($this->circlePen != null) {
            $this->circlePen->setChart($this->chart);
        }
        if ($this->circleLabelsFont != null) {
            $this->circleLabelsFont->setChart($this->chart);
        }
    }

    public function setColor($c) {
        parent::setColor($c);
        $this->getPen()->setColor($c);
    }

    /**
      * Returns the pixel Screen Horizontal coordinate of the ValueIndex Series
      * value. <br>
      * This coordinate is calculated using the Series associated Horizontal
      * Axis. <br>
      *
      * @param valueIndex int
      * @return int
      */
    public function calcXPos($valueIndex) {
        return $this->calcXYPos($valueIndex, $this->getXRadius())->x;
    }

    /**
      * Returns the pixel Screen Vertical coordinate of the ValueIndex Series
      * value.<br>
      * This coordinate is calculated using the Series associated Vertical Axis.
      *
      * @param valueIndex int
      * @return int
      */
    public function calcYPos($valueIndex) {
        return $this->calcXYPos($valueIndex, $this->getXRadius())->y;
    }

    //CDI DrawZone
    public function drawZone($min, $max, $z) {
        $tmp = $this->getVertAxis()->getMaximum() - $this->getVertAxis()->getMinimum();

        if ($tmp != 0) {
            $tmp = ($max - $this->getVertAxis()->getMinimum()) / $tmp;
            $this->drawPolarCircle(MathUtils::round($tmp * $this->getXRadius()),
                            MathUtils::round($tmp * $this->getYRadius()), $z);
        }

        $tmp = $this->getVertAxis()->getMaximum() - $this->getVertAxis()->getMinimum();

        if ($tmp != 0) {
            $tmp = ($min - $this->getVertAxis()->getMinimum()) / $tmp;

             $halfWidth = MathUtils::round($tmp * $this->getXRadius());
             $halfHeight = MathUtils::round($tmp * $this->getYRadius());

            if ($this->iMaxValuesCount == 0) {
                $this->chart->getGraphics3D()->transparentEllipse($this->getCircleXCenter() -
                        $halfWidth,
                        $this->getCircleYCenter() - $halfHeight,
                        $this->getCircleXCenter() + $halfWidth,
                        $this->getCircleYCenter() + $halfHeight,
                        $z);
            }
        }
    }

    // Used to draw inside circles (grid) or radar grid lines.
    // Can be also used to custom draw circles at specific values.
    // $CDI $changed $to $public
    public function drawRing($value, $z) {
        $tmp = $this->getVertAxis()->getMaximum() - $this->getVertAxis()->getMinimum();

        if ($tmp != 0) {
            $tmp = ($value - $this->getVertAxis()->getMinimum()) / $tmp;
            $this->drawPolarCircle(MathUtils::round($tmp * $this->getXRadius()),
                            MathUtils::round($tmp * $this->getYRadius()), $z);
        }
    }
    
    /**
      * Displays labels in 15,30,45 or 90 degree increments.
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * series1.setAngleIncrement(15);
      * </font></pre></p>
      *
      * @param value double
      */
    public function setAngleIncrement($value) {
        if ($this->chart != null) {
            if ($this->getHorizAxis() == null) {
                $this->recalcGetAxis();
            }
            $this->getHorizAxis()->setIncrement($value);
        }
    }

    /**
      * Sets Polar Back Brush.
      *
      * @return ChartBrush
      */
    public function getBrush() {
        return $this->bBrush;
    }

    /**
      * Sets CicleLabel properties.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getCircleLabels() {
        return $this->circleLabels;
    }

    /**
      * Sets CicleLabel properties.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setCircleLabels($value) {
        $this->circleLabels = $this->setBooleanProperty($this->circleLabels, $value);
    }

    /**
      * The label font characteristics.
      *
      * @return ChartFont
      */
    public function getFont() {
        if ($this->font == null) {
            $this->font = new ChartFont($this->chart);
        }
        return $this->font;
    }

    /**
      * Enables/disables the display of the axis labels inside the circle area.
      * <br>
      * Default value: false
      *
      * @return boolean
      */
    public function getCircleLabelsInside() {
        return $this->circleLabelsInside;
    }

    /**
      * Enables/disables the display of the axis labels inside the circle area.
      * <br>
      * Default value: false
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * series.setCircleLabelsInside(true);
      * </font></pre></p>
      *
      * @param value boolean
      */
    public function setCircleLabelsInside($value) {
        $this->circleLabelsInside = $this->setBooleanProperty($this->circleLabelsInside, $value);
    }

    /**
      * Places Circle Labels at an angle in line with the Radar/Polar circle at
      * each Label point when true. <br>
      * Default value: false
      *
      * @return boolean
      */
    public function getCircleLabelsRotated() {
        return $this->circleLabelsRot;
    }

    /**
      * Places Circle Labels at an angle in line with the Radar/Polar circle at
      * each Label point when true. <br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setCircleLabelsRotated($value) {
        $this->circleLabelsRot = $this->setBooleanProperty($this->circleLabelsRot, $value);
    }

    /**
      * Determines the pen used to draw the outmost circle of all CustomPolar
      * series derived Series.<br>
      *
      * @return ChartPen
      */
    public function getCirclePen() {
        return $this->circlePen;
    }

    /**
      * Displays the circle labels in a clockwise direction.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getClockWiseLabels() {
        return $this->clockWiseLabels;
    }

    /**
      * Displays the circle labels in a clockwise direction when true.<br>
      * Default value: false
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * series.setClockWiseLabels(true);
      * </font></pre></p>
      *
      * @param value boolean
      */
    public function setClockWiseLabels($value) {
        $this->clockWiseLabels = $this->setBooleanProperty($this->clockWiseLabels, $value);
    }

    /**
      * Draws a Line between the last and first PolarSeries point coordinates.
      * <br>If true, the Polar series polygon is closed.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getCloseCircle() {
        return $this->closeCircle;
    }

    /**
      * Draws a Line between the last and first PolarSeries point coordinates.
      * <br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setCloseCircle($value) {
        $this->closeCircle = $this->setBooleanProperty($this->closeCircle, $value);
    }

    /**
      * Determines Pen used to draw the Line connecting PolarSeries points.<br>
      * Points can be displayed by setting Pointer.Visible to true. <br>
      * You can set the Pen used to draw the circle using CirclePen.
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
      * Pointer contains several properties to control the formatting
      * attributes of Points like Pen, Brush, Draw3D, Visible, etc.<br>
      * It is a subclass of Points series, Line series and all other derived
      * Points series classes like Bubble series, Polar series and Candle series.
      * <br>
      * Each point in a Polar series is drawn using the Pointer properties. <br>
      *
      * @return SeriesPointer
      */
    public function getPointer() {
        return $this->iPointer;
    }

    /**
      * Determines the increment used to draw the ring grid lines.<br>
      * It is the same as accessing Chart.Axes.Left.Increment when using Polar
      * series. <br>
      * You can use RadiusIncrement with Polar series .AngleIncrement to control
      * how gridlines are displayed in Polar charts. <br>
      *
      * @return double
      */
    public function getRadiusIncrement() {
        return ($this->chart == null) ? 0 : $this->getVertAxis()->getIncrement();
    }

    /**
      * Sets the increment used to draw the ring grid lines.<br>
      *
      * @param value double
      * @throws TeeChartException
      */
    public function setRadiusIncrement($value) /*throws ChartException*/ {
        if ($this->chart != null) {
            $this->getVertAxis()->setIncrement($value);
        }
    }

    /**
      * The Transparency level from 0 to 100%.<br>
      * Default value: 0
      *
      * @return int
      */
    public function getTransparency() {
        return $this->bBrush->getTransparency();
    }

    /**
      * Sets Transparency level from 0 to 100%.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setTransparency($value) {
        $this->bBrush->setTransparency($value);
        $this->invalidate();
    }
}
?>