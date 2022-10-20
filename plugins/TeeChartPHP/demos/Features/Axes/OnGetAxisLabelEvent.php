<?php
  //Includes
  include "../../../sources/TChart.php";

  // Args contains axis, index order to be displayed, labelText
  function handleGetAxisLabel($sender, $args)
  {
      // If it's going to display left axis labels 
      if ($args[0] === $sender->getAxes()->getLeft())   
      {   
        // if the left axis label value is bigger than 50 add extra character
        if ((int)$args[2] > 50) {
            $args[0]->getLabels()->labelText = $args[2].'-e';
        }
      } 
      else
      {
        if ($args[0] === $sender->getAxes()->getBottom())   
        {   
          if ((int)$args[2] < 4) {
              // if value is less than 5 changes its labeltext
            $args[0]->getLabels()->labelText = $args[2].'-u';
          }            
        }
      } 
  }
  
  $handlers = new EventHandlerCollection();
  $handlers->add(new EventHandler(new ChartEvent('OnGetAxisLabel'),'handleGetAxisLabel'));
  
  $chart = new TChart(500,300, $handlers);
  
  $bar = new Bar($chart->getChart());
  $chart->addSeries($bar);
  $bar->fillSampleValues();
  $bar->setColorEach(true);  
  $chart->render('chart.png');  
  $rand=rand(); 
   
  print '<font face="Verdana" size="2">This Demo shows how to use the OnGetAxisLabel Event<p>';
  print '<img src="chart.png?rand='.$rand.'">';                
?>