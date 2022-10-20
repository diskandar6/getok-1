<?php
 /**
 * Description:  This file contains the following class:<br>
 * SeriesRandom class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
* <p>Title: SeriesRandom class</p>
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
class SeriesRandom
{
   public $tmpX;
   public $StepX;
   public $tmpY;
   public $MinY;
   public $DifY;

   public function Random()  {
      return (rand()%100);
   }

   public function __construct()   {}
}
?>
