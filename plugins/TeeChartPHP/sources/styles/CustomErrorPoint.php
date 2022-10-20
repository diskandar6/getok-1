<?php

class CustomErrorPoint extends Points {
    
    private static $serialVersionUID = 1;
    private $errors;
        
    // internal
    private $iErrorPoint;
    private $iPoint;

    public function __construct($c=null) {
        parent::__construct($c);
    }

    public function getErrors() {
        if ($this->errors == null)
            $this->errors = new ChartErrors($this);
        return $this->errors;
    }

    public function setChart($c) {
        $this->getErrors()->setChart($c);
        $this->getErrors()->getFormat()->IntChart = $c;

        parent::setChart($c);
    }

    public function calcHorizMargins($margins) {
        $this->LeftMargin += 2;
        $this->RightMargin += 2;
    }

    public function calcVerticalMargins($margins) {
        $this->TopMargin += 2;
        $this->BottomMargin += 2;
    }

    protected function addSampleValues($numValues) {
        $r = $this->randomBounds($numValues);
        for ($t = 1; $t <= $numValues; $t++) {
            $this->addXYLRTB($r->tmpX, MathUtils::round($r->DifY * $r->Random()), $numValues / (20 + $r->Random()), 
                $numValues / (20 + $r->Random()), $r->DifY / (20 + $r->Random()),  $r->DifY / (20 + $r->Random()));
            $r->tmpX += $r->StepX;
        }
    }

    public function addXYLRTBTextColor($XVal, $YVal, $LErr, $RErr, $TErr, $BErr, $text, $color) {
        $this->getErrors()->getLeft()->tempValue = $LErr;
        $this->getErrors()->getRight()->tempValue = $RErr;
        $this->getErrors()->getTop()->tempValue = $TErr;
        $this->getErrors()->getBottom()->tempValue = $BErr;

        return $this->addXYTextColor($XVal, $YVal, $text, $color);
    }

    public function addXYLRTBText($x, $y, $LErr, $RErr, $TErr, $BErr, $text) {
        return $this->addXYLRTBTextColor($x, $y, $LErr, $RErr, $TErr, $BErr, $text, Color::EMPTYCOLOR());
    }

    public function addXYLRTB($x, $y, $LErr, $RErr, $TErr, $BErr) {
        return $this->addXYLRTBTextColor($x, $y, $LErr, $RErr, $TErr, $BErr, "", Color::EMPTYCOLOR());
    }

    public function addXYLRTBColor($x, $y, $LErr, $RErr, $TErr, $BErr, $color) {
        return $this->addXYLRTBTextColor($x, $y, $LErr, $RErr, $TErr, $BErr, "", $color);
    }

    public function addYLRTB($y, $LErr, $RErr, $TErr, $BErr) {
        return $this->addXYLRTBTextColor($this->getCount(), $y, $LErr, $RErr, $TErr, $BErr, "", Color::EMPTYCOLOR());
    }

    private function drawLeftError() {
        $tmpX = $this->getHorizAxis()->calcSizeValue($this->errors->getLeft()->getValue($this->iErrorPoint->ValueIndex));
        if (($this->errors->getFormat()->getLeft()->getVisible()) && ($this->getPointer()->getHorizSize() < $tmpX)) {
            $this->errors->preparePen($this->iErrorPoint->ValueIndex, $this->errors->getFormat()->getLeft());
            $this->errors->drawError($this->iErrorPoint->XPos - MathUtils::round($this->getPointer()->getHorizSize()), $this->iErrorPoint->YPos,
                    $tmpX - MathUtils::round($this->getPointer()->getHorizSize()), $this->iErrorPoint->ErrorHorizSize, MathUtils::round($this->getMiddleZ()), true);
        }
    }

    private function drawRightError() {
        $tmpX = $this->getHorizAxis()->calcSizeValue($this->errors->getRight()->getValue($this->iErrorPoint->ValueIndex));
        if (($this->errors->getFormat()->getRight()->getVisible()) && ($this->getPointer()->getHorizSize() < $tmpX)) {
            $this->errors->preparePen($this->iErrorPoint->ValueIndex, $this->errors->getFormat()->getRight());
            $this->errors->drawError($this->iErrorPoint->XPos + MathUtils::round($this->getPointer()->getHorizSize()), $this->iErrorPoint->YPos,
                    -($tmpX - MathUtils::round($this->getPointer()->getHorizSize())), $this->iErrorPoint->ErrorHorizSize, MathUtils::round($this->getMiddleZ()), true);
        }
    }

