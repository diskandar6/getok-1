<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: LegendTextStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */
/**
 * LegendTextStyle class
 *
 * Description: Describes the possible values of the Legend.TextStyle
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */

class LegendTextStyle
{

   /**
   * Legend Text is defined as the series point labels.
   */
   public static $PLAIN = 0;
   /**
   * Legend Text is defined as the series values on the left of the series
   * point labels.
   */
   public static $LEFTVALUE = 1;
   /**
   * Legend Text is defined as the series values on the right of the series
   * point labels.
   */
   public static $RIGHTVALUE = 2;
   /**
   * Legend Text is defined as the series values as a percentage of the total
   * of series values on the left of the series point labels.
   */
   public static $LEFTPERCENT = 3;
   /**
   * Legend Text is defined as the series values as a percentage of the total
   * of series values on the right of the series point labels.
   */
   public static $RIGHTPERCENT = 4;
   /**
   * Legend Text is defined as the xvalues of the series.
   */
   public static $XVALUE = 5;
   /**
   * Legend Text is defined as the series value.
   */
   public static $VALUE = 6;
   /**
   * Legend Text is defined as the series values as a percentage of the total
   * of series values
   */
   public static $PERCENT = 7;
   /**
   * Legend Text is defined as xvalues of the series and the series values.
   */
   public static $XANDVALUE = 8;
   /**
   * Legend Text is defined as xvalues of the series and the series values as
   * a percentage of the total of series values.
   */
   public static $XANDPERCENT = 9;


   public function __construct()   {}

   public function fromValue($value)
   {
      switch($value)
      {
         case 0:
            return self::$PLAIN;
         case 1:
            return self::$LEFTVALUE;
         case 2:
            return self::$RIGHTVALUE;
         case 3:
            return self::$LEFTPERCENT;
         case 4:
            return self::$RIGHTPERCENT;
         case 5:
            return self::$XVALUE;
         case 6:
            return self::$VALUE;
         case 7:
            return self::$PERCENT;
         case 8:
            return self::$XANDVALUE;
         case 9:
            return self::$XANDPERCENT;
         default:
            return self::$LEFTVALUE;
      }
   }
}
?>