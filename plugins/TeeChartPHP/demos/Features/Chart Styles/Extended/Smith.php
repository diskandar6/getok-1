<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getAspect()->setView3D(false);
        $chart1->getChart()->getHeader()->setText("Smith Style");
        $smith = new Smith($chart1->getChart());
        $smith->add(10);
        $chart1->getPanel()->getGradient()->setVisible(false);
       // $chart1->getPanel()->setColor(Color::YELLOW());
        
        $smith->getCirclePen()->setVisible(true);
        $smith->getCirclePen()->setWidth(2);
        $smith->getCirclePen()->setColor(Color::YELLOW());
        
        $smith->getRCirclePen()->setVisible(true);
        
        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Smith Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Smith Chart</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>