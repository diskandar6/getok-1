<?php
 /**
 * Description:  This file contains the following class:<br>
 * TeeBevel class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * TeeBevel class
 *
 * Description: Displays bevels (frames) around rectangles
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class TeeBevel extends TeeBase {

    protected $inner;
    protected $outer;
    public $defaultOuter;

    private $width = 1;
    private $colorOne;
    private $colorTwo;

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

    public function __construct($c) {
        $this->inner=BevelStyle::$NONE;
        $this->outer=BevelStyle::$NONE;

        $this->colorOne=new Color(255,255,255);
        $this->colorTwo=new Color(180,180,180);

        parent::__construct($c);
        $this->readResolve();
    }
    
    public function __destruct()    
    {        
        parent::__destruct();
       
        unset($this->inner);
        unset($this->outer);
        unset($this->defaultOuter);
        unset($this->width);
        unset($this->colorOne);
        unset($this->colorTwo);
    }        

    protected function readResolve() {
        $this->defaultOuter=BevelStyle::$NONE;
        return $this;
    }

    /**
     * Defines the inner bevel type of the TChart Panel border. <br>
     * Default value: BevelStyle.None
     *
     *
     * @return BevelStyle
     */
    public function getInner() {
        return $this->inner;
    }

    /**
     * Defines the inner bevel type of the TChart Panel border. <br>
     * Default value: BevelStyle.None
     *
     *
     * @param value BevelStyle
     */
    public function setInner($value) {
        if ($this->inner != $value) {
            $this->inner = $value;
            $this->invalidate();
        }
    }

    /**
     * Width of the TeeChart Panel border in pixels. <br>
     * Default value: 1
     *
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Sets the width of the TeeChart Panel border in pixels. <br>
     * Default value: 1
     *
     * @param value int
     */
    public function setWidth($value) {
        $this->width = $this->setIntegerProperty($this->width, $value);
    }

    /**
     * Color of left and top sides of bevels. <br>Used together with ColorTwo
     * to set the colors applied to the Bevel edge when Raised or Lowered. <br>
     * Default value: white
     *
     * @return Color
     */
    public function getColorOne() {
        return $this->colorOne;
    }

    /**
     * Sets the Color of left and top sides of bevels. <br>
     * Default value: white
     *
     * @param value Color
     */
    public function setColorOne($value) {
        $this->colorOne = $this->setColorProperty($this->colorOne, $value);
    }

    /**
     * Color of right and bottom sides of bevels.<br> Used together with
     * ColorOne, these properties set the colors applied to the Bevel edge
     * when Raised or Lowered. <br>
     * Default value: gray
     *
     * @return Color
     */
    public function getColorTwo() {
        return $this->colorTwo;
    }

    /**
     * Sets the Color of right and bottom sides of bevels.<br>
     * Default value: gray
     *
     * @param value Color
     */
    public function setColorTwo($value) {
        $this->colorTwo = $this->setColorProperty($this->colorTwo, $value);
    }

    //private boolean shouldSerializeOuter() {
    //    return outer != defaultOuter;
    //}

    /**
     * The outer bevel type of the TChart Panel border. <br>
     *
     *
     * @return BevelStyle
     */
    public function getOuter() {
        return $this->outer;
    }

    /**
     * Defines the outer bevel type of the TChart Panel border. <br>
     *
     *
     * @param value BevelStyle
     */
    public function setOuter($value) {
        if ($this->outer != $value) {
            $this->outer = $value;
            $this->invalidate();
        }
    }

    /**
     * Assigns all properties from one bevel to another.
     *
     * @param b Bevel
     */
    public function assign($b) {
        if ($b != null) {
            $this->colorOne = $b->colorOne;
            $this->colorTwo = $b->colorTwo;
            $this->inner = $b->inner;
            $this->outer = $b->outer;
            $this->width = $b->width;
        }
    }

    /**
     * Draws bevels around rectangle parameter.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     */
    public function draw($g, $rect) {
        $r = new Rectangle($rect->x,$rect->y,$rect->width,$rect->height);

        if ($this->inner != BevelStyle::$NONE) {
            $g->paintBevel($this->inner, $r, $this->width, $this->colorOne, $this->colorTwo);
            $r->grow( -$this->width, -$this->width);
        }

        if ($this->outer != BevelStyle::$NONE) {
            $g->paintBevel($this->outer, $r, $this->width, $this->colorOne, $this->colorTwo);
        }
    }
}

?>