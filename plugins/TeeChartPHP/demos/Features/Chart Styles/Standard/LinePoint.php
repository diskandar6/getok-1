<?php
  
//Includes
include "../../../../sources/TChart.php";

$chart = new TChart(600,450);

$chart->getHeader()->setText("Line with Pointer");
$chart->getPanel()->getGradient()->setVisible(false);
$chart->getPanel()->setColor(Color::getWhite());
$chart->getAspect()->setView3D(false);

$panel=$chart->getPanel();
$panel->getBevel()->setInner(BevelStyle::$NONE);
$panel->getBevel()->setOuter(BevelStyle::$NONE);
$panel->getPen()->setColor(new Color(120,120,120));
$panel->getPen()->setVisible(true);

$line = new Line($chart->getChart());
$line->fillSampleValues(6);

$line->getLinePen()->setWidth(3);

$pointer=$line->getPointer();
$pointer->setVisible(true);
$pointer->setStyle(PointerStyle::$CIRCLE);
$pointer->getBrush()->setColor(Color::getWhite());
$pointer->getPen()->setColor($line->getColor());
$pointer->getPen()->setWidth(2);

$bAxis=$chart->getAxes()->getBottom();
$bAxis->getGrid()->setVisible(false);
$bAxis->setMinimumOffset(15);
$bAxis->setMaximumOffset(15);

$lAxis=$chart->getAxes()->getLeft();
$lAxis->getLabels()->setSeparation(100);
$lAxis->setMinimumOffset(15);
$lAxis->setMaximumOffset(15);
$chart->getPanel()->getBorderPen()->setVisible(false);

$chart->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Line with Pointer Series Style<p>';
print '<img src="chart1.png?rand='.$rand.'">';   


$chart2 = new TChart(600,450);

$chart2->getHeader()->setText("");
$chart2->getPanel()->getGradient()->setVisible(false);
$chart2->getPanel()->setColor(Color::getWhite());
$chart2->getAspect()->setView3D(false);
$chart2->getWalls()->getBack()->setTransparent(true);

$panel=$chart2->getPanel();
$panel->getBevel()->setInner(BevelStyle::$NONE);
$panel->getBevel()->setOuter(BevelStyle::$NONE);
$panel->getPen()->setColor(new Color(120,120,120));
$panel->getPen()->setVisible(true);

$line2 = new Line($chart2->getChart());
$line3 = new Line($chart2->getChart());
$line4 = new Line($chart2->getChart());

$line2->setTitle("Bicycle");
$line3->setTitle("Car");
$line4->setTitle("Train");

$line2->addYText(2,'January');
$line2->addYText(6,'February');
$line2->addYText(13,'March');
$line2->addYText(25,'April');

$line3->addYText(3,'January');
$line3->addYText(8,'February');
$line3->addYText(16,'March');
$line3->addYText(32,'April');

$line4->addYText(4,'January');
$line4->addYText(10,'February');
$line4->addYText(20,'March');
$line4->addYText(45,'April');

$line2->setColor(Color::fromRgb(39,82,255));
$line3->setColor(Color::fromRgb(232,0,0));
$line4->setColor(Color::fromRgb(255,155,0));

//$line2->getLinePen()->setWidth(3);
//$line3->getLinePen()->setWidth(3);
//$line4->getLinePen()->setWidth(3);

$pointer=$line2->getPointer();
$pointer->setVisible(true);
$pointer->setStyle(PointerStyle::$CIRCLE);
$pointer->getPen()->setColor($line2->getColor());
$pointer->getPen()->setWidth(2);

$pointer2=$line3->getPointer();
$pointer2->setVisible(true);
$pointer2->setStyle(PointerStyle::$CIRCLE);
$pointer2->getPen()->setColor($line3->getColor());
$pointer2->getPen()->setWidth(2);

$pointer3=$line4->getPointer();
$pointer3->setVisible(true);
$pointer3->setStyle(PointerStyle::$CIRCLE);
$pointer3->getPen()->setColor($line4->getColor());
$pointer3->getPen()->setWidth(2);

$bAxis=$chart2->getAxes()->getBottom();
$bAxis->getGrid()->setVisible(false);
$bAxis->setMinimumOffset(15);
$bAxis->setMaximumOffset(15);

$lAxis=$chart2->getAxes()->getLeft();
$lAxis->getLabels()->setSeparation(100);
$lAxis->setMinimumOffset(15);
$lAxis->setMaximumOffset(15);
$chart2->getPanel()->getBorderPen()->setVisible(false);

$chart2->render("chart2.png");
$rand2=rand();
print '<img src="chart2.png?rand='.$rand2.'>';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Line Point</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>
