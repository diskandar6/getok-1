<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: LegendAlignment class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */
/**
 * LegendAlignment class
 *
 * Description: Describes the possible values of Legend.Alignment
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */


class LegendAlignment
{
   /**
   * Aligns the legend to the left of the TChart.
   */
   public static $LEFT = 0;

   /**
   * Aligns the legend to the right of the TChart.
   */
   public static $RIGHT = 1;

   /**
   * Aligns the legend to the top of the TChart.
   */
   public static $TOP = 2;

   /**
   * Aligns the legend to the bottom of the TChart.
   */
   public static $BOTTOM = 3;

   public function __construct()  {}
}
?>