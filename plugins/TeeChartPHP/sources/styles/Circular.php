<?php
 /**
 * Description:  This file contains the following class:<br>
 * Circular class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Circular class
 *
 * Description: Circled Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Circular extends Series {

    /**
      Represents the static finalant pi / 180.
    */
    public static $PIDEGREE;

    private $circled;
    private $rotationAngle;
    private $customXRadius;
    private $customYRadius;
    private $circleWidth;
    private $circleHeight;
    private $circleBackColor;
    private $circleGradient;
    private $iBack3D; // global to all instances

    protected $iXRadius;
    protected $iYRadius;
    protected $iCircleXCenter;
    protected $iCircleYCenter;
    protected $rCircleRect;
    protected $rotDegree;

    private $HALFPI;

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

    public function __construct($c=null) {
        self::$PIDEGREE = M_PI / 180;
        $this->circleBackColor = new Color(0,0,0,0,true); // EMPTY
        $this->HALFPI = 0.5 * M_PI;

        parent::__construct($c);
        
        $this->useAxis = false;
        $this->calcVisiblePoints = false; //   all $this->points
        $this->vxValues->name = "ValuesAngle"; // TODO $this->Language->getString("ValuesAngle");
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->circled);
        unset($this->rotationAngle);
        unset($this->customXRadius);
        unset($this->customYRadius);
        unset($this->circleWidth);
        unset($this->circleHeight);
        unset($this->circleBackColor); 
        unset($this->circleGradient); 
        unset($this->iBack3D); 
        unset($this->iXRadius); 
        unset($this->iYRadius); 
        unset($this->iCircleXCenter); 
        unset($this->iCircleYCenter); 
        unset($this->rCircleRect); 
        unset($this->rotDegree); 
        unset($this->HALFPI);           
    }  
        
    protected function adjustCircleRect() {

        $r = $this->rCircleRect;
        if (($r->width % 2) == 1) {
            $r->width--;
        }
        if (($r->height % 2) == 1) {
            $r->height--;
        }
        if ($r->width < 4) {
            $r->width = 4;
        }
        if ($r->height < 4) {
            $r->height = 4;
        }
        $this->circleWidth = $r->width;
        $this->circleHeight = $r->height;
        $tmp = $this->rCircleRect->center();
        $this->iCircleXCenter = $tmp->getX();
        $this->iCircleYCenter = $tmp->getY();
    }

    protected function calcCircleBackColor() {
        $result = $this->circleBackColor;
        if ($result->isEmpty()) {
            if ($this->chart->getPrinting()) {
                $tmpColor = new Color();
                $result = $tmpColor->WHITE;
                unset($tmpColor);
            } else
            if (!$this->chart->getWalls()->getBack()->getTransparent()) {
                $result = $this->getColor();
            }
        }

        if ($result->isEmpty()) {
            $result = $this->chart->getPanel()->getColor();
        }
        return $result;
    }

    //CDI CircleGradient
    protected function calcCircleGradient() {
         $result = $this->circleGradient;
        return $result;
    }

    protected function calcRadius() {
        if ($this->customXRadius != 0) {
            $this->iXRadius = $this->customXRadius;
            $this->circleWidth = 2 * $this->iXRadius;
        } else {
            $this->iXRadius = $this->circleWidth / 2;
        }

        if ($this->customYRadius != 0) {
            $this->iYRadius = $this->customYRadius;
            $this->circleHeight = 2 * $this->iYRadius;
        } else {
            $this->iYRadius = $this->circleHeight / 2;
        }

        $this->rCircleRect->x = $this->iCircleXCenter - $this->iXRadius;
        $this->rCircleRect->width = 2 * $this->iXRadius;
        $this->rCircleRect->y = $this->iCircleYCenter - $this->iYRadius;
        $this->rCircleRect->height = 2 * $this->iYRadius;
    }

    private function adjustRatio($aRatio, $g) {
        // todo: obtain width and height from "g" instead of screen device
        $tmpH = GraphicsGD::getScreenHeight();
        $tmpW = GraphicsGD::getScreenWidth();

        $result = $aRatio;

        if ($tmpH != 0) {
             $tmpRatio = (1.0 * $tmpW / $tmpH);
            if ($tmpRatio != 0) {
                $result = 1.0 * $aRatio / $tmpRatio;
            }
        }
        return $result;
    }

    private function calcCircledRatio() {
 
        $ratio = $this->adjustRatio(1.0 * GraphicsGD::getScreenWidth() /
                                   GraphicsGD::getScreenHeight(),
                                   $this->chart->getGraphics3D());
        $this->calcRadius();

        if (MathUtils::round($ratio * $this->iYRadius) < $this->iXRadius) {
            $dif = ($this->iXRadius - MathUtils::round($ratio * $this->iYRadius));
            $this->rCircleRect->x += $dif;
            $this->rCircleRect->width -= 2 * $dif;
        } else {
            $dif = ($this->iYRadius - MathUtils::round(1.0 * $this->iXRadius / $ratio));
            $this->rCircleRect->y += $dif;
            $this->rCircleRect->height -= 2 * $dif;
        }

        $this->adjustCircleRect();
    }

    private function adjustCircleMarks() {
        $tmpFrame = $this->getMarks()->getCallout()->getLength();

        if ($this->getMarks()->getPen()->getVisible()) {
            $tmpFrame += round(2 * $this->getMarks()->getPen()->getWidth());
        }

        $this->chart->getGraphics3D()->setFont($this->getMarks()->getFont());

        $tmpH = $this->chart->getGraphics3D()->getFontHeight() + $tmpFrame;

        $this->rCircleRect->y += $tmpH;
        $this->rCircleRect->height -= 2 * $tmpH;

        $tmpW = round($this->maxMarkWidth() +
            $this->chart->getGraphics3D()->textWidth(" ") + $tmpFrame);  // TODO textWidth($this->Language->getString("CharForHeight"))

        $this->rCircleRect->x += $tmpW;
        $this->rCircleRect->width -= 2 * $tmpW;
        $this->adjustCircleRect();
    }

    //CDI base method called last to initialise Radius values
    protected function doBeforeDrawValues() {
        parent::doBeforeDrawValues();
        $this->rCircleRect = $this->chart->getChartRect();
        $this->adjustCircleRect();

        if ($this->getMarks()->getVisible()) {
            $this->adjustCircleMarks();
        }

        if ($this->circled) {
            $this->calcCircledRatio();
        }
        $this->calcRadius();
    }

    protected function prepareLegendCanvas($g, $valueIndex, $backColor, $aBrush) {
        $backColor = $this->calcCircleBackColor();
    }

    public function setActive($value) {
        parent::setActive($value);
        $this->setParentProperties(!$this->bActive);
    }

    // Trick (due to .Net delayed GC)
    public function onDisposing() {
        $this->setParentProperties(true);
    }

    public function setChart($value) {
        if ($value == null) {
            $this->setParentProperties(true);
        }
        if ($value != $this->chart) {
            parent::setChart($value);
            if ($this->chart != null) {
                $this->setParentProperties(false);
            }
        }
    }

    protected function setParentProperties($enableParentProps) {

        if ($this->chart != null) {

             $g = $this->chart->getGraphics3D();
             $tmp = ($g == null) ? true : !$g->getSupportsFullRotation();

            if ($tmp) {
                if ($enableParentProps) {
                    if ($this->iBack3D != null) {
                        $this->chart->getAspect()->assign($this->iBack3D);
                    }
                    $this->iBack3D = null;
                } else
                if ($this->iBack3D == null) {
                    $this->iBack3D = new Aspect();

                     $a = $this->chart->getAspect();
                    $this->iBack3D->assign($a);

                    if ($a->getOrthogonal()) {
                        $a->setOrthogonal(false);
                        $a->setRotation(360);
                        $a->setElevation(315);
                        $a->setPerspective(0);
                    }
                    $a->setTilt(0);
                }
            }
        }
    }

    /**
          * The angle of Chart rotation.<br>
          * The RotationAngle can be a valid integer number between 0 and 359.<br>
          * This angle can be changed by code to rotate the Pie (or Polar). <br>
          * Default value: 0
          *
          * @return int
          */
    public function getRotationAngle() {
        return $this->rotationAngle;
    }

    /**
          * Sets angle of Chart rotation.<br>
          * Default value: 0<br>
          *
          * <p>Example:
          * <pre><font face="Courier" size="4">
          * pieSeries = new com.steema.teechart.styles.Pie(myChart.getChart());
          * pieSeries.getMarks().setVisible(true);
          * pieSeries.getMarks().setStyle(MarksStyle.LABELPERCENT);
          * pieSeries.fillSampleValues(5);
          * pieSeries.setAngleSize(180);
          * pieSeries.setRotationAngle(90);
          * </font></pre></p>
          *
          * @param value int
          */
    public function setRotationAngle($value) {
        $this->rotationAngle = $this->setIntegerProperty($this->rotationAngle, $value % 360);
        $this->rotDegree = $this->rotationAngle * self::$PIDEGREE;
    }

    /**
          * Returns the exact Screen position for a given pair of Angle and Radius
          * values.
          *
          * @param angle double
          * @param aXRadius double
          * @param aYRadius double
          * @return Point
          */
    public function angleToPos($angle, $aXRadius, $aYRadius) {
        $tmpSin = sin($this->rotDegree + $angle);
        $tmpCos = cos($this->rotDegree + $angle);
        return new TeePoint($this->iCircleXCenter + MathUtils::round($aXRadius * $tmpCos),
                         $this->iCircleYCenter - MathUtils::round($aYRadius * $tmpSin));
    }

    public function associatedToAxis($a) {
        return true;
    }

    /**
          * Returns the angle from the XY point parameter to the circle center.
          *
          * @param x int
          * @param y int
          * @return double
          */
    public function pointToAngle($x, $y) {
        if (($x - $this->iCircleXCenter) == 0) {
            if ($y > $this->iCircleYCenter) {
                $result = -$this->HALFPI;
            } else {
                $result = $this->HALFPI;
            }
        } else
        if (($this->iYRadius == 0) || ($this->iYRadius == 0)) {
            $result = 0;
        } else {
            $result = atan2(((double)($this->iCircleYCenter - $y) /
                                      (double) $this->iYRadius),
                                     ((double) ($x - $this->iCircleXCenter) /
                                      (double) $this->iXRadius));
        }
        if ($result < 0) {
            $result += 2.0 * M_PI;
        }
        $result -= $this->rotDegree;
        if ($result < 0) {
            $result += 2.0 * M_PI;
        }
        return $result;
    }

    /**
          * Returns the radius from XY point to the circle center.
          *
          * @param x int
          * @param y int
          * @return double
          */
    public function pointToRadius($x, $y) {
        if ($this->getVertAxis() != null) {
             $range = $this->getVertAxis()->getMaximum() -
                           $this->getVertAxis()->getMinimum();
            if ($range == 0.0) {
                return 0.0;
            } else {
                 $dx = $x - $this->iCircleXCenter;
                 $dy = $y - $this->iCircleYCenter;
                $dx *= $range / (double) $this->iXRadius;
                $dy *= $range / (double) $this->iYRadius;
                return sqrt($dx * $dx + $dy * $dy) + $this->getVertAxis()->getMinimum();
            }
        } else {
            return 0.0;
        }
    }

    /**
          * Returns the angle by which the Chart is rotated.
          *
          * @param angle int
          */
    public function rotate($angle) {
        $this->setRotationAngle(($this->rotationAngle + $angle) % 360);
    }

    /**
          * Returns the exact horizontal size of the ellipse's radius in pixels.<br>
          * The ellipse XRadius can be set to a fixed number of pixels by using
          * this method. Circled series.Circled controls whether both radii must
          * be proportional to the Screen X/Y ratio.
          *
          * @return int
          */
    public function getXRadius() {
        return $this->iXRadius;
    }

    /**
          * Returns the exact vertical size of the ellipse's radius in pixels.<br>
          * The ellipse YRadius can be set to a fixed number of pixels by using this
          * method. Circled series .Circled controls whether both radii must be
          * proportional to the Screen X/Y ratio.
          *
          * @return int
          */
    public function getYRadius() {
        return $this->iYRadius;
    }

    /**
          * Returns the exact horizontal position of ellipse's center in pixels.<br>
          * Run-time and read only.
          * The ellipse's radius is determined by Circled series.XRadius and YRadius.
          * The AngleToPoint function converts from angles to X and Y Screen
          * coordinates. The PointToAngle function converts from XY Screen positions
          * to angles.
          *
          * @return int
          */
    public function getCircleXCenter() {
        return $this->iCircleXCenter;
    }

    /**
          * Returns the exact vertical position of the ellipse's center in pixels.
          * <br>
          * The ellipse's radius is determined by Circled series.XRadius and YRadius.
          * The AngleToPoint function converts from angles to X and Y Screen
          * coordinates. The PointToAngle function converts from XY Screen positions
          * to angles.
          *
          * @return int
          */
    public function getCircleYCenter() {
        return $this->iCircleYCenter;
    }

    /**
          * Returns the width of the bounding Circle.
          *
          * @return int
          */
    public function getCircleWidth() {
        return $this->circleWidth;
    }

    /**
          * Returns the height of the bounding Circle.
          *
          * @return int
          */
    public function getCircleHeight() {
        return $this->circleHeight;
    }

    /**
          * Returns the rectangle that bounds the circle.<br>
          * eg. Pie Series, in its default position displacement of elevevation,
          * rotation ,etc not applied.

          * @return Rectangle
          */
    public function getCircleRect() {
        return $this->rCircleRect;
    }

    protected function shouldSerializeCircleBackColor() {
        return!$this->circleBackColor->isEmpty();
    }

    /**
          * Determines the color to fill the ellipse.<br>
          * Setting it to Color.EMPTY indicates the CircledSeries to use to
          * tChart.getPanel().getColor() color.
          *
          * @return Color
          */
    public function getCircleBackColor() {
        return $this->circleBackColor;
    }

    /**
          * Determines the color to fill the ellipse.<br>
          *
          * @param value Color
          */
    public function setCircleBackColor($value) {
        if ($this->bBrush->getTransparency() != 0) {
            $this->circleBackColor = $value->transparentColor($this->bBrush->getTransparency());
        } else {
            $this->circleBackColor = $this->setColorProperty($this->circleBackColor, $value);
        }
    }

    //CDI CircleGradient
    /**
          * Determines the Gradient which fills the ellipse.<br>
          * Default value: null
          *
          * <p>Example:
          * <pre><font face="Courier" size="4">
          * series = new com.steema.teechart.styles.Polar(myChart.getChart());
          * series.fillSampleValues(20);
          * series.setCircled(true);
          * series.getCircleGradient().setDirection(GradientDirection.RADIAL);
          * series.getCircleGradient().setStartColor(Color.WHITE);
          * series.getCircleGradient().setEndColor(Color.DARK_GRAY);
          * series.getCircleGradient().setRadialX(100);
          * series.getCircleGradient().setRadialY(-100);
          * series.getCircleGradient().setVisible(true);
          * series.getCirclePen().setColor(Color.NAVY);
          * series.getCirclePen().setStyle(DashStyle::$DOT);
          * series.getCirclePen().setWidth(2);
          * </font></pre></p>
          *
          * @return Gradient
          */
    public function getCircleGradient() {
        if ($this->circleGradient == null) {
            $this->circleGradient = new TeeGradient($this->chart);
        }
        return $this->circleGradient;
    }

    /**
          * The CirleSeries as elliptical or circular.<br>
          * Default value: false
          *
          * @return boolean
          */
    public function getCircled() {
        return $this->circled;
    }

    /**
          * Sets CirleSeries as elliptical or circular.<br>
          * Default value: false
          *
          * @param value boolean
          */
    public function setCircled($value) {
        $this->circled = $this->setBooleanProperty($this->circled, $value);
    }

    /**
          * The ellipse's horizontal radius in pixels.<br>
          * Default value: 0
          *
          * @return int
          */
    public function getCustomXRadius() {
        return $this->customXRadius;
    }

    /**
          * Sets ellipse's horizontal radius in pixels.<br>
          * Default value: 0
          *
          * @param value int
          */
    public function setCustomXRadius($value) {
        $this->customXRadius = $this->setIntegerProperty($this->customXRadius, $value);
    }

    /**
          * The ellipse's vertical radius in pixels.<br>
          * Default value: 0
          *
          * @return int
          */
    public function getCustomYRadius() {
        return $this->customYRadius;
    }

    /**
          * Sets ellipse's vertical radius in pixels.<br>
          * Default value: 0
          *
          * @param value int
          */
    public function setCustomYRadius($value) {
        $this->customYRadius = $this->setIntegerProperty($this->customYRadius, $value);
    }
}
?>
