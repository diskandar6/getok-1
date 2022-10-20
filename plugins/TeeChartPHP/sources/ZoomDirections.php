<?php
 /**
 * Description:  This file contains the following class:<br>
 * ZoomDirections class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
  * <p>Title: ZoomDirections class</p>
  *
  * <p>Description: Describes the possible values of Zoom.Direction method.</p>
  *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

 class ZoomDirections {
    /**
    * Allows only Horizontal Zooming.
    */
    public $HORIZONTAL = 0;
    /**
    * Allows only Vertical Zooming.
    */
    public $VERTICAL = 1;
    /**
    * Allows both Horizontal and Vertical Zooming.
    */
    public $BOTH = 2;

    public function __construct($value) {
    }
}
?>