<?php
    
 /**
 * Description:  This file contains the following class:<br>
 * Donut class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 *
 * <p>Title: Donut class</p>
 *
 * <p>Description: Donut series.</p>
 *
 * <p>Example:
 * <pre><font face="Courier" size="4">
 * $series = new Donut($myChart->getChart());
 * $series->FillSampleValues(8);
 * $series->setDonutPercent(50);
 * $series->setCircled(true);
 * </font></pre></p>
 * 
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
*/
 
 
class Donut extends Pie {
    static $DEFAULTDONUTPERCENT = 50;
    
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

    public function __construct($c) {
        parent::__construct($c);
        $this->setDonutPercent(self::$DEFAULTDONUTPERCENT);
    }

    public function galleryChanged3D($is3D) {
        parent::galleryChanged3D($is3D);
        $this->setCircled(true);
    }

    /**
     * The dimension of the middle hole.
     * Default value: DefaultDonutPercent
     *
     * @return int
     */
    public function getDonutPercent() {
        return $this->iDonutPercent;
    }

    /**
     * Sets the dimension of the middle hole.
     * Default value: DefaultDonutPercent
     *
     * <p>Example:
     * <pre><font face="Courier" size="4">
     * series.setDonutPercent(75);
     * </font></pre></p>
     *
     * @param value int
     */
    public function setDonutPercent($value) {
        parent::setDonutPercent($value);
    }

    /**
     * Gets descriptive text.
     *
     * @return String
     */
    public function getDescription()  {
        return Language::getString("GalleryDonut");
    }
}
?>