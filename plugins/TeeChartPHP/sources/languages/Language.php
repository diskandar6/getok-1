<?php
 /**
 * Description:  This file contains the following class:<br>
 * Language class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage languages
 * @link http://www.steema.com
 */
 /**
 * Language class
 *
* Description: Internationalization i18n language selection
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage languages
 * @link http://www.steema.com
 */
 
 class Language {

    public static $ENGLISH=0;
    private $language = 0; // English
    private $currentLanguage="English";
    private $bundle;

    private function __construct() {}

   public function __destruct()    
   {        
        unset($this->language);
        unset($this->currentLanguage);
        unset($this->bundle);
   }   
       
    public function activate() {
        $this->currentLanguage = $this->language;
    }

    public static function getString($text) {
        // Read string depending of the language choosed , english by default
        return Texts::${$text};
    }
}
?>
