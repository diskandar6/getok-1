<?php
  /**
 * Description:  This file contains the following class:<br>
 * ADX class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 * ADX class
 *
 * Description: ADX Function
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 2013.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
 class ADX extends Functions {

    private $iDMDown;
    private $iDMUp;
    private $interpolate = true;
    private $factor = 4;

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
        
        $this->dPeriod = 14;
        $this->SingleSource = true;
        $this->HideSourceList = true;

        $this->iDMDown = new FastLine();
        $this->HideSeries($this->iDMDown);
        $tmpColor = new Color(255,0,0);  // RED
        $this->iDMDown->setColor($tmpColor);

        $this->iDMUp = new FastLine();
        $this->HideSeries($this->iDMUp);
        $this->iDMUp->setColor(new Color(0,128,0));  // GREEN
        
        unset($tmpColor);
    }

    public function __destruct()    
    {        
        parent::__destruct();                

        unset($this->iDMDown);
        unset($this->iDMUp);
        unset($this->interpolate);
        unset($this->factor);
    }  
        
    /// Access characteristics of the DMDown line (a FastLineSeries).
    /// DMDown is a sub-series (of type FastLine) of ADX function.
    public function getDMDown() {
        return $this->iDMDown;
    }

    /// Access characteristics of the DMUp line (a FastLineSeries).
    /// DMUp is a sub-series (of type FastLine) of ADX function.
    public function getDMUp() {
        return $this->iDMUp;
    }

    /// The pen used to draw the upper ADX line.
    /// Corresponds to DMUp.Pen property.
    /// <code>
    /// aDX.getUpLinePen().setColor(Color.Blue);
    /// </code>
    public function getUpLinePen() {
        return $this->iDMUp->getLinePen();
    }

    /// The pen used to draw the lower ADX line.
    /// Corresponds to DMDown.Pen property.
    public function getDownLinePen() {
        return $this->iDMDown->getLinePen();
    }

    public function isValidSourceOf($value) {
        return $value instanceof OHLC;
    }

    private function prepareSeries($series) {
        $series->setChart($this->getSeries()->getChart());
        $series->setCustomVertAxis($this->getSeries()->getCustomVertAxis());
        $series->setVerticalAxis($this->getSeries()->getVerticalAxis());
        $series->getXValues()->setDateTime($this->getSeries()->getXValues()->
                                         $this->getDateTime());

/* TODO        $series->addSeriesPaintListener( new SeriesPaintAdapter() {
            public function seriesPainting($e) {
                $this->ADX->this->getSeries()->doBeforeDrawChart();
            };

            public function seriesPainted($e) {
                $this->ADX->this->getSeries()->doBeforeDrawChart();
            };
        });
*/
    }

    private function calcADX($Index) {
         $tmpIndex = $Index - MathUtils::round($this->getPeriod());
         $result = (100 *
                         abs($this->iDMUp->getYValues()->getValue($tmpIndex) -
                                  $this->iDMDown->getYValues()->getValue($tmpIndex)) /
                         ($this->iDMUp->getYValues()->getValue($tmpIndex) +
                          $this->iDMDown->getYValues()->getValue($tmpIndex)));
        return $result;
    }

    ///Gets all points from Source series, performs a function operation and stores results in ParentSeries.
    public function addPoints($source) {
         $tmpTR=Array();
         $tmpDMUp=Array();
         $tmpDMDown=Array();
         $tmpClose;
         $tmpX;
        //	base.AddPoints (source);
        if (!$this->updating) { // 5.02
            if ($source != null) {
                if (sizeof($source) > 0) {
                    $this->getSeries()->clear();
                     $s = $source->offsetget(0);
                    if ($s->getCount() > 0) {
                        if ($this->getPeriod() < 2) {
                            return;
                        }

                        $this->iDMUp->clear();
                        $this->iDMDown->clear();
                        $this->prepareSeries($this->iDMUp);
                        $this->prepareSeries($this->iDMDown);

                        if ($s->getCount() >= (2 * $this->getPeriod())) {
                            $this->Closes = $s->getCloseValues();
                            $this->Highs = $s->getHighValues();
                            $this->Lows = $s->getLowValues();

                            $tmpTR[] = $s->getCount();
                            $tmpDMUp[] = $s->getCount();
                            $tmpDMDown[] = $s->getCount();

                            for ( $t = 1; $t < $s->getCount(); ++$t) {
                                $tmpClose = $this->Closes->getValue($t - 1);
                                $tmpTR[$t] = $this->Highs->getValue($t) - $this->Lows->getValue($t);
                                $tmpTR[$t] = max($tmpTR[$t],
                                        abs($this->Highs->getValue($t) - $tmpClose));
                                $tmpTR[$t] = max($tmpTR[$t],
                                        abs($this->Lows->getValue($t) - $tmpClose));

                                if (($this->Highs->getValue($t) - $this->Highs->getValue($t - 1)) >
                                    ($this->Lows->getValue($t - 1) - $this->Lows->getValue($t))) {
                                    $tmpDMUp[$t] = max(0,
                                            $this->Highs->getValue($t) -
                                            $this->Highs->getValue($t - 1));
                                } else {
                                    $tmpDMUp[$t] = 0;
                                }

                                if (($this->Lows->value[$t - 1] - $this->Lows->value[$t]) >
                                    ($this->Highs->value[$t] - $this->Highs->value[$t - 1])) {
                                    $tmpDMDown[$t] = max(0,
                                            $this->Lows->getValue($t - 1) -
                                            $this->Lows->getValue($t));
                                } else {
                                    $tmpDMDown[$t] = 0;
                                }
                            }

                             $tmpTR2 = 0;
                             $tmpUp2 = 0;
                             $tmpDown2 = 0;

                             $tmp = MathUtils::round($this->getPeriod());

                            for ( $t = $tmp; $t < $s->getCount(); ++$t) {
                                if ($t == $tmp) {
                                    for ( $tt = 1;
                                                  $tt <= MathUtils::round($this->getPeriod());
                                                  ++$tt) {
                                        $tmpTR2 = $tmpTR2 + $tmpTR[$tt];
                                        $tmpUp2 = $tmpUp2 + $tmpDMUp[$tt];
                                        $tmpDown2 = $tmpDown2 + $tmpDMDown[$tt];
                                    }
                                } else {
                                    $tmpTR2 = $tmpTR2 - ($tmpTR2 / $this->getPeriod()) +
                                             $tmpTR[$t];
                                    $tmpUp2 = $tmpUp2 - ($tmpUp2 / $this->getPeriod()) +
                                             $tmpDMUp[$t];
                                    $tmpDown2 = $tmpDown2 - ($tmpDown2 / $this->getPeriod()) +
                                               $tmpDMDown[$t];
                                }
                                $tmpX = $s->getXValues()->getValue($t);
                                $this->iDMUp->add($tmpX, 100 * ($tmpUp2 / $tmpTR2));
                                $this->iDMDown->add($tmpX, 100 * ($tmpDown2 / $tmpTR2));
                            }

                            $tmpTR[]= Array();
                            $tmpDMUp = Array();
                            $tmpDMDown = Array();
                            $tmpADX = 0;

                            $tmp = MathUtils::round((2 * $this->getPeriod()) - 2);

                            for ( $t = $tmp; $t < $s->getCount(); ++$t) {
                                if ($t == $tmp) {
                                    $tmpADX = 0;
                                    for ( $tt = MathUtils::round($this->getPeriod());
                                                  $tt <= $tmp; ++$tt) {
                                        $tmpADX = $tmpADX + $this->calcADX($tt);
                                    }
                                    $tmpADX = $tmpADX / ($this->getPeriod() - 1);
                                } else {
                                    $tmpADX = (($tmpADX * ($this->getPeriod() - 1)) +
                                              ($this->calcADX($t))) / $this->getPeriod();
                                }

                                $this->getSeries()->add($s->getXValues()->getValue($t),
                                                $tmpADX);
                            }
                        }
                    }
                }
            }
        }
    }

    private function HideSeries($ASeries) {
        $ASeries->setShowInLegend(false);
        $ASeries->InternalUse = true;
    }

    protected function dispose($disposing) {
        $this->iDMDown->dispose();
        $this->iDMUp->dispose();
        $this->dispose($disposing);
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return Language::getString("FunctionADX");
    }
}

?>