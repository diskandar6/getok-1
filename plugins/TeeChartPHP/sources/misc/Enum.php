<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: Enum class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: Enum class</p>
 *
 * <p>Description: </p>
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */

  class Enum {

    public $name='';
    public $value;

    protected function _Enum($value) {
        $this();
        $this->value = $value;
    }

    function Enum() {
    }

    protected function readResolve()  {
        return getClass()->getField(name)->get(null);
    }

    public function getValue() {
        return $value;
    }

    private function readObject($in)  {
        $this->name = (string) $in->readObject();
    }

    private function writeObject($out)  {
        $out->writeObject(getName());
    }

    private function  getName() {
        return "";
    }
}

?>