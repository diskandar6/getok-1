<?php

 /**
 * Description:  This file contains the following class:<br>
 * FastLine class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
 /**
 * FastLine Class
 *
 * Description: The FastLine Series is an extremely simple Series component
 * that draws its points as fast as possible
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class FastLine extends BaseLine {

    private $autoRepaint = true;
    private $drawAll = true;
    private $old;
    private $internalG;
    private $internal3D;
    private $invertedStairs=false;
    private $stairs=false;
    private $ignoreNulls = true;

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

    public function __construct($c=null) {
        $this->old = new TeePoint();

        parent::__construct($c);
        
        $this->allowSinglePoint = false;
        $this->drawBetweenPoints = true;
        $this->getLinePen()->setUsesVisible(false);
    }

    public function __destruct()    
    {        
        parent::__destruct();       
                 
        unset($this->autoRepaint);
        unset($this->drawAll);
        unset($this->old);
        unset($this->internalG);
        unset($this->internal3D);
        unset($this->invertedStairs);
        unset($this->stairs);
        unset($this->ignoreNulls);
    } 
        
    public function setChart($value) {
        parent::setChart($value);

        $this->getLinePen()->setChart($value);

        /** @todo FINISH ! */
        //pLinePen.ColorChanged=linePenColorChanged;
    }

        /**
          * Repaints Chart after any changes are made.<br>
          * Use AutoRepaint false to disable Chart repainting whilst, for example,
          * adding a large number of points to a FastLine Series. This avoids
          * repainting of the Chart whilst the points are added.<br>
          * AutoRepaint may be re-enabled, followed by a manual Repaint command
          * when all points are added. <br>
          * Default value: true
          *
          * @return boolean
          */
    public function getAutoRepaint() {
        return $this->autoRepaint;
    }

        /**
          * Repaints Chart after any changes are made.<br>
          * Default value: true
          *
          * @param value boolean
          */
    public function setAutoRepaint($value) {
        $this->autoRepaint = $value;
    }

        //private void linePenColorChanged(Object o, EventArgs e) {
        //    setColor(pLinePen.getColor());
        //}

    private function prepareCanvas($g=null) {
        if ($g==null)
           $g=$this->chart->getGraphics3D();

        $g->setPen($this->getLinePen());
        $g->getPen()->setColor($this->getColor());
    }

        /**
          * The Transparency of the FastLine series as a percentage.
          * Default value: 0
          *
          * @return int
          */
    public function getTransparency() {
        return $this->getLinePen()->getTransparency();
    }

        /**
          * Sets the Transparency of the FastLine series as a percentage.
          * Default value: 0
          *
          * @param value int
          */
    public function setTransparency($value) {
        $this->getLinePen()->setTransparency($value);
    }

        /**
          * When false, it only draws the first point at any X pixel location.
          * The option offers speed gains if large numbers of point repetitions
          * occur at one X location. <br>
          * Default value: true
          *
          * @return boolean
          */
    public function getDrawAllPoints() {
        return $this->drawAll;
    }

        /**
          * When false, it only draws the first point at any X pixel location.
          * The option offers speed gains if large numbers of point repetitions
          * occur at one X location. <br>
          * Default value: true<br>
          *
          * <p>Example:
          * <pre><font face="Courier" size="4">
          * lineSeries.setDrawAllPoints( false );
          * </font></pre></p>
          *
          * @param value boolean
          */
    public function setDrawAllPoints($value) {
        $this->drawAll = $this->setBooleanProperty($this->drawAll, $value);
    }

    public function setColor($value) {
        parent::setColor($value);
        $this->getLinePen()->setColor($value);
    }

        /**
          * Returns the ValueIndex of the "clicked" point in the Series.<br>
          * Clicked means the X and Y coordinates are in the point screen region
          * bounds. If no point is "touched", Clicked returns -1 <br>
          *
          * @param x int
          * @param y int
          * @return int
          */
    public function clicked($x, $y) {

        if (($this->firstVisible > -1) && ($this->lastVisible > -1)) {

             $p = new TeePoint($x, $y);

            if ($this->chart != null) {
                $p = $this->chart->getGraphics3D()->calculate2DPosition($x, $y, $this->getMiddleZ());
            }

             $oldX = 0;
             $oldY = 0;

            for ( $t = $this->firstVisible; $t <= $this->lastVisible; $t++) {

                 $tmpX = $this->calcXPos($t);
                 $tmpY = $this->calcYPos($t);

                if (($tmpX == $x) && ($tmpY == $y)) { //   $on $this->point
                    return $t;
                } else
                if (($t > $this->firstVisible) &&
                    MathUtils::pointInLineTolerance($p, $tmpX, $tmpY, $oldX, $oldY,
                        3)) {
                    return $t - 1;
                }
                $oldX = $tmpX;
                $oldY = $tmpY;
            }
        }
        return -1;
    }

    private function calcPosition($index) {
        return new TeePoint($this->getHorizAxis()->calcXPosValue($this->getXValues()->value[$index]),
                         $this->getVertAxis()->calcYPosValue($this->getYValues()->value[$index]));
    }

    protected function draw() {
        $this->prepareCanvas();
        $tmp = $this->firstVisible;

        $this->old = $this->calcPosition(($tmp > 0) ? $tmp - 1 : 0);

        $this->internalG = $this->chart->getGraphics3D();
        $this->internal3D = $this->chart->getAspect()->getView3D();

        $this->doMove($this->old);

        if ($tmp >= 0) {
            $this->drawValue($tmp);
        }

        for ( $t = $tmp + 1; $t <= $this->lastVisible; $t++) {
            $this->drawValue($t);
        }
    }

    private function doMove($p) {
        if ($this->internal3D) {
            $this->internalG->moveToZ($p, $this->middleZ);
        } else {
            $this->internalG->moveTo($p);
        }
    }

        /**
          * Called internally. Draws the "ValueIndex" point of the Series.
          *
          * @param index int
          */
    public function drawValue($index) {
         $p = $this->calcPosition($index);

        if ($this->internalG == null) {
            $this->internalG = $this->chart->getGraphics3D();
        }

        if ($p->getX() == $this->old->getX()) {
            if ((!$this->drawAll) || ($p->getY() == $this->old->getY())) {
                $tmpColor = new Color(0,0,0,255);  // TODO check transparent
                if ($this->getValueColor($index) != $tmpColor/*->TRANSPARENT*/) {
                    return; // $FastLine $this->Nulls
                }
                unset($tmpColor);
            }
        }

        if ($this->ignoreNulls || ($this->getValueColor($index) != new Color(0,0,0,255))) { // $FastLine $Nulls
            if ($this->bColorEach) {
                $this->internalG->getPen()->setColor($this->getValueColor($index));
            }

            if ($this->internal3D) {
                if ($this->stairs) {
                    if ($this->invertedStairs) {
                        $this->internalG->___lineTo($this->old->getX(), $p->getY(), $this->middleZ);

                    } else {
                        $this->internalG->___lineTo($p->getX(), $this->old->getY(), $this->middleZ);
                    }
                }
                $this->internalG->lineTo($p, $this->middleZ);
            } else {
                if ($this->stairs) {
                    if ($this->invertedStairs) {
                        $this->internalG->_____lineTo($this->old->getX(), $p->getY());

                    } else {
                        $this->internalG->_____lineTo($p->getX(), $this->old->getY());
                    }
                }

                $this->internalG->__lineTo($p);
            }
        } else { // $FastLine $Nulls
            if ($index + 1 < $getCount()) {
                $this->doMove($this->calcPosition($index + 1));
            } else {
                return;
            }
        }

        //            if (drawAll) {
        //                    if (colorEach) internalG.getPen().Color=getValueColor(index);
        //                    if (internal3D)
        //                        internalG.LineTo(X,Y,middleZ);
        //                    else
        //                        internalG.LineTo(X,Y);
        //            }
        //            else {
        //                if (X != oldX) {
        //                    if (colorEach) internalG.getPen().Color=getValueColor(index);
        //                    if (internal3D)
        //                        internalG.LineTo(X,Y,middleZ);
        //                    else
        //                        internalG.LineTo(X,Y);
        //                }
        //                else
        //                    return;
        //            }

        $this->old->setX($p->getX());
        $this->old->setY($p->getY());
    }

    protected function drawMark($valueIndex, $st, $aPosition) {
        $this->getMarks()->applyArrowLength($aPosition);
        parent::drawMark($valueIndex, $st, $aPosition);
    }

    protected function drawLegendShape($g, $valueIndex, $rect) {
        $this->prepareCanvas($g);
        $g->horizontalLine($rect->x, $rect->getRight(),
                         ($rect->y + $rect->getBottom()) / 2);
    }

    public function createSubGallery($addSubChart) {
        parent::createSubGallery($addSubChart);
        $addSubChart->createSubChart(Language::getString("Marks"));
        $addSubChart->createSubChart(Language::getString("Dotted"));
        $addSubChart->createSubChart(Language::getString("Stairs"));
    }

    public function setSubGallery($index) {
        switch ($index) {
        case 1:
            $this->getMarks()->setVisible(true);
            break;
        case 2:
            $this->getLinePen()->setStyle(DashStyle::$DOT);
            break;
        case 3:
            $this->setStairs(true);
            break;
        default:
            break;
        }
    }

        /**
          * Controls the drawing of FastLine series. <br>
          * In most normal situations, a series draws a line between each Line
          * point. This makes the Line appear as a "mountain" shape.  <br>
          * However, setting Stairs to true will make the Series to draw 2 Lines
          * between each pair of points, thus giving a "stairs" appearance.  <br>
          * This is most used in some financial Chart representations. <br>
          * When Stairs is set to true you may set InvertedStairs to true to alter
          * the direction of the step. <br>
          * Default value: false
          *
          * @return boolean
          */
    public function getStairs() {
        return $this->stairs;
    }

        /**
          * Controls the drawing of FastLine series. <br>
          * Default value: false<br>
          *
          * <p>Example:
          * <pre><font face="Courier" size="4">
          * lineSeries1.setStairs( true );
          * </font></pre></p>
          *
          * @param value boolean
          */
    public function setStairs($value) {
        $this->stairs = $this->setBooleanProperty($this->stairs, $value);
    }

        /**
          * Controls the FastLine series drawing. <br>
          * When Stairs is set to true you may set InvertedStairs to true to alter
          * the direction of the step. <br>
          * In most normal situations, the Series draws a line between each Line
          * point. This makes the Line appear as a "mountain" shape.  <br>
          * However, setting Stairs to true will make the Series draw 2 Lines
          * between each pair of points, thus giving a "stairs" appearance.  <br>
          * This is most used in some financial Chart representations. You may
          * invert the stair by setting InvertedStairs to true. <br>
          * Default value: false
          *
          * @return boolean
          */
    public function getInvertedStairs() {
        return $this->invertedStairs;
    }

        /**
          * Controls the FastLine series drawing. <br>
          * Default value: false
          *
          * @param value boolean
          */
    public function setInvertedStairs($value) {
        $this->invertedStairs = $this->setBooleanProperty($this->invertedStairs, $value);
    }

        /**
          * Displays null points when false<br>
          * For speed reasons, FastLine series supports null (empty) values only
          * when IgnoreNulls is false. <br>
          * By default all points are displayed (IgnoreNulls is true by default).<br>
          * To enable FastLine series to hide null points, set IgnoreNulls to
          * false. <br>
          * Default value: true
          *
          * @return boolean
          */
    public function getIgnoreNulls() {
        return $this->ignoreNulls;
    }

        /**
          * Displays null points when false<br>
          * Default value: true<br>
          *
          * <p>Example:
          * <pre><font face="Courier" size="4">
          * lineSeries1.setNull( 123 ); // -- make null (empty) point index 123
          * lineSeries1.setIgnoreNulls( false ); // -- allow null points
          * lineSeries1.setStairs( true ); // -- set "stairs" mode
          * </font></pre></p>
          *
          * @param value boolean
          */
    public function setIgnoreNulls($value) {
        $this->ignoreNulls = $this->setBooleanProperty($this->ignoreNulls, $value);
    }

        /**
          * Gets descriptive text.
          *
          * @return String
          */
    public function getDescription() {
        return Language::getString("GalleryFastLine");
    }
}


/**
  *
  * <p>Title: BaseLine class</p>
  *
  * <p>Description: Abstract Series class inherited by a number of TeeChart
  * series styles.</p>
  *
  * <p>Copyright (c) 2005-2007 by Steema Software SL. All Rights
  * Reserved.</p>
  *
  * <p>Company: Steema Software SL</p>
  *
  */

  /* todo remove ... baseline class done in separate class unit
 class BaseLine extends Series {

    protected $linePen;

    protected function BaseLine($c=null) {
        parent::FastLine($c);
    }

    public function assign($source) {
        if ($source instanceof BaseLine) {
            $tmp = $source;
            if ($this->tmp->linePen != null) {
                $this->getLinePen()->assign($this->tmp->linePen);
            }
        }
        parent::assign($source);
    }

    public function setChart($c) {
        parent::setChart($c);
        $this->getLinePen()->setChart($this->chart);
    }

    /**
     * Determines pen to draw the line connecting all points.<br>
     *
     * @return ChartPen
     *
    public function getLinePen() {
        if ($this->linePen == null) {
            $tmpColor = new Color();
            $this->linePen = new ChartPen($this->chart, $tmpColor->EMPTY);
        }
        return $this->linePen;
    }
}
*/
?>
