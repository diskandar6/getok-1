<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Add Function");
        $chart1->getChart()->getAspect()->setView3D(false);

        $bar=new Bar($chart1->getChart());
        $bar->fillSampleValues(6);
        $bar->setColorEach(true);

        // Adds Add function
        $line = new Line($chart1->getChart());
        $line->getPointer()->setVisible(true);
        $line->getPointer()->setColor(new Color(255,100,0));
        $line->getMarks()->setVisible(true);
        $add = new Add();
        $add->setChart($chart1->getChart());
        $line->setDataSource($bar);
        $line->setColor(new Color(237,28,36));
        $line->setFunction($add);

// TODO       if ($cbPeriod->Checked) {
          $chart1->getSeries(1)->getFunction(0)->setPeriod(2);
//        }
//        else {
//          $chart->getSeries(1)->getFunction(0)->setPeriod(0); // all points
//        }

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Add Function Chart<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Add Function Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>