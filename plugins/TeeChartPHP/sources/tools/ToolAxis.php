<?php
/**
 * Description:  This file contains the following class:<br>
 * ToolAxis class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * ToolAxis class
 *
 * Description: Base abstract class for Tool components with an Axis method
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

class ToolAxis extends Tool
{

   protected $iAxis;

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

   public function __construct($c = null)
   {
      parent::__construct($c);
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->iAxis);
    }         

   /**
   * Element Pen characteristics.
   *
   * @return ChartPen
   */
   public function getPen()
   {
      if($this->pPen == null)
      {
         $tmpColor = new Color(0, 0, 0);
         $this->pPen = new ChartPen($this->getChart(), $tmpColor);
      }
      return $this->pPen;
   }

   /**
   * The axis to which a Tool will belong.<br>
   * Default value: null
   *
   * @return Axis
   */
   public function getAxis()
   {
      return $this->iAxis;
   }

   /**
   * Sets the axis to which a Tool will belong.<br>
   * Default value: null
   *
   * @param value Axis
   */
   public function setAxis($value)
   {
      if($this->iAxis != $value)
      {
         $this->iAxis = $value;
         $this->invalidate();
      }
   }
}
?>