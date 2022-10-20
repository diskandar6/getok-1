<?php
 /**
 * Description:  This file contains the following class:<br>
 * Line class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * Line class
 *
 * Description: Line Series
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2017 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class Line extends Custom
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

   /**
   * The class constructor.
   */
   public function __construct($c = null)
   {
      parent::__construct($c);

      $this->drawLine = true;
      $this->getPointer()->setDefaultVisible(false);
      $this->allowSinglePoint = false;
   }
   
    public function __destruct()    
    {        
        parent::__destruct();       
    }   

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return $this->Language->getString("GalleryLine");
   }


   /**
   * Determines the Line Gradient.
   *
   * @return Gradient
   */
   public function getGradient()
   {
      return $this->bBrush->getGradient();
   }

   protected function prepareLegendCanvas($g, $valueIndex, $backColor, $aBrush)
   {
      $g->setPen($this->getLinePen());
      $g->setBrush($aBrush);
   }

   public function createSubGallery($addSubChart)
   {
      parent::createSubGallery($addSubChart);
      $addSubChart->createSubChart(Language::getString("Stairs"));
      $addSubChart->createSubChart(Language::getString("Points"));
      $addSubChart->createSubChart(Language::getString("Height"));
      $addSubChart->createSubChart(Language::getString("Hollow"));
      $addSubChart->createSubChart(Language::getString("Colors"));
      $addSubChart->createSubChart(Language::getString("Marks"));
      $addSubChart->createSubChart(Language::getString("NoBorder"));
   }

   public function setSubGallery($index)
   {
      switch($index)
      {
         case 1:
            $this->setStairs(true);
            break;
         case 2:
            $this->getPointer()->setVisible(true);
            break;
         case 3:
            $this->setLineHeight(5);
            break;
         case 4:
            $this->getBrush()->setVisible(false);
            break;
         case 5:
            $this->setColorEach(true);
            break;
         case 6:
            $this->getMarks()->setVisible(true);
            break;
         case 7:
            $this->getLinePen()->setVisible(false);
            break;
      }
   }
}

?>