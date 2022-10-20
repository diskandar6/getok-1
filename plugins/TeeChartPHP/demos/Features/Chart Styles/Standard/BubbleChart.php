<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(700,450);
        $chart1->getChart()->getHeader()->setText("Bubble Style");
        $chart1->getChart()->getAspect()->setView3D(false);
        $bubble1=new Bubble($chart1->getChart());
        addRandomData($bubble1);

        $chart2 = new TChart(700,450);
        $chart2->getChart()->getHeader()->setText("UnClipped Bubble Style");
        $chart2->getChart()->getAspect()->setView3D(false);
        $chart2->getChart()->getLegend()->setVisible(false);
        $chart2->getAspect()->setClipPoints(false);
        $chart2->getAxes()->getLeft()->setVisible(false);
        $chart2->getAxes()->getBottom()->setVisible(false);
        $chart2->getWalls()->getBack()->setVisible(false);
        $bubble2=new Bubble($chart2->getChart());
        $bubble2->getMarks()->setVisible(true);
        $bubble2->getMarks()->setTransparent(true);  
        addRandomData($bubble2);

        $chart3 = new TChart(700,450);
        $chart3->getChart()->getHeader()->setText("Bubble Style");
        $chart3->getChart()->getAspect()->setView3D(false);
        $bubble3=new Bubble($chart3->getChart());
        $bubble3->getPointer()->getPen()->setVisible(false);
        addRandomData($bubble3);

        $chart1->render("chart1.png");
        $chart2->render("chart2.png");
        $chart3->render("chart3.png");

        $rand=rand();
        print '<font face="Verdana" size="2">Bubble Series Style<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';        
        print '<font face="Verdana" size="2">UnClipped Bubble Series Style<p>';
        print '<img src="chart2.png?rand='.$rand.'"><p>';        
        print '<font face="Verdana" size="2">Bubble with some modifications<p>';
        print '<img src="chart3.png?rand='.$rand.'"><p>';        
        
        function addRandomData($s) {
          // Add random bubble data
          for ($i=0;$i<=6;$i++)  {
            $x=rand(0,10);
            $y=rand(1,100);
            $radius=rand(10,60);
            $s->addBubble($x,$y,$radius,"");
          }
        }
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