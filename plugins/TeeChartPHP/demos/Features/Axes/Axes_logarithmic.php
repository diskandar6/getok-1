<?php
include "../../../sources/TChart.php";     
$chart = new TChart(600,450);
$fline = new FastLine($chart->getChart());
$chart->getAxes()->getBottom()->setLogarithmic(true);
$fline->fillSampleValues(1000);
$chart->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Logarithmic Chart<p>';
print '<img src="chart1.png?rand='.$rand.'">';   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Logarithmic Chart</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>  