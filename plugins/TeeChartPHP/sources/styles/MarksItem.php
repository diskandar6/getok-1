<?php
 /**
 * Description:  This file contains the following class:<br>
 * MarksItem class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * MarksItem class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class MarksItem extends TextShape
{
   public $MARKCOLOR = null;

   public function __construct($c = null)
   {
      $this->MARKCOLOR = new Color(255, 255, 200);//LIGHT_YELLOW
      parent::__construct($c);

      $this->setColor($this->MARKCOLOR);
      unset($this->MARKCOLOR);
   }
}
?>