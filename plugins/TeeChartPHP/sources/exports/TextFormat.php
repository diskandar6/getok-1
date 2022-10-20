<?php
 /**
 * Description:  This file contains the following class:<br>
 * TextFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * TextFormat class
 *
 * Description: Chart data export to Text
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class TextFormat extends DataExportFormat {

    public static function textDelimiter(){
        return Language::getString("TabDelimiter");
    }

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
        
        $this->setFileExtension("txt");
    }

    protected function getContent() {
        $this->prepare();
        (string)$tmpResult="";

        $tmpResult=$tmpResult . ($this->getIncludeSeriesTitle() ?
                         ((string)$this->headerTitle() . (string)$this->getTextLineSeparator()) :
                         "");
        $tmpResult=$tmpResult . ($this->getIncludeHeader() ? ((string)$this->header() . (string)$this->getTextLineSeparator()) :
                         "");

        $tmpResult= $tmpResult . (parent::getContent() . $this->getTextLineSeparator());

        return (string)$tmpResult;
    }

    public function getFilterFiles() {
        return Language::getString("TextFilter");
    }

    private function headerSeriesTitle($aSeries) {
        $tmpResult="";

        if ($this->hasLabels) {
            $tmpResult=$tmpResult . $aSeries->toString() . self::textDelimiter();
        }

        if ($this->hasNoMandatory && !$this->hasLabels) {
            $tmpResult=$tmpResult . $aSeries->toString() . self::textDelimiter();
        }

        if (!$this->hasLabels && !$this->hasNoMandatory) {
            $tmpResult=$tmpResult . $aSeries->toString() . self::textDelimiter();
        } else {
            $tmpResult=$tmpResult . self::textDelimiter();
        }

        for ( $t = 2; $t < sizeof($aSeries->getValuesLists()); $t++) {
            $tmpResult=$tmpResult . self::textDelimiter();
        }

        return $tmpResult;
    }


    private function headerSeries($aSeries) {
         $tmpResult = "";

        if ($this->hasLabels) {
            $tmpResult=$tmpResult . Language::getString("Text");
            $tmpResult=$tmpResult . self::textDelimiter();
        }

        if ($this->hasNoMandatory) {
            $tmpResult=$tmpResult . $aSeries->getNotMandatory()->getName();
            $tmpResult=$tmpResult . self::textDelimiter();
        }

        $tmpResult=$tmpResult . $aSeries->getMandatory()->getName();

        for ( $t = 2; $t < sizeof($aSeries->getValuesLists()); $t++) {
            $tmpResult=$tmpResult . (self::textDelimiter() . $aSeries->getValueList($t)->getName());
        }

        return $tmpResult;
    }

    private function headerTitle() {
        //CDI - each column should be headed by the name of the valuelist
        //new header line with Series.ToString() added.
         $tmpResult="";

        if ($this->getIncludeIndex()) {
            $tmpResult=$tmpResult . self::textDelimiter();
        }

        if ($this->series != null) {
            $tmpResult=$tmpResult . $this->headerSeriesTitle($this->series);
        } else {
            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                $tmpResult=$tmpResult . $this->headerSeriesTitle($this->chart->getSeries($t));
            }
        }

        $length = strlen($tmpResult);

        $tmpResult=substr($tmpResult,0,$length-1);

        return $tmpResult;
    }

    private function header() {
        $tmpResult = "";

        $tmpResult=$tmpResult . ($this->getIncludeIndex() ? /* TODO $this->Language->getString(*/"Index"/*)*/ : "");

        if (strlen($tmpResult) != 0) {
            $tmpResult=$tmpResult . self::textDelimiter();
        }

        if ($this->series != null) {
            $tmpResult=$tmpResult . $this->headerSeries($this->series);
        } else
        if ($this->chart->getSeriesCount() > 0) {

            $tmpResult=$tmpResult . $this->headerSeries($this->chart->getSeries(0));

            for ( $t = 1; $t < $this->chart->getSeriesCount(); $t++) {
                $tmpResult=$tmpResult . (self::textDelimiter() . $this->headerSeries($this->chart->getSeries($t)));
            }
        }

        return $tmpResult;
    }

    protected function pointToString($index) {
         $result = $this->getIncludeIndex() ? (string)$index : "";

        // Export Series data
        if ($this->series != null) {
            $result= $result . self::textDelimiter()+$this->doSeries($index, $this->series);
        } else {
            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                $result= $result . self::textDelimiter() . $this->doSeries($index, $this->chart->getSeries($t));
            }
        }

        if(substr($result,0,strlen(self::textDelimiter()))==self::textDelimiter()) {
            $result= str_replace(self::textDelimiter(), "",$result);
        }

        return (string)$result;
    }

    private function add($st, $result) {
        return $result . self::textDelimiter() . $st;
    }

    private function doSeries($index, $aSeries) {

         $result="";
        //tmpNum++;

        /* the point Label text, if exists */
        if ( /*($this->tmpNum==1)&&*/($this->hasLabels)) { //$this->CDI $this->let'    for  $the $this->series
            if ($aSeries->getCount() > $index) {
                $labels=$aSeries->getLabels();
                (string)$result=$this->add($labels[$index], $result);
            } else {
                (string)$result=$this->add("", $result);
            }
        }

        /* the "X" point value, if exists */
        //add(FloatToStr(ASeries.NotMandatoryValueList.Value[Index]));
        if ($this->hasNoMandatory) {
            if ($aSeries->getCount() > $index) {
                (string)$result=$this->add($aSeries->getNotMandatory()->getValue($index),
                    $result);
            } else {
                (string)$result=$this->add("", $result);
            }
        }

        /* the "Y" point value */
        if ($aSeries->getCount() > $index) {
            (string)$result=$this->add($aSeries->getMandatory()->getValue($index), $result);
        } else {
            (string)$result=$this->add("", $result);
        }

        /* write the rest of values (always) */
        for ( $tt = 2; $tt < sizeof($aSeries->getValuesLists()); $tt++) {

            if ($aSeries->getCount() > $index) {
                $result = $result . self::textDelimiter() .
                        $aSeries->getValueList($tt)->getValue($index);
            } else {
                $result = $result . self::textDelimiter() . "";
            }
        }

        if(substr($result,0,strlen(self::textDelimiter()))==self::textDelimiter()) {
            $result= str_replace(self::textDelimiter(), "",$result);
        }

        return (string)$result;
    }
}
?>