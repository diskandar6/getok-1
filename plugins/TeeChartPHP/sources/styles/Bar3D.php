<?php
 /**
 * Description:  This file contains the following class:<br>
 * Bar3D class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: Bar3D class</p>
  *
  * <p>Description: Bar3D series.</p>
  *
  * <p>Example:
  * <pre><font face="Courier" size="4">
  * series1 = new Bar3D(myChart.getChart());
  * series1.add( 0, 250, 200, "A", Color.RED );
  * series1.add( 1,  10, 200, "B", Color.GREEN );
  * series1.add( 2,  90, 100, "C", Color.YELLOW );
  * series1.add( 3,  30,  50, "D", Color.BLUE );
  * series1.add( 4,  70, 150, "E", Color.WHITE );
  * series1.add( 5, 120, 150, "F", Color.SILVER );
  * series1.setColorEach(true);
  * series1.getMarks().setArrowLength(20);
  * series1.getMarks().setVisible(true);
  * series1.setBarStyle(BarStyle.RECTGRADIENT);
  * series1.setBarWidthPercent(90);
  * series1.getGradient().setDirection(GradientDirection.HORIZONTAL);
  * series1.getGradient().setStartColor(Color.YELLOW);
  * </font></pre></p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Bar3D extends Bar {

    private $offsetValues;

    public function __construct($c=null) {
        parent::__construct($c);

        $this->offsetValues = new ValueList($this, "ValuesOffset");
                                                /* TODO $this->Language->getString("ValuesOffset")*/
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->offsetValues);
    }    
       
    protected function addSampleValues($numValues) {
        $r = $this->randomBounds($numValues);

        for ($t = 1; $t <= $numValues; $t++) {
            $r->tmpY = $r->DifY * $r->Random();
            $this->addBar($r->tmpX, 10 + abs($r->tmpY),
                   abs($r->DifY / (1 + 5 * $r->Random())));
            $r->tmpX += $r->StepX;
        }
    }

    /**
    * Adds a bar with an X and Y value, Y start point and color.
    *
    * @param double $x
    * @param double $y
    * @param double $offset
    * @param Color $color
    * @return int
    */
/*    public function add($x, $y, $offset, $color) {
        return $this->add($x, $y, $offset, "", $color);
    }
*/
    /**
      * Adds a bar with an X and Y value and Y start point.
      *
      * @param x double
      * @param y double
      * @param offset double
      * @return int
      */
/*    public function add($x, $y, $offset) {
        $tmpColor = new Color();
        return $this->add($x, $y, $offset, "", $tmpColor->EMPTY);
    }
*/
    /**
      * Adds a bar with an X and Y value with offset and label.
      *
      * @param x double
      * @param y double
      * @param offset double
      * @param text String
      * @return int
      */
/*    public function add($x, $y, $offset, $text) {
        $tmpColor = new Color();
        return $this->add($x, $y, $offset, $text, $tmpColor->EMPTY);
    }
*/
    /**
    * Adds a bar with an X and Y value, Y start point, label and color.
    *
    * @param double $x
    * @param double $y
    * @param double $offset
    * @param String $text
    * @param Color $color
    * @return int
    */
    public function addBar($x, $y, $offset, $text="", $color=null) {
        if ($color==null)
           $color = new Color(0,0,0,127,true);  // EMPTY

        $this->offsetValues->tempValue = $offset;
        return $this->addXYTextColor($x, $y, $text, $color);
    }

    public function getOriginValue($valueIndex) {
        return parent::getOriginValue($valueIndex) + $this->offsetValues->value[$valueIndex];
    }

    /**
    * Returns the Maximum Value of the Series Y Values List.
    *
    * @return double
    */
    public function getMaxYValue() {
        $result = parent::getMaxYValue();
        if (($this->iMultiBar == MultiBars::$NONE) || ($this->iMultiBar == MultiBars::$SIDE)) {
            $result = max($result, $this->offsetValues->getMaximum());
        }
        return $result;
    }

    /**
    * Returns the Minimum Value of the Series Y Values List.
    *
    * @return double
    */
    public function getMinYValue() {
        $result = parent::getMinYValue();
        if (($this->iMultiBar == MultiBars::$NONE) || ($this->iMultiBar == MultiBars::$SIDE)) {
            for ($t = 0; $t < $this->getCount(); $t++) {
                if ($this->offsetValues->value[$t] < 0) {
                    $result = min($result, $this->vyValues->value[$t] + $this->offsetValues->value[$t]);
                }
            }
        }
        return $result;
    }

    /**
    * Returns the corresponding screen pixels coordinate of the leftmost
    * horizontal bar edge.
    * The UseOrigin property must be true (the default) to use the Origin
    * method.
    * Bars with a value bigger than Origin are drawn in one direction and
    * Bars with a lower value are drawn in the opposite direction.
    * This applies both to Bar series and HorizBar series classes.
    * Default Value: 0
    *
    * @param int $valueIndex
    * @param boolean $sumAll
    * @return double
    */
    public function pointOrigin($valueIndex, $sumAll) {
        return $this->offsetValues->value[$valueIndex];
    }

    /**
    * Specifies a different origin value for each bar point.
    * This can be used with standard Bar series components to make a
    * "Stacked-3D" chart type.
    *
    * @return ValueList
    */
    public function getOffsetValues() {
        return $this->offsetValues;
    }

    /**
    * Specifies a different origin value for each bar point.
    * This can be used with standard Bar series components to make a
    * "Stacked-3D" chart type.
    *
    * @param ValueList $value
    */
    public function setOffsetValues($value) {
        $this->setValueList($this->offsetValues, $value);
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("GalleryBar3D");
    }

    protected function subGalleryStack() {
        return false; // 5.01      at sub-gallery
    }
}

?>
