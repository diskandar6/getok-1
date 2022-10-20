<?php
 /**
 * Description:  This file contains the following class:<br>
 * Title: LegendResolver class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */
/**
 * LegendResolver class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */

interface LegendResolver{

function getBounds($legend, $rectangle);//TODO Check: is this on total legend, or only item?

function getItemCoordinates($legend, $coordinates);

function getItemText($legend, $legendStyle, $index, $text);
}

?>