<?php
 /**
 * Description:  This file contains the following class:<br>
 * Area class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 * BaseLine class
 *
 * Description: Abstract Series class inherited by a number of TeeChart
 * series styles.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

abstract class BaseLine extends Series {

    protected $linePen;

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
        unset($this->linePen);
    }      

    public function assign($source) {
        if ($source instanceof BaseLine) {
            $tmp = $source;
            if ($tmp->linePen != null) {
                $this->getLinePen()->assign($tmp->linePen);
            }
        }
        parent::assign($source);
    }

    public function setChart($c) {
        parent::setChart($c);
        $this->getLinePen()->setChart($c);
    }

    /**
     * Determines pen to draw the line connecting all points.<br>
     *
     * @return ChartPen
     */
    public function getLinePen() {
        if ($this->linePen == null) {
            $this->linePen = new ChartPen($this->chart, new Color (0,0,0,0,true));
        }
        return $this->linePen;
    }
}
?>
