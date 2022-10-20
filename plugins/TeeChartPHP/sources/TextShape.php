<?php
 /**
 * Description:  This file contains the following class:<br>
 * TextShape class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * TextShape class
 *
 * Description: Base class for Chart shape elements with text
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class TextShape extends TeeShape {

    private $DEFAULTROUNDSIZE = 16;
    protected $drawText = true;
    public $defaultText = "";

    private $lines;
    private $shapeStyle;
    private $font;
    private $textFormat;

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
    * The class constructor.
    */
    public function __construct($c=null) {
        $this->lines = array();
        $this->shapeStyle = TextShapeStyle::$RECTANGLE;
        $this->textFormat = TextFormatted::$NORMAL;

        parent::__construct($c);
        $this->readResolve();
    }

    public function __destruct()    
    {        
        parent::__destruct();

        unset($this->DEFAULTROUNDSIZE);
        unset($this->drawText);
        unset($this->defaultText);
        unset($this->lines);
        unset($this->shapeStyle);
        if (isset($this->font))
        {
            $this->font->__destruct();
            unset($this->font);
        }
        unset($this->textFormat);    
    }          
        
    protected function readResolve() {
        $this->drawText = true;
        $this->defaultText = "";
        return $this;
    }

    public function setChart($c) {
        parent::setChart($c);
        if ($this->font != null) {
            $this->font->setChart($this->chart);
        }
    }

    /**
     * Shape may be rectagular or rounded rectangular in shape. <br>
     * Default value: TextShapeStyle.Rectangle
     *
     * @return TextShapeStyle
     */
    public function getShapeStyle() {
        return $this->shapeStyle;
    }

    public function setDrawText($value) {
        $this->drawText = $value;
    }

    /**
     * Shape may be rectagular or rounded rectangular in shape. <br>
     * Default value: TextShapeStyle.Rectangle
     *
     * @param value TextShapeStyle
     */
    public function setShapeStyle($value) {
        if ($this->shapeStyle != $value) {
            $this->shapeStyle = $value;
            $this->invalidate();
        }
    }

    /**
     * Determines if Text is drawn as Normal or HTML styles.
     * Default value: TextFormatted::$Normal
     */
    public function getTextFormat(){
        return $this->textFormat;
    }

    public function setTextFormat($value) {
        if ($this->textFormat != $value)
            $this->textFormat = $value;
        $this->invalidate();
    }

    /**
     * Obsolete.&nbsp;Please use Shadow.<!-- -->Size.
     *
     * @return int
     */
    public function getShadowSize() {
        return $this->getShadow()->getWidth();
    }

    /**
     * Obsolete.&nbsp;Please use Shadow.<!-- -->Size.
     *
     * @param value int
     */
    public function setShadowSize($value) {
        $this->getShadow()->setWidth($value);
    }

    protected function getLinesLength() {
        return ($this->lines == null) ? 0 : count($this->lines);
    }

    static private function stringJoin($separator, $source) {
        $result = "";
        for ($t = 0; $t < sizeof($source); $t++) {
            $result = $result . $source[$t] . $separator;
        }
        return $result;
    }

    /**
     * Displays customized strings inside Shapes. <br>
     * You can use Font and Aligment to control Text display.  <br><br>
     * Note: You would maybe need to change Shape Font size to a different
     * value when creating metafiles or when zooming Charts.
     *
     * @return String
     */
    public function getText() {
       /* TODO  correct line, temp code added      
          return ($this->getLinesLength() == 0) ? "" : $this->stringJoin($Language->getString("crlf"), $this->lines);
       */
       return ($this->getLinesLength() == 0) ? "" : $this->lines[0];
    }

    /**
     * Displays customized strings inside Shapes. <br>
     *
     * @param value String
     */
    public function setText($value) {
        if ($this->getText()!=$value) {
            $this->lines = null;

            /* TODO
            One separator can be single char, so use a trick and replace \r\n with \n            
            $istr = $value->replaceAll($Language->getString("crlf"), $Language->getString("LineSeparator"));
            $this->lines = $StringFormat->split($istr, $Language->getString("LineSeparator"));
            */
            $this->lines[]=$value;
            $this->invalidate();
        }
    }

    /**
     * Accesses the array of Text lines.<br>
     * Use lines to add multiline text to TeeChart's text objects
     * (TeeChart Header, TeeChart Axis Titles etc.). <br>
     * Default value: null
     *
     * @return String[]
     */
    public function getLines() {
        return $this->lines;
    }

    /**
     * Accesses the array of Text lines.<br>
     * Default value: null

     * @param value String[]
     */
    public function setLines($value) {
        $this->lines[] = $value;
        $this->invalidate();
    }

    /**
     * Determines the font attributes used to output
     * ShapeSeries.<!-- -->Text Strings.
     *
     * @return ChartFont
     */
    public function getFont() {
        if ($this->font == null) {
            $this->font = new ChartFont($this->chart);
        }
        return $this->font;
    }

    /**
     * Assign all properties from a TextShape to another.
     *
     * @param s TextShape
     */
    public function assign($s) {
        if ($s != null) {
            parent::assign($s);

            if ($s->font != null) {
                $this->getFont()->assign($s->font);
            }
            $this->lines = $s->lines;
            $this->shapeStyle = $s->shapeStyle;
        }
    }

    /**
     * Paints the TextShape object on the Chart Canvas.
     */
    public function paint($gd=null, $rect=null) {
        $this->_paint($this->chart->getGraphics3D(), $this->getShapeBounds());
    }

    /**
     * Paints the TextShape object on the Chart Canvas.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     */
    public function _paint($gd, $rect, $animations=null) {
        $tmpText=$this->getText();
        
        if ($this->drawText && ($this->lines != null)) {
            $gd->setFont($this->font);

            $tmpW = $gd->textWidth($tmpText);
            $x = $rect->getRight();

            $rect->width = $tmpW;
            $rect->height = $gd->textHeight($tmpText);

            $rect->x = (($rect->x + $x) / 2) - $tmpW;
        }

        if ($this->bBevel != null) {
            if ($this->bBevel->getInner() != BevelStyle::$NONE) {
                $rect->grow(1, 1);
            }
            if ($this->bBevel->getOuter() != BevelStyle::$NONE) {
                $rect->grow(1, 1);
            }
        }

        //CDI Fix for TextShapeStyle
        if ($this->shapeStyle == TextShapeStyle::$RECTANGLE) {
            if ($this->getBorderRound()!=0) {
               $this->setBorderRound(0);
            }
        } else
        if ($this->shapeStyle == TextShapeStyle::$ROUNDRECTANGLE) {
            if ($this->getBorderRound()!=8) {
              $this->setBorderRound(8);
            }
        }

        $this->drawRectRotated($gd, $rect, 0, 0, $animations);

        if ($this->drawText && ($this->lines != null)) {
            $gd->textOut($rect->x, $rect->y + 2, 0, $tmpText);
        }
    }

    private function internalDrawShape($gd, $aRect, $defaultRoundSize, $angle, $aZ,$animations=null) {
        if ($angle > 0) {
            $gd->polygonZ($aZ, $gd->rotateRectangle($aRect, $angle));
        } else {
            if ($gd->getSupportsFullRotation()) {
                $gd->rectangleWithZ($aRect, $aZ);
            } else {
                if ($this->shapeStyle == TextShapeStyle::$RECTANGLE) {
                    $gd->rectangle($aRect);  // $animations
                } else {
                    $gd->roundRectangle($aRect,$defaultRoundSize,$defaultRoundSize);
                }
            }
        }
    }

    /**
     * Draws the Shape rectangle rotated by Angle degrees.
     *
     * @param g IGraphics3D
     * @param rect Rectangle
     * @param angle int
     * @param aZ int
     */
    public function drawRectRotated($gd, $rect, $angle, $aZ, $animations=null) {
        if (!$this->bTransparent) {
            if ($this->getShadow()->getVisible() && $this->getBrush()->getVisible()) {
                if (!$gd->getSupportsFullRotation()) {
                    $this->shadow->draw($gd, $rect, $angle, $aZ); // internaldrawshape !
                }
            }

//            if (($this->getGradient()->getVisible()) && ($angle == 0)) {
         //       $this->getGradient()->fill($gd->img,
         //       $this->getGradient()->getDirection(),
         //       $this->getGradient()->getStartColor(),
         //       $this->getGradient()->getEndColor());

         //       $gd->getBrush()->setVisible(false);
  //          } else {
                $gd->setBrush($this->getBrush());
    //        }

            $gd->setPen($this->getPen());
            $this->internalDrawShape($gd, $rect, $this->DEFAULTROUNDSIZE, $angle, $aZ, $animations);
        }

        if ($this->bBevel != null) {
            $this->bBevel->draw($gd, $rect);
        }
    }
}
?>
