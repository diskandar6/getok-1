<?php

        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,400);

        $chart1->getChart()->getHeader()->setText("Smoothing Function");
        // Aspect
        $chart1->getAspect()->setView3D(false);
        $chart1->getLegend()->getFont()->setSize(10);

        // Axis settings
        $axis = $chart1->getAxes()->getBottom();
        $axis->getGrid()->setVisible(false);
        $axis->getMinorTicks()->setColor(Color::getBlack());
        $axis->getTicksInner()->setColor(Color::getBlack());

        $axis = $chart1->getAxes()->getLeft();
        $axis->getGrid()->setColor(Color::getSilver());
        $axis->getGrid()->setStyle(DashStyle::$SOLID);
        $axis->getMinorTicks()->setLength(3);
        $axis->getMinorTicks()->setColor(Color::getBlack());
        $axis->getTicks()->setLength(5);

        $axis = $chart1->getAxes()->getRight();
        $axis->getGrid()->setColor(Color::getSilver());
        $axis->getGrid()->setStyle(DashStyle::$SOLID);
        $axis->getMinorTicks()->setColor(Color::getBlack());

        $line=new Line($chart1->getChart());
        $line->fillSampleValues(10);
        $line->setColor(new Color(155,155,155));
        $line->getPointer()->setVisible(true);
        $line->getPointer()->setStyle(PointerStyle::$TRIANGLE);

        // Adds Perimeter function
        $linef = new Line($chart1->getChart());
        $linef->getMarks()->setVisible(false);
        $linef->getLinePen()->setWidth(2);
        $smoothing = new Smoothing();
        $smoothing->setChart($chart1->getChart());
        $smoothing->setPeriod(10);
        $smoothing->setFactor(35);
        
        //$smoothing->setPeriod(0);
        $linef->setDataSource($line);
        $linef->setColor(new Color(237,28,36));
        $linef->setFunction($smoothing);

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Smoothing Function Chart<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Smoothing Function Charts - Extended</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>