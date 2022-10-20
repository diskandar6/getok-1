<?php
        //Includes
        include "../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("GridBand Tool Demo");

        // Add Series to the Chart
        $bar = new Bar($chart1->getChart());
        $bar->fillSampleValues(4);

        // Adding GridBandTool
        $chart1->getChart()->getTools()->add(new GridBand());
        $chart1->getChart()->getTools()->getTool(0)->setAxis($chart1->getChart()->getAxes()->getLeft());
        $chart1->getChart()->getTools()->getTool(0)->getBand1()->setColor(new Color(125,125,125));
        $chart1->getChart()->getTools()->getTool(0)->getBand2()->setColor(new Color(225,225,225));
        $chart1->doInvalidate();

/* TODO
               function Button1Click($sender, $params)
               {
                  $c=$this->TChartObj1->Chart;

                  $r=$this->Edit4->Text;
                  $g=$this->Edit5->Text;
                  $b=$this->Edit6->Text;

                  $c->getChart()->getTools()->getTool(0)->getBand2()->setColor(new Color($r,$g,$b));
               }


               function band1Click($sender, $params)
               {
                  $c=$this->TChartObj1->Chart;

                  $r=$this->Edit1->Text;
                  $g=$this->Edit2->Text;
                  $b=$this->Edit3->Text;

                  $c->getChart()->getTools()->getTool(0)->getBand1()->setColor(new Color($r,$g,$b));
               }

*/

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">GridBand Tool<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';                 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>GridBand Tool</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>