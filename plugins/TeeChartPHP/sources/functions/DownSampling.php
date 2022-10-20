<?php
  /**
 * Description:  This file contains the following class:<br>
 * DownSampling class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
/**
 * DownSampling class
 *
 * Description: DownSampling Function
 *
 * Example:
 * $downSamplingFunction = new DownSampling();
 * $downSamplingFunction->setChart($myChart->getChart());
 * $downSamplingFunction->setPeriod(0); //all points
 *
 * $tmpArray = Array();
 * $tmpArray->add($barSeries1);
  *$lineSeries->setDataSource($tmpArray);
 * $lineSeries->setFunction($downSamplingFunction);
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 2018.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */
 

/// <summary>
/// Reduces the number of points in series by using several different methods.
/// </summary>
class DownSampling extends Functions 
{
	private static $serialVersionUID = 1;

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
       
    private $tolerance;
    private $method;
    
    private $r;
    private $reducedsize;

    public function reduce($algorithm, $s, $tol, $lbound, $ubound, &$rx, &$ry, $colors, $color)
    {
        $rsize = 0;
        $i = $lbound;
        $j = $i;
        $nullcount = 0;
        $itol = MathUtils::Round($tol);

        $x = $s->getXValues()->getValues();
        $y = $s->getYValues()->getValues();
        $tmpsum = 0.0;
        $tmpmax = 0.0;
        $tmpmin = 0.0;
        $tmpfirst = 0.0;
        $tmplast = 0.0;
        $tmpXfirst = 0.0;
        $tmpXmax = 0.0;
        $tmpXmin = 0.0;
        $tmpXlast = 0.0;

        while ($i < $ubound)
        {
            $j = $i;
            if ($algorithm == DownSamplingMethod::$MINMAXFIRSTLASTNULL)
            {
                $nullcount = 0;
                if ($s->isNull($i))
                {
                    ++$nullcount;
                }
            }
            $tmpsum = $y[$i];
            $tmpmax = $y[$i];
            $tmpmin = $y[$i];
            $tmpfirst = $y[$i];
            $tmpXfirst = $x[$i];
            $tmpXmax = $x[$i];
            $tmpXmin = $x[$i];
            $tmplast = $tmpfirst;
            $tmpXlast = $tmpXfirst;

            if ($this->getDisplayedPointCount() > 0)
            {
                $count = 1;
                while (($j + 1) < $ubound && $count < $itol)
                {
                    $j++;

                    if ($algorithm == DownSamplingMethod::$MINMAXFIRSTLASTNULL)
                    {
                        if ($s->isNull($j))
                        {
                            ++$nullcount;
                        }
                        if ($nullcount <= 1)
                        {
                            if (!$s->isNull($j))
                            {
                                if ($tmpsum != $s->getDefaultNullValue())
                                {
                                    $tmpsum += $y[$j];
                                }
                                else
                                {
                                    $tmpsum = $y[$j];
                                }

                                if ($y[$j] > $tmpmax)
                                {
                                    $tmpmax = $y[$j];
                                    $tmpXmax = $x[$j];
                                }

                                if ($y[$j] < $tmpmin)
                                {
                                    $tmpmin = $y[$j];
                                    $tmpXmin = $x[$j];
                                }

                                $tmplast = $y[$j];
                                $tmpXlast = $x[$j];
                            }
                            else
                            {
                                if ($y[$j] > $tmpmax)
                                {
                                    $tmpmax = $y[$j];
                                    $tmpXmax = $x[$j];
                                }

                                if ($y[$j] < $tmpmin)
                                {
                                    $tmpmin = $y[$j];
                                    $tmpXmin = $x[$j];
                                }

                                $tmplast = $y[$j];
                                $tmpXlast = $x[$j];
                            }
                        }
                    }
                    else
                    {
                        $tmpsum += $y[$j];
                        if ($y[$j] > $tmpmax)
                        {
                            $tmpmax = $y[$j];
                            $tmpXmax = $x[$j];
                        }
                        if ($y[$j] < $tmpmin)
                        {
                            $tmpmin = $y[$j];
                            $tmpXmin = $x[$j];
                        }
                        $tmplast = $y[$j];
                        $tmpXlast = $x[$j];
                    }
                    ++$count;
                }
            }
            else
            {
                while ((($j + 1) < $ubound) && (abs($x[$j + 1] - $x[$i]) < $tol))
                {
                    $j++;
                    $tmpsum += $y[$j];
                    if ($y[$j] > $tmpmax)
                    {
                        $tmpmax = $y[$j];
                        $tmpXmax = $x[$j];
                    }
                    if ($y[$j] < $tmpmin)
                    {
                        $tmpmin = $y[$j];
                        $tmpXmin = $x[$j];
                    }
                    $tmplast = $y[$j];
                    $tmpXlast = $x[$j];
                }
            }

            if ($algorithm != DownSamplingMethod::$MINMAX && $algorithm != DownSamplingMethod::$MINMAXFIRSTLAST
                    && $algorithm != DownSamplingMethod::$MINMAXFIRSTLASTNULL)
            {
                $rx[$rsize] = ($x[$j] + $x[$i]) * 0.5; // x is average of group
                if ($algorithm == DownSamplingMethod::$AVERAGE)
                {
                    $ry[$rsize] = $tmpsum / (double) ($j - $i + 1);
                }
                else if ($algorithm == DownSamplingMethod::$MAX)
                {
                    $ry[$rsize] = $tmpmax;
                }
                else if ($algorithm == DownSamplingMethod::$MIN)
                {
                    $ry[$rsize] = $tmpmin;
                }
                $rsize++;
            }
            else if ($rsize <= sizeof($rx)) // safeguard in case somebody tries to do this on very short array
            {
                if ((($j - $i) == 0)) //CDI only drawing half the plot when tolerance = 0
                {
                    $rx[$rsize] = $x[$i];
                    $ry[$rsize] = $tmpmin;
                    //#if !NULLABLE
                    if ($algorithm == DownSamplingMethod::$MINMAXFIRSTLASTNULL)
                    {
                        if ($tmpmin == $s->getDefaultNullValue())
                        {
                            $colors[]=Color::TRANSPARENT();
                        }
                        else
                        {
                            $colors[]=$color;
                        }
                    }
                    //#endif
                    $rsize += 1;
                }
                else if (($algorithm == DownSamplingMethod::$MINMAX))
                {
                    $rx[$rsize] = $x[$i];
                    $rx[$rsize + 1] = $x[$j];
                    $ry[$rsize] = $tmpmin;
                    $ry[$rsize + 1] = $tmpmax;
                    $rsize += 2;
                }
                else if (($j - $i) > 2)
                {
                    $rx[$rsize] = $tmpXfirst;
                    $ry[$rsize] = $tmpfirst;

                    if ($algorithm == DownSamplingMethod::$MINMAXFIRSTLASTNULL)
                    {
                        if ($tmpfirst == $s->getDefaultNullValue())
                        {
                            $colors[]=Color::TRANSPARENT();
                        }
                        else
                        {
                            $colors[]=$color;
                        }
                        ++$rsize;
                        if ($tmpXmax <= $tmpXmin)
                        {
                            if ($tmpXfirst != $tmpXmax)
                            {
                                $rx[$rsize] = $tmpXmax;
                                $ry[$rsize] = $tmpmax;
                                if ($tmpmax == $s->getDefaultNullValue())
                                {
                                    $colors[]=Color::TRANSPARENT();
                                }
                                else
                                {
                                    $colors[]=$color;
                                }
                                ++$rsize;
                            }
                            if ($tmpXfirst != $tmpXmin && $tmpXmin != $tmpXmax)
                            {
                                $rx[$rsize] = $tmpXmin;
                                $ry[$rsize] = $tmpmin;
                                if ($tmpmin == $s->getDefaultNullValue())
                                {
                                    $colors[]=Color::TRANSPARENT();
                                }
                                else
                                {
                                    $colors[]=$color;
                                }
                                ++$rsize;
                            }
                        }
                        else
                        {
                            if ($tmpXfirst != $tmpXmin)
                            {
                                $rx[$rsize] = $tmpXmin;
                                $ry[$rsize] = $tmpmin;
                                if ($tmpmin == $s->getDefaultNullValue())
                                {
                                    $colors[]=Color::TRANSPARENT();
                                }
                                else
                                {
                                    $colors[]=$color;
                                }
                                ++$rsize;
                            }
                            if ($tmpXfirst != $tmpXmax && $tmpXmin != $tmpXmax)
                            {
                                $rx[$rsize] = $tmpXmax;
                                $ry[$rsize] = $tmpmax;
                                if ($tmpmax == $s->getDefaultNullValue())
                                {
                                    $colors[]=Color::TRANSPARENT();
                                }
                                else
                                {
                                    $colors[]=$color;
                                }
                                ++$rsize;
                            }
                        }
                        if ($tmpXlast != $tmpXfirst && $tmpXlast != $tmpXmin && $tmpXlast != $tmpXmax)
                        {
                            $rx[$rsize] = $tmpXlast;
                            $ry[$rsize] = $tmplast;
                            if ($tmplast == $s->getDefaultNullValue())
                            {
                                $colors[]=Color::TRANSPARENT();
                            }
                            else
                            {
                                $colors[]=$color;
                            }
                            ++$rsize;
                        }
                    }
                    else
                    {
                        if ($tmpXmax <= $tmpXmin)
                        {
                            $rx[$rsize + 1] = $tmpXmax;
                            $rx[$rsize + 2] = $tmpXmin;
                            $ry[$rsize + 1] = $tmpmax;
                            $ry[$rsize + 2] = $tmpmin;
                        }
                        else
                        {
                            $rx[$rsize + 2] = $tmpXmax;
                            $rx[$rsize + 1] = $tmpXmin;
                            $ry[$rsize + 2] = $tmpmax;
                            $ry[$rsize + 1] = $tmpmin;
                        }

                        $rx[$rsize + 3] = $tmpXlast;
                        $ry[$rsize + 3] = $tmplast;
                        $rsize += 4;
                    }
                }
                else if (($j - $i) < 2)
                {
                    $rx[$rsize] = $x[$i];
                    $rx[$rsize + 1] = $x[$j];
                    $ry[$rsize] = $y[$i];
                    $ry[$rsize + 1] = $y[$j];
                    $rsize += 2;
                }
                else
                {
                    $one = 0.0;
                    $two = 0.0;
                    $three = 0;
                    $oneX = 0;
                    $twoX = 0;
                    $threeX = 0;

                    if ($tmpfirst == $tmpmin || $tmplast == $tmpmin)
                    {
                        $one = $tmpfirst;
                        $oneX = $tmpXfirst;
                        $two = $tmpmax;
                        $twoX = $tmpXmax;
                        $three = $tmplast;
                        $threeX = $tmpXlast;
                    }
                    else if ($tmpfirst == $tmpmax || $tmplast == $tmpmax)
                    {
                        $one = $tmpfirst;
                        $oneX = $tmpXfirst;
                        $two = $tmpmin;
                        $twoX = $tmpXmin;
                        $three = $tmplast;
                        $threeX = $tmpXlast;
                    }

                    $rx[$rsize] = $oneX;
                    $rx[$rsize + 1] = $twoX;
                    $rx[$rsize + 2] = $threeX;
                    $ry[$rsize] = $one;
                    $ry[$rsize + 1] = $two;
                    $ry[$rsize + 2] = $three;
                    $rsize += 3;
                }
            }
            $i = $j + 1;

        }
        return $rsize;
    }

