<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Error Style");
        $chart1->getAspect()->setView3D(false);
        $error = new ErrorSeries($chart1->getChart());

        $error->addXYErrorColor(0,10,100,null);
        $error->addXYErrorColor(1,20,200,null);
        $error->addXYErrorColor(2,30,300,null);
        $error->addXYErrorColor(3,40,400,null);
        
        $error->setColorEach(true);
        $error->getErrorPen()->setWidth(3);
        
        $chart1->render("chart1.png");                                                   
        $rand=rand();
        print '<font face="Verdana" size="2">Error Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Error Chart</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>  
