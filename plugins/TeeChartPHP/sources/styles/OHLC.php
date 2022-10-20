<?php
 /**
 * Description:  This file contains the following class:<br>
 * OHLC class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * OHLC class
 *
 * Description: OHLC is an base Series class that maintains lists for Open,
 * Close, High and Low values
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class OHLC extends Custom {

    protected $vHighValues;
    protected $vLowValues;
    protected $vOpenValues;

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

        $this->getXValues()->setDateTime(true);
        $this->getXValues()->setName("ValuesDate"); // TODO $this->Language->getString("ValuesDate");
        $this->getYValues()->setName("ValuesClose"); // TODO $this->Language->getString("ValuesClose");

        $this->vHighValues = new ValueList($this, "ValuesHigh"); // TODO $this->Language->getString("ValuesHigh"));
        $this->vLowValues = new ValueList($this, "ValuesLow"); // TODO $this->Language->getString("ValuesLow"));
        $this->vOpenValues = new ValueList($this, "ValuesOpen"); //$this->Language->getString("ValuesOpen"));
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->vHighValues);
        unset($this->vLowValues);
        unset($this->vOpenValues);
    }   
        
    /**
    * All the Stock market Date values.
    * You can access Date values in the same way you can access X or Y values.
    *
    * @return ValueList
    */
    public function getDateValues() {
        return $this->getXValues();
    }

    /**
    * Sets all Stock market Date values.
    * You can access Date values in the same way you can access X or Y values.
    *
    * @param ValueList $value
    */
    public function setDateValues($value) {
        $this->setValueList($this->getXValues(), $value);
    }

    /**
    * All the Stock market Close values.
    * You can access Close values in the same way you can access X or Y values.
    *
    * @return ValueList
    */
    public function getCloseValues() {
        return $this->getYValues();
    }

    /**
    * Sets all Stock market Close values.
    * You can access Close values in the same way you can access X or Y values.
    *
    * @param ValueList $value
    */
    public function setCloseValues($value) {
        $this->setValueList($this->getYValues(), $value);
    }

    /**
    * All the Stock market Open values.
    * You can access Open values in the same way you can access X or Y values.
    *
    * @return ValueList
    */
    public function getOpenValues() {
        return $this->vOpenValues;
    }

    /**
    * Sets all Stock market Open values.
    * You can access Open values in the same way you can access X or Y values.
    *
    * @param ValueList $value
    */
    public function setOpenValues($value) {
        $this->setValueList($this->vOpenValues, $value);
    }

    /**
    * All the Stock market High values.
    * You can access High values in the same way you can access X or Y values.
    *
    * @return ValueList
    */
    public function getHighValues() {
        return $this->vHighValues;
    }

        /**
          * Sets all Stock market High values.<br>
          * You can access High values in the same way you can access X or Y values.
          *
          * @param value ValueList
          */
    public function setHighValues($value) {
        $this->setValueList($this->vHighValues, $value);
    }

        /**
          * All the Stock market Low values.<br>
          * You can access High values in the same way you can access X or Y values.
          *
          * @return ValueList
          */
    public function getLowValues() {
        return $this->vLowValues;
    }

        /**
          * Sets all Stock market Low values.<br>
          * You can access High values in the same way you can access X or Y values.
          *
          * @param value ValueList
          */
    public function setLowValues($value) {
        $this->setValueList($this->vLowValues, $value);
    }

        /**
          * Adds new point with specified integer index and double open, high,
          * low and close.
          *
          * @param index int
          * @param open double
          * @param high double
          * @param low double
          * @param close double
          * @return int index of added point
          */
/* TODO remove    public function add($index, $open, $high, $low,$close) {
        $tmp = $index;
        return $this->add($tmp, $open, $high, $low, $close);
    }*/

        /**
          * Adds new point with specified double index and double open, high, low
          * and close.
          *
          * @param index double
          * @param open double
          * @param high double
          * @param low double
          * @param close double
          * @return int index of added point
          */
    public function addCandle($index, $open, $high, $low, $close,$text="") {
        $this->vHighValues->tempValue = $high;
        $this->vLowValues->tempValue = $low;
        $this->vOpenValues->tempValue = $open;

        if ($text == "")
          return $this->addXY($index, $close);
        else
          return $this->addXYText($index, $close,$text);
    }

        /**
          * Adds new point with specified double open, high, low and close.
          *
          * @param open double
          * @param high double
          * @param low double
          * @param close double
          * @return int index of added point
          */