    private function drawTopError() {
        $tmpY = $this->getVertAxis()->calcSizeValue($this->errors->getTop()->getValue($this->iErrorPoint->ValueIndex));
        if (($this->errors->getFormat()->getTop()->getVisible()) && ($this->getPointer()->getVertSize() < $tmpY)) {
            $this->errors->preparePen($this->iErrorPoint->ValueIndex, $this->errors->getFormat()->getTop());
            $this->errors->drawError($this->iErrorPoint->XPos, $this->iErrorPoint->YPos - MathUtils::round($this->getPointer()->getVertSize()),
                    $tmpY - MathUtils::round($this->getPointer()->getVertSize()), $this->iErrorPoint->ErrorVertSize, MathUtils::round($this->getMiddleZ()), false);
        }
    }

    private function drawBottomError() {
        $tmpY = $this->getVertAxis()->calcSizeValue($this->errors->getBottom()->getValue($this->iErrorPoint->ValueIndex));
        if (($this->errors->getFormat()->getBottom()->getVisible()) && ($this->getPointer()->getVertSize() < $tmpY)) {
            $this->errors->preparePen($this->iErrorPoint->ValueIndex, $this->errors->getFormat()->getBottom());
            $this->errors->drawError($this->iErrorPoint->XPos, $this->iErrorPoint->YPos + MathUtils::round($this->getPointer()->getVertSize()),
                    -($tmpY - MathUtils::round(getPointer()->getVertSize())), $this->iErrorPoint->ErrorVertSize, MathUtils::round($this->getMiddleZ()), false);
        }
    }

    private function drawWithOrder($LeftFirst, $TopFirst) {
        if ($LeftFirst) {
            $this->drawLeftError();
            if ($TopFirst) {
                $this->drawTopError();
                parent::drawValue($this->iErrorPoint->ValueIndex);
                $this->drawBottomError();
            } else {
                $this->drawBottomError();
                parent::drawValue($this->iErrorPoint->ValueIndex);
                $this->drawTopError();
            }
            $this->drawRightError();
        } else {
            $this->drawRightError();
            if ($TopFirst) {
                $this->drawTopError();
                parent::drawValue($this->iErrorPoint->ValueIndex);
                $this->drawBottomError();
            } else {
                $this->drawBottomError();
                parent::drawValue($this->iErrorPoint->ValueIndex);
                $this->drawTopError();
            }
            $this->drawLeftError();
        }
    }

    private function calcErrorSize() {
        if ($this->errors->getSize() == 0) {
            $this->iErrorPoint->ErrorHorizSize = MathUtils::round($this->getPointer()->getHorizSize());
            $this->iErrorPoint->ErrorVertSize = MathUtils::round($this->getPointer()->getVertSize());
        } else if ($this->errors->getErrorSizeUnits() == ErrorWidthUnit::$PERCENT) {
            $this->iErrorPoint->ErrorHorizSize = MathUtils::round(1.0 * $this->errors->getSize() * $this->getPointer()->getHorizSize() * 0.01);
            $this->iErrorPoint->ErrorVertSize = MathUtils::round(1.0 * $this->errors->getSize() * $this->getPointer()->getVertSize() * 0.01);
        } else {
            $this->iErrorPoint->ErrorHorizSize = $this->errors->getSize();
            $this->iErrorPoint->ErrorVertSize = $this->errors->getSize();
        }
    }

