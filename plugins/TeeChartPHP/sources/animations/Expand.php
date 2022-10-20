<?php
/**
 * Description: Expand animation
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage animations
 * @link http://www.steema.com
 */
/**
 * Expand class
 *
 * Description: Expand animation
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage animations
 * @link http://www.steema.com
 */
  class Expand extends Animation
  {
    private $sizeBy=10;
    private $timer;
    private $steps;
    private $x;
    private $y;
    private $clone;

    private $once = false;
    private $oldIndex;
    private $actualInterval;
          
    public function __construct($c=null)
    {
      parent::__construct($c);      
      $this->sizeBy = 10;
      $this->timer = 0; // new System.Threading.Timer(new System.Threading.TimerCallback(timer_Tick), null, System.Threading.Timeout.Infinite, System.Threading.Timeout.Infinite);
      //timer.Change(System.Threading.Timeout.Infinite, System.Threading.Timeout.Infinite);
    }

    public function __destruct()    
    {        
        parent::__destruct();                
        unset($this->sizeBy);
        unset($this->timer);
        unset($this->steps);
        unset($this->x);
        unset($this->y);
        unset($this->clone);

        unset($this->once);
        unset($this->oldIndex);
        unset($this->actualInterval);
    }    

    public function getSizeBy() 
    {
        return $this->sizeBy;
    }

    public function setSizeBy($value)     
    {
        $this->sizeBy = $value;
    }

    /// <summary>
    /// Gets descriptive text.
    /// </summary>
    public function getDescription() 
    { 
        return Texts::ExpandAnimation; 
    }

    /// <summary>
    /// Gets detailed descriptive text.
    /// </summary>
    public function getSummary() 
    { 
        return Texts::ExpandSummary;
    }

    protected function DoSeriesPointer()
    {
      if (!$this->once)
      {
        $interval = MathUtils::round($this->speed / $this->sizeBy);
        $this->actualInterval = $interval == 0 ? $this->speed : $interval;
        $this->timer->Change(0, $this->actualInterval);
      }
      $this->DrawSeriesPointer();
    }

    /*
    protected function DoMouseMove($e, $c)
    {
      base.DoMouseMove(e, ref c);
      if (!drawing)
      {
        oldIndex = -1;
      }
    }

    protected function DoMouseDown(MouseEventArgs e, ref Cursor c)
    {
      base.DoMouseDown(e, ref c);
      if (!drawing)
      {
        oldIndex = -1;
      }
    }
    */

    private function DrawSeriesPointer()
    {

      for ($i = 0; $i < $this->chart->series->getCount(); $i++)
      {
        if ($this->chart->series[$i] === CustomPoint && ($this->chart->series[$i]->pointer->visible))
        {
          $index = $this->chart->series[$i]->clickedPointer($this->P);
          if ($index != -1)
          {
            if ($this->oldIndex == $index)
            {
              $this->once = true;
            }
            else
            {            
              $this->x = $this->y = $this->steps = 0;
              $this->clone = null;
              $this->once = false;
            }
            if ($this->clone == null) $this->clone = $this->chart->series[$i]->Pointer->Clone();
            if ($this->x == 0) $this->x = $this->chart->series[$i]->calcXPos($index);
            if ($this->y == 0) $this->y = $this->chart->series[$i]->calcYPos($index);
            $step = (($this->steps / $this->actualInterval) / 2);
            $horiz = $this->clone->HorizSize + $step;
            $vert = $this->clone->VertSize + $step;
            $this->clone->Draw($this->clone->Chart->Graphics3D, $this->clone->Chart->Aspect->View3D, 
                 $this->x, $this->y, $horiz, $vert, $this->clone->Color, $this->clone->Style);
            $this->oldIndex = $index;
          }
        }
      }
    }

    //private delegate void InvalidateDelegate();

    private function timer_Tick($sender)
    {
        /*
      if ((steps) < (Speed))
      {
        timer.Change(System.Threading.Timeout.Infinite, actualInterval);
        steps += actualInterval;
        if (Chart.Parent != null)
        {
          Control control = Chart.Parent.GetControl();
          control.Invoke(new InvalidateDelegate(Invalidate)); 
        }
        timer.Change(0, actualInterval);
      }
      else
      {
        timer.Change(System.Threading.Timeout.Infinite, actualInterval);
        if (Chart.Parent != null)
        {
          Control control = Chart.Parent.GetControl();
					control.Invoke(new InvalidateDelegate(Invalidate)); 
        }
      }  */
    }
}
?>