<?php
 /**
 * Description:  This file contains the following class:<br>
 * HTML5Format class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * HTML5Format class
 *
 * Description: Chart data export to HTML5
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

  /// <summary>
  /// HTML5 export format
  /// </summary>
  class HTML5Format extends ImageExportFormat
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

    public function __destruct()    
    {        
        parent::__destruct();                
    }   
    
    private function FilterFiles()
    {
        return Texts::$HTMLFilter;
    }

/*
    protected function DataFormat
    {
      get
      {
        return DataFormats.Text;
      }
    }
*/
    public function Save($fileName)
    {         
        // Create the html5 file        
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

    /// <summary>
    /// Save a Chart as an HTML5 image
    /// </summary>
    /// <param name="c">Chart to save</param>
    /// <param name="fileName">filename as string</param>
    static public function SaveToFile($c, $fileName)
    {
      $s = new HTML5Format($c);
      $s->Save($fileName);
    }
  }    
?>