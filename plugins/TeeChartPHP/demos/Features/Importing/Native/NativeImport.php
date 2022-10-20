<?php
      //Includes
      include "../../../../sources/TChart.php";

      // Get Values from form
      if(isset($_POST["path"]))
        $path = $_POST['path'];

      // Assign Header text
      $chart1 = new TChart(600,450);
      $chart1->getHeader()->setText("TEP Native Import Demo");

      // Save Chart to text
      if(isset($_POST['submit'])) {
          if ($path!="") {
            if (realpath($path)) {
              $chart1->setChart($chart1->getImport()->getTemplate()->fromFile($path));
              echo "The Chart has been imported correctly !";
              echo "<br>";
              echo "<br>";
              $xx=rand(0,100);
              $chart1->render("chart" . $xx . ".png");            
              echo '<img src="chart' . $xx . '.png . "'.'<br/>';              
            }
          }
          else
          {
              echo "Correct path must be entered ! ";
          }
      }
      else
      {   
        $chart1->render("chart1.png");
        echo '<img src="chart1.png"'.'<br/>';                      
      }
?>

<html>
<body>
<font face="Verdana" size="2">
  <br />  
  TEP Native Import Format<p>
<form method="post" action="<?php echo $PHP_SELF;?>">  
  Path:  <input name="path" type="text" value="c:\temp\TChart.tep" />
  <input type="submit" name="submit" value="Import From Native TEP">
</form>
</font>
</body></html>