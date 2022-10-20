<?php

 /**
 * Description: Internal use only
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
require_once 'SerializeManager.php';
if(isset($this->__unserialized_data__) && is_array($this->__unserialized_data__)){
	SerializeManager::instance()
	 ->replaceUnserializedObjects($this->__unserialized_data__);
	foreach($this->__unserialized_data__ as $key=>$value){
	  $this->$key = $value;
	}
	unset($this->__unserialized_data__);
}
?>