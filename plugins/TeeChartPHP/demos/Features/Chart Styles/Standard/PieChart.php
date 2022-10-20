<?php
        //Includes
        include "../../../../sources/TChart.php";
  
        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Pie Style");
        $chart1->getChart()->getHeader()->getFont()->setColor(new Color(255,255,255));
        $chart1->getChart()->getHeader()->setLeft(15);
        $chart1->getChart()->getHeader()->setTop(15);
        
        $chart1->getChart()->getAspect()->setView3D(false);
        $chart1->getChart()->getHeader()->setAlignment(StringAlignment::$NEAR);
        $chart1->getChart()->getLegend()->setTransparent(true);
        $chart1->getChart()->getPanel()->getGradient()->setVisible(false);
        $chart1->getChart()->getPanel()->setColor(Color::fromRgb(69,69,69));
        $chart1->getChart()->getHeader()->setCustomPosition(true);
        $chart1->getChart()->getLegend()->getFont()->setColor(Color::WHITE());
        $chart1->getChart()->getLegend()->getFont()->setSize(12);
        $chart1->getChart()->getLegend()->setCustomPosition(true);
        $chart1->getChart()->getLegend()->setTop(60);
        $chart1->getChart()->getPanel()->setMarginLeft(25);
        
        $pie=new Pie($chart1->getChart());
        $pie->getMarks()->setVisible(true);
        $pie->getMarks()->setArrowLength(-55);
        $pie->getMarks()->setTransparent(true);
        $pie->getMarks()->setStyle(MarksStyle::$PERCENT);
        $pie->getMarks()->getFont()->setColor(Color::WHITE());
        $pie->getMarks()->getFont()->setSize(10);
        $pie->getMarks()->getArrow()->setVisible(false);        
        $pie->setExplodeBiggest(25);
        $chart1->getChart()->getLegend()->setTextStyle(LegendTextStyle::$PERCENT);
        
        
        // Setup the Pie
        //$pie->setBevelPercent(20);
        $pie->setCircled(true);
        $pie->addYText(852,"Laptops");
        $pie->addYText(821,"MP3s");
        $pie->addYText(990,"Tablets");
        $pie->addYText(978,"Monitors");
        $pie->addYText(514,"Consoles");
        $pie->addYText(386,"Mobiles");
        $pie->addYText(537,"TVs");
        $pie->addYText(810,"Players");
        

        $chart2 = new TChart(400,250);
        $chart2->getChart()->getHeader()->setText("2D Pie Style");
        // Changes View3D aspect
        $chart2->getChart()->getAspect()->setView3D(false);
        $chart2->getLegend()->setTextStyle(LegendTextStyle::$VALUE);

        $pie2d=new Pie($chart2->getChart());
        // Set Circled mode
        $pie2d->setCircled(true);
        $pie2d->fillSampleValues(5);        

        $chart1->render("chart1.png");
        $chart2->render("chart2.png");
        $rand=rand();
        print '<font face="Verdana" size="2">3D Pie Style<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';          
        print '<font face="Verdana" size="2">2D Pie Style<p>';
        print '<img src="chart2.png?rand='.$rand.'">';          
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Pie Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>