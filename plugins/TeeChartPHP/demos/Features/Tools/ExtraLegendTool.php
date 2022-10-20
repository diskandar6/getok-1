<?php
        //Includes
        include "../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("ExtraLegend Tool Demo");

        // Add Series to the Chart
        $area = new Area($chart1->getChart());
        $area->add(100);
        $area->add(150);
        $area->add(120);
        $area->add(90);
        $area->add(105);

        $bar = new Bar($chart1->getChart());
        $bar->add(34);
        $bar->add(45);
        $bar->add(70);
        $bar->add(60);
        $bar->add(40);

        // Add the Extra Legend Tool
        $extraLegend = new ExtraLegend($chart1->getChart());
        $extraLegend->setSeries($bar);
        $extraLegend->getLegend()->setLeft(350);
        $extraLegend->getLegend()->setTop(150);

        // Set Values style for the default Legend
        $chart1->getLegend()->setLegendStyle(LegendStyle::$VALUES);

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">ExtraLegend Tool<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>ExtraLegend Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>