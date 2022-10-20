<?php
 /**
 * Description:  This file contains the following class:<br>
 * MultiBars class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
*
* <p>Title: MultiBars class</p>
*
* <p>Description: Describes the possible values of CustomBar.MultiBar.</p>
*
* <p>Example:
* <pre><font face="Courier" size="4">
* $bar1Series->setMultiBar(MultiBars::$SIDEALL);
*  or
* $barSeries->setMultiBar(MultiBars::$SELFSTACK);
* </font></pre></p>
*
* @see com.steema.teechart.styles.CustomBar#getMultiBar
* 
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class MultiBars
{
   /**
   * Bar series are placed one behind the other.
   */
   public static $NONE = 0;
   /**
   * Bar series points are placed one beside the other.
   */
   public static $SIDE = 1;
   /**
   * Bar series are placed one on top of the other.
   */
   public static $STACKED = 2;
   /**
   * Bar series are placed one on top of the other against a common axis
   * scale 0..100.
   */
   public static $STACKED100 = 3;
   /**
   * Bar series, that is, all series points, are drawn one beside the other.
   */
   public static $SIDEALL = 4;
   /**
   * The points of each bar series are drawn one on top of the other.
   */
   public static $SELFSTACK = 5;

   public function __construct()   {}
}
?>