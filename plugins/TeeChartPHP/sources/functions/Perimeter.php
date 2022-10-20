<?php
  /**
 * Description:  This file contains the following class:<br>
 * Perimeter class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: Perimeter class</p>
  *
  * <p>Description: Perimeter function.</p>
  *
  *<p>Example:
  * <pre><font face="Courier" size="4">
  * $function = new Perimeter();
  * $function->setChart($myChart->getChart());
  * $function->setPeriod(0); //all points
  *
  * $functionSeries = new Line($myChart->getChart());
  * $functionSeries->setTitle("Perimeter");
  * $functionSeries->setDataSource($series);
  * $functionSeries->getXValues()->setOrder(ValueListOrder::$NONE);
  * //$functionSeries->setVerticalAxis(VerticalAxis::$RIGHT);
  * $functionSeries->setFunction($function);
  * </font></pre></p>
  *
*  @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
*/
 class Perimeter extends Functions {

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

        $this->canUsePeriod = false;
        $this->SingleSource = true;
    }

    public function addPoints($source) {

        if (!$this->updating) {
            if ($source != null) {
                if (sizeof($source) > 0) {
                    $src = $source[0];

                    if ($src->getCount() > 0) {

                        $this->getSeries()->beginUpdate();
                        $this->getSeries()->clear();
                        $this->getSeries()->getXValues()->setOrder(ValueListOrder::$NONE);

                        $p = Array();  // Array of Point[$src->getCount()]

                        if ($src->getVertAxis()->iAxisSize == 0 ||
                            $src->getHorizAxis()->iAxisSize == 0) {

                            // MS : Not good, rectangle is (0,0,0,0).
                            // How to match it with actual size ??
                            // Force repaint:
                            // TODO check $this->getChart()->getParent()->refreshControl();
                        }

                        $tmpG = $this->getChart()->getGraphics3D();

                        for ( $t = 0; $t < $src->getCount(); $t++) {
                                    $p[$t] = $tmpG->calc3DPoint(
                                    $src->calcXPos($t), $src->calcYPos($t),
                                    $src->getMiddleZ());
                        }

                        $sz = $tmpG->convexHull($p);

                        for ( $t = 0; $t < $sz; $t++) {
                            $this->getSeries()->add($this->getSeries()->xScreenToValue(
                            $p[$t]->getX()), $this->getSeries()->yScreenToValue($p[$t]->getY()));
                        }
                        if ($sz > 0) {
                            $this->getSeries()->add($this->getSeries()->getXValues()->value[0],
                                            $this->getSeries()->getYValues()->value[0]);
                        }
                        $p = null;
                        $this->getSeries()->endUpdate();
                    }
                }
            }
        }
    }

    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("FunctionPerimeter");
    }
}
?>