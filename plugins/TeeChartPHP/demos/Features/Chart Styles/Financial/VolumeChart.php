<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Volume Style");
        $chart1->getChart()->getAspect()->setView3D(false);

        $volume=new Volume($chart1->getChart());
        $chart1->getChart()->getSeries(0)->fillSampleValues();

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Volume Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Volume Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>