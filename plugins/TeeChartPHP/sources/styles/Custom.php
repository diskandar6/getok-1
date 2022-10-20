<?php
 /**
 * Description:  This file contains the following class:<br>
 * Custom class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Custom class
 *
 * Description: Base Series class inherited by a number of TeeChart
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

  class Custom extends CustomPoint {

    protected $bAreaBrush;
    protected $pAreaLines;
    protected $bClickableLine = true;
    protected $bDark3D = true;
    protected $drawArea;
    protected $drawLine = true;

    private $invertedStairs;
    //private Color areaColor;
    private $colorEachLine = true;
    private $lineHeight;
    private $outLine;
    private $stairs;
    private $bottomPos;
    private $oldBottomPos;
    private $oldX;
    private $oldY;
    private $oldColor;
    private $tmpDark3DRatio;
    private $tmpColor;
    private $isLastValue;
    protected $shadow;


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
        parent::__construct($c);
        
        $this->getLinePen()->setDefaultColor(new Color(0,0,0)); // Black
        $this->shadow=new Shadow($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->bAreaBrush);
        unset($this->pAreaLines);
        unset($this->bClickableLine);
        unset($this->bDark3D);
        unset($this->drawArea);
        unset($this->drawLine);
        unset($this->invertedStairs);     
        unset($this->colorEachLine);     
        unset($this->lineHeight);     
        unset($this->outLine);     
        unset($this->stairs);     
        unset($this->bottomPos);     
        unset($this->oldBottomPos);     
        unset($this->oldX);     
        unset($this->oldY);     
        unset($this->oldColor);     
        unset($this->tmpDark3DRatio);     
        unset($this->tmpColor);     
        unset($this->isLastValue);     
        unset($this->shadow);     
    }   
        
    protected function readResolve() {
        $this->tmpColor = new Color(0,0,0,0,true);
        $this->oldColor=$this->tmpColor; // ->EMPTY;
        return parent::readResolve();
    }

    /**
      * Allows mouse clicks over the line drawn between points.<br>
      * Default value: true
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * lineSeries.setClickableLine( false );
      * </font></pre></p>
      *
      * @return boolean
      */
    public function getClickableLine() {
        return $this->bClickableLine;
    }

    /**
    * Allows mouse clicks over the line drawn between points.
    * Default value: true
    * @param boolean $value
    */

    public function setClickableLine($value) {
        $this->bClickableLine = $this->setBooleanProperty($this->bClickableLine, $value);
    }

    /**
    * Opacity level from 0 to 100%
    *
    * @return integer
    */
    public function getOpacity() {
        return 100 - $this->getTransparency();
    }

    /**
    * Sets Opacity level from 0 to 100%
    *
    * @return integer
    */
    public function setOpacity($value) {
        $this->setTransparency(100 - $value);
    }

    /**
    * Transparency level from 0 to 100%
    * Default value: 0
    *
    * @return integer
    */
    public function getTransparency() {
        return $this->getBrush()->getTransparency();
    }

    /**
    * Sets Transparency level from 0 to 100%
    * Default value: 0
    * <p>Example:<pre><font face="Courier" size="4">
    * Series1.setTransparency(45);
    * </font></pre></p>
    *
    * @param integer $value
    */
    public function setTransparency($value) {
        $this->getBrush()->setTransparency($value);
    }

    /**
    * Sets Brush characteristics.
    *
    * @return object {@link ChartBrush}
    */
    public function getBrush() {
        return $this->bBrush;
    }

    /**
    * Darkens parts of 3D Line Series to add depth.<br>
    * Default value: true
    *
    * @return boolean
    */
    public function getDark3D() {
        return $this->bDark3D;
    }

    /**
    * Darkens parts of 3D Line Series to add depth.<br>
    * Default value: true
    *
    * @param boolean $value
    */
    public function setDark3D($value) {
        $this->bDark3D = $this->setBooleanProperty($this->bDark3D, $value);
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->bAreaBrush != null) {
            $this->bAreaBrush->setChart($c);
        }
        if ($this->pAreaLines != null) {
            $this->pAreaLines->setChart($c);
        }
        if ($this->outLine != null) {
            $this->outLine->setChart($c);
        }
    }

    public function setColor($value) {
        parent::setColor($value);
        if ($this->bAreaBrush != null) {
            $this->bAreaBrush->setColor($value);
        }
    }

    /**
      * Steps line joining adjacent points.<br>
      * In most normal situations, a series draws a line between each Line
      * point. This makes the Line appear as a "mountain" shape. However,
      * setting Stairs to true will make the Series draw 2 Lines between each
      * pair of points, thus giving a "stair" appearance.<br>
      * This is most used in some financial Chart representations. <br>
      * When Stairs is set to true you may set InvertedStairs to true to alter
      * the direction of the step. <br>
      * Default value: false
      *
      * @return boolean
      */
    public function getStairs() {
        return $this->stairs;
    }

    /**
      * Steps line joining adjacent points.<br>
      * Default value: false
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * areaSeries1.setStairs(true);
      * areaSeries2.setStairs(true);
      * </font></pre></p>
      *
      * @see #getStairs
      * @param value boolean
      */
    public function setStairs($value) {
        $this->stairs = $this->setBooleanProperty($this->stairs, $value);
    }

    /**
      * Enables/Disables the coloring of each connecting line of a series.<br>
      * Default value: true
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * lineSeries.setColorEach(true); lineSeries.setColorEachLine(false);
      * </font></pre></p>
      *
      * @return boolean
      */
    public function getColorEachLine() {
        return $this->colorEachLine;
    }

    /**
      * Enables/Disables the coloring of each connecting line of a series.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setColorEachLine($value) {
        $this->colorEachLine = $this->setBooleanProperty($this->colorEachLine, $value);
    }

    /**
      * Changes the direction of the step, when true.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getInvertedStairs() {
        return $this->invertedStairs;
    }

    /**
      * Changes the direction of the step, when true.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setInvertedStairs($value) {
        $this->invertedStairs = $this->setBooleanProperty($this->invertedStairs, $value);
    }


    /**
      * Pen for Series Line's outer pen.<br>
      * Default value: null
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * lineSeries.getOutline().setColor(Color.Yellow);
      * </font></pre></p>
      *
      * @return ChartPen
      */
    public function getOutLine() {
        if ($this->outLine == null) {
            $this->tmpColor = new Color(0,0,0);  // Black
            $tmpLineCap = new LineCap();
            $this->outLine = new ChartPen($this->chart, $this->tmpColor, false,
                                   $tmpLineCap->ROUND);
        }
        return $this->outLine;
    }

    /**
      * The vertical thickness of the line in pixels.<br>
      * Default value: 0
      *
      * @return int
      */
    public function getLineHeight() {
        return $this->lineHeight;
    }

    /**
      * Sets the vertical thickness of the line in pixels.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setLineHeight($value) {
        $this->lineHeight = $this->setIntegerProperty($this->lineHeight, $value);
    }

    public function calcHorizMargins($margins) {
        parent::calcHorizMargins($margins);
        $this->internalCalcMargin(!$this->getYMandatory(), true, $margins);
    }

    private function internalCalcMargin($sameSide, $horizontal, $margins) {
        if ($horizontal) {
            $this->getPointer()->calcHorizMargins($margins);
        } else {
            $this->getPointer()->calcVerticalMargins($margins);
        }

         $a = $margins->min;
         $b = $margins->max;

        if ($this->drawLine) {
            if ($this->stairs) {
                $a = max($a, $this->linePen->getWidth());
                $b = max($b, $this->linePen->getWidth() + 1);
            }
            if (($this->outLine != null) && ($this->outLine->getVisible())) {
                $a = max($a, $this->outLine->getWidth());
                $b = max($b, $this->outLine->getWidth());
            }
        }

        if ($this->marks!=null) {
            if ($this->marks->getVisible() && $sameSide) {
                if ($this->yMandatory) {
                    $a = max($a, $this->marks->getArrowLength());
                } else {
                    $b = max($b, $this->marks->getArrowLength());
                }
            }

            if ($this->marks->getVisible() && $sameSide) {
                 $tmp = $this->marks->getCallout()->getLength() +
                          $this->marks->getCallout()->getDistance();
                if ($this->yMandatory) {
                    $a = max($b, $tmp);
                } else {
                    $b = max($a, $tmp);
                }
            }
        }
    }

    public function calcVerticalMargins($margins) {
        parent::calcVerticalMargins($margins);

        $this->internalCalcMargin($this->yMandatory, false, $margins);

        if (($this->lineHeight > 0) && (!$this->drawArea) && $this->chart->getAspect()->getView3D()) {
            if ($this->lineHeight > $margins->max) {
                $margins->max = $this->lineHeight;
            }
        }
    }

    private function pointInVertLine($p, $x0, $y0, $y1) {
        return MathUtils::pointInLineTolerance($p, $x0, $y0, $x0, $y1, 3);
    }

    private function pointInHorizLine($p, $x0, $y0, $x1) {
        return MathUtils::pointInLineTolerance($p, $x0, $y0, $x1, $y0, 3);
    }

    private function checkPointInLine($p, $tmpX, $tmpY, $oldXPos, $oldYPos) {

        if ($this->chart->getAspect()->getView3D()) {
            $tmp = array();
            $tmp[0] = new TeePoint($tmpX, $tmpY);
            $tmp[1] = new TeePoint($tmpX + $this->chart->getSeriesWidth3D(),
                                    $tmpY - $this->chart->getSeriesHeight3D());
            $tmp[2] = new TeePoint($oldXPos +  $this->chart->getSeriesWidth3D(),
                                    $oldYPos - $this->chart->getSeriesHeight3D());
            $tmp[3] = new TeePoint($oldXPos, $oldYPos);

            return GraphicsGD::pointInPolygon($p, $tmp);
        } else
        if ($this->stairs) {
            if ($this->invertedStairs) {
                return $this->pointInVertLine($p, $oldXPos, $oldYPos, $tmpY) ||
                        $this->pointInHorizLine($p, $oldXPos, $tmpY, $tmpX);
            } else {
                return $this->pointInHorizLine($p, $oldXPos, $oldYPos, $tmpX) ||
                        $this->pointInVertLine($p, $tmpX, $oldYPos, $tmpY);
            }
        } else {
            return MathUtils::pointInLineTolerance($p, $tmpX, $tmpY,
                                                  $oldXPos,
                                                  $oldYPos, 3);
        }
    }

    /**
      * Calculates if any point is at XY position.
      *
      * @param x int
      * @param y int
      * @return int Point index
      */
    public function clicked($x, $y) {

        if ($this->chart != null) {
            $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y, $this->getStartZ());
            $x = $p->x;
            $y = $p->y;
        }

         $result = parent::clicked($x, $y);

        if (($result == -1) &&
            ($this->firstVisible > -1) && ($this->lastVisible > -1)) {
             $oldXPos = 0;
             $oldYPos = 0;
             $previousBottomPos = 0;
             $p = new TeePoint($x, $y);

            for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {

                 $tmpX = $this->calcXPos($t);
                 $tmpY = $this->calcYPos($t);

                if ($this->getPointer()->getVisible()) {
                    if ($this->clickedPointer($t, $tmpX, $tmpY, $x, $y)) {
                        $this->doClickPointer($t, $x, $y);
                        return $t;
                    }
                }
                if (($tmpX == $x) && ($tmpY == $y)) {
                    return $t;
                }

                if (($t > $this->firstVisible) && $this->bClickableLine) {

                    $tmp = Array();
                    $tmp[0] = new TeePoint($oldXPos, $oldYPos);
                    $tmp[1] = new TeePoint($tmpX, $tmpY);
                    $tmp[2] = new TeePoint($tmpX, $this->getOriginPos($t));
                    $tmp[3] = new TeePoint($oldXPos, $this->getOriginPos($t - 1));

                    if ($this->checkPointInLine($p, $tmpX, $tmpY, $oldXPos,
                         $oldYPos) ||  ($this->drawArea &&
                         $this->Graphics3D->pointInPolygon($p, $tmp))) {
                        return $t - 1;
                    }
                }

                $oldXPos = $tmpX;
                $oldYPos = $tmpY;
                $previousBottomPos = $this->bottomPos;
            }
        }

        return $result;
    }

    protected function draw() {

      if ($this->shadow->getVisible())
          $tmpSize=$this->shadow->getSize();
      else
          $tmpSize=new Dimension(0,0);


      if (($tmpSize->width!=0) || ( $tmpSize->height!=0))
      {
         $tmpColor=$this->getSeriesColor();
         $this->setSeriesColor($this->shadow->getColor());

         $tmpPColor=$this->getPointer()->getVisible();
         $this->getPointer()->setVisible(False);

         $this->getHorizAxis()->iStartPos+=$this->shadow->getHorizSize();
         $this->getHorizAxis()->iEndPos+=$this->shadow->getHorizSize();
         $this->getVertAxis()->iStartPos+=$this->shadow->getVertSize();
         $this->getVertAxis()->iEndPos+=$this->shadow->getVertSize();

         parent::draw();

         $this->getHorizAxis()->iStartPos-=$this->shadow->getHorizSize();
         $this->getHorizAxis()->iEndPos-=$this->shadow->getHorizSize();
         $this->getVertAxis()->iStartPos-=$this->shadow->getVertSize();
         $this->getVertAxis()->iEndPos-=$this->shadow->getVertSize();

         $this->getPointer()->setVisible($tmpPColor);
         $this->setSeriesColor($tmpColor);
      }

      if (($this->outLine != null) && ($this->outLine->getVisible())) {
          $previousColor = $this->getColor();
          $this->setColor($this->outLine->getColor());
          $oldWidth = $this->linePen->getWidth();
          $oldPen = $this->linePen;
          $this->linePen = $this->outLine;
          $this->linePen->setWidth($oldWidth + $this->outLine->getWidth() + 2);
          parent::draw();
          $this->linePen->setWidth($oldWidth);
          $this->linePen = $oldPen;
          $this->setColor($previousColor);
      }
      parent::draw();
    }

    /* calculate vertical pixel */
    private function calcYPosLeftRight($yLimit, $anotherIndex, $valueIndex) {

         $tmpPredValueX = $this->vxValues->value[$anotherIndex];
         $tmpDif = $this->vxValues->value[$valueIndex] - $tmpPredValueX;
        if ($tmpDif == 0) {
            return $this->calcYPos($anotherIndex);
        } else {
             $tmpPredValueY = $this->vyValues->value[$anotherIndex];
            return $this->getVertAxis()->calcYPosValue(1.0 * $tmpPredValueY +
                                               ($this->yLimit - $tmpPredValueX) *
                                               ($this->vyValues->value[$valueIndex] -
                                                $tmpPredValueY) / $tmpDif);
        }
    }

