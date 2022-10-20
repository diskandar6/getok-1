<?php
  /**
 * Description:  This file contains the following class:<br>
 * GradientDirection class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * GradientDirection class
 *
 * Description: Describes the possible values of Gradient Direction.
 * 
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
 
final class GradientDirection {

    private static $upperBound=0;
    private static $values = Array();

    public static $VERTICAL = 0;
    public static $HORIZONTAL = 1;
    public static $ELLIPSE = 2;
    public static $ELLIPSE2 = 3;
    public static $CIRCLE = 4;
    public static $CIRCLE2 = 5;
    public static $SQUARE = 6;
    public static $RECTANGLE = 7;
    public static $DIAMOND = 8;
    // TODO public static $FORWARDDIAGONAL = 2;
    // TODO public static $BACKDIAGONAL = 3;
    // TODO public static $RADIAL = 4;

    public function __construct() {
        /*super(upperBound++);
        values.add(this);*/
    }

    public static function size() { return $this->upperBound; }

    /*public static atIndex($index) {
        return (GradientDirection)values.get(index);
    }*/
}

?>