<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);

        $chart1->getChart()->getHeader()->setText("Low Function");
        $chart1->getChart()->getAspect()->setView3D(false);

        $bar=new Bar($chart1->getChart());
        $bar->marks->transparent=true;
        $bar->fillSampleValues(5);
        $bar->setColor(new Color(182,130,142));

        // Adds Low function
        $line = new Line($chart1->getChart());
        $line->setColor(new Color(255,50,0));
        $line->getMarks()->setVisible(true);
        $low = new Low();
        $low->setChart($chart1->getChart());
        $low->setPeriod(0); // all points
        $line->setDataSource($bar);
        $line->setColor(Color::BLUE());
        $line->setFunction($low);

        /* TODO
        if ($this->cbPeriod->Checked) {
          $chart1->getSeries(1)->getFunction(0)->setPeriod(2);
        }
        else {
          $chart1->getSeries(1)->getFunction(0)->setPeriod(0); // all points
        }  */

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Low Function Chart<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Low Function Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>