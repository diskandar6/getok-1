<?php
        //Includes
        include "../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("SeriesBand Tool Example");
        $chart1->getAspect()->setView3D(false);        
        
        // Add Series to the Chart
        $line1 = new Line($chart1->getChart());
        $line2 = new Line($chart1->getChart());

        $line1->fillSampleValues(8);
        
        for ($i=0; $i<$line1->getCount(); $i++) {
            $line2->addXY($line1->getXValues()->getValue($i),
                    $line1->getYValues()->getValue($i) / 2.0);
        }
        
        $line1->getLinePen()->setWidth(3);
        $line2->getLinePen()->setWidth(3);
               
        // Adding ColorBandTool
        $tool=new SeriesBand($chart1->getChart());
        $tool->setSeries($line1);
        $tool->setSeries2($line2);
        

        $chart1->getChart()->getTools()->add($tool);
        $tool->getBrush()->setVisible(true);
        $tool->getBrush()->setColor(Color::ORANGE());
        $tool->getBrush()->setTransparency(75);
               
        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">SeriesBand Tool<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>SeriesBand Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>