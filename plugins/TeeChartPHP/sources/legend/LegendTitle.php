<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: LegendTitle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */
/**
 * LegendTitle class
 *
 * Description: Legend title characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */

 class LegendTitle extends TextShape {

    private $textAlign;
    private $tmpFrameWidth;
    private $tmpXPosTitle;
    private $tmpMargin;
    private $FontH;

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
    public function __construct($c) {
        $this->textAlign = Array(StringAlignment::$CENTER);

        parent::__construct($c);

        $tmpColor = new Color(0,0,0);
        $font = $this->getFont();
        $font->setColor($tmpColor);
        $font->setBold(true);
        $font->getBrush()->setDefaultColor($tmpColor);
        $this->getPen()->setVisible(false);
        
        unset($tmpColor);
    }
    
   public function __destruct()    
   {        
        parent::__destruct();       
                 
        unset($this->textAlign);
        unset($this->tmpFrameWidth);
        unset($this->tmpXPosTitle);
        unset($this->tmpMargin);
        unset($this->FontH);
   }       

    // Determines if text is displayed at left, center or right side of chart legend title.
    // Description("Horizontal alignment of displayed text.")

    public function getTextAlign()  {
        return $this->textAlign;
    }

    public function setTextAlign($value) {
        if ($this->textAlign!=$value) {
            $this->textAlign=$value;
            $this->invalidate();
        }
    }

    public function calcHeight() {
        $this->getChart()->getGraphics3D()->getFont()->assign($this->getFont());
        $this->setHeight(MathUtils::round($this->getChart()->getGraphics3D()->textHeight("W") * sizeof($this->lines)));

        if(!$this->getTransparent()) {
            $this->setHeight($this->getHeight()+2);
            if ($this->getPen()->getVisible())
                $this->setHeight($this->getHeight()+(2 * $this->getPen()->getWidth()));
            }
    }

    public function drawLineTitle($AIndex) {
        $tmparray = $this->lines;
        $St=$tmparray[$AIndex];
        $APos=$this->getShapeBounds()->getTop();
        $APos+=($AIndex+1 * $this->FontH) + $this->tmpFrameWidth;

        if (in_array(StringAlignment::$FAR,$this->textAlign)) {
            $this->tmpXPosTitle = $this->getShapeBounds()->getRight() - MathUtils::round($this->getChart()->getGraphics3D()->textWidth($St)) - ($this->tmpMargin / 2);
        }
        else
        if (in_array(StringAlignment::$CENTER,$this->textAlign)) {
            $this->tmpXPosTitle = MathUtils::round(($this->getShapeBounds()->getLeft()+$this->getShapeBounds()->getRight()) / 2) - MathUtils::round($this->getChart()->getGraphics3D()->textWidth($St) / 2);
        }

        $this->getChart()->getGraphics3D()->textOut($this->tmpXPosTitle,$APos,0, $St, $this->textAlign);
    }

    public function drawText() {
        if($this->getPen()->getVisible())
            $this->tmpFrameWidth=$this->getPen()->getWidth();
        else
            $this->tmpFrameWidth = 1;

        $this->tmpMargin = MathUtils::round($this->getChart()->getGraphics3D()->textWidth("W"));
        $this->FontH = MathUtils::round($this->getChart()->getGraphics3D()->textHeight("W"));

        if (in_array(StringAlignment::$NEAR,$this->textAlign)) {
            $this->tmpXPosTitle=$this->getShapeBounds()->getLeft() + ($this->tmpMargin/2);
        }

        if ($this->getTextFormat() == TextFormatted::$NORMAL) {
            for($t=0; $t < sizeof($this->lines); ++$t) {
                $this->drawLineTitle($t);
            }
        } else {
            $this->getChart()->getGraphics3D()->setTextAlign($this->textAlign);
            $this->getChart()->getGraphics3D()->textOut($this->tmpXPosTitle,$this->tmpFrameWidth+$this->getShapeBounds()->getTop(),0,$this->getText());
        }
    }

    public function internalDraw($g, $Rect) {
        $this->calcShapeBounds($Rect);
        $this->drawRectRotated($g, $this->getShapeBounds(), 0, 0);
        $this->drawText();
    }

    public function getTotalWidth() {
        $this->getChart()->getGraphics3D()->getFont()->assign($this->getFont());
        $result = 0;
        $tmpArray=$this->lines;
        for($t=0; $t < sizeof($tmpArray); ++$t) {
            $result=max($result,MathUtils::round($this->getChart()->getGraphics3D()->textWidth($tmpArray[$t])));
        }
        $result=$result+MathUtils::round($this->getChart()->getGraphics3D()->textWidth("W"));

        if(!$this->getTransparent()) {
            if($this->getPen()->getVisible())
                $result += $this->getPen()->getWidth() * 2;
            if($this->getShadow()->getVisible())
                $result += $this->getShadow()->getWidth();
        }

        return $result;
    }

    private function calcShapeBounds($R) {
        $this->setShapeBounds(Rectangle::fromLTRB($R->getLeft()+2, $R->getTop() +2, $R->getRight()-2,$R->getTop()+4+ $this->getHeight()));
        if(!$this->getTransparent() && $this->getShadow()->getVisible()) {
            if($this->getShadow()->getWidth() > 0) {
                $this->setRight($this->getRight()-$this->getShadow()->getWidth());
            } else {
                $this->shapeBounds->x-=$this->getShadow()->getWidth();
            }

            if($this->getShadow()->getHeight() < 0) {
                $this->shapeBounds->y-=$this->getShadow()->getHeight();
            }
        }
    }
}

?>
