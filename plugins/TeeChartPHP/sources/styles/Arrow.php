<?php
 /**
 * Description:  This file contains the following class:<br>
 * Arrow class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Arrow class
 *
 * Description: Arrow Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */  
 class Arrow extends Points {

    private $endXValues;
    private $endYValues;

    public function __construct($c=null) {
        parent::__construct($c);

        $this->calcVisiblePoints = false;
        $this->endXValues = new ValueList($this, Language::getString("ValuesArrowEndX"));
        $this->endYValues = new ValueList($this, Language::getString("ValuesArrowEndY"));
        $this->point->setInflateMargins(false);
        $this->getMarks()->getPen()->setVisible( false);
        $this->getMarks()->setTransparent(true);
    }
    
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->endXValues);
        unset($this->endYValues);
   }       

    /**
      * Determines the vertical arrow head size in pixels.<br>
      * It sets the distance from the base of the arrow head to the arrow tip
      * in pixels. It can be used together with ArrowWidth to determine the
      * overall size of the arrow head.
      *
      * @return int
      */
    public function getArrowHeight() {
        return $this->point->getVertSize();
    }

    /**
      * Sets the vertical arrow head size in pixels.<br>
      *
      * @see #getArrowHeight
      * @param value int
      */
    public function setArrowHeight($value) {
        $this->point->setVertSize($value);
    }

    /**
      * Determines the horizontal arrow head size in pixels. <br>
      * Default value: 4
      *
      * @return int
      */
    public function getArrowWidth() {
        return $this->point->getHorizSize();
    }

    /**
      * Sets the horizontal arrow head size in pixels. <br>
      * Default value: 4
      *
      * @param value int
      */
    public function setArrowWidth($value) {
        $this->point->setHorizSize($value);
    }

    /**
      * The X0 values for Arrows. <br>
      * Each Arrow has (X0,Y0) and (X1,Y1) coordinates. <br>
      * StartXValues.DateTime property default value is true.
      *
      * @return ValueList
      */
    public function getStartXValues() {
        return $this->vxValues;
    }

    /**
      * Sets X0 values for Arrows. <br>
      *
      * @param value ValueList
      */
    public function setStartXValues($value) {
        $this->setValueList($this->vxValues, $value);
    }

    /**
      * The Y0 values for Arrows.<br>
      * Each Arrow has (X0,Y0) and (X1,Y1) coordinates. <br>
      *
      * @return ValueList
      */
    public function getStartYValues() {
        return $this->vyValues;
    }

    /**
      * Sets Y0 values for Arrows.<br>
      *
      * @param value ValueList
      */
    public function setStartYValues($value) {
        $this->setValueList($this->vyValues, $value);
    }

    /**
      * The X1 values for Arrows.<br>
      * Each Arrow has (X0,Y0) and (X1,Y1) coordinates. <br>
      *
      * @return ValueList
      */
    public function getEndXValues() {
        return $this->endXValues;
    }

    /**
      * Sets X1 values for Arrows.<br>
      *
      * @param value ValueList
      */
    public function setEndXValues($value) {
        $this->setValueList($this->endXValues, $value);
    }

    /**
      * The Y1 values for Arrows.<br>
      * Each Arrow has (X0,Y0) and (X1,Y1) coordinates. <br><br>
      *
      * @return ValueList
      */
    public function getEndYValues() {
        return $this->endYValues;
    }

    /**
      * Sets Y1 values for Arrows.<br>
      *
      * @param value ValueList
      */
    public function setEndYValues($value) {
        $this->setValueList($this->endYValues, $value);
    }

    /**
      * Adds an Arrow with start and end coordinates.<br>
      * Returns the position of the Arrow in the list.<br>
      * Positions start at zero. <br><br>
      * Each arrow is made of 2 points: <br>
      * (X0,Y0)   The starting arrow point. <br>
      * (X1,Y1)   The arrow head end point. <br>
      *
      * @param x0 double arrow start x coordinate
      * @param y0 double arrow start y coordinate
      * @param x1 double arrow end x coordinate
      * @param y1 double arrow end y coordinate
      * @return int
      */
    public function _add($x0, $y0, $x1, $y1) {
        $tmpColor = new Color();
        return $this->addArrow($x0, $y0, $x1, $y1, "", $tmpColor->getEmpty());
        
        unset($tmpColor);
    }

    /**
      * Adds an Arrow with start and end coordinates and label.<br>
      * Returns the position of the Arrow in the list.<br>
      * Positions start at zero. <br><br>
      * Each arrow is made of 2 points: <br>
      * (X0,Y0)   The starting arrow point. <br>
      * (X1,Y1)   The arrow head end point. <br>
      * Label (overload option) <br>
      *
      * @param x0 double arrow start x coordinate
      * @param y0 double arrow start y coordinate
      * @param x1 double arrow end x coordinate
      * @param y1 double arrow end y coordinate
      * @param text String label text
      * @return int
      */
    public function __add($x0, $y0, $x1, $y1, $text) {
        $tmpColor = new Color();
        return $this->addArrow($x0, $y0, $x1, $y1, $text, $tmpColor->getEmpty());
        
        unset($tmpColor);
    }

    /**
      * Returns the position of the Arrow in the list.<br>
      * Positions start at zero. <br><br>
      * Each arrow is made of 2 points: <br>
      * (X0,Y0)   The starting arrow point. <br>
      * (X1,Y1)   The arrow head end point. <br>
      * Color (overload option) <br>
      *
      * @param x0 double arrow start x coordinate
      * @param y0 double arrow start y coordinate
      * @param x1 double arrow end x coordinate
      * @param y1 double arrow end y coordinate
      * @param color Color arrow color
      * @return int
      */
    public function ___add($x0, $y0, $x1, $y1, $color) {
        return $this->addArrow($x0, $y0, $x1, $y1, "", $color);
    }

    /**
      * Returns the position of the Arrow in the list.<br>
      * Positions start at zero. <br><br>
      * Each arrow is made of 2 points: <br>
      * (X0,Y0)   The starting arrow point. <br>
      * (X1,Y1)   The arrow head end point. <br>
      * Label (overload option) <br>
      * Color (overload option) <br>
      *
      * @param x0 double arrow start x coordinate
      * @param y0 double arrow start y coordinate
      * @param x1 double arrow end x coordinate
      * @param y1 double arrow end y coordinate
      * @param text String label text
      * @param color Color arrow color
      * @return int
      */
    public function AddArrow($x0, $y0, $x1, $y1, $text, $color) {
        $this->endXValues->tempValue = $x1;
        $this->endYValues->tempValue = $y1;
        return parent::add($x0, $y0, $text, $color);
    }

    protected function addSampleValues($numValues) {
         $r = $this->randomBounds($numValues);

         $tmpDifY = MathUtils::round($r->DifY);
         $tmpDifX = MathUtils::round($r->StepX * $numValues);

        for ( $t = 1; $t <= $numValues; $t++) {
            $tmpX0 = $r->tmpX + $tmpDifX * $r->Random();
            $tmpY0 = $r->MinY + $tmpDifY * $r->Random();
            $this->_add($tmpX0, $tmpY0, $tmpX0 + $tmpDifX * $r->Random(),
                $tmpY0 + $tmpDifY * $r->Random());
        }
    }

    public function clicked($x, $y) {
         $p = new TeePoint($x, $y);

        for ( $t = 0; $t < $this->getCount(); $t++) {
            /*ArrowPoints*/ $arrow=$this->getArrowPoints($t);

            if (MathUtils::pointInLineTolerance($p, $arrow->p0->X, $arrow->p0->Y, $arrow->p1->X ,$arrow->p1->Y,
                                     $this->getPointer()->getPen()->getWidth())) {
                return $t;
            }
        }

        return -1;
    }

    /**
      * The Maximum Value of the Series X Values List.
      *
      * @return double
      */
    public function getMaxXValue() {
        return max(parent::getMaxXValue(), $this->endXValues->getMaximum());
    }

    /**
      * The Minimum Value of the Series X Values List.
      *
      * @return double
      */
    public function getMinXValue() {
        return min(parent::getMinXValue(), $this->endXValues->getMinimum());
    }

    /**
      * The Maximum Value of the Series Y Values List.
      * @return double
      */
    public function getMaxYValue() {
        return max(parent::getMaxYValue(), $this->endYValues->getMaximum());
    }

    /**
      * The Minimum Value of the Series Y Values List.
      *
      * @return double
      */
    public function getMinYValue() {
        return min(parent::getMinYValue(), $this->endYValues->getMinimum());
    }

    private function getArrowPoints($valueIndex)
    {
            $result=new ArrowPoints();
            $result->p0= new TeePoint($this->calcXPos($valueIndex), $this->calcYPos($valueIndex));
            $result->p1 = new TeePoint($this->calcXPosValue($this->endXValues->value[$valueIndex]),
                $this->calcYPosValue($this->endYValues->value[$valueIndex]));
            return $result;
    }

    /**
      * Called internally. Draws the "ValueIndex" point of the Series.<br>
      *
      * @param valueIndex int
      */
    public function drawValue($valueIndex) {
         $arrow=$this->getArrowPoints($valueIndex);

         $tmpColor = $this->getValueColor($valueIndex);
         $g = $this->chart->getGraphics3D();

        if ($this->chart->getAspect()->getView3D()) {
            $this->getPointer()->prepareCanvas($g, $tmpColor);
        } else {
            $g->setPen($this->getPointer()->getPen());
            $g->getPen()->setColor( $tmpColor);
        }

        $g->arrow($this->chart->getAspect()->getView3D(), $arrow->p0, $arrow->p1, $this->getPointer()->getHorizSize(),
                $this->getPointer()->getVertSize(), $this->getMiddleZ());
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return Language::getString("GalleryArrow");
    }
}

 /**
 * Description:  This file contains the following class:<br>
 * ArrowPoint class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * ArrowPoint class
 *
 * Description: ArrowPoint characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
class ArrowPoints {
    
  public $p0;  // Point  
  public $p1;  // Point
  
}
?>
