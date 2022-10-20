<?php

 /**
 * Description:  This file contains the following class:<br>
 * ThemeList class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
 /**
 *
 * <p>Title: ThemeList class</p>
 *
 * <p>Description: ThemesList is a collection of Theme objects.</p>
 *
 * <p>Example:
 * <pre><font face="Courier" size="4">
 * ThemesList.applyTheme(myChart.getChart(), new
 * ExcelTheme(myChart.getChart()));
 * </font></pre>
 * </p>
 *
 * @see com.steema.teechart.themes.Theme
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */

 
 class ThemesList {
     
     public static $OPERATHEME = 0;
     public static $BLACKISBLACKTHEME = 1;
     public static $DEFAULTTHEME = 2;
     public static $EXCELTHEME = 3;
     public static $CLASSICTHEME = 4;
     public static $XPTHEME = 5;
     public static $WEBTHEME = 6;
     public static $BUSINESSTHEME = 7;
     public static $BLUESKYTHEME = 8;
     public static $GRAYSCALETHEME = 9;          

    /**
     * Returns the number of registered Chart Theme classes.
     *
     * @return int
     */
    public function size() {
        return 3;
    }

        /**
          * Returns index'th Theme class in list.
          *
          * @param index int
          * @return Class
          */
    public function getTheme($index) {
        switch ($index) {
        case 0:
            return OperaTheme;
            break;
        case 1:
            return BlackIsBackTheme;                        
            break;
        case 2:
            return DefaultTheme;
            break;
        case 3:
            return ExcelTheme;
            break;
        case 4:
            return ClassicTheme;            
            break;
        case 5:
            return XPTheme;                                    
            break;
        case 6:
            return WebTheme;                        
            break;
        case 7:
            return BusinessTheme;
            break;
        case 8:
            return BlueSkyTheme;            
            break;
        case 9:
            return GrayscaleTheme;            
            break;
        default:
            return null;            
        }
    }

        /**
          * Creates a new instance of index'th Theme and applies it to chart.
          *
          * @param chart IBaseChart
          * @param index int
          */
    public static function applyTheme($chart, $index) {
        switch ($index) {
        case 0:        
            self::_applyTheme($chart, new OperaTheme($chart));
            break;
        case 1:
            self::_applyTheme($chart, new BlackIsBackTheme($chart));
            break;            
        case 2:
            self::_applyTheme($chart, new DefaultTheme($chart));
            break;
        case 3:
            self::_applyTheme($chart, new ExcelTheme($chart));
            break;
        case 4:
            self::_applyTheme($chart, new ClassicTheme($chart));
            break;            
        case 5:
            self::_applyTheme($chart, new XPTheme($chart));
            break;                        
        case 6:
            self::_applyTheme($chart, new WebTheme($chart));
            break;                            
        case 7:
            self::_applyTheme($chart, new BusinessTheme($chart));
            break;            
        case 8:
            self::_applyTheme($chart, new BlueSkyTheme($chart));            
            break;                        
        case 9:
            self::_applyTheme($chart, new GrayscaleTheme($chart));
            break;                                    
        case 10:
            self::_applyTheme($chart, new Y2009($chart));
            break;                                    
        default:
            break;  
        }              
    }

        /**
          * Applies Theme to Chart. Color palette is determined by the Theme class.
          *
          * @param chart IBaseChart
          * @param theme Theme
          */
    public static function _applyTheme($chart, $theme) {
        self::__applyTheme($chart, $theme, -1);
    }

        /**
          * Applies Theme to Chart and sets the Chart palette (if paletteIndex is
          * different than -1).
          *
          * @param chart IBaseChart
          * @param theme Theme
          * @param paletteIndex int
          */
    public static function __applyTheme($chart, $theme, $paletteIndex) {
        $theme->apply();           

        if ($paletteIndex != -1) {
            ColorPalettes::applyPalette($chart, $paletteIndex);
        }
    }

        /**
          * Returns the textual description of index'th Theme in list.
          *
          * @param index int
          * @return String
          * @see com.steema.teechart.themes.Theme
          */
    public function getThemeDescription($index) {       
        switch ($index) {
        case 0:
            return "Opera";
        case 1:
            return "BlackIsBack";            
        case 2:
            return "TeeChart";
        case 3:
            return "Excel";
        case 4:
            return "Classic";
        case 5:
            return "XP";            
        case 6:
            return "Web";
        case 7:
            return "Business"; 
        case 8:
            return "Blues";             
        case 9:
            return "Grayscale";                                                              
        case 10:
            return "Y2009";
        default:
            return "";
        }        
    }
}
?>