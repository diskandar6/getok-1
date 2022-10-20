<?php

 /**
 * Description:  This file contains the following class:<br>
 * CanvasFlex class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
 /**
 * CanvasFlex class
 *
 * Description: Class with all Flex canvas drawing methods.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
  class Graphics3DFlex extends GraphicsGD 
  {
    # private members
    private $iAddedInitApp;
    private $iApplication;
    private $iScript;
    private $iIdent;
    private $iTransp;
    private $iImageID;
    private $iSmallDots;
    private $iPath=Array();
	private $iItems=Array();
    private $embeddedImages;
    private $imagePath;
    private $fStream;
    private $tipString;       

    public function __construct($fhandle,$c)  {
      parent::__construct($c, $c->getWidth(), $c->getHeight());
      $this->iCanvasType = "Flex"; 
      $this->fStream=$fhandle;
      $this->supportsID = true;
      $this->embeddedImages = true;
      $this->iPath = Array();
      $this->iItems = Array();
      $this->iImageID = 0;
    }
    
    public function __destruct()    
    {        
        parent::__destruct();                
        unset($this->iAddedInitApp);
        unset($this->iApplication);
        unset($this->iScript);
        unset($this->iIdent);
        unset($this->iTransp);
        unset($this->iImageID);
        unset($this->iSmallDots);
        unset($this->iPath);
        unset($this->iItems);
        unset($this->embeddedImages);
        unset($this->imagePath);
        unset($this->fStream);
        unset($this->tipString);       
    }
    
    private function ImageSource($graphic)  {
      if ($this->EmbeddedImages)  {
        return '@Embed("' . $this->ImageFileName($graphic) . '")';
      }
      else  {
        return $this->ImageFileName($graphic);
      }
    }

    private function GraphicsExtension($format)  {                             
      if ($format == ImageExport::getEMF())  {
        return "emf";
      }
      else if ($format == ImageExport::getGIF())  {
        return "gif";
      }
      else if ($format == ImageExport::getJPEG())  {
        return "jpg";
      }
      else if ($format == ImageExport::getTIFF())  {
        return "tif";
      }
      else  {
        return "png";
      }
    }

    private function CalcResult($tmp)  {
      $tmpExt = $this->GraphicsExtension($tmp->RawFormat);

      $result = "TeeChart_Flex_Temp_" . $this->iImageID . "." . $tmpExt;
      ++$this->iImageID;

      $tmp->Save($this->ImagePath . "/" . $result);

      return $result;
    }

    private function ImageFileName($graphic)  {
      if ($graphic->RawFormat == ImageExport::getPNG())  {
        $format = new JPEGFormat($this->Chart);
        /*MemoryStream ms = new MemoryStream();
        Bitmap bmp = new Bitmap(graphic);
        format.Save(ms, bmp, bmp.Width, bmp.Height);
        bmp = new Bitmap(ms);*/
        return $this->CalcResult($bmp);
      }
      else  {
        return $this->CalcResult($graphic);
      }
    }

    private function FlexSize($R)  {
      return $this->FlexSizeWH($R->Width, $R->Height);
    }

    private function FlexSizeWH($w, $h)  {
      return 'width="' . MathUtils::round($w) . '" height="' . MathUtils::round($h) . '"';
    }

    private function ParseSeriesID($ID)  {
      $result = false;

	  if (strpos($ID,"Series") != false)  {
        $ID = str_replace('""',"",$ID);
        $elements = Split('_',$ID);
        
        // TODO  must work for all Series... now just work for 0 index
        // $seriesIndex = str_replace("Series", "", $elements[1]) - 1;
        $seriesIndex = 0;
        
        for ($tt=0; $tt < sizeof($elements); ++$tt)   {
           if (strstr($elements[$tt], 'SeriesPointer')!= false)   {
              $srsPtrIndx = $tt;
              break; 
           }   
        }
        
        if (sizeof($elements) > 4) 
          $valueIndex=(int)$elements[4];
        else
          $valueIndex=(int)0;
          /*
          $srsPtrIndx = array_search('id=\"SeriesPointer', $elements); //  strpos($elements, "SeriesPointer");
          $valueIndex = (int)($elements[2]);        
          if ($srsPtrIndx > (sizeof($elements) - 3 ))  // - 2   before
          {
            $valueIndex += $elements[$srsPtrIndx + 1];
          }
          */

        for ($i = 0; $i < sizeof($this->getChart()->getTools()); $i++)  {
          if ($this->Chart->Tools[$i]->Active && $this->chart->getTool($i) instanceof MarksTip)  {
            $marksTip = $this->chart->getTool($i);
						if ($marksTip->series == $this->chart->getSeries($seriesIndex) || $marksTip->series == null)
            {
              $series = $this->chart->getSeries($seriesIndex);
              $result = true;

              $tmpStyle = $series->getMarks()->getStyle();
              $tmpOld = $this->chart->getAutoRepaint();
              $this->chart->autoRepaint = false;
              $series->getMarks()->style = $marksTip->getStyle();

              $this->tipString = $series->getValueMarkText($valueIndex);
                                               
              $series->getMarks()->style = $tmpStyle;
              $this->chart->autoRepaint = $tmpOld;
            }
          }
        }
      }
      return $result;
    }

    private function AddAnimation($ID)  {
      $result = "";
      $this->tipString = "";
      $ineffect = "";
      $outeffect = "";

	  if ($this->isMarksTip)      
        if ($this->ParseSeriesID($ID))  {
          $result = ' toolTip="' . $this->tipString . '"';        
        }
        
      if (sizeof($this->chart->animations) > 0)      
        for ($i = 0; $i < sizeof($this->chart->animations); $i++)  {
          $animation = $this->chart->animations[$i];
          switch ($animation->trigger)  {
            case AnimationTrigger::$MouseClick:
              $ineffect = "mouseDownEffect";
              $outeffect = "mouseUpEffect";
              break;
            case AnimationTrigger::$MouseOver:
              $ineffect = "rollOverEffect";
              $outeffect = "rollOutEffect";
              break;
          }

          if ($animation instanceof Expand) {
            $strTarget = '';
            switch ($animation->target)  {
                    case 0:
                        $strTarget ='None';
                        break;
                    case 1:
                        $strTarget ='Legend';
                        break;
                    case 2:
                        $strTarget ='Axis';
                        break;
                    case 3:
                        $strTarget ='Series';
                        break;
                    case 4:
                        $strTarget ='Header';
                        break;
                    case 5:
                        $strTarget ='Foot';
                        break;
                    case 6: 
                        $strTarget ='ChartRect';
                        break;
                    case 7:
                        $strTarget ='SeriesMarks';
                        break;
                    case 8:
                        $strTarget ='SeriesPointer';
                        break;
                    case 9:
                        $strTarget ='SubHeader';
                        break;
                    case 10:
                        $strTarget ='SubFoot';
                        break;
                    case 11:
                        $strTarget ='AxisTitle';
                        break;
                    default:
                        break;
            }
                              
		    if (strpos($ID,$strTarget) != false) {
                if (strpos($ID,'Chart_Series') != false)        
    			    $result .= ' ' . $ineffect . ' ="{teeexpand}" ' . $outeffect . ' ="{teeunexpand}"';
            }
          }
        }
        
      return $result;
    }

    private function AddTag($ATag, $AText)  {
      $ID = $this->TheID();
      $this->AddToStream($this->iIdent . '<' . $ATag . $ID . ' ' . $AText . $this->AddAnimation($ID) . '/>');
    }

    private function CalcAlpha($penOnly)  {
      if ($penOnly)  {
        return $this->Pen->Transparency;
      }
      else  {
        if ($this->Brush->Visible)  {
          return $this->Brush->Transparency;
        }
        else if ($this->Pen->Visible)  {
          return $this->Pen->Transparency;
        }
        else  {
          return 0;
        }
      }
    }                                   

    private function TheID()  {
      $result = "";
      $tmpID = $this->CurrentID();
      $tmp = 0;
      $this->isMarksTip = false;         

      if (strstr($tmpID, 'SeriesPointer_') !=false) 
        if (strstr($tmpID, 'Chart_Series') !=false)  {
          $series_index = substr($tmpID,12,1);
          
          for ($t = 0; $t < sizeof($this->chart->getTools()); $t++) {
            $s = $this->chart->getTool($t);
            if ($s->getActive()) {
                if ($s instanceof MarksTip) {
                   //if ($s->getSeries() ==)
                   $this->isMarksTip = true; 
                   //$tmpID = "";
                }                 
            }                                              
          }  
      }
      
	/*  if (strpos($tmpID,"MarksTip_") != false)  {
        $this->isMarksTip = true;
        $tmpID = str_replace("MarksTip_", "",$tmpID);
      }
      else  {
        $this->isMarksTip = false;
      }
   */
      $result = $tmpID;
      while( (in_array( $result, $this->iItems )) != FALSE )  {
        ++$tmp;
        $result = $tmpID . "_" . $tmp;
      }
            
      $this->iItems[]=$result;
      return ' id="' . $result . '"';
    }
    
    private function CurrentID()  {
      $tmpStr="";
      if (sizeof($this->iPath) == 0) {
        if ($this->Chart->Parent != null)  {
           // TODO 
           // If we wanto display the name of the component which references to the
           // mxml file lines we have to add a Control property into the TChart class
           // for example and set and assign each class name to it at the time it's 
           // instanced.
          //$tmpStr .= get_class($this->getChart()->getParent()) . "_";   
          $tmpStr .= TChart::$controlName . "_";
        }
        else  {
          $tmpStr .= "Chart";
        }
      }
      else  {
        $tmpStr->Append($this->iPath[0]);
      }

      for ($i = 1; $i < sizeof($this->iPath); $i++)  {
        $tmpStr .= "_" . $this->iPath[$i];
      }
      return $tmpStr;
    }

    private function PenWidth()  {
      if ($this->Pen->Width == 1)  {
        return "";
      }
      else  {
        return ' strokeWidth="' . $this->Pen->Width . '"';
      }
    }

    private function BrushColor()  {
      if ($this->Brush->Visible)  {
        if ($this->Brush->Gradient->Visible)  {
          return $this->FlexGradient($this->Brush->Gradient);
        }
        else  {
          return " brushColor=" . $this->FlexColor($this->Brush->Color); ;
        }
      }
      else  {
        return ' brushColor=""';
      }
    }

    private function GradientDirection($direction)  {
      $result = "";

      switch ($direction)  {
        case "BackwardDiagonal":
          $result = "TopBottom";
          break;
        case "ForwardDiagonal":
          $result = "LeftRight";
          break;
        case "Horizontal":
          $result = "RightLeft";
          break;
        case "Vertical":
          $result = "BottomTop";
          break;
      }

      return $result;
    }

    private function FlexGradient($gradient)  {
      $tmpType = "Linear";

      return ' gradientType="' . $tmpType . '" ' .
          'gradientDir="' . $this->GradientDirection($gradient->Direction) . '" ' .
          "startColor=" . $this->FlexColor($gradient->StartColor) . " " .
          "endColor=" . $this->FlexColor($gradient->EndColor) . " ";
    }

    private function PenColor()  {
      if ($this->getPen()->getVisible())  {
        return ' strokeColor=' . $this->FlexColor($this->getPen()->getColor()); 
      }
      else  {
        return ' strokeColor=""';
      }
    }

    private function ColorInternal($color)  {
      switch ($color)  {
        case Color::Black():
          $result = "black";
          break;
        case Color::Blue():
          $result = "blue";
          break;
        case Color::Fuchsia():
          $result = "fuchsia";
          break;
        case Color::Gray():
          $result = "gray";
          break;
        case Color::Green():
          $result = "green";
          break;
        case Color::Lime():
          $result = "lime";
          break;
        case Color::Maroon():
          $result = "maroon";
          break;
        case Color::Navy():
          $result = "navy";
          break;
        case Color::Olive():
          $result = "olive";
          break;
        case Color::Purple():
          $result = "purple";
          break;
        case Color::Red():
          $result = "red";
          break;
        case Color::Silver():
          $result = "silver";
          break;
        case Color::Teal():
          $result = "teal";
          break;
        case Color::White():
          $result = "white";
          break;
        case Color::Yellow():
          $result = "yellow";
          break;
        default:
          $result = "0x" . self::rgbhex($color->getRed(), $color->getGreen(), $color->getBlue());
          break;
      }

      return $result;
    }

    // Converts RGB color to Hex
    static function rgbhex($red,$green,$blue) {
      $red = dechex($red);
      $green = dechex($green);
      $blue = dechex($blue);

      return strtoupper($red.$green.$blue);
    }
    
    private function FlexColor($aColor)  {
      return '"' . $this->ColorInternal($aColor) . '"';
    }

    private function FlexAlpha($transparency)  {
      if ($transparency == 0)  {
        return "";
      }
      else  {
        return ' alpha="' . $this->FloatToStr(1.0 - ($transparency / 100.0)) . '"';
      }
    }

    private function FlexPoints($Points)  {
      //tmpStr.Length = 0;
      $tmpStr->Append('points="[');

      if (sizeof($Points) > 0)  {
        $tmpStr->Append($this->$Points[0]);

        for ($i = 1; $i < sizeof($Points); $i++)  {
          $tmpStr->Append("," . $this->$Points[$i]);
        }
      }

      $tmpStr->Append(']"');
      return $tmpStr;
    }
 
    private function FontStyle($AFont)  {
      if ($AFont->Italic)  {
        return ' fontStyle="italic" ';
      }
      else  {
        return "";
      }
    }

    private function FontWeight($AFont)  {
      if ($AFont->Bold)  {
        return ' fontWeight="bold" ';
      }
      else  {
        return "";
      }
    }

    private function TextDecoration($AFont)  {
      if ($AFont->Underline)  {
        return ' textDecoration="underline" ';
      }
      else  {
        return "";
      }
    }

    private function FlexFont($AFont)  {
      return $this->FontStyle($AFont) .
          $this->FontWeight($AFont) .
          ' fontSize="' . (int)($AFont->Size/* * 1.2*/) . '" ' .
          $this->TextDecoration($AFont) .
          ' fontFamily="Verdana" ' .
          ' color=' . $this->FlexColor($AFont->Color) . " ";
    }

    #region protected and internal members
	private $IPath=Array();
    /*
    #if BLOCK
        protected internal override TVisualBlock BeginEntity(string Entity, TVisualBlock Visual)
        {
          TVisualBlock Result = Visual;
          this.iPath.Add(Entity);
          this.iIdent = this.iIdent + " ";
          return Result;
        }
    #elif SILVERLIGHT || WPF
        protected internal override UIElement BeginEntity(string Entity, UIElement Visual)
        {
          UIElement Result = Visual;
          this.iPath.Add(Entity);
          this.iIdent = this.iIdent + " ";
          return Result;
        }
    #else
        protected internal override object BeginEntity(string Entity, object Visual)
        {
          this.iPath.Add(Entity);
          this.iIdent = this.iIdent + " ";
          return Visual;
        }
    #endif

    protected internal override function EndEntity()  {
      this.iPath.RemoveAt(this.iPath.Count - 1);
      this.iIdent = this.iIdent.Remove(0, 1);
    }
     */
    private function AddAnimationTypes()  {
      //Animation animation;
      if (sizeof($this->chart->getAnimations()) > 0)  {
        for ($i = 0; $i < sizeof($this->chart->getAnimations()); $i++)  {
          $animation = $this->chart->getAnimation($i);
          if ($animation instanceof Expand)  {
            $expand = $animation;
            $this->AddToStream('    <mx:Parallel id="teeexpand">');
            $this->AddToStream('        <mx:children>');
            $this->AddToStream('            <mx:Move duration="' . $expand->getSpeed() . 
                    '" suspendBackgroundProcessing="true"	xBy="-' . 
                    ($expand->getSizeBy() / 2) . '" yBy="-' . ($expand->getSizeBy() / 2) . 
                    '"/>');
            $this->AddToStream('            <mx:Resize duration="' . $expand->getSpeed() . 
                     '" suspendBackgroundProcessing="true" widthBy="' . 
                     $expand->getSizeBy() . '" heightBy="' . 
                     $expand->getSizeBy() . '"/>');
            $this->AddToStream('        </mx:children>');
            $this->AddToStream('    </mx:Parallel>');
            $this->AddToStream('    <mx:Parallel id="teeunexpand">');
            $this->AddToStream('        <mx:children>');
            $this->AddToStream('            <mx:Resize duration="' . $expand->getSpeed() . 
                    '" suspendBackgroundProcessing="true" widthBy="-' . 
                    $expand->getSizeBy() . '" heightBy="-' . 
                    $expand->getSizeBy() . '"/>');
            $this->AddToStream('            <mx:Move duration="' . $expand->getSpeed() . 
                    '" suspendBackgroundProcessing="true" xBy="' . 
                    ($expand->getSizeBy() / 2) . '" yBy="' . ($expand->getSizeBy() / 2) . 
                    '"/>');
            $this->AddToStream('        </mx:children>');
            $this->AddToStream('    </mx:Parallel>');
          }
        }
      }
    }

    /// <summary>
    /// Adds canvas instruction to stream.
    /// </summary>
    /// <param name="text">Instructions to be added to stream.</param>
    protected function AddToStream($text)  {
        $linetext = $text . "\r\n";
        fwrite($this->fStream,$linetext);
        fflush($this->fStream);
    }
        
    private $isMarksTip;

    private function AddMarksTip()  {
      $hasMarksTip = false;
      if (sizeof($this->chart->getTools()) > 0)  {
        for ($i = 0; $i < sizeof($this->chart->getTools()); $i++)  {
          if ($this->chart->getTool($i)->active && $this->chart->getTool($i) instanceof MarksTip)  {
            $hasMarksTip = true;
            break;
          }
        }
      }

      if ($hasMarksTip)  {
        $this->AddToStream('    <mx:Script>');
        $this->AddToStream('        <![CDATA[');
        $this->AddToStream('        import mx.managers.ToolTipManager;');
        $this->AddToStream('        import com.steema.graphics.HtmlToolTip;');
        $this->AddToStream('        ToolTipManager.toolTipClass = HtmlToolTip;');
        $this->AddToStream('       ]]>');

        //iScript = 

        $this->AddToStream('    </mx:Script>');
        $this->AddToStream('    <mx:Style>');
        $this->AddToStream('      HtmlToolTip {');
        $this->AddToStream('        fontFamily: "Verdana";');
        $this->AddToStream('        fontSize: 12;');
        $this->AddToStream('        fontStyle: "normal";');
        $this->AddToStream('        color: #000000;');
        $this->AddToStream('        backgroundColor: #FFFFFF;');
        $this->AddToStream('      }');
        $this->AddToStream('    </mx:Style>');
      }
    }

    public /*protected */ function InitWindow($a, $r, $MaxDepth)  {
      parent::initWindow($a,$r,$MaxDepth);

      $this->iAddedInitApp = false;

      $this->AddToStream('<?xml version="1.0"?>');
      $this->AddToStream('<!-- Generated by TeeChart for .NET -->');
      $this->AddToStream('<mx:Application xmlns:mx="http://www.adobe.com/2006/mxml"');
      $this->AddToStream('                xmlns:tee="com.steema.graphics.*"');
      $this->AddToStream('                ' . $this->FlexSize($r));
      $this->AddToStream('                paddingTop="0"');
      $this->AddToStream('                paddingBottom="0"');
      $this->AddToStream('                paddingRight="0"');
      $this->AddToStream('                paddingLeft="0"');
      $this->AddToStream('>');

      //iApplication = swFromStream.

      $this->AddMarksTip();
      $this->AddAnimationTypes();

      $this->AddToStream('    <mx:Canvas ' . $this->FlexSize($r) . ' horizontalScrollPolicy = "off" verticalScrollPolicy = "off">');
    }

    // TODO search original net file for pointtostr
    protected function PointToStr($X, $Y)  {
      return 'x="' . (int)$X . '" y="' . (int)$Y . '"';
    }

    public function ShowImage($g) {
      $this->AddToStream('    </mx:Canvas>');
      $this->AddToStream('</mx:Application>');
    }

    protected function TransparentEllipse($x1, $y1, $x2, $y2)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function textOut($x, $y, $z, $text, $align=-1)   {
        $font=$this->getFont();
        $fontFileName = $font->getName();

        $fontSize = $font->getFontSize();
        $lineSpacing = 1;

        $textWidth =  $this->textWidth($text); //  $lrx - $llx;
        $textHeight = $this->textHeight("W"); //  $fontSize; // $lry - $ury;
        $angle = 0;
                
        if ($align==-1) {
           $align = $this->getTextAlign();
        }
                                  
        if (in_array(StringAlignment::$HORIZONTAL_CENTER_ALIGN, $align)) {
            $x -= ($textWidth / 2);
        }
        else
        if (in_array (StringAlignment::$HORIZONTAL_RIGHT_ALIGN, $align)) {
            $x -= $textWidth;
        }

        /*
        if (in_array (StringAlignment::$VERTICAL_CENTER_ALIGN, $align)) {
            $y += $textHeight - 3;
        }
        if (in_array (StringAlignment::$VERTICAL_TOP_ALIGN, $align)) {
            $py += $textHeight;
        }
        else
        if (in_array (StringAlignment::$VERTICAL_BOTTOM_ALIGN, $align)) {
            $y += $textHeight + 3;
        } */
                
      if (in_array (StringAlignment::$FAR, $align))  {
        $x -= MathUtils::round($this->TextWidth($text));
      } 
      else 
      if (in_array (StringAlignment::$CENTER, $align)) {
        //$x += MathUtils::round($this->TextWidth($text) / 2.0);
        $y -= MathUtils::round($this->TextHeight($text) / 2.0);        
      }
      
      $this->AddTag("mx:Label", 'text="' . $text . '" ' . $this->PointToStr($x, $y) .
       $this->FlexFont($this->Font) . ' textAlign="left"');
    }

    private function RXY($r) {
      return 'rx="' . '8' . '" ry="' . '8' . '"';
    }

    public function rectangle($r) {        
      if ($this->getBrush()->getImage() != null)  {
        // TODO $this->Draw($r, $b->Image, $b->ImageTransparent);
      }
      else  {          
        if ($this->getChart()->getPanel()->getBorderRound() > 0)  {
          $this->AddTag("tee:RoundRect", $this->PointToStr($r->X, $r->Y) . " " . $this->FlexSize($r) . " " . $this->RXY($r) .
            $this->FlexAlpha($this->CalcAlpha(false)) . $this->PenColor() . $this->BrushColor() . $this->PenWidth());
        }
        else  {
          $this->AddTag("tee:Rectangle", $this->PointToStr($r->X, $r->Y) . " " .
             $this->FlexSize($r) . $this->FlexAlpha($this->CalcAlpha(false)) . $this->PenColor() . $this->BrushColor() . $this->PenWidth());
        }
      }
    }
  
    public function getEmbeddedImages() {
         return $this->embeddedImages; 
    }
    
    public function setEmbeddedImages($value) {
          $this->embeddedImages = $value; 
    }
    
    public function getImagePath() {
        return $this->imagePath; 
    }
    
    public function setImagePath($value) {
        $this->imagePath = $value; 
    }

    public function arc($x1, $y1, $x2, $y2, $startAngle, $sweepAngle,$filled=0)  {
      if ($this->Pen->Visible)  {
        $this->AddTag("tee:Arc",
          'x0="' . $x1 . '" y0="' . $y1 . '" ' .
          'x1="' . $x2 . '" y1="' . $y2 . '" ' .
          'startAngle="' . $this->FloatToStr($startAngle) .
          '" endAngle="' . $this->FloatToStr($startAngle . $sweepAngle) . '" ' .
          $this->FlexAlpha($this->CalcAlpha(true)) .
          $this->PenColor() .
          $this->PenWidth());
      }
    }
    
    public function _Arc($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4)  {
      if ($this->Pen->Visible)  {
        $this->CalcArcAngles($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4, $start, $sweep);
        $this->Arc((int)$x1, (int)$y1, (int)$x2, (int)$y2, (float)$start, (float)$sweep);
      }
    }

    public function FillRegion($brush, $region)  {
        Utils::MsgErrorException('The method or operation is not implemented.');        
    }

    public function ellipse($x1, $y1, $x2, $y2, $z=0, $angle=0)  {
      if($z>0) {
        $p1 = $this->calc3DPos($x1, $y1, $z);
        $p2 = $this->calc3DPos($x2, $y2, $z);
        $this->ellipsePoints($p1,$p2);
      }
      else  {
        if ($angle>0) {
          $p = Array();

          $points = Array();
          for ($t = 0; $t < 3; $t++) {
              $points[$t] = new TeePoint();
          }

          $xCenter = ($x2 + $x1) * 0.5;
          $yCenter = ($y2 + $y1) * 0.5;
          $xRadius = ($x2 - $x1) * 0.5;
          $yRadius = ($y2 - $y1) * 0.5;

          $angle *= M_PI / 180.0;
          $tmpPiStep = 2 * M_PI / (self::$NUMCIRCLEPOINTS - 1);

          // initial rotation (rotation matrix elements)
          $tmpSinAngle = sin($angle);
          $tmpCosAngle = cos($angle);

          for ($t = 0; $t < self::$NUMCIRCLEPOINTS; $t++) {
            $tmpSin = sin($t * $tmpPiStep);
            $tmpCos = cos($t * $tmpPiStep);
            $tmpX = $xRadius * $tmpSin;
            $tmpY = $yRadius * $tmpCos;

            $p[$t] = new TeePoint(
                    MathUtils::round($xCenter +
                                          ($tmpX * $tmpCosAngle +
                                           $tmpY * $tmpSinAngle)),
                    MathUtils::round($yCenter +
                                          ( -$tmpX * $tmpSinAngle +
                                           $tmpY * $tmpCosAngle))
                   );
          }

          if ($this->getBrush()->getVisible()) {
            $old = $this->getPen()->getVisible();
            $this->getPen()->setVisible(false);

            $xc = MathUtils::round($xCenter);
            $yc = MathUtils::round($yCenter);

            for ($t = 1; $t < self::$NUMCIRCLEPOINTS; $t++) {
                // has to be in loop because the Polygon
                // transforms the positions from 3d to 2d in each pass
                $points[0]->setX($xc);
                $points[0]->setY($yc);
                $points[1] = $p[$t - 1];
                $points[2] = $p[$t];
                $this->polygon($z, $points);
            }
            // close it up with polygon from last to first
            $points[0]->setX($xc);
            $points[0]->setY($yc);
            $points[1] = $p[self::$NUMCIRCLEPOINTS - 1];
            $points[2] = $p[0];
            $this->polygon($z, $points);
            
            $this->getPen()->setVisible($old);
          }
          if ($this->getPen()->getVisible()) {
            $this->polyLine($z, $p);
          }
        }
        else  {
         // updates x,y,width,height to be used in imagefilledellipse correctly
          
          //$x1=$x1+(($x2-$x1) / 2);
          //$y1=$y1+(($y2-$y1) / 2);
          $tmpWidth=((int)$x2-(int)$x1); //*2;
          $tmpHeight=((int)$y2-(int)$y1); //*2;          
          
          /*$x1=(int)$x1+(((int)$x2-(int)$x1));
          $y1=(int)$y1+(((int)$y2-(int)$y1));
          $tmpWidth=((int)$x2-(int)$x1);
          $tmpHeight=((int)$y2-(int)$y1);
           */
          if ($this->brush->getVisible()) {             
            $this->AddTag("tee:Ellipse", $this->PointToStr((int)$x1, (int)$y1) . " " . $this->FlexSizeWH((int)$tmpWidth, (int)$tmpHeight) .
            $this->FlexAlpha($this->CalcAlpha(false)) . $this->BrushColor() . $this->PenColor() . $this->PenWidth());
          }

        }
      }
    }

    public function EraseBackground($left, $top, $right, $bottom)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function drawImage($x, $y, $image)  {
      if ($image != null)  {
        $this->AddTag('mx:Image', $this->PointToStr($x, $y) . ' source="' . $this->ImageSource($image) . '"');
      }
    }

    public function _drawImage($destRect, $srcRect, $image, $transparent)  {
      if ($image != null)  {
        $this->AddTag('mx:Image', $this->PointToStr($destRect->X, $destRect->Y) . ' ' .
          ' scaleX="' . $this->FloatToStr($destRect->Width / $image->Width) . '" ' .
          ' scaleY="' . $this->FloatToStr($destRect->Height / $image->Height) + '" ' .
          ' source="' . $this->ImageSource($image) . '"');
      }
    }

