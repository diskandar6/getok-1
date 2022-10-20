<?php

//Includes
include "../../../sources/TChart.php";

$chart = new TChart(500,500);
$chart->getAspect()->setView3D(false);

$bar = new Bar($chart->getChart());
$values = Array(50,100,150,75,50,25,80,110);
$bar->addArray($values);

$bar->getGradient()->setVisible(true);

$chart->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Bar Series can be drawn with Gradient <p>';
print '<img src="chart1.png?rand='.$rand.'">';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Bar with Gradient</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>