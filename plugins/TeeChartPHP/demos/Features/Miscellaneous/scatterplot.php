<?php
  
//Includes
include "../../../sources/TChart.php";

$chart = new TChart(600,450);

$chart->getHeader()->setText("Scatter Plot");
$chart->getPanel()->getGradient()->setVisible(false);
$chart->getAspect()->setView3D(false);

$panel=$chart->getPanel();
$panel->getBevel()->setInner(BevelStyle::$NONE);
$panel->getBevel()->setOuter(BevelStyle::$NONE);
$panel->getPen()->setColor(new Color(120,120,120));
$panel->getPen()->setVisible(true);

$line = new Line($chart->getChart());

// Adding DateTime data
$today = gettimeofday(true); 
$days7 = 7 * 86400; 
$days2 = 2 * 86400; 
$end_date = $today + $days7; 
$end_task2= $end_date + $days7 ; 

$chart->getChart()->getSeries(0)->getXValues()->setDateTime(true);         
$chart->getChart()->getAxes()->getBottom()->getLabels()->setAngle(45); 
$chart->getChart()->getAxes()->getBottom()->getLabels()->setRoundFirstLabel(false);

// If you want to set a datetime format...
//  $chart->getChart()->getAxes()->getBottom()->getLabels()->setDateTimeFormat('d-m-y h:m:s');

$line->addXY($today,30);
$line->addXY($today+86400,32);
$line->addXY($today+$days2,20);
$line->addXY($end_date+$days7+$days7,8);
$line->addXY($end_date+$days7+$days7+$days2,18);        
$line->addXY($end_date+$days7+$days7+$days7,10);

$line->getLinePen()->setWidth(3);

$pointer=$line->getPointer();
$pointer->setVisible(true);
$pointer->setStyle(PointerStyle::$CIRCLE);
$pointer->getBrush()->setColor(Color::getWhite());
$pointer->getPen()->setColor($line->getColor());
$pointer->getPen()->setWidth(2);

$chart->getPanel()->getBorderPen()->setVisible(false);

$chart->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Scatter Plot<p>';
print '<img src="chart1.png?rand='.$rand.'">';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Scatter Plot</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>