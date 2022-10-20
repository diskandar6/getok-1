<?php
  /**
 * Description:  This file contains the following class:<br>
 * CustomAxes class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * CustomAxes class
 *
 * Description: Used to access the Custom series List
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

final class CustomAxes extends ArrayObject
{

   private $chart;

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
   
    public function __destruct() {        
        unset($this->chart);
    }      
   
   /**
   * Creates and adds a custom axis to the chart.
   *
   * @return Axis
   */
   public function getNew()
   {
      return $this->add(new Axis(false,false,$this->chart));
   }

   public function setChart($value)
   {
      $this->chart = $value;

      for($t = 0; $t < sizeof($this); $t++)
      {
         $this->getAxis($t)->setChart($this->chart);
      }
   }

   /**
   * Adds a Custom Axis.
   *
   * @param axis Axis
   * @return Axis
   */
   public function add($axis)
   {
      if($this->indexOf($axis) == - 1)
      {
           if (is_object($this)) {
              parent::offsetset(sizeof($this),$axis);
           }
           else
           {
              parent::append($axis);
           }
      }
      // remove $axis->setChart($this->chart);
      return $axis;
   }

   /**
   * Accesses Axis characteristics of corresponding index value.
   *
   * @param index int
   * @return Axis
   */
   public function getAxis($index)
   {
      return $this->offsetGet($index);
   }
    /**
    * Sets Axis characteristics of corresponding index value.
    *
    * @param index int
    * @param value Axis
    */
   public function setAxis($index, $value)
   {
      $this->offsetSet($index, $value);
   }
    /**
    * Returns the corresponding axis index which has the specified value.
    *
    * @param a Axis
    * @return int
    */
   public function indexOf($a)
   {
      for($t = 0; $t < sizeof($this); $t++)
      {
         if($this->offsetGet($t) == $a)
         {
            return $t;
         }
      }
      return - 1;
   }

   /**
   * Removes the Custom Axis of Index 'CustomAxisIndex'.<br>
   * Any Series associated with the Axis are reset to their default Axes.
   *
   * @param a Axis
   */
   public function remove($a)
   {
      $i = $this->indexOf($a);
      if($i != - 1)
      {
         $this->remove($i);
      }
   }

   /**
   * Removes all Custom Axes.<br>
   * Any Series associated with the Axes are reset to their default Axes.
   */
   public function removeAll()
   {
      while(sizeof($this) > 0)
      {
         $this->remove(0);
      }
   }
}
?>