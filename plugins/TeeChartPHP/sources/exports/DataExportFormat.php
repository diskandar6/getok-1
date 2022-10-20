<?php
 /**
 * Description:  This file contains the following class:<br>
 * DataExportFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * DataExportFormat class
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

 abstract class DataExportFormat {

    private $includeIndex=false;
    private $includeHeader=false;
    private $includeSeriesTitle=false;
    private $includeLabels=true;
    private $textLineSeparator = '\r\n';

    protected $hasColors;
    protected $hasLabels;
    protected $hasNoMandatory;
    protected $hasMarkPositions;
    protected $series;
    protected $chart;

    public $fileExtension = "";


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

    /// <summary>
    /// Data export constructor, named Series
    /// </summary>
    public function __construct($c=null, $s=null) {

        $this->chart = $c;

        if ($s!=null) {
          $this->series = $s;
        }
    }
    
    public function __destruct()    
    {        
        unset($this->includeIndex);
        unset($this->includeHeader);
        unset($this->includeSeriesTitle);
        unset($this->includeLabels);
        unset($this->textLineSeparator);
        unset($this->hasColors);
        unset($this->hasLabels);
        unset($this->hasNoMandatory);
        unset($this->hasMarkPositions);
        unset($this->series);
        unset($this->chart);
        unset($this->fileExtension);
    }       

    public function lostOwnership($clipboard, $contents) {
    }

    protected function prepare() {
        $tmp = null;

        if ($this->series != null) {
            $tmp = $this->series;
        } else
        if ($this->chart->getSeriesCount() > 0) {
            $i = 0;

            while (($i < $this->chart->getSeriesCount())) {
                if ($this->chart->getSeries($i)->getCount() != 0) {
                    $tmp = $this->chart->getSeries($i);
                    break;
                }
                $i++;
            }
        }

        if ($tmp != null) {
            $this->seriesGuessContents($tmp);
        }

        if (!$this->includeLabels) {
            $this->hasLabels = false;
        }
    }

    private function seriesGuessContents($aSeries) {
        $this->hasNoMandatory = $this->hasNoMandatoryValues($aSeries);
        $this->hasColors = $this->hasColors($aSeries);
        $this->hasLabels = $this->hasLabels($aSeries);
        $this->hasMarkPositions = $aSeries->getMarks()->getPositions()->existCustom();
    }

    private function maxSeriesCount() {
        if ($this->series != null) {
            return $this->series->getCount();
        } else {
            $tmpResult = -1;

            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                 $s = $this->chart->getSeries($t);
                if ($s->getCount() > $tmpResult) {
                    $tmpResult = $s->getCount();
                }
            }
            return $tmpResult;

        }
    }

    // Returns if a Series has "X" values (or Y values for HorizBar series)
    private function hasNoMandatoryValues($aSeries) {

        $s = $aSeries;

        if ($s->getCount() > 0) {
            $tmp = $s->getNotMandatory();

            if (($tmp->getFirst() == 0) && ($tmp->getLast() == $s->getCount() - 1)) {

                 $tmpCount = ($s->getCount() - 1 < 10000) ? $s->getCount() - 1 :
                               10000;

                for ( $t = 0; $t <= $tmpCount; $t++) {
                    if ($tmp->getValue($t) != $t) {
                        return true;
                    }
                }
            } else {
                return true;
            }
        }

        return false;
    }

    // Returns if a Series has Colors
    private function hasColors($aSeries) {
        $s = $aSeries;
        $tmpSeriesColor = $s->getColor();

        $tmpCount = ($s->getCount() - 1 < 10000) ? $s->getCount() - 1 : 10000;

        for ( $t = 0; $t <= $tmpCount; $t++) {
             $tmpColor = $s->getValueColor($t);

            if ((!$tmpColor->isEmpty()) &&
                ($this->tmpColor != $tmpSeriesColor)) {
                return true;
            }
        }
        return false;
    }

    // Returns if a Series has labels
    private function hasLabels($aSeries) {

        if (sizeof($aSeries->getLabels()) > 0) {

            $tmpCount = ($aSeries->getCount() - 1 < 10000) ?
                           $aSeries->getCount() - 1 :
                           10000;

            for ( $t = 0; $t <= $tmpCount; $t++) {
                $labels=$aSeries->getLabels();
                if (strlen($labels[$t]) != 0) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function pointToString($index)
    {}

    protected function getContent() {
        $this->prepare();

        $tmpResult="";

        $tmp = $this->maxSeriesCount();

        for ( $t = 0; $t < $tmp; $t++) {
            $tmpResult = $tmpResult . (string)$this->pointToString($t);
            $tmpResult = $tmpResult . (string)$this->textLineSeparator;
        }

        return $tmpResult;
    }

    /// <summary>
    /// Save Chart to file with Data export format
    /// </summary>
    /// <param name="fileName">string eg. "c:\tempFiles\MyChart.xml"</param>
    public function save($fileName) /* TODO throw IOException*/ {

        $f= fopen($fileName,'w');
        if($f==false)
        {
          	die("Unable to create file");
        }
        else
        {
          if (file_exists($fileName)) {
// TODO             if (Utils::yesNo("File $exists-> " + "Overwrite ($this->y/$this->n)?"))
                $this->writeData($f);
          }
          else
          {
            $this->writeData($f);
          }
        }
    }

    /// <summary>
    /// Save Chart to stream with Data export format
    /// </summary>
    public function writeData($fw) /* tODO throws IOException*/ {

      fwrite($fw, $this->getContent());
      fclose($fw);
    }

    /// <summary>
    /// return descriptive name of Dataformat
    /// </summary>
    protected function getDataFormat() {
        //TODO: ??
        return ""; // $this->DataFormats->Text;
    }

    /// <summary>
    /// Copy Chart data to clipboard
    /// </summary>
    public function copyToClipboard() {
        $this->Toolkit->getDefaultToolkit()->getSystemClipboard()->setContents(
                new StringSelection($this->getContent()), $this);
    }

    /// <summary>
    /// Include the Series index with exported data
    /// </summary>
    public function getIncludeIndex() {
        return $this->includeIndex;
    }

    public function setIncludeIndex($value) {
        $this->includeIndex = $value;
    }

    /// <summary>
    /// Include the Series valuelist name with exported data
    /// </summary>
    public function getIncludeHeader() {
        return $this->includeHeader;
    }

    public function setIncludeHeader($value) {
        $this->includeHeader = $value;
    }

    /// <summary>
    /// Include the Series title with exported data
    /// </summary>
    public function getIncludeSeriesTitle() {
        return $this->includeSeriesTitle;
    }

    public function setIncludeSeriesTitle($value) {
        $this->includeSeriesTitle = $value;
    }

    /// <summary>
    /// Include data Labels with exported data
    /// </summary>
    public function getIncludeLabels() {
        return $this->includeLabels;
    }

    public function setIncludeLabels($value) {
        $this->includeLabels = $value;
    }

    public function getFilterFiles() {
        return "";
    }

    /// <summary>
    /// Line separator for ascii export formats
    /// </summary>
    public function getTextLineSeparator() {
        return $this->textLineSeparator;
    }

    public function setTextLineSeparator($value) {
        $this->textLineSeparator = $value;
    }

    /// <summary>
    /// Series whose data is to be exported
    /// </summary>
    public function getSeries() {
        return $this->series;
    }

    public function setSeries($value) {
        $this->series = $value;
    }

    public function getFileExtension() {
        return $this->fileExtension;
    }

    public function setFileExtension($value) {
        $this->fileExtension = $value;
    }
}

?>