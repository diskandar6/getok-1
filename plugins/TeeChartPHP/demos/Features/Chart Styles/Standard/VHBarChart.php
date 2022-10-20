
<?php
        //Includes
        include "../../../../sources/TChart.php";            

        if(isset($_POST["barStyle"]))
          $barStyle = $_POST["barStyle"];
          
        $chart1 = new TChart(700,450);

        $chart1->getChart()->getHeader()->setText("Bar Style");
        $chart1->getChart()->getAspect()->setChart3DPercent(30);

        $bar=new Bar($chart1->getChart());
        $chart1->getChart()->getSeries(0)->setColorEach(true);
        $chart1->getChart()->getSeries(0)->fillSampleValues(10);
        $chart1->getPanel()->setColor(Color::getWHITE());

        if(isset($_POST["barStyle"])) {
          switch ($barStyle) {
          case 0:
            $bar->setBarStyle(BarStyle::$RECTANGLE);
            $bar->getPen()->setVisible(true);
            break;
          case 1:
            $bar->setBarStyle(BarStyle::$CYLINDER);
            $bar->getPen()->setVisible(false);
            break;
          case 2:
            $bar->setBarStyle(BarStyle::$ARROW);
            $bar->getPen()->setVisible(false);
            break;
          case 3:
            $bar->setBarStyle(BarStyle::$CONE);
            $bar->getPen()->setVisible(false);
            break;
          case 4:
            $bar->setBarStyle(BarStyle::$ELLIPSE);
            $bar->getPen()->setVisible(false);
            break;
          case 5:
            $bar->setBarStyle(BarStyle::$INVARROW);
            $bar->getPen()->setVisible(false);
            break;
          case 6:
            $bar->setBarStyle(BarStyle::$PYRAMID);
            $bar->getPen()->setVisible(false);
            break;
          case 7:
            $bar->setBarStyle(BarStyle::$INVPYRAMID);
            $bar->getPen()->setVisible(false);
            break;
          }
        }
        else
        {
            $bar->setBarStyle(BarStyle::$RECTANGLE);
            $bar->getPen()->setVisible(true);
        }
        
        $chart2 = new TChart(700,450);
        $chart2->getChart()->getHeader()->setText("HorizBar Style");
        $horizBar=new HorizBar($chart2->getChart());
        $chart2->getChart()->getSeries(0)->setColorEach(true);
        $chart2->getChart()->getSeries(0)->fillSampleValues(5);

        $chart3 = new TChart(700,450);
        $chart3->getChart()->getHeader()->setText("Bar Style");
        $chart3->getChart()->getAspect()->setView3D(false);
        $chart3->getChart()->getPanel()->setMarginTop(5);
        $chart3->getChart()->getLegend()->setVisible(false);

        for ($i=0;$i<4;$i++) {
          $chart3->getChart()->addSeries(new Bar($chart3->getChart()));
          $chart3->getChart()->getSeries($i)->fillSampleValues(5);
        }
        
        $chart1->getLegend()->getFont()->setSize(12);

        ColorPalettes::_applyPalette($chart1->getChart(), Theme::getBrightPalette());
        ColorPalettes::_applyPalette($chart2->getChart(), Theme::getBrightPalette());
        ColorPalettes::_applyPalette($chart3->getChart(), Theme::getBrightPalette());

        $chart1->render("chart1.png");
        $chart2->render("chart2.png");
        $chart3->render("chart3.png");
        
        $rand=rand();
        print '<font face="Verdana" size="2">Vertical Bar Chart<p>';
        ?>
          <form method="post" action="VHBarChart.php">
          <p>Select Bar style:
          <select name="barStyle">
          <option value="0">Rectangle</option>
          <option value="1">Cylinder</option>
          <option value="2">Arrow</option>
          <option value="3">Cone</option>
          <option value="4">Ellipse</option>
          <option value="5">Inv.Arrow</option>
          <option value="6">Pyramid</option>
          <option value="7">Inv.Pyramid</option>
          </select>
          <input type="submit" value="Refresh !">
          </form>
        <?php        
        print '<br><img src="chart1.png?rand='.$rand.'"><p>';         
        print '<font face="Verdana" size="2">Horizontal Bar Chart<p>';
        print '<img src="chart2.png?rand='.$rand.'"><p>';         
        print '<font face="Verdana" size="2">Multiple Bar Chart<p>';
        print '<img src="chart3.png?rand='.$rand.'"><p>';         
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Bar Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>