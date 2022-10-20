<?php
 /**
 * Description:  This file contains the following class:<br>
 * BusinessTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 * <p>Title: Business Theme class</p>
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
 
class BusinessTheme extends DefaultTheme {

    /**
     * Description of Classic theme
     *
     * @param c IBaseChart
     */
    public function __construct($c) {
        parent::__construct($c);    
    }

    public function toString() {
        return Language::getString("BusinessTheme");
    }

    public function apply() {
        parent::apply();
        
        $this->chart->getPanel()->getBevel()->setOuter(BevelStyle::$NONE);        
        //$this->chart->getPanel()->setBorderRound(10);
        
        $this->getChart()->getPanel()->getBorderPen()->setVisible(true);
        $this->getChart()->getPanel()->getBorderPen()->setWidth(6);
        
        $this->chart->getPanel()->getPen()->setVisible(true);
        $this->chart->getPanel()->getPen()->setWidth(6);
        $this->chart->getPanel()->getPen()->setColor(Color::NAVY());
        $this->chart->getPanel()->getGradient()->setVisible(true);
        $this->chart->getPanel()->getGradient()->setEndColor(Color::GRAY());
        $this->chart->getPanel()->getGradient()->setStartColor(Color::WHITE());
        
        $this->chart->getLegend()->getShadow()->setSize(3);
        //$this->chart->getLegend()->getGradient()->setVisible(true);
        
        $this->chart->getWalls()->getLeft()->setColor(Color::fromRgb(255, 255, 128));
        $this->chart->getWalls()->getRight()->setColor(Color::SILVER());
        $this->chart->getWalls()->getBack()->setColor(Color::SILVER());
        $this->chart->getWalls()->getBottom()->setColor(Color::WHITE());
        
        for ($t = 0; $t < $this->chart->getSeriesCount(); ++$t) {
            $this->doChangeSeries($this->chart->getSeries($t));
        }

        $this->chart->getTools()->add(new GridBand());
        $this->chart->getTools()->getTool(0)->setAxis($this->chart->getAxes()->getLeft());
        $this->chart->getTools()->getTool(0)->getBand1()->setColor(new Color(200,200,200));
        $this->chart->getTools()->getTool(0)->getBand2()->setColor(new Color(225,225,225));
                
        ColorPalettes::_applyPalette($this->chart, Theme::getVictorianPalette());  // Victorian
    }

    private function doChangeSeries($series) {
        //$series->getMarks()->getGradient()->setVisible(true);
        $tmpColor = Color::SILVER();
        //  $series->getMarks()->getGradient()->setStartColor($tmpColor->getRed(),
        //     $tmpColor->getGreen(), $tmpColor->getBlue());
    }
}
?>