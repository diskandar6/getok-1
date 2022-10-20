<?php
  /**
 * Description:  This file contains the following class:<br>
 * JsToolsCollection class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */
/**
 * JsToolsCollection class
 *
 * Description: Collection of JsTool components
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */

class JsToolsCollection extends ArrayObject
{

   public $chart;

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
      parent::__construct();      
      $this->chart = $c;
   }
   
    public function __destruct()    
    {        
        unset($this->chart);
    }    

   /**
   * Adds a new jstool to your TChart.
   * Returns the added tool instance.
   * @param tool JsTool
   * @return int
   */
   public function add($jstool)
   {
      $jstool->setChart($this->chart);
      return $this->internalAdd($jstool);
   }

   public function internalAdd($jstool)
   {
      if($this->indexOf($jstool) == - 1)
      {
         parent::append($jstool);
      }
      return $jstool;
   }

   public function getJsTool($index)
   {
      return $this->offsetGet($index);
   }

   public function setJsTool($index, $value)
   {
      $this->set($index, $value);
   }

   /**
   * Returns the corresponding point index which has the specified Value.
   *
   * @param s JsTool
   * @return int
   */
   public function indexOf($s)
   {
      for($t = 0; $t < sizeof($this); $t++)
      {
         if($this->getJsTool($t) === $s)
         {
            return $t;
         }
      }
      return - 1;
   }

   /**
   * Removes a jstool from the TChart.
   *
   * @param s JsTool
   */
   public function remove($s)
   {
      $i = $this->indexOf($s);
      if($i != - 1)
      {
         $this->remove($i);
         $this->chart->invalidate();
      }
   }

   /**
   * Sets Chart interface to tools collection
   *
   * @param chart IBaseChart
   */
   public function setChart($chart)
   {
      $this->chart = $chart;

      for($t = 0; $t < sizeof($this); $t++)
      {
         $this->getJsTool($t)->setChart($chart);
      }
   }
}
?>