<?php
 /**
 * Description:  This file contains the following class:<br>
 * ISeries class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */
/**
 * ISeries class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright Copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

interface ISeries {
        function clear();
        function checkDataSource();
        function getDataSource();
        function setDataSource($value);
        function invalidate();
        function valuesListAdd($value);
        function getShowInLegend();
        function hasDataSource($source);
        function setSubGallery($index);
        function getYMandatory();
        function getStartZ();
        function getMiddleZ();
        function getEndZ();
        function getColorEach();
        function getColor();
        function getCount();
        function getCountLegendItems();
        function getMarks();
        function getChart();
        function getMandatory();
        function getNotMandatory();
        function getValueList($name);
        function getAllowSinglePoint();
        function getMarkValue($index);
        function getMarkText($index);
        function getValueFormat();
        function getActive();
        function setActive($value);
        function getUseAxis();
        function dispose(); // misc
        function setChart($value);
        function add($value=null);
        function addXY($x, $y);
        function setFunction($value);
        function getLabels();
        function getXValues();
        function getYValues();
        function isNull($index);
        function onDisposing();
        function getHasZValues();
        function getMinZValue();
        function getMaxZValue();
        function dataSourceArray();
        function getZOrder();
        function getFirstVisible();
        function getLastVisible();
        function associatedToAxis($axis);
        function calcFirstLastVisibleIndex();
        function getValueMarkText($index);
        function getLegendString($valueIndex, $style);
        function legendToValueIndex($itemIndex);
        function legendItemColor($itemIndex);
        function drawLegend($g=null,$index,$r);
        function getHorizAxis();
        function getVertAxis();
        function getOriginValue($valueIndex);
        function drawMarks();
        function drawValue($valueIndex);
        function getValueColor($valueIndex);
}
?>