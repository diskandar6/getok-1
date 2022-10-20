<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Donut Style");
        $chart1->getChart()->getAspect()->setChart3DPercent(45);

        $donut=new Donut($chart1->getChart());
        $donut->getMarks()->setVisible(false);

        // Setup the Donut
        $donut->setBevelPercent(20);
        $donut->fillSampleValues(5);

        $chart2 = new TChart(400,250);
        $chart2->getChart()->getHeader()->setText("2D Donut Style");
        
        // Changes View3D aspect
        $chart2->getChart()->getAspect()->setView3D(false);
        $chart2->getLegend()->setTextStyle(LegendTextStyle::$VALUE);

        $donut2d=new Donut($chart2->getChart());
        
        // Set Circled mode
        $donut2d->setCircled(true);
        $donut2d->fillSampleValues(5);


        $chart1->render("chart1.png");
        $chart2->render("chart2.png");
        $rand=rand();
        print '<font face="Verdana" size="2">3D Donut Style<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';          
        print '<font face="Verdana" size="2">2D Donut Style<p>';
        print '<img src="chart2.png?rand='.$rand.'">';          
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Donut Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>