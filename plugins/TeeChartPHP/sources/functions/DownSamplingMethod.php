<?php
  /**
 * Description:  DownSamplingMethod class:<br>
 * DownSamplingMethod class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */

class DownSamplingMethod
{
	private static $serialVersionUID = 1;
	/**
     * Replace group of points with group maximum value.
     */
    public static $MAX = 0;
    /**
     * Replace group of points with group minimum value.
     */
    public static $MIN = 1;
    /**
     * Replace group of points with two points : group minimum and maximum
     * value.
     */
    public static $MINMAX = 2;
    /**
     * Replace group of points with two points : group minimum and maximum value. Draw
     * From Last value of one group to the First value of the next. Only include the first
     * null of the group in the calculation but without plotting it.
     */
    public static $MINMAXFIRSTLAST = 3;
    /**
     * Replace group of points with two points : group minimum and maximum value. Draw
     * From Last value of one group to the First value of the next. Only include the first
     * null of the group in the calculation but without plotting it.
     */
    public static $MINMAXFIRSTLASTNULL = 4;
    /**
     * Replace group of points with group average value.
     */
    public static $AVERAGE = 5;


   public function __construct()   {}                
}
?>