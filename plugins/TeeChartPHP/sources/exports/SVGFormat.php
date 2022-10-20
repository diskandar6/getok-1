<?php
 /**
 * Description:  This file contains the following class:<br>
 * SVGFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * SVGFormat class
 *
 * Description: Chart data export to SVG
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 
class SVGFormat extends ImageExportFormat {  
    
    private $FDesc; 
    private $FGroups; 
    private $Properties; 

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
        $this->fileExtension="svg";     
    }

    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->FDesc);
        unset($this->FGroups);
        unset($this->Properties);
    }   
        
    private function FilterFiles()
    {
        return Texts::$SVGFilter;
    }
    
    /**
    * Render the chart to svg
    *
    * @access  public
    */    
    function Render($chartName="Chart1")
    {
        //$this->CheckSize();
        $st = new StringBuilder();
        $this->CheckProperties();
                
        //$jsExport->AddStrings($this->getChart(),$st);
          $oldGraphics = $this->getChart()->getGraphics3D();
          $g = new CanvasSVG($this->chart, $this->getChart()->getWidth(),$this->getChart()->getHeight());
          $g->CreateText($st,$this->chart);
          
          // TODO $g->setImagePath($this->ImagePath);
          $this->chart->setGraphics3D($g);
                      
          $this->chart->_paint($g, new Rectangle(0, 0,  $this->getWidth(), $this->getHeight()));
          
          // To add end of html5 file
          // TODO Remove $g->ShowImage($g);

          $this->chart->setGraphics3D($oldGraphics);
               
       return $st;   
     }

    /**
    * Save the chart to Html file as svg
    *
    * @access  public
    */    
    function SaveToFile($fileName,$chartName="Chart1")
    {
        $jsExport = new JavaScriptExport($chartName);
        $jsExport->SaveToFile($this->getChart(),$fileName);
    }
    
    function getDescription()
    {
      return 'as &SVG';
    }

    function getFileExtension()
    {
      return'SVG';
    }

    function getFileFilter()
    {
      return 'SVG files (*.svg)|*.svg';
    }

    function CheckProperties()
    {
        /* TODO
      if not Assigned(FProperties) then
      {
        FProperties:=TSVGOptions.Create(nil);
        FProperties.EDesc.Text:=FDesc;
        FProperties.CBGroup.Checked:=FGroups;
      }
      */
    }

    function Options($Check=True)
    {
      if ($Check)
        $this->CheckProperties();
      
      return $this->FProperties;
    }
}
?>
