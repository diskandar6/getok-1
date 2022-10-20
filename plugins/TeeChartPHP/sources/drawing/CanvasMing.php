<?php
 /**
 * Description:  This file contains the following class:<br>
 * CanvasMing class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * CanvasMing class
 *
 * Description: Class with all Chart with Ming Canvas drawing methods.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

class CanvasMing extends TeeBase
{
    // Private properties
    private $tmpImg=null;
    private $rectClip;
    private $polygonClip;
    private $is3D=false;
    private $isOrtho=false;
    private $iZoomText=false;
    private $xCenter=0;
    private $yCenter=0;
    private $zCenter=0;
    private $xCenterOffset=0;
    private $yCenterOffset=0;
    private $buffered=true;
    private $rotationCenter=null;
    protected $moveToX;
    protected $moveToY;
    private $iPoints;
    private $s2;
    private $c1;
    private $s1;
    private $c3;
    private $s3;
    private $c2;
    private $c2s3;
    private $c2c3;
    private $tempXX;
    private $tempYX;
    private $tempXZ;
    private $tempYZ;
    private $iPerspec;
    private $iOrthoX=0;
    private $iOrthoY=0;
    private $iZoomFactor=0;
    private $iZoomPerspec=0;
    private $pie3D;
    private $colorPalette;

    private static $NUMCIRCLEPOINTS = 64;
    public static $DARKCOLORQUANTITY = 64;
    private static $DARKERCOLORQUANTITY = 128;

    // Protected properties
    protected $aspect;
    protected $smoothingMode=false;
    protected $textSmooth=false;
    protected $font=null;
    protected $stringFormat;
    protected $bounds;
    protected $brush=null;
    protected $pen=null;
    protected $metafiling;
    protected $imageinterlace=true;
    protected $imagereflection=false;
    // For CanvasFlex
    protected $supportsID;

    // Public properties
    public $img;
    public $shape;
    
    public $width=0;
    public $height=0;
    public $monochrome;
    public $iPointDoubles;


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
    * Creates a new Graphics object
    *
    * @access       public
    * @param IBaseChart $c
    * @param integer $width
    * @param integer $height
    */
    function __construct($c, $width, $height) {

        $this->font = new ChartFont(null);
        $this->stringFormat = new StringFormat();
        $this->brush = new ChartBrush(null,null,null);
        $this->pen = new ChartPen(null,new Color(0,0,0));
        $this->colorPalette = Theme::getSkyBluesPalette();
        $this->rotationCenter = new Point3D();

        $this->iPoints = array();
        $this->iPoints[0]=new TeePoint();
        $this->iPoints[1]=new TeePoint();
        $this->iPoints[2]=new TeePoint();
        $this->iPoints[3]=new TeePoint();

        $this->iPointDoubles = Array();
        $this->iPointDoubles[0]= new PointDouble();
        $this->iPointDoubles[1]= new PointDouble();
        $this->iPointDoubles[2]= new PointDouble();
        $this->iPointDoubles[3]= new PointDouble();

        $this->width = $width;
        $this->height= $height;

        $this->createImage();           
                
        parent::__construct($c);  // TeeBase
       
        if ($this->chart != null) {
            $this->setAspect($this->chart->getAspect());            
      }      
    }
    
    public function __destruct()    
    {        
        parent::__destruct();                
        
        unset($this->tmpImg);
        unset($this->rectClip);
        unset($this->polygonClip);
        unset($this->is3D);
        unset($this->isOrtho);
        unset($this->iZoomText);
        unset($this->xCenter);
        unset($this->yCenter);
        unset($this->zCenter);
        unset($this->xCenterOffset);
        unset($this->yCenterOffset);
        unset($this->buffered);
        unset($this->rotationCenter);
        unset($this->moveToX);
        unset($this->moveToY);
        unset($this->iPoints);
        unset($this->s2);
        unset($this->c1);
        unset($this->s1);
        unset($this->c3);
        unset($this->s3);
        unset($this->c2);
        unset($this->c2s3);
        unset($this->c2c3);
        unset($this->tempXX);
        unset($this->tempYX);
        unset($this->tempXZ);
        unset($this->tempYZ);
        unset($this->iPerspec);
        unset($this->iOrthoX);
        unset($this->iOrthoY);
        unset($this->iZoomFactor);
        unset($this->iZoomPerspec);
        unset($this->pie3D);
        unset($this->colorPalette);
        unset($this->aspect);
        unset($this->smoothingMode);
        unset($this->textSmooth);
        unset($this->font);
        unset($this->stringFormat);
        unset($this->bounds);
        unset($this->brush);
        unset($this->pen);
        unset($this->metafiling);
        unset($this->imageinterlace);
        unset($this->imagereflection);
        unset($this->supportsID);
        unset($this->img);
        unset($this->shape);
        unset($this->width);
        unset($this->height);
        unset($this->monochrome);
        unset($this->iPointDoubles); 
    }
    
    function getImg()
    {
       return $this->img;   
    }

    /**************************************************************************
    * Drawing methods............                                             *
    **************************************************************************/

    /**
    * Paints the image in rectangle r.
    *
    * @param r Rectangle
    * @param image Image
    * @param mode ImageMode
    * @param transparent boolean
    */
    public function draw($r, $image, $mode, $shapeBorders, $transparent) {

        /*        
        imageAlphaBlending($image, false);
        imageSaveAlpha($image, true);

        //Get the sizes of both pix
        $sourcefile_width=imagesx($this->img);
        $sourcefile_height=imagesy($this->img);
        $image_width=imagesx($image);
        $image_height=imagesy($image);


        if ($mode==ImageMode::$TILE) {
          // TODO
        }
        elseif ($mode==ImageMode::$CENTER) {
            $dest_x = ( $sourcefile_width / 2 ) - ( $image_width / 2 );
            $dest_y = ( $sourcefile_height / 2 ) - ( $image_height / 2 );
            imagecopy($this->img, $image, $dest_x, $dest_y, 0, 0,
               $image_width, $image_height);
        }
        elseif ($mode==ImageMode::$NORMAL) {
            $dest_x = 0;
            $dest_y = 0;

            imagecopy($this->img, $image, $dest_x, $dest_y, 0, 0,
               $image_width, $image_height);
        }
        else{
          // Streched
          $dest_x = 0;
          $dest_y = 0;

          imagecopyresized($this->img, $image,$dest_x, $dest_y, 0, 0,
              $sourcefile_width, $sourcefile_height,
              $image_width, $image_height);
        }

        // Check Round borders
        // Top-left corner
        if (($shapeBorders->getTopLeft()->getBorderRound() > 0) || ($shapeBorders->getBottomLeft()->getBorderRound() > 0) ||
            ($shapeBorders->getTopRight()->getBorderRound() > 0) || ($shapeBorders->getBottomRight()->getBorderRound() > 0)) {

              $this->drawRoundedBorders($shapeBorders,null,null);
        }
        */
    }

    /**
     * Draws a line with an arrow head of ArrowWidth and ArrowHeight dimensions
     * in pixels.
     *
     * @param filled boolean
     * @param fromPoint Point
     * @param toPoint Point
     * @param headWidth int
     * @param headHeight int
     * @param z int
     */
    public function arrow($filled, $fromPoint, $toPoint,
                      $headWidth, $headHeight, $z) {
        /*
                                     pc |\
                      ph             pf | \
                           |------------   \ ToPoint
                      From |------------   /
                      pg             pe | /
                                     pd |/
         */

        $dx = $toPoint->getX() - $fromPoint->getX();
        $dy = $fromPoint->getY() - $toPoint->getY();
        $l = sqrt($dx * $dx + $dy * $dy);

        if ($l > 0) { // if at least one pixel...
            $a = new ArrowPoint();
            $a->z = $z;
            $a->g = $this;

            (int) $tmpHoriz = $headWidth;
            (int) $tmpVert = min(MathUtils::round($l), $headHeight);
            $a->sinA = $dy / $l;
            $a->cosA = $dx / $l;
            $xb = $toPoint->getX() * $a->cosA - $toPoint->getY() * $a->sinA;
            $yb = $toPoint->getX() * $a->sinA + $toPoint->getY() * $a->cosA;
            $a->x = $xb - $tmpVert;
            $a->y = $yb - $tmpHoriz * 0.5;

            $pc = $a->calc();
            $a->y = $yb + $tmpHoriz * 0.5;
            $pd = $a->calc();

            if ($filled) {
                $tmpHoriz4 = $tmpHoriz * 0.25;
                $a->y = $yb - $tmpHoriz4;
                $pe = $a->calc();
                $a->y = $yb + $tmpHoriz4;
                $pf = $a->calc();
                $a->x = $fromPoint->x * $a->cosA - $fromPoint->y * $a->sinA;
                $a->y = $yb - $tmpHoriz4;
                $pg = $a->calc();
                $a->y = $yb + $tmpHoriz4;
                $ph = $a->calc();
                
                $tmp = Array($ph, $pg, $pe, $pc, $this->calc3DPoint($toPoint->getX(),$toPoint->getY(),
                    $z), $pd, $pf);
                    
                    /*
            TODO    $this->polygon($tmp);
                */
            } else {
                $this->moveToZ($fromPoint, $z);
                $this->lineTo($toPoint, $z);
                $this->lineTo($pd, $z);
                $this->moveToZ($toPoint, $z);
                $this->lineTo($pc, $z);
            }
        }
    }

    /**
     * Draws Bezier splines for the Point array p at displacement z
     *
     * @param z int
     * @param p Point[]
     */
    public function drawBeziersRect($z, $p) {
        $this->internalBezier($z, true, $p);
    }
        
    /**
     * Draws Bezier splines for the Point array p
     *
     * @param p Point[]
     */
    public function drawBeziers($p) {
        $this->internalBezier(0, false, $p);
    }
    
    private function internalBezier($z, $is3D, $points) {
        if ($is3D) {
            $this->moveToXYZ($points[0]->x, $points[0]->y, $z);
        } else {
            $this->moveTo($points[0]);
        }

        $this->drawBezier($is3D, $z, $points, 2);
        $t = 4;
        do {
            $this->drawBezier($is3D, $z, $points, $t);
            $t += 2;
        } while (!($t > sizeof($points) - 1));
    }   
    
    private function drawBezier($is3D, $z, $points, $first) {

        $p1 = $points[$first - 2];
        $p2 = $points[$first - 1];
        $p3 = $points[$first];

        for ($t = 1; $t < 32; $t++) {
            $mu = $t / 32;
            $mu2 = $mu * $mu;
            $mum1 = 1 - $mu;
            $mum12 = $mum1 * $mum1;

            $p = new TeePoint((int) ($p1->x * $mum12 + 2 * $p2->x * $mum1 * $mu +
                                       $p3->x * $mu2),
                                (int) ($p1->y * $mum12 + 2 * $p2->y * $mum1 * $mu +
                                       $p3->y * $mu2));

            if ($is3D) {
                $this->lineTo($p, $z);
            } else {
                $this->__lineTo($p);
            }
        }
    }
     
    /**
     * Calculates and returns the XY position in pixels of the XYZ 3D
     * coordinate.<br>
     * Can be used when custom drawing using 3D XYZ coordinates are returned
     * from the axes or not.
     *
     * @param x int
     * @param y int
     * @param z int
     * @return Point
     */
    public function calc3DPos($x, $y, $z) {
        if ($this->isOrtho) {
            return new TeePoint(($this->iZoomFactor * ($x - $this->xCenter +
                   ($this->iOrthoX * $z))) + $this->xCenterOffset,
                   ($this->iZoomFactor * ($y - $this->yCenter - ($this->iOrthoY *
                   $z))) + $this->yCenterOffset);
        } else
        if ($this->is3D) {
            $z -= $this->zCenter;
            $x -= $this->xCenter;
            $y -= $this->yCenter;

            $zz = $z * $this->c2 - $x * $this->s2;

            $tmp = $this->iZoomFactor;

            if ($this->iPerspec) {
                $tmp /= (1 + $this->iZoomPerspec * ($zz * $this->c1 + $y * $this->s1));
            }

            return new TeePoint( (($x * $this->c2 + $z * $this->s2) * $tmp) + $this->xCenterOffset,
                              (($y * $this->c1 - $zz * $this->s1) * $tmp) + $this->yCenterOffset);
        } else {
            return new TeePoint($x, $y);
        }
    }

    /**
     * Calculates and returns the XY position as double of the XYZ 3D
     * coordinate.<br>
     * Can be used when custom drawing using 3D XYZ coordinates are returned
     * from the axes or not.
     * Returns PointDouble
     */
    public function calc3DPosDouble($x, $y, $z, $pointDouble) {
        if ($this->isOrtho) {
            return new PointDouble((int) ($this->iZoomFactor * ($x - $this->xCenter + ($this->iOrthoX * $z))) +
                             $this->xCenterOffset,
                             (int) ($this->iZoomFactor * ($y - $this->yCenter - ($this->iOrthoY * $z))) +
                             $this->yCenterOffset);
        } else
        if ($this->is3D) {
            $z -= $this->zCenter;
            $x -= $this->xCenter;
            $y -= $this->yCenter;

            $zz = $z * $this->c2 - $x * $this->s2;

            $tmp = $this->iZoomFactor;

            if ($this->iPerspec) {
                $tmp /= (1 + $this->iZoomPerspec * ($zz * $this->c1 + $y * $this->s1));
            }

            return new PointDouble((int) (($x * $this->c2 + $z * $this->s2) * $tmp) + $this->xCenterOffset,
               (int) (($y * $this->c1 - $zz * $this->s1) * $tmp) + $this->yCenterOffset);

        } else {
            return new PointDouble($x, $y);
        }
    }

    /**
     * Calculates and returns the XY position in pixels of the point p Z 3D
     * coordinate. <br>
     * Can be used when custom drawing using 3D XYZ coordinates are returned
     * from the axes or not.
     *
     * @param source Point3D
     * @return Point
     */
    public function _calc3DPos($source) {
        return $this->calc3DPos($source->getX(), $source->getY(), $source-getZ());
    }

    /**
     * Calculates and returns the XY position in pixels of the point p Z 3D
     * coordinate.<br>
     * Can be used when custom drawing using 3D XYZ coordinates are returned
     * from the axes or not.
     *
     * @param source Point
     * @param z int
     * @return Point
     */
    public function __calc3DPos($source, $z) {
        return $this->calc3DPos($source->getX(), $source->getY(), $z);
    }

    /**
     * Calculates and returns the XY position in pixels of the point p with
     * Z = 0 3D coordinate.<br>
     * Can be used when custom drawing using 3D XYZ coordinates are returned
     * from the axes or not.
     *
     * @param source Point
     * @return Point
     */
    public function ___calc3DPos($source) {
        return $this->calc3DPos($source->x, $source->y, 0);
    }

    public function calc3DPoint($x, $y, $z=0) {
        return $this->calc3DPos($x, $y, $z);
    }

    public function calcPerspective($r) {
        $PERSPECFACTOR = 1.0 / 150.0;
        $perspec = $this->aspect->getPerspective();
        $this->iPerspec = ($perspec > 0);

        if ($this->iPerspec) {
            $tmp = $r->width;
            if ($tmp < 1) {
                $tmp = 1;
            }

            $this->iZoomPerspec = $this->iZoomFactor * $perspec * $PERSPECFACTOR / $tmp;
        }
    }

    public function calcTrigValues() {
        $rx = 0;
        $ry = 0;
        $rz = 0;

        if (!$this->aspect->getOrthogonal()) {
            $rx = -$this->aspect->getElevation();
            $ry = -$this->aspect->getRotation();
            $rz = $this->aspect->getTilt();
        }

        $this->s1 = sin($rx * MathUtils::getPiStep());
        $this->c1 = cos($rx * MathUtils::getPiStep());

        $this->s2 = sin($ry * MathUtils::getPiStep());
        $this->c2 = cos($ry * MathUtils::getPiStep());
        $this->s3 = sin($rz * MathUtils::getPiStep());
        $this->c3 = cos($rz * MathUtils::getPiStep());

        $this->c2s3 = $this->c2 * $this->s3;
        $this->c2c3 = max(1E-5, $this->c2 * $this->c3);

        $this->tempXX = max(1E-5, $this->s1 * $this->s2 * $this->s3 + $this->c1 * $this->c3);
        $this->tempYX = ($this->c3 * $this->s1 * $this->s2 - $this->c1 * $this->s3);

        $this->tempXZ = ($this->c1 * $this->s2 * $this->s3 - $this->c3 * $this->s1);
        $this->tempYZ = ($this->c1 * $this->c3 * $this->s2 + $this->s1 * $this->s3);

        $this->iPerspec = false;
        $this->iZoomPerspec = 0;
    }

    public function changed($o) {}

    function unClip() {
    /*
      if (!$this->rectClip==null)
      {
        $x = $this->rectClip->getX();
        $y = $this->rectClip->getY();
        imagecopymerge($this->tmpImg, $this->img,$x,$y,$x,$y,
        $this->rectClip->getWidth(),$this->rectClip->getHeight(),100);

        imagecopy($this->img,$this->tmpImg,0,0,0,0,imagesx($this->img),imagesy($this->img));
        $this->rectClip=null;
      }

      if (!$this->polygonClip==null)
      {
        // TODO polygon uniclip
        $this->polygonClip=null;
      }
      */
    }

    /**
     * Creates a Windows GDI clipping region and selects it into
     * TChart.<!-- -->Canvas device context handle.<br>
     *
     * @param left int
     * @param top int
     * @param right int
     * @param bottom int
     */
    public function clipRectangle($left, $top, $right, $bottom) {
      /* TODO
      $top=$top-2;
      $bottom++;
      $right=$right+2;

      $this->rectClip=new Rectangle();
      $this->rectClip->x=$left;
      $this->rectClip->y=$top;
      $this->rectClip->width=$right-$left;
      $this->rectClip->height=$bottom-$top;

      $this->tmpImg = imagecreatetruecolor(imagesx($this->img), imagesy($this->img));

      // Converts to Transparent image
      imagesavealpha($this->tmpImg, true);

      // Check if required or not
      $trans_colour = imagecolorallocatealpha($this->tmpImg, 0, 0, 0, 127);
      imagefill($this->tmpImg, 0, 0, $trans_colour);
      

      imagecopy($this->tmpImg,$this->img,0,0,0,0,imagesx($this->img),imagesy($this->img));
      */
    }

    /**
     * Creates a Windows GDI clipping region and selects it into
     * TChart.<!-- -->Canvas device context handle.<br>
     *
     * @param polygonPoints - Array of TeePoints
     */
    public function clipPolygon($polygonPoints) {
    /* TODO clipPolygon
      $this->polygonClip=Array();
      $this->polygonClip=$polygonPoiints;
      */  
    }
    
    /**
     * Paints a cone with Cone Percent.<br>
     * Use <br>ONLY with OPENGL</b>.<br>
     * This parameter varies the apex size
     * as a percentage of the base.<br>
     *
     * @param vertical boolean
     * @param r Rectangle
     * @param z0 int
     * @param z1 int
     * @param darkSides boolean
     * @param conePercent int varies the apex size as a percentage of the base.
     */
    public function cone($vertical, $r, $z0, $z1, $darkSides, $conePercent=0) {
        $this->internalCylinder($vertical, $r, $z0, $z1, $darkSides, $conePercent);
    }

    /**
     * Draws cylinder toggle Boolean for vertical or horizontal cylinder.
     *
     * @param vertical boolean
     * @param r Rectangle
     * @param z0 int
     * @param z1 int
     * @param darkSides boolean
     */
    public function cylinder($vertical, $r, $z0, $z1, $darkSides) {
        $this->internalCylinder($vertical, $r, $z0, $z1, $darkSides, 100);
    }

    private function internalCylinder($vertical, $r, $z0, $z1, $dark3D, $conePercent) {
    /*
        $NUMCYLINDERSIDES = 16;   // 256
        $STEP = 2.0 * M_PI / $NUMCYLINDERSIDES; 
        $STEPCOLOR = 256 / $NUMCYLINDERSIDES;         // 512
        
        $poly = Array();
        $tmpPoly = Array();
          
        $oldColor = $this->brush->getColor();
          
        (int) $zRadius = ($z1 - $z0) / 2;
        (int) $tmpMidZ = ($z1 + $z0) / 2;

        if ($vertical) {
            
            (int) $radius = ($r->getRight() - $r->x) / 2;
            (int) $tmpMid = ($r->getRight() + $r->x) / 2;
            (int) $tmpSize = abs($r->getBottom() - $r->y);

            for ($t = 0; $t < $NUMCYLINDERSIDES; $t++) {
                (double) $tmpSin = sin(($t - 3) * $STEP);
                (double) $tmpCos = cos(($t - 3) * $STEP);

                $poly[$t] = new Point3D();

                $poly[$t]->x = $tmpMid + MathUtils::round($tmpSin * $radius);

                if ($r->y < $r->getBottom()) {
                    $poly[$t]->y = $r->y;
                } else {
                    $poly[$t]->y = $r->getBottom();
                }

                $poly[$t]->z = $tmpMidZ - MathUtils::round($tmpCos * $zRadius);
            }
            $radius = MathUtils::round($radius * $conePercent * 0.01);
            $zRadius = MathUtils::round($zRadius * $conePercent * 0.01);

            $tmpPoly[1] = $this->calc3DPoint($poly[0]->x, $poly[0]->y + $tmpSize, $poly[0]->z);

            $tmpSin = sin((1 - 4) * $STEP);
            $tmpCos = cos((1 - 4) * $STEP);

            $poly[0]->x = $tmpMid + MathUtils::round($tmpSin * $radius);
            $poly[0]->z = $tmpMidZ - MathUtils::round($tmpCos * $zRadius);

            $tmpPoly[0] = $this->calc3DPoint($poly[0]->x,$poly[0]->y,$poly[0]->z);

            $numSide = 0;

            for ($t = 1; $t < $NUMCYLINDERSIDES; $t++) {
                $tmpPoly[2] = $this->calc3DPoint($poly[$t]->x, $poly[$t]->y + $tmpSize,
                                         $poly[$t]->z);

                $tmpSin = sin(($t - 3) * $STEP);
                $tmpCos = cos(($t - 3) * $STEP);

                $poly[$t]->x = $tmpMid + MathUtils::round($tmpSin * $radius);
                $poly[$t]->z = $tmpMidZ - MathUtils::round($tmpCos * $zRadius);

                $tmpPoly[3] = $this->calc3DPoint($poly[$t]->x,$poly[$t]->y,$poly[$t]->z);
                $tmp = ($tmpPoly[0]->x - $tmpPoly[2]->x + $tmpPoly[1]->x -
                       $tmpPoly[3]->x) < 0;
                if ($tmp) {
                    if ($dark3D) {                           
                        $this->internalApplyDark($oldColor, $STEPCOLOR * $numSide);
                    }

                    $p = Array($tmpPoly[0], $tmpPoly[1], $tmpPoly[2], $tmpPoly[3]);                    
                    $this->polygon($p);
                }
                $tmpPoly[0] = $tmpPoly[3];
                $tmpPoly[1] = $tmpPoly[2];
                $numSide++;
            }
        } else {
            $radius = ($r->getBottom() - $r->y) / 2;
            $tmpMid = ($r->getBottom() + $r->y) / 2;      
           
            $tmpSize = $r->getRight() - $r->X;

            for ($t = 0; $t < $NUMCYLINDERSIDES; $t++) {
                $tmpSin = sin(($t - 4) * $STEP);
                $tmpCos = cos(($t - 4) * $STEP);

                $poly[$t] = new Point3D();
                         
                if ($r->x < $r->getRight()) {
                    $poly[$t]->x = $r->getRight();
                } else {
                    $poly[$t]->x = $r->x;
                }
            
                $poly[$t]->y = $tmpMid + MathUtils::round($tmpSin * $radius);
                $poly[$t]->z = $tmpMidZ - MathUtils::round($tmpCos * $zRadius);
            }

            $radius = MathUtils::round($radius * $conePercent * 0.01);
            $zRadius = MathUtils::round($zRadius * $conePercent * 0.01);
            $tmpSize = abs($r->getRight() - $r->x);

            $tmpPoly[1] = $this->calc3DPoint($poly[0]->x - $tmpSize, $poly[0]->y, $poly[0]->z);

            $tmpSin = sin( -4 * $STEP);
            $tmpCos = cos( -4 * $STEP);

            $poly[0]->y = $tmpMid + MathUtils::round($tmpSin * $radius);
            $poly[0]->z = $tmpMidZ - MathUtils::round($tmpCos * $zRadius);
                          
                        
            $tmpPoly[0] = $this->calc3DPoint($poly[0]->x,$poly[0]->y,$poly[0]->z);
            $numSide = 0;

            for ($t = 1; $t < $NUMCYLINDERSIDES; $t++) {
                $tmpPoly[2] = $this->calc3DPoint($poly[$t]->x - $tmpSize, $poly[$t]->y,
                                         $poly[$t]->z);

                $tmpSin = sin(($t - 4) * $STEP);
                $tmpCos = cos(($t - 4) * $STEP);

                $poly[$t]->y = $tmpMid + MathUtils::round($tmpSin * $radius);
                $poly[$t]->z = $tmpMidZ - MathUtils::round($tmpCos * $zRadius);

                $tmpPoly[3] = $this->calc3DPoint($poly[$t]->x,$poly[$t]->y,$poly[$t]->z);
                $tmp = ($tmpPoly[0]->y - $tmpPoly[2]->y + $tmpPoly[1]->y -
                       $tmpPoly[3]->y) < 0;

                if ($tmp) {
                    if ($dark3D) {                
                         $this->internalApplyDark($oldColor, $STEPCOLOR * $numSide);
                    }                                                                  

                    $p = Array($tmpPoly[0], $tmpPoly[1], $tmpPoly[2], $tmpPoly[3]);
                    $this->polygon($p);
                }

                $tmpPoly[0] = $tmpPoly[3];
                $tmpPoly[1] = $tmpPoly[2];
                $numSide++;
            }
        }

        for ($t = 0; $t < $NUMCYLINDERSIDES; $t++) {
            $tmpPoly[$t] = $this->calc3DPoint($poly[$t]->x,$poly[$t]->y,$poly[$t]->z);
        }

        if ($dark3D) {
            $this->internalApplyDark($oldColor, $DARKCOLORQUANTITY);
        }

        $this->polygon($tmpPoly);
        */
    }
    

    function imagegradientellipse($image, $cx, $cy, $w, $h, $ic, $oc){
    /*    $w = abs($w);
        $h = abs($h);
        $oc = array(0xFF & ($oc >> 0x10), 0xFF & ($oc >> 0x8), 0xFF & $oc);
        $ic = array(0xFF & ($ic >> 0x10), 0xFF & ($ic >> 0x8), 0xFF & $ic);
        $c0 = ($oc[0] - $ic[0]) / $w;
        $c1 = ($oc[1] - $ic[1]) / $w;
        $c2 = ($oc[2] - $ic[2]) / $w;
        $i = 0;
        $j = 0;
        $is = ($w<$h)?($w/$h):1;
        $js = ($h<$w)?($h/$w):1;
        while(1){
            $r = $oc[0] - floor($i * $c0);
            $g = $oc[1] - floor($i * $c1);
            $b = $oc[2] - floor($i * $c2);
            $c = imagecolorallocate($image, $r, $g, $b);
            imagefilledellipse($image, $cx, $cy, $w-$i, $h-$j, $c);
            if($i < $w){
                $i += $is;
            }
            if($j < $h){
                $j += $js;
            }
            if($i >= $w && $j >= $h){
                break;
            }
        }
        */
    }

    function imagegradientellipsealpha($image, $cx, $cy, $w, $h, $ic, $oc){
    /*       $w = abs($w);
           $h = abs($h);
           $oc = array(0xFF & ($oc >> 0x10), 0xFF & ($oc >> 0x8), 0xFF & $oc);
           $ic = array(0xFF & ($ic >> 0x10), 0xFF & ($ic >> 0x8), 0xFF & $ic);
           $c0 = ($oc[0] - $ic[0]) / $w;
           $c1 = ($oc[1] - $ic[1]) / $w;
           $c2 = ($oc[2] - $ic[2]) / $w;
           $ot = $oc >> 24;
           $it = $ic >> 24;
           $ct = ($ot - $it) / $w;
           $i = 0;
           $j = 0;
           $is = ($w<$h)?($w/$h):1;
           $js = ($h<$w)?($h/$w):1;
           while(1){
               $r = $oc[0] - floor($i * $c0);
               $g = $oc[1] - floor($i * $c1);
               $b = $oc[2] - floor($i * $c2);
               $t = $ot - floor($i * $ct);
               $c = imagecolorallocatealpha($image, $r, $g, $b, $t);
               imageellipse($image, $cx, $cy, $w-$i, $h-$j, $c);
               if($i < $w){
                   $i += $is;
               }
               if($j < $h){
                   $j += $js;
               }
               if($i >= $w && $j >= $h){
                   break;
               }
           }
           */
    }
    
    private function clipToRight($rect, $minZ, $maxZ) {
        /*
        $p = Array();
        $p[0] = new TeePoint();
        $p[1] = new TeePoint();
        $p[2] = new TeePoint();
        $p[3] = new TeePoint();
        $p[4] = new TeePoint();
        $p[5] = new TeePoint();

        $p[0] = $this->calc3DPoint($rect->x, $rect->getBottom(), $minZ);
        $p[1] = $this->calc3DPoint($rect->x, $rect->y, $minZ);

        {
            $pa = $this->calc3DPoint($rect->x, $rect->y, $maxZ);
            $pb = $this->calc3DPoint($rect->getRight(), $rect->y, $minZ);

            $p[2] = ($pb->getY() < $pa->getY()) ? $pb : $pa;
        }

        $p[3] = $this->calc3DPoint($rect->getRight(), $rect->y, $maxZ);

        $pc = $this->calc3DPoint($rect->getRight(), $rect->getBottom(), $maxZ);
        $pd = $this->calc3DPoint($rect->getRight(), $rect->y, $minZ);

        $p[4] = ($pd->getX() > $pc->getX()) ? $pd : $pc;

        $p[5] = $this->calc3DPoint($rect->getRight(), $rect->getBottom(), $minZ);
        if ($p[5]->getX() < $p[0]->getX()) {
            $p[0]->setX($p[5]->getX());
            if ($pd->getY() < $p[0]->getY()) {
                $p[0]->setY($pd->getY());
            }
        }

        $c1 = imagecolorallocate($this->img, $this->getBrush()->getColor()->red,
            $this->getBrush()->getColor()->green,
            $this->getBrush()->getColor()->blue);
            */
    }

    private function clipToLeft($rect, $minZ, $maxZ) {
    /*
        $c1 = imagecolorallocate($this->img, $this->getBrush()->getColor()->red,
            $this->getBrush()->getColor()->green,
            $this->getBrush()->getColor()->blue);

        clippolygon        imagepolygon($this->img,  array (
                    $this->calc3DPoint($rect->x, $rect->getBottom(), $minZ),
                    $this->calc3DPoint($rect->x, $rect->getBottom(), $maxZ),
                    $this->calc3DPoint($rect->x, $rect->y, $maxZ),
                    $this->calc3DPoint($rect->getRight(), $rect->y, $maxZ),
                    $this->calc3DPoint($rect->getRight(), $rect->y, $minZ),
                    $this->calc3DPoint($rect->getRight(), $rect->getBottom(), $minZ)),
                    3, $c1);*/
    }

    public function cuber ($rect, $z0, $z1, $darkSides) {
        $this->cube($rect->getLeft(), $rect->getTop(), $rect->getRight(), $rect->getBottom(), $z0, $z1, $darkSides);
    }

    /**
     * Draws a Cube with Dark Sides.
     *
     * @param left int
     * @param top int
     * @param right int
     * @param bottom int
     * @param z0 int
     * @param z1 int
     * @param darkSides boolean
     */
    public function cube($left, $top, $right, $bottom, $z0, $z1, $darkSides) {
/*
        $oldColor = $this->brush->getColor();
        $p0 = $this->calc3DPoint($left, $top, $z0);
        $p1 = $this->calc3DPoint($right, $top, $z0);
        $p2 = $this->calc3DPoint($right, $bottom, $z0);
        $p3 = $this->calc3DPoint($right, $top, $z1);
        $this->iPoints[0] = $p0;
        $this->iPoints[1] = $p1;
        $this->iPoints[2] = $p2;
        $this->iPoints[3] = $this->calc3DPoint($left, $bottom, $z0);

        if ($this->culling() > 0) {
            $this->polygonFour(); // front-side
        } else {
            $this->iPoints[0] = $this->calc3DPos($left, $top, $z1);
            $this->iPoints[1] = $this->calc3DPos($right, $top, $z1);
            $this->iPoints[2] = $this->calc3DPos($right, $bottom, $z1);
            $this->iPoints[3] = $this->calc3DPos($left, $bottom, $z1);
            $this->polygonFour(); // back-side
        }

        $this->iPoints[2] = $this->calc3DPos($right, $bottom, $z1);
        $this->iPoints[0] = $p1;
        $this->iPoints[1] = $p3;
        $this->iPoints[3] = $p2;

        if ($this->culling() > 0) {
            if ($darkSides) {
                $this->internalApplyDark($oldColor, self::$DARKERCOLORQUANTITY);
            }
            $this->polygonFour(); // left-side
        }

        $this->iPoints[0] = $p0;
        $this->iPoints[1] = $this->calc3DPos($left, $top, $z1);
        $this->iPoints[2] = $this->calc3DPos($left, $bottom, $z1);
        $this->iPoints[3] = $this->calc3DPos($left, $bottom, $z0);

        $tmp = ($this->iPoints[3]->getX() - $this->iPoints[0]->getX()) *
                     ($this->iPoints[1]->getY() - $this->iPoints[0]->getY()) -
                     ($this->iPoints[1]->getX() - $this->iPoints[0]->getX()) *
                     ($this->iPoints[3]->getY() - $this->iPoints[0]->getY());

        if ($tmp > 0) {
            if ($darkSides) {
                $this->internalApplyDark($oldColor, self::$DARKERCOLORQUANTITY);
            }
            $this->polygonFour(); // right-side
        }

        $this->iPoints[3] = $this->calc3DPos($left, $top, $z1);

        // culling
        $tmp = ($p0->getX() - $p1->getX()) * ($p3->getY() - $p1->getY()) -
            ($p3->getX() - $p1->getX()) * ($p0->getY() - $p1->getY());
        if ($tmp > 0) {
            $this->iPoints[0] = $p0;
            $this->iPoints[1] = $p1;
            $this->iPoints[2] = $p3;
            if ($darkSides) {
                $this->internalApplyDark($oldColor, self::$DARKCOLORQUANTITY);
            }
            $this->polygonFour(); // top-side
        }

        $this->iPoints[0] = $this->calc3DPos($left, $bottom, $z0);
        $this->iPoints[2] = $this->calc3DPos($right, $bottom, $z1);
        $this->iPoints[1] = $this->calc3DPos($left, $bottom, $z1);

        $this->iPoints[3] = $p2;
        if ($this->culling() < 0) {
            if ($darkSides) {
                $this->internalApplyDark($oldColor, self::$DARKCOLORQUANTITY);
            }
            $this->polygonFour();
        }

        $this->brush->setColor($oldColor);
        */
    }

    /**
     * Creates a cubic Windows GDI clipping region.
     *
     * @param rect Rectangle
     * @param minZ int
     * @param maxZ int
     */
    public function clipCube($rect, $minZ, $maxZ) {
    /*
        if ($this->is3D) {
            if ($this->aspect->getElevation() == 270) {
                if (($this->aspect->getRotation() == 270) ||
                    ($this->aspect->getRotation() == 360)) {
                    $tmpLT = $this->calc3DPoint($rect->x, $rect->y, $minZ);
                    $tmpRB = $this->calc3DPoint($rect->getRight(), $rect->y, $maxZ);
                    $this->clipRectangle($tmpLT->x, $tmpLT->y, $tmpRB->x, $tmpRB->y);
                    return;
                }
            }

            if ($this->isOrtho) {
                if ($this->aspect->getOrthoAngle() > 90) {
                    $this->clipToLeft($rect, $minZ, $maxZ);
                } else {
                    $this->clipToRight($rect, $minZ, $maxZ);
                }
            } else
            if ($this->aspect->getRotation() >= 270) {
                $this->clipToRight($rect, $minZ, $maxZ);
            }
        } else {
            $this->clipRectangle($rect->x + 1, $rect->y + 1, $rect->getRight() - 1,
                          $rect->getBottom() - 1);
        }
        */
    }

    private function culling() {
        return (($this->iPoints[3]->getX() - $this->iPoints[2]->getX()) * ($this->iPoints[1]->getY() -
            $this->iPoints[2]->getY())) - (($this->iPoints[1]->getX() - $this->iPoints[2]->getX()) *
            ($this->iPoints[3]->getY() - $this->iPoints[2]->getY()));
    }

    /**
    * Creates and initialize the image
    * @access       protected
    */
    function createImage()
    {
       Ming_setScale(20.0000000);
       ming_useswfversion(6);
       $m = new SWFMovie();
       $m->setRate(31);
       
       $m->setDimension($this->width,$this->height); 
       $m->setBackground(220,220,220);
 
       //$i->setDepth(3);       
       
       $this->shape = new SWFShape(); 
       $sqfill = $this->shape->addFill(0, 0, 0xff);
       //$this->shape->setRightFill($sqfill);       
       $m->add($this->shape);
       
       $this->img = $m;
       
/*    
$square = new SWFShape();
 
$sqfill = $square->addFill(0, 0, 0xff);
$square->setRightFill($sqfill);
 
$square->movePenTo(-250,-250);
$square->drawLineTo(250,-250);
$square->drawLineTo(250,250);
$square->drawLineTo(-250,250);
$square->drawLineTo(-250,-250);

//Now we can use that shape in a movie clip and define some actions:
$sqclip = new SWFSprite();
$i = $sqclip->add($square);
$i->setDepth(1);
$sqclip->setframes(25);
$sqclip->add(new SWFAction("stop();"));
 
$sqclip->nextFrame();
$sqclip->add(new SWFAction("play();"));
 
for($n=0; $n<24; $n++) {
$i->rotate(-15);
      $sqclip->nextFrame();
}

//Next we'll create another shape and use it for a button. Rather than create a separate shape for each button action (over, down, up, and release), I've created a function to automate drawing the shapes:
function rect($r, $g, $b)  {
$s = new SWFShape();
$s->setRightFill($s->addFill($r, $g, $b));
$s->drawLine(500,0);
$s->drawLine(0,500);
$s->drawLine(-500,0);
$s->drawLine(0,-500);
return $s;
}
 
$b = new SWFButton();
$b->addShape(rect(0xff, 0, 0), SWFBUTTON_UP | SWFBUTTON_HIT);
$b->addShape(rect(0, 0xff, 0), SWFBUTTON_OVER);
$b->addShape(rect(0, 0, 0xff), SWFBUTTON_DOWN);
 
$b->addAction(new SWFAction("setTarget('/box'); gotoandplay(2);"), SWFBUTTON_MOUSEDOWN);

//Next, we define the movie and place the movie clip (sprite) and the button in the movie itself:
$m = new SWFMovie();
$m->setDimension(4000,3000);
 
$m->setBackground(255,0,0);
 
$i = $m->add($sqclip);
$i->setDepth(3);
$i->moveTo(1650, 400);
$i->setName("box");
 
$i = $m->add($b);
$i->setDepth(2);
$i->moveTo(1400,900);
    
$this->img = $m;

*/  
        return $this->img;
    }

    private function doBevelRect($rect, $a, $b) {
        /*        
        $topRight = new TeePoint($rect->getRight() - 1, $rect->y);
        $bottomLeft = new TeePoint($rect->x, $rect->getBottom() - 1);
        $bottomRight = new TeePoint($rect->getRight() - 1, $rect->getBottom() - 1);

        $this->___line($a, $rect->getLocation(), $topRight);
        $this->___line($a, $rect->getLocation(), $bottomLeft);
        $this->___line($b, $bottomLeft, $bottomRight);
        $this->___line($b, $bottomRight, $topRight);
        */
    }

    public function doRev() {
        $black = imagecolorallocate($this->img, 150, 150, 150);
        $x = imagesx($this->img);
        $y = imagesy($this->img)-6;

        $text = "EVALUATION VERSION";
        $font_file = ChartFont::$DEFAULTFAMILY;
        imagefttext($this->img, 25, 45, 25, $y+3, $black, $font_file, $text);
    }

    /**
     * Draws an Ellipse bounding Rectangle r.
     *
     * @param r Rectangle
     */
    public function ellipseRect($r) {
        $this->ellipse($r->getX(), $r->getY(), $r->getRight(), $r->getBottom());
    }

    /**
     * Ellipse bounding Rectangle r at z depth.
     *
     * @param r Rectangle
     * @param z int
     */
    public function ellipseRectZ($r, $z) {
        $this->ellipse($r->getX(), $r->getY(), $r->getRight(), $r->getBottom(), $z);
    }

    // DrawZone
    public function transparentEllipseZ($x1, $y1, $x2, $y2, $z) {
        $p1 = $this->calc3DPos($x1, $y1, $z);
        $p2 = $this->calc3DPos($x2, $y2, $z);
        $this->transparentEllipsePoints($p1, $p2);
    }

    protected function transparentEllipsePoints($p0, $p1) {
        $this->transparentEllipse($p0->getX(), $p0->getY(), $p1->getX(), $p1->getY());
    }

    /**
     * Ellipse bounding Rect (X1,Y1,X2,Y2) at Z position at angle.
     *
     * @param x1 int
     * @param y1 int
     * @param x2 int
     * @param y2 int
     * @param z int
     * @param angle double

     */
    public function ellipse($x1, $y1, $x2, $y2, $z=0, $angle=0) {
/*      if($z>0) {
        $p1 = $this->calc3DPos($x1, $y1, $z);
        $p2 = $this->calc3DPos($x2, $y2, $z);
        $this->ellipsePoints($p1,$p2);
       //  todo here draw directly the ellipse with p1 and p2 $this->ellipsePoints($p1, $p2);
      }
      else
      {
        if ($angle>0) {
        //  todo remove Point[] p = new Point[NUMCIRCLEPOINTS]; //       : Array[0..NumCirclePoints-1] of TPoint;
        $p = Array();

        $points = Array();
        for ($t = 0; $t < 3; $t++) {
            $points[$t] = new TeePoint();
        }

        $xCenter = ($x2 + $x1) * 0.5;
        $yCenter = ($y2 + $y1) * 0.5;
        $xRadius = ($x2 - $x1) * 0.5;
        $yRadius = ($y2 - $y1) * 0.5;

        $angle *= M_PI / 180.0;

        $tmpPiStep = 2 * M_PI / (self::$NUMCIRCLEPOINTS - 1);

        // initial rotation (rotation matrix elements)
        $tmpSinAngle = sin($angle);
        $tmpCosAngle = cos($angle);

        for ($t = 0; $t < self::$NUMCIRCLEPOINTS; $t++) {
            $tmpSin = sin($t * $tmpPiStep);
            $tmpCos = cos($t * $tmpPiStep);
            $tmpX = $xRadius * $tmpSin;
            $tmpY = $yRadius * $tmpCos;

            $p[$t] = new TeePoint(
                    MathUtils::round($xCenter +
                                          ($tmpX * $tmpCosAngle +
                                           $tmpY * $tmpSinAngle)),
                    MathUtils::round($yCenter +
                                          ( -$tmpX * $tmpSinAngle +
                                           $tmpY * $tmpCosAngle))
                   );
        }

        if ($this->getBrush()->getVisible()) {
            $old = $this->getPen()->getVisible();
            $this->getPen()->setVisible(false);

            $xc = MathUtils::round($xCenter);
            $yc = MathUtils::round($yCenter);

            for ($t = 1; $t < self::$NUMCIRCLEPOINTS; $t++) {
                // has to be in loop because the Polygon
                // transforms the positions from 3d to 2d in each pass
                $points[0]->setX($xc);
                $points[0]->setY($yc);
                $points[1] = $p[$t - 1];
                $points[2] = $p[$t];
                $this->polygonz($z, $points);
            }
            // close it up with polygon from last to first
            $points[0]->setX($xc);
            $points[0]->setY($yc);
            $points[1] = $p[self::$NUMCIRCLEPOINTS - 1];
            $points[2] = $p[0];
            $this->polygonz($z, $points);

            $this->getPen()->setVisible($old);
        }
        if ($this->getPen()->getVisible()) {
            $this->polyLine($z, $p);
        }
        }
        else
        {
          $color = imagecolorallocate($this->img, $this->getBrush()->getColor()->red,
                                                  $this->getBrush()->getColor()->green,
                                                  $this->getBrush()->getColor()->blue);

          // updates x,y,width,height to be used in imagefilledellipse correctly
          $x1=$x1+(($x2-$x1) / 2);
          $y1=$y1+(($y2-$y1) / 2);
          $tmpWidth=($x2-$x1)*2;
          $tmpHeight=($y2-$y1)*2;

          if ($this->brush->getVisible()) {
            imagefilledellipse($this->img,$x1,$y1,$tmpWidth,$tmpHeight,$color);
          }

         if ($this->getPen()->getVisible()) {
            // Gets the pen color and style (dot , dashed, ...)
            $penColorStyle = $this->getPenColorStyle();
            imagesetstyle($this->img, $penColorStyle);

            // Assign the pen width for the image
            imagesetthickness ( $this->img, $this->pen->getWidth());
                        
            for ($i=0;$i<=$this->pen->getWidth();$i++)
              imageellipse($this->img,$x1,$y1,$tmpWidth+$i,$tmpHeight+$i,IMG_COLOR_STYLED);
          }
        }
      }
      */
    }

    public function ellipsePoints($p0, $p1) {
        $this->ellipse($p0->getX(), $p0->getY(), $p1->getX(), $p1->getY());
    }

    /**
     * Ellipse bounding rectangle r with Z offset at angle.
     *
     * @param r Rectangle
     * @param z int
     * @param angle double
     */
    public function ellipseRectZAngle($r, $z, $angle=0) {
        $this->ellipse($r->getX(), $r->getY(), $r->getWidth(),
            $r->getHeight(), $z, $angle); // $r->getRight(), $r->getBottom(), $z, $angle);
    }

    /**
     * Determines the Font Height to be used for outputted text when using the
     * Drawing.
     *
     * @param f ChartFont
     * @return int
     */
    public function fontTextHeight($f) {
        return $this->_textHeight($f, "W");
    }

    public function initWindow($a, $r, $maxDepth) {
        $this->bounds = new Rectangle($r->x,$r->y,$r->width,$r->height);
        $this->setAspect($a);
        $this->iZoomFactor = 1;

        if ($this->is3D) {
            if ($this->isOrtho) {
                $tmpAngle = $this->aspect->getOrthoAngle();
                if ($tmpAngle > 90) {
                    $this->iOrthoX = -1;
                    $tmpAngle = 180 - $tmpAngle;
                } else {
                    $this->iOrthoX = 1;
                }

                $tmpSin = sin($this->aspect->getOrthoAngle() *
                                         MathUtils::getPiStep());
                $tmpCos = cos($this->aspect->getOrthoAngle() *
                                         MathUtils::getPiStep());
                $this->iOrthoY = ($tmpCos < 0.01) ? 1 : $tmpSin / $tmpCos;
            }
            $this->iZoomFactor = 0.01 * $this->aspect->getZoom();
            $this->iZoomText = $this->aspect->getZoomText();
        }

        $this->calcTrigValues();
    }

    public function internalApplyDark($c, $quantity) {
        $this->brush->_applyDark($c, $quantity);
    }

    /**
    * Draws a straight line
    *
    * @access       public
    * @param        integer         line start (X)
    * @param        integer         line start (Y)
    * @param        integer         line end (X)
    * @param        integer         line end (Y)
    * @param        Color           line color
    * @param        integer         line width
    */

    function line($x1, $y1, $x2, $y2, $color=null, $width = -1)
    {
        /*if ($color==null)
        {
          $color = imagecolorallocate($this->img, $this->pen->getColor()->red,
          $this->pen->getColor()->green,
          $this->pen->getColor()->blue);
        }
        */
/*
        imageantialias($this->img,false);          
        // Gets the pen color and style (dot , dashed, ...)
        $penColorStyle = $this->getPenColorStyle();
        imagesetstyle($this->img, $penColorStyle);
      
        // Assign the pen width for the image
        // Set thickness. 
        if ($width==-1) {
          $width = $this->pen->getWidth();
//          if ($width < 2)
//            imageantialias($this->img,true);

          imagesetthickness ($this->img, $width);
        }
        else
        {
//          if ($width < 2)
//            imageantialias($this->img,true);

          imagesetthickness ($this->img, $width);
        }
               
        imageline($this->img, $x1, $y1, $x2, $y2, IMG_COLOR_STYLED);
  //      if ($width < 2)
//          imageantialias($this->img,false);

        imageantialias($this->img,true);
        */
        

        $this->shape->setLine($this->getPen()->getWidth(),
                    $this->pen->getColor()->red,
                    $this->pen->getColor()->green,
                    $this->pen->getColor()->blue);

        //$this->shape->setRightFill($this->shape->addFill(0xff, 0, 0));
                    
        $this->shape->movePenTo($x1,$y1);
        $this->shape->drawLineTo($x2,$y2);
        
    }

    /**
    * Draws a Line between co-ordinates with z depth offset.
    *
    * @param x0 int
    * @param y0 int
    * @param x1 int
    * @param y1 int
    * @param z int
    */
    public function _line($x0, $y0, $x1, $y1, $z=0) {
        $this->__line($this->calc3DPos($x0, $y0, $z), $this->calc3DPos($x1, $y1, $z));
    }

    /**
    * Draws a Line between point p0 and point p1.
    *
    * @param p0 Point is origin xy
    * @param p1 Point is destination xy
    */
    public function __line($p0, $p1) {
        $this->line($p0->getX(), $p0->getY(), $p1->getX(), $p1->getY());
        // Move the mouse point
        $this->moveToXY($p1->getX(),$p1->getY());     // review
    }

    /**
    * Draws a Line between point p0 and point p1 using specific pen.
    *
    * @param pen ChartPen id the pen used
    * @param p0 Point is origin xy
    * @param p1 Point is destination xy
    */
    public function ___line($pen, $p0, $p1) {

        $oldPen = $this->getPen();
        $this->setPen($pen);

        // Gets the pen color and style (dot , dashed, ...)
        $penColorStyle = $this->getPenColorStyle();
        // imagesetstyle($this->img, $penColorStyle);

        // Assign the pen width for the image
        // imagesetthickness ( $this->img, $this->pen->getWidth());
        
        $this->shape->setLine($this->getPen()->getWidth(),
                    $this->pen->getColor()->red,
                    $this->pen->getColor()->green,
                    $this->pen->getColor()->blue);

        //$this->shape->setRightFill($this->shape->addFill(0xff, 0, 0));
                    
        $this->shape->movePenTo($p0->getX(),$p0->getY());
        $this->shape->drawLineTo($p1->getX(),$p1->getY());
                
        $this->setPen($oldPen);
    }

    /**
     * Draws a line to Point with z depth offset.
     *
     * @param p Point
     * @param z int
     */
    public function lineTo($p, $z) {
        $this->___lineTo($p->getX(), $p->getY(), $z);
    }

    /**
     * Draws a line to Point with z = 0 depth offset.
     *
     * @param p Point
     */
    public function __lineTo($p) {
        $this->line($this->moveToX, $this->moveToY ,$p->getX(), $p->getY());

        // Move the mouse point
        $this->moveToXY($p->getX(),$p->getY());
    }

    /**
     * Draws line from present position to end co-ordinates with z depth offset.
     *
     * @param x int
     * @param y int
     * @param z int
     */
    public function ___lineTo($x, $y, $z=0) {
        $this->__lineTo($this->calc3DPos($x, $y, $z));
    }

    /**
     * Draws a Line to 3D Point.
     *
     * @param p Point3D
     */
    public function ____lineTo($p) {
        $this->__lineTo($this->calc3DPos($p->getX(), $p->getY(), $p->getZ()));
    }

    /**
     * Draws line from present position to end co-ordinates with z depth offset.
     *
     * @param x int
     * @param y int
     */
    public function _____lineTo($x, $y) {
        $this->line($this->moveToX, $this->moveToY ,$x, $y);
        // Move the mouse point
        $this->moveToXY($x,$y);   // review
    }

    /**
     * Sets the value of PenPos to x and y co-ordinates  before calling LineTo.
     *
     * @param x int
     * @param y int
     */
    public function moveToXY($x, $y) {
        $this->moveToX=$x;
        $this->moveToY=$y;
    }

    /**
     * Sets the value of PenPos to Point p before calling LineTo.
     *
     * @param p Point
     */
    public function moveTo($p) {
        $this->moveToXY($p->getX(), $p->getY());
    }

    /**
     * Sets the value of PenPos to x, y and z co-ordinates before calling
     * LineTo.
     *
     * @param x int
     * @param y int
     * @param z int
     */
    public function moveToXYZ($x, $y, $z) {
        $p = $this->calc3DPos($x, $y, $z);
        $this->moveTo($p);
    }

    /**
     * Sets the value of PenPos to Point p  with z depth offset before calling
     * LineTo.
     *
     * @param p Point
     * @param z int
     */
    public function moveToZ($p, $z) {
        $p2 = $this->calc3DPos($p->getX(), $p->getY(), $z);
        $this->moveTo($p2);
    }

    /**
     * Sets the value of PenPos  to 3D Point p before calling LineTo.
     *
     * @param p Point3D
     */
    public function moveTo3D($p) {
        $this->moveTo($this->calc3DPos($p->getX(),$p->getY(), 0));
    }

    /**
    * Draws a Line from (X,Y,Z0) to (X,Y,Z1).
    *
    * @param x int
    * @param y int
    * @param z0 int
    * @param z1 int
    */
    public function zLine($x, $y, $z0, $z1) {
        /*
        $c1 = imagecolorallocatealpha($this->img, $this->pen->getColor()->red,
            $this->pen->getColor()->green,
            $this->pen->getColor()->blue,
            $this->pen->getColor()->alpha);
        */
        $p1=$this->calc3DPos($x, $y, $z0);
        $p2=$this->calc3DPos($x, $y, $z1);

        /*
        imagesetthickness ( $this->img, $this->pen->getWidth());
        */
        
        $this->shape->setLine($this->getPen()->getWidth(),
                    $this->pen->getColor()->red,
                    $this->pen->getColor()->green,
                    $this->pen->getColor()->blue);

        //$this->shape->setRightFill($this->shape->addFill(0xff, 0, 0));                    
        
        $this->shape->movePenTo($p1->getX(),$p1->getY());
        $this->shape->drawLineTo($p2->getX(),$p2->getY());
        
    }

    /**
     * Draws a Horizontal at z depth position.
     *
     * @param left int
     * @param right int
     * @param y int
     * @param z int
     */
    public function horizontalLine($left, $right, $y, $z=0) {
        
        $p1=$this->calc3DPos($left, $y, $z);
        $p2=$this->calc3DPos($right, $y, $z);
                
        $this->shape->setLine($this->getPen()->getWidth(),
                    $this->pen->getColor()->red,
                    $this->pen->getColor()->green,
                    $this->pen->getColor()->blue);
       
        //$this->shape->setRightFill($this->shape->addFill(0xff, 0, 0));       
        
        $this->shape->movePenTo($p1->getX(),$p1->getY());
        $this->shape->drawLineTo($p2->getX(),$p2->getY());                          
    }

    /**
     * Draws a Vertical Line from (X,Top) to (X,Bottom) at z depth position.
     *
     * @param x int
     * @param top int
     * @param bottom int
     * @param z int
     */
    public function verticalLine($x, $top, $bottom, $z=0) {        
        
        $p1=$this->calc3DPos($x, $top, $z);
        $p2=$this->calc3DPos($x, $bottom, $z);

        $this->shape->setLine($this->getPen()->getWidth(),
                    $this->pen->getColor()->red,
                    $this->pen->getColor()->green,
                    $this->pen->getColor()->blue);
       
        //$this->shape->setRightFill($this->shape->addFill(0xff, 0, 0));       
        
        $this->shape->movePenTo($p1->getX(),$p1->getY());
        $this->shape->drawLineTo($p2->getX(),$p2->getY());
    }

    /**
    * Draw a filled gray box with thick borders and darker corners.
    *
    * @param integer top left coordinate (x)
    * @param integer top left coordinate (y)
    * @param integer bottom right coordinate (x)
    * @param integer bottom right coordinate (y)
    * @param Color edge color
    * @param Color corner color
    */
    public function outlinedBox($x1, $y1, $x2, $y2, $color0, $color1) {
/*        if ($this->brush->getVisible()) {
            
            if ($this->getBrush()->getGradient()->getVisible()==true) {
            
                 $colA = array($this->getBrush()->getGradient()->getStartColor()->getRed(),
                   $this->getBrush()->getGradient()->getStartColor()->getGreen(),
                   $this->getBrush()->getGradient()->getStartColor()->getBlue());   
                 $colB = array($this->getBrush()->getGradient()->getEndColor()->getRed(),
                   $this->getBrush()->getGradient()->getEndColor()->getGreen(),
                   $this->getBrush()->getGradient()->getEndColor()->getBlue());
                       
                 $penWidth=$this->getPen()->getWidth();
                 Gradient::imagecolorgradient(
                   $this->img,
                   $x1+$penWidth, $y1+$penWidth, 
                   $x2-$penWidth, $y2,
                    $colA,$colB
                 );            
            }   
            else
            {                                         
              imagefilledrectangle($this->img, $x1, $y1, $x2, $y2, $color0->getColor($this->img));
            }
            imagerectangle($this->img, $x1, $y1, $x1 + 1, $y1 + 1, $color1->getColor($this->img));
            imagerectangle($this->img, $x2 - 1, $y1, $x2, $y1 + 1, $color1->getColor($this->img));
            imagerectangle($this->img, $x1, $y2 - 1, $x1 + 1, $y2, $color1->getColor($this->img));
            imagerectangle($this->img, $x2 - 1, $y2 - 1, $x2, $y2, $color1->getColor($this->img));            
        }
        */
    }

    public function paintBevel($bevel, $rect, $width, $one, $two) {
        if ($bevel == BevelStyle::$RAISED) {
            $a = new ChartPen(null,$one);
            $b = new ChartPen(null,$two);
        } else {
            $a = new ChartPen(null,$two);
            $b = new ChartPen(null,$one);
        }

        $tmp = $width;
        while ($tmp > 0) {
            $tmp--;

            $this->doBevelRect($rect, $a, $b);
            $rect->grow( -1, -1);
        }
    }

    /**
    * Draws a 3D Pie slice using start Angle and end Angle and donut percent.
    *
    * @param xCenter int
    * @param yCenter int
    * @param xRadius int
    * @param yRadius int
    * @param z0 int
    * @param z1 int
    * @param startAngle double
    * @param endAngle double
    * @param darkSides boolean
    * @param drawSides boolean
    * @param donutPercent int
    */
