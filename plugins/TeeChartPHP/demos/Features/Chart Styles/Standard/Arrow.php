<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(820,420);
        $chart1->getChart()->getHeader()->setText("Arrow Style");

        if(isset($_POST["view3D"]))
          $chart1->getChart()->getAspect()->setView3D(true);
        else
          $chart1->getChart()->getAspect()->setView3D(false);
        
        $chart1->getChart()->getAxes()->getLeft()->getMinorGrid()->setVisible(false);
        $chart1->getChart()->getAxes()->getBottom()->getMinorGrid()->setVisible(false);

        // Add Arrow Series
        $arrow=new Arrow($chart1->getChart());

        $arrow->fillSampleValues(10);
        $arrow->getPointer()->setVertSize(15);
        $arrow->getPointer()->setHorizSize(15);
        $arrow->setColorEach(true);
        
        $chart1->getLegend()->getSymbol()->setSquared(true);
        $chart1->getLegend()->setAlignment(LegendAlignment::$BOTTOM);
        
        /* Way to add Arrow points
        
        $arrow->AddArrow(0,0,1,3,"",null);
        $arrow->AddArrow(1,1,1,13,"",null);
        $arrow->AddArrow(2,2,2,15,"",null);
        $arrow->AddArrow(3,13,3,25,"",null);
        $arrow->AddArrow(4,10,5,35,"",null);
        
        */

        $chart1->render("chart1.png");                    
        $rand=rand();
        print '<font face="Verdana" size="2">Arrow Series<p>';
        print '<img src="chart1.png?rand='.$rand.'">';            
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Arrow Chart</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
  <form method="post" action="Arrow.php">
  View 3D: <input type="checkbox" name="view3D" value="view3D"  /><br />
  <input type="submit" value="Refresh !">
  </form>
  </font>
</body>
</html>
