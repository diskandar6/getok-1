<?php
/**
 * Description:  This file contains the following class:<br>
 * ChartPen class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * ChartPen class
 *
 * Description: Common Chart Pen. Pen used to draw lines and borders
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

class ChartPen extends TeeBase {

    public $color;
    public $dashStyle;
    public $width;
    public $endCap;
//    public $dashCap = DashCap.FLAT;
    public $visible = true;

    protected $defaultColor;
    protected $defaultEndCap;
    protected $defaultStyle;

    private $transparency;
    protected $defaultVisible=false;
    protected $usesVisible=false;
    private $stroke;
    private $colorChanged;
    private $dashWidth=1;


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

    public function __construct($c, $startColor=null, $startVisible=true,
                    $startWidth=1, $startEndCap=-1, $startStyle=null) {

        if ($startColor == null)
            $startColor=new Color(0,0,0,0,true);  

        if ($startEndCap==null) {
         //  TODO  $tmpLineCap=new LineCap();
         //   $startEndCap = $tmpLineCap->BEVEL;
        }

        if ($startStyle==null) {
            $startStyle=DashStyle::$SOLID;
        }

        parent::__construct($c);
               
        $this->usesVisible=true;
        $this->defaultColor = $startColor;
        $this->color = $this->defaultColor;
        $this->defaultVisible = $startVisible;
        $this->visible = $this->defaultVisible;

        $this->width = $startWidth;

        $this->endCap = $startEndCap;
        $this->defaultEndCap = $startEndCap;

        $this->dashStyle = $startStyle;
        $this->defaultStyle = $startStyle;

        $this->recreateStroke();
    }
    
    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->color);
        unset($this->dashStyle);
        unset($this->width);
        unset($this->endCap);
        unset($this->visible);
        unset($this->defaultColor);
        unset($this->defaultEndCap);
        unset($this->defaultStyle);
        unset($this->transparency);
        unset($this->defaultVisible);
        unset($this->usesVisible);
        unset($this->stroke);
        unset($this->colorChanged);
        unset($this->dashWidth); 
    }       

    public function reset() {
        $this->setColor(new Color(0,0,0));
        $this->setWidth(1);

        $this->setStyle(DashStyle::$SOLID);

        /* TODO
        setEndCap(LineCap.ROUND);
        setDashCap(DashCap.FLAT);
        */
        $this->setTransparency(0);
    }

    public function internalAssign($p) {
        $this->dashStyle = $p->dashStyle;
        $this->width = $p->width;
        $this->color = $p->color;
        $this->endCap = $p->endCap;
// TODO        $this->dashCap = $p->dashCap;
        $this->visible = $p->visible;
        $this->transparency = $p->transparency;
        $this->stroke = $p->stroke;
    }

    public function assign($p) {
        $this->internalAssign($p);
        $this->changed();
    }

    //CDI AssignVisiblePenColor
    public function _assign($p, $value) {
        $this->internalAssign($p);
        $this->color = $value;
        $this->changed();
    }

    public function setUsesVisible($value) {
        $this->usesVisible = $value;
    }

    protected function shouldSerializeColor() {
        return $this->color != $this->defaultColor;
    }

    public function setDefaultColor($value) {
        $this->defaultColor = $value;
        $this->color = $value;
    }

    public function _setColor($value) {
        $this->setColor(new Color($value));
    }

    public function setColor($value) {
        if ($this->color != $value) {
            $this->color = $value;

            if ($this->colorChanged != null) {
                $this->colorChanged->invoke($this, null, null);
            }

            $this->invalidate();
        }
    }

    public function setDefaultStyle($value) {
        $this->defaultStyle = $value;
        $this->setStyle($value);
    }

    public function setDefaultVisible($value) {
        $this->defaultVisible = $value;
        $this->visible = $value;
    }

    protected function shouldSerializeVisible() {
        return $this->visible != $this->defaultVisible;
    }

    /**
     * Determines if the pen will draw lines or not.
     *
     * @return boolean
     */
    public final function getVisible() {
        return $this->visible;
    }

    /**
     * Determines if the pen will draw lines or not.
     *
     * @param value boolean
     */
    public function setVisible($value) {
        $this->visible = $this->setBooleanProperty($this->visible, $value);
    }

    /**
     * Sets Transparency level from 0 to 100%. <br>
     * Default value: 0
     *
     * @return int
     */
    public function getTransparency() {
        return (127*$this->transparency/100);        
    }

    /**
     * Sets Transparency level from 0 to 100%. <br>
     * Default value: 0
     *
     * @param value int
     */
    public function setTransparency($value) {
        $this->transparency = $this->setIntegerProperty($this->transparency, $value);
    }

    /**
     * Determines the color used by the pen to draw lines on the Drawing.
     * It can be any valid color constant like Color.Red, Color.Green, etc. <br>
     * A special color constant unique to TeeChart is: Color.EMPTY.
     * This is the "default color". <br><br>
     * Each TeeChart drawing object has a different default color. For example,
     * the tChart.getFrame() property has a default color of Color.BLACK.
     *
     *
     * @return Color
     */
    public function getColor() {
        if ($this->transparency == 0) {
            return $this->color;
        } else {
            return $this->color->transparentColor($this->transparency);
        }
    }

    protected function shouldSerializeEndCap() {
        return $this->endCap != $this->defaultEndCap;
    }

    /**
     * Style of line endings.
     *
     * @return LineCap
     */
    public function getEndCap() {
        return $this->endCap;
    }

    /**
     * Style of line endings.
     *
     * @param value LineCap
     */
    public function setEndCap($value) {
        if ($this->endCap != $value) {
            $this->endCap = $value;
            $this->recreateStroke();
            $this->invalidate();
        }
    }

    public function getStroke() {
        if ($this->stroke == null) {
            $this->recreateStroke();
        }
        return $this->stroke;
    }

    // "stroke" is cached due to speed reasons.
    // creating a BasicStroke is a slow operation.
    private function recreateStroke() {
/*        if ($this->dashStyle ==  DashStyle::$SOLID) {
            // todo remove ... imagesetthickness ( resource image, int thickness)
            $this->stroke = new BasicStroke($this->width, $this->dashCap.getValue(), $this->endCap.getValue());
        } else {
            $this->stroke = new $this->BasicStroke($this->width, $this->dashCap.getValue(), $this->endCap.getValue(),
                                     1,
                                     $this->dashStyle.getDash(), 0);
        }
*/
    }

    private function changed() {
        /** @todo FINISH / NECESSARY? */
        /*
         if (this == chart.getGraphics3D().getPen()) {
             chart.getGraphics3D().Changed(this);
                }
         */
    }

    public function invalidate() {
        parent::invalidate();
        $this->changed();
    }

    /**
     * Defines segment ending style of dashed lines.<br>
     * Default value: DashCap.Flat
     *
     * @return DashCap
     */
    public function getDashCap() {
        return $this->dashCap;
    }

    public function setDashCap($value) {
        if ($this->dashCap != $value) {
            $this->dashCap = $value;
            $this->recreateStroke();
            $this->invalidate();
        }
    }

    /**
     * Determines the width of lines the pen draws.<br>
     * Default value: 1
     *
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Determines the width of lines the pen draws.<br>
     * Default value: 1
     *
     * @param value int
     */
    public function setWidth($value) {
        if ($this->width != $value) {
            $this->width = $this->setIntegerProperty($this->width, $value);
            $this->recreateStroke();
        }
    }

    protected function shouldSerializeStyle() {
        return $this->dashStyle != $this->defaultStyle;
    }

    /**
     * Determines the style in which the pen draw lines on the Drawing.
     *
     * @return DashStyle
     */
    public function getStyle() {
        return $this->dashStyle;
    }

    /**
     * Determines the style in which the pen draw lines on the Drawing.
     *
     * @param value DashStyle
     */
    public function setStyle($value) {
        if ($this->dashStyle != $value) {
            $this->dashStyle = $value;
            $this->setDashWidth($this->getWidth());
            // TODO maybe remove ? pep $this->recreateStroke();
            $this->invalidate();
        }
    }

    public function getDashWidth() {
        return $this->dashWidth;
    }

    public function setDashWidth($value) {
        $this->dashWidth = $value;
    }
}
?>
