<?php
  //Includes
  include "../../../../sources/TChart.php";    
  
  // Assign Header text
  $chart = new TChart(500,350);      
  $chart->getHeader()->setText("Line and Point");
  
  // Add Series to the Chart  
  for ($i=0;$i<3;$i++) {
    $chart->addSeries(new Line($chart->getChart())); 
    $chart->getSeries($i)->fillSampleValues(20);
    $chart->getSeries($i)->getPointer()->setVisible(true);
  }
  
  // Export the Chart to a file
  $chart->getChart()->getExport()->getImage()->getJavaScript()->SaveToFile('jsLinePointChart.html');   
?>      
<?php  
  // Shows the chart directly to the browser, exporting to as text
  echo  $chart->getChart()->getExport()->getImage()->getJavaScript()->Render()->toString();   
?>
