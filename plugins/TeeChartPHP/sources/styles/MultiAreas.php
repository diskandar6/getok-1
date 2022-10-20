<?php

 /**
 * Description:  This file contains the following class:<br>
 * MultiAreas class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: MultiAreas class</p>
 *
 * <p>Description: Describes the possible values of Area.MultiArea.</p>
 * @see com.steema.teechart.styles.Area#getMultiArea
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class MultiAreas {
    /**
    * Areas will be drawn one behind the other.
    */
    public static $NONE = 0;
    /**
    * Draws each Area on top of previous one.
    */
    public static $STACKED = 1;
    /**
    * Adjusts each individual point to a common 0..100 axis scale.
    */
    public static $STACKED100 = 2;

    private function __construct() {}
}
?>