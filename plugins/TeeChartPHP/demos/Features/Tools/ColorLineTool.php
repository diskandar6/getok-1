<?php
        //Includes
        include "../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("ColorLine Tool Demo");

        // Add Series to the Chart
        $bar = new Bar($chart1->getChart());
        $bar->add(100);
        $bar->add(150);
        $bar->add(120);
        $bar->add(90);
        $bar->add(105);
        $bar->setColorEach(true);

        // Adding ColorLineTool
        $chart1->getChart()->getTools()->add(new ColorLine());
        $chart1->getChart()->getTools()->getTool(0)->setAxis($chart1->getChart()->getAxes()->getLeft());
        $chart1->getChart()->getTools()->getTool(0)->setValue(100);

        $chart1->doInvalidate();
/* TODO

        $this->EditValue->setText("100");
        $this->EditPenWidth->setText("1");

               function EditPenWidthSubmit($sender, $params)
               {
                  $c = $this->TChartObj1->Chart->getChart();
                  $c->getTools()->getTool(0)->getPen()->setWidth($this->EditPenWidth->getText());
               }

               function cbBehindClick($sender, $params)
               {
                  $c = $this->TChartObj1->Chart->getChart();
                  $c->getTools()->getTool(0)->setDrawBehind($this->cbBehind->getChecked());
               }

               function EditValueSubmit($sender, $params)
               {
                  $c = $this->TChartObj1->Chart->getChart();
                  $c->getTools()->getTool(0)->setValue($this->EditValue->getText());
               }
*/

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">ColorLine Tool<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';         
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>ColorLine Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>