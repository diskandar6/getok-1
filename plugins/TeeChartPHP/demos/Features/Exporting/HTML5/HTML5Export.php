<?php
      // HTMNL5 export Example
      
      //Includes
      include "../../../../sources/TChart.php";      
      
      // Get Values from form
      if(isset($_POST["path"]))
        $path = $_POST['path'];

      // Assign Header text
      $chart1 = new TChart(600,450);
      $chart1->getAspect()->setView3D(false);
      $chart1->getHeader()->setText("HTML5 Demo");
      $chart1->getPanel()->getGradient()->setVisible(false);      
      $chart1->getPanel()->setColor(Color::WHITE());
      $chart1->getLegend()->setLegendStyle(LegendStyle::$LASTVALUES);

      // Add Series to the Chart
      $line = new Line($chart1->getChart());
      $line->getPointer()->setVisible(true);
      $line->getPointer()->setStyle(PointerStyle::$CIRCLE);
      $line->fillSampleValues(10);

      $chart1->render("chart1.png");
      $rand=rand();
      print '<font face="Verdana" size="2">HTML5 Export Format is allowed<p>';
      print '<img src="chart1.png?rand='.$rand.'"><p>';         

      // Save Chart to text
      if(isset($_POST['submit'])) {
          if (($path!="") && (realpath($path))) {                
              $chart1->getChart()->getExport()->getImage()->getHTML5()->save($path."\\TChart.html");
              
              exec($path."\\TChart.html");
              echo "The Chart has been exported correctly !";
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
<form method="post" action="<?php echo $PHP_SELF;?>">
  Path:  <input name="path" type="text" value="c:\" />
  <input type="submit" name="submit" value="Export to HTML5">
</form>
</font>
</body></html>