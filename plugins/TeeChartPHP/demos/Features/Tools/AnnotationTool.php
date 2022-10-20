<?php
        //Includes
        include "../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Annotation Tool Demo");

        // Two ways to add an annotation tool

        // First way
        $chart1->getChart()->getTools()->add(new Annotation());
        $chart1->getChart()->getTools()->getTool(0)->setText("Annotation");


        // Another way
        $tool=new Annotation($chart1->getChart());
        $tool->getShape()->setCustomPosition(true);
        $tool->setTop(rand(10, 200));
        $tool->setLeft(rand(10, 200));
        $tool->setText("Random Text ");

        // Setting alignment
        //$tool->setPosition(AnnotationPosition::$RIGHTBOTTOM);

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Annotation Tool<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';         
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Annotation Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>