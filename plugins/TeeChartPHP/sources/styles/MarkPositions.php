<?php
 /**
 * Description:  This file contains the following class:<br>
 * MarkPositions class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * MarkPositions class
 *
 * Description: Series Marks Positions
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class MarkPositions extends ArrayObject
{

   public function getPosition($index)
   {
      return($index < sizeof($this)) ? $this->offsetget($index) : null;
   }

   public function setPosition($index, $value)
   {
      $this->offsetset($index, $value);
   }

   public function removeRange($startIndex, $count)
   {
      parent::removeRange($startIndex, $startIndex + $count - 1);
   }

   /**
   * Checks for Custom Marks.
   *
   * @return boolean true if Custom exists
   */
   public function existCustom()
   {
      for($t = 0; $t < sizeof($this); $t++)
      {
         $m = $this->getPosition($t);
         if(($m != null) && $m->custom)
         {
            return true;
         }
      }
      return false;
   }

   public function clear()
   {
      
   }
}
?>
