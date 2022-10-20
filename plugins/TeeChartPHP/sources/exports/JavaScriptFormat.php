<?php
 /**
 * Description:  This file contains the following class:<br>
 * JavaScriptFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * JavaScriptFormat class
 *
 * Description: Chart data export to JavaScript
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

  /// <summary>
  /// JavaScript export format
  /// </summary>
  class JavaScriptFormat extends ImageExportFormat
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
        $this->fileExtension="html";
    }

    private function FilterFiles()
    {
        return Texts::$HTMLFilter;
    }

    /**
    * Render the chart to JavaScript
    *
    * @access  public
    */    
    function Render($chartName="Chart1")
    {
        $st = new StringBuilder();
        $jsExport = new JavaScriptExport($chartName);
        $jsExport->AddStrings($this->getChart(),$st);
     
       return $st;   
     }

    /**
    * Save the chart to Html file as javascript
    *
    * @access  public
    */    
    function SaveToFile($fileName,$chartName="Chart1")
    {
        $jsExport = new JavaScriptExport($chartName);
        $jsExport->SaveToFile($this->getChart(),$fileName);
    }

    /*
    public function Save($fileName)
    {         
        // Create the html file        
        $fhandle=fopen($fileName,'w');
        if($fhandle==false)
        {
              die("Unable to create file");
        }
        else
        {        
          rewind($fhandle);        
          $oldGraphics = $this->getChart()->getGraphics3D();
          $g = new Graphics3DHTML5($fhandle, $this->chart);
        
          $g->setImagePath($this->ImagePath);
          $this->chart->setGraphics3D($g);
                      
          $this->chart->_paint($g, new Rectangle(0, 0,  $this->getWidth(), $this->getHeight()));
          
          // To add end of html5 file
          $g->ShowImage($g);

          $this->chart->setGraphics3D($oldGraphics);
        
          // Close the mxml file
          fflush($fhandle);
          ftruncate($fhandle, ftell($fhandle));          
          fclose($fhandle);                         
        }      
    }
    */
  }    
?>