<?php
        //Includes
        include "../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Custom Axes Demo");
        $chart1->getAspect()->setView3D(false);

        $line1 = new Line($chart1->getChart());
        $line2 = new Line($chart1->getChart());
        $line1->setColor(Color::RED());
        $line2->setColor(Color::GREEN());
        $chart1->addSeries($line1);
        $chart1->addSeries($line2);

        // Speed optimization
        $chart1->getChart()->setAutoRepaint(false);

        for($t = 0; $t <= 10; ++$t) {
          $line1->addXY($t, (10 + $t), Color::RED());
          if($t > 1) {
            $line2->addXY($t, $t, Color::GREEN());
          }
        }
//        $chart1->getChart()->setAutoRepaint(true);

        $chart1->getAxes()->getLeft()->setStartPosition(0);
        $chart1->getAxes()->getLeft()->setEndPosition(50);        
        $chart1->getAxes()->getLeft()->getAxisPen()->color = Color::RED();
        $chart1->getAxes()->getLeft()->getTitle()->getFont()->setColor(Color::RED());
        $chart1->getAxes()->getLeft()->getTitle()->getFont()->setBold(true);
        $chart1->getAxes()->getLeft()->getTitle()->setText("1st Left Axis");

        $chart1->getAxes()->getTop()->getLabels()->setAngle(45);
        $chart1->getAxes()->getTop()->getTitle()->getFont()->setColor(Color::YELLOW());
        $chart1->getAxes()->getTop()->getTitle()->getFont()->setBold(true);

        $chart1->getAxes()->getBottom()->getLabels()->setAngle(0);
        $chart1->getAxes()->getRight()->getLabels()->setAngle(45);
        $chart1->getAxes()->getBottom()->getTitle()->getFont()->setColor(new Color(255,25,25));
        $chart1->getAxes()->getBottom()->getTitle()->getFont()->setBold(true);
        $chart1->getAxes()->getRight()->getTitle()->getFont()->setColor(Color::BLUE());
        $chart1->getAxes()->getRight()->getTitle()->getFont()->setBold(true);
        $chart1->getAxes()->getRight()->getTitle()->setText("OtherSide Axis");
        $chart1->getAxes()->getRight()->getLabels()->getFont()->setColor(Color::BLUE());
        $chart1->getAxes()->getRight()->getAxisPen()->setColor(Color::BLUE());        

        $chart1->getAxes()->getTop()->getTitle()->setText("Top Axis");
        $chart1->getAxes()->getBottom()->getTitle()->setText("Bottom Axis");

        $line1->setHorizontalAxis(HorizontalAxis::$BOTH);
        $line1->setVerticalAxis(VerticalAxis::$BOTH);

        $axis1 = new Axis(false, false, $chart1->getChart());
        $chart1->getAxes()->getCustom()->add($axis1);
        $line2->setCustomVertAxis($axis1);
        $axis1->setStartPosition(50);
        $axis1->setEndPosition(100);
        $axis1->getTitle()->getFont()->setColor(Color::GREEN());        
        $axis1->getTitle()->getFont()->setBold(true);
        $axis1->getTitle()->setText("Extra Axis");
        $axis1->getTitle()->setAngle(90);
        $axis1->setRelativePosition(20);
        $axis1->getAxisPen()->setColor(Color::GREEN());
        $axis1->getGrid()->setVisible(false);

            
//        $chart1->doInvalidate();

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">This Chart uses Custom Axes and OtherSide Axes.<p>';
        print '<img src="chart1.png?rand='.$rand.'">';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Custom Axes Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>