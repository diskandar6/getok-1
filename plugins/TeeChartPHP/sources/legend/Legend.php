<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: Legend class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */
/**
 * Legend class
 *
 * Description: Accesses all Chart Legend characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */

  class Legend extends TextShapePosition {

    static $CHECKBOXSIZE = 11;
    static $LEGENDOFF2 = 2;
    static $LEGENDOFF4 = 4;
    static $MAXLEGENDCOLUMNS = 2;
    static $ALLVALUES = -1;

    private $animations = Array();
    private $resizeChart = true;
    private $checkBoxes = false;
    private $textStyle;
    private $series;
    private $legendStyle;
    private $textAlign=-1;
    private $currentPage = true;
    private $vertSpacing=0;
    private $horizMargin=0;
    private $vertMargin=0;
    private $topLeftPos = 10;
    private $alignment;
    private $numCols;
    private $numRows;
    private $maxNumRows = 10;
    private $fontSeriesColor=null;
    private $inverted=false;
    private $dividingLines=null;
    private $title=null;
    private $frameWidth;
    private $iColorWidth;
    private $incPos;
    private $iTotalItems;
    private $posXLegend;
    private $posYLegend;
    private $iSpaceWidth;
    private $items;
    private $tmpSeries;
    private $itemHeight;
    private $symbol;
    private $xLegendColor;
    private $xLegendText;
    private $xLegendBox;
    private $tmpMaxWidth;
    private $tmpTotalWidth;

    protected $columnWidthAuto=true;
    protected $columnWidths; 
    protected $firstValue=0;
    protected $iLastValue=0;

    public $iLegendStyle;


    // Class Definition

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
    public function __construct($c) {

        $this->columnWidths= Array();
        $this->textStyle = LegendTextStyle::$LEFTVALUE;
        $this->legendStyle = LegendStyle::$AUTO;
        $this->alignment = LegendAlignment::$RIGHT;
        $this->textAlign = Array(StringAlignment::$HORIZONTAL_LEFT_ALIGN,
                                 StringAlignment::$VERTICAL_CENTER_ALIGN);

        parent::__construct($c);

        $this->readResolve();

        $tmpColor = new Color(0,0,0);
        $this->getShadow()->getBrush()->setDefaultColor($tmpColor);
        $this->getShadow()->setDefaultSize(3);
        $this->getShadow()->setDefaultVisible(true);
        
        unset($tmpColor);
    }
    
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->animations);
        unset($this->resizeChart);
        unset($this->checkBoxes);
        unset($this->textStyle);
        unset($this->series);
        unset($this->legendStyle);
        unset($this->textAlign);
        unset($this->currentPage);
        unset($this->vertSpacing);
        unset($this->horizMargin);
        unset($this->vertMargin);
        unset($this->topLeftPos);
        unset($this->alignment);
        unset($this->numCols);
        unset($this->numRows);
        unset($this->maxNumRows);
        unset($this->fontSeriesColor);
        unset($this->inverted);
        unset($this->dividingLines);
        unset($this->title);
        unset($this->frameWidth);
        unset($this->iColorWidth);
        unset($this->incPos);
        unset($this->iTotalItems);
        unset($this->posXLegend);
        unset($this->posYLegend);
        unset($this->iSpaceWidth);
        unset($this->items);
        unset($this->tmpSeries);
        unset($this->itemHeight);
        unset($this->symbol);
        unset($this->xLegendColor);
        unset($this->xLegendText);
        unset($this->xLegendBox);
        unset($this->tmpMaxWidth);
        unset($this->tmpTotalWidth);
        unset($this->columnWidthAuto);
        unset($this->columnWidths);
        unset($this->firstValue);
        unset($this->iLastValue);
        unset($this->iLegendStyle);
   }     

    protected function readResolve() {
        $this->iLegendStyle=LegendStyle::$AUTO;
        $this->items = Array(); 
        return $this;
    }

    private function getFrame() {
        return $this->getPen();
    }

    /**
      * Determines how Legend text items will be formatted.<br>
      * Plain shows the point Label only.<br>
      * LeftValue shows the point Value and the point Label. <br>
      * RightValue shows the point Label and the point Value. <br>
      * LeftPercent shows the percent the point represents and the point Label. <br>
      * RightPercent shows the point Label and the percent the points represent. <br>
      * XValue shows the point's X value. It applies only to Series with X
      * (horizontal) values. <br><br>
      * Values are pre-formatted using the Series ValueFormat property. <br>
      * Percents are pre-formatted using the Series PercentFormat property. <br><br>
      * Default value: LeftValue
      *
      *
      * @return LegendTextStyle
      */
    public function getTextStyle() {
        return $this->textStyle;
    }

    /**
      * Returns the index of the first displayed value at legend.
      * The index can be a series value index or a series index depending
      * on legend style.
      *
      * @return int
      */
    public function getLastValue() {
        return $this->iLastValue;
    }

    public function getTextAlign() {
        return $this->textAlign;
    }

    /**
      * Specifies how Legend text items will be formatted.<br>
      * Default value: LeftValue
      *
      *
      * @param value LegendTextStyle
      */
    public function setTextStyle($value) {
        if ($this->textStyle != $value) {
            $this->textStyle = $value;
            $this->invalidate();
        }
    }

    public function setTextAlign($value) {
//        if ($this->textAlign != $value) {
//            $this->textAlign = array($value);
//            $this->invalidate();
//        }
          if (is_array($value)){
            $this->textAlign=$value;
          }
          else
          {
            $this->textAlign=Array($value);
          }
          $this->invalidate();
    }

    /**
      * Determines which series is used as data for the Legend entries.<br>
      * By default, the Legend chooses the first Active Series with
      * ShowInLegend:=true. It only applies to Legend style "Values".
      *
      * @return Series
      */
    public function getSeries() {
        return $this->series;
    }

    /**
      * Determines which series is used as data for the Legend entries.<br>
      *
      * @param value Series
      */
    public function setSeries($value) {
        $this->series = $value;
        $this->invalidate();
    }

    /**
      * Enables/Disables the display of Legend check boxes.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getCheckBoxes() {
        return $this->checkBoxes;
    }

    public function setChart($c) {
        parent::setChart($c);

        if ($this->symbol != null) {
           $this->getSymbol()->legend=$this;
        }
    }

    /**
      * Displays the Legend check boxes when true.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setCheckBoxes($value) {
        $this->checkBoxes = $this->setBooleanProperty($this->checkBoxes, $value);
        $this->invalidate();
    }

    /**
      * Determines whether or not the Legend shows only the current page items
      * when the Chart is divided into pages.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getCurrentPage() {
        return $this->currentPage;
    }

    /**
      * When true, the Legend shows only the current page items when the Chart
      * is divided into pages.<br>
      *
      * Default value: true
      *

      * @param value boolean
      */
    public function setCurrentPage($value) {
        $this->currentPage = $this->setBooleanProperty($this->currentPage, $value);
    }

    /**
      * The legend text font color to that of the Series color.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getFontSeriesColor() {
        return $this->fontSeriesColor;
    }

    /**
      * Sets the legend text font color to that of the Series color.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setFontSeriesColor($value) {
        $this->fontSeriesColor = $this->setBooleanProperty($this->fontSeriesColor, $value);
    }

    /**
      * Specifies the Pen attributes used to draw lines separating Legend items.
      * <br>
      * Lines are drawn horizontally for Left or Right aligned Legend
      * and vertically for Top or Bottom Legend alignments.
      *
      * @return ChartPen
      */
    public function getDividingLines() {
        if ($this->dividingLines == null) {
            $tmpColor = new Color(0,0,0); 
            $this->dividingLines = new ChartPen($this->chart, $tmpColor, false);
            
            unset($tmpColor);
        }
        return $this->dividingLines;
    }

    /**
      * Internal use - serialization
      */
    public function setDividingLines($value) {
      $this->dividingLines =$value;
    }


    /**
      * Controls the width and position of the color rectangle associated with
      * each Legend's item.
      *
      * @return LegendSymbol
      */
    public function getSymbol() {
        if ($this->symbol == null) {
            $this->symbol = new LegendSymbol($this);
        }
        return $this->symbol;
    }

    /*
    * Internal use - serialization
    */
    public function setSymbol($value) {
      $this->symbol=$value;
    }

    /**
      * Draws the Legend items in opposite direction when true.<br>
      * Legend strings are displayed starting at top for Left and Right Aligment
      * and starting at left for Top and Bottom Legend orientations. You can use
      * Legend.FirstValue to determine the ValueIndex for the first Legend
      * text item. <br>
      * Default value: false
      *
      * @return boolean
      */
    public function getInverted() {
        return $this->inverted;
    }

    /**
      * Draws the Legend items in opposite direction when true.<br>
      * Default value: false
      *

      * @param value boolean
      */
    public function setInverted($value) {
        $this->inverted = $this->setBooleanProperty($this->inverted, $value);
    }

    /**
      * Defines the Legend position.<br>
      * Legend can be currently placed at Top, Left, Right and Bottom side of
      * Chart. <br>
      * Left and Right Legend alignments define a vertical Legend with
      * currently one single column of items. <br>
      * Top and Bottom Legend alignments define an horizontal Legend with
      * currently one single row of items. <br>
      * The Legend itself automatically reduces the number of displayed
      * legend items based on the available charting space. <br>
      * The Legend.ResizeChart property controls if Legend dimensions should be
      * used to reduce Chart points space. <br>
      * The Legend.GetLegendRect event provides a mechanism to supply the
      * desired Rectangle Legend dimensions and placement. <br>
      * The Legend.GetLegendPos event can be used to specify fixed Legend items
      * X Y coordinates. <br>
      * The Legend.HorizMargin and VertMargin properties control distance
      * between Legend and Left and Right margins. <br>
      * The Legend.TopLeftPos property can be used in Left Legend alignments
      * to control vertical distance between Legend and Top Chart Margin.  <br><br>
      * These techniques allow almost complete Legend control. <br>
      * Default value: Right
      *
      *
      * @return LegendAlignment
      */
    public function getAlignment() {
        return $this->alignment;
    }

    /**
      * Defines the Legend position.<br>
      * Default value: Right
      *
      *
      * @param value LegendAlignments
      * @see LegLegendAlignment
      */
    public function setAlignment($value) {
        if ($this->alignment != $value) {
            $this->alignment = $value;
            $this->invalidate();
        }
    }

    public function getColumnWidth($column) {
        if ($column < self::$MAXLEGENDCOLUMNS) {
            return $this->columnWidths[$column];
        } else {
            return -1;
        }
    }

    public function setColumnWidth($column, $value) {
        if ($column < self::$MAXLEGENDCOLUMNS) {
            $this->columnWidths[$column] = $value;
        };
        $this->invalidate();
    }

    /**
      * Automatically calculates best fit of legend columns.<br>
      * When set to true, columnWidths control the legend width<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getColumnWidthAuto() {
        return $this->columnWidthAuto;
    }

    /**
      * Automatically calculates best fit of legend columns.<br>
      * When set to true, columnWidths control the legend width<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setColumnWidthAuto($value) {
        $this->columnWidthAuto = $this->setBooleanProperty($this->columnWidthAuto, $value);
    }

    /**
      * Defines which is the first Legend item displayed.<br>
      * Legend can display all active Series names or all points of a single
      * Series. FirstValue should be set accordingly, taking care not to
      * overflow the number of active Series or the number of Series points. You
      * can use FirstValue to show a specific subset of Series or points in
      * Legend. It should be greater or equal to zero, and lower than the number
      * of active Series or Series points. See Legend.LegendStyle for a
      * description of the different Legend styles. <br>
      * Default value: 0
      *
      * @return int
      */
    public function getFirstValue() {
        return $this->firstValue;
    }

    /**
      * Determines which is the first Legend item displayed.<br>
      * Default value: 0
      *
      * @see Legend#getFirstValue
      * @param value int
      */
    public function setFirstValue($value) {
        $this->firstValue = $this->setIntegerProperty($this->firstValue, $value);
    }

    /**
      * Specifies the Legend's top position in percent of total chart height.<br>
      * It's used when Legend.Alignment is Left or Right only. For Top or
      * Bottom Legend alignments, you can use the Chart's MarginTop and
      * MarginBottom. <br>
      * Default value: 10
      *
      * @return int
      */
    public function getTopLeftPos() {
        return $this->topLeftPos;
    }

    /**
      * Specifies the Legend's top position in percent of total chart height.<br>
      * Default value: 10
      *
      * @param value int
      */
    public function setTopLeftPos($value) {
        $this->topLeftPos = $this->setIntegerProperty($this->topLeftPos, $value);
    }

    /**
      * The Maximum number of Legend Rows displayed for a horizontal Legend
      * (Chart Top or Bottom).<br>
      * Default value: 10
      *
      * @return int
      */
    public function getMaxNumRows() {
        return $this->maxNumRows;
    }

    /**
      * Sets the Maximum number of Legend Rows displayed for a horizontal Legend
      * (Chart Top or Bottom).<br>
      * Default value: 10
      *
      * @param value int
      */
    public function setMaxNumRows($value) {
        $this->maxNumRows = $this->setIntegerProperty($this->maxNumRows, $value);
    }

    public function getLines() {
        return parent::getLines();
    }

    public function setLines($value) {
        parent::setLines($value);
    }

    /**
      * Adds text to the Legend.
      *
      * @return String
      */
    public function getText() {
        return parent::getText();
    }

    /**
      * Adds text to the Legend.
      *
      * @param value String
      */
    public function setText($value) {
        parent::setText($value);
    }

    /**
      * The vertical spacing between Legend items (pixels).<br>
      * Default value: 0
      *
      * @return int
      */
    public function getVertSpacing() {
        return $this->vertSpacing;
    }

    /**
      * Determines the vertical spacing between Legend items (pixels).<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setVertSpacing($value) {
        $this->vertSpacing = $this->setIntegerProperty($this->vertSpacing, $value);
    }

    /**
      * Speficies the number of screen pixels between Legend and Chart
      * rectangles.<br>
      * By default it is 0, meaning Legend will calculate a predefined margin
      * based on total Legend width. It is only used when Legend position is
      * Left or Right aligned otherwise use VertMargin. <br>
      * Default value: 0
      *
      * @return int
      */
    public function getHorizMargin() {
        return $this->horizMargin;
    }

    /**
      * Speficies the number of screen pixels between Legend and Chart
      * rectangles.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setHorizMargin($value) {
        $this->horizMargin = $this->setIntegerProperty($this->horizMargin, $value);
    }

    /**
      * The vertical margin in pixels between Legend and Chart
      * rectangle.<br>
      * Legend.ResizeChart must be true and Legend.Alignment must be
      * Top or Bottom. When 0, the corresponding Chart margin method is used to
      * determine the amount of pixels for margins (Chart.MarginTop for Top
      * Legend.alignment and Chart.MarginBottom for Bottom Legend.Alignment).<br>
      * Default value: 0
      *
      * @return int
      */
    public function getVertMargin() {
        return $this->vertMargin;
    }

    /**
      * Determines the vertical margin in pixels between Legend and Chart
      * rectangle.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setVertMargin($value) {
        $this->vertMargin = $this->setIntegerProperty($this->vertMargin, $value);
    }

    /**
      * Automatically resizes Chart rectangle to prevent overlap with Legend.<br>
      * When set to true, Legend.HorizMargin and Legend.VertMargin control the
      * amount of pixels by which the Chart rectangle will be reduced. <br>
      * Default value: true
      *
      * @return boolean
      */
    public function getResizeChart() {
        return $this->resizeChart;
    }

    /**
      * Automatically resizes Chart rectangle to prevent overlap with Legend.<br>
      * When set to true, Legend.HorizMargin and Legend.VertMargin control the
      * amount of pixels by which the Chart rectangle will be reduced. <br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setResizeChart($value) {
        $this->resizeChart = $this->setBooleanProperty($this->resizeChart, $value);
    }

    private function getLegendSeries() {
        $tmpResult = $this->series;
        if ($tmpResult == null) {
            return $this->chart->getFirstActiveSeries();
        } else {
            return $tmpResult;
        }
    }

    /**
      * Defines which items will be displayed in the Chart Legend. <br>
      * Series style shows the Series.Title of all active Series in a Chart.
      * Whenever a Series Title is empty, Series Name is used. <br>
      * Values style shows a text representation of all points of the first
      * active Series in a Chart. <br>
      * LastValues style shows the last point value and the Series.Title of all
      * active Series in a Chart.  It is useful for real-time charting, where
      * new points are being added at the end of each Series. <br>
      * Auto style (the default) means LegendStyle will be Series when there's
      * more than one Active Series, and Values when there's only one Series
      * in a Chart. <br>
      * Legend.TextStyle determines how the Series point values are formatted.<br>
      * Default value: auto
      *
      *
      * @return LegendStyle
      */
    public function getLegendStyle() {
        return $this->legendStyle;
    }

    /**
    * Defines which items will be displayed in the Chart Legend. <br>
    * Default value: Auto
    *
    *
    * @param value LegendStyles
    * @see Legend#getLegendStyle
    */
    public function setLegendStyle($value) {
        if ($this->legendStyle != $value) {
            $this->legendStyle = $value;
            $this->calcLegendStyle();
            $this->invalidate();
        }
    }

    /**
    * Sets the Title text and its characteristics at the top of the legend
    */
    public function getTitle() {
        if($this->title == null) {
            $this->title = new LegendTitle($this->chart);
        }
        return $this->title;
    }

    public function doMouseDown($p) {
        $result = false;

        if ($this->hasCheckBoxes()) {
            $tmp = $this->clicked($p);
            if ($tmp != -1) {
                 $s = $this->chart->seriesLegend($tmp, false);
                $s->setActive(!$s->getActive());
                $result = true;
            }
        }
        return $result;
    }

    private function clickedRow($tmpH, $y) {
        $result = -1;
        for ( $t = 0; $t < $this->numRows; $t++) {
            $tmp=round($this->getFirstItemTop()+1+$t * $tmpH);

            if (($y >= $tmp) && ($y <= ($tmp + $tmpH))) {
                $result = $t;
                if ($this->getInverted()) {
                    $result = $this->numRows - $t - 1;
                }
                break;
            }
        }
        return $result;
    }

    /**
    * Returns the index of the clicked Legend Point.
    *
    * @param p Point
    * @return int
    */
    public function _clicked($p) {
        return $this->clicked($p->x, $p->y);
    }

    /**
    * Returns the index of the clicked Legend Point.
    *
    * @param x int
    * @param y int
    * @return int
    */
    public function clicked($x, $y) {
        $result = -1;

        if ($this->getShapeBounds()->contains($x, $y)) {

            $this->chart->getGraphics3D()->setFont($this->getFont());
            $tmpH = $this->calcItemHeight();

            if ($this->getVertical()) {
                if ($this->numRows > 0) {
                    $result = $this->clickedRow($tmpH, $y);
                }
            } else {
                if ($this->numCols > 0) {
                     $tmpW = ($this->getShapeBounds()->getRight() -
                               $this->getShapeBounds()->getLeft()) /
                               $this->numCols;

                    for ( $t = 0; $t < $this->numCols; $t++) {
                        $tmp2 = $this->getShapeBounds()->getLeft() + 1 + $t * $tmpW;
                        if (($x >= $tmp2) && ($x <= ($tmp2 + $tmpW))) {
                            $result = $this->clickedRow($tmpH, $y);
                            if ($result != -1) {
                                $result *= $this->numCols;
                                if ($this->getInverted()) {
                                    $result += $this->numCols - $t - 1; // 5.02
                                } else {
                                    $result += $t;
                                }

                                if ($result > $this->iTotalItems - 1) {
                                    $result = -1;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function calcItemHeight() {
        $result = $this->chart->getGraphics3D()->getFontHeight();
        if ($this->hasCheckBoxes()) {
            $result = max(6 + self::$CHECKBOXSIZE, $result);
        }
        $result += $this->vertSpacing;

        if ($this->getVertical() && ($this->dividingLines != null) &&
            $this->dividingLines->getVisible())
        /* 5.02 */
        {
            $result += MathUtils::round($this->dividingLines->getWidth());
        }
        return $result;
    }

    protected function drawTitle() {
        return $this->getTitle()->getVisible() && $this->getTitle()->getText() != "";
    }

    private function calcLegendStyle() {

        if ($this->legendStyle == LegendStyle::$AUTO) {
            if (($this->checkBoxes) || ($this->chart->countActiveSeries() > 1)) {
                $this->iLegendStyle = LegendStyle::$SERIES;
            } else {
                /*  TODO
                if($this->getLegendSeries() instanceof Custom3DPalette) {
                    $this->maxNumRows = 8;
                    $this->iLegendStyle = LegendStyle::$PALETTE;
                }
                else {*/
                    $this->maxNumRows = 10;
                    $this->iLegendStyle = LegendStyle::$VALUES;
               // }
            }
        } else {
            $this->iLegendStyle = $this->legendStyle;
        }
    }

    private function calcTotalItems() {
        $result = 0;

        if (($this->iLegendStyle == LegendStyle::$SERIES) ||
            ($this->iLegendStyle == LegendStyle::$LASTVALUES)) {
            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                 $s = $this->chart->getSeries($t);
                if (($this->checkBoxes || $s->getActive()) && $s->getShowInLegend()) {
                    $result++;
                }
            }
            $result -= $this->firstValue;
        } else {
            $aSeries = $this->getLegendSeries();
            if (($aSeries != null) && $aSeries->getShowInLegend()) {
                $result = $aSeries->getCountLegendItems() - $this->firstValue;
            }
        }
        return max(0, $result);
    }

    /**
    * Returns true when the legend displays checkboxes and it is showing
    * series names.
    *
    * @return boolean
    */
    public function hasCheckBoxes() {
        return ($this->checkBoxes && ($this->iLegendStyle != LegendStyle::$VALUES));
    }

    /**
    * Is read only and returns true only if the legend is left or right
    * aligned.
    *
    * @return boolean
    */
    public function getVertical() {
        return ($this->alignment == LegendAlignment::$LEFT) ||
                ($this->alignment == LegendAlignment::$RIGHT);
    }

    private function calcSymbolTextPos($leftPos) {
        $tmp = $leftPos + self::$LEGENDOFF2 + self::$LEGENDOFF4;
        if ($this->getSymbol()->position == LegendSymbolPosition::$LEFT) {
            $this->xLegendColor = $tmp;
            $this->xLegendText = $this->xLegendColor + $this->iColorWidth + self::$LEGENDOFF4;
        } else {
            $this->xLegendText = $tmp;
            $this->xLegendColor = $this->xLegendText + $this->tmpMaxWidth;
        }
    }

    private function calcHorizontalPositions() {
        $halfMaxWidth = 2 * self::$LEGENDOFF2 + 2 * self::$LEGENDOFF4 +
                           (($this->tmpMaxWidth + $this->iColorWidth) * $this->numCols) +
                           ((self::$LEGENDOFF2 + self::$LEGENDOFF4) * ($this->numCols - 1));

        if ($this->hasCheckBoxes()) {
            $halfMaxWidth += self::$LEGENDOFF4 + (self::$CHECKBOXSIZE + self::$LEGENDOFF2) * $this->numCols;
            $halfMaxWidth += self::$LEGENDOFF4 * 2;
        }

        $halfMaxWidth = min($this->chart->getWidth(), $halfMaxWidth);
        $halfMaxWidth /= 2;

        if (!$this->getCustomPosition()) {
            $tmpW = MathUtils::round(1.0 * $this->topLeftPos *
                                        ($this->chart->getRight() - $this->chart->getLeft() -
                                         2 * $halfMaxWidth) * 0.01); // 5.02
            $this->setLeft($this->chart->getGraphics3D()->getXCenter() - $halfMaxWidth + $tmpW);
        }

        $this->setRight($this->shapeBounds->x + (2 * $halfMaxWidth));

        $tmpW = $this->shapeBounds->x;

        if ($this->hasCheckBoxes()) {
            $this->xLegendBox = $this->shapeBounds->x + self::$LEGENDOFF4;
            $tmpW += self::$CHECKBOXSIZE + self::$LEGENDOFF4;
        }
        $this->calcSymbolTextPos($tmpW);
    }

    private function calcColumnsWidth($numLegendValues) {
        if ($this->columnWidthAuto) {
            $g = $this->chart->getGraphics3D();

            for ( $t = 0; $t < self::$MAXLEGENDCOLUMNS-1; $t++) {
                $this->columnWidths[$t] = 0;
                for ( $tt = $this->firstValue; $tt <= $this->iLastValue; $tt++) {
                    $s = $this->items[$tt - $this->firstValue][$t];
                    if ($s != null) {
                        $this->columnWidths[$t] = max($this->columnWidths[$t],
                                MathUtils::round($g->textWidth($s)));
                    }
                }
            }
        }

        $result = $this->iSpaceWidth * self::$MAXLEGENDCOLUMNS - 1;
        for ( $t = 0; $t < self::$MAXLEGENDCOLUMNS-1; $t++) {
            $result += $this->columnWidths[$t];
        }
        return $result;
    }

    public function getColorWidth() {
        return $this->getSymbol()->getWidth();
    }

    public function setColorWidth($value) {
        $this->getSymbol()->setWidth($value);
    }

    private function calcWidths() {
        $this->tmpMaxWidth = $this->calcColumnsWidth($this->numRows);
        $this->tmpTotalWidth = 2 * self::$LEGENDOFF4 + $this->tmpMaxWidth + self::$LEGENDOFF2;
        $this->iColorWidth = $this->getSymbol()->calcWidth($this->tmpTotalWidth);
        $this->tmpTotalWidth += $this->iColorWidth + 2; //  03 //#  2 pixels

        if ($this->drawTitle()) {
            $this->tmpTotalWidth=max($this->tmpTotalWidth,$this->getTitle()->getTotalWidth());
        }
    }

    private function calcVerticalPositions() {

        if ($this->getCustomPosition() || ($this->getAlignment() == LegendAlignment::$LEFT)) {
            if (!$this->getCustomPosition()) {
                if ($this->getFrame()->getVisible()) {
                    $this->shapeBounds->x += $this->frameWidth + 1;
                }
            }
            $this->calcWidths();
        } else {
            if ($this->getShadow()->getVisible()) {
                $this->shapeBounds->width -= max(0, $this->getShadow()->getWidth());
            }
            if ($this->getFrame()->getVisible()) {
                $this->shapeBounds->width -= $this->frameWidth + 1;
            }
            $this->calcWidths();

            $this->shapeBounds->x = $this->getRight() - $this->tmpTotalWidth;
            $this->shapeBounds->width = $this->tmpTotalWidth;


            if ($this->hasCheckBoxes()) {
                $this->shapeBounds->x -= self::$CHECKBOXSIZE + self::$LEGENDOFF4;
            }
        }

        $tmpW = $this->shapeBounds->x;

        if ($this->hasCheckBoxes()) {
            $this->xLegendBox = $tmpW + self::$LEGENDOFF4;
            $tmpW = $this->xLegendBox + self::$CHECKBOXSIZE;
        }

        $this->shapeBounds->width = $tmpW + $this->tmpTotalWidth - $this->shapeBounds->x;
        $this->calcSymbolTextPos($tmpW);
    }

    private function setRightAlign($column, $isRight) {
        if ($isRight) {
          if ($this->textAlign==-1)
          {
            $tmpAlign = Array(/*StringAlignment::$HORIZONTAL_LEFT_ALIGN,   // RIGHT*/
                              StringAlignment::$VERTICAL_CENTER_ALIGN);
            $this->chart->getGraphics3D()->setTextAlign($tmpAlign);
          }
          else
          {
            $this->chart->getGraphics3D()->setTextAlign($this->textAlign);
          }
            $this->incPos = false;
        } else {
            $this->chart->getGraphics3D()->setTextAlign(StringAlignment::$HORIZONTAL_LEFT_ALIGN);  //LEFT
        }
    }

    private function drawSymbol(Series $series, $index, $r) {
        if ($this->iColorWidth > 0) {
            if ($series != null) {
                $series->drawLegend(null, $index, $r);
            } else {
                $tmpColor = new Color(255,255,255);  //white
                $g=$this->chart->getGraphics3D();
                $g->getBrush()->setForegroundColor($tmpColor);
                $g->getBrush()->setSolid(true);
                $g->rectangle($r);
                
                unset($tmpColor);
            }
        }
    }

    private function drawLegendItem($itemIndex, $itemOrder) {
        $old_name = TChart::$controlName;
        TChart::$controlName .= 'Legend_Item_' . $itemIndex;        
        
        if ($itemOrder >= $this->iTotalItems) {
            return;
        }

        $g = $this->chart->getGraphics3D();
        $g->getBrush()->setForegroundColor($this->getColor());
        $g->getBrush()->setVisible(false);

        $this->prepareSymbolPen();

        $tmp = $this->xLegendText;
        $tmpX = 0;
        $this->posYLegend=$this->getFirstItemTop()+1;
        $posXColor = $this->xLegendColor;

        (int) $tmpOrder = $itemOrder;

        if (!$this->getVertical()) {
            (int)$tmpOrder = $itemOrder / $this->numCols;
            $tmpX = ($this->tmpMaxWidth + $this->iColorWidth + self::$LEGENDOFF4 + self::$LEGENDOFF2);

            if ($this->hasCheckBoxes()) {
                $tmpX += self::$CHECKBOXSIZE + 2 * self::$LEGENDOFF2;
            }

            $tmpX *= ($itemOrder % $this->numCols);
            $tmp += $tmpX;
            $posXColor += $tmpX;
        }

        $this->posYLegend += (int)$tmpOrder * $this->itemHeight + ($this->vertSpacing / 2);

        if ($this->chart->getParent() != null) {
             $res = new LegendItemCoordinates($itemIndex,
                   $tmp, $this->posYLegend, $posXColor);
            // TODO    $res = $this->chart->getParent()->getLegendResolver()->getItemCoordinates($this, $res);
            $tmp = $res->getX();
            $this->posYLegend = $res->getY();
            $posXColor = $res->getXColor();
        }

        $this->posXLegend = $tmp;

        if ($this->fontSeriesColor) {
            $font=$g->getFont();
            if (($this->iLegendStyle == LegendStyle::$SERIES) ||
                ($this->iLegendStyle == LegendStyle::$LASTVALUES)) {
                $font->setColor($this->chart->seriesLegend($itemIndex, !$this->checkBoxes)->
                                     $this->getColor());
            } else {
                $font->setColor($this->tmpSeries->legendItemColor($itemIndex));
            }
        }

        for ( $t = 0; $t < self::$MAXLEGENDCOLUMNS-1; $t++) {
            $tmpSt = $this->items[$itemOrder][$t];
            $this->incPos = true;

            if ($tmpSt != null) {
                if ($this->iLegendStyle == LegendStyle::$SERIES) {
                     $tmpAlign = Array(StringAlignment::$VERTICAL_CENTER_ALIGN);
                     $g->setTextAlign($tmpAlign);
                } else
                if ($t == 0) {
                    if (($this->textStyle == LegendTextStyle::$XVALUE) ||
                        ($this->textStyle == LegendTextStyle::$VALUE) ||
                        ($this->textStyle == LegendTextStyle::$PERCENT) ||
                        ($this->textStyle == LegendTextStyle::$XANDVALUE) ||
                        ($this->textStyle == LegendTextStyle::$XANDPERCENT) ||
                        ($this->textStyle == LegendTextStyle::$LEFTPERCENT) ||
                        ($this->textStyle == LegendTextStyle::$LEFTVALUE)
                            ) {
                        $this->setRightAlign($t, true);
                    } else {
                        $this->setRightAlign($t, true);
//                        $this->setRightAlign($t, false);
                    }
                } else
                if ($t == 1) {
                    if (($this->textStyle == LegendTextStyle::$RIGHTVALUE) ||
                        ($this->textStyle == LegendTextStyle::$XANDVALUE) ||
                        ($this->textStyle == LegendTextStyle::$XANDPERCENT) ||
                        ($this->textStyle == LegendTextStyle::$RIGHTPERCENT)
                            ) {
                        $this->setRightAlign($t, true);
                    } else {
                        $this->setRightAlign($t, true);
                    }
                }

                if (strlen($tmpSt) != 0) {
                    $tmpBox = $this->hasCheckBoxes() ? $this->posYLegend + 1 : $this->posYLegend;
                    $g->textOut($this->posXLegend + 3, $tmpBox-1, 0, $tmpSt);
                }
            }

            if ($this->incPos) {
                $this->posXLegend += $this->columnWidths[$t];
            }
            $this->posXLegend += $this->iSpaceWidth;
        }

        $r = new Rectangle($posXColor,($this->posYLegend + 1),$this->iColorWidth,
        ($this->itemHeight + 1));

        $symbol = $this->getSymbol();
        if ((!$symbol->continuous) || ($itemOrder == 0)) {
            $r->y += 2;
            $r->height -= 2;
        }

        if ((!$symbol->continuous) || ($itemOrder == ($this->iLastValue - $this->firstValue))) {
            $r->height -= 1 + 2 + $this->vertSpacing;
        }

        if (($this->iLegendStyle == LegendStyle::$SERIES) ||
            ($this->iLegendStyle == LegendStyle::$LASTVALUES)) {
            if ($this->checkBoxes) {
                $tmpBox = $this->xLegendBox;
                $this->tmpSeries = $this->chart->seriesLegend($itemIndex, false);

                if (!$this->getVertical()) {
                    $tmpBox += $tmpX;
                }

                $checkStyle=true;

                if ($g instanceof GraphicsGD) {
                   /* TODO
                   Utils:drawCheckBox($tmpBox, $this->posYLegend + (($this->itemHeight - $this->vertSpacing -
                        self::$CHECKBOXSIZE) / 2) - 1, $g, $this->tmpSeries->getActive(),$checkStyle, $this->getColor());
                   */
                }

                $this->drawSymbol($this->tmpSeries, -1, $r);
            } else {
                $this->drawSymbol($this->chart->activeSeriesLegend($itemIndex), -1, $r);
            }
        } else {
            if ($this->tmpSeries != null) {
                $this->drawSymbol($this->tmpSeries, $this->tmpSeries->legendToValueIndex($itemIndex),
                           $r);
            } else {
                $this->drawSymbol(null, -1, $r);
            }
        }

        if (($itemOrder > 0) && ($this->dividingLines != null) &&
            $this->dividingLines->getVisible()) {
                
            $g->setPen($this->dividingLines);

            if ($this->getVertical()) {
                $g->horizontalLine($this->getShapeBounds()->getLeft(),
                                 $this->getShapeBounds()->getRight(),
                                 $this->posYLegend - ($this->vertSpacing / 2));
            } else {
                $g->verticalLine($this->getShapeBounds()->getLeft() + $tmpX + self::$LEGENDOFF2,
                               $this->getShapeBounds()->getTop(),
                               $this->getShapeBounds()->getBottom());
            }
        }
        TChart::$controlName=$old_name;
    }

    private function drawItems() {
        $this->tmpSeries = $this->getLegendSeries();
        if ($this->inverted) {
            for ( $t = $this->iLastValue; $t >= $this->firstValue; $t--) {
                $this->drawLegendItem($t, ($this->iLastValue - $t));
            }
        } else {
            for ( $t = $this->firstValue; $t <= $this->iLastValue; $t++) {
                $this->drawLegendItem($t, ($t - $this->firstValue));
            }
        }
    }

    private function setItem($index, $pos) {
         $tmpSt = $this->chart->formattedLegend($pos); /* 5.01 */

         $tmp = 0;
         $i = -1;

         do {
            $i = strpos($tmpSt,Language::getString("ColumnSeparator"));
            if ($i != false) {
                $this->items[$index][$tmp] = substr($tmpSt,0, $i);
                $tmpSt = substr($tmpSt,$i + 1);
                $tmp++;
            }
        } while (!(($i == false) || (strlen($tmpSt) == 0) || ($tmp > 1)));

        if ((strlen($tmpSt) != 0) && ($tmp <= 1)) {
            $this->items[$index][$tmp] = $tmpSt;
        }
    }

    private function getItems() {
        $this->items = array();

        if ($this->getInverted()) {
            for ( $t = $this->iLastValue; $t >= $this->firstValue; $t--) {
                $this->setItem($this->iLastValue - $t, $t);
            }
        } else {
            for ( $t = $this->firstValue; $t <= $this->iLastValue; $t++) {
                $this->setItem($t - $this->firstValue, $t);
            }
        }
    }

    private function calcMaxLegendValues($yLegend, $a, $b, $c, $itemHeight) {
        if (($yLegend < $a) && ($itemHeight > 0)) {
             $tmp = $itemHeight;
             $result = (int) ((($b - 2 * $this->getFrame()->getWidth()) -
                                 $yLegend + $c) / $tmp);
            return min($result, $this->iTotalItems);
        } else {
            return 0;
        }
    }

    private function maxLegendValues($yLegend, $itemHeight) {
        $tmp=$this->chart->getChartRect();
        
        if ($this->getVertical()) {
            return $this->calcMaxLegendValues($yLegend, $tmp->getBottom(),
                                       $tmp->height,
                                       $tmp->y,
                                       $itemHeight);
        } else {
            return $this->calcMaxLegendValues($yLegend, $tmp->getRight(),
                                       $tmp->width,
                                       0,
                                       $itemHeight);
        }
    }

    private function resizeVertical() {
        $tmp = 2 * self::$LEGENDOFF2 + $this->itemHeight * $this->numRows;

        if ($this->drawTitle()) {
          $tmp += $this->getTitle()->getHeight()+2;
          if (! $this->getTitle()->getTransparent())
             $tmp+=abs($this->getTitle()->getShadow()->getVertSize());
        }

        if (($this->getAlignment() == LegendAlignment::$BOTTOM) && (!$this->getCustomPosition())) {
            $this->shapeBounds->y = $this->shapeBounds->getBottom() - $tmp;
        }
        $this->shapeBounds->height = $tmp;
    }

    private function calcMargin($margin, $defaultMargin, $size) {
        return ($margin == 0) ? $defaultMargin * $size / 100 : $margin;
    }

    /**
    * Returns the chart rectangle minus the space occupied by the Legend.
    *
    * @param rect Rectangle
    * @return Rectangle
    */
    public function resizeChartRect($rect) {
        if ($this->getResizeChart() && (!$this->getCustomPosition())) {
            if ($this->alignment == LegendAlignment::$LEFT) {
                $rect->x = $this->shapeBounds->getRight();
                $rect->width -= $rect->x;
            } else
            if ($this->alignment == LegendAlignment::$RIGHT) {
                $rect->width = $this->shapeBounds->x - $rect->x;
                if (($this->getShadow()->getVisible()) && ($this->shadow->getWidth() < 0)) {
                    $rect->width += $this->shadow->getWidth();
                }
            } else
            if ($this->alignment == LegendAlignment::$TOP) {
                $tmpRY = $rect->y;
                $rect->y = $this->shapeBounds->getBottom();

                if ($this->getShadow()->getVisible()) {
                    $rect->y += max(0, $this->getShadow()->getHeight());
                }

                if ($rect->y > $tmpRY) {
                    $rect->height -= ($rect->y - $tmpRY);
                }
            } else
            if ($this->alignment == LegendAlignment::$BOTTOM) {
                $rect->height = $this->shapeBounds->y - $rect->y;
            }
        }

        if ($this->getVertical()) {
            $tmp = $this->calcMargin($this->getHorizMargin(), 3, $this->chart->getWidth());
            if ($this->getAlignment() == LegendAlignment::$LEFT) {
                $rect->x += $tmp;
            } else {
                $rect->width -= $tmp;
            }
        } else {
             $tmp = $this->calcMargin($this->getVertMargin(), 4, $this->chart->getHeight());
            if ($this->getAlignment() == LegendAlignment::$TOP) {
                $rect->y += $tmp;
            } else {
                $rect->height -= $tmp;
            }
        }
        return $rect;
    }

    private function getFirstItemTop() {
        $result=$this->getShapeBounds()->getTop();

        if ($this->drawTitle()) {
            $result=$result + $this->getTitle()->getHeight();
            if (!$this->getTitle()->getTransparent()) {
                $result = $result + abs($this->getTitle()->getShadow()->getHeight());
            }
        }
        return $result;
    }

    public function paint($gd=null, $rect=null) {
        TChart::$controlName .= 'Legend_';
        
        if ($this->bCustomPosition) {
            $this->setShapeBounds(new Rectangle($this->getLeft(), $this->getTop(), $rect->width,
                                         $rect->height));
        } else {
            $this->setShapeBounds($rect);
        }

        $this->calcLegendStyle();

        $isPage = ($this->iLegendStyle == LegendStyle::$VALUES) && $this->currentPage &&
                         ($this->chart->getPage()->getMaxPointsPerPage() > 0);

        if ($isPage) {
            $this->firstValue = ($this->chart->getPage()->getCurrent() - 1) *
                         $this->chart->getPage()->getMaxPointsPerPage();
        }

        $this->iTotalItems = $this->calcTotalItems();

        if ($isPage) {
            $this->iTotalItems = min($this->iTotalItems,
                                   $this->chart->getPage()->getMaxPointsPerPage());
        }

        $gd->setFont($this->getFont());

        $this->iSpaceWidth = MathUtils::round($gd->textWidth(" ") - 1);

        // calculate default Height for each Legend Item
        $this->itemHeight = $this->calcItemHeight();

        if ($this->drawTitle()) {
            $this->getTitle()->calcHeight();
        }

        // calculate Frame Width offset
        if ($this->getFrame()->getVisible()) {
            $this->frameWidth = MathUtils::round($this->getFrame()->getWidth());
        } else {
            $this->frameWidth = 0;
        }
        if ($this->getBevel()->getInner() != BevelStyle::$NONE) {
            $this->frameWidth = $this->getBevel()->getWidth();
        }

        if ($this->getVertical()) {
            if (!$this->bCustomPosition) {
                $this->getShapeBounds()->setY($this->getShapeBounds()->getY() + (int) ($this->topLeftPos * $this->getShapeBounds()->getHeight() * 0.01));
            }

            $this->numCols = 1;
            $this->numRows=$this->maxLegendValues($this->getFirstItemTop(),$this->itemHeight);

            $this->iLastValue = $this->firstValue + min($this->iTotalItems, $this->numRows) - 1;
            $this->getItems(); // Visible !!
        }

        else {
            $this->iLastValue = $this->firstValue + $this->iTotalItems - 1;
            $this->getItems(); // All !!
            $this->tmpMaxWidth = $this->calcColumnsWidth(self::$ALLVALUES);
            $this->iColorWidth = $this->getSymbol()->calcWidth($this->tmpMaxWidth);

            if (!$this->bCustomPosition) {
                if ($this->getAlignment() == LegendAlignment::$BOTTOM) {
                    $this->setBottom($rect->getBottom() - $this->frameWidth - 1);
                    if ($this->getShadow()->getVisible()) {
                        $this->shapeBounds->height -= $this->getShadow()->getHeight();
                    }
                } else {
                    $this->shapeBounds->y = $rect->y + $this->frameWidth + 1;
                }
            }

            //CDI TF02010041
            $tmpCol = $this->tmpMaxWidth + $this->iColorWidth + 2 * self::$LEGENDOFF4;
            if ($this->hasCheckBoxes()) {
                $tmpCol += self::$CHECKBOXSIZE + 2 * self::$LEGENDOFF2 + 3 * self::$LEGENDOFF4;
            }

            $this->numCols = $this->maxLegendValues(2 * self::$LEGENDOFF4, $tmpCol);
            if ($this->numCols > 0) {
                $this->numRows = $this->iTotalItems / $this->numCols;
                if (($this->iTotalItems % $this->numCols) > 0) {
                    $this->numRows++;
                }
                $this->numRows = min($this->numRows, $this->maxNumRows);
            } else {
                $this->numRows = 0;
            }
            /* adjust the last index now we know the max number of rows... */
            $this->iLastValue = $this->firstValue + min($this->iTotalItems,
                  $this->numCols * $this->numRows) - 1;
        }

        if ($this->iLastValue >= $this->firstValue) {
            $this->resizeVertical();

            if ($this->getVertical()) {
                $this->calcVerticalPositions();
            } else {
                $this->calcHorizontalPositions();
            }

            if ($this->chart->getParent() != null) {
                /* TODO $this->setShapeBounds($this->chart->getParent()->getLegendResolver()->getBounds(
                        $this,
                        $this->getShapeBounds()));
                        */
            }

            parent::_paint($gd, $this->getShapeBounds(), $this->getAnimations());

            if ($this->drawTitle()) {
                $this->getTitle()->internalDraw($gd, $this->getShapeBounds());
                $gd->getFont()->assign($this->getFont());
            }

            $this->drawItems();             
        }
    }
    
    function getAnimations()
    {
       return $this->animations;   
    }
    
    function addAnimation($animation)
    {
       $this->animations[] = $animation;   
    }

    /**
    * Returns the text string corresponding to a Legend position.<br>
    * The Legend position depends on Legend.LegendStyle. If LegendStyle is
    * lsSeries, then the text string will be the SeriesOrValueIndexth Active
    * Series Title.<br> If LegendStyle is lsValues, then the text string will
    * be the formatted SeriesOrValueIndexth value of the first Active Series
    * in the Chart.<br>
    * If LegendStyle is lsAuto and only one Active Series exists in the Chart,
    * then the LegendStyle is considered to be lsValues.<br>
    * If there is more than one Active Series then LegendStyle will be
    * lsSeries. <br>
    * Values are formatted accordingly to LegendTextStyle.
    *
    * @param seriesOrValueIndex int
    * @return String
    */
    public function formattedLegend($seriesOrValueIndex) {
        $c = $this->chart;

        if ($this->iLegendStyle == LegendStyle::$SERIES) {
            return $c->getSeriesTitleLegend($seriesOrValueIndex, !$this->getCheckBoxes());
        } else
        if ($this->iLegendStyle == LegendStyle::$VALUES) {
            return $c->formattedValueLegend($this->getLegendSeries(), $seriesOrValueIndex);
        } else
        if ($this->iLegendStyle == LegendStyle::$LASTVALUES) {
            return $c->formattedValueLegend($c->getSeries($seriesOrValueIndex),
                                          $c->getSeries($seriesOrValueIndex)->getCount() - 1);
        } else
        if($this->iLegendStyle == LegendStyle::$PALETTE) {
            return $c->formattedValueLegend($this->getLegendSeries(), $seriesOrValueIndex);
        }

        return "";
    }

    private function prepareSymbolPen() {
        $this->chart->setLegendPen($this->getSymbol()->getDefaultPen() ? null :
                           $this->getSymbol()->getPen());
    }

    private function removeChar($c, $s) {
        while (($i = strpos($s,$c)) != FALSE) {
            $s = substr($s,0,$i) . substr($s,$i+1);
        }
        return $s;
    }

    /**
    * Returns the corresponding Legend text for the Series ValueIndex point.
    * <br>
    * Legend.LegendTextStyle is used to properly format the point values
    * and labels.
    *
    * @param aSeries Series
    * @param valueIndex int
    * @return String
    */
    public function formattedValue($aSeries, $valueIndex) {
        if ($valueIndex != self::$ALLVALUES) {
            $tmpResult = $aSeries->getLegendString($valueIndex, $this->getTextStyle());

            // eliminate breaks in String... }
            return $this->removeChar(Language::getString("LineSeparator"), $tmpResult);
        } else {
            return "";
        }
    }
}
?>