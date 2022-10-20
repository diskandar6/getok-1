<?php
      //Includes
      include "../../../../sources/TChart.php";

      // Get Values from form
      if(isset($_POST["path"]))
        $path = $_POST['path'];
      if(isset($_POST["includeindex"]))
        $includeindex = $_POST["includeindex"];

      // Assign Header text
      $chart1 = new TChart(600,450);
      $chart1->getHeader()->setText("XML Export Demo");

      // Add Series to the Chart
      $area = new Area($chart1->getChart());
      $area->fillSampleValues(10);

      $chart1->render("chart1.png");
      $rand=rand();
      print '<font face="Verdana" size="2">XML Export Format is allowed<p>';
      print '<img src="chart1.png?rand='.$rand.'"><p>';         

      // Save Chart to text
      if(isset($_POST['submit'])) {
          if ($path!="") {
            if (realpath($path)) {
              $chart1->getExport()->getData()->getXML()->setIncludeIndex(isset($includeindex));

              $chart1->getChart()->getExport()->getData()->getXML()->save($path."\\TChart.xml");
              echo "The Chart has been exported correctly !";
            }
          }
          else
          {
              echo "Correct path must be entered ! ";
          }
      }
?>

<html><body>
<font face="Verdana" size="2">
  <br />
<form method="post" action="XMLExport.php">
  <p>Select XML export options:</p>
  Include Index: <input type="checkbox" name="includeindex" value="pointindex"  /><br /> <br />
  Path:  <input name="path" type="text" value="c:\temp" />
  <input type="submit" name="submit" value="Save To XML">
</form>
</font>
</body></html>