    public function drawValue($valueIndex) {
        if ($this->iErrorPoint == null)
            $this->iErrorPoint = new IErrorPoint();
        $this->iErrorPoint->XPos = MathUtils::round($this->calcXPosValue($this->getXValues()->getValue($valueIndex)));
        $this->iErrorPoint->YPos = MathUtils::round($this->calcYPosValue($this->getYValues()->getValue($valueIndex)));
        $this->calcErrorSize();
        $this->iErrorPoint->ValueIndex = $valueIndex;

        if (($this->getChart()->getAspect()->getOrthogonal()) || (!$this->getChart()->getAspect()->getView3D())) {
            $this->drawWithOrder(true, false);
        } else {
            if ($this->getChart()->getAspect()->getRotation() % 360 <= 180) {
                if ($this->getChart()->getAspect()->getElevation() % 360 <= 90)
                    $this->drawWithOrder(false, true);
                else if ($this->getChart()->getAspect()->getElevation() % 360 <= 180)
                    $this->drawWithOrder(true, true);
                else if ($this->getChart()->getAspect()->getElevation() % 360 <= 270)
                    $this->drawWithOrder(true, false);
                else
                    $this->drawWithOrder(false, false);
            } else {
                if ($this->getChart()->getAspect()->getElevation() % 360 <= 90)
                    $this->drawWithOrder(true, true);
                else if ($this->getChart()->getAspect()->getElevation() % 360 <= 180)
                    $this->drawWithOrder(false, true);
                else if ($this->getChart()->getAspect()->getElevation() % 360 <= 270)
                    $this->drawWithOrder(false, false);
                else
                    $this->drawWithOrder(true, false);
            }
        }
    }

    public function getMaxXValue() {
        return $this->calcMinMaxValue(false, true);
    }

    public function getMaxYValue() {
        return $this->calcMinMaxValue(false, false);
    }

    public function getMinXValue() {
        return $this->calcMinMaxValue(true, true);
    }

    public function getMinYValue() {
        return $this->calcMinMaxValue(true, false);
    }

    public function getDescription() {
        return Language::getString("GalleryErrorPoint");
    }

