<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: Utils class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */
/**
 * Utils class
 *
 * Description: Chart utility procedures
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */

 class Utils {

    private $TicksPerMillisecond = 10000;
    private $TicksPerSecond;
    private $TicksPerMinute;
    private $TicksPerHour;
    private $TicksPerDay;

    // Number of milliseconds per time unit
    private $MillisPerSecond = 1000;
    private $MillisPerMinute;
    private $MillisPerHour;
    private $MillisPerDay;

    private $DaysPerYear = 365;
    // Number of days in 4 years
    private $DaysPer4Years;
    // Number of days in 100 years
    private $DaysPer100Years;
    // Number of days in 400 years
    private $DaysPer400Years;

    // Number of days from 1/1/0001 to 12/31/1600
    //static final int DaysTo1601 = DaysPer400Years * 4;

    // Number of days from 1/1/0001 to 12/30/1899
    private $DaysTo1899;
    private $DoubleDateOffset;
    // The minimum OA date is 0100/01/01 (Note it's year 100).
    // The maximum OA date is 9999/12/31
    private $OADateMinAsTicks;

    // Converts RGB color to Hex
    static function rgbhex($red,$green,$blue) {
        $red = dechex($red);
        $green = dechex($green);
        $blue = dechex($blue);
      
        while (strlen($red)<2)
           $red = '0'.$red;
        while (strlen($green)<2)
           $green = '0'.$green;
        while (strlen($blue)<2)
           $blue = '0'.$blue;      

      return "#".strtoupper($red.$green.$blue);
    }

    // Hex to RGB color
    static function hex2rgb($color) {
        $color = str_replace('#','',$color);
        $s = strlen($color) / 3;
        $r=hexdec(str_repeat(substr($color,0,$s),2/$s));
        $g=hexdec(str_repeat(substr($color,$s,$s),2/$s));
        $b=hexdec(str_repeat(substr($color,2*$s,$s),2/$s));

        return new Color($r,$g,$b);
    }

    /**
      * Evaluates and returns a steema.<!-- -->teechart.<!-- -->DateTimeStep
      * value as an Axis double scale that may be used to set the
      * steema.<!-- -->teechart.<!-- -->Axis.<!-- -->Increment.
      *
      *
      * @param value DateTimeStep
      * @return double
      */

    public function getDateTimeStep($value) {
        $tmpDateTimeStep = new DateTimeStep();
        return (int) $tmpDateTimeStep->STEP[$value];
    }
    
    public function __construct() {
        $this->TicksPerSecond = $this->TicksPerMillisecond * 1000;
        $this->TicksPerMinute = $this->TicksPerSecond * 60;
        $this->TicksPerHour = $this->TicksPerMinute * 60;
        $this->TicksPerDay = $this->TicksPerHour * 24;
        $this->MillisPerMinute = $this->MillisPerSecond * 60;
        $this->MillisPerHour = $this->MillisPerMinute * 60;
        $this->MillisPerDay = $this->MillisPerHour * 24;
        $this->DaysPer4Years = $this->DaysPerYear * 4 + 1;
        $this->DaysPer100Years = $this->DaysPer4Years * 25 - 1;
        $this->DaysPer400Years = $this->DaysPer100Years * 4 + 1;
        $this->DaysTo1899 = $this->DaysPer400Years * 4 + $this->DaysPer100Years * 3 - 367;
        $this->DoubleDateOffset = $this->DaysTo1899 * $this->TicksPerDay;
        $this->OADateMinAsTicks = ($this->DaysPer100Years - $this->DaysPerYear) * $this->TicksPerDay;
    }

    /**
     * Recursively delete a directory
     *
     * @param string $dir Directory name
     * @param boolean $deleteRootToo Delete specified top-level directory as well
     */
    static function unlinkRecursive($dir, $deleteRootToo) {
      if(!$dh = @opendir($dir)) {
          return;
      }
      while (false !== ($obj = readdir($dh)))  {
        if($obj == '.' || $obj == '..')  {
            continue;
        }

        if (!@unlink($dir . '/' . $obj)) {
            unlinkRecursive($dir.'/'.$obj, true);
        }
      }

      closedir($dh);
   
      if ($deleteRootToo)  {
        @rmdir($dir);
      }
   
      return;
    } 
    
    static function MsgErrorException($msg) {
        try {
            throw new Exception($msg);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }        
    }
    
    // Copied from Microsoft's SSCLI sources.
    static private function ticksToOADate($value) /* todo throws Exception*/ {
        if ($value == 0) {
            return 0.0; // Returns OleAut's zero'ed date value.
        }

        if ($value < $this->TicksPerDay) { // This is a fix for VB. They want the default day to be 1/1/0001 rathar then 12/30/1899.
            $value += $this->DoubleDateOffset; // We could have moved this fix down but we would like to keep the bounds check.
        }
        if ($value < $this->OADateMinAsTicks) {
            throw new Exception("Arg_OleAutDateInvalid");
        }

        // Currently, our max date == OA's max date (12/31/9999), so we don't
        // need an overflow check in that direction.
        $millis = ($value - $this->DoubleDateOffset) / $this->TicksPerMillisecond;
        if ($millis < 0) {
            $frac = $millis % $this->MillisPerDay;
            if ($frac != 0) {
                $millis -= ($this->MillisPerDay + $frac) * 2;
            }
        }
        return (double) $millis / $this->MillisPerDay;
    }

    // return double
    static public function stringToDouble($text, $value) {
        if (strlen($text) == 0) {
            return $value;
        } else {
            try {
                return (double)$text;
            } catch (NumberFormatException $e) {
                return $value;
//            } catch (FormatException e) {
//                return value;
//            } catch (OverflowException e) {
//                return value;
            }
        }
    }

    static public function swapInteger($a, $b)
    {
       $tmpA = round($b);
       $b = $a;
       $a = $tmpA;
    }

    static private function privateSort($l, $r, $c, $s) {
        $i = round($l);
        $j = round($r);
        $x = round(($i + $j) >> 1);
        while ($i < $j) {
            while ($c->CompareValueIndex($i, $x) < 0) {
                $i++;
            } 
            
            while ($c->CompareValueIndex($x, $j) < 0) {
                $j--;
            }
            if ($i < $j) {
                $s->swap($i, $j);
                if ($i == $x) {
                    $x = $j;
                } else if ($j == $x) {
                    $x = $i;
                }
            }
            if ($i <= $j) {
                $i++;
                $j--;
            }
        }
        if ($l < $j) {
            self::privateSort($l, $j, $c, $s);
        }
        if ($i < $r) {
            self::privateSort($i, $r, $c, $s);
        }
    }

    static public function sort($startIndex, $endIndex, $c, $s) {
        self::privateSort($startIndex, $endIndex, $c, $s);
    }

    /**
     * Make a recursive copy of an array
     *
     * @param array $aSource
     * @return array    copy of source array
     */
    static function  array_copy ($aSource) {
        // check if input is really an array
        if (!is_array($aSource)) {
            throw new Exception("Input is not an Array");
        }
       
        // initialize return array
        $aRetAr = array();
       
        // get array keys
        $aKeys = array_keys($aSource);
        // get array values
        $aVals = array_values($aSource);
       
        // loop through array and assign keys+values to new return array
        for ($x=0;$x<count($aKeys);$x++) {
            // clone if object
            if (is_object($aVals[$x])) {
                $aRetAr[$aKeys[$x]]=clone $aVals[$x];
            // recursively add array
            } elseif (is_array($aVals[$x])) {
                $aRetAr[$aKeys[$x]]=array_copy ($aVals[$x]);
            // assign just a plain scalar value
            } else {
                $aRetAr[$aKeys[$x]]=$aVals[$x];
            }
        }
        return $aRetAr;
    }
}
?>