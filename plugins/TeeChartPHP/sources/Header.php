<?php
 /**
 * Description:  This file contains the following class:<br>
 * Header class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Header class
 *
 * Description: Text displayed above Chart
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Header extends Title
{
   /**
   * The class constructor.
   */
   function __construct($c)
   {
      parent::__construct($c);
      
      TChart::$controlName .= 'Header_';        

      $this->getFont()->getBrush()->setDefaultColor(new Color(70,70,70));    // (0,0,255)
   }
   
    public function __destruct()    
    {        
        parent::__destruct();   
    }   
}
?>