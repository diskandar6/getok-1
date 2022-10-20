<?php
  /**
 * Description:  This file contains the following class:<br>
 * IEventListener class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */
 /**
 * IEventListener class
 *
 * Description:
 *
 * @author Steema Software SL
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */

interface IEventListener {
	function onMyEvent(ChartEvent $event);
}
?>