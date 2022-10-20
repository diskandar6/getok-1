<?php
 /**
 * Description:  This file contains the following class:<br>
 * ToolsCollection class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * ToolsCollection class
 *
 * Description: Collection of Tool components
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

class ToolsCollection extends ArrayObject
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

   /**
   * Adds a new tool to your TChart.
   * Returns the added tool instance.
   * @param tool Tool
   * @return int
   */
   public function add($tool)
   {
      $tool->setChart($this->chart);
      return $this->internalAdd($tool);
   }

   public function internalAdd($tool)
   {
      if($this->indexOf($tool) == - 1)
      {
         parent::append($tool);
      }
      return $tool;
   }

   public function getTool($index)
   {
      return $this->offsetGet($index);
   }

   public function setTool($index, $value)
   {
      $this->set($index, $value);
   }

   /**
   * Returns the corresponding point index which has the specified Value.
   *
   * @param s Tool
   * @return int
   */
   public function indexOf($s)
   {
      for($t = 0; $t < sizeof($this); $t++)
      {
         if($this->getTool($t) === $s)
         {
            return $t;
         }
      }

      return - 1;
   }

   /**
   * Removes a tool from the TChart.
   *
   * @param s Tool
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
         $this->getTool($t)->setChart($chart);
      }
   }
}
?>