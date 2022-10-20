<?php
  /**
 * Description:  This file contains the following class:<br>
 * AxisLinePen class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * AxisLinePen class
 *
 * Description: Determines the pen used to draw the axis lines
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

class AxisLinePen extends ChartPen
{
   /**
   * The class constructor.
   */
   public function __construct($c)
   {
      $tmpColor = new Color(0, 0, 0);
      parent::__construct($c, $tmpColor, true, 2);
      
      unset($tmpColor);
   }
   
    public function __destruct() {        
        parent::__destruct();   
    }         
}
?>
