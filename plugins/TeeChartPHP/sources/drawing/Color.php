<?php
 /**
 * Description:  This file contains the following class:<br>
 * Color class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * Color class
 *
 * Description: Color characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

 class Color
 {

    private $_empty=true;
    private $none=false;
    private $red;
    private $green;
    private $blue;
    private $alpha;
    private $gdColor;

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
    * Creates a new color
    *
    * @access       public
    * @param        integer         red [0,255]
    * @param        integer         green [0,255]
    * @param        integer         blue [0,255]
    * @param        integer         alpha [0,255]
    */

    function __construct($red=0, $green=0, $blue=0, $alpha = 0, $_empty=false, $none=false)
    {
        // Some Colors
        $this->red = (int)$red;
        $this->green = (int)$green;
        $this->blue = (int)$blue;

        $this->alpha = (int)$alpha;
        //  $this->alpha = (int)round($alpha * 127.0 / 255);

        $this->gdColor = null;
        $this->_empty = $_empty;
        $this->none = $none;
    }

    public function __destruct()    
    {        
        unset($this->_empty);
        unset($this->none);
        unset($this->red);
        unset($this->green);
        unset($this->blue);
        unset($this->alpha);
        unset($this->gdColor);        
    }   
        
    /**
    * Get GD color
    *
    * @access       public
    * @param        $img            GD image resource
    */

    function getColor($img)
    {
        // Checks if color has already been allocated
        if(!$this->gdColor)  {
            if($this->alpha == 0 || !function_exists('imagecolorallocatealpha'))
                $this->gdColor = imagecolorallocate($img, $this->red, $this->green, $this->blue);
            else
                $this->gdColor = imagecolorallocatealpha($img, $this->red, $this->green, $this->blue, $this->alpha);
        }

        // Returns GD color
        return $this->gdColor;
    }

    public function isEmpty() {
        return $this->_empty;
    }

    /**
     * Returns true when the Color equals to EMPTY color. <br>
     * EMPTY Color means objects will not fill drawing elements.
     *
     * @return Color
     */
    public function getEmpty() {
        return $this->_empty;
    }

    public function setEmpty($value) {
        $this->_empty = $value;
    }

    public function isNull() {
      return $this->none;
    }

    public function getNone() {
        return $this->none;
    }

    public function setNone($value) {
        $this->none = $value;
    }

    static public function fromArgb($a, $r, $g, $b) {
        return new Color($r, $g, $b, $a);
    }

    static public function EMPTYCOLOR(){
       return new Color(0,0,0,0,true,false);
    }

    static public function TRANSPARENT() {
        return new Color (0,0,0,127,false,true); // Transparent
    }
