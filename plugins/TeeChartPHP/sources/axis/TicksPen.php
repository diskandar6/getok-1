<?php
  /**
 * Description:  This file contains the following class:<br>
 * TicksPen class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * TicksPen class
 *
 * Description: Determines the kind of Pen used to draw Axis marks along
 * the Axis line
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */


class TicksPen extends ChartPen
{

   public $length;
   public $defaultLength;

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

   /**
   * The class constructor.
   */
   public function __construct($c)
   {
      parent::__construct($c);
      $tmpColor = new Color(120, 120, 120);// DARK_GRAY
      $this->setDefaultColor($tmpColor);
      
      unset($tmpColor);
   }
   
    public function __destruct()    
    {        
        parent::__destruct();                
        unset($this->length);
        unset($this->defaultLength);
    }

   private function shouldSerializeLength()
   {
      return $this->length != $this->defaultLength;
   }

   /**
   * Length of Axis Ticks in pixels.
   *
   * @return int
   */
   public function getLength()
   {
      return $this->length;
   }

   /**
   * Sets the length of Axis Ticks in pixels.
   *
   * @param value int
   */
   public function setLength($value)
   {
      $this->length = $this->setIntegerProperty($this->length, $value);
   }
}

?>