<?php

 /**
 * Description: Internal use only
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
require_once 'SerializeManager.php';
if(!isset($serialized_by_manager_data)){
	$serialized_by_manager_data = get_object_vars($this);
}
$serialized = SerializeManager::instance()->serializeVars($this, $serialized_by_manager_data);
?>
