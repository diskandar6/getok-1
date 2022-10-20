<?php
  /**
 * Description:  This file contains the following class:<br>
 * ToolTip class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */
/**
 * ToolTip class
 *
 * Description: ToolTip jstool
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */

class ToolTip extends JsTool
{
    protected $onShow="";    
    protected $onGetText="";    
    protected $onHide="";    
    protected $series=null;
    protected $autoHide=false;
    protected $delay=1000;
    protected $animated=100;
    protected $autoRedraw=true;
    protected $font=null;
    
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

   public function __construct($c = null)
   {
      parent::__construct($c);
      
      $this->series=null;            
      $this->font=new ChartFont($c);
      $this->font->setSize(16);
      $this->font->setName("Tahoma");
   }

   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->onShow);
        unset($this->onGetText);
        unset($this->onHide);
        unset($this->series);
        unset($this->autoHide);
        unset($this->delay);
        unset($this->animated);
        unset($this->autoRedraw);
        unset($this->font);
   }   
      
   public function setChart($c)
   {
      parent::setChart($c);
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("ToolTipTool");
   }

   /**
   * Gets detailed descriptive text.
   *
   * @return String
   */
   public function getSummary()
   {
      return Language::getString("ToolTipSummary");
   }
    
   public function setOnShow($value) {
       $this->onShow=$value;
   }
   
   public function getOnShow() {
       return $this->onShow;
   }    
   
   public function setOnHide($value) {
       $this->onHide=$value;
   }
   
   public function getOnHide() {
       return $this->onHide;
   }    
   
   public function setOnGetText($value) {
       $this->onGetText=$value;
   }
   
   public function getOnGetText() {
       return $this->onGetText;
   }    
   
   public function setSeries($value) {
       $this->series=$value;
   }
   
   public function getSeries() {
       return $this->series;
   }    
   
   public function setAutoHide($value) {
       $this->autoHide=$value;
   }
   
   public function getAutoHide() {
       return $this->autoHide;
   }    
   
   public function setDelay($value) {
       $this->delay=$value;
   }
   
   public function getDelay() {
       return $this->delay;
   }    

   public function setAnimated($value) {
       $this->animated=$value;
   }
   
   public function getAnimated() {
       return $this->animated;
   }    
   
   public function getFont() {
       return $this->font;       
   }
}
?>
