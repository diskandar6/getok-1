<?php

        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);

        $chart1->getChart()->getHeader()->setText("Smooth Line with Region");

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
        for ($i=0;$i<10;$i++)
          $line->addXY($i,rand(60,200));

        $line->setVisible(false);

        $line2=new Line($chart1->getChart());
        for ($i=0;$i<10;$i++)
          $line2->addXY($i,rand(10,55));
        
        $chart1->getAxes()->getLeft()->setMinMax(0,$line->getMaxYValue()+10);
        $line2->setVisible(false);
        
        // Adds Smoothing function
        $linef = new Line($chart1->getChart());
        $linef->getMarks()->setVisible(false);
        $linef->getLinePen()->setWidth(2);
        $smoothing = new Smoothing();
        $smoothing->setChart($chart1->getChart());
        $smoothing->setPeriod(4);
        $smoothing->setFactor(35);
        
        $linef->setDataSource($line);
//        $linef->setColor(new Color(237,28,36));
        $linef->setColor(Color::ORANGE());
        $linef->setFunction($smoothing);
        
        // Adding ColorBandTool
        $tool=new SeriesBand($chart1->getChart());
        $tool->setSeries($linef);

        $chart1->getChart()->getTools()->add($tool);
        $tool->getBrush()->setVisible(true);
        $tool->getBrush()->setColor(Color::ORANGE());
        $tool->getBrush()->setTransparency(75);   
        $linef->getShadow()->setVisible(true);
        $linef->getShadow()->setHorizSize(2);
        $linef->getShadow()->setVertSize(2);

        // Adds Smoothing function
        $linef2 = new Line($chart1->getChart());
        $linef2->getMarks()->setVisible(false);
        $linef2->getLinePen()->setWidth(2);
        $smoothing2 = new Smoothing();
        $smoothing2->setChart($chart1->getChart());
        $smoothing2->setPeriod(4);
        $smoothing2->setFactor(35);
        
        $linef2->setDataSource($line2);
//        $linef2->setColor(new Color(237,28,36));
        $linef2->setColor(Color::BLUE());
        $linef2->setFunction($smoothing2);
        
        // Adding ColorBandTool
        $tool2=new SeriesBand($chart1->getChart());
        $tool2->setSeries($linef2);

        $chart1->getChart()->getTools()->add($tool2);
        $tool2->getBrush()->setVisible(true);
        $tool2->getBrush()->setColor(Color::BLUE());
        $tool2->getBrush()->setTransparency(75);   
        $linef2->getShadow()->setVisible(true);
        $linef2->getShadow()->setHorizSize(2);
        $linef2->getShadow()->setVertSize(2);
                   
        $chart1->getLegend()->setVisible(false);        
                   
        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Smooth Line with Region<p>';
        print '<img src="chart1.png?rand='.$rand.'">';          
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Smooth Line with Region</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>