<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: LegendStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */
/**
 * LegendStyle class
 *
 * Description: Describes the possible values of Legend::$LegendStyle
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */

class LegendStyle
{
   /**
   * Legend draws Series Titles if there's more than one Series in the chart.
   */
   public static $AUTO = 0;
   /**
   * Legend draws the Series Titles even if there's only one Series in the
   * chart.
   */
   public static $SERIES = 1;
   /**
   * Legend draws the first Active Series' values.
   */
   public static $VALUES = 2;
   /**
   * Legend draws the Last Value of each Active Series (similar to Series).
   */
   public static $LASTVALUES = 3;
   /*
   * Legend draws a number of the Palette entries defined by Legend.MaxNumRows.
   */
   public static $PALETTE = 4;

   public function __construct()
   {
   }

   public function fromValue($value)
   {
      switch($value)
      {
         case 0:
            return self::$AUTO;
         case 1:
            return self::$SERIES;
         case 2:
            return self::$VALUES;
         case 3:
            return self::$LASTVALUES;
         case 4:
            return self::$PALETTE;
         default:
            return self::$AUTO;
      }
   }
}

?>