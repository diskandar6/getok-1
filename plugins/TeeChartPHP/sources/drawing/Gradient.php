<?php
 /**
 * Description:  This file contains the following class:<br>
 * Gradient class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
 /**
 * Gradient class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

class TeeGradient extends TeeBase {

    private $width = 0;
    private $height = 0;
    private $direction = 0; // Vertical
    private $startColor; // ='#f00';
    private $endColor; //='#000';
    private $step=0;  // = intval(abs($step));
    private $customTargetPolygon = null;

    // properties from teechart
    protected $visible=false;

    //private Color startColor = Color.GOLD;
    //private Color middleColor = Color.GRAY;
    //private Color endColor = Color.WHITE;

    //private float sigmaFocus = 0.5F;
    //private float sigmaScale = 1.0F;
    //private boolean sigma;
    //private boolean wrapTile = false;
    //private boolean gammaCorrection;

    //private boolean useMiddle;
    //private int transparency = 0;
    //private double angle = 0D;

    //private int radialX = 0;
    //private int radialY = 0;


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

    function __construct($c=null) {
        $this->direction = GradientDirection::$VERTICAL;
        $this->startColor = new Color(255,100,100);
        $this->endColor = new Color(255,255,255);

        parent::__construct($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->width);
        unset($this->height);
        unset($this->direction);
        unset($this->startColor);
        unset($this->endColor);
        unset($this->step);
        unset($this->customTargetPolygon);
        unset($this->visible);
    }       

    /**
     * Copies the Gradient parameter properties into the Canvas.Gradient object.
     *
     * @param value Gradient
     */
    public function assign($value) {
        //angle = value.angle;
        $this->direction = $value->direction;
        $this->startColor = $value->startColor;
        //middleColor = value.middleColor;
        $this->endColor = $value->endColor;
        //radialX = value.radialX;
        //radialY = value.radialY;

        $this->customTargetPolygon = $value->customTargetPolygon;
        /*
        sigmaFocus = value.sigmaFocus;
        sigmaScale = value.sigmaScale;
        sigma = value.sigma;
        wrapTile = value.wrapTile;
        gammaCorrection = value.gammaCorrection;
        */

        //useMiddle = value.useMiddle;
        $this->visible = $value->visible;
        //transparency = value.transparency;
    }


    /*
      Script Name: GD Gradient Fill
      Script URI: http://planetozh.com/blog/my-projects/images-php-gd-gradient-fill/
      Description: Creates a gradient fill of any shape (rectangle, ellipse, vertical, horizontal, diamond)
      Author: Ozh
      Version: 1.1
      Author URI: http://planetozh.com/
    */
    /*
    *  Parameters :
    *  - width and height : integers, dimesions of your image.
    *  - direction : string, shape of the gradient.
    *    Can be : vertical, horizontal, rectangle (or square), ellipse, ellipse2, circle, circle2, diamond.
    *  - startcolor : string, start color in 3 or 6 digits hexadecimal.
    *  - endcolor : string, end color in 3 or 6 digits hexadecimal.
    *  - step : integer, optional, default to 0. Step that breaks the smooth blending effect.
    *
    *  @return resource
    *  Example :
    *  $image = new TeeGradient(300,200,'ellipse','#f00','#000',0);
    */
    function gradientFill($w,$h,$d,$s,$e,$step=0) {

        $this->width = $w;
        $this->height = $h;
        $this->direction = $d;
        $this->startcolor = $s;
        $this->endcolor = $e;
        $this->step = intval(abs($step));

        // Attempt to create a blank image in true colors, or a new palette based image if this fails
        if (function_exists('imagecreatetruecolor')) {
            $this->image = imagecreatetruecolor($this->width,$this->height);
        } elseif (function_exists('imagecreate')) {
            $this->image = imagecreate($this->width,$this->height);
        } else {
            die('Unable to create an image');
        }

        // Fill it
        $this->fill($this->image,$this->direction,$this->startcolor,$this->endcolor);

        // Show it
        $this->display($this->image);

        // Return it
        return $this->image;
    }


    // Displays the image with a portable function that works with any file type
    // depending on your server software configuration
    function display ($im) {
        if (function_exists("imagepng")) {
            header("Content-type: image/png");
            imagepng($im);
        }
        elseif (function_exists("imagegif")) {
            header("Content-type: image/gif");
            imagegif($im);
        }
        elseif (function_exists("imagejpeg")) {
            header("Content-type: image/jpeg");
            imagejpeg($im, "", 0.5);
        }
        elseif (function_exists("imagewbmp")) {
            header("Content-type: image/vnd.wap.wbmp");
            imagewbmp($im);
        } else {
            die("Doh ! No graphical functions on this server ?");
        }
        return true;
    }

    // The main function that draws the gradient
    function fill($im,$direction=null,$start=null,$end=null) {

        (int)$r=0;
        (int)$g=0;
        (int)$b=0;

        if ($direction==null) $direction=$this->direction;
        if ($start==null) $start=$this->startColor;
        if ($end==null) $end=$this->endColor;

        switch($direction) {
            case GradientDirection::$HORIZONTAL:
                $line_numbers = imagesx($im);
                $line_width = imagesy($im);
                list($r1,$g1,$b1) = $this->rgbtoArray($start);
                list($r2,$g2,$b2) = $this->rgbtoArray($end);
                break;
            case GradientDirection::$VERTICAL:
                $line_numbers = imagesy($im);
                $line_width = imagesx($im);
                list($r1,$g1,$b1) = $this->rgbtoArray($start);
                list($r2,$g2,$b2) = $this->rgbtoArray($end);
                break;
            case GradientDirection::$ELLIPSE:
                $width = imagesx($im);
                $height = imagesy($im);
                $rh=$height>$width?1:$width/$height;
                $rw=$width>$height?1:$height/$width;
                $line_numbers = min($width,$height);
                $center_x = $width/2;
                $center_y = $height/2;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                break;
            case GradientDirection::$ELLIPSE2:
                $width = imagesx($im);
                $height = imagesy($im);
                $rh=$height>$width?1:$width/$height;
                $rw=$width>$height?1:$height/$width;
                $line_numbers = sqrt(pow($width,2)+pow($height,2));
                $center_x = $width/2;
                $center_y = $height/2;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                break;
            case GradientDirection::$CIRCLE:
                $width = imagesx($im);
                $height = imagesy($im);
                $line_numbers = sqrt(pow($width,2)+pow($height,2));
                $center_x = $width/2;
                $center_y = $height/2;
                $rh = $rw = 1;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                break;
            case GradientDirection::$CIRCLE2:
                $width = imagesx($im);
                $height = imagesy($im);
                $line_numbers = min($width,$height);
                $center_x = $width/2;
                $center_y = $height/2;
                $rh = $rw = 1;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                imagefill($im, 0, 0, imagecolorallocate( $im, $r1, $g1, $b1 ));
                break;
            case GradientDirection::$SQUARE:
            case GradientDirection::$RECTANGLE:
                $width = imagesx($im);
                $height = imagesy($im);
                $line_numbers = max($width,$height)/2;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                break;
            case GradientDirection::$DIAMOND:
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                $width = imagesx($im);
                $height = imagesy($im);
                $rh=$height>$width?1:$width/$height;
                $rw=$width>$height?1:$height/$width;
                $line_numbers = min($width,$height);
                break;
            default:
        }

        for ( $i = 0; $i < $line_numbers; $i=$i+1+$this->step ) {
            // old values :
            $old_r=$r;
            $old_g=$g;
            $old_b=$b;
            // new values :
            $r = ( $r2 - $r1 != 0 ) ? intval( $r1 + ( $r2 - $r1 ) * ( $i / $line_numbers ) ): $r1;
            $g = ( $g2 - $g1 != 0 ) ? intval( $g1 + ( $g2 - $g1 ) * ( $i / $line_numbers ) ): $g1;
            $b = ( $b2 - $b1 != 0 ) ? intval( $b1 + ( $b2 - $b1 ) * ( $i / $line_numbers ) ): $b1;
            // if new values are really new ones, allocate a new color, otherwise reuse previous color.
            // There's a "feature" in imagecolorallocate that makes this function
            // always returns '-1' after 255 colors have been allocated in an image that was created with
            // imagecreate (everything works fine with imagecreatetruecolor)
//review todo            if ( "$old_r,$old_g,$old_b" != "$r,$g,$b")
                $fill = imagecolorallocate( $im, $r, $g, $b );
            switch($direction) {
                case GradientDirection::$VERTICAL:                
                    imagefilledrectangle($im, 0, $i, $line_width, $i+$this->step, $fill);
                    break;
                case GradientDirection::$HORIZONTAL:
                    imagefilledrectangle( $im, $i, 0, $i+$this->step, $line_width, $fill );
                    break;
                case GradientDirection::$ELLIPSE:
                case GradientDirection::$ELLIPSE2:
                case GradientDirection::$CIRCLE:
                case GradientDirection::$CIRCLE2:
                    imagefilledellipse ($im,$center_x, $center_y, ($line_numbers-$i)*$rh, ($line_numbers-$i)*$rw,$fill);
                    break;
                case GradientDirection::$SQUARE:
                case GradientDirection::$RECTANGLE:
                    imagefilledrectangle ($im,$i*$width/$height,$i*$height/$width,$width-($i*$width/$height), $height-($i*$height/$width),$fill);
                    break;
                case GradientDirection::$DIAMOND:
                    imagefilledpolygon($im, array (
                        $width/2, $i*$rw-0.5*$height,
                        $i*$rh-0.5*$width, $height/2,
                        $width/2,1.5*$height-$i*$rw,
                        1.5*$width-$i*$rh, $height/2 ), 4, $fill);
                    break;
                default:
            }
        }
    }


    function fillGradient($im,$x,$y,$w,$h,$direction=null,$start=null,$end=null) {

        (int)$r=0;
        (int)$g=0;
        (int)$b=0;

        if ($direction==null) $direction=$this->direction;
        if ($start==null) $start=$this->startColor;
        if ($end==null) $end=$this->endColor;

        switch($direction) {
            case GradientDirection::$HORIZONTAL:
                $line_numbers =  $w; // imagesx($im);
                $line_width = $h; //  imagesy($im);
                list($r1,$g1,$b1) = $this->rgbtoArray($start);
                list($r2,$g2,$b2) = $this->rgbtoArray($end);
                break;
            case GradientDirection::$VERTICAL:
                $line_numbers = $h; // imagesy($im);
                $line_width = $w; // imagesx($im);
                list($r1,$g1,$b1) = $this->rgbtoArray($start);
                list($r2,$g2,$b2) = $this->rgbtoArray($end);
                break;
            case GradientDirection::$ELLIPSE:
                $width = $w; // imagesx($im);
                $height = $h; // imagesy($im);
                $rh=$height>$width?1:$width/$height;
                $rw=$width>$height?1:$height/$width;
                $line_numbers = min($width,$height);
                $center_x = $width/2;
                $center_y = $height/2;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                break;
            case GradientDirection::$ELLIPSE2:
                $width = $w; //imagesx($im);
                $height = $h; // imagesy($im);
                $rh=$height>$width?1:$width/$height;
                $rw=$width>$height?1:$height/$width;
                $line_numbers = sqrt(pow($width,2)+pow($height,2));
                $center_x = $width/2;
                $center_y = $height/2;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                break;
            case GradientDirection::$CIRCLE:
                $width = $w; //imagesx($im);
                $height = $h; // imagesy($im);
                $line_numbers = sqrt(pow($width,2)+pow($height,2));
                $center_x = $width/2;
                $center_y = $height/2;
                $rh = $rw = 1;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                break;
            case GradientDirection::$CIRCLE2:
                $width = $w; // imagesx($im);
                $height = $h; // imagesy($im);
                $line_numbers = min($width,$height);
                $center_x = $width/2;
                $center_y = $height/2;
                $rh = $rw = 1;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                imagefill($im, 0, 0, imagecolorallocate( $im, $r1, $g1, $b1 ));
                break;
            case GradientDirection::$SQUARE:
            case GradientDirection::$RECTANGLE:
                $width = $w; // imagesx($im);
                $height = $h; // imagesy($im);
                $line_numbers = max($width,$height)/2;
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                break;
            case GradientDirection::$DIAMOND:
                list($r1,$g1,$b1) = $this->rgbtoArray($end);
                list($r2,$g2,$b2) = $this->rgbtoArray($start);
                $width = $w; //imagesx($im);
                $height = $h; //imagesy($im);
                $rh=$height>$width?1:$width/$height;
                $rw=$width>$height?1:$height/$width;
                $line_numbers = min($width,$height);
                break;
            default:
        }

        for ( $i = 0; $i < $line_numbers; $i=$i+1+$this->step ) {
            // old values :
            $old_r=$r;
            $old_g=$g;
            $old_b=$b;
            // new values :
            $r = ( $r2 - $r1 != 0 ) ? intval( $r1 + ( $r2 - $r1 ) * ( $i / $line_numbers ) ): $r1;
            $g = ( $g2 - $g1 != 0 ) ? intval( $g1 + ( $g2 - $g1 ) * ( $i / $line_numbers ) ): $g1;
            $b = ( $b2 - $b1 != 0 ) ? intval( $b1 + ( $b2 - $b1 ) * ( $i / $line_numbers ) ): $b1;
            // if new values are really new ones, allocate a new color, otherwise reuse previous color.
            // There's a "feature" in imagecolorallocate that makes this function
            // always returns '-1' after 255 colors have been allocated in an image that was created with
            // imagecreate (everything works fine with imagecreatetruecolor)
//review todo            if ( "$old_r,$old_g,$old_b" != "$r,$g,$b")
                $fill = imagecolorallocate( $im, $r, $g, $b );
            switch($direction) {
                case GradientDirection::$VERTICAL:                
                    imagefilledrectangle($im, 0, $i, $line_width, $i+$this->step, $fill);
                    break;
                case GradientDirection::$HORIZONTAL:
                    imagefilledrectangle( $im, $i, 0, $i+$this->step, $line_width, $fill );
                    break;
                case GradientDirection::$ELLIPSE:
                case GradientDirection::$ELLIPSE2:
                case GradientDirection::$CIRCLE:
                case GradientDirection::$CIRCLE2:
                    imagefilledellipse ($im,$center_x, $center_y, ($line_numbers-$i)*$rh, ($line_numbers-$i)*$rw,$fill);
                    break;
                case GradientDirection::$SQUARE:
                case GradientDirection::$RECTANGLE:
                    imagefilledrectangle ($im,$i*$width/$height,$i*$height/$width,$width-($i*$width/$height), $height-($i*$height/$width),$fill);
                    break;
                case GradientDirection::$DIAMOND:
                    imagefilledpolygon($im, array (
                        $width/2, $i*$rw-0.5*$height,
                        $i*$rh-0.5*$width, $height/2,
                        $width/2,1.5*$height-$i*$rw,
                        1.5*$width-$i*$rh, $height/2 ), 4, $fill);
                    break;
                default:
            }
        }
    }
    
    function rgbtoArray($color) {
        return Array($color->red,$color->green,$color->blue); 
    }
    
    // #ff00ff -> array(255,0,255) or #f0f -> array(255,0,255)
    function hex2rgb($color) {
        $color = str_replace('#','',$color);
        $s = strlen($color) / 3;
        $rgb[]=hexdec(str_repeat(substr($color,0,$s),2/$s));
        $rgb[]=hexdec(str_repeat(substr($color,$s,$s),2/$s));
        $rgb[]=hexdec(str_repeat(substr($color,2*$s,$s),2/$s));
        return $rgb;
    }

    /**
     * Determines whether the gradient fill appears on screen.<br>
     * Default value: false
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->visible;
    }

    /**
     * Determines whether the gradient fill appears on screen.<br>
     * Default value: false
     *
     * @param value boolean
     */
    public function setVisible($value) {
        $this->visible = $this->setBooleanProperty($this->visible, $value);
    }

    /**
     * Determines the gradient direction
     * Default value: vertical
     *
     * @return string
     */
    public function getDirection() {
        return $this->direction;
    }

    /**
     * Determines the gradient direction
     * Default value: vertical
     *
     * @param value string
     */
    public function setDirection($value) {
        $this->direction = $this->setStringProperty($this->direction, $value);
    }


    /**
     * Determines the gradient startColor
     * Default value:
     *
     * @return string
     */
    public function getStartColor() {
        if ($this->startColor==null)
           $this->startColor = new Color(255,100,100);

        return $this->startColor;
    }

    /**
     * Determines the gradient startColor as RGB
     * Default value:
     *
     * @return Color
     */
    public function getStartRGBColor() {
        //return Utils::hex2rgb($this->startColor);
        return $this->startColor;
    }
    
    /**
     * Determines the gradient startColor
     * Default value:
     *
     * @param value string
     */
    public function setStartColor($value) {
        $this->startColor = $this->setStringProperty($this->startColor, $value);
    }

    /**
     * Determines the gradient startColor as RGB
     * Default value:
     *
     * @param value Color
     */
    public function setStartRGBColor($value) {
//        $this->startColor = Utils::rgbhex($value->getRed(),$value->getGreen(),$value->getBlue());
        $this->startColor = $value;
    }
    
    /**
     * Determines the gradient endColor
     * Default value:
     *
     * @return string
     */
    public function getEndColor() {
        if ($this->endColor==null)
            $this->endColor = new Color(255,255,255);        
            
        return $this->endColor;
    }

    /**
     * 
     * Determines the gradient endColor as RGB
     * Default value:
     *
     * @return Color
     */
    public function getEndRGBColor() {
        return Utils::hex2rgb($this->endColor);        
    }

    /**
     * Determines the gradient endColor
     * Default value:
     *
     * @param value string
     */
    public function setEndColor($value) {
        $this->endColor = $this->setStringProperty($this->endColor, $value);
    }
    
    /**
     * Determines the gradient endColor  as RGB
     * Default value:
     *
     * @param value Color
     */
    public function setEndRGBColor($value) {
        $this->endColor = Utils::rgbhex($value->getRed(),$value->getGreen(),$value->getBlue());        
    }
   
    /// <summary>
    /// Assign a rectangle to this property to define a custom rectangle to a Gradient.
    /// ret Point[]
    /// </summary>
    public function getCustomTargetPolygon()
    {
      return $this->customTargetPolygon;
    }

    public function setCustomTargetPolygon($value)
    {
      $this->customTargetPolygon = $value;
    }
    
    /*   
    function imagecolorgradient($img,$x1,$y1,$height,$width,$colA,$colB) {
        
        $varC1=($colA[1]-$colB[1])/$height;
        $varC2=($colA[2]-$colB[2])/$height;
        $varC3=($colA[3]-$colB[3])/$height;
        
        for ($i=0;$i<=$height;$i++) {
          $col=ImageColorAllocate($img,
               $colA[1]-floor($i*$varC1),
               $colA[2]-floor($i*$varC2),
               $colA[3]-floor($i*$varC3));
          ImageLine($img,$x1,$y1+$i,$x1+$width,$y1+$i,$col);
        }
    }    
    */ 

    static function imagecolorgradient($img,$x1,$y1,$x2,$y2,$f_c,$s_c){
     if($y2>$y1) $y=$y2-$y1;
        else $y=$y1-$y2;
     if($f_c[0]>$s_c[0]) $r_range=$f_c[0]-$s_c[0];
        else $r_range=$s_c[0]-$f_c[0];
     if($f_c[1]>$s_c[1]) $g_range=$f_c[1]-$s_c[1];
        else $g_range=$s_c[1]-$f_c[1];
     if($f_c[2]>$s_c[2]) $b_range=$f_c[2]-$s_c[2];
        else $b_range=$s_c[2]-$f_c[2];
     if ($y<>0)
     {
        $r_px=$r_range/$y;
        $g_px=$g_range/$y;
        $b_px=$b_range/$y;
     }
     $r=$f_c[0];
     $g=$f_c[1];
     $b=$f_c[2];
     for($i=0;$i<=$y;$i++){
       $col=imagecolorallocate($img,round($r),round($g),round($b));
       imageline($img,$x1,$y1+$i,$x2,$y1+$i,$col);
       if($f_c[0]<$s_c[0]) $r+=$r_px;
       else $r-=$r_px;
       if($f_c[1]<$s_c[1]) $g+=$g_px;
       else $g-=$g_px;
       if($f_c[2]<$s_c[2]) $b+=$b_px;
       else $b-=$b_px;
     }
     return $img;
    }    
   
   
    /**
    *Draws a gradient color filled polygon
    *@access private
    *@return void
    *@param $ColorHandler
    */
    private function draw_GradientPolygon($ColorHandler) {
        $ProperVertices=array();    
        $CurrentColor=0;
        
        for ($vertex=0;$vertex<count($this->Vertices);$vertex++) {
            $Vertex=explode(",",$this->Vertices[$vertex]);
            array_push($ProperVertices,$Vertex[0]);
            array_push($ProperVertices,$Vertex[1]);
        }
            
        for ($i=0;$i<count($ProperVertices)-6;$i+=2) {
            
            $current=$i;
            
            $StartPointX=$ProperVertices[$i];
            $StartPointY=$ProperVertices[$i+1];
            $FinishPointX=$ProperVertices[$i+2];
            $FinishPointY=$ProperVertices[$i+3];
        
            $RangeX=$FinishPointX-$StartPointX;
            if ($RangeX==0) $RangeX=1;
            
            $Ratio=($FinishPointY-$StartPointY)/$RangeX;
            
            $YPos=$ProperVertices[count($ProperVertices)-1];
            
            for ($XPos=$StartPointX;$XPos<$FinishPointX;$XPos++)
                ImageLine($this->Canvas,$XPos,$StartPointY+$Ratio*($XPos-$StartPointX),$XPos,$YPos,$ColorHandler[$CurrentColor++]);
        }
        
        $this->draw_Caption();    
    }   
}
?>
