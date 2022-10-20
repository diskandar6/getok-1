<?php
 /**
 * Description:  This file contains the following class:<br>
 * MarksCallout class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 *
 * <p>Title: MarksCallout class</p>
 *
 * <p>Description: </p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class MarksCallout extends Callout
{

   protected $length = 8;
   private $defaultLength=0;

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

   public function __construct($s)
   {
      parent::__construct($s);
      
      $this->readResolve();
      $this->setDefaultVisible(false);
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->length);
        unset($this->defaultLength);
    }          
   

   protected function readResolve()
   {
      $this->defaultLength = 8;
      return parent::readResolve();
   }

   /**
   * Length between series data points and Marks.
   *
   * @return int
   */
   public function getLength()
   {
      return $this->length;
   }

   /**
   * Specifies the Length between series data points and Marks.
   *
   * @param value int
   */
   public function setLength($value)
   {
      if($this->length != $value)
      {
         $this->length = $value;
         $this->invalidate();
      }
   }

   function setDefaultLength($value)
   {
      $this->defaultLength = $value;
      $this->length = $value;
   }

}

?>