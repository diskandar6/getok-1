<?php
 /**
 * Description:  This file contains the following class:<br>
 * Zoom class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: Zoom class</p>
  *
  * <p>Description: Used at tChart1.Zoom property, determines mouse
  * zoom attributes.</p>
  *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
 class Zoom extends ZoomScroll {

    private $animated;
    private $animatedSteps = 8;
    private $bBrush;
    private $direction = 2; // ZoomDirections::$BOTH;
    private $mouseButton = 0; // MouseEvent::$UTTON1;
    private $keyShift = 0;
    private $minPixels = 16;
    protected $pen;
    protected $zoomed;

    /**
    * Controls the animated zoom "speed" (inertia)
    */
    public $animatedFactor = 3.0;

    /**
    * Creates a new Zoom instance.
    *
    * @param c IBaseChart
    */
    public function __construct($c) {
        parent::__construct($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();

        unset($this->animated);
        unset($this->animatedSteps);
        unset($this->bBrush);
        unset($this->direction);
        unset($this->mouseButton);
        unset($this->keyShift);
        unset($this->minPixels);
        unset($this->pen);
        unset($this->zoomed);
    }      

    /**
    * Animates Zoom in sequenced steps when true.<br>
    * Default value: false
    *
    * @return boolean
    */
    public function getAnimated()
    {
        return $this->animated;
    }

    /**
    * Animates Zoom in sequenced steps when true.<br>
    * Default value: false
    *
    * @param value boolean
    */
    public function setAnimated($value) {
        $this->animated = $value;
    }

    /**
    * Brush used to fill mousedragged zoom area.
    *
    * @return ChartBrush
    */
    public function getBrush() {
        if ($this->bBrush == null) {
            $this->bBrush = new ChartBrush($this->chart, Color::WHITE(), false);
        }
        return $this->bBrush;
    }

    /**
    * The direction of the zoom on a selected area.<br><br>
    * Example. Horizontal will zoom only on a horizontal plane although the
    * mouse is dragged across a vertical and horizontal plane.<br>
    * Default value: Both
    *
    * @return ZoomDirections
    */
    public function getDirection() {
        return $this->direction;
    }

    /**
    * Sets the direction of the zoom on a selected area.<br><br>
    * Default value: Both
    *
    * @param value ZoomDirections
    */
    public function setDirection($value) {
        $this->direction = $value;
    }

    /**
    * Determines the number of steps of the animated zooming sequence.<br>
    * Large number of steps can delay zooming. The Animated property should be
    * true.<br>
    * Default value: 8
    *
    * @return int
    */
    public function getAnimatedSteps() {
        return $this->animatedSteps;
    }

    /**
    * Sets the number of steps of the animated zooming sequence.<br>
    * Large number of steps can delay zooming. The Animated property should be
    * true.<br>
    * Default value: 8
    *
    * @param value int
    */
    public function setAnimatedSteps($value) {
        $this->animatedSteps = $value;
    }

    /**
    * The keyboard button as an extra condition to initiate the zoom.<br>
    * Default value: None
    *
    * @return int
    */
    public function getKeyMask() {
        return $this->keyShift;
    }

    /**
    * Sets a keyboard button as an extra condition to initiate the zoom.<br>
    * Default value: None
    *
    * @param value int
    */
    public function setKeyMask($value) {
        $this->keyShift = $value;
    }

    /**
    * The minimum number of pixels to actuate zoom action.<br>
    * Default value: 16
    *
    * @return int
    */
    public function getMinPixels() {
        return $this->minPixels;
    }

    /**
    * Sets minimum number of pixels to actuate zoom action.<br>
    * Default value: 16
    *
    * @param value int
    */
    public function setMinPixels($value) {
        $this->minPixels = $value;
    }

    /**
    * The mousebutton to use for the zoom action.<br>
    * Note that Scroll action uses the right (Right) mousebutton as
    * default.<br>
    * Default value: Left
    *
    * @return int
    */
    public function getMouseButton() {
        return $this->mouseButton;
    }

    /**
    * Sets the mousebutton to use for the zoom action.<br>
    * Default value: Left
    *
    * @param value int
    */
    public function setMouseButton($value) {
        $this->mouseButton = $value;
    }

    /**
    * Pen used to draw surrounding rectangle of zoom area.
    *
    * @return ChartPen
    */
    public function getPen() {
        if ($this->pen == null) {
            $tmpColor = new Color();
            $tmpLineCap = new LineCap();
            $tmpDashStyle = new DashStyle();
            $this->pen = new ChartPen($this->chart, $tmpColor->BLACK, false, 1, $tmpLineCap->BEVEL, $tmpDashStyle->SOLID);
            
            unset($tmpColor);
            unset($tmpDashStyle);
            unset($tmpLineCap);
        }
        return $this->pen;
    }

    /**
    * Zooms the Chart rectangle. Units pixels.
    *
    * @param r Rectangle
    */
    public function zoomRect($r) {
        $this->x0 = $r->getLeft();
        $this->y0 = $r->getTop();
        $this->x1 = $r->getRight();
        $this->y1 = $r->getBottom();
        $this->calcZoomPoints();
    }

    protected function calcZoomPoints() {
        $this->check();
        $this->chart->getAxes()->doZoom($this->x0, $this->y0, $this->x1, $this->y1);
    }

    /**
    * Displays rectangle while dragging Chart for zoom operation.
    */
    public function draw() {
        $g = $this->chart->getGraphics3D();
        $e = $g->getGraphics();

        $r = new Rectangle($this->x0,$this->y0,$this->x1-$this->x0,$this->y1-$this->y0);

        if($this->chart->getParent()!=null) {
            if ($this->bBrush != null && $this->bBrush->getVisible()) {
                $brushXOR = -1 ^ $this->bBrush->getColor()->getRGB();
                $e->setXORMode($this->Color->fromArgb($brushXOR));
                $e->fillRect($this->x0, $this->y0, $this->x1 - $this->x0, $this->y1 - $this->y0);

                if ($this->pen!= null && $this->pen->getVisible()) {
                      $penXOR = -1 ^ $this->pen->getColor()->getRGB();
                     $e->setXORMode($this->Color->fromArgb($penXOR));
                     $e->drawRect($this->x0-1,$this->y0-1,$this->x1+1-$this->x0,$this->y1+1-$this->y0);
                }
            }
            else if($this->pen!= null && $this->pen->getVisible()) {
                $this->chart->invalidate();
                $g->setPen($this->getPen());
                $g->getBrush()->setVisible(false);
                $g->rectangle($r);
                $g->getBrush()->setVisible(true);
            }
            else {
                $this->chart->invalidate();
                $tmpColor = new Color();
                $tmpLineCap = new LineCap();
                $tmpDashStyle = new DashStyle();
                $g->setPen(new ChartPen($this->chart, $tmpColor->BLACK, true, 1, $tmpLineCap->BEVEL, $tmpDashStyle->DASH));
                $g->getBrush()->setVisible(false);
                $g->rectangle($r);
                $g->getBrush()->setVisible(true);
                
                unset($tmpColor);
                unset($tmpLineCap);
                unset($tmpDashStyle);
            }
        }
    }

    /**
    * Overrides base SetChart method to adjust pen and brush chart properties.
    *
    * @param c IBaseChart
    */
    public function setChart($c) {
        parent::setChart($c);
        if ($this->pen != null) {
            $this->pen->setChart($c);
        }
        if ($this->bBrush != null) {
            $this->bBrush->setChart($c);
        }
    }

    /**
    * Rescales the Chart Axis to their Maximum and Minimum values.
    */
    public function undo() {
        $this->chart->restoreAxisScales();
        $this->setZoomed(false);
    }

    /**
    * Determines if Chart axis scales fit all Chart points or not.<br>
    * Run-time only. <br>
    * It is set to true when users's apply zoom or scroll to the Chart using
    * the mouse at run-time. <br>
    * The Zoom.Undo method sets the Zoomed property to false and resets the
    * axis scales to fit all Series points. <br>
    * The default value is true, meaning no zoom or scroll has been applied
    * to the chart after it has been displayed for first time. <br><br>
    * Default value: false
    *
    * @return boolean
    */
    public function getZoomed() {
        return $this->zoomed;
    }

    /**
    * Set the Chart axis scales to fit all Chart points when true.<br>
    * Default value: false
    *
    * @param value boolean
    */
    public function setZoomed($value) {
        $this->zoomed = $value;
        if (($this->chart->getParent() != null) && (!$this->zoomed)) {
            $this->chart->getParent()->doUnZoomed($this);
        }
        $this->invalidate();
    }

    private function calcAxisScale($axis, $percentZoom) {
        $minmax = new FloatRange();
        $axis->calcMinMax($minmax);
        $tmpDelta = ($minmax->min - $minmax->max) * $percentZoom;
        return new PointDouble($minmax->min + $tmpDelta, $minmax->max - $tmpDelta);
    }

    /**
    * Applies the specified PercentZoom Zoom In/Out to the current Axis
    * scales.<br>
    * When PercentZoom is greater than 100%, Zoom Out is performed. <br>
    * When PercentZoom is lower than 100%, Zoom In is performed.<br>
    * The Animated property controls if Zoom is done directly in only o
    * ne step or by multiple zooms thus giving an animation effect.
    *
    * @param percentZoom double
    */
    public function zoomPercent($percentZoom) {
        $percentZoom = ($percentZoom - 100.0) * 0.01;

        $left = $this->calcAxisScale($this->chart->getAxes()->getLeft(), $percentZoom);
        $right = $this->calcAxisScale($this->chart->getAxes()->getRight(), $percentZoom);
        $top = $this->calcAxisScale($this->chart->getAxes()->getTop(), $percentZoom);
        $bottom = $this->calcAxisScale($this->chart->getAxes()->getBottom(), $percentZoom);
        $this->chart->doZoom($top, $bottom, $left, $right);
        $this->invalidate();
    }
}
?>