    private function calcMinMaxValue($isMin, $isXVal) {
        $NEGATIVE_INFINITY =intval('-1000000000000');
        
        $tmpfirst = true;
        $result = 0.0;
        $tmpvalue = 0.0;
        for ($t = 0; $t < $this->getCount(); $t++) {
            if (!$this->isNull($t)) {
                if ($isMin) {
                    if ($isXVal) {
                        $tmpvalue = $this->notMandatory->getValue($t) - $this->errors->getLeft()->getValue($t);
                    } else {
                        $tmpvalue = $this->mandatory->getValue($t) - $this->errors->getBottom()->getValue($t);
                    }
                } else {
                    if ($isXVal) {
                        $tmpvalue = $this->notMandatory->getValue($t) + $this->errors->getRight()->getValue($t);
                    } else {
                        $tmpvalue = $this->mandatory->getValue($t) + $this->errors->getTop()->getValue($t);
                    }
                }
                if ($tmpfirst) {
                    $result = $tmpvalue;
                    $tmpfirst = false;
                } else {
                    if ($isMin) {                        
                        if (bccomp($NEGATIVE_INFINITY, $result) == 0) {
                            $result = $tmpvalue;
                        } else {
                            $result = min($result, $tmpvalue);
                        }
                    } else {
                        if (is_infinite($result)) {
                            $result = $tmpvalue;
                        } else {
                            $result = max($result, $tmpvalue);
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function clicked($x, $y) {
        $result = parent::clicked($x, $y);

        if (($result == -1) && ($this->firstVisible > -1) && ($this->lastVisible > -1)) {
            $this->iPoint = new Point($x, $y);            
            $tmpIndex = min($this->lastVisible, $this->getCount() - 1);
            $this->calcErrorSize();

            for ($t = $this->firstVisible; $t <= $tmpIndex; $t++) {
                $this->iErrorPoint->XPos = $this->calcXPosValue($this->getXValues()->getValue($t));
                $this->iErrorPoint->YPos = $this->calcYPosValue($this->getYValues()->getValue($t));
                $this->iErrorPoint->ValueIndex = $t;
                if ($this->clickedError()) {
                    $result = $t;
                    break;
                }
            }
        }
        return $result;
    }

    private function clickedError() {
        return $this->clickedTopError() || $this->clickedBottomError() || $this->clickedLeftError() || $this->clickedRightError();
    }

    private function clickedTopError() {
        $errValue = $this->errors->getTop()->getValue($this->iErrorPoint->ValueIndex);
        return ($errValue > 0)
                && ($this->errors->getFormat()->getTop()->getVisible())
                && ($this->clickedHorizontal($this->iErrorPoint->XPos - $this->iErrorPoint->ErrorHorizSize, $this->iErrorPoint->XPos + $this->iErrorPoint->ErrorHorizSize,
                        $this->calcYPosValue($this->getYValues()->getValue($this->iErrorPoint->ValueIndex) + $errValue), $this->errors->getFormat()->getTop()->getWidth()) || $this->clickedVertical(
                        $this->iErrorPoint->XPos, $this->iErrorPoint->YPos - $this->getPointer()->getVertSize(), $this->calcYPosValue($this->getYValues()->getValue($this->iErrorPoint->ValueIndex)
                                + $errValue), $this->errors->getFormat()->getTop()->getWidth()));
    }

    private function clickedBottomError() {
        $errValue = $this->errors->getBottom()->getValue($this->iErrorPoint->ValueIndex);
        return ($errValue > 0)
                && ($this->errors->getFormat()->getBottom()->getVisible())
                && ($this->clickedHorizontal($this->iErrorPoint->XPos - $this->iErrorPoint->ErrorHorizSize, $this->iErrorPoint->XPos + $this->iErrorPoint->ErrorHorizSize,
                        $this->calcYPosValue($this->getYValues()->getValue($this->iErrorPoint->ValueIndex) - $errValue), $this->errors->getFormat()->getBottom()->getWidth()) || $this->clickedVertical(
                        $this->iErrorPoint->XPos, $this->iErrorPoint->YPos + $this->getPointer()->getVertSize(), $this->calcYPosValue($this->getYValues()->getValue($this->iErrorPoint->ValueIndex)
                                - $errValue), $this->errors->getFormat()->getBottom()->getWidth()));
    }

    private function clickedLeftError() {
        $errValue = $this->errors->getLeft()->getValue($this->iErrorPoint->ValueIndex);
        return ($errValue > 0)
                && ($this->errors->getFormat()->getLeft()->getVisible())
                && ($this->clickedHorizontal($this->iErrorPoint->XPos - $this->getPointer()->getHorizSize(), $this->calcXPosValue($this->getXValues()->getValue($this->iErrorPoint->ValueIndex)
                        - $errValue), $this->iErrorPoint->YPos, $this->errors->getFormat()->getLeft()->getWidth()) || $this->clickedVertical($this->calcXPosValue($this->getXValues()->getValue($this->iErrorPoint->ValueIndex) - $errValue), 
                        $this->iErrorPoint->YPos - $this->iErrorPoint->ErrorVertSize, $this->iErrorPoint->YPos
                        + $this->iErrorPoint->ErrorVertSize, $this->errors->getFormat()->getLeft()->getWidth()));
    }

    private function clickedRightError() {
        $errValue = $this->errors->getRight()->getValue($this->iErrorPoint->ValueIndex);
        return ($errValue > 0)
                && ($this->errors->getFormat()->getRight()->getVisible())
                && ($this->clickedHorizontal($this->iErrorPoint->XPos + $this->getPointer()->getHorizSize(), $this->calcXPosValue($this->getXValues()->getValue($this->iErrorPoint->ValueIndex)
                        + $errValue), $this->iErrorPoint->YPos, 
                        $this->errors->getFormat()->getRight()->getWidth()) || $this->clickedVertical($this->calcXPosValue($this->getXValues()->getValue($this->iErrorPoint->ValueIndex) + $errValue), 
                        $this->iErrorPoint->YPos - $this->iErrorPoint->ErrorVertSize, $this->iErrorPoint->YPos
                        + $this->iErrorPoint->ErrorVertSize, $this->errors->getFormat()->getRight()->getWidth()));
    }

    private function clickedHorizontal($x0, $x1, $y, $t) {
        if ($this->chart != null) {
            $g = $this->chart->getGraphics3D();
            $P0 = $g->calculate3DPosition($x0, $y, $this->getMiddleZ());
            $P1 = $g->calculate3DPosition($x1, $y, $this->getMiddleZ());
            return MathUtils::pointInLineTolerance($this->iPoint, $P0->X, $P0->Y, $P1->X, $P1->Y, $t);
        } else
            return false;
    }

    private function clickedVertical($x, $y0, $y1, $t) {
        if ($this->chart != null) {
            $g = $this->chart->getGraphics3D();
            $P0 = $g->calculate3DPosition($x, $y0, $this->getMiddleZ());
            $P1 = $g->calculate3DPosition($x, $y1, $this->getMiddleZ());
            return MathUtils::pointInLineTolerance($this->iPoint, $P0->X, $P0->Y, $P1->X, $P2->Y, $t);
        } else
            return false;
    }
}  
?>