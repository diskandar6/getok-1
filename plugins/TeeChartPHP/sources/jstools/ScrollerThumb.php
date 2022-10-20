<?php

  /**
 * Description:  This file contains the following class:<br>
 * ScrollerThumb class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */
/**
 * ScrollerThumb class
 *
 * Description: Scroller thumb properties and methods
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */  

 class ScrollerThumb extends TeeBase {

    private $transparency=0.6;
    private $shadow;  // shadow height = 0
    private $color;  // black
  
    // Class Definition

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

    // Constructor
    public function __construct($c) {
        $this->transparency=0.6;
        $this->color= new Color(0,0,0);
        
        parent::__construct($c);
        $this->shadow=new Shadow($c,0,new Color(0,0,0));  
        $this->shadow->setVisible(false);
    }
    
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->transparency);
        unset($this->shadow);
        unset($this->color);
   }     
    
   public function getTransparency()
   {
      return $this->transparency;
   }

   public function setTransparency($value)
   {
      if($this->transparency != $value)
         $this->transparency = $value;
   }

   public function getShadow()
   {
      if($this->shadow == null)
         $this->shadow = new Shadow($this->chart,0, new color(0,0,0));
         
      return $this->shadow;
   }   
}
?>