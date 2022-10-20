<?php
 /**
 * Description:  This file contains the following class:<br>
 * ShapeSeries class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: ShapeSeries class</p>
  *
  * <p>Description: Shape Series.</p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

  class ShapeSeries extends Series {

    private $shape;
    private $style;
    private $xyStyle;
    private $textVertAlign;
    private $textHorizAlign;

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

        $this->style = ShapeStyle::$CIRCLE;
        $this->xyStyle = ShapeXYStyle::$AXIS;
        $this->textVertAlign = ShapeTextVertAlign::$CENTER;
        $this->textHorizAlign = ShapeTextHorizAlign::$CENTER;

        $this->shape = new TextShape($c);

        parent::__construct($c);

        $this->getBrush()->setColor(new Color(255,255,255));
        $this->setSeriesColor($this->getBrush()->getColor());

        $this->addDefaultPoints();
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->shape);
        unset($this->style);
        unset($this->xyStyle);
        unset($this->textVertAlign);
        unset($this->textHorizAlign);
    }     
        
    public function setChart($c) {

        parent::setChart($c);

        if ($this->shape != null) {
            $this->shape->setChart($c);
        }
    }

    private function addDefaultPoints() {
        if (parent::getChart() != null) {
            $this->addXY(0, 0);
            $this->addXY(100, 100);
        }
    }

    protected function drawLegendShape($g, $valueIndex, $rect) {
        $this->drawShape($g, false, $rect);
    }

    private function drawText($r) {

        $tmpPosX = 0;
        $tmpH = 0;
        $tmpPosY = 0;
        $tmpWidth = 0;

        $g = $this->chart->getGraphics3D();
        if (sizeof($this->getText()) > 0) {
            $g->setFont($this->getFormat()->getFont());
            $tmpH = MathUtils::round($g->fontTextHeight($this->getFont()));

            $tmpMid = $r->center();

            if ($this->textVertAlign == ShapeTextVertAlign::$TOP) {
                $tmpPosY = $r->getTop();
            } else
            if ($this->textVertAlign == ShapeTextVertAlign::$CENTER) {
                $tmpPosY = $tmpMid->getY() - MathUtils::round($tmpH * sizeof($this->getText()) / 2.0);
            } else {
                $tmpPosY = $r->getBottom() - ($tmpH * strlen($this->getText()));
            }

            for ( $t = 0; $t < sizeof($this->getText()); $t++) {
                $tmpWidth = $g->textWidth($this->getText($t));

                if ($this->textHorizAlign == ShapeTextHorizAlign::$CENTER) {
                    $tmpPosX = $tmpMid->getX() - ($tmpWidth / 2);
                } else
                if ($this->textHorizAlign == ShapeTextHorizAlign::$LEFT) {
                    $tmpPosX = $r->getLeft() + $this->getPen()->getWidth() + $shapeHorizMargin;
                } else {
                    $tmpPosX = $r->getRight() - $this->getPen()->getWidth() - $tmpWidth -
                              $shapeHorizMargin;
                }

                if ($this->getXYStyle() == ShapeXYStyle::$PIXELS) {
                    $g->textOut($tmpPosX, $tmpPosY, 0, $this->getText($t));
                } else {
                    $g->textOut($tmpPosX, $tmpPosY, $this->getStartZ(), $this->getText($t));
                }

                $tmpPosY += $tmpH;
            }
        }
    }

    /**
      * Displays customized Strings inside Shapes.<br>
      * You can use the Font and Aligment properties to control Text display.<br>
      * <b>Note:</b> You may need to change Shape Font size to a different
      * value when creating metafiles or when zooming Charts.
      *
      * @return String[]
      */
    public function getText($index=-1) {
      if ($index != -1) {
        $tmpx = array();  
        $tmpx = $this->shape->getLines();

        return $tmpx[$index];
      }
      else
      {        
        if ($this->shape->getLines() == null) {
            $tmpStr = "";
            $this->shape->setLines($tmpStr);
        }
        return $this->shape->getLines();
      }
    }

    /**
      * Coordinate used to define the englobing ShapeSeries rectangle.<br>
      * The values should be expressed in Axis coordinates. <br>
      * You can convert from Screen pixel coordinates to values and vice-versa
      * using several TChart and Series methods like XScreenToValue and
      * YScreenToValue.
      *
      * @return double
      */
    public function getX0() {
        return $this->vxValues->value[0];
    }

    /**
      * Coordinate used to define the englobing ShapeSeries rectangle.<br>
      *
      * @param value double
      */
    public function setX0($value) {
        $this->vxValues->value[0] = $value;
        $this->invalidate();
    }

    /**
      * Coordinate used to define the englobing ShapeSeries rectangle.<br>
      * The values should be expressed in Axis coordinates. <br>
      * You can convert from Screen pixel coordinates to values and vice-versa
      * using several TChart and Series methods like XScreenToValue and
      * YScreenToValue.
      *
      * @return double
      */
    public function getX1() {
        return $this->vxValues->value[1];
    }

    /**
      * Coordinate used to define the englobing ShapeSeries rectangle.<br>
      *
      * @param value double
      */
    public function setX1($value) {
        $this->vxValues->value[1] = $value;
        $this->invalidate();
    }

    /**
      * Coordinate used to define the englobing ShapeSeries rectangle.<br>
      * The values should be expressed in Axis coordinates. <br>
      * You can convert from Screen pixel coordinates to values and vice-versa
      * using several TChart and Series methods like XScreenToValue and
      * YScreenToValue.
      *
      * @return double
      */
    public function getY0() {
        return $this->vyValues->value[0];
    }

    /**
      * Coordinate used to define the englobing ShapeSeries rectangle.<br>
      *
      * @param value double
      */
    public function setY0($value) {
        $this->vyValues->value[0] = $value;
        $this->invalidate();
    }

    /**
      * Coordinate used to define the englobing ShapeSeries rectangle.<br>
      * The values should be expressed in Axis coordinates. <br>
      * You can convert from Screen pixel coordinates to values and vice-versa
      * using several TChart and Series methods like XScreenToValue and
      * YScreenToValue.
      *
      * @return double
      */
    public function getY1() {
        return $this->vyValues->value[1];
    }

    /**
      * Coordinate used to define the englobing ShapeSeries rectangle.<br>
      *
      * @param value double
      */
    public function setY1($value) {
        $this->vyValues->value[1] = $value;
        $this->invalidate();
    }

    /**
      * Defines how a TChartShape component appears on a Chart.<br>
      * Default value: Circle
      *
      *
      * @return ShapeStyle
      */
    public function getStyle() {
        return $this->style;
    }

    /**
      * Defines how a TChartShape component appears on a Chart.<br>
      * Default value: Circle
      *
      *
      * @param value ShapeStyle
      */
    public function setStyle($value) {
        $this->style = $value;
        $this->chart->invalidate();
    }

    public function getFormat() {
        return $this->shape;
    }

    /**
      * Sets the vertical alignment of Text within a TChartShape Series shape.
      * <br>
      * It can be Top, Center, Bottom.
      *
      * @return ShapeTextVertAlign
      */
    public function getVertAlignment() {
        return $this->textVertAlign;
    }

    /**
      * Sets the vertical alignment of Text within a TChartShape Series shape.
      * <br>
      *
      * @param value ShapeTextVertAlign
      */
    public function setVertAlignment($value) {
        if ($this->textVertAlign != $value) {
            $this->textVertAlign = $value;
        }
        $this->repaint();
    }

    /**
      * Horizontally aligns the text.<br>
      * There are three options; Centre, Left or Right.
      *
      * @return ShapeTextHorizAlign
      */
    public function getHorizAlignment() {
        return $this->textHorizAlign;
    }

    /**
      * Horizontally aligns the text.<br>
      *
      * @param value ShapeTextHorizAlign
      */
    public function setHorizAlignment($value) {
        if ($this->textHorizAlign != $value) {
            $this->textHorizAlign = $value;
        }
        $this->repaint();
    }

    private function getShapeRectangle() {

        if ($this->xyStyle==ShapeXYStyle::$PIXELS) {
            $x0 = (int) ($this->getX0());
            $y0 = (int) ($this->getY0());
            $x1 = (int) ($this->getX1());
            $y1 = (int) ($this->getY1());
        }
        else
        if ($this->xyStyle==ShapeXYStyle::$AXIS) {
            $x0 = $this->calcXPos(0);
            $y0 = $this->calcYPos(0);
            $x1 = $this->calcXPos(1);
            $y1 = $this->calcYPos(1);
        }
        else
            {
            $x0 = $this->calcXPos(0);
            $y0 = $this->calcYPos(0);
            $x1 = $x0 + (int) ($this->getX1());
            $y1 = $y0 + (int) ($this->getY1());
        }

        return Rectangle::fromLTRB($x0, $y0, $x1, $y1);
    }

    private function getAdjustedRectangle() {
        $r = $this->getShapeRectangle();
        if ($r->y == $r->getBottom()) {
            $r->height = 1;
        } else
        if ($r->y > $r->getBottom()) {
             $tmp = $r->height;
            $r->y = $r->getBottom();
            $r->height = ( -$tmp);
        }

        if ($r->x == $r->getRight()) {
            $r->width = 1;
        } else
        if ($r->x > $r->getRight()) {
             $tmp = $r->width;
            $r->x = $r->getRight();
            $r->width = ( -$tmp);
        }

        return $r;
    }

    private function drawDiagonalCross2D($g, $r) {
        $g->line($r->x, $r->y, $r->getRight() + 1, $r->getBottom() + 1);
        $g->line($r->x, $r->getBottom(), $r->getRight() + 1, $r->y - 1);
    }

    private function drawDiagonalCross3D($g, $r) {
        $g->line($r->x, $r->y, $r->getRight(), $r->getBottom(), $this->getMiddleZ());
        $g->line($r->x, $r->getBottom(), $r->getRight(), $r->y, $this->getMiddleZ());
    }

    private function drawCross3D($g, $r) {
        $tmpMid = $r->center();
        $g->verticalLine($tmpMid->x, $r->y, $r->getBottom(), $this->getMiddleZ());
        $g->horizontalLine($r->x, $r->getRight(), $tmpMid->y, $this->getMiddleZ());
    }

    private function drawCross2D($g, $r) {
        $tmpMid = $r->center();
        $g->verticalLine($tmpMid->x, $r->y, $r->getBottom() + 1);
        $g->horizontalLine($r->x, $r->getRight() + 1, $tmpMid->y);
    }

    private function doGradient($is3D, $r) {

        $g=$this->chart->getGraphics3D();
        if ((!$this->getTransparent()) && $this->getGradient()->getVisible()) {
             $tmpR = $is3D ? $g->calcRect3D($r, $this->getMiddleZ()) : $r;
            if ($this->style == ShapeStyle::$CIRCLE) {
                $g->clipEllipse($tmpR);
            }

            $this->getGradient()->draw($this->chart->getGraphics3D(), $tmpR);

            if ($this->style == ShapeStyle::$CIRCLE) {
                $g->unClip();
            }
            $g->getBrush()->setVisible(false);
        }
    }

    private function _drawShape($is3D, $r) {
        $this->drawShape($this->chart->getGraphics3D(), $is3D, $r);
    }

    private function drawShape($g, $is3D, $r) {
        $g->setPen($this->getPen());

        if ($this->getTransparent()) {
            $g->getBrush()->setVisible(false);
        } else {
            $g->setBrush($this->getBrush());
            $g->getBrush()->setColor($this->getColor());
        }

        //            if ( Brush.Color.isEmpty())
        //                g.getBrush().getVisible()=false;

        // TODO assign visible brush to false if transparent is true


        $tmpMid = $r->center();

        if ($is3D) {
            if ($this->style==ShapeStyle::$RECTANGLE) {
                $this->doGradient($is3D, $r);
                $g->rectangle($r, $this->getMiddleZ());
            }
            else
            if ($this->style==ShapeStyle::$CIRCLE) {
                $this->doGradient($is3D, $r);
                $g->ellipseRectZ($r, $this->getMiddleZ());
            }
            else
            if ($this->style==ShapeStyle::$VERTLINE) {
                $g->verticalLine($tmpMid->getX(), $r->getY(), $r->getBottom(), $this->getMiddleZ());
            }
            else
            if ($this->style==ShapeStyle::$HORIZLINE) {
                $g->horizontalLine($r->getX(), $r->getRight(), $tmpMid->getY(), $this->getMiddleZ());
            }
            else
            if ($this->style==ShapeStyle::$TRIANGLE) {
                $g->triangle(new TeePoint($r->getX(), $r->getBottom()),
                           new TeePoint($tmpMid->getX(), $r->getY()),
                           new TeePoint($r->getRight(), $r->getBottom()), $this->getMiddleZ());
            }
            else
            if ($this->style==ShapeStyle::$INVERTTRIANGLE) {
                $g->triangle(new TeePoint($r->getX(), $r->getY()),
                           new TeePoint($tmpMid->getX(), $r->getBottom()),
                           new TeePoint($r->getRight(), $r->getY()), $this->getMiddleZ());
            }
            else
            if ($this->style==ShapeStyle::$LINE) {
                $g->line($r->getX(), $r->getY(), $r->getRight(), $r->getBottom(), $this->getMiddleZ());
            }
            else
            if ($this->style==ShapeStyle::$DIAMOND) {
                $g->plane(new TeePoint($r->getX(), $tmpMid->getY()),
                        new TeePoint($tmpMid->getX(), $r->getY()),
                        new TeePoint($r->getRight(), $tmpMid->getY()),
                        new TeePoint($tmpMid->getX(), $r->getBottom()), $this->getMiddleZ());
            }
            else
            if ($this->style==ShapeStyle::$CUBE) {
                $g->cube($r, $this->getStartZ(), $this->getEndZ(), !$this->getTransparent());
            }
            else
            if ($this->style==ShapeStyle::$CROSS) {
                $this->drawCross3D($g,$r);
            }
            else
            if ($this->style==ShapeStyle::$DIAGCROSS) {
                $this->drawDiagonalCross3D($g,$r);
            }
            else
            if ($this->style==ShapeStyle::$STAR) {
                $this->drawCross3D($g,$r);
                $this->drawDiagonalCross3D($g,$r);
            }
            else
            if ($this->style==ShapeStyle::$PYRAMID) {
                $g->pyramid(true, $r, $this->getStartZ(), $this->getEndZ(), !$this->getTransparent());
            }
            else
            if ($this->style==ShapeStyle::$INVERTPYRAMID) {
                $g->pyramid(true, $r->getX(), $r->getBottom(), $r->getRight(), $r->getY(), $this->getStartZ(),
                          $this->getEndZ(),
                          !$this->getTransparent());
            }
        } else {
            if ($this->style==ShapeStyle::$RECTANGLE) {
                if ($this->getFormat()->getShapeStyle() ==
                    TextShapeStyle::$ROUNDRECTANGLE) {
                     $roundSize = 12;
                     $tmpR = new Rectangle($r->getLeft(), $r->getTop(),
                            $r->width - $roundSize,
                            $r->height - $roundSize);
                    $g->roundRectangle($tmpR, $roundSize, $roundSize);
                } else {
                    $this->doGradient($is3D, $r);

                    $g->rectangle($r);
                }
            }
            else
            if ($this->style==ShapeStyle::$CIRCLE) {
                $this->doGradient($is3D, $r);
                $g->ellipseRect($r);
            }
            else
            if ($this->style==ShapeStyle::$VERTLINE) {
                $g->verticalLine($tmpMid->getX(), $r->getY(), $r->getBottom());
            }
            else
            if ($this->style==ShapeStyle::$HORIZLINE) {
                $g->horizontalLine($r->getX(), $r->getRight() + 1, $tmpMid->getY());
            }
            else
            if (($this->style==ShapeStyle::$TRIANGLE) |
                ($this->style==ShapeStyle::$PYRAMID)) {
                // Point[] array
                $tmp = Array(new TeePoint($r->getX(), $r->getBottom()),
                              new TeePoint($tmpMid->getX(), $r->getY()),
                              new TeePoint($r->getRight(), $r->getBottom()));
                $g->polygon($tmp);
            }
            else
            if (($this->style==ShapeStyle::$INVERTTRIANGLE) |
                ($this->style==ShapeStyle::$INVERTPYRAMID)) {
                // Point[] array
                $tmp = Array(new TeePoint($r->getX(), $r->getY()),
                              new TeePoint($tmpMid->getX(), $r->getBottom()),
                              new TeePoint($r->getRight(), $r->getY()));
                $g->polygon($tmp);
            }
            else
            if ($this->style==ShapeStyle::$LINE) {
                $g->line($r->getX(), $r->getY(), $r->getRight(), $r->getBottom());
            }
            else
            if ($this->style==ShapeStyle::$DIAMOND) {
                // Point[] array
                $tmp = Array(new TeePoint($r->getX(), $tmpMid->getY()),
                              new TeePoint($tmpMid->getX(), $r->getY()),
                              new TeePoint($r->getRight(), $tmpMid->getY()),
                              new TeePoint($tmpMid->getX(), $r->getBottom()));
                $g->polygon($tmp);
            }
            else
            if ($this->style==ShapeStyle::$CUBE) {
                $g->rectangle($r);
            }
            else
            if ($this->style==ShapeStyle::$CROSS) {
                $this->drawCross2D($g,$r);
            }
            else
            if ($this->style==ShapeStyle::$DIAGCROSS) {
                $this->drawDiagonalCross2D($g,$r);
            }
            else
            if ($this->style==ShapeStyle::$STAR) {
                $this->drawCross2D($g,$r);
                $this->drawDiagonalCross2D($g,$r);
            }
        }
    }

    /**
      * Called internally. Draws the "ValueIndex" point of the Series.
      *
      * @param valueIndex int
      */
    public function drawValue($valueIndex) {
        if (($this->getCount() == 2) && ($valueIndex == 0)) {
            $r = $this->getAdjustedRectangle();
            if ($r->intersects($this->chart->getChartRect())) {
                 $tmp = ($this->xyStyle == ShapeXYStyle::$PIXELS) ? false :
                              $this->chart->getAspect()->getView3D();

                $this->_drawShape($tmp,
                    ($this->style == ShapeStyle::$LINE) ? $this->getShapeRectangle() : $r);

                $this->drawText($r);
            }
        }
    }

    protected function addSampleValues($numValues) {
        $r = $this->randomBounds(1);
        if ($r->StepX == 0) {
            $this->addDefaultPoints();
        } else {
            $this->add($r->tmpX + ($r->StepX / 8.0), $r->tmpY / 2);
            $this->add($r->tmpX + $r->StepX - ($r->StepX / 8.0),
                $r->tmpY + MathUtils::round($r->DifY * $r->Random()));
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

         $p;

        if (($this->chart != null)) {
            $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y, $this->getStartZ());
        } else {
            $p = new TeePoint($x, $y);
        }

         $r = $this->getShapeRectangle();
         $tmpMid = $r->center();

         $tmp;

        if ($this->style==ShapeStyle::$VERTLINE){
            $tmp = GraphicsGD::pointInLineTolerance($p, $tmpMid->x, $r->y, $tmpMid->x,
                                                  $r->getBottom(), 3);
        } else if ($this->style==ShapeStyle::$HORIZLINE) {
            $tmp = GraphicsGD::pointInLineTolerance($p, $r->x, $tmpMid->y, $r->getRight(),
                                                  $tmpMid->y, 3);
        } else if ($this->style==ShapeStyle::$LINE) {
            $tmp = GraphicsGD::pointInLineTolerance($p, $r->x, $r->y, $r->getRight(),
                                                  $r->getBottom(), 3);
        } else if ($this->style==ShapeStyle::$DIAMOND) {
            // Point[] array
            $points=Array (new TeePoint($tmpMid->x, $r->y),
                                            new TeePoint($r->getRight(), $tmpMid->y),
                                            new TeePoint($tmpMid->x, $r->getBottom()),
                                            new TeePoint($r->x, $tmpMid->y));

            $tmp = GraphicsGD::pointInPolygon($p, $points);
        } else if (($this->style==ShapeStyle::$TRIANGLE) | ($this->style==ShapeStyle::$PYRAMID)) {
            $tmp = GraphicsGD::pointInTriangle($p, $r->x, $r->getRight(), $r->getBottom(), $r->y);
        } else if (($this->style==ShapeStyle::$INVERTTRIANGLE) | ($this->style==ShapeStyle::$INVERTPYRAMID)) {
            $tmp = GraphicsGD::pointInTriangle($p, $r->x, $r->getRight(), $r->y, $r->getBottom());
        } else if ($this->style==ShapeStyle::$CIRCLE) {
            $tmp = GraphicsGD::pointInEllipse($p, $r);
        } else {
            $tmp = $r->contains($x, $y);
        }
        return $tmp ? 0 : -1;
    }

    /**
      * Determines the font attributes used to output ShapeSeries.<br>
      * No auto font sizing is performed, so you must specify the desired font
      * size to avoid shape text from overlapping the Shape boundaries.
      *
      * @return ChartFont
      */
    public function getFont() {
        return $this->shape->getFont();
    }

    /**
      * Defines the brush used to fill shape background.<br>
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * //shape1
      * shape[0] = new TeeShape(myChart.getChart());
      * tmpShape = shape[0];
      * tmpShape.getMarks().setVisible(false);
      * tmpShape.setColor(Color.WHITE);
      * tmpShape.getBrush().setColor(Color.WHITE);
      * tmpShape.getBrush().setImageMode(ImageMode::$TILE);
      * tmpShape.getBrush().loadImage(ChartSamplePanel.class.getResource(URL_IMAGE1));
      *
      * tmpShape.setStyle(ShapeStyle::$CIRCLE);
      * tmpShape.getPen().setColor(Color.RED);
      * tmpShape.getPen().setWidth(2);
      * tmpShape.setX1(50);
      * tmpShape.setY1(50);
      * </font></pre></p>
      *
      * @return ChartBrush
      */
    public function getBrush() {
        return $this->shape->getBrush();
    }

    /**
      * Defines pen to draw Series Shape.
      *
      * @return ChartPen
      */
    public function getPen() {
        return $this->shape->getPen();
    }

    /**
      * Gets Gradient fill characteristics for the ShapeSeries Shape.
      *
      * @return Gradient
      */
    public function getGradient() {
        return $this->shape->getGradient();
    }

    public function setText($value) {
        $this->shape->setLines($value);
    }

    /**
      * Allows Shape Brush attributes to fill the interior of the Shape.<br>
      * When false, Shapes do not redraw their background, so charting contents
      * behind Shape Series is seen inside the Shape. <br>
      * Default value: false
      *
      * @return boolean
      */
    public function getTransparent() {
        return $this->shape->getTransparent();
    }

    /**
      * Allows Shape Brush attributes to fill the interior of the Shape.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setTransparent($value) {
        $this->shape->setTransparent($value);
    }

    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);

        $tmpColor = new Color(255,255,255); // White
        $this->getFont()->setColor($tmpColor);
        $this->getFont()->setSize(12);
        // String[1] array
        $tmpArray = Array();
        $this->shape->setLines($tmpArray);
        if ($this->chart->getSeriesIndexOf($this) == 1) {
            $this->style = ShapeStyle::$CIRCLE;
            $this->getBrush()->setColor($isEnabled ? $tmpColor->BLUE : $tmpColor->SILVER);
            // String[] array
            $tmp= Array(Language::getString("ShapeGallery1"));
            $this->setText($tmp);
        } else {
            $this->style = ShapeStyle::$TRIANGLE;
            $this->getBrush()->setColor($isEnabled ? $tmpColor->RED : $tmpColor->SILVER);
            // String[] array
            $tmp= Array(Language::getString("ShapeGallery2"));
            $this->setText($tmp);
        }
    }

    public function calcZOrder() {
        if ($this->getUseAxis()) {
            parent::calcZOrder();
        }
    }

    protected function moreSameZOrder() {
        return false;
    }

    /**
      * Can be set to:- Axis, AxisOrigin or Pixels.
      *
      *
      * @return ShapeXYStyle
      */
    public function getXYStyle() {
        return $this->xyStyle;
    }

    /**
      * Can be set to:- Axis, AxisOrigin or Pixels.
      *
      *
      * @param value ShapeXYStyle
      */
    public function setXYStyle($value) {
        if ($this->xyStyle != $value) {
            $this->xyStyle = $value;
            $this->repaint();
        }
    }

    /**
      * Returns false if the Value parameter is the same as Self.
      *
      * @param s Series
      * @return boolean
      */
    public function isValidSourceOf($s) {
        return $s instanceof Shape;
    }

    public function createSubGallery($addSubChart) {
        parent::createSubGallery($addSubChart);

        $addSubChart->createSubChart(Language::getString("Rectangle"));
        $addSubChart->createSubChart(Language::getString("VertLine"));
        $addSubChart->createSubChart(Language::getString("HorizLine"));
        $addSubChart->createSubChart(Language::getString("Ellipse"));
        $addSubChart->createSubChart(Language::getString("DownTri"));
        $addSubChart->createSubChart(Language::getString("Line"));
        $addSubChart->createSubChart(Language::getString("Diamond"));
        $addSubChart->createSubChart(Language::getString("Cube"));
        $addSubChart->createSubChart(Language::getString("Cross"));
        $addSubChart->createSubChart(Language::getString("DiagCross"));
        $addSubChart->createSubChart(Language::getString("Star"));
        $addSubChart->createSubChart(Language::getString("Pyramid"));
        $addSubChart->createSubChart(Language::getString("InvPyramid"));
        $addSubChart->createSubChart(Language::getString("Hollow"));
    }

    public function setSubGallery($index) {
        switch ($index) {
        case 1:
            $this->setStyle(ShapeStyle::$RECTANGLE);
            break;
        case 2:
            $this->setStyle(ShapeStyle::$VERTLINE);
            break;
        case 3:
            $this->setStyle(ShapeStyle::$HORIZLINE);
            break;
        case 4:
            $this->setStyle(ShapeStyle::$CIRCLE);
            break;
        case 5:
            $this->setStyle(ShapeStyle::$INVERTTRIANGLE);
            break;
        case 6:
            $this->setStyle(ShapeStyle::$LINE);
            break;
        case 7:
            $this->setStyle(ShapeStyle::$DIAMOND);
            break;
        case 8:
            $this->setStyle(ShapeStyle::$CUBE);
            break;
        case 9:
            $this->setStyle(ShapeStyle::$CROSS);
            break;
        case 10:
            $this->setStyle(ShapeStyle::$DIAGCROSS);
            break;
        case 11:
            $this->setStyle(ShapeStyle::$STAR);
            break;
        case 12:
            $this->setStyle(ShapeStyle::$PYRAMID);
            break;
        case 13:
            $this->setStyle(ShapeStyle::$INVERTPYRAMID);
            break;
        case 14:
            $this->setTransparent(!$this->getTransparent());
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
        return Language::getString("GalleryShape");
    }
}
?>