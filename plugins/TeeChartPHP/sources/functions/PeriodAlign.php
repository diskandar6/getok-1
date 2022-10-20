<?php
  /**
 * Description:  This file contains the following class:<br>
 * PeriodAlign class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
*
* <p>Title: PeriodAlign class</p>
*
* <p>Description: Descibes how a function is aligned with respect to the
* source series.</p>
*
*  @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
*/
class PeriodAlign
{
   /**
   * Aligns the function with the first point of the function period.
   */
   public static $FIRST = 0;
   /**
   * Aligns the function with the centre point of the function period.
   */
   public static $CENTER = 1;
   /**
   * Aligns the function with the last point of the function period.
   */
   public static $LAST = 2;

   public function __construct()   {}
}
?>