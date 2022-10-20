<?php
 /**
 * Description:  This file contains the following class:<br>
 * ValueList class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * ValueList class
 *
 * Description: Array to hold Series data point values
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class ValueList extends TeeBase {

    public $defaultCapacity=0;
    public $value;
    public $count=0;
    public $capacity;
    public $dateTime=false;
    public $maximum;
    public $minimum;
    public $total;
    public $totalABS;
    public $statsOk;
    public $tempValue;
    public $valueSource = "";
    public $series;

    private $order;

    // "name" should not be transient, as it can be the "valueSource"
    // (setDataMember) of another series source. So it must be serialized.
    protected $name;

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

    public function __construct($s, $name, $initialCapacity=-1) {
        if ($initialCapacity==-1) {
            $initialCapacity=$this->defaultCapacity;
        }

        $this->value = Array();
        $this->order = ValueListOrder::$NONE;

        parent::__construct(null);
       
        $this->series = $s;
        $this->series->valuesListAdd($this);
        $this->name = $name;
        $this->capacity = $initialCapacity;
    }
    
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->defaultCapacity);
        unset($this->value);
        unset($this->count);
        unset($this->capacity);
        unset($this->dateTime);
        unset($this->maximum);
        unset($this->minimum);
        unset($this->total);
        unset($this->totalABS);
        unset($this->statsOk);
        unset($this->tempValue);
        unset($this->valueSource);
        unset($this->valueSource);
        unset($this->series);
        unset($this->order);
        unset($this->name);
    }            

    /**
      * Field to use as source for this value list.<br>
      * Default value: ""
      *
      * @return String
      */
    public function getDataMember() {
        return $this->valueSource;
    }

    /**
      * Field to use as source for this value list.<br>
      * Default value: ""
      *
      * @param value String
      */
    public function setDataMember($value) {
        if (! $this->valueSource->equals($value)) {
            $this->valueSource = $value;
            if ($this->series != null) {
                $this->series->checkDataSource();
            }
        }
    }

    /**
      * Allows values to be expressed either as numbers or as Date+Time
      * values.<br><br>
      * Each Series value list has a boolean property called DateTime.  The
      * boolean DateTime method tells TeeChart what type the numbers are. The
      * horizontal (x axis) and vertical (y axis) value defaults are number
      * format (DateTime False). DateTime can be changed both at design-time and
      * run-time, forcing the Chart to repaint. It used whenever a value must be
      * converted to text, for example, to draw it as the chart axis labels.
      * Axis labels will be drawn in DateTime or numeric format accordingly to
      * the setting of the DateTime method. <br><br>
      * You can also set the Chart Series ValueFormat and the Chart Axis
      * DateTimeFormat formatting strings, to control how the values will be
      * displayed. <br>
      * Default value: false
      *
      * @return boolean
      */
    public function getDateTime() {
        return $this->dateTime;
    }

    /**
      * Allows values to be expressed either as numbers or as Date+Time
      * values.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setDateTime($value) {
        if ($this->dateTime != $value) {
            $this->dateTime = $value;
            $this->series->invalidate();
        }
    }

    /**
      * Determines if points are automatically sorted or left at original
      * position.<br> Runtime only. <br>
      * This Order is used by default by the Series XValues to draw lines from
      * Left to Right. Setting the XValues.Order property to loNone will respect
      * the points order at point creation. This can be used to draw polygons.
      * <br>Default value: None
      *
      * @return ValueListOrder
      */
    public function getOrder() {
        return $this->order;
    }

    /**
      * Determines if points are automatically sorted or left at original
      * position.<br> Runtime only. <br>
      * Default value: None
      *
      * @param value ValueListOrder
      */
    public function setOrder($value) {
        if ($this->order != $value) {
            $this->order = $value;
            //DB: Removed as it breaks series initialization at design-time,
            //when changing series order it'll call fillSampleValues.
            //if (series != null) {
            //    series.checkDataSource();
            //}
        }
    }

    /**
      * Returns the name of this ValueList.
      * The Name property can be used to link series when using functions.
      * You can link one series ValueList to another series list, by using
      * the setDataMember method.
      *
      * For example:
      *
      * mySeries.setDataSource( myCandle );
      * mySeries.getYValues().setDataMember(myCandle.getHighValues().getName());
      *
      * @param name String
      */
    public function setName($name) {
        $this->name = $name;
    }

    /**
      * Returns the name of this ValueList.
      * The "Name" property is used as the "dataMember" of other series
      * when they are linked through functions.
      *
      * @return String
      */
    public function getName() {
        return $this->name;
    }

    /**
      * Removes all values in the list.
      * Warning: You should not call this "clear" method directly.
      * Call the series "clear" method instead.
      */
    public function clear() {
        $this->count = 0;
        $this->value = Array(); 
    }

    /**
      * Returns the corresponding point index which has the specified Value.<br>
      * You can use it for example to obtain X co-ordinates based on Y values, or
      * vice-versa.
      *
      * @param value double
      * @return int
      */
    public function indexOf($value) {
        for ( $t = 0; $t < sizeof($this->value); $t++) {
            if ($this->value[$t] == $value) {
                return $t;
            }
        }
        return -1;
    }

    public function removeRange($index, $count) {
        $this->count -= $count;
        for ( $t = $index; $t < $this->count; $t++) {
            $this->value[$t] = $this->value[$t + $count];
        }
        $this->statsOk = false;
    }

    public function removeAt($index) {
        $this->removeRange($index, 1);
    }

    /**
      * Re-orders Series points, interchanging their position in the Series
      * Values lists.<br>
      * By default, Series are set to sort points in ascending order using their
      * X coordinates. This is accomplished with this code: <br><br>
      * [C#]<br>
      * tChart1.getSeries(0).getXValues().setOrder( loAscending )<br>
      * tChart1.getSeries(0).getYValues().setOrder( loNone )<br><br>
      * By default, Series draw points using the point ValueIndex, except in
      * some non common situations like having the horizontal axis inverted.<br>
      * <b>Important Note:</b>  Re-Ordering Series points do NOT change point
      * X coordinates. Series points which have no X coordinates are assigned a
      * unique incremental number to determine the point horizontal positions.
      * Automatic Point indexes  start at zero. You will need to change every
      * point X coordinate when sorting Series points with automatic X values.
      */
    public function sort() {
        if ($this->order != ValueListOrder::$NONE) {            
            Utils::sort(0, $this->count - 1,
                            $this,
                            $this->series
                       );
        }
    }

        // Eliminates excess of empty values in array.
        // (Array always contains Count plus some more empty values to
        // reduce overhead expanding the array each time a new value is added).
    public function trim() {
        /*double[]*/ $newValue = array(); // todo review double[$this->count];
        $this->System->arraycopy($this->value,0,$this->newValue,0,$this->count);

        /*
        for (int t = 0; t < count; t++) {
            newValue[t] = value[t];
        }
        */

        $this->value = $this->newValue;
    }

        /**
          * Returns the First point value.
          *
          * @return double
          */
    public function getFirst() {
        return $this->value[0];
    }

    function insertChartValue($valueIndex,$value) {

        $this->incrementArray();

        for ($t = $this->count - 1; $t > $valueIndex; $t--) {
              $this->value[$t] = $this->value[$t - 1];
        }

        $this->value[$valueIndex] = $value;
        $this->statsOk = false;
    }

        /**
          * Returns the Last point value.<br>
          * This is the same value as the Count - 1 index value:
          *
          * @return double
          */
    public function getLast() {
        return $this->value[$this->count - 1];
    }

        /**
          * Obsolete.&nbsp;Please use IndexOf method instead.
          *
          * @param value double
          * @return int
          */
    public function locate($value) {
        return $this->indexOf($value);
    }

    public function assign($value) {
        $this->order = $value->order;
        $this->dateTime = $value->dateTime;
        $this->name = $value->name;
        $this->valueSource = $value->valueSource;
    }

    private function calcStats() {
        if ($this->count > 0) {
            $this->minimum = $this->value[0];
            $this->maximum = $this->minimum;
            $this->total = $this->minimum;
            $this->totalABS = abs($this->total);

            for ( $t = 1; $t < $this->count; $t++) {
                $tmp = $this->value[$t];
                if ($tmp < $this->minimum) {
                    $this->minimum = $tmp;
                }
                if ($tmp > $this->maximum) {
                    $this->maximum = $tmp;
                }
                $this->total += $tmp;
                $this->totalABS += abs($tmp);
            }
        } else {
            $this->minimum = 0;
            $this->maximum = 0;
            $this->total = 0;
            $this->totalABS = 0;
        }
        $this->statsOk = true;
    }

    /**
      *
      * @return double
      */
    public function getRange()
        {
                if (!$this->statsOk) {
                        $this->calcStats();
                }
                return $this->maximum - $this->minimum;
        }

        /**
          * The highest of all values in the list.<br>
          * As new points are being added to Series, the IValueList object
          * calculates the Maximum, Minimum and TotalABS properties. <br>
          * This applies to all Series lists of values, such as XValues, YValues,
          * etc. <br>
          *
          * @return double
          */
    public function getMaximum()
        {
                if (!$this->statsOk) {
                        $this->calcStats();
                }
                return $this->maximum;
        }

        /**
          * Obsolete.&nbsp;Please use Maximum method instead.
          *
          * @return double
          */
    public function getMaxValue() {
        return $this->maximum;
    }

        /**
          * Obsolete.&nbsp;Please use Minimum instead.
          *
          * @return double
          */
    public function getMinValue() {
        return $this->minimum;
    }

        /**
          * The lowest of all values in the list.<br>
          *
          * @see ValueList#getMaximum
          * @return double
          */
    public function getMinimum() {
        if (!$this->statsOk) {
            $this->calcStats();
        }
        return $this->minimum;
    }

        /**
          * The sum of all IValueList values.<br>
          * When adding, deleting or modifying point values using the right methods,
          * Total is automatically incremented and decremented. <br>
          * Total is used by some Functions to improve speed when performing
          * calculations against point values, where having already calculated
          * the sum of point values is necessary. <br>
          *
          * @return double
          */
    public function getTotal() {
        if (!$this->statsOk) {
            $this->calcStats();
        }
        return $this->total;
    }

        /**
          * The sum of all absolute values in the list.<br>
          * Run-time and read only. <br>
          * The values are first converted to their absolute value.<br>
          * Pie series, for example, uses this property to calculate the percent
          * each Pie slice represents. <br>
          *
          * @see ValueList#getMaximum
          * @return double
          */
    public function getTotalABS() {
        if (!$this->statsOk) {
            $this->calcStats();
        }
        return $this->totalABS;
    }

    public function getValue($index) {
        return $this->value[$index];
    }

    public function setValue($index, $value) {
        $this->value[$index] = $value;
        $this->statsOk = false;
    }

    // For XMLEncoder only
    public function getValues() {
      return $this->value;
    }

    // For XMLEncoder only
    public function setValues($value) {
      $this->value=$value;
    }

    // For XMLEncoder only
    public function getCount() {
      return $this->count;
    }

    // For XMLEncoder only
    public function setCount($value) {
      $this->count=$value;
    }

    public function asDateTime($index) {
        return new DateTime($this->value[$index]);
    }

    private function incrementArray() {
        $this->count++;
         $tmp = sizeof($this->value);
        if ($this->count > $tmp) {
            if ($this->capacity > 0) {
                $tmp += $this->capacity;
            } else
            if ($this->count > 3) {
                $tmp += $this->count / 4;
            } else {
                $tmp += 100;
            }
            /*double[]*/ $newValue = array(); //todo review new double[$tmp];

// TODO Review   before         System->arraycopy($this->value,0,newValue,0,$this->count-1);

            $newValue=$this->value;
            $this->value = $newValue;
        }
    }

    function addChartValue($value) {

                if ($this->order == ValueListOrder::$NONE) {
                        $result = $this->count;

                        $this->incrementArray();
                        $this->value[$result] = $value;
                } else {
                        $t = $this->count - 1;
                        if (($t == -1) ||
                                (($this->order == ValueListOrder::$ASCENDING) &&
                                  ($value >= $this->value[$t])) ||
                                (($this->order == ValueListOrder::$DESCENDING) &&
                                  ($value <= $this->value[$t]))) {

                                $result = $this->count;
                                $this->incrementArray();
                                $this->value[$result] = $value;
                        } else {
                                if ($this->order == ValueListOrder::$ASCENDING) {
                                        while (($t >= 0) && ($this->value[$t] > $value)) {
                                                $t--;
                                        }
                                } else {
                                        while (($t >= 0) && ($this->value[$t] < $value)) {
                                                $t--;
                                        }
                                }
                                $result = $t + 1;

                                $this->incrementArray();
                                for ($t = ($this->count - 1); $t > ($result); $t--) {
                                        $this->value[$t] = $this->value[$t - 1];
                                }
                                $this->value[$result] = $value;
                        }
                }
                $this->statsOk = false;
                return $result;
        }


    /**
      * Renumbers all values in a ValueList class starting at zero.<br>
      * <b>Warning:</b>  Calling fillSequence removes any previous value in a
      * ValueList. <br>
      * Use fillSequence when deleting points at runtime.
      *
      * @see ValueList#sort
      */
    public function fillSequence() {
        for ( $t = 0; $t < $this->count; $t++) {
            $this->value[$t] = $t;
        }
        $this->statsOk = false;
    }

    public function exchange($index1, $index2) {
        $tmp = $this->value[$index1];
        $this->value[$index1] = $this->value[$index2];
        $this->value[$index2] = $tmp;
    }

    public function CompareValueIndex($a, $b) {
        $result = 0;                
        if ((int)$this->value[$a] < (int)$this->value[$b]) {
          $result= -1;  
        } 
        else {
            if ($this->value[$a] > $this->value[$b]) {
                $result = 1;
            }
        }
            
        if ($this->order == ValueListOrder::$DESCENDING) {
            $result = -$result;
        }
        return $result;
    }
}
?>