<?php
 /**
 * Description:  This file contains the following class:<br>
 * SeriesCollection class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * SeriesCollection class
 *
 * Description: The SeriesCollection class, a collection of Series objects,
 * is manipulated via the TChart TChart.getSeries() method.
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

final class SeriesCollection extends ArrayObject {

    public $chart;

    private $arrayList = array();
    private $applyZOrder = true;

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

    public function __destruct()    
    {        
        unset($this->chart);        
        unset($this->arrayList);        
        unset($this->applyZOrder);        
    }
    
    public function __construct($c=null) {
        parent::__construct();
        $this->chart = $c;
    }

    public function internalAdd($s) {
        $this->add($s);
    }

    /* TODO
    public function add(Class type) throws InstantiationException,
            IllegalAccessException {
        return add((Series) (type.newInstance()));
    }

    public function add($type) {
        return $this->add($type->newInstance());
    }
    */

    /**
     * Adds a new Series instance to Chart.
     *
     * @param s Series The Series instance to add.
     * @return Series The same Series.
     */
    public function add($s) {
        if ($this->indexOf($s) == -1) {
           if (is_object($this)) {
              parent::offsetset(sizeof($this),$s);
           }
           else
           {
              parent::append($s);
           }

            // TODO $this->chart->broadcastEvent($s, SeriesEventStyle.ADD);

            // TODO remove, but adding series throught delphi ide does not
            // save the chart property into the object
            // temp line
            $this->chart=$s->getChart();

            if (!($s->getChart() === $this->chart)) {
                $s->setChart($this->chart);
            }
        }
        return $s;
    }

    public function getSeries($index) {
        return parent::offsetget($index);
    }

    public function setSeries($index, $value) {
        parent::offsetset($index,$value);
    }

    public function insert($index, $s) {
        /** @todo VALID? */
        // $this->add(index, s);
    }

    public function moveTo($s, $index) {
        $old = $this->indexOf($s);

        if ($old != $index) {
            $tmp = $this->get($index);
            $this->set($index, $s);
            $this->set($old, $tmp);
            $s->repaint();
        }
    }

    /**
     * Returns the corresponding point index which has the specified Value.
     *
     * @param s Series
     * @return int
     */
    public function indexOf($s) {
        for ($t = 0; $t < $this->count(); $t++) {
            if ($this->getSeries($t) === $s) {
                return $t;
            }
        }
        return -1;
    }

    public function withTitle($title) {
        for ($t = 0; $t < sizeof($this); $t++) {
            $s = $this->getSeries($t);
            if ($s->toString()->equals($title)) {
                return $s;
            }
        }
        return null;
    }

    /**
     * Deletes the specified Series from the Chart list of series.
     *
     * @param s Series
     */
    public function remove($s) {
        $i = $this->indexOf($s);

        if ($i > -1) {
            // TODO $this->chart->broadcastEvent($s, SeriesEventStyle.REMOVE);
            parent::offsetUnset($i);

            $tmpArray=Array();
            foreach($this as $item)
            {
                $tmpArray[]=$item;
            }

            $this->clear();
            for ($i=0;$i<sizeof($tmpArray);$i++)
            {
               $this[$i]=$tmpArray[$i];
            }
            // TODO $this->chart->invalidate();
        }
    }

    /**
     * Removes all Series from the Chart but  does not dispose of (destroy)
     * them.
     */
    public function removeAllSeries() {
        while (sizeof($this) > 0) {
            $this->remove($this[0]);
        }
    }

    /**
     * Changes the Series order, swapping one Series Z position with another.<br>
     * The Chart repaints to reflect the new Series order. <br>
     * It accesses TChart.SeriesList method.
     *
     * @param series1 int
     * @param series2 int
     */
    public function exchange($series1, $series2) {
        $s1 = $this->getSeries($series1);
        $s2 = $this->getSeries($series2);
        $this->setSeries($series1, $s2);
        $this->setSeries($series2, $s1);

        // TODO $this->chart->broadcastEvent(null, SeriesEventStyle.SWAP);
        $this->chart->invalidate();
    }

    /**
     * Removes (and optionally disposes) all Series.
     *
     * @param dispose boolean
     */
    public function clear($dispose=true) {
        /* TODO
        foreach($this as $key=>$item)
        {
            review parent::offsetUnset($key);
        }

            $tmp->onDisposing();
            if ($dispose) {
                $tmp->dispose();
            } 

         review - This cannot be done due to the php bug (does not
           serialize fine the classes which extends from ArrayObject, it does
           not serializes the properties. This has been fixed in php 5.3.

        $this->arrayList->clear();
        before super.clear();

        $this->chart->invalidate();
        
        $this->chart->broadcastEvent(null, SeriesEventStyle.REMOVEALL);
        */
    }

    /**
     * Defines the Chart component.
     *
     * @return IBaseChart
     */
    public function getChart() {
        return $this->chart;
    }

    public function activeUseAxis() {
        for ($t = 0; $t < sizeof($this); $t++) {
            $s = $this->getSeries($t);
            if ($s->getActive()) {
                return $s->getUseAxis();
            }
        }
        return true;
    }

    /**
     * Sets multiple Series on same Chart in different Z spaces when true.<br>
     * Run-time only. <br>
     * It's valid only when TChart.View3D is true and when there's more than
     * one Series in the same chart.<br>
     * When false, all Series are drawn using the full Chart Z space. The
     * Chart output can be confusing if Series overlap. <br>
     * Default value: true
     *
     * @return boolean
     */
    public function getApplyZOrder() {
        return $this->applyZOrder;
    }

    /**
     * Sets multiple Series on same Chart in different Z spaces when true.<br>
     * Run-time only. <br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setApplyZOrder($value) {
        $this->applyZOrder = $value;
        if ($this->chart != null) {
            $this->chart->invalidate();
        }
    }

    /**
     * Adds the specified NumValues random points to all series in the collection.
     *
     * @param numValues int the number of sample values to add.
     */
    public function fillSampleValues($numValues=-1) {
        for ($t = 0; $t < sizeof($this); $t++) {
            $this->getSeries($t)->fillSampleValues($numValues);
        }
    }

    public function setChart($chart) {
        $this->chart = $chart;

        for ($t = 0; $t < sizeof($this); $t++) {
            $this->getSeries($t)->setChart($chart);
        }
    }
}
?>