<?php
  /**
 * Description:  This file contains the following class:<br>
 * Smoothing class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 * Smoothing class
 *
 * Description: Smoothing Function
 *
*  @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
*/
class Smoothing extends Functions {

    private $interpolate = true;
    private $factor = 4;

    public function __construct($c=null) {
        parent::__construct($c);
        
        $this->canUsePeriod = false;
        $this->SingleSource=true;
        $this->dPeriod = 1;
    }

    /**
     * When true, resulting smooth curves will pass exactly over source points.
     * <br>
     * When false, the smooth curves will not necessarily pass over source
     * points. <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getInterpolate() {
        return $this->interpolate;
    }

    /**
     * Resulting smooth curves will pass exactly over source points when true.
     * <br>
     * When false, the smooth curves will not necessarily pass over source
     * points. <br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setInterpolate($value) {
        if ($this->interpolate != $value) {
            $this->interpolate = $value;
            $this->recalculate();
        }
    }

    /**
     * The number of times the resulting smooth points are compared to source
     * points. <br>
     * For example, a value of 4 means the smooth points will be 4 times
     * the number of source points. <br>
     * The greater the factor value is, the smoother the resulting curves will
     * be. <br>
     * Default value: 4
     *
     * @return int
     */
    public function getFactor() {
        return $this->factor;
    }

    /**
     * Sets the number of times the resulting smooth points are
     * compared to source points. <br>
     * Default value: 4
     *
     * @param value int
     */
    public function setFactor($value) {
        if ($this->factor != $value) {
            $this->factor = max(1, $value);
            $this->recalculate();
        }
    }

    /**
     * gets all points from Source series, performs a function operation on
     * points and finally stores results in ParentSeries. <br>
     *
     * @param source ArrayList
     */
    public  function addPoints($source) {
        if (!$this->updating) {
            if ($source != null) {
                if (sizeof($source) > 0) {
                    $s = $source[0];
                    $this->getSeries()->clear();
                    if ($s->getCount() > 0) {
                        $v = $this->valueList($s);
                        $sp = new Spline();
                        for ($t = 0; $t < $s->getCount(); $t++) {
                            $sp->addPoint($s->getXValues()->value[$t], $v->value[$t]);
                            $sp->setKnuckle($t, false);
                        }
                        $sp->setInterpolated($this->interpolate);
                        $sp->setFragments($s->getCount() * $this->factor);

                        for ($t = 0; $t <= $sp->getFragments(); $t++) {
                            $p = $sp->value((double) $t / $sp->getFragments());
                            if ($this->getSeries()->getYMandatory()) {
                              $this->getSeries()->addXY($p->x, $p->y);
                            } else {
                                $this->getSeries()->addXY($p->y, $p->x);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return Language.getString("FunctionSmooth");
    }
}
?>