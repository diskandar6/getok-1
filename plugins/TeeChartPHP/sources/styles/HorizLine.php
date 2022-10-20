<?php

 /**
 * Description:  This file contains the following class:<br>
 * HorizLine class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: HorizLine class</p>
 *
 * <p>Description: Horizontal Line Series.</p>
 *
 * <p>Example:
 * <pre><font face="Courier" size="4">
 *  lineSeries = new com.steema.teechart.styles.HorizLine(myChart.getChart());
 *  lineSeries.fillSampleValues(8);
 *  lineSeries.getPointer().setVisible(true);
 * </font></pre></p>
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 class HorizLine extends Line {

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
        
        $this->setHorizontal();
        $this->getPointer()->setDefaultVisible(false);
        $this->calcVisiblePoints = false;
        $this->getXValues()->setOrder(ValueListOrder::$NONE);
        $this->getYValues()->setOrder(ValueListOrder::$ASCENDING);
    }

        /**
          * Gets descriptive text.
          *
          * @return String
          */
    public function getDescription() {
        return Language::getString("GalleryHorizLine");
    }
}

?>
