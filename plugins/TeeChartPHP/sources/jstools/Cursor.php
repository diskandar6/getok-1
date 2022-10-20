<?php
  /**
 * Description:  This file contains the following class:<br>
 * Cursor class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage jstools
 * @link http://www.steema.com
 */
/**
 * Cursor class
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

class Cursor extends JsTool
{
    
    protected $followmouse=true;    
    protected $size;
    protected $direction;    // available values "both" ,"horizontal", "vertical"
    protected $render;       // available values "full","copy","layer"
    protected $pen;
    
    protected $onChange="";    
    
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
      
      $this->followmouse=true;
      $this->size = new TeePoint(0,0);   
      $this->direction=CursorDirection::$BOTH;   
      $this->pen=new ChartPen($c);
      $this->pen->width=2;
      $this->render=CursorRender::$FULL;
   }
   
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->followmouse);
        unset($this->size);
        unset($this->direction);
        unset($this->render);
        unset($this->pen);
        unset($this->onChange);
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
      return Language::getString("CursorTool");
   }

   /**
   * Gets detailed descriptive text.
   *
   * @return String
   */
   public function getSummary()
   {
      return Language::getString("CursorSummary");
   }

    public function getFollowMouse() {
        return $this->followmouse;
    }

    public function setFollowMouse($value) {
        $this->followmouse = $this->setBooleanProperty($this->followmouse, $value);
    }
    
    public function getDirection() {
        return $this->direction;
    }

    public function setDirection($value) {
        $this->direction = $value;
    }    
    
    public function getSize() {
        return $this->size;
    }

    public function setSize($value) {
        $this->getSize()->setX($value);
        $this->getSize()->setY($value);
    }  
    
    public function getPen() {
        return $this->pen;
    }  
    
    public function setPen($value) {
        $this->pen=$value;
    }
    
    public function getRender() {
        return $this->render;
    }  
    
    public function setRender($value) {
        $this->render=$value;
    }    
    
   public function setOnChange($value) {
       $this->onChange=$value;
   }
   
   public function getOnChange() {
       return $this->onChange;
   }    
}
?>
