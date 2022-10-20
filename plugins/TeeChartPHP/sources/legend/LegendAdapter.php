<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: LegendAdapter class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */
/**
 * LegendAdapter class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */

class LegendAdapter implements LegendResolver
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

   /** Creates a new instance of LegendAdapter */
   public function __construct()   {}

   public function getBounds($legend, $rectangle)
   {
      return $rectangle;
   }

   public function getItemCoordinates($legend, $coordinates)
   {
      return $coordinates;
   }

   public function getItemText($legend, $legendStyle, $index, $text)
   {
      return $text;
   }
}

?>