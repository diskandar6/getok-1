<?php
 /**
 * Description:  This file contains the following class:<br>
 * GIFFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
/**
 * GIFFormat class
 *
 * Description: GIF export format
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class GIFFormat extends ImageExportFormat {

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
    public function __construct($c) {
        parent::__construct($c);
        
//        $this->format = new JPEGImageWriteParam($this->Locale->getDefault());
        $this->fileExtension = "gif";
    }
    
    public function __destruct()    
    {        
        parent::__destruct();                
    }       

    public function save($ios) /* TODO throws IOException*/ {
        if ($this->width <= 0) {
            $this->width = 400;
        }

        if ($this->height <= 0) {
            $this->height = 300;
        }

        $img = $this->chart->image($this->width, $this->height);
        imagegif($this->chart->getGraphics3D()->img,$ios);
    }
}
?>