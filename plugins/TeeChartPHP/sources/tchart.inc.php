<?php
/**
 *  This file is part of Steema Software
 *  It generates the design time TChart component.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 *  This file is part of Steema Software
 *  It generates the design time TChart component.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

  use_unit("classes.inc.php");
  use_unit("controls.inc.php");
  use_unit("stdctrls.inc.php");
  use_unit("teechart/sources/TChart.php");  // for Deploy

  /* use the following line in case that TeeChart for PHP library is placed on another place */
  //include ("E:\Steema\Root\TeeChart PHP\Version 1\sources\TChart.php");


class TChartObj extends GraphicControl
{
        protected $_onclick = null;
        protected $_chart = null;
        protected $_axes = null;
        protected $_legend = null;
        protected $_title = null;
        public $serialized;

        // Events

        //OnBeforeDrawAxes event
        protected $_onBeforeDrawAxes = null;
        function getOnBeforeDrawAxes() { return $this->_onBeforeDrawAxes; }
        function setOnBeforeDrawAxes($value) { $this->_onBeforeDrawAxes = $value; }
        function defaultOnBeforeDrawAxes() { return ""; }

        //OnBeforeDrawSeries event
        protected $_onBeforeDrawSeries = null;
        function getOnBeforeDrawSeries() { return $this->_onBeforeDrawSeries; }
        function setOnBeforeDrawSeries($value) { $this->_onBeforeDrawSeries = $value; }
        function defaultOnBeforeDrawSeries() { return ""; }


//    function getAxes() { return $this->_axes; }
//    function setAxes($value) { if(is_object($value)) $this->_axes = $value; }

//    function getLegend() { return $this->_legend; }
//    function setLegend($value) { if(is_object($value)) $this->_legend = $value; }

//    function getTitle() { return $this->_title; }
//    function setTitle($value) { if(is_object($value)) $this->_title = $value; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 400;
                $this->Height = 250;

                // Makes sure the framework knows that this component dumps binary image data
                $this->ControlStyle="csImageContent=1";

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";

