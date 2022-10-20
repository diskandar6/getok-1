<?php
 /**
 * Description:  This file contains the following class:<br>
 * SeriesMarks class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * SeriesMarks class
 *
 * Description: Series Marks characteristics
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class SeriesMarks extends TextShape
{
   /**
   * When True, Marks arrow pen color is changed if the
   * point has the same color.
   */

   public $checkMarkArrowColor = true;

   protected $iSeries;
   protected $pPositions;
   protected $bClip=false;
   protected $markerStyle = 2; // MarksStyle::$LABEL

   private $multiLine=false;
   private $drawEvery = 1;
   private $zPosition = -1;
   private $angle=0;
   private $callout=null;
   private $items=null;
   private $symbol=null;
   private $textAlign;

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
   public function __construct($s)
   {
      parent::__construct($s->getChart());

      $this->iSeries = $s;

      $tmpColor = new Color(255,255,180);  // LIGHT_YELLOW
      $this->getBrush()->setDefaultColor($tmpColor);

      $this->textAlign=Array(StringAlignment::$VERTICAL_CENTER_ALIGN,
                            StringAlignment::$HORIZONTAL_CENTER_ALIGN);

      $this->getShadow()->setDefaultVisible(true);
      $this->shadow->setDefaultSize(1);
      $this->shadow->getBrush()->setDefaultColor(new Color(128,128,128)); // DARK_GRAY

      $this->setDefaultVisible(false);

      $this->callout = new MarksCallout($s);
      $this->callout->setDefaultLength(10);

      $this->items = new MarksItems($this);
      $this->items->iMarks = $this;

      $this->readResolve();
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->checkMarkArrowColor);
        unset($this->iSeries);
        unset($this->pPositions);
        unset($this->bClip);
        unset($this->markerStyle);
        unset($this->multiLine);
        unset($this->drawEvery);
        unset($this->zPosition);
        unset($this->angle);
        unset($this->callout);
        unset($this->items);
        unset($this->symbol);
        unset($this->textAlign);
    }     

   protected function readResolve()
   {
      $this->pPositions = new MarkPositions();
      return $this;
   }

   /**
   * Marks Callout characteristics.<br>
   * Determines how to draw a line connecting a series mark to its
   * series point.
   *
   * @return MarksCallout
   */
   public function getCallout()
   {
      return $this->callout;
   }

   /**
   * Returns a collection of mark items. <br>
   * Each mark item has its own formatting (color, font, shadow, etc).<br>
   * By default Items are empty, so the default marks formatting is used.
   *
   * @return MarksItems
   */
   public function getItems()
   {
      return $this->items;
   }

   public function setItems($value)
   {
      $this->items = $value;
   }

   /**
   * Accesses Custom position characteristics for Series Marks. <br>
   * TeeChart for Net has a number of algorithmns that were designed to stop
   * TeeChart SeriesMark overlap. However, if you aren't happy with the
   * automatically generated mark positions, you can always move marks around
   * with code.<br><br>
   * (Remember that you could also use the DragMarks Tool to reposition
   * marks on your Chart.)
   *
   * @return MarkPositions
   */
   public function getPositions()
   {
      return $this->pPositions;
   }

   /**
   * Contains the list of lines drawn on the chart by the user at run-time.
   *
   * @return String[]
   */
   public function getLines()
   {
      return parent::getLines();
   }

   /**
   * Series is a read-only runtime method.<br>
   * It returns the Series component that owns the TSeriesMarks subcomponent.
   * <br>
   * All Series types own a Marks subcomponent of the TSeriesMarks class.
   *
   * @return ISeries
   */
   public function getSeries()
   {
      return $this->iSeries;
   }

   /**
   $Defines $how $Series $Marks $are $static $finalructed.<br>
   * Each different Style value makes Marks output a different text.
   * Several options are available, but you can also use the TChart
   * Series.OnGetMarkText event and override the default Series Marks text.
   * <br>
   * Default value: MarksStyle.Label
   *
   *
   * @return MarksStyle
   */
   public function getStyle()
   {
      return $this->markerStyle;
   }

   /**
   * Defines how Series Marks are constructed.<br>
   * Default value: MarksStyle.Label
   *
   *
   * @param value MarksStyle
   */
   public function setStyle($value)
   {
      if($this->markerStyle != $value)
      {
         $this->markerStyle = $value;
         $this->invalidate();
      }
   }

   public function getSymbol()
   {
      if($this->symbol == null)
      {
         $this->symbol = new TextShape($this->chart);
         $this->symbol->setVisible(false);
         $this->symbol->setTransparent(false);
         $this->symbol->getShadow()->setWidth(1);
         $this->symbol->getShadow()->setHeight(1);
      }
      return $this->symbol;
   }

   public function setChart($value)
   {
      parent::setChart($value);
      if($this->symbol != null)
      {
         $this->symbol->setChart($value);
      }
   }

   /**
   * Tells chart to repaint using automatically positioned marks.<br>
   * Turns all Marks positions Custom to false.
   */
   public function resetPositions()
   {
      for($t = 0; $t < sizeof($this->pPositions); $t++)
      {
         $p = $this->pPositions->getPosition($t);
         if($p != null)
         {
            $p->custom = false;
         }
      }
      $this->invalidate();
   }

   /**
   * Removes all mark positions and mark items.
   */
   public function clear()
   {
      $this->pPositions->clear();
      if(!$this->getItems()->iLoadingCustom)
      {
         $this->getItems()->clear();
      }
   }

   /**
   * Determines which Mark contains the p point parameters.
   *
   * @param p Point
   * @return int
   */
   public function _clicked($p)
   {
      return $this->clicked($p->x, $p->y);
   }

   /**
   *  Determines which Mark contains the XY pixel point parameters.
   *
   * @param x int
   * @param y int
   * @return int the Mark index containing the XY point.
   */
   public function clicked($x, $y)
   {
      if($this->iSeries->getChart() != null)
      {
         $p = $this->iSeries->getChart()->getGraphics3D()->calculate2DPosition($x, $y,
            $this->getZPosition());
         $x = $p->getX();
         $y = $p->getY();
      }

      $result = 0;
      for($t = 0; $t < $this->pPositions->count(); $t++)
      {
         $p = $this->pPositions->getPosition($t);
         if(($result % $this->drawEvery == 0) && ($p != null) &&
         ($p->getBounds()->contains($x, $y)))
         {
            return $result;
         }
         else
         {
            $result++;
         }
      }
      return - 1;
   }

   /**
   * Obsolete.&nbsp;Use the Color method instead.
   *
   * @return Color
   */
   public function getBackColor()
   {
      return $this->getColor();
   }

   /**
   * Obsolete.&nbsp;Use the Color method instead.
   *
   * @param value Color
   */
   public function setBackColor($value)
   {
      $this->setColor($value);
   }

   /**
   * Obsolete.&nbsp;Use the Pen method instead.
   *
   * @return ChartPen
   */
   public function getFrame()
   {
      return $this->getPen();
   }

   /**
   * The Pen used to draw a line connecting Marks to Series points.<br>
   * Each Series class handles Marks in a different manner, thus the Arrow
   * coordinates are specific to each Series type. <br>
   * By default, Arrow pen is defined to be a White solid pen of 1 pixel
   * width.
   *
   * @return ChartPen
   */
   public function getArrow()
   {
      return $this->callout->getArrow();
   }

   //protected boolean shouldSerializeArrowLength() {
   //    return getArrowLength() != defaultArrowLength;
   //}

   /**
   * The length in pixels for the line connecting the Mark to Series point.
   * <br>Default value: 16
   *
   * @return int
   */
   public function getArrowLength()
   {
      return $this->callout->getLength();
   }

   /**
   * Stes the length in pixels of the line connecting the Mark to Series
   * point.<br>
   * Default value: 16
   *
   * @param value int
   */
   public function setArrowLength($value)
   {
      $this->getCallout()->setLength($value);
   }

   /**
   * Restricts Marks to Chart axes space, when true.<br>
   * When true, Marks will be drawn only within inner chart boundaries,
   * keeping Axis Labels, Titles, Legend, etc almost untouched.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getClip()
   {
      return $this->bClip;
   }

   /**
   * Restricts Marks to Chart axes space, when true.<br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setClip($value)
   {
      $this->bClip = $this->setBooleanProperty($this->bClip, $value);
   }

   /**
   * Characters in Mark texts are split into multiple lines, when true.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getMultiLine()
   {
      return $this->multiLine;
   }

   /**
   * Characters in Mark texts are split into multiple lines, when true.<br>
   * Default value: false
   *
   * @param value boolean
   */
   public function setMultiLine($value)
   {
      $this->multiLine = $this->setBooleanProperty($this->multiLine, $value);
   }

   /**
   * The number of Marks to skip.<br>
   * Default is 1, all Marks are displayed.
   * Setting it to two will draw every other Mark, to three every third etc.
   * <br>
   * Default value: 1
   *
   * @return int
   */
   public function getDrawEvery()
   {
      return $this->drawEvery;
   }

   /**
   * Sets the number of Marks to skip.<br>
   * Default value: 1
   *
   * @param value int
   */
   public function setDrawEvery($value)
   {
      $this->drawEvery = $this->setIntegerProperty($this->drawEvery, $value);
   }

   /**
   * The angle from 0 to 360 to rotate Marks.<br>
   * Default value: 0
   *
   * @return double
   */
   public function getAngle()
   {
      return $this->angle;
   }

   /**
   * Sets angle from 0 to 360 to rotate Marks.<br>
   * Default value: 0
   *
   * @param value double
   */
   public function setAngle($value)
   {
      $this->angle = $this->setDoubleProperty($this->angle, $value);
   }

   /**
   * The Position in pixels on the Z axis.
   *
   * @return int
   */
   public function getZPosition()
   {
      return $this->zPosition;
   }

   /**
   * Sets Position in pixels on the Z axis.
   *
   * @param value int
   */
   public function setZPosition($value)
   {
      $this->zPosition = $this->setIntegerProperty($this->zPosition, $value);
   }

   public function getTextAlign($value)
   {
      return $this->textAlign;
   }

   public function setTextAlign($value)
   {
      $this->textAlign=$value;
   }

   private function drawTextLine($lineSt, $r, $tmpNumRow, $tmpRowHeight)
   {
      $tmpP = new TeePoint();
      $tmpCenter = $r->center();

      if($this->angle != 0)
      {
         $tmp = $this->angle * MathUtils::getPiStep();
         $s = sin($tmp);
         $c = cos($tmp);

         $tmpY = $tmpNumRow * $tmpRowHeight -
         ($r->getBottom() - $tmpCenter->y);
         $tmpP->setX($tmpCenter->x + MathUtils::round($tmpY * $s));

         if($this->angle == 90)
         {
            $tmpP->setX($tmpP->getX() + 2);
         }
         $tmpP->setY($tmpCenter->y + MathUtils::round($tmpY * $c));
      }
      else
      {
         $tmpP->setX($tmpCenter->getX());
         $tmpP->setY($r->y + $tmpNumRow * $tmpRowHeight);

         if($this->getPen()->getVisible())
         {
            $tmpP->setX($tmpP->getX() + $this->getPen()->getWidth());
            $tmpP->setY($tmpP->getY() + $this->getPen()->getWidth());
         }
      }

      $g = $this->iSeries->getChart()->getGraphics3D();
      $g->setTextAlign($this->textAlign);

      if($g->getSupports3DText())
      {
         if($this->angle == 0)
         {
            $g->textOut($tmpP->getX(), $tmpP->getY(), $this->getZPosition(), $lineSt);
         }
         else
         {
            $g->rotateLabel($tmpP->getX(), $tmpP->getY(),$this->getZPosition(), $lineSt,
            $this->angle);
         }
      }
      else
      {
         if($this->angle == 0) {
            $g->textOut($tmpP->getX(), $tmpP->getY(),0,$lineSt);
         }
         else {
            $g->rotateLabel($tmpP->getX(), $tmpP->getY(), 0, $lineSt, $this->angle);
         }
      }
   }

   public function allSeriesVisible()
   {
      if($this->chart != null)
      {
         for($t = 0; $t < $this->chart->getSeriesCount(); $t++)
         {
            if(!$this->chart->getSeries($t)->getMarks()->getVisible())
            {
               return false;
            }
         }
         return true;
      }
      else
      {
         return $this->getVisible();
      }
   }

   public /*protected*/ function applyArrowLength($aPos)
   {
      $tmp = $this->callout->getLength() + $this->callout->getDistance();
      $aPos->leftTop->setY($aPos->leftTop->getY() - $tmp);
      $aPos->arrowTo->setY($aPos->arrowTo->getY() - $tmp);
      $aPos->arrowFrom->setY($aPos->arrowFrom->getY() - $this->callout->getDistance());
      return $aPos;
   }

   /**
   * Returns the String showing a "percent" value for a given point.<br>
   * For example: "25%"<br>
   * The optional "AddTotal" parameter, when true, returns: "25% of 1234".
   *
   * @param valueIndex int
   * @param addTotal boolean
   * @return String
   */
   public function percentString($valueIndex, $addTotal)
   {
      $m = $this->iSeries->getMandatory();
      $tmp = ($m->getTotalABS() != 0) ?
      abs($this->iSeries->getMarkValue($valueIndex)) /
      $m->getTotalABS() : 100;
      
      $tmpResult= number_format($tmp*100,2) . " %"; 
      
      if($addTotal)
      {
         $tmpF = $this->multiLine ? Language::getString("DefaultPercentOf") :
            Language::getString("DefaultPercentOf");
         try
         {
            $tmpResult = StringFormat::format($tmpF, $tmpResult,
            $m->getTotalABS(), $this->iSeries->getValueFormat());
         }
         catch(Exception $e)
         {
            $tmpResult = StringFormat::format($tmpF, $tmpResult,
            $m->getTotalABS(), Language::getString("DefValueFormat"));
         }
      }
      return $tmpResult;
   }

   private function drawText($r, $st)
   {       
      $tmpNumRow = 0;
      $tmpRowHeight = $this->iSeries->getChart()->getGraphics3D()->getFontHeight();

      $i = strpos($st, Language::getString("LineSeparator"));

      if($i !== FALSE) {
         (int)$this->sepLength = 2;
         $tmpSt = $st;
         do  {
            $this->drawTextLine(substr($tmpSt,0, $i), $r, $tmpNumRow,$tmpRowHeight);
            $tmpSt = substr($tmpSt,$i + 1, strlen($tmpSt));
            $tmpNumRow++;
            $i = strpos($tmpSt, Language::getString("LineSeparator"));
         }
         while($i !== FALSE);

         if(strlen($tmpSt) != 0)   {
            $this->drawTextLine($tmpSt, $r, $tmpNumRow, $tmpRowHeight);
         }
      }
      else {
         $this->drawTextLine($st, $r, $tmpNumRow, $tmpRowHeight);
      }
   }

   private function usePosition($index, $markPosition)
   {
      while($index >= sizeof($this->pPositions))
      {
          $this->pPositions[]=null;
      }

      $tmp = null;

      if($this->pPositions->getPosition($index) == null)
      {
         $tmp = new SeriesMarksPosition();
         $tmp->custom = false;
         $this->pPositions->setPosition($index, $tmp);
      }
      $tmp = $this->pPositions->getPosition($index);

      if($tmp->custom)
      {
         if($markPosition->arrowFix)
         {
            $old = $markPosition->arrowFrom;
            $markPosition->assign($tmp);
            $markPosition->arrowFrom = $old;
         }
         else
         {
            $markPosition->assign($tmp);
         }
      }
      else
      {
         $tmp->assign($markPosition);
      }
   }

   /**
   * Returns the length in pixels for the ValueIndex th mark text String.<br>
   * It checks if the Mark has multiple lines of text.
   *
   * @param valueIndex int
   * @return int
   */
   public function textWidth($valueIndex)
   {
      $tmpSt2 = "";
      $tmpResult = 0;
      $tmpSt = $this->iSeries->getMarkText($valueIndex);
      
      $i = strrpos($tmpSt,Language::getString("LineSeparator"));

      if($i > 0)
      {
         do
         {
            $tmpSt2 = substr($tmpSt, 0, $i);
            $tmpResult = max($tmpResult,
            $this->iSeries->getChart()->getGraphics3D()->textWidth($tmpSt2));
            $tmpSt = $tmpSt->substring($i + 1);
            $i = $tmpSt->indexOf(Language::getString("LineSeparator"));
         }
         while($i != - 1) ;
      }

      if(strlen($tmpSt) != 0)
      {
         $tmpResult = max($tmpResult,
         $this->iSeries->getChart()->getGraphics3D()->textWidth($tmpSt));
      }

      return $tmpResult;
   }

   protected function convertTo2D($aPos, $p)
   {
      if($this->chart->getAspect()->getView3D() &&
      !$this->chart->getGraphics3D()->getSupports3DText())
      {
         $tmpDifX = $aPos->arrowTo->getX() - $p->getX();
         $tmpDifY = $aPos->arrowTo->getY() - $p->getY();
         $tmpPos2D = $this->chart->getGraphics3D()->calc3DPoint($aPos->arrowTo->getX(),
            $aPos->arrowTo->getY(), $this->getZPosition());

         $p->setX($tmpPos2D->getX() - $tmpDifX);
         $p->setY($tmpPos2D->getY() - $tmpDifY);
      }

      return $p;
   }

   private function totalBounds($valueIndex, $aPos)
   {
      $result = $aPos->getBounds();
      $tmpMark = $this->markItem($valueIndex);

      if($tmpMark->getPen()->getVisible())
      {
         $result->width += $tmpMark->getPen()->getWidth();
         $result->height += $tmpMark->getPen()->getWidth();
      }

      if($tmpMark->getShadow()->getWidth() > 0)
      {
         $result->width += $tmpMark->getShadow()->getWidth();
      }
      else
         if($tmpMark->getShadow()->getWidth() < 0)
         {
            $result->x -= $tmpMark->getShadow()->getWidth();
         }

      if($tmpMark->getShadow()->getHeight() > 0)
      {
         $result->height += $tmpMark->getShadow()->getHeight();
      }
      else
         if($tmpMark->getShadow()->getHeight() < 0)   {
            $result->y -= $tmpMark->getShadow()->getHeight();
         }

      $p = $this->convertTo2D($aPos, $result->getLocation());

      $tmp = $result->x - $p->getX();
      $result->x -= $tmp;
      $result->width -= $tmp;

      $tmp = $result->getY() - $p->getY();
      $result->y -= $tmp;
      $result->height -= $tmp;

      return $result;
   }

   public function antiOverlap($first, $valueIndex, $aPos)
   {
      $tmpDest = new Rectangle();
      $tmpBounds = $this->totalBounds($valueIndex, $aPos);

      for($t = $first; $t < $valueIndex; $t++)
      {
         if($this->getPositions()->getPosition($t) != null) {
            $tmpR = $this->totalBounds($t, $this->getPositions()->getPosition($t));
            Rectangle::__intersect($tmpR, $tmpBounds, $tmpDest);
            if(!$tmpDest->isEmpty())   {
               $tmpH = 0;

               if($tmpBounds->getTop() < $tmpR->getTop())   {
                  $tmpH = $tmpBounds->getBottom() - $tmpR->y;
               }
               else {
                  $tmpH = $tmpBounds->y - $tmpR->getBottom();
               }

               $aPos->leftTop->setY($aPos->leftTop->getY() - $tmpH);
               $aPos->arrowTo->setY($aPos->arrowTo->getY() - $tmpH);
            }
         }
      }
   }

   public function markItem($valueIndex)
   {
      $result = $this;
      if (sizeof($this->getItems()) > 0)  {
        if((sizeof($this->getItems()) > $valueIndex) && ($this->getItems()->getItem($valueIndex) != null))   {
           $result = $this->getItems()->getItem($valueIndex);
        }
      }
      return $result;
   }

   public function internalDraw($index, $aColor, $st, $aPos)
   {
      $old_name=TChart::$controlName;       
      TChart::$controlName .='Mark_'; 
      
      $this->usePosition($index, $aPos);
      $c = $this->iSeries->getChart();
      $g = $c->getGraphics3D();

      $tmpMark = $this->markItem($index);

      $tmp3D = $c->getAspect()->getView3D();

      if($this->callout->getVisible() || $this->callout->getArrow()->getVisible())
      {
         $this->callout->drawCallout($aColor, $aPos->arrowFrom, $aPos->arrowTo,
         $this->getZPosition());
      }

      if ($this->getTransparent()) {
         $tmpMark->setTransparent(true);
      }
      else {
        if($tmpMark->getTransparent())  {
         $g->getBrush()->setVisible(false);
        }
        else {
         $g->setBrush($tmpMark->getBrush());
        }
      }

      $g->setPen($tmpMark->getPen());
      $aPos->leftTop = $this->convertTo2D($aPos, $aPos->leftTop);

      // Added extra -2 and +4, ok?
      $frameRect = new Rectangle($aPos->leftTop->getX()-2,
          $aPos->leftTop->getY()+2, $aPos->width + 2 + 4,
          $aPos->height);

      $tmpMark->drawRectRotated($g, $frameRect, (int)($this->angle % 360),
           $this->getZPosition());

      $tmpSymbol = $this->shouldDrawSymbol();

      if($tmpSymbol)
      {
         $this->symbol->setColor($this->getSeries()->getValueColor($index));
         $this->symbol->setTransparent(false);

         $tmpH = $g->getFontHeight();

         $this->symbol->setShapeBounds(Rectangle::fromLTRB($aPos->leftTop->getX() + 4,
         $aPos->leftTop->getY() + 3,
         $aPos->leftTop->getX() + $tmpH - 1,
         $aPos->leftTop->getY() + $tmpH - 2));
         $this->symbol->drawRectRotated($g, $this->symbol->getShapeBounds(),
         (int)($this->angle % 360), $this->getZPosition() + 1);
      }

      $g->getBrush()->setVisible(false);

      $r = $aPos->getBounds();

      if($tmpSymbol)
      {
         $tmp = 4 + $this->symbol->getShapeBounds()->width;
         $r->setX($r->getX() + $tmp);
         $r->width -= $tmp;
      }

      $this->drawText($r, $st);
      TChart::$controlName=$old_name;             
   }

   function shouldDrawSymbol()
   {
      return($this->symbol != null) && ($this->symbol->getVisible()) &&
      (!$this->symbol->getTransparent());
   }
}

?>
