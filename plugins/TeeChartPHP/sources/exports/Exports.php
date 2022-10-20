<?php
 /**
 * Description:  This file contains the following class:<br>
 * Exports class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * Exports class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class Exports extends TeeBase {

    private $image;
    private $template;
    private $data;

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

        unset($this->image);
        unset($this->template);
        unset($this->data);
    }           
    /**
    * Gets a class instance with methods to export chart Series data.
    *
    * @return DataExport
    */
    public function getData() {
        if ($this->data == null) {
            $this->data = new DataExport($this->chart);
        }

        return $this->data;
    }

    /**
    * Gets a class instance with methods to create images from chart.
    *
    * @return ImageExport
    */
    public function getImage() {
        if ($this->image == null) {
            $this->image = new ImageExport($this->chart);
        }

        return $this->image;
    }

    /**
    * Gets a class instance with methods to store the chart to a file or
    * stream using Java standard serialization and XMLEncoder mechanisms.
    *
    * <p>Example:
    * <pre><font face="Courier" size="4">
    *  myChart.getExport().getTemplate().toXML(tmpName);
    *          showSavedFile(tmpName);
    * </font></pre></p>
    *
    * @return TemplateExport
    */
    public function getTemplate() {
        if ($this->template == null) {
            $this->template = new TemplateExport($this->getChart());
        }

        return $this->template;
    }
}

 /**
 * DataExport class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 class DataExport {

    private $xmlFormat;
    private $txtFormat;
    private $htmlFormat;
    private $excelFormat;
    private $chart;

    public function __construct($c=null) {
        $this->chart=$c;
    }
    
    public function __destruct()    
    {        
        unset($this->xmlFormat);
        unset($this->txtFormat);
        unset($this->htmlFormat);
        unset($this->excelFormat);
        unset($this->chart);
    }         

    /**
    * Export Chart to XML data format
    *
    * @return XMLFormat
    */
    public function getXML() {
        if ($this->xmlFormat == null) {
            $this->xmlFormat = new XMLFormat($this->chart);
        }
        return $this->xmlFormat;
    }

    /**
    * Export Chart as text
    *
    * <p>Example:
    * <pre><font face="Courier" size="4">
    * myChart.getExport().getData().getText().save(tmpName);
    * </font></pre></p>

    * @return TextFormat
    */
    public function getText() {
        if ($this->txtFormat == null) {
            $this->txtFormat = new TextFormat($this->chart);
        }
        return $this->txtFormat;
    }

    /**
    * Export Chart as HTML table
    *
    * @return HTMLFormat
    */
    public function getHTML() {
        if ($this->htmlFormat == null) {
            $this->htmlFormat = new HTMLFormat($this->chart);
        }
        return $this->htmlFormat;
    }

    /**
    * Export Chart as Excel spreadsheet
    *
    * @return ExcelFormat
    */
    public function getExcel() {
        if ($this->excelFormat == null) {
            $this->excelFormat = new ExcelFormat($this->chart);
        }
        return $this->excelFormat;
    }
 }

