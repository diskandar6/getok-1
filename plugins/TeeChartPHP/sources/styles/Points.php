<?php
 /**
 * Description:  This file contains the following class:<br>
 * Points class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
  *
  * <p>Title: Points class</p>
  *
  * <p>Description: Point Series.</p>
  *
  * <p>Example:
  * <pre><font face="Courier" size="4">
  *  pointSeries = new com.steema.teechart.styles.Points(myChart.getChart());
  *  pointSeries.fillSampleValues(20);
  * </font></pre></p>
  *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class Points extends CustomPoint {

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
        parent::__construct($c);

        if ($this->point == null) {
            $tmpColor = new Color(0,0,0,0,true);
            $this->getPointer()->setColor($tmpColor);
            
            unset($tmpColor);
        }
    }

    /**
      * Sets the Pen for the Point connecting Lines.
      *
      * @return ChartPen
      */
    public function getLinePen() {
        return parent::getLinePen();
    }

    public function getColor() {
        $tmpColor = new Color(0,0,0,0,true);
        return ($this->point == null) ? $tmpColor : $this->getPointer()->getColor();
    }

    public function setColor($value) {
        parent::setColor($value);
        $this->getPointer()->setColor($value);
    }

    public function setColorEach($value) {
        parent::setColorEach($value);
        if ($value) {
            $tmpColor = new Color(0,0,0,0,true);
            $this->point->getBrush()->setForegroundColor($tmpColor);
        }
    }

    /**
      * Gets descriptive text.
      *
      * @return String
      */
    public function getDescription() {
        return $this->Language->getString("GalleryPoint");
    }

    protected function canDoExtra() {
        return true;
    }

    public function createSubGallery($addSubChart) {
        parent::createSubGallery($addSubChart);

        $addSubChart->createSubChart(Language::getString("Colors"));
        $addSubChart->createSubChart(Language::getString("Marks"));
        $addSubChart->createSubChart(Language::getString("Hollow"));
        $addSubChart->createSubChart(Language::getString("NoBorder"));
        $addSubChart->createSubChart(Language::getString("Gradient"));

        if ($this->canDoExtra()) {
            $addSubChart->createSubChart(Language::getString("Point2D"));
            $addSubChart->createSubChart(Language::getString("Triangle"));
            $addSubChart->createSubChart(Language::getString("Star"));
            $addSubChart->createSubChart(Language::getString("Circle"));
            $addSubChart->createSubChart(Language::getString("DownTri"));
            $addSubChart->createSubChart(Language::getString("Cross"));
            $addSubChart->createSubChart(Language::getString("Diamond"));
        }
    }

    public function setSubGallery($index) {
        switch ($index) {
        case 1:
            $this->setColorEach(true);
            break;
        case 2:
            $this->getMarks()->setVisible(true);
            break;
        case 3:
            $this->getPointer()->getBrush()->setVisible(false);
            break;
        case 4:
            $this->getPointer()->getPen()->setVisible(false);
            break;
        case 5:
            $this->getPointer()->getGradient()->setVisible(true);
            break;
        default: {
            if ($this->canDoExtra()) {
                switch ($index) {
                case 6:
                    $this->getPointer()->setDraw3D(false);
                    break;
                case 7:
                    $this->getPointer()->setStyle(PointerStyle::$TRIANGLE);
                    break;
                case 8:
                    $this->getPointer()->setStyle(PointerStyle::$STAR);
                    break;
                case 9: {
                    $this->getPointer()->setStyle(PointerStyle::$CIRCLE);
                    $this->getPointer()->setHorizSize(8);
                    $this->getPointer()->setVertSize(8);
                }
                break;
                case 10:
                    $this->getPointer()->setStyle(PointerStyle::$DOWNTRIANGLE);
                    break;
                case 11:
                    $this->getPointer()->setStyle(PointerStyle::$CROSS);
                    break;
                case 12:
                    $this->getPointer()->setStyle(PointerStyle::$DIAMOND);
                    break;
                default:
                    break;
                }
            }
        }
        break;
        }
    }
}
?>