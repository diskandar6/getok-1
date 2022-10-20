<?php
 /**
 * Description:  This file contains the following class:<br>
 * StringAlignment class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * StringAlignment class
 *
 * Description: String alignment options
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

final class StringAlignment {

    public static $NEAR = 1000; //30;
    public static $CENTER = 2000; //40;
    public static $FAR = 3000; //50;

    public static $HORIZONTAL_LEFT_ALIGN = 1;
    public static $HORIZONTAL_CENTER_ALIGN = 2;
    public static $HORIZONTAL_RIGHT_ALIGN = 4;
    public static $VERTICAL_TOP_ALIGN = 8;
    public static $VERTICAL_CENTER_ALIGN = 16;
    public static $VERTICAL_BOTTOM_ALIGN = 32;


    function __construct() {
    }

    public function fromValue($v) {
        switch ($v) {
        case 0:
            return self::$NEAR;
        case 1:
            return self::$CENTER;
        default:
            return self::$FAR;
        }
    }
}
?>