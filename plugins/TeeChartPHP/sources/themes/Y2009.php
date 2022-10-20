<?php
 /**
 * Description:  This file contains the following class:<br>
 * Y2009 class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 * Y2009 class
 *
 * Description: Summary description for Y2009Theme
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */

 class Y2009 extends DefaultTheme {

    public function __construct($c) {
        parent::__construct($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();        
    }    

    public function apply() {        
        
        $header = $this->getChart()->getHeader();
        $header->getFont()->setSize(12);
        
        $aspect = $this->getChart()->getAspect();
        //  $aspect->setChart3DPercent(30);
        
        // Legend
        $legend = $this->getChart()->getLegend();
        $legend->getShadow()->getBrush()->setColor(new Color(120,120,120));
        $legend->getPen()->setVisible(false);
        
        /*        $legend->getFont()->setSize(10);
        $legend->setTransparent(true);
        */

        
        $panel = $this->getChart()->getPanel();
        $panel->getBevel()->setInner(BevelStyle::$NONE);
        $panel->getBevel()->setOuter(BevelStyle::$NONE);
        
        //$panel->getBevel()->setWidth(1);
        
        $panel->getPen()->setVisible(true);
        $panel->getPen()->setColor(Color::GRAY());
        $panel->getPen()->setWidth(1);
        
        /*
        $panel->getBorderPen()->setWidth(5);
        $panel->getBorderPen()->setVisible(true);
        $panel->getBorderPen()->setColor(new Color(255,255,0));
        $panel->setBorderRound(0);
        */

        
        $panel->getShadow()->setSize(0);
        $panel->setColor(Color::getSilver());
         
        $this->resetGradient($panel->getGradient());
        
        $tmpColor1 = new Color(226,226,226);
        $this->changeWall($this->chart->getWalls()->getLeft(),$tmpColor1);
        $this->changeWall($this->chart->getWalls()->getRight(),$tmpColor1);
        $this->changeWall($this->chart->getWalls()->getBottom(),$tmpColor1);
        $this->changeWall($this->chart->getWalls()->getBack(),$tmpColor1);
        
        for ( $t = 0; $t < $this->chart->getAxes()->getCount(); ++$t) {
            $this->changeAxis($this->chart->getAxes()->getAxis($t));
        }
        
        /*        
        for ( $t = 0; $t < $this->chart->getSeriesCount(); ++$t) {
            $this->changeSeries($this->chart->getSeries($t));
        }*/

        ColorPalettes::applyPalette($this->chart, 17);
        
        unset($header);
        unset($aspect);
        unset($legend);
        unset($panel);
        unset($tmpColor1);
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
         $chartGradient->setVisible(true);
         $chartGradient->setStartColor(Color::getWhite());
         $chartGradient->setDirection(GradientDirection::$VERTICAL);
         $chartGradient->setEndColor(new Color(220,220,220));
//        $chartGradient->setMiddleColor( Color::getEmpty());
    }

    public function changeWall($wall, $aColor) {
        $wall->getPen()->setVisible(false);
        //$wall->setSize(3);
        $wall->getPen()->setVisible(false);
        $wall->getBrush()->setColor($aColor);
    }

    public function changeSeries($chartSeries) {
        $chartSeries->getMarks()->setTransparent(false);
        $chartSeries->getMarks()->getGradient()->setVisible(false);
        $baseDir = dirname(__FILE__) . "/../";
        $chartSeries->getMarks()->getFont()->setName(ChartFont::$DEFAULTFAMILY);
        $chartSeries->getMarks()->getFont()->setSize(8);
        $chartSeries->getMarks()->getArrow()->setColor(Color::getWhite());
    }

    public function changeAxis($axes) {
        
        $tmpColor2 = new Color(0,0,0);
        
        $axes->getAxisPen()->setVisible(true);
        $axes->getAxisPen()->setWidth(1);
        $tmpColor3 = new Color(100,100,100);
        $axes->getAxisPen()->setColor($tmpColor3);
        
        $axes->getMinorTicks()->setVisible(false);
        $axes->getTicks()->setColor($tmpColor2);
        $axes->getTicks()->setLength(3);

        $f=$axes->getLabels()->getFont();
        $baseDir = dirname(__FILE__) . "/../";
        $f->setName(ChartFont::$DEFAULTFAMILY);
        $f->setSize(8);
        $f->setColor($tmpColor2);
        $axes->getTitle()->getFont()->setName(ChartFont::$DEFAULTFAMILY);
        $axes->getTitle()->getFont()->setColor($tmpColor2);
        
        
        unset($tmpColor2);
        unset($tmpColor3);
        unset($axes);
        unset($f);
    }
}
?>