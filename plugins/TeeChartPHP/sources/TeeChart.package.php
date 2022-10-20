<?php
/**
 *  This file is part of Steema Software
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

   require_once("vcl/vcl.inc.php");

   use_unit("designide.inc.php");
   use_unit("templateplugins.inc.php");

   setPackageTitle("TeeChart for PHP Components");
   setIconPath("./icons");

   registerComponents("TeeChart",array("TChartObj"),"tchart.inc.php");
   registerAsset(array("TChartObj"),array("teechart/sources"));

   // List of Properties for Object inspector
   registerBooleanProperty("TChartObj","View3D");
   registerBooleanProperty("TChartObj","AxisBehind");
   registerBooleanProperty("TChartObj","AxisVisible");
   registerBooleanProperty("TChartObj","ClipPoints");
//   registerProperty("TChartObj","BackImage");
   registerBooleanProperty("TChartObj","BackImageInside");

//   registerProperty("TChartObj","BackImageMode");
//   registerBooleanProperty("TChartObj","BackImageTransp");

//   registerBooleanProperty("TChartObj","BackWall.Visible");
//    registerPropertyEditor("TChartObj","BackWall.Visible","TSamplePropertyEditor","native");
//    registerPropertyEditor("TChartObj","Walls.Left","TSamplePropertyEditor","native");
//    registerPropertyEditor("TChartObj","Walls.Bottom","TStringListPropertyEditor","native");
//    registerBooleanProperty('TChartObj','BackWall.Width');
//    registerBooleanProperty('TChartObj','Walls.Vertical');

   registerComponentEditor("TChartObj","TChartObjEditor","tchart.ide.inc.php");
?>