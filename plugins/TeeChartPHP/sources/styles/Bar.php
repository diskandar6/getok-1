<?php
 /**
 * Description:  This file contains the following class:<br>
 * Bar class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Bar Class
 *
 * Description: The Bar Series component outputs all points as vertical
 * bars
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
class Bar extends CustomBar
{

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
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("GalleryBar");
   }

   /**
   * Determines the percent of total Bar width used.<br>
   * Setting BarWidthPercent = 100 makes joined Bars.<br>
   * You can control how many Bars appear at the same time by using
   * Page.MaxPointsPerPage.<br>
   * Default value: 70
   *
   * @return int
   */
   public function getBarWidthPercent()
   {
      return $this->barSizePercent;
   }

   /**
   * Sets the percent of total Bar width used.<br>
   * Default value: 70
   *
   * @see #getBarWidthPercent
   * @param value int
   */
   public function setBarWidthPercent($value)
   {
      $this->setBarSizePercent($value);
   }

   protected function internalCalcMarkLength($valueIndex)
   {
      return $this->chart->getGraphics3D()->getFontHeight();
   }

   protected function internalClicked($valueIndex, $point)
   {
      $tmpResult = false;

      $tmpX = $this->calcXPos($valueIndex);

      if(($point->x >= $tmpX) && ($point->x <= ($tmpX + $this->iBarSize)))
      {
         $tmpY = $this->calcYPos($valueIndex);
         $endY = $this->getOriginPos($valueIndex);
         if($endY < $tmpY)
         {
            $tmpSwap = $endY;
            $endY = $tmpY;
            $tmpY = $tmpSwap;
         }

         $tmpStyle = $this->getBarStyle();
         if($tmpStyle == BarStyle::$INVPYRAMID)
         {
            $tmpResult = GraphicsGD::pointInTriangle($point, $tmpX,
            $tmpX + $this->iBarSize, $tmpY, $endY);
         }
         else
            if(($tmpStyle == BarStyle::$PYRAMID)|($tmpStyle == BarStyle::$CONE))
            {
               $tmpResult = GraphicsGD::pointInTriangle($point, $tmpX,
               $tmpX + $this->iBarSize, $endY, $tmpY);
            }
            else
               if($tmpStyle == BarStyle::$ELLIPSE)
               {
                  $tmpResult = GraphicsGD::pointInEllipse($point,
                  new Rectangle($tmpX, $tmpY, $tmpX + $this->iBarSize, $endY));
               }
               else
               {
                  $tmpResult = ($point->y >= $tmpY) && ($point->y <= $endY);
               }
      }
      return $tmpResult;
   }

   public function calcHorizMargins($margins)
   {
      parent::calcHorizMargins($margins);
      $this->internalApplyBarMargin($margins);
   }

   public function calcVerticalMargins($margins)
   {

      parent::calcVerticalMargins($margins);

      $tmp = $this->calcMarkLength(0);

      if($tmp > 0)
      {
         $tmp++;
         if($this->bUseOrigin && (parent::getMinYValue() < $this->dOrigin))
         {
            if($this->getVertAxis()->getInverted())
            {
               $margins->min += $tmp;
            }
            else
            {
               $margins->max += $tmp;
            }
         }

         if((!$this->bUseOrigin) || (parent::getMaxYValue() > $this->dOrigin))
         {
            if($this->getVertAxis()->getInverted())
            {
               $margins->max += $tmp;
            }
            else
            {
               $margins->min += $tmp;
            }
         }
      }
   }

   /**
   * Called internally. Draws the "ValueIndex" point of the Series.
   *
   * @param valueIndex int
   */
   public function drawValue($valueIndex)
   {

      parent::drawValue($valueIndex);
      $this->normalBarColor = $this->getValueColor($valueIndex);

      // if not null...
      $tmpColor = new Color(0, 0, 0, 0, true);
      if($this->normalBarColor != $tmpColor)
      {
         $r = new Rectangle();
         $r->x = $this->calcXPos($valueIndex);

         if(($this->barSizePercent == 100) && ($valueIndex < $this->getCount() - 1))
         {// 5.02
            $r->width = $this->calcXPos($valueIndex + 1) - $r->x;
         }
         else
         {
            $r->width = $this->iBarSize + 1;// 5.02
         }

         $r->y = $this->calcYPos($valueIndex);
         $r->height = $this->getOriginPos($valueIndex) - $r->y;

         if(!$this->getPen()->getVisible())
         {
            if($r->getBottom() > $r->y)
            {
               $r->height++;
            }
            else
            {
               $r->y++;
            }
            $r->width++;
         }

         $this->iBarBounds = $r;

         if($r->getBottom() > $r->y)
         {
            $this->drawBar($valueIndex, $r->y, $r->getBottom());
         }
         else
         {
            $this->drawBar($valueIndex, $r->getBottom(), $r->y);
         }

         unset($r);
      }
      unset($tmpColor);
   }

   /**
   * Internal use
   *
   * @param barIndex int
   * @param startPos int
   * @param endPos int
   */
   public function drawBar($barIndex, $startPos, $endPos)
   {
      $this->setPenBrushBar($this->normalBarColor);

      $tmpMidX = $this->getBarBoundsMidX();
      $tmp = $this->doGetBarStyle($barIndex);

      $g = $this->chart->getGraphics3D();
      $r = $this->iBarBounds;   

      if($this->chart->getAspect()->getView3D())
      {
         if($tmp == BarStyle::$RECTANGLE)
         {
            $g->cube($r->x, $startPos, $r->getRight(), $endPos, $this->getStartZ(),
            $this->getEndZ(),
            $this->bDark3D);
         }
         else
            if($tmp == BarStyle::$PYRAMID)
            {
               $g->pyramid(true, $r->x, $startPos, $r->getRight(), $endPos, $this->getStartZ(),
               $this->getEndZ(),
               $this->bDark3D);
            }
            else
               if($tmp == BarStyle::$INVPYRAMID)
               {
                  $g->pyramid(true, $r->x, $endPos, $r->getRight(), $startPos, $this->getStartZ(),
                  $this->getEndZ(),
                  $this->bDark3D);
               }
               else
                  if($tmp == BarStyle::$CYLINDER)
                  {
                     $g->cylinder(true, $this->iBarBounds, $this->getStartZ(), $this->getEndZ(), $this->bDark3D);
                  }
                  else
                     if($tmp == BarStyle::$ELLIPSE)
                     {  
                        $g->ellipseRectZ($this->iBarBounds, $this->getMiddleZ());
                     }
                     else
                        if($tmp == BarStyle::$ARROW)
                        {
                           $g->arrow(true, new TeePoint($tmpMidX, $endPos),
                           new TeePoint($tmpMidX, $startPos),
                           $r->width, $r->width / 2, $this->getMiddleZ());
                        }
                        else
                          if($tmp == BarStyle::$INVARROW)
                          {
                             $g->arrow(true, new TeePoint($tmpMidX, $startPos),
                             new TeePoint($tmpMidX, $endPos),
                             $r->width, $r->width / 2,$this->getMiddleZ());                            
                          }
                          /* TODO else
                           if($tmp == BarStyle::$RECTGRADIENT)
                           {
                              $g->cube($r->x, $startPos, $r->getRight(), $endPos, $this->getStartZ(),
                              $this->getEndZ(),
                              $this->bDark3D);
                              if($g->getSupportsFullRotation() ||
                              $this->chart->getAspect()->getOrthogonal())
                              {
                                 $this->doGradient3D($barIndex,
                                 $g->calc3DPoint($r->x, $startPos, $this->getStartZ()),
                                 $g->calc3DPoint($r->getRight(), $endPos, $this->getStartZ()));
                              }
                           }
                           */
                           else
                              if($tmp == BarStyle::$CONE)
                              {
                                 $g->cone(true, $this->iBarBounds, $this->getStartZ(), $this->getEndZ(), $this->bDark3D,
                                 $this->conePercent);
                              }
      }
      else
      {
         if(($tmp == BarStyle::$RECTANGLE)|
         ($tmp == BarStyle::$CYLINDER))
         {
            $this->barRectangle($this->normalBarColor, $this->iBarBounds);
         }
         else
            if(($tmp == BarStyle::$PYRAMID)|
            ($tmp == BarStyle::$CONE))
            {
               $p = array(new TeePoint($r->x, $endPos),
                                     new TeePoint($tmpMidX, $startPos),
                                     new TeePoint($r->getRight(), $endPos));
               $g->polygon($p);
            }
            else
               if($tmp == BarStyle::$INVPYRAMID)
               {
                  $p = array(new TeePoint($r->x, $startPos),
                                        new TeePoint($tmpMidX, $endPos),
                                        new TeePoint($r->getRight(), $startPos));
                  $g->polygon($this->p);
               }
               else
                  if($tmp == BarStyle::$ELLIPSE)
                  {
                     $g->ellipseRect($this->iBarBounds);
                  }
                  else
                     if($tmp == BarStyle::$ARROW)
                     {
                        $g->arrow(true, new TeePoint($tmpMidX, $endPos),
                        new TeePoint($tmpMidX, $startPos),
                        $r->width, $r->width / 2, $this->getMiddleZ());
                     }
                     else
                      if($tmp == BarStyle::$INVARROW)
                      {                       
                          $g->arrow(true, new TeePoint($tmpMidX, $startPos),
                            new TeePoint($tmpMidX, $endPos),
                            $r->width, $r->width / 2,$this->getMiddleZ());
                      }
                      /* TODO else                                   
                        if($tmp == BarStyle::$RECTGRADIENT)
                        {
                           $this->doBarGradient($barIndex,
                           new Rectangle($r->x, $startPos, $r->getRight() - $r->x,
                           $endPos - $startPos));
                        }
                        */
      }
   }

   protected function moreSameZOrder()
   {
      return($this->iMultiBar == MultiBars::$SIDEALL) ? false : parent::moreSameZOrder();
   }

   /**
   * The Screen X pixel coordinate of the ValueIndex Series
   * value.<br>
   * The horizontal Bar position is the "real" X pos + the BarWidth by our
   * BarSeries order.
   *
   * @param valueIndex int
   * @return int
   */
   public function calcXPos($valueIndex)
   {

      $result = 0;

      if($this->iMultiBar == MultiBars::$SIDEALL)
      {
         $result = $this->getHorizAxis()->calcXPosValue($this->iPreviousCount + $valueIndex) -
         ($this->iBarSize / 2);
      }
      else
         if($this->iMultiBar == MultiBars::$SELFSTACK)
         {
            $result = (parent::calcXPosValue($this->getMinXValue())) - ($this->iBarSize / 2);
         }
         else
         {
            $result = parent::calcXPos($valueIndex);

            if($this->iMultiBar != MultiBars::$NONE)
            {
               $result += MathUtils::round($this->iBarSize *
               (($this->iOrderPos - ($this->iNumBars * 0.5)) - 1.0));
            }
            else
            {
               $result -= ($this->iBarSize / 2);
            }
         }

      return $this->applyBarOffset($result);
   }

   /**
   * The  Screen Y pixel coordinate of the ValueIndex Series value.
   *
   * @param valueIndex int
   * @return int
   */
   public function calcYPos($valueIndex)
   {
      $result = 0;

      if(($this->iMultiBar == MultiBars::$NONE)|
      ($this->iMultiBar == MultiBars::$SIDE)|
      ($this->iMultiBar == MultiBars::$SIDEALL))
      {
         $result = parent::calcYPos($valueIndex);
      }
      else
      {
         $tmpValue = $this->vyValues->value[$valueIndex] +
         $this->pointOrigin($valueIndex, false);
         if(($this->iMultiBar == MultiBars::$STACKED) ||
         ($this->iMultiBar == MultiBars::$SELFSTACK))
         {
            $result = $this->calcYPosValue($tmpValue);
         }
         else
         {
            $tmp = $this->pointOrigin($valueIndex, true);
            $result = ($tmp != 0) ? $this->calcYPosValue($tmpValue * 100.0 / $tmp) : 0;
         }
      }

      return $result;
   }

   protected function drawMark($valueIndex, $s, $p)
   {
      $difW = $this->iBarSize / 2;
      $tmpDistance = $this->getMarks()->getCallout()->getDistance();
      $difH = $this->getMarks()->getCallout()->getLength() + $tmpDistance;

      if($p->arrowFrom->getY() > $this->getOriginPos($valueIndex))
      {
         $difH = -$difH - $p->height;
         $p->arrowFrom->setY($p->arrowFrom->getY() + $tmpDistance);
      }
      else
      {
         $p->arrowFrom->setY($p->arrowFrom->getY() - $tmpDistance);
      }

      $p->leftTop->setX($p->leftTop->getX() + $difW);
      $p->leftTop->setY($p->leftTop->getY() - $difH);
      $p->arrowTo->setX($p->arrowTo->getX() + $difW);
      $p->arrowTo->setY($p->arrowTo->getY() - $difH);
      $p->arrowFrom->setX($p->arrowFrom->getX() + $difW);

      if($this->getAutoMarkPosition())
      {
         $this->getMarks()->antiOverlap($this->firstVisible, $valueIndex, $p);
      }

      parent::drawMark($valueIndex, $s, $p);
   }

   protected function drawSeriesForward($valueIndex)
   {
      if(($this->iMultiBar == MultiBars::$NONE)|
      ($this->iMultiBar == MultiBars::$SIDE)|
      ($this->iMultiBar == MultiBars::$SIDEALL))
      {
         return true;
      }
      else
         if(($this->iMultiBar == MultiBars::$STACKED)|
         ($this->iMultiBar == MultiBars::$SELFSTACK))
         {
            $result = $this->vyValues->value[$valueIndex] >= $this->dOrigin;
            if($this->getVertAxis()->getInverted())
            {
               $result = !$result;
            }
            return $result;
         }
         else
         {
            return !$this->getVertAxis()->getInverted();
         }
   }

   /**
   * The corresponding screen pixels coordinate of the leftmost
   * horizontal bar edge.
   *
   * @param valueIndex int
   * @return int
   */
   public function getOriginPos($valueIndex)
   {
      return $this->internalGetOriginPos($valueIndex, $this->getVertAxis()->iEndPos);
   }

   /**
   * The Maximum Value of the Series X Values List.
   *
   * @return double
   */
   public function getMaxXValue()
   {
      if($this->iMultiBar == MultiBars::$SELFSTACK)
      {
         return $this->getMinXValue();
      }
      else
      {
         return($this->iMultiBar == MultiBars::$SIDEALL) ?
         $this->iPreviousCount + $this->getCount() - 1 :
         parent::getMaxXValue();
      }
   }

   /**
   * The Minimum Value of the Series X Values List.
   *
   * @return double
   */
   public function getMinXValue()
   {

      if($this->iMultiBar == MultiBars::$SELFSTACK)
      {
         return $this->getChart()->getSeriesIndexOf($this);
      }
      else
      {
         return parent::getMinXValue();
      }
   }

   /**
   * The Maximum Value of the Series Y Values List.
   *
   * @return double
   */
   public function getMaxYValue()
   {
      return $this->maxMandatoryValue(parent::getMaxYValue());
   }

   /**
   * The Minimum Value of the Series Y Values List.
   *
   * @return double
   */
   public function getMinYValue()
   {
      return $this->minMandatoryValue(parent::getMinYValue());
   }
}

?>
