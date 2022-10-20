<?php
 /**
 * Description:  This file contains the following class:<br>
 * HorizontalAxis class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 *
 * <p>Title: HorizontalAxis class</p>
 *
 * <p>Description: Describes the possible values of Series.HorizAxis.</p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class HorizontalAxis
{
   /**
   * Associates the series with the top axis.
   */
   public static $TOP = 0;
   /**
   * Associates the series with the bottom axis.
   */
   public static $BOTTOM = 1;
   /**
   * Associates the series with both the top and bottom axes.
   */
   public static $BOTH = 2;
   /**
   * Associates the series with a custom axis.
   */
   public static $CUSTOM = 3;

   public function __construct()    { }

   public function fromInt($value)
   {
      switch($value)
      {
         case 0:
            return self::$TOP;
         case 1:
            return self::$BOTTOM;
         case 2:
            return self::$BOTH;
         default:
            return self::$CUSTOM;
      }
   }
}
?>