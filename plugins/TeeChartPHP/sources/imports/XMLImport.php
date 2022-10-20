<?php
 /**
 * Description:  This file contains the following class:<br>
 * XMLImport class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage imports
 * @link http://www.steema.com
 */
 /**
 * XMLImport class
 *
 * Description: hart import data from XML
 * (Exported via getExport()->getData()->getXML()->save())
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage imports
 * @link http://www.steema.com
 */

class XMLImport extends DataImportFormat
{

   private $sSeriesNode = "";
   private $sDataMember = "";
   private $dom;

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

   /** Load XML from file **/
   public function open($file) {
      $this->Load($file);
   }

   /** Creates a new instance of XMLImport */
   public function __construct($c)
   {
      parent::__construct($c);
   }
   
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->sSeriesNode);
        unset($this->sDataMember);
        unset($this->dom);
   }        

   private function XMLError($error)/* TODO throws ChartException*/
   {
      throw new Exception($error);
   }

   /**
   * Returns Series (if set) into which to import XML data
   */
   public function getSeriesNode()
   {
      return $this->sSeriesNode;
   }

   /**
   * Set Series into which to import data. If not set Import process will
   * create Series.
   */
   public function setSeriesNode($value)
   {
      $this->sSeriesNode = $value;
      for($t = 0; $t < sizeof($this->chart->getSeries()); $t++)
      {
         if($this->chart->getSeries($t)->getTitle()->equals($value))
         {
            $this->series = $this->chart->getSeries($t);
            break;
         }
      }
   }

   /*
   * Gets ValueList Datamember if set.
   */
   public function getDataMember()
   {
      return $this->sDataMember;
   }

   /**
   * Sets ValueList Datamember.
   */
   public function setDataMember($value)
   {
      $this->sDataMember = $value;
   }

   private function getSelectedNodes($node, $arg)
   {
      //Node tmpNode = node;

      for($t = 0; $t < sizeof($node->getChildNodes()); $t++)
         if($node->getChildNodes()->item($t)->getNodeName() == $arg)
            $tmpNode->appendChild($node->getChildNodes()->item($t));

      return $tmpNode->getChildNodes();
   }

   private function LoadSeriesNode($nodeDocument)  /* TODO throws InstantiationException,
       IllegalAccessException, ChartException*/
   {
        $tmpSeries = $this->series;
        $tmpSeriesTitle = "";
        $tmpSeriesTitle = $nodeDocument->getAttribute("title");

        if($tmpSeries != null)
            $tmpSeries->clear();
        else
        {
            // Create a new Series...
            $tmpClass = null;
            $tmpSeriesName = $nodeDocument->getAttribute("type");
            if ($tmpSeriesName != null)
            {
                $tmpName = $tmpSeriesName;

                for($t = 0; $t < sizeof(Utils::$seriesTypesOf); $t++)
                {
                    if((string)Utils::$seriesTypesOf[$t] == (string)$tmpName)
                    {
                        try
                        {
                          $tmpClass = Series::newFromType(Utils::$seriesTypesOf[$t]);
                        }
                        catch(Exception $e)
                        {
                        }
                        break;
                   }
                }

                if($tmpClass == null)
                    $tmpClass = Series::newFromType(Utils::$seriesTypesOf[5]);// Bar

                $tmpClass->chart = $this->chart;

                $idx = $this->chart->addSeries($tmpClass);
                $tmpSeries = $this->chart->getSeries($idx);

                // Series Title
                $tmpTitle = $nodeDocument->getAttribute("title");

                if($tmpTitle != null)
                   $tmpSeries->setTitle($tmpTitle);

                // Series Color
                $tmpColor = $nodeDocument->getAttribute("color");
                if($tmpColor != null)
                  $tmpSeries->setColor(Color::fromCode($tmpColor->getNodeValue()));
            }
        }

        // NodeList
        $tmpPoints = $this->dom->getElementsByTagName("points");

        if($tmpPoints != null)
        {
          //NodeList
          $tmpPoint = $this->dom->getElementsByTagName("point");

          if($tmpPoint == null)
          {
              $this->XMLError("No <point> nodes.");
          }
          else
          {
              $tmpName = $tmpSeries->getMandatory()->valueSource;
              if(strlen($tmpName) == 0) {
                  $tmpName = $this->getDataMember();
              }
              if(strlen($tmpName) == 0) {
                  $tmpName = $tmpSeries->getMandatory()->getName();
              }

              $tmpX = $tmpSeries->getNotMandatory()->valueSource;

              if(strlen($tmpX) == 0) {
                  $tmpX = $tmpSeries->getNotMandatory()->getName();
              }

              for($t = 0; $t < (int)$tmpPoints->item(0)->getAttribute("count"); $t++)
              {
                 $node = $tmpPoint->item($t);
                 $parentNode1 = $node->parentNode;
                 $parentNode2 = $parentNode1->parentNode;

                 if($tmpSeriesTitle == $parentNode2->getAttribute("title"))
                 {
                    // If node has attributes - points
                    if(!$tmpPoint->item($t)->hasAttributes())
                    {
                       $this->XMLError("<point> node has no data.");
                       break;
                    }
                    else
                    {
                        $tmpText = $tmpPoint->item($t)->getAttribute("text");

                        if($tmpText == "")
                          $tmpTex = "";
                        else
                          $tmpTex = $tmpText->getNodeValue();

                        $tmpColor = $tmpPoint->item($t)->getAttribute("color");

                        if($tmpColor == "")
                            $tmpCol = new Color(0,0,0,0,true);
                        else
                            $tmpCol = Color::fromCode($tmpColor);

                        // Rest of values (if exist)
                        for($tt = 2; $tt < sizeof($tmpSeries->getValuesLists()); $tt++)
                        {
                            $tmpList = $tmpSeries->getValuesLists()->getValueList($tt)->valueSource;
                            if(sizeof($tmpList) == 0)
                              $tmpList = $tmpSeries->getValuesLists()->getValueList($tt)->getName();

                              // TODO remove $tmpValue = $tmpItems->getNamedItem(tmpList);
                              $tmpValue = $tmpPoint->item($t)->getAttribute($tmpList);

                              if($tmpValue != "")
                                $tmpSeries->getValuesLists()->getValueList($tt)->tempValue = $tmpValue;
                        }

                        // Get X and Y values
                        $tmpValue = $tmpPoint->item($t)->getAttribute($tmpName);
                        $tmpValueX = $tmpPoint->item($t)->getAttribute($tmpX);

                        // Add point !
                        if($tmpValue == "")
                        {
                           if($tmpValueX == "")
                           {
                              $tmpSeries->addNull();//  .Add(tmpTex);
                           }
                           else
                           {
                              $tmpSeries->addXY($tmpValueX, 0.0, $tmpTex);
                           }
                        }
                        else
                        {
                           if($tmpValueX == null)
                           {
                              $tmpSeries->addYTextColor($tmpValue, $tmpTex, $tmpCol);
                           }
                           else
                           {
                              $tmpSeries->addXYTextColor($tmpValueX, $tmpValue, $tmpTex, $tmpCol);
                           }
                        }
                    }
               }
            }
         }
      }
      else $this->XMLError("No <points> node.");
   }

   /**
   * Passes XML Document to be parsed
   */
   public function Load($d)  /* TODO throws ChartException  */
   {
    // Load XML using DOM
    $dom = new DOMDocument;
    $dom->load($d);
    $this->dom=$dom;

    /*create the xPath object _after_  loading the xml source, otherwise the query won't work:*/
    $xPath = new DOMXPath($dom);


    if(($this->chart != null) || ($this->series != null))
    {
      /*nodelist - now get the nodes in a DOMNodeList:*/
      //$tmpSeries = $xPath->query($anXPathExpr);

      $tmpSeries = $dom->getElementsByTagName("series");

      if($tmpSeries == null) {
         $this->XMLError("No <$this->series> $this->nodes->");
      }
      else
      {
         if($this->series == null)
         {
            while($this->chart->getSeriesCount() > 0)
               $this->chart->removeSeries($this->chart->getSeries(0));
            }

            if(strlen($this->getSeriesNode()) == 0)
            {
               if(sizeof($tmpSeries) > 0)
                  for($t = 0; $t < sizeof($tmpSeries); $t++)
                  {
                     try
                     {
                        $this->LoadSeriesNode($tmpSeries->item($t), $d);
                     }
                     catch(Exception $ex)
                     {
                     }
                     catch(Exception $ex)
                     {
                     }
                     if($this->series != null)
                       break;
                  }
                  else
                     $this->XMLError("Empty <$series> $this->node->");
            }
            else
            {
               $tmpFound = false;

               if(sizeof($tmpSeries) > 0)
               {
                  for($t = 0; $t < sizeof($tmpSeries); $t++)
                  {
                     /*Node*/ $tmpTitle = $tmpSeries->item($t)->getAttribute("title");
                     if($tmpTitle != null)
                     {
                        if(strtolower($tmpTitle) == $this->getSeriesNode())
                        {
                           try
                           {
                              $this->LoadSeriesNode($tmpSeries->item($t), $d);
                           }
                           catch(Exception $ex)
                           {
                           }
                           catch(Exception $ex)
                           {
                           }
                           $tmpFound = true;
                           break;
                        }
                     }
                  }
               }

               if(!$tmpFound)
               {
                 $this->XMLError("Series " + $this->getSeriesNode() + "  found");
               }
            }
         }
      }
   }


   /* XML USING simpleXML

   /**
   * XML File to process for import
   *
   public function open($file)/* TODO throws IOException,
   ClassNotFoundException
   {

        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, "startTag", "endTag");
        xml_set_character_data_handler($xml_parser, "contents");

        if (!($fp = fopen($file, "r"))) {
            die("could not open XML input");
        }

        while ($data = fread($fp, 4096)) {     //* review 80000 tambe
          if (!xml_parse($xml_parser, $data, feof($fp))) {
                die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
          }
        }
        xml_parser_free($xml_parser);
        fclose($fp);



      DocumentBuilderFactory docBuilderFactory = DocumentBuilderFactory . newInstance();
      try
      {
         DocumentBuilder docBuilder = docBuilderFactory . newDocumentBuilder();

         try
         {
            Document m_doc = docBuilder . parse(stream);
            try
            {
               Load(m_doc);
            }
            catch(ChartException cExp)
            {
            }
         }
         catch(org . xml . sax . SAXException sar)
         {
         }
      }
      catch(javax . xml . parsers . ParserConfigurationException err)
      {
      }
      ;
   }

   function  startTag($parser, $data){
      echo "<b>";
   }

   function contents($parser, $data){
      echo $data;
   }

   function endTag($parser, $data){
      echo "</b><br />";
   }   */
}
?>