<?php
 /**
 * Description:  This file contains the following class:<br>
 * ShapeXYStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 *
 * <p>Title: ShapeXYStyle class</p>
 *
 * <p>Description: Describes the possible values of the Shape.XYStyle
 * method.</p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class ShapeXYStyle
{
   /**
   * Position relative to Chart Panel. 0,0 is Panel Left, Top.
   */
   public static $PIXELS = 0;
   /**
   * Position in Axis units.
   */
   public static $AXIS = 1;
   /**
   * Use Left,Top (X0,Y0) to set the Axis origin in Axis units. Right,
   * Bottom sets width and height in Pixels.
   */
   public static $AXISORIGIN = 2;

   public function __construct() {}
}
?>