/*
    static public Color fromArgb(int value) {
        return new Color(value);
    }

    static public Color fromArgb(int value, Color c) {
        return new Color(c.getRed(), c.getGreen(), c.getBlue(), value);
    }

    static public fromCode($nm) {
        return new Color(Color.decode(nm).getRed(),
                         Color.decode(nm).getGreen(),Color.decode(nm).getBlue(),Color.decode(nm).getAlpha());
    }
*/
    static public function fromRgb($r, $g, $b) {
        return new Color($r, $g, $b);
    }

    /**
     * Creates a new Color instance with random RED, GREEN and BLUE color
     * components.
     *
     *
     *
     *
     * @return Color
     */
    static public function random() {
        srand(time());

        return new Color((int) (rand()%255), (int) (rand()%255),
                         (int) (rand()%255));
    }

    /**
     * The color black.  In the default sRGB space.
     */
    static public final function getBlack() {
      return new Color(0,0,0);
    }

    /**
     * The color black.  In the default sRGB space.
     */
    static public final function BLACK() {
      return self::getBlack();
    }

    /**
     * The color dark gray.  In the default sRGB space.
     */
    static public final function getDarkGray() {
      return new Color(169, 169, 169);
    }

    /**
     * The color dark gray.  In the default sRGB space.
     */
    static public final function DARK_GRAY() {
      return self::getDarkGray();
    }

    /**
     * The color yellow.  In the default sRGB space.
     */
    static public final function getYellow() {
      return new Color(255,255,0);
    }

    /**
     * The color yellow.  In the default sRGB space.
     */
    static public final function YELLOW() {
      return self::getYellow();
    }

    /**
     * The color red.  In the default sRGB space.
     */
    public function getRed() {
      return $this->red;
    }

    /**
     * The color red.  In the default sRGB space.
     */
    static public final function RED() {
      return new Color(255,0,0);
    }

    /**
     * The color green.  In the default sRGB space.
     */
    public function getGreen() {
      return $this->green;
    }

    /**
     * The color green.  In the default sRGB space.
     */
    static public final function GREEN() {
      return new Color(0,128,0);
    }

    /**
     * The color blue.  In the default sRGB space.
     */
    public function getBlue() {
      return $this->blue;
    }

    /**
     * The color blue.  In the default sRGB space.
     */
    static public final function BLUE() {
      return new Color(0,0,255);
    }

    /**
     * The color silver.  In the default sRGB space.
     */
    static public final function getSilver() {
      return new Color(192, 192, 192);
    }

    /**
     * The color silver.  In the default sRGB space.
     */
    static public final function SILVER() {
      return self::getSilver();
    }

    /**
     * The color gray.  In the default sRGB space.
     */
    static public final function  getGray() {
      return new Color(128,128,128);
    }

    /**
     * The color gray.  In the default sRGB space.
     */
    static public final function GRAY() {
      return self::getGray();
    }

    /**
     * The color white.  In the default sRGB space.
     */
    static public final function getWhite() {
      return new Color(255,255,255);
    }

    /**
     * The color white.  In the default sRGB space.
     */
    static public final function WHITE() {
      return self::getWhite();
    }

    /**
     * The color white smoke.  In the default sRGB space.
     */
    static public final function getWhiteSmoke() {
      return new Color(245, 245, 245);
    }

    /**
     * The color white smoke.  In the default sRGB space.
     */
    static public final function WHITE_SMOKE() {
      return self::getWhiteSmoke();
    }

    /**
     * The color navy.  In the default sRGB space.
     */
    static public final function getNavy() {
      return new Color(0, 0, 128);
    }

    /**
     * The color navy.  In the default sRGB space.
     */
    static public final function NAVY() {
      return self::getNavy();
    }

    /**
     * The color gold.  In the default sRGB space.
     */
    static public final function getGold() {
      return new Color(255, 215, 0);
    }

    /**
     * The color gold.  In the default sRGB space.
     */
    static public final function GOLD() {
      return self::getGold();
    }

    /*
     * The color light yellow.  In the default sRGB space.
     */
    static public final function getLightYellow() {
      return new Color(255, 255, 224);
    }

    /**
     * The color light yellow.  In the default sRGB space.
     */
    static public final function LIGHT_YELLOW() {
      return self::getLightYellow();
    }

    /**
     * The color fuchsia.  In the default sRGB space.
     */
    static public final function getFuchsia() {
      return new Color(255, 0, 255);
    }

    /**
     * The color fuchsia.  In the default sRGB space.
     */
    static public final function FUCHSIA() {
      return self::getFuchsia();
    }

    /**
     * The color teal.  In the default sRGB space.
     */
    static public final function getTeal() {
      return new Color(0, 128, 128);
    }

    /**
     * The color teal.  In the default sRGB space.
     */
    static public final function TEAL() {
      return self::getTeal();
    }

    /**
     * The color maroon.  In the default sRGB space.
     */
    static public final function getMaroon() {
      return new Color(128, 0, 0);
    }

    /**
     * The color maroon.  In the default sRGB space.
     */
    static public final function MAROON() {
      return self::getMaroon();
    }

    /**
     * The color lime.  In the default sRGB space.
     */
    static public final function getLime() {
      return new Color(0, 255, 0);
    }

    /**
     * The color lime.  In the default sRGB space.
     */
    static public final function LIME() {
      return self::getLime();
    }

    /**
     * The color olive.  In the default sRGB space.
     */
    static public final function getOlive() {
      return new Color(128, 128, 0);
    }

    /**
     * The color olive.  In the default sRGB space.
     */
    static public final function OLIVE() {
      return self::getOlive();
    }

    /**
     * The color purple.  In the default sRGB space.
     */
    static public final function getPurple() {
      return new Color(128, 0, 128);
    }

    /**
     * The color purple.  In the default sRGB space.
     */
    static public final function PURPLE() {
      return self::getPurple();
    }

    /**
     * The color aqua.  In the default sRGB space.
     */
    static public final function getAqua() {
      return new Color(0, 255, 255);
    }

    /**
     * The color aqua.  In the default sRGB space.
     */
    static public final function AQUA() {
      return self::getAqua();
    }

    /**
     * The color green yellow.  In the default sRGB space.
     */
    static public final function getGreenYellow() {
      return new Color(173, 255, 47);
    }

    /**
     * The color green yellow.  In the default sRGB space.
     */
    static public final function GREEN_YELLOW() {
      return self::getGreenYellow();
    }

    /**
     * The color sky blue.  In the default sRGB space.
     */
    static public final function getSkyBlue() {
      return new Color(135, 206, 235);
    }

    /**
     * The color sky blue.  In the default sRGB space.
     */
    static public final function SKY_BLUE() {
      return self::getSkyBlue();
    }

    /**
     * The color bisque.  In the default sRGB space.
     */
    static public final function getBisque() {
      return new Color(255, 228, 196);
    }

    /**
     * The color bisque.  In the default sRGB space.
     */
    static public final function BISQUE() {
      return self::getBisque();
    }

    /**
     * The color indigo.  In the default sRGB space.
     */
    static public final function getIndigo() {
      return new Color(75, 0, 130);
    }

    /**
     * The color indigo.  In the default sRGB space.
     */
    static public final function INDIGO() {
      return self::getIndigo();
    }

    /**
     * The color pink.  In the default sRGB space.
     */
    static public final function getPink() {
      return new Color(255,0,255);
    }

    /**
     * The color pink.  In the default sRGB space.
     */
    static public final function PINK() {
      return self::getPink();
    }

    /**
     * The color orange.  In the default sRGB space.
     */
    static public final function getOrange() {
      return new Color(255,128,64);
    }

    /**
     * The color orange.  In the default sRGB space.
     */
    static public final function ORANGE() {
      return self::getOrange();
    }

    /**
     * The color magenta.  In the default sRGB space.
     */
    static public final function getMagenta() {
      return new Color(168, 0, 168);
    }

    /**
     * The color magenta.  In the default sRGB space.
     */
    static public final function MAGENTA() {
      return self::getMagenta();
    }

    /**
     * The color cyan.  In the default sRGB space.
     */
    static public final function getCyan() {
      return new Color(0, 128, 128);
    }

    /**
     * The color cyan.  In the default sRGB space.
     */
    static public final function CYAN() {
      return self::getCyan();
    }

    /**
     * Returns Color with transparency percentage applied.
     *
     * @param value int
     * @return Color with transparency percentage applied.
     */
    public function transparentColor($value) {
        return new Color(self::getRed(), self::getGreen(), self::getBlue(),
                         MathUtils::round(((100 - $value) * 2.55)));
    }

    /**
     * Returns an integer from 0 to 100 that is the percent of transparency
     * of this color.
     *
     * @param value Color
     * @return int
     * @see #transparentColor
     * @see java.awt.Color#getAlpha
     */
    static public function transparencyOf($value) {
        $a = $value->getAlpha();
        return (a == 255) ? 0 : (a == 0) ? 100 : (int) (0.39216 * (255 - a));
    }


    /**
     * Returns the alpha component in the range 0-255.
     * @return the alpha component.
     * @see #getRGB
     */

    public function getAlpha() {
        return $this->alpha;
        //return ($this->getRGB() >> 24) & 0xff;
    }

    /**
     * Returns the RGB value representing the color in the default sRGB
     * {@link ColorModel}.
     * (Bits 24-31 are alpha, 16-23 are red, 8-15 are green, 0-7 are
     * blue).
     * @return the RGB value of the color in the default sRGB
     *         <code>ColorModel</code>.
     * @see java.awt.image.ColorModel#getRGBdefault
     * @see #getRed
     * @see #getGreen
     * @see #getBlue
     * @since JDK1.0
     */
    public function getRGB() {
	    return 0/*value*/;   /* TODO review what to return ?? */
    }


    /**
     * Converts the Color parameter to a darker color.<br> The HowMuch
     * parameter indicates the quantity of dark increment.<br>
     * It is used by Bar Series and Pie Series to calculate the right color t
     * to draw Bar sides and Pie 3D zones.
     *
     * @param howMuch int
     * @return Color
     */
    public function applyDark($howMuch) {
        $r = $this->red;
        if ($r > $howMuch) {
            $r -= $howMuch;
        } else {
            $r = 0;
        }

        $gr = $this->green;
        if ($gr > $howMuch) {
            $gr -= $howMuch;
        } else {
            $gr = 0;
        }

        $b = $this->blue;
        if ($b > $howMuch) {
            $b -= $howMuch;
        } else {
            $b = 0;
        }

        return new Color($r, $gr, $b, $this->alpha);
    }


    /*
     * Converts the Color parameter to a brighter color.<br>
     * The HowMuch parameter indicates the quantity of bright increment.<br>
     * It is used by Styles.Bar Series and Styles.Pie Series to calculate the
     * right color to draw Bar sides and Pie 3D zones.
     *
     * @param howMuch int
     * @return Color
     */
    public function applyBright($howMuch) {
        $r = $this->red;
        if (($r + $howMuch) < 256) {
            $r += $howMuch;
        } else {
            $r = 255;
        }

        $g = $this->green;
        if (($g + $howMuch) < 256) {
            $g += $howMuch;
        } else {
            $g = 255;
        }

        $b = $this->blue;
        if (($b + $howMuch) < 256) {
            $b += $howMuch;
        } else {
            $b = 255;
        }

        return new Color($r, $g, $b, $this->getAlpha());
    }
}

?>