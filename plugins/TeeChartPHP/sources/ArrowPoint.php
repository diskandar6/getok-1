<?php
 /**
 * Description:  This file contains the following class:<br>
 * ArrowPoint class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * ArrowPoint class
 *
 * Description: ArrowPoint characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

 class ArrowPoint {

    public $x;
    public $y;
    public $z;
    public $sinA;
    public $cosA;
    public $g;

    public function calc() {
        $p = new TeePoint(MathUtils::round($this->x * $this->cosA + $this->y * $this->sinA),
              MathUtils::round( -$this->x * $this->sinA + $this->y * $this->cosA));

        return $this->g->calc3DPoint($p->getX(), $p->getY(), $this->z);
    }
    
    function __destruct()
    {
        unset($this->x);
        unset($this->y);
        unset($this->z);
        unset($this->sinA);
        unset($this->cosA);
        unset($this->g);
    }
}
?>