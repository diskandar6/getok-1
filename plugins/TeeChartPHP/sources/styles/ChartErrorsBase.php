<?php

  class ChartErrorsBase extends TeeBase
  {
    private static $serialVersionUID = 1;
    
    private $left;
    private $right;
    private $top;
    private $bottom;
    private $seriesColor;
    private $size = 100;
    private $errorSizeUnits = 0; // ErrorWidthUnit::$PERCENT;
    public $ISeries;

    public function __construct($AOwner)
    {
        parent::__construct($AOwner->getChart());
    
        $this->ISeries = $AOwner;

        $this->left = new ValueList($this->ISeries, "LeftErrors");
        $this->right = new ValueList($this->ISeries, "RightErrors");
        $this->top = new ValueList($this->ISeries, "TopErrors");
        $this->bottom = new ValueList($this->ISeries, "BottomErrors");
    }

    public function getLeft() 
    { 
        return  $this->left; 
    }

    public function getRight() 
    {         
        return $this->right; 
    }

    public function getTop() 
    { 
        return $this->top; 
    }

    public function getBottom() 
    { 
        return $this->bottom; 
    }

    public function getErrorSizeUnits() { return $this->errorSizeUnits; }
    
    public function setErrorSizeUnits($value)
    {
        if ($this->errorSizeUnits != $value)
        {
          $this->errorSizeUnits = $value;
          $this->invalidate();
        }
     }

    public function getSize() { return $this->size; }
      
    public function setSize($value) { $this->size = $this->setIntegerProperty($this->size, $value); }

    public function getSeriesColor() { return $this->seriesColor; }
     
    public function setSeriesColor($value) { $value = $this->setBooleanProperty($this->seriesColor, $value); }

    public function preparePen($ValueIndex, $ErrorPen)
    {
      $g = $this->ISeries->getChart()->getGraphics3D();

      if ($this->seriesColor) $ErrorPen->setColor($this->ISeries->getValueColor($ValueIndex));
      $g->setPen($ErrorPen);
    }

    private function drawHoriz($XPos, $X, $Y, $HalfSize, $AZ)
    {
      $g = $this->ISeries->getChart()->getGraphics3D();

      if ($this->ISeries->getChart()->getAspect()->getView3D())
      {
        $g->horizontalLine($X, $XPos, $Y, $AZ);
        $g->verticalLine($XPos, $Y - $HalfSize, $Y + $HalfSize, $AZ);
      }
      else
      {
        $g->horizontalLine($X, $XPos, $Y);
        $g->verticalLine($XPos, $Y - $HalfSize, $Y + $HalfSize);
      }
    }

    private function drawVert($YPos, $X, $Y, $HalfSize, $AZ)
    {
      $g = $this->ISeries->getChart()->getGraphics3D();

      if ($this->ISeries->getChart()->getAspect()->getView3D())
      {
        $g->verticalLine($X, $Y, $YPos, $AZ);
        $g->horizontalLine($X - $HalfSize, $X + $HalfSize, $YPos, $AZ);
      }
      else
      {
        $g->verticalLine($X, $Y, $YPos);
        $g->horizontalLine($X - $HalfSize, $X + $HalfSize, $YPos);
      }
    }

    public function drawError($X, $Y, $ALength, $HalfSize, $AZ, $IsHoriz)
    {
      if ($IsHoriz)
        $this->drawHoriz($X - $ALength, $X, $Y, $HalfSize, $AZ);
      else
        $this->drawVert($Y - $ALength, $X, $Y, $HalfSize, $AZ);
    }

    public function drawZError($X, $Y, $Z, $ALength, $HalfSize)
    {
      $g = $this->ISeries->getChart()->getGraphics3D();
      $g->moveTo($X, $Y, $Z);
      $g->lineTo($X, $Y, $Z - $ALength);
      $g->moveTo($X, $Y - $HalfSize, $Z - $ALength);
      $g->lineTo($X, $Y + $HalfSize, $Z - $ALength);
    }
  }  
?>