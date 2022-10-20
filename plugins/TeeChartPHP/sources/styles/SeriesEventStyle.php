<?php

 /**
 * Description:  This file contains the following class:<br>
 * SeriesEventStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: SeriesEventStyle class</p>
  *
  * <p>Description: For internal use by Series instances to notify changes.</p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 class SeriesEventStyle {

    public $ADD = 0;
    public $REMOVE = 1;
    public $REMOVEALL = 2;
    public $CHANGETITLE = 3;
    public $CHANGECOLOR = 4;
    public $SWAP = 5;
    public $CHANGEACTIVE = 6;
    public $DATACHANGED = 7;

    public function __construct() {
    }
}

?>