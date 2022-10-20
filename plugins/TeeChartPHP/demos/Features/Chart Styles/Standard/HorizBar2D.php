<?php
  
//Includes
include "../../../../sources/TChart.php";

$chart = new TChart(500,800);
$chart->getAspect()->setView3D(false);
$chart->getHeader()->setText("Horiz Bar 2D");
$chart->getHeader()->setVisible(false);

$chart->getLegend()->setVisible(false);

$chart->getAxes()->getBottom()->setMinimumOffset(10);
$chart->getAxes()->getBottom()->setMaximumOffset(10);
$chart->getAxes()->getTop()->setMinimumOffset(10);
$chart->getAxes()->getTop()->setMaximumOffset(10);

$line1=new HorizBar($chart->getChart());  
$data = Array(66,35,55,49,40,50,82,90,95,86,65,50,65,35,175,125,200,175);
$line1->addArray($data);
$labels = Array('James','John','Chris','Alison','Henri','Jason','Eddi','Joseph', 'Yngvart','Jorn','Sally',
    'Sam','Jeremy','Charles','Tom','Albert','Thomas','Janet');
$line1->setLabels($labels);
$line1->setColor(new Color(47,54,153));
$chart->getAxes()->getLeft()->getLabels()->setStyle(AxisLabelStyle::$TEXT);
$chart->getAxes()->getLeft()->getLabels()->setAlign(AxisLabelAlign::$OPPOSITE);

$line1->getMarks()->getArrow()->setVisible(false);
$line1->getMarks()->setArrowLength(-52);
$line1->getMarks()->setTransparent(true);
$line1->getMarks()->getFont()->setColor(Color::WHITE());

$chart->getAxes()->getLeft()->setGridCentered(true);
$line1->setHorizontalAxis(HorizontalAxis::$BOTH);
$chart->getAxes()->getBottom()->getTitle()->setText('time (in Sec)');
$chart->getAxes()->getTop()->getTitle()->setText('time (in Sec)');

$chart->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Horiz Bar 2D<p>';
print '<img src="chart1.png?rand='.$rand.'">';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Line 2D</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>