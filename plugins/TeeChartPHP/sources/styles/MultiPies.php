<?php
 /**
 * Description:  This file contains the following class:<br>
 * MultiPies class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 * <p>Title: MultiPies - enum constants</p>
 *
 * <p>Description: </p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class MultiPies
{
   /**
   * Multiple Pie series are displayed using an automatically
   * calculated chart space portion. (default)
   */
   public static $AUTOMATIC = 0;
   /**
   * Multiple Pie series are displayed using custom manual ChartRect
   * positions, or overlapped.
   */
   public static $DISABLED = 1;

   function __construct() {}
}
?>