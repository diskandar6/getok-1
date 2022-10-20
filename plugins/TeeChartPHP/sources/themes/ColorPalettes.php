<?php

 /**
 * Description:  This file contains the following class:<br>
 * ColorPalettes class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: ColorPalettes class</p>
 *
 * <p>Description: </p>
 *
 *   * <p>Example:
 * <pre><font face="Courier" size="4">
 * ColorPalettes.applyPalette(myChart.getChart(), index);
 * </font></pre></p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
 class ColorPalettes {

    public static function getPalettes() {
    
            $tmpArray = Array(
                Theme::getDefaultPalette(),       
                Theme::getOperaPalette(),
                Theme::getExcelPalette(),
                Theme::getVictorianPalette(),
                Theme::getPastelsPalette(),
                Theme::getSolidPalette(),
                Theme::getClassicPalette(),
                Theme::getWebPalette(),
                Theme::getModernPalette(),
                Theme::getRainbowPalette(),
                Theme::getWindowsXPPalette(),
                Theme::getMacOSPalette(),
                Theme::getWindowsVistaPalette(),
                Theme::GetCoolPalette(),
                Theme::getWarmPalette(),
                Theme::getGrayscalePalette(),
                Theme::getOnBlackPalette(),                
                Theme::getBrightStarsPalette()
           );

        return $tmpArray;    
    }

    public $PaletteNames = Array(
               "TeeChart", //"Default"       
               "Opera",
               "Excel",
               "Victorian",
               "Pastels",
               "Solid",
               "Classic",
               "Web",
               "Modern",
               "Rainbow",
               "Windows XP",       
               "MacOS",
               "Windows Vista",       
               "Cool",
               "Warm",
               "Grayscale",
               "OnBlack",
               "Y2009",
        );



    public static function applyPalette($custom, $index) {
        $tmpPalettes = self::getPalettes();
        self::_applyPalette($custom, $tmpPalettes[$index]);
    }
    
    public static function _applyPalette($custom, $palette) {
        $custom->getGraphics3D()->setColorPalette($palette);        
        $custom->invalidate();        
    }    
}
?>