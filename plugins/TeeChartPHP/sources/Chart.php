<?php
 /**
 * Description:  This file contains the following class:<br>
 * Chart class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Chart class
 *
 * Description: Chart contents
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Chart extends TeeBase implements IBaseChart {

    // Private properties
    private $autoRepaint=false;
    private $export;
    private $imports;
    private $toolTip;
    private $listeners;                // TeeEventListeners
    private $savedScales;              // AllAxisSavedScales
    private $numRedraws=0;
    private $panel;
    private $printer;
    private $header, $subHeader;
    private $footer, $subFooter;
    private $walls;
    private $tools;                    // ToolsCollection
    private $jstools;                    // JSToolsCollection
    private $animations;               // AnimationsCollection
    private $panning;                  // Scroll

    // Protected properties
    protected $parent;                 // IChart
    protected $cancelMouse;
    protected $IClicked;
    protected $graphics3D;
    protected $restoredAxisScales;
    protected $printing;
    protected $seriesWidth3D=0;
    protected $legendPen=null;
    protected $maxZOrder=0;
    protected $aspect;
    protected $axes;
    protected $legend;
    protected $page;
    protected $series;                 // SeriesCollection
    protected $chartBounds;
    protected $zoom;                   // Zoom
    protected $scroll;                   // Scroll    
    protected $originalCursor;         // Cursor
    protected $chartRect;

    // Public properties
    public $clipWhenPrinting=true;     /* Apply clipping when printing */
    public $clipWhenMetafiling=true;
    public $seriesHeight3D=0;
    public $left,$top,$right,$bottom;  // AxisSavedScales

    // Class definition

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
    function __construct($parent=null, $cursor=null) {
        
        if ($parent==null)
        {
            $this->chartBounds=new Rectangle(0,0,0,0);
            $this->chartRect=new Rectangle(0,0,0,0);                  
        }
        else
        {
            $this->chartBounds=new Rectangle(0,0,
                $parent->width, $parent->height);
            $this->chartRect=new Rectangle(0,0,
                $parent->width, $parent->height);
        }

        parent::__construct($parent);  // TeeBase

        TChart::$controlName =' Chart_';

        $this->initFields();
        $this->readResolve();
        $this->parent = $parent;        
        $this->originalCursor = $cursor;

        // Apply Gradient temp..until Themes...
        //$this->getPanel()->getGradient()->setVisible(true);
    }
    
    function __destruct()
    {
        parent::__destruct();        

        unset($this->autoRepaint);        
            
        if (isset($this->export))
          $this->export->__destruct();        
        unset($this->export);
        
        if (isset($this->imports))
          $this->imports->__destruct();          
        unset($this->imports);
        
        if (isset($this->toolTip))
          $this->toolTip->__destruct();        
        unset($this->toolTip);

        if (isset($this->listeners))
          $this->listeners->__destruct();                
        unset($this->listeners);           
             
        unset($this->savedScales);       
        unset($this->numRedraws);
        
        if (isset($this->panel))
          $this->panel->__destruct();          
        unset($this->panel);

        if (isset($this->printer))
          $this->printer->__destruct();                
        unset($this->printer);

        unset($this->header);

        if (isset($this->subHeader))
          $this->subHeader->__destruct();                
        unset($this->subHeader);
        
        if (isset($this->footer))
          $this->footer->__destruct();                
        unset($this->footer);
        
        if (isset($this->subFooter))
          $this->subFooter->__destruct();                
        unset($this->subFooter);
        
        if (isset($this->walls))
          $this->walls->__destruct();
        unset($this->walls);
        
        unset($this->tools);             
        
        if (isset($this->jstools))
          $this->jstools->__destruct();        
        unset($this->jstools);           
        
        if (isset($this->animations))
          $this->animations->__destruct();                
        unset($this->animations);        
        
        if (isset($this->panning))
          $this->panning->__destruct();        
        unset($this->panning);           

        unset($this->parent);         
        unset($this->cancelMouse);
        unset($this->IClicked);
        
        if ($this->getGraphics3D()!=NULL)
            $this->getGraphics3D()->__destruct();
        unset($this->graphics3D);
        
        unset($this->restoredAxisScales);
        unset($this->printing);
        unset($this->seriesWidth3D);
               
        unset($this->maxZOrder);
        
        if(isset($this->aspect))
          $this->aspect->__destruct();
        unset($this->aspect);

        if (isset($this->axes))
        {
          $this->axes->__destruct();        
          unset($this->axes);
        }
        
        unset($this->legend);
        
        if (isset($this->page))
          $this->page->__destruct();
        unset($this->page);
        
        for ($i=0;$i<$this->getSeriesCount();$i++)
        {           
            $s = $this->getSeries($i);
            if (isset($s))
            {
              $this->getSeries($i)->__destruct();
              unset($s);
            }
        }        
        
//        if (isset($this->series))
//          $this->series->__destruct();
//        unset($this->series);         
                
        if (isset($this->chartBounds))
          $this->chartBounds->__destruct();
        unset($this->chartBounds);
        
        if (isset($this->zoom))
          $this->zoom->__destruct();
        unset($this->zoom);    
                     
        if (isset($this->scroll))
          $this->scroll->__destruct();
        unset($this->scroll);    
                   
        if (isset($this->originalCursor))
          $this->originalCursor->__destruct();
        unset($this->originalCursor);       
        
        if (isset($this->chartRect))
          $this->chartRect->__destruct();
        unset($this->chartRect);

        unset($this->clipWhenPrinting);
        unset($this->clipWhenMetafiling);
        unset($this->seriesHeight3D);
        unset($this->left);
        unset($this->top);
        unset($this->right);
        unset($this->bottom);  
        unset($i);                 
    }
    
    private function initFields() {
        $this->setChart($this);        
        $this->series = new SeriesCollection($this);        
        $this->tools = new ToolsCollection($this);        
        $this->jstools = new JsToolsCollection($this);
        $this->animations = new AnimationsCollection($this);        
        $this->aspect = new Aspect($this);
        $this->panel = new TeePanel($this);
        $this->legend = new Legend($this);
        $this->header = new Header($this);
        $this->header->defaultText = "TeeChart";
        $this->header->setText($this->header->defaultText);
        $this->subHeader = new Header($this);
        $this->footer = new Footer($this);
        $this->subFooter = new Footer($this);
        $this->walls = new Walls($this);
        $this->axes = new Axes($this);
        $this->page = new TeePage($this);        
        $this->export = new Exports($this);
        $this->imports = new Imports($this);        
        // TODO      $this->printer = new Printer($this);
    }

    /**
     * Main drawing procedure. Paints all Chart contents.
     *
     * @param g IGraphics3D
     */
    private function internalDraw($g) {
        $this->seriesBeforeDraw();
        $rect = $this->chartRect;
        $this->chartRect = $this->drawTitlesAndLegend($g, $rect, true);
        $this->setSeriesZOrder();
        $rect = $this->calcWallsRect($rect);
        $this->chartRect = $rect;
        $this->calcAxisRect();
        $rect = $this->chartRect;
        $this->setSeriesZPositions();
        $this->calcSeriesRect();
        
        $g->projection($this->aspect->width3D, $this->chartRect);
        
        TChart::$controlName = 'Chart_';             
                
        if ($this->series->activeUseAxis() && ($this->walls->getVisible())) {
            TChart::$controlName .='Walls_';
            $this->walls->paint($g,$rect);
        }
        
        TChart::$controlName = 'Chart_';                     
                
        if ($this->axes->getDrawBehind()) {
            TChart::$controlName .='Axes_';            
            $this->axes->draw($g);
        }

        TChart::$controlName = 'Chart_';             
                        
        //  Draw all Tools...
        $tmpChartDrawEvent = new ChartDrawEvent($this, ChartDrawEvent::$PAINTING,
                                              ChartDrawEvent::$SERIES);
        $this->broadcastToolEvent($tmpChartDrawEvent);

        if ($this->parent != null) {
            $this->parent->doBeforeDrawSeries();
        }

        $oldStrAlign = $g->getTextAlign();

        TChart::$controlName = 'Chart_';                     
        
        // Draw all Series...
        if ($this->axes->getDepth()->getInverted()) {
            for ($t = sizeof($this->series) - 1; $t >= 0; $t--) {
                $s = $this->series->getSeries($t);
                if ($s->getActive()) {
                    TChart::$controlName .='Series' . $t .'_';
                    $s->drawSeries();
                }
            }
        } else {
            for ($t = 0; $t < sizeof($this->series); $t++) {
                $s = $this->series->getSeries($t);
                if ($s->getActive()) {
                    TChart::$controlName .='Series' . $t .'_';
                    $s->drawSeries();
                }
            }

            $g->setTextAlign($oldStrAlign);
        }

        /* TODO
        if ($this->parent != null) {
            $this->parent->doAfterDrawSeries();
        }*/

        TChart::$controlName = 'Chart_';                     
        
        if (!$this->axes->getDrawBehind()) {
            TChart::$controlName .='Axes_';
            $this->axes->draw($g);
        }

        TChart::$controlName = 'Chart_';                     
        
        $rect = $this->drawTitlesAndLegend($g, $rect, false);

        // Draw all tools
        $tmpChartDrawEvent = new ChartDrawEvent($this, ChartDrawEvent::$PAINTED,
                                              ChartDrawEvent::$CHART);
        $this->broadcastToolEvent($tmpChartDrawEvent);

        // UTILS g.textOut(0, 0, 0, Integer.toString(numRedraws++));

        if (REV) {
            $g->doRev();
        }
                                          
        unset($tmpChartDrawEvent);
        unset($rect);
        unset($oldStrAlign);        
    }                                                                                            

    private function readObject($in) 
    {
        $this->initFields();
        $in->defaultReadObject();
    }

    protected function readResolve() {

        $this->aspect->setChart($this);
        $this->panel->setChart($this);
        $this->legend->setChart($this);
        $this->header->setChart($this);
        $this->subHeader->setChart($this);
        $this->footer->setChart($this);
        $this->subFooter->setChart($this);
        $this->walls->setChart($this);
        $this->axes->setChart($this);
        $this->page->setChart($this);
        
        $this->export->setChart($this);
        $this->imports->setChart($this);
        // TODO  $this->printer->setChart($this);        
        $this->series->setChart($this);    
        $this->tools->setChart($this);
        $this->jstools->setChart($this);
        $this->restoredAxisScales = true;
        $this->maxZOrder = 0;

        $parent = $this->getParent();
        if ($parent != null) {
            $parent->checkGraphics();
        }

        unset($parent);
        
        return $this;
    }

    public function recalcWidthHeight($r) {
        if ($r->x < $this->chartBounds->x) {
            $r->x = $this->chartBounds->x;
        }
        if ($r->y < $this->chartBounds->y) {
            $r->y = $this->chartBounds->y;
        }
        if ($r->getRight() < $this->chartBounds->x) {
            $r->width = 1;
        } else
        if ($r->getRight() == $this->chartBounds->x) {
            $r->width = $this->chartBounds->width;
        }
        if ($r->getBottom() < $this->chartBounds->y) {
            $r->height = 1;
        } else
        if ($r->getBottom() == $this->chartBounds->y) {
            $r->height = $this->chartBounds->height;
        }

        $this->graphics3D->setXCenter(($r->x + $r->getRight()) / 2);
        $this->graphics3D->setYCenter(($r->y + $r->getBottom()) / 2);

        return $r;
    }

    public function cloner() {
        $c = new Chart();

        $stream = new ByteArrayOutputStream();
        try {
            $this->getExport()->getTemplate()->toStream($stream);
        } catch (Exception $ex) { 
            $ex->printStackTrace();
        }

        $inputStream = new ByteArrayInputStream($stream->toByteArray());

        try {
            $c = $c->getImport()->getTemplate()->fromStream($inputStream);
        } catch (Exception $ex) {  
            $ex->printStackTrace();
        }
        catch (Exception $ex) {  
            $ex->printStackTrace();
        }

        return $c;
    }

    /**
     * @return Image
     */
    public function image($width, $height) {
        return $this->getExport()->getImage()->image($width, $height);
    }

    /**
     * (Read only) Used to get the four sides of the Chart (Left, Top,
     * Right and Bottom)
     *
     * @return Rectangle
     */
    public function getChartBounds() {
        return $this->chartBounds;
    }

    /**
     * Sets the four sides of the Chart (Left, Top,
     * Right and Bottom)
     *
     * @param value Rectangle
     */
    public function setChartBounds($value) {
        $this->chartBounds = $value;
        $this->invalidate();
    }

    /**
     * The Chart width in pixels.
     *
     * @return int
     */
    public function getWidth() {
        return $this->chartBounds->width;
    }

    /**
     * Sets the Chart width in pixels.
     *
     * @param value int
     */
    public function setWidth($value) {
        $this->chartBounds->width = $value;
        $this->invalidate();
    }

    /**
     * The Chart Height in pixels.
     *
     * @return int
     */
    public function getHeight() {
        return $this->chartBounds->height;
    }

    /**
     * Sets the Chart Height in pixels.
     *
     * @param value int
     */
    public function setHeight($value) {
        $this->chartBounds->height = $value;
        $this->invalidate();
    }

    public function getLeft() {
        return $this->chartBounds->getLeft();
    }

    public function getRight() {
        return $this->chartBounds->getRight();
    }

    public function getTop() {
        return $this->chartBounds->getTop();
    }

    protected function getChartRectBottom() {
        return $this->chartRect->getBottom();
    }

    protected function chartRectWidth() {
        return $this->chartRect->width;
    }

    protected function chartRectHeight() {
        return $this->chartRect->height;
    }

    // IBaseChart
    public function doChangedBrush($value) {
        if ($this->graphics3D != null) {
            if ($value === $this->graphics3D->getBrush()) {
                $this->graphics3D->changed($this->graphics3D->getBrush());
              }
        }
    }

    public function doChangedFont($value) {
        if ($this->graphics3D != null) {
            $this->graphics3D->changed($this->graphics3D->getFont());
        }
    }

    public function canDrawPanelBack() {
        return ((!$this->printing) || getPrinter().getPrintPanelBackground());
    }

    /**
     * Determines when Chart is being printed.
     *
     * @return boolean
     */
    public function getPrinting() {
        return $this->printing;
    }

    /**
     * Determines when Chart is being printed.
     *
     * @param value boolean
     */
    public function setPrinting($value) {
        $this->printing = $value;
    }

    public function setCancelMouse($value) {
        $this->cancelMouse = $value;
    }

    // return Series
    static public function changeSeriesType($series, $newClass) {
        $type = $newClass;
        $tmpFunction = $series->getFunction();
    }

    /* TODO
    static public function changeAllSeriesType($chart, $newClass) {
        $tmp; // Series
        
        List $tmpList = new ArrayList(chart.getSeries());
        Iterator it = tmpList.iterator();
        while (it.hasNext()) {
            Series s = (Series) it.next();
            changeSeriesType(s, newClass);
        }
    }
    */

    protected function removeAllComponents() {
        $this->series->clear();
        $this->tools->clear();
        $this->jstools->clear();
        $this->axes->getCustom()->clear();
    }

    /**
     * Returns array list of objects that implement the
     * TeeEventListener interface.
     *
     * @return TeeEventListeners
     */
    public function  getListeners() {
        if ($this->listeners == null) {
            $this->listeners = new TeeEventListeners();
        }
        return $this->listeners;
    }

    protected function removeListener($sender) {
        if ($this->listeners != null) {
            $this->listeners->remove($sender);
        }
    }

    // Return boolean
    public function isValidDataSource($s, $source) {
    /*  TODO        
      $result = (($s != $source) && ($source instanceof Series) &&
                          (s.isValidSourceOf((Series) source)));

        if (!result) {
            result = DataSeriesSource::isValidSource(source);
        }

        return $result;
     */   
    }

    // Parameter Axis
    private function calcNumPages($a) {
        // By default, one single page.
        $result = 1;

        // Calc max number of points for all active series associated to "a" axis.
        $tmp = 0;
        $firstTime = true;

        for ($t = 0; $t < $this->series->count(); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getActive() && $s->associatedToAxis($a)) {
                if ($firstTime || ($s->getCount() > $tmp)) {
                    $tmp = $s->getCount();
                    $firstTime = false;
                }
            }

            // If there are points... divide into pages... }
            if ($tmp > 0) {
                $result = $tmp / $this->page->getMaxPointsPerPage();

                // Extra page for remaining points...
                if (($tmp % $this->page->getMaxPointsPerPage()) > 0) {
                    $result++;
                }
            }

        }
        
        unset($tmp);
        unset($firstTime);
        
        return $result;
    }

    // restore the "remembered" axis scales when unzooming
    static private function restoreAxisScales($a=null, $tmp=null) {
        if(($a==null) && ($tmp==null)) {
                if (!$this->restoredAxisScales) {
                    $this->restoreScales($this->savedScales);
                    $this->restoredAxisScales = true;
                }
        }
        else
        {
                $a->setAutomatic($tmp->auto);
                $a->setAutomaticMinimum($tmp->autoMin);
                $a->setAutomaticMaximum($tmp->autoMax);
                if (!$a->getAutomatic()) {
                    $a->setMinMax($tmp->min, $tmp->max);
                }
        }
    }

    public function getNumPages() {
        if (($this->page->getMaxPointsPerPage() > 0) && ($this->getSeries()->count() > 0)) {
            if ($this->getSeries()->getSeries(0)->getYMandatory()) {
                return max($this->calcNumPages($this->axes->getTop()),
                                $this->calcNumPages($this->axes->getBottom()));
            } else {
                return max($this->calcNumPages($this->axes->getLeft()),
                                $this->calcNumPages($this->axes->getRight()));
            }
        } else {
            return 1;
        }
    }

    /**
     * Displays a text box at the cursor.
     *
     * @return ToolTip
     */
    public function getToolTip() {
        if ($this->toolTip == null) {
            $this->toolTip = new ToolTip($this);
        }
        return $this->toolTip;
    }

    /**
     * Returns the Active series (visible) that corresponds to the
     * ItemIndex position in the Legend.<br>
     * When the Legend style is "Series", returns the series that corresponds
     * to the Legend "ItemIndex" position. The "OnlyActive" parameter, when
     * false takes into account all series, visibly active or not.
     *
     * @param itemIndex int
     * @return Series that corresponds to the ItemIndex position in the Legend
     */
    public function activeSeriesLegend($itemIndex) {
        return $this->seriesLegend($itemIndex, true);
    }

    /**
     * Returns the Series.Title string.
     *
     * @param seriesIndex int
     * @param onlyActive boolean
     * @return String
     */
    public function getSeriesTitleLegend($seriesIndex, $onlyActive) {
        $tmpSeries = null;

        if ($onlyActive) {
            $tmpSeries = $this->activeSeriesLegend($seriesIndex);
        } else {
            $tmpSeries = $this->seriesLegend($seriesIndex, false);
        }

        return ($tmpSeries != null) ? $tmpSeries->toString() : "";
    }

    private function seriesBeforeDraw() {
        for ($t = 0; $t < sizeof($this->series); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getActive()) {
                $s->doBeforeDrawChart();
            }
        }
        unset($t);
    }

    /**
     * Accesses the Zoom characteristics of the Chart.
     *
     * @return Zoom
     */
    public function getZoom() {
        if ($this->zoom == null) {
            $this->zoom = new Zoom($this);
        }
        return $this->zoom;
    }

    public function setZoom($zoom) {
        $this->zoom = $zoom;
    }

    /**
     * Accesses the Scroll characteristics of the Chart.
     *
     * @return Scroll
     */
    public function getScroll() {
        if ($this->scroll == null) {
            $this->scroll = new Scroll($this);
        }
        return $this->scroll;
    }

    public function setScroll($scroll) {
        $this->scroll = $scroll;
    }
    
    /**
     * Sets the scrolling direction or denies scrolling.
     *
     * @return Scroll
     */
    public function getPanning() {
        if ($this->panning == null) {
            $this->panning = new Scroll($this);
        }
        return $this->panning;
    }

    public function setPanning($panning) {
        $this->panning = $panning;
    }

    private function calcSize3DWalls() {
        if ($this->aspect->getView3D()) {

            $tmp = 0.001 * $this->aspect->getChart3DPercent();

            if (!$this->aspect->getOrthogonal()) {
                $tmp *= 2;
            }

            $this->seriesWidth3D = MathUtils::round($tmp * $this->chartBounds->width);

            if ($this->aspect->getOrthogonal()) {
                $tmpSin = sin($this->aspect->getOrthoAngle() *
                                         MathUtils::getPiStep());
                $tmpCos = cos($this->aspect->getOrthoAngle() *
                                         MathUtils::getPiStep());
                $tmp = $tmpSin / $tmpCos;
                unset($tmpCos);
                unset($tmpSin);
            } else {
                $tmp = 1;
            }

            if ($tmp > 1) {
                $this->seriesWidth3D = MathUtils::round($this->seriesWidth3D / $tmp);
            }

            $this->seriesHeight3D = MathUtils::round($this->seriesWidth3D * $tmp);

            $tmpNumSeries = $this->aspect->getApplyZOrder() ?
                               max(1, $this->maxZOrder + 1) : 1;

            $this->aspect->height3D = $this->seriesHeight3D * $tmpNumSeries;
            $this->aspect->width3D = $this->seriesWidth3D * $tmpNumSeries;
            unset($tmp);                         
            unset($tmpNumSeries);
        } else {
            $this->seriesHeight3D = 0;
            $this->seriesWidth3D = 0;
            $this->aspect->height3D = 0;
            $this->aspect->width3D = 0;
        }
    }

    public function getSeriesIndexOf($value) {
        return $this->series->indexOf($value);
    }

    /**
     * Collection of Series contained in this Chart.
     *
     * @return SeriesCollection
     */
    public function getSeriesCollection() {
        return $this->series;
    }

    /**
    * Returns the Series at seriesIndex
    *
    * @param int $seriesIndex
    * @return Series
    */
    public function getSeries($seriesIndex=-1) {
        if ($seriesIndex==-1) {
            return $this->series;
        }
        else
        {
            return $this->series->getSeries($seriesIndex);
        }
    }

    public function setSeriesCollection($value) {
        $this->series = $value;
        $this->series->chart = $this;
    }

    private function checkTitle($t, $e, $c) {
        if ($this->parent != null) {
            $this->parent->checkTitle($t, $e, $c);
        }
    }
    
    // "remember" the axis scales when zooming, to restore if unzooming.
    static private function saveAxisScales($a) {
        $result = new AxisSavedScales();
        $result->auto = $a->getAutomatic();
        $result->autoMin = $a->getAutomaticMinimum();
        $result->autoMax = $a->getAutomaticMaximum();
        $result->min = $a->getMinimum();
        $result->max = $a->getMaximum();
        return $result;
    }
    
    private function saveScales() {
        $result = new AllAxisSavedScales();
        $result->top = self::saveAxisScales($this->getAxes()->getTop());
        $result->bottom = self::saveAxisScales($this->getAxes()->getBottom());
        $result->left = self::saveAxisScales($this->getAxes()->getLeft());
        $result->right = self::saveAxisScales($this->getAxes()->getRight());
        return $result;
    }

    private function restoreScales($s) {                
        $this->restoreAxisScales($this->getAxes()->getTop(), $s->top);
        $this->restoreAxisScales($this->getAxes()->getBottom(), $s->bottom);
        $this->restoreAxisScales($this->getAxes()->getLeft(), $s->left);
        $this->restoreAxisScales($this->getAxes()->getRight(), $s->right);
    }
    
    public function doZoom($topx, $topy, $bottomx, $bottomy, $leftx, $lefty, $rightx, $righty) {
        $this->doZoomPoints(new PointDouble($topx, $topy),
               new PointDouble($bottomx, $bottomy),
               new PointDouble($leftx, $lefty),
               new PointDouble($rightx, $righty));
    }

    public function doZoomPoints($top, $bot, $lef, $rig) {
        if ($this->restoredAxisScales) {
            $this->savedScales = $this->saveScales();
            $this->restoredAxisScales = false;
        }

        // final zoom
        $this->getAxes()->getLeft()->setMinMax($lef->x, $lef->y);
        $this->getAxes()->getRight()->setMinMax($rig->x, $rig->y);
        $this->getAxes()->getTop()->setMinMax($top->x, $top->y);
        $this->getAxes()->getBottom()->setMinMax($bot->x, $bot->y);
        $this->getZoom()->setZoomed(true);

        if ($this->parent != null) {
            $this->parent->doZoomed($this);
        }
    }

    /**
     * Obsolete.Please use tChart1.<!-- -->Zoom.<!-- -->Undo method.
     */
    public function undoZoom() {
        $this->zoom->undo();
    }

    private function activeSeriesUseAxis() {
        for ($t = 0; $t < sizeof($this->series); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getActive() && $s->getUseAxis()) {
                return true;
            }
        }
        return false;
    }

    public function setBrushCanvas($aColor, $aBrush, $aBackColor) {
//      if ((!aBrush.Solid) && (AColor==aBackColor))
//        if (aBackColor==Color.black) aColor=Color.WHITE; else aColor=Color.black;

        $this->graphics3D->setBrush($aBrush);
        if ($aBrush->getGradientVisible()) {
            $this->graphics3D->getBrush()->getGradient()->setStartColor($aColor);
        }
        else {
            $this->graphics3D->getBrush()->setColor($aColor); ////#1482 ColorEach
        }
    }

    /**
     * Returns the number of active (visible) series.<br>
     * CanClip returns if the Chart Drawing Canvas has the capability of
     * "clipping" lines and polygons.<br>
     * "Clipping" means the feature that allows hiding drawing outside the
     * rectangle or polygon specifed by the developer.<br>
     * CanClip returns false when the Chart is displayed in OpenGL 3D, or when
     * the Chart is printed and the TeeClipWhenPrinting constant is true, or
     * when the Chart is converted to a metafile image and the
     * TeeClipWhenMetafiling constant is true. <br>
     * By default all display drivers and printers support clipping. You can
     * turn off the clipping constants in case the printer or display driver
     * has a bug related to clipping. <br>
     * See also: <br>
     * ClipPoints, TeeClipWhenPrinting, TeeClipWhenMetafiling, ClipCanvas,
     * UnClipCanvas, ClipRoundRectangle and ClipPolygon.
     *
     * @return boolean
     */
    public function canClip() {
        return (!$this->graphics3D->getSupportsFullRotation()) &&
                (((!$this->printing) && (!$this->graphics3D->getMetafiling())) ||
                 ($this->printing && $this->clipWhenPrinting) ||
                 ($this->graphics3D->getMetafiling() && $this->clipWhenMetafiling)
                );
    }

    // Return Rectangle
    private function calcWallsRect($r) {
        $this->calcSize3DWalls();

        // for orthogonal only :
        if ($this->aspect->getView3D() && $this->aspect->getOrthogonal()) {
            $tmp = 0;

            if ($this->activeSeriesUseAxis()) {
                $tmp = $this->getWalls()->getBack()->getSize();
            }

            $r->width -= abs($this->aspect->width3D) + $tmp;
            $t = abs($this->aspect->height3D) + $tmp;
            $r->height -= $t;
            $r->y += $t;

            if ($this->getWalls()->getRight()->getVisible()) {
                $r->width -= $this->getWalls()->getRight()->getSize() + 1;
            }
        }

        return $this->recalcWidthHeight($r);
    }

    /**
     * Returns if no series are active (visible) and associated to the
     * Axis "a" parameter.
     *
     * @param a Axis
     * @return boolean
     */
    private function noActiveSeries($a) {
        for ($t = 0; $t < $this->series->count(); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getActive() && $s->associatedToAxis($a)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns the first Series that depends on the specified Axis.<br>
     * If no Series depends on Axis, the null value is returned.
     *
     * @param axis Axis
     * @return Series
     */
    public function getAxisSeries($axis) {
        for ($t = 0; $t < sizeof($this->series); $t++) {
            $s = $this->getSeries($t);
            if (($s->getActive() || $this->noActiveSeries($axis)) &&
                $s->associatedToAxis($axis)) {
                return $s;
            }
        }

        return null;
    }

    public function internalMinMax($aAxis, $isMin, $isX) {
        $firstTime = true;
        $tmp = 0;
        $tmpResult = 0;

        if ($aAxis->isDepthAxis) {
            if ($aAxis->calcLabelStyle() == AxisLabelStyle::$VALUE) {
                $tmpResult = 0;
                $firstTime = true;
                for ($t = 0; $t < $this->series->count(); $t++) {
                    $s = $this->series->getSeries($t);
                    if ($s->getActive()) {
                        $tmp = $isMin ? $s->getMinZValue() : $s->getMaxZValue();
                        if ($firstTime || (isMin && (tmp < tmpResult)) ||
                            ((!$isMin) && ($tmp > $tmpResult))) {
                            $firstTime = false;
                            $tmpResult = $tmp;
                        }
                    }
                }
            } else {
                $tmpResult = $isMin ? -0.5 : $this->maxZOrder + 0.5;
            }
        } else {
            $tmpResult = 0;
            $tmpSeries = $this->getAxisSeries($aAxis);
            $tmpPagingAxis = ($tmpSeries != null) ?
                                    $tmpSeries->getYMandatory() ?
                                    $isX :
                                    !$isX : $isX;

            if (($this->page->getMaxPointsPerPage() > 0) && $tmpPagingAxis) {
                if (($tmpSeries != null) && ($tmpSeries->getCount() > 0)) {

                    $tmpList = $isX ? $tmpSeries->getXValues() :
                                        $tmpSeries->getYValues();

                    $tmpFirstPoint = ($this->page->getCurrent() - 1) *
                                        $this->page->getMaxPointsPerPage();
                    $tmpCount = $tmpSeries->getCount();

                    if ($tmpCount <= $tmpFirstPoint) {
                        $tmpFirstPoint = (max(0,($tmpCount /
                                $this->page->getMaxPointsPerPage()) - 1) *
                                         $this->page->getMaxPointsPerPage());
                    }

                    $tmpLastPoint = $tmpFirstPoint +
                                       $this->page->getMaxPointsPerPage() - 1;

                    if ($tmpCount <= $tmpLastPoint) {
                        $tmpLastPoint = $tmpFirstPoint +
                                       ($tmpCount %
                                        $this->page->getMaxPointsPerPage()) - 1;
                    }

                    if ($isMin) {
                        $tmpResult = $tmpList->value[$tmpFirstPoint];
                    } else {
                        $tmpResult = $tmpList->value[$tmpLastPoint];

                        if (!$this->page->getScaleLastPage()) {
                            $tmpNumPoints = $tmpLastPoint - $tmpFirstPoint + 1;

                            if ($tmpNumPoints < $this->page->getMaxPointsPerPage()) {

                                $tmp = $tmpList->value[$tmpFirstPoint];
                                $tmpResult = $tmp +
                                            $this->page->getMaxPointsPerPage() *
                                            ($tmpResult - $tmp) /
                                            $tmpNumPoints;
                            }
                        }
                    }
                }
            } else {
                $firstTime = true;
                for ($t = 0; $t < sizeof($this->series); $t++) {
                    $s = $this->series->getSeries($t);

                    if (($s->getActive() || $this->noActiveSeries($aAxis)) &&
                        ($s->getCount() > 0)) {
                        if (($isX &&
                             (($s->getHorizontalAxis() == HorizontalAxis::$BOTH) ||
                              ($s->getHorizAxis() === $aAxis))) ||
                            ((!$isX) &&
                             (($s->getVerticalAxis() == VerticalAxis::$BOTH) ||
                              ($s->getVertAxis() === $aAxis)))) {

                            if ($isMin) {
                                $tmp = $isX ? $s->getMinXValue() :
                                      $s->getMinYValue();
                            } else {
                                $tmp = $isX ? $s->getMaxXValue() :
                                      $s->getMaxYValue();
                            }

                            if ($firstTime || ($isMin && ($tmp < $tmpResult)) ||
                                ((!$isMin) && ($tmp > $tmpResult))) {
                                $tmpResult = $tmp;
                                $firstTime = false;
                            }
                        }
                    }
                }
            }
        }
        return $tmpResult;
    }

    /**
     * Returns the Maximum width in pixels of all Series Labels, whether
     * active or not.<br>
     * This applies only to Series which have Labels.
     *
     * @return int
     */

    public function maxTextWidth() {
        $tmpResult = 0;
        for ($t = 0; $t < sizeof($this->series); $t++) {
            $s = $this->series->getSeries($t);
            $labels=$s->getLabels();
            if (sizeof($labels) > 0) {
                for ($tt = 0; $tt < $s->getCount(); $tt++) {
                    $tmp=$this->multiLineTextWidth($labels[$tt]);
                    $tmpResult = max($tmpResult,
                    $tmp->width);
                }
            }
        }
        return $tmpResult;
    }

    /**
     * Returns the Maximum width of the Active Series Marks.<br>
     * Series Marks must be Visible. This can be used to adjust the Chart
     * Margins in order to accomodate the biggest Series Mark.
     *
     * @return int
     */
    public function maxMarkWidth() {
        $tmpResult = 0;
        for ($t = 0; $t < $this->series->count(); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getActive()) {
                $tmpResult = max($tmpResult, $s->maxMarkWidth());
            }
        }
        return $tmpResult;
    }


    private function calcString($result, $st) {
        $result->tmpResult = max($result->tmpResult,
                            $this->getGraphics3D()->textWidth($st));
        $result->numLines++;
        return $result;
    }

    public function multiLineTextWidth($s) {
        $result = new MultiLine();

        // Note our use of ===.  Simply == would not work as expected
        // because the position of 'a' was the 0th (first) character.
        $i = strpos($s, Language::getString("LineSeparator"));

        if ($i === FALSE) {
            $result->count = 1;
            $result->width = $this->graphics3D->textWidth($s);
        } else {
            $tmpResult = 0;
            $r = new CalcStringResults();

            while ($i !== false) {
                $r = $this->calcString($r, substr($s, 0, $i + 1));
                $tmpResult = $r->tmpResult;

                $s = substr($s,$i + 1);
                $i = strpos($s, Language::getString("LineSeparator"));
            }

            $result->count = $r->numLines;
            $result->width = $r->tmpResult;

            if (strlen($s) != 0) {
                $result->count++;
                $result->width = max($tmpResult, $this->graphics3D->textWidth($s));
            }
        }
        return $result;
    }

    /**
     * Returns the Maximum Value of the Series X Values List.
     *
     * @param axis Axis
     * @return double
     */
    public function getMaxXValue($axis) {
        return $this->internalMinMax($axis, false, true);
    }

    /**
     * Returns the highest of all the current Series Y point values.
     *
     * @param axis Axis
     * @return double
     */
    public function getMaxYValue($axis) {
        return $this->internalMinMax($axis, false, false);
    }

    /**
     * Returns the Minimum Value of the Series X Values List.
     *
     * @param axis Axis
     * @return double
     */
    public function getMinXValue($axis) {
        return $this->internalMinMax($axis, true, true);
    }

    /**
     * Returns the Minimum Value of the Series Y Values List.
     *
     * @param axis Axis
     * @return double
     */
    public function getMinYValue($axis) {
        return $this->internalMinMax($axis, true, false);
    }

    /**
     * Returns whether the AColor parameter is used by any Series or not.
     *
     * @param color Color
     * @param checkBackground boolean When true, uses current Chart background
     * @return boolean
     */
    public function isFreeSeriesColor($color, $checkBackground) {
        $isUsed = ($checkBackground &&
                          (($color == $this->panel->getColor()) ||
                           ($color == $this->walls->getBack()->getColor())));

        for ($t = 0; $t < $this->series->count(); $t++) {
            $s = $this->series->getSeries($t);
            if (($s->getColor() == $color) || $isUsed) {
                return false;
            }
        }

        return !$isUsed;
    }

    /**
     * Returns a color from the default color palette not used by any Series.
     * <br>
     * The CheckBackGround parameter controls if the returned color should
     * or shouldn't be the Chart BackColor color. This function returns a
     * Color which is not used by any Series in the Chart.
     *
     * @param checkBackground boolean
     * @return Color
     */
    public function freeSeriesColor($checkBackground) {
        if ($this->getGraphics3D() == null) {
            return new Color(255,255,255);
        } else {
            $t = 0;
            $g=$this->getGraphics3D();

            do {
                $result = $g->getDefaultColor($t);
                if ($this->isFreeSeriesColor($result, $checkBackground)) {
                    return $result;
                } else {
                    $t++;
                }
            } while ($t < $g->getColorPaletteLength());

            return $g->getDefaultColor(0);
        }
    }

    /**
     * Default indexer.<br><br>
     *
     * Example:<pre><font face="Courier" size="4">
     * tChart1[0].Color=Color.Blue;
     *  is equivalent to
     * tChart1.Series[0].Color=Color.Blue;
     * </font></pre>
     *
     * @param index int
     * @return Series
     */
    public function getItem($index) {
        return $this->series->getSeries($index);
    }

    /**
     * Default indexer.<br>
     *
     * @param index int
     * @param value Series
     */
    public function setItem($index, $value) {
        $this->series->setSeries($index, $value);
    }

    //  Steps to determine if an axis is Visible:
    // 1) The global Chart.AxisVisible property is True... and...
    // 2) The Axis Visible property is True... and...
    // 3) At least there is a Series Active and associated to the axis and
    //   the Series has the "UseAxis" property True.
    public function isAxisVisible($a) {

        $result = ($this->axes->getVisible() && $a->getVisible());

        if ($result) { // if still visible...
            if ($a->isDepthAxis) {
                return $this->aspect->getView3D();
            } else {
                for ($t = 0; $t < sizeof($this->series); $t++) {
                    $s = $this->series->getSeries($t);
                    if ($s->getActive()) {
                        if ($s->getUseAxis()) {
                            $result = $s->associatedToAxis($a);
                            if ($result) {
                                return true;
                            }
                        } else {
                            return false;
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Returns first active (visible) series.
     *
     * @return Series
     */
    public function getFirstActiveSeries() {
        for ($t = 0; $t < $this->series->count(); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getActive()) {
                return $s;
            }
        }
        return null;
    }

    private function axisRect($a, $r) {
        if ($this->isAxisVisible($a)) {
            $oldR=$r;
            if($a != $a->getChart()->getAxes()->getDepthTop())
                $a->calcRect($oldR,true);
            else
                $a->calcRect($oldR,false);
            $r->intersect($oldR);
        }
        return $r;
    }

    private function calcAxisRect() {
        $tmpR = $this->chartRect;
        $this->axes->adjustMaxMin();
        $this->axes->internalCalcPositions();

        $oldR = $tmpR;

        $tmpR = $this->axisRect($this->axes->getLeft(), $tmpR);
        $tmpR = $this->axisRect($this->axes->getTop(), $tmpR);
        $tmpR = $this->axisRect($this->axes->getRight(), $tmpR);
        $tmpR = $this->axisRect($this->axes->getBottom(), $tmpR);
        $tmpR = $this->axisRect($this->axes->getDepth(), $tmpR);
        $tmpR = $this->axisRect($this->axes->getDepthTop(), $tmpR);

        for ($t = 0; $t < sizeof($this->axes->getCustom()); $t++) {
            $a = $this->axes->getCustom()->getAxis($t);
            if ($this->isAxisVisible($a)) {
                $oldR = $tmpR;
                $tmpR = $a->calcRect($tmpR, false); // <-- inflate only for first 4 axes
                $tmpR->intersect($oldR);
            }
        }

        $tmpR = $this->recalcWidthHeight($tmpR);
        $this->chartRect = $tmpR;

        $this->axes->internalCalcPositions(); // recalc again
    }

    private function setSeriesZOrder() {
        $this->maxZOrder = 0;

        $ok = ($this->aspect->getApplyZOrder() && $this->aspect->getView3D());

        if ($ok) {
            $this->maxZOrder = -1;
            for ($t = 0; $t < sizeof($this->series); $t++) {
                $s = $this->series->getSeries($t);
                if ($s->getActive()) {
                    $s->calcZOrder();
                }
            }
        }

        // invert Z Orders
        if (!$this->axes->getDepth()->getInverted()) { // 6.01
            for ($t = 0; $t < sizeof($this->series); $t++) {
                $s = $this->series->getSeries($t);
                if ($s->getActive()) {
                    $s->iZOrder = $ok ? $this->maxZOrder - $s->getZOrder() : 0;
                }
            }
        }

    }

    /**
     * Returns the String to display at Legend for a given series and point
     * index.<br>
     * In other words it returns the string representation of a Series
     * Point value just as it would appear in Chart.Legend. The ValueIndex
     * parameter is the point index. Legend.TextStyle and all other
     * TChartLegend methods are used to create the resulting string.
     *
     * @param aSeries Series
     * @param valueIndex int
     * @return String
     */
    public function formattedValueLegend($aSeries, $valueIndex) {
        return ($aSeries != null) ?
                $this->legend->formattedValue($aSeries, $valueIndex) :
                "";
    }

    private function setSeriesZPositions() {
        for ($t = 0; $t < sizeof($this->series); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getActive()) {
                $s->setZPositions();
            }
        }
    }

    private function calcSeriesAxisRect($axis) {
        $tmpLeft = 0;
        $tmpTop = 0;
        $tmpRight = 0;
        $tmpBottom = 0;
        $margins = new Margins();

        for ($t = 0; $t < sizeof($this->series); $t++) {

            $tmpSeries = $this->series->getSeries($t);

            if ($tmpSeries->getActive()) {
                if ($tmpSeries->associatedToAxis($axis)) {
                    if ($axis->getHorizontal()) {
                        $tmpSeries->calcHorizMargins($margins);
                        if ($axis->getAutomaticMinimum()) {
                            $tmpLeft = max($tmpLeft, $margins->min);
                        }
                        if ($axis->getAutomaticMaximum()) {
                            $tmpRight = max($tmpRight, $margins->max);
                        }
                    } else {
                        $tmpSeries->calcVerticalMargins($margins);
                        if ($axis->getAutomaticMaximum()) {
                            $tmpTop = max($tmpTop, $margins->min);
                        }
                        if ($axis->getAutomaticMinimum()) {
                            $tmpBottom = max($tmpBottom, $margins->max);
                        }
                    }
                }
            }
        }

        // Apply offsets in pixels
        if ($axis->getHorizontal()) {
            $tmpLeft += $axis->getMinimumOffset();
            $tmpRight += $axis->getMaximumOffset();
        } else {
            $tmpTop += $axis->getMaximumOffset();
            $tmpBottom += $axis->getMinimumOffset();
        }

        $axis->adjustMaxMinRect(Rectangle::fromLTRB($tmpLeft, $tmpTop, $tmpRight,
                                                     $tmpBottom));
    }

    private function calcSeriesRect() {
        //std & custom axes
        for ($i = 0; $i < $this->axes->getCount(); $i++) {
            $this->calcSeriesAxisRect($this->axes->getAxis($i));
        }
    }

    private function drawTitleFoot($g, $rect, $customOnly) {
        $rect = $this->header->doDraw($g, $rect, $customOnly);
        $rect = $this->subHeader->doDraw($g, $rect, $customOnly);
        $rect = $this->footer->doDraw($g, $rect, $customOnly);
        $rect = $this->subFooter->doDraw($g, $rect, $customOnly);

        return $rect;
    }

    private function shouldDrawLegend() {
        return $this->legend->getVisible() &&
                ($this->legend->hasCheckBoxes() || ($this->countActiveSeries() > 0));
    }

    public function doDrawLegend($g, $tmp) {
        if ($this->legend->getVisible()) {
            $this->legend->paint($g, $tmp);
            if ($this->legend->getLastValue() >= $this->legend->getFirstValue()) {
                $tmp = $this->legend->resizeChartRect($tmp);
            }
        }
        return $tmp;
    }

    private function drawRightWallAfter() {
       $p1 = $this->graphics3D->calc3DPoint($this->chartRect->getRight(),
                                          $this->chartRect->y, 0);
       $p2 = $this->graphics3D->calc3DPoint($this->chartRect->getRight(),
                                          $this->chartRect->getBottom() +
                                          $this->walls->calcWallSize($this->axes->getBottom()),
                                          $this->getAspect()->width3D +
                                          $this->walls->getBack()->getSize());
       return $p1->x <= $p2->x;
    }

    private function drawTitlesAndLegend($g, $tmp, $beforeSeries) {
       $rect = $tmp;

       if ($beforeSeries) {
            // draw titles and legend before series
            if ((!$this->legend->getCustomPosition()) && $this->shouldDrawLegend()) {
                if ($this->legend->getVertical()) {
                    $tmp = $this->doDrawLegend($g, $tmp);
                    $tmp = $this->drawTitleFoot($g, $tmp, false);
                } else {
                    $tmp = $this->drawTitleFoot($g, $tmp, false);
                    $tmp = $this->doDrawLegend($g, $tmp);
                }
            } else {
                $tmp = $this->drawTitleFoot($g, $tmp, false);
            }
        } else {
            // after series
            if ($this->legend->getCustomPosition() && $this->shouldDrawLegend()) {
                $tmp = $this->doDrawLegend($g, $tmp);
            }

            $tmp = $this->drawTitleFoot($g, $tmp, true);
        }

       if (!$beforeSeries) {
            if ($this->activeSeriesUseAxis()) {
                if ($this->getAspect()->getView3D() && $this->walls->getView3D()) {
                    if ($this->walls->getRight()->getVisible() && $this->drawRightWallAfter()) {
                        $this->walls->getRight()->paint($g, $tmp);
                    }
                    if ($this->walls->getLeft()->getVisible() &&
                        ((!$this->getAspect()->getOrthogonal()) &&
                         ($this->getAspect()->getRotation() < 270))) {
                        $this->walls->getLeft()->paint($g, $tmp);
                        $this->axes->getLeft()->hideBackGrid = true;
                        $this->axes->getLeft()->draw($g, false);
                        $this->axes->getLeft()->hideBackGrid = false;
                    }
                }
            }
        }

        return $tmp;
    }

    /**
     * Returns the number of active (visible) series.<br>
     * In other words it is a count of Series in Chart that have their Active
     * property set to true.
     *
     * @return int Number of Active (visible) Series.
     */
    public function countActiveSeries() {
        $tmpResult = 0;
        for ($t = 0; $t < $this->series->count(); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getActive()) {
                $tmpResult++;
            }
        }

        return $tmpResult;
    }

    public function isAxisCustom($axis) {
        return $this->axes->getCustom()->indexOf($axis) != -1;
    }

    /**
     * Returns the series that corresponds to the Legend "ItemIndex" position,
     * when the Legend style is "Series".<br>
     * The "OnlyActive" parameter, when false, takes into account all series,
     * visibly active or not.
     *
     * @param itemIndex int
     * @param onlyActive boolean
     * @return Series
     */
    public function seriesLegend($itemIndex, $onlyActive) {
        $tmp = 0;
        for ($t = 0; $t < $this->series->count(); $t++) {
            $s = $this->series->getSeries($t);
            if ($s->getShowInLegend() && ((!$onlyActive) || $s->getActive())) {
                if ($tmp == $itemIndex) {
                    return $s;
                } else {
                    $tmp++;
                }
            }
        }
        return null;
    }

    /**
     * Returns the text string corresponding to a Legend position.<br>
     * The Legend position depends on Legend.LegendStyle.<br>
     * If LegendStyle is lsSeries, then the text string will be the
     * SeriesOrValueIndexth Active Series Title.<br>
     * If LegendStyle is lsValues, then the text string will be the formatted
     * SeriesOrValueIndexth value of the first Active Series in the Chart.<br>
     * If LegendStyle is lsAuto and only one Active Series exists in the Chart,
     * then the LegendStyle is considered to be lsValues.<br>
     * If there's more than one Active Series then LegendStyle will be lsSeries.
     *
     * @param seriesOrValueIndex int
     * @return String
     */
    public function formattedLegend($seriesOrValueIndex) {
        $tmp = $this->legend->formattedLegend($seriesOrValueIndex);

        /* TODO
        if ($this->parent != null) {
            $tmp = $this->parent->getLegendResolver()->getItemText(
                    $this->legend,
                    $this->legend->iLegendStyle,
                    $seriesOrValueIndex,
                    $tmp);
        }
        */
        
        return $tmp;
    }

    public function getMaxValuesCount() {
        $result = 0;
        $firstTime = true;

        for ($t = 0; $t < $this->series->count(); $t++) {
            $s = $this->series->getSeries($t);

            if ($s->getActive() && ($firstTime || ($s->getCount() > $result))) {
                $result = $s->getCount();
                $firstTime = false;
            }
        }
        return $result;
    }

    /**
     * Accesses all visible Background attributes..
     *
     * @return TeePanel
     */
    public function getPanel() {
        return $this->panel;
    }

    public function setPanel($value) {
        $this->panel = $value;
        $this->panel->setChart($this);
    }

    /**
     * Internal use.
     * Sets instance that implements the IChart interface.
     *
     * @param value IChart
     */
    public function setParent($value) {
        $this->parent = $value;
    }

    // return IChart
    public function getParent() {
        return $this->parent;
    }

    /**
     * Printing related attributes.
     *
     * @return Printer
     */
    public function getPrinter() {
        return $this->printer;
    }

    public function setPrinter($value) {
        $this->printer = $value;
        $this->printer->setChart($this);
    }

    /**
     * Accesses multiple page characteristics of the Chart.
     *
     * @return TeePage
     */
    public function getPage() {
        return $this->page;
    }

    public function setPage($value) {
        $this->page = value;
        $this->page->setChart($this);
    }

    /**
     * Determines the Legend characteristics.<br>
     * Legend determines the text and drawing attributes of Chart's textual
     * representation of Series and Series values. <br>
     * The Legend class draws a rectangle and for each Series in a Chart (or
     * for each point in a Series) outputs a text representation of that
     * Series (or that point). You can use the Legend.LegendStyle and
     * Legend.TextStyle to control the text used to draw the legend. <br>
     * The Legend can be positioned at Left, Right, Top and Bottom chart sides
     * using Legend.Alignment. <br>
     * Use Legend.Visible to show / hide the Legend. <br>
     * Inverted makes Legend draw text starting from bottom.<br>
     * Frame, Font and Color allow you to change the Legend appearance.<br>
     * Legend.ColorWidth determines the percent width of each item's "colored"
     * mark. <br>
     * Legend.FirstValue controls which Series (or Series point) will be
     * used to draw first Legend item.
     *
     * @return Legend
     */
    public function getLegend() {
        return $this->legend;
    }

    public function setLegend($value) {
        $this->legend = $value;
        $this->legend->setChart($this);
    }


    /**
     * Defines the Text and formatting attributes to be drawn at the top of
     * the Chart.<br>
     * Use Text to enter the desired Header lines, set Visible to true and
     * change Font, Frame and Brush. Use Alignment to control text output
     * position.
     *
     * @return Header
     */
    public function getHeader() {
        return $this->header;
    }

    public function setHeader($value) {
        $this->header = $value;
        $this->header->setChart($this);
    }

    /**
     * Obsolete.&nbsp;Please use Header instead.
     *
     * @return Header
     */
    public function getTitle() {
        return $this->header;
    }

    /**
     * Obsolete.&nbsp;Please use SubHeader instead.
     *
     * @return Header
     */
    public function getSubTitle() {
        return $this->subHeader;
    }

    /**
     * Defines the Text and formatting attributes to be drawn at the top of
     * the Chart, just below the Header text.<br>
     * Use Text to enter the desired SubHeader lines, set Visible to true and
     * change Font, Frame and Brush.<br>
     * Use Alignment to control text output position.
     *
     * @return Header
     */
    public function getSubHeader() {
        return $this->subHeader;
    }

    public function setSubHeader($value) {
        $this->subHeader = $value;
        $this->subHeader->setChart($this);
    }

    /**
     * Defines the Text and formatting attributes to be drawn at the bottom of
     * the Chart.<br>
     * Use Text to enter the desired Footer lines, set Visible to true and
     * change Font, Frame and Brush.<br>
     * Use Alignment to control text output position.
     *
     * @return Footer
     */
    public function getFooter() {
        return $this->footer;
    }

    public function setFooter($value) {
        $this->footer = $value;
        $this->footer->setChart($this);
    }

    /**
     * Defines the Text and formatting attributes to be drawn at the bottom of
     * the Chart, just above the Footer text.<br>
     * Use Text to enter the desired SubFooter lines, set Visible to true and
     * change Font, Frame and Brush.<br>
     * Use Alignment to control text output position.
     *
     * @return Footer
     */
    public function getSubFooter() {
        return $this->subFooter;
    }

    public function setSubFooter($value) {
        $this->subFooter = $value;
        $this->subFooter->setChart($this);
    }

    /**
     * 3D view parameters.
     *
     * @return Aspect
     */
    public function getAspect() {
        return $this->aspect;
    }

    public function setAspect($value) {
        $this->aspect = $value;
        $this->aspect->setChart($this);
    }

    /**
     * Accesses TeeChart Draw attributes.
     *
     * @return IGraphics3D
     */
    public function getGraphics3D() {
        if (isset($this->graphics3D))
            return $this->graphics3D;
        else
            return NULL;
    }

    public function setGraphics3D($value) {
        if ($value != null) {
            $this->graphics3D = $value;
            $this->invalidate();
        }
    }

    /**
     * Gets the index'th tool in getTools() collection
     *
     * @param index int
     * @return Tool
     */
    public function getTool($index) {
        return $this->tools->getTool($index);
    }
    
    /**
     * Gets the index'th jstool in getjsTools() collection
     *
     * @param index int
     * @return JsTool
     */
    public function getJsTool($index) {
        return $this->jstools[$index];
    }
    

    /**
     * Collection of Tool components contained in this Chart.
     *
     * @return ToolsCollection
     */
    public function getTools() {
        return $this->tools;
    }

    /**
     * Collection of JsTool components contained in this Chart.
     *
     * @return JsToolsCollection
     */
    public function getJsTools() {
        return $this->jstools;
    }

    
    public function setTools($value) {
        $this->tools = $value;
        $this->tools->chart = $this;
    }

    public function setJsTools($value) {
        $this->jstools = $value;
        $this->jstools->chart = $this;
    }

    /**
     * Gets the index'th animation in getAnimations() collection
     *
     * @param index int
     * @return Animation
     */
    public function getAnimation($index) {
        return $this->animations->getAnimation($index);
    }
        
    /**
     * Collection of Animation components contained in this Chart.
     *
     * @return AnimationsCollection
     */
    public function getAnimations() {
        return $this->animations;
    }

    public function setAnimations($value) {
        $this->animations = $value;
        $this->animations->chart = $this;
    }

    
    /**
     * Accesses left, bottom and back wall characteristics of the Chart.
     *
     * @return Walls
     */
    public function getWalls() {
        return $this->walls;
    }

    public function setWalls($value) {
        $this->walls = $value;
        $this->walls->setChart($this);
    }

    /**
     * Accesses the five axes, Top, Left, Right, Bottom and z depthas well as
     * custom axis objects.
     *
     * @return Axes
     */
    public function getAxes() {
        return $this->axes;
    }

    public function setAxes($value) {
        $this->axes = $value;
        $this->axes->setChart($this);
    }

    /**
     * Accesses Chart export attributes.
     *
     * @return Exports
     */
    public function getExport() {
        return $this->export;
    }

    public function setExport($value) {
        $this->export = $value;
        $this->export->setChart($this);
    }

    /**
     * Accesses Chart import attributes.
     *
     * @return Imports
     */
    public function getImport() {
        return $this->imports;
    }

    public function setImport($value) {
        $this->imports = $value;
        $this->imports->setChart($this);
    }

    public function getSeriesHeight3D() {
        return $this->seriesHeight3D;
    }

    public function getSeriesWidth3D() {
        return $this->seriesWidth3D;
    }

    public function getLegendPen() {
        return $this->legendPen;
    }

    public function setLegendPen($value) {
        $this->legendPen = $value;
    }

    public function moveSeriesTo($value, $newIndex) {
        $this->series->moveTo($value, $newIndex);
    }

    /**
     * Removes a Series from the Chart series list, without disposing it.
     *
     * @param value Series
     */
    public function removeSeries($value) {
        $this->series->remove($value);
    }

    public function addSeries($value) {
        $result = $this->series->indexOf($value);
        if ($result == -1) {
            $this->series->add($value);
            $result = $this->series->count() - 1;
        }
        return $result; // int
    }

    public function getBottom() {
        return $this->getChartBounds()->getBottom();
    }

    public function getMaxZOrder() {
        return $this->maxZOrder;
    }

    public function setMaxZOrder($value) {
        $this->maxZOrder = $value;
    }

    /**
     * Returns if the Chart should automatically repaint itself when a
     * property has been changed.
     *
     * @return boolean
     */
    public function getAutoRepaint() {
        return $this->autoRepaint;
    }

    /**
     * Sets if this Chart should automatically repaint after a property change.
     *
     * @param value boolean
     */
    public function setAutoRepaint($value) {
        $this->autoRepaint = $value;
        $this->doBaseInvalidate();
    }

    /**
     * Returns the rectangle that contains the four main Chart axes.
     *
     * @return Rectangle
     */
    public function getChartRect() {
        return $this->chartRect;
    }

    /**
     * Sets the rectangle to contain the four main Chart axes.
     *
     * @param value Rectangle
     */
    public function setChartRect($value) {
        $this->chartRect = $value;
    }

    /**
     * Returns the number of Series associated to this Chart.
     *
     * @return int
     */
    public function  getSeriesCount() {      
      if ($this->series != null)  
        return $this->series->count();
      else
        return 0;
    }

    public function series() {
        return $this->getSeries()->iterator();
    }

    public function tools() {
        return $this->getTools()->iterator();
    }

    public function jstools() {
        return $this->getJsTools()->iterator();
    }

    public function doBaseInvalidate() {
        if (($this->graphics3D != null) && (!$this->graphics3D->getDirty()) &&
            $this->getAutoRepaint()) {
            $this->graphics3D->setDirty(true);
            $parent = $this->getParent();
            if ($parent != null) {
                $parent->doInvalidate();
            }
        }
    }

    public function paint() {
        $this->_paint($this->getGraphics3D(), $this->chartBounds);
    }

    /**
     * Paints the Chart in your preferred Canvas and region.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     */
    public function _paint($g, $rect) {
        TChart::$controlName = 'Chart_';
                
        $this->autoRepaint = false;

        $oldG = $this->graphics3D;
        $this->graphics3D = $g;

        // TODO  $this->parent->doBeforeDraw();
        $this->chartRect = $rect->copy();
        $this->chartBounds = $this->chartRect->copy();
        $g->initWindow($this->aspect, $this->chartRect, 100);
        /* TODO
        if ((!getPrinter().isPrinting) ||
            ((getPrinter().isPrinting) &&
             (getPrinter().getPrintPanelBackground()))) {*/
                $this->chartRect = $this->panel->draw($g, $this->chartRect);
        //}

        $this->parent->doDrawImage($g);
        $this->internalDraw($g);

        /* TODO
        if (($this->zoom != null) && $this->zoom->getActive()) {
            $this->zoom->draw();
        }

        $g->resetState();
        $this->parent->doAfterDraw();
        $g->showImage();
        */

        $this->graphics3D = $oldG;        
    }


    protected function broadcastToolEvent($ce) {
        for ($t = 0; $t < sizeof($this->tools); $t++) {
            $s = $this->tools->getTool($t);
            if ($s->getActive()) {
                $s->chartEvent($ce);
            }
        }
    }
}

/**
 * CalcStringResults class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
final class CalcStringResults {
        var $tmpResult;
        var $numLines;
}
?>