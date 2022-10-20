<?php
 /**
 * Description:  This file contains the following class:<br>
 * PieAngle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
  * <p>Title: PieAngle class</p>
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

 class PieAngle {

    public $StartAngle;
    public $EndAngle;
    public $MidAngle;

    public function contains($value) {
        return ($value>=$this->StartAngle) && ($value<=$this->EndAngle);
    }
 }

?>