<?php
        //Includes
        require "../../../../sources/TChart.php";

        $chart1 = new TChart(700,450);
        $chart1->getChart()->getHeader()->setText("Area Style");
        $chart1->getChart()->getAspect()->setChart3DPercent(10);

        $area=new Area($chart1->getChart());
        $chart1->getChart()->getSeries(0)->fillSampleValues(5);
        $chart1->getChart()->getSeries(0)->getXValues()->setDateTime(true);
        $chart1->getChart()->getAxes()->getBottom()->getLabels()->setAngle(45);
        $chart1->doInvalidate();

        $chart2 = new TChart(700,450);
        $chart2->getChart()->getHeader()->setText("Horiz Area Style");
        $horizArea=new HorizArea($chart2->getChart());
        $chart2->getChart()->getSeries(0)->fillSampleValues(5);

        $chart3 = new TChart(700,450);
        $chart3->getChart()->getHeader()->setText("2D Area Style");
        $chart3->getChart()->getLegend()->setVisible(false);
        $chart3->getChart()->getAspect()->setView3D(false);
        $chart3->getChart()->getPanel()->setMarginRight(10);
        $chart3->getChart()->getPanel()->getGradient()->setVisible(false);
        $chart3->getChart()->getPanel()->setColor(Color::getWhite());
        $chart3->getChart()->getAxes()->getLeft()->getTitle()->setText("Axis Title");
        $chart3->getChart()->getAxes()->getBottom()->getTitle()->setText("Axis Title");

        for ($i=0;$i<4;$i++) {
          $chart3->getChart()->addSeries(new Area($chart3->getChart()));
          $chart3->getChart()->getSeries($i)->fillSampleValues(15);
          // TODO Stacked
        }
        
        $chart1->render("chart1.png");
        $chart2->render("chart2.png");
        $chart3->render("chart3.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Vertical Area Style<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';           
        print '<font face="Verdana" size="2">Horizontal Area Style<p>';
        print '<img src="chart2.png?rand='.$rand.'"><p>';           
        print '<font face="Verdana" size="2">Multiple 2D Area Style<p>';
        print '<img src="chart3.png?rand='.$rand.'"><p>';           
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Line Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>
