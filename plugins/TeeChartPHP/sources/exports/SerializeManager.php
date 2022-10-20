<?php
 /**
 * Description:  Internal use only
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
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
class ReferencedObjectSerializeMarker{
  public function __construct($objectKey){
  	$this->objectKey = $objectKey;
  }
}
 /**
 * Description: SerializeManager class
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
class SerializeManager{  
  private $_serializedObjects = array(); // avoid key = 0;
  private $_autoKey = 1;
  private $_serializedKeys = array();
  private $_unserializedObjects = array();
  
  /**
   * OURD_SerializeManager
   * @return SerializeManager
   */
  public static function instance(){
  	static $intance;
  	if(!isset($intance)){
  		$intance = new self();
  	}
  	return $intance;
  }
  
  private function _isSerialized($obj){
      foreach($this->_serializedObjects as $key=>$value){
        if($obj === $value){
          return $key;
        }
      }
      return false;   
  }
  
  private function _addSerializedObject($obj){
      $this->_serializedObjects[$this->_autoKey++] = $obj;    
      return $this->_autoKey - 1;
  }
  
  private function _registerSerializedObject($obj){
    if(is_object($obj) && !($objectKey = $this->_isSerialized($obj))){
      return $this->_addSerializedObject($obj);
    }else{
      return $objectKey;
    }
  }
  
  private function _replaceSerializedObjects(array &$data){
    foreach($data as $key=>&$value){
      if(is_object($value)){
        if($objectKey = $this->_isSerialized($value)){
          $data[$key] = new ReferencedObjectSerializeMarker($objectKey); 
        }else{
          $this->_addSerializedObject($value);
        }       
      }else if(is_array($value)){
        $this->_replaceSerializedObjects($value);
      }
    }
  }
  
  /**
   * @return string
   */
  public function serializeObject($object){
  	$this->init();
  	return serialize($object);
    $this->init();
  }  
  
  /**
   * @return string
   */
  public function serializeVars($object, array $data = array()){
  	$objectKey = $this->_registerSerializedObject($object);
  	if(!isset($this->_serializedKeys[$objectKey])){
  		$this->_serializedKeys[$objectKey] = true;
	    $this->_replaceSerializedObjects($data);   
	    return "$objectKey:".serialize($data); 
  	}else{
  		throw new Exception("Circle reference without serialize by manager");
  	}
  }

  /******** Unserialze **********/
  
  public function replaceUnserializedObjects(array &$data){
      foreach($data as $key=>&$value){
      if($value instanceof ReferencedObjectSerializeMarker){
        $data[$key] = $this->_unserializedObjects[$value->objectKey];
      }elseif(is_array($value)){
        $this->replaceUnserializedObjects($value);
      }
    }
  }

  /**
   * @return array
   */
  public function unserializeVars($object, $serialized){
    if(preg_match("#^(.*?):a:#", $serialized, $matches)){
       $objectKey = $matches[1];
       $this->_unserializedObjects[$objectKey] = $object;
       $serialized = substr($serialized, strlen($matches[1]) + 1);
       return unserialize($serialized);
    }else{
      return array();
    }
  }
  
  private function init(){
    // clearn-up
    $this->_serializedObjects = array(""); // avoid key = 0;
    $this->_serializedKeys = array();
    $this->_unserializedObjects = array();     
    $this->_autoKey = 1;   	
  }
  
  public function postUnserialize(){
    foreach($this->_unserializedObjects as $key=>$value){
    	if(is_object($value) && is_callable(array($value, 'postUnserializedByManager'))){
    	 $value->postUnserializedByManager();
    	}
    }
    $this->init();
  }
  
  public function unserializeObject($serialized){
    $this->init();  	
    $object = unserialize($serialized);
    $this->postUnserialize();
    return $object;
  }
}
?>
