<?php

 /**
 * Description:  This file contains the following class:<br>
 * FlexFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * FlexFormat class
 *
 * Description: Chart data export to Flex
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class FlexFormat extends ImageExportFormat {

    private $embeddedImages;
    private $imagePath;
         
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

        $this->fileExtension="mxml";
        $this->embeddedImagess = true;
        $this->imagePath = "";        
    }
    
    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->embeddedImages);
        unset($this->imagePath);
    }           
    
    public function getEmbeddedImages()
    {
      return $this->embeddedImages; 
    }
    
    public function setEmbeddedImages($value) 
    {
      $this->embeddedImages = $value; 
    }

    public function getImagePath()
    {
      return $this->imagePath;
    }
    
    public function setImagePath($value)
    {
      $this->imagePath = $value; 
    }
       
    public function Save($fileName, $makeAll=false, $deleteTemp=false, $makeHTML=false)
    {
      if (!$makeAll)
      {
        $this->imagePath = dirname($fileName);
        $this->saveFlex($fileName);        
      }
      else
      {
        $dir = dirname($fileName);
        $tmpFile = $fileName;

        if (strpos("/", $fileName) != -1)
        {
          if (realpath($dir) != false)
          {
            //dir = fileName.Substring(0, fileName.LastIndexOf('\\'));
            //fileName = fileName.Substring(fileName.LastIndexOf('\\')+1);
          }
        }
        
        FlexOptions::CompileDeleteShow($this->chart, $this->getWidth(), $this->getHeight(), $dir, $fileName, $deleteTemp, true, false);
        if ($makeHTML)
          FlexOptions::GenerateHTML($this->chart, $this->getWidth(), $this->getHeight(), $dir, $fileName);
      }
    }

   public function SaveFlex($fileName)
    {
        // Create the mxml file        
        $fhandle=fopen($fileName,'w');
        if($fhandle==false)
        {
              die("Unable to create file");
        }
        else
        {        
          rewind($fhandle);        
          $oldGraphics = $this->getChart()->getGraphics3D();
          $g = new Graphics3DFlex($fhandle, $this->chart);
        
          $g->setImagePath($this->ImagePath);
          $g->setEmbeddedImages($this->EmbeddedImages);
          $this->chart->setGraphics3D($g);
                      
          $this->chart->_paint($g, new Rectangle(0, 0,  $this->getWidth(), $this->getHeight()));
          
          // To add end of mxml file
          $g->ShowImage($g);

          $this->chart->setGraphics3D($oldGraphics);
        
          // Close the mxml file
          fflush($fhandle);
          ftruncate($fhandle, ftell($fhandle));          
          fclose($fhandle);                         
        }
    }

    /// <summary>
    /// Save a Chart as a Flex image
    /// </summary>
    /// <param name="c">Chart to save</param>
    /// <param name="fileName">filename as string</param>
    static public function SaveToFile($c, $fileName)
    {
      $s = new FlexFormat($c);
      $s->Save(fileName);
    }
}                             
?>