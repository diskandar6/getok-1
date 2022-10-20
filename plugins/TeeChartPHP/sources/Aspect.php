<?php
 /**
 * Description:  This file contains the following class:<br>
 * Aspect class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Aspect class
 *
 * Description: Chart view characteristics to define Chart 3D appearance
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

final class Aspect extends TeeBase {

    private $applyZOrder=true;
    private $chart3D=15;
    private $clipPoints=true;
    private $elevation=345;
    private $horizOffset=0;
    private $orthoAngle=45;
    private $orthogonal=true;
    private $perspective=100;
    private $rotation=345;
    private $tilt=0;
    private $vertOffset=0;
    private $view3D=true;
    private $zoom=100;
    private $zoomText=true;

    public $height3D=0;
    public $width3D=0;


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
    }
        
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->applyZOrder);
        unset($this->chart3D);
        unset($this->clipPoints);
        unset($this->elevation);
        unset($this->horizOffset);
        unset($this->orthoAngle);
        unset($this->orthogonal);
        unset($this->perspective);
        unset($this->rotation);
        unset($this->tilt);
        unset($this->vertOffset);
        unset($this->view3D);
        unset($this->zoom);
        unset($this->zoomText);
        unset($this->height3D);
        unset($this->width3D);
    }         

    /**
     * Determines the angle of 3D rotation in degrees.<br>
     * Rotation describes front plane rotation by rotation degrees (0 - 360).
     * Increasing the value positively will bring the right of the Chart
     * towards the viewer and the left of the Chart away, moving around a
     * vertical axis at the central horizontal point of the Chart. <br>
     * <b>Important.</b> Orthogonal should be set to false for Rotation
     * to act on the Chart. <br>
     * Default value: 345
     *
     * @return integer
     */
    public function getRotation() {
        return $this->rotation;
    }

    /**
     * Sets the angle of 3D rotation in degrees.
     *
     * @param integer $value
     */
    public function setRotation($value) {
        $this->rotation = $this->setIntegerProperty($this->rotation, $value);
    }

    /**
     * Determines the angle of 3D elevation in degrees.<br>
     * Elevation describes front plane rotation by rotation degrees (0 - 360).
     * Increasing the value positively will bring the top of the Chart towards
     * the viewer and the bottom of the Chart away, moving around an horizontal
     * axis at the central vertical point of the Chart. <br>
     * <b>Important.</b> Orthogonal should be set to false for Elevation to
     * act on the Chart. <br>
     * Default value: 345
     *
     * @return integer
     */
    public function getElevation() {
        return $this->elevation;
    }

    /**
     * Sets the angle of 3D elevation in degrees.
     *
     * @param integer $value
     */
    public function setElevation($value) {
        $this->elevation = $this->setIntegerProperty($this->elevation, $value);
    }

    /**
     * Determines the angle of 3D tilt in degrees.<br>
     * Not supported for 2D or 3D orthogonal Charts <br>
     * <b>Important.</b> Set TChart.Aspect.Orthogonal = false;<br>
     * Default value: 0
     *
     * @return integer
     */
    public function getTilt() {
        return $this->tilt;
    }

    /**
     * Sets the angle of 3D tilt in degrees.
     *
     * @param integer $value
     */
    public function setTilt($value) {
        $this->tilt = $this->setIntegerProperty($this->tilt, $value);
    }

    /**
     * Displays multiple Series at different 3D "Z" (depth) positions.<br>
     * Run-time only. <br> ApplyZOrder controls if several Series of the same
     * TChart class are displayed in a different Z space for each one. <br>
     * It's valid only when TChart.Aspect.View3D is true and when there's more
     * than one Series in same chart. When false, all Series are drawn using
     * the full Chart Z space. The Chart output can be confusing if Series
     * overlap. <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getApplyZOrder() {
        return $this->applyZOrder;
    }

    /**
     * Sets the different 3D "Z" depth positions of multiple Series.
     *
     * @param boolean $value
     */
    public function setApplyZOrder($value) {
        $this->applyZOrder = $this->setBooleanProperty($this->applyZOrder, $value);
    }

    /**
     * Restricts those Series points displayed outside the Chart axes
     * rectangle when true.<br>
     * Chart method defines the TChart or TDBChart component to display
     * on a TQRChart. TQRChart is an "interface" component. It must be
     * associated to a TChart or TDBChart component. <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getClipPoints() {
        return $this->clipPoints;
    }

    /**
     * Restricts those Series points displayed outside the Chart axes
     * rectangle when true.
     *
     * @param boolean $value
     */
    public function setClipPoints($value) {
        $this->clipPoints = $this->setBooleanProperty($this->clipPoints, $value);
    }

    /**
     * Displays the Chart in semi-3D mode when true.<br>
     * Orthogonal displays the Chart in a simulated 3D fashion by drawing the
     * Chart depth at an inclined angle. The bottom of the Chart is always
     * horizontal. When false and the Chart is in 3D, the Chart will display
     * in true 3D mode. <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getOrthogonal() {
        return $this->orthogonal;
    }

    /**
     * Displays the Chart in semi-3D mode when true.
     *
     * @param boolean $value
     */
    public function setOrthogonal($value) {
        $this->orthogonal = $this->setBooleanProperty($this->orthogonal, $value);
    }

    /**
     * Chooses between speed or display quality for Chart rendering. <br><br>
     * for example:-<br>
     * AntiAlias - Specifies antialiased rendering.  <br>
     * Default - Specifies the default mode.  <br>
     * HighQuality - Specifies high quality, low speed rendering.  <br>
     * HighSpeed - Specifies high speed, low quality rendering.  <br>
     * Invalid - Specifies an invalid mode.  <br>
     * None - Specifies no antialiasing. <br>
     * Default value: HighSpeed
     *
     * @return boolean
     */
    public function getSmoothingMode() {
      if (($this->chart==null) || ($this->chart->getGraphics3D()==null)) {
        return false;
      }
      else {
        return $this->chart->getGraphics3D()->getSmoothingMode();
      }
    }

    /**
     * Sets the type of rendering used to display the Chart depending on whether
     * speed, display quality or antialiasing is required.
     *
     * @param boolean $value
     */
    public function setSmoothingMode($value) {
      $g=$this->chart->getGraphics3D();
      if (($this->chart!=null) && ($g!=null)) {
           $g->setSmoothingMode($value);
      }
    }

    /**
     * Chooses between speed or display quality for Text rendering.<br>
     *
     * @return boolean
     */
    public function getTextSmooth() {
        return $this->chart->getGraphics3D()->getTextSmooth();
    }

    /**
     * Sets the type of rendering used to display Text.
     *
     * @param boolean $value
     */
    public function setTextSmooth($value) {
        $this->chart->getGraphics3D()->setTextSmooth($value);
    }

    /**
     * Percent of zoom in 3D mode for the entire Chart.<br>
     * Increasing the value of Zoom brings the entire Chart towards the viewer.
     * 'In Chart' zoom will still function by mouse dragging within the Chart
     * area and is distinct from whole Chart zooming.<br>
     * Default value: 100
     *
     * @return integer
     */
    public function getZoom() {
        return $this->zoom;
    }

    /**
     * Sets the percentage of zoom in 3D mode for the entire Chart.
     *
     * @param  integer $value
     */
    public function setZoom($value) {
        $this->zoom = $this->setIntegerProperty($this->zoom, $value);
    }

    /**
     * <br>
     * Perspective offers a distance adjustment for the Chart display, giving
     * an appearance of perspective between the nearer and further parts of the
     * Chart. <br>
     * See the comparison below: <br>
     * No perspective <br>
     * Perspective = 50; <br>
     * Default value: 15
     *
     * @return integer
     */
    public function getPerspective() {
        return $this->perspective;
    }

    /**
     * Sets the percentage of 3D perspective.
     *
     * @param integer $value
     */
    public function setPerspective($value) {
        $this->perspective = $this->setIntegerProperty($this->perspective, $value);
    }

    /**
     * Angle in degrees, from 0 to 90, when displaying in Orthogonal mode.<br>
     * OrthoAngle sets the angle of inclination of the Depth axis when the
     * Chart is set to Orthogonal mode, or in other words, when Orthogonal
     * property is set to true. <br>
     * Default value: 45
     *
     * @return integer
     */
    public function getOrthoAngle() {
        return $this->orthoAngle;
    }

    /**
     * Sets the angle in degrees, from 0 to 90, to display the Chart when in
     * Orthogonal mode.
     *
     * @param integer $value
     */
    public function setOrthoAngle($value) {
        $this->orthoAngle = $this->setIntegerProperty($this->orthoAngle, $value);
    }

    /**
     * Percent from 0 to 100 of Z Depth.<br>
     * Chart3DPercent indicates the size ratio between Chart dimensions and
     * Chart depth when Chart.Aspect.View3D is true. You can specify a percent
     * number from 1 to 100.<br>
     * Default value: 15
     *
     * @return integer
     */
    public function getChart3DPercent() {
        return $this->chart3D;
    }

    /**
     * Sets the percentage of Z Depth.<br>
     *
     * @param integer $value
     */
    public function setChart3DPercent($value) {
        $this->chart3D = $this->setIntegerProperty($this->chart3D, $value);
    }

    public function getWidth3D() {
        return $this->width3D;
    }

    public function getHeight3D() {
        return $this->height3D;
    }

    /**
     * Amount (postive or negative) in pixels of horizontal displacement.<br>
     * HorizOffset will move the Chart Rectangle horizontally across the Chart
     * Panel. Positive values move the Chart to the right, negative values to
     * the left. <br>
     * Default value: 0
     *
     * @return integer
     */
    public function getHorizOffset() {
        return $this->horizOffset;
    }

    /**
     * Sets the amount (postive or negative) in pixels of horizontal
     * displacement.<br>
     *
     * @param integer $value
     */
    public function setHorizOffset($value) {
        $this->horizOffset = $this->setIntegerProperty($this->horizOffset, $value);
    }

    /**
     * Amount (postive or negative) in pixels of vertical displacement.<br>
     * Moves the entire Chart on a vertical plane. Not Active for 2D or 3D
     * orthogonal Charts. <br>
     * Default value: 0
     *
     * @return integer
     */
    public function getVertOffset() {
        return $this->vertOffset;
    }

    /**
     * Sets the amount (postive or negative) in pixels of vertical
     * displacement.<br>
     *
     * @param integer $value
     */
    public function setVertOffset($value) {
        $this->vertOffset = $this->setIntegerProperty($this->vertOffset, $value);
    }

    /**
     * Draws each Series with a 3D effect.<br>
     * You can control the 3D proportion by using Chart.Aspect.Chart3DPercent.
     * Chart.Walls.Visible depends on View3D. <br>
     * Default value: true
     *
     * @return boolean
     * @see Aspect#getOrthoAngle
     */
    public function getView3D() {
        return $this->view3D;
    }

    /**
     * Draws each Series with a 3D effect when true.
     *
     * @param boolean $value
     */
    public function setView3D($value) {
      if ($value==0) { $value=false; }
      else
        if ($value==1) { $value=true; }

        $this->view3D = $this->setBooleanProperty($this->view3D, $value);
    }

    /**
     * Resizes all texts according to Zoom property when true.<br>
     * When false, Text size will remain constant regardless of the zoom factor
     * obtained with Aspect.Zoom <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getZoomText() {
        return $this->zoomText;
    }

    /**
     * Resizes all texts according to Zoom property when true.
     *
     * @param boolean $value
     */
    public function setZoomText($value) {
        $this->zoomText = $this->setBooleanProperty($this->zoomText, $value);
    }

    /**
     * Copies all properties from a Series component to another.<br>
     * Only the common properties shared by both source and destination Series
     * are copied. <br>
     * The following code copies all properties from Series2 into Series1: <br>
     * tChart1.Series[0].Assign(tChart1.Series[1]);<br><br>
     * Some Series types restore values after assigning them. For example,
     * Points Series restores Pointer.Visible to True after being assigned
     * to a Line Series, which has Pointers invisible by default. <br>
     * <b>Note:</b> Series events are not assigned.  Series DataSource and
     * FunctionType are assigned.  Assign is used by CloneChartSeries and
     * ChangeSeriesType methods for example.
     *
     * @param Aspect $a
     */
    public function assign($a) {
        $this->applyZOrder = $a->applyZOrder;
        $this->chart3D = $a->chart3D;
        $this->clipPoints = $a->clipPoints;
        $this->elevation = $a->elevation;
        $this->horizOffset = $a->horizOffset;
        $this->orthoAngle = $a->orthoAngle;
        $this->orthogonal = $a->orthogonal;
        $this->perspective = $a->perspective;
        $this->rotation = $a->rotation;
        $this->tilt = $a->tilt;
        $this->vertOffset = $a->vertOffset;
        $this->view3D = $a->view3D;
        $this->zoom = $a->zoom;
        $this->zoomText = $a->zoomText;
    }
}
?>
