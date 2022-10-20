<?php
 /**
 * Description:  This file contains the following class:<br>
 * BevelStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
 /**
 * BevelStyle class
 *
 * Description: Defines the styles of the bevels (frames) around rectangles
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

final class BevelStyle
{
   /**
   * No bevel.
   */
   public static $NONE = 0;
   /**
   * Lowered Bevel.
   */
   public static $LOWERED = 1;
   /**
   * Raised bevel.
   */
   public static $RAISED = 2;

   public function __construct()  {}

   static public function fromValue($value)
   {
      switch($value)
      {
         case 0:
            return self::$NONE;
         case 1:
            return self::$LOWERED;
         default:
            return self::$RAISED;
      }
   }
}
?>