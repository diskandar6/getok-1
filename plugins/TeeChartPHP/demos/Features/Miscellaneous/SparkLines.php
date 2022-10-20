<?php
        //Includes
        include "../../../sources/TChart.php";
        $rand=rand();
        
        // Chart1

        $chart1 = new TChart(150,40);
        $chart1->getChart()->getHeader()->setVisible(false);
        $chart1->getChart()->getAxes()->setVisible(false);
        $chart1->getChart()->getWalls()->setVisible(false);
        $chart1->getChart()->getLegend()->setVisible(false);
        $chart1->getChart()->getAspect()->setView3D(false);

        $fline = new FastLine($chart1->getChart());
        $fline->setColor(Color::GRAY());
        $fline->fillSampleValues(70);

        // Chart2

        $chart2 = new TChart(150,40);
        $chart2->getChart()->getHeader()->setVisible(false);
        $chart2->getChart()->getAxes()->setVisible(false);
        $chart2->getChart()->getWalls()->setVisible(false);
        $chart2->getChart()->getLegend()->setVisible(false);
        $chart2->getChart()->getAspect()->setView3D(false);
        $chart2->getChart()->getPanel()->getGradient()->setVisible(false);
        $chart2->getChart()->getAspect()->setView3D(false);
        $chart2->getChart()->getPanel()->setColor(Color::WHITE());

        $fline = new FastLine($chart2->getChart());
        $fline->setColor(Color::GRAY());
        $fline->fillSampleValues(70);
        $points = new Points($chart2->getChart());
        $points->setColorEach(true);
        $points->addXYText(5, $chart1->getSeries(0)->getYValues()->getValue(5),
                $chart1->getSeries(0)->getYValues()->getValue(5));
        $points->addXYText(65, $chart1->getSeries(0)->getYValues()->getValue(65),
                $chart1->getSeries(0)->getYValues()->getValue(65));
        $points->getPointer()->setHorizSize(1);
        $points->getPointer()->setVertSize(1);
        $points->getPointer()->getPen()->setVisible(false);
        $chart2->doInvalidate();

        // Chart3        

        $chart3 = new TChart(150,40);
        $chart3->getPanel()->getBrush()->loadImageFromFile("blackGlass.png");
        $chart3->getChart()->getHeader()->setVisible(false);
        $chart3->getChart()->getAxes()->setVisible(false);
        $chart3->getChart()->getWalls()->setVisible(false);
        $chart3->getChart()->getLegend()->setVisible(false);
        $chart3->getChart()->getAspect()->setView3D(false);

        $histo = new Histogram($chart3->getChart());
        $histo->setColor(Color::RED());
        $histo->getLinePen()->setVisible(false);
        $histo->fillSampleValues(50);

        // Render
        
        $chart1->render("chart1.png");
        print '<font face="Verdana" size="2">SparkLines<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 

        $chart2->render("chart2.png");
        print '<font face="Verdana" size="2">SparkLines<p>';
        print '<img src="chart2.png?rand='.$rand.'"><p>';                 
        
        $chart3->render("chart3.png");
        print '<font face="Verdana" size="2">SparkLines<p>';
        print '<img src="chart3.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>SparkLines</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>