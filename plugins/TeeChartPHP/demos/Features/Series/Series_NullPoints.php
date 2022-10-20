<?php

//Includes
include "../../../sources/TChart.php";

$chart = new TChart(500,500);
$chart->getAspect()->setView3D(false);

$line = new Line($chart->getChart());
$line->add(10);
$line->add(15);
$line->add(30);
$line->addNull();
$line->add(10);
$line->add(60);
$line->add(30);
$line->addNull();
$line->add(15);
$line->add(30);
$line->add(12);
$line->add(5);

$chart->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Line with Null Points <p>';
print '<img src="chart1.png?rand='.$rand.'">';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Line with Null Points</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>