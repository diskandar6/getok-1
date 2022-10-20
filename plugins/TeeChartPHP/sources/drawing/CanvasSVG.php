<?php
 /**
 * Description:  This file contains the following class:<br>
 * CanvasSVG class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2019 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * CanvasSVG class
 *
 * Description: Class with all SVG Canvas and Exporting.
 * SVG : Scalable Vector Graphics
 * www.w3.org/Graphics/SVG 
 * @author Steema Software SL.
 * @copyright (c) 1995-2019 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

  class CanvasSVG extends GraphicsGD 
  {
      # Private declarations 
      private $FStrings;                                     

      private $IClipCount;
      private $IClipStack;
      private $IGradientCount;

      private $IPenStyle; //    : TPenStyle;
      private $IPenWidth; //    : Integer;
      private $ITransp; //      : TTeeTransparency;

      # Public declarations 
      public $Antialias; // : Boolean;
      public $DocType;   // : String;
      public $Groups;    // : Boolean;
      public $SVGDescription; // : String;
      public $CRLF="\n";



    public function __destruct()    
    {        
        parent::__destruct();                
        
        unset($this->FStrings);
        unset($this->IClipCount);
        unset($this->IClipStack);
        unset($this->IGradientCount);
        unset($this->IPenStyle);
        unset($this->IPenWidth);
        unset($this->ITransp);
        unset($this->Antialias);
        unset($this->DocType);  
        unset($this->Groups); 
        unset($this->SVGDescription);
        unset($this->CRLF);        
    }
          
    public function CreateText($AStrings,$c) {
      parent::__construct($c, $c->getWidth(), $c->getHeight());
      $this->supportsID=true;
      $this->FStrings=$AStrings;
      $this->useBuffer=false;

      $this->antialias=true;
      $this->groups=true;
      
      // start 
      $this->Add('<?xml version="1.0" standalone="no"?>');
      $this->DocType='<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
    }
      
    private function ShowImage($DestCanvas,$DefaultCanvas, $UserRect)  {
      // finish }
      $this->Add('</svg>');
      $this->pen->OnChange=null;
    }

    function Add($S)  {
      $this->FStrings->addLine($S);
    }

    Function SVGColor($AColor) {
        $result='';
        
        switch ($AColor) {
          case Color::BLACK(): 
            $result='"black"';
            break;
          case Color::WHITE(): 
            $result='"white"';
            break;
          case Color::RED(): 
            $result='"red"';
            break;
          case Color::GREEN(): 
            $result='"green"';
            break;
          case Color::BLUE(): 
            $result='"blue"';
            break;
          case Color::YELLOW(): 
            $result='"yellow"';
            break;
          case Color::GRAY(): 
            $result='"gray"';
            break;
          case Color::NAVY(): 
            $result='"navy"';
            break;
          case Color::OLIVE(): 
            $result='"olive"';
            break;
          case Color::LIME(): 
            $result='"lime"';
            break;
          case Color::TEAL():  
            $result='"teal"';
            break;
          case Color::SILVER():  
            $result='"silver"';
            break;
          case Color::PURPLE():  
            $result='"purple"';
            break;
          case Color::FUCHSIA():  
            $result='"fuchsia"';
            break;
          case Color::MAROON():  
            $result='"maroon"';
            break;
          default:        
           $result = '"rgb('.$AColor->getRed().','.
                           $AColor->getGreen().','.
                           $AColor->getBlue().')"';
        }
        return $result;
    }

    function Rectangle($rect)  {
      $this->internalRect($rect,True);
    }
       
    function MoveToXY($X, $Y)  {        
      $this->moveToX=$X;
      $this->moveToY=$Y;
    }

    function AddEnd($s) {
      $this->Add($s.'/>');
    }
    
    
    /**
     * Draws a Cube with Dark Sides.
     *
     * @param left int
     * @param top int
     * @param right int
     * @param bottom int
     * @param z0 int
     * @param z1 int
     * @param darkSides boolean
     */
    public function cube($left, $top, $right, $bottom, $z0, $z1, $darkSides) {
        $oldColor = $this->brush->getColor();
        $p0 = $this->calc3DPoint($left, $top, $z0);
        $p1 = $this->calc3DPoint($right, $top, $z0);
        $p2 = $this->calc3DPoint($right, $bottom, $z0);
        $p3 = $this->calc3DPoint($right, $top, $z1);
        $this->iPoints[0] = $p0;
        $this->iPoints[1] = $p1;
        $this->iPoints[2] = $p2;
        $this->iPoints[3] = $this->calc3DPoint($left, $bottom, $z0);

        if ($this->culling() > 0) {
            $this->polygonFour(); // front-side
        } else {
            $this->iPoints[0] = $this->calc3DPos($left, $top, $z1);
            $this->iPoints[1] = $this->calc3DPos($right, $top, $z1);
            $this->iPoints[2] = $this->calc3DPos($right, $bottom, $z1);
            $this->iPoints[3] = $this->calc3DPos($left, $bottom, $z1);
            $this->polygonFour(); // back-side
        }

        $this->iPoints[2] = $this->calc3DPos($right, $bottom, $z1);
        $this->iPoints[0] = $p1;
        $this->iPoints[1] = $p3;
        $this->iPoints[3] = $p2;

        if ($this->culling() > 0) {
            if ($darkSides) {
                $this->internalApplyDark($oldColor, self::$DARKERCOLORQUANTITY);
            }
            $this->polygonFour(); // left-side
        }

        $this->iPoints[0] = $p0;
        $this->iPoints[1] = $this->calc3DPos($left, $top, $z1);
        $this->iPoints[2] = $this->calc3DPos($left, $bottom, $z1);
        $this->iPoints[3] = $this->calc3DPos($left, $bottom, $z0);

        $tmp = ($this->iPoints[3]->getX() - $this->iPoints[0]->getX()) *
                     ($this->iPoints[1]->getY() - $this->iPoints[0]->getY()) -
                     ($this->iPoints[1]->getX() - $this->iPoints[0]->getX()) *
                     ($this->iPoints[3]->getY() - $this->iPoints[0]->getY());

        if ($tmp > 0) {
            if ($darkSides) {
                $this->internalApplyDark($oldColor, self::$DARKERCOLORQUANTITY);
            }
            $this->polygonFour(); // right-side
        }

        $this->iPoints[3] = $this->calc3DPos($left, $top, $z1);

        // culling
        $tmp = ($p0->getX() - $p1->getX()) * ($p3->getY() - $p1->getY()) -
            ($p3->getX() - $p1->getX()) * ($p0->getY() - $p1->getY());
        if ($tmp > 0) {
            $this->iPoints[0] = $p0;
            $this->iPoints[1] = $p1;
            $this->iPoints[2] = $p3;
            if ($darkSides) {
                $this->internalApplyDark($oldColor, self::$DARKCOLORQUANTITY);
            }
            $this->polygonFour(); // top-side
        }

        $this->iPoints[0] = $this->calc3DPos($left, $bottom, $z0);
        $this->iPoints[2] = $this->calc3DPos($right, $bottom, $z1);
        $this->iPoints[1] = $this->calc3DPos($left, $bottom, $z1);

        $this->iPoints[3] = $p2;
        if ($this->culling() < 0) {
            if ($darkSides) {
                $this->internalApplyDark($oldColor, self::$DARKCOLORQUANTITY);
            }
            $this->polygonFour();
        }

        $this->brush->setColor($oldColor);    
    }
    
    /**
    * Draws a polygon (Point p1, Point p2, Point p3, Point p4) at Z depth
    * offset.
    *
    * @param p1 Point
    * @param p2 Point
    * @param p3 Point
    * @param p4 Point
    * @param z int
    */
    public function _plane($p1, $p2, $p3, $p4, $z) {
        $this->iPoints[0] = $this->calc3DPos($p1->getX(), $p1->getY(), $z);
        $this->iPoints[1] = $this->calc3DPos($p2->getX(), $p2->getY(), $z);
        $this->iPoints[2] = $this->calc3DPos($p3->getX(), $p3->getY(), $z);
        $this->iPoints[3] = $this->calc3DPos($p4->getX(), $p4->getY(), $z);
        $this->polygonFour();
    }
        
    public function zLine($x, $y, $z0, $z1) {
        $p1=$this->calc3DPos($x, $y, $z0);
        $p2=$this->calc3DPos($x, $y, $z1);

        $this->moveToX=$p1->getX();
        $this->moveToY=$p1->getY();
        
        $this->LineToXY($p2->getX(),$p2->getY());
    }
        
    function horizontalLine($left, $right, $y, $z=0) {
        $p1=$this->calc3DPos($left, $y, $z);
        $p2=$this->calc3DPos($right, $y, $z);
                
        $this->moveToX=$p1->getX();
        $this->moveToY=$p1->getY();        
                
        $this->LineToXY($p2->getX(),$p2->getY());
    }
    
    public function verticalLine($x, $top, $bottom, $z=0)  {
        $p1=$this->calc3DPos($x, $top, $z);
        $p2=$this->calc3DPos($x, $bottom, $z);
                
        $this->moveToX=$p1->getX();
        $this->moveToY=$p1->getY();        
                
        $this->LineToXY($p2->getX(),$p2->getY());        
    }    
    
    function line($x1, $y1, $x2, $y2, $color=null, $width = -1)  {
        // TODO apply color and width 
        $this->moveToX=$x1;
        $this->moveToY=$y1;
        
        $this->LineToXY($x2,$y2);    
    }    
        
    function LineToXY($X, $Y)  {
      $tmpSt='<line x1="'.$this->moveToX.'" y1="'.$this->moveToY.'" '.
                   'x2="'.$X. '" y2="'.$Y.'" fill="none" '.$this->SVGPen();
      $this->AddEnd($tmpSt);
      $this->moveToX=$X;
      $this->moveToY=$Y;
    }

    Function SVGRect($Rect)  {
      $tmp=$this->OrientRectangle($Rect);

      return ' x="'.($tmp->Left).'" y="'.($tmp->Top).'" '.
              ' width="'.($tmp->Right-$tmp->Left-1).'"'.
              ' height="'.($tmp->Bottom-$tmp->Top-1).'"';
    }

    function SVGClip()   {
      ++$this->IClipStack;
      ++$this->IClipCount;
      $ClipName='Clip'.($this->IClipCount);
      $this->Add('<g clip-path="url(#'.$ClipName.')">');
      $this->Add('<defs>');
      $this->Add('<clipPath id="'.$ClipName.'" style="clip-rule:nonzero">');
    }

    function ClipRectangle($left,$top, $right, $bottom) {
      $this->SVGClip();
      $this->AddEnd('<rect ' .$this->SVGRect(new Rectangle($left,$top,$right,$bottom)));
      $this->SVGEndClip();
    }

    Function SVGEllipse($X1,$Y1,$X2,$Y2)  {
      return 'cx="'.(($X1+$X2) / 2).'" cy="'.(($Y1+$Y2) / 2) .
            '" rx="'.(($X2-$X1) / 2).'" ry="'.(($Y2-$Y1) / 2).'"';
    }

    function ClipEllipse($Rect, $Inverted=false) {
      $this->SVGClip();      
        $this->AddEnd('<ellipse '.$this->SVGEllipse($Rect->Left,$Rect->Top,$Rect->Right,$Rect>Bottom));
      $this->SVGEndClip();
    }

    function ClipPolygon($Points) {
      $this->SVGClip();

      //@TODO: When DiffRegion is True, 
      //clipping the difference between existing clipping region and Points polygon.

      $this->AddEnd('<polygon '.$this->SVGPoints($Points));
      $this->SVGEndClip();
    }

    function UnClipRectangle() {
      if ($this->IClipStack==0)
         echo 'oops'; // Exception

      $this->IClipStack=$this->IClipStack-1;
      $this->Add('</g>');
    }

    function StretchDraw($Rect,$Graphic) {
    }

    public function draw($r, $image, $mode, $shapeBorders=null, $transparent) {  
    }

    Function TotalBounds() {
      return 'width="'.($this->bounds->getRight()-$this->bounds->getLeft()).'px" '.
              'height="'.($this->bounds->Bottom-$this->bounds->Top).'px"';
    }

    Function PointToStr($X,$Y) {
      return ($X).','.($Y);
    }

    Function GradientTransform() {
         /*
        case Direction of
           gdTopBottom : result:=' x1="0%" y1="100%" x2="0%" y2="0%" ';
           gdBottomTop : result:=' x1="0%" y1="0%" x2="0%" y2="100%" ';
           gdRightLeft : result:=' x1="0%" y1="0%" x2="100%" y2="0%" ';
           gdLeftRight : result:=' x1="100%" y1="0%" x2="0%" y2="0%" ';

           //gdFromCenter
           //gdFromTopLeft
           //gdFromBottomLeft
           //gdDiagonalUp
           //gdDiagonalDown
        */
    }

    function AddColors($StartColor,$EndColor) {
        $this->AddEnd('<stop offset="0%" stop-color='.$this->SVGColor($StartColor));
        $this->AddEnd('<stop offset="100%" stop-color='.$this->SVGColor($EndColor));
    }
          
    function GradientFill( $Rect, $StartColor,$EndColor,
                                      $Direction,
                                      $Balance=50,
                                      $RadialX=0,
                                      $RadialY=0)
    {
        $tmp='';
        
    /*  TODO 
      Inc(IGradientCount);
      Add('<defs>');

      if Direction=gdRadial then
      {
        Add('<radialGradient id="Gradient'+TeeStr(IGradientCount)+'" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">');
        AddColors;
        Add('</radialGradient>');
      end
      else
      {
       $this-> Add('<linearGradient id="Gradient'.$this->TeeStr(IGradientCount)+'" '+GradientTransform+'>');
        $this->AddColors;
        $this->Add('</linearGradient>');
      }

      Add('</defs>');

      tmp:='<rect fill="url(#Gradient'+TeeStr(IGradientCount)+')" stroke="none" ';
      tmp:=tmp+SVGRect(Rect);
      AddEnd(tmp);
      */
    }

    function FillRect($Rect) {
      $this->InternalRect($Rect,False);
    }

    function InternalRect($Rect, $UsePen, $RoundX=0, $RoundY=0) {
      $tmp='';
      if (($this->brush->getVisible()) || ($UsePen && ($this->pen->getVisible() ))) 
//      if (($this->brush->getStyle()!=HatchStyle::$CLEAR) || ($UsePen && ($this->pen->getStyle()!= DashStyle::$CLEAR ))) 
      {
        $tmp='<rect '.$this->SVGRect($Rect).$this->SVGBrushPen($UsePen);

        if (($RoundX!=0) || ($RoundY!=0))
           $tmp=$tmp.' rx="'.($RoundX).'" ry="'.($RoundY).'"';

        $this->AddEnd($tmp);
      }
    }

    public function ellipse($x1, $y1, $x2, $y2, $z=0, $angle=0) {       
      $tmpSt='';
      if (($this->brush->getVisible()) || ($this->pen->getVisible())) 
//      if (($this->brush->getStyle()!=HatchStyle::$CLEAR) || ($this->pen->getStyle()!=DashStyle::$CLEAR)) 
      {
        $tmpSt='<ellipse '-$this->SVGEllipse($X1,$Y1,$X2,$Y2);
        $this->AddEnd($tmpSt.$this->SVGBrushPen());
      }
    }
    
    /*  TODO
    function {Entity(const Entity:String; Visual:TVisualBlock=nil):TVisualBlock;
    {
      result:=Visual;

      if Groups then
         Add('<g id="'+Entity+'">');
    }

    function TSVGCanvas.EndEntity;
    {
      if Groups then
         Add('</g>');
    }
    */
    
    function SetPixel3D($X,$Y,$Z, $Value)  {
      if ($this->pen->getVisible())
//      if ($this->pen->getStyle()!=DashStyle::$CLEAR)
      {
        $this->Calc3DPos($x,$y,$z);
        $this->pen->setColor($Value);
        $this->MoveToXY($x,$y);
        $this->LineToXY($x,$y);
      }
    }

    function SetPixel($X, $Y, $Value) {
      if ($this->pen->getVisible())
//      if ($this->pen->getStyle()!=DashStyle::$CLEAR)
      {
        $this->pen->setColor($Value);
        $this->MoveToXY($x,$y);
        $this->LineToXY($x,$y);
      }
    }

    function AssignVisiblePenColor($APen, A$Color)  {
      $this->IPenStyle=$APen->getStyle();
      $this->IPenWidth=$APen->getWidth();
    }

    function arc($x1, $y1, $x2, $y2, $startAngle, $sweepAngle,$filled=0) {      
    //function Arc($Left, $Top, $Right, $Bottom, $StartX, $StartY, $EndX, $EndY, $filled=0)  {
      $tmpSt='';
      if ($this->pen->getVisible())
//      if ($this->pen->getStyle()!=DashStyle::$CLEAR)
      {
        $this->PrepareShape();
 //  TODO       $tmpSt='points="'.$this->PointToStr($x1,$y1).' '.$this->PointToStr($x2,$y2).' '.
  //                        $this->PointToStr($StartX,$StartY).' '.$this->PointToStr($EndX,$EndY).'"';
  //      $this->AddEnd($tmpSt);
      }
    }

    public function pie($xCenter, $yCenter, $xOffset, $yOffset, $xRadius,
                    $yRadius, $z0, $z1, $startAngle, $endAngle,
                    $darkSides, $drawSides, $donutPercent,
                    $bevelPercent, $edgeStyle, $last/*, Shadow shadow*/)  {  
    //function Pie($X1, $Y1, $X2, $Y2, $X3, $Y3, $X4, $Y4) {
      $tmpSt='';

      if (($this->brush->getVisible()) || ($this->pen->getVisible())) 
//      if (($this->brush->getStyle()!=HatchStyle::$CLEAR) || ($this->pen->getStyle()!=DashStyle::$CLEAR)) 
      {
        $this->PrepareShape();
        $tmpSt=' points="'.$this->PointToStr(($X2+$X1) / 2,($Y2+$Y1) / 2).' ';
        $tmpSt=$tmpSt.$this->PointToStr($X1,$Y1).' '.$this->PointToStr($X2,$Y2).' '.
                     $this->PointToStr($X3,$Y3).' '.$this->PointToStr($X4,$Y4).'"';

        $this->AddEnd($tmpSt);
      }
    }

    function RoundRect($X1, $Y1, $X2, $Y2, $X3, $Y3) {
      $this->InternalRect($this->TeeRect($X1,$Y1,$X2,$Y2),True,$X3,$Y3);
    }

    function TextOut3D($X,$Y,$Z,$Text) {
      $this->Calc3DPos($x,$y,$z);
      $this->TextOut($x,$y,$Text);
    }

        Function VerifySpecial($S)
        {
            // TODO $AllowedSVGChars=['!'..'z'] - ['&', '<', '>', '"', ''''];
            $str=(string)$S;
            $result='';

            for ($t=0; $t<strlen($S);$t++)
              /* TODO 
             if {$IFDEF D12}CharInSet({$IFDEF CLR}AnsiChar{$ENDIF}(S[t]), AllowedSVGChars){$ELSE}{$IFDEF CLR}AnsiChar{$ENDIF}(S[t]) in AllowedSVGChars{$ENDIF} then
                     result:=result+S[t]
             else
             */
              switch ($str[$t]) {       
                case '&' : 
                    $result=$result . '&amp;';
                    break;
                case '<' : 
                    $result=$result . '&lt;';
                    break;
                case '>' : 
                    $result=$result . '&gt;';
                    break;
                case '"' : 
                    $result=$result . '&quot;';
                    break;
                case '""' : 
                    $result=$result . '&apos;';
                    break;
                default:
                    $result=$result . '&#'.(Ord($str[$t])).';';
             }
             
             return $result;
        }
  
      function DoText($AX, $AY, $Text, $AColor)  {
        $tmpSt='';
  
        /* TODO
        if ($this->TextAlign && TA_CENTER)=TA_CENTER then
           Dec(AX,TextWidth(Text) div 2)
        else
        if (TextAlign and TA_RIGHT)=TA_RIGHT then
           Dec(AX,TextWidth(Text));
        */
        
        $tmpSt='<text x="'.MathUtils::round($AX-1).'" y="'.MathUtils::round($AY-1).'"'.
            ' font-family="verdana" font-size="'.$this->font->getSize().'pt" ';
                      
//            ' font-family="'.$this->font->getName().'" font-size="'.$this->font->getSize().'pt" ';

        /* TODO
        if fsItalic in Font.Style then
           tmpSt:=tmpSt+' font-style="italic"';

        if fsBold in Font.Style then
           tmpSt:=tmpSt+' font-weight="bold"';

        if fsUnderline in Font.Style then
           tmpSt:=tmpSt+' text-decoration="underline"'
        else
        if fsStrikeOut in Font.Style then
           tmpSt:=tmpSt+' text-decoration="line-through"';
        */
        $tmpSt=$tmpSt.' fill='.$this->SVGColor($AColor).'>';

        $this->Add($tmpSt);
// TODO         $this->Add($this->VerifySpecial($Text));
        $this->Add($Text);
        $this->Add('</text>');
      }
                
    function TextOut($px,$py,$Z,$text, $align=-1)  {
      $font=$this->getFont();
      $color = $font->getBrush()->getColor();

      $fontFileName = $font->getName();

      if ($align==-1) {
         $align = $this->getTextAlign();
      }

      $fontSize = $font->getFontSize();
      $lineSpacing = 1;

      $textWidth =  $this->textWidth($text); //  $lrx - $llx;
      $textHeight = $this->textHeight($text); //  $fontSize; // $lry - $ury;
      $angle = 0;

      if ($align!=null)
      {
        if (in_array(StringAlignment::$HORIZONTAL_CENTER_ALIGN, $align)) {
            $px -= $textWidth / 2;
        }
        else
        if (in_array (StringAlignment::$HORIZONTAL_RIGHT_ALIGN, $align)) {
            $px -= $textWidth;
        }

        if (in_array (StringAlignment::$VERTICAL_CENTER_ALIGN, $align)) {
            $py += $textHeight;
        }                                 
        
        /*if (in_array (StringAlignment::$VERTICAL_TOP_ALIGN, $align)) {
            $py += $textHeight;
        }*/
        else
        if (in_array (StringAlignment::$VERTICAL_BOTTOM_ALIGN, $align)) {
            $py += $textHeight;
        }
      }
        
      $this->DoText($px, $py, $text, $this->font->getColor());
    }

    function RotateLabel3D($x,$y,$z,$St, $RotDegree) {
      //$this->Calc3DPos($x,$y,$z);
      $this->RotateLabel($x,$y,$z,$St,$RotDegree);
    }
   
    function RotateLabel($x,$y,$z,$St,$RotDegree) {
    //TODO: RotDegree text rotation
      $tmpSt='<text transform="rotate('. $RotDegree .')" style="text-anchor:end;" x="'.MathUtils::round($x-1);
      $tmpSt=$tmpSt. '" y="'.MathUtils::round($y).'" fill="black" font-size="'.$this->font->getSize().'pt" font-family="verdana" ';    
      $tmpSt=$tmpSt.' fill=black>';
      $this->Add($tmpSt);
// TODO         $this->Add($this->VerifySpecial($Text));
      $this->Add($St);
      $this->Add('</text>');
    }

    Function SVGBrushPen($UsePen=True) {
      $result='';
      
      if ($this->brush->getVisible())
//      if ($this->brush->getStyle()!=HatchStyle::$CLEAR)
      {
        $result=' fill='.$this->SVGColor($this->brush->getColor());
        if ($this->ITransp>0)
           $result=$result.' fill-opacity="'.$this->FloatToStr($this->ITransp*0.01).'"';
      }
      else
        $result=' fill="none"';

      if ($UsePen) 
        $result=$result.$this->SVGPen();
      
      return $result;
    }

    Function PenStyle() {
        if ($this->pen instanceof ChartPen && $this->pen->getSmallDots())
            $result='2, 2';
        else
           
        switch ($this->IPenStyle) {
        case 'psDash': 
            $result='4, 2'; 
            break;
        case 'psDot': 
            $result='2, 2';
            break;
        case 'psDashDot': 
            $result='4, 2, 2, 2';
            break;
        case 'psDashDotDot': 
            $result='4, 2, 2, 2, 2, 2';
            break;
        default;
            $result='';
        }  
        return $result;
    }
      
    Function SVGPen() {
      $result='';
      if (!$this->pen->getVisible())
//      if ($this->pen->getStyle()==DashStyle::$CLEAR)
         $result=' stroke="none"';
      else
      {
        $result=' stroke='.$this->SVGColor($this->pen->getColor());

        if ($this->IPenWidth>1)
           $result=$result.' stroke-width="'.$this->TeeStr($this->IPenWidth).'"';

        if ($this->IPenStyle!=DashStyle::$SOLID)
           $result=$result.' stroke-dasharray="'.$this->PenStyle.'" ';  //  fill="none" breaks brush ??

        /* TODO 
        if ($this->pen instanceof ChartPen)
          switch $this->pen->getEndCap() {
            esSquare: $result=$result.' stroke-linecap="square"';
            esFlat: $result=$result.' stroke-linecap="flat"';
        }
        */
      }
      return $result;
    }

    function PrepareShape() {
      $this->Add('<polygon'.$this->SVGBrushPen());
    }

    Function SVGPoints($Points) {
      $t=0;
      $result='points="';
      
//  TODO review pep    for ($t=min($Points);$t<=max($Points);$t++)
      for ($t=0;$t<sizeof($Points);$t++)
          $result=$result.$this->PointToStr($Points[$t]->getX(),$Points[$t]->getY()).' ';
      $result=$result.'"';
      
      return $result;
    }

    public function plane($p1, $p2, $z0, $z1) {
        $this->iPoints[0] = $this->calc3DPos($p1->getX(), $p1->getY(), $z0);
        $this->iPoints[1] = $this->calc3DPos($p2->getX(), $p2->getY(), $z0);
        $this->iPoints[2] = $this->calc3DPos($p2->getX(), $p2->getY(), $z1);
        $this->iPoints[3] = $this->calc3DPos($p1->getX(), $p1->getY(), $z1);
        $this->polygonFour();
    } 
    
    public function rectangleY($left, $top, $right, $z0, $z1) {
        $this->iPoints[0] = $this->calc3DPos($left, $top, $z0);
        $this->iPoints[1] = $this->calc3DPos($right, $top, $z0);
        $this->iPoints[2] = $this->calc3DPos($right, $top, $z1);
        $this->iPoints[3] = $this->calc3DPos($left, $top, $z1);
        $this->polygonFour();
    }
        
    public function rectangleZ($left, $top, $bottom, $z0, $z1) {
        $this->iPoints[0] = $this->calc3DPos($left, $top, $z0);
        $this->iPoints[1] = $this->calc3DPos($left, $top, $z1);
        $this->iPoints[2] = $this->calc3DPos($left, $bottom, $z1);
        $this->iPoints[3] = $this->calc3DPos($left, $bottom, $z0);
        $this->polygonFour();
    }
        
    public function rectangleWithZ($r, $z){
        $this->iPoints[0] = $this->calc3DPos($r->x, $r->y, $z);
        $this->iPoints[1] = $this->calc3DPos($r->getRight(), $r->y, $z);
        $this->iPoints[2] = $this->calc3DPos($r->getRight(), $r->getBottom(), $z);
        $this->iPoints[3] = $this->calc3DPos($r->x, $r->getBottom(), $z);
        $this->polygonFour();
    }
    
    function polygonFour() {
      $Points=$this->iPoints;
      if (($this->brush->getVisible()) || ($this->pen->getVisible())) 
//      if (($this->brush->getStyle()!=HatchStyle::$CLEAR) || ($this->pen->getStyle()!=DashStyle::$CLEAR)) 
      {
        $this->PrepareShape();
        $this->AddEnd($this->SVGPoints($Points));
      }
    }

    function Polyline($z,$Points) {
      if (($this->brush->getVisible()) || ($this->pen->getVisible())) 
//      if (($this->brush->getStyle()!=HatchStyle::$CLEAR) || ($this->pen->getStyle()!=DashStyle::$CLEAR)) 
      {
        $this->Add('<polyline fill="none" '.$this->SVGPen());
        $this->AddEnd($this->SVGPoints($Points));
      }
    }
    
    // If you need a diferent set of headers, override this method
    // in a descendant class (ie: TMySVGCanvas.HeaderContents)
    function HeaderContents() {
      $result='version="1.1" baseProfile="full"'.$this->CRLF.

              // Not supported in Firefox:

              /*
              'xmlns:cc="http://web.resource.org/cc/"'+CRLF+
              'xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"'+CRLF+
              'xmlns:ev="http://www.w3.org/2001/xml-events"'+CRLF+
              'xmlns:svg="http://www.w3.org/2000/svg"'+CRLF+
              */

              'xmlns="http://www.w3.org/2000/svg"'.$this->CRLF.
              'xmlns:xlink="http://www.w3.org/1999/xlink"'.$this->CRLF;
              
      return $result;
    }

    function InitWindow($a, $r, $MaxDepth) {
      $result=parent::initWindow($a,$r,$MaxDepth);  

      $this->Add($this->DocType);
      $tmp='<svg '.$this->HeaderContents().$this->TotalBounds();
      if ($this->Antialias)
         $tmp=$tmp.' style="text-antialiasing:true"';

      $this->Add($tmp.'>');

      if ($this->SVGDescription!='')
         $this->Add('<desc>'.$this->SVGDescription.'</desc>');

      // TODO Pen.OnChange:=ChangedPen;
    }

    /* TODO
    function ChangedPen($Sender)
    {
      $this->IPenStyle=$this->pen->getStyle();
      $this->IPenWidth=$this->pen->getWidth();
    }
    */

    function Blending($R, $Transparency) {
      $this->ITransp=$Transparency;
      return null;
    }

    function EndBlending($Blend) {
      $this->ITransp=0;
    }

    function SVGEndClip() {
      $this->Add('</clipPath>');
      $this->Add('</defs>');
    }

    function _ClipRectangle($Rect, $RoundX, $RoundY) {
      $this->SVGClip();
      $this->AddEnd('<rect '.$this->SVGRect($Rect).' rx="'.($RoundX).'" ry="'.($RoundY).'"');
      $this->SVGEndClip();
    }
    
    function unClip() {
    }
    
    function imagegradientellipse($image, $cx, $cy, $w, $h, $ic, $oc){
    }
    
    function imagegradientellipsealpha($image, $cx, $cy, $w, $h, $ic, $oc){
    }
  
    public function ___line($pen, $p0, $p1) {
    }
    
    public function outlinedBox($x1, $y1, $x2, $y2, $color0, $color1) {
    }      
    
    public function polygon($points) {
    }    

    public function polygonFourDouble()    {        
    }
  
    public function printDiagonal($img, $px, $py, $text, $angle) {
    }
      
    function roundrectangle($x1, $y1, $x2, $y2, $radius, $filled=1) {
    }
    
    function drawRoundedBorders($shapeBorders,$backcolor,$forecolor) {        
    }    
  }   
?>