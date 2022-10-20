<?php
 /**
 * Description:  This file contains the following class:<br>
 * TeeJavascript class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */
 /**
 * TeeJavascript class
 *
 * Description: Chart JavaScript export
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports                                             
 * @link http://www.steema.com
 */

 class JavaScriptExport  {
     
  public static $PathToScript='http://www.steema.com/files/public/teechart/html5/latest/src/teechart.js';
  public static $PathToExtraScript='http://www.steema.com/files/public/teechart/html5/latest/src/teechart-extras.js';
 
  private $jstext;
  protected $ChartName; 

  public function __construct($chartName="Chart1") {
      $this->ChartName=$chartName;   
  }
  
  public function __destruct()    
  {        
      unset($this->jstext);
      unset($this->ChartName);
  }     
  
  function getChartName(){	
      return  $this->ChartName;
  }
  
  function setChartName($value) {
      $this->ChartName=$value;
  } 
  
  function EmitTitle($Tag, $ATitle)
  {
      $str[]= $ATitle->getText();
      $this->EmitStrings($Tag.'.text',$str);
      $this->EmitCustomShapeFormat('  '.$Tag.'.format',$ATitle);     
      
    if (!$ATitle->getVisible())
       $this->AddScript($Tag.'.visible='.$this->ToBool(false).';');

    if (!$ATitle->getTransparent())
       $this->jstext->addLine($Tag.'.transparent='.$this->ToBool(false).';');             
  }

  function EmitAxis($Tag, $Axis)
  {
      if (!$Axis->getVisible())
         $this->jstext->addLine($Tag.'.visible=false;');

      if ($Axis->getInverted())
         $this->jstext->addLine($Tag.'.inverted=true;');

      if ($Axis->getLabels()->getAlternate())
         $this->jstext->addLine($Tag.'.labels.alternate=true;');

      switch ($Axis->getLabels()->getStyle()) 
      {
         case AxisLabelStyle::$AUTO: break;
         case AxisLabelStyle::$NONE: 
           $this->jstext->addLine($Tag.'.labels.visible=false;');
           break;
         case AxisLabelStyle::$VALUE:
           $this->jstext->addLine($Tag.'.labels.labelStyle="value";');
           break;
         case AxisLabelStyle::$MARK: 
           $this->jstext->addLine($Tag.'.labels.labelStyle="mark";');
           break;
         case AxisLabelStyle::$TEXT:
           $this->jstext->addLine($Tag.'.labels.labelStyle="text";');
           break;
       }

      if (!$Axis->getLabels())
         $this->jstext->addLine($Tag.'.labels.visible=false;');

      $this->EmitStroke($Tag.'.format.stroke',$Axis->getAxisPen());

      $this->EmitStroke($Tag.'.grid.format.stroke',$Axis->getGrid());
      if (!$Axis->getGrid()->getVisible())
         $this->jstext->addLine($Tag.'.grid.visible=false;');

      $this->EmitFont($Tag.'.labels.format.font',$Axis->getLabels()->getFont());

      if ($Axis->getTitle()->getCaption()<>'')
      {
        $this->EmitFont($Tag.'.title.format.font',$Axis->getTitle()->getFont());
        $this->jstext->addLine($Tag.'.title.text="'.$Axis->getTitle()->getCaption().'";');
      }
      
      if (($Axis->Maximum<>0) and ($Axis->Minimum<>0))
         $this->jstext->addLine($Tag.'.setMinMax('.$Axis->getMinimum().','.$Axis->getMaximum().');');
      
      if ($Axis->getStartPosition()<>0) 
          $this->jstext->addLine($Tag.'.start='.$Axis->getStartPosition().';');
          
      if ($Axis->getEndPosition()<>100) 
          $this->jstext->addLine($Tag.'.end='.$Axis->getEndPosition().';');
      
      if ($Axis->getRelativePosition()<>0)
          $this->jstext->addLine($Tag.'.position='.$Axis->getRelativePosition().';');     
  }
   
  function EmitAxes($Tag, $Axes)
  {
    if (!$Axes->getVisible())
       $this->jstext->addLine($Tag.'.visible=false;');

    $this->EmitAxis($Tag.'.left',$Axes->getLeft());
    $this->EmitAxis($Tag.'.top',$Axes->getTop());
    $this->EmitAxis($Tag.'.right',$Axes->getRight());
    $this->EmitAxis($Tag.'.bottom',$Axes->getBottom());
    
    for ($i=0; $i<$Axes->getCustom()->count(); $i++) {
        $this->AddNewAxis($Axes->getCustom()->getAxis($i),$Tag);
    }
  }

  function EmitStrings($Tag, $AStrings)
  {
    $tmp ='';
    $t=0;

    $tmp=$Tag.'="';

    for ($t=0;$t<sizeof($AStrings);++$t)
    {
        if ($t>0) $tmp=$tmp.'\n';
        
        $tmp=$tmp.$AStrings[$t];
    }

    $this->jstext->addLine('  '.$tmp.'";');
  }

  function EmitFont($Tag, $AFont)
  {
    $this->jstext->addLine($Tag.'.style="'.(Round($AFont->getSize()*96/72)).'px '.$this->FontStyle($AFont->Style).basename($AFont->FontName, ".ttf").'";');
    $this->jstext->addLine($Tag.'.fill="'.$this->HtmlColor($AFont->Color).'";');
    
    if ($AFont->getShadow()->getVisible() && ($AFont->getShadow()->getSize()!=0)) 
         $this->EmitShadow($Tag.'.shadow',$AFont->getShadow());    
  }
  
  function HtmlColor($AColor)
  {
    return Utils::rgbhex($AColor->getRed(),$AColor->getGreen(),$AColor->getBlue());
  }

  function EmitStroke($Tag, $APen)
  {
    if (!$APen->getVisible())
       $this->jstext->addLine($Tag.'.fill="";');
    else
    if ($APen->getColor()<>'clTeeColor')
       $this->jstext->addLine($Tag.'.fill="'.$this->HtmlColor($APen->getColor()).'";');

    if ($APen->getWidth()<>1)
       $this->jstext->addLine($Tag.'.size="'.$APen->getWidth().'";');
  }
  
  function EmitGradient($Tag, $AGradient)
  {
      // TODO
  }

  function Direction($ALegend)
  {
      switch ($ALegend->getAlignment()) {   
      case 0 : 
        return 'left';
        break;
      case 1:  
        return 'right';
        break;
      case 2:
        return 'top';
        break;
      default:
        return 'bottom';
      }
  }
  
  private function EmitSymbol($Tag ,$ASymbol) {
      if (!$ASymbol->getVisible())
         $this->jstext->addLine($Tag.'.visible='.$this->ToBool(false).';');
  }
    
  private function EmitLegendTitle($Tag, $ATitle) {

      $this->EmitStrings($Tag.'.text',$ATitle->getText());
      $this->EmitCustomShapeFormat($Tag.'.format', $ATitle);

      if (!$ATitle->getVisible())
         $this->jstext->addLine($Tag.'.visible='.$this->ToBool(false).';');

      if (!$ATitle->getTransparent())
         $this->jstext->addLine($Tag.'.transparent='.$this->ToBool(false).';');
  }
      
  function EmitLegend($Tag, $ALegend)
  {
    $this->jstext->addLine($Tag.'.position="'.$this->Direction($ALegend).'";');
    //$this->EmitGradient($Tag.'.format.gradient',$ALegend->getGradient());
    $this->EmitCustomShapeFormat($Tag.'.format', $ALegend);

    if (!$ALegend->getVisible())
       $this->jstext->addLine($Tag.'.visible='.$this->ToBool(false).';');

    if ($ALegend->getInverted())
       $this->jstext->addLine($Tag.'.inverted='.$this->ToBool(true).';');

    if ($ALegend->getTransparent())
       $this->jstext->addLine($Tag.'.transparent='.$this->ToBool(true).';');

    $this->EmitSymbol($Tag.'.symbol',$ALegend->getSymbol());

    if ($ALegend->getTitle()->getVisible() && ($ALegend->getTitle()->getText()!='')) 
       $this->EmitLegendTitle($Tag.'.title',$ALegend->getTitle());    
  }
  
  private function EmitShadow($Tag, $AShadow) {
    $Silver2="$505050";
  
    if (($AShadow->getColor()!="clTeeColor") /* TODO && ($this->ColorToRGB($AShadow->getColor())!="Silver2")*/) 
       $this->jstext->addLine($Tag.'.color="'.$this->HtmlColor($AShadow->getColor()).'";');

    if ($AShadow->getHorizSize()<>4) 
       $this->jstext->addLine($Tag.'.width='.$AShadow->getHorizSize().';');

    if ($AShadow->getVertSize()<>4) 
       $this->jstext->addLine($Tag.'.height='.$AShadow->getHorizSize().';');

    if (!$AShadow->getVisible())
       $this->jstext->addLine($Tag.'.visible='.$this->ToBool(False).';');

    /* TODO
    if (!$AShadow->getSmooth())
       $this->jstext->addLine($Tag.'.blur=0;');
    else
    if ($AShadow->getSmoothBlur()!=0)
       $this->jstext->addLine($Tag.'.blur='.(Round(($AShadow->getSmoothBlur()+75)*0.1).';'));
    */
  }  
  
  private function EmitPointer($Tag, $APointer)  {  
    $this->EmitStroke($Tag.'.format.stroke',$APointer->getPen());
    $this->EmitGradient($Tag.'.format.gradient',$APointer->getGradient());

    if ($APointer->getColor()!="clTeeColor")
        $this->jstext->addLine($Tag.'.fill="'-$this->HtmlColor($APointer->getColor()).'";');

    if (($APointer->getShadow()->getVisible()) && ($APointer->getShadow()->getSize()!=0)) 
        $this->EmitShadow($Tag.'.format.shadow',$APointer->getShadow());

    $this->jstext->addLine($Tag.'.visible='+$this->ToBool($APointer->getVisible()).';');

    $this->jstext->addLine($Tag.'.width='.($APointer->getHorizSize()*2).';');
    $this->jstext->addLine($Tag.'.height='.($APointer->getVertSize()*2).';');

    if ($APointer->getStyle()!=PointerStyle::$RECTANGLE)
      switch ($APointer->getStyle()) 
      {
         case PointerStyle::$CIRCLE: 
            $this->jstext->addLine($Tag.'.style="ellipse";');         
            break;
         case PointerStyle::$SPHERE: 
            $this->jstext->addLine($Tag.'.style="ellipse";');         
            break;
         case PointerStyle::$TRIANGLE: 
            $this->jstext->addLine($Tag.'.style="triangle";');         
            break;
         case PointerStyle::$DIAMOND: 
            $this->jstext->addLine($Tag.'.style="diamond";');         
            break;
         case PointerStyle::$DOWNTRIANGLE: 
            $this->jstext->addLine($Tag.'.style="downtriangle";');         
            break;
         case PointerStyle::$CROSS: 
            $this->jstext->addLine($Tag.'.style="cross";');         
            break;
         case PointerStyle::$STAR: 
            $this->jstext->addLine($Tag.'.style="x";');         
            break;
         case PointerStyle::$DIAGCROSS: 
            $this->jstext->addLine($Tag.'.style="x";');         
            break;
      }
  }

  private function EmitWall($Tag, $Wall)
  {
    if (!$Wall->getVisible())
     $this->jstext->addLine($Tag.'.visible='.$this->ToBool(false).';');

    $this->EmitCustomShapeFormat($Tag.'.format',$Wall,false);
  }
  
  private function EmitCustomShapeFormat($Tag, $AShape, $AEmitFont=true)  {
    $tmp=0; 

    if ($AShape->getColor()!="clTeeColor")
       $this->jstext->addLine($Tag.'.fill="'.$this->HtmlColor($AShape->getColor()).'";');

    /* TODO
    if ($AShape->getShapeStyle()==TextShapeStyle::$RECTANGLE)
       $tmp='0';
    else
       $tmp=$AShape->getRoundSize();
       */

    $this->jstext->addLine($Tag.'.round.x='.$tmp.';');
    $this->jstext->addLine($Tag.'.round.y='.$tmp.';');

    if ($AShape->getGradient()->getVisible())
       $this->EmitGradient($Tag.'.gradient',$AShape->getGradient());

    if ($AEmitFont)
       $this->EmitFont($Tag.'.font',$AShape->getFont());

    if ($AShape->getPen()->getVisible())
       $this->EmitStroke($Tag.'.stroke',$AShape->getPen());

    if ($AShape->getShadow()->getVisible() && ($AShape->getShadow()->getSize()!=0))
       $this->EmitShadow($Tag.'.shadow',$AShape->getShadow());
  }  

 
  private function EmitWalls($Tag, $Walls) {
    if (!$Walls->getVisible())
       $this->jstext->addLine($Tag.'.visible='.$this->ToBool(False).';');

    $this->EmitWall($Tag.'.back',$Walls->getBack());
  }
  
  private function EmitPanel($Tag, $APanel)
  {
    $tmp='';

    if ($APanel->getColor()!='clTeeColor') {
      if ($APanel->getColor()=='clNone')  
         $this->jstext->addLine($Tag.'.transparent='.$this->ToBool(True).';');
      else
         $this->jstext->addLine($Tag.'.format.fill="'.$this->HtmlColor($APanel->getColor()).'";');
    }

    $tmp=$APanel->getBorderRound();
    $this->jstext->addLine($Tag.'.format.round.x='.$tmp.';');
    $this->jstext->addLine($Tag.'.format.round.y='.$tmp.';');

    $this->EmitStroke($Tag.'.format.stroke',$APanel->getPen());
    $this->EmitGradient($Tag.'.format.gradient',$APanel->getGradient());

    if ($APanel->getShadow()->getVisible() && ($APanel->getShadow()->getSize()!=0))
       $this->EmitShadow($Tag.'.format.shadow',$APanel->getShadow());
  }
    
  // Start Emit Series
  
  function SeriesColors($Series) {
      $t=0;
      $result=$this->HtmlColor($Series->ValueColor[0]);
      for ($t=1;$t< sizeof($Series); ++$t)
        $result=$result.','.$this->HtmlColor($Series->ValueColor[$t]);
      
      return $result;
  }

  function SeriesLabels($Series) {
      $t=0;
      $result='"'.$Series->Labels[0].'"';
      for ($t=1; $t< sizeof($Series); ++$t)
        $result=$result.',"'.$Series->Labels[$t].'"';
      
      return $result;
  }

  function AddNewSeries($Series,$AClass,$Tag) {
     $this->jstext->addLine('  var '.$Series->toString().'='.trim($Tag).'addSeries(new Tee.'.$AClass.'());');
  }
  
  function AddNewAxis($Axis,$Tag) {
      $horiz=$Axis->getHorizontal()?'true':'false';
      $other=$Axis->getOtherSide()?'true':'false';
      $this->jstext->addLine($Tag.'.add('.$horiz.','.$other.');');
      $this->EmitAxis($Tag.'.items['.trim($Tag).'.items.length-1'.']',$Axis);
  }
  
  function EmitLineStyle($Series,$Tag,$tmp) {
    $this->AddNewSeries($Series,'Line',$Tag);      
    
    if ($Series->getPointer()->getVisible())
         $this->jstext->addLine($tmp.'pointer.visible=true;');
  }
  
  // Parses the Series types
  function SeriesEmit($Series,$Tag) {
    $tmp="";
    $tmp='  '.$Series->titleOrName().'.';     // get_class

    if ($Series instanceof Line) 
         $this->EmitLineStyle($Series,$Tag,$tmp);
      else
        if ($Series instanceof HorizArea)
          $this->AddNewSeries($Series,'HorizArea',$Tag);
        else
          if ($Series instanceof Bar)
            $this->AddNewSeries($Series,'Bar',$Tag);
          else
              if ($Series instanceof Area)
                $this->AddNewSeries($Series,'Area',$Tag);
              else
                if ($Series instanceof HorizBar)
                  $this->AddNewSeries($Series,'HorizBar',$Tag);
                else
                  if ($Series instanceof Donut)
                   $this->AddNewSeries($Series,'Donut',$Tag);                        
                  else                
                  if ($Series instanceof Pie)
                    $this->AddNewSeries($Series,'Pie',$Tag);
                  else
                    if ($Series instanceof Points)
                      $this->AddNewSeries($Series,'PointXY',$Tag);
                    else
                      if ($Series instanceof Bubble)
                        $this->AddNewSeries($Series,'Bubble',$Tag);
                      else                    
                        if ($Series instanceof Candle)
                          $this->AddNewSeries($Series,'Candle',$Tag);
                        else
                          $this->jstext->append('Series class: '.$Series->ClassName.' not implemented yet.');

      $this->jstext->addLine($tmp.'title="'.$Series->titleOrName().'";');

      if ($Series->getColor()<>'clTeeColor') 
         $this->jstext->addLine($tmp.'format.fill="'.$this->HtmlColor($Series->getColor()).'";');

      if ($Series->getColorEach())
         $this->jstext->addLine($tmp.'colorEach="yes";');

      if ($Series->getCount()>0)
      {
        $this->jstext->addLine($tmp.'data.values=['.$this->Floats($Series->getCount(),$Series->getMandatory()).'];');

        if ($Series->hasNoMandatoryValues())
           $this->jstext->addLine($tmp.'data.x=['.$this->Floats($Series->getCount(),$Series->getNotMandatory()).'];');

        if ($Series->iColors!=null)
           $this->jstext->addLine($tmp.'palette=["'.implode('","', $Series->getColors()).'"];');

        if ($Series->getLabels())
           $this->jstext->addLine($tmp.'data.labels=["'.implode('","', $Series->getLabels()).'"];');
      }

      $this->EmitSeriesMarks($tmp.'marks',$Series->getMarks());
      
      if ($Series->getHorizontalAxis()<>HorizontalAxis::$BOTTOM) {
          if ($Series->getHorizontalAxis()==HorizontalAxis::$TOP) {
              $this->jstext->addLine($tmp.'horizAxis="top";');
          }
          else if ($Series->getHorizontalAxis()==HorizontalAxis::$BOTH) {
              $this->jstext->addLine($tmp.'horizAxis="both";');
          }
          else if ($Series->getHorizontalAxis()==HorizontalAxis::$CUSTOM) {
              $this->jstext->addLine($tmp.'horizAxis='.trim($Tag).'axes.items['.($Series->getChart()->getAxes()->getCustom()->indexOf($Series->getCustomHorizAxis())+4).'];');
          }
      }
      
      if ($Series->getVerticalAxis()<>VerticalAxis::$LEFT) {
          if ($Series->getVerticalAxis()==VerticalAxis::$RIGHT) {
              $this->jstext->addLine($tmp.'vertAxis="right";');
          }
          else if ($Series->getVerticalAxis()==VerticalAxis::$BOTH) {
              $this->jstext->addLine($tmp.'vertAxis="both";');
          }
          else if ($Series->getVerticalAxis()==VerticalAxis::$CUSTOM) {
              $this->jstext->addLine($tmp.'vertAxis='.trim($Tag).'axes.items['.($Series->getChart()->getAxes()->getCustom()->indexOf($Series->getCustomVertAxis())+4).'];');
          }
      }
  }    
  // End Emit Series  
  
  private function EmitMarksStyle($Tag, $AStyle, $HasLabels) {
      switch ($AStyle)
      {
          case MarksStyle::$VALUE:
             $this->jstext->addLine($Tag.'="value";');
             break;
          case MarksStyle::$PERCENT:
             $this->jstext->addLine($Tag.'="percent";');
             break;
          case MarksStyle::$LABEL:
             if ($HasLabels)  $this->jstext->addLine($Tag.'="label";');
             break;
          case MarksStyle::$LABELPERCENT:
             $this->jstext->addLine($Tag.'="labelpercent";');
             break;
          case MarksStyle::$LABELVALUE:
             $this->jstext->addLine($Tag.'="labelv";');
             break;
          case MarksStyle::$LEGEND:
             $this->jstext->addLine($Tag.'="legend";');
             break;
          case MarksStyle::$POINTINDEX:
             $this->jstext->addLine($Tag.'="index";');
             break;
      }
 }
    
  // Emit Series Marks
  function EmitSeriesMarks($Tag,$AMarks) {
      
      $this->jstext->addLine($Tag.'.visible='.$this->ToBool($AMarks->getVisible()).';');      
      if ($AMarks->getTransparent())
        $this->jstext->addLine($Tag.'.transparent='.$this->ToBool(True).';');

      $this->EmitCustomShapeFormat($Tag.'.format',$AMarks);

      $this->EmitMarksStyle($Tag.'.style',$AMarks->getStyle(),sizeof($AMarks->getSeries()->getLabels())>0);
      
      if ($AMarks->getDrawEvery()!=1)
        $this->jstext->addLine($Tag.'.drawEvery='.$AMarks->getDrawEvery().';');            
  }  
  
  // Parses evary Series added to the Chart
  function EmitSeries($Tag, $ASeries) {
    $t=0;
    for ($t=0;$t<sizeof($ASeries);++$t)
      $this->SeriesEmit($ASeries[$t],$Tag);
  }
  
  function FontStyle(&$AStyle/*TFontStyles*/)  {
    $result = '';
    /* TODO
    if fsBold in AStyle then result:=result+' bold';
    if fsItalic in AStyle then result:=result+' italic';
    if result<>'' then result:=result+' ';
    */
    return $result;
  }
    
  private static $LOCALE; 
    
  function Floats($Count, $AList)  {
    $t=0;
    $Old=''; 

    if ($Count>0)
    {
        //$Old=$this->DecimalSeparator;
        //$this->DecimalSeparator='.';

        $result=$AList->getValue(0);
        for ($t=1;$t< $Count;++$t)
            $result=$result.','. $AList->getValue($t);

        //$this->DecimalSeparator=$Old;
    }
    else
        $result='';
        
    return $result;
  }
  
  function ToBool($Value)  {
    if ($Value) 
      return 'true';
    else 
      return 'false';
  }


  function CreateNewTool($Tool,$AClass,$Tag)  {
     $this->jstext->addLine('');      
     $this->jstext->addLine('  tool'.sizeof($Tool->getChart()->getTools()).'= new Tee.'.$AClass.'('.$this->getChartName().');');
  }
  
  // Parses the Tool types (Standard tools)
  function ToolsEmit($Tool,$Tag)  {
    $tmp="";
    $tmp='tool'.sizeof($Tool->getChart()->getTools()).'.'; 

    if ($Tool instanceof Annotation) 
      $this->ApplyAnnotationTool($Tool,$Tag,$tmp);   
    else
      $this->jstext->append('Tool class: '.$Tool->ClassName.' not implemented yet.');
  }  
  
  // End Emit Tools  

  // Parses the JsTool types (JavaScript tools)
  function JsToolsEmit($JsTool,$Tag)  {
    $tmp="";
    $tmp='tool'.sizeof($JsTool->getChart()->getJsTools()).'.'; 

    if ($JsTool instanceof Scroller) 
      $this->ApplyScrollerTool($JsTool,$Tag,$tmp);   
    else
      if ($JsTool instanceof slider) 
        $this->ApplySliderTool($JsTool,$Tag,$tmp);   
      else
      if ($JsTool instanceof Cursor) 
        $this->ApplyCursorTool($JsTool,$Tag,$tmp);   
      else
        if ($JsTool instanceof ToolTip) 
          $this->ApplyToolTip($JsTool,$Tag,$tmp);           
        else
          $this->jstext->append('JsTool class: '.$JsTool->ClassName.' not implemented yet.');
  }  
  // End Emit JsTools  
  
  // Parses evary Tool (Standard tool) added to the Chart
  function EmitTools($Tag, $ATools)  {
    $t=0;
    // Emit Tools
    for ($t=0;$t<sizeof($ATools);++$t)
      $this->ToolsEmit($ATools[$t],$Tag);
  }

  // Parses evary JsTool (Standard tool) added to the Chart
  function EmitJsTools($Tag, $AJsTools)  {
    $t=0;
    // Emit JsTools
    for ($t=0;$t<sizeof($AJsTools);++$t)
      $this->JsToolsEmit($AJsTools[$t],$Tag);
  }

  function ApplyScrollerTool($JsTool,$Tag,$tmp)  {
    $this->jstext->addLine('');     
    $this->jstext->addLine('  var tool'.sizeof($JsTool->getChart()->getJsTools()).';');
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'= new Tee.Scroller("canvas'.(sizeof($JsTool->getChart()->getJsTools())+1) .'",'.$this->getChartName().');');
    if ($JsTool->getOnChanging()!="")
      $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.onChanging='.$JsTool->getOnChanging());    
  }

  function ApplyCursorTool($JsTool,$Tag,$tmp)  {
    $this->jstext->addLine('');      
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'= new Tee.CursorTool('.$this->getChartName() .');');

    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.format.stroke.size='.$JsTool->getPen()->getWidth().';');
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.format.stroke.fill="'.$this->HtmlColor($JsTool->getPen()->getColor()).'";');
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.direction="'.$JsTool->getDirection().'";');
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.followmouse='.($JsTool->getFollowMouse() ? "true":"false").';');
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.render="'.$JsTool->getRender().'";');
    
    if ($JsTool->getOnChange!="")
      $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.onchange='.$JsTool->getOnChange());    
        
    $this->jstext->addLine('  '.$this->getChartName().'.tools.add(tool'.sizeof($JsTool->getChart()->getJsTools()).');');       
  }
      
  function ApplySliderTool($JsTool,$Tag,$tmp)  {
    $this->jstext->addLine('');      
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'= new Tee.Slider('.$this->getChartName().');');
    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.min='.$JsTool->getMin().';');    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.max='.$JsTool->getMax().';');    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.position='.$JsTool->getPosition().';');    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.useRange='.($JsTool->getUseRange() ? "true":"false").';');    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.thumbSize='.$JsTool->getThumbSize().';');    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.horizontal='.($JsTool->getHorizontal() ? "true":"false").';');    

    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.bounds.x='.$JsTool->getBounds()->getLeft().';');    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.bounds.y='.$JsTool->getBounds()->getTop().';');    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.bounds.width='.$JsTool->getBounds()->getWidth().';');    
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.bounds.height='.$JsTool->getBounds()->getHeight().';');    
    
    if ($JsTool->getOnChanging!="")
      $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'.onChanging='.$JsTool->getOnChanging());    
    
    $this->jstext->addLine('  '.$this->getChartName().'.tools.add(tool'.sizeof($JsTool->getChart()->getJsTools()).');');           
  }
      
  function ApplyToolTip($JsTool,$Tag,$tmp)  {
    $this->jstext->addLine('');      
    $this->jstext->addLine('  tool'.sizeof($JsTool->getChart()->getJsTools()).'= new Tee.ToolTip('.$this->getChartName().');');
    
    $this->jstext->addLine('  '.$tmp.'format.font.style="'. $JsTool->getFont()->getSize().'px '. $JsTool->getFont()->getName().'";    ');
    $this->jstext->addLine('  '.$tmp.'format.font.fill="'. $this->HtmlColor($JsTool->getFont()->getColor()).'";    ');
    $this->jstext->addLine('  var scaling=0, poindex=-1; ');   

    $this->jstext->addLine('');
    $this->jstext->addLine('  '.$this->getChartName().'.tools.add('.'tool'. sizeof($JsTool->getChart()->getJsTools()) .');');
    
    if ($JsTool->getOnShow()!="")
          $this->jstext->addLine('  '.$tmp.'onshow='.$JsTool->getOnShow());

    if ($JsTool->getOnHide()!="")
          $this->jstext->addLine('  '.$tmp.'onhide='.$JsTool->getOnHide());
          
    if ($JsTool->getOnGetText()!="")
          $this->jstext->addLine('  '.$tmp.'ongettext='.$JsTool->getOnGetText());
    
    /*
    // For each series add ToolTip
    for ($i=0;$i<sizeof($JsTool->getChart()->getSeries());++$i)
    {
        $this->jstext->addLine('  '.$this->getChartName().'.series.items['.$i.'].pointer.transform=function(x,y,index) {');
        $this->jstext->addLine('  var p='.$this->getChartName().'.series.items['.$i.'].pointer;');

        $this->jstext->addLine('  if ((scaling!=0) && (poindex==index)) {');
        $this->jstext->addLine('  '.$this->getChartName().'.ctx.translate(-x,-y);');
        $this->jstext->addLine('  '.$this->getChartName().'.ctx.scale(scaling,scaling);');
        $this->jstext->addLine('  p.format.fill="red";');
        $this->jstext->addLine('  }');
        $this->jstext->addLine('  else');
        $this->jstext->addLine('    p.format.fill='.$this->getChartName().'.series.items[0].format.fill;');
        $this->jstext->addLine('  }');
    }
    */
  }

  function ApplyAnnotationTool($Tool,$Tag,$tmp)  {
    $this->CreateNewTool($Tool,'Annotation',$Tag);

    // Fill color
    if ($Tool->getShape()->getColor()<>'clTeeColor') 
        $this->jstext->addLine($tmp.'format.fill="'.$this->HtmlColor($Tool->getShape()->getColor()).'";');
     
    // Stroke (pem) color
    if ($Tool->getShape()->getPen()->getColor()<>'clTeeColor') 
       $this->jstext->addLine($tmp.'format.stroke.color="'.$this->HtmlColor($Tool->getShape()->getPen()->getColor()).'";');

    // Font style
    $this->jstext->addLine($tmp.'format.font.style="'.(Round($Tool->getShape()->getFont()->getSize()*96/72)).'px '.$this->FontStyle($AFont->Style).$Tool->getShape()->getFont()->getFontName().'";');
    
    // Font Fill Color  
    $this->jstext->addLine($tmp.'format.font.fill="'.$this->HtmlColor($Tool->getShape()->getFont()->getColor()).'";');
  
    // Annotation Text
    $this->jstext->addLine($tmp.'text="'.$Tool->getText().'";');

    // Annotation positions
    $this->jstext->addLine($tmp.'position.x='.$Tool->getTop().';');
    $this->jstext->addLine($tmp.'position.y='.$Tool->getLeft().';');
  
    $this->jstext->addLine('  '.$this->getChartName().'.tools.add('.'tool'. sizeof($Tool->getChart()->getTools()) .');');
  }

  // Main method 
  function AddStrings($Chart, &$s)  {
    $this->jstext=&$s;
    
    $this->jstext->addLine('<!DOCTYPE html>');
    $this->jstext->addLine('<head>');
    $this->jstext->append('<title>'.$this->getChartName().'</title>');
    $this->jstext->addLine('<script src="'.self::$PathToScript.'" type="text/javascript"></SCRIPT>');
    
    // TODO This should be added just in case some tools added requires it
    $this->jstext->addLine('<script src="'.self::$PathToExtraScript.'" type="text/javascript"></SCRIPT>');
    
    $this->jstext->addLine('<script type="text/javascript">');
    $this->jstext->addLine('var '.$this->getChartName().';');
    $this->jstext->addLine('function draw() {');
    $this->jstext->addLine('  '.$this->getChartName().'=new Tee.Chart("canvas");');

    $this->jstext->addLine('  '.$this->getChartName().'.zoom.enabled='.$this->ToBool($Chart->getZoom()->getActive()).';');
    $this->jstext->addLine('  '.$this->getChartName().'.scroll.enabled='.$this->ToBool($Chart->getScroll()->getActive()).';');
    $this->jstext->addLine('  '.$this->getChartName().'.scroll.mouseButton='.$Chart->getScroll()->getMouseButton().';');
    $this->jstext->addLine('  '.$this->getChartName().'.scroll.direction="'.$Chart->getScroll()->getDirection().'";');
    
    $this->EmitPanel('  '.$this->ChartName.'.panel',$Chart->getPanel());
    $this->EmitWalls('  '.$this->ChartName.'.walls',$Chart->getWalls());
      
    $this->EmitGradient('  '.$this->getChartName().'.format.gradient',$Chart->getPanel()->getGradient());

    $this->EmitTitle($this->getChartName().'.title',$Chart->getTitle());
    $this->EmitTitle($this->getChartName().'.footer',$Chart->getFooter());
    $this->EmitAxes('  '.$this->getChartName().'.axes',$Chart->getAxes());    
    $this->EmitSeries('  '.$this->getChartName().'.',$Chart->getSeries());
    $this->EmitLegend('  '.$this->getChartName().'.legend',$Chart->getLegend());

    // Emit Tools
    $this->EmitTools('  '.$this->getChartName().'.',$Chart->getTools());

    // Emit JsTools
    $this->EmitJsTools('  '.$this->getChartName().'.',$Chart->getJsTools());
    
    // Draw Chart
    $this->jstext->addLine('  '.$this->getChartName().'.draw();');
    $this->jstext->addLine('}');
    
    // Add functions in case tools are used
    if (sizeof($Chart->getTools())>0)
    {
      for ($t=0;$t<sizeof($Chart->getTools());++$t)
      {
        if ($Chart->getTool($t) instanceof MarksTip) 
          $this->AddToolTipFunction('tool'.($t+1));
      }
    }    
    
    $this->jstext->addLine('</script>');
    $this->jstext->addLine('</HEAD>');
    $this->jstext->addLine('<BODY onload="draw()">');
    $this->jstext->addLine('<canvas id="canvas" width="600" height="400">');
    $this->jstext->addLine('This browser does not seem to support HTML5 Canvas.');
    $this->jstext->addLine('</canvas>');
    
    // Add canvas in case scroller tool is used
    if (sizeof($Chart->getJSTools())>0)
    {
      for ($t=0;$t<sizeof($Chart->getJSTools());++$t)
      {
        if ($Chart->getJsTools()->getJsTool($t) instanceof Scroller) 
       {
            $this->jstext->addLine('</br>');            
            $this->jstext->addLine('<canvas id="canvas' . ($t+2) . '" width="504" height="100" style="margin-left : 55px;">');
            $this->jstext->addLine('This browser does not seem to support HTML5 Canvas.');
            $this->jstext->addLine('</canvas>');
            $this->jstext->addLine('<span id="data"/>');
        }
      }
    }    
    
    $this->jstext->addLine('</BODY>');
    $this->jstext->addLine('</HTML>');
  }
                      
  // Add extra function at the end to the use of Tooltip tool     
  function AddToolTipFunction($tool)  {
    $this->jstext->addLine('');    
    $this->jstext->addLine('$(function() {');
    $this->jstext->addLine('  $( "#delay" ).slider( {');
    $this->jstext->addLine('      max: 10000,');
    $this->jstext->addLine('      value: 1000,');
    $this->jstext->addLine('      slide: function( event, ui ) {');
    $this->jstext->addLine('         '.$tool.'.delay= parseFloat(ui.value);');
    $this->jstext->addLine('         document.getElementById("pdelay").textContent='.$tool.'.delay.toFixed(0);');
    $this->jstext->addLine('         '.$this->getChartName().'.draw();');
    $this->jstext->addLine('      }');
    $this->jstext->addLine('  });');
    $this->jstext->addLine('});');
  }

  /// <summary>
  /// Save Chart to stream with Data export format
  /// </summary>
  public function writeData($fw,$st) {
    fwrite($fw, $st->toString());
    fclose($fw);
  }
  
  function SaveToFile($Chart, $fileName)  {                         
        $st = new StringBuilder();
        $this->AddStrings($Chart,$st);

        $f= fopen($fileName,'w');
        if($f==false)
        {
              die("Unable to create file");
        }
        else
        {
          if (file_exists($fileName)) {
            $this->writeData($f,$st);
          }
          else
          {
            $this->writeData($f,$st);
          }
        }
  }
 }
?>