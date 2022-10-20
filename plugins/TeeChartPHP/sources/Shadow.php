<?php
 /**
 * Description:  This file contains the following class:<br>
 * Shadow class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Shadow class
 *
 * Description: Properties to draw a shadow
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Shadow extends TeeBase {

    private $height = 3;
    private $width = 3;

    protected $bBrush;
    protected $bVisible=false;
    protected $defaultVisible=false;
    protected $defaultSize;
    protected $defaultColor;

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
     * Shadow constructor, defines initial size and color
     *
     * @param c IBaseChart
     * @param size int
     * @param color Color
     */
    public function __construct($c, $size=-1, $color=null) {
        $this->bBrush=new ChartBrush($c, new Color(120,120,120)); // DARK_GRAY 
        
        parent::__construct($c);
               
        if($size != -1)  {
                $this->defaultSize = $size;
                $this->width = $size;
                $this->height = $size;
        } else {
                $this->defaultSize=3;
        }

        if($color != null)  {
                $this->setColor($color);
                $this->defaultColor = $color;
        } else {
                $this->bBrush = new ChartBrush($c, new Color(120,120,120)); // DARK_GRAY
        }
    }
    
    public function __destruct()    
    {        
        parent::__destruct();
       
        unset($this->height);
        unset($this->width);
        unset($this->bBrush);
        unset($this->bVisible);
        unset($this->defaultVisible);
        unset($this->defaultSize);
        unset($this->defaultColor);
    }         

    /**
     * Assigns characteristics of Shadow '$value'.<br>
     * Copies all properties from Source Shadow to Self.
     *
     * @param value Shadow
     */
    public function assign($value) {
        $this->height = $value->height;
        $this->width = $value->width;
        $this->bVisible = $value->bVisible;
        $this->bBrush->assign($value->bBrush);
    }

    /**
     * Defines the shadow Color. Gets or sets Color used to fill shadow.
     *
     * @return Color
     */
    public function getColor() {
        return $this->bBrush->getColor();
    }

    /**
     * Defines the shadow Color. Gets or sets Color used to fill shadow.
     *
     * @param value Color
     */
    public function setColor($value) {
        $this->getBrush()->setColor($value);
    }

    public function setDefaultSize($value) {
        $this->defaultSize = $value;
        $this->height = $value;
        $this->width = $value;
    }

    public function setDefaultVisible($value) {
        $this->defaultVisible = $value;
        $this->bVisible = $value;
    }

    protected function shouldSerializeHeight() {
        return $this->height != $this->defaultSize;
    }

    /**
     * The Transparency level from 0 to 100% of shadow.<br>
     * Transparency is a $value between 0 and 100 which sets the transparency
     * percentage with respect to foreground versus background for the shadow.
     *
     * @return int
     */
    public function getTransparency() {
        return $this->bBrush->getTransparency();
    }

    /**
     * Sets Transparency level from 0 to 100% of shadow.<br>
     *
     * @param $value int
     */
    public function setTransparency($value) {
        $this->bBrush->setTransparency($value);
    }

    /**
     * The vertical displacement of the shadow in pixels.
     *
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Sets the vertical displacement of the shadow in pixels.
     *
     * <p>Example:
     * <pre><font face="Courier" size="4">
     * pieSeries = new com.steema.teechart.styles.Pie(myChart.getChart());
     * pieSeries.getMarks().setVisible(true);
     * pieSeries.getShadow().setVisible(true);
     * pieSeries.getShadow().setWidth(30);
     * pieSeries.getShadow().setHeight(50);
     * pieSeries.getShadow().setColor(Color.SILVER);
     * pieSeries.fillSampleValues(9);
     * </pre>
     * @param value int
     */
    public function setHeight($value) {
        $this->height = $this->setIntegerProperty($this->height, $value);
    }

    /**
     * Obsolete.&nbsp;Please use Width property.
     *
     * @return int
     */
    public function getHorizSize() {
        return $this->width;
    }

    /**
     * Obsolete.&nbsp;Please use Width property.
     *
     * @param $value int
     */
    public function setHorizSize($value) {
        $this->width = $value;
    }

    /**
     * Obsolete.&nbsp;Please use Height property.
     *
     * @return int
     */
    public function getVertSize() {
        return $this->height;
    }

    /**
     * Obsolete.&nbsp;Please use Height property.
     *
     * @param $value int
     */
    public function setVertSize($value) {
        $this->height = $value;
    }

    protected function shouldSerializeWidth() {
        return $this->width != $this->defaultSize;
    }

    /**
     * The horizontal shadow size in pixels.
     *
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Sets the horizontal shadow size in pixels.
     *
     * <p>Example:
     * <pre><font face="Courier" size="4">
     * pieSeries = new com.steema.teechart.styles.Pie(myChart.getChart());
     * pieSeries.getMarks().setVisible(true);
     * pieSeries.getShadow().setVisible(true);
     * pieSeries.getShadow().setWidth(30);
     * pieSeries.getShadow().setHeight(50);
     * pieSeries.getShadow().setColor(Color.SILVER);
     * pieSeries.fillSampleValues(9);
     * </pre>
     * @param value int
     */
    public function setWidth($value) {
        $this->width = $this->setIntegerProperty($this->width, $value);
    }

    /**
     * Defines the Brush characteristics to fill the shadow.
     *
     * @return ChartBrush
     */
    public function getBrush() {
        return $this->bBrush;
    }

    /**
     * Size in pixels of shadow.<br>
     * Returns the biggest of the HorizSize and VertSize properties.
     * When setting Size, it will set both HorizSize and VertSize to the
     * same $value.
     *
     * @return Dimension
     */
    public function getSize() {
        return new Dimension($this->width, $this->height);
    }

    /**
     * Sets both horizontal and vertical shadow size to same $value.
     *
     * @param $value int
     */
    public function setSize($value) {
      $this->width=$value;
      $this->height=$value;
      $this->invalidate();
    }

    /**
     * Size in pixels of shadow.<br>
     *
     * @param $value Dimension
     */
