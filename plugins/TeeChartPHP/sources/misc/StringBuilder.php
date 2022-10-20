<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: StringBuilder class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */
/**
 * StringBuilder class
 *
 * Description: string utility procedures
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */

 class StringBuilder {

    private $text = "";

    public function __construct($value=null) {
        $this->text = $value;
    }

    public function append($value) {
        $this->text = $this->text . $value;
    }

    public function addLine($value) {
        $this->text = $this->text . $value. "\r\n";
    }

    public function toString() {
        return $this->text;
    }

    public function length() {
        return strlen($this->text);
    }

    public function delete($start, $end) {
        $this->text =  substr($this->text, 0, $start) .
               substr($this->text,$start + $end, strlen($this->text)-($end-$start));
    }
}
?>
