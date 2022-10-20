<?php

//Includes
include "../../../../sources/TChart.php";

$chart = new TChart(500,500);
$chart->getAspect()->setView3D(false);

$bar = new HorizBar($chart->getChart());
$values = Array(50,100,150,75,50,25,80,110);
$bar->addArray($values);

$chart->getAxes()->getLeft()->setGridCentered(true);

$gridBand = new GridBand($chart->getChart());
$gridBand->setAxis($chart->getAxes()->getLeft());
$gridBand->getBand1()->setColor(Color::WHITE_SMOKE());
$gridBand->getBand2()->setColor(new Color(210,210,210));

$myPalette =  Array(        
            new Color(56,113,172),
            new Color(217,131,29),
            new Color(190,59,44),
            new Color(143,179,57),
            new Color(116,84,146)  
            );

ColorPalettes::_applyPalette($chart->getChart(),$myPalette);
$bar->setColorEach(true);
$bar->getPen()->setVisible(false);

$chart->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Setting GridCentered property to true for the Axis makes to change the aspect of the Grid Band tool too <p>';
print '<img src="chart1.png?rand='.$rand.'">';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Centered Grids with GriodBand Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>