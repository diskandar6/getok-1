<?php
  /**
 * Description:  This file contains the following class:<br>
 * CanvasHTML5 class<br>
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */
/**
 * CanvasHTML5 class
 *
 * Description: Class with all HTML5 canvas drawing methods.
 *
 * @author Steema Software SL.
 * @copyright (c) 1995-2018 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage 
 * @link http://www.steema.com
 */
 
 class Graphics3DHTML5 extends GraphicsGD  
 {
    private $iGradientCount;
    private $fStream;    
    private $imagePath;    

    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }
    
    public function __construct($fhandle,$c)
    {
      parent::GraphicsGD($c, $c->getWidth(), $c->getHeight());
          
      $this->iCanvasType = "HTML5";             
      $this->fStream=$fhandle;
      $this->supportsID = true;
      $this->embeddedImages = true;
      $this->iPath = Array();
      $this->iItems = Array();
      $this->iImageID = 0;

      $this->InitStrings();      
    }        

    public function __destruct()    
    {        
        parent::__destruct();                
        unset($this->iGradientCount);
        unset($this->fStream);    
        unset($this->imagePath);    
    }
    
    /// <summary>
    /// Adds canvas instruction to stream.
    /// </summary>
    /// <param name="text">Instructions to be added to stream.</param>
    protected function AddToStream($text)
    {
        $linetext = $text . "\r\n";

        fwrite($this->fStream,$linetext);
        fflush($this->fStream);
    }
    
    // Returns string
    private function HTMLRect($r)
    {
      return $r->Left . ", " . $r->Top . ", " . $r->Width . ", " . $r->Height;
    }

    public function textOut($x, $y, $z, $text, $align=-1) 
    {
        $this->AddToStream(" ctx.fillStyle = \"" . $this->HTML5Color($this->getFont()->getColor()) . "\";");
     
        $font=$this->getFont();
        $color = $font->getBrush()->getColor();

        $fontFileName = $font->getName();

        if ($align==-1) {
           $align = $this->getTextAlign();
        }

        $fontSize = $font->getFontSize();
        $lineSpacing = 1;

        $textWidth =  $this->textWidth($text); 
        $textHeight = $this->textHeight($text);
        $angle = 0;

        if ($align!=null)
        {
            if (in_array(StringAlignment::$HORIZONTAL_CENTER_ALIGN, $align)) {
                $x -= $textWidth / 2;
                //$this->AddToStream(" ctx.textAlign = \"center\";");                
            }
            else
            if (in_array (StringAlignment::$HORIZONTAL_RIGHT_ALIGN, $align)) {
                $x -= $textWidth;
                //$this->AddToStream(" ctx.textAlign = \"right\";");                
            }
            else
            if (in_array (StringAlignment::$HORIZONTAL_LEFT_ALIGN, $align)) {
                //$this-> AddToStream(" ctx.textAlign = \"left\";");                
            }
                     
            if (in_array (StringAlignment::$VERTICAL_CENTER_ALIGN, $align)) {
           //     $y += $textHeight;
            }                                 
            
            if (in_array (StringAlignment::$VERTICAL_TOP_ALIGN, $align)) {
                $py += $textHeight;
            }
            else
            if (in_array (StringAlignment::$VERTICAL_BOTTOM_ALIGN, $align)) {
                $y -= $textHeight;
            }
            else
            if (in_array (StringAlignment::$CENTER, $align)) {
                $y -= $textHeight;
            }            
        }
   
//      $y = $y - ($this->getFont()->getSize());
      $this->AddToStream(" ctx.textBaseline = \"top\";");                                 
      $this->AddToStream(" ctx.font = \"" . ($this->getFont()->getSize()+3)."px Verdana" . "\";");
      $this->AddToStream(" ctx.fillText(\"" . $text . "\"," . number_format($x,2,'.','').",". (number_format($y,2,'.','')) . ");");
    }

    // Returns string
    private function HTMLFontStyle()
    {
      $result = "";

      if ($this->Font->Bold) {
        $result .= "bold ";
      }
      
      if (Font.Italic) {
        $result .= "italic ";
      }
      return $result;
    }

    public function Rectangle($r)
    {
      $b = $this->brush;
      $IsRound =($this->getChart()->getPanel()->getBorderRound() > 0);
      $UsePen = $this->getPen()->getVisible();
      
      if ($this->brush->visible || $this->pen->visible)
      {
        if ($b->GradientVisible) 
           $this->AddGradient($b->Gradient, $r);
        else 
          if ($b->visible) 
            $this->AddBrush($b);

        if ($IsRound)  {
          $x1 = $r->Left;
          $y1 = $r->Top;
          $x2 = $r->Right;
          $y2 = $r->Bottom;
          $x3 = 8;
          $y3 = 8;

          $this->AddToStream(" ctx.beginPath();");
          $this->AddToStream(" ctx.moveTo(" . $this->PointToStr($x1, $y1 + $y3) . ");");
          $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($x1, $y2 - $y3) . ");");
          $this->AddToStream(" ctx.quadraticCurveTo(" . $x1 . "," . $y2 . "," . ($x1 + $x3) . "," . $y2 . ");");
          $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($x2 - $x3, $y2) . ");");
          $this->AddToStream(" ctx.quadraticCurveTo(" . $x2 . "," . $y2 . "," . $x2 . "," . ($y2 - $y3) . ");");
          $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($x2, $y1 + $y3) . ");");
          $this->AddToStream(" ctx.quadraticCurveTo(" . $x2 . "," . $y1 . "," . ($x2 - $x3) . "," . $y1 . ");");
          $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($x1 + $x3, $y1) . ");");
          $this->AddToStream(" ctx.quadraticCurveTo(" . $x1 . "," . $y1 . "," . $x1 . "," . ($y1 + $y3) . ");");

          if ($b->Visible) AddToStream(" ctx.fill();");
          if ($UsePen) {
            $this->AddPen();
            $this->AddToStream(" ctx.stroke();");
          }
        }
        else
        {
          if ($b->GradientVisible || $b->Visible) 
            $this->AddToStream(" ctx.fillRect(" . $this->HTMLRect($r) . ");");
          if ($UsePen) {
            $this->AddPen();
            $this->AddToStream(" ctx.strokeRect(" . $this->HTMLRect($r) . ");");
          }
        }
      }
    }

    private function AddPen()
    {
      if ($this->Pen->Visible) {
        $this->AddToStream(" ctx.strokeStyle = \"" . $this->HTML5Color($this->Pen->Color) . "\";");
        $this->AddToStream(" ctx.lineWidth = " . $this->Pen->Width . ";");
      }
    }

    private function InitStrings()
    {
      $this->AddToStream("<html>");
      $this->AddToStream(" <head>");
      $this->AddToStream("  <script type=\"application/javascript\">");

      $this->AddDashedLine();

      $this->AddToStream("function draw() {");
      $this->AddToStream(" var canvas = document.getElementById(\"canvas\");");
      $this->AddToStream(" var ctx = canvas.getContext(\"2d\");");
    }

    private function AddDashedLine()
    {
      $this->AddToStream("// Copyright David Owens: http://davidowens.wordpress.com/2010/09/07/html-5-canvas-and-dashed-lines/");
      $this->AddToStream("CanvasRenderingContext2D.prototype.dashedLineTo = function (fromX, fromY, toX, toY, pattern) {");
      $this->AddToStream("// Our growth rate for our line can be one of the following:");
      $this->AddToStream("//   (+,+), (+,-), (-,+), (-,-)");
      $this->AddToStream("// Because of this, our algorithm needs to understand if the x-coord and");
      $this->AddToStream("// y-coord should be getting smaller or larger and properly cap the values");
      $this->AddToStream("// based on (x,y).");
      $this->AddToStream("  var lt = function (a, b) { return a <= b; };");
      $this->AddToStream("  var gt = function (a, b) { return a >= b; };");
      $this->AddToStream("  var capmin = function (a, b) { return Math.min(a, b); };");
      $this->AddToStream("  var capmax = function (a, b) { return Math.max(a, b); };");
      $this->AddToStream("");
      $this->AddToStream("  var checkX = { thereYet: gt, cap: capmin };");
      $this->AddToStream("  var checkY = { thereYet: gt, cap: capmin };");
      $this->AddToStream("");
      $this->AddToStream("  if (fromY - toY > 0) {");
      $this->AddToStream("    checkY.thereYet = lt;");
      $this->AddToStream("    checkY.cap = capmax;");
      $this->AddToStream("  }");
      $this->AddToStream("  if (fromX - toX > 0) {");
      $this->AddToStream("    checkX.thereYet = lt;");
      $this->AddToStream("    checkX.cap = capmax;");
      $this->AddToStream("  }");
      $this->AddToStream("");
      $this->AddToStream("");
      $this->AddToStream("  var offsetX = fromX;");
      $this->AddToStream("  var offsetY = fromY;");
      $this->AddToStream("  var idx = 0, dash = true;");
      $this->AddToStream("  while (!(checkX.thereYet(offsetX, toX) && checkY.thereYet(offsetY, toY))) {");
      $this->AddToStream("    var ang = Math.atan2(toY - fromY, toX - fromX);");
      $this->AddToStream("    var len = pattern[idx];");
      $this->AddToStream("");
      $this->AddToStream("    offsetX = checkX.cap(toX, offsetX + (Math.cos(ang) * len));");
      $this->AddToStream("    offsetY = checkY.cap(toY, offsetY + (Math.sin(ang) * len));");
      $this->AddToStream("");
      $this->AddToStream("    if (dash) this.lineTo(offsetX, offsetY);");
      $this->AddToStream("    else this.moveTo(offsetX, offsetY);");
      $this->AddToStream("");
      $this->AddToStream("    idx = (idx + 1) % pattern.length;");
      $this->AddToStream("    dash = !dash;");
      $this->AddToStream("  }");
      $this->AddToStream("};");
    }

    private function AddBrush($b)
    {
      if ($b->Visible) $this->AddToStream(" ctx.fillStyle = \"" . $this->HTML5Color($b->Color) . "\";");
    }

    private function AddGradient($AGradient, $Rect)
    {
      if ($AGradient->Style->Visible)
      {
        //TODO
      }
      else
      {
        switch ($AGradient->Direction)
        {
          case System.Drawing.Drawing2D.LinearGradientMode.BackwardDiagonal:
            $this->AddLinearGradient($Rect->Right, $Rect->Top, $Rect->Left, $Rect->Bottom, $AGradient->StartColor, $AGradient->EndColor);
            break;
          case System.Drawing.Drawing2D.LinearGradientMode.ForwardDiagonal:
            $this->AddLinearGradient($Rect->Left, $Rect->Top, $Rect->Right, $Rect->Bottom, $AGradient->StartColor, $AGradient->EndColor);
            break;
          case System.Drawing.Drawing2D.LinearGradientMode.Horizontal:
            $this->AddLinearGradient($Rect->Left, 0, $Rect->Right, 0, $AGradient->StartColor, $AGradient->EndColor);
            break;
          case System.Drawing.Drawing2D.LinearGradientMode.Vertical:
            $this->AddLinearGradient(0, $Rect->Top, 0, $Rect->Bottom, $AGradient->StartColor, $AGradient->EndColor);
            break;
        }
      }
      $this->AddToStream(" ctx.fillStyle=gradient" . $this->iGradientCount . ";");
    }

    private function AddLinearGradient($x1, $y1, $x2, $y2, $color1, $color2)
    {
      ++$$this->iGradientCount;
      $this->AddToStream(" var gradient" . $this->iGradientCount . " = ctx.createLinearGradient(" . $this->HTMLBounds($x1, $y1, $x2, $y2) . ");");
      $this->AddToStream(" gradient" . $this->iGradientCount . ".addColorStop(0,\"" . $this->HTML5Color($color1) . "\");");
      $this->AddToStream(" gradient" . $this->iGradientCount . ".addColorStop(1,\"" . $this->HTML5Color($color2) . "\");");
    }

    protected function FloatToStr($value)
    {
        return number_format($value,2);
    }

    // Returns string
    private function HTML5Color($color)
    {
      $result = "";

      if ($color->alpha > 0)
      {
        $result = "rgb(" . $color->red. ", " . $color->green . ", " . $color->blue . ")";
      }
      else
      {
        $result = "rgba(" . $color->red . ", " . $color->green . ", " . $color->blue . ", " . (1 - (0.01 * $color->alpha)) . ")";
      }
      return $result;
    }

    // Returns String
    private function HTMLBounds($left, $top, $right, $bottom)
    {
      return $left . ", " . $top . ", " . $right . ", " . $bottom;
    }

    public function ShowImage($g)
    {
      $this->AddToStream("}");
      $this->AddToStream("  </script>");
      $this->AddToStream(" </head>");
      $this->AddToStream(" <body onload=\"draw()\">");
      $this->AddToStream("   <canvas id=\"canvas\" width=\"" . $this->Chart->Width .
                              "\" height=\"" . $this->Chart->Height .
          "\">This browser does not support HTML5 Canvas</canvas>");
      $this->AddToStream(" </body>");
      $this->AddToStream("</html>");
    }

    public function arc($x1, $y1, $x2, $y2, $startAngle, $sweepAngle, $filled=0)     
    {
      if ($x2 != $x1 && $this->Pen->Visible)
      {
        $rect = Utils::FromLTRB($x1, $y1, $x2, $y2);
        $radius = $rect->Width < $rect->Height ? $rect->Height / 2.0 : $rect->Width / 2.0;

        $this->AddToStream(" ctx.save();");
        $this->AddToStream(" ctx.translate(" . ($this->PointToStr($rect->X + ($rect->Width / 2)) . "," . ($rect->Y + ($rect->Height / 2))) . ");");

        if ($rect->Width != $rect->Height)
          $this->AddToStream(" ctx.scale(1," . $this->FloatToStr((double)$rect->Height / (double)$rect->Width) . ");");

        $this->AddToStream(" ctx.beginPath();");
        $this->AddToStream(" ctx.arc(0, 0, " . $this->FloatToStr($radius) . ", " . $this->FloatToStr(Utils.Deg2Rad($startAngle)) . ", " . $this->FloatToStr(Utils::Deg2Rad($sweepAngle) + Utils::Deg2Rad($startAngle)) . ",  false);");

        if ($this->Pen->Visible)
        {
          $this->AddPen();
          $this->AddToStream(" ctx.stroke();");
        }

        $this->AddToStream(" ctx.restore();");
      }
    }

    public function _Arc($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4)
    {
      $start = 0.0;
      $sweep = 0.0;

      if ($this->Pen->Visible)
      {
        $this->CalcArcAngles($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4, /*out*/ $start, /*out*/ $sweep);
        $this->Arc($x1, $y1, $x2, $y2, (float)$start, (float)$sweep);
      }
    }

    protected function /*Region*/ AddRightRegion($rect, $minZ, $maxZ)
    {
      
      /*  
      $p = new Point[6];
      //Point pa;
      //Point pb;

      $p[0] = $this->Calc3DPoint($rect->Left, $rect->Bottom, $minZ);
      $p[1] = $this->Calc3DPoint($rect->Left, $rect->Top, $minZ);

      $pa = $this->Calc3DPoint($rect->Left, $rect->Top, $maxZ);
      $pb = $this->Calc3DPoint($rect->Right, $rect->Top, $minZ);

      $p[2] = $pb->Y < $pa->Y ? $pb : $pa;

      $p[3] = $this->Calc3DPoint($rect->Right, $rect->Top, $maxZ);

      $pa = $this->Calc3DPoint($rect->Right, $rect->Bottom, $maxZ);
      $pb = $this->Calc3DPoint($rect->Right, $rect->Top, $minZ);

      $p[4] = $pb->X > $pa->X ? $pb : $pa;

      $p[5] = $this->Calc3DPoint($rect->Right, $rect->Bottom, $minZ);
      if ($p[5]->X < $p[0]->X)
      {
        $p[0]->X = $p[5]->X;
        if ($pb->Y < $p[0]->Y) { $p[0]->Y = $pb->Y; }
      }

      $myPath = new System.Drawing.Drawing2D.GraphicsPath();

      $myPath->AddPolygon($p);

      return new Region($myPath);
      */
    }

    public function FillRegion($brush, $region)
    {
      //throw new Exception("The method or operation is not implemented.");
    }

    function imagegradientellipse($image, $cx, $cy, $w, $h, $ic, $oc)             
    {        
      if ($x2 != $x1 && ($this->Brush->Gradient->Visible || $this->Brush->Visible || $this->Pen->Visible))
      {
        $rect = Rectangle::fromLTRB($x1, $y1, $x2, $y2);
        $radius = $rect->Width < $rect->Height ? $rect->Height / 2.0 : $rect->Width / 2.0;

        if ($this->Brush->Gradient->Visible)
          $this->AddGradient($this->Brush->Gradient, $rect);
        else
          $this->AddBrush($this->Brush);

        $this->AddToStream(" ctx.save();");
        $this->AddToStream(" ctx.translate(" . ($rect->X + ($rect->Width / 2)) . "," . ($rect->Y + ($rect->Height / 2)) . ");");

        if ($rect->Width != $rect->Height)
          $this->AddToStream(" ctx.scale(1," . (double)$rect->Height / (double)$rect->Width . ");");

        $this->AddToStream(" ctx.beginPath();");
        $this->AddToStream(" ctx.arc(0,0," . $radius . "," . "0,Math.PI*2,true);");

        if ($this->Brush->Gradient->Visible || $this->Brush->Visible)
          $this->AddToStream(" ctx.fill();");

        if ($this->Pen->Visible)
        {
          $this->AddPen();
          $this->AddToStream(" ctx.stroke();");
        }

        $this->AddToStream(" ctx.restore();");
      }
    }

    protected function TransparentEllipse($x1, $y1, $x2, $y2)
    {
      //throw new NotImplementedException();
    }

    public function EraseBackground($left, $top, $right, $bottom)
    {
      //throw new NotImplementedException();
    }

    public function drawImage($x, $y, $image)
    {
      //throw new NotImplementedException();
    }

    public function _drawImage($destRect, $srcRect, $image, $transparent)
    {
      //throw new NotImplementedException();
    }

    /*
    public function Polygon(PointDouble[] $p)
    {
      if ($this->Brush->Visible || $this->Pen->Visible)
      {
        $this->AddToStream(" ctx.beginPath();");
        $this->AddToStream(" ctx.moveTo(" . $this->PointToStr($p[0]) . ");");

        for ($t = 1; $t < sizeof($p); $t++)
          $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($p[$t]) . ");");

        $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($p[0]) . ");");

        if ($this->Brush->Visible || $this->Brush->GradientVisible)
        {
          if ($this->Brush->Gradient->Visible)
            $this->AddGradient($this->Brush->Gradient, $this->PolygonRect(PointDouble.Round($p)));
          else
            $this->AddBrush($this->Brush);
          $this->AddToStream(" ctx.fill();");
        }

        if ($this->Pen->Visible)
        {
          $this->AddPen();
          $this->AddToStream(" ctx.stroke();");
        }
      }
    }
    */

    public function Polygon($p)
    {
      if ($this->Brush->Visible || $this->Pen->Visible)
      {
        $this->AddToStream(" ctx.beginPath();");
        $this->AddToStream(" ctx.moveTo(" . $this->PointToStr($p[0]) . ");");

        for ($t = 1; $t < sizeof($p); $t++)
          $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($p[t]) . ");");

        $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($p[0]) . ");");

        if ($this->Brush->Visible || $this->Brush->GradientVisible)
        {
          if ($this->Brush->Gradient->Visible)
            $this->AddGradient($this->Brush->Gradient, $this->PolygonRect($p));
          else
            $this->AddBrush($this->Brush);
          $this->AddToStream(" ctx.fill();");
        }

        if ($this->Pen->Visible)
        {
          $this->AddPen();
          $this->AddToStream(" ctx.stroke();");
        }
      }
    }

    public function ClipEllipse($r)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function ClipPolygon($p)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }
    
    function ToFloat($Value)  {
      $locale = localeconv();
      return number_format($Value,3,$locale['decimal_point'],$locale['thousands_sep']);
    }    

    function HTMLPoint($X,$Y) {
        return $this->ToFloat($X).','.$this->ToFloat($Y);
    }
    
    public function clipRectangle($left, $top, $right, $bottom)  {
          $this->AddToStream(' ctx.save();');
          $this->AddToStream(' ctx.beginPath();');
          $this->AddToStream(' ctx.moveTo('.$this->HTMLPoint($left,$top).');');
          $this->AddToStream(' ctx.lineTo('.$this->HTMLPoint($right,$top).');');
          $this->AddToStream(' ctx.lineTo('.$this->HTMLPoint($right,$bottom).');');
          $this->AddToStream(' ctx.lineTo('.$this->HTMLPoint($left,$bottom).');');
          $this->AddToStream(' ctx.lineTo('.$this->HTMLPoint($left,$top).');');

          $this->AddToStream(' ctx.clip();');
    }

    public function SetClipRegion($region)
    {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function _SetClipRegion($region, $intersect)
    {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function DrawPath($pen, $path)
    {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function polyLine($z, $p)  {
      $this->MoveTo($p[0]);
      for ($i = 1; $i < sizeof($p); $i++)  {
        $this->LineTo($p[$i]->X, $p[$i]->Y);
      }
    }

    public function UnClip()  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function ClearClipRegions()  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function rotateLabel($x, $y, $z, $text, $rotDegree)   {
      $this->DoText($x, $y, $text, $rotDegree, $this->Font->Color);
    }

    public function Pixel($x, $y, $z, $color)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function horizontalLine($left, $right, $y, $z=0) {
//        $p1=$this->calc3DPos($left, $y, $z);
//        $p2=$this->calc3DPos($right, $y, $z);
        
        $this->moveToXY($left,$y);
        $this->LineTo($right,$y);
    }    
    
    public function verticalLine($x, $top, $bottom, $z=0) {
        //$p1=$this->calc3DPos($x, $top, $z);
        //$p2=$this->calc3DPos($x, $bottom, $z);
        $this->moveToXY($x,$top);
        $this->LineTo($x,$bottom);
    }           
        
    public function LineTo($x, $y)  {
      if ($this->Pen->Visible)  {          
        $this->AddToStream(" ctx.beginPath();");
        $this->AddToStream(" ctx.moveTo(" . $this->PointToStr($this->moveToX, $this->moveToY) . ");");

        switch ($this->Pen->Style)  {
          case DashStyle::$DASH:
            $this->AddDash("4,1", $x, $y);
            break;
          case DashStyle::$DASHDOT:
            $this->AddDash("4,1,2,1", $x, $y);
            break;
          case DashStyle::$DASHDOTDOT:
            $this->AddDash("4,1,2,1,2,1", $x, $y);
            break;
          case DashStyle::$DOT:
            $this->AddDash("2,1", $x, $y);
            break;
          default:
            $this->AddToStream(" ctx.lineTo(" . $this->PointToStr($x, $y) . ");");
            break;
        }

        $this->AddPen();
        $this->AddToStream(" ctx.stroke();");
        $this->MoveToXY($x, $y);
      }
    }

    function line($x1, $y1, $x2, $y2, $color=null, $width = -1)  {
      $this->moveToXY($x1, $y1);
      $this->LineTo($x2, $y2);
    }
    
    private function AddDash($pattern, $x, $y)  {
      $this->AddToStream(" ctx.dashedLineTo(" . $this->PointToStr($this->moveToX, $this->moveToY) . ", " . $this->PointToStr($x, $y) . ", [". $pattern . "]);");
    }

    public function DrawBeziers($p)  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function PrepareDrawImage()  {
        Utils::MsgErrorException('The method or operation is not implemented.');
    }

    public function getImagePath() {
        return $this->imagePath; 
    }
    
    public function setImagePath($value) {
        $this->imagePath = $value; 
    }
    
    public function getStream() {
        return $this->fStream;
    }

/*    
    function AddBrush() {
         $this->AddToStream(' ctx.fillStyle = "'.$this->HTML5Color($this->brush->getColor()).'";');
    }
  */  
  
    public function ellipse($x1, $y1, $x2, $y2, $z=0, $angle=0) {
          if ($x2<>$x1)  {
            if ($this->brush->getGradient()->getVisible())
               $this->AddGradient(Gradient, new Rectangle(round()-($x2-$x1) / 2),
                                     round(-($y2-$y1) / 2),
                                     round(($x2-$x1) / 2),
                                     round(($y2-$y1) / 2));
            else  {
               $this->AddPen();
               $this->AddBrush($this->brush);
            }

            $this->AddToStream(' ctx.save();');
            $this->AddToStream(' ctx.translate('.$this->HTMLPoint(round(($x2+$x1) / 2),
                                            round(($y2+$y1) / 2)).');');

            if (($y2-$y1)!=($x2-$x1)) 
               $this->AddToStream(' ctx.scale(1,'.$this->ToFloat(($y2-$y1)/($x2-$x1)).');');

            $this->AddToStream(' ctx.beginPath();');
            $this->AddToStream(' ctx.arc(0,0,'.$this->ToFloat(0.5*($x2-$x1)).','.'0,Math.PI*2,true);');
            
            if ($this->getPen()->getStyle()!=DashStyle::$CLEAR)
               $this->AddToStream(' ctx.stroke();');

            if ($this->getBrush()->getGradient()->getVisible() || ($this->getBrush()->getStyle()!=HatchStyle::$CLEAR)) 
               $this->AddToStream(' ctx.fill();');

            $this->AddToStream(' ctx.restore();');
          }
    }
  }
?>