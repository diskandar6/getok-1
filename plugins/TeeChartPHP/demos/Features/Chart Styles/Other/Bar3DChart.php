<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Bar3D Style");
   	    $bar3D = new Bar3D($chart1->getChart());

        $chart1->setAutoRepaint(false);
	      $bar3D->addBar(0,10,0,"");
	      $bar3D->addBar(1,20,10,"");
  	    $bar3D->addBar(2,30,20,"");
        $chart1->setAutoRepaint(true);

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Bar3D Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Bar3D Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>