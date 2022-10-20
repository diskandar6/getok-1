<?php
  
//Includes
include "../../../../sources/TChart.php";

$chart1 = new TChart(600,450);

//$chart1->getHeader()->getFont()->setSize(12);
$chart1->getHeader()->setText("Monthly Sales Sumary");
$chart1->getAspect()->setChart3DPercent(30);

$chart1->getAxes()->getBottom()->getLabels()->setStyle(AxisLabelStyle::$TEXT);
$chart1->getAxes()->getBottom()->getGrid()->setVisible(false);
$chart1->getAxes()->getLeft()->getAxisPen()->setVisible(false);
$chart1->getAxes()->getBottom()->getAxisPen()->setVisible(false);

$chart1->getLegend()->setAlignment(LegendAlignment::$BOTTOM);
$chart1->getLegend()->setTopLeftPos(0);
$chart1->getLegend()->getFont()->setSize(10);
$chart1->getLegend()->setTransparent(true);

$chart1->getWalls()->getBottom()->setSize(3);
$chart1->getWalls()->getLeft()->setSize(3);

// Loading data, using AddArray to be faster
$data1 = Array(3200,3500,3000,3300,3500,3800,4100,3900,4300,3600,4650,4900);
$data2 = Array(3500,3200,3800,2800,4500,3350,3850,4100,3500,4800,4200,4600);
$labels = Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

$line1=new Line($chart1->getChart());
$line1->setTitle("2008");
$line1->addArray($data1);
$line1->setLabels($labels);
$line1->getLinePen()->setVisible(false);

$line2=new Line($chart1->getChart());
$line2->setTitle("2009");
$line2->addArray($data2);
$line2->setLabels($labels);
$line2->getLinePen()->setVisible(false);

$axis = $chart1->getAxes()->getLeft();
$axis->getLabels()->setSeparation(50);
$axis->getLabels()->setOnAxis(false);
$axis->getLabels()->setRoundFirstLabel(true);

$axis = $chart1->getAxes()->getBottom();
$axis->getLabels()->setSeparation(50);
$axis->getLabels()->setOnAxis(false);
$axis->getLabels()->setRoundFirstLabel(true);

$chart1->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Line 3D Style<p>';
print '<img src="chart1.png?rand='.$rand.'">';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Line 3D</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>
