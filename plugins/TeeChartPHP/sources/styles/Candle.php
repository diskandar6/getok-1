<?php
 /**
 * Description:  This file contains the following class:<br>
 * Candle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Candle class
 *
 * Description: Candle Series
 *
 * Example:
 * $candleSeries = Candle($myChart->getChart());
 * $candleSeries->fillSampleValues(30);
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Candle extends OHLC {

    private static $DEFAULTCANDLEWIDTH = 4;
    private $upCloseColor;
    private $downCloseColor;
    private $candleWidth;
    private $style;
    private $showOpenTick = true;
    private $showCloseTick = true;
    private $oldP;

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

    public function __construct($c=null) 
    {
        $this->upCloseColor = Color::WHITE();
        $this->downCloseColor = Color::RED();
        $this->candleWidth = self::$DEFAULTCANDLEWIDTH;
        $this->style = CandleStyle::$CANDLESTICK;

        parent::__construct($c);

        $this->getPointer()->setDraw3D(false);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->upCloseColor);
        unset($this->downCloseColor);
        unset($this->candleWidth);
        unset($this->style);
        unset($this->showOpenTick);
        unset($this->showCloseTick);
        unset($this->oldP);     
    }      

    /**
    * Determines how the Candle points will be drawn.
    * When it is CandleStick, a vertical rectangle represents each candle
    * point.
    * When it is CandleBar, a vertical line is drawn, among Open and Close
    * horizontal tick marks.
    * You can control both the candle colors and width.
    * Default value: CandleStick
    *
    * @return CandleStyle
    */
    public function getStyle() {
        return $this->style;
    }

    /**
    * Determines how the Candle points will be drawn.
    * Default value: CandleStick
    *
    * Example:
    * $candleSeries = new Candle($myChart->getChart());
    * $candleSeries->fillSampleValues(30);
    *
    * $candleSeries->setStyle(CandleStyles::$OpenClose);
    *
    * @param CandleStyles $value
    */
    public function setStyle($value) {
        if ($this->style != $value) {
            $this->style = $value;
            $this->invalidate();
        }
    }

    public function createSubGallery($addSubChart) {
        parent::createSubGallery($addSubChart);
        $addSubChart->createSubChart(Language::getString("CandleBar"));
        $addSubChart->createSubChart(Language::getString("CandleNoOpen"));
        $addSubChart->createSubChart(Language::getString("CandleNoClose"));
        $addSubChart->createSubChart(Language::getString("NoBorder"));
        $addSubChart->createSubChart(Language::getString("Line"));
    }

    public function setSubGallery($index) {
        switch ($index) {
        case 1:
            $this->setStyle(CandleStyle::$CANDLEBAR);
            break;
        case 2: {
            $this->getPen()->setVisible(true);
            $this->setStyle(CandleStyle::$CANDLEBAR);
            $this->showOpenTick = false;
        }
        break;
        case 3: {
            $this->getPen()->setVisible(true);
            $this->setStyle(CandleStyle::$CANDLEBAR);
            $this->showCloseTick = false;
        }
        break;
        case 4: {
            $this->setStyle(CandleStyle::$CANDLESTICK);
            $this->getPen()->setVisible(false);
        }
        break;
        case 5: {
            $this->setStyle(CandleStyle::$LINE);
        }
        break;
        default:
            parent::setSubGallery($index);
        }
    }

    /**
    * The horizontal Candle Size in pixels.
    * It is based on pixels for Screen charts. When printing, this number is
    * multiplied by the ratio between the Printer width and the Screen width.
    *
    * Default value: 6
    *
    * @return int
    */
    public function getCandleWidth() {
        return $this->candleWidth;
    }

    /**
    * Sets the horizontal Candle Size in pixels.<br>
    * Default value: 6
    *
    * @param int $value
    */
    public function setCandleWidth($value) {
        $this->candleWidth = $this->setIntegerProperty($this->candleWidth, $value);
    }

    /**
    * Candle color fill when Open value is greater than Close value.<br>
    * By default, UpCloseColor is WHITE and DownCloseColor is RED. <br>
    * Each Candle will be filled with a different color depending on its Open
    * and Close values.<br>
    * If Open value is greater than Close value, then the selected color will
    * be the UpCloseColor color.<br>
    * If Close value is greater or equal than Open value, then the selected
    * color will be the DownCloseColor color. <br>
    * Default value: white
    *
    * @return Color
    */
    public function getUpCloseColor() {
        return $this->upCloseColor;
    }

        /**
          * Candle color fill when Open value is greater than Close value.<br>
          * Default value: white
          *
          * @param value Color
          */
    public function setUpCloseColor($value) {
        $this->upCloseColor = $this->setColorProperty($this->upCloseColor, $value);
    }

        /**
          * Candle color fill when Close value is greater than Open value.<br>
          * By default, UpCloseColor is WHITE and DownCloseColor is RED. <br>
          * Each Candle will be filled with a different color depending on its Open
          * and Close values.<br>
          * If Open value is greater than Close value, then the selected color will
          * be the UpCloseColor color.<br>
          * If Close value is greater or equal than Open value, then the selected
          * color will be the DownCloseColor color. <br>
          * Default value: red
          *
          *
          *
          * @return Color
          */
    public function getDownCloseColor() {
        return $this->downCloseColor;
    }

        /**
          * Candle color fill when Close value is greater than Open value.<br>
          * Default value: red
          *
          * @param value Color
          */
    public function setDownCloseColor($value) {
        $this->downCloseColor = $this->setColorProperty($this->downCloseColor, $value);
    }

        /**
          * Determines whether Open prices will be displayed.<br>
          * It only has effect when Candle series.CandleStyle is set to csCandleBar.
          * CandleWidth determines the length in pixels of Open and Close ticks. <br>
          * Default value: true
          *
          * @return boolean
          */
    public function getShowOpen() {
        return $this->showOpenTick;
    }

        /**
          * Determines whether Open prices will be displayed.<br>
          * Default value: true
          *
          * @param value boolean
          */
    public function setShowOpen($value) {
        $this->showOpenTick = $this->setBooleanProperty($this->showOpenTick, $value);
    }

        /**
          * Determines whether Close prices will be displayed.<br>
          * It only has effect when Candle series.CandleStyle is set to csCandleBar.
          * CandleWidth determines the length in pixels of Open and Close ticks. <br>
          * Default value: true
          *
          * @return boolean
          */
    public function getShowClose() {
        return $this->showCloseTick;
    }

        /**
          * Determines whether Close prices will be displayed.<br>
          * Default value: true
          *
          * @param value boolean
          */
    public function setShowClose($value) {
        $this->showCloseTick = $this->setBooleanProperty($this->showCloseTick, $value);
    }

    private function calculateColor($valueIndex) {
        $result = $this->getValueColor($valueIndex);

        if ($result == $this->getColor()) {
            if ($this->vOpenValues->value[$valueIndex] > $this->getCloseValues()->value[$valueIndex])
            /* 5.01 */
            {
                $result = $this->downCloseColor;
            } else
            if ($this->vOpenValues->value[$valueIndex] < $this->getCloseValues()->value[$valueIndex]) {
                $result = $this->upCloseColor;
            } else {
                // color algorithm when open is equal to close
                if ($valueIndex == 0) {
                    $result = $this->upCloseColor; // <-- first point
                } else
                if ($this->getCloseValues()->value[$valueIndex - 1] >
                    $this->getCloseValues()->value[$valueIndex]) {
                    $result = $this->downCloseColor;
                } else
                if ($this->getCloseValues()->value[$valueIndex - 1] <
                    $this->getCloseValues()->value[$valueIndex]) {
                    $result = $this->upCloseColor;
                } else {
                    $result = $this->getValueColor($valueIndex - 1);
                }
            }
        }

        return $result;
    }

        /**
          * Called internally. Draws the "ValueIndex" point of the Series.
          *
          * @param valueIndex int
          */
    public function drawValue($valueIndex) {

        $tmpStyle = PointerStyle::$RECTANGLE;

        // TODO $this->onGetPointerStyle($valueIndex, $tmpStyle);

        $g = $this->chart->getGraphics3D();

        /* Pointer Pen && Brush styles */
        $this->point->prepareCanvas($g, new Color(0,0,0));

        /* The horizontal position */
        $x = $this->calcXPosValue($this->getDateValues()->value[$valueIndex]);

        // Vertical positions of Open, High, Low & Close values for this point
        $yOpen = $this->calcYPosValue($this->vOpenValues->value[$valueIndex]);
        $yHigh = $this->calcYPosValue($this->vHighValues->value[$valueIndex]);
        $yLow = $this->calcYPosValue($this->vLowValues->value[$valueIndex]);
        $yClose = $this->calcYPosValue($this->getCloseValues()->value[$valueIndex]);

        $tmpLeftWidth = $this->candleWidth / 2; /* Width */
        $tmpRightWidth = $this->candleWidth - $tmpLeftWidth;

        if (($this->style == CandleStyle::$CANDLESTICK) ||
            ($this->style == CandleStyle::$OPENCLOSE)) {

            // draw Candle Stick
            if ($this->chart->getAspect()->getView3D() && $this->point->getDraw3D()) {
                (int)$this->tmpTop=0;
                (int)$this->tmpBottom=0;

                if ($yClose > $yOpen) {
                    $this->tmpTop = $yOpen;
                    $this->tmpBottom = $yClose;
                } else {
                    $this->tmpTop = $yClose;
                    $this->tmpBottom = $yOpen;
                }

                // Draw Candle Vertical Line from bottom to Low
                if ($this->style == CandleStyle::$CANDLESTICK) {
                    $g->verticalLine($x, $this->tmpBottom, $yLow, $this->getMiddleZ());
                }

                // Draw 3D Candle
                $g->getBrush()->setColor( $this->calculateColor($valueIndex));
                if ($yOpen == $yClose) {
                    $g->getPen()->setColor( $this->calculateColor($valueIndex));
                }

                if ($this->getTransparency() > 0) {
                    $g->getBrush()->setTransparency( $this->getTransparency());
                }

                $g->cube($x - $tmpLeftWidth, $this->tmpTop, $x + $tmpRightWidth,
                       $this->tmpBottom, $this->getStartZ(), $this->getEndZ(), $this->point->getDark3D());

                // Draw Candle Vertical Line from Top to High
                if ($this->style == CandleStyle::$CANDLESTICK) {
                    $g->verticalLine($x, $this->tmpTop, $yHigh, $this->getMiddleZ());
                }
            } else {
                // Draw Candle Vertical Line from High to Low
                if ($this->style == CandleStyle::$CANDLESTICK) {
                    if ($this->chart->getAspect()->getView3D()) {
                        $g->verticalLine($x, $yLow, $yHigh, $this->getMiddleZ());
                    } else {
                        $g->verticalLine($x, $yLow, $yHigh);
                    }
                }

                // remember that Y coordinates are inverted

                // prevent zero height rectangles 5.02
                // in previous releases, an horizontal line was displayed instead
                // of the small candle rectangle
                if ($yOpen == $yClose) {
                    $yClose--;
                }

                // draw the candle
                $g->getBrush()->setColor( $this->calculateColor($valueIndex));
                if ($this->getTransparency() > 0) {
                    $g->getBrush()->setTransparency($this->getTransparency());
                }

                if ($this->chart->getAspect()->getView3D()) {
                    $g->rectangleWithZ(new Rectangle($x - $tmpLeftWidth,
                                              $yOpen,
                                              $tmpLeftWidth + $tmpRightWidth,
                                              $yClose - $yOpen),
                                              $this->getMiddleZ());
                } else {
                    if (!$this->point->getPen()->getVisible()) {
                        if ($yOpen < $yClose) {
                            $yOpen--;
                        } else {
                            $yClose--;
                        }
                    }
                    $g->rectangle(new Rectangle($x - $tmpLeftWidth, $yOpen,
                                $tmpLeftWidth + $tmpRightWidth + 1, $yClose - $yOpen));
                }
            }
        } else
        if ($this->style == CandleStyle::$CANDLEBAR) {
            // draw Candle bar
            $g->setPen($this->point->getPen());
            $g->getPen()->setColor($this->calculateColor($valueIndex));

            // Draw Candle Vertical Line from High to Low
            if ($this->chart->getAspect()->getView3D()) {
                $g->verticalLine($x, $yLow, $yHigh, $this->getMiddleZ());
                if ($this->showOpenTick) {
                    $g->horizontalLine($x, $x - $tmpLeftWidth - 1, $yOpen,
                                     $this->getMiddleZ());
                }
                if ($this->showCloseTick) {
                    $g->horizontalLine($x, $x + $tmpRightWidth + 1,
                                     $yClose, $this->getMiddleZ());
                }
            } else {
                // 5.02
                $g->verticalLine($x, $yLow, $yHigh);
                if ($this->showOpenTick) {
                    $g->horizontalLine($x, $x - $tmpLeftWidth - 1, $yOpen);
                }
                if ($this->showCloseTick) {
                    $g->horizontalLine($x, $x + $tmpRightWidth + 1,
                                     $yClose);
                }
            }
        } else {
            // Line
            $p = new Point($x, $yClose);

            $tmpFirst = $this->drawValuesForward() ? $this->firstVisible :
                           $this->lastVisible;

            if (($valueIndex != $tmpFirst) && (!$this->isNull($valueIndex))) {
                $g->setPen($this->getPen());
                $g->getPen()->setColor( $this->calculateColor($valueIndex));
                if ($this->chart->getAspect()->getView3D()) {
                    $g->line($this->oldP, $p, $this->getMiddleZ());
                } else {
                    $g->line($this->oldP, $p);
                }
            }

            $this->oldP = $p;
        }
    }

    public function getPen() {
        return $this->getPointer()->getPen();
    }

    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);
        $this->fillSampleValues(4);
        $this->setColorEach(true);

        if ($isEnabled) {
            $this->upCloseColor = Color::getBlue();
        } else {
            $this->upCloseColor = Color::getSilver();
            $this->downCloseColor = Color::getSilver();
            $this->point->getPen()->setColor(Color::getGray());
        }
        $this->point->getPen()->setWidth(2);
        $this->candleWidth = 12;
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("GalleryCandle");
    }

    /* TODO
    /*
    * Returns the ValueIndex of the x,y located point in the Series.
    *
    public function clicked($xint)
    {
        return clicked(new TeePoint(x,y));
    }

    /*
    * Returns the ValueIndex of the "clicked" point in the Series.
    *
    public function clicked($p)
    {
        int result=-1;
        if (firstVisible>-1 && lastVisible>-1)
        {

            if (chart!=null) chart.getGraphics3D().calculate2DPosition(p.x, p.y, startZ);
            //Point p = new Point(x,y);
            for (int t=firstVisible; t<=lastVisible; t++)
                if (clickedCandle(t,p))
                {
                    result=t;
                    break;
                }
        }
        return result;
    }

    /*
    * Returns true if point p is inside the bounds of the ValueIndex candle
    *
    public function clickedCandle($valueIndex, $p)
    {
        boolean result = false;

        int tmpX =calcXPosValue(getDateValues().value[valueIndex]); /* The horizontal position
        int yOpen =calcYPosValue(vOpenValues.value[valueIndex]);
        int yHigh =calcYPosValue(vHighValues.value[valueIndex]);
        int yLow  =calcYPosValue(vLowValues.value[valueIndex]);
        int yClose=calcYPosValue(getCloseValues().value[valueIndex]);

        int tmpLeftWidth=candleWidth / 2; /* calc half Candle Width
        int tmpRightWidth=candleWidth-tmpLeftWidth;

        int tmpTop;
        int tmpBottom;
        int tmpFirst;
        Point tmpTo=new Point();

        if (style==CandleStyle::$CANDLESTICK || style==CandleStyle::$OPENCLOSE)
        {
            if (chart.getAspect().getView3D() && getPointer().getDraw3D())
            {
                tmpTop = yClose;
                tmpBottom = yOpen;

                if (tmpTop>tmpBottom) Utils.swapInteger(tmpTop,tmpBottom);

                if (style==CandleStyle::$CANDLESTICK &&
                        (Graphics3D.pointInLineTolerance(p,tmpX,tmpBottom,tmpX,yLow,3) ||
                          Graphics3D.pointInLineTolerance(p,tmpX,tmpTop,tmpX,yHigh,3)))
                        return true;

                Rectangle tmpR=Rectangle::fromLTRB(tmpX-tmpLeftWidth,tmpTop,tmpX+tmpRightWidth,tmpBottom);
                if (tmpR.contains(p.getX(), p.getY()))
                                return true;
            }
            else
            {
                if (style==CandleStyle::$CANDLESTICK &&
                        Graphics3D.pointInLineTolerance(p,tmpX,yLow,tmpX,yHigh,3))
                        return true;

                if (yOpen==yClose) yClose--;

                if (chart.getAspect().getView3D())
                {
                    Rectangle tmpR=Rectangle::fromLTRB(tmpX-tmpLeftWidth,yOpen,tmpX+tmpRightWidth,yClose);
                    if (tmpR.contains(p.getX(), p.getY()))
                            return true;
                }
                else
                {
                    if (!getPen().getVisible())
                                    if (yOpen<yClose)
                                                    yOpen--;
                                    else
                                                    yClose--;

                    Rectangle tmpR=Rectangle::fromLTRB(tmpX-tmpLeftWidth,yOpen,tmpX+tmpRightWidth+1,yClose);
                    if (tmpR.contains(p.getX(), p.getY()))
                                    return true;
                }
            }
        }
        else if (style==CandleStyle::$LINE)
        {
            tmpFirst = firstVisible;
            tmpTo.x=tmpX;
            tmpTo.y=yClose;
            if (valueIndex!=tmpFirst)
                result = Graphics3D.pointInLineTolerance(p,oldP.x,oldP.y,tmpTo.x,tmpTo.y,3);
            oldP = tmpTo;
        }
        else
        {
            if (Graphics3D.pointInLineTolerance(p,tmpX,yLow,tmpX,yHigh,3) ||
                            (showOpenTick && Graphics3D.pointInLineTolerance(p,tmpX,yOpen,tmpX-tmpLeftWidth-1,yOpen,3)) ||
                            (showCloseTick && Graphics3D.pointInLineTolerance(p,tmpX,yClose,tmpX+tmpRightWidth+1,yClose,3)))
                            result=true;
        }
        return result;
    }
    */
}
?>