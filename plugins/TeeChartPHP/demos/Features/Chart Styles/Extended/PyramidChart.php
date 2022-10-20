<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Pyramid Style");
        $chart1->getAspect()->setChart3DPercent(45);
        $pyramid = new Pyramid($chart1->getChart());
        $pyramid->fillSampleValues(6);

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Pyramid Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Pyramid  Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>