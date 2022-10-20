<?php
 /**
 * Description:  This file contains the following classes:<br>
 * Bezier class<br>
 * BezierStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Bezier class
 *
 * Description: Bezier Series
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
  
 class Bezier extends Custom {
     
    //private $bezierStyle = 0;
    private $numBezierPoints = 32;

    public function __construct($c=null) {
        parent::__construct($c);
        
        //$this->bezierStyle=BezierStyle::$WINDOWS;
        $this->numBezierPoints=32;        
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->numBezierPoints);
    }    
    
    protected function draw() {
        // Limitation: points must be 4 + n*3
        //$tmp = $this->getCount();
        $tmp = $this->numBezierPoints;
        while ((($tmp - 4) % 3) != 0) {
            $tmp++;
        }

        $p = Array();
        for ( $t = 0; $t < $this->getCount(); $t++) {
            $p[$t] = new TeePoint($this->calcXPos($t), $this->calcYPos($t));
        }

        // Copy last point to remainder (see limitation above)        
        for ( $t = $this->getCount(); $t < $tmp; $t++) {
            $p[$t] = $p[$this->getCount() - 1];
        }

        $g = $this->chart->getGraphics3D();
        $g->getBrush()->setVisible(false);

        if (!$this->getLinePen()->getVisible())
            $g->getPen()->setColor(Color::TRANSPARENT());
        else
            $g->setPen($this->getLinePen());
//        }
        if ($this->chart->getAspect()->getView3D()) {
            $g->drawBeziers($this->getMiddleZ(), $p);
        } else {
            $g->drawBeziers($p);
        }

        // Draw pointers...
        if ($this->point->getVisible()) {
            for ($t = 0; $t < $this->getCount(); $t++) {
                $this->drawPointer($p[$t]->x, $p[$t]->y, $this->getValueColor($t), $t);
            }
        }
    }

    /**
    * Internal use.
    *
    * @param isEnabled boolean
    */
    public function prepareForGallery($isEnabled) {
        parent::prepareForGallery($isEnabled);
        $this->fillSampleValues(7); // 4 + $this->n*3  ( 4  $points + 3 for  $group )
        $this->setColorEach($isEnabled);
        $this->getPointer()->setDraw3D(false);
    }

    public function setColor($c) {
        parent::setColor($c);
        $this->getLinePen()->setColor($c);
    }

    
    public function setNumBezierPoints($value)
    {
        if ($value<2)
          echo 'Number of Bezier points should be > 1';

        $this->numBezierPoints=$value;
    }
    
    /*public function setBezierStyle($value)
    {
        if ($this->bezierStyle!=$value)
        {
            $this->bezierStyle=$value;
            $this->repaint();
        }
    }

    public function getBezierStyle()
    {
       return $this->bezierStyle;
    }*/
    
    public function getNumBezierPoints()
    {
        return $this->numBezierPoints;
    }
        
    /**
    * Gets descriptive text.
    *
    * @return String
    */
    public function getDescription() {
        return Language::getString("GalleryBezier");
    }
}
 /**
 * Description:  This file contains the following classes:<br>
 * Bezier class<br>
 * BezierStyle class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * BezierStyle class
 *
 * Description: BezierStyle Series
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
class BezierStyle {

   public static $WINDOWS = 0;
   public static $BEZIER3 = 1;
   public static $BEZIER4 = 2;

   public function __construct()
   {}

   public function fromValue($value)
   {
      switch($value)
      {
         case 0:
            return self::$WINDOWS;
         case 1:
            return self::$BEZIER3;
         default:
            return self::$BEZIER4;
      }
   }
}
?>