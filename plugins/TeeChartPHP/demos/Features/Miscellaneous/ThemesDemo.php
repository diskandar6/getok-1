<?php

//Includes
include "../../../sources/TChart.php";

if(isset($_POST["theme"]))
  $theme = $_POST["theme"];

if (file_exists(dirname(__FILE__).'/chart1.png'))
{
    unlink(dirname(__FILE__).'/chart1.png');
}
  
$chart1 = new TChart(600,450);
$bar = new Bar($chart1->getChart());
$bar->fillSampleValues(5);
$bar->setColorEach(true);
ThemesList::applyTheme($chart1->getChart(),0);  // Opera


if(isset($_POST["theme"]))
    switch ($theme) {
          case 0:
            ThemesList::applyTheme($chart1->getChart(),0);  // Opera
            break;
          case 1:
            ThemesList::applyTheme($chart1->getChart(),1);  // BlackIsBack
            break;
          case 2:
            ThemesList::applyTheme($chart1->getChart(),2);   // TeeChart
            break;
          case 3:
            ThemesList::applyTheme($chart1->getChart(),3);  // Excel
            break;
          case 4:
            ThemesList::applyTheme($chart1->getChart(),4);  // Classic
            break;
          case 5:
            ThemesList::applyTheme($chart1->getChart(),5);  // XP
            break;
          case 6:
            ThemesList::applyTheme($chart1->getChart(),6);  // Web
            break;
          case 7:
            ThemesList::applyTheme($chart1->getChart(),7);  // Business
            break;
          case 8:
            ThemesList::applyTheme($chart1->getChart(),8);  // Blues
            break;
          case 9:
            ThemesList::applyTheme($chart1->getChart(),9);  // Grayscale
            break;
          case 10:
            ThemesList::applyTheme($chart1->getChart(),10);  // Y2009
            break;
    }

$chart1->render("chart1.png");
$rand=rand();
print '<font face="Verdana" size="2">Themes Demo<p>';
print '<img src="chart1.png?rand='.$rand.'">';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Themes Demo</title>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
  <form method="post" action="ThemesDemo.php">
  <p>Select Theme from list:
  <select name="theme">
  <option value="0">Opera</option>
  <option value="1">BlackIsBack</option>
  <option value="2">Default</option>
  <option value="3">Excel</option>
  <option value="4">Classic</option>
  <option value="5">XP</option>
  <option value="6">Web</option>
  <option value="7">Business</option>
  <option value="8">BlueSky</option>
  <option value="9">Grayscale</option>
  <option value="10">Y2009</option>
  <option selected=""  value=""></option>  
  </select>
  <input type="submit" value="Refresh !">
  </form>
  </font>
</body>
</html>
