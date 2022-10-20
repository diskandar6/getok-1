<?php
/**
 * Description: Animations Collection
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage animations
 * @link http://www.steema.com
 */
/**
 * AnimationsCollection class
 *
 * Description: Animations Collection
 *
 * @author
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage animations
 * @link http://www.steema.com
 */
class AnimationsCollection extends ArrayObject
{

    public $chart;

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

   public function __construct($c)
   {
      parent::__construct();      
      $this->chart = $c;
   }
         

   public function __destruct()    
   {        
       unset($this->chart);
   }
         
   public function add($animation)
   {
      $animation->setChart($this->chart);
      return $this->internalAdd($animation);
   }

   public function internalAdd($animation)
   {
      if($this->indexOf($animation) == - 1)
      {
         parent::append($animation);
      }
      return $animation;
   }
            
   public function getAnimation($index)
   {
      return $this->offsetGet($index);
   }

   public function setAnimation($index, $value)
   {
      $this->set($index, $value);
   }
   
   public function indexOf($s)
   {
      for($t = 0; $t < sizeof($this); $t++)
      {
         if($this->getAnimation($t) === $s)
         {
            return $t;
         }
      }

      return - 1;
   }

   public function remove($s)
   {
      $i = $this->indexOf($s);
      if($i != - 1)
      {
         $this->remove($i);
         $this->chart->invalidate();
      }
   }


   /**
   * Sets Chart interface to tools collection
   *
   * @param chart IBaseChart
   */
   public function setChart($chart)
   {
      $this->chart = $chart;

      for($t = 0; $t < sizeof($this); $t++)
      {
         $this->getAnimation($t)->setChart($chart);
      }
   }
   
    /*
    /// <summary>
    /// Internal. Exchange animation order.
    /// </summary>
    internal void MoveUp(Animation t1) //CDI - it's a sealed class .. we can forget about protected
    {
      int i = IndexOf(t1);
      if (i > 0)
      {
        Animation tmpTool = ((Animation)chart.Animations[i]);
        RemoveAt(i);
        this.InnerList.Insert(i - 1, tmpTool);
        chart.Invalidate();
      }
    }

    /// <summary>
    /// Internal. Exchange animation order.
    /// </summary>
    internal void MoveDown(Animation t1)
    {
      int i = IndexOf(t1);
      if ((i >= 0) && (i < chart.Animations.Count - 1))
      {
        Animation tmpTool = ((Animation)chart.Animations[i]);
        RemoveAt(i);
        if (i == chart.Animations.Count - 1)
          InnerList.Add(tmpTool);
        else
          InnerList.Insert(i + 1, tmpTool);
          chart.Invalidate();
      }
    }
  }
              */
  /// <summary>
  /// Internal use. Animation support EventArgs 
  /// </summary>
//  public class BeforeDrawAxesEventArgs : EventArgs { }
  /// <summary>
  /// Internal use. Animation support EventArgs 
  /// </summary>
//  public class BeforeDrawSeriesEventArgs : EventArgs { }
  /// <summary>
  /// Internal use. Animation support EventArgs 
  /// </summary>
//  public class AfterDrawSeriesEventsArgs : EventArgs { }
  /// <summary>
  /// Internal use. Animation support EventArgs 
  /// </summary>
  //public class BeforeDrawEventArgs : EventArgs { }
  /// <summary>
  /// Internal use. Animation support EventArgs 
  /// </summary>
  //public class AfterDrawEventArgs : EventArgs { }

}  
?>