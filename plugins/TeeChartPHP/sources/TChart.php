<?php
/**
 * Description:  This file contains the following class:<br>
 * TChart class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
  define ("REV", false);
  // increases the memory to 64M
  ini_set("memory_limit","64M");
  // set_time_limit  ( 60 );

  // set_include_path(dirname(__FILE__) . PATH_SEPARATOR);

  require_once 'libTeeChart.php';

/**
 * TChart class
 *
 * Description: TChart contents
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
  class TChart implements IChart, IEventListener
  {
    private $chart;
    private $backImage;

    protected $scrollable;   
    protected $listeners;

    public $mousePosition;
    public $tmpImg;
    public $width;
    public $height;
    public $eventSource;
    public $eventHandlers;

    public static $controlName='TChart'; 

    
	protected function fireChartPaint() {

  		$event = new ChartEvent($this);
        /* TEST
 	  	foreach ($this->listeners->getRaw() as $listener) {
    		$listener->onMyEvent($event);
  		}
        */
  	}

    function onMyEvent(ChartEvent $event) {
  		echo "Taking short break...\n";
  	}

    /**
    * Serializes the TChart and Chart objects
    */
    public function serialize($chart_s,$prefix){
        if (is_object($chart_s->getChart())) {
            $this->tmpImg=$chart_s->getChart()->getGraphics3D()->img;
            $serialized = Array();
            $serialized=serialize($chart_s->getChart());
            $_SESSION[$prefix."Chart"] =$serialized;
        }
    }

    /**
    * Unserializes the TChart and Chart objects
    */
    public function unserialize($chart_s,$prefix) {
      if (is_string($_SESSION[$prefix."Chart"]))
      {
          $unserialized=unserialize($_SESSION[$prefix."Chart"]);
          $unserialized->getGraphics3D()->img=$this->getGraphics3D()->img;
          $chart_s->setChart($unserialized);
      }
    }

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
    function __construct($width=300,$height=200,$handlers=null)
    {
        English::setTexts();
        
  	    $this->listeners = new EventListenerList();
        if ($handlers)
             $this->eventHandlers = $handlers;
         else           
             $this->eventHandlers = new EventHandlerCollection();
        
        $this->mousePosition = new TeePoint();
        
        $this->width = $width;
        $this->height = $height;

        $this->chart = new Chart($this, null);  
        $this->checkGraphics();

        $this->InitEvents();
        $this->TriggerEvent('OnLoad', array('arg1'=>1));

        // Apply Theme
        //ThemesList::_applyTheme($this->getChart(),new DefaultTheme(($this->getChart())));        
        $t = new Y2009($this->getChart());
        ThemesList::_applyTheme($this->getChart(),$t);        
        unset($t);                
        unset($width);
        unset($height);
        unset($handlers);                
   }

   public function __destruct()
   {        
        //if (isset($this->chart))
            //$this->chart->__destruct();  
        unset($this->chart);        
        
        if (isset($this->backImage))
            $this->backImage->__destruct();          
        unset($this->backImage);
        
        if (isset($this->scrollable))
            $this->scrollable->__destruct();          
        unset($this->scrollable);
        
        if (isset($this->listeners))
            $this->listeners->__destruct();          
        unset($this->listeners);
        
        if (isset($this->tmpImg))
            $this->tmpImg->__destruct();          
        unset($this->tmpImg);
        
        if (isset($this->eventSource))
            $this->eventSource->__destruct();          
        unset($this->eventSource);
                 
        unset($this->eventHandlers);
                
        if (isset($this->mousePosition))
            $this->mousePosition->__destruct();          
        unset($this->mousePosition);
        
        unset($this->width);
        unset($this->height);                    
   }

   public function RegisterEventHandler($handler)
   {
        if ($this->events->Contains($handler->GetEventName()))
            $this->eventHandlers->Add($handler);
   }

   private function InitEvents()
   {
        $this->listeners->add(new ChartEvent('OnLoad'));
        $this->listeners->add(new ChartEvent('OnUnload'));
        $this->listeners->add(new ChartEvent('OnGetAxisLabel'));
   }

   public function TriggerEvent($eventName,$args)
   {
        $this->eventHandlers->RaiseEvent($eventName,$this,$args);
   }

    /**
     * Cleans up any resources being used.
     *
     * @param disposing boolean
     */
    protected function dispose($disposing) {
        if ($disposing) {
            $this->chart->removeAllComponents();
        }
    }

    /**
     * Returns a Dimension object of prefered size.
     */
    public function getPreferredSize() {
        return new Dimension(400, 250);
    }

    /**
     * Determines which Chart is being printed.
     *
     * @return boolean
     */
    public function getPrinting() {
        return $this->chart->printing;
    }

    /**
     * Determines which Chart is being printed.
     *
     * @param boolean $value
     */
    public function setPrinting($value) {
        $this->chart->printing = $value;
        $this->doInvalidate();
    }

    /**
     * True when the Chart is internally drawing into a Metafile image.
     *
     * @return boolean
     */
    public function getMetafiling() {
        return $this->chart->getGraphics3D()->getMetafiling();
    }

    /**
     * Obsolete.&nbsp;Please use Aspect->ClipPoints instead.
     *
     * @return boolean
     *
     * @deprecated
     */
    public function getClipPoints() {
        return $this->chart->getAspect()->getClipPoints();
    }

    /**
     * Obsolete. Please use Aspect->ClipPoints instead.
     *
     * @param boolean $value
     */
    public function setClipPoints($value) {
        $this->chart->getAspect()->setClipPoints($value);
    }

    /**
     * Obsolete.&nbsp;Please use getSeries.getApplyZOrder() instead.
     *
     * @return boolean
     *
     * @deprecated
     */
    public function getApplyZOrder() {
        return $this->chart->getSeries()->getApplyZOrder();
    }

    /**
     * Obsolete.&nbsp;Please use getSeries().setApplyZOrder() instead.
     *
     * @param boolean $value
     *
     * @deprecated
     */
    public function setApplyZOrder($value) {
        $this->chart->getSeries()->setApplyZOrder($value);
    }

    /**
     * The color the Chart rectangle is filled with.<br>
     * The chart rectangle is the screen area between axes. <br>
     * Setting BackColor to Color.EMPTY does not fill the rectangle. <br>
     * Assigning Color->_empty to tChart->getBackColor() makes TeeChart NOT fill the
     * Chart back area, so Gradient fills and Background Bitmaps can be shown.
     *
     * @return Color
     */
    public function getBackColor() {
        return $this->chart->getPanel()->getColor();
    }

    /**
     * Sets the color the Chart rectangle is filled with.<br>
     *
     * @param Color $value
     */
    public function setBackColor($value) {
        $this->setBackground($value);
        $this->doInvalidate();
      }

    public function setBackground($value) {
        $this->chart->getPanel()->setColor($value);
    }

    public function getBackground() {
        return $this->chart->getPanel()->getColor();
    }

    public function mouseDragged($e) {
        $this->mousePosition = $e->getPoint();
    }

    /**
     * Captures current mouse position every time the mouse is moved.
     * @param MouseEvent $e
     */
    public function mouseMoved($e) {
        $this->mousePosition = $e->getPoint();
    }

    /**
     * Obsolete. Please use mousePosition field instead.
     *
     * @return TeePoint
     *
     * @deprecated
     */
    public function getGetCursorPos() {
        return $this->mousePosition;
    }

    /**
     * Adds a new Series.
     *
     * @param Series $s
     * @return Series
     */
    public function addSeries($s) {
        $s->setChart($this->chart);
        $series = $this->chart->getSeries()->add($s);

        // TODO $this->fireChartAdded(new ChartEvent($s, ChartEvent.CHART_ADDED));
        return $series;
    }

    /**
     * Enables/Disables repainting of Chart when points are added.<br>
     * Use AutoRepaint false to disable Chart repainting whilst, for example,
     * adding a large number of points to a Chart Series. This avoidss
     * repainting of the Chart whilst the points are added. <br>
     * AutoRepaint may be re-enabled, followed by a manual Repaint command
     * when all points are added. <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getAutoRepaint() {
        return $this->chart->getAutoRepaint();
    }

    /**
     * Enables/Disables repainting of Chart when points are added.<br>
     * Default value: true
     *
     * @see TChart#getAutoRepaint
     * @param boolean $value
     */
    public function setAutoRepaint($value) {
        $this->chart->setAutoRepaint($value);
        // Do not call invalidate here.
    }

    public function getImage() {
        return $this->getExport()->getImage()->image($this->width, $this->height);
    }

    public function setHeight($value) {
        $this->height=$value;
        $g=$this->getGraphics3D();

        $tmpImg = imagecreatetruecolor($this->width, $this->height);
        imagecopyresized($tmpImg,$g->img,0,0,0,0,$this->width,

        $this->height,ImageSX($g->img),ImageSY($g->img));
        $g->img=$tmpImg;

        $this->doInvalidate();
        imagedestroy($tmpImg);        
    }

    public function setWidth($value) {
        $this->width=$value;
        $g=$this->getGraphics3D();

        $tmpImg = imagecreatetruecolor($this->width, $this->height);
        imagecopyresized($tmpImg,$g->img,0,0,0,0,$this->width,

        $this->height,ImageSX($g->img),ImageSY($g->img));
        $g->img=$tmpImg;

        $this->doInvalidate();
        imagedestroy($tmpImg);        
    }

    /**
     * Removes all Series.
     */
    public function removeAllSeries() {
        $this->chart->getSeries()->clear();
    }

    /**
     * Obsolete.&nbsp;Use TChart.<!-- -->Series.<!-- -->Exchange() instead.
     *
     * @param int $series1
     * @param int $series2
     *
     * @deprecated
     */
    public function exchangeSeries($series1, $series2) {
        $this->chart->getSeries()->exchange($series1, $series2);
    }

    /**
     * Use TChart.<!-- -->getWalls()<!-- -->getPen() instead.
     *
     * @return ChartPen
     */
    public function getFrame() {
        return $this->chart->getWalls()->getBack()->getPen();
    }

    /**
     * Returns the number of Series in Chart.
     *
     * @return int
     */
    public function getSeriesCount() {
        return sizeof($this->chart->getSeries());
    }

    public function setScrollable($scrollable) {
        $this->scrollable = $scrollable;
    }

    public function removeScrollable() {
        $this->scrollable = null;
    }

    /**
     * Returns background image of TChart
     * @return Image
     */
    public function getBackgroundImage() {
        if ($this->backImage == null) {
            $this->backImage = new BufferedImage($this->width, $this->height, 0);
        }
        return $this->backImage;
    }

    public function doDrawImage($g) {
        if ($this->chart->getPanel()->getImage() != null) {
            $g->draw($this->chart->getChartRect(), $this->chart->getPanel()->getImage(),
            $this->getPanel()->getBrush()->getImageMode(),
            $this->getPanel()->getShapeBorders(),false);
        }
    }

    public function paint($g, $rectangle) {
        TChart::$controlName = 'TChart';        
        
        $g=$this->chart->getGraphics3D();
        $g->setGraphics($g);

        if ($this->getBorder() != null) {
            $i = $this->getInsets();
            $rectangle->x += $i->left;
            $rectangle->y += $i->top;
            $rectangle->width -= ($i->left + $i->right);
            $rectangle->height -= ($i->top + $i->bottom);
        }
        $this->chart->paint($g, $rectangle);

        if ($this->getBorder() != null) {
            $this->getBorder()->paintBorder($this, $g, 0, 0, $this->width, $this->height);
        }
    }

    public function _paint($g, $width, $height) {
        $this->paint($g, new Rectangle(0, 0, $width, $height));
    }

    // Events
    public function doBeforeDrawAxes() {
      /*TODO
      $this-> callEvent('onBeforeDrawAxes', array());
      $this->fireChartPaint(new ChartDrawEvent($this, ChartDrawEvent.PAINTING,
                                          ChartDrawEvent.AXES)); 
      */
    }

    public function doAfterDrawSeries() {
        $this->fireChartPaint(new ChartDrawEvent($this, ChartDrawEvent.PAINTED,
                                          ChartDrawEvent.SERIES));
    }

    public function doBeforeDrawSeries() {
        /* TODO 
        $this->fireChartPaint();
        $this->fireChartPaint(new ChartDrawEvent($this, ChartDrawEvent::$PAINTING,
                                          ChartDrawEvent::$SERIES));
        */
    }

    public function doAfterDraw() {
        $this->fireChartPaint(new ChartDrawEvent($this, ChartDrawEvent.PAINTED,
                                          ChartDrawEvent.CHART));
    }

    public function doBeforeDraw() {
        $this->fireChartPaint(new ChartDrawEvent($this, ChartDrawEvent.PAINTING,
                                          ChartDrawEvent.CHART));
    }

    public function doClickSeries($sender, $s, $valueIndex, $e) {
        $this->fireSeriesClick(new SeriesMouseEvent($s, SeriesMouseEvent.SERIES_CLICKED,
                                             $valueIndex, $e));
    }

    public function doAllowScroll($a, $delta, $result) {
        $result->allow = true;
        if ($this->scrollable != null) {
            $result = $this->scrollable->isScrollable($a, $result);
        }
    }

    public function checkBackground($sender, $e) {
        if ($this->fireChartClicked(new ChartMouseEvent($sender,
                                                 ChartMouseEvent.MOUSE_CLICKED,
                                                 ClickedParts.CHARTRECT, e))) {
            $this->chart->cancelMouse = true;
            $this->chart->iClicked = $this->chart->cancelMouse;
        }
    }

    /**
     *
     * @param value Chart
     */
    public function setChart($value) {
        if ($value != null) {
            $this->chart=$value;
            $this->getChart()->setParent($this);
        }
    }

    public function setAxes($axes) {
        $this->chart->setAxes($axes);
    }

    public function setFooter($footer) {
        $this->chart->setFooter($footer);
    }

    public function setFont($font) {
        $this->getGraphics3D()->setFont($font);
    }

    public function setHeader($header) {
        $this->chart->setHeader($header);
    }

    public function setLegend($legend) {
        $this->chart->setLegend($legend);
    }

    public function setSubFooter($subFooter) {
        $this->chart->setSubFooter($subFooter);
    }

    public function setSubHeader($subHeader) {
        $this->chart->setSubHeader($subHeader);
    }

    public function setWalls($walls) {
        $this->chart->setWalls($walls);
    }

    public function setZoom($zoom) {
        $this->chart->setZoom($zoom);
    }

    public function setPrinter($printer) {
        $this->chart->setPrinter($printer);
    }

    public function setPanning($panning) {
        $this->chart->setPanning($panning);
    }

    public function setPanel($panel) {
        $this->chart->setPanel($panel);
    }

    public function setPage($page) {
        $this->chart->setPage($page);
    }

    public function getControl() {
        return $this;
    }

    public function doBaseInvalidate() {
    }

    public function pointToScreen($p) {
        $screen = $this->getLocationOnScreen();
        $p->move( -$screen->x, -$screen->y);
        return $p;
    }

    public function setCursor($c) {
        $this->chart->originalCursor = $c;
    }

    public function refreshControl() {
        $this->paintImmediately($this->chart->chartBounds);
    }

    public function createToolTip()
    {
        return new JMultiLineToolTip();
    }

    /**
     * Defines the Chart to display.
     *
     * @return Chart
     */
    public function getChart() {
        if (isset($this->chart))
            return $this->chart;
        else
            return NULL;
    }

    /**
     * The text for the Footer, Header, SubFooter and SubHeader.
     *
     * @return String
     */
    public function getText() {
        return ($this->chart == null) ? "" : $this->chart->getHeader()->getText();
    }

    /**
     * Sets the text for the Footer, Header, SubFooter and SubHeader.
     *
     * @param String $value
     */
    public function setText($value) {
        if ($this->chart != null) {
            $this->chart->getHeader()->setText($value);
        }
    }

    /**
     * Background visible attributes.<br>
     * Provides access, via the Panel Interface, to all Chart Panel properties.
     *
     * @return TeePanel
     */
    public function getPanel() {
        return $this->getChart()->getPanel();
    }

    /**
     * Printing related attributes.
     *
     * @return Printer
     */
    public function getPrinter() {
        return $this->getChart()->getPrinter();
    }

    /**
     * Accesses multiple page characteristics of the Chart.
     *
     * @return Page
     */
    public function getPage() {
        return $this->chart->getPage();
    }

    /**
     * Legend characteristics.<br>
     * The Legend property determines the text and drawing attributes of
     * Chart's textual representation of Series and Series values.  <br>
     * The Legend class draws a rectangle and for each Series in a Chart
     * (or for each point in a Series) outputs a text representation of
     * that Series (or that point). <br>
     * You can use the Legend.LegendStyle and Legend.TextStyle properties to
     * control the text used to draw the legend. <br>
     * The Legend can be positioned at Left, Right, Top and Bottom chart sides
     * using the Legend.Alignment property. <br>
     * Use the Legend.Visible property to show / hide the Legend. <br>
     * The Inverted property makes Legend to draw text starting from bottom.<br>
     * The Frame, Font and Color properties allow you to change Legend
     * appearance. <br>
     * The Legend.ColorWidth property determines the percent width of each
     * item's "colored" mark. <br>
     * The Legend.FirstValue property controls which Series (or Series point)
     * will be used to draw first Legend item. <br>
     *
     * @return Legend
     */
    public function getLegend() {
        return $this->chart->getLegend();
    }

    /**
     *
     * Defines the Text and formatting properties to be drawn at the top of
     * the Chart.<br>
     * Use Text to enter the desired Header lines, set Visible to True and
     * change the Font, Frame and Brush methods.<br>
     * Use Alignment to control text output position.
     *
     * @return Header
     */
    public function getHeader() {
        return $this->getChart()->getHeader();
    }

    /**
     * Defines Text shown directly below Header.<br>
     * Use the Text method to enter the desired SubHeader lines, set Visible
     * to True and change the Font, Frame and Brush methods.<br>
     * Use the Alignment method to control text output position.
     *
     * @return Header
     */
    public function getSubHeader() {
        return $this->chart->getSubHeader();
    }

    /**
     * Determines the Font characteristics.
     *
     * @return Font
     */
    public function getFont() {
        return $this->getGraphics3D()->getFont();
    }

    /**
     * Defines Text shown at the bottom of the Chart.<br>
     * Use Text to enter the desired Footer lines, set Visible to True and
     * change the Font, Frame and Brush methods.<br>
     * Use Alignment to control text output position.
     *
     * @return Footer
     */
    public function getFooter() {
        return $this->chart->getFooter();
    }

    /**
     * Accesses the Zoom characteristics of the Chart.
     *
     * @return Zoom
     */
    public function getZoom() {
        return $this->chart->getZoom();
    }

    /**
     * Accesses the Scroll characteristics of the Chart.
     *
     * @return Scroll
     */
    public function getScroll() {
        return $this->chart->getScroll();
    }
    
    /**
     * Accesses Panning characteristics. <br><br>
     * Scrolling speed depends on: <br>
     *    The number of Series and Series Points. <br>
     *    The Chart Width and Height. <br>
     *    The computer processor and Video card processor speed. <br>
     *    The Video resolution and number of colors. <br>
     *    The Windows version and the Video driver. <br>
     *    The speed when dragging the mouse !
     *
     * @return Scroll
     */
    public function getPanning() {
        return $this->chart->getPanning();
    }

    /**
     * Defines Text shown directly above Footer.<br>
     * Use Text to enter the desired SubFooter lines, set Visible to True and
     * change the Font, Frame and Brush methods.<br>
     * Use Alignment to control text output position.
     *
     * @return Footer
     */
    public function getSubFooter() {
        return $this->chart->getSubFooter();
    }

    /**
     * Accesses view characteristics of the Chart.<br>
     * 3D view parameters.
     *
     * @return Aspect
     */
    public function getAspect() {
        return $this->chart->getAspect();
    }

    /**
     * Obsolete.&nbsp;Please use getGraphics3D function.
     *
     * @return IGraphics3D
     * @deprecated
     */
    public function getCanvas() {
        return $this->getGraphics3D();
    }

    /**
     * Obsolete.&nbsp;Please use setGraphics3D method.
     *
     * @param IGraphics3D $value
     * @deprecated
     */
    public function setCanvas($value) {
        $this->setGraphics3D($value);
        $this->checkGraphics();
    }

    /**
     * Used to access TeeChart Draw attributes.
     *
     * @param IGraphics3D $value
     */
    public function setGraphics3D($value) {
        $this->chart->setGraphics3D($value);
    }

    /**
     * Collection of Series contained in this Chart.<br><br>
     * TeeChart Series are the data display method type, e.g. Line Series,
     * Bar Series, Pie Series etc. You can mix different Series types in a
     * Chart according to your requirements, thus your design is not limited to
     * just one 'Chart type' defined by TeeChart. The concept of Chart type
     * being virtually obsolete in terms of the number of permutations of
     * Charts (Series type mix) you may create. <br><br>
     * For more information please see "Tutorial 6 - Working with Series".
     *
     * @param int $index
     * @return SeriesCollection or Series depending if parameter has been passed
     */
    public function getSeries($index=-1) {
        if ($index==-1)
            return $this->chart->getSeries();
        else
            return $this->chart->getSeries($index);
    }

    /**
     * Collection of Tool components contained in this Chart.
     *
     * @return ToolsCollection
     */
    public function getTools() {
        return $this->chart->getTools();
    }

    /**
     * Accesses left, bottom and back wall characteristics of the Chart.
     *
     * @return Walls
     */
    public function getWalls() {
        return $this->chart->getWalls();
    }

    /**
     * Collection of predefined and custom axis objects.
     *
     * @return Axes
     */
    public function getAxes() {
        return $this->chart->getAxes();
    }

    /**
     * Accesses Chart export attributess.
     *
     * @return Exports
     */
    public function getExport() {
        return $this->getChart()->getExport();
    }

    /**
     * Accesses Chart import attributes.
     *
     * @return Imports
     */
    public function getImport() {
        return $this->chart->getImport();
    }

    public function setSeries($series) {
        $this->chart->setSeries($series);
    }

    public function _setSeries($index, $value) {
        $this->chart->series->setSeries($index, $value);
    }

    private function prepareGraphics() {
        $this->checkGraphics()->setGraphics($this->getGraphics());
    }

    public function setToolTip($tool, $text) {
        $this->tool->setToolTip($this, $text);
    }

    public function setTools($value) {
        $this->chart->setTools($value);
    }

    // TESTS
  	function addMyEventListener(IEventListener $listener) {
  		$this->listeners->add($listener);
  	}

    public function doInvalidate() {
        $this->paintComponent($this->getGraphics3D());
    }

    protected function paintComponent($g,$rec=null) {
        $this->checkGraphics()->setGraphics($g);

        if($rec==null) 
        {
          $tmp = new Rectangle(0,0,0,0);

          $tmp->x = 0;
          $tmp->y = 0;
          $tmp->width=$this->width;
          $tmp->height=$this->height;
        }
        else
        {
            $tmp = $rec;
        }        
        $this->chart->_paint($this->chart->getGraphics3D(),$tmp);
    }

    /**
    * Render the chart image
    *
    * @access  public
    * @param   string     Name of the file to render the image to (optional)
    */
    function render($fileName = null)
    {
        $this->chart->setAutoRepaint(true);   
        
        $g=$this->chart->getGraphics3D();

        /*TODO 
        if ($g->getImageReflection()==true) {
          $reflection=$g->doReflection($g->img);
        }*/

        if ($g instanceof CanvasMing) 
        {
             $g->getImg()->save($fileName);            
        }
        else
        {
          if ($g->getImageInterlace()==true) {
            imageinterlace($g->img,true);
          }

          if(isset($fileName))
                  imagepng($g->img, $fileName);
          else
                  imagepng($g->img);
        }
        
      
  //      $this->__destruct();
        
        if (isset($g->img))
          imagedestroy($g->img);        
        
        unset($g);      
    }
    
    public function checkGraphics() {
        $g3D=$this->getGraphics3D();

        if ($g3D == null) {
            $g3D = new GraphicsGD($this->chart,$this->width,$this->height);
            $g3D->createImage();
            $this->chart->setGraphics3D($g3D);     
        }

        return $g3D;
    }

    /**
     * Used to access TeeChart Draw attributes.
     *
     * @return GraphicsGD
     */
    public function getGraphics3D() {
        return ($this->chart == null) ? null : $this->chart->getGraphics3D();
    }

    public function getBuildNumber() {
        return Texts::$BuildNumber;
    }
    
    public function doZoomed($sender) {
        //  fireChartMotion(new ChartEvent(sender, ChartEvent.CHART_ZOOMED));
        $this->doBaseInvalidate();
    }
    
  }
?>
