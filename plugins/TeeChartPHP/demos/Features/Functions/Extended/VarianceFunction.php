<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);

        $chart1->getChart()->getHeader()->setText("Variance Function");

        // Aspect
        $chart1->getAspect()->setView3D(false);
        $chart1->getAspect()->setChart3DPercent(15);
        $chart1->getLegend()->getFont()->setSize(12);

        // Axis settings
        $axis = $chart1->getAxes()->getBottom();
        $axis->getGrid()->setVisible(false);
        $axis->getMinorTicks()->setLength(3);
        $axis->getMinorTicks()->setColor(Color::BLACK());
        $axis->getTicksInner()->setLength(6);
        $axis->getTicksInner()->setColor(Color::BLACK());
        $axis->getTicks()->setLength(0);

        $axis = $chart1->getAxes()->getLeft();
        $axis->getGrid()->setColor(Color::SILVER());
        $axis->getGrid()->setStyle(DashStyle::$SOLID);
        $axis->getMinorTicks()->setLength(3);
        $axis->getMinorTicks()->setColor(Color::BLACK());
        $axis->getTicks()->setLength(5);

        $points=new Points($chart1->getChart());
        $points->fillSampleValues();

        // Adds Variance function
        $line = new Line($chart1->getChart());
        $line->getMarks()->setVisible(false);
        $variance = new Variance();
        $variance->setChart($chart1->getChart());
        $variance->setPeriod(0);
        $line->setDataSource($points);
        $line->setColor(new Color(237,28,36));
        $line->setVerticalAxis(VerticalAxis::$RIGHT);
        $line->setFunction($variance);

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Variance Function Chart<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Variance Function Charts - Extended</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>