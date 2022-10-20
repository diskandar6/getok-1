<?php
 /**
 * Description:  This file contains the following class:<br>
 * DateTimeStep class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
 /**
 * DateTimeStep class
 *
 * Description: Describes a number of different DateTime steps
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class DateTimeStep
{

   /**
   * Array of double values to define DateTimeStep.
   */
   public $DAYSTEP;

   //Millisecond step
   public $STEP;
   /**
   * Defines a OneMillisecond TimeSpan.
   */
   public static $ONEMILLISECOND = 0;
   /**
   * Defines a OneSecond TimeSpan.
   */
   public static $ONESECOND = 1;
   /**
   * Defines a FiveSeconds TimeSpan.
   */
   public static $FIVESECONDS = 2;
   /**
   * Defines a TenSeconds TimeSpan.
   */
   public static $TENSECONDS = 3;
   /**
   * Defines a FifteenSeconds TimeSpan.
   */
   public static $FIFTEENSECONDS = 4;
   /**
   * Defines a ThirtySeconds TimeSpan.
   */
   public static $THIRTYSECONDS = 5;
   /**
   * Defines a OneMinute TimeSpan.
   */
   public static $ONEMINUTE = 6;
   /**
   * Defines a FiveMinutes TimeSpan.
   */
   public static $FIVEMINUTES = 7;
   /**
   * Defines a TenMinutes TimeSpan.
   */
   public static $TENMINUTES = 8;
   /**
   * Defines a FifteenMinutes TimeSpan.
   */
   public static $FIFTEENMINUTES = 9;
   /**
   * Defines a ThirtyMinutes TimeSpan.
   */
   public static $THIRTYMINUTES = 10;
   /**
   * Defines a OneHour TimeSpan.
   */
   public static $ONEHOUR = 11;
   /**
   * Defines a TwoHours TimeSpan.
   */
   public static $TWOHOURS = 12;
   /**
   * Defines a SixHours TimeSpan.
   */
   public static $SIXHOURS = 13;
   /**
   * Defines a TwelveHours TimeSpan.
   */
   public static $TWELVEHOURS = 14;
   /**
   * Defines a OneDay TimeSpan.
   */
   public static $ONEDAY = 15;
   /**
   * Defines a TwoDays TimeSpan.
   */
   public static $TWODAYS = 16;
   /**
   * Defines a ThreeDays TimeSpan.
   */
   public static $THREEDAYS = 17;
   /**
   * Defines a OneWeek TimeSpan.
   */
   public static $ONEWEEK = 18;
   /**
   * Defines a HalfMonth TimeSpan.
   */
   public static $HALFMONTH = 19;
   /**
   * Defines a OneMonth TimeSpan.
   */
   public static $ONEMONTH = 20;
   /**
   * Defines a TwoMonths TimeSpan.
   */
   public static $TWOMONTHS = 21;
   /**
   * Defines a ThreeMonths TimeSpan.
   */
   public static $THREEMONTHS = 22;
   /**
   * Defines a FourMonths TimeSpan.
   */
   public static $FOURMONTHS = 23;
   /**
   * Defines a SixMonths TimeSpan.
   */
   public static $SIXMONTHS = 24;
   /**
   * Defines a OneYear TimeSpan.
   */
   public static $ONEYEAR = 25;
   /**
   *
   * Defines an automatic TimeSpan.
   */
   public static $NONE = 26;


   public function __construct()
   {

      $this->DAYSTEP = array((1.0 / (1000.0 * 86400.0)),
                             (1.0 / 86400.0), (5.0 / 86400.0),
                             (10.0 / 86400.0),
                             (0.25 / 1440.0), (0.5 / 1440.0),
                             (1.0 / 1440.0),
                             (5.0 / 1440.0), (10.0 / 1440.0),
                             (0.25 / 24.0),
                             (0.5 / 24.0), (1.0 / 24.0), (2.0 / 24.0),
                             (6.0 / 24.0),
                             (12.0 / 24.0), 1, 2, 3, 7, 15, 30, 60,
                             90,
                             120, 182, 365, /*MMnone:*/1);

      $this->STEP = array(1.0, /*1 $millisec*/
                          1000.0, 5000.0,
                          10000.0, /*10 secs*/
                          15000.0,
                          30000.0,
                          60000.0, /*1 min*/
                          (5.0 * 60000.0), /*5 mins*/
                          (10.0 * 60000.0),
                          (15.0 * 60000.0),
                          (30.0 * 60000.0), /*30 mins*/
                          (60.0 * 60000.0), /*1hr*/
                          (2.0 * 3600000.0), /*2hrs*/
                          (6.0 * 3600000.0),
                          (12.0 * 3600000.0), /*12hrs*/
                          (24.0 * 3600000.0), /*1 day*/
                          (2.0 * 86400000.0),
                          (3.0 * 86400000.0),
                          (7.0 * 86400000.0),
                          (15.0 * 86400000.0),
                          (30.0 * 86400000.0), /*30 days*/
                          (60.0 * 86400000.0),
                          (90.0 * 86400000.0),
                          (120.0 * 86400000.0),
                          (182.0 * 86400000.0),
                          (365.0 * 86400000.0), /*1 yr*/
                          /*MMnone:*/1);


   }

   public static function find($value)
   {
      /** @todo FINISH ! (copy from Axis class) */
      return self::$NONE;
   }
}
?>