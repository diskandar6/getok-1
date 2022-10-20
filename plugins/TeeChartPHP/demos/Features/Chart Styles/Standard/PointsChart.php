<?php
        //Includes
        include "../../../../sources/TChart.php";

        $chart1 = new TChart(600,450);
        $chart1->getChart()->getHeader()->setText("Points Style");
        $chart1->getAspect()->setView3D(false);
        $chart1->getLegend()->setVisible(false);
        $chart1->getPanel()->getGradient()->setVisible(false);
        $chart1->getPanel()->setColor(Color::WHITE());
        $chart1->getWalls()->getBack()->setColor(Color::fromRgb(245,245,245));
        
        $points1 = new Points($chart1->getChart());
        $points1->fillSampleValues(10);
        $points1->getPointer()->setStyle(PointerStyle::$DIAMOND);
        $points1->getPointer()->getPen()->setVisible(false);
        
        $points2 = new Points($chart1->getChart());
        $points2->fillSampleValues(10);
        $points2->getPointer()->setStyle(PointerStyle::$RECTANGLE);
        $points2->getPointer()->setHorizSize(2);
        $points2->getPointer()->setVertSize(2);
        $points2->getPointer()->getPen()->setVisible(false);
        
        $points3 = new Points($chart1->getChart());
        $points3->fillSampleValues(3);
        $points3->setColor(Color::ORANGE());
        $points3->getPointer()->setStyle(PointerStyle::$TRIANGLE);
        $points3->getPointer()->getPen()->setVisible(false);
        $points3->getPointer()->setHorizSize(6);
        $points3->getPointer()->setVertSize(6);
        
        $chart1->axes->bottom->increment=2;
        $chart1->axes->bottom->minimunoffset=15;
        $chart1->axes->bottom->maximumoffset=15;
        
        $chart1->axes->left->increment=20;
        $chart1->axes->left->minimumoffset=15;
        $chart1->axes->left->maximumoffset=15;
        

        $chart1->render("chart1.png");
        $rand=rand();
        print '<font face="Verdana" size="2">Points Chart Style<p>';
        print '<img src="chart1.png?rand='.$rand.'">';               
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Points Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>