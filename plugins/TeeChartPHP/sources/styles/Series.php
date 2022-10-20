<?php
 /**
 * Description:  This file contains the following class:<br>
 * Series class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Series class
 *
 * Description: The base class for all TeeChart Series styles
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class Series extends TeeBase implements ISeries /*, Cloneable*/
{
   // Private properties
   private $title="";
   private $updating;
   private $horizontalAxis;
   private $verticalAxis;
   private $customHorizAxis;
   private $customVertAxis;
   private $horizAxis;
   private $vertAxis;
   private $valuesList;
   private $zOrder;
   private $isMouseInside;
   private $iLabelOrder;
   private $depth;
   private $showInLegend = true;
   private $function;
   private $cursor;

   // Protected properties
   protected $mandatory;
   protected $notMandatory;
   protected $vxValues;
   protected $vyValues;
   protected $sLabels;
   protected $iColors;
   protected $bColorEach;
   protected $listenerList;
   protected $customMarkText;
   protected $bBrush;
   protected $bActive=true;
   protected $marks=null;
   protected $startZ;
   protected $middleZ;
   protected $endZ;
   protected $drawBetweenPoints=true;
   protected $yMandatory=true;
   protected $useSeriesColor=true;
   protected $calcVisiblePoints=true;
   protected $labelMember="";
   protected $colorMember="";
   protected $valueFormat;
   protected $percentFormat;
   protected $percentDecimal;
   protected $firstVisible;
   protected $lastVisible;
   protected $iNumSampleValues;

   // Public properties
   public $InternalUse;
   public $iZOrder;
   public $manualData = true;
   public $allowSinglePoint = true;
   /**
   * Returns True when the Series needs axes to display points.
   * For example, Pie Series returns False (it does not need axes).
   */
   public $useAxis = true;
   /**
   * Returns true if the series has ZValues.
   */
   public $hasZValues;
   /**
   * Constant field for internal use.
   */
   public static $AUTODEPTH = -1;
   /**
   * Constant field for internal use.
   */
   public static $AUTOZORDER = -1;


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

   public function __destruct()
   {        
       parent::__destruct();        
               
       unset($this->title);
       unset($this->updating);
       unset($this->horizontalAxis);
       unset($this->verticalAxis);
       unset($this->customHorizAxis);
       unset($this->customVertAxis);
       unset($this->horizAxis);
       unset($this->vertAxis);
       unset($this->valuesList);
       unset($this->zOrder);
       unset($this->isMouseInside);
       unset($this->iLabelOrder);
       unset($this->depth);
       unset($this->showInLegend);
       unset($this->function);
       unset($this->cursor);

       // Protected properties
       unset($this->mandatory);
       unset($this->notMandatory);
       unset($this->vxValues);
       unset($this->vyValues);
       unset($this->sLabels);
       unset($this->iColors);
       unset($this->bColorEach);
       unset($this->listenerList);
       unset($this->customMarkText);
       unset($this->bBrush);
       unset($this->bActive);
       unset($this->marks);
       unset($this->startZ);
       unset($this->middleZ);
       unset($this->endZ);
       unset($this->drawBetweenPoints);
       unset($this->yMandatory);
       unset($this->useSeriesColor);
       unset($this->calcVisiblePoints);
       unset($this->labelMember);
       unset($this->colorMember);
       unset($this->valueFormat);
       unset($this->percentFormat);
       unset($this->percentDecimal);
       unset($this->firstVisible);
       unset($this->lastVisible);
       unset($this->iNumSampleValues);
       unset($this->InternalUse);
       unset($this->iZOrder);
       unset($this->manualData);
       unset($this->allowSinglePoint);
       unset($this->useAxis);
       unset($this->hasZValues);
       unset($this->datasource);       
       
   }


   public function setMarkTextResolver($resolver)  {
      if($resolver != null)  {
         $this->customMarkText = $resolver;
      }
      else  {
         $this->removeMarkTextResolver();
      }
   }

   public function removeMarkTextResolver()  {
// TODO      $this->customMarkText = $this->MARKTEXT_RESOLVER;
   }

   public function addSeriesPaintListener($l)  {
      $this->listenerList->add($this->SeriesPaintListener->class , $l);
   }

   public function removeSeriesPaintListener($l)  {
      $this->listenerList->remove($this->SeriesPaintListener->class , $l);
   }

   protected function fireSeriesPaint($e)  {
      /* todo    $this->Object[] $this->listeners = $this->listenerList->getListenerList();
      for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
      if ($this->listeners[$i] == $this->SeriesPaintListener->class) {
      switch ($e->getDrawPart()) {
      //SERIES
      case 3: {
      $tmpChartDrawEvent = new ChartDrawEvent();
      if ($e->getID() == $tmpChartDrawEvent->PAINTING) {
      (($this->SeriesPaintListener) $this->listeners[$i + 1])->seriesPainting($e);
      } else if ($e->getID() == $tmpChartDrawEvent->PAINTED) {
      (($this->SeriesPaintListener) $this->listeners[$i + 1])->seriesPainted($e);
      }
      break;
      }
      }
      }
      }  */
   }

   public function addSeriesMouseListener($l)  {
      // todo   $this->listenerList->add($this->SeriesMouseListener->class, $l);
   }

   public function removeSeriesMouseListener($l)  {
      // todo    $this->listenerList->remove($this->SeriesMouseListener->class, $l);
   }

   protected function fireSeriesMouseEvent($se)  {
      /* todo    $this->Object[] $this->listeners = $this->listenerList->getListenerList();
      for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
      if ($this->listeners[$i] == $this->SeriesMouseListener->class) {
      switch ($se->getID()) {
      $tmpSeriesMouseEvent = new SeriesMouseEvent();
      case $tmpSeriesMouseEvent->SERIES_CLICKED: {
      (($this->SeriesMouseListener) $this->listeners[$i + 1])->seriesClicked($se);
      break;
      }
      case $tmpSeriesMouseEvent->SERIES_ENTERED: {
      (($this->SeriesMouseListener) $this->listeners[$i + 1])->seriesEntered($se);
      break;
      }
      case $tmpSeriesMouseEvent->SERIES_EXITED: {
      (($this->SeriesMouseListener) $this->listeners[$i + 1])->seriesExited($se);
      break;
      }
      }
      }
      }
      */
   }

   protected function doClickPointer($valueIndex, $x, $y)
   {
      $tmpSeriesMouseEvent = new SeriesMouseEvent();
      $this->fireSeriesMouseEvent(new SeriesMouseEvent($this, $tmpSeriesMouseEvent->SERIES_CLICKED, $valueIndex, new TeePoint($x, $y)));
   }

   protected function hasListenersOf($listener)  {
      /* todo    $this->Object[] $this->listeners = $this->listenerList->getListenerList();
      for ( $i = $this->listeners->length - 2; $i >= 0; $i -= 2) {
      if ($this->listeners[$i] == $listener) {
      return true;
      }
      }             */
      return false;
   }

   public function getHorizAxis() {
      return $this->horizAxis;
   }

   public function getVertAxis()  {
      return $this->vertAxis;
   }

   // Prevent instantiation
   public function __construct($c = null)  {
      $this->zOrder = self::$AUTOZORDER;
      $this->percentFormat=Texts::$DefPercentFormat;
      $this->valueFormat=Language::getString("DefValueFormat");
      $this->bBrush = new ChartBrush(null , new Color(0, 0, 0, 0, true));
      $this->horizontalAxis = HorizontalAxis::$BOTTOM;
      $this->verticalAxis = VerticalAxis::$LEFT;
      $this->depth = self::$AUTODEPTH;
      parent::__construct($c);

      $tmpColor = new Color(0, 0, 0, 0, true);
      $this->setColor($tmpColor);
      $this->checkValuesList();
      $this->vxValues = new ValueList($this, "ValuesX");// todo $this->Language->getString("ValuesX"));
      $this->vxValues->setOrder(ValueListOrder::$ASCENDING);
      $this->vyValues = new ValueList($this, "ValuesY");// todo $this->Language->getString("ValuesY"));
      $this->readResolve();

      if($this->chart != null)  {
         $this->bBrush->setChart($this->chart);
         $this->chart->addSeries($this);
         $this->added();
      }
   }

   public function getNotMandatory()  {
      return $this->notMandatory;
   }

   public function getMandatory()  {
      return $this->mandatory;
   }

   public function dispose() {
      if($this->function != null)  {
         $this->function->setSeries(null);
      }
      $this->setDataSource(null);
      $this->setChart(null);
   }

   /**
   * Creates a new series from the Class type of an existing series object.
   *
   * @param type Class
   * @return Series
   * @throws InstantiationException
   * @throws IllegalAccessException
   */
   public function newFromType($type)  {
      return(new $type($this->chart));
   }

   private function initMandatory()  {
      $this->mandatory = $this->vyValues;
      $this->notMandatory = $this->vxValues;
   }

   private function checkValuesList()  {
      if($this->valuesList == null) {
         $this->valuesList = new ValuesLists();
      }
   }

   protected function readResolve() {
      $this->checkValuesList();
      // TODO        $this->listenerList = new EventListenerList();
      // TODO        $this->customMarkText = $this->MARKTEXT_RESOLVER;
      $this->drawBetweenPoints = true;
      $this->yMandatory = true;
      $this->allowSinglePoint = true;
      $this->useAxis = true;
      $this->useSeriesColor = true;
      $this->calcVisiblePoints = true;
      $this->percentDecimal = Texts::$DefPercentFormat;
      $this->initMandatory();
      $this->recalcGetAxis();
      return $this;
   }

   /**
   * Creates a new Series object and sets the Name, Chart, Sub-Style and
   * Function methods.<br>
   * This is an internal method, you should seldomly use it in your
   * applications.
   *
   * @param chart IBaseChart
   * @param type Class
   * @param aFunction Class
   * @param subIndex int
   * @return Series
   * @throws InstantiationException
   * @throws IllegalAccessException
   */
   public function createNewSeries($chart, $type, $aFunction, $subIndex = 0)  {
      $result = Series::newFromType($type);
      $result->setChart($chart);

      if($aFunction != null) {
         $result->setFunction($aFunction->newInstance());
      }
      if($subIndex != 0) {
         $result->setSubGallery($subIndex);
      }
      return $result;
   }

   protected function doBeforeDrawValues() {
      /* TODO
      $tmpChartDrawEvent = new ChartDrawEvent();
      $this->fireSeriesPaint(new ChartDrawEvent($this, $tmpChartDrawEvent->PAINTING,
      $tmpChartDrawEvent->SERIES));*/
      
      $this->getChart()->parent->TriggerEvent('OnBeforeDrawValues', array($this));
   }

   protected function doAfterDrawValues() {
      /* TODO
      $tmpChartDrawEvent = new ChartDrawEvent();
      $this->fireSeriesPaint(new ChartDrawEvent($this, $tmpChartDrawEvent->PAINTED,
      $tmpChartDrawEvent->SERIES));*/
      
      $this->getChart()->parent->TriggerEvent('OnAfterDrawValues', array($this));
   }
   
   public function calcZOrder()  {
      if($this->zOrder == self::$AUTOZORDER) {
         if($this->chart->getAspect()->getView3D()) {
            $this->chart->setMaxZOrder($this->chart->getMaxZOrder() + 1);
            $this->iZOrder = $this->chart->getMaxZOrder();
         }
         else {
            $this->iZOrder = 0;
         }
      }
      else  {
         $this->chart->setMaxZOrder(max($this->chart->getMaxZOrder(), $this->getZOrder()));
      }
   }

   /**
   * Accesses the stored Color Array, if created, for the Series.<br>
   * When attaching new series to any Chart, setting TChart Series.SerieColor
   * to Color.EMPTY will make TeeChart assign a different color to each Series.
   * <br>
   * Some Series types allow Color.EMPTY in their Pen and Brushes properties,
   * thus forcing the use of the actual point color instead of the Pen or
   * Brush assigned color. <br>
   * Default value: null
   *
   * <p>Example:
   * <pre><font face="Courier" size="4">
   * candleSeries.add( ...., Color.Yellow );
   * candleSeries.getColors().setColor( 10, Color.Blue);
   * </font></pre></p>
   *
   * @see Series#getColorEach
   * @return ColorList
   */
   public function getColors() {
      if($this->iColors == null) {
         $this->iColors = new ColorList(($this->getCount() > 0) ? $this->getCount() :
         $this->ValueList->defaultCapacity);
      }
      return $this->iColors;
   }

   // For XMLEncoder only
   /**
   * Accesses the stored Color Array, if created, for the Series.<br>
   * Default value: null
   *
   * @see #getColors
   * @param value ColorList
   */
   public function setColors($value) {
      $this->iColors = $value;
   }

   /**
   * Point characteristics.
   *
   * @param index int
   * @return SeriesXYPoint
   */
   public function getPoint($index) {
      return new SeriesXYPoint($this, $index);
   }

   /**
   * Values defining horizontal point positions.<br>
   * By default, any Series has an XValues property. This is the IValueList
   * where the  point values will be stored at runtime. Also by default,
   * XValues is a Public method. Some derived Series publish it: Line series,
   * Bar series, Points series, etc. Some others publish it with another,
   * more friendly name: GanttSeries.StartValues, etc.  <br><br>
   * <b>WARNING: </b><br>
   * You <b>CAN NOT Delete, Clear or Add values DIRECTLY.</b> You need to
   * call the Series equivalent methods to do this.
   *
   * @return ValueList
   */
   public function getXValues() {
      return $this->vxValues;
   }

   // For XMLEncoder only
   public function setXValues($value)  {
      $this->vxValues = $value;
   }

   /**
   * Values defining vertical point positions.<br><br>
   * <b>WARNING: </b><br>
   * You <b>CAN NOT Delete, Clear or Add values DIRECTLY.</b> You need to
   * call the Series equivalent methods to do this.
   *
   * @return ValueList
   */
   public function getYValues()  {
      return $this->vyValues;
   }

   // For XMLEncoder only
   public function setYValues($value)  {
      $this->vyValues = $value;
   }

   /**
   * Copies all properties from one Series component to another.<br>
   * Only the common properties shared by both source and destination Series
   * are copied. <br>
   * The following code copies all properties from Series2 into Series1:
   * <br><br>
   * Series1.Assign( Series2 ) ;<br><br>
   * Some Series types restore method values after assigning them. For
   * example, Points series restores the Pointer.Visible method to true after
   * being assigned to a Line series, which has Pointers invisible by default.
   * <br>
   * <b>Note:</b> Series events are not assigned.  Series DataSource and
   * FunctionType properties are assigned.  Assign is used by
   * CloneChartSeries and ChangeSeriesType methods for example.
   *
   * @param source Series
   */
   public function assign($source)  {
      // AssignCommonProperties(source);
      $this->title = $source->title;
      $this->bBrush->assign($source->bBrush);
      $this->bColorEach = $source->bColorEach;
      $this->showInLegend = $source->showInLegend;
      $this->valueFormat = $source->valueFormat;
      $this->percentFormat = $source->percentFormat;
      $this->percentDecimal = $source->percentDecimal;
      $this->bActive = $source->bActive;

      if($this->datasource == null) {
         $this->assignValues($source);
      }
      $this->checkDataSource();
   }

   public function getAllowSinglePoint()  {
      return $this->allowSinglePoint;
   }

   public function assignDispose($s, $newSeries) {

      $index = $s->chart->getSeriesIndexOf($s);
      $newSeries->assign($s);
      $s->dispose();
      $s = $newSeries;
      $s->chart->moveSeriesTo($s, $index);
      return $s;
   }

   /**
   * Replaces ASeries object with a new Series object of another class.
   *
   * @param s Series
   * @param newType Class
   * @return Series
   * @throws InstantiationException
   * @throws IllegalAccessException
   */
   public function changeType($s, $newType)  {
      if($s->get_class() != $newType)  {
         // Only if different classes
         $newSeries = $this->createNewSeries($s->chart, $newType, null);
         if($newSeries != null)  {
            $s = Series::assignDispose($s, $newSeries);
         }
      }
      return $s;
   }

   /**
   * Returns the steema.teechart.styles.ValuesLists object of the series.<br>
   * It permits access to the list of TeeChartValueLists of a Series. <br>
   * Several standard Series types such as TLineSeries and  TBarSeries
   * maintain 2 ValueLists, X and Y values. Other Series such as TCandleSeries
   * maintain more lists, ie. DateValues, OpenValues, HighValues, LowValues
   * and CloseValues.
   *
   * @see com.steema.teechart.styles.ValuesLists
   * @return ValuesLists
   */
   public function getValuesLists() {
      return $this->valuesList;
   }

   public function valuesListAdd($value)  {
      $this->checkValuesList();
      $this->valuesList[] = $value;
   }

   //Returns if a Series has "X" values (or Y values for non-vertical series like HorizBar)
   public function hasNoMandatoryValues()  {
      if(/* $this->iUseNotMandatory && */($this->getCount() > 0))  {
         $tmp = $this->getNotMandatory();
         if(($tmp->getFirst() == 0) && ($tmp->getLast() == $this->getCount() - 1))  {
            $tmpCount = min(10000, $this->getCount());
            for($t = 0; $t < $tmpCount; $t++)  {
               if($tmp->getValue($t) != $t)  {
                  return true;
               }
            }
         }
         else  {
            return true;
         }
      }
      return false;
   }

   /**
   * Returns the URL of the associated bitmap icon for a given Series class.<br>
   * This icon is used at ChartListBox and Series Editor dialog.
   *
   * @return URL
   */
   public function getBitmapEditor()  {
      $name = $this->get_class();
      $name = "icons/" + substr($name,substr($name(0,'->') + 1) + "->gif",0);
      return $this->Series->class ->getResource($name);
   }

   /**
   * Returns the value list that the AListName parameter has.
   *
   * @param aListName String
   * @return ValueList
   */
   public function getYValueList($aListName)  {
      $aListName = $aListName->toUpperCase();
      for($t = 2; $t < sizeof($this->valuesList); $t++)  {
         if($aListName->equals($this->valuesList->getValueList($t)->name->toUpperCase()))  {
            return $this->valuesList->getValueList($t);
         }
      }
      return $this->vyValues;
   }

   /**
   * Specifies the custom horizontal axis for the series.<br>
   * After adding a new horizontal Custom Axis to a Chart, use
   * CustomHorizAxis to associate the Series to the Custom Axis. <br>
   * Together with the axis PositionPercent and "stretching" methods, it's
   * possible to have unlimited axes floating anywhere on the chart. <br>
   * Scroll, zoom, and axis hit-detection also apply to custom-created axes.<br>
   * Creating extra axes is only allowed at run-time, as a few lines of code
   * are necessary.<br>
   * Default value: null
   *
   * @return Axis
   */
   public function getCustomHorizAxis()  {
      return $this->customHorizAxis;
   }

   /**
   * Specifies the custom horizontal axis for the series.<br>
   * Default value: null
   *
   * @param value Axis
   */
   public function setCustomHorizAxis($value)  {
      $this->customHorizAxis = $value;
      $this->horizontalAxis = ($value != null) ? HorizontalAxis::$CUSTOM :
      HorizontalAxis::$BOTTOM;
      $this->recalcGetAxis();
      $this->repaint();
   }

   /**
   * Specifies the custom horizontal axis for the series.<br>
   * Default value: null
   *
   * @param value int
   */
   public function setCustomHorizAxisValue($value)  {
      if($this->getChart() != null)  {
         $tmp = $this->getChart()->getAxes()->getCustom();
         $this->setCustomHorizAxis($tmp->getAxis($value));
      }
   }

   /**
   * Specifies the custom vertical axis for the series.<br>
   * Default value: null
   *
   * @return Axis
   */
   public function getCustomVertAxis()  {
      return $this->customVertAxis;
   }

   /**
   * Specifies the custom vertical axis for the series.<br>
   * Default value: null
   *
   * @param value int
   */
   public function setCustomVertAxisValue($value)  {
      if($this->getChart() != null)  {
         $tmp = $this->getChart()->getAxes()->getCustom();
         $this->setCustomVertAxis($tmp->getAxis($value));
      }
   }

   /**
   * Specifies the custom vertical axis for the series.<br>
   * Default value: null
   *
   * @param value Axis
   */
   public function setCustomVertAxis($value)  {
      $this->customVertAxis = $value;
      $this->verticalAxis = ($value != null) ? VerticalAxis::$CUSTOM :
      VerticalAxis::$LEFT;
      $this->recalcGetAxis();
      $this->repaint();
   }

   /**
   * Accesses a list of series point labels.
   *
   * @return StringList
   */
   public function getLabels()  {
      if($this->sLabels == null)
         $this->sLabels = Array();

      return $this->sLabels;
   }

   /**
   * Accesses a list of series point labels.
   *
   * @param value StringList
   */
   public function setLabels($value)  {
      $this->sLabels = $value;
   }

   /**
   * The the Datasource Label Field.<br>
   * Default value: ""
   *
   * @return String
   */
   public function getLabelMember()  {
      return $this->labelMember;
   }

   /**
   * Sets the Datasource Label Field.<br>
   * Default value: ""
   *
   * @param value String
   */
   public function setLabelMember($value)  {
      if(!$this->labelMember->equals($value))  {
         $this->labelMember = $value;
         $this->checkDataSource();
      }
   }

   /**
   * The the Datasource Color Field.<br>
   * Default value: ""
   *
   * @return String
   */
   public function getColorMember()  {
      return $this->colorMember;
   }

   /**
   * Sets the Datasource Color Field.<br>
   * Default value: ""
   *
   * @param value String
   */
   public function setColorMember($value)  {
      if(!$this->colorMember->equals($value))  {
         $this->colorMember = $value;
         $this->checkDataSource();
      }
   }

   /**
   * Returns the number of pixels for horizontal margins
   *
   * @param margins Margins
   */
   public function calcHorizMargins($margins)  {
      $margins->min = 0;
      $margins->max = 0;// abstract
   }

   /**
   * Returns the number of pixels for vertical margins
   *
   * @param margins Margins
   */
   public function calcVerticalMargins($margins)  {
      $margins->min = 0;
      $margins->max = 0;// $this->abstract
   }

   public function galleryChanged3D($is3D)  {
      $this->chart->getAspect()->setView3D($is3D);
   }

   /**
   * Draws the Series "Legend" on the specified rectangle and Graphics.
   *
   * @param g Graphics
   * @param r Rectangle
   */
   protected function paintLegend($g, $r)  {
      $tmpChart = null;
      if($this->chart == null)  {
         //            tmpChart = new Chart();
         //            tmpChart.setAutoRepaint(false);
         //            setChart(tmpChart);
      }
      else  {
//  TODO remove old     $this->chart->setAutoRepaint(false);
      }

      //   try {
      //Graphics3D g3d = new Graphics3D(chart);
      //g3d.g = g;
      //DrawLegend(g3d, -1, r);
      //    } finally {
      if($this->chart == $tmpChart)  {
         $this->setChart(null);
         //tmpChart.dispose();
      }
      else  {
//  TODO remove old       $this->getChart()->setAutoRepaint(true);
      }
      //   }
   }

   public function getUseAxis()  {
      return $this->useAxis;
   }

   public function associatedToAxis($a)  {
      return $this->useAxis && (
      ($a->getHorizontal() &&
      (($this->horizAxis === $a) ||
      ($this->horizontalAxis == HorizontalAxis::$BOTH))) ||
      ((!$a->getHorizontal()) &&
      (($this->vertAxis === $a) ||
      ($this->verticalAxis == VerticalAxis::$BOTH)))
      );
   }

   /**
   * Returns a new Series, copy of this original.<br>
   * It returns the SeriesIndex of the new Series.
   *
   * @return Series
   * @throws InstantiationException
   * @throws IllegalAccessException
   */
   public function cloneSeries()
   {
      return $this->cloneS();
   }

   public function cloneS()  {
      $tmp = null;

      if($this->getFunction() != null)  {
         $tmp = $this->getFunction()->get_class();
      }

      try  {
         $result = $this->Series->createNewSeries($this->chart, $this->get_class(), $tmp);

         // result.Assign(this);
         // add values to --> result
         // if DataSource is not null, values are already added in Assign.
         // if (result.DataSource==null)

         $result->assignValues($this);
         return $result;

      }
      catch(Exception $ex) {
         return null;
      }
   }

   /**
   * Adds all Values from Source seriesto the current Series.
   *
   * @param source Series
   */
   public function assignValues($source) {
      $a = new ArrayList();
      $a->add($source);
      $this->addValues($a);
   }

   protected function addChartValue($source, $valueIndex)  {
      $tmpX = $source->getXValues()->value[$valueIndex];
      $tmpY = $source->getYValues()->value[$valueIndex];

      // if we are adding values from (for example) an Horizontal Bar series...
      if($this->yMandatory != $source->yMandatory) {
         $tmp = $tmpX;
         $tmpX = $tmpY;
         $tmpY = $tmp;
      }

      // pending: if ...FY.Order<>loNone then (inverted)

      $result = $this->vxValues->addChartValue($tmpX);
      $this->getYValues()->insertChartValue($result, $tmpY);

      // rest of lists...
      $listsCount = sizeof($this->valuesList);
      if($listsCount > 2)  {
         $tmp = sizeof($source->valuesList) - 1;
         for($t = 2; $t < $listsCount; $t++) {
            $tmpY = ($t <= $tmp) ?
            $source->valuesList->getValueList($t)->value[$valueIndex] : 0;
            $this->valuesList->getValueList($t)->insertChartValue($result, $tmpY);
         }
      }

      return $result;
   }

   // Called when a new value is added to the series.
   private function addedValue($source, $valueIndex)
   {
      $tmpIndex = $this->addChartValue($source, $valueIndex);

      if($source->iColors != null)
      {
         $this->getColors()->setColor($tmpIndex,
         $source->getColors()->getColor($valueIndex));         
      }      

      if($source->sLabels != null)
      {
         $this->sLabels[$tmpIndex]=$source->sLabels[$valueIndex];
      }

      $this->notifyNewValue($this, $tmpIndex);      
   }

   // This method is called whenever the series points are added,
   // deleted, modified, etc.
   // DB : NOT sure to include it.
   private function notifyValue($valueIndex)
   {
      /*
      if (IUpdating==0)
      foreach (Series s in linkedSeries )
      switch (ValueEvent) {
      case veClear  : if (rOnClear in recalcOptions) clear();
      case veDelete : if (rOnDelete in recalcOptions )
      if (FunctionType==null) DeletedValue(this,valueIndex);
      case veAdd    : if (rOnInsert in recalcOptions)
      if (FunctionType==null) AddedValue(this,valueIndex);
      case veModify : if (rOnModify in recalcOptions) AddValues(this);
      case veRefresh: AddValues(this);
      }
      */
   }

   public function mouseEvent($e, $c)
   {
      return $c;
   }

   // Triggers the OnAfterAdd event when a new point is added.
   // DB : Not sure to include it in NET.
   private function notifyNewValue($sender, $valueIndex)
   {
      /*
      if (OnAfterAdd!=null) OnAfterAdd(sender,valueIndex);
      NotifyValue(veAdd,valueIndex);
      */
      if($this->bActive)
      {
         $this->repaint();
      }
   }

   // Allocates memory for the ALabel String parameter and inserts it
   // into the labels list.
   private function insertLabel($valueIndex, $text)
   {
      if($text->length() != 0)
      {
         $tmp = $this->getLabels();
         $tmp[$valueIndex]=$text;
      }
   }

   private function addValuesFrom($source)
   {
      if($this->isValidSourceOf($source))
      {
         $this->beginUpdate();// $this->before $this->clear
         $this->clear();

         if($this->getFunction() == null)
         {// "Copy $this->Function", $this->copy $this->values->->->

            if($this->yMandatory != $source->yMandatory)
            {//  $Dec03 //#1274
               $this->getXValues()->setDateTime($source->getYValues()->getDateTime());
               $this->getYValues()->setDateTime($source->getXValues()->getDateTime());
            }
            else
            {
               $this->getXValues()->setDateTime($source->getXValues()->getDateTime());
               $this->getYValues()->setDateTime($source->getYValues()->getDateTime());
            }

            $sourceCount = $source->getCount();
            for($t = 0; $t < $sourceCount; $t++)
            {
               $this->addedValue($source, $t);
            }

         }
         else
         {
            $this->getXValues()->setDateTime($source->getXValues()->getDateTime());
            $this->getYValues()->setDateTime($source->getYValues()->getDateTime());
            $list = Array();
            $list[]=$source;
            $this->getFunction()->addPoints($list);// $this->calculate $this->function
         }

         $this->endUpdate();// $this->propagate $this->changes->->->
      }
   }

   /**
   * Recalculates all dependent Series points again.<br>
   * Each Series has a DataSource method. When DataSource is a valid Series
   * or DataSet component, Series get all point values from the DataSource
   * and adds them as Series points. The RefreshSeries method forces the
   * Series to Clear and get all points again from the DataSource component.
   * The Refreshing process traverses the Series tree recursively.
   */
   public function refreshSeries()
   {
      if($this->chart != null)
      {
         for($t = 0; $t < $this->chart->getSeriesCount(); $t++)
         {
            $s = $this->chart->getSeries($t);
            if($s->hasDataSource($this))
            {
               $s->checkDataSource();
            }
         }
      }
   }

   /**
   * Recalculates the function just one time, when finished adding points.
   */
   public function beginUpdate()
   {
      $this->updating++;
   }

   /**
   * Recalculates the function just one time, when finished adding points.
   */
   public function endUpdate()
   {
      $this->updating--;
      if($this->updating == 0)
      {
         $this->refreshSeries();
         $this->invalidate();
      }
   }

   // Clears and adds all points values from "source" ArrayList of Series.
   protected function addValues($source)
   {
      $s = $source[0];

      if($this->isValidSourceOf($s))
      {
         $this->beginUpdate();// $this->before $this->Clear
         $this->clear();

         if($this->function == null)
         {
            // "Copy Function", copy values...
            if($this->yMandatory != $s->yMandatory)//  $Dec03 #1274
            {
               $this->vxValues->dateTime = $s->vyValues->dateTime;
               $this->vyValues->dateTime = $s->vxValues->dateTime;
            }
            else
            {
               $this->vxValues->dateTime = $s->vxValues->dateTime;
               $this->vyValues->dateTime = $s->vyValues->dateTime;
            }

            $this->addValuesFrom($s);
         }
         else
         {
            $this->vxValues->dateTime = $s->vxValues->dateTime;
            $this->vyValues->dateTime = $s->vyValues->dateTime;
            $this->function->addPoints($source);// $this->calculate $this->function
         }

         $this->endUpdate();
      }
   }

   public function setColorEach($value)
   {
      $this->bColorEach = $this->setBooleanProperty($this->bColorEach, $value);

      if(!$this->bColorEach)
      {
         for($t = 0; $t < $this->getCount(); $t++)
         {
            if($this->isNull($t))
            {
               return;
            }
         }
         $this->iColors = null;
         $this->invalidate();
      }
   }

   public function dataSourceArray()
   {
      if($this->datasource instanceof ArrayList)
      {
         $this->a = $this->datasource;
         if($this->a->get(0)instanceof $Series)
         {
            $this->result = new ArrayList();
            for($t = 0; $t < $this->a->size(); $t++)
            {
               $this->result->add($this->a->get($t));
            }

            return $this->result;
         }
      }
      /* ??? repeated from above, except above code returns a duplicated array
      else
      if (datasource instanceof ArrayList) {
      ArrayList a = (ArrayList) datasource;
      if (a.get(0) instanceof Series) {
      return a;
      }
      }
      */
      else
         if($this->datasource instanceof Series)
         {
            $result =Array();
            $result[]=$this->datasource;
            return $result;
         }/* TODOelse
      if ($this->datasource instanceof Series[]) {
      $tmp = $this->datasource;
      $result = new ArrayList();
      for ( $t = 0; $t < $tmp->length; $t++) {
      $result->add($tmp[$t]);
      }
      return $result;
      }        */

      return null;
   }

   public function hasDataSource($source)
   {
      if($this->datasource == null)
      {
         return false;
      }
      else
      {
         if($this->datasource === $source)
         {
            return true;
         }

         $a = $this->dataSourceArray();
         if($a == null)
         {
            return false;
         }
         else
         {
            return in_array($source, $a,true);
         }
      }
   }

   public function doDoubleClick($valueIndex, $e)
   {
      $tmpSeriesMouseEvent = new SeriesMouseEvent();
      $this->fireSeriesMouseEvent(new SeriesMouseEvent($this, $tmpSeriesMouseEvent->SERIES_CLICKED, $valueIndex, $e));
   }

   public function doClick($valueIndex, $e)
   {
      $tmpSeriesMouseEvent = new SeriesMouseEvent();
      $this->fireSeriesMouseEvent(new SeriesMouseEvent($this, $tmpSeriesMouseEvent->SERIES_CLICKED, $valueIndex, $e));
   }

   /**
   * Draws points with different preset Colors.<br>
   * If false, all points will be drawn using the Series Series.Color color
   * method.<br> If true, each Series point will be "colored" with its
   * corresponding point color. The point colors are stored in the
   * Series.PointColor array. If a point has an Color.Empty color value,
   * then a TeeChart determined, available color value will be used to draw
   * it.<br>
   * Default value: false
   *
   * @return boolean
   */
   public function getColorEach()
   {
      return $this->bColorEach;
   }

   public function getCountLegendItems()
   {
      return $this->getCount();
   }

   /**
   * For internal use.
   *
   * @return int
   */
   public function getNumGallerySeries()
   {
      return 2;
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return "";
   }

   private function calcMinMaxValue($a, $b, $c, $d)
   {
      $axis = $this->yMandatory ? $this->horizAxis : $this->vertAxis;
      if($this->yMandatory)
      {
         return $axis->getInverted() ? $axis->calcPosPoint($c) :
         $axis->calcPosPoint($a);
      }
      else
      {
         return $axis->getInverted() ? $axis->calcPosPoint($b) :
         $axis->calcPosPoint($d);
      }
   }

   /**
   * Returns if this series is Visible.<br>
   *
   * @return boolean
   */
   public function getVisible()
   {
      return $this->bActive;
   }

   /**
   * An alias to Active property.  <br>
   * Shows or Hides the component.
   *
   * @param value boolean
   */
   public function setVisible($value)
   {
      $this->setActive($value);
   }

   /**
   * Returns the corresponding X value of a Screen position between Axis
   * limits.<br>
   * The Screen position must be between Axis limits.
   *
   * @param screenPos int
   * @return double
   */
   public function xScreenToValue($screenPos)
   {
      return $this->horizAxis->calcPosPoint($screenPos);
   }

   /**
   * Returns the corresponding Y value of a Screen position between Axis
   * limits.<br>
   * The resulting Value is based on the Series.GetVertAxis.
   *
   * @param screenPos int
   * @return double
   */
   public function yScreenToValue($screenPos)
   {
      return $this->vertAxis->calcPosPoint($screenPos);
   }

   public function prepareForGallery($isEnabled)
   {
      $this->fillSampleValues(4);
      $this->getMarks()->setVisible(false);
      $this->getMarks()->getFont()->setSize(7);
      $this->getMarks()->setArrowLength(4);
      $this->getMarks()->setDrawEvery(2);
      $this->getMarks()->getCallout()->setLength(4);

      $this->setColorEach(false);

      if($isEnabled)
      {
         if($this->chart->getSeriesIndexOf($this) == 0)
         {
            $tmpColor = new Color();
            $this->setColor($tmpColor->RED);
         }
         else
         {
            $this->setColor($tmpColor->BLUE);
         }
      }
      else
      {
         $this->setColor($tmpColor->SILVER);
      }
   }

   protected function prepareLegendCanvas($g, $valueIndex, $backColor, $aBrush)
   {
   }

   protected function drawLegendShape($g, $valueIndex, $rect)
   {
      $g->rectangle($rect);/* <-- $this->rectangle */
      if($g->getBrush()->getForegroundColor() == $this->chart->getLegend()->getColor())
      {
         /* <-- color conflict ! */
         $oldColor = $g->getPen()->getColor();
         if($g->getBrush()->getForegroundColor() == new Color(0,0,0))
         {
            $g->getPen()->setColor(new Color(255,255,255));
         }
         $g->getBrush()->setVisible(false);
         $g->rectangle($rect);/* <--  $rectangle */
         $g->getPen()->setColor($oldColor);
      }                       
   }

   public function legendItemColor($index)
   {
      return $this->getValueColor($index);
   }

   public function drawLegend($g = null , $valueIndex, $rect)
   {
      if($g == null)
         $g = $this->chart->getGraphics3D();

      if(($valueIndex != - 1) || (!$this->getColorEach()))
      {
         // set pen
         $g->setPen($this->chart->getLegend()->getSymbol()->getPen());

         // set brush color
         $tmpColor = ($valueIndex == - 1) ?
         $this->getColor() : $this->legendItemColor($valueIndex);

         $g->getBrush()->setColor($tmpColor);

         // if not empty brush...
         if (!$tmpColor->isEmpty()) {
             // set background color and style
             $tmpBack = $this->chart->getLegend()->getColor();
             $tmpStyle = new ChartBrush($this->chart);
             $tmpStyle->assign($this->bBrush);
             $this->prepareLegendCanvas($g, $valueIndex, $tmpBack, $tmpStyle);
             // After calling PrepareLegendCanvas, set custom symbol pen, if any...
             if($this->chart->getLegendPen() != null)
                $g->setPen($this->chart->getLegendPen());

             // if back color is "default", use Legend back color
             if($tmpBack->isEmpty())
             {
                $tmpBack = $this->chart->getLegend()->getColor();
                if($tmpBack->isEmpty())
                   $tmpBack = $this->chart->getPanel()->getColor();
             }

             //force the use of TILED imagemode, so image always fits the legendshape boundary
             $tmpStyle->setImageMode(ImageMode::$TILE);
             
             $this->chart->setBrushCanvas($g->getBrush()->getColor(), $tmpStyle, $tmpBack);

             // draw shape
             $this->drawLegendShape($g, $valueIndex, $rect);
         }
      }
   }

   public function calcFirstLastVisibleIndex()
   {

      $this->firstVisible = -1;
      $this->lastVisible = -1;

      if($this->getCount() > 0)
      {
         $tmpLastIndex = $this->getCount() - 1;

         if($this->calcVisiblePoints &&
         ($this->notMandatory->getOrder() != ValueListOrder::$NONE))
         {

            /* NOTE:
            The code below does NOT use a "divide by 2" (bubble)
            algorithm because the tmpMin value might not have any
            correspondence with a Series point.
            When the Series point values are "floating" (not int)
            the "best" solution is to do a lineal all-traverse search.
            However, this code can still be optimized.
            It will be revisited for next coming releases.

            */

            $r = $this->chart->getChartRect();

            $tmpMin = $this->calcMinMaxValue($r->x, $r->y, $r->getRight(),
            $r->getBottom());

            $this->firstVisible = 0;
            while($this->notMandatory->value[$this->firstVisible] < $tmpMin)
            {
               $this->firstVisible++;
               if($this->firstVisible > $tmpLastIndex)
               {
                  $this->firstVisible = -1;
                  break;
               }
            }

            if($this->firstVisible >= 0)
            {
               $tmpMax = $this->calcMinMaxValue($r->getRight(), $r->getBottom(),
               $r->x,
               $r->y);

               if($this->notMandatory->getLast() <= $tmpMax)
               {
                  $this->lastVisible = $tmpLastIndex;
               }
               else
               {
                  $this->lastVisible = $this->firstVisible;
                  while($this->notMandatory->value[$this->lastVisible] <
                  $tmpMax)
                  {
                     $this->lastVisible++;
                     if($this->lastVisible > $tmpLastIndex)
                     {
                        $this->lastVisible = $tmpLastIndex;
                        break;
                     }
                  }

                  if((!$this->drawBetweenPoints) &&
                  ($this->notMandatory->value[$this->lastVisible] > $tmpMax))
                  {
                     $this->lastVisible--;
                  }
               }
            }
         }
         else
         {
            $this->firstVisible = 0;
            $this->lastVisible = $tmpLastIndex;
         }
      }
   }

   /**
   * Returns the length in pixels of the longest Mark text.
   *
   * @return int
   */
   public function maxMarkWidth()
   {
      $tmpResult = 0;
      $count = $this->getCount();
      for($t = 0; $t < $count; $t++)
      {
         $tmpResult = max($tmpResult, $this->getMarks()->textWidth($t));
      }
      return $tmpResult;
   }

   /**
   * Returns corresponding Point value suitable for displaying at Series
   * Marks.
   *
   * @param valueIndex int
   * @return double
   */
   public function getMarkValue($valueIndex)  {
      return $this->mandatory->value[$valueIndex];
   }

   private function formatValue($value)  {
       $LOCALE = localeconv();       
                                  
       try { // CDI TF02010053
            if (fmod((double)$value,1)!=0) {
              if ($LOCALE['frac_digits'] != $this->valuesDecimal)
                $decimals=$this->valuesDecimal;
              else
                $decimals=$LOCALE['frac_digits'];
            }
            else
              $decimals=0;

            $tmpResult = number_format($value,$decimals,
                $LOCALE['decimal_point'],
                $LOCALE['thousands_sep']);

            if ($tmpResult=='-0') {
                $tmpResult='0';
            }

        } catch (Exception $e) {
            $tmpResult = number_format($value, $decimals,
                $LOCALE['decimal_point'],
                $LOCALE['thousands_sep']);
        }
        
        return $tmpResult;                
   }

   private function labelOrValue($valueIndex)  {
      $tmpResult = ($this->sLabels == null) ? "" :
      $this->sLabels[$valueIndex];
      if(strlen($tmpResult) == 0)  {
         $tmpResult = $this->formatValue($this->getMarkValue($valueIndex));
      }
      return $tmpResult;
   }

   private function getAXValue($valueIndex)  {
      if(!($this->horizAxis == null))  {
         if($this->vxValues->getDateTime())  {
            try  {
               if($this->horizAxis->getLabels()->getDateTimeFormat()->equals(""))  {
                  /* tODO    $result = new DateTime($this->vxValues->value[$valueIndex])->
                  $this->toString(
                  $this->horizAxis->
                  $this->dateTimeDefaultFormat(
                  $this->horizAxis->getRange()));*/
               }
               else  {
                  /* TODO    $result = new DateTime($this->vxValues->
                  $this->value[$valueIndex])->toString(
                  $this->horizAxis->getLabels()->
                  $this->getDateTimeFormat());*/
               }
            }
            catch(Exception $e)  {
               /*todo   $result = (new DecimalFormat($this->Language->getString("DefValueFormat")))->format(
               $this->vxValues->value[$valueIndex]);*/
            }
            return $result;
         }
         else  {
            return $this->formatValue($this->vxValues->value[$valueIndex]);
         }
      }
      else  {
         return $this->horizAxis->getLabels()->labelValue(
         $this->vxValues->value[$valueIndex]);
      }
   }

   private function getAYValue($valueIndex)  {
      return $this->formatValue($this->getMarkValue($valueIndex));
   }

   /**
   * Returns the String corresponding to the Series Mark text
   * for a given ValueIndex point.<br>
   * The Mark text depends on the Marks.Style method.<br>
   *
   * @param valueIndex int
   * @return String
   */
   public function getMarkText($valueIndex)  {
      $tmp = $this->marks->getMultiLine() ? Language::getString("LineSeparator") : " ";

      if($this->marks->getStyle() == MarksStyle::$VALUE)  {
         $tmpResult = $this->getAYValue($valueIndex);
      }
      else
         if($this->marks->getStyle() == MarksStyle::$PERCENT)  {
            $tmpResult = $this->marks->percentString(
            $valueIndex, false);
         }
         else
            if($this->marks->getStyle() == MarksStyle::$LABEL)  {
               $tmpResult = $this->labelOrValue($valueIndex);
            }
            else
               if($this->marks->getStyle() == MarksStyle::$LABELPERCENT)  {
                  $tmpResult = $this->labelOrValue($valueIndex) +
                  $tmp +
                  $this->marks->percentString($valueIndex, false);
               }
               else
                  if($this->marks->getStyle() == MarksStyle::$LABELVALUE)  {
                     $tmpResult = $this->labelOrValue($valueIndex) +
                     $tmp + $this->getAYValue($valueIndex);
                  }
                  else
                     if($this->marks->getStyle() == MarksStyle::$LEGEND) {
                        $tmpResult = $this->chart->formattedValueLegend($this,
                        $valueIndex);
                     }
                     else
                        if($this->marks->getStyle() == MarksStyle::$PERCENTTOTAL)  {
                           $tmpResult = $this->marks->percentString($valueIndex, true);
                        }
                        else
                           if($this->marks->getStyle() == MarksStyle::$LABELPERCENTTOTAL)  {
                              $tmpResult = $this->labelOrValue($valueIndex) +
                              $tmp +
                              $this->marks->percentString($valueIndex, true);
                           }
                           else
                              if($this->marks->getStyle() == MarksStyle::$XVALUE)  {
                                 $tmpResult = $this->getAXValue($valueIndex);
                              }
                              else
                                 if($this->marks->getStyle() == MarksStyle::$XY)  {
                                    $tmpResult = $this->getAXValue($valueIndex) +
                                    $tmp + $this->getAYValue($valueIndex);
                                 }
                                 else {
                                    $tmpResult = "";
                                 }

        // TODO       return $this->customMarkText->getMarkText($valueIndex, $tmpResult);
        return $tmpResult;
   }
   
	private $defaultNull = 0.0;

	/**
	 * Sets or returns the value to be used as a null value within the series.
	 * 
	 * @param value
	 *            double
	 */
	public function getDefaultNullValue() {
		return $this->defaultNull;
	}

	public function setDefaultNullValue($value) {
		$this->defaultNull = $value;
	}
	   

   /**
   * Returns the String representation of a Index point used to draw the Mark.
   *
   * @param index int
   * @return String
   */
   public function getValueMarkText($index)  {
      return $this->getMarkText($index);
   }

   /**
   * Forces the Chart to Repaint.<br>
   * You don't normally call Repaint directly. It can be used within derived
   * TChartSeries components when changing their properties internally .
   */
   public function repaint()  {
      $this->invalidate();
   }

   /**
   * Returns True when the tmpSeries parameter is of the same class.
   *
   * @param s ISeries
   * @return boolean
   */
   protected function sameClass($s)  {
      return get_class($this) == get_class($s);
   }

   /**
   * Sorts all points in the series using the Labels (texts) list.<br><br>
   * <b>Note:</b> non-mandatory values (X) are modified (they are not
   * preserved).
   *
   * @param order ValueListOrder
   */
   /* TODO   public function sortByLabels($order) {
   if ($order != ValueListOrder::$NONE) {
   $this->iLabelOrder = $order;

   $this->Utils->sort(
   0,
   $this->getCount() - 1,
   new Comparator() {
   public function compare($a, $b) {
   $result = $this->getLabels()->getString($a)->compareTo($this->getLabels()->
   $this->getString($b));
   return ($this->iLabelOrder == ValueListOrder::$DESCENDING) ? -$result :
   $result;
   }
   },
   $this->getValueIndexSwapper()
   );

   $this->iLabelOrder = ValueListOrder::$NONE;
   $this->notMandatory->fillSequence(); //    $values ( $them)
   $this->invalidate();
   }
   }

   public function sortByLabels() {
   $this->sortByLabels(ValueListOrder::$ASCENDING);
   }   */

   /**
   * For internal use.
   *
   * @return int
   */
   public function getStartZ()  {
      return $this->startZ;
   }

   public function setStartZ($value)  {
      $this->startZ = $value;
   }

   /**
   * For internal use.
   *
   * @return int
   */
   public function getMiddleZ()  {
      return $this->middleZ;
   }

   public function setMarks($value)  {
      $this->marks = $value;
   }

   public function setMiddleZ($value)  {
      $this->middleZ = $value;
   }

   public function setZPositions()  {
      $w = $this->getChart()->getSeriesWidth3D();
      $this->setStartZ($this->iZOrder * $w);

      if($this->getDepth() == self::$AUTODEPTH)  {
         $this->setEndZ($this->getStartZ() + $w);
      }
      else  {
         $this->setEndZ($this->getStartZ() + $this->getDepth());
      }

      $this->setMiddleZ(($this->getStartZ() + $this->getEndZ()) / 2);

      if($this->marks != null)  {
         $this->marks->setZPosition($this->getMiddleZ());
      }
   }

   /**
   * For internal use.
   *
   * @return int
   */
   public function getEndZ() {
      return $this->endZ;
   }

   public function setEndZ($value)  {
      $this->endZ = $value;
   }

   /**
   * Determines the Format to display point values.<br>
   * It specifies the desired formatting string to be applied to Axis Labels.
   * It has effect when Axis associated Series have their XValues.DateTime
   * or YValues.DateTime is set to false. <br>
   * For DateTime Axis labels use AxisLabels.DateTimeFormat. <br>
   * ValueFormat is a standard formatting string specifier. <br>
   * Chart Axis uses it to draw the axis labels. <br>
   * Chart Series uses it to draw the Marks. <br>
   * Default value: Language::getString("DefValueFormat")
   *
   * @return String
   */
   public function getValueFormat()  {
      return $this->valueFormat;
   }

   /**
   * Determines the Format to display point values.<br>
   * Default value: Language::getString("DefValueFormat")
   *
   * @param value String
   */
   public function setValueFormat($value)  {
      $this->valueFormat = $this->setStringProperty($this->valueFormat, $value);
   }

   /**
   * The Format to display point values as percentage.<br>
   * PercentFormat is a standard string specifier. It is used to draw the
   * Series Marks Percent Style figures.<br>
   * Default value: Language::getString("DefPercentFormat")
   *
   * @see Series#getValueFormat
   * @return String
   */
   public function getPercentFormat()  {
      return $this->percentFormat;
   }

   /**
   * Sets the Format to display point values as percentage.<br>
   * Default value: Language::getString("DefPercentFormat")
   *
   * @param value String
   */
   public function setPercentFormat($value) {
      $this->percentFormat = $this->setStringProperty($this->percentFormat, $value);
      $this->percentDecimal = $this->percentFormat;
   }

   /**
   * Horizontal axis associated to this Series.<br>
   * Default value: HorizontalAxis.Bottom
   *
   * @return HorizontalAxis
   */
   public function getHorizontalAxis()  {
      return $this->horizontalAxis;
   }

   /**
   * Stes the Horizontal axis associated to this Series.<br>
   * Default value: HorizontalAxis.Bottom
   *
   * @param value HorizontalAxis
   */
   public function setHorizontalAxis($value)  {
      if($this->horizontalAxis != $value)  {
         $this->horizontalAxis = $value;
         if($this->horizontalAxis != HorizontalAxis::$CUSTOM)  {
            $this->customHorizAxis = null;
         }
         $this->recalcGetAxis();
         $this->invalidate();
      }
   }

   /**
   * Determines Vertical axis associated to this Series.<br>
   * Default value: VerticalAxis.Left
   *
   * @return VerticalAxis
   */
   public function getVerticalAxis()  {
      return $this->verticalAxis;
   }

   /**
   * Determines Vertical axis associated to this Series.<br>
   * Default value: VerticalAxis.Left
   *
   * @param value VerticalAxis
   */
   public function setVerticalAxis($value)  {
      if($this->verticalAxis != $value)  {
         $this->verticalAxis = $value;
         if($this->verticalAxis != VerticalAxis::$CUSTOM)  {
            $this->customVertAxis = null;
         }
         $this->recalcGetAxis();
         $this->invalidate();
      }
   }

   /**
   * Returns "Value" parameter coordinate position in pixels.
   *
   * @param value double
   * @return int
   */
   public function calcPosValue($value)  {
      return $this->yMandatory ? $this->calcYPosValue($value) : $this->calcXPosValue($value);
   }

   /**
   * The pixel Screen Horizontal coordinate of the ValueIndex Series
   * value.<br>
   * This coordinate is calculated using the Series associated Horizontal
   * Axis.
   *
   * @param index int
   * @return int
   */
   public function calcXPos($index)  {
      return $this->calcXPosValue($this->vxValues->value[$index]);
   }

   /**
   * The pixel Screen Horizontal coordinate of the specified Value.
   * <br>
   * This coordinate is calculated using the Series associated Horizontal
   * Axis.
   *
   * @param value double
   * @return int
   */
   public function calcXPosValue($value)  {
      return $this->horizAxis->calcXPosValue($value);
   }

   /**
   * The pixel Screen Vertical coordinate of the ValueIndex Series
   * value.<br>
   * This coordinate is calculated using the Series associated Vertical Axis.
   *
   * @param index int
   * @return int
   */
   public function calcYPos($index)  {
      return $this->calcYPosValue($this->getYValues()->value[$index]);
   }

   /**
   * The pixel Screen Vertical coordinate of the specified Value.<br>
   * This coordinate is calculated using the Series associated Vertical Axis.
   *
   * @param value double
   * @return int
   */
   public function calcYPosValue($value) {
      return $this->vertAxis->calcYPosValue($value);
   }

   public function getOriginValue($valueIndex)  {
      return $this->getMarkValue($valueIndex);
   }

   /* Draws a point Mark using the APosition coordinates. */
   protected function drawMark($valueIndex, $st, $aPosition) {
      $this->getMarks()->internalDraw($valueIndex,
      $this->getValueColor($valueIndex), $st,
      $aPosition);
   }

   private function getDefaultColor($valueIndex)  {
      if($this->bColorEach)  {
         $c = $this->getChart()->getGraphics3D()->getDefaultColor($valueIndex);
         return $c;
      }
      else  {
         return $this->getColor();
      }
   }

   /**
   * The colour of the index point.
   *
   * @param valueIndex int
   * @return Color
   */
   public function getValueColor($valueIndex)  {
      if(($this->iColors != null) && (sizeof($this->iColors) > $valueIndex))  {
         $result = $this->iColors->getColor($valueIndex);
         return $result->isEmpty() ?
         $this->getDefaultColor($valueIndex) : $result;
      }
      else  {
         return $this->getDefaultColor($valueIndex);
      }
   }

   public function drawMarks()  {
      $g = $this->chart->getGraphics3D();
      $a = $this->chart->getAspect();

      $shouldZoomFont = ($a->getView3D() &&
      (!$g->getSupports3DText()) && $a->getZoomText() &&
      ($a->getZoom() != 100));

      for($t = $this->firstVisible; $t <= $this->lastVisible; $t++)  {
         if(($t % $this->marks->getDrawEvery()) == 0)  {
            if(!$this->isNull($t))  {
               $st = $this->getMarkText($t);

               if(strlen($st) != 0) {
                  $tmpMark = $this->getMarks()->markItem($t);

                  if($tmpMark->getVisible())  {
                     $g->setFont($tmpMark->getFont());

                     if($shouldZoomFont)  {
                        $f = $g->getFont();
                        $f->setSize(max(1, MathUtils::round(
                        0 . 01 *
                        $a->getZoom() *
                        $f->getSize())));
                     }

                     $tmpFontH = $g->getFontHeight();

                     $tmp = $this->chart->multiLineTextWidth($st);
                     $tmpW = $tmp->width;
                     $tmpH = $tmp->count * $tmpFontH;

                     if($this->marks->shouldDrawSymbol())
                     {
                        $tmpW += $tmpFontH;// - 4;
                     }

                     $g->setPen($tmpMark->getPen());
                     if($tmpMark->getPen()->getVisible())
                     {
                        $tmpWidth = 2 * MathUtils::round($tmpMark->getPen()->getWidth());
                        $tmpW += $tmpWidth;
                        $tmpH += $tmpWidth;
                     }
                     else
                     {
                        $tmpH++;
                     }

                     $aPos = new SeriesMarksPosition();
                     $aPos->width = $tmpW;
                     $aPos->height = $tmpH;
                     $aPos->arrowTo->setX($this->calcXPos($t));
                     $aPos->arrowTo->setY($this->calcYPos($t));
                     $aPos->arrowFrom->setX($aPos->arrowTo->getX());
                     $aPos->arrowFrom->setY($aPos->arrowTo->getY());
                     $aPos->leftTop->setX($aPos->arrowTo->getX() - ($tmpW / 2));
                     $aPos->leftTop->setY($aPos->arrowTo->getY() - $tmpH + 1);

                     if($this->getMarks()->getSymbol() != null)
                     {
                        $tmpR = $this->getMarks()->getSymbol()->getShapeBounds();
                        $tmpR->y = $aPos->leftTop->getY() + 2;
                        $tmpR->x = $aPos->leftTop->getX() + 2;
                        $tmpR->width = $tmpFontH;
                        $tmpR->height = $tmpFontH;
                     }

                     $this->drawMark($t, $st, $aPos);
                  }
               }
            }
         }
      }
   }

   private function clipRegionCreate($activeRegion)
   {
      $tmpR = $this->chart->getChartRect();

      if($this->chart->canClip()) {
         // tmpR.height++; out mm 27ago07 causes incr series upon series
         $this->chart->getGraphics3D()->clipCube($tmpR, 0, $this->chart->getAspect()->getWidth3D());
         $activeRegion = true;
      }

      return $activeRegion;
   }

   // Remove the clipping region
   private function clipRegionDone($activeRegion)
   {
      if($activeRegion)  {
         $this->chart->getGraphics3D()->unClip();
         $activeRegion = false;
      }

      return $activeRegion;
   }

   // Draw the "Marks" of the Series
   private function drawMarksSeries($s, $activeRegion)
   {
      if($s->getCount() > 0)  {
         if(($s->marks != null) && ($s->getMarks()->getVisible()))  {
            if($s->getMarks()->getClip())  {
               $activeRegion = $this->clipRegionCreate($activeRegion);
            }
            $s->drawMarks();
            if($s->getMarks()->getClip())  {
               $activeRegion = $this->clipRegionDone($activeRegion);
            }
         }
      }
      return $activeRegion;
   }

   // if the ASeries parameter has the same "Z" order than the current series, draw the point
   private function tryDrawSeries($s, $valueIndex)  {
      if($s->getActive() && ($s->getZOrder() == $this->getZOrder()) &&
      ($valueIndex < $s->getCount()))
      {
         $s->drawValue($valueIndex);
      }
   }

   protected function drawSeriesForward($valueIndex)   {
      return true;// abstract
   }

   // Draw one single point (ValueIndex) for all Series
   private function drawAllSeriesValue($valueIndex)  {
      $tmp1 = $this->chart->getSeriesIndexOf($this);
      $tmp2 = $this->chart->getSeriesCount() - 1;

      if($valueIndex < $this->getCount()) {
         if($this->drawSeriesForward($valueIndex))  {
            for($t = $tmp1; $t <= $tmp2; $t++)  {
               $this->tryDrawSeries($this->chart->getSeries($t), $valueIndex);
            }
         }
         else  {
            for($t = $tmp2; $t >= $tmp1; $t--)  {
               $this->tryDrawSeries($this->chart->getSeries($t), $valueIndex);
            }
         }
      }
      else  {
         for($t = $tmp1; $t <= $tmp2; $t++)  {
            $this->tryDrawSeries($this->chart->getSeries($t), $valueIndex);
         }
      }
   }

   // Returns True if the series is the first one with the same ZOrder.
   // Some series allow sharing the same ZOrder (example: Stacked Bars).
   private function firstInZOrder()  {
      if($this->getActive())  {
         for($t = 0; $t < $this->chart->getSeriesCount(); $t++)  {
            $s = $this->chart->getSeries($t);

            if($s === $this)  {
               break;
            }
            else
               if($s->getActive() &&
               ($s->getZOrder() == $this->getZOrder()))
               {
                  return false;
               }
         }
         return true;
      }
      else  {
         return false;
      }
   }

   public function getHasZValues() {
      return $this->hasZValues;
   }

   /**
   * Returns true if there are more series that share the same Z order.<br>
   * For example Stacked Bars.
   *
   * @return boolean
   */
   protected function moreSameZOrder() {
      if($this->chart->getAspect()->getApplyZOrder())  {
         for($t = 0; $t < $this->chart->getSeriesCount(); $t++)  {
            $s = $this->chart->getSeries($t);
            if(!($s === $this))  {
               if($s->getActive() && (!$s->getHasZValues()) &&
               ($s->getZOrder() ==
               $this->getZOrder()))
               {
                  return true;
               }
            }
         }
      }
      return false;
   }

   protected function draw()  {
      if($this->drawValuesForward()) {
         for($t = $this->firstVisible; $t <= $this->lastVisible; $t++)  {
            $this->drawValue($t);
         }
      }
      else  {
         for($t = $this->lastVisible; $t >= $this->firstVisible; $t--)  {
            $this->drawValue($t);
         }
      }
   }

   public function doBeforeDrawChart() { }// abstract

   /**
   * Draws the series to the Chart Canvas.
   *
   */
   public function drawSeries()  {
      $activeRegion = false;/* <--  IMPORTANT !!!! */

      if($this->chart->getAspect()->getView3D() && $this->moreSameZOrder())  {
         if($this->firstInZOrder())  {
            $activeRegion = false;
            $tmpFirst = -1;
            $tmpLast = -1;

            for($t = $this->chart->getSeriesIndexOf($this); $t < $this->chart->getSeriesCount(); $t++)  {
               $s = $this->chart->getSeries($t);
               if($s->getActive() && ($s->getZOrder() == $this->getZOrder()))  {
                  $s->calcFirstLastVisibleIndex();
                  if($s->getFirstVisible() != - 1)  {
                     $tmpFirst = ($tmpFirst == - 1) ?
                     $s->getFirstVisible() :
                     max($tmpFirst,
                     $s->getFirstVisible());
                     $tmpLast = ($tmpLast == - 1) ?
                     $s->getLastVisible() :
                     max($tmpLast, $s->getLastVisible());

                     $s->doBeforeDrawValues();

                     if($this->chart->getAspect()->getClipPoints() && (!$activeRegion))  {
                        $activeRegion = $this->clipRegionCreate($activeRegion);
                     }
                  }
               }
            }

            // values
            if($tmpFirst != - 1)  {
               if($this->drawValuesForward())  {
                  for($t = $tmpFirst; $t <= $tmpLast; $t++)  {
                     $this->drawAllSeriesValue($t);
                  }
               }
               else  {
                  for($t = $tmpLast; $t >= $tmpFirst; $t--)  {
                     $this->drawAllSeriesValue($t);
                  }
               }
            }

            // Finish Clipping Region
            $activeRegion = $this->clipRegionDone($activeRegion);

            // Marks and doAfterDrawValues
            for($t = 0; $t < $this->chart->getSeriesCount(); $t++) {
               $s = $this->chart->getSeries($t);
               if($s->getActive() &&
               ($s->getZOrder() == $this->getZOrder()) &&
               ($s->getFirstVisible() != - 1))
               {
                  $activeRegion = $this->drawMarksSeries($s, $activeRegion);
                  $this->doAfterDrawValues();
               }
            }
         }
      }
      else  {
         $this->calcFirstLastVisibleIndex();

         if($this->firstVisible != - 1)  {
            $this->doBeforeDrawValues();
            if($this->useAxis && $this->chart->getAspect()->getClipPoints())  {
               $activeRegion = $this->clipRegionCreate($activeRegion);
            }
            $this->draw();
            $activeRegion = $this->clipRegionDone($activeRegion);
            $activeRegion = $this->drawMarksSeries($this, $activeRegion);
            $this->doAfterDrawValues();
         }
      }
   }

   /**
   * Obsolete.&nbsp;Use the Series.Color method instead.
   *
   * @see Series#getColor
   * @param value Color
   */
   protected function setSeriesColor($value)
   {
      $this->setColor($value);
   }

   protected function canAddRandomPoints()
   {
      return true;
   }

   private $datasource;

   /**
   * Object to load data from.<br>
   * Default value: null
   *
   * @return Object
   */
   public function getDataSource()
   {
      return $this->datasource;
   }

   /**
   * Object to load data from.<br>
   * Default value: null
   *
   * @param value Object
   */
   public function setDataSource($value)
   {
      if($this->datasource != $value)
      {

         // To protect when disposing the Data.SeriesSource component.
         if($this->datasource instanceof SeriesSource) {
            $this->datasource->setSeries(null);
         }

         $this->datasource = $value;
         if($this->datasource instanceof SeriesSource) {
            $this->datasource->setSeries($this);
         }

         //if (! (datasource is Series)) Function=null; //CI Dec 03
         if(!($this->datasource instanceof Series) &&
         // TODO                !($this->datasource instanceof Series[]) &&
         !(is_Array($this->datasource)))
         {
            $this->setFunction(null);
         }

         $this->checkDataSource();
      }
   }

   /**
   * Adds the collection of objects that implement the IList interface.
   *
   * @param list ArrayList
   */
   /* TODO    
   public function add($list) {
   for ( $t = 0; $t < sizeof($list); $t++) {
   $this->add($list->get($t));
   TODO review before            $this->add(($list->get($t))->doubleValue());
   }
   }  */

   public function getValueListNum($index)
   {
      return $this->valuesList->getValueList($index);
   }

   public function getValueList($name)
   {
      for($t = 0; $t < sizeof($this->valuesList); $t++)
      {
         if($this->valuesList->getValueList($t)->name->equals($name))
         {
            return $this->valuesList->getValueList($t);
         }
      }
      return null;
   }

   protected function getFields($otherList)
   {
      $fieldCount = 0;

      for($t = 0; $t < sizeof($this->valuesList); $t++)
      {
         $v = $this->valuesList->getValueList($t);
         if($v->getDataMember()->length() != 0)
         {
            $fieldCount++;
            if($this->mandatory != $v)
            {
               $otherList = $v;
            }
         }
      }
      return $fieldCount;
   }

   // Prevents a circular relationship between series and
   // series DataSource. Raises an exception if "dest" is already "this".
   public function checkOtherSeries($dest)/* todo throws ChartException*/
   {
      if($dest == $this)
      {
         new ChartException(Language::getString("CircularSeries"));
      }
      else
      {
         $a = $dest->dataSourceArray();
         if($a != null)
         {
            for($t = 0; $t < $a->size(); $t++)
            {
               // TODO  ($a->get($t))->checkOtherSeries($this);
            }
         }
      }
   }

   private function fillFromDataSource()
   {
      if($this->datasource instanceof Series)
      {
         $this->addValuesFrom($this->datasource);
      }
      else
         if(is_Array($this->datasource))
         {
              $a = $this->datasource;
              if(sizeof($a) > 0)
              {
                 $o = $a[0];
                 if(!($o instanceof Series))
                 {  // Array of Values
                    $this->addValues($a);
                 }
                 else
                 { // Array of Series
                    $tmp = $this->datasource;
                    $a = Array();
                    for ( $t = 0; $t < sizeof($tmp); $t++) {
                      $a[$t]=$tmp[$t];
                      $this->addValues($a);
                    }
                 }
              }
              /*
            } else if ($this->datasource instanceof SeriesSource) {
            $this->datasource->refreshData();
            } else {
            if (!$this->DataSeriesSource->tryRefreshData($this)) {

            /** @todo THROWING HERE MAKES EXPLOSION
            //  throw new TeeChartException(
            //          "Cannot bind to non-supported datasource: " +
            //          datasource.toString());
            }             */
         }
   }

   /**
   * Refreshes all Series point values, either from database Tables
   * or Series points.<br>
   *
   * You can call this method regularly if you want new or modified data to
   * appear in realtime in the Series. The parent Chart will be repainted to
   * reflect any changes.
   */
   public function checkDataSource()
   {
      if($this->datasource != null)
      {
         $this->fillFromDataSource();
      }
      else
         if($this->function != null)
         {
            if($this->function->noSourceRequired)
            {// For "Custom" $this->function
               $this->beginUpdate();
               $this->clear();
               $this->function->addPoints(null);
               $this->endUpdate();
            }
         }
         else
            if(!$this->manualData)
            {
               if($this->canAddRandomPoints())
               {
                  $this->fillSampleValues();
               }
            }
      }

      protected function recalcGetAxis()
      {
         if($this->chart != null)
         {
            $this->horizAxis = $this->chart->getAxes()->getBottom();

            if($this->horizontalAxis == HorizontalAxis::$TOP)
            {
               $this->horizAxis = $this->chart->getAxes()->getTop();
            }
            else
               if($this->horizontalAxis == HorizontalAxis::$CUSTOM)
               {
                  if($this->customHorizAxis != null)
                  {
                     $this->horizAxis = $this->customHorizAxis;
                  }
               }

            $this->vertAxis = $this->chart->getAxes()->getLeft();

            if($this->verticalAxis == VerticalAxis::$RIGHT)
            {
               $this->vertAxis = $this->chart->getAxes()->getRight();
            }
            else
               if($this->verticalAxis == VerticalAxis::$CUSTOM)
               {
                  if($this->customVertAxis != null)
                  {
                     $this->vertAxis = $this->customVertAxis;
                  }
               }
         }
         else
         {
            $this->horizAxis = null;
            $this->vertAxis = null;
         }
      }

      protected function added()
      {
         /* TODO review - if is not commented freeseriescolor makes a repaint which affects to the
         series->horizaxis to be null and vertaxistoo, temporary color assigned manually
         */
         $this->recalcGetAxis();
         if($this->getColor()->isEmpty())
         {
            $this->setColor($this->chart->freeSeriesColor(true));
         }

         $this->checkDataSource();
      }

      /**
      * Obsolete.&nbsp;Use the Series.Color method instead.
      * @see steema.teechart.styles.Series.Color
      *
      * @return Color
      */
      protected function getSeriesColor()
      {
         return $this->getColor();
      }

      /**
      * Default color for all points.<br>
      * The TChart Series SeriesColor method is the default color in which the
      * Series points will be drawn. It could be any valid color. If you add
      * points with Color.EMPTY color, then they will be drawn with the
      * SeriesColor color. This method is the default Color associated to the
      * Series. When you place a new Series component in a Chart, TeeChart will
      * assign a free color to this method (a Color that no other Series in the
      * same Chart uses). Some Series have the ColorEach boolean property.
      * Setting this to true will force the Series to paint each point with a
      * different color, thus without using its SeriesColor.<br>
      * SeriesColor is also used to paint the small rectangle in Chart Legend.
      * <br>Default value: Color.Empty
      *
      * @see Series#getColorEach
      * @return Color
      */
      public function getColor()
      {
         return $this->bBrush->getColor();
      }

      /**
      * Default color for all points.<br>
      * Default value: Color.Empty
      *
      * @see #getColorEach
      * @param value Color
      */
      public function setColor($value)
      {
         $this->bBrush->setColor($value);
         if($this->chart != null)
         {
            $tmpSeriesEventStyle = new SeriesEventStyle();
            // TODO       $this->chart->broadcastEvent($this, $tmpSeriesEventStyle->CHANGECOLOR);
         }
      }

      /**
      * Shows or hides this series.<br>
      * It can be changed both at design time or runtime. When hiding, all point
      * values are preserved, so there's no need to refill the values again
      * when showing them. The Series relatives Chart Axis are rescaled in order
      * to accomodate changes.
      *
      * @return boolean
      */
      public function getActive()
      {
         return $this->bActive;
      }

      /**
      * Shows or hides this series.<br>
      * It can be changed both at design time or runtime. When hiding, all point
      * values are preserved, so there's no need to refill the values again
      * when showing them. The Series relatives Chart Axis are rescaled in order
      * to accomodate changes.
      *
      * @param value boolean
      */
      public function setActive($value)
      {
         $this->bActive = $this->setBooleanProperty($this->bActive, $value);
         if($this->chart != null)
         {
            $tmpSeriesEventStyle = new SeriesEventStyle();
            // TODO     $this->chart->broadcastEvent($this, $tmpSeriesEventStyle->CHANGEACTIVE);
         }
      }

      /**
      * Exchanges one point with another. Also the point color and point label.
      *
      * @param a int index of first point to exchange.
      * @param b int index of second point to exchange.
      */
      protected function swapValueIndex($a, $b)
      {
         for($t = 0; $t < sizeof($this->valuesList); $t++)
         {
            $v = $this->valuesList->getValueList($t);
            $v->exchange($a, $b);
         }

         if($this->iColors != null)
         {
            $this->iColors->exchange($a, $b);
         }
         if($this->sLabels != null)
         {
              /* $this->sLabels->exchange($a, $b); */
              // Exchange Array
              $c=$this->sLabels[$a];
              $this->sLabels[$a]=$this->sLabels[$b];
              $this->sLabels[$b]=$c;
         }
      }

      public function swap($a, $b) {
         $this->swapValueIndex($a, $b);
      }

      /**
      * Series description to show in Legend and dialogs.<br>
      * Every Series has a Title method of type String. It is used in
      * TChart.Legend to draw the series descriptions. If Title is empty,
      * then the Series class Name will be used to draw the legend. Setting
      * Title both at design time and runtime will force the Chart to repaint.
      * <br>Default value: ""
      *
      * @return String
      */
      public function getTitle()
      {
         return $this->title;
      }

      /**
      * Series description to show in Legend and dialogs.<br>
      * Default value: ""
      *
      * @param value String
      */
      public function setTitle($value)
      {
         $this->title = $this->setStringProperty($this->title, $value);
         if($this->chart != null)
         {
            /* TODO
            $tmpSeriesEventStyle = new SeriesEventStyle();
            $this->chart->broadcastEvent($this, $tmpSeriesEventStyle->CHANGETITLE);
            */
         }
      }

      public function onDisposing() { }

      public function setChart($value)
      {

         if($this->chart != $value)
         {
            if($this->chart != null)
            {
               $this->chart->removeSeries($this);
            }

            parent::setChart($value);

            $this->bBrush->setChart($this->chart);

            if($this->chart != null)
            {
               $this->chart->addSeries($this);
               $this->added();
            }

            if($this->marks != null)
            {
               $this->marks->iSeries = $this;
               $this->marks->setChart($this->chart);
               $this->marks->getCallout()->setChart($this->chart);
            }

            if($this->function != null)
            {
               $this->function->setChart($this->chart);
            }

            if($this->chart != null)
            {
               $this->chart->invalidate();
            }

            for($t = 0; $t < sizeof($this->valuesList); $t++)
            {
               $this->valuesList->getValueList($t)->series = $this;
               $this->valuesList->getValueList($t)->setChart($this->chart);
            }
         }
      }

      protected function setHorizontal()
      {
         $this->mandatory = $this->vxValues;
         $this->notMandatory = $this->vyValues;
         $this->yMandatory = false;
      }

      /**
      * Adds new point with specified DateTime x and Double y values.
      *
      * @see ValueList
      * @param x DateTime
      * @param y double
      * @return int index of added point
      */

      // TODO add datatime
      /*    public function add($x, $y) {
      $this->vxValues->dateTime = true;
      return $this->add($x->toDouble(), $y);
      }

      *//**
      * @see ValueList
      *
      * @param x DateTime
      * @param y DateTime
      * @return int index of added point
      */
      /* todo public function add($x, $y) {
      $this->vxValues->dateTime = true;
      $this->vyValues->dateTime = true;
      return $this->add($x->toDouble(), $y->toDouble());
      }       */

      /**
      * Adds new point with specified DateTime x, Double y values and Color.
      * @see ValueList
      *
      * @param x DateTime
      * @param y double
      * @param c Color
      * @return int index of added point
      */
      /* TODO public function add($x, $y, $c) {
      $this->vxValues->dateTime = true;
      return $this->add($x->toDouble(), $y, $c);
      }
      */
      /**
      * Adds new point with specified DateTime x, Double y values and Text.
      * @see ValueList
      *
      * @param x DateTime
      * @param y double
      * @param text String
      * @return int index of added point
      */
      /* TODO    public function add($x, $y, $text) {
      $this->vxValues->dateTime = true;
      return $this->add($x->toDouble(), $y, $text);
      }
      */

      /**
      * Obsolete.&nbsp;Please use add(x,y,Color.<!-- -->Transparent)
      * method instead.
      *
      * @param x double
      * @param y double
      * @return int
      */
      public function addNullXY($x, $y)
      {
         $tmpColor = new Color(0, 0, 0, 127);// TRANSPARENT
         return $this->add($x, $y, $tmpColor);
      }

      /**
      * Obsolete.&nbsp;Please use add() method without parameters instead.
      *
      * @return int
      */
      public function addNull()
      {
         return $this->add();
      }

      /**
      * Adds a new point with specified value.
      *
      * @param value int
      * @return int
      */
      public function add($value = "null")
      {
         if($value === "null") {
            $tmpColor = new Color(0,0,0,127);// TRANSPARENT
            return $this->addYColor(0, $tmpColor);
         }
         else {
            if($this->yMandatory) {
               return $this->addXY($this->getCount(), $value);
            }
            else {
               return $this->addXY($value, $this->getCount());
            }
         }
      }

      /**
      * Adds a new point with specified value.
      *
      * @param value double
      * @return int
      */
      /* TODO public function add($value) {
      if ($this->yMandatory) {
      return $this->add($this->getCount(), $value);
      } else {
      return $this->add($value, $this->getCount());
      }
      }       */

      /**
      * Adds a new point with specified value.
      *
      * @param value float
      * @return int
      */
      /* TODO    public function add($value) {
      return $this->add(($this->double) $value);
      }
      */
      /**
      * Adds a new point with specified value and text.
      *
      * @param value double
      * @param text String
      * @return int
      */
      public function addYText($value, $text)
      {
         if($this->yMandatory) {
            return $this->addXYText($this->getCount(), $value, $text);
         }
         else {
            return $this->addXYText($value, $this->getCount(), $text);
         }
      }

      /**
      * Adds a new point with specified x and y values.
      *
      * @param x double
      * @param y double
      * @return int
      */
      public function addXY($x, $y)
      {
         $tmp = $this->vxValues->addChartValue($x);
         $this->vyValues->insertChartValue($tmp, $y);

         $listsCount = sizeof($this->valuesList);
         if($listsCount > 2)
         {
            for($t = 2; $t < $listsCount; $t++) {
               $v = $this->valuesList->getValueList($t);
               $v->insertChartValue($tmp, $v->tempValue);
            }
         }

         if($this->updating == 0) {
            $this->invalidate();
         }

         return $tmp;
      }

      /**
      * Adds the pair of floating point x- and y-pixel coordinates
      *
      * @param p Double
      * @return int
      */
      /*todo    public function add($p) {
      return $this->add($p->x, $p->y);
      } */

      /**
      * Adds a new point with specified x,y values and text.
      *
      * @param x double
      * @param y double
      * @param text String
      * @return int
      */
      public function addXYText($x, $y, $text)
      {
         $tmpColor = new Color(0, 0, 0, 0, true);// EMPTY
         return $this->addXYTextColor($x, $y, $text, $tmpColor);
      }

      /**
      * Adds a new point with specified x,y values, text and color.
      *
      * @param x double
      * @param y double
      * @param text String
      * @param color Color
      * @return int
      */
      public function addXYTextColor($x, $y, $text="", $color=null)
      {
         $tmp = $this->addXY($x, $y);

         if ($color!=null) {
           if(!($color->isEmpty())) {
              $this->getColors()->setColor($tmp, $color);
           }
         }

         if(($text != null))
         {
            if($this->getXValues()->getOrder() == ValueListOrder::$NONE)
            {
               $this->sLabels[sizeof($this->getLabels())]=$text;
            }
            else if(strlen($text) != 0)
            {
               $this->sLabels[$tmp] = $text;
            }
         }
         return $tmp;
      }

      /**
      * Adds a new Datetime point to a Series, label and color.
      *
      * @param aDate DateTime datetime value
      * @param y double
      * @param text String point text
      * @param color Color
      * @return int index of added point
      */
      /* TODO    public function add($aDate, $y, $text, $color) {
      $this->vxValues->dateTime = true;
      return $this->add($aDate->toDouble(), $y, $text, $color);
      }  */

      /**
      * Adds a new point with specified x and y values and color.
      *
      * @param x double
      * @param y double
      * @param color Color
      * @return int
      */
      public function addXYColor($x, $y, $color)
      {
         return $this->addXYTextColor($x, $y, "", $color);
      }

      /**
      * Adds a new point with specified value, text and color.
      *
      * @param value double
      * @param text String
      * @param color Color
      * @return int
      */
      public function addYTextColor($value, $text, $color)
      {
         if($this->yMandatory)
         {
            return $this->addXYTextColor($this->getCount(), $value, $text, $color);
         }
         else
         {
            return $this->addXYTextColor($value, $this->getCount(), $text, $color);
         }
      }

      /**
      * Adds a new point with specified value and color.
      *
      * @param value double
      * @param color Color
      * @return int
      */
      public function addYColor($value, $color)
      {
         if($this->yMandatory)
         {
            return $this->addXYColor($this->getCount(), $value, $color);
         }
         else
         {
            return $this->addXYColor($value, $this->getCount(), $color);
         }
      }

      /**
      * Adds a new null point with specified text.
      *
      * @param text String
      * @return int
      */
      public function addText($text)
      {
         $tmpColor = new Color(0, 0, 0, 127);// Transparent
         return $this->addYTextColor(0, $text, $tmpColor);
      }

      /**
      * Adds all points in source Series.
      *
      * @param source Series
      */
      //[Description("Adds all points in source Series.")]
      /* tODO    public function add($source) {
      $this->addValuesFrom($source);
      }  */

      protected function convertArray($a, $numPoints)
      {
         /*double[]*/$tmpArray = null;

         //        if (a instanceof DateTime[]) {
         //            tmpArray = new double[numPoints];
         //            int max = a.size();
         //            for (int i = 0; i <= max; i++) {
         //                tmpArray[i] = (DateTime) a.get(i);
         //            }
         //        } else if ((a instanceof int[]) || (a instanceof float[]) ||
         //                   (a instanceof Decimal[])) {
         //            tmpArray = new double[numPoints];
         //            a.CopyTo(tmpArray, 0);
         //        } else if (a instanceof double[]) {
         //            tmpArray = (double[]) a;
         //        }

         return $this->tmpArray;
      }

      /**
      * Adds the X and Y arrays.
      *
      * @param xValues ArrayList
      * @param yValues ArrayList
      */
      /* TODO    public function add($xValues, $yValues) {
      $numPoints = $yValues->size();
      $this->getXValues()->count = $numPoints;
      $this->getXValues()->value = $this->convertArray($xValues, $numPoints);
      $this->getYValues()->count = $numPoints;
      $this->getYValues()->value = $this->convertArray($yValues, $numPoints);
      $this->getXValues()->statsOk = false;
      $this->getYValues()->statsOk = false;
      $this->invalidate();
      }
      */
      /**
      * Adds the array of double values.
      *
      * @param values double[]
      */
      public function addArray($values)
      {
         for($t = 0; $t < sizeof($values); $t++)
            $this->add($values[$t]);
      }
	  
      /**
      * Adds the X and Y arrays.
      *
      * @param xValues Array
      * @param yValues Array
      */
      public function addArrays($xValues, $yValues)
      {
         for($t = 0; $t < sizeof($xValues); $t++)
            $this->addXY($xValues[$t], $yValues[$t]);
      }

      /**
      * Adds the array of float values.
      *
      * @param values float[]
      */
      /*    public function add($values) {
      for ( $t = 0; $t < $values->length; $t++) {
      $this->add($values[$t]);
      }
      }
      */
      /**
      * Adds the array of integer values.
      *
      * @param values int[]
      */
      /* TODO    public function add($values) {
      for ( $t = 0; $t < $values->length; $t++) {
      $this->add($values[$t]);
      }
      }
      */
      public function checkMouse($c, $x, $y)
      {
         $r = new MouseClicked($c, false);

         $tmpCursors = new Cursors();
         if(($this->getCursor() != $tmpCursors->DEFAULT) ||
         ($this->hasListenersOf($this->SeriesMouseListener->class)))
         {
            if($this->clicked($x, $y) != - 1)
            {
               if($this->getCursor() != $tmpCursors->DEFAULT)
               {
                  $r->cursor = $this->getCursor();
               }

               if(!$this->isMouseInside)
               {
                  $this->isMouseInside = true;
                  $tmpSeriesMouseEvent = new SeriesMouseEvent();
                  $this->fireSeriesMouseEvent(new SeriesMouseEvent($this,
                        $tmpSeriesMouseEvent->SERIES_ENTERED, - 1,
                        new TeePoint($x, $y)));
               }

               $r->clicked = true;
            }
            else
            {
               if($this->isMouseInside)
               {
                  $this->isMouseInside = false;
                  $this->fireSeriesMouseEvent(new $tmpSeriesMouseEvent(this ,
                        $tmpSeriesMouseEvent->SERIES_EXITED, - 1,
                        new TeePoint($x, $y)));
               }
            }
         }
         return $r;
      }

      /**
      * Reorders points according to Order property of X,Y,etc value lists.<br>
      * Refreshes sort order of Series points if Order type of XValues or
      * YValues is not loNone.
      */
      public function checkOrder()  {
         if ($this->mandatory->getOrder() != ValueListOrder::$NONE)  {
            $this->mandatory->sort();

            // if NotMandatory list has a ValueSource, do not call FillSequence
            if(sizeof($this->notMandatory->valueSource) == 0){
               $this->notMandatory->fillSequence();
            }
            $this->repaint();
         }
      }

      /**
      * Removes all points, texts and Colors from the Series.<br>
      * Dependent Series are notified. If no new points are appended to the
      * Series, nothing will be painted.
      */
      public function clear()  {
         $this->clearLists();
         if($this->updating == 0)  {
            $this->invalidate();
         }
      }

      protected function clearLists() {
         // Values
         for($t = 0; $t < sizeof($this->valuesList); $t++)  {
            $this->valuesList->getValueList($t)->clear();
         }
         if($this->sLabels != null)  {
            $this->sLabels= Array();
         }
         if($this->iColors != null)  {
            unset($this->iColors);// Clears the array
         }
         if($this->marks != null)  {
            $this->marks->clear();
         }
      }

      /* TODO
      public function clicked($p)
      {
          return $this->clicked($p->x, $p->y);
      }
      */

      /**
      * Returns the ValueIndex of the "clicked" point in the Series.<br>
      * Clicked means the X and Y coordinates are in the point screen region
      * bounds. If no point is "touched", Clicked returns -1
      *
      * @param x int
      * @param y int
      * @return int
      */
      public function clicked($x, $y) {
         return -1;    
      }
      
      /**
      * Returns the number of points in the Series.
      *
      * @return int
      */
      public function getCount()  {
         return $this->mandatory->count;
      }

      /**
      * Removes the index th point.<br>
      * X values remain unchanged.<br>
      * The Chart will be automatically redrawn. <br>
      * Dependent Series will be recalculated.
      *
      * @param index int
      */
      public function delete($index)
      {
         $this->vxValues->removeAt($index);
         $this->vyValues->removeAt($index);
         if(($this->sLabels != null) &&
         (sizeof($this->sLabels) > $index))
         {
            $this->sLabels->remove($index);
         }
         if(($this->iColors != null) &&
         ($this->iColors->size() > $index))
         {
            $this->iColors->remove($index);
         }
         if($this->marks != null)
         {
            if($this->marks->getPositions()->size() > $index)
            {
               $this->marks->getPositions()->remove($index);
            }
            if($this->marks->getItems()->size() > $index)
            {
               $this->marks->getItems()->remove($index);
            }
         }
         if($this->updating == 0)
         {
            $this->invalidate();
         }
      }

      /**
      * Removes count number of points starting at index.<br>
      * When RemoveGap parameter is true, it calls ValueList FillSequence.<br>
      * The Chart will be automatically redrawn. <br>
      * Dependent Series will be recalculated.
      *
      * @param index int
      * @param count int
      * @param removeGap boolean
      */
      /* TODO    public function delete($index, $count, $removeGap) {
      $this->vxValues->removeRange($index, $count);
      $this->vyValues->removeRange($index, $count);
      if (($this->sLabels != null) &&
      ($this->sLabels->size() > $index + $count - 1)) {
      $this->sLabels->removeRange($index, $count);
      }
      if (($this->iColors != null) &&
      ($this->iColors->getCount() > $index + $count - 1)) {
      $this->iColors->removeRange($index, $count);
      }
      if (($this->marks != null) &&
      ($this->marks->getPositions()->size() >
      $index + $count - 1)) {
      $this->marks->getPositions()->removeRange($index, $count);
      }
      if ($removeGap) {
      $this->notMandatory->fillSequence();
      }
      if ($this->updating == 0) {
      $this->invalidate();
      }
      }

      public function delete($index, $count) {
      $this->delete($index, $count, false);
      }
      */
      protected function randomBounds($numValues)
      {
         $minX=0.0;
         $maxX=0.0;

         $result = new SeriesRandom();

         $result->MinY = 0;
         $maxY = 1000;

         if(($this->chart != null) &&
         ($this->chart->getMaxValuesCount() > 0))
         {
            $result->MinY = $this->chart->getMinYValue($this->vertAxis);
            $maxY = $this->chart->getMaxYValue($this->vertAxis);

            if($maxY == $result->MinY)
            {
               if($maxY == 0)
               {
                  $maxY = 1000;
               }
               else
               {
                  $maxY = 2.0 * $result->MinY;
               }
            }

            $minX = $this->chart->getMinXValue($this->horizAxis);
            $maxX = $this->chart->getMaxXValue($this->horizAxis);

            if($maxX == $minX)
            {
               if($maxX == 0)
               {
                  $maxX = $numValues;
               }
               else
               {
                  $maxX = 2.0 * $minX;
               }
            }

            if(!$this->yMandatory)
            {
               $tmp = $minX;
               $minX = $result->MinY;
               $result->MinY = $tmp;

               $tmp = $maxX;
               $maxX = $maxY;
               $maxY = $tmp;
            }
         }
         else
         {
            if($this->vxValues->getDateTime())
            {
               $minX = gettimeofday(true); // get Now as double
               $maxX = $minX + $numValues - 1;
            }
            else
            {
               $minX = 0;
               $maxX = $numValues - 1;
            }
         }

         $NEGATIVE_INFINITY =intval('-1000000000000');

         if (bccomp($NEGATIVE_INFINITY, $result->MinY) == 0) {
            $result->MinY = 0;
         }

         if (bccomp($NEGATIVE_INFINITY, $minX) == 0) {
            $minX = 0;
         }

         if (bccomp($NEGATIVE_INFINITY, $maxY) == 0) {
            $maxY = 0;
         }

         if (bccomp($NEGATIVE_INFINITY, $maxX) == 0) {
            $maxX = 0;
         }

         $result->StepX = $maxX - $minX;
         if($numValues > 1)
         {
            $result->StepX /= ($numValues - 1);
         }
         $result->DifY = $maxY - $result->MinY;

         $MAX_VALUE = intval('1000000000000');

         if($result->DifY > $MAX_VALUE)
         {
            $result->DifY = $MAX_VALUE;
         }
         else
            if($result->DifY < - $MAX_VALUE)
            {
               $result->DifY = -$MAX_VALUE;
            }

         $result->tmpY = $result->MinY +
         $result->DifY * $result->Random();
         $result->tmpX = $minX;

         return $result;
      }

      public function getNumSampleValues()
      {
         return $this->numSampleValues();
      }

      protected function numSampleValues()
      {
         return 25;
      }

      protected function addSampleValues($numValues)
      {
         $s = $this->randomBounds($numValues);
         $tmpH = MathUtils::round($s->DifY * 0 . 25);

         for($t = 1; $t <= $numValues; $t++)
         {
            $s->tmpY = $s->Random();

            if($this->yMandatory)
            {
               $this->addXY($s->tmpX, $s->tmpY);
            }
            else
            {
               $this->addXY($s->tmpY, $s->tmpX);
            }

            $s->tmpX += $s->StepX;
         }
      }

      /**
      * Adds the specified NumValues random points.
      *
      * @param numValues int the number of sample values to add.
      */
      public function fillSampleValues($numValues = -1)
      {
         if($numValues == - 1)
            $numValues = $this->getNumSampleValues();

         if($numValues == 0)
         {
            $numValues = $this->iNumSampleValues;
            if($numValues <= 0)
            {
               $numValues = $this->getNumSampleValues();
            }
         }

         $this->clear();

         $this->beginUpdate();
         $this->addSampleValues($numValues);
         $this->checkOrder();
         $this->endUpdate();

         $this->manualData = false;
      }

      /**
      * Returns true if the index th point in the Series is "null" or "empty".
      * <br>
      * A point is considered "null" when the color of that point is
      * "Transparent".
      *
      * @param index int the point index.
      * @return boolean true if the point color is Color.Transparent
      */
      public function isNull($index)
      {
         return($this->iColors != null) &&
         ($this->iColors->getCount() > $index) && $this->iColors->getColor($index)->isNull();
      }

      /**
      * Validates Series datasource.<br>
      * The isValidSourceOf function returns false if the Value parameter is the
      * same as Self. <br>
      * It's used to validate the DataSource property both at design and
      * run-time.
      *
      * @param value Series the series to validate.
      * @return boolean true if value can be a Series data source.
      */
      public function isValidSourceOf($value)
      {
         return $this !== $value;
      }

      protected function isValidSeriesSource($value)
      {
         return true;
      }

      /**
      * Function object to calculate values.<br>
      * Default value: null
      *
      * @return Function
      */
      public function getFunction()
      {
         return $this->function;
      }

      public function setFunction($value)
      {
         $b = $this->function === $value;

         if($b==false)
         {
            $this->function = $value;
            if($this->function != null)  {
               $this->function->setSeries($this);
            }
            $this->checkDataSource();
         }
      }

      /**
      * The Depth of the series points or interconnecting lines.<br>
      * Default value: -1
      *
      * @return int
      */
      public function getDepth()
      {
         return $this->depth;
      }

      /**
      * Sets the Depth of the series points or interconnecting lines.<br>
      * Default value: -1
      *
      * @param value int
      */
      public function setDepth($value)
      {
         $this->depth = $this->setIntegerProperty($this->depth, $value);
      }

      /**
      * Determines where on the depth axis the Series is drawn.<br><br>
      * Read-only and run time. <br><br>
      * It's valid only when TChart.Aspect.View3D is true and when there's more
      * than one Series in the same chart. <br>
      * You can't alter the ZOrder property directly. If you want a different
      * order, you need to use tChart.SeriesList instead.<br>
      * The ZOrder property is calculated for each Series just before the
      * Chart is drawn. <br>
      * TChart.ApplyZOrder controls if Series will be assigned a different
      * Z position or not. When False, all Series are drawn at same Z plane.<br>
      * TChart.MaxZOrder returns the highest of all Series ZOrder values. <br>
      * Default value: AutoZOrder
      *
      * @return int
      */
      public function getZOrder()
      {
         return($this->zOrder == self::$AUTOZORDER) ? $this->iZOrder :
         $this->zOrder;
      }

      /**
      * Determines where on the depth axis the Series is drawn.<br><br>
      * Default value: AutoZOrder
      *
      * @param value int
      */
      public function setZOrder($value)
      {
         $this->zOrder = $this->setIntegerProperty($this->zOrder, $value);
         $this->iZOrder = ($this->zOrder == self::$AUTOZORDER) ? 0 :
         $this->zOrder;
      }

      /**
      * Displays this Series Title in Legend.<br>
      * It is only meaningful when LegendStyle is Series or LastValues. <br>
      * Default value: true
      *
      * @return boolean
      */
      public function getShowInLegend()
      {
         return $this->showInLegend;
      }

      /**
      * Displays this Series Title in Legend.<br>
      * Default value: true
      *
      * @param value boolean
      */
      public function setShowInLegend($value)
      {
         $this->showInLegend = $this->setBooleanProperty($this->showInLegend, $value);
      }

      /**
      * Returns the index of the Series' first visible point.
      *
      * @return int
      */
      public function getFirstVisible()
      {
         return $this->firstVisible;
      }

      /**
      * Returns the index of the Series' last visible point.
      *
      * @return int
      */
      public function getLastVisible()
      {
         return $this->lastVisible;
      }

      /**
      * Cursor displayed when mouse is over a series point.<br>
      * Each Series determines the intersection of points with mouse coordinates
      * each time the mouse moves. There are many different Cursors available.
      * The Series ZOrder determines the order in which Series will be examined
      * to calculate the clicked Series point. <br>
      * Default value: default
      *
      * @return Cursor
      */
      public function getCursor()
      {
         return $this->cursor;
      }

      /**
      * Cursor displayed when mouse is over a series point.<br>
      * Default value: default
      *
      * @param value Cursor
      */
      public function setCursor($value)
      {
         $this->cursor = $value;
      }

      /**
      * Defines how to draw a mark near to each Series point.<br>
      * A mark consist of a colored rectangle with a text string on it and a
      * line that indicates which points corresponds to which mark. <br>
      * Each different Series type draws it's marks differently. <br>
      *
      * @return SeriesMarks
      */
      public function getMarks()
      {
         if($this->marks == null)
         {
            $this->marks = new SeriesMarks($this); // delayed creation
            $this->marks->setZPosition($this->middleZ);
         }
         return $this->marks;
      }

      /**
      * Returns whether Series draws its points in ascending/descending order.
      * <br>Some Series need to draw their points in descending order (starting
      * from the last point to the first) depending on certain situations.
      * For example, when the horizontal axis Inverted property is True. <br>
      *
      * @return boolean true if values in this series are displayed forward,
      * from 0 to Count-1.
      */
      public function drawValuesForward()
      {
         $result = true;
         if($this->mandatory === $this->vyValues)
         {
            $result = !$this->horizAxis->getInverted();
            if(($this->chart->getAspect()->getView3D()) &&
            (!$this->chart->getAspect()->getOrthogonal()) &&
            ($this->chart->getAspect()->getRotation() < 270))
            {
               $result = !$result;
            }
            return $result;
         }
         else
         {
            return !$this->vertAxis->getInverted();
         }
      }

      /**
      * Called internally. Draws the "ValueIndex" point of the Series.
      *
      * @param index int
      */
      public function drawValue($index) { }// abstract

      public function legendToValueIndex($legendIndex)
      {
         return $legendIndex;
      }

      /**
      * Sets the specified series point to a null (transparent) point.<br>
      *
      * <p>Example:
      * <pre><font face="Courier" size="4">
      * lineSeries1.setNull( 123 ); // -- make null (empty) point index 123
      * lineSeries1.setIgnoreNulls( false ); // -- allow null points
      * lineSeries1.setStairs( true ); // -- set "stairs" mode
      * </font></pre></p>
      *
      * @param valueIndex int
      */
      public function setNull($valueIndex)
      {
         $tmpColor = new Color(0, 0, 0, 127);// Transparent
         $this->getColors()->setColor($valueIndex, $tmpColor);
      }

      public function createSubGallery($addSubChart)
      {
         $addSubChart->createSubChart(Language::getString("Normal"));
      }

      /**
      * Creates and prepares the index'th Series style to show at sub-gallery
      * dialog.
      *
      * @param index int
      */
      public function setSubGallery($index) { }// abstract

      protected function setValueList($l,
      $value)
      {
         $l->assign($value);
         $this->repaint();
      }

      /**
      * Returns the size in pixels corresponding to value parameter in
      * horizontal axis scales.<br>
      * This coordinate is calculated using the Series associated Horizontal
      * Axis.
      *
      * @param value double
      * @return int
      */
      public function calcXSizeValue($value)
      {
         return $this->horizAxis->calcSizeValue($value);
      }

      /**
      * Returns the size in pixels corresponding to value parameter in vertical
      * axis scales.<br>
      * This coordinate is calculated using the Series associated Vertical Axis.
      *
      * @param value double
      * @return int
      */
      public function calcYSizeValue($value)
      {
         return $this->vertAxis->calcSizeValue($value);
      }

      private function calcXValue($valueIndex)
      {
         if($this->horizAxis != null)
         {
            return $this->horizAxis->getLabels()->labelValue(
            $this->vxValues->value[$valueIndex]);
         }
         else
         {
            return $this->formatValue($this->vxValues->value[$valueIndex]);
         }
      }

      /**
      * Overridden ToString() method.
      *
      * @see Series#getTitle
      * @return String the Series Series.Title method.
      */
      public function toString()
      {
         $tmpResult = $this->title;
         if(strlen($tmpResult) == 0) {
             if($this->chart != null) {
                 
                 $tmpResult = "Series" . "" . $this->chart->getSeriesIndexOf($this);

                 /* tODO temp lines added
                 $tmpResult = $this->Language->getString("Series") + " " +
                 $this->Integer->toString($this->chart->getSeriesIndexOf($this));
                 */
             }
             else {
                 //$tmpResult = parent::toString();
             }
         }
         return (string)$tmpResult;
      }

      /**
      * Obsolete.&nbsp;Please use ToString() method instead.
      *
      * @return String
      */
      public function titleOrName()
      {
         return $this->toString();
      }

      private function valueToStr($tmpValue)
      {
         if($this->mandatory->getDateTime()) {
            if($tmpValue < 1) {
               return date('H:i:s',$tmpValue);
            }
            else  {
               return date('Y-m-d',$tmpValue);
            }
         }
         else  {
            return $this->formatValue($tmpValue);
         }
      }

      private function calcPercentSt($value)
      {
         $pformat = (($this->mandatory->getTotalABS() == 0) ? 100 :         
           $value / $this->mandatory->getTotalABS());
         return number_format($pformat*100,2);
      }

      /* Returns the formatted String corresponding to the LegendIndex
      point. The String is used to show at the Legend.
      Uses the LegendTextStyle property to ) the appropiate formatting.*/
      /**
      * Returns the formatted String corresponding to the LegendIndex point.
      *
      *
      * @param legendIndex int
      * @param legendTextStyle LegendTextStyle
      * @return String
      */
      public function getLegendString($legendIndex, $legendTextStyle)
      {
         $valueIndex = $this->legendToValueIndex($legendIndex);
         if ($this->sLabels==null)   
         {      
             $this->sLabels = Array();
         }
         $tmpResult = (sizeof($this->sLabels) <= $valueIndex) ? "" :
         
         $this->sLabels[$valueIndex];

         if($legendTextStyle != LegendTextStyle::$PLAIN)
         {
            $tmpValue = $this->getMarkValue($valueIndex);
            if($legendTextStyle == LegendTextStyle::$LEFTVALUE)
            {
               if(strlen($tmpResult) != 0)
               {
                  $tmpResult = Language::getString("ColumnSeparator") . $tmpResult;
               }
               return $this->valueToStr($tmpValue) . $tmpResult;
            }
            else
               if($legendTextStyle == LegendTextStyle::$RIGHTVALUE)
               {
                  if(strlen($tmpResult) != 0)
                  {
                     $tmpResult = $tmpResult . Language::getString("ColumnSeparator");
                  }
                  return $this->valueToStr($tmpResult) . $tmpValue;
               }
               else
                  if($legendTextStyle == LegendTextStyle::$LEFTPERCENT)
                  {
                     if(strlen($tmpResult) != 0)
                     {                       
                        $tmpResult = Language::getString("ColumnSeparator") . $tmpResult;
                     }
                     return '% ' . $this->calcPercentSt($tmpValue) . $tmpResult;
                  }
                  else
                     if($legendTextStyle == LegendTextStyle::$RIGHTPERCENT)
                     {                         
                        if(strlen($tmpResult) != 0)
                        {
                           $tmpResult = $tmpResult . Language::getString("ColumnSeparator");
                        }
                        return $tmpResult + $this->calcPercentSt($tmpValue) . ' %';
                     }
                     else
                        if($legendTextStyle == LegendTextStyle::$XVALUE)
                        {
                           return $this->calcXValue($valueIndex);
                        }
                        else
                           if($legendTextStyle == LegendTextStyle::$VALUE)
                           {
                              return $this->valueToStr($tmpValue);
                           }
                           else
                              if($legendTextStyle == LegendTextStyle::$PERCENT)
                              {
                                 return $this->calcPercentSt($tmpValue) . ' %';
                              }
                              else
                                 if($legendTextStyle == LegendTextStyle::$XANDVALUE)
                                 {
                                    return $this->calcXValue($valueIndex) . Language::getString("ColumnSeparator") . $this->valueToStr($tmpValue);
                                 }
                                 else
                                    if($legendTextStyle == LegendTextStyle::$XANDPERCENT)
                                    {
                                       return $this->calcXValue($valueIndex) . Language::getString("ColumnSeparator") . $this->calcPercentSt($tmpValue) . ' %';
                                    }
         }
         return $tmpResult;
      }

      /**
      * The Maximum Value of the Series X Values List.
      *
      * @return double
      */
      public function getMaxXValue()
      {
         return $this->vxValues->getMaximum();
      }

      /**
      * The Maximum Value of the Series Y Values List.
      *
      * @return double
      */
      public function getMaxYValue()
      {
         return $this->vyValues->getMaximum();
      }

      /**
      * The Minimum Value of the Series X Values List.
      *
      * @return double
      */
      public function getMinXValue()
      {
         return $this->vxValues->getMinimum();
      }

      /**
      * The Minimum Value of the Series Y Values List.
      *
      * @return double
      */
      public function getMinYValue()
      {
         return $this->vyValues->getMinimum();
      }

      /**
      * The Maximum Z Value. For non-3D series, this is the Z order.
      *
      * @return double
      */
      public function getMaxZValue()
      {
         return $this->getZOrder();
      }

      /**
      * The Minimum Z Value. For non-3D series, this is the Z order.
      *
      * @return double
      */
      public function getMinZValue()
      {
         return $this->getZOrder();
      }

      /**
      * Returns whether or not this Series has Y values as mandatory.
      *
      * @return boolean
      */
      public function getYMandatory()
      {
         return $this->yMandatory;
      }
   }
?>