                // Creates the chart
                $this->createChart();

/*                //Creates the axis properties
                $this->_axes = new Axes($this->_chart);
                $this->_axes->_control = $this;

                //Creates the legend properties
                $this->_legend = new Legend($this->_chart);
                $this->_legend->_control = $this;

                //Creates the legend properties
                $this->_title = new Title($this->_chart->getChart());
                $this->_title->_control = $this;
*/
        }

        /**
        * Creates a new chart and updates the protected chart variable.
        * @return object Chart object.
        */
        function createChart()
        {
		    $this->_chart = new TChart($this->Width,$this->Height);
            return $this->_chart;
        }

        function init()
        {
            parent::init();
            $submitEventValue = $this->input->{$this->readJSWrapperHiddenFieldName()};

            if (is_object($submitEventValue)){
                // Checks if the a click event has been fired
                if ($this->_onclick != null && $submitEventValue->asString() == $this->readJSWrapperSubmitEventValue($this->_onclick)) {
                        $this->callEvent('onclick', array());
                }
            }
        }

        function dumpHeaderCode()
        {
            parent::__construct();
            // Dumps only the header if not in design mode
            if (($this->ControlState & csDesigning) != csDesigning)  {
                // Tries to prevent the browser from caching the image
                echo "<META HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\" />\n";
            }
        }

        /**
         * Dumps the TChart graphic.
         *
         * This method dumps the chart graphic by dumping binary image data to the
         * browser. The browser is instructed to show image data because of the headers
         * sent first. You don't need to call this method directly.
         *
         * @see Control::readControlStyle()
         * @link http://www.php.net/manual/en/function.header.php
         */
        function dumpGraphic()
        {
            // Graphic component that dumps binary data
            header("Content-type: image/png");

            // Tries to prevent the browser from caching the image
            header("Pragma: no-cache");
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

            $tmpImg = imagecreatetruecolor($this->Width, $this->Height);            
            imagecopyresized($tmpImg,$this->_chart->getGraphics3D()->img,0,0,0,0,$this->width,            
                     $this->height,ImageSX($this->_chart->getGraphics3D()->img),ImageSY($this->_chart->getGraphics3D()->img));
            $this->_chart->getGraphics3D()->img=$tmpImg;
            $this->_chart->width = $this->Width;
            $this->_chart->height = $this->Height;
            $this->_chart->getChart()->setWidth($this->Width);
            $this->_chart->getChart()->setHeight($this->Height);
            $this->_chart->doInvalidate();                
            imagepng($this->_chart->getGraphics3D()->img);                    
            imagedestroy($tmpImg);                    
        }

        public $tmpImg;
                
        function serialize()
        {
            parent::__construct();
            // Serializes the TChart
            $owner = $this->readOwner();
            if ($owner != null) {
                $prefix = $owner->readNamePath().".".$this->_name.".TChartObj.";
                if (is_object($this->_chart->getChart())) {
                    $this->tmpImg=$this->_chart->getChart()->getGraphics3D()->img;
                    $serialized = Array();
                    $serialized=serialize($this->_chart->getChart());
                    $_SESSION[$prefix] =$serialized;
                }        
            }
        }
            
        function unserialize()
        {
            parent::__construct();
            // Unserializes the TChart
            $owner = $this->readOwner();

            if ($this->_chart != null && $owner != null) {
                $prefix = $owner->readNamePath().".".$this->_name.".TChartObj.";
                $this->_chart->unserialize($this->_chart,$prefix);
            }

            $key = md5($this->owner->Name.$this->Name.$this->Left.$this->Top.$this->Width.$this->Height);
            $bchart = $this->input->bchart;

            // Checks if the request is for this chart
            if ((is_object($bchart)) && ($bchart->asString() == $key)) {
                $this->dumpGraphic();
            }
        }

        function dumpContents()
        {
            parent::__construct();
            if (($this->ControlState & csDesigning) == csDesigning)  {
              $this->dumpGraphic();
            }
            else {
                $events = $this->readJsEvents();
                // Adds or replaces the JS events with the wrappers if necessary
                $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                
                //$hint = $this->getHintAttribute();
                $alt = htmlspecialchars($this->_chart->getChart()->getHeader()->getText());
                $style = "";
                if ($this->Style=="") {
                    // Adds the cursor to the style
                    if ($this->_cursor != "")    {
                            $cr = strtolower(substr($this->_cursor, 2));
                            $style .= "cursor: $cr;";
                    }
                }

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                if ($style != "") $style = "style=\"$style\"";

                if ($this->_onshow != null)  {
                    $this->callEvent('onshow', array());
                }

                $key = md5($this->owner->Name.$this->Name.$this->Left.$this->Top.$this->Width.$this->Height);
                $url = $_SERVER['PHP_SELF']; //$GLOBALS
                // Outputs an image generated by a URL requesting this script
                echo "<img src=\"$url?bchart=$key\" width=\"$this->Width\" height=\"$this->Height\" id=\"$this->_name\" name=\"$this->_name\" alt=\"$alt\" $hint $style $class $events />";
            }
        }

        function dumpFormItems()
        {
            // Adds a hidden field so we can determine for which event the chart was fired
            if ($this->_onclick != null) {
                $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
            }
        }

        function dumpJavascript()  {
            parent::__construct();

            if ($this->_onclick != null && !defined($this->_onclick)) {
                // Outputs the same function only once in case two
                // or more objects use the same OnClick event handler.
                // Otherwise, if for example two buttons use the same
                // OnClick event handler, it would be output twice.
                $def=$this->_onclick;
                define($def,1);

                // Outputs the wrapper function
                echo $this->getJSWrapperFunction($this->_onclick);
            }
        }

        function loaded() {
          parent::__construct();
          $this->writeBackImage($this->_chart->getChart()->getPanel()->getImage());
        }
                             
        protected function writeBackImage($value)
        {
            $this->_chart->getChart()->getPanel()->setImage($this->fixupProperty($value));
        }

        /**
        * Occurs when the user clicks the control.
        * @return mixed
        */
        function getOnClick                     () { return $this->_onclick; }
        function setOnClick                     ($value) { $this->_onclick=$value; }
        function defaultOnClick                 () { return null; }

        /*
        * Publishes the JS events for the Chart component
        */
        function getjsOnClick                   () { return $this->readjsOnClick(); }
        function setjsOnClick                   ($value) { $this->writejsOnClick($value); }

        function getjsOnDblClick                () { return $this->readjsOnDblClick(); }
        function setjsOnDblClick                ($value) { $this->writejsOnDblClick($value); }

        function getjsOnMouseDown               () { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown               ($value) { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp                 () { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp                 ($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseOver               () { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver               ($value) { $this->writejsOnMouseOver($value); }

        function getjsOnMouseMove               () { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove               ($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut                () { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut                ($value) { $this->writejsOnMouseOut($value); }

        function getjsOnKeyPress                () { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress                ($value) { $this->writejsOnKeyPress($value); }

        function getjsOnKeyDown                 () { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown                 ($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyUp                   () { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp                   ($value) { $this->writejsOnKeyUp($value); }


        /**
        * TChart object
        * See the TChart class to understand the functionallity
        * of the chart object.
        *
        * @link http://www.steema.com/products/teechart/php/documentation/
        *
        * @see getChart()
        *
        * @return object
        */
        function readChart() { return $this->_chart; }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        // TChart - Designtime properties (Object Inspector)
        // Published

        function getView3D() { return $this->_chart->getChart()->getAspect()->getView3D(); }
        function setView3D($value) { $this->_chart->getChart()->getAspect()->setView3D($value); }

        function getTitle() { return $this->_chart->getChart()->getHeader()->getText(); }
        function setTitle($value) { $this->_chart->getChart()->getHeader()->setText($value); }
        function defaultTitle() { return "TeeChart"; }

        function getBorderRound() { return $this->_chart->getChart()->getPanel()->getBorderRound(); }
        function setBorderRound($value) { $this->_chart->getChart()->getPanel()->setBorderRound($value); }
        function defaultBorderRound() { return 0; }

        function getAxisBehind() { return $this->_chart->getChart()->getAxes()->getDrawBehind(); }
        function setAxisBehind($value) { $this->_chart->getChart()->getAxes()->setDrawBehind($value); }
        function defaultAxisBehind() { return true; }

        function getAxisVisible() { return $this->_chart->getAxes()->getVisible(); }
        function setAxisVisible($value) { $this->_chart->getAxes()->setVisible($value); }
        function defaultAxisVisible() { return true; }

        function getBackImageInside() { return $this->_chart->getPanel()->getBackImageInside(); }
        function setBackImageInside($value) { $this->_chart->getPanel()->setBackImageInside($value); }
        function defaultBackImageInside() { return false; }

//        function getBackWall() { return $this->_chart->getWalls()->getBack(); }
//        function setBackWall($value) { if(is_object($value)) $this->_chart->getWalls()->backWall=$value; }

//        function getLeftAxis() { return $this->_chart->getAxes()->getLeft(); }
//        function setLeftAxis($value) { if(is_object($value)) $this->_chart->getAxes()->left=$value; }

//        function getLegend() { return $this->_chart->getLegend(); }
//        function setLegend($value) { if(is_object($value)) $this->_chart->setLegend($value); }

        function getChart3DPercent() { return $this->_chart->getAspect()->getChart3DPercent(); }
        function setChart3DPercent($value) { $this->_chart->getAspect()->setChart3DPercent($value); }
        function defaultChart3DPercent() { return 15; }

        function getClipPoints() { return $this->_chart->getAspect()->getClipPoints(); }
        function setClipPoints($value) { $this->_chart->getAspect()->setClipPoints($value); }
        function defaultClipPoints() { return true; }

        function getMarginBottom() { return $this->_chart->getPanel()->getMarginBottom(); }
        function setMarginBottom($value) { $this->_chart->getPanel()->setMarginBottom($value); }
        function defaultMarginBottom() { return 4; }

        function getMarginLeft() { return $this->_chart->getPanel()->getMarginLeft(); }
        function setMarginLeft($value) { $this->_chart->getPanel()->setMarginLeft($value); }
        function defaultMarginLeft() { return 3; }

        function getMarginRight() { return $this->_chart->getPanel()->getMarginRight(); }
        function setMarginRight($value) { $this->_chart->getPanel()->setMarginRight($value); }
        function defaultMarginRight() { return 3; }

        function getMarginTop() { return $this->_chart->getPanel()->getMarginTop(); }
        function setMarginTop($value) { $this->_chart->getPanel()->setMarginTop($value); }
        function defaultMarginTop() { return 4; }
}
?>
