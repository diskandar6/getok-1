<?php
 /**
 * Description:  This file contains the following class:<br>
 * XPTheme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 * <p>Title: XP Theme class</p>
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

 class XPTheme extends DefaultTheme {

    /**
     * Description of Classic theme
     *
     * @param c IBaseChart
     */
    public function __construct($c) {
        parent::__construct($c);  
    }

    public function toString() {
        return Language::getString("XPTheme");
    }

    public function apply() {
        parent::apply();  

        $this->chart->getPanel()->getPen()->setWidth(3);
        $this->chart->getPanel()->getPen()->setColor(Color::fromRgb(41, 122, 223));

        $this->chart->getPanel()->setBorderRound(0);
        
        $this->chart->getLegend()->getShadow()->setVisible(true);
        $this->chart->getLegend()->getShadow()->setSize(5);
        $this->chart->getLegend()->getShadow()->setColor(Color::BLACK());
        
        $this->chart->getPanel()->setColor(Color::WHITE());
        
        $this->chart->getPanel()->getGradient()->setVisible(true);
        $this->chart->getPanel()->getGradient()->setEndColor(Color::fromRgb(177, 177, 177));
        $this->chart->getPanel()->getGradient()->setStartColor(Color::fromRgb(255,255,255));
// TODO         $this->chart->getPanel().getGradient()->setDirection(GradientDirectionBACKDIAGONAL);
        $this->chart->getPanel()->getGradient()->setDirection(GradientDirection::$VERTICAL);

        $this->doChangeWall($this->chart->getWalls()->getLeft());
        $this->doChangeWall($this->chart->getWalls()->getRight());
        $this->doChangeWall($this->chart->getWalls()->getBack());
        $this->doChangeWall($this->chart->getWalls()->getBottom());

        $this->chart->getWalls()->getBack()->setTransparent(false);        

        ColorPalettes::_applyPalette($this->chart, Theme::getWindowsXPPalette());
    }

    private function doChangeWall($wall) {
        $wall->getGradient()->setVisible(true);
        $tmp = Theme::getWindowsXPPalette();
        $wall->getGradient()->setStartColor($tmp[2]);
        $wall->getGradient()->setEndColor($tmp[1]);
    }
}
?>