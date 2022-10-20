<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: MathUtils class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */
/**
 * MathUtils class
 *
 * Description: Math utility procedures
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */

class MathUtils {

    /*static*/ public/*final double*/ $PISTEP = M_PI; // / 180;

    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }

    /**
     * A constant holding the positive infinity of type
     * <code>double</code>. It is equal to the value returned by
     * <code>Double.longBitsToDouble(0x7ff0000000000000L)</code>.
     */
//    public static /*final*/ $POSITIVE_INFINITY = 1.0 / 0.0;

    /**
     * A constant holding the negative infinity of type
     * <code>double</code>. It is equal to the value returned by
     * <code>Double.longBitsToDouble(0xfff0000000000000L)</code>.
     */
//    public static final double NEGATIVE_INFINITY = -1.0 / 0.0;

    /**
     * A constant holding a Not-a-Number (NaN) value of type
     * <code>double</code>. It is equivalent to the value returned by
     * <code>Double.longBitsToDouble(0x7ff8000000000000L)</code>.
     */
//    public static final double NaN = 0.0d / 0.0;

    /**
     * A constant holding the largest positive finite value of type
     * <code>double</code>,
     * (2-2<sup>-52</sup>)&middot;2<sup>1023</sup>.  It is equal to
     * the hexadecimal floating-point literal
     * <code>0x1.fffffffffffffP+1023</code> and also equal to
     * <code>Double.longBitsToDouble(0x7fefffffffffffffL)</code>.
     */
//    public static final double MAX_VALUE = 1.7976931348623157e+308; // 0x1.fffffffffffffP+1023

    /**
     * A constant holding the smallest positive nonzero value of type
     * <code>double</code>, 2<sup>-1074</sup>. It is equal to the
     * hexadecimal floating-point literal
     * <code>0x0.0000000000001P-1022</code> and also equal to
     * <code>Double.longBitsToDouble(0x1L)</code>.
     */
//    public static final double MIN_VALUE = 4.9e-324; // 0x0.0000000000001P-1022




    static public function getPiStep () {
        return M_PI / 180;
    }

    static public function sqr($x) {
        return $x * $x;
    }

    /**
     * Note: This function has been added to MathUtils because J2ME Math
     * class does not include it.
     *
     * Returns Math.log of value parameter.
     *
     * @param value double
     * @return double
     */
    public static function log($value) {
        return log($value);
    }

    static public function _log($x, $numBase) {
        return log($x) / log($numBase);
    }

    // Note: This function is implemented here instead of using Math.round
    // because J2ME Math class does not include it (as far as in CLDC 1.1)

    /**
     * Returns the integer nearest to "value" parameter
     *
     * @param value double
     * @return int
     */
    public static function round($value) {
        return floor($value + 0.5); // before 0.5d);
    }

    /**
     * Returns TeePoint
     *
     * @param value TeePoint
     * @param value TeePoint
     * @param value int
     * @return TeePoint
     */
    static public function pointAtDistance($aFrom, $aTo, $aDist) {

        $res = new TeePoint($aTo->x, $aTo->y);

        if ($aFrom.x != $aTo.x) {
            $tmp = MathUtils::atan2(($aTo->getY() - $aFrom->getY()), ($aTo->getX() - $aFrom->getX()));

            $tmpSin = sin($tmp);
            $tmpCos = cos($tmp);
            $res->x -= self::round($aDist * $tmpCos);
            $res->y -= self::round($aDist * $tmpSin);
        } else {
            if ($aTo->getY() < $aFrom->getY()) {
                $res->setY($res->getY() + $aDist);
            } else {
                $res->setY($res->getY() - $aDist);
            }
        }

        return $res;
    }

    static public function calcDistance($x0, $y0, $x1, $y1) 
    {
        $dx=0;
        $dy=0;

        if (($x1 == $x0) && ($y1 == $y0)) {
            $dx = $p.x - $x0;
            $dy = $p.y - $y0;

            return sqrt($dx * $dx + $dy * $dy);
        } else {
            $dx = $x1 - $x0;
            $dy = $y1 - $y0;

            $tmpResult=0;
            $tmpResult = (($p.x - $x0) * $dx + ($p.y - $y0) * $dy) /
                        ($dx * $dx + $dy * $dy);

            if ($tmpResult < 0) {
                $dx = $p.x - $x0;
                $dy = $p.y - $y0;
            } else if ($tmpResult > 1) {
                $dx = $p.x - $x1;
                $dy = $p.y - $y1;
            } else {
                $dx = $p.x - ($x0 + $tmpResult * $dx);
                $dy = $p.y - ($y0 + $tmpResult * $dy);
            }

            return sqrt($dx * $dx + $dy * $dy);
        }
    }

    static public function pointInLineTolerance($p, $x0, $y0, $x1, $y1, $tolerance) {
        if ((($p.x == $x0) && ($p.y == $y0)) || (($p.x == $x1) && ($p.y == $y1))) {
            return true;
        } else {
            return abs(calcDistance($p, $x0, $y0, $x1, $y1)) <= $tolerance++;
        }
    }

    /**  TODO REMOVE THIS FUNCTION BCOS BCCCOMP IS USED INSTEAD
     * Compares Double d1 with d2. Returns 0 if both are equal.
     * Returns -1 if d1 is lower than d2, and 1 if d1 is bigger than d2.
     *
     * @param d1 double
     * @param d2 double
     * @return int
     */
    public static function compareDoubles($d1, $d2) {
        if ($d1 < $d2) {
            return -1; // Neither val is NaN, thisVal is smaller
        }
        if ($d1 > $d2) {
            return 1; // Neither val is NaN, thisVal is larger
        }


        $thisBits = Double.doubleToLongBits($d1);
        $anotherBits = Double.doubleToLongBits($d2);

        return ($thisBits == $anotherBits ? 0 : // Values are equal
                ($thisBits < $anotherBits ? -1 : // (-0.0, 0.0) or (!NaN, NaN)
                 1)); // (0.0, -0.0) or (NaN, !NaN)
    }

    /**
     * Note: This method has been implemented here in MathUtils class
     * because J2ME Math class does not include it.
     *
     * Returns Math.atan2.
     *
     * @param y double
     * @param x double
     * @return double
     */
    public static function atan2($y, $x) {
       return atan2($y,$x);
    }

    /**
     * Note: This method has been implemented here in MathUtils class
     * because J2ME Math class does not include it.
     *
     * Returns Math.pow.
     *
     * @param a double
     * @param b double
     * @return double
     */
    public static function pow($a, $b) {
        return pow($a,$b);
    }

    /**
     * Note: This method has been implemented here in MathUtils class
     * because J2ME Math class does not include it.
     *
     * Returns Math.exp.
     *
     * @param a double
     * @return double
     */
    public static function exp($a) {
        return exp($a);
    }
}
?>