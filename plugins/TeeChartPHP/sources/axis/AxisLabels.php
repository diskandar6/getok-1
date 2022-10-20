<?php
 /**
 * Description:  This file contains the following class:<br>
 * AxisLabels class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * AxisLabels class
 *
 * Description: Axis Label characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

 class AxisLabels extends TextShape {

    // Private Properties
    private $align;
    private $customSize=0;
    private $multiline=false;
    private $exactDateTime = true;
    private $roundfirstlabel = true;
    private $items;
    private $labelsAlternate=false;

    // Protected Properties
    protected $iAngle=0;
    protected $iSeparation = 10;
    protected $bExponent;
    protected $axisvaluesformat=null; // = "DefValueFormat"; // $Language.getString("DefValueFormat");
    protected $valuesDecimal=0;
    protected $sDatetimeformat = "";
    protected $bOnAxis = true;

    // Public Properties
    public $iStyle;
    public $position;    // protected before
    public $axis;        // protected before

    private static $LOCALE;

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

    /**
     * Accesses the Label characteristics of Axis Labels.
     *
     * @param a Axis
     */
    public function __construct($a) {

        $this->iStyle = AxisLabelStyle::$AUTO;
        $this->align= AxisLabelAlign::$DEF;
        $this->axisvaluesformat = null; //Language::getString("DefValueFormat");

        // Set Locale
        setlocale(LC_ALL,'');
        self::$LOCALE = localeconv();

        parent::__construct($a->chart);
       
        $this->axis = $a;
        $this->bTransparent = true;
        $this->items = new AxisLabelsItems($a);
        //$this->readResolve();
    }

    public function __destruct()    
    {        
        parent::__destruct();                
        unset($this->align);
        unset($this->customSize);
        unset($this->multiline);
        unset($this->exactDateTime);
        unset($this->roundfirstlabel);
        unset($this->items);
        unset($this->labelsAlternate);
        unset($this->iAngle);
        unset($this->iSeparation);
        unset($this->bExponent);
        unset($this->axisvaluesformat);
        unset($this->valuesDecimal);
        unset($this->sDatetimeformat);
        unset($this->bOnAxis);
        unset($this->iStyle);
        unset($this->position);
        unset($this->axis);        
        unset($this->labelText);
    }
    
    protected function readResolve() {
    /* TODO 
        $locale = localeconv();
        $this->valuesDecimal = $locale['decimal_point'];
        $this->valuesDecimal = new NumberFormat(); // $this->Language->getString("DefValueFormat"));
        return $this;
        */
    }

    protected function shouldSerializeTransparent() {
        return!$this->bTransparent;
    }

    /**
      * Determines whether Axis.Increment calculates Axis Labels in
      * exact DateTime steps. <br>
      * This is very useful when Axis.Increment is a DateTimeStep constant value.
      * <br>When ExactDateTime is false (the default value), the OneMonth
      * increment equals 30 days, and axis do not calculate how many days a
      * month has. <br>
      * The Series XValues or YValues properties should have DateTime = true.
      * ( XValues for horizontal Axis and YValues for vertical Axis).
      *
      * Default value: false
      *
      * @return boolean
      */
    public function getExactDateTime() {
        return $this->exactDateTime;
    }

    /**
      * Determines whether Axis.Increment calculates Axis Labels in
      * exact DateTime steps. <br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setExactDateTime($value) {
        $this->exactDateTime = $this->setBooleanProperty($this->exactDateTime, $value);
    }

    /**
      * Defines the rotation degree applied to each Axis Label. Valid angle
      * in degrees are 0, 90, 180, 270 and 360. <br>
      * Please note that some printers and video drivers fail when drawing
      * rotated fonts or calculating the rotated font dimensions.
      * Metafile Charts containing rotated fonts sometimes place text
      * at sligthly different coordinates.
      *
      * Default value: 0
      *
      * @return int
      */
    public function getAngle() {
        return $this->iAngle;
    }
    
    /**
      * Defines the rotation degree applied to each Axis Label.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setAngle($value) {
        $this->iAngle = $this->setIntegerProperty($this->iAngle, $value % 360);
    }

    /**
      *
      * Determines whether the Labels at Axis Minimum and Maximum positions
      * will be shown or not.<br>
      *
      * Default value: true
      *
      * @return boolean
      */
    public function getOnAxis() {
        return $this->bOnAxis;
    }
    
    /**
      * Shows the Labels at Axis Minimum and Maximum positions when true.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setOnAxis($value) {
        $this->bOnAxis = $this->setBooleanProperty($this->bOnAxis, $value);
    }

    /**
      * Specifies the minimum distance between Axis Labels as a percentage.
      * Setting it to "0" zero makes Axis skip calculating overlapping labels.
      * (No clipping is performed). Labels visibility depends also on
      * Labels.Font size, Labels.Angle and Axis.Increment properties. <br>
      * Default value: 10
      *
      * @return int
      */
    public function getSeparation() {
        return $this->iSeparation;
    }

    /**
      * Specifies the minimum distance between Axis Labels as a percentage.<br>
      * Default value: 10
      *
      * @param value int
      */
    public function setSeparation($value) {
        $this->iSeparation = $this->setIntegerProperty($this->iSeparation, $value);
    }

    /**
      * Changes the spacing occupied by the axis labels between the Ticks and
      * the Title.<br>
      * Default value: 0
      *
      * @return int
      */
    public function getCustomSize() {
        return $this->customSize;
    }

    /**
      * Changes the spacing occupied by the axis labels between the Ticks and
      * the Title.<br>
      * Default value: 0
      *
      * @param value int
      */
    public function setCustomSize($value) {
        $this->customSize = $this->setIntegerProperty($this->customSize, $value);
    }

    /**
      * The style of the labels. Setting Axis.Label.Style to talAuto will
      * force the Axis to guess what labels will be drawn. For each Active
      * associated Series, if the Series have XLabels then the Label.Style
      * will be talText. If no Series have XLabels, then Label.Style will be
      * talValue. If no Active Series are associated with the Axis,
      * then Label.Style will be talNone. <br>
      * Default value: AxisLabelStyle.Auto
      *
      * @return AxisLabelStyle
      */
    public function getStyle() {
        return $this->iStyle;
    }

    /**
      * Sets the style of the labels.<br>
      * Default value: AxisLabelStyle.Auto
      *
      * @param value AxisLabelStyle
      */
    public function setStyle($value) {
        if ($this->iStyle != $value) {
            $this->iStyle = $value;
            $this->invalidate();
        }
    }

    /**
      * Controls if Axis labels will be automatically "rounded" to the nearest
      * magnitude. Run-time only. This applies both to DateTime and non-DateTime
      * axis values. When false, Axis labels will start at Maximum Axis value.<br>
      * Default value: true
      *
      * @return boolean
      */
    public function getRoundFirstLabel() {
        return $this->roundfirstlabel;
    }

    /**
      * Axis labels will be automatically "rounded" to the nearest magnitude when
      * true.<br>
      * Default value: true
      *
      * @param value boolean
      */
    public function setRoundFirstLabel($value) {
        $this->roundfirstlabel = $this->setBooleanProperty($this->roundfirstlabel, $value);
    }

    /**
      * Standard DateTime formatting string specifier used to draw the
      * axis labels.<br>
      * Default value: ""
      *
      * @return String
      */
    public function getDateTimeFormat() {
        return $this->sDatetimeformat;
    }

    /**
      * Standard DateTime formatting string specifier used to draw the
      * axis labels.<br>
      * Default value: ""
      *
      * @param value String
      */
    public function setDateTimeFormat($value) {
        $this->sDatetimeformat = $this->setStringProperty($this->sDatetimeformat, $value);
    }

    /**
      * Specifies the desired formatting string to be applied to Axis Labels.
      * It has effect when Axis associated Series have their XValues.DateTime
      * or YValues.DateTime property set to false.<br>
      * For DateTime Axis labels use the AxisLabels.DateTimeFormat property.<br>
      * ValueFormat is a standard formatting string specifier. Chart Axis uses
      * it to draw the axis labels. Chart Series uses it to draw the Marks. <br>
      * Default value: '#,##0.###'
      *
      * @return formatting String to be applied to Axis Labels.
      */
    public function getValueFormat() {
        return $this->axisvaluesformat;
    }

    /**
      * Specifies the desired formatting string to be applied to Axis Labels.<br>
      * Default value: '#,##0.###'
      *
      * @param value String
      */
    public function setValueFormat($value) {
      if ($this->axisvaluesformat != $value) {
        $this->axisvaluesformat = $this->setStringProperty($this->axisvaluesformat, $value);
        // todo $this->valuesDecimal = new NumberFormat($this->axisvaluesformat);
      }
    }

    /**
      * Automatically breaks DateTime Labels on occurence of a space " ".
      * Use '\n' in other label types to break a line or use SplitInLines in
      * the OnGetAxisLabel event. <br>
      * Default value: false
      *
      * @return boolean
      */
    public function getMultiLine() {
        return $this->multiline;
    }

    /**
      * Automatically breaks DateTime Labels on occurence of a space " ".<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setMultiLine($value) {
        $this->multiline = $this->setBooleanProperty($this->multiline, $value);
    }

    /**
      * Sets Separator String to invoke 'new line' in String St. Replaces input
      * string St with separator to be used to break lines at each occurrence
      * of the separator.
      *
      * @param s Input String
      * @param separator String to be used for new line
      * @return String
      */
    public function splitInLines($s, $separator) {
        $loc = 0;

        do {
            $loc = strrpos($s,$separator, 0);
            if ($loc != false) {                
                $s = substr($s, 0, $loc - 1) . Language::getString("LineSeparator");
            }
        } while ($loc != false);

        return $s;
    }

    /**
      * Enables/disables the display of Axis Labels in exponent format with
      * super-script fonts.<br>
      * Default value: false
      *
      * @return boolean
      */
    public function getExponent() {
        return $this->bExponent;
    }

    /**
      * Enables/disables the display of Axis Labels in exponent format with
      * super-script fonts.<br>
      * Default value: false
      *
      * @param value boolean
      */
    public function setExponent($value) {
        $this->bExponent = $this->setBooleanProperty($this->bExponent, $value);
    }

    /**
      * The position of Labels on an Axis.<br>
      * The default position of an AxisLabel will depend on the Axis with which
      * it is associated. A Bottom Axis will place Labels below the Axis by
      * default. A Top Axis will place the Labels above the Axis.<br>
      * Default value: Default position <br>
      * Opposite: Labels positioned on the opposite side to the default position.
      *
      * @return AxisLabelAlign
      */
    public function getAlign() {
        return $this->align;
    }

    /**
      * Sets the position of Labels on an Axis.<br>
      * Default value: Default position
      *
      * @param value AxisLabelAlign
      */
    public function setAlign($value) {
        if ($this->align != $value) {
            $this->align = $value;
            $this->invalidate();
        }
    }

    /**
      * Contains the custom labels.
      *
      * @return AxisLabelsItems
      */
    public function getItems() {
        return $this->items;
    }

    private function internalLabelSize($value, $isWidth) {
         $m = $this->chart->multiLineTextWidth($this->labelValue($value));

         $result = $m->width;
         $tmp = $m->count;

        if ($isWidth) {
            $tmpMulti = ($this->iAngle == 90) || ($this->iAngle == 270);
        } else {
            $tmpMulti = ($this->iAngle == 0) || ($this->iAngle == 180);
        }

        if ($tmpMulti) {
            $result = $this->chart->getGraphics3D()->getFontHeight() * $tmp;
        }

        return $result;
    }

    /**
      * returns the Axis Label width of the Value parameter. It uses the Axis
      * formatting specifiers, the Axis Labels Font and the Labels rotation
      * and style.
      *
      * @param value double Axis value
      * @return int Axis Label width in pixels
      */
    public function labelWidth($value) {
        //			int tmp;
        //			int tmpResult=chart.MultiLineTextWidth(LabelValue(value),tmp);
        //			if ((angle==90) || (angle==270))
        //			{
        //				tmpResult=chart.getGraphics3D().FontHeight*tmp;
        //			}
        return $this->internalLabelSize($value, true);
        //return tmpResult;
    }

    /**
      * returns the Axis Label height of the Value parameter. It uses the Axis
      * formatting specifiers, the Axis Labels Font and the Labels rotation
      * and style.
      *
      * @param value double Axis value
      * @return int Axis Label height in pixels
      */
    public function labelHeight($value) {
        return $this->internalLabelSize($value, false);
        //			int tmp;
        //			int tmpResult=chart.MultiLineTextWidth(LabelValue(value),out tmp);
        //			if ((angle==0) || (angle==180))
        //				tmpResult=chart.getGraphics3D().FontHeight*tmp;
        //			return tmpResult;
    }

    /**
    * returns the corresponding text representation of the Value parameter.
    * It uses the Axis formatting specifiers.
    *
    * @param value double
    * @return String
    */
    public $labelText = '';
       
    public function labelValue($value) {

        if ($this->axis->iAxisDateTime) {
     //MM todo   //if ((value >= -657435) && (value <= 2958466)){
                try {  //CDI TF02010053
                    if (strlen($this->sDatetimeformat) == 0) {
                        $tmpResult = date($this->axis->dateTimeDefaultFormat($this->axis->iRange),$value);
                    } else {
                        $tmpResult = date($this->sDatetimeformat,$value);
                    }
                } catch (Exception $e) {
                        $tmpResult = date($this->axis->dateTimeDefaultFormat($this->axis->iRange),$value);
                }
       /* } else {
            $tmpResult="";
          }  */
        } else {
            try { // CDI TF02010053
                if (fmod((double)$value,1)!=0) {
                  if (self::$LOCALE['frac_digits'] != $this->valuesDecimal)
                    $decimals=$this->valuesDecimal;
                  else
                    $decimals=self::$LOCALE['frac_digits'];
                }
                else
                  $decimals=$this->getFrac_digits();

                $tmpResult = number_format((float)$value,$decimals,
                    self::$LOCALE['decimal_point'],
                    self::$LOCALE['thousands_sep']);

                if ($tmpResult=='-0') {
                    $tmpResult='0';
                }

            } catch (Exception $e) {
                $locale = localeconv();
                $tmpResult = number_format((float)$value, $decimals,
                    $locale['decimal_point'],
                    $locale['thousands_sep']);
            }
        }

        $parent=$this->chart->getParent();
        
        if ($parent != null) {
            $this->labelText = $tmpResult;
            // Args  : Axis, valueindex display order, label
            $parent->TriggerEvent('OnGetAxisLabel', array($this->axis,$this->axis->labelIndex, $this->labelText));
            
            if ($this->labelText != $tmpResult)
               $tmpResult = $this->labelText;
        }

        if ($this->multiline) {
            $tmpResult = $this->splitInLines($tmpResult, " ");
        }

        return $tmpResult;
    }

    public function setFrac_digits($value) {
        $this->valuesDecimal = $this->setIntegerProperty($this->valuesDecimal, $value);
    }

    public function getFrac_digits() {
        return $this->valuesDecimal;
    }

    /**
     * Gets the axis labels to be drawn in two rows or columns.
     *
     * @return boolean
     */
    public function getAlternate() {
        return $this->labelsAlternate;
    }

    /**
     * Gets the axis labels to be drawn in two rows or columns.
     *
     * @return boolean
     */
    public function setAlternate($value) {
        $this->labelsAlternate=$this->setBooleanProperty($this->labelsAlternate,$value);
    }
}
?>