/**
 * ColorPersistenceDelegate class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */       
 class ColorPersistenceDelegate /*extends DefaultPersistenceDelegate*/ {

    public function __construct($constructorPropertyNames) {
        //parent::DefaultPersistenceDelegate($constructorPropertyNames);
    }

    protected function mutatesTo($oldInstance, $newInstance) {
        return $oldInstance->equals($newInstance);
    }   
}

 /**
 * TemplateExport class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
class TemplateExport {

    private $chart;   
    
    public function __construct($c=null) {
        $this->chart=$c;
    }
    
    public function __destruct()    
    {        
        unset($this->chart);
    }         
    
            
    /**
    * Writes a TChart oboject with all of its settings by cycling to a file using serialization mechanism.
    *
    * @param fileName String
    */
    public function toFile($fileName) {

      $f=fopen($fileName,'w');
      if($f==false)
      {
            die("Unable to create file");
      }
      else
      {
        if (file_exists($fileName)) {             
           $str = SerializeManager::instance()->serializeObject($this->chart);
           fwrite($f, $str);
           fclose($f);               
        }
        else
        {
           $str = SerializeManager::instance()->serializeObject($this->chart);
           fwrite($f, $str);
           fclose($f);               
        }
      }            
    }
     
    private function getProperties($value) {
        try {
            return $this->Introspector->getBeanInfo($value)->
                    $this->getPropertyDescriptors();
        } catch ( Excepction $ex) {
        }

        return null;
    }

    /**
    * Returns all properties in "value" Object that are different from their
    * default values, in XML text format.
    *
    * @param value Object
    * @return String
    */
    public function getXML($value=null) {
        if ($value==null) {
           $value = $this->getChart();
        }

        $stream = new ByteArrayOutputStream();
        $this->toXML($value, $stream);
        return new String($stream->toByteArray());
    }

    /**
    * Stores all chart properties to a file in XML format using Java
    * XMLEncoder class.
    *
    * @param file File
    * @throws FileNotFoundException
    */
    public function toXML($file) {
        $this->toXML($file->getPath());
    }

    /**
      * Stores all chart properties to a file in XML format using Java
      * XMLEncoder class.
      *
      * @param fileName String
      * @throws FileNotFoundException
      */
      
    /*TODO   
    public function toXML($fileName)  TODO  throws FileNotFoundException {
        $this->toXML(new BufferedOutputStream(
                new FileOutputStream($fileName)));
    }

    /**
      * Stores all chart properties to stream, in XML text format using
      * Java XMLEncoder class.
      *
      * @param stream OutputStream
    public function toXML($stream) {
        $this->toXML($this->getChart(), $stream);
    }
    private function prepareTransients() {
        $this->PropertyDescriptor[] $this->propertyDescriptors = $this->getProperties($this->Chart->class);

        for ( $i = 0; $i < $this->propertyDescriptors->length; ++$i) {
             $pd = $this->propertyDescriptors[$i];
            if ($pd->getName()->equals("graphics3D")) {
                $tmpBoolean = new Boolean();
                $pd->setValue("/*transient*//*", $tmpBoolean->TRUE);
            }
        }

        $this->PropertyDescriptor[] $this->propertyDescriptors2 = $this->getProperties($this->TeeBase->class);

        for ( $i = 0; $i < $propertyDescriptors2->length; ++$i) {
             $pd = $propertyDescriptors2[$i];
            if ($pd->getName()->equals("chart")) {
                $pd->setValue("/*transient", $tmpBoolean->TRUE);
            }
        }

        $this->PropertyDescriptor[] $this->propertyDescriptors3 = $this->getProperties($this->Series->class);

        for ( $i = 0; $i < $propertyDescriptors3->length; ++$i) {
             $pd = $propertyDescriptors3[$i];
            if (($pd->getName()->equals("endZ")) ||
                ($this->pd->getName()->equals("middleZ")) ||
                ($this->pd->getName()->equals("startZ"))) {
                $pd->setValue("/*transient", $tmpBoolean->TRUE);
            }
        }
    } 

    /**
      * Stores value object properties to stream, in XML text format using
      * Java XMLEncoder class.
      *
      * @param value Object
      * @param stream OutputStream
      *
    public function toXML($value, $stream) {

        $xe = new XMLEncoder($stream);

        $xe->setExceptionListener(new ExceptionListener() {
            public function exceptionThrown($exception) {
                $exception->printStackTrace();
            }
        });

        $this->prepareTransients();

         $colorDel = new ColorPersistenceDelegate(
                new String[] {"Red", "Green", "Blue", "Alpha"});
        $this->xe->setPersistenceDelegate($this->Color->class, $colorDel);

        $this->xe->writeObject($this->value);
        $this->xe->close();
    }

    /**
      * Writes all non-transient chart fields to a stream using Java standard
      * serialization mechanism.
      *
      * @param stream OutputStream
      * @throws IOException
      *
    public function toStream($stream) todo throws IOException {
         $out = new ObjectOutputStream($stream);
        $this->prepareTransients();
        $out->writeObject($this->chart);
        $out->close();
    }
    */
}
?>