/* TODO    public function add($open, $high, $low, $close) {
        return $this->add($this->getCount(), $open, $high, $low, $close);
    }  */

        /**
          * Adds new point with specified DateTime x and double open, high, low
          * and close.
          * @param aDate DateTime
          * @param open double
          * @param high double
          * @param low double
          * @param close double
          * @return int index of added point
          */
    public function addCandleDate($aDate, $open, $high, $low, $close) {
        return $this->add($aDate->toDouble(), $open, $high, $low, $close);
    }

        /**
          * Adds the DataView to the OHLC series.
          *
          * @param view DataView
          */
        /**
          * Validates Series datasource.
          *
          * @param value ISeries the series to validate.
          * @return boolean true if value can be a Series data source.
          */
    public function isValidSourceOf($value) {
        return $value instanceof OHLC;
    }

        /**
          * The Maximum Value of the Series Y Values List.
          *
          * @return double
          */
    public function getMaxYValue() {
        $result = max($this->getCloseValues()->getMaximum(),
                                 $this->vHighValues->getMaximum());
        $result = max($result, $this->vLowValues->getMaximum());
        return max($result, $this->vOpenValues->getMaximum());
    }

        /**
          * The Minimum Value of the Series Y Values List.<br>
          * As some Series have more than one Y Values List, this Minimum Value is
          * the "Minimum of Minimums" of all Series Y Values lists.
          *
          * @return double
          */
    public function getMinYValue() {
        $result = min($this->getCloseValues()->getMinimum(),
                                 $this->vHighValues->getMinimum());
        $result = min($result, $this->vLowValues->getMinimum());
        return min($result, $this->vOpenValues->getMinimum());
    }

    protected function numSampleValues() {
        return 40;
    }

    protected function addSampleValues($numValues) {
        $r = $this->randomBounds($numValues);

        $aOpen = $r->MinY + MathUtils::round($r->DifY * $r->Random()); //  open price

        for ( $t = 1; $t <= $numValues; $t++) {
            // Generate random figures
            $ohlc = $this->getRandomOHLC($r, $aOpen, $r->DifY);

            // Call the standard add method
            $this->addCandle($r->tmpX, $aOpen, $ohlc->aHigh, $ohlc->aLow, $ohlc->aClose);

            $r->tmpX += $r->StepX; // <--   X value

            // Tomorrow, the market will open at today's close plus/minus something
            $aOpen = $ohlc->aClose + (10 * $r->Random()) - 5;
        }
    }

        /**
          * Point characteristics
          *
          * @param index int
          * @return SeriesOHLCPoint
          */
    public function getOHLCPoint($index) {
        return new SeriesOHLCPoint($this, $index);
    }

    private function getRandomOHLC($rr, $aOpen,$yRange) {

        $r = new RandomOHLC();
        $tmpY = abs(MathUtils::round($yRange / 400.0));

        $r->aClose = $aOpen + MathUtils::round($yRange / 25.0) * $rr->Random() -
                   ($this->yRange / 50.0); /*   close price->->-> */

        /* and imagine the high and low session price */

        $tmpFixed = 3 * MathUtils::round(abs($r->aClose - $aOpen) / 10.0);

        if ($r->aClose > $aOpen) {
            $r->aHigh = $r->aClose + $tmpFixed + $tmpY * $rr->Random();
            $r->aLow = $aOpen - $tmpFixed - $tmpY * $rr->Random();
        } else {
            $r->aHigh = $aOpen + $tmpFixed + $tmpY * $rr->Random();
            $r->aLow = $r->aClose - $tmpFixed - $tmpY * $rr->Random();
        }
        return $r;
    }
}

?>