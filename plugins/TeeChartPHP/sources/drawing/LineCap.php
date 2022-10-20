<?php
  /**
 * Description:  This file contains the following class:<br>
 * LineCap class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
 /**
 * LineCap class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

 class LineCap {

    /**
      * Defines a beveled union style between line segments
      */
    public static $BEVEL = 0; // BasicStroke.JOIN_BEVEL

    /**
      * Defines a miter union style between line segments
      */
    public static $MITER = 1; //BasicStroke.JOIN_MITER

    /**
      * Defines a round union style between line segments
      */
    public static $ROUND = 2; //BasicStroke.JOIN_ROUND

    public function __construct() {
    }

    public function fromValue($value) {
        switch ($value) {
        case 0:
            return self::$BEVEL;
        case 1:
            return self::$MITER;
        default:
            return self::$ROUND;
        }
    }
}

?>