<?php
 /**
 * Description:  This file contains the following class:<br>
 * MarksItems class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * MarksItems class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class MarksItems extends ArrayObject
{

   public /*protected*/ $iMarks;

   // Will be used when saving the items for design time
   public /*protected*/ $iLoadingCustom = false;

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
      parent::__construct();
   }
   
    public function __destruct()    
    {        
        unset($this->iMarks);
        unset($this->iLoadingCustom);
    }      

   /**
   * Returns the formatting object for the Index'th mark.
   *
   * @param index int
   * @return MarksItem
   */
   public function getItem($index)
   {
      while($index >= sizeof($this))
      {
         $this->append(null); 
      }

      if (!isset($this[$index]) || ($this[$index]==null))
      {
         $tmp = new MarksItem($this->iMarks->chart);

         //$tmp->getShadow()->setDefaultVisible(true);
         //$tmp->getShadow()->setSize(1);
         $tmpColor = new Color(130, 130, 130);// GRAY
         $tmp->getShadow()->setColor($tmpColor);
         $this[$index]=$tmp;
         
         unset($tmp);
         unset($tmpColor);
      }

      return $this[$index];
      //parent::offsetget($index);
   }

   public function clear()
   {
      
// tODO review      $this->iMarks->invalidate();
   }
}
?>
