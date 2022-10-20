<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);

        $chart1->getChart()->getHeader()->setText("Average Function");
        $chart1->getChart()->getAspect()->setView3D(false);

        $bar=new Bar($chart1->getChart());
        $bar->fillSampleValues(5);
        $bar->setColorEach(true);

        // Adds Average function
        $line = new Line($chart1->getChart());
        $average = new Average();
        $average->setChart($chart1->getChart());
        $average->setPeriod(0); // all points
        $line->setDataSource($bar);
        $line->setColor(new Color(237,28,36));
        $line->setFunction($average);

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Average Function Chart<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Average Function Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>