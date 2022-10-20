<?php
  //Includes
  include "../../../../sources/TChart.php";    
  
  // Assign Header text
  $chart = new TChart(500,350);      
  $chart->getHeader()->setText("Point XY Scatter");
  
  // Add Series to the Chart  
  $point = new Points($chart->getChart());
  $point->fillSampleValues(20);
  $point->setColorEach(true);
  $point->getPointer()->setStyle(PointerStyle::$SPHERE);
  
  $chart->getPanel()->getPen()->setColor(Color::GREEN());
  $chart->getPanel()->getPen()->setWidth(5);
  $chart->getPanel()->getShadow()->setWidth(10);
  $chart->getPanel()->getShadow()->setHeight(10);
  
  $point->getMarks()->setTransparent(true);
  
  // Export the Chart to a file
  $chart->getChart()->getExport()->getImage()->getJavaScript()->SaveToFile('jsPointChart.html');   
?>      
<!-- Mixing JavaScript code into the page -->
<form method="post" action="#" name="myform">
<input type="checkbox" name="legend" onclick="Chart1.legend.visible= !Chart1.legend.visible; Chart1.draw();" checked>Legend
<input type="checkbox" id="series1" name="series1" onclick="Chart1.series.items[0].visible= !Chart1.series.items[0].visible; Chart1.draw();" checked>Series1
<input type="checkbox" id="gradient1" onclick="Chart1.series.items[0].pointer.format.gradient.visible= document.getElementById('gradient1').checked; Chart1.draw();" checked>Gradient
<input type="checkbox" id="marks" name="series1" onclick="Chart1.series.items[0].marks.visible= document.getElementById('marks').checked; Chart1.draw();">Marks
</br>
<div id="w" style="width:100px; float:left"></div></br>
<div id="h" style="width:100px"></div>
Pointer Style:</br>
<select id="pointer_style" onchange="Chart1.series.items[0].pointer.style=document.getElementById('pointer_style').value; Chart1.draw();">
  <option value="rectangle">Rectangle</option>
  <option value="ellipse" selected>Ellipse</option>
  <option value="triangle">Triangle</option>
  <option value="diamond">Diamond</option>
  <option value="downtriangle">Down Triangle</option>
  <option value="cross">Cross</option>
  <option value="x">X</option>
</select>
</form>  
<?php  
  // Shows the chart directly to the browser, exporting to as text
  echo  $chart->getChart()->getExport()->getImage()->getJavaScript()->Render()->toString();   
?>