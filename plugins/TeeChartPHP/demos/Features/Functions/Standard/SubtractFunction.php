<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);

        $chart1->getChart()->getHeader()->setText("Subtract Function");
        $chart1->getChart()->getAspect()->setView3D(false);

        $bar1=new Bar($chart1->getChart());
        $bar2=new Bar($chart1->getChart());

        $bar1->marks->visible=false;
        $bar2->marks->visible=false;

        // Adding data using Array
        $myArray1=Array(2,3,5,7,1,4);
        $myArray2=Array(1,5,9,3,8,2);

        $bar1->addArray($myArray1);
        $bar2->addArray($myArray2);

        // Adds Subtract function
        $line = new Line($chart1->getChart());
        $line->getMarks()->setVisible(true);
        $line->linePen->width=3;
        $subtract = new Subtract();
        $subtract->setChart($chart1->getChart());
        $line->setDataSource(Array($bar1,$bar2));
        $line->setColor(new Color(237,28,36));
        $line->setFunction($subtract);

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Substract Function Chart<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Subtract Function Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>