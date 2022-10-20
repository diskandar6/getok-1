<?php
 /**
 * Description:  This file contains the following class:<br>
 * BlackIsBackTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: BlackIsBack Theme class</p>
 *
 * <p>Description: Summary description for BlackIsBackTheme.</p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
 
class BlackIsBackTheme extends OperaTheme {

    public function __construct($c) {
        parent::__construct($c);    
    }

    public function apply() {       
        parent::apply(); 
        $this->resetGradient($this->chart->getPanel()->getGradient());
        
        //$this->chart->getPanel()->getGradient()->setEndColor(Utils::hex2rgb('0xFF464646'));
                
        $this->changeWallPen($this->chart->getWalls()->getBack());
        $this->changeWallPen($this->chart->getWalls()->getBottom());        
        $this->changeWallPen($this->chart->getWalls()->getLeft());                

        $this->chart->getLegend()->getFont()->setColor(Color::WHITE());       
        $this->resetGradient($this->chart->getLegend()->getGradient());                
        $this->chart->getLegend()->getShadow()->setWidth(0);                
        $this->chart->getLegend()->getPen()->setVisible(false);
        $this->chart->getHeader()->getFont()->setColor(Color::WHITE());                

        for ($t = 0; $t < $this->chart->getAxes()->getCount(); ++$t) {
            $this->changeAxis($this->chart->getAxes()->getAxis($t));
        }      
        
        for ($t = 0; $t < $this->chart->getSeriesCount(); ++$t) {
            $this->doChangeSeries($this->chart->getSeries($t));
        }

        ColorPalettes::_applyPalette($this->chart, Theme::getOnBlackPalette());
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return "BlackIsBack";
    }

    public function resetGradient($chartGradient) {
        $chartGradient->setVisible(true);
        $chartGradient->setStartColor(new Color(70,70,70));
        $chartGradient->setEndColor(new Color(70,70,70));
        //$chartGradient->setMiddleColor(Utils::hex2rgb('0x00000000'));
    }

    public function changeWallPen($chartWall) {    
        $chartWall->getPen()->setVisible(false);        
        //$this->resetGradient($chartWall->getGradient());
    }   

    public function changeAxis($chartAxis) {
        $chartAxis->getAxisPen()->setColor(Utils::hex2rgb('0xFF828282'));
        
        $chartAxis->getGrid()->setColor(Utils::hex2rgb('0xFF828282'));
        $chartAxis->getGrid()->setStyle(DashStyle::$SOLID);
        
        $chartAxis->getLabels()->getFont()->setColor(Color::WHITE());
                
        $chartAxis->getTicks()->setColor(Utils::hex2rgb('0xFF828282'));    
        $chartAxis->getMinorTicks()->setVisible(false);
    }
    
    private function doChangeSeries($series) {
        $series->getMarks()->getFont()->setColor(Color::WHITE());
        $series->getMarks()->setTransparent(true);
    }    
}
?>