<?php
  /**
 * Description:  This file contains the following class:<br>
 * GridPen class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */
 /**
 * GridPen class
 *
 * Description: Determines the kind of pen used to draw the Grid lines at
 * every Axis Label position
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

class GridPen extends ChartPen
{

   /**
   * When centered is true, grid is displayed in between axis labels.
   * When false, grid lines are drawn at axis labels positions.
   */
   protected $centered;
   private $zPosition;

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
   * Creates a new Grid pen.
   *
   * @param chart IBaseChart
   */
   public function __construct($chart)
   {
      $tmpColor = new Color(220, 220, 220);// GRAY
      parent::__construct($chart, $tmpColor, true , 1 , 1 , DashStyle::$DOT);
      
      unset($tmpColor);
   }

    public function __destruct()    
    {        
        parent::__destruct();                
        unset($this->centered);
        unset($this->zPosition);  
    }
   
   /**
   * Determines the style of the axis grid lines.<br>
   * It sets both vertical and horizontal lines independently. <br>
   * DefaultValue: DashStyle::$DOT
   *
   * @return DashStyle
   */
   public function getStyle()
   {
      return parent::getStyle();
   }

   /**
   * Aligns the Grid to the centre. <br>
   * DefaultValue: false
   *
   * @return boolean
   */
   public function getCentered()
   {
      return $this->centered;
   }

   /**
   * Sets grid lines to display between axis labels or at label positions.
   *
   * @param value boolean
   */
   public function setCentered($value)
   {
      $this->centered = $this->setBooleanProperty($this->centered, $value);
   }

   /**
   * Returns the Z position of the Grid lines, in percent of total chart
   * depth.
   *
   * @return double
   */
   public function getZPosition()
   {
      return $this->zPosition;
   }

   /**
   * Sets the Z position of Grid lines in percentage of total chart depth.
   *
   * @param value double
   */
   public function setZPosition($value)
   {
      if($this->zPosition != $value)
      {
         $this->zPosition = $value;
         $this->invalidate();
      }
   }
}

?>