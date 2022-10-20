<?php
 /**
 * Description:  This file contains the following class:<br>
 * XMLFormat class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * XMLFormat class
 *
 * Description: Chart data export to XML
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class XMLFormat extends DataExportFormat {

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
        
        $this->setFileExtension("xml");
    }

    public function getFilterFiles() {
        return "XMLFilter"; // TODO $this->Language->getString("XMLFilter");
    }

    private function get($aList, $index) {
        return " " . $aList->getName() . "=\"" . (string)($aList->getValue($index)) .
                "\"";
    }

    // Not used.
    protected function pointToString($index) {
        return "";
    }

    private function getPointString($index, $aSeries) {

        $tmpResult = new StringBuilder();
        $tmpResult->append(($this->getIncludeIndex()) ?
                         "index=\"" . (string)($index) . "\"" :
                         "");

        // the point Label text, if exists
        if ($this->hasLabels) {
            $labels=$aSeries->getLabels();
            $tmpResult->append(" text=\"" . $labels[$index] .
                             "\"");
        }

        // the "X" point value, if exists
        if ($this->hasNoMandatory) {
            $tmpResult->append($this->get($aSeries->getNotMandatory(), $index));
        }

        // the "Y" point value
        $tmpResult->append($this->get($aSeries->getMandatory(), $index));

        // write the rest of values (always)
        for ( $tt = 2; $tt < sizeof($aSeries->getValuesLists()); $tt++) {
            $tmpResult->append($this->get($aSeries->getValueList($tt), $index));
        }

        return $tmpResult->toString();
    }

    private function seriesPoints($aSeries) {
         $tmpResult = new StringBuilder(); // capacity 1

        if ($aSeries->getCount() > 0) {
            for ( $t = 0; $t < $aSeries->getCount(); $t++) {
                $tmpResult->append("<point " . $this->getPointString($t, $aSeries) . "/>" .
                                 $this->getTextLineSeparator());
            }
        }

        return $tmpResult->toString();
    }

    private function XMLSeries($aSeries) {
        return
                "<series title=\"" . $aSeries->toString() . "\" type=\"" .
                get_class($aSeries) .
                "\">" . $this->getTextLineSeparator() .
                "<points count=\"" . (string)($aSeries->getCount()) .
                "\">" .
                $this->getTextLineSeparator() .
                $this->seriesPoints($aSeries) .
                "</points>" . $this->getTextLineSeparator() .
                "</series>" . $this->getTextLineSeparator() . $this->getTextLineSeparator();
    }

    protected function getContent() {
        $this->prepare();
        $tmpResult = new StringBuilder();

        if ($this->series != null) {
            $tmpResult->append($this->XMLSeries($this->series));
        } else {
            $tmpResult->append("<chart>" . $this->getTextLineSeparator());

            for ( $t = 0; $t < $this->chart->getSeriesCount(); $t++) {
                 $s = $this->chart->getSeries($t);
                $tmpResult->append($this->XMLSeries($s));
            }

            $tmpResult->append("</chart>");
        }

        return $tmpResult->toString();
    }
}

?>