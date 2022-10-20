<?php
 /**
 * Description:  This file contains the following class:<br>
 * Smith class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Smith class
 *
 * Description: Smith Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Smith extends Circular {

    private $circlePen;
    private $pen;
    private $imagSymbol;
    private $pointer;
    private $oldX;
    private $oldY;

    public function __construct($c=null) {
        parent::__construct($c);

        $this->getXValues()->name = Language::getString("SmithResistance");
        $this->getXValues()->setOrder(ValueListOrder::$NONE);
        $this->getYValues()->name = Language::getString("SmithReactance");
        $this->pointer = new SeriesPointer($this->chart, $this);
        $this->circlePen = new ChartPen($c,Color::BLACK());
        $this->imagSymbol = "i";
        $this->setCircleBackColor(Color::EMPTYCOLOR());
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->circlePen);
        unset($this->pen);
        unset($this->imagSymbol);
        unset($this->pointer);
        unset($this->oldX);
        unset($this->oldY);
    }         

    /**
      * Defines pen to draw SmithSeries Chart.
      *
      * @return ChartPen
      */
    public function getPen() {
        if ($this->pen == null) {
            $this->pen = new ChartPen($this->chart);
        }
        return $this->pen;
    }

    /**
      * Defines pen to draw SmithSeries Chart.
      *
      * @return SeriesPointer
      */
    public function getPointer() {
        if ($this->pointer == null) {
            $this->pointer = new SeriesPointer($this->chart, $this);
        }
        return $this->pointer;
    }

    /**
      * Specifies the text used to display together with axis labels around a
      * Smith circle series.<br>
      * Default value: ImagSymbol is a lowercase "i" letter.
      *
      * @return String
      */
    public function getImagSymbol() {
        return $this->imagSymbol;
    }

    /**
      * Specifies the text used to display together with axis labels around a
      * Smith circle series.<br>
      * Default value: ImagSymbol is a lowercase "i" letter.
      *

      * @param value String
      */
    public function setImagSymbol($value) {
        $this->imagSymbol = $this->setStringProperty($this->imagSymbol, $value);
    }

    /**
      * Defines Brush to fill Chart.
      *
      * @return ChartBrush
      */
    public function getBrush() {
        return $this->bBrush;
    }

    protected function addSampleValues($numValues) {
        $r = $this->randomBounds($numValues);
        for ( $t = 0; $t <= $numValues; $t++) {
            $this->add(6.5 * $t / $numValues, ($t * $r->Random() + 3.8) / $numValues);
        }
    }

    /**
      * Defines Pen to draw CCircles of the Smith Series.<br>
      * xCircle (reactance circle) pen. <br>
      * Read CCirclePen to obtain the TChartPen object that represents the color
      * and style of the CCircles of the Smith Series.<br>
      * Use CCirclePen to change the color or style.
      *
      * @return GridPen
      */
    public function getCCirclePen() {
        return $this->getVertAxis()->getGrid();
    }

    /**
      * Defines Pen to draw RCircles of the Smith Series.<br>
      * rCircle (resistance circle) pen. <br>
      * Read RCirclePen to obtain the Pen object that represents the color and
      * style of the RCircles of the Smith Series.<br>
      * Use RCirclePen to change the color or style.
      *
      * @return GridPen
      */
    public function getRCirclePen() {
        return $this->getHorizAxis()->getGrid();
    }

    /**
      * Defines Pen to draw external Circle of the Smith Series.<br>
      * Resistance = 0 rCircle pen (biggest circle). <br>
      * Read CirclePen to obtain the Pen object that represents the color and
      * style of the external circle of the Smith Series.<br>
      * Use CirclePen to change the color or style.
      *
      * @return ChartPen
      */
    public function getCirclePen() {
        if ($this->circlePen == null) {
            $this->circlePen = new ChartPen($this->chart);
        }
        return $this->circlePen;
    }

    private $DEFAULTX =  Array (0, 0.1, 0.3, 0.5, 0.8, 1, 1.5, 2, 3, 5, 7, 10);
    
    /**
       $Shows/hides $the $static $finalant $reactance $labels.<br>
      * When set to true, constant reactance labels are shown.
      *
      * @return boolean
      */
    public function getCLabels() {
        return $this->getVertAxis()->getLabels()->getVisible();
    }

    /**
       $Shows/hides $the $static $finalant $reactance $labels.<br>
      * When set to true, constant reactance labels are shown.
      *
      * @param value boolean
      */
    public function setCLabels($value) {
        $this->getVertAxis()->getLabels()->setVisible($value);
    }

    /**
       $Shows/hides $the $static $finalant $resistance $labels.<br>
      * When set to true constant resistance labels are shown.
      *
      * @return boolean
      */
    public function getRLabels() {
        return $this->getHorizAxis()->getLabels()->getVisible();
    }

    /**
       $Shows/hides $the $static $finalant $resistance $labels.<br>
      * When set to true constant resistance labels are shown.
      *
      * @param value boolean
      */
    public function setRLabels($value) {
        $this->getHorizAxis()->getLabels()->setVisible($value);
    }

    private function drawXCircleGrid() {
        $this->chart->getGraphics3D()->setPen($this->getCCirclePen());
        for ( $t = 0; $t <= 11; $t++) {
            $this->drawXCircle($this->DEFAULTX[$t], $this->getMiddleZ(), $this->getCLabels());
        }
    }

    private $DEFAULTR = Array(0, 0.2, 0.5, 1, 2, 5, 10);

    private function drawRCircleGrid() {
        $this->chart->getGraphics3D()->setPen($this->getRCirclePen());
        for ( $t = 0; $t <= 6; $t++) {
           $this->drawRCircle($this->DEFAULTR[$t], $this->getMiddleZ(), $this->getRLabels());
        }
    }

    private function drawAxis() {
        if ($this->getVertAxis()->getVisible()) {
           $this->drawXCircleGrid();  
        }

        $this->chart->getGraphics3D()->unClip();

        if ($this->getHorizAxis()->getVisible()) {
            $this->drawRCircleGrid();
        }
    }

    private function drawCircle() {
        $g = $this->chart->getGraphics3D();

        //CDI CircleGradient
        if ($this->getCircleBackColor()->isEmpty() && $this->calcCircleGradient() == null)  {
            $g->getBrush()->setVisible(false);
        } 
        else {
            $g->getBrush()->setVisible(true);
            $g->getBrush()->setSolid(true);
            $g->getBrush()->setColor($this->calcCircleBackColor());
            $g->getBrush()->setGradient($this->getCircleGradient());
        }
        
        $tmpX = $this->getCircleWidth() / 2;
        $tmpY = $this->getCircleHeight() / 2;
        $g->setPen($this->getCirclePen());
        
        $g->ellipse($this->getCircleXCenter() - $tmpX, $this->getCircleYCenter() - $tmpY,
                  $this->getCircleXCenter() + $tmpX, $this->getCircleYCenter() + $tmpY, $this->getEndZ());
    }

    protected function doBeforeDrawValues() {
        $first = false;

        for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
             $s = $this->chart->getSeries($t);
            if ($s->getActive() && ($s instanceof Smith)) {
                if ($s === $this) {
                    if (!$first) {
                        if ($this->getCLabels()) {
                            $r = $this->chart->getChartRect();
                            $r->grow( -$this->chart->getGraphics3D()->textWidth("360"),
                                   -$this->chart->getGraphics3D()->getFontHeight() + 2);
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

       for ( $tt = 0; $tt < $this->chart->getSeriesCount(); $tt++) {
           $ss = $this->chart->getSeries($tt);
           if ($ss->getActive() && ($ss instanceof Smith)) {
               if ($ss === $this) {
                   if (!$first) {
                       $this->drawCircle();                                              
                       if ($this->chart->getAxes()->getVisible() &&
                           $this->chart->getAxes()->getDrawBehind()) {
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

        if ($this->pointer->getVisible()) {

            for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {
                $tmpColor = $this->getValueColor($t);
                $this->pointer->prepareCanvas($this->chart->getGraphics3D(), $tmpColor);
                $this->pointer->draw($this->calcXPos($t), $this->calcYPos($t), $tmpColor);
            }
        }
    }

    /**
      * Called internally. Draws the "ValueIndex" point of the Series.
      *
      * @param valueIndex int
      */
    public function drawValue($valueIndex) {
        $p = $this->zToPos($this->vxValues->getValue($valueIndex),
                         $this->vyValues->getValue($valueIndex));
        $this->linePrepareCanvas($valueIndex);
        if ($valueIndex == $this->firstVisible) {
            $this->chart->getGraphics3D()->moveTo($p, $this->getStartZ()); // <-- first point
        } else
        if (($p->x != $this->oldX) || ($p->y != $this->oldY)) {
            $this->chart->getGraphics3D()->lineTo($p, $this->getStartZ());
        }

        $this->oldX = $p->x;
        $this->oldY = $p->y;
    }

    private function getXCircleLabel($reactance) {
        return $reactance . $this->imagSymbol;
    }

    private function linePrepareCanvas($valueIndex) {
        $g = $this->chart->getGraphics3D();
        if ($this->getPen()->getVisible()) {
            $g->setPen($this->getPen());
            $g->getPen()->setColor(($valueIndex == -1) ? $this->getColor() :
                                $this->getValueColor($valueIndex));
        } else {
            $g->getPen()->setVisible(false);
        }
    }

    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);
        $this->chart->getAspect()->setChart3DPercent(5);
        $this->chart->getAxes()->getRight()->getLabels()->setVisible(false);
        $this->chart->getAxes()->getTop()->getLabels()->setVisible(false);
        $this->chart->getAspect()->setOrthogonal(false);
        $this->chart->getAspect()->setElevation(360);
        $this->chart->getAspect()->setZoom(90);
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->pointer != null) {
            $this->pointer->setChart($c);
        }
        if (($this->chart != null) && $this->Beans->isDesignTime()) {
            $this->chart->getAspect()->setView3D(false);
        }
    }

    /**
      * The pixel Screen Horizontal coordinate of the ValueIndex Series
      * value.<br>
      * This coordinate is calculated using the Series associated Horizontal Axis.
      *
      * @param valueIndex int
      * @return int
      */
    public function calcXPos($valueIndex) {
        return $this->zToPos($this->vxValues->getValue($valueIndex),
                      $this->vyValues->getValue($valueIndex))->x;
    }

    /**
      * The pixel Screen Vertical coordinate of the ValueIndex Series
      * value.<br>
      * This coordinate is calculated using the Series associated Vertical Axis.
      *
      * @param valueIndex int
      * @return int
      */
    public function calcYPos($valueIndex) {
        return $this->zToPos($this->vxValues->getValue($valueIndex),
                      $this->vyValues->getValue($valueIndex))->y;
    }

    /**
      * The ValueIndex of the "clicked" point in the Series.<br>
      *
      * @param x int
      * @param y int
      * @return int
      */
    public function clicked($x, $y) {
        if ($this->chart != null) {
            $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y, $this->getStartZ());
            $x = $p->x;
            $y = $p->y;
        }

        $result = parent::clicked($x, $y);

        if (($result == -1) && ($this->firstVisible > -1) && ($this->lastVisible > -1)) {
            if ($this->pointer->getVisible()) {
                for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {
                    if (($this->abs($this->calcXPos($t) - $x) < $this->pointer->getHorizSize()) &&
                        ($this->abs($this->calcYPos($t) - $y) < $this->pointer->getVertSize())) {
                        return $t;
                    }
                }
            }
        }

        return $result;
    }

    private function drawRCircleLabel($rVal, $x, $y) {
        if ($this->getHorizAxis()->getVisible()) {
            /* 5.02 */
            $this->chart->getGraphics3D()->setFont($this->getRLabelsFont());
            $this->chart->getGraphics3D()->setTextAlign(StringAlignment::$VERTICAL_BOTTOM_ALIGN );
            $this->chart->getGraphics3D()->textOut($x, $y, $this->getEndZ(), $rVal);
        }
    }

    private function drawRCircle($value, $z, $showLabel) {
        if ($value != -1) {
             // Transform R
             $tmp = 1 / (1 + $value);
             $halfXSize = MathUtils::round($tmp * $this->getXRadius());
             $halfYSize = MathUtils::round($tmp * $this->getYRadius());

            // Circles are always right aligned
          
           if ($this->getPen()->getVisible()) {
            // Gets the pen color and style (dot , dashed, ...)
            $penColorStyle = $this->chart->getGraphics3D()->getPenColorStyle();
            imagesetstyle($this->chart->getGraphics3D()->img, $penColorStyle);

            // Assign the pen width for the image
            imagesetthickness ( $this->chart->getGraphics3D()->img, $this->chart->getGraphics3D()->getPen()->getWidth());
                        
            for ($i=0;$i<=$this->pen->getWidth();$i++)
                imageellipse($this->chart->getGraphics3D()->img,$this->getCircleRect()->getRight() -
                                           $halfXSize,
                                          $this->getCircleYCenter() ,
                                          $this->getCircleRect()->getRight()-($this->getCircleRect()->getRight() -
                                          2* $halfXSize) +$i,
                                          ($this->getCircleYCenter() + $halfYSize)- ($this->getCircleYCenter() - $halfYSize)+$i, $z);                                                        
            }
                    
            if ($showLabel) { // 5.02 ( if $RLabels)
                $this->drawRCircleLabel($value,
                                 $this->getCircleRect()->getRight() - 2 * $halfXSize,
                                 $this->getCircleYCenter());
            }
        }
    }

    /**
      * xCircle labels font.
      *
      * @return ChartFont
      */
    public function getCLabelsFont() {
        return $this->getVertAxis()->getLabels()->getFont();
    }

    /**
      * rCircle labels font.
      *
      * @return ChartFont
      */
    public function getRLabelsFont() {
        return $this->getHorizAxis()->getLabels()->getFont();
    }

    private function drawXCircleLabel($xVal, $x, $y) {

        if ($this->getVertAxis()->getVisible()) {
            /* 5.02 */
            $this->chart->getGraphics3D()->setFont($this->getCLabelsFont());
            $tmpHeight = $this->chart->getGraphics3D()->getFontHeight();
            $tmpSt = $this->getXCircleLabel($xVal);

            $angle = $this->pointToAngle($x, $y) * 57.29577;

            if ($angle >= 360) {
                $angle -= 360;
            }
            if (($angle == 0) || ($angle == 180)) {
                $y -= $tmpHeight / 2;
            } else
            if (($angle > 0) && ($angle < 180)) {
                $y -= $tmpHeight;
            }
            
            if (($angle == 90) || ($angle == 270)) {                
                $this->chart->getGraphics3D()->setTextAlign(StringAlignment::$CENTER);
            } else {
                $this->chart->getGraphics3D()->setTextAlign((($angle > 90) &&
                        ($angle < 270)) ?
                        StringAlignment::$HORIZONTAL_RIGHT_ALIGN&&StringAlignment::$VERTICAL_BOTTOM_ALIGN :
                        StringAlignment::$HORIZONTAL_LEFT_ALIGN&&StringAlignment::$VERTICAL_BOTTOM_ALIGN);
            }

            $tmpWidth = $this->chart->getGraphics3D()->textWidth("0") / 2;

            if ($angle == 0) {
                $x += $tmpWidth;
            } else if ($angle == 180) {
                $x -= $tmpWidth;
            }

            $this->chart->getGraphics3D()->textOut($x, $y, $this->getEndZ(), $tmpSt);
        }
    }

    private function drawXCircle($value, $z, $showLabel) {

        $p1 = new TeePoint();
        $p2 = new TeePoint();

        if ($value != 0) {
            $invValue = 1 / $value;
            $p4 = $this->zToPos(0, $value); // Endpos
            if ($showLabel) {
                $this->drawXCircleLabel($value, $p4->x, $p4->y);
            }

            $p3 = $this->zToPos(100, $value); // Startpos

            // ellipse bounding points
            $halfXSize = MathUtils::round($invValue * $this->getXRadius());
            $halfYSize = MathUtils::round($invValue * $this->getYRadius());

            $p1->x = $this->getCircleRect()->getRight() - $halfXSize;
            $p2->x = $this->getCircleRect()->getRight() + $halfXSize;
            $p1->y = $this->getCircleYCenter();
            $p2->y = $p1->y - (2* $halfYSize);
            
            // TODO $this->chart->getGraphics3D()->clipEllipse($this->getCircleRect());
            if ((!$this->chart->getAspect()->getView3D()) ||
                $this->chart->getAspect()->getOrthogonal()) {
                /*          TODO                     
                $this->chart->getGraphics3D()->arc($p1->x, $p2->y, $p2->x, $p1->y, 0, 360);

                $color = imagecolorallocate($this->chart->getGraphics3D()->img, $this->chart->getGraphics3D()->getBrush()->getColor()->red,
                                                  $this->chart->getGraphics3D()->getBrush()->getColor()->green,
                                                  $this->chart->getGraphics3D()->getBrush()->getColor()->blue);
                     
                                               
                imagearc($this->chart->getGraphics3D()->img, $p1->x, $p2->y+($halfYSize*$invValue), $p2->x-$p1->x, $p1->y-$p2->y ,0, 360, $color);
                */                      
            }

            $p4 = $this->zToPos(0, -$value); // Endpos

            if ((!$this->chart->getAspect()->getView3D()) ||
                $this->chart->getAspect()->getOrthogonal()) {
           //     $this->chart->getGraphics3D()->arc($p1->x, $p2->y + 2 * $halfYSize, $p2->x,
           //                             $p1->y + 2 * $halfYSize, 0, 360);
            }
            // TODO $this->chart->getGraphics3D()->unClip();

            if ($showLabel) {
                $this->drawXCircleLabel( -$value, $p4->x, $p4->y);
            }                        
        } else {
            /* special case ) reactance is zero */
            $p1->x = $this->getCircleRect()->x;
            $p2->x = $this->getCircleRect()->getRight();
            $p1->y = $this->getCircleYCenter();

            $this->chart->getGraphics3D()->line($p1->x, $p1->y, $p2->x, $p1->y, $this->getMiddleZ());

            if ($showLabel) {
                $this->drawXCircleLabel(0, $p1->x, $p1->y);
            }
        }
    }

    // Position to impendance
    // (ZRe,ZIm)=(1+gamma)/(1-gamma)
    private function posToZ($x, $y) {
        $x -= $this->getCircleXCenter();
        $y = $this->getCircleYCenter() - $y;
        $gRe = $x / $this->getXRadius();
        $gIm = $y / $this->getYRadius();
        $norm2 = ($gRe * $gRe) + ($gIm * $gIm);
        $invDen = 1 / ($norm2 - 2 * $gRe + 1);
        return new PointDouble((1 - $norm2) * $invDen, 2 * $gIm * $invDen);
    }

    // impendance to Position
    // (GRe,GIm)=(1-z)/(1+z)
    private function zToPos($resist, $react) {

        $norm2 = ($resist * $resist) + ($react * $react);
        $invDen = 1 / ($norm2 + 2 * $resist + 1);
        $gRe = ($norm2 - 1) * $invDen;
        $gIm = 2 * $react * $invDen;
        return new TeePoint($this->getCircleXCenter() + MathUtils::round($gRe * $this->getXRadius()),
                         $this->getCircleYCenter() - MathUtils::round($gIm * $this->getYRadius()));
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return Language::getString("GallerySmith");
    }
}

?>