//    private Rectangle RectFromPoints(int P0X,int P0Y,int P1X,int P1Y,int P2X,int P2Y,int P3X,int P3Y)
//    {
//      Rectangle r=new Rectangle();
//      r.x=Math.min(P3X,Math.min(P2X,Math.min(P0X,P1X)));
//      r.y=Math.min(P3Y,Math.min(P2Y,Math.min(P0Y,P1Y)));
//      r.width=Math.max(P3X,Math.max(P2X,Math.max(P0X,P1X)))-r.x;
//      r.height=Math.max(P3Y,Math.max(P2Y,Math.max(P0Y,P1Y)))-r.y;
//      return chart.getAspect().getView3D() ? chart.getGraphics3D().CalcRect3D(r,getStartZ()) : r;
//    }

    protected function getAreaBrushColor($c) {
        if ($this->bColorEach) {
            return $c;
        } else
        if ($this->bAreaBrush == null) {
            return $c;
        } else {
            return $this->bAreaBrush->getColor()->isEmpty() ? $c : $this->bAreaBrush->getColor();
        }
    }

    private function drawArea($brushColor, $x, $y) {    
        $g = $this->chart->getGraphics3D();

        if (!$this->bAreaBrush->getColor()->isEmpty()) {
            $this->bAreaBrush->setTransparency($this->getTransparency());
        }

        $this->chart->setBrushCanvas($brushColor, $this->bAreaBrush,
                             $this->bAreaBrush->getColor()->isEmpty() ? $this->getColor() :
                             $this->bAreaBrush->getColor());

        if ($this->chart->getAspect()->getView3D() && $this->isLastValue) { // final point
            if ($this->yMandatory) {
                $g->rectangleZ($x, $y, $this->bottomPos, $this->getStartZ(), $this->getEndZ());
            } else {
                $g->rectangleY($x, $y, $this->bottomPos, $this->getStartZ(), $this->getEndZ());
            }
        }

        if ($this->stairs) {
            if ($this->invertedStairs) {
                $tmpY = $this->yMandatory ? $y : $x;
                $tmpBottom = $this->bottomPos;
            } else {
                $tmpY = $this->yMandatory ? $this->oldY : $this->oldX;
                $tmpBottom = $this->oldBottomPos;
            }

            if ($this->yMandatory) {
                $tmpR = new Rectangle($this->oldX, $tmpY, $x - $this->oldX,
                                     $tmpBottom - $tmpY);
            } else {
                $tmpR = new Rectangle($tmpBottom, $y, $tmpY - $tmpBottom - 1,
                                     $this->oldY - $y);
            }

            if ($this->chart->getAspect()->getView3D()) {                                
                $g->rectangleWithZ($tmpR, $this->getStartZ());
                if ($g->getSupportsFullRotation()) {
                    $g->rectangleWithZ($tmpR, $this->getEndZ());
                }
            }
            else {
                $g->rectangle($tmpR);
            }
        } else {
            // not in "stairs" mode...
            if ($this->yMandatory) {
                $tmp0 = new TeePoint($this->oldX, $this->oldBottomPos);
                $tmp3 = new TeePoint($x, $this->bottomPos);
            } else {
                $tmp0 = new TeePoint($this->oldBottomPos, $this->oldY);
                $tmp3 = new TeePoint($this->bottomPos, $y);
            }

            $tmp1 = new TeePoint($this->oldX, $this->oldY);
            $tmp2 = new TeePoint($x, $y);

            if ($this->chart->getAspect()->getView3D()) {
                $g->_plane($tmp0, $tmp1, $tmp2, $tmp3, $this->startZ);
            } else
            if (($this->getBrush() != null) && ($this->getBrush()->getGradientVisible())) {
                $tmp = Array();
                $tmp[0] = $tmp0;
                $tmp[1] = $tmp1;
                $tmp[2] = $tmp2;
                $tmp[3] = $tmp3;

                $g->clipPolygon($tmp);

                $tmpMax = $this->calcPosValue($this->mandatory->getMaximum());
                $tmpMin = $this->calcPosValue($this->mandatory->getMinimum());

                if ($this->yMandatory) {
                    $tmpR = new Rectangle($this->oldX, $tmpMax, $x, $tmpMin);
                } else {
                    $tmpR = new Rectangle($tmpMin, $this->oldY, $tmpMax, $y);
                }

                $this->getBrush()->getGradient()->draw($g, $tmpR);
                $g->unClip();

                $this->getBrush()->setVisible(false);
                if ($this->pAreaLines->getVisible()) {
                    if ($this->yMandatory) {
                        $g->verticalLine($this->oldX, $this->oldY, $this->oldBottomPos);
                    } else {
                        $g->horizontalLine($this->oldBottomPos, $this->oldX, $this->oldY);
                    }
                }

            } else {
                $tmp = Array();
                $tmp[0] = $tmp0;
                $tmp[1] = $tmp1;
                $tmp[2] = $tmp2;
                $tmp[3] = $tmp3;
                $g->polygon($tmp);
            }

            if ($g->getSupportsFullRotation()) {
                $g->plane($tmp0, $tmp1, $tmp2, $tmp3, $this->getEndZ());
            }

            if ($this->linePen->getVisible()) {
                $g->setPen($this->getLinePen());
                $g->_line($this->oldX, $this->oldY, $x, $y, $this->getStartZ());
            }
        }
    }

    private function drawPoint($drawOldPointer, $valueIndex, $x, $y) {
      
        $p4 = Array();
        $p4[] = new TeePoint;
        $g = $this->chart->getGraphics3D();

        if ((($x != $this->oldX) || ($y != $this->oldY)) && (!$this->tmpColor->isEmpty())) { // <-- if !null
            if ($this->chart->getAspect()->getView3D()) {
                // 3D
                if ($this->drawArea || $this->drawLine) {
                    $g->setPen($this->getLinePen());
                    if ($this->tmpColor->isNull()) {
                        $g->getPen()->setColor($this->tmpColor);
                    }

                    //if ( linePen.getVisible() ) CheckPenWidth(g.Pen);

                    $g->setBrush($this->getBrush());

                    if ($this->colorEachLine || $this->drawArea) {
                        $oldDarkColor = $this->getAreaBrushColor($this->tmpColor);
                    } else {
                        $oldDarkColor = $this->getColor(); // 6.01
                    }

                    //OldDarkColor=GetAreaBrushColor(tmpColor);

                    $oldBrushColor = $g->getBrush()->getColor();
                    $g->getBrush()->setColor($oldDarkColor);

                    //                        if (transparency>0) {
                    //                            OldDarkColor=Color.FromArgb((100-transparency)*255/100,OldDarkColor);
                    //                            g.SetTransparency(transparency);
                    //                        }

                    //if ( g.getBrush().Image != null )
                    //  g.getBrush().Bitmap=Brush.Image.Bitmap;

                     $tmpPoint = new TeePoint($x, $y);
                     $tmpOldP = new TeePoint($this->oldX, $this->oldY);

                    if ($this->stairs) {
                        if ($this->invertedStairs) {
                            /* || LastValue=FirstValueIndex */
                            if ($this->bDark3D) {
                                $g->getBrush()->applyDark(GraphicsGD::$DARKCOLORQUANTITY);
                            }
                            $g->rectangleZ($tmpOldP->x, $tmpOldP->y, $y,
                                         $this->getStartZ(),
                                         $this->getEndZ());
                            if ($this->bDark3D) {
                                $g->getBrush()->setColor($oldDarkColor);
                            }
                            $g->rectangleY($tmpPoint->x, $tmpPoint->y, $this->oldX,
                                         $this->getStartZ(), $this->getEndZ());
                        } else {
                            $g->rectangleY($tmpOldP->x, $tmpOldP->y, $x,
                                         $this->getStartZ(),
                                         $this->getEndZ());
                            if ($this->bDark3D) {
                                $g->getBrush()->applyDark(GraphicsGD::$DARKCOLORQUANTITY);
                            }
                            $g->rectangleZ($tmpPoint->x, $tmpPoint->y, $this->oldY,
                                         $this->getStartZ(), $this->getEndZ());
                            if ($this->bDark3D) {
                                $g->getBrush()->setColor($oldDarkColor);
                            }
                        }
                    } else {
                        if (($this->lineHeight > 0) && (!$this->drawArea)) {
                            $p4[0] = $tmpPoint;
                            $p4[1] = $tmpOldP;
                            $p4[2] = new TeePoint($tmpOldP);
                            $p4[2]->y += $this->lineHeight;
                            $p4[3] = new TeePoint($tmpPoint);
                            $p4[3]->y += $this->lineHeight;

                            $g->planeFour3D($this->getStartZ(), $this->getStartZ(), $p4);

                            if ($this->isLastValue) {
                                $g->rectangleZ($tmpPoint->x, $tmpPoint->y,
                                             $tmpPoint->y + $this->lineHeight,
                                             $this->getStartZ(), $this->getEndZ());
                            }
                        }

                         $tmpDark3D = $this->bDark3D && (!$g->getSupportsFullRotation());
                        if ($tmpDark3D) {

                             $tmpDifX = $tmpPoint->getX() - $tmpOldP->getX();

                            if (($tmpDifX != 0) && ($this->tmpDark3DRatio != 0) &&
                                (($tmpOldP->getY() - $tmpPoint->getY()) / $tmpDifX >
                                 $this->tmpDark3DRatio)) {
                                $g->getBrush()->applyDark(GraphicsGD::$DARKCOLORQUANTITY);
                                if (($this->lineHeight > 0) && (!$this->drawArea)) {
                                    /*special case*/
                                    $tmpPoint->setY($tmpOldP->getY() + $this->lineHeight);
                                    $tmpOldP->setY($tmpOldP->getY() + $this->lineHeight);
                                }
                            }
                        }
                        if ($g->getMonochrome()) {
                            $this->tmpColor = new Color(255,255,255);  // White
                            $g->getBrush()->setColor($this->tmpColor);
                        }


                        $g->plane($tmpPoint, $tmpOldP, $this->getStartZ(), $this->getEndZ());

                        if ($tmpDark3D) {
                            $g->getBrush()->setColor($oldDarkColor);
                        }
                    }
                    $g->getBrush()->setColor($oldBrushColor);
                }
            }
        }

        if ($this->drawArea) {
            //Color oldColor=g.getBrush().Color;
            $g->getBrush()->setColor($this->getAreaBrushColor($this->tmpColor));

            $g->setPen($this->pAreaLines);

            if ($this->pAreaLines->getColor()->isEmpty() || (!$this->pAreaLines->getVisible())) {
                $g->getPen()->setColor($this->tmpColor);
            } else {
                $g->setPen($this->pAreaLines);
            }

            $this->drawArea($g->getBrush()->getColor(), $x, $y);
            //g.getBrush().Color=oldColor;
        } else
        if ((!$this->chart->getAspect()->getView3D()) && $this->drawLine) {

            // line 2D
            $this->linePrepareCanvas($g, $this->colorEachLine ? $this->tmpColor : $this->getColor());

            if ($this->stairs) {
                if ($this->invertedStairs) {
                    $g->verticalLine($this->oldX, $this->oldY, $y);
                } else {
                    $g->horizontalLine($this->oldX, $x, $this->oldY);
                }
                $g->moveToXY($x,$this->oldY);
                $g->_____lineTo($x, $y);        
//                $g->___lineTo($this->oldX, $this->oldY, 0);                
            } else {                
                $g->line($this->oldX, $this->oldY, $x, $y);
            }
        }

        /* pointers */
        if ($this->point->getVisible() && $drawOldPointer) {
            if (!$this->oldColor->isEmpty()) /* <-- if ( !null */
            {
                $this->drawPointer($this->oldX, $this->oldY, $this->oldColor, $valueIndex - 1);
            }
            if ($this->isLastValue && (!$this->tmpColor->isEmpty())) /*<-- if ( !null */
            {
                $this->drawPointer($x, $y, $this->tmpColor, $valueIndex);
            }
        }
    }

    /**
      * Called internally. Draws the "ValueIndex" point of the Series.
      *
      * @param valueIndex int
      */
    public function drawValue($valueIndex) {
       
        $g = $this->chart->getGraphics3D();

        $this->tmpColor = $this->getValueColor($valueIndex);
        $x = $this->calcXPos($valueIndex);
        $y = $this->calcYPos($valueIndex);

        $g->getPen()->setColor(new Color(0,0,0));
        $g->getBrush()->setColor($this->tmpColor);

        if ($this->oldColor->isEmpty()) { // if null
            $this->oldX = $x;
            $this->oldY = $y;
        }

        $this->bottomPos = $this->getOriginPos($valueIndex);

        if ($this->drawValuesForward()) {
            $tmpFirst = $this->firstVisible;
            $this->isLastValue = ($valueIndex == $this->lastVisible);
        } else {
            $tmpFirst = $this->lastVisible;
            $this->isLastValue = ($valueIndex == $this->firstVisible);
        }

        if ($valueIndex == $tmpFirst) {
            // first point
            if ($this->bDark3D) {
                if ($this->chart->getSeriesWidth3D() != 0) {
                    $this->tmpDark3DRatio = $this->chart->getSeriesHeight3D() / $this->chart->getSeriesWidth3D();
                } else {
                    $this->tmpDark3DRatio = 1;
                }
            }

            if (($tmpFirst == $this->firstVisible) && ($valueIndex > 0)) {
                // previous point outside left
                if ($this->drawArea) {
                    $this->oldX = $this->calcXPos($valueIndex - 1);
                    $this->oldY = $this->calcYPos($valueIndex - 1);
                    $this->oldBottomPos = $this->getOriginPos($valueIndex - 1);
                } else {
                    $tmpRect = $this->chart->getChartRect();
                    $this->oldX = $this->getHorizAxis()->getInverted() ? $tmpRect->getRight() :
                           $tmpRect->x;

                    if ($this->stairs) {
                        $this->oldY = $this->calcYPos($valueIndex - 1);
                    } else {
                        $this->oldY = $this->calcYPosLeftRight($this->xScreenToValue($this->oldX),
                                                 $valueIndex - 1, $valueIndex);
                    }
                }
                if (!$this->isNull($valueIndex - 1)) {
                    $this->drawPoint(false, $valueIndex, $x, $y);
                }
            }

            if ($this->isLastValue && $this->point->getVisible()) {
                $this->drawPointer($x, $y, $this->tmpColor, $valueIndex);
            }

            if ($g->getSupportsFullRotation() && $this->drawArea &&
                $this->chart->getAspect()->getView3D()) {
                $g->rectangleZ($x, $y, $this->bottomPos, $this->getStartZ(), $this->getEndZ());
            }
        } else {
            if (!$this->isNull($valueIndex - 1)) {
                $this->drawPoint(true, $valueIndex, $x, $y);
            }
        }

        $this->oldX = $x;
        $this->oldY = $y;
        $this->oldBottomPos = $this->bottomPos;
        $this->oldColor = $this->tmpColor;
    }

    private function drawLine($g, $drawRectangle, $tmpColor, $rect) {
        
        if ($this->chart->getLegend()->getSymbol()->getDefaultPen()) {
            $this->linePrepareCanvas($g, $tmpColor);
        }

        if ($drawRectangle) {
            $g->rectangle($rect);
        } else {
            $g->horizontalLine($rect->x, $rect->getRight(),
                             ($rect->y + $rect->getBottom()) / 2,0);
        }
    }

    protected function drawLegendShape($g, $valueIndex, $rect) {
        
        $tmpLegendColor = ($valueIndex == -1) ? $this->getColor() :
                         $this->getValueColor($valueIndex);
                         
        if ($this->getPointer()->getVisible()) {
            if ($this->drawLine) {
                $this->drawLine($g, false, $tmpLegendColor, $rect);
            }
            $this->point->drawLegendShape($g, $tmpLegendColor, $rect, $this->getLinePen()->getVisible());
        } else
        if ($this->drawLine && (!$this->drawArea)) {
            $this->drawLine($g, $this->chart->getAspect()->getView3D(), $tmpLegendColor, $rect);
        } else {
            parent::drawLegendShape($g, $valueIndex, $rect);
        }
    }

    private function linePrepareCanvas($g, $aColor) {
        if ($g->getMonochrome()) {
            $aColor = new Color(255,255,255);  // White
        }
        if ($this->chart->getAspect()->getView3D()) {
            $g->setBrush($this->getBrush());

            if ($this->bBrush->getImage() != null) {
                $g->getBrush()->setImage($this->bBrush->getImage());
            } else {
                $g->getBrush()->setStyle($this->bBrush->getStyle());
                $g->getBrush()->setColor($aColor);
            }
            $g->setPen($this->getLinePen());
            if ($aColor->isNull()) {
                $g->getPen()->setColor($aColor);
            }
        } else {
            $g->getBrush()->setVisible(false);
            $g->setPen($this->getLinePen());
            $g->getPen()->setColor($aColor);
        }
        // chart.CheckPenWidth(g.Pen);
    }

    public function getShadow() {
       return $this->shadow;
    }

    public function setShadow($value) {
       $this->shadow->assign($value);
    }
}

?>