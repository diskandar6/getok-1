<?php
 /**
 * Description:  This file contains the following class:<br>
 * PieOtherStyles class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 *
 * <p>Title: PieOtherStyles class</p>
 *
 * <p>Description: Describes the possible values of the Style method of
 * Pie.PieOtherSlice class.</p>
 *
 * @see com.steema.teechart.styles.Pie.PieOtherSlice
 * 
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */


class PieOtherStyles
{
   /**
   * No "Other" slice is generated. (default)
   */
   public static $NONE = 0;
   /**
   * Slices with values below a percentage are grouped.
   */
   public static $BELOWPERCENT = 1;
   /**
   * Slices with values below a value are grouped.
   */
   public static $BELOWVALUE = 2;

   function __construct() {}
}
?>