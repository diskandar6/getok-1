<?php
      //Includes
      include "../../../../sources/TChart.php";

      // Get Values from form
      if(isset($_POST["path"]))
        $path = $_POST['path'];

      // Assign Header text
      $chart1 = new TChart(600,450);
      $chart1->getHeader()->setText("GIF Export Demo");

      // Add Series to the Chart
      $pie = new Pie($chart1->getChart());
      $pie->marks->visible=false;
      $pie->fillSampleValues(5);

      // Save Chart to text
      if(isset($_POST['submit'])) {
          if ($path!="") {
            if (realpath($path)) {
              $chart1->doInvalidate();  
              $chart1->getChart()->getExport()->getImage()->getGIF()->save($path."\\TChart.gif");
              echo "The Chart has been exported correctly ! <br>";
            }
          }
          else
          {
              echo "Correct path must be entered ! ";
          }
      }
            
      $chart1->render("chart1.png");
      $rand=rand();
      print '<font face="Verdana" size="2">GIF Export Format<p>';
      print '<img src="chart1.png?rand='.$rand.'"><p>';         
?>

<html><body>
<font face="Verdana" size="2">
  <br />
<form method="post" action="GIFExport.php">
  Path:  <input name="path" type="text" value="c:\temp" />
  <input type="submit" name="submit" value="Save To GIF">
</form>
</font>
</body></html>