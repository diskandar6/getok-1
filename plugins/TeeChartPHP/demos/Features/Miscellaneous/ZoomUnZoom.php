<?php

    //Includes
    include "../../../sources/TChart.php";

    session_start(); 

    if (isset($_SESSION['xval']))
    {
        $xval = $_SESSION['xval'];
    }
    else
    {
        $xval = 1;   
    }

    if (isset($_SESSION['xval']))
        $_SESSION['xval'] = $_SESSION['xval'] + 1;
    else
        $_SESSION['xval'] = 1;

    if (isset($_SESSION['yval']))
    {
        $yval = $_SESSION['yval'];
    }
    else
    {
        $yval = 1;   
    }
    
    if (isset($_SESSION['yval']))    
        $_SESSION['yval'] = $_SESSION['yval'] + 1;
    else
        $_SESSION['yval'] = 1;
    

    if (isset($_POST['Submit'])) 
    {
        $xxval = $_SESSION['xval']*100;
        $xyval = $_SESSION['yval']*100;   
    }

    if (isset($_POST['Submit2'])) 
    {
        $xxval = $_SESSION['xval'];
        $xyval = $_SESSION['yval'];   
    }

    // Create the Chart    
    $tChart1 = new TChart(600,450);            
    
    //Add a data Series 
    $line1 = new Line($tChart1->getChart());
    //Populate it with data (here random) 
    $line1->fillSampleValues(10);

    //Add a series to be used for an Average Function 
    $line2 = new Line($tChart1->getChart()); 

    $average1 = new Average();
    //Define the Function Type for the new Series 
    $line2->setFunction($average1); 

    $line2->setDataSource($line1);
    $line2->getFunction()->setPeriod(2);
    $line2->checkDataSource();

    // Default
    if (isset($_POST['Submit3'])) 
    { 
        $tChart1->doInvalidate();  
    }

    // Zoom
    if (isset($_POST['Submit2'])) 
    { 
        $tChart1->doInvalidate();
        $tChart1->getZoom()->zoomRect(new Rectangle(200,200,200,200));
    }

    // UnZoom
    if (isset($_POST['Submit'])) 
    { 
      $tChart1->doInvalidate();
      $tChart1->getZoom()->zoomRect(new Rectangle(-$xxval,-$xyval,$tChart1->getChart()->getWidth()+$xxval+$xxval,$tChart1->getChart()->getHeight()+$xyval+$xyval));  
    }

    $tChart1->render("chart1.png");
    $rand=rand();
    print '<img src="chart1.png?rand='.$rand.'">';                
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Zoom and UnZoom Rectangle</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
  <br>
  <table>
  <tr>
  <td>
  <form method="post" action="ZoomUnZoom.php">
  <input type="submit" Name = "Submit3" value="Default !">
  </form>
  </td>
  <td>
  <form method="post" action="ZoomUnZoom.php">
  <input type="submit" Name = "Submit2" value="Zoom !">
  </form>
  </td>
  <td>
  <form method="post" action="ZoomUnZoom.php">
  <input type="submit" Name = "Submit" value="UnZoom !">  
  </form>
  </td>
  </tr>
  </table>
</body>
</html>