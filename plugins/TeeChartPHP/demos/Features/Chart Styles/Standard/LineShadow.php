<?php

//Includes
include "../../../../sources/TChart.php";

$chart = new TChart(600,450);

// Settings for Chart
$chart->getHeader()->setVisible(false);
$chart->getAspect()->setView3D(false);

$chart->getPanel()->getGradient()->setVisible(false);
$chart->getPanel()->setColor(new Color(70,70,70));
$chart->getPanel()->setMarginTop(10);

// Setting Series options
$line1 = new Line($chart->getChart());
$line1->getLinePen()->setWidth(3);

// Adding Data
$line1->add(20);
$line1->add(10);
$line1->add(30);
$line1->add(20);
$line1->add(40);

$line1->getShadow()->setHorizSize(2);
$line1->getShadow()->setVertSize(3);
$line1->getShadow()->setVisible(true);
/* Shadow Color could be changed
$line1->setColor(new Color(255,0,0));
$line1->getShadow()->setColor(new Color(255,255,255));
*/

$line2 = new Line($chart->getChart());
$line2->getLinePen()->setWidth(3);

// Adding Data
$line2->add(40);
$line2->add(35);
$line2->add(10);
$line2->add(15);
$line2->add(5);

$line2->getShadow()->setHorizSize(2);
$line2->getShadow()->setVertSize(3);
$line2->getShadow()->setVisible(true);

// Setting Axes options
$leftAxis=$chart->getAxes()->getLeft();
$leftAxis->getLabels()->getFont()->getBrush()->setColor(new Color(220,220,220));
$leftAxis->getAxisPen()->setColor(new Color(127,127,127));
$leftAxis->getAxisPen()->setWidth(1);
  
$bottomAxis=$chart->getAxes()->getBottom();
$bottomAxis->getLabels()->getFont()->getBrush()->setColor(new Color(220,220,220));
$bottomAxis->getGrid()->setVisible(false);
$bottomAxis->getMinorGrid()->setVisible(false);
$bottomAxis->getAxisPen()->setColor(new Color(127,127,127));
$bottomAxis->getAxisPen()->setWidth(1);

// Settings for the Legend
$chart->getLegend()->setColor(new Color(127,127,127));
$chart->getLegend()->getShadow()->setVisible(false);
$chart->getLegend()->getFont()->getBrush()->setColor(new Color(220,220,220));
$chart->getLegend()->getPen()->setVisible(false);

// Walls
$chart->getWalls()->getBack()->getPen()->setVisible(false);
  
$chart->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Line With Shadow Style<p>';
print '<img src="chart1.png?rand='.$rand.'">';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Line with Shadow Chart</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>