<?php
   /**
 * Description:  This file contains the following class:<br>
 * NextAxisLabelValue class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * NextAxisLabelValue class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

 class NextAxisLabelValue {

    private $labelValue;
    private $stop = false;

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

    /**
    * The class constructor.
    */
    public function __construct($labelValue=null, $stop=null) {
        $this->stop = false;
        if ($labelValue!=null)
          $this->labelValue = $labelValue;

        if ($stop!=null)
          $this->stop = $stop;
    }
    
    public function __destruct()    
    {        
        unset($this->labelValue);
        unset($this->stop);
    }
        
    /**
    * Specifies  the desired Axis Label value.
    *
    * @param labelValue double
    */
    public function setLabelValue($labelValue) {
        $this->labelValue = $labelValue;
    }
    /**
    * Returns the desired Axis Label value.
    *
    * @return double
    */
    public function getLabelValue() {
        return $this->labelValue;
    }
    /**
    * The Stop  parameter is  false  by default, meaning that if it's not<br>
    * set to  true  the first time this event gets called, TeeChart will<br>
    * draw the default Axis Labels.<br><br>
    * Default value: false
    *
    * @param stop boolean
    */
    public function setStop($stop) {
        $this->stop = $stop;
    }
    /**
    * The Stop  parameter is  false  by default, meaning that if it's not<br>
    * set to  true  the first time this event gets called, TeeChart will<br>
    * draw the default Axis Labels.<br><br>
    * Default value: false
    *
    * @return boolean
    */
    public function getStop() {
        return $this->stop;
    }
}

?>
