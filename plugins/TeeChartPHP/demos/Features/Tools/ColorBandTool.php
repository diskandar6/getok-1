<?php
        //Includes
        include "../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("ColorBand Tool Demo");
        $chart1->getAspect()->setView3D(false);

        // Add Series to the Chart
        $bar = new Bar($chart1->getChart());
        $bar->add(100);
        $bar->add(150);
        $bar->add(120);
        $bar->add(90);
        $bar->add(105);

        // Adding ColorBandTool
        $chart1->getChart()->getTools()->add(new ColorBand());
        $chart1->getChart()->getTools()->getTool(0)->setAxis($chart1->getChart()->getAxes()->getLeft());
        $chart1->getChart()->getTools()->getTool(0)->setStart($bar->getYValues()->getMaximum() / 3);
        $chart1->getChart()->getTools()->getTool(0)->setEnd($bar->getYValues()->getMaximum() / 2);
/* TODO
        $this->EditStart->setText($chart1->getChart()->getTools()->getTool(0)->getStart());
        $this->EditEnd->setText($chart1->getChart()->getTools()->getTool(0)->getEnd());
*/

        // Another way to Add a ColorBandTool
        // $colorBand = new ColorBand($chart1->getChart());

/* TODO
               function Button1Click($sender, $params)
               {
                  $c = $this->TChartObj1->Chart->getChart();
                  $c->getTools()->getTool(0)->getBrush()->setColor(new Color(rand(0,255),
                                rand(0,255), rand(0,255)));
               }

               function EditEndSubmit($sender, $params)
               {
                  $c = $this->TChartObj1->Chart->getChart();
                  $c->getTools()->getTool(0)->setEnd($this->EditEnd->getText());
               }

               function cbBehindClick($sender, $params)
               {
                  $c = $this->TChartObj1->Chart->getChart();
                  $c->getTools()->getTool(0)->setDrawBehind($this->cbBehind->getChecked());
               }

               function EditStartSubmit($sender, $params)
               {
                  $c = $this->TChartObj1->Chart->getChart();
                  $c->getTools()->getTool(0)->setStart($this->EditStart->getText());
               }
*/

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">ColorBand Tool<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';         
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>ColorBand Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>