<?php
	//Includes
	include "../../../sources/libTeeChart.php";       

	$chart1 = new TChart(1200,650);

	$chart1->getChart()->getHeader()->setText("DownSampling Function");
	$chart1->getChart()->getAspect()->setView3D(false);
	
	$chart1->getChart()->getPanel()->getGradient()->setVisible(false);
	$chart1->getChart()->getPanel()->setColor(Color::WHITE());
	$chart1->getChart()->getWalls()->getBack()->setTransparent(true);		
	
	ChartInit($chart1);

	$chart1->render("chart1.png");
	$rand=rand();
	print '<font face="Verdana" size="2">DownSampling Function Chart<p>';
	print '<img src="chart1.png?rand='.$rand.'"><p>';   		
		
	
    function ChartInit($chart1)
    {	
		$xValues[]=null;
		$yValues[]=null;

        $length = 500;

        for ($i = 0; $i < $length; $i++)
        {
            $xValues[$i] = $i;
            if ($i % 20 == 0)
            {
                $yValues[$i] = 0.0;
            }
            else
            {
                $yValues[$i] = MathUtils::round(rand(0,100));
            }
        }

        for ($i = 0; $i < $length; $i++)
        {
            $xValues[$i + $length] = $i;
            if ($i % 20 == 0)
            {
                $yValues[$i + $length] = 0.0;
            }
            else
            {
                $yValues[$i + $length] = MathUtils::round(rand(0,100));
            }
        }
		
				
        $points = new Points($chart1->getChart());
        $fastLine = new FastLine($chart1->getChart());
        $points->getPointer()->getBrush()->setVisible(false);
        $points->getPointer()->getPen()->setVisible(false);
		$points->getPointer()->setVertSize(0);
		$points->getPointer()->setHorizSize(0);

        $chart1->getChart()->getSeries(0)->addArrays($xValues, $yValues);
		
        $downSampling = new DownSampling();
		$downSampling->setChart($chart1->getChart());					

		$fastLine->setDataSource(Array($points));
        $fastLine->setFunction($downSampling);
		
        $fastLine->setTitle("DownSample");
        $fastLine->setColor(Color::GREEN());
	
        $downSampling->setDisplayedPointCount(250);        
        
        //$downSampling->setMethod(DownSamplingMethod::$MINMAXFIRSTLASTNULL);
        //$downSampling->setMethod(DownSamplingMethod::$MAX);
        //$downSampling->setMethod(DownSamplingMethod::$MIN);
        //$downSampling->setMethod(DownSamplingMethod::$MINMAXFIRSTLAST);
		
        $downSampling->setMethod(DownSamplingMethod::$MINMAX);

		$chart1->doInvalidate();
		$fastLine->checkDataSource();
	}             
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>DownSampling Function Charts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
</body>
</html>