/*    public function setSize($value) {
        $this->width = $value->width;
        $this->height = $value->height;
        $this->invalidate();
    }
*/
    protected function shouldSerializeVisible() {
        return $this->bVisible != $this->defaultVisible;
    }

    /**
     * Determines whether the shadow will appear on screen.
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->bVisible;
    }

    /**
     * Determines whether the shadow will appear on screen.
     *
     * @param $value boolean
     */
    public function setVisible($value) {
        $this->bVisible = $this->setBooleanProperty($this->bVisible, $value);
    }

    /**
     * Draws a shadow around the Rect rectangle parameter, using the ACanvas
     * canvas.<br>
     * Uses the Height, Width and Transparency properties to draw the shadow.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     */
    public function _draw($g, $rect) {
        $this->draw($g, $rect, 0, 0);
    }

    /**
     * Draws a shadow around the Rect rectangle parameter.<br>
     * Uses the Height, Width and Transparency properties to draw the shadow.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     * @param angle int
     * @param aZ int
     */
    public function draw($g, $rect, $angle=0, $aZ=0) {

          //TChart::$controlName .='Shadow';           
          if (($this->height != 0) || ($this->width != 0)) {
            $g->getPen()->setVisible(false);
            $g->setBrush($this->getBrush());

            $bottom = new Rectangle($rect->getLeft() + $this->width, $rect->getBottom(), ($rect->getRight()-$rect->getLeft()) , $this->height);
            $right = new Rectangle($rect->getRight(), $rect->getTop() + $this->height, $this->width, ($rect->getBottom()-$rect->getTop()) - $this->height);

            if ( $angle>0 ) {
                    $g->polygon($aZ,$g->rotateRectangle($bottom,$angle));
                    $g->polygon($aZ,$g->rotateRectangle($right,$angle));
            } else {
                    $g->rectangle($bottom);
                    $g->rectangle($right);
            }

/*          Pep Changed to fix when legend have transparency
            Rectangle tmp = new Rectangle(rect);
            tmp.translate(width, height);

            if (angle > 0) {
                g.polygon(aZ, g.rotateRectangle(tmp, angle));
            } else {
                g.rectangle(tmp);
            }*/
          }
    }

    public function setChart($c) {
        parent::setChart($c);

        if ($this->bBrush != null) {
            $this->bBrush->setChart($this->chart);
        }
    }
}
?>