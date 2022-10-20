<?php
        //Includes
        include "../../../sources/TChart.php";

        if(isset($_POST["imgStyle"]))
          $imgStyle = $_POST["imgStyle"];

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Back Image Load");
 	      $bar3D = new Bar3D($chart1->getChart());
        $bar3D->setColorEach(true);
	      $bar3D->addBar(0,10,0,"");
	      $bar3D->addBar(1,20,10,"");
  	    $bar3D->addBar(2,30,20,"");
        
        $bar3D->getPen()->setVisible(false);
        ColorPalettes::_applyPalette($chart1->chart, Theme::getPastelsPalette());
        
        // Changes the back image
        if(isset($_POST["imgStyle"])) {
          switch ($imgStyle) {
          case 0:
            $chart1->getPanel()->getBrush()->loadImageFromFile("blackGlass.png");
            $chart1->getAxes()->getBottom()->getLabels()->getFont()->setColor(Color::WHITE());
            $chart1->getAxes()->getLeft()->getLabels()->getFont()->setColor(Color::WHITE());
            break;
          case 1:
	        $chart1->getPanel()->getBrush()->loadImageFromFile("VistaImg.png");
            $chart1->getAxes()->getBottom()->getLabels()->getFont()->setColor(Color::BLACK());
            $chart1->getAxes()->getLeft()->getLabels()->getFont()->setColor(Color::BLACK());
            break;
          }
        }
        else
        {
            $chart1->getPanel()->getBrush()->loadImageFromFile("blackGlass.png");
            $chart1->getAxes()->getBottom()->getLabels()->getFont()->setColor(Color::WHITE());
            $chart1->getAxes()->getLeft()->getLabels()->getFont()->setColor(Color::WHITE());
        }

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Back Image Load<p>';
        print '<img src="chart1.png?rand='.$rand.'"><p>';         
        
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Back Image Load</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
  <form method="post" action="LoadBackImage.php">
  <p>Select back image:
  <select name="imgStyle">
  <option value="0">blackGlass</option>
  <option value="1">VistaImg</option>
  </select>
  <input type="submit" value="Refresh !">
  </form>
  </font>
</body>
</html>