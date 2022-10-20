<?php
 /**
 * Description:  This file contains the following class:<br>
 * Gantt class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 * Gantt Class
 *
 * Description: Gantt Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class Gantt extends Points
{
   private static $NUMGANTTSAMPLES = 10;
   private $endValues;
   private $nextTask;

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
   * Creates a new Gantt series.
   */
   public function __construct($c = null)
   {
      parent::__construct($c);
      $this->setHorizontal();
      $this->calcVisiblePoints = false;

      $this->vxValues->setName("ValuesGanttStart");// TODO  $this->Language->getString("ValuesGanttStart");
      $this->vxValues->setDateTime(true);
      $this->vxValues->setOrder(ValueListOrder::$NONE);
      $this->bColorEach = true;

      $tmpColor = new Color(0, 0, 0);// Black
      $this->getLinePen()->setColor($tmpColor);

      $this->endValues = new ValueList($this, "ValuesGanttEnd"/*$this->Language->getString("ValuesGanttEnd")*/);
      $this->endValues->setDateTime(true);

      $this->nextTask = new ValueList($this, "ValuesGanttNextTask"/*$this->Language->getString("ValuesGanttNextTask")*/);
      $this->point->setStyle(PointerStyle::$RECTANGLE);// <--    $Bar ( default)
      
      unset($tmpColor);
   }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->endValues);
        unset($this->nextTask);
    }        
    
   /**
   * Defines the starting Gantt bar date values.<br>
   * The ending Gantt bar point date is stored at TGanttSeries.EndValues.<br>
   * StartValues and EndValues can be specified both as DateTime or double
   * values. <br>
   * Both are standard TChartValueList components. That means you can access
   * their values with same methods as you can access X or Y values.<br>
   * The TGanttSeries.Add method must be used to add Gantt bar points. <br>
   *
   * @return ValueList
   */
   public function getStartValues()
   {
      return $vxValues;
   }

   /**
   * Defines the ending Gantt bar date value.<br>
   * The starting Gantt bar point is stored at TGanttSeries.StartValues<br>
   * StartValues and EndValues can be specified both as DateTime or double
   * values. <br>
   * Both are standard TChartValueList components. That means you can access
   * their values with same methods as you can access X or Y values. <br>
   * The TGanttSeries.Add  method must be used to add Gantt bar points. <br>
   *
   * @return ValueList
   */
   public function getEndValues()
   {
      return $this->endValues;
   }

   /**
   * Holds the Gantt bar index each Gantt bar is connected to. <br>
   * When a Gantt bar is added to TGanttSeries, it's NextTask value is
   * assigned to -1 by default. That means the Gantt bar is NOT connected
   * to any other Gantt Bar. <br>
   * You need to set a valid bar index to NextTask. <br>
   *
   * @return ValueList
   */
   public function getNextTasks()
   {
      return $this->nextTask;
   }

   private function ganttSampleStr($index)
   {
      switch($index)
      {
         case 0:
            return "GanttSample1";//$this->Language->getString("GanttSample1");
         case 1:
            return "GanttSample2";//$this->Language->getString("GanttSample2");
         case 2:
            return "GanttSample3";//$this->Language->getString("GanttSample3");
         case 3:
            return "GanttSample4";//$this->Language->getString("GanttSample4");
         case 4:
            return "GanttSample5";//$this->Language->getString("GanttSample5");
         case 5:
            return "GanttSample6";//$this->Language->getString("GanttSample6");
         case 6:
            return "GanttSample7";//$this->Language->getString("GanttSample7");
         case 7:
            return "GanttSample8";//$this->Language->getString("GanttSample8");
         case 8:
            return "GanttSample9";//$this->Language->getString("GanttSample9");
         default:
            return "GanttSample1";//$this->Language->getString("GanttSample1");
      }
   }

   /**
   * Adds random values to series.
   * @param numValues int
   */
   protected function addSampleValues($numValues)
   {
      $r = $this->randomBounds($numValues);
      // some sample values to see something at design mode
      for($t = 0; $t <= min($numValues,  self::$NUMGANTTSAMPLES + MathUtils::round(20 * $r->Random())); $t++)
      {
         $tmpStartTask =  gettimeofday(true) + $t * 3 + 5 * $r->Random();
         $tmpEndTask = $tmpStartTask + 9 + 16 * $r->Random();
         $tmpY = ($t % 10);

         $addedGantt = $this->addGantt($tmpStartTask,
         $tmpEndTask,
         $tmpY,
         $this->ganttSampleStr($tmpY)
         );

         // Connect Gantt points
         for($tt = 0; $tt < $addedGantt; $tt++)
         {
            if(($this->nextTask->value[$tt] == - 1) && ($tmpStartTask > $this->endValues->value[$tt]))
            {
               $this->nextTask->value[$tt] = $addedGantt;
               break;
            }
         }
      }
   }

   /**
   * Determines the pen to draw the optional lines that connect Gantt
   * Bars. <br>
   *
   * @return ChartPen
   */
   public function getConnectingPen()
   {
      return $this->linePen;
   }

   /**
   * Called internally. Draws the "ValueIndex" point of the Series.
   *
   * @param valueIndex int
   */
   public function drawValue($valueIndex)
   {
      // This overrided method is the main paint method for Gantt bar points.
      if($this->point->getVisible())
      {
         $c = $this->getValueColor($valueIndex);
         $this->point->prepareCanvas($this->chart->getGraphics3D(), $c);

         $x1 = $this->calcXPos($valueIndex);
         $x2 = $this->calcXPosValue($this->endValues->value[$valueIndex]);
         $tmpHalfHorizSize = ($x2 - $x1) / 2;
         $y = $this->calcYPos($valueIndex);

         $tmpStyle = $this->onGetPointerStyle($valueIndex, $this->point->getStyle());

         $g = $this->chart->getGraphics3D();

         $this->point->intDraw($g,
         $this->chart->getAspect()->getView3D(),
         $x1 + $tmpHalfHorizSize,
         $y,
         $tmpHalfHorizSize,
         $this->point->getVertSize(),
         $c, $tmpStyle);

         if($this->getConnectingPen()->getVisible())
         {
            $tmpNextTask = round($this->nextTask->value[$valueIndex]);

            if(($tmpNextTask >= 0) && ($tmpNextTask < $this->getCount()))
            {
               $g->setPen($this->getConnectingPen());
               $g->getBrush()->setVisible(false);

               $xNext = $this->calcXPos($tmpNextTask);
               $halfWay = $x2 + (($xNext - $x2) / 2);
               $yNext = $this->calcYPos($tmpNextTask);
               $g->_line($x2, $y, $halfWay, $y, $this->getMiddleZ());
               $g->___lineTo($halfWay, $yNext, $this->getMiddleZ());
               $g->___lineTo($xNext, $yNext, $this->getMiddleZ());
            }
         }
      }
   }

   /**
   * For internal use.
   *
   * @param valueIndex int
   * @param tmpX int
   * @param tmpY int
   * @param x int
   * @param y int
   * @return boolean
   */
   public function clickedPointer($valueIndex, $tmpX, $tmpY, $x, $y)
   {
      return($x >= $tmpX) && ($x <= $this->calcXPosValue($this->getEndValues()->value[$valueIndex])) &&
      (abs($tmpY - $y) < $this->getPointer()->getVertSize());
   }

   protected function drawMark($valueIndex, $s, $aPosition)
   {
      $aPosition->leftTop->x +=
      ($this->calcXPosValue($this->endValues->value[$valueIndex]) -
      $aPosition->arrowFrom->x) / 2;
      $aPosition->leftTop->y += $aPosition->height / 2;
      parent::drawMark($valueIndex, $s, $aPosition);
   }

   public function prepareForGallery($isEnabled)
   {
      parent::prepareForGallery($isEnabled);
      $this->setColorEach($isEnabled);
      $this->point->setVertSize(3);
   }

   /*
   public function Add($view) {
   $labelField = -1;
   $colorField = -1;
   $tmpColor = new Color();
   $tmpColor = $tmpColor->EMPTY;
   $tmpLabel = "";

   $this->int[] $this->fields = new int[$this->ValuesLists->Count];

   $fieldCount = 0;
   $this->foreach(   $ValuesLists)
   if ($this->v->DataMember->length() != 0) {
   $this->fields[$ValuesLists->IndexOf($this->v)] = $view->Table->Columns->IndexOf($this->v->DataMember);
   $fieldCount++;
   }

   if ($this->labelMember->length() != 0) {
   $labelField = $view->Table->Columns->IndexOf($this->labelMember);
   }
   if ($this->colorMember->length() != 0) {
   $colorField = $view->Table->Columns->IndexOf($this->colorMember);
   }

   if ($fieldCount == $ValuesLists->Count - 1) {
   $this->foreach(   $view) {
   $r = $this->rv->Row;
   if ($colorField != -1) {
   $tmpColor = ($tmpColor) ($r[$colorField]);
   }
   if ($labelField != -1) {
   $tmpLabel = $this->Convert->ToString($r[$labelField]);
   }

   $this->foreach(   $ValuesLists) {
   $fieldIndex = $this->fields[$ValuesLists->IndexOf($this->v)];
   if ($r[$fieldIndex]  $DateTime) {
   $this->v->TempValue = $this->misc->Utils->DateTime(($this->System->DateTime) $r[
   $fieldIndex]);
   } else {
   $this->v->TempValue = $this->Convert->ToDouble($r[$fieldIndex]);
   }
   }

   $this->Add($this->XValues->TempValue, $this->endValues->TempValue, $this->YValues->TempValue,
   $tmpLabel, $tmpColor);
   }
   }
   }
   */
   /* TODO datetime
   public function add($start, $endDate, $y, $text="", $color=null) {
   if ($color == null) {
   $tmpColor = new Color(0,0,0);  //  // EMPTY COLOR BLACK
   }
   return $this->add($start->toDouble(), $endDate->toDouble(), $y, $text,
   $color);
   }
   */

   /**
   * Adds a new Gantt bar with start and end coordinates, label and color.
   *
   * @param start double
   * @param endDate double
   * @param y double
   * @param text String
   * @param color Color
   * @return int
   */
   public function addGantt($start, $endDate, $y, $text="", $color=null)
   {
      if($color == null)
      {
         $color = new Color(0, 0, 0, 0, true);// Black empty
      }

      $this->endValues->tempValue = $endDate;
      $this->nextTask->tempValue = -1;

      // TODO review temp or correct   ****  ****
//      $this->endValues->addChartValue($endDate);
//      $this->nextTask->addChartValue(-1);
//      ***** ****  TODO reivew

      return $this->addXYTextColor($start, $y, $text, $color);
   }

   /**
   * True if Series source is Gantt.<br>
   * It returns false if the Value parameter is the same as Self. <br>
   * It's used to validate DataSource both at design and run-time. <br>
   *
   * @param value Series
   * @return boolean
   */
   public function isValidSourceOf($value)
   {
      return $value instanceof Gantt;
   }

   /**
   * Returns the Maximum Value of the Series X Values List.
   *
   * @return double
   */
   public function getMaxXValue()
   {
      return max(parent::getMaxXValue(), $this->endValues->getMaximum());
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return $this->Language->getString("GalleryGantt");
   }
}
?>