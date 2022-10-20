<?php
 /**
 * Description:  This file contains the following class:<br>
 * AxisLabelItem class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * AxisLabelItem class
 *
 * Description: Custom label
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

class AxisLabelItem extends TextShape
{

   private $value;
   protected $iAxisLabelsItems;

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

   public function __construct($c)
   {
      parent::__construct($c);
   }
   
   public function __destruct()    
   {        
       parent::__destruct();                
       unset($this->value);
       unset($this->iAxisLabelsItems);       
   }

   /**
   * Refreshes Label
   */
   public function repaint()
   {
      if (isset($this->iAxisLabelsItems->iAxis->chart))
        $this->iAxisLabelsItems->iAxis->chart->invalidate();
   }

   public function setValue($v)
   {
      if($v != $this->value)
      {
         $this->value = $v;
         $this->repaint();
      }
   }

   /**
   * Determines the Axis Value of the Label.
   *
   * @return double
   */
   public function getValue()
   {
      return $this->value;
   }
}
?>