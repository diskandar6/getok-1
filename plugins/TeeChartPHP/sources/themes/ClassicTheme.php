<?php
 /**
 * Description:  This file contains the following class:<br>
 * ClassicTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
  * <p>Title: Classic Theme class</p>
  *
  * <p>Description: TeeChart for Java</p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
  
 class ClassicTheme extends DefaultTheme {
    /**
    * Description of Classic theme
    *
    * @param c IBaseChart
    */
    public function __construct($c) {
        parent::__construct($c);
    }

    public function toString() {
        return Language::getString("ClassicTheme");
    }

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

        $this->chart->getLegend()->getShadow()->setSize(0);
        $this->chart->getLegend()->getDividingLines()->setVisible(false);        
        $this->chart->getLegend()->getFont()->setSize(10);
        $this->chart->getLegend()->setTransparent(true);
        $this->chart->getLegend()->getPen()->setVisible(false);
        $this->chart->getLegend()->getGradient()->setVisible(false);
        $this->chart->getLegend()->getSymbol()->setDefaultPen(false);
        $this->chart->getLegend()->getSymbol()->getPen()->setVisible(false);

        $this->doChangeWall($this->chart->getWalls()->getLeft());
        $this->doChangeWall($this->chart->getWalls()->getRight());
        $this->doChangeWall($this->chart->getWalls()->getBack());
        $this->doChangeWall($this->chart->getWalls()->getBottom());

        $this->chart->getWalls()->getBack()->setTransparent(false);

        for ( $t = 0; $t < $this->chart->getAxes()->getCount(); ++$t) {
            $this->doChangeAxis($this->chart->getAxes()->getAxis($t));
        }

        $this->chart->getAxes()->getBottom()->getGrid()->setCentered(true);

        for ( $t = 0; $t < $this->chart->getSeriesCount(); ++$t) {
            $this->doChangeSeries($this->chart->getSeries($t));
        }

        $this->chart->getHeader()->getFont()->setSize(12);
        $this->chart->getHeader()->getFont()->setColor(Color::BLACK());
        
        ColorPalettes::applyPalette($this->chart, 5);
    }

    private function doChangeWall($wall) {
        $wall->getPen()->setVisible(true);
        $wall->getPen()->setColor(Color::BLACK());
        $wall->getPen()->setWidth(1);
        $wall->getPen()->setStyle(DashStyle::$SOLID);
        $wall->getGradient()->setVisible(false);
        $wall->setColor(Color::WHITE());
        $wall->setApplyDark(false);
        //$wall->setSize(8);
    }

    private function doChangeAxis($axis) {
        $axis->getAxisPen()->setWidth(1);
        $axis->getGrid()->setVisible(true);
        $axis->getGrid()->setColor(Color::BLACK());
        $axis->getGrid()->setStyle(DashStyle::$SOLID);

        $axis->getTicks()->setColor(Color::BLACK());

        $axis->getMinorTicks()->setVisible(false);
        $axis->getTicksInner()->setVisible(false);

        $axis->getLabels()->getFont()->setSize(10);
    }


    private function doChangeSeries($series) {
        $series->getMarks()->getGradient()->setVisible(false);
        $series->getMarks()->setTransparent(true);
        $series->getMarks()->getFont()->setSize(10);
        //$series->getMarks()->getArrow()->setColor(Color::BLACK());
    }
}
?>