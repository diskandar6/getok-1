<?php
 /**
 * Description:  This file contains the following class:<br>
 * WebTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 * <p>Title: Web Theme class</p>
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

 class WebTheme extends DefaultTheme {

    /**
     * Description of Classic theme
     *
     * @param c IBaseChart
     */
    public function __construct($c) {
        parent::__construct($c);    
    }

    public function toString() {
        return Language::getString("WebTheme");
    }
        
    public function apply() {
        parent::apply();
        
        $this->chart->getPanel()->getBevel()->setOuter(BevelStyle::$NONE);
        $this->chart->getPanel()->getPen()->setVisible(true);        
        $this->chart->getPanel()->setColor(Color::fromRgb(196, 196, 196));
        
        $this->chart->getLegend()->getShadow()->setColor(Color::DARK_GRAY());
        //$this->chart->getLegend()->getFont()->setName("Lucida Console");
        $this->chart->getLegend()->getFont()->setSize(9);
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

        //chart->getHeader()->getFont()->setName("Lucida Console");
        $this->chart->getHeader()->getFont()->setSize(10);
        $this->chart->getHeader()->getFont()->setColor(Color::BLACK());
        $this->chart->getHeader()->getFont()->setBold(true);

        ColorPalettes::_applyPalette($this->chart, Theme::getWebPalette());
    }

    private function doChangeWall($wall) {
        $wall->getPen()->setColor(Color::WHITE());
    }

    private function doChangeAxis($axis) {                
        $axis->getGrid()->setVisible(true);
        $axis->getGrid()->setColor(Color::fromRgb(196, 196, 196));
        $axis->getGrid()->setStyle(DashStyle::$SOLID);

        $axis->getTicks()->setColor(Color::BLACK());

        $axis->getMinorTicks()->setLength(-3);
        $axis->getTicks()->setLength(0);
        $axis->getTicksInner()->setLength(6);

        //$axis->getLabels()->getFont()->setName("Lucida Console");
        $axis->getLabels()->getFont()->setSize(10);
        
    }

    private function doChangeSeries($series) {
        //$series->getMarks()->getGradient()->setVisible(true);
        //$series->getMarks()->getGradient()->setStartColor(Color::SILVER());
        //$series->getMarks()->getFont()->setName("Lucida Console");
    }
}
?>