<?php
 /**
 * ImageExport class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2019 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class ImageExport extends TeeBase {

    private $jpegFormat;
    private $gifFormat;
    private $pngFormat;
    private $wbmpFormat;
    private $flexFormat;
    private $HTML5Format;
    private $SVGFormat;    
    private $JavaScriptFormat;

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

    public function __construct($c) {
        parent::__construct($c);
    }

    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->jpegFormat);
        unset($this->gifFormat);
        unset($this->pngFormat);
        unset($this->wbmpFormat);
        unset($this->flexFormat);
        unset($this->HTML5Format);
        unset($this->SVGFormat);
        unset($this->JavaScriptFormat);
    }   
        
    public function getJPEG() {
        if ($this->jpegFormat == null) {
            $this->jpegFormat = new JPEGFormat($this->chart);
        }
        return $this->jpegFormat;
    }

    public function getGIF() {
        if ($this->gifFormat == null) {
            $this->gifFormat = new GIFFormat($this->chart);
        }
        return $this->gifFormat;
    }

    public function getPNG() {
        if ($this->pngFormat == null) {
            $this->pngFormat = new PNGFormat($this->chart);
        }
        return $this->pngFormat;
    }

    public function getWBMP() {
        if ($this->wbmpFormat == null) {
            $this->wbmpFormat = new WBMPFormat($this->chart);
        }
        return $this->wbmpFormat;
    }

    public function getFlex() {
        if ($this->flexFormat == null) {
            $this->flexFormat = new FlexFormat($this->chart);
        }
        return $this->flexFormat;
    }

    public function getHTML5() {
        if ($this->HTML5Format == null) {
            $this->HTML5Format = new HTML5Format($this->chart);
        }
        return $this->HTML5Format;
    }

    public function getSVG() {
        if ($this->SVGFormat == null) {
            $this->SVGFormat = new SVGFormat($this->chart);
        }
        return $this->SVGFormat;
    }

    public function getJavaScript() {
        if ($this->JavaScriptFormat == null) {
            $this->JavaScriptFormat = new JavaScriptFormat($this->chart);
        }
        return $this->JavaScriptFormat;
    }
    
    /*
    public function image($dimension) {
        return $this->image($dimension->width, $dimension->height);
    }
    */

    public function image($width=-1, $height=-1) {

        if ($width == -1) {
            $width = $this->chart->getWidth();

            if ($width <=0) {
               $width = 400;
            }
        }
        if ($height =-1) {
            $height = $this->chart->getHeight();

            if ($height <=0) {
               $height = 300;
            }
        }

        return $this->chart->getGraphics3D()->img;
    }


    public function lostOwnership($clipboard, $contents) {
    }


    public function copyToClipboard($width=-1, $height=-1) {
        if ($width==-1 || $height==-1) {
           $this->Toolkit->getDefaultToolkit()->getSystemClipboard()->setContents(new
                TransferImage($this->image($this->chart->getWidth(),  $this->chart->getHeight())), $this);
        }
        else
        {
           $this->Toolkit->getDefaultToolkit()->getSystemClipboard()->setContents(new
                TransferImage($this->image($width, $height)), $this);
        }
    }

}

 /**
 * TransferImage class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2019 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

class TransferImage {

        private $image;

        public function __construct($img) {
            $this->image = $img;
        }

        public function /*DataFlavor[]*/ getTransferDataFlavors() {
            // TODO return new DataFlavor[] {$this->DataFlavor->imageFlavor};
        }

        public function isDataFlavorSupported($flavor) {
            return $this->DataFlavor->imageFlavor->equals($flavor);
        }

        public function /*Object*/ getTransferData($flavor) /* tODO throws
                                UnsupportedFlavorException, IOException*/ {
            if (!$this->isDataFlavorSupported($flavor)) {
                throw new UnsupportedFlavorException($flavor);
            }
            return $this->image;
        }
}

?>