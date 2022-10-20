<?php
 /**
 * Description:  This file contains the following class:<br>
 * AnnotationPosition class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */
/**
 * AnnotationPosition class
 *
 * Description: Describes the possible values of the Annotation.Position
* method
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

class AnnotationPosition
{
   /**
   * Draws the Annotation Tool in the top left of the Chart Panel.
   */
   public static $LEFTTOP = 0;

   /**
   * Draws the Annotation Tool in the bottom left of the Chart Panel.
   */
   public static $LEFTBOTTOM = 1;

   /**
   * Draws the Annotation Tool in the top right of the Chart Panel.
   */
   public static $RIGHTTOP = 2;

   /**
   * Draws the Annotation Tool in the bottom right of the Chart Panel.
   */
   public static $RIGHTBOTTOM = 3;

   function __construct() {}
}

?>