<?php
    //Includes
    include "../../../sources/TChart.php";           
             
    $tChart1 = new TChart(600,450);
      
    $tChart1->getAspect()->setView3D(false);
    $tChart1->getPanel()->getGradient()->setVisible(true);
    $tChart1->getPanel()->getGradient()->setEndColor(Color::GRAY());
    
    // Set Legend to custom position                                  
    $tChart1->getLegend()->setCustomPosition(true);
    $tChart1->getLegend()->setTop(70);
    $tChart1->getLegend()->setLeft(70);

    //You could add the Series at runtime  
    $area1 = new Area($tChart1->getChart()); 
    $bar1 = new Bar($tChart1->getChart()); 
    $line1 = new Line($tChart1->getChart()); 
    $line2 = new Line($tChart1->getChart()); 
    
    //Use Series common properties  
    $tChart1->getSeries(0)->fillSampleValues(10); 
    $tChart1->getSeries(1)->fillSampleValues(10); 
    $tChart1->getSeries(2)->fillSampleValues(10); 
    $tChart1->getSeries(3)->fillSampleValues(10); 

    $area1->setColor(new Color(230,250,105));
    $area1->getLinePen()->setVisible(false);
    
    $bar1->setColor(new Color(100,155,255));
    $bar1->getMarks()->setColor(Color::WHITE());
    $bar1->getMarks()->getPen()->setVisible(false);
    $bar1->getMarks()->getArrow()->setVisible(false);
    $bar1->getPen()->setVisible(false);
           
    $line1->setColor(Color::RED());
    $line2->setColor(Color::FUCHSIA());
    
    $bar1->setBarStyle(BarStyle::$PYRAMID);
    //Modify Line specific properties  
    $line1->setStairs(true); //Set line to Stairs  
    $line1->getLinePen()->setColor(Color::BLUE()); //LineSeries bounding lines colour  
    
    $tChart1->getLegend()->getGradient()->setVisible(true);    
    
    $tChart1->render("chart1.png");
    $rand=rand();
    print '<img src="chart1.png?rand='.$rand.'">';                
?>