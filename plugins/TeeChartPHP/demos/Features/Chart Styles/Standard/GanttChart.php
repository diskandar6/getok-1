<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(800,450);
        $chart1->getChart()->getHeader()->setText("Gantt Style");
        $chart1->getChart()->getAspect()->setChart3DPercent(10);
        $gantt=new Gantt($chart1->getChart());

        // Add Gantt data using doubles for date values
        $today = gettimeofday(true);
        $days7 = 7 * 86400;
        $days2 = 2 * 86400;
        $end_date = $today + $days7;
        $end_task2= $end_date + $days7 ;

        //$chart1->getSeries(0)->fillSampleValues();

        /* Another way to add data ..
        $chart1->getSeries(0)->addGantt(40000,80003,1,"Task 1",new Color(255,0,0));
        $chart1->getSeries(0)->addGantt(48003,98558,3,"Task 2",new Color(100,0,0));
        */

        $gantt->addGantt($today,$end_date,0,"Task 1"); //,new Color(155,155,200));
        $gantt->addGantt($today+$days2,$end_date+$days2,1,"Task 2");//,new Color(155,155,100));
        $gantt->addGantt($end_date,($end_date+$days7+$days7),2,"Task 3");//,new Color(255,20,0));
        $gantt->addGantt($today+$days2,($end_date+$days7+$days2),3,"Task 4");//,new Color(255,20,0));

        $gantt->getPointer()->getPen()->setVisible(false);
        
        ColorPalettes::_applyPalette($chart1->getChart(),Theme::getPastelsPalette());
        
        $gantt->getPointer()->setVertSize(8);
        $gantt->getMarks()->setVisible(true);
        $gantt->getMarks()->setTransparent(true);
        
        // Add Gantt data using DateTime for date values
        // TODO   $this->gantt->addGantt($x,$y,$radius,"",new Color(155,155,200));

        $chart1->getAxes()->getBottom()->getLabels()->setAngle(90);
        
        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Gantt Series Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';          
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Gantt Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>