<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Candle Style");
        $chart1->getChart()->getAspect()->setView3D(false);
        // Clip Series points
        $chart1->getChart()->getAspect()->setClipPoints(true);
        $chart1->getChart()->getLegend()->setVisible(false);

        // Add Candle data using doubles for date values
        $today = gettimeofday(true);
        $day = 86400;
        $hour = 3600;

        $chart1->getAxes()->getBottom()->setIncrement(DateTimeStep::$ONEMINUTE);
        $chart1->getAxes()->getBottom()->getLabels()->setDateTimeFormat('H:i:s');
        $chart1->getAxes()->getBottom()->getLabels()->setAngle(90);
        $candle=new Candle($chart1->getChart());

        $chart1->setAutoRepaint(false);
        for ($i=$today;$i<($today+$hour);$i+=60) {
          $candle->addCandle($i,rand(0,100),rand(0,100),rand(0,100),rand(0,100));
        }
        $chart1->setAutoRepaint(true);
        $chart1->doInvalidate();

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Candle Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Candle Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>