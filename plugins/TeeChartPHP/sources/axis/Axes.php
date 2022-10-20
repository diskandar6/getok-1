<?php
/**
 * Description: Axes
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
/**
 * Axes Class
 *
 * Description: Accesses list of all TChart Axes. Includes Custom and Depth
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

class Axes extends TeeBase {

    private static $STANDARD_AXES = 5;
    private $left;
    private $right;
    private $top;
    private $bottom;
    private $visible = true;
    private $drawBehind = true;

    protected $custom;
    protected $depth;
    protected $depthTop;

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
        
        unset($this->visible);
        unset($this->drawBehind);

        if (isset($this->custom))
        {
          $this->custom->__destruct();   
          unset($this->custom);
        }
    }
    
    /**
    * The class constructor.
    */
    public function __construct($c=null) {

        $this->custom = new CustomAxes();

        parent::__construct($c);

        $this->custom->setChart($this->chart);

        $this->left = new Axis(null, null, $this->chart);
        $this->left->getTitle()->setInitialAngle(90);

        $this->right = new Axis(false, true, $this->chart);
        $this->right->setZPosition(100);
        $this->right->getGrid()->setZPosition(100);
        $this->right->getTitle()->setInitialAngle(270);

        $this->top = new Axis(true, true, $this->chart);
        $this->top->setZPosition(100);
        $this->top->getGrid()->setZPosition(100);

        $this->bottom = new Axis(true, false, $this->chart);
        $this->depth = new DepthAxis(false, true, $this->chart);
        $this->depthTop = new DepthAxis(false, false, $this->chart);
    }

    /**
     * @return Axis
     * @see Axis
     */
    static public function createNewAxis($chart) {
        return new Axis(null, null, $chart);
    }

    /**
     * @return String[]
     */
    public function stringItems() {
        $names = array();

        $names[0] = Language::getString("LeftAxis");
        $names[1] = Language::getString("TopAxis");
        $names[2] = Language::getString("RightAxis");
        $names[3] = Language::getString("BottomAxis");

        for ($t = 0; $t < sizeof($this->custom); $t++) {
            $names[3 + $t] = "Custom " + $t;
        }

        return $names;
    }

    /**
     * @return Int
     */
    public function indexOf($a) {
        if ($a == $this->left) {
            return 0;
        } else if ($a == $this->top) {
            return 1;
        } else if ($a == $this->right) {
            return 2;
        } else if ($a == $this->bottom) {
            return 3;
        } else if ($a == $this->depth) {
            return 4;
        } else if ($a == $this->depthTop) {
            return 5;
        } else {
            return $this->custom->indexOf($a) + self::$STANDARD_AXES;
        }
    }

    /**
     * Accesses indexed axis
     *
     * @param index int
     * @return Axis
     */
    public function getAxis($index) {

        if ($index <= $this->getCount()) {
            if ($index < 6) {
                switch ($index) {
                case 0:
                    return $this->left;
                case 1:
                    return $this->top;
                case 2:
                    return $this->right;
                case 3:
                    return $this->bottom;
                case 4:
                    return $this->depth;
                case 5:
                    return $this->depthTop;
                }
            } else {
                return $this->custom->getAxis($index - self::$STANDARD_AXES);
            }
        }
        return null;
    }

    /**
     * Returns the number of axes.
     *
     * @return int Number of axes
     */
    public function getCount() {
        return sizeof($this->custom) + self::$STANDARD_AXES;
    }

    /**
     * Draws axes behind or in front of Series.<br>
     * Enables/disables the painting of the Axes before the Series.<br>
     * When false, the Axes will appear over the Chart Series.<br>
     * Default value: true
     *
     * @return boolean
     */
    public function getDrawBehind() {
        return $this->drawBehind;
    }

    /**
     * Draws axes behind the Series when true.
     *
     * @param value boolean
     */
    public function setDrawBehind($value) {
        $this->drawBehind = $this->setBooleanProperty($this->drawBehind, $value);
    }

    public function doZoom($x0, $y0, $x1, $y1) {
        $this->chart->doZoom(
                $this->getTop()->calcPosPoint($x0), $this->getTop()->calcPosPoint($x1),
                $this->getBottom()->calcPosPoint($x0), $this->getBottom()->calcPosPoint($x1),
                $this->getLeft()->calcPosPoint($y1), $this->getLeft()->calcPosPoint($y0),
                $this->getRight()->calcPosPoint($y1), $this->getRight()->calcPosPoint($y0));
    }

    protected function checkAxis($a) {
        return ($a == null) ? new Axis(null, null, $this->chart) : $a;
    }

    /**
     * Accesses the Custom axes List.
     *
     * @return CustomAxes
     */
    public function getCustom() {
        return $this->custom;
    }

    public function setCustom($value) {
        $this->custom = $value;
    }

    /**
     * Calls adjustMaxMin method of all axes and custom axes
     */
    public function adjustMaxMin() {
        $this->left->adjustMaxMin();
        $this->top->adjustMaxMin();
        $this->right->adjustMaxMin();
        $this->bottom->adjustMaxMin();
        $this->depth->adjustMaxMin();
        $this->depthTop->adjustMaxMin();

        for ($t = 0; $t < sizeof($this->custom); $t++) {
            $this->custom->getAxis($t)->adjustMaxMin();
        }
    }

    public function internalCalcPositions() {

        $this->left->internalCalcPositions();
        $this->top->internalCalcPositions();
        $this->right->internalCalcPositions();
        $this->bottom->internalCalcPositions();
        $this->depth->internalCalcPositions();
        $this->depthTop->internalCalcPositions();

        for ($t = 0; $t < sizeof($this->custom); $t++) {
            $this->custom->getAxis($t)->internalCalcPositions();
        }
    }

    /**
     * Determines the Labels and formatting attributes of Left Chart side.<br>
     * It also controls where Series points will be placed. <br>
     * Every TChart class has five Axes: Left, Top, Right, Bottom and z depth.
     *
     * @return Axis
     */
    public function getLeft() {
        return $this->checkAxis($this->left);
    }

    public function setLeft($value) {
        $this->left = $value;
    }

    /**
     * Determines the Labels and formatting attributes of Top Chart side.<br>
     * It also controls where Series points will be placed.<br>
     * Every TChart class has five Axes: Left, Top, Right, Bottom and z depth.
     * The Top is pre-defined to be: <br>
     * Horizontal = true<br>
     * OtherSide = true<br>
     *
     * @return Axis
     * @see Axis
     */
    public function getTop() {
        return $this->checkAxis($this->top);
    }

    public function setTop($value) {
        $this->top = $value;
    }

    /**
     * Determines the Labels and formatting attributes of Right Chart side.<br>
     * It also controls where Series points will be placed.<br>
     * Every TChart class has five Axes: Left, Top, Right, Bottom and z depth.
     *
     * @return Axis
     * @see Axis
     */
    public function getRight() {
        return $this->checkAxis($this->right);
    }

    public function setRight($value) {
        $this->right = $value;
    }

    /**
     * Determines the Labels and formatting attributes of Bottom Chart side.<br>
     * It also controls where Series points will be placed.<br>
     * Every TChart class has five Axes: Left, Top, Right, Bottom and z depth.
     *
     * @return Axis
     * @see Axis
     */
    public function getBottom() {
        return $this->checkAxis($this->bottom);
    }

    public function setBottom($value) {
        $this->bottom = $value;
    }

    /**
     * Accesses characteristics of the Depth Axis, or z axis as it is also
     * known.<br>
     * Every TChart º has five Axes: Left, Top, Right, Bottom and z depth.
     *
     * @return Axis
     * @see Axis
     */
    public function getDepth() {
        if ($this->depth == null) {
           $this->depth = new DepthAxis(false, true, $this->chart);
        }
        return $this->depth;
    }

    public function setDepth($value) {
        $this->depth = $value;
    }

    public function getDepthTop() {
        if ($this->depthTop == null) {
           $this->depthTop = new DepthAxis(false, false, $this->chart);
        }
        return $this->depthTop;
    }

    public function setDepthTop($value) {
        $this->depthTop = $value;
    }

    /**
     * Shows or hides the five Chart Axes at once.<br>
     * Each Axis will be drawn depending also on their Visible property.<br>
     * Default value: true
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->visible;
    }

    /**
     * Determines whether all five Chart Axes are visible or not.
     *
     * @param value boolean
     */
    public function setVisible($value) {
        $this->visible = $this->setBooleanProperty($this->visible, $value);
    }

    public function setChart($value) {
        parent::setChart($value);

        $this->left->setChart($this->chart);
        $this->top->setChart($this->chart);
        $this->right->setChart($this->chart);
        $this->bottom->setChart($this->chart);
        $this->depth->setChart($this->chart);
        $this->depthTop->setChart($this->chart);

        $this->custom->setChart($this->chart);
    }

    public function draw($g) {

        if ($g==null)
            $g=$this->chart->getGraphics3D();

        $parent = $this->chart->getParent();
        if ($parent != null) {
            $parent->doBeforeDrawAxes();
        }

        $old_name = TChart::$controlName;
        
        if ($this->chart->isAxisVisible($this->left)) {
            TChart::$controlName = $old_name . 'Axis_Left_';   
            $this->left->draw(true);
        }
        if ($this->chart->isAxisVisible($this->right)) {
            TChart::$controlName = $old_name . 'Axis_Right_';               
            $this->right->draw(true);
        }
        if ($this->chart->isAxisVisible($this->top)) {
            TChart::$controlName = $old_name . 'Axis_Top_';               
            $this->top->draw(true);
        }
        if ($this->chart->isAxisVisible($this->bottom)) {
            TChart::$controlName = $old_name . 'Axis_Bottom_';               
            $this->bottom->draw(true);
        }
        if ($this->chart->isAxisVisible($this->depth)) {
            TChart::$controlName = $old_name . 'Axis_Depth_';               
            $this->depth->draw(true);
        }
        if ($this->chart->isAxisVisible($this->depthTop)) {
            TChart::$controlName = $old_name . 'Axis_DepthTop_';               
            $this->depthTop->draw(true);
        }

        TChart::$controlName = $old_name;
        
        for ($t = 0; $t < sizeof($this->custom); $t++) {
            $a = $this->custom->getAxis($t);
            if ($a->getVisible()) {
                $a->draw(true);
            }
        }
    }
}

?>