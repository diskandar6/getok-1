<?php
 /**
 * Description:  This file contains the following class:<br>
 * ImageMode class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
 /**
 * ImageMode class
 *
 * Description: Displays characteristics for an Image
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

final class ImageMode {
    /**
     * Display unmodfied
     */
    public static $NORMAL = 0;
    /**
     * Stretch to bounding area dimensions
     */
    public static $STRETCH = 1;
    /**
     * Repeat Tile small image over larger bounding area
     */
    public static $TILE = 2;
    /**
     * Place unmodified image at Center of bounding area
     */
    public static $CENTER = 3;

    function __construct() {
    }
}
?>