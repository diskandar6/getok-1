<?php
 /**
 * Description:  This file contains the following class:<br>
 * BlueSkyTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: BlueSkyTheme class</p>
 *
 * <p>Description: Summary description for BlueSkyTheme.</p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */

 class BlueSkyTheme extends DefaultTheme {

    public function __construct($c) {
        parent::__construct($c);  
    }

    public function apply() {
        $this->chart->getLegend()->getShadow()->setVisible(true);
        //$this->chart->getPanel()->getShadow()->setColor(Color::BLACK());        
        
        $this->chart->getPanel()->getBevel()->setInner(BevelStyle::$LOWERED);        
        $this->chart->getPanel()->getBevel()->setOuter(BevelStyle::$NONE);        
        $this->chart->getPanel()->getBevel()->setWidth(2);        
        
        $this->chart->getWalls()->getBack()->setVisible(true);
        $this->chart->getWalls()->getBack()->setTransparent(false);
        

        $this->changeWall($this->chart->getWalls()->getBack(),Utils::hex2rgb('FCECCF'));
        $this->changeWall($this->chart->getWalls()->getBottom(),Utils::hex2rgb('038CFC'));        
        $this->changeWall($this->chart->getWalls()->getLeft(), Utils::hex2rgb('8080FF'));
        $this->chart->getWalls()->getBack()->setSize(2);     
        
        $this->resetGradient($this->chart->getPanel()->getGradient());
        
        $this->chart->getLegend()->getDividingLines()->setColor(Color::SILVER());
        $this->chart->getLegend()->getDividingLines()->setVisible(true);
        $this->chart->getLegend()->getFont()->setColor(Utils::hex2rgb('000064'));
// TODO         $this->chart->getLegend()->getGradient()->setDirection(GradientDirection.HORIZONTAL);
        //$this->chart->getLegend()->getGradient()->setDirection('horizontal');
        //$this->chart->getLegend()->getGradient()->setEndColor(Utils::hex2rgb('FFFFDBCE'));
        //$this->chart->getLegend()->getGradient()->setMiddleColor(Utils::hex2rgb('0xFFE9E6E0'));
        //$this->chart->getLegend()->getGradient()->setStartColor(Utils::hex2rgb('FFEAF3FF'));
        //$this->chart->getLegend()->getGradient()->setVisible(true);
        $this->chart->getLegend()->getShadow()->setHeight(5);
        $this->chart->getLegend()->getShadow()->setWidth(4);
        $this->chart->getLegend()->getShadow()->setTransparency(50);
        $this->chart->getLegend()->getSymbol()->setSquared(true);
        
        $this->chart->getHeader()->setColor(Color::BLACK());
        $this->chart->getHeader()->setTransparency(70);
        $this->chart->getHeader()->getFont()->setColor(Color::SILVER());
        $this->chart->getHeader()->getFont()->setSize(12);
        $this->chart->getHeader()->getPen()->setVisible(true);
        $this->chart->getHeader()->getPen()->setWidth(2);
        $this->chart->getHeader()->getPen()->setColor(Utils::hex2rgb('FBDD99'));
        //$this->chart->getHeader()->getGradient()->setEndColor(Color::BLACK());
        //$this->chart->getHeader()->getGradient()->setMiddleColor(Utils::hex2rgb('0xFF400080'));
        //$this->chart->getHeader()->getGradient()->setStartColor(Color::WHITE());
        //$this->chart->getHeader()->getGradient()->setVisible(true);
        $this->chart->getHeader()->getShadow()->setSize(4);
        $this->chart->getHeader()->getShadow()->setTransparency(70);

        for ($t = 0; $t < $this->chart->getAxes()->getCount(); ++$t) {
            $this->changeAxis($this->chart->getAxes()->getAxis($t));
        }       

        ColorPalettes::_applyPalette($this->chart, Theme::getPastelsPalette());
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return "Blues";
    }

    public function resetGradient($chartGradient) {
        $chartGradient->setVisible(true);
        $chartGradient->setStartColor(Utils::hex2rgb('2003A5'));
        $chartGradient->setEndColor(Color::WHITE());
        //$chartGradient->setMiddleColor(Utils::hex2rgb('0xFF80FFFF'));
    }

    public function changeWall($chartWall, $aColor) {
        $chartWall->getPen()->setVisible(false);
        $chartWall->setColor($aColor);
        $chartWall->setApplyDark(true);
        $chartWall->setSize(1);
    }   

    public function changeAxis($chartAxis) {
        $chartAxis->getAxisPen()->setWidth(1);
        $chartAxis->getAxisPen()->setColor(Color::NAVY());
        
        $chartAxis->getGrid()->setColor(Utils::hex2rgb('B9B9FF'));
        $chartAxis->getGrid()->setStyle(DashStyle::$DOT);
        
        $chartAxis->getLabels()->getFont()->setColor(Color::NAVY());
        //$f->setName("Tahoma");
        //$f->setBold(true);
        //$f->setColor(Color::NAVY());
        
        $chartAxis->getMinorGrid()->setVisible(false);
        $chartAxis->getMinorGrid()->setColor(Utils::hex2rgb('E5E5E5'));        
        $chartAxis->setMinorTickCount(7);
        
        $chartAxis->getTicks()->setLength(5);
        
        $chartAxis->getGrid()->setColor(Color::BLUE());
        $chartAxis->getGrid()->setStyle(DashStyle::$DOT);
    }
}

?>