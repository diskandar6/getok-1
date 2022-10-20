<?php
/**
 * Description: Animation
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage animations
 * @link http://www.steema.com
 */
/**
 * Animation class
 *
 * Description: Animation
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage animations
 * @link http://www.steema.com
 */
class Animation extends TeeBase
{
    public $ClickTolerance = 3;
    public $Part;  /*ChartClickedPart*/    
    private $active = true;
    

    public function __construct($c=null)
    {
      parent::__construct($c);
      
      if ($this->chart != null)
        $this->getChart()->getAnimations()->add($this);
    }

    public function __destruct()    
    {        
        parent::__destruct();        
        unset($this->ClickTolerance);
        unset($this->Part);
        unset($this->active);
    }
    
    protected function Dispose($disposing)
    {
      if ($disposing)
      {
        $this->Chart = null;
      }
      parent::Dispose($disposing);
    }

    static function GetFirstLastSeries($s, $AMin, $AMax)
    {
      $AMin = $s->firstVisible;
      if ($AMin < 0) $AMin = 0;

      $AMax = $s->lastVisible;
      if ($AMax < 0) $AMax = $s->Count - 1;
      else
        if ($AMax >= $s->Count) $AMax = $s->Count - 1; // 5.03

      return ($s->Count > 0) && ($AMin <= $s->Count) && ($AMax <= $s->Count);
    }

    public function ToString()
    {
       return $this->Description;
    }

    public function getActive()
    {
       return $this->active;
    }
    
    public function setActive($value)
    {
       $this->active($value);
    }

    public function SetChart($value)
    {
      if ($this->chart != $value)
      {
        if ($this->chart != null) $this->chart->Animations->Remove($this);    //CDI same as for Series.SetChart()
        parent::setChart($value);
        if ($this->chart != null && !$this->InternalUse) $this->chart->Animations->Add($this);
        if ($this->chart != null) $this->chart->Invalidate();
      }
    }

    protected function KeyEvent($e) { }
/*    protected function ChartEvent($e) 
        {
            if (($e === AfterDrawEventArgs) && $this->drawing)
            {
                switch (Target)
                {
                    case ChartClickedPartStyle.None:
                        break;
                    case ChartClickedPartStyle.Legend:
                        break;
                    case ChartClickedPartStyle.Axis:
                        break;
                    case ChartClickedPartStyle.Series:
                        break;
                    case ChartClickedPartStyle.Header:
                        break;
                    case ChartClickedPartStyle.Foot:
                        break;
                    case ChartClickedPartStyle.ChartRect:
                        break;
                    case ChartClickedPartStyle.SeriesMarks:
                        break;
                    case ChartClickedPartStyle.SeriesPointer:
                        DoSeriesPointer();
                        break;
                    case ChartClickedPartStyle.SubHeader:
                        break;
                    case ChartClickedPartStyle.SubFoot:
                        break;
                    case ChartClickedPartStyle.AxisTitle:
                        break;
                    default:
                        break;
                }
            }
        }
        
    protected internal virtual void SeriesEvent(EventArgs e) { } // MS: v3
                              */
        protected $P;
        protected $drawing = false;
                                /*
        protected virtual internal void MouseEvent(MouseEventKinds kind, MouseEventArgs e, ref Cursor c)
    {
#if WPF || SILVERLIGHT
      P = e.GetPosition(Chart.Parent.GetControl());
#else
      P = new Point(e.X, e.Y);
#endif

      Chart.CalcClickedPart(P, out Part);

      switch (kind)
      {
        case MouseEventKinds.Up:
          DoMouseUp(e, ref c);
          break;

        case MouseEventKinds.Move:
          DoMouseMove(e, ref c);
          break;

        case MouseEventKinds.Down:
          DoMouseDown(e, ref c);
          break;
      }
    }
        
    protected DoMouseDown($e, $c) 
    {
      if (Trigger == AnimationTrigger.MouseClick && Part.Part == Target)
      {
        drawing = true;
      }
      else
      {
        drawing = false;
      }
            if (Trigger == AnimationTrigger.MouseClick)
            {
                Invalidate();
            }
    }

    protected virtual void DoMouseMove(MouseEventArgs e, ref Cursor c) 
        {
            if (Trigger == AnimationTrigger.MouseOver && Part.Part == Target)
            {
                drawing = true;
            }
            else
            {
                drawing = false;
            }

            if (Trigger == AnimationTrigger.MouseOver)
            {
                Invalidate();
            }
        }

    protected virtual void DoMouseUp(MouseEventArgs e, ref Cursor c) 
    {

    }

        protected virtual void DoSeriesPointer() { }


    protected internal virtual void OnDisposing() { }
*/
    private $speed = 10;

    /// <summary>
    /// Gets and sets the speed of the animation effect, in milliseconds.
    /// </summary>
    public function getSpeed()
    {
        return $this->speed;
    }
    
    public function setSpeed($value)
    {
        $this->speed = $value;
    }
                    
    //private $target = ChartClickedPartStyle.None;


    public function /*ChartClickedPartStyle*/ getTarget()
    {
        return $this->target;
    }
    
    public function setTarget($value) 
    {
        $this->target = $value;
    }

    private $trigger = 1; // AnimationTrigger::$MouseOver;


    public function getTrigger()
    {
        return $this->trigger;
    }

    public function setTrigger($value)
    {
        $this->trigger = $value;
    }

   // public $Description { get { return ""; } }
    //public virtual string Summary { get { return ""; } }

    /// <summary>
    /// Creates a new Animation object and sets the Name and Chart properties.
    /// </summary>
    public static function CreateNewAnimation($chart, $type)
    {
      $result = Self::NewFromType($type);
      //result.Chart = chart;
      //return result;
    }

    protected function Assign($t)
    {
      $t->Active = $this->Active;
    }
  }
/**
 * AnimationTrigger class
 *
 * Description: AnimationTrigger
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage animations
 * @link http://www.steema.com
 */
class AnimationTrigger
{
  public static $MouseClick=0;
  public static $MouseOver=1;
}  
?>