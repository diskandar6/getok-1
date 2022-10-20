<?php
  
//Includes
include "../../../../sources/TChart.php";

$chart = new TChart(375,667);
$chart->getAspect()->setView3D(false);
$chart->getHeader()->setText("2D Line Chart");

$chart->getAxes()->getLeft()->setMinimumOffset(10);
$chart->getAxes()->getLeft()->setMaximumOffset(10);

$chart->getAxes()->getBottom()->setMinimumOffset(10);
$chart->getAxes()->getBottom()->setMaximumOffset(10);

$chart->getAxes()->getLeft()->getLabels()->setFrac_digits(1);  
 
$line1=new Line($chart->getChart());  
$data = Array(10,50,25,175,125,200,175);
$line1->addArray($data);

$line2=new Line($chart->getChart());  
$line2->addXY(0,10);
$line2->addXY(1,15);
$line2->addXY(2,20);
$line2->addXY(3,25);                                       
$line2->addXY(10,30);

/* You can also use one of the following methods , in the case you want to 
specify a text or color for each point :

$line2->addXYColor(x,y,color)
$line2->addXYText(x,y,text)
$line2->addXYTextColor(x,y,text,color)
*/


$line3=new Line($chart->getChart());  
$data = Array(200,175,175,100,65,110,90);
$line3->addArray($data);

foreach ($chart->getSeries() as $serie) {
  $pointer = $serie->getPointer();
  $pointer->setVisible(true);
  $pointer->getPen()->setVisible(false);
  $pointer->setHorizSize(3);
  $pointer->setVertSize(3);  
  
  $marks = $serie->getMarks();
  $marks->setVisible(true);
  $marks->setArrowLength(5);
  $marks->getArrow()->setVisible(false);
  $marks->setTransparent(true);  
}

$line1->getPointer()->setStyle(PointerStyle::$CIRCLE);
$line2->getPointer()->setStyle(PointerStyle::$TRIANGLE);

$line2->getLinePen()->setStyle(DashStyle::$DASH);

$chart->render("chart1.png");
$rand=rand();

print '<font face="Verdana" size="2">Line 2D Style<p>';
print '<img src="chart1.png?rand='.$rand.'">'; 

// Chart 2

$chart2 = new TChart(375,667);
$chart2->getAspect()->setView3D(false);
$chart2->getHeader()->setText("Line Chart");

$chart2->getAxes()->getLeft()->setMinimumOffset(10);
$chart2->getAxes()->getLeft()->setMaximumOffset(10);
$chart2->getAxes()->getLeft()->setIncrement(50);
$chart2->getAxes()->getLeft()->getTitle()->setText("Count");
$chart2->getAxes()->getLeft()->getAxisPen()->setVisible(false);

$chart2->getAxes()->getBottom()->setMinimumOffset(10);
$chart2->getAxes()->getBottom()->setMaximumOffset(10);
$chart2->getAxes()->getBottom()->setIncrement(2);
$chart2->getAxes()->getBottom()->getTitle()->setText("Category");

$lines=new Line($chart2->getChart());  
$data = Array(10,50,25,175,125,200,175);
$lines->addArray($data);

$l=new Line($chart2->getChart());  

$chart2->getPanel()->getGradient()->setVisible(false);
$chart2->getPanel()->setColor(Color::WHITE());
$chart2->getWalls()->getBack()->setTransparent(true);
$chart2->getHeader()->setAlignment(StringAlignment::$NEAR);
$chart2->getLegend()->setVisible(false);

$chart2->render("chart2.png");
$rand2=rand();

print '<img src="chart2.png?rand='.$rand2.'" hspace="20">';   
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
