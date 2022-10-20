<?php

 /**
 * Description:  This file contains the following class:<br>
 * Title: StringFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 *//**
 * StringFormat class
 *
 * Description: string format utility procedures
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */

 class StringFormat {

    public $alignment;

/*    public function format($format, $prefix, $value, $valueFormat) {
        /** @todo FINISH !
        return $prefix + " " + $this->Double->toString($value);
    }
*/
    public function format2($format, $value1, $value2) {
        return $format + " " + $this->Double->toString($value1) + " " +
                $this->Double->toString($value2);
    }

/*    public function format2($format, $value1, $value2) {
        $this->Object[] $this->obj = {$this->Integer->toString($value1), $this->Integer->toString($value2)};
        return $format($format, $this->obj);
    }

    public function format($formatStr, $value) {
        $this->Object[] $this->args = {$value};
        return $this->java->text->MessageFormat->format($formatStr, $this->args);
    }

    public function format($formatStr, $args) {
        return $this->java->text->MessageFormat->format($formatStr, $args);
    }
*/
    public static function split($in, $ch ){
        $tmp= Array();

        $pos=false;

        do {
            $pos = strpos($in,$ch);

            if ($pos != false) {
                $s = substr($in,0,$pos);
                $tmp[]=$s;
                $in = substr($in,0,$pos+1);
            }
        } while ($pos != false);

            if (strlen($in) > 0) {
                $tmp[]=$in;
            }

        //$result = new String[$this->tmp->size()];
        return /*str_split(*/$tmp/*)*/;
    }
}
?>