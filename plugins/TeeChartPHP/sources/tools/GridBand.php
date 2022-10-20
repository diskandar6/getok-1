<?php
 /**
 * Description:  This file contains the following class:<br>
 * GridBand class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * GridBand class
 *
 * Description: Grid Band tool, use it to display a coloured rectangles
 * (bands) at the grid lines of the specified axis and position
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

class GridBand extends ToolAxis
{

   private $band1;
   private $band2;
   private $tmpBand;

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

   public function __construct($c = null)
   {
      parent::__construct($c);

      $tmpColor = new Color(0, 0, 0);
      $this->getBand1()->setColor($tmpColor);
      $this->getBand2()->setColor($tmpColor);
      unset($tmpColor);
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->band1);
        unset($this->band2);
        unset($this->tmpBand);
    }       
  
   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("GridBandTool");
   }

   /**
   * Gets detailed descriptive text.
   *
   * @return String
   */
   public function getSummary()
   {
      return Language::getString("GridBandSummary");
   }

   /**
   * The Brush characteristics of the first GridBand tool Band.
   *
   * @return ChartBrush
   */
   public function getBand1()
   {
      if($this->band1 == null)
      {
         $this->band1 = new ChartBrush($this->chart);
      }
      if($this->band1->getSolid())
      {
         $this->band1->setStyle(HatchStyle::$BACKWARDDIAGONAL);//to avoid Form serialisation issues
      }
      if($this->chart != null)
      {
         $this->chart->invalidate();//CDI because firing BeforeDrawSeriesEventArgs?
      }
      return $this->band1;
   }

   /**
   * The Brush characteristics of the second GridBand tool Band.
   *
   * @return ChartBrush
   */
   public function getBand2()
   {
      if($this->band2 == null)
      {
         $this->band2 = new ChartBrush($this->chart);
      }
      if($this->band2->getSolid())
      {
         $this->band2->setStyle(HatchStyle::$BACKWARDDIAGONAL);//to avoid Form serialisation issues
      }
      if($this->chart != null)
      {
         $this->chart->invalidate();//CDI because firing BeforeDrawSeriesEventArgs?
      }
      return $this->band2;
   }

   private function drawBand($tmpPos1, $tmpPos2)
   {
      $chartRect = $this->chart->getChartRect();

      $g = $this->chart->getGraphics3D();
      $g->setBrush($this->tmpBand);
      $g->getPen()->setVisible(false);

      $tmpR = null;

      if($this->iAxis->getHorizontal())
      {           
         $tmpR = Rectangle::fromLTRB($tmpPos1, $chartRect->getTop()+1, $tmpPos2,
         $chartRect->getBottom()-2);
      }
      else
      {
         $tmpR = Rectangle::fromLTRB($chartRect->getLeft() + 2, $tmpPos1,
         $chartRect->getRight(),
         $tmpPos2-2);
      }

      if($this->chart->getAspect()->getView3D())
      {
         $this->chart->getGraphics3D()->rectangleWithZ($tmpR, $this->chart->getAspect()->getWidth3D());
      }
      else
      {
         $tmpR->grow(1, 0);
         $this->chart->getGraphics3D()->rectangle($tmpR);
      }
   }

   public function chartEvent($e)
   {
      parent::chartEvent($e);
      if(/* TODO ($e->getID()==$tmpChartDrawEvent->PAINTING) &&*/
      ($e->getDrawPart() == ChartDrawEvent::$SERIES))
      {
         if($this->chart != null && $this->getAxis() != null)
         {
            $this->drawGrids();
         }
      }
   }

   private function drawGrids()
   {
      if(!$this->getActive())
      {
         return;
      }
            
      $tmp = $this->iAxis->axisDraw->getNumTicks();
      $t=1;

      if($tmp > 0)
      {
         $this->tmpBand = $this->getBand1();

         if($this->iAxis->getHorizontal())
         {
             if ($this->iAxis->getGridCentered())
             {                 
                $tmpValue = round(($this->iAxis->axisDraw->ticks[$t-1] - $this->iAxis->axisDraw->ticks[$t])/2);
                if($this->iAxis->axisDraw->ticks[t]+$tmpValue < $this->iAxis->iEndPos)
                {
                   $this->drawBand($this->iAxis->iEndPos + 1, $this->iAxis->axisDraw->ticks[0]+$tmpValue);
                   $this->tmpBand = $this->getBand2();
                }
             }
             else             
                if($this->iAxis->axisDraw->ticks[0] < $this->iAxis->iEndPos)
                {
                  $this->drawBand($this->iAxis->iEndPos - 1, $this->iAxis->axisDraw->ticks[0]);
                  $this->tmpBand = $this->getBand2();
                }
         }
         else
         {
             if ($this->iAxis->getGridCentered())             
             {                 
                $tmpValue = round(($this->iAxis->axisDraw->ticks[$t-1] - $this->iAxis->axisDraw->ticks[$t])/2);                 
                if ($this->iAxis->iStartPos < $this->iAxis->axisDraw->ticks[0] - $tmpValue)
                   $this->drawBand($this->iAxis->iStartPos,$this->iAxis->axisDraw->ticks[$tmp-1]-$tmpValue);              
                $this->tmpBand = $this->getBand2();
             }
             else
                if($this->iAxis->axisDraw->ticks[0] > $this->iAxis->iStartPos)
                {
                   $this->drawBand($this->iAxis->iStartPos + 1, $this->iAxis->axisDraw->ticks[0]);
                   $this->tmpBand = $this->getBand2();
                }              
         }

         if ($this->iAxis->getGridCentered())
         {
            for ( $t = 0; $t < $tmp; $t++) {
               if ($t > 0) {
                 $tmpValue = round(($this->iAxis->axisDraw->ticks[$t] - $this->iAxis->axisDraw->ticks[$t-1])/2);
                 $this->drawBand($this->iAxis->axisDraw->ticks[$t - 1]-$tmpValue,
                         $this->iAxis->axisDraw->ticks[$t]-$tmpValue);

                 if($this->tmpBand === $this->getBand1())
                     $this->tmpBand = $this->getBand2();
                 else
                     $this->tmpBand = $this->getBand1();                            
               }
            }         
         }
         else                
         for($t = 1; $t < $tmp; ++$t)
         {
            $this->drawBand($this->iAxis->axisDraw->ticks[$t - 1],
                  $this->iAxis->axisDraw->ticks[$t]);
                            
            if($this->tmpBand === $this->getBand1())
               $this->tmpBand = $this->getBand2();
            else
               $this->tmpBand = $this->getBand1();
         }
         
         if($this->iAxis->getHorizontal())
         {
             if ($this->iAxis->getGridCentered())             
             {
              $tmpValue = round(($this->iAxis->axisDraw->ticks[$t-2] - $this->iAxis->axisDraw->ticks[$t-1])/2);                
              if($this->iAxis->axisDraw->ticks[$tmp]-$tmpValue < $this->iAxis->iStartPos)
              {
                    $this->drawBand($this->iAxis->axisDraw->ticks[$t-1]-$tmpValue, 
                    $this->iAxis->axisDraw->ticks[$t-1]+$tmpValue);
              }            

              if($this->tmpBand === $this->getBand1())
                 $this->tmpBand = $this->getBand2();
              else
                 $this->tmpBand = $this->getBand1();

                 
              $tmpValue = round(($this->iAxis->axisDraw->ticks[$t-2] - $this->iAxis->axisDraw->ticks[$t-1])/2);                
              if($this->iAxis->axisDraw->ticks[$tmp - 1]+$tmpValue > $this->iAxis->iStartPos)
              {
                 $this->drawBand($this->iAxis->axisDraw->ticks[$tmp - 1]-$tmpValue, $this->iAxis->iStartPos);                        
              }            
            }
            else                         
              if($this->iAxis->axisDraw->ticks[$tmp - 1] > $this->iAxis->iStartPos)
              {
                 $this->drawBand($this->iAxis->axisDraw->ticks[$tmp - 1], $this->iAxis->iStartPos);
              }
         }
         else
         {
            if ($this->iAxis->getGridCentered())             
            {
              $tmpValue = round(($this->iAxis->axisDraw->ticks[$t-2] - $this->iAxis->axisDraw->ticks[$t-1])/2);                
              if($this->iAxis->axisDraw->ticks[$tmp - 2]+$tmpValue < $this->iAxis->iEndPos)
              {
                    $this->drawBand($this->iAxis->axisDraw->ticks[$tmp - 2]-$tmpValue, 
                    $this->iAxis->iEndPos);
              }            

              if($this->tmpBand === $this->getBand1())
                 $this->tmpBand = $this->getBand2();
              else
                 $this->tmpBand = $this->getBand1();
              
              if ($this->iAxis->iEndPos > $this->iAxis->axisDraw->ticks[$tmp - 1] - $tmpValue)
                 $this->drawBand($this->iAxis->axisDraw->ticks[$tmp-1]-$tmpValue, $this->iAxis->iEndPos);              
            }
            else            
              if($this->iAxis->axisDraw->ticks[$tmp - 1] < $this->iAxis->iEndPos)
              {
               $this->drawBand($this->iAxis->axisDraw->ticks[$tmp - 1], $this->iAxis->iEndPos);
              }
         }
      }
   } 
}
?>