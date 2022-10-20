<?php
    //Includes
    include "../../../sources/TChart.php";   
             
    $tChart1 = new TChart(600,450);
      
    $area1 = new Area($tChart1->getChart()); 
    $tChart1->getSeries(0)->fillSampleValues(10); 
    $area1->setTransparency(50);
    $area1->getLinePen()->setColor($area1->getColor());        
    
    $area2 = new Area($tChart1->getChart()); 
    $tChart1->getSeries(1)->fillSampleValues(10); 
    $area2->setTransparency(50);
    $area2->getLinePen()->setColor($area2->getColor());    

    $area3 = new Area($tChart1->getChart()); 
    $area3->setColor(new Color(230,250,105));
    $yval = Array(10,20,35,5,50,10,40,55,20,60);
    $area3->addArray($yval);
    $area3->setTransparency(50);
    $area3->getLinePen()->setColor($area3->getColor());    
          
    $tChart1->render("chart1.png");
    $rand=rand();
    print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Area Transparency</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>