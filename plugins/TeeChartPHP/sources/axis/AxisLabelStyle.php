<?php
 /**
 * Description:  This file contains the following class:<br>
 * AxisLabelStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * AxisLabelStyle class
 *
 * Description: Defines the possible values of Axis->getLabels()->getStyle()
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

class AxisLabelStyle
{

   /**
   * Chooses the Style automatically
   */
   public static $AUTO = 0;

   /**
   * No label. This will trigger the event with empty strings
   */
   public static $NONE = 1;

   /**
   * Axis labeling is based on axis Minimum and Maximum properties.
   */
   public static $VALUE = 2;

   /**
   * Each Series point will have a Label using SeriesMarks style.
   */
   public static $MARK = 3;

   /**
   * Each Series point will have a Label using Series.XLabels strings
   */
   public static $TEXT = 4;

   public function __construct()
   {}

   public function fromValue($value)
   {
      switch ($value)
      {
         case 0:
            return self::$AUTO;
         case 1:
            return self::$NONE;
         case 2:
            return self::$VALUE;
         case 3:
            return self::$MARK;
         default :
            return self::$TEXT;
      }
   }
}
?>