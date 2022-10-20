<?php
 /**
 * Description:  This file contains the following class:<br>
 * PieMarks class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
* <p>Title: PieMarks class</p>
*
* <p>Description: Customized pie series marks with additional properties.</p>
*
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class PieMarks extends TeeBase
{
   private $vertcenter = false;
   private $legsize = 0;

   public $series = null;

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
   public function __construct($c, $s)
   {
      parent::__construct($c);

      if($this->series == null)
      {
         $this->series = $s;
      }
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->vertcenter);
        unset($this->legsize);
        unset($this->series);
    }       

   public function getVertCenter()
   {
      return $this->vertcenter;
   }

   public function setVertCenter($value)
   {
      if($this->vertcenter != $value)
      {
         $this->vertcenter = $value;
         if($this->series != null) $this->series->refreshSeries();
      }
   }

   public function getLegSize()
   {
      return $this->legsize;
   }

   public function setLegSize($value)
   {
      if($this->legsize != $value)
      {
         $this->legsize = $value;
         if($this->series != null) $this->series->refreshSeries();
      }
   }
}

?>