/*
    public override function Polygon(params PointDouble[] $p)
    {
      $this->AddTag("tee:Polygon", $this->FlexPoints($p) . " " .
       $this->FlexAlpha($this->CalcAlpha(false)) . $this->BrushColor() . $this->PenColor() . 
       $this->PenWidth());
    }
*/
    public function polygon($p)  {
       $this->AddTag("tee:Polygon", $this->FlexPoints($p) . " " .
       $this->FlexAlpha($this->CalcAlpha(false)) . $this->BrushColor() . $this->PenColor() .
       $this->PenWidth());
    }

    public function clipEllipse($r)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function clipPolygon($p) {                                         
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function clipRectangle($left, $top, $right, $bottom) {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function SetClipRegion($region)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function DrawPath($pen, $path)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function GradientFill($left, $top, $right, $bottom, $startColor, $endColor, $direction)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }
    
    public function Pixel($x, $y, $z, $color) {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function polyLine($z, $p) {
      $this->AddTag("tee:Polyline", $this->FlexPoints($p) . ' ' .
             $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() . $this->PenWidth());
    }

    public function rotateLabel($x, $y, $z, $text, $rotDegree)  {
      $this->DoText($x, $y, $text, $rotDegree, $this->Font->Color);
    }

    public function UnClip()  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function ClearClipRegions()  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    private function Pos0($x=null, $y=null)  {
        if (($x==null) && ($y==null)) {
            if ($this->moveToX==null) 
                $this->moveToX=0;

            if ($this->moveToY==null) 
                $this->moveToY=0;
                
          $result= 'x0="' . round($this->moveToX) . '" y0="' . round($this->moveToY) . '"';
        }
        else {
            if ($x==null) 
                $x=0;
            if ($y==null) 
                $y=0;
                            
          $result= 'x0="' . round($x) . '" y0="' . round($y) . '"';                        
        }
        return $result;
    }

    private function Pos1($x, $y)  {
      return 'x1="' . MathUtils::round($x) . '" y1="' . MathUtils::round($y) . '"';
    }

    private function DashLenGap()  {
      $len = 4;
      $gap = 4;

      switch ($this->Pen->Style)  {
        case 2:  // Dash:
          break;
        case 3:  // DashDot:
          $len = 4; $gap = 2;
          break;
        case 4:  // DashDotDot:
          $len = 4; $gap = 3;
          break;
        case 1:  // Dot:
          $len = 2; $gap = 2;
          break;
      }

      return ' len="' . $len . '" gap="' . $gap . '"';
    }

    public function LineTo($x, $y)  {
      if ($this->Pen->Style == DashStyle::$SOLID)  {
        $this->AddTag("tee:Line", $this->Pos0() . " " . $this->Pos1($x, $y) . 
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() .
          $this->PenWidth());
      }
      else  {
        $this->AddTag("tee:DashLine", $this->Pos0() . " " . $this->Pos1($x, $y) .
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() . $this->PenWidth() . 
          $this->DashLenGap());
      }

    }
    
    /**
    * Draws a straight line
    *
    * @access       public
    * @param        integer         line start (X)
    * @param        integer         line start (Y)
    * @param        integer         line end (X)
    * @param        integer         line end (Y)
    * @param        Color           line color
    * @param        integer         line width
    */

    function line($x1, $y1, $x2, $y2, $color=null, $width = -1)
    {
        if ($color==null)  {
          //$color = $this->PenColor();
        }
        
        // Assign the pen width for the image
        /* Set thickness. */
        if ($width==-1) {
          //$width = $this->pen->getWidth();
        }
        
        if ($this->Pen->Style == DashStyle::$SOLID)  {
          $this->AddTag("tee:Line", $this->Pos0($x1,$y1) . " " . $this->Pos1($x2, $y2) . 
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() .
          $this->PenWidth());
        }
        else
        {
          $this->AddTag("tee:DashLine", $this->Pos0($x1, $y1) . " " . $this->Pos1($x2, $y2) .
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() . $this->PenWidth() . 
          $this->DashLenGap());
        }      
    }

    /**
    * Draws a Line between point p0 and point p1 using specific pen.
    *
    * @param pen ChartPen id the pen used
    * @param p0 Point is origin xy
    * @param p1 Point is destination xy
    */
    public function ___line($pen, $p0, $p1) {

        $oldPen = $this->getPen();
        $this->setPen($pen);

        if ($this->Pen->Style == DashStyle::$SOLID)
        {
          $this->AddTag("tee:Line", $this->Pos0($p0->getX(),$p0->getY()) . " " . $this->Pos1($p1->getX(), $p1->getY()) . 
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() .
          $this->PenWidth());
        }
        else  {
          $this->AddTag("tee:DashLine", $this->Pos0($p0->getX(),$p0->getY()) . " " . $this->Pos1($p1->getX(), $p1->getY()) .
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() . $this->PenWidth() . 
          $this->DashLenGap());
        }   
                
        $this->setPen($oldPen);
    }

    /**
    * Draws a Line from (X,Y,Z0) to (X,Y,Z1).
    *
    * @param x int
    * @param y int
    * @param z0 int
    * @param z1 int
    */
    public function zLine($x, $y, $z0, $z1) {
        $c1 = imagecolorallocate($this->img, $this->pen->getColor()->red,
            $this->pen->getColor()->green,
            $this->pen->getColor()->blue);

        $p1=$this->calc3DPos($x, $y, $z0);
        $p2=$this->calc3DPos($x, $y, $z1);

      if ($this->Pen->Style == DashStyle::$SOLID)  {                                        
        $this->AddTag("tee:Line", $this->Pos0($p1->getX(),$p1->getY()) . " " . $this->Pos1($p2->getX(), $p2->getY()) . 
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() .
          $this->PenWidth());
      }
      else  {
        $this->AddTag("tee:DashLine", $this->Pos0($p1->getX(),$p1->getY()) . " " . $this->Pos1($p2->getX(), $p2->getY()) .
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() . $this->PenWidth() . 
          $this->DashLenGap());
      }         
    }
                
    /**
     * Draws a Horizontal at z depth position.
     *
     * @param left int
     * @param right int
     * @param y int
     * @param z int
     */
    public function horizontalLine($left, $right, $y, $z=0) {
        $p1=$this->calc3DPos($left, $y, $z);
        $p2=$this->calc3DPos($right, $y, $z);
        
      if ($this->Pen->Style == DashStyle::$SOLID) {                                        
        $this->AddTag("tee:Line", $this->Pos0($p1->getX(),$p1->getY()) . " " . $this->Pos1($p2->getX(), $p2->getY()) . 
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() .
          $this->PenWidth());
      }
      else  {
        $this->AddTag("tee:DashLine", $this->Pos0($p1->getX(),$p1->getY()) . " " . $this->Pos1($p2->getX(), $p2->getY()) .
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() . $this->PenWidth() . 
          $this->DashLenGap());
      }              
    }    
    
    /**
     * Draws a Vertical Line from (X,Top) to (X,Bottom) at z depth position.
     *
     * @param x int
     * @param top int
     * @param bottom int
     * @param z int
     */
    public function verticalLine($x, $top, $bottom, $z=0) {
        $p1=$this->calc3DPos($x, $top, $z);
        $p2=$this->calc3DPos($x, $bottom, $z);

      if ($this->Pen->Style == DashStyle::$SOLID) {
        $this->AddTag("tee:Line", $this->Pos0($p1->getX(),$p1->getY()) . " " . $this->Pos1($p2->getX(), $p2->getY()) . 
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() .
          $this->PenWidth());
      }
      else  {
        $this->AddTag("tee:DashLine", $this->Pos0($p1->getX(),$p1->getY()) . " " . $this->Pos1($p2->getX(), $p2->getY()) .
          $this->FlexAlpha($this->CalcAlpha(true)) . $this->PenColor() . $this->PenWidth() . 
          $this->DashLenGap());
      }      
    }    

    public function DrawBeziers($p){
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function PrepareDrawImage()  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function AddLink($x, $y, $Text, $URL, $Hint)  {
      $this->AddTag('mx:LinkButton', 'label="' . $Text . '" ' . $this->PointToStr($x, $y) .
        ' toolTip="' . $Hint . '" ' .
        $this->FlexFont($this->Font) .
        'click="navigateToURL(new URLRequest("' . $URL . "'), '" . $Hint . '")"');
    }

    public function AddToolTip($Entity, $ToolTip)  {
      if (!$iAddedInitApp)  {
        //TODO
      }
    }
}
?>