<?php

 /**
 * Description:  This file contains the following class:<br>
 * CustomStack class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
*
* <p>Title: CustomStack class</p>
*
* <p>Description: Describes the possible values of CustomPoint.Stacked</p>
*
* <p>Example:
* <pre><font face="Courier" size="4">
* $lineSeries->setStacked( CustomStack::$OVERLAP );
* </font></pre></p>
* 
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
*/
class CustomStack
{
   /**
   * Series will be drawn one behind the other using different "z" depths.
   */
   public static $NONE = 0;
   /**
   * Series will be drawn one over the other using the same "z" depth.
   */
   public static $OVERLAP = 1;
   /**
   * Draws each series on top of the previous one by summing the values.
   */
   public static $STACK = 2;
   /**
   * Adjusts each individual series to a common 0..100 axis scale.
   */
   public static $STACK100 = 3;

   public function __construct() {}

   public function fromInt($value)
   {
      switch ($value)
      {
         case 0:
            return self::$NONE;
         case 1:
            return self::$OVERLAP;
         case 2:
            return self::$STACK;
         default :
            return self::$STACK100;
      }
   }
}

?>