    /*private void addValuesFrom(Series source) {

    int sourceCount = source.getCount();
    for (int t = 0; t < sourceCount; t++) {
    addedValue(source, t);
    }
    }*/
    /// <summary>
    /// Returns reduced size
    /// </summary>
    public function getReducedSize()
    {
        return $this->r->size;
    }
 
    public function __construct($c=null)
    {
        parent::__construct($c);
        $this->canUsePeriod = false;
        $this->SingleSource = true;
        $this->dPeriod = 1;
        $this->tolerance = 1.0;
        $this->method = DownSamplingMethod::$AVERAGE;
    }
    
    private $displayedPointCount = 0;

    public function getDisplayedPointCount()
    {
        return $this->displayedPointCount;
    }

    public function setDisplayedPointCount($value)
    {
        $this->displayedPointCount = $value;
    }

    /// <summary>
    /// Gets or sets the tolerance for downsampling method. All points within Tolerance will be replaced with one or two points.
    /// </summary>
    public function getTolerance()
    {
        return $this->tolerance;
    }

    public function setTolerance($value)
    {
        if ($this->tolerance != $value)
        {
            $this->tolerance = max(0.0, $value);
            $this->recalculate();
        }
    }

    //#if DESIGNATTRIBUTES
    //[Description("Defines reduction/downsampling method.")]
    //#endif
    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($value)
    {
        if ($this->method != $value)
        {
            $this->method = $value;
            $this->recalculate();
        }
    }

