<?php
 /**
 * Description:  This file contains the following class:<br>
 * Footer class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Footer class
 *
 * Description:Text displayed below Chart
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Footer extends Title
{

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

      TChart::$controlName .= 'Footer_';        
              
      $tmpColor = new Color(255, 0, 0);// RED
      $this->getFont()->getBrush()->setDefaultColor($tmpColor);
      $this->onTop = false;
      unset($tmpColor);
   }

   protected function readResolve()
   {
      $this->onTop = false;
      return $this;
   }
   
    public function __destruct()    
    {        
        parent::__destruct();   
    }
}
?>