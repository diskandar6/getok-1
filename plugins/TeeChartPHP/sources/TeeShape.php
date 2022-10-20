<?php
 /**
 * Description:  This file contains the following class:<br>
 * Shape class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Shape class
 *
 * Description: Base class for Chart Shape elements
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class TeeShape extends TeeBase {

    protected $defaultVisible=true;
    protected $visible=true;
    protected $bTransparent=false;
    protected $pPen=null;
    protected $bBevel=null;
    protected $shadow=null;
    protected $bImageBevel=null;
    protected $bBrush=null;
    protected $shapeBounds=null;
    protected $bBorderRound=0;
    protected $shapeBorders=null;

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
        $this->shapeBounds = new Rectangle(0,0,0,0);

        parent::__construct($c);
        
        $this->defaultVisible=true;
        $this->shapeBorders=new ShapeBorders($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();

        unset($this->defaultVisible);
        unset($this->visible);
        unset($this->bTransparent);
        unset($this->pPen);
        
        if (isset($this->bBevel))
        {
            $this->bBevel->__destruct();
            unset($this->bBevel);
        }
        
        if (isset($this->shadow))
        {
            $this->shadow->__destruct();
            unset($this->shadow);          
        }
        unset($this->bImageBevel);    
        if (isset($this->brush))
        {
            $this->brush->__destruct();
            unset($this->bBrush);    
        }
        
        if (isset($this->shapeBounds))
        {
            $this->shapeBounds->__destruct();
            unset($this->shapeBounds);    
        }
        
        unset($this->bBorderRound);    
        
        if (isset($this->shapeBorders))
        {
            $this->shapeBorders->__destruct();
            unset($this->shapeBorders);    
        }
    }          
    
    /**
     * Defines the Shape Borders.
     *
     * @return shapeBorders
     */
    public function getShapeBorders() {
        return $this->shapeBorders;
    }

    /**
     * Defines the boundaries of the Shape.
     *
     * @return Rectangle
     */
    public function getShapeBounds() {
        return $this->shapeBounds;
    }

    /**
     * Defines the boundaries of the Shape.
     *
     * @param value Rectangle
     */
    public function setShapeBounds($value) {
        $this->getShapeBounds()->setX($value->getX());
        $this->getShapeBounds()->setY($value->getY());
        $this->getShapeBounds()->setWidth($value->getWidth());
        $this->getShapeBounds()->setHeight($value->getHeight());
    }

    /**
     * Obsolete.&ndsp;Please use Bevel.<!-- -->Inner.
     *
     *
     * @return BevelStyle
     */
    public function getBevelInner() {
        return $this->getBevel()->getInner();
    }

    /**
     * Defines the inner bevel type of the TChart Panel border.<br>
     * Available types:<br>
     *                  None<br>
     *                  Lowered<br>
     *                  Raised<br>
     *
     *
     * @param value BevelStyle
     */
    public function setBevelInner($value) {
        $this->getBevel()->setInner($value);
    }

    /**
     * Obsolete.&nbsp;Please use Bevel.<!-- -->Width
     *
     * @return int
     */
    public function getBevelWidth() {
        return $this->getBevel()->getWidth();
    }

    /**
     * Obsolete.&nbsp;Please use Bevel.<!-- -->Width
     *
     * @param value int
     */
    public function setBevelWidth($value) {
        $this->getBevel()->setWidth($value);
    }

    /**
     * Obsolete.&nbsp;Please use Bevel.<!-- -->Outer
     *
     *
     * @return BevelStyle
     */
    public function getBevelOuter() {
        return $this->getBevel()->getOuter();
    }

    /**
     * Defines the outer bevel type of the TChart Panel border.<br>
     * Available types:<br>
     *                  None<br>
     *                  Lowered<br>
     *                  Raised<br>
     *
     *
     * @param value BevelStyle
     */
    public function setBevelOuter($value) {
        $this->getBevel()->setOuter($value);
    }

    /**
     * Chart associated with this object.
     *
     * @param c IBaseChart
     */
    public function setChart($c) {
        parent::setChart($c);

        if ($this->pPen != null) {
            $this->pPen->setChart($this->chart);
        }
        if ($this->shadow != null) {
            $this->shadow->setChart($this->chart);
        }
        if ($this->bBrush != null) {
            $this->bBrush->setChart($this->chart);
        }
        if ($this->bBevel != null) {
            $this->bBevel->setChart($this->chart);
        }
    }

    /**
     * Sets the bevel characteristics of the Shape.
     *
     * @return ImageBevel
     */
    public function getImageBevel() {
        if ($this->bImageBevel==null)
            $this->bImageBevel=new ImageBevel($this->chart);
        return $this->bImageBevel;
    }

    /**
     * Sets the bevel characteristics of the Shape.
     *
     * @return TeeBevel
     */
    public function getBevel() {
        if ($this->bBevel == null) {
            $this->bBevel = new TeeBevel($this->chart);
        }

        return $this->bBevel;
    }

    /**
     * Internal use - serialization
     */
    public function setBevel($value) {
        $this->bBevel = $value;
    }

    /**
     * Defines the shape's Shadow characteristics.
     *
     * @return Shadow
     */
    public function getShadow() {
        if ($this->shadow == null) {
            $this->shadow = new Shadow($this->chart);
        }
        return $this->shadow;
    }

    /**
     * Defines the kind of brush used to fill shape background.
     *
     * @return ChartBrush
     */
    public function getBrush() {
        if ($this->bBrush == null) {
            $this->bBrush = new ChartBrush($this->chart,new Color(255,255,255), true);
        }
        return $this->bBrush;
    }

    /**
     * Internal use - serialization
     */
    public function setBrush($value) {
        $this->bBrush = $value;
    }

    /**
     * Rounds the Borders of the Chart Shapes.
     *
     * @return int
     */
    public function getBorderRound() {
        return $this->bBorderRound;
    }

    /**
     * Rounds the Borders of the Chart Shapes.
     *
     * @param value int
     */
    public function setBorderRound($value) {
        $this->bBorderRound = $this->setIntegerProperty($this->bBorderRound, $value);
        // Assign value to independent shape borders
        $this->getShapeBorders()->getTopLeft()->setBorderRound($value);
        $this->getShapeBorders()->getBottomLeft()->setBorderRound($value);
        $this->getShapeBorders()->getTopRight()->setBorderRound($value);
        $this->getShapeBorders()->getBottomRight()->setBorderRound($value);
    }

    /**
     * Rendered Image for Shape background.<br>
     * Default value: null
     *
     * @return Image
     */
    public function getImage() {
        return $this->getBrush()->getImage();
    }

    public function setDefaultVisible($value) {
        $this->defaultVisible = $value;
        $this->visible = $value;
    }

    /**
     * Sets Rendered Image for Shape background.<br>
     * Default value: null
     *
     * @param value Image
     */
    public function setImage($value) {
        $this->getBrush()->setImage($value);
    }

    /**
     * ImageMode for rendered Shape background Image.<br>
     * Default value: ImageMode::$Stretch
     *
     * @return ImageMode
     */
    public function getImageMode() {
        return $this->getBrush()->getImageMode();
    }

    /**
     * Sets the ImageMode for rendered Shape background Image.<br>
     * Default value: ImageMode.Stretch
     *
     * @param value ImageMode
     */
    public function setImageMode($value) {
        $this->getBrush()->setImageMode($value);
    }

    //CDI TTrack //#1480 -- added new property ... have to set Shape.Color to Color.Transparent for it to work
    /** Sets the shape image to transparent.
     *
     * @return boolean
     */
    public function getImageTransparent() {
        return $this->getBrush()->getImageTransparent();
    }

    public function setImageTransparent($value) {
        $this->getBrush()->setImageTransparent($value);
    }

    /**
     * Defines the shape Color.
     *
     * @return Color
     */
    public function getColor() {
        return $this->getBrush()->getColor();
    }

    public function setColor($value) {
        $this->_setColor($value);
    }

    /**
     * Defines the shape Color.
     *
     * @param value Color
     */
    public function _setColor($value) {
        $this->getBrush()->setColor($value);
    }

    /**
     * Calls the  Gradient characteristics for the shape.
     *
     * @return Gradient
     */
    public function getGradient() {
        return $this->getBrush()->getGradient();
    }

    /**
     * Shows or hides the Shape.
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->visible;
    }

    /**
     * Shows or hides the Shape.
     *
     * @param value boolean
     */
    public function setVisible($value) {
        $this->visible = $this->setBooleanProperty($this->visible, $value);
    }

    /**
     * Enables/disables transparency of shape.<br>
     * See transparency, which sets percentage transparency when
     * Transparent is true.
     *
     * @see Shape#getTransparency
     * @return boolean
     */
    public function getTransparent() {
        return $this->bTransparent;
    }

    /**
     * Enables/disables transparency of shape.<br>
     *
     * @param value boolean
     */
    public function setTransparent($value) {
        $this->bTransparent = $this->setBooleanProperty($this->bTransparent, $value);
    }

    /**
     * Specifies the pen used to draw the shape.
     *
     * @return ChartPen
     */
    public function getPen() {
        if ($this->pPen == null) {
            $this->pPen = new ChartPen($this->chart, new Color(0,0,0));
        }
        return $this->pPen;
    }

    /**
     * Internal use - serialization
     */
    public function setPen($value) {
        $this->pPen = $value;
    }

    /**
     * Shape rectangle left co-ordinate.
     *
     * @return int
     */
    public function getLeft() {
        return $this->shapeBounds->x;
    }

    /**
     * Shape rectangle left co-ordinate.
     *
     */
    public function setLeft($value) {
        $this->shapeBounds->x= $value; //$this->setIntegerProperty($this->shapeBounds->x, $value);
        $this->invalidate();
    }

    /**
     * Shape rectangle top co-ordinate.
     *
     * @return int
     */
    public function getTop() {
        return $this->shapeBounds->y;
    }

    /**
     * Shape rectangle top co-ordinate.
     *
     * @param value int
     */
    public function setTop($value) {
        $this->shapeBounds->y=$value;
        $this->invalidate();
    }

    /**
     * Shape rectangle right co-ordinate.
     *
     * @return int
     */
    public function getRight() {
        return $this->shapeBounds->getRight();
    }

    /**
     * Shape rectangle right co-ordinate.
     *
     * @param value int
     */
    public function setRight($value) {
        if ($this->shapeBounds->getRight() != $value) {
            $this->shapeBounds->setRight($value);
            $this->invalidate();
        }
    }

    /**
     * Shape rectangle bottom co-ordinate.
     *
     * @return int
     */
    public function getBottom() {
        return $this->shapeBounds->getBottom();
    }

    /**
     * Shape rectangle bottom co-ordinate.
     *
     * @param value int
     */
    public function setBottom($value) {
        if ($this->shapeBounds->getBottom() != $value) {
            $this->shapeBounds->setBottom($value);
            $this->invalidate();
        }
    }

    /* The Height of the shape. */
    public function getHeight()
    {
        return $this->shapeBounds->height;
    }

    public function setHeight($value)
    {
        $this->getShapeBounds()->setHeight($value);
    }

    /* The Width of the shape. */
    public function getWidth()
    {
        return $this->shapeBounds->width;
    }

    public function setWidth($value)
    {
        $this->shapeBounds->width = $value;
    }

    /**
     * Assign all properties from a shape to another.
     *
     * @param s Shape
     */
    public function assign($shape) {
        if ($shape != null) {
            if ($shape->bBevel != null) {
                $this->bBevel->assign($shape->bBevel);
            }
            if ($shape->bBrush != null) {
                $this->bBrush->assign($shape->bBrush);
            }

            $this->setShapeBounds($shape->shapeBounds);

            if ($shape->pPen != null) {
                $this->pPen->assign($shape->pPen, $shape->pPen->getColor());
            }
            if ($shape->shadow != null) {
                $this->shadow->assign($shape->shadow);
            }

            $this->setVisible($shape->getVisible());
            $this->setTransparent($shape->getTransparent());
        }
    }

    public function paint($gd, $rect) {

        if (!$this->bTransparent) {
            $gd->setBrush($this->getBrush());
            $gd->setPen($this->getPen());

            //CDI BorderRound
            if (($this->getShapeBorders()->getTopLeft()->getBorderRound() > 0) ||
                 ($this->getShapeBorders()->getBottomLeft()->getBorderRound() > 0)||
                 ($this->getShapeBorders()->getTopRight()->getBorderRound() > 0) ||
                 ($this->getShapeBorders()->getBottomRight()->getBorderRound() > 0))
            {
                //$gd->createImage();
                //$gd->roundRectangle($rect->x, $rect->y, $rect->getRight(),
                  //  $rect->getBottom(), $this->bBorderRound);

                $gd->drawRoundedBorders($this->getShapeBorders(),null,null);
            } else {                
                $gd->rectangle($rect);
                
                if ($this->getBrush()->getGradient()->getVisible()==true) {
            
                 $colA = array($this->getBrush()->getGradient()->getStartColor()->getRed(),
                   $this->getBrush()->getGradient()->getStartColor()->getGreen(),
                   $this->getBrush()->getGradient()->getStartColor()->getBlue());   
                 $colB = array($this->getBrush()->getGradient()->getEndColor()->getRed(),
                   $this->getBrush()->getGradient()->getEndColor()->getGreen(),
                   $this->getBrush()->getGradient()->getEndColor()->getBlue());
                       
                 $penWidth=$this->getPen()->getWidth();
                 TeeGradient::imagecolorgradient(
                   $this->getChart()->getGraphics3D()->img,
                   $rect->getX()+$penWidth, $rect->getY()+$penWidth, 
                   $rect->getRight()-$penWidth, $rect->getHeight()-$penWidth,
                    $colA,$colB
                 );            
                }                           
            }

            if (($this->shadow != null) && $this->shadow->getVisible()) {
                $this->shadow->draw($gd, $rect);
            }

            if ($this->bBevel != null) {
                $this->bBevel->draw($gd, $rect);
            }                       
        }
    }

    /**
     * The Transparency level from 0 to 100% of shape.<br>
     * Transparency is a value between 0 and 100 which sets the transparency
     * percentage with respect to foreground versus background.<br>
     * Default value: 0
     *
     * @return int
     */
    public function getTransparency() {
        return $this->getBrush()->getTransparency();
    }

    /**
     * Sets Transparency level from 0 to 100% of shape.<br>
     * Default value: 0
     *
     * @param value int
     */
    public function setTransparency($value) {
        $this->getBrush()->setTransparency($value);
    }
}

?>