    /// <summary>
    /// Gets all points from Source series, performs a function operation on points and stores results in ParentSeries.
    /// </summary>
    public function addPoints($source)
    {    	
        {
            if (!$this->updating)            
            {
                if ($source != null)
                {
                    if (sizeof($source) > 0)
                    {
                        $s = $source[0]; // single series only!
                        $this->getSeries()->Clear();
                        $n = $s->getCount();
                        $lbound = 0;                                            

                        if ($this->chart != null && ($this->chart->getChartRect()->width != 0))
                        {                                               
                            $this->chart->image($this->chart->getChartRect()->width, $this->chart->getChartRect()->height);
                            $s->calcFirstLastVisibleIndex();                            
                            
                            $n = $s->getLastVisible() - $s->getFirstVisible();
                            $lbound = $s->getFirstVisible();
                        }
                        
                        if ($n > 0)
                        {            	
                            if ($s->getYMandatory() == $this->getSeries()->getYMandatory())
                            {
                                $this->getSeries()->getNotMandatory()->setOrder(
                                        ValueListOrder::$ASCENDING);
                                $this->getSeries()->getMandatory()->setOrder(ValueListOrder::$NONE);
                                // calc visible true
                            }
                            else
                            {
                                $this->getSeries()->getNotMandatory()->setOrder(
                                        ValueListOrder::$NONE);
                                $this->getSeries()->getMandatory()->setOrder(ValueListOrder::$ASCENDING);
                                // calc visible false
                            }

                            $colors = new ColorList($n);
                            
                            $rx = array_fill (0, $n ,0);
                            $ry = array_fill (0, $n ,0);
                            $tmpTol = $this->tolerance;

                            if ($this->getDisplayedPointCount() > 0)
                            {
                                $tmpTol = $this->getDisplayedPointCount() / 4.0;
                                $tmpTol = $n / $tmpTol;
                            }

                            $this->reducedsize = $this->reduce($this->method, $s, $tmpTol, $lbound, $lbound + $n,
                                    $rx,
                                    $ry,
                                    $colors, $this->series->getColor());
                            $this->getSeries()->getNotMandatory()->count = $this->reducedsize;
                            $this->getSeries()->getMandatory()->count = $this->reducedsize;

                            if ($s->getYMandatory())
                            {                            	                                                                                   
                                $this->getSeries()->getNotMandatory()->value = $rx;
                                $this->getSeries()->getMandatory()->value = $ry;
                            }
                            else
                            {
                                $this->getSeries()->getNotMandatory()->value = $ry;
                                $this->getSeries()->getMandatory()->value = $rx;
                            }
                            $this->getSeries()->setColors($colors);                        
                        }
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
    public function getDescription()
    {
        return Language::getString("FunctionDownSampling");
    }
}
class ReduceResults
{
    private $size;
    private $x;
    private $y;

    public function __construct($size, $x, $y)
    {
        $this->size = $size;
        $this->x = $x;
        $this->y = $y;
    }
}
?>