<?php
 /**
 * Description:  This file contains the following class:<br>
 * Theme class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
/**
 * <p>Title: Theme class</p>
 *
 * Description: Summary description for Theme
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */

abstract class Theme extends TeeBase {

    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }

    public function __construct($c=null) {
        parent::__construct($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();      
        unset($this->themeSelectorHook);
        unset($this->newChartHook);  
    }        

    public abstract function apply();

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription() {
        return "Default";
    }

    // Returns Theme
    public function themeSelector($custom) {
        return null;
    }

    public $themeSelectorHook = null;  // ThemeSelectorDelegate
    public $newChartHook = null;  // ThemeSelectorDelegate

    // Returns Array of Color
    public final static function getDefaultPalette() {
                                    return Array(
                                                 Color::RED(),
                                                 Color::GREEN(),
                                                 Color::getYellow(),
                                                 Color::BLUE(),
                                                 Color::getWhite(),
                                                 Color::getGray(),
                                                 Color::getFuchsia(),
                                                 Color::getTeal(),
                                                 Color::getNavy(),
                                                 Color::getMaroon(),
                                                 Color::getLime(),
                                                 Color::getOlive(),
                                                 Color::getPurple(),
                                                 Color::getSilver(),
                                                 Color::getAqua(),
                                                 Color::getBlack(),
                                                 Color::getGreenYellow(),
                                                 Color::getSkyBlue(),
                                                 Color::getBisque(),
                                                 Color::getIndigo()
                                                 );
    }

    public final static function getOperaPalette() {
                                  return Array(
                                               Color::fromRgb(66,102,163), //blue
                                               Color::fromRgb(243,156,53), //orange
                                               Color::fromRgb(241,76,20), //red
                                               Color::fromRgb(78,151,168), //blue
                                               Color::fromRgb(43,64,107), //blue
                                               Color::fromRgb(29,123,99), //blue-green dark
                                               Color::fromRgb(179,8,14), //dark red
                                               Color::fromRgb(242,192,93), //pale orange
                                               Color::fromRgb(93,183,158), //blue-green
                                               Color::fromRgb(112,112,112), //grey
                                               Color::fromRgb(243,234,141), //yellow
                                               Color::fromRgb(180,180,180) //grey
                                               );
    }

    public final static function getOnBlackPalette() {
                                  return Array(
                                               Color::fromRgb(200, 230, 90),
//                                               Color::fromRgb(90, 150, 220),
                                               Color::fromRgb(166, 198, 236),
//                                               Color::fromRgb(230, 90, 40),
                                               Color::fromRgb(240, 155, 123),
//                                               Color::fromRgb(230, 160, 15),
                                               Color::fromRgb(245, 199, 101),
                                               Color::fromRgb(255, 255, 128)
                                               );
    }

    public final static function getCoolPalette() {
                                  return Array (
                                               Utils::hex2rgb("2B406B"), //dark blue
                                               Utils::hex2rgb("3B548C"), //blue
                                               Utils::hex2rgb("4466A3"), //blue
                                               Utils::hex2rgb("4E97A8"), //blue
                                               Utils::hex2rgb("5DB79E"), //blue-green
                                               Utils::hex2rgb("41A08A"), //blue-green
                                               Utils::hex2rgb("2B927D"), //blue-green
                                               Utils::hex2rgb("1D7B63") //blue-green dark
                                             );
    }

    public final static function getWarmPalette() {
                                  return Array(
                                               Utils::hex2rgb("F3EA8D"), //yellow
                                               Utils::hex2rgb("F2C05D"), //pale orange
                                               Utils::hex2rgb("F39C35"), //orange
                                               Utils::hex2rgb("F5811C"), //orange
                                               Utils::hex2rgb("F66B15"), //dark orange
                                               Utils::hex2rgb("F14C14"), // red orange
                                               Utils::hex2rgb("E6180A"), // red
                                               Utils::hex2rgb("B3080E") //dark red
                                               );
    }

    public final static function getMacOSPalette() {
                                  return Array(                        
                                               Utils::hex2rgb("FFFFFF"),
                                               Utils::hex2rgb("FCF305"),
                                               Utils::hex2rgb("FF6402"),
                                               Utils::hex2rgb("DD0806"),
                                               Utils::hex2rgb("F20884"),
                                               Utils::hex2rgb("4600A5"),
                                               Utils::hex2rgb("0000D4"),
                                               Utils::hex2rgb("02ABEA"),
                                               Utils::hex2rgb("1FB714"),
                                               Utils::hex2rgb("006411"),
                                               Utils::hex2rgb("562C05"),
                                               Utils::hex2rgb("90713A"),
                                               Utils::hex2rgb("C0C0C0"),
                                               Utils::hex2rgb("808080"),
                                               Utils::hex2rgb("404040"),
                                               Utils::hex2rgb("000000")
                                               );
    }

    public final static function getWindowsVistaPalette() {
                                  return Array(
                                               Utils::hex2rgb("001FD2"),
                                               Utils::hex2rgb("E00201"),
                                               Utils::hex2rgb("1E6602"),
                                               Utils::hex2rgb("E8CD7E"),
                                               Utils::hex2rgb("AFABAC"),
                                               Utils::hex2rgb("A4D0D9"),
                                               Utils::hex2rgb("3D3B3C"),
                                               Utils::hex2rgb("95DD31"),
                                               Utils::hex2rgb("9E0001"),
                                               Utils::hex2rgb("DCF774"),
                                               Utils::hex2rgb("45FDFD"),
                                               Utils::hex2rgb("D18E74"),
                                               Utils::hex2rgb("A0D891"),
                                               Utils::hex2rgb("D57A65"),
                                               Utils::hex2rgb("9695D9")
                                               );                                             
    }

    public final static function getExcelPalette()  {
                                  return Array(
                                               Utils::hex2rgb("FF9999"),
                                               Utils::hex2rgb("663399"),
                                               Utils::hex2rgb("CCFFFF"),
                                               Utils::hex2rgb("FFFFCC"),
                                               Utils::hex2rgb("660066"),
                                               Utils::hex2rgb("8080FF"),
                                               Utils::hex2rgb("CC6600"),
                                               Utils::hex2rgb("FFCCCC"),
                                               Utils::hex2rgb("800000"),
                                               Utils::hex2rgb("FF00FF"),
                                               Utils::hex2rgb("00FFFF"),
                                               Utils::hex2rgb("FFFF00"),
                                               Utils::hex2rgb("800080"),
                                               Utils::hex2rgb("000080"),
                                               Utils::hex2rgb("808000"),
                                               Utils::hex2rgb("FF0000"),
                                               Utils::hex2rgb("FFCC00"),
                                               Utils::hex2rgb("FFFFCC"),
                                               Utils::hex2rgb("CCFFCC"),
                                               Utils::hex2rgb("00FFFF"),
                                               Utils::hex2rgb("FFCC99"),
                                               Utils::hex2rgb("CC99FF")
                                               );
    }

    public final static function getVictorianPalette() {
      return Array(
            Utils::hex2rgb("5DA5A1"),
            Utils::hex2rgb("C45331"),
            Utils::hex2rgb("E79609"),
            Utils::hex2rgb("F6E84A"),
            Utils::hex2rgb("B1A2A7"),
            Utils::hex2rgb("C9A784"),
            Utils::hex2rgb("8C7951"),            
            Utils::hex2rgb("D8CDB7"),
            Utils::hex2rgb("086553"),
            Utils::hex2rgb("F7D87B"),
            Utils::hex2rgb("016484")       
/*            
Blues palette
            Utils::hex2rgb("A1A55D"),
            Utils::hex2rgb("3153C4"),
            Utils::hex2rgb("0996E7"),
            Utils::hex2rgb("4AE8F6"),
            Utils::hex2rgb("A7A2B1"),
            Utils::hex2rgb("84A7C9"),
            Utils::hex2rgb("51798C"),
            Utils::hex2rgb("B7CDD8"),
            Utils::hex2rgb("536508"),
            Utils::hex2rgb("7BD8F7"),
            Utils::hex2rgb("846401")
  */
            
            );
    }

    public final static function getPastelsPalette()  {
                                    return Array(
                                                 Utils::hex2rgb("CCFFFF"),
                                                 Utils::hex2rgb("FFFFCC"),
                                                 Utils::hex2rgb("CCCCFF"),
                                                 Utils::hex2rgb("00CCCC"),
                                                 Utils::hex2rgb("CCCCCC"),
                                                 Utils::hex2rgb("009999"),
                                                 
                                                 Utils::hex2rgb("999999"),
                                                 Utils::hex2rgb("DDCCCC"),
                                                 Utils::hex2rgb("FFCC66"),
                                                 Utils::hex2rgb("CCCCFF"),
                                                 Utils::hex2rgb("FF9999"),
                                                 Utils::hex2rgb("FFFF99"),
                                                 Utils::hex2rgb("99CCFF"),
                                                 Utils::hex2rgb("CCFFCC"));
    }

    public final static function getSolidPalette() {
                                  return Array(
                                               Utils::hex2rgb("FF0000"),
                                               Utils::hex2rgb("0000FF"),
                                               Utils::hex2rgb("00FF00"),
                                               Utils::hex2rgb("00CCFF"),
                                               Utils::hex2rgb("404040"),
                                               Utils::hex2rgb("00FFFF"),
                                               Utils::hex2rgb("C000FF"),
                                               Utils::hex2rgb("FFFFFF")
                                               );
    }

    public final static function getClassicPalette()  {
                                    return Array(
                                                 Utils::hex2rgb("FF0000"),
                                                 Utils::hex2rgb("00FF00"),
                                                 Utils::hex2rgb("FFFF00"),
                                                 Utils::hex2rgb("0000FF"),
                                                 Utils::hex2rgb("FF00FF"),
                                                 Utils::hex2rgb("00FFFF"),
                                                 Utils::hex2rgb("800000"),
                                                 Utils::hex2rgb("008000"),
                                                 Utils::hex2rgb("808000"),
                                                 Utils::hex2rgb("000080"),
                                                 Utils::hex2rgb("800080"),
                                                 Utils::hex2rgb("008080")
                                                 );
    }

    public final static function getWebPalette() {
                                return Array(
                                             Utils::hex2rgb("00A5FF"),
                                             Utils::hex2rgb("CE0000"),
                                             Utils::hex2rgb("00CE00"),
                                             Utils::hex2rgb("40FFFF"),
                                             Utils::hex2rgb("FFFF40"),
                                             Utils::hex2rgb("FF40FF"),
                                             Utils::hex2rgb("0040FF"),
                                             Utils::hex2rgb("A58080"),
                                             Utils::hex2rgb("408080")
                                             );
    }

    public final static function getModernPalette()  {
                                  return Array(
                                                Utils::hex2rgb("6699FF"),
                                                Utils::hex2rgb("6666FF"),
                                                Utils::hex2rgb("FFCC99"),
                                                Utils::hex2rgb("669966"),
                                                Utils::hex2rgb("99CCCC"),
                                                Utils::hex2rgb("CC6699"),
                                                Utils::hex2rgb("6666CC"),
                                                Utils::hex2rgb("99CCFF"),
                                                Utils::hex2rgb("FF6699"),
                                                Utils::hex2rgb("CCCCCC"),
                                                Utils::hex2rgb("CCFF66"),
                                                Utils::hex2rgb("FF9966"),
                                                Utils::hex2rgb("996699"),
                                                Utils::hex2rgb("FFCCCC")
                                                );
    }

    public final static function getRainbowPalette() {
        return Array(
                                                 Utils::hex2rgb("000099"),
                                                 Utils::hex2rgb("0000C3"),
                                                 Utils::hex2rgb("0000EE"),
                                                 Utils::hex2rgb("001AFF"),
                                                 Utils::hex2rgb("0046FF"),
                                                 Utils::hex2rgb("0073FF"),
                                                 Utils::hex2rgb("009FFF"),
                                                 Utils::hex2rgb("00CBFF"),
                                                 Utils::hex2rgb("00F7FF"),
                                                 Utils::hex2rgb("08F4E3"),
                                                 Utils::hex2rgb("11E7C3"),
                                                 Utils::hex2rgb("1BDAA3"),
                                                 Utils::hex2rgb("25CD83"),
                                                 Utils::hex2rgb("2EC063"),
                                                 Utils::hex2rgb("38B342"),
                                                 Utils::hex2rgb("42A622"),
                                                 Utils::hex2rgb("4B9A02"),
                                                 Utils::hex2rgb("6A870C"),
                                                 Utils::hex2rgb("8A751A"),
                                                 Utils::hex2rgb("AA6328"),
                                                 Utils::hex2rgb("CB5036"),
                                                 Utils::hex2rgb("EB3E44"),
                                                 Utils::hex2rgb("FF2A61"),
                                                 Utils::hex2rgb("FF1596"),
                                                 Utils::hex2rgb("FF00CC")
                                                 );
    }

    public final static function getWindowsXPPalette() {
        return Array(        
            new Color(130,155,254),
            new Color(252,209,36),
            new Color(124,188,13),
            new Color(253,133,47),
            new Color(253,254,252),
            new Color(226,78,33),
            new Color(41,56,214),
            new Color(183,148,0),
            new Color(90,134,0),
            new Color(210,70,0),
            new Color(211,229,250),
            new Color(216,216,216),
            new Color(95,113,123)    
            );
    }

    public final static function getGrayscalePalette()  {
      return Array(
            Utils::hex2rgb("F0F0F0"),
            Utils::hex2rgb("E0E0E0"),
            Utils::hex2rgb("D0D0D0"),
            Utils::hex2rgb("C0C0C0"),
            Utils::hex2rgb("B0B0B0"),
            Utils::hex2rgb("A0A0A0"),
            Utils::hex2rgb("909090"),
            Utils::hex2rgb("808080"),
            Utils::hex2rgb("707070"),
            Utils::hex2rgb("606060"),
            Utils::hex2rgb("505050"),
            Utils::hex2rgb("404040"),
            Utils::hex2rgb("303030"),
            Utils::hex2rgb("202020"),
            Utils::hex2rgb("101010")
            );
    }

    public final static function getSkyBluesPalette()  {

        $colorArray = Array();
            for ($i=0;$i<15;$i++)
              $colorArray[] = new Color(20+($i*30),255-($i*50),225-($i*8));  
        
        return $colorArray;
    }    
       
    public final static function getBrightStarsPalette()  {
      return Array(
            Color::fromRgb(186,67,48),       
            Color::fromRgb(17,113,186),       
            Color::fromRgb(100,20,112),       
            Color::fromRgb(214,252,58),       
            Color::fromRgb(89,176,55),
            Color::fromRgb(54,177,153),       
            Color::fromRgb(54,75,177),       
            Color::fromRgb(180,52,109),       
            Color::fromRgb(140,177,54),       
            Color::fromRgb(176,158,55)      
            );
    }
    
    public final static function getBrightPalette()  {
      return Array(
            Color::fromRgb(232,82,129),       
            Color::fromRgb(245,186,41),       
            Color::fromRgb(233,237,53),       
            Color::fromRgb(185,216,76),       
            Color::fromRgb(91,191,185),
            Color::fromRgb(65,166,214),       
            Color::fromRgb(140,81,159)
            );
    }    
       
}
/**
 * <p>Title: ThemeSelectorDelegate class</p>
 *
 * Description: ThemeSelectorDelegate class
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage themes
 * @link http://www.steema.com
 */
class ThemeSelectorDelegate {

    public function invoke($chart) {
         return null;
    }
}
?>