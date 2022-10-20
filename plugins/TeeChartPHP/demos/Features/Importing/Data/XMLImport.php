<?php
      //Includes
      include "../../../../sources/TChart.php";

      // Get Values from form
      if(isset($_POST["path"]))
        $path = $_POST['path'];

      // Assign Header text
      $chart1 = new TChart(600,450);
      $chart1->getHeader()->setText("XML Import Demo");

      // Save Chart to text
      if(isset($_POST['submit'])) {
          if ($path!="") {
            if (file_exists($path)) {
              $chart1->getImport()->getXML()->load($path);
              echo "The Chart has been imported correctly !";
              $chart1->doInvalidate();
            }
          }
          else
          {
              echo "Correct path and xml file must be entered ! ";
          }
      }
      $chart1->render("chart1.png");
      $rand=rand();
      print '<font face="Verdana" size="2">XML Import Format<p>';
      print '<img src="chart1.png?rand='.$rand.'"><p>';               
?>

<html><body>
<font face="Verdana" size="2">
  <br />
<form method="post" action="<?php echo $PHP_SELF;?>">
  Path:  <input name="path" type="text" value="TChart.xml" />
  <input type="submit" name="submit" value="Import from XML">
</form>
</font>
</body></html>