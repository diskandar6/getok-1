<?php
        //Includes
        include "../../../../sources/TChart.php";

        if(isset($_POST["transparent"]))
          $transparent = $_POST["transparent"];
        if(isset($_POST["style"]))
          $style = $_POST["style"];

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Shape Style");
        $chart1->getChart()->getAspect()->setView3D(false);

        // Add Shape Series
        $shape=new ShapeSeries($chart1->getChart());

        // Changes the Shape style of the Series on Top

        if(isset($_POST["style"]))
        switch ($style) {
          case 0:
            $shape->setStyle(ShapeStyle::$RECTANGLE);
            break;
          case 1:
            $shape->setStyle(ShapeStyle::$CIRCLE);
            break;
          case 2:
            $shape->setStyle(ShapeStyle::$VERTLINE);
            break;
          case 3:
            $shape->setStyle(ShapeStyle::$HORIZLINE);
            break;
          case 4:
            $shape->setStyle(ShapeStyle::$TRIANGLE);
            break;
          case 5:
            $shape->setStyle(ShapeStyle::$INVERTTRIANGLE);
            break;
          case 6:
            $shape->setStyle(ShapeStyle::$LINE);
            break;
          case 7:
            $shape->setStyle(ShapeStyle::$DIAMOND);
            break;
          case 8:
            $shape->setStyle(ShapeStyle::$CUBE);
            break;
          case 9:
            $shape->setStyle(ShapeStyle::$CROSS);
            break;
          case 10:
            $shape->setStyle(ShapeStyle::$DIAGCROSS);
            break;
          case 11:
            $shape->setStyle(ShapeStyle::$STAR);
            break;
          case 12:
            $shape->setStyle(ShapeStyle::$PYRAMID);
            break;
          case 13:
            $shape->setStyle(ShapeStyle::$INVERTPYRAMID);
            break;
        }

        // Setting color for Shapes
        $shape->setColor(new Color(66,102,163));

        $shape->fillSampleValues();

        // Make transparent shapes
        if (isset($transparent)) {
          foreach ($chart1->getChart()->getSeries() as $shape)
          {
            $shape->setTransparent(true);
          }
        }

        $chart1->doInvalidate();

        /*
            Way to set Shape bounds :
            $shape2=new ShapeSeries($myChart->getChart());

            $shape2->setX0($myChart->getAxes()->getBottom()->getMinimum()+5);
            $shape2->setX1($myChart->getAxes()->getBottom()->getMaximum()-5);
            $shape2->setY0($myChart->getAxes()->getLeft()->getMinimum()+5);
            $shape2->setY1($myChart->getAxes()->getLeft()->getMaximum()-5);

            $shape2->setStyle(ShapeStyle::$CIRCLE);
        */

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Different Styles of Shape Series<p>';
        print '<img src="chart1.png?rand='.$rand.'">';         
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Line Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
  <form method="post" action="ShapeChart.php">
  Transparent Shape: <input type="checkbox" name="transparent" value="transparent"  /><br />
  <p>Select Shape Style:
  <select name="style">
  <option value="0">Rectangle</option>
  <option value="1">Circle</option>
  <option value="2">VertLine</option>
  <option value="3">HorizLine</option>
  <option value="4">Triangle</option>
  <option value="5">InvertTriangle</option>
  <option value="6">Line</option>
  <option value="7">Cube</option>
  <option value="8">Cross</option>
  <option value="9">DiagCross</option>
  <option value="10">Star</option>
  <option value="11">Pyramid</option>
  <option value="12">InvertPyramid</option>
  </select>
  <input type="submit" value="Refresh !">
  </form>
  </font>
</body>
</html>