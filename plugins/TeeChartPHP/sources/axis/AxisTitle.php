<?php
  /**
 * Description:  This file contains the following class:<br>
 * AxisTitle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * AxisTitle class
 *
 * Description: Axis Title characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

final class AxisTitle extends TextShape {

    private $iDefaultAngle=0;
    private $angle=0;
    private $customSize=0;

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
    public function __construct($c) {
        parent::__construct($c);
    }
    
    public function __destruct()    
    {        
        parent::__destruct();                
        unset($this->iDefaultAngle);
        unset($this->angle);
        unset($this->customSize);  
    }
    
    function setInitialAngle($a) {
        $this->angle = $a;
        $this->iDefaultAngle = $this->angle;
    }

    /**
     * Rotation in degrees applied to each Axis Label. <br>
     * The Axis will use this to draw its Title.
     *
     * @return int
     */
    public function getAngle() {
        return $this->angle;
    }

    /**
     * Specifies the rotation in degrees applied to each Axis Label. <br>
     *
     * @param value int
     */
    public function setAngle($value) {
        $this->angle = $this->setIntegerProperty($this->angle, $value % 360);
    }

    /**
     * The string of text used to register near each Chart Axis.<br>
     * When empty, no Title is displayed. Use Angle and Font to control Axis
     * Title formatting. <br>
     * Default value: ""
     *
     * @return String
     */
    public function getCaption() {
        return $this->getText();
    }

    /**
     * Defines the string of text used to draw near to each Chart Axis.<br>
     * Default value: ""
     *
     * @param value String
     */
    public function setCaption($value) {
        if ($value != null) {
            $this->setText($value);
        }
    }

    //private boolean shouldSerializeAngle() {
    //    return angle != iDefaultAngle;
    //}

    /**
     * Changes the spacing between the axis/labels and the outer panel edge.<br>
     * Default valure: 0
     *
     * @return int
     */
    public function getCustomSize() {
        return $this->customSize;
    }

    /**
     * Sets the spacing between the axis/labels and the outer panel edge.<br>
     * Default valure: 0
     *
     * @param value int
     */
    public function setCustomSize($value) {
        $this->customSize = $this->setIntegerProperty($this->customSize, $value);
    }
}
?>