<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
/**
 * Title class
 *
 * Description: Underlying Title characteristics
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Title extends TextShapePosition {

    private static $TITLEFOOTDISTANCE = 5;
    private $adjustFrame = true;
    private $alignment;
    private $fontH;
    private $tmpXPosTitle;
    private $tmpFrameWidth;
    private $tmpMargin;

    protected $onTop = true;

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

    public function __construct($c) {
        $this->alignment=Array(StringAlignment::$CENTER);
        parent::__construct($c);
                      
        $this->getBrush()->setDefaultColor(new Color(220,220,220));
        $this->drawText = false;
        $this->bTransparent = true;
    }

    public function __destruct()    
    {        
        parent::__destruct();

        unset($this->adjustFrame);
        unset($this->alignment);
        unset($this->fontH);
        unset($this->tmpXPosTitle);
        unset($this->tmpFrameWidth);
        unset($this->tmpMargin);
        unset($this->onTop);
    }  
        
    protected function readResolve() {
        $this->onTop=true;
        return $this;
    }

    /**
     * Resizes Header and Footer frames to full Chart dimensions when true.<br>
     * When false it resizes to the Title text width. It only has effect when
     * Chart.Header or Chart.Footer.Visible is true.<br>
     * Default value: true
     *
     * @return boolean
     */
    public function getAdjustFrame() {
        return $this->adjustFrame;
    }

    /**
     * Resizes Header and Footer frames to full Chart dimensions when true.<br>
     * When false it resizes to the Title text width. It only has effect when
     * Chart.Header or Chart.Footer.Visible is true.<br>
     * Default value: true
     *
     * @param value boolean
     */
    public function setAdjustFrame($value) {
        $this->adjustFrame = setBooleanProperty($this->adjustFrame, $value);
    }

    /**
     * Determines how tChart Header and Footer text will be aligned within the
     * Chart rectangle. <br>
     * The Header or Footer can optionally be surrounded by a Frame. <br>
     * Default value: Center
     *
     * @return StringAlignment
     */
    public function getAlignment() {
        return $this->alignment;
    }

    /**
     * Sets how tChart Header and Footer text will be aligned within the
     * Chart rectangle. <br>
     * The Header or Footer can optionally be surrounded by a Frame. <br>
     * Default value: Center
     *
     * @param value StringAlignment
     */
    public function setAlignment($value) {
        /*
          if ($this->alignment != $value) {
            $this->alignment = $value;
            $this->invalidate();
        }
        */
        
        if (is_array($value)){
          $this->alignment=$value;
        }
        else
        {
          $this->alignment=Array($value);
        }
        $this->invalidate();
    }

    /* draw a title text line */
    private function drawTitleLine($aIndex, $gd) {
        $xst = $this->getLines();
        $st=$xst[$aIndex];

        if ($st != null) {
            $aPos = ($aIndex+1) * $this->fontH + $this->tmpFrameWidth / 2;

            if ($this->onTop) {
                $aPos += $this->getShapeBounds()->getTop();
            } else {
                $aPos = $this->getShapeBounds()->getBottom() - ($this->fontH + $aPos);
            }

            if (in_array(StringAlignment::$FAR,$this->alignment)) {
                $this->tmpXPosTitle = $this->shapeBounds->getRight() -
                               MathUtils::round($gd->textWidth($st)) -
                               ($this->tmpMargin / 2);
            } else
              if (in_array(StringAlignment::$CENTER,$this->alignment)) {
                $this->tmpXPosTitle = round((($this->shapeBounds->x
                               +   $this->shapeBounds->getRight()) / 2) -
                               ($gd->textWidth($st) /2));
            }

            $oldAlign=$gd->getTextAlign();
            $gd->setTextAlign($this->getAlignment());

            $gd->textOut($this->tmpXPosTitle, $aPos, 0, $st);
            $gd->setTextAlign($oldAlign);
        }
    }

    /**
     * Returns if mouse cursor is inside TChartTitle bound rectangle.<br><br>
     * The Title.Visible property must be true. <br>
     * The Title rectangle size depends on Title.Pen.Visible and
     * Title.AdjustFrame.
     *
     * @param p Point
     * @return boolean
     */
    public function clicked($p) {
        return $this->visible && $this->getShapeBounds()->contains($p->x, $p->y);
    }

    /**
     * Returns if mouse cursor is inside TChartTitle bound rectangle.<br><br>
     * The Title.Visible property must be true. <br>
     * The Title rectangle size depends on Title.Pen.Visible and
     * Title.AdjustFrame.
     *
     * @param x int
     * @param y int
     * @return boolean
     */
    public function _clicked($x, $y) {
        return $this->visible && $this->getShapeBounds()->contains($x, $y);
    }

    function doDraw($gd, $rect, $customOnly) {
       if ($this->bCustomPosition == $customOnly) {
            return $this->draw($gd, $rect);
        } else {
            return $rect;
        }
    }

    protected function draw($gd, $rect) {

        TChart::$controlName .= 'Title_';
        $linesCount = $this->getLinesLength();

        if ($this->visible && ($linesCount > 0)) {
            // calculate title shape margin
            $tmpFrameVisible = $this->getPen()->getVisible();

            if ($tmpFrameVisible) {
                $this->tmpFrameWidth = $this->getPen()->getWidth();
            } else {
                $this->tmpFrameWidth = 0;
            }

            if ($this->getBevel()->getInner() != BevelStyle::$NONE) {
                $this->tmpFrameWidth += $this->getBevel()->getWidth();
            }

            // apply title margins
            if (!$this->bCustomPosition) {
                $this->setShapeBounds($rect);
                if ($this->onTop) {
                    $this->shapeBounds->y += $this->tmpFrameWidth;
                }
            }

            // prepare title font
            $gd->setFont($this->getFont());
            $gd->setTextAlign(StringAlignment::$NEAR);

            $oldAlign=$gd->getTextAlign();

            $this->fontH = $gd->getFontHeight();

            // autosize title height on number of text lines
            if ($this->onTop || $this->bCustomPosition) {
                $this->shapeBounds->height = $linesCount * $this->fontH + $this->tmpFrameWidth;
            } else {
                $old = $this->shapeBounds->getBottom();
                $this->shapeBounds->height= $linesCount * $this->fontH + $this->tmpFrameWidth;
                $this->shapeBounds->y = $old - $this->shapeBounds->height;
            }

            $this->tmpMargin = MathUtils::round($gd->textWidth("W"));

            $tmp = 0;

            // resize Title to maximum Chart width
            if ($this->adjustFrame) {

                $tmpMaxWidth = 0;

                for ($t = 0; $t < $linesCount; $t++) {
                    $tmpx = array();
                    $tmpx = $this->getLines();
                    $tmp = MathUtils::round($gd->textWidth($tmpx[$t]));

                    if ($tmp > $tmpMaxWidth) {
                        $tmpMaxWidth = $tmp;
                    }
                }

                $tmpMaxWidth += $this->tmpMargin + $this->tmpFrameWidth;

                if (in_array(StringAlignment::$NEAR,$this->alignment)) {
                    $this->shapeBounds->width = $tmpMaxWidth;
                } else
                if (in_array(StringAlignment::$FAR,$this->alignment)) {
                    $this->shapeBounds->x = $this->shapeBounds->getRight() - $tmpMaxWidth;
                } else {
                    if ($this->bCustomPosition) {
                        $this->shapeBounds->width = $tmpMaxWidth;
                    }
                    $tmp = ($this->shapeBounds->x + $this->shapeBounds->getRight()) / 2;
                    $this->shapeBounds->x = $tmp - ($tmpMaxWidth / 2);
                    $this->shapeBounds->width = $tmpMaxWidth;
                }
            }

            // draw title shape
            parent::paint($gd, $this->getShapeBounds());

            if (in_array(StringAlignment::$NEAR,$this->alignment)) {
                $this->tmpXPosTitle = $this->getShapeBounds()->getLeft() + ($this->tmpMargin / 2);
            }

            // draw all Title text lines
            for ($t = 0; $t < $linesCount; $t++) {
                $this->drawTitleLine($t, $gd);
            }

            $gd->setTextAlign($oldAlign);

            // calculate Chart positions after drawing the titles / footers
            if (!$this->bCustomPosition) {
                $tmp = self::$TITLEFOOTDISTANCE + $this->tmpFrameWidth;

                if ((!$this->getTransparent()) && $this->getShadow()->getVisible()) {
                    $tmp += $this->getShadow()->getHeight();
                }

                if ($this->onTop) {
                    $tmpY = $rect->y;
                    $rect->y = $this->shapeBounds->getBottom() + $tmp;
                    $rect->height -= ($rect->y - $tmpY);
                } else {
                    $rect->height -= ($tmp + $linesCount * $this->fontH);
                }
            }
        }

        return $this->chart->recalcWidthHeight($rect); // DB
    }
}

?>