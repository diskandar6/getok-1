<?php
 /**
 * Description:  This file contains the following class:<br>
 * GrayscaleTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 * <p>Title: Grayscale Theme class</p>
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

 class GrayscaleTheme extends DefaultTheme {

    /**
     * Description of Classic theme
     *
     * @param c IBaseChart
     */
    public function __construct($c) {
        parent::__construct($c);                  
    }

    public function toString() {
        return Language::getString("GrayscaleTheme");
    }

    public function apply() {
        parent::apply();

        $this->chart->getPanel()->getBevel()->setOuter(BevelStyle::$NONE);

        $this->chart->getPanel()->getPen()->setVisible(true);
        $this->chart->getPanel()->getPen()->setColor(Color::WHITE());

        $this->chart->getLegend()->getShadow()->setSize(0);
        $this->chart->getLegend()->getDividingLines()->setVisible(true);
        $this->chart->getLegend()->getFont()->setSize(10);
        $this->chart->getLegend()->setTransparent(true);

        $this->doChangeWall($this->chart->getWalls()->getLeft());
        $this->doChangeWall($this->chart->getWalls()->getRight());
        $this->doChangeWall($this->chart->getWalls()->getBack());
        $this->doChangeWall($this->chart->getWalls()->getBottom());

        $this->chart->getWalls()->getBack()->setTransparent(false);
        
        for ($t = 0; $t < $this->chart->getAxes()->getCount(); ++$t) {
            $this->doChangeAxis($this->chart->getAxes()->getAxis($t));
        }
             
        for ($t = 0; $t < $this->chart->getSeriesCount(); ++$t) {
            $this->doChangeSeries($this->chart->getSeries($t));
        }
        
        $this->chart->getHeader()->getGradient()->setVisible(true);
        $this->chart->getHeader()->getGradient()->setEndColor(Color::GRAY());

        $this->chart->getHeader()->getFont()->setSize(12);
        $this->chart->getHeader()->getFont()->setColor(Color::BLACK());
        
        $this->chart->getHeader()->setColor(Color::WHITE());

        ColorPalettes::_applyPalette($this->chart, Theme::getGrayscalePalette());
    }

    private function doChangeWall($wall) {
        $wall->setColor(Color::WHITE());
        $wall->setApplyDark(false);
        $wall->setSize(0);
    }

    private function doChangeAxis($axis) {
        $axis->getAxisPen()->setWidth(1);
        
        $axis->getGrid()->setColor(Color::BLACK());
        $axis->getGrid()->setStyle(DashStyle::$SOLID);

        $axis->getMinorTicks()->setVisible(false);
        $axis->getTicksInner()->setVisible(false);
    }


    private function doChangeSeries($series) {
        $series->getMarks()->setTransparent(true);
        $series->getMarks()->getFont()->setSize(10);
        $series->getMarks()->getArrow()->setColor(Color::BLACK());
    }
}

?>