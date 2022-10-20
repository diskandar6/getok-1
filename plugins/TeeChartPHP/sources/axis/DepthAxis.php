<?php
  /**
 * Description:  This file contains the following class:<br>
 * DepthAxis class <br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * DepthAxis class
 *
 * Description: Z plane Axis characteristics.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0                    Steema Software SL.
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

 class DepthAxis extends Axis {

    /**
    * The class constructor.
    */
    public function __construct($horiz, $isOtherSide, $c) {
        parent::__construct($horiz, $isOtherSide, $c);

        $this->isDepthAxis = true;
        $this->bVisible = false;
    }
    
    public function __destruct() {        
        parent::__destruct();   
    }          
}

?>