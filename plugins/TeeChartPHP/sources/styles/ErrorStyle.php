<?php
  /**
 * Description:  Describes the possible values of the CustomError::ErrorStyle.<br>
 * ErrorStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * CustomBar Class
 *
 * Description: Error Style
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 
class ErrorStyle {
    /**
     * 
     */
    private static $serialVersionUID = 1;
    /**
     * Crossbar of 'T' error displacement indicator displayed on the left.
     */
    public static $LEFT = 0;
    /**
     * Crossbar of 'T' error displacement indicator displayed on the right.
     */
    public static $RIGHT = 1;
    /**
     * Crossbar of 'T' error displacement indicator displayed on the left and
     * right.
     */
    public static $LEFTRIGHT = 2;
    /**
     * Crossbar of 'T' error displacement indicator displayed on the top.
     */
    public static $TOP = 3;
    /**
     * Crossbar of 'T' error displacement indicator displayed on the bottom.
     */
    public static $BOTTOM = 4;
    /**
     * Crossbar of 'T' error displacement indicator displayed on the top and
     * bottom.
     */
    public static $TOPBOTTOM = 5;

    function __construct() {        
    }
}
?>
