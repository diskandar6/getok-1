<?php
        //Includes
        include "../../../../sources/TChart.php";

        if(isset($_POST["stairs"]))
          $stairs = $_POST["stairs"];
        if(isset($_POST["invstairs"]))
          $invstairs = $_POST["invstairs"];
        if(isset($_POST["ignorenulls"]))
          $ignorenulls = $_POST["ignorenulls"];

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("FastLine Style");
        $chart1->getChart()->getAspect()->setView3D(false);
        $chart1->getChart()->getAxes()->getLeft()->getMinorGrid()->setVisible(false);
        $chart1->getChart()->getAxes()->getBottom()->getMinorGrid()->setVisible(false);

        // Add FastLine Series
        $fastLine=new FastLine($chart1->getChart());
        $fastLine->setColor(new Color(250,72,52));

        // Adding data from Array 
        $yValues = Array();
        for ($i=0;$i<100;$i++)
          $yValues[]=rand(0,1000);

        $fastLine->addArray($yValues);

        // Set some nulls
        $fastLine->setNull(13);
        $fastLine->setNull(25);
        $fastLine->setNull(40);

        // Changes Stairs mode
        $fastLine->setStairs(isset($stairs));
        // Inverted Stairs
        if (isset($invstairs))
            $fastLine->setStairs(true);

        $fastLine->setInvertedStairs(isset($invstairs));
        // FastLine Ignore Nulls
        $fastLine->setIgnoreNulls(isset($ignorenulls));
        
        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">FastLine Series, allows to populate data using Arrays<p>';
        print '<img src="chart1.png?rand='.$rand.'">';            
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Line Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
  <form method="post" action="FastLineChart.php">
  Stairs Mode: <input type="checkbox" name="stairs" value="stairs"  /><br />
  Inverted Stairs: <input type="checkbox" name="invstairs" value="invstairs"  /><br />
  Ignore Nulls: <input type="checkbox" name="ignorenulls" value="ignorenulls"  /><br /><br />
  <input type="submit" value="Refresh !">
  </form>
  </font>
</body>
</html>
