<?php
 /**
 * Description:  This file contains the following class:<br>
 * ExcelTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: ExcelTheme class</p>
  *
  * <p>Description: Summary description for ExcelTheme.</p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
  
 class ExcelTheme extends DefaultTheme {

    public function __construct($c) {
        parent::__construct($c);
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return " Excel";
    }

    /**
    * Applies Excel-like visual formatting properties to Chart parameter.
    */
    public function apply() {
        parent::apply();
        
        $this->chart->getPanel()->getBevel()->setInner(BevelStyle::$NONE);
        $this->chart->getPanel()->getBevel()->setOuter(BevelStyle::$NONE);
        $this->chart->getPanel()->setBorderRound(0);
        $this->chart->getPanel()->getPen()->setVisible(true);
        $this->chart->getPanel()->getPen()->setWidth(1);
        $this->chart->getPanel()->getPen()->setStyle(DashStyle::$SOLID);
        $this->chart->getPanel()->getPen()->setColor(Color::BLACK());

        $this->chart->getPanel()->setColor(Color::WHITE());
        $this->chart->getPanel()->getGradient()->setVisible(false);

        $this->chart->getLegend()->getShadow()->setHeight(0);
        $this->chart->getLegend()->getShadow()->setWidth(0);
        $this->chart->getLegend()->getDividingLines()->setVisible(false);
        //$this->chart->getLegend()->getFont()->setName("Arial");
        $this->chart->getLegend()->getFont()->setSize(10);
        $this->chart->getLegend()->getPen()->setColor(Color::BLACK());
        $this->chart->getLegend()->getPen()->setWidth(1);
        $this->chart->getLegend()->getPen()->setStyle(DashStyle::$SOLID);
        $this->chart->getLegend()->getPen()->setVisible(true);             
        $this->chart->getLegend()->setTransparent(false);
        $this->chart->getLegend()->getGradient()->setVisible(false);

        $this->doChangeWall($this->chart->getWalls()->getLeft(), Color::SILVER());
        $this->doChangeWall($this->chart->getWalls()->getRight(), Color::SILVER());
        $this->doChangeWall($this->chart->getWalls()->getBack(), Color::SILVER());
        $this->doChangeWall($this->chart->getWalls()->getBottom(), Color::DARK_GRAY());

        $this->chart->getWalls()->getBack()->setTransparent(false);

        for ( $t = 0; $t < $this->chart->getAxes()->getCount(); ++$t) {
            $this->doChangeAxis($this->chart->getAxes()->getAxis($t));
        }

        $this->chart->getAxes()->getTop()->getGrid()->setVisible(false);
        $this->chart->getAxes()->getBottom()->getGrid()->setVisible(false);
        $this->chart->getAxes()->getBottom()->getGrid()->setCentered(true);

        for ( $t = 0; $t < $this->chart->getSeriesCount(); ++$t) {
            $this->doChangeSeries($this->chart->getSeries($t));
        }

        //$this->chart->getHeader()->getFont()->setName("Arial");
        $this->chart->getHeader()->getFont()->setSize(10);
        $this->chart->getHeader()->getFont()->setColor(Color::BLACK());

        ColorPalettes::applyPalette($this->chart, 2);
    }

    private function doChangeWall($chartWall, $aColor) {
        $chartWall->getPen()->setVisible(true);
        $chartWall->getPen()->setColor(Color::DARK_GRAY());
        $chartWall->getPen()->setWidth(1);
        $chartWall->getPen()->setStyle(DashStyle::$SOLID);
        $chartWall->getGradient()->setVisible(false);
        $chartWall->setColor($aColor);
        $chartWall->setApplyDark(false);
    }

    private function doChangeAxis($chartAxis) {
        $chartAxis->getGrid()->setWidth(1);
        $chartAxis->getGrid()->setVisible(true);
        $chartAxis->getGrid()->setColor(Color::BLACK());
        $chartAxis->getGrid()->setStyle(DashStyle::$SOLID);
        $chartAxis->getGrid()->setCentered(false);

        $chartAxis->getTicks()->setColor(Color::BLACK());

        $chartAxis->getMinorTicks()->setVisible(false);
        $chartAxis->getTicksInner()->setVisible(false);

        //$chartAxis->getLabels()->getFont()->setName("Arial");
        $chartAxis->getLabels()->getFont()->setSize(10);
    }

    private function doChangeSeries($chartSeries) {
        $chartSeries->getMarks()->getGradient()->setVisible(false);
        $chartSeries->getMarks()->setTransparent(true);
        //$chartSeries->getMarks()->getFont()->setName("Arial");
        $chartSeries->getMarks()->getFont()->setSize(10);
        $chartSeries->getMarks()->getArrow()->setColor(Color::WHITE());        
    }
}
?>