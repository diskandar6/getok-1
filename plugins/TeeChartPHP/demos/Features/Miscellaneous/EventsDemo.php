<?php
  //Includes
  include "../../../sources/TChart.php";

  function handleLoad($sender, $args)
  {
     // print 'object '.get_class($sender).' loaded with '.count($args).' args!<br />';
     $sender->getHeader()->setText("OnLoad Event");    
  }

  function handleUnLoad($sender, $args)
  {
     ?><br><br><?php
     print 'object '.get_class($sender).' unloaded with '.count($args).' args!<br />';
     ?></br><?php     
  }

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
  $handlers->add(new EventHandler(new ChartEvent('OnLoad'),'handleLoad'));
  $handlers->add(new EventHandler(new ChartEvent('OnUnload'),'handleUnload'));
  $handlers->add(new EventHandler(new ChartEvent('OnGetAxisLabel'),'handleGetAxisLabel'));
  
  $chart = new TChart(600,450, $handlers);
  
  $chart->getAspect()->setView3D(false);

  $points = new Points($chart->getChart());
  $chart->addSeries($points);
 
  $points->fillSampleValues();
  $points->getPointer()->setHorizSize(10);
  $points->getPointer()->setVertSize(5);
  $points->setColorEach(true);
  
  $chart->getLegend()->getSymbol()->setSquared(false);
  
  $chart->doInvalidate();

  //--- This part of code simulates an OnAfterDraw ---
  $chart->getChart()->getGraphics3D()->TextOut(35,15,0,'TextOut and draw rectangle at AfterDraw');
  $chart->getChart()->getGraphics3D()->Rectangle(new Rectangle(15,6,10,10));
  imagepng($chart->getChart()->getGraphics3d()->img, 'chart.png');   
  //--------------------------------------------------------
  
  $rand=rand();               
   
  print '<font face="Verdana" size="2">This Demo shows how to use the OnLoad, OnUnload and OnGetAxisLabel Events<p>';
  print '<img src="chart.png?rand='.$rand.'">';                
?>