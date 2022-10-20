<?php
/**
 * Description:  This file contains the following class:<br>
 * ChartBrush class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
 /**
 * ChartBrush class
 *
 * Description: Common Chart Brush (pattern) used to fill polygons and
 * rectangles
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

class ChartBrush extends TeeBase {

    private $image;
    private $hatchImage;
    private $foregroundColor;
    private $gradient;
    private $imageMode;
    private $imageTransparent;
    private $solid = true;
    private $style;
    private $wrapTile = true;

    protected $internalTransparency;
    protected $defaultColor;
    protected $defaultVisible;
    protected $visible = true;
    protected $color;


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

    public function __construct($c, $aColor=null, $startVisible=true) {

        if($aColor==null)
            $aColor=new Color(255,255,255);

        $this->imageMode=ImageMode::$STRETCH;
        $this->style=HatchStyle::$BACKWARDDIAGONAL;

        parent::__construct($c);

        $this->internalTransparency = 0;
        $this->color = $aColor;
        $this->defaultColor = $this->color;
        $this->visible = $startVisible;
        $this->defaultVisible = $this->visible;
        $this->foregroundColor = new Color (220,220,220);  // Silver
        
        unset($aColor);
    }

    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->image);
        unset($this->hatchImage);
        unset($this->foregroundColor);
        unset($this->gradient);
        unset($this->imageMode);
        unset($this->imageTransparent);
        unset($this->solid);
        unset($this->style);
        unset($this->wrapTile);
        unset($this->internalTransparency);
        unset($this->defaultColor);
        unset($this->defaultVisible);
        unset($this->visible);
        unset($this->color);
    }
        
    public function reset() {
        $this->setColor(new Color(255,255,255));  // White
        $this->setSolid(true);
        $this->setTransparency(0);
        $this->setForegroundColor(new Color(220,220,220)); // Silver
        $this->setStyle(HatchStyle::$BACKWARDDIAGONAL);
    }

    private function bufferedFrom($image) {
        return $this->chart->getGraphics3D()->bufferedFrom($image, $this->getForegroundColor());
    }

    public function getHatchTexture() {

        $this->hatchImage = $this->bufferedFrom($this->style->getImage(($this->getChart()->getParent())));

        $r = new Rectangle(0, 0, $this->hatchImage->getWidth(null),
                                    $this->hatchImage->getHeight(null));

        return new TexturePaint($this->hatchImage, $r);
    }

    public function getTexture($rect) {
        $tileRect = $rect;
        if ($this->imageMode != ImageMode::$STRETCH) {
            $tileRect = $this->getImageRect();
        }
        return new TexturePaint($this->bufferedFrom($image), $tileRect);
    }

    public function assign($b) {
        $this->foregroundColor = $b->foregroundColor;
        $this->color = $b->color;
        $this->visible = $b->visible;
        $this->style = $b->style;
        $this->image = $b->image;
        $this->imageTransparent = $b->imageTransparent;
        $this->solid = $b->solid;
        $this->wrapTile = $b->wrapTile;
        $this->imageMode = $b->imageMode;
        $this->internalTransparency = $b->internalTransparency;

        //CDI chart cannot be null
        if($this->chart == null) {
            $this->chart = $b->chart;
        }

        // chart = b.chart;  <-- problem, when assigning brush from another chart

        if ($b->gradient != null) {
            $this->getGradient()->assign($b->gradient);
        } else {
            $this->gradient = null;
        }

        $this->setNullHandle();
    }

    private function setNullHandle() {
        if ($this->chart != null) {
            $this->chart->doChangedBrush($this);
        }
    }

    public function setDefaultColor($value) {
        $this->defaultColor = $value;
        $this->color = $value;
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->gradient != null) {
            $this->gradient->setChart($this->chart);
        }
    }

    /**
     * The Transparency level from 0 to 100%.<br>
     * Transparency is a value between 0 and 100 which sets the transparency
     * percentage with respect to foreground versus background.<br>
     * Default value: 0

     * @return int
     */
    public function getTransparency() {    
        return (127*$this->internalTransparency/100);
    }

    /**
     * Sets Transparency level from 0 to 100%.<br>
     * Default value: 0
     *
     * @param value int
     */
    public function setTransparency($value) {
        if ($this->internalTransparency != $value) {
            $this->internalTransparency = $value;

            if ($this->gradient != null) {
                $this->gradient->setTransparency($value);
            }
        }
    }

    /**
     * Fills using Color only. Does not use Foreground color.<br>
     * Default value: true
     *
     * @return boolean
     */
    public function getSolid() {
        return $this->solid;
    }

    /**
     * Fills using Color only. Does not use Foreground color.<br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setSolid($value) {
        $this->solid = $this->setBooleanProperty($this->solid, $value);
    }

    /**
     * The Brush image will be Transparent when true.<br>
     * Default value: false
     *
     * @return boolean
     */
    public function getImageTransparent() {
        return $this->imageTransparent;
    }

    /**
     * Sets the Brush image to Transparent.<br>
     * Default value: false
     *
     * @param value boolean
     */
    public function setImageTransparent($value) {
        $this->imageTransparent = $this->setBooleanProperty($this->imageTransparent, $value);
    }

    public function getGradientVisible() {
        return ($this->gradient != null) && $this->gradient->visible;
    }

    /**
     * Fill Gradient.<br>
     * Gradient specifies the colors used to fill a zone.
     * The zone is filled using these three colors: StartColor, MidColor and
     * EndColor. You can control the drawing output by setting
     * Gradient.Direction.<br>
     * Use the Visible property to show / hide filling. <br>
     * Default value: null
     *
     * @return Gradient
     */
    public function getGradient() {
        if ($this->gradient == null) {
            $this->gradient = new TeeGradient($this->chart);
        }
        return $this->gradient;
    }

    /**
     * Sets the Gradient fill.<br>
     * Default value: null
     *
     * @param value Gradient
     */
    public function setGradient($value) {
        if ($value == null) {
            $this->gradient = null;
        } else {
            $this->getGradient()->assign($value);
        }
    }

    /**
     * Use invalidate when the entire canvas needs to be repainted.<br>
     * When more than one region within the canvas needs repainting, Invalidate
     * will cause the entire window to be repainted in a single pass, aing
     * flicker caused by redundant repaints. There is no performance penalty
     * for calling Invalidate multiple times before the control is actually
     * repainted.
     */
    public function invalidate() {
        $this->setNullHandle();
        parent::invalidate();
    }

    /**
     * Drawing Brush Image Style.<br>
     * Default value: Stretch
     *
     * @return ImageMode
     */
    public function getImageMode() {
        return $this->imageMode;
    }

    /**
     * Drawing Brush Image Style.<br>
     * Default value: Stretch
     *
     * @param value ImageMode
     */
    public function setImageMode($value) {
        if ($this->imageMode != $value) {
            $this->imageMode = $value;
            $this->invalidate();
        }
    }

    public function getImageRect() {
        if ($this->image !=  null) {
            return new Rectangle(0,0, $this->image->getWidth(null), $this->image->getHeight(null));
        } else {
            return null;
        }
    }

    /**
     * Drawing Brush Image Style.<br>
     * Default value: Tile
     *
     * @return boolean
     */
    public function getWrapTile() {
        return $this->wrapTile;
    }

    /**
     * Drawing Brush Image Style.<br>
     * Default value: Tile
     *
     * @param value boolean
     */
    public function setWrapTile($value) {
        if ($this->wrapTile != $value) {
            $this->wrapTile = $value;
            $this->invalidate();
        }
    }

    /**
     * Color to fill inner portions of Brush, when Solid is false.<br>
     * Default value: SILVER
     *
     *
     * @return Color
     */
    public function getForegroundColor() {
        return $this->foregroundColor;
    }

    /**
     * Specifies the Color to fill inner portions of Brush, when Solid is false.
     * <br>
     * Default value: SILVER
     *
     *
     * @param value Color
     */
    public function setForegroundColor($value) {
        $this->foregroundColor = $this->setColorProperty($this->foregroundColor, $value);
    }

    public function _applyDark($c, $quantity) {
        $this->color = $c;
        $this->applyDark($quantity);
    }

    public function applyDark($quantity) {
        $this->color = $this->color->applyDark($quantity);
        $this->setNullHandle();
    }

    /**
     * Determines the color used to fill a zone.
     *
     * @return Color
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Specifies the color used to fill a zone.
     *
     * @param value Color
     */
     public function setColor($value) {         
         $this->color = $value;
     }

    /**
     * Determines if the brush will draw lines or not.
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->visible;
    }

    /**
     * Determines if the brush will draw lines or not.
     *
     * @param value boolean
     */
    public function setVisible($value) {
        $this->visible = $this->setBooleanProperty($this->visible, $value);
    }

    /**
     * Determines the style in which the zone is filled or patterned using both
     * Color and ForegroundColor.<br>
     * Default value: HatchStyle.BackwardDiagonal
     *
     * @return HatchStyle
     */
    public function getStyle() {
        return $this->style;
    }

    /**
     * Determines the style in which the zone is filled or patterned using both
     * Color and ForegroundColor.<br>
     * Default value: HatchStyle.BackwardDiagonal
     *
     * @param value HatchStyle
     */
    public function setStyle($value) {
        if ($this->style != $value) {
            $this->style = $value;
            $this->solid = false;
            $this->hatchImage = null;
            $this->invalidate();
        }
    }

    /**
     * Image to use for fill.<br>
     * Default value: null
     *
     * @return Image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Image to use for fill.<br>
     * Default value: null
     *
     * @param value Image
     */
    public function setImage($value) {
        $this->image = $value;
        $this->solid = $this->image == null;
        $this->invalidate();
    }

    /**
     * Loads a bitmap into a ChartBrush element from the specified path.
     *
     * @param fileName String
     */
    public function loadImageFromFile($fileName) {
        $this->clearImage();
        $this->setImage(ImageUtils::getImage($fileName, ($this->getChart()->getParent())));
    }

    /**
     * Loads a bitmap into a ChartBrush element from the specified URL.
     *
     * @param location URL
     */
/* todo    public function loadImage($location) {
        $this->clearImage();
        $this->setImage(ImageUtils->getImage($location, ($this->getChart()->getParent())));
    }  */

    /**
     * Clears the ChartBrush element from all associated bitmap images.
     */
    public function clearImage() {
        $this->setImage(null);
    }

/* todo    private function writeObject($stream) {
        $stream->defaultWriteObject();

        $gd= ($this->chart==null) ? null : $this->chart->getGraphics3D();

        ImageUtils->writeImage($stream, $this->image, $gd);
        ImageUtils->writeImage($stream, $this->hatchImage, $gd);
    }

    private readObject($stream) {
        $stream->defaultReadObject();

        $tmp = ImageUtils->readImage($stream);

        if ($tmp != null) {
            $this->image = $tmp;
        }

        $tmp2 = ImageUtils->readImage($stream);

        if ($tmp2 != null) {
            $this->hatchImage = $tmp2;
        }
    }  */
}
?>
