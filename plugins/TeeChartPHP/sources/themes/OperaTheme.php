<?php
 /**
 * Description:  This file contains the following class:<br>
 * OperaTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 * <p>Title: Opera Theme class</p>
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

 class OperaTheme extends DefaultTheme {

    /**
     * Description of Classic theme
     *
     * @param c IBaseChart
     */
    public function __construct($c) {
        parent::__construct($c);    
    }

    public function toString() {
        return Language::getString("OperaTheme");
    }

    public function apply() {
        parent::apply();

        $this->chart->getPanel()->getGradient()->setVisible(true);        
        $this->chart->getPanel()->getGradient()->setEndColor(new Color(220,220,220));
        //$this->chart->getPanel()->getGradient()->setMiddleColor(Utils::rgbhex(255,234,234);        
        $this->chart->getPanel()->getGradient()->setStartColor(new Color(255,255,255));

        //$this->chart->getLegend()->getFont()->setName("Verdana");
        $this->chart->getLegend()->getSymbol()->getPen()->setVisible(true);

        $this->chart->getWalls()->getBack()->setTransparent(true);
        $this->chart->getWalls()->getBack()->getGradient()->setDirection(GradientDirection::$VERTICAL);
        $this->chart->getWalls()->getBack()->getGradient()->setEndColor(Utils::hex2rgb('FFFFFFFF'));
      //$this->chart->getWalls()->getBack()->getGradient()->setMiddleColor(Color::EMPTYCOLOR());             
        $this->chart->getWalls()->getBack()->getGradient()->setStartColor(Utils::hex2rgb('FFEAEAEA'));    
        $this->chart->getWalls()->getBack()->getGradient()->setVisible(true);               
        
        $this->chart->getWalls()->getRight()->setColor(Utils::hex2rgb('FFC0C0C0'));
        
        for ($t = 0; $t < $this->chart->getAxes()->getCount(); ++$t) {
            $this->doChangeAxis($this->chart->getAxes()->getAxis($t));
        }

        for ($t = 0; $t < $this->chart->getSeriesCount(); ++$t) {
            $this->doChangeSeries($this->chart->getSeries($t));
        }
        
        //$this->chart->getHeader()->getFont()->setName("Verdana");
        $this->chart->getHeader()->getFont()->setColor(Utils::hex2rgb('FF000080'));
        $this->chart->getHeader()->getPen()->setVisible(true);        
        
        $this->chart->getAspect()->setSmoothingMode(true);  

        // Sets Opera Palette Colors        
        ColorPalettes::applyPalette($this->chart, 1);    
    }

    private function doChangeAxis($axis) {
        $axis->getAxisPen()->setColor(Utils::hex2rgb('FFA9A9A9'));
        
        $axis->getGrid()->setColor(Utils::hex2rgb('FF404040'));
        $axis->getGrid()->setStyle(DashStyle::$DASH);
        
        //$axis->getLabels()->getFont()->setName("Verdana");
        
        $axis->getTicksInner()->setColor(Utils::hex2rgb('FFA9A9A9'));        
        $axis->getTicks()->setLength(4);

        //$axis->getTitle()->getFont()->setName("Verdana");
    }

    private function doChangeSeries($series) {
        //$series->getMarks()->getFont()->setName("Verdana");
    }
}

?>