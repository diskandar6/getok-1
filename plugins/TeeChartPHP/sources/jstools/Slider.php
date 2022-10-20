<?php
  /**
 * Description:  This file contains the following class:<br>
 * Slider class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */
/**
 * Slider class
 *
 * Description: Cursor jstool
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */

class Slider extends JsTool
{
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
    
   protected $horizontal=true;
   protected $bounds=null;
   protected $gripSize=3;
   protected $transparent=false;
   protected $min=0;
   protected $max=100;
   protected $cursor="pointer";
   protected $gradient=null;
   protected $useRange=false;
   protected $position=0;
   protected $thumbSize=8;
   
   protected $onChanging="";

   public function __construct($c = null)
   {
      parent::__construct($c);
      $this->horizontal=true;
      $this->bounds=new Rectangle(10,10,200,20);
      $this->gripSize=3;
      $this->transparent=false;
      $this->min=0;
      $this->max=100;
      $this->useRange=false;
      $this->thumbSize=8;      
   }
   
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->horizontal);
        unset($this->bounds);
        unset($this->gripSize);
        unset($this->transparent);
        unset($this->min);
        unset($this->max);
        unset($this->cursor);
        unset($this->gradient);
        unset($this->useRange);
        unset($this->position);
        unset($this->thumbSize);
        unset($this->onChanging);
   }   

   public function setChart($c)
   {
      parent::setChart($c);
      $this->getThumb()->setChart($this->chart);
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("SliderTool");
   }

   /**
   * Gets detailed descriptive text.
   *
   * @return String
   */
   public function getSummary()
   {
      return Language::getString("SliderSummary");
   }
   
   public function getBounds()
   {
      if($this->bounds == null)
         $this->bounds = new Rectangle(10,10,200,20); 
       
      return $this->bounds;
   }
   
   public function getHorizontal() {
       return $this->horizontal;
   }
   
   public function setHorizontal($value) {
       $this->horizontal=$value;
   }

   public function getTransparent() {
       return $this->transparent;
   }
   
   public function setTransparent($value) {
       $this->transparent=$value;
   }

   public function getGripSize() {
       return $this->gripSize;
   }
   
   public function setGripSize($value) {
       $this->gripSize=$value;
   }

   
   public function getMin() {
       return $this->min;
   }
   
   public function setMin($value) {
       $this->min=$value;
   }
   
   public function getMax() {
       return $this->max;
   }
   
   public function setMax($value) {
       $this->max=$value;
   }

    public function getUseRange() {        
       return $this->useRange;       
   }
   
   public function setUseRange($value) {
       $this->useRange =$value;
   }

    public function getPosition() {
       return $this->position;
   }
   
   public function setPosition($value) {
       $this->position =$value;
   }
   
    public function getThumbSize() {
       return $this->thumbSize;
   }
   
   public function setThumbSize($value) {
       $this->thumbSize =$value;
   }
   
   public function setOnChanging($value) {
       $this->onChanging=$value;
   }
   
   public function getOnChanging() {
       return $this->onChanging;
   }
}
?>