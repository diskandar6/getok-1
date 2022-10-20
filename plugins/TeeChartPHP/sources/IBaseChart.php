<?php
 /**
 * Description:  This file contains the following class:<br>
 * IBaseChart class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */
 /**
 * IBaseChart class
 *
 * Description:
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

interface IBaseChart {

    /**
     * Accesses all visible TChart attributes..
     *
     * @return TChart
     */        
    function getParent();
    function getChartBounds();
    function getWidth();
    function getHeight();
    function getLeft();
    function getRight();
    function getTop();
    /**
     * Accesses all visible Background attributes..
     *
     * @return TeePanel
     */    
    function getPanel();
    /**
     * Accesses all visible Legend attributes..
     *
     * @return Legend
     */        
    function getLegend();
    function getWalls();
    function getHeader();
    function doBaseInvalidate();
    function doChangedBrush($value);
    function doChangedFont($value);
    /**
     * Accesses all visible graphics attributes..
     *
     * @return GraphicsGD;
     */            
    function getGraphics3D();
    function canDrawPanelBack();
    function getAspect();
    function  getTools();
    function invalidate();
    function getSeriesCount();
    function getChartRect();
    function setChartRect($rect);
    function getPage();
    function setAutoRepaint($value);
    function getAutoRepaint();
    function getMaxZOrder();
    function setMaxZOrder($value);
    function countActiveSeries();
    function getLegendPen();
    function addSeries($series);
    function removeSeries($series);
    function moveSeriesTo($series, $index);
    /**
     * Accesses Axes methods and properties
     *
     * @return Axes
     */
    function getAxes();
    function isAxisCustom($axis);
    function seriesLegend($index, $onlyActive);
    function activeSeriesLegend($itemIndex);
    function formattedLegend($pos);
    function formattedValueLegend($series, $seriesOrValueIndex);
    function setLegendPen($pen);
    function setCancelMouse($value);
    function getPrinting();
    function setPrinting($value);
    function getMaxValuesCount();
    function getSeriesWidth3D();
    function getSeriesHeight3D();
    function getToolTip();
    function setLegend($value);
    function doDrawLegend($g, $rect);
    function setGraphics3D($value);
    function setWidth($value);
    function setHeight($value);
    function image($width, $height);
    function getBottom();
}
?>
