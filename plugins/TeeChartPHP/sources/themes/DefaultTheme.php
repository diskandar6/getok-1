<?php
 /**
 * Description:  This file contains the following class:<br>
 * DefaultTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 * DefaultTheme class
 *
 * Description: Summary description for DefaultTheme
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
 
 class DefaultTheme extends Theme {

    public function __construct($c) {
        parent::__construct($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();        
    }        

    public function apply() {
        //$baseDir = dirname(__FILE__) . "/../";      
       
        $this->chart->getPanel()->getBevel()->setInner(BevelStyle::$NONE);
        $this->chart->getPanel()->getBevel()->setOuter(BevelStyle::$RAISED);
        $this->chart->getPanel()->getBevel()->setWidth(1);
        $this->chart->getPanel()->getPen()->setVisible(false);
        $this->chart->getPanel()->setBorderRound(0);

        $this->chart->getPanel()->getShadow()->setSize(0);      
        $this->chart->getPanel()->setColor(Color::getSilver());

        $this->resetGradient($this->chart->getPanel()->getGradient());
        $this->chart->getLegend()->getShadow()->setHeight(3);
        $this->chart->getLegend()->getShadow()->setWidth(3);
        $this->chart->getLegend()->getShadow()->setTransparency(0);        
        //$this->chart->getLegend()->getFont()->setName($baseDir . ChartFont::$DEFAULTFAMILY);
        //$this->chart->getLegend()->getFont()->setSize(ChartFont::$DEFAULTSIZE);
        $this->chart->getLegend()->getSymbol()->setDefaultPen(true);
        $this->chart->getLegend()->setTransparent(false);
        $this->chart->getLegend()->getPen()->setVisible(true);
        $this->chart->getLegend()->getDividingLines()->setVisible(false);
        $this->chart->getLegend()->getGradient()->setVisible(false);

        $this->changeWall($this->chart->getWalls()->getLeft(), new Color(255,255,128));
        $this->changeWall($this->chart->getWalls()->getRight(), Color::getSilver());
        $this->changeWall($this->chart->getWalls()->getBack(), Color::getSilver());
        $this->changeWall($this->chart->getWalls()->getBottom(), Color::getWhite());

        $this->chart->getWalls()->getBack()->setTransparent(true);

        for ( $t = 0; $t < $this->chart->getAxes()->getCount(); ++$t) {
            $this->changeAxis($this->chart->getAxes()->getAxis($t));
        }

        for ( $t = 0; $t < $this->chart->getSeriesCount(); ++$t) {
            $this->changeSeries($this->chart->getSeries($t));
        }
                
        $this->chart->getPanel()->getGradient()->setStartColor(new Color(175,175,175));
        $this->chart->getPanel()->getGradient()->setEndColor(new Color(255,255,255));
        $this->chart->getPanel()->getGradient()->setVisible(true);
        
        ColorPalettes::applyPalette($this->chart, 0);
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return " default";
    }

    public function resetGradient($chartGradient) {
        $chartGradient->setVisible(false);
        $chartGradient->setStartColor( Color::getWhite());
        $chartGradient->setDirection('vertical');
        $chartGradient->setEndColor( Color::getYellow());
//        $chartGradient->setMiddleColor( Color::getEmpty());
    }
   
    public function changeWall($chartWall, $aColor) {
        $chartWall->getPen()->setVisible(true);
        $chartWall->getPen()->setColor(Color::getBlack());
        $chartWall->getPen()->setWidth(1);
        $chartWall->getPen()->setStyle(DashStyle::$SOLID);
        $chartWall->getGradient()->setVisible(false);
        $chartWall->setColor($aColor);
        $chartWall->setApplyDark(true);
        $chartWall->setSize(0);
    }

    public function changeSeries($chartSeries) {
        $chartSeries->getMarks()->setTransparent(false);
        $chartSeries->getMarks()->getGradient()->setVisible(false);
        //$chartSeries->getMarks()->getFont()->setName($baseDir . ChartFont::$DEFAULTFAMILY);
        $chartSeries->getMarks()->getFont()->setSize(8);
        $chartSeries->getMarks()->getArrow()->setColor(Color::getWhite());
    }

    public function changeAxis($chartAxis) {
        $chartAxis->getAxisPen()->setWidth(2);
        $chartAxis->getAxisPen()->setColor(Color::getBlack());

        $chartAxis->getGrid()->setVisible(true);
        $chartAxis->getGrid()->setColor(Color::getGray());
        $chartAxis->getGrid()->setStyle(DashStyle::$DOT);
        $chartAxis->getGrid()->setCentered(false);

        $chartAxis->getTicks()->setColor(Color::getDarkGray());
        $chartAxis->getTicksInner()->setVisible(true);
        $chartAxis->getMinorTicks()->setVisible(true);

        $chartAxis->getMinorGrid()->setVisible(false);
        $chartAxis->setMinorTickCount(3);
        $chartAxis->getMinorTicks()->setLength(2);
        $chartAxis->getTicks()->setLength(2);
        $chartAxis->getTicksInner()->setLength(0);

        //$f=$chartAxis->getLabels()->getFont();
        //$f->setName($baseDir . ChartFont::$DEFAULTFAMILY);
        //$f->setSize(8);
        //$f->setColor(Color::getBlack());

        //$chartAxis->getTitle()->getFont()->setName($baseDir . ChartFont::$DEFAULTFAMILY);
    }
}
?>