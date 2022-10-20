<?php
 /**
 * Description:  This file contains the following class:<br>
 * FloatRange class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * FloatRange class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class FloatRange {

    public $min;
    public $max;

    public function __construct($min=0, $max=0) {
        $this->min = $min;
        $this->max = $max;
    }
    
    function __destruct()
    {
        unset($this->min);
        unset($this->max);
    }    
}
?>