<?php

class ErrorsFormat
{
    private $left;
    private $right;
    private $top;
    private $bottom;    
    public $IntChart;
    

    public function __construct($c)
    {
      $this->IntChart = $c;
    }

    public function getLeft()
    {
       if ($this->left == null) $this->left = new ChartPen($this->IntChart, Color::BLACK(), true);
       return $this->left;
    }
      
    public function setLeft($value)
    {
       $this->left = $value;
    }

    public function getRight()
    {
        if ($this->right == null) $this->right = new ChartPen($this->IntChart, Color::BLACK(), true);
        return $this->right;
    }
      
    public function setRight($value)
    {
        $this->right = $value;
    }

    public function getTop()
    {
      if ($this->top == null) $this->top = new ChartPen($this->IntChart, Color::BLACK(), true);
      return $this->top;
    }
     
    public function setTop($value)
    {
       $this->top = $value;
    }

    public function getBottom()
    {
        if ($this->bottom == null) $this->bottom = new ChartPen($this->IntChart, Color::BLACK(), true);
        return $this->bottom;
    }
    
    public function setBottom($value)
    {
        $this->bottom = $value;
    }
  }
?>