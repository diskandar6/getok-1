<?php
 /**
 * Description:  This file contains the following class:<br>
 * ImageExportFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * ImageExportFormat class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class ImageExportFormat extends TeeBase {

    private $width;
    private $height;
    public $fileExtension = "";
    protected $format = null;

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

    public function __construct($chart) {
        parent::__construct($chart);
        $r = $chart->getChartBounds();
        $this->width = $r->width;
        $this->height = $r->height;

        /*
                 if ((height != 0) && (width != 0)) {
            chart.getExport().chartWidthHeightRatio = (double) width /
                    (double) height;
                 }
         */
    }

    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->width);
        unset($this->height);
        unset($this->fileExtension);
        unset($this->format);
    }   
        
    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($value) {
        $this->width = $value;
    }

    public function setHeight($value) {
        $this->height = $value;
    }

/*    public function save($fileName) /*throws IOException {
        $outfile = new File($fileName);
        $ios = $this->ImageIO->createImageOutputStream($outfile);
        $this->save2($ios);
        $ios->close();
    }
*/

    public function save($ios) /* TODO throws IOException*/ {
    }        
}
?>