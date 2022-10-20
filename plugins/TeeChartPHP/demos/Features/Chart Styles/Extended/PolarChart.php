<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getAspect()->setView3D(false);
        $chart1->getChart()->getHeader()->setText("Polar Style");

        $chart1->getHeader()->getFont()->setColor(Color::WHITE());        
        $chart1->getPanel()->setColor(Color::fromRgb(23,71,153));
        $chart1->getPanel()->getGradient()->setVisible(false);
        
        $polar = new Polar($chart1->getChart());
        $polar2 = new Polar($chart1->getChart());
        
        $polar->fillSampleValues(15);
        $polar2->fillSampleValues(15);
        $polar->setTransparency(40);
        $polar2->setTransparency(40);
        
        $chart1->getLegend()->getFont()->setColor(Color::WHITE());
        $chart1->getLegend()->setTransparent(true);
        
        $polar->setColor(Color::ORANGE());
        $polar2->setColor(Color::CYAN());
        $polar->setCircled(true);
        $polar2->setCircled(true);
        
        $polar->getVertAxis()->getGrid()->setVisible(false);
        $polar->getHorizAxis()->getGrid()->setVisible(false);
        
        $polar2->getPointer()->setVisible(false);  
        $polar->getPointer()->setVisible(false);  
        
        $chart1->getLegend()->getTitle()->setVisible(true);
        $chart1->getLegend()->getTitle()->setText("Title");
        $chart1->getHeader()->setVisible(false);
        $chart1->getAxes()->getLeft()->setVisible(true);        
        $chart1->getAxes()->getRight()->setVisible(true);
        $chart1->getAxes()->getTop()->setVisible(true);        
        $chart1->getAxes()->getBottom()->setVisible(true);        
        $chart1->getAxes()->getLeft()->getLabels()->getFont()->setColor(Color::WHITE());
        $chart1->getAxes()->getTop()->getLabels()->getFont()->setColor(Color::WHITE());
        $chart1->getAxes()->getBottom()->getLabels()->getFont()->setColor(Color::WHITE());
        $chart1->getAxes()->getRight()->getLabels()->getFont()->setColor(Color::WHITE());
        $chart1->getAxes()->getLeft()->getAxisPen()->setColor(Color::WHITE());
        $chart1->getAxes()->getTop()->getAxisPen()->setColor(Color::WHITE());
        $chart1->getAxes()->getBottom()->getAxisPen()->setColor(Color::WHITE());
        $chart1->getAxes()->getRight()->getAxisPen()->setColor(Color::WHITE());
        
        $polar->setCircleLabels(true);
        $polar->getCircleLabelsFont()->setColor(Color::WHITE());
        
        //$polar->setCircleLabelsInside(true);
        //$polar->setCircleLabelsRotated(true);
                
        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Polar Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Polar Chart</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>
