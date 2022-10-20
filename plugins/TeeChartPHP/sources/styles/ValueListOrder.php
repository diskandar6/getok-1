<?php
 /**
 * Description:  This file contains the following class:<br>
 * ValueListOrder class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * ValueListOrder class
 *
 * Description: Describes the possible values of the ValueList.Order
 * method
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class ValueListOrder
{
   /**
   * Values are ordered in the order in which they were added to the
   * ValueList.
   */
   public static $NONE = 0;
   /**
   * Values are ordered in ascending numerical order.
   */
   public static $ASCENDING = 1;
   /**
   * Values are ordered in descending numerical order.
   */
   public static $DESCENDING = 2;

   public function __construct() {}
}

?>