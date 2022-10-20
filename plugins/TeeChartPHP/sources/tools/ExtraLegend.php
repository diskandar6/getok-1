<?php
 /**
 * Description:  This file contains the following class:<br>
 * ExtraLegend class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * ExtraLegend class
 *
 * Description: ExtraLegend tool
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

 class ExtraLegend extends ToolSeries {

    private $legend;

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

    /**
    * The class constructor.
    */
    public function __construct($c=null) {
        parent::__construct($c);
    }

    /**
    * Defines the Legend characteristics.
    *
    * @return Legend
    */
    public function getLegend() {
        if ($this->legend == null) {
            $this->legend = new Legend($this->chart);
            $this->legend->setCustomPosition(true);
            $this->legend->setLegendStyle(LegendStyle::$VALUES);
        }
        return $this->legend;
    }

    /**
    * Defines the Legend characteristics.
    *
    * @param value Legend
    */
    public function setLegend($value) {
        $this->legend->assign($value);
    }

    public function chartEvent($ce) {
        parent::chartEvent($ce);
        // TODO
        if (/*($ce->getID()==$tmpChartDrawEvent->PAINTED) &&*/
            ($ce->getDrawPart()==ChartDrawEvent::$CHART)) {
            if ($this->chart != null && $this->getSeries() != null) {
                $this->getLegend()->setSeries($this->getSeries());
                if ($this->getLegend()->getVisible()) {
                    $this->drawExtraLegend();
                }
            }
        }
    }

    private function drawExtraLegend() {
        $rect = $this->chart->getChartRect();
        $tmp = $this->chart->getLegend();
        $this->chart->setLegend($this->getLegend());
        $rect = $this->chart->doDrawLegend($this->chart->getGraphics3D(), $rect);
        $this->chart->setLegend($tmp);
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("ExtraLegendTool");
    }

    /**
    * Gets detailed descriptive text.
    *
    * @return String
    */
    public function getSummary() {
        return Language::getString("ExtraLegendSummary");
    }
}
?>