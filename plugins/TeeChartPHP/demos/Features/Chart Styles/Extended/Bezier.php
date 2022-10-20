<?php
        //Includes
        include "../../../../sources/TChart.php";
       
        $chart1 = new TChart(600,450);

        //$chart1->getPanel()->getGradient()->setVisible(false);
        $chart1->getPanel()->getGradient()->setStartColor(Color::SILVER());
        $chart1->getPanel()->getGradient()->setEndColor(Color::WHITE());
        $chart1->getWalls()->getBack()->setTransparent(false);
        $chart1->getWalls()->getBack()->setColor(Color::WHITE_SMOKE());
        $chart1->getWalls()->getBack()->getPen()->setVisible(true);
        $chart1->getWalls()->getBack()->getPen()->setColor(Color::SILVER());
        
        $chart1->getLegend()->setAlignment(LegendAlignment::$BOTTOM);
        $chart1->getLegend()->setTopLeftPos(0);
        
        $chart1->getPanel()->setMarginRight(10);
        $chart1->getPanel()->setMarginTop(10);

        $chart1->getAspect()->setView3D(false);
        $chart1->getChart()->getHeader()->setText("Bezier Style");
        
        $chart1->getAxes()->getLeft()->getGrid()->setVisible(false);
        $chart1->getAxes()->getLeft()->getAxisPen()->setVisible(false);
        $chart1->getAxes()->getBottom()->getAxisPen()->setVisible(false);

        $bezier = new Bezier($chart1->getChart());
        $bezier->getLinePen()->setColor($bezier->getColor());
        $bezier->getLinePen()->setWidth(3);

        $bezier->getPointer()->setVertSize(3);
        $bezier->getPointer()->setHorizSize(3);        
        $bezier->getPointer()->setStyle(PointerStyle::$CIRCLE);
        $bezier->getPointer()->getPen()->setVisible(false);
        $bezier->getPointer()->setHorizSize(5);
        $bezier->getPointer()->setVertSize(5);
        
        $bezier->add(245);
        $bezier->add(155);
        $bezier->add(150);
        $bezier->add(35);
        $bezier->add(90);
        $bezier->add(130);
        
        $bezier->setNumBezierPoints(5);
        
        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Bezier Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Bezier Chart</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>