<?php
  //Includes
  include "../../../../sources/TChart.php";    

  /* Get Values from form
  if(isset($_POST["panelGradient"]))
    $panelGradient = $_POST['panelGradient'];
  */
  
  // Assign Header text
  $chart = new TChart(500,350);      
  $chart->getHeader()->setText("Line Demo");
  
  // Add Series to the Chart  
  $s = new Line($chart->getChart()); 
  $s->fillSampleValues(1000);
 
  $chart->getAxes()->getLeft()->getTitle()->setCaption("Y");
  $chart->getSeries(0)->getMarks()->setDrawEvery(120);
  
  $chart->getHeader()->getFont()->setName("Verdana");
  $chart->getHeader()->getFont()->setSize(18);
  
  // Export the Chart to a file
  $chart->getChart()->getExport()->getImage()->getJavaScript()->SaveToFile('jsLineChart.html');   
?>      
<!-- Mixing JavaScript code into the page -->
<form method="post" action="#" name="myform">
<input type="checkbox" id="series1" name="series1" onclick="Chart1.series.items[0].visible= !Chart1.series.items[0].visible; Chart1.draw();" checked>Series1
<input type="checkbox" id="marks" onclick="Chart1.series.items[0].marks.visible= document.getElementById('marks').checked; Chart1.draw();">Marks
</br>
<input type="checkbox" name="gradient1" onclick="Chart1.panel.format.gradient.visible= !Chart1.panel.format.gradient.visible; Chart1.draw();" checked>Gradient
<input type="checkbox" id="shadow" onclick="Chart1.series.each(function(s){s.format.shadow.visible= document.getElementById('shadow').checked;}); Chart1.draw();" checked>Shadow
<input type="checkbox" id="legend" onclick="Chart1.legend.visible=document.getElementById('legend').checked; Chart1.draw();" checked>Legend 
<input type="checkbox" id="logy" onclick="Chart1.axes.left.log=document.getElementById('logy').checked; Chart1.draw();">Logarithmic Y
<input type="checkbox" id="logx" onclick="Chart1.axes.bottom.log=document.getElementById('logx').checked; Chart1.draw();">Logarithmic X
</form>
<?php  
  // Shows the chart directly to the browser, exporting to as text
  echo  $chart->getChart()->getExport()->getImage()->getJavaScript()->Render()->toString();   
?>