/*    public function pie($xCenter, $yCenter, $xRadius, $yRadius, $z0,
        $z1, $startAngle, $endAngle, $darkSides, $drawSides, $donutPercent=0) {

        if ($this->pie3D == null) {
            $this->pie3D = new Pie3D($this);
        }
        $this->pie3D->pie($xCenter, $yCenter, $xRadius, $yRadius, $z0, $z1, $startAngle,
                  $endAngle, $darkSides, $drawSides, $donutPercent);
    }
*/

    public function pie($xCenter, $yCenter, $xOffset, $yOffset, $xRadius,
                    $yRadius, $z0, $z1, $startAngle, $endAngle,
                    $darkSides, $drawSides, $donutPercent,
                    $bevelPercent, $edgeStyle, $last/*, Shadow shadow*/)
    {
      if ($this->pie3D == null) {
            $this->pie3D = new Pie3D($this);
        }
      $this->pie3D->pie( $xCenter + $xOffset, $yCenter - $yOffset, $xRadius,  $yRadius,  $z0,  $z1,
                 $startAngle,  $endAngle,  $darkSides,  $drawSides,
                 $donutPercent,  $bevelPercent, $edgeStyle, $last);
    }


    /**
     * Draws a vertical or horizontal Pyramid with optional dark shaded sides.
     *
     * @param vertical boolean
     * @param r Rectangle
     * @param z0 int
     * @param z1 int
     * @param darkSides boolean
     */
    public function pyramidRect($vertical, $r, $z0, $z1, $darkSides) {
        $this->pyramid($vertical, $r->x, $r->y, $r->getRight(), $r->getBottom(), $z0, $z1,
                $darkSides);
    }

    /**
     * Draws a vertical or horizontal Pyramid with optional dark shaded sides.
     *
     * @param vertical boolean
     * @param left int
     * @param top int
     * @param right int
     * @param bottom int
     * @param z0 int
     * @param z1 int
     * @param darkSides boolean
     */
    public function pyramid($vertical, $left, $top, $right, $bottom, $z0, $z1, $darkSides) {
/*
        $oldColor = $this->brush->getSolid() ? $this->brush->getColor() : $this->getBackColor();

        if ($vertical) {
            if ($top != $bottom) {
                $p0 = $this->calc3DPoint($left, $bottom, $z0);
                $p1 = $this->calc3DPoint($right, $bottom, $z0);
                $pTop = $this->calc3DPoint(($left + $right) / 2, $top, ($z0 + $z1) / 2);
                $tmpArray = Array($p0, $pTop, $p1);
                $this->polygon($tmpArray);
                $p2 = $this->calc3DPoint($left, $bottom, $z1);

                if ($top < $bottom) {
                    if ($p2->y < $pTop->y) {
                        $tmpArray = Array($p0, $pTop, $p2);
                        $this->polygon($tmpArray);                        
                    }
                }
                if ($darkSides) {
                    $this->internalApplyDark($oldColor, self::$DARKERCOLORQUANTITY);
                }

                $p3 = $this->calc3DPoint($right, $bottom, $z1);
                $tmpArray = Array($p1, $pTop, $p3);
                $this->polygon($tmpArray);                        

                if (($top < $bottom) && ($p2->y < $pTop->y)) {
                    $tmpArray = Array($pTop, $p2, $p3);
                    $this->polygon($tmpArray);                        
                }
            }
            if ($top >= $bottom) {
                if ($darkSides) {
                    $this->internalApplyDark($oldColor, self::$DARKCOLORQUANTITY);
                }
                $this->rectangleY($left, $bottom, $right, $z0, $z1);
            }
        } else {
            if ($left != $right) {
                $p0 = $this->calc3DPoint($left, $top, $z0);
                $p1 = $this->calc3DPoint($left, $bottom, $z0);
                $pTop = $this->calc3DPoint($right, ($top + $bottom) / 2, ($z0 + $z1) / 2);
                $tmpArray = Array($p0, $pTop, $p1);
                $this->polygon($tmpArray);                        

                if ($darkSides) {
                    $this->internalApplyDark($oldColor, self::$DARKCOLORQUANTITY);
                }
                $p2 = $this->calc3DPoint($left, $top, $z1);
                $tmpArray = Array($p0, $pTop, $p2);
                $this->polygon($tmpArray);                        
            }
            if ($left >= $right) {
                if ($darkSides) {
                    $this->internalApplyDark($oldColor, self::$DARKERCOLORQUANTITY);
                }
                $this->rectangleZ($left, $top, $bottom, $z0, $z1);
            }
        }
        */
    }

    /**
     * Sets / returns the color used to fill spaces when displaying text
     * or filling with brushes of different style other than bsSolid.<br>
     * Brush.Visible must be set to true.
     *
     * @return Color
     */
    public function getBackColor() {
        return $this->brush->getColor();
    }

    public function setBackColor($value) {
        $this->brush->setColor($value);
    }
    
    /**
    * Draws a pyramid with a truncated apex of variable thickness.
    *
    * @param Rectangle $r
    * @param int $startZ
    * @param int $endZ
    * @param int $truncX
    * @param int $truncZ
    */

    public function pyramidTrunc($r, $startZ, $endZ, $truncX, $truncZ) {
        $p = new InternalPyramidTrunc();
        $p->r = $r;
        $p->startZ = $startZ;
        $p->endZ = $endZ;
        $p->truncX = $truncX;
        $p->truncZ = $truncZ;
        $p->draw($this);
    }

    /**
    * Draws a polygon (Point p1, Point p2) at Z depth offset.
    *
    * @param p1 Point
    * @param p2 Point
    * @param z0 int
    * @param z1 int
    */
    public function plane($p1, $p2, $z0, $z1) {
        $this->iPoints[0] = $this->calc3DPos($p1->getX(), $p1->getY(), $z0);
        $this->iPoints[1] = $this->calc3DPos($p2->getX(), $p2->getY(), $z0);
        $this->iPoints[2] = $this->calc3DPos($p2->getX(), $p2->getY(), $z1);
        $this->iPoints[3] = $this->calc3DPos($p1->getX(), $p1->getY(), $z1);
        $this->polygonFour();
    }

    /**
    * Draws a polygon (Point p1, Point p2, Point p3, Point p4) at Z depth
    * offset.
    *
    * @param p1 Point
    * @param p2 Point
    * @param p3 Point
    * @param p4 Point
    * @param z int
    */
    public function _plane($p1, $p2, $p3, $p4, $z) {
        $this->iPoints[0] = $this->calc3DPos($p1->getX(), $p1->getY(), $z);
        $this->iPoints[1] = $this->calc3DPos($p2->getX(), $p2->getY(), $z);
        $this->iPoints[2] = $this->calc3DPos($p3->getX(), $p3->getY(), $z);
        $this->iPoints[3] = $this->calc3DPos($p4->getX(), $p4->getY(), $z);
        $this->polygonFour();
    }

    /**
    * Draws a polygon of  four points.
    *
    * @param z0 int
    * @param z1 int
    * @param p Point[]
    */
    public function planeFour3D($z0, $z1, $p) {
        $this->iPoints[0] = $this->calc3DPoint($p[0]->x, $p[0]->y, $z0);
        $this->iPoints[1] = $this->calc3DPoint($p[1]->x, $p[1]->y, $z0);
        $this->iPoints[2] = $this->calc3DPoint($p[2]->x, $p[2]->y, $z1);
        $this->iPoints[3] = $this->calc3DPoint($p[3]->x, $p[3]->y, $z1);
        $this->polygonFour();
    }
       
    public function polygon($points) {
        if ($this->brush->getVisible()) {
                       
           $rfill=0;
           $gfill=0;
           $bfill=0;
           $afill=255;
 
           $routline=0;
           $goutline=0;
           $boutline=0;
           $width=0;
           $aoutline=255;
 
           $shape = new SWFShape(); 
           $sqfill = $shape->addFill(0, 0, 0xff);
           //$shape->setRightFill($sqfill);       
           $shape->movePenTo($points[0]->x,$points[0]->y);
       
           for($ipt=0;$ipt<sizeof($points);$ipt++)
              $shape->drawLineTo($points[$ipt]->x, $points[$ipt]->y);
         
           $shape->drawLineTo($points[0]->x, $points[0]->y);

           $this->img->add($shape);
        }
                       
/*                        
            $c1 = imagecolorallocatealpha($this->img, $this->getBrush()->getColor()->red,
              $this->getBrush()->getColor()->green,
              $this->getBrush()->getColor()->blue,
              $this->getBrush()->getTransparency());

             
            $p1 = imagecolorallocatealpha($this->img, $this->getPen()->getColor()->red,
              $this->getPen()->getColor()->green,
              $this->getPen()->getColor()->blue,
              $this->getPen()->getTransparency());
             
            $tmpArray2= Array();

            for ($tt=0;$tt < sizeof($points); $tt++) {
                 $tmpTeePointDouble =$points[$tt];
                 $tmpX=$tmpTeePointDouble->getX();
                 $tmpY=$tmpTeePointDouble->getY();
                 $tmpArray2[]=$tmpX;
                 $tmpArray2[]=$tmpY;
            }
                
            if (count($tmpArray2) >= 3) {
                imageantialias($this->img,true);
                imagefilledpolygon($this->img, $tmpArray2, count($tmpArray2)/2, $c1);
                imageantialias($this->img,false);
            }
            
            if ($this->getPen()->getVisible()) {
                // Gets the pen color and style (dot , dashed, ...)
                $penColorStyle = $this->getPenColorStyle();
                imagesetstyle($this->img, $penColorStyle);

                // Assign the pen width for the image
                imagesetthickness ( $this->img, $this->pen->getWidth());

                if (count($tmpArray2) >= 3) {
                   imageantialias($this->img,true);
                   imagepolygon($this->img, $tmpArray2, count($tmpArray2)/2, $p1);                   
                  imageantialias($this->img,false);
                }
            }            
        }
        */
    }

    /**
     * Draws a polygon with z position offset.
     *
     * @param z int
     * @param p Point[]
     */
    public function polygonZ($z, $p) {
        for ($t = 0; $t < sizeof($p); $t++) {
            $p[$t] = $this->calc3DPoint($p[$t]->getX(),$p[$t]->getY(), $z);
        }
        $this->polygon($p);
    }

    public function polygonPoints($p0, $p1, $p2) {
        $p = Array($p0, $p1, $p2);
        $this->polygon($p);
    }


    public function polygonFourDouble()
    {
        /*
        if ($this->brush->getVisible()) {
          $c1 = imagecolorallocatealpha($this->img, $this->getBrush()->getColor()->red,
              $this->getBrush()->getColor()->green,
              $this->getBrush()->getColor()->blue,
              $this->getBrush()->getTransparency());

            $p1 = imagecolorallocatealpha($this->img, $this->getPen()->getColor()->red,
              $this->getPen()->getColor()->green,
              $this->getPen()->getColor()->blue,
              $this->getPen()->getTransparency());

            $tmpArray2= Array();

            for ($tt=0;$tt < count($this->iPointDoubles); $tt++) {
               $tmpTeePoint =$this->iPointDoubles[$tt];
                 $tmpX=$tmpTeePoint->getX();
                 $tmpY=$tmpTeePoint->getY();
                 $tmpArray2[]=$tmpX;
                 $tmpArray2[]=$tmpY;
            }

            if (count($tmpArray2) >= 3) {
                imageantialias($this->img,true);
                imagefilledpolygon($this->img, $tmpArray2, count($tmpArray2)/2, $c1);
                imageantialias($this->img,false);
            }
        }

        if ($this->getPen()->getVisible()) {
          // Gets the pen color and style (dot , dashed, ...)
          $penColorStyle = $this->getPenColorStyle();
          imagesetstyle($this->img, $penColorStyle);

          // Assign the pen width for the image
          imagesetthickness ( $this->img, $this->pen->getWidth());

            if (count($tmpArray2) >= 3) {
                imageantialias($this->img,true);
                imagepolygon($this->img, $tmpArray2, count($tmpArray2)/2, $p1);
                imageantialias($this->img,false);
            }
        }
        */
    }

    private function polygonFour() {
        /*
        $tmpArray2= Array();
        if ($this->brush->getVisible()) {

          $c1 = imagecolorallocatealpha($this->img, $this->getBrush()->getColor()->red,
              $this->getBrush()->getColor()->green,
              $this->getBrush()->getColor()->blue,
              $this->getBrush()->getTransparency());

            $p1 = imagecolorallocatealpha($this->img, $this->getPen()->getColor()->red,
              $this->getPen()->getColor()->green,
              $this->getPen()->getColor()->blue,
              $this->getPen()->getTransparency());              


            for ($tt=0;$tt < count($this->iPoints); $tt++) {
                 $tmpTeePoint =$this->iPoints[$tt];
                 $tmpX=$tmpTeePoint->getX();
                 $tmpY=$tmpTeePoint->getY();
                 $tmpArray2[]=$tmpX;
                 $tmpArray2[]=$tmpY;
            }

            if (count($tmpArray2) >= 3) {
                imageantialias($this->img,true);
                imagefilledpolygon($this->img, $tmpArray2, count($tmpArray2)/2, $c1);
                imageantialias($this->img,false);
            }
        }

        if ($this->getPen()->getVisible()) {
          // Gets the pen color and style (dot , dashed, ...)
          $penColorStyle = $this->getPenColorStyle();
          imagesetstyle($this->img, $penColorStyle);

          // Assign the pen width for the image
          imagesetthickness ( $this->img, $this->pen->getWidth());

            if (count($tmpArray2) >= 3) {
                imageantialias($this->img,true);
                imagepolygon($this->img, $tmpArray2, count($tmpArray2)/2, $p1);
                imageantialias($this->img,false);
            }
        }
        */
    }

    /**
     * Draws a series of line segments to join point array p at z displacement.
     *
     * @param z int
     * @param p Point[]
     */
    public function polyLine($z, $p) {
        $l = sizeof($p);
        $tmpP = Array(); //new Point[l];
        for ($t = 0; $t < $l; $t++) {
            $tmpP[$t] = $this->calc3DPoint($p[$t]->getX(),$p[$t]->getY(), $z);
        }
        for ($t = 1; $t < $l; $t++) {
            $this->line($tmpP[$t - 1]->getX(),$tmpP[$t - 1]->getY(),
                $tmpP[$t]->getX(),$tmpP[$t]->getY());
        }
    }

    /**
    * Print text.
    *
    * @param Image GD image
    * @param integer text coordinate (x)
    * @param integer text coordinate (y)
    * @param Color text color
    * @param string text value
    * @param string font file name
    * @param bitfield text alignment
    */
    public function printText($img, $px, $py, $text, $align = -1) {

        
        $font=$this->getFont();
        $color = $font->getBrush()->getColor();

        $fontFileName = $font->getName();

        if ($align==-1) {
           $align = $this->getTextAlign();
        }

        $fontSize = $font->getFontSize();
        $lineSpacing = 1;

        $textWidth =  $this->textWidth($text); //  $lrx - $llx;
        $textHeight = $this->textHeight($text); //  $fontSize; // $lry - $ury;
        $angle = 0;
        
        if (in_array(StringAlignment::$HORIZONTAL_CENTER_ALIGN, $align)) {
            $px -= $textWidth / 2;
        }
        else
        if (in_array (StringAlignment::$HORIZONTAL_RIGHT_ALIGN, $align)) {
            $px -= $textWidth;
        }
        /*
        if (in_array (StringAlignment::$VERTICAL_CENTER_ALIGN, $align)) {
            $py += $textHeight - 3;
        }
        */
        /*if (in_array (StringAlignment::$VERTICAL_TOP_ALIGN, $align)) {
            $py += $textHeight;
        }*/

        /*
        else
        if (in_array (StringAlignment::$VERTICAL_BOTTOM_ALIGN, $align)) {
            $py += $textHeight + 3;
        }

        imagettftext($img, $fontSize, $angle, $px, $py, $color->getColor($img),
            $fontFileName, $text);
            */
            
//        $f = new SWFFont($fontFileName); 
        $f = new SWFFont('Arial'); 
        $t = new SWFTextField(); 
        $t->setFont($f); 
        $t->addString($text); 
        $t->setColor($font->getBrush()->getColor()->getRed(),$font->getBrush()->getColor()->getGreen(),
           $font->getBrush()->getColor()->getBlue(), $font->getBrush()->getColor()->getAlpha());
        //$t->setHeight($fontSize);
        //$p -> remove($i); 

        $text = $this->img->add($t); 
        $text->moveTo($px, $py);
    }

    /**
    * Print text centered horizontally on the image.
    *
    * @param Image GD image
    * @param integer text coordinate (y)
    * @param Color text color
    * @param string text value
    * @param string font file name
    */
    public function printCentered($img, $py, $color, $text, $fontFileName) {
          $tmpAlign = Array(StringAlignment::$HORIZONTAL_CENTER_ALIGN,StringAlignment::$VERTICAL_CENTER_ALIGN);
          $this->printText($img, imagesx($img) / 2, $py, $color, $text, $fontFileName,
              $tmpAlign);
    }

    /**
    * Print text in diagonal.
    *
    * @param Image GD image
    * @param integer text coordinate (x)
    * @param integer text coordinate (y)
    * @param Color text color
    * @param string text value
    */
    public function printDiagonal($img, $px, $py, $text, $angle) {
/*
        $font=$this->getFont();
        $fontSize = $font->getFontSize();
        $fontFileName = $font->getName();
        $color = $font->getBrush()->getColor(); //  $this->textColor;
        $lineSpacing = 1;

        list ($lx, $ly, $rx, $ry) = imageftbbox($fontSize, 0, $fontFileName,
            strtoupper($text), array("linespacing" => $lineSpacing));

        $textWidth = $rx - $lx;

        imagettftext($img, $fontSize, $angle, $px, $py, $color->getColor($img),
            $fontFileName, $text);
            */
    }

    /**
     * Internal use. Calculates the projection co-ordinates for rectangle
     * Bounds.<br>
     *
     * @param maxDepth int is the max shape depth
     * @param r Rectangle is the projected shape rectangle
     */
    public function projection($maxDepth, $r) {
        $this->xCenter = ($r->x + ($r->width * 0.5) + $this->getRotationCenter()->x);
        $this->yCenter = ($r->y + ($r->height * 0.5) + $this->getRotationCenter()->y);
        $this->zCenter = (($maxDepth * 0.5) + $this->getRotationCenter()->z);
        $this->xCenterOffset = $this->xCenter + $this->aspect->getHorizOffset();
        $this->yCenterOffset = $this->yCenter + $this->aspect->getVertOffset();

        $this->calcPerspective($r);
    }

    public function rectangle($rect,$animations=null) {
        
        if ($this->getBrush()->getVisible()) {
            
          /*  $c1 = imagecolorallocatealpha($this->img, $this->getBrush()->getColor()->red,
              $this->getBrush()->getColor()->green,
              $this->getBrush()->getColor()->blue,
              $this->getBrush()->getTransparency());
          */   
            if ($this->getBrush()->getGradient()->getVisible()==true) {
                 /*
                 $colA = array($this->getBrush()->getGradient()->getStartColor()->getRed(),
                   $this->getBrush()->getGradient()->getStartColor()->getGreen(),
                   $this->getBrush()->getGradient()->getStartColor()->getBlue());   
                 $colB = array($this->getBrush()->getGradient()->getEndColor()->getRed(),
                   $this->getBrush()->getGradient()->getEndColor()->getGreen(),
                   $this->getBrush()->getGradient()->getEndColor()->getBlue());
                       
                 $penWidth=$this->getPen()->getWidth();
                 Gradient::imagecolorgradient(
                   $this->img,
                   $rect->getX()+$penWidth, $rect->getY()+$penWidth, 
                   $rect->getRight()-$penWidth, $rect->getHeight()-$penWidth+$rect->getY(),
                   $colA,
                   $colB
                 );  */          
            }   
            else
            { 
              $shape = new SWFShape();
              $penColor = $this->getPen()->getColor();
              $shape->setLine($this->getPen()->getWidth(),$penColor->getRed(), $penColor->getGreen(), $penColor->getBlue());
              
              $brush = $this->getBrush()->getColor();
              //$shape->setRightFill($shape->addFill($brush->getRed(),$brush->getGreen(),$brush->getBlue()));
              
              $shape->movePenTo($rect->x,$rect->y);                            
              $shape->drawLineTo($rect->getRight(),$rect->y);
              $shape->drawLineTo($rect->getRight(),$rect->getBottom());
              $shape->drawLineTo($rect->x,$rect->getBottom());
              $shape->drawLineTo($rect->x,$rect->y);                            
                            
              if (sizeof($animations)>0)
              {
                 for ($i=0;$i<sizeof($animations);$i++)   
                 {
                    //Now we can use that shape in a movie clip and define some actions:
                    $sqclip = new SWFSprite();
                    $i = $sqclip->add($shape);
                    $i->setDepth(1);
                    $sqclip->setframes(155);
                    $sqclip->add(new SWFAction("stop();"));
 
                    $sqclip->nextFrame();
                    $sqclip->add(new SWFAction("play();"));
 
                    for($n=0; $n<24; $n++) {
                        $i->rotate(-1);
                        $sqclip->nextFrame();
                    }

                    //Next we'll create another shape and use it for a button. Rather than create a separate shape for each button action (over, down, up, and release), I've created a function to automate drawing the shapes:
                    function rect($r, $g, $b)  {
                        $s = new SWFShape();
                        $s->setRightFill($s->addFill($r, $g, $b));
                        $s->drawLine(50,0);
                        $s->drawLine(0,50);
                        $s->drawLine(-50,0);
                        $s->drawLine(0,-50);
                        return $s;
                    }
 
                    $b = new SWFButton();
                    $b->addShape(rect(0xff, 0, 0), SWFBUTTON_UP | SWFBUTTON_HIT);
                    $b->addShape(rect(0, 0xff, 0), SWFBUTTON_OVER);
                    $b->addShape(rect(0, 0, 0xff), SWFBUTTON_DOWN);
 
                    $b->addAction(new SWFAction("setTarget('/box'); gotoandplay(2);"), SWFBUTTON_MOUSEDOWN);

                    //Next, we define the movie and place the movie clip (sprite) and the button in the movie itself:
                    //$m = new SWFMovie();
                    //$m->setDimension(4000,3000);
 
                    //$m->setBackground(255,0,0);
 
                    $i = $this->img->add($sqclip);
                    $i->setDepth(3);
                    //$i->moveTo(10, 10);
                    $i->setName("box");
 
                    $i = $this->img->add($b);
                    $i->setDepth(2);
                   // $i->moveTo(10,10);
                 }
              }

              //$this->img->add($shape);
            }
        }

        // Gradient  // TODO post the code into the shape..
/*        if ($this->getBrush()->getGradient()->getVisible()==true) {
            $this->getBrush()->getGradient()->fill($this->img,
            $this->getBrush()->getGradient()->getDirection(),
            $this->getBrush()->getGradient()->getStartColor(),
            $this->getBrush()->getGradient()->getEndColor());
            
        }   */

        
        /*
        if ($this->getPen()->getVisible()) {
          // Gets the pen color and style (dot , dashed, ...)
          $penColorStyle = $this->getPenColorStyle();
          imagesetstyle($this->img, $penColorStyle);

          // Assign the pen width for the image
          imagesetthickness ( $this->img, $this->pen->getWidth());
          imagerectangle($this->img, $rect->x, $rect->y, $rect->getRight(),
              $rect->getBottom(), IMG_COLOR_STYLED); 
          }      
          */  
    }

    public function _rectangle($x, $y, $width, $height) {
        $this->rectangle(new Rectangle($x,$y,$width.$height));
    }

    /**
     * Horizontal Rectangle from Left to Right, from Z0 to Z1 position,
     * at Top Y.<br>
     *
     * @param left int
     * @param top int
     * @param bottom int
     * @param z0 int
     * @param z1 int
     */
    public function rectangleZ($left, $top, $bottom, $z0, $z1) {
        $this->iPoints[0] = $this->calc3DPos($left, $top, $z0);
        $this->iPoints[1] = $this->calc3DPos($left, $top, $z1);
        $this->iPoints[2] = $this->calc3DPos($left, $bottom, $z1);
        $this->iPoints[3] = $this->calc3DPos($left, $bottom, $z0);
        $this->polygonFour();
    }

    public function rectangleWithZ($r, $z) {
        $this->iPoints[0] = $this->calc3DPos($r->x, $r->y, $z);
        $this->iPoints[1] = $this->calc3DPos($r->getRight(), $r->y, $z);
        $this->iPoints[2] = $this->calc3DPos($r->getRight(), $r->getBottom(), $z);
        $this->iPoints[3] = $this->calc3DPos($r->x, $r->getBottom(), $z);
        $this->polygonFour();
    }

    /**
     * Horizontal Rectangle from Left to Right, from Z0 to Z1 position,
     * at Top Y.<br>
     *
     * @param left int
     * @param top int
     * @param right int
     * @param z0 int
     * @param z1 int
     */
    public function rectangleY($left, $top, $right, $z0, $z1) {
        $this->iPoints[0] = $this->calc3DPos($left, $top, $z0);
        $this->iPoints[1] = $this->calc3DPos($right, $top, $z0);
        $this->iPoints[2] = $this->calc3DPos($right, $top, $z1);
        $this->iPoints[3] = $this->calc3DPos($left, $top, $z1);
        $this->polygonFour();
    }

    // With this function you will draw rounded corners rectangles with transparent colors.
    // Empty (not filled) figures are allowed too!!

    function roundrectangle($x1, $y1, $x2, $y2, $radius, $filled=1) {
    /*
      $color = imagecolorallocate($this->img, $this->getBrush()->getColor()->red,
            $this->getBrush()->getColor()->green,
            $this->getBrush()->getColor()->blue);

      if ($filled==1){
        if ($this->getBrush()->getVisible()) {
          imagefilledrectangle($this->img, $x1+$radius, $y1, $x2-$radius, $y2, $color);
          imagefilledrectangle($this->img, $x1, $y1+$radius, $x1+$radius-1, $y2-$radius, $color);
          imagefilledrectangle($this->img, $x2-$radius+1, $y1+$radius, $x2, $y2-$radius, $color);

          imagefilledarc($this->img,$x1+$radius, $y1+$radius, $radius*2, $radius*2, 180 , 270, $color, IMG_ARC_PIE);
          imagefilledarc($this->img,$x2-$radius, $y1+$radius, $radius*2, $radius*2, 270 , 360, $color, IMG_ARC_PIE);
          imagefilledarc($this->img,$x1+$radius, $y2-$radius, $radius*2, $radius*2, 90 , 180, $color, IMG_ARC_PIE);
          imagefilledarc($this->img,$x2-$radius, $y2-$radius, $radius*2, $radius*2, 360 , 90, $color, IMG_ARC_PIE);
        }
      }else{
        imageline($this->img, $x1+$radius, $y1, $x2-$radius, $y1, $color);
        imageline($this->img, $x1+$radius, $y2, $x2-$radius, $y2, $color);
        imageline($this->img, $x1, $y1+$radius, $x1, $y2-$radius, $color);
        imageline($this->img, $x2, $y1+$radius, $x2, $y2-$radius, $color);

        imagearc($this->img,$x1+$radius, $y1+$radius, $radius*2, $radius*2, 180 , 270, $color);
        imagearc($this->img,$x2-$radius, $y1+$radius, $radius*2, $radius*2, 270 , 360, $color);
        imagearc($this->img,$x1+$radius, $y2-$radius, $radius*2, $radius*2, 90 , 180, $color);
        imagearc($this->img,$x2-$radius, $y2-$radius, $radius*2, $radius*2, 360 , 90, $color);
      }
      */
    }

    function drawRoundedBorders($shapeBorders,$backcolor,$forecolor) {        
      /*
            $sourcefile_width=imagesx($this->img);
            $sourcefile_height=imagesy($this->img);
            $background = imagecreatetruecolor($sourcefile_width,$sourcefile_height);

            if ($backcolor==null) {
                $backcolor = new Color(0,0,0,127);  //  transparent
            }
            if ($forecolor==null) {
                $forecolor = new Color(0,0,0,127);  // transparent
            }

            if ($shapeBorders->getTopLeft()->getBorderRound() > 0) {

                $endsize=$shapeBorders->getTopLeft()->getBorderRound();;
                $startsize=$endsize*3-1;
                $arcsize=$startsize*2+1;

                imagecopymerge($background, $this->img, 0, 0, 0, 0, $sourcefile_width, $sourcefile_height, 100);
                $startx=$sourcefile_width*2-1;
                $starty=$sourcefile_height*2-1;
                $im_temp = imagecreatetruecolor($startx,$starty);
                imagecopyresampled($im_temp, $background, 0, 0, 0, 0, $startx, $starty, $sourcefile_width, $sourcefile_height);
                $bg = imagecolorallocate($im_temp,$backcolor->red,$backcolor->green, $backcolor->blue);
                $fg = imagecolorallocate($im_temp,$forecolor->red,$forecolor->green, $forecolor->blue);

                imagearc($im_temp, $startsize, $startsize, $arcsize, $arcsize, 180,270,$fg);
                imagefilltoborder($im_temp,0,0,$fg,$bg);
                imagecopyresampled($this->img, $im_temp, 0, 0, 0, 0, $sourcefile_width,$sourcefile_height,$startx, $starty);
                imagedestroy($im_temp);
            }

            if ($shapeBorders->getBottomLeft()->getBorderRound() > 0) {

                $endsize=$shapeBorders->getBottomLeft()->getBorderRound();;
                $startsize=$endsize*3-1;
                $arcsize=$startsize*2+1;

                imagecopymerge($background, $this->img, 0, 0, 0, 0, $sourcefile_width, $sourcefile_height, 100);
                $startx=$sourcefile_width*2-1;
                $starty=$sourcefile_height*2-1;
                $im_temp = imagecreatetruecolor($startx,$starty);
                imagecopyresampled($im_temp, $background, 0, 0, 0, 0, $startx, $starty, $sourcefile_width, $sourcefile_height);
                $bg = imagecolorallocate($im_temp,$backcolor->red,$backcolor->green, $backcolor->blue);
                $fg = imagecolorallocate($im_temp,$forecolor->red,$forecolor->green, $forecolor->blue);

                imagearc($im_temp, $startsize, $starty-$startsize,$arcsize, $arcsize, 90,180,$fg);
                imagefilltoborder($im_temp,0,$starty,$fg,$bg);
                imagecopyresampled($this->img, $im_temp, 0, 0, 0, 0, $sourcefile_width,$sourcefile_height,$startx, $starty);
                imagedestroy($im_temp);
            }

            if ($shapeBorders->getTopRight()->getBorderRound() > 0) {

                $endsize=$shapeBorders->getTopRight()->getBorderRound();;
                $startsize=$endsize*3-1;
                $arcsize=$startsize*2+1;

                imagecopymerge($background, $this->img, 0, 0, 0, 0, $sourcefile_width, $sourcefile_height, 100);
                $startx=$sourcefile_width*2-1;
                $starty=$sourcefile_height*2-1;
                $im_temp = imagecreatetruecolor($startx,$starty);
                imagecopyresampled($im_temp, $background, 0, 0, 0, 0, $startx, $starty, $sourcefile_width, $sourcefile_height);
                $bg = imagecolorallocate($im_temp,$backcolor->red,$backcolor->green, $backcolor->blue);
                $fg = imagecolorallocate($im_temp,$forecolor->red,$forecolor->green, $forecolor->blue);

                imagearc($im_temp, $startx-$startsize, $startsize,$arcsize, $arcsize, 270,360,$fg);
                imagefilltoborder($im_temp,$startx,0,$fg,$bg);
                imagecopyresampled($this->img, $im_temp, 0, 0, 0, 0, $sourcefile_width,$sourcefile_height,$startx, $starty);
                imagedestroy($im_temp);
            }

            if ($shapeBorders->getBottomRight()->getBorderRound() > 0) {

                $endsize=$shapeBorders->getBottomRight()->getBorderRound();;
                $startsize=$endsize*3-1;
                $arcsize=$startsize*2+1;

                imagecopymerge($background, $this->img, 0, 0, 0, 0, $sourcefile_width, $sourcefile_height, 100);
                $startx=$sourcefile_width*2-1;
                $starty=$sourcefile_height*2-1;
                $im_temp = imagecreatetruecolor($startx,$starty);
                imagecopyresampled($im_temp, $background, 0, 0, 0, 0, $startx, $starty, $sourcefile_width, $sourcefile_height);
                $bg = imagecolorallocate($im_temp,$backcolor->red,$backcolor->green, $backcolor->blue);
                $fg = imagecolorallocate($im_temp,$forecolor->red,$forecolor->green, $forecolor->blue);

                imagearc($im_temp, $startx-$startsize, $starty-$startsize,$arcsize, $arcsize, 0,90,$fg);
                imagefilltoborder($im_temp,$startx,$starty,$fg,$bg);
                imagecopyresampled($this->img, $im_temp, 0, 0, 0, 0, $sourcefile_width,$sourcefile_height,$startx, $starty);
                imagedestroy($im_temp);
            }

            imagedestroy($background);
            */
    }

    /**
     * Draws a triangle (point p0, pointp1, pointp2) at Z position.
     *
     * @param p0 Point
     * @param p1 Point
     * @param p2 Point
     * @param z int
     */
    public function triangle($p0, $p1, $p2, $z=0) {
        $p0 = $this->calc3DPoint($p0->getX(), $p0->getY(), $z);
        $p1 = $this->calc3DPoint($p1->getX(), $p1->getY(), $z);
        $p2 = $this->calc3DPoint($p2->getX(), $p2->getY(), $z);
        $this->polygonPoints($p0, $p1, $p2);
    }
    
    public function arc($x1,$y1,$x2,$y2,$startAngle, $sweepAngle,$filled=0) {
        /*
      $color = imagecolorallocate($this->img, $this->getBrush()->getColor()->red,
            $this->getBrush()->getColor()->green,
            $this->getBrush()->getColor()->blue);

            
      if ($filled==1){
        if ($this->getBrush()->getVisible()) {
          imagefilledarc($this->img,$x1, $y1, $x2-$x1, $y2-$y1, $startAngle , $endAngle, $color, IMG_ARC_PIE);
        }
      }else{
        imagearc($this->img,$x1, $y1, $x2-$x1, $y2-$y1, $startAngle, $endAngle, $color);
      }
      */
    }


    /**
     * Draws a triangle (Triangle3D p).
     *
     * @param p Triangle3D
     *  Todo
    public void triangle(Triangle3D p) {
        Point[] tmp = {calc3DPoint(p.p0), calc3DPoint(p.p1), calc3DPoint(p.p2)};
        polygon(tmp);
    }       */

    /**
     * Draws a rotated text String at the specified x,y and z coordinates with
     * the RotDegree rotation angle.<br>
     * RotDegree values must be between 0 and 360.<br>
     * The string is drawn on the Chart Drawing Canvas.
     *
     * @param x int
     * @param y int
     * @param z int
     * @param text String
     * @param rotDegree double
     */
    public function rotateLabel($x, $y, $z, $text, $rotDegree) {
        // TODO z param is not considred for the moment
        $this->printDiagonal($this->img,$x,$y,$text,$rotDegree);
    }

    /**
     * Draws a rotated text String at the specified Point x,y coordinates with
     * the RotDegree rotation angle.<br>
     * RotDegree values must be between 0 and 360.<br>
     * The string is drawn on the Chart Drawing Canvas.
     *
     * @param p Point
     * @param text String
     * @param rotDegree double
     */
    public function _rotateLabel($p, $text, $rotDegree) {
        $this->rotateLabel($p->getX(), $p->getY(), $text, $rotDegree);
    }

    public function rotateRectangle($r, $angle) {
         $tmpCenter = $r->center();
         $tmpMathUtils = new MathUtils();
         $tmp = $angle * MathUtils::getPiStep();
         $tmpSin = sin($tmp);
         $tmpCos = cos($tmp);

         $tmpRect = $r;
         $tmpRect->offset( -$tmpCenter->x, -$tmpCenter->y);

         $result = Array();
         $result[0] = $this->rotatePoint($tmpRect->x, $tmpRect->y, $tmpCenter, $tmpCos, $tmpSin);
         $result[1] = $this->rotatePoint($tmpRect->getRight(), $tmpRect->y, $tmpCenter,
                                $tmpCos,
                                $tmpSin);
         $result[2] = $this->rotatePoint($tmpRect->getRight(), $tmpRect->getBottom(),
                                $tmpCenter,
                                $tmpCos, $tmpSin);
         $result[3] = $this->rotatePoint($tmpRect->x, $tmpRect->getBottom(), $tmpCenter,
                                $tmpCos,
                                $tmpSin);

        return $result;
    }

    private function rotatePoint($ax, $ay, $tmpCenter, $tmpCos, $tmpSin) {
         $p = new TeePoint();
         $p->x = $tmpCenter->x + (int)($ax * $tmpCos + $ay * $tmpSin);
         $p->y = $tmpCenter->y + (int)( -$ax * $tmpSin + $ay * $tmpCos);

         return $p;
    }

    public function sliceArray($source, $length) {
        $result = Array();
        for ($t = 0; $t < $length; $t++) {
            $result[$t] = $source[$t];
        }
        return $result;
    }

    /**
     * Displays the 2D non-rotated label at the specified X Y screen
     * coordinates.<br>
     * Text is outputted to the correct internal drawing Graphics2D. <br>
     * The X and Y coordinates must be valid and fit inside the Chart
     * rectangle. It uses the current drawing Font attributes. <br>
     * Writes text at the named x and y co-ordinates.
     *
     * @param x int
     * @param y int
     * @param z int
     * @param text String
     */
    public function textOut($x, $y, $z, $text, $align=-1) {
        $f = $this->getFont();

        if ($z <> 0) {
            $p = $this->calc3DPos($x, $y, $z);

            /* TODO style of font
            if (($this->iZoomText) && ($this->iZoomFactor != -1)) {
                (double) $old = $this->font->getDrawingFont()->getSize();
                (int) $tmp = (int) max(1, $this->iZoomFactor * $old);
                if ($old != $tmp) {
                    $this->font->setSize($tmp);
                }
            }
            */

            $x = $p->getX();
            $y = $p->getY();
        }

        /* TODO text shadow
        if ($f->shouldDrawShadow()) {
            $s = $f->getShadow();
            $this->drawString(x + s.getWidth(), y + s.getHeight(), text, s.getBrush());
        }
        */
        if ($align==-1) {
           $align = $this->getTextAlign();
        }

        $this->printText($this->img, $x, $y, $text, $align); //, $f->getBrush());
    }

    /**
     * Returns the vertical text size in pixels of ChartFont f.
     *
     * @param f ChartFont
     * @param text String
     * @return int Height in pixels of ChartFont f.
     */
    public function _textHeight($f, $text) {
        return imagefontheight($f->getFontSize());
    }

    /**
     * Returns the horizontal text size in pixels of ChartFont f.
     *
     * @param f ChartFont
     * @param text String
     * @return int Width in pixels of ChartFont f.
     */
    public function textWidth($text, $f=null) {
       if ($f==null)
           $f=$this->font;

       $lineSpacing = 1;

       list ($llx, $lly, $lrx, $lry, $urx, $ury, $ulx, $uly) = imageftbbox($f->getFontSize(),
               0, $f->getName(), strtoupper($text), array("linespacing" => $lineSpacing));

       $width = $lrx - $llx;

       return round($width);
    }

    /**
     * Returns the vertical size in pixels of the text String.
     *
     * @param text String
     * @return int Height in pixels of the text String.
     */
    public function textHeight($text) {
        return $this->_textHeight($this->font, $text);
    }

    /**
     * Calculates the boundary points of the convex hull of a set of 2D xy
     * points.&nbsp;Original
     *
     * @param p Point[]
     * @return int
     */
    public function convexHull($p) {
        if (sizeof($p) == 3) {
            return 3;
        } else if (sizeof($p) < 3) {
            return 0;
        } else {
            // find pivot point, which is known to be on the hull
            // point with lowest y - if there are multiple, point with highest x
            $lminY = 10000000;
            $lmaxX = 10000000;
            $lpivotIndex = 0;

            $lbound = 0;

            $ubound = sizeof($p) - 1;
            $tmpubound = $ubound - 1;

            for ($lIndex = $lbound; $lIndex <= $ubound; $lIndex++) {
                if ($p[$lIndex]->getY() == $lminY) {
                    if ($p[$lIndex]->getX() > $lmaxX) {
                        $lmaxX = $p[$lIndex]->getX();
                        $lpivotIndex = $lIndex;
                    }
                } else if ($p[$lIndex]->getY() < $lminY) {
                    $lminY = $p[$lIndex]->getY();
                    $lmaxX = $p[$lIndex]->getX();
                    $lpivotIndex = $lIndex;
                }
            }

            // put pivot into seperate variable and remove from array
            $lPivot = $p[$lpivotIndex];
            $p[$lpivotIndex] = $p[$ubound];

            // calculate angle to pivot for each point in the array
            // quicker to calculate dot product of point with a horizontal comparison vector
            $langles = Array();  // Array of doubles
            //double[] langles = new double[tmpubound + 1];

            for ($lindex = 0; $lindex <= $tmpubound; $lindex++) {
                $lvx = $lPivot->getX() - $p[$lindex]->getX();
                $lvy = $lPivot->getY() - $p[$lindex]->getY();

                // reduce to a unit-vector - length 1
                $tmp = sqrt($lvx * $lvx + $lvy * $lvy);
                $langles[$lindex] = ($tmp == 0) ? 0.0 : $lvx / $tmp;
            }

            // sort the points by angle
            self::quickSortAngle($p, $langles, 0, $tmpubound);

            // step through array to remove points that are not part of the convex hull
            $t = 1;
            $lrightturn = true;

            do {
                // assign points behind and infront of current point
                if ($t == 0) {
                    $lrightturn = true;
                } else {
                    $lBehind = $p[$t - 1];
                    $lInFront = ($t == $tmpubound) ? $lPivot : $p[$t + 1];

                    // work out if we are making a right or left turn using vector product
                    $lrightturn = (($lBehind->getX() - $p[$t]->getX()) * ($lInFront->getY() - $p[$t]->getY())) -
                                 (($lInFront->getX() - $p[$t]->getX()) * ($lBehind->getY() - $p[$t]->getY())) < 0;
                }

                if ($lrightturn) {
                    $t++;
                } else {
                    $tmphigh = $tmpubound;
                    // remove point from convex hull
                    if ($t != $tmphigh) {
                        for ($i = $t; $i < $tmphigh; $i++) {
                            $p[$i] = $p[$i + 1];
                        }
                    }
                    $tmpubound = $tmphigh - 1;
                    $t--; // backtrack to previous point
                }
            } while ($t != $tmpubound);

            // add pivot back into points array
            $tmpubound++;
            $p[$tmpubound] = $lPivot;
            return $tmpubound + 1;
        }
    }

    /**
     * Sort an array of points by angles.
     *
     * @param p Point[]
     * @param angles double[]
     * @param low int
     * @param high int
     */
    static private function quickSortAngle($p, $angles, $low, $high) {
        $lo = $low;
        $hi = $high;
        $midangle = $angles[($lo + $hi) / 2];

        do {
            while ($angles[$lo] < $midangle) {
                $lo++;
            } while ($angles[$hi] > $midangle) {
                $hi--;
            }
            if ($lo <= $hi) {
                // swap points
                $tpoint = $p[$lo];
                $p[$lo] = $p[$hi];
                $p[$hi] = $tpoint;
                // swap angles
                $tangle = $angles[$lo];
                $angles[$lo] = $angles[$hi];
                $angles[$hi] = $tangle;
                $lo++;
                $hi--;
            }
        } while ($lo <= $hi);

        // perform quicksorts on subsections
        if ($hi > $low) {
            self::quickSortAngle($p, $angles, $low, $hi);
        }
        if ($lo < $high) {
            self::quickSortAngle($p, $angles, $lo, $high);
        }
    }


    /**************************************************************************
    * Gets and Sets methods.....                                              *
    **************************************************************************/

    private function setAspect($value) {
        $this->aspect = $value;
        $this->is3D = $this->aspect->getView3D();
        $this->isOrtho = $this->aspect->getOrthogonal();
    }

    /**
     * Determines the kind of brush used to fill the Canvas draw rectangle
     * background.<BR>
     * The Brush.Visible method must be set to true.
     *
     * @return ChartBrush
     */
    public function getBrush() {
        if ($this->brush==null)
           $this->brush=new ChartBrush(null);

        return $this->brush;
    }

    /**
     * Determines the kind of brush used to fill the Canvas draw rectangle
     * background.<BR>
     * The Brush.Visible method must be set to true.
     *
     * @param value ChartBrush
     */
    public function setBrush($value) {
        if ($value!=null)
          $this->getBrush()->assign($value);
        else
          $this->brush=null;
    }

    /**
     * Returns a color from global ColorPalette array variable.
     *
     * @param index int
     * @return Color
     */
    public function getDefaultColor($index) {
        return $this->colorPalette[$index % sizeof($this->colorPalette)];
    }

    /**
     * Specifies a color from global ColorPalette array variable.
     *
     * @param palette Color[]
     */
    public function setColorPalette($palette) {
        $this->colorPalette=$palette;
        
        //$colorPalette = Array(); //sizeof($palette.length)];
/*        for ($t = 0; $t < sizeof($palette); $t++) {
            $this->colorPalette[$t] = $palette[$t];                        
        }
        
        $this->getChart()->doBaseInvalidate();
  */    
        $this->getChart()->doBaseInvalidate();                                             
    }
    
    // Return integer
    public function getColorPaletteLength() {
        return sizeof($this->colorPalette);
    }

    public function getDirty() {
        return false;
    }

    public function setDirty($value) {}

    /**
     * Determines the Font for outputted text when using the Drawing Canvas.
     *
     * @return ChartFont
     */
    public function getFont() {
        return $this->font;
    }

    /**
     * Determines the Font for outputted text when using the Drawing Canvas.
     *
     * @param value ChartFont
     */
    public function setFont($value) {
        $this->font->assign($value);
    }

    /**
     * Defines the Height of the Font in pixels.
     *
     * @return int
     */
    public function getFontHeight() {
        return $this->textHeight("W");
    }

    public function setGraphics($value) {
       $this->GraphicsGD=$value;
    }

    public function getMetafiling() {
        return $this->metafiling;
    }

    public function setMetafiling($value) {
        $this->metafiling = $value;
    }

    public function getMonochrome() {
        return $this->monochrome;
    }

    /**
     * Gets / Sets the alignment used when displaying text using TextOut or TextOut3D.
     * <br>
     * Default value: Near
     *
     * @param value StringAlignment
     */

    public function getTextAlign() {
        return $this->stringFormat->alignment;
    }

    public function setTextAlign($value) {
          if (is_array($value)){
            $this->stringFormat->alignment=$value;
          }
          else {
           $this->stringFormat->alignment=Array($value);
          }
    }

    /**
     * Indicates the kind of pen used to draw Canvas lines.
     *
     * @return ChartPen
     */
    public function getPen() {
        return $this->pen;
    }

    /**
     * Determines the kind of pen used to draw Canvas lines.
     *
     * @param value ChartPen
     */
    public function setPen($value) {
        if ($value!=null)
          $this->pen->assign($value);
    }

    private function getPenColorStyle() {
        
        $penColor = imagecolorallocatealpha($this->img,
                    $this->pen->getColor()->red,
                    $this->pen->getColor()->green,
                    $this->pen->getColor()->blue,
                    $this->pen->getColor()->alpha);
                                
        switch ($this->pen->getStyle()) {
            case 1: // DOT
                return array($penColor,IMG_COLOR_TRANSPARENT);
                break;
            case 2: // DASH
                return array($penColor,$penColor,IMG_COLOR_TRANSPARENT,IMG_COLOR_TRANSPARENT,IMG_COLOR_TRANSPARENT);
                break;
            case 3: // DASHDOT
                return array($penColor,$penColor,IMG_COLOR_TRANSPARENT,$penColor);
                break;
            case 4: // DASHDOTDOT
                return array($penColor,$penColor,IMG_COLOR_TRANSPARENT,$penColor,IMG_COLOR_TRANSPARENT,$penColor);
                break;            
            default:  // SOLID value 0
                return array($penColor);
                break;
        }
    }

    /**
     * Sets the Pixel location (using X,Y,Z) of the centre of rotation for use
     * with the Aspect Rotation and Elevation properties.<br>
     *
     * @return Point3D
     */
    public function getRotationCenter() {
        return $this->rotationCenter;
    }


    /**
     * Returns the bounding rectangle for a given array of XY points.
     *
     * @param num int
     * @param p Point[]
     * @return Rectangle
     */
    public function rectFromPolygon($num, $p) {
        $r = new Rectangle($p[0]->getX(), $p[0]->getY(), 0, 0);

        for ($t = 1; $t < $num; $t++) {
            if ($p[$t]->getX() < $r->getX()) {
                $r->setX($p[$t]->getX());
            } else
            if ($p[$t]->getX() > $r->getRight()) {
                $r->setWidth($p[$t]->getX() - $r->getX());
            }

            if ($p[$t]->getY() < $r->getY()) {
                $r->setY($p[$t]->getY());
            } else
            if ($p[$t]->getY() > $r->getBottom()) {
                $r->setHeight($p[$t]->getY() - $r->getY());
            }
        }

        $r->width++;
        $r->height++;

        return $r;
    }

    /**
     * Obsolete.&nbsp;Please use Rectangle.<!-- -->Contains method.
     *
     * @param rect Rectangle
     * @param x int
     * @param y int
     * @return boolean
     */
    static public function pointInRect($rect, $x, $y) {
        return $rect->contains($x, $y);
    }

    /**
     * Returns true if point P is inside the vert triangle of x0y0, midxY1,
     * x1y0.
     *
     * @param p Point
     * @param x0 int
     * @param x1 int
     * @param y0 int
     * @param y1 int
     * @return boolean
     */
    static public function pointInTriangle($p, $x0, $x1, $y0, $y1) {
        $tmp = Array(new TeePoint($x0, $y0), new TeePoint(($x0 + $x1) / 2, $y1),
                      new TeePoint($x1, $y0));

        return $this->pointInPolygon($p, $tmp);
    }

    /**
     * Returns true if point P is inside the horizontal triangle.
     *
     * @param p Point
     * @param y0 int
     * @param y1 int
     * @param x0 int
     * @param x1 int
     * @return boolean
     */
    static public function pointInHorizTriangle($p, $y0, $y1, $x0, $x1) {
        $tmp = Array(new TeePoint($x0, $y0), new TeePoint($x1, ($y0 + $y1) / 2),
                      new TeePoint($x0, $y1));
        return $this->pointInPolygon($p, $tmp);
    }

    /// <summary>
    /// Returns point "ATo" minus ADist pixels from AFrom point.
    /// </summary>
    static public function pointAtDistance($From, $To, $distance)
    {
      (int)$px = $To->getX();
      (int)$py = $To->getY();

      if ($To->getX() != $From->getX())
      {
        $angle = atan2($To->getY() - $From->getY(), $To->getX() - $From->getX());
        $tmpsin = sin($angle);
        $tmpcos = cos($angle);
        $px -= MathUtils::round($distance * $tmpcos);
        $py -= MathUtils::round($distance * $tmpsin);
      }
      else
      {
        if ($To->getY() < $From->getY()) $py += $distance;
        else $py -= $distance;
      }
      return new TeePoint($px, $py);
    }

    /**
     * Returns true if point P is inside the ellipse bounded by Left, Top,
     * Right, Bottom.
     *
     * @param p Point
     * @param left int
     * @param top int
     * @param right int
     * @param bottom int
     * @return boolean
     */
    static public function _pointInEllipse($p, $left, $top, $right, $bottom) {
        return $this->pointInEllipse($p, Rectangle::fromLTRB($left, $top, $right, $bottom));
    }

    /**
     * Returns true if point P is inside the ellipse bounded by Rect.
     *
     * @param p Point
     * @param rect Rectangle
     * @return boolean
     */
    static public function pointInEllipse($p, $rect) {
        $tmp = $rect->center();
        $tmpWidth = (int) sqr($tmp->getX() - $rect->getX());
        $tmpHeight = (int) sqr($tmp->getY() - $rect->getY());

        return ($tmpWidth != 0) && ($tmpHeight != 0) &&
                ((sqr($p->getX() - $tmp->getX()) / $tmpWidth) +
                 (sqr($p->getY() - $tmp->getY()) / $tmpHeight) <= 1
                );
    }

    /**
     * Returns true if point P is inside Poly polygon.
     *
     * @param p Point
     * @param poly Point[]
     * @return boolean
     */
    static public function pointInPolygon($p, $poly) {
        $result = false;
        (int)$j = sizeof($poly) - 1;
        (int)$tmp = $j;

        for ($i = 0; $i <= $tmp; $i++) {
            if ((((($poly[$i]->getY() <= $p->getY()) && ($p->getY() < $poly[$j]->getY())) ||
                  (($poly[$j]->getY() <= $p->getY()) && ($p->getY() < $poly[$i]->getY()))) &&
                 ($p->getX() < ($poly[$j]->getX() - $poly[$i]->getX()) * ($p->getY() - $poly[$i]->getY())
                  / ($poly[$j]->getY() - $poly[$i]->getY()) + $poly[$i]->getX()))) {
                $result = !$result;
            }
            $j = $i;
        }

        return $result;
    }

    // Returns boolean
    protected function getIZoomfactor() {
        return $this->iZoomFactor;
    }

    protected function setIZoomfactor($value) {
        $this->iZoomFactor = $value;
    }

    /**
     * The X coordinate of the pixel location of the center of the 3D
     * Canvas.<br>
     * The origin of the pixel coordinate system is in the top left corner of
     * the parent window.
     *
     * @return int
     */
    public function getXCenter() {
        return $this->xCenter;
    }

    /**
     * Specifies the X coordinate of the pixel location of the center of the 3D
     * Canvas.<br>
     * The origin of the pixel coordinate system is in the top left corner of
     * the parent window.
     *
     * @param value int
     */
    public function setXCenter($value) {
        $this->xCenter = $value;
    }

    /**
     * The Y coordinate of the pixel location of the center of the 3D
     * Canvas.<br>
     * The origin of the pixel coordinate system is in the top left corner of
     * the parent window.
     *
     * @return int
     */
    public function getYCenter() {
        return $this->yCenter;
    }

    /**
     * Specifies the Y coordinate of the pixel location of the center of the 3D
     * Canvas.<br>
     * The origin of the pixel coordinate system is in the top left corner of
     * the parent window.
     *
     * @param value int
     */
    public function setYCenter($value) {
        $this->yCenter = $value;
    }

    /**
     * Returns a valid Windows Brush Style from anpalette of many possible
     * Brush styles.
     *
     * @param index int
     * @return HatchStyle
     */
    static public function getDefaultPattern($index) {
        $patternPalette = Array (
                                      HatchStyle::$HORIZONTAL,
                                      HatchStyle::$VERTICAL,
                                      HatchStyle::$FORWARDDIAGONAL,
                                      HatchStyle::$BACKWARDDIAGONAL,
                                      HatchStyle::$CROSS,
                                      HatchStyle::$DIAGONALCROSS,
                                      HatchStyle::$DIAGONALBRICK,
                                      HatchStyle::$DIVOT,
                                      HatchStyle::$LARGECONFETTI,
                                      HatchStyle::$OUTLINEDDIAMOND,
                                      HatchStyle::$PLAID,
                                      HatchStyle::$SHINGLE,
                                      HatchStyle::$SOLIDDIAMOND,
                                      HatchStyle::$SPHERE,
                                      HatchStyle::$TRELLIS,
                                      HatchStyle::$WAVE,
                                      HatchStyle::$WEAVE,
                                      HatchStyle::$ZIGZAG
        );
        return $patternPalette[$index % sizeof($patternPalette)];
    }


    /**
     * The anti-alias mode for the Graphics Pen when Custom drawing.<br>
     * For example: <br>
     *             AntiAlias - Specifies antialiased rendering.<br>
     *             Default - Specifies the default mode.<br>
     *             HighQuality - Specifies high quality, low speed rendering.
     * <br>
     *             HighSpeed - Specifies high speed, low quality rendering.<br>
     *             Invalid - Specifies an invalid mode.  <br>
     *
     * @return boolean
     */
    public function getSmoothingMode() {
        return $this->smoothingMode;
    }

    /**
     * Sets the anti-alias mode for the Graphics Pen when Custom drawing.<br>
     * For example: <br>
     *             AntiAlias - Specifies antialiased rendering.<br>
     *             Default - Specifies the default mode.<br>
     *             HighQuality - Specifies high quality, low speed rendering.
     * <br>
     *             HighSpeed - Specifies high speed, low quality rendering.<br>
     *             Invalid - Specifies an invalid mode.  <br>
     *

     * @param value boolean
     */
    public function setSmoothingMode($value) {
        $this->smoothingMode = $this->setBooleanProperty($this->smoothingMode, $value);
    }

    static private function internalGetSupports3DText() {
        return false;
    }

    /**
     * Returns if Canvas supports 3D Text or not.
     *
     * @return boolean
     */
    public function getSupports3DText() {
        return self::internalGetSupports3DText();
    }

    /**
     * Returns if Canvas can do rotation and elevation of more than 90 degree.
     *
     * @return boolean
     */
    public function getSupportsFullRotation() {
        return false;
    }

    // Returns TeePoint
    static public function rectCenter($r) {
        return new TeePoint(
                ($r->getX() + $r->getRight()) / 2,
                ($r->y + $r->getBottom()) / 2
                );
    }

    // returns PointDouble
    public function pointFromCircle($rectBounds, $degrees,
                                       $zPos, $clockWise=false)
    {
      $centrePoint = $this->rectCenter($rectBounds);

      $radians = (M_PI * $degrees) / 180.0;
      $radiusH = $rectBounds->getWidth() / 2.0;
      $radiusV = $rectBounds->getHeight() / 2.0;

      $tmpX = $centrePoint->getX() + $radiusH * cos($radians);
      $tmpY = 0;
      if ($clockWise)
      {
        $tmpY = $centrePoint->getY() + $radiusV * sin($radians);
      }
      else
      {
        $tmpY = $centrePoint->getY() - $radiusV * sin($radians);
      }

      //$tmpPoint = new PointDouble();

      if ($zPos > 0)
      {
        $tmpPoint = $this->calc3DPos($tmpX,$tmpY,$zPos);
      }
      else
      {
        $tmpPoint = new PointDouble($tmpX, $tmpY);
      }

      return $tmpPoint;
    }

    public function getImageInterlace()
    {
        return $this->imageinterlace;
    }

    public function setImageInterlace($vlaue)
    {
        $this->imageinterlace=$value;
    }

    public function getImageReflection()
    {
        return $this->imageReflection;
    }

    public function setImageReflection($value)
    {
        $this->imageReflection=$value;
    }

    /**
     * Converts the Color parameter to a darker color.<br>
     * The HowMuch parameter indicates the quantity of dark increment.
     * It is used by Bar Series and Pie Series to calculate the right color to
     * draw Bar sides and Pie 3D zones.
     *
     * @param c Color
     * @param howMuch int
     * @return Color
     */
    static public function applyDark($c, $howMuch) {
        return $c->applyDark($howMuch);
    }

    public static function doReflection($im) {
    /*
        $rH = 50; // Reflection height
        $tr = 30; // Starting transparency
        $div = 1; // Size of the divider line

        $w=imagesx($im);
        $h=imagesy($im);

        $imgFinal = $im;

        $li = imagecreatetruecolor($w, 1);
        $bgc = imagecolorallocate($li, 255, 255, 255); // Background color
        imagefilledrectangle($li, 0, 0, $w, 1, $bgc);
        $bg = imagecreatetruecolor($w, $rH);
        $wh = imagecolorallocate($im,255,255,255);

        $im = imagerotate($im, -180, $wh);
        imagecopyresampled($bg, $im, 0, 0, 0, 0, $w, $h, $w, $h);
        $im = $bg;
        $bg = imagecreatetruecolor($w, $rH);

        for ($x = 0; $x < $w; $x++) {
          imagecopy($bg, $im, $x, 0, $w-$x, 0, 1, $rH);
        }

        $im = $bg;
        $in = 100/$rH;

        for($i=0; $i<=$rH; $i++){
          if($tr>100) $tr = 100;
            imagecopymerge($im, $li, 0, $i, 0, 0, $w, 1, $tr);
          $tr+=$in;
        }

        imagecopymerge($im, $li, 0, 0, 0, 0, $w, $div, 100); // Divider

        return $im;
        imagedestroy($li);
        */
    }


    /**
     * Returns the height, in pixels, of the Chart Panel.<br>
     * It should be used when using Canvas methods to draw relative to the
     * Panel height. <br>
     * <b>Note:</B> You should <b>NOT</b> use TChart.Height.

     *
     * @return int
     */
    static public function getScreenHeight() {
        return 1050;  // Value assigned as PHP does not allow to get the screen hetight directly
    }

    /**
     * Returns the width, in pixels, of the Chart Panel.
     *
     * @return int
     */
    static public function getScreenWidth() {
        return 1680;  // Value assigned as PHP does not allow to get the screen width directly
    }
}
?>