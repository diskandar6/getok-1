<?php
/*
////////////////////////////////////////////////////////////////////////////////

Circle(float x, float y, float r [, string style])

x: abscissa of center.
y: ordinate of center.
r: radius.
style: style of rendering, like for Rect (D, F or FD). Default value: D.

Ellipse(float x, float y, float rx, float ry [, string style])

x: abscissa of center.
y: ordinate of center.
rx: horizontal radius.
ry: vertical radius.
style: style of rendering, like for Rect (D, F or FD). Default value: D. 

////////////////////////////////////////////////////////////////////////////////

Rotate(float angle [, float x [, float y]])
RotatedText($x,$y,$txt,$angle)
function RotatedImage($file,$x,$y,$w,$h,$angle)

angle: angle in degrees.
x: abscissa of the rotation center. Default value: current position.
y: ordinate of the rotation center. Default value: current position.

////////////////////////////////////////////////////////////////////////////////

Polygon(array points [, string style])

points: array of the form (x1, y1, x2, y2, ..., xn, yn) where (x1, y1) is the starting point and (xn, yn) is the last one.
style: style of rendering, the same as for Rect(): D, F or FD.

////////////////////////////////////////////////////////////////////////////////

    drawTextBox(string strText, float w, float h [, string align [, string valign [, boolean border]]])

    strText: the string to print
    w: width of the box
    h: height of the box
    align: horizontal alignment (L, C, R or J). Default value: L
    valign: vertical alignment (T, M or B). Default value: T
    border: whether to draw the border of the box. Default value: true

////////////////////////////////////////////////////////////////////////////////

    subWrite(float h, string txt [, mixed link [, float subFontSize [, float subOffset]]])
    
    h: line height
    txt: string to print
    link: URL or identifier returned by AddLink()
    subFontSize: size of font in points (12 by default)
    subOffset: offset of text in points (positive means superscript, negative subscript; 0 by default)

////////////////////////////////////////////////////////////////////////////////

CellFit(float w [, float h [, string txt [, mixed border [, int ln [, string align 
        [, boolean fill [, mixed link [, boolean scale [, boolean force]]]]]]]]])

The first 8 parameters are the same as Cell(). The additional parameters are:

scale

false: character spacing
true: horizontal scaling

force

false: only space/scale if necessary (not when text is short enough to fit)
true: always space/scale

The following four methods are also provided for convenience, allowing all combinations of scale/force, and using only the 8 parameters of Cell():

CellFitScale()
CellFitScaleForce()
CellFitSpace()
CellFitSpaceForce()

////////////////////////////////////////////////////////////////////////////////

int WordWrap(string &text, float maxwidth)
$text=str_repeat('this is a word wrap test ',20);
$pdf->WordWrap($text,120);
$pdf->Write(5,$text);

////////////////////////////////////////////////////////////////////////////////

SetDash([float black, float white])

black: length of dashes
white: length of gaps

////////////////////////////////////////////////////////////////////////////////

*/
/*
For an image loaded into a string:
MemImage(string data [, float x [, float y [, float w [, float h [, mixed link]]]]])

For a GD image:
GDImage(resource im [, float x [, float y [, float w [, float h [, mixed link]]]]])


<?php
require('mem_image.php');

$pdf = new PDF_MemImage();
$pdf->AddPage();

// Load an image into a variable
$logo = file_get_contents('logo.jpg');
// Output it
$pdf->MemImage($logo, 50, 30);

// Create a GD graphics
$im = imagecreate(200, 150);
$bgcolor = imagecolorallocate($im, 255, 255, 255);
$bordercolor = imagecolorallocate($im, 0, 0, 0);
$color1 = imagecolorallocate($im, 255, 0, 0);
$color2 = imagecolorallocate($im, 0, 255, 0);
$color3 = imagecolorallocate($im, 0, 0, 255);
imagefilledrectangle($im, 0, 0, 199, 149, $bgcolor);
imagerectangle($im, 0, 0, 199, 149, $bordercolor);
imagefilledrectangle($im, 30, 100, 60, 148, $color1);
imagefilledrectangle($im, 80, 80, 110, 148, $color2);
imagefilledrectangle($im, 130, 40, 160, 148, $color3);
// Output it
$pdf->GDImage($im, 120, 25, 40);
imagedestroy($im);

$pdf->Output();
?>

///////////////////////////////////////////





$c=array(60,25,25,25,25,25,25,25,25,25);
$title=array('Nama','Gol','Gapok','Anak','T.Suami/Istri','T.Anak','T.Fungsional','T.Doktoral','Jumlah Gaji','Pembulatan');
$y=20;
$style=array('L','C','R');
col_t($c,$y,$title,$style);
*/

class VariableStream
{
    private $varname;
    private $position;

    function stream_open($path, $mode, $options, &$opened_path)
    {
        $url = parse_url($path);
        $this->varname = $url['host'];
        if(!isset($GLOBALS[$this->varname]))
        {
            trigger_error('Global variable '.$this->varname.' does not exist', E_USER_WARNING);
            return false;
        }
        $this->position = 0;
        return true;
    }

    function stream_read($count)
    {
        $ret = substr($GLOBALS[$this->varname], $this->position, $count);
        $this->position += strlen($ret);
        return $ret;
    }

    function stream_eof()
    {
        return $this->position >= strlen($GLOBALS[$this->varname]);
    }

    function stream_tell()
    {
        return $this->position;
    }

    function stream_seek($offset, $whence)
    {
        if($whence==SEEK_SET)
        {
            $this->position = $offset;
            return true;
        }
        return false;
    }
    
    function stream_stat()
    {
        return array();
    }
}

class PDF_Modify extends FPDF{
    var $angle=0;

    function col_t($c,&$y,$t,$l=''){
        $y+=6;
        $w=0; $i=0;$n=count($c);
        $this->Rect(5,$y-4,array_sum($c),6,'FD');
        if(is_array($l)){
            for($i=0;$i<$n;$i++)
                if(!isset($l[$i]))$l[$i]='C';
        }else for($i=0;$i<$n;$i++)$l[$i]='C';
        for($i=0;$i<$n;$i++){
            if($i==0)$s=1;
            elseif($i==$n-1)$s=-1;
            else $s=0;
            switch($l[$i]){
            case 'L':
                $this->Text(5+$w+$s,$y,$t[$i]);
                break;
            case 'C':
                $this->Text(5+$w+$s+($c[$i]-$this->GetStringWidth($t[$i]))/2,$y,$t[$i]);
                break;
            case 'R':
                $this->Text(5+$w+$s+$c[$i]-$this->GetStringWidth($t[$i]),$y,$t[$i]);
                break;
            }
            $w+=$c[$i];
            //if($i<$n-1)$this->Line(5+$w,$y-4,5+$w,$y+2);
        }
        //$this->Line(5,$y+2,5+$w,$y+2);
    }

    function __construct($orientation='P', $unit='mm', $size='A4')
    {
        parent::__construct($orientation, $unit, $size);
        // Register var stream protocol
        stream_wrapper_register('var', 'VariableStream');
    }

    function MemImage($data, $x=null, $y=null, $w=0, $h=0, $link='')
    {
        // Display the image contained in $data
        $v = 'img'.md5($data);
        $GLOBALS[$v] = $data;
        $a = getimagesize('var://'.$v);
        if(!$a)
            $this->Error('Invalid image data');
        $type = substr(strstr($a['mime'],'/'),1);
        $this->Image('var://'.$v, $x, $y, $w, $h, $type, $link);
        unset($GLOBALS[$v]);
    }

    function GDImage($im, $x=null, $y=null, $w=0, $h=0, $link='')
    {
        // Display the GD image associated with $im
        ob_start();
        imagepng($im);
        $data = ob_get_clean();
        $this->MemImage($data, $x, $y, $w, $h, $link);
    }
    function Header(){
        if(function_exists('PDFHeader'))
            PDFHeader($this);
        $this->SetTitle(ucfirst(D_PAGE).' | '.D_TITLE_PAGE);
        $this->SetAuthor('Dadang Iskandar');
        $this->SetCreator('Dadang Iskandar');
        $this->SetSubject(D_TITLE_PAGE);
        $this->SetKeywords(D_TITLE_PAGE);
    }
    function Circle($x, $y, $r, $style='D')
    {
        $this->Ellipse($x,$y,$r,$r,$style);
    }
    
    function Ellipse($x, $y, $rx, $ry, $style='D')
    {
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $lx=4/3*(M_SQRT2-1)*$rx;
        $ly=4/3*(M_SQRT2-1)*$ry;
        $k=$this->k;
        $h=$this->h;
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x+$rx)*$k,($h-$y)*$k,
            ($x+$rx)*$k,($h-($y-$ly))*$k,
            ($x+$lx)*$k,($h-($y-$ry))*$k,
            $x*$k,($h-($y-$ry))*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x-$lx)*$k,($h-($y-$ry))*$k,
            ($x-$rx)*$k,($h-($y-$ly))*$k,
            ($x-$rx)*$k,($h-$y)*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x-$rx)*$k,($h-($y+$ly))*$k,
            ($x-$lx)*$k,($h-($y+$ry))*$k,
            $x*$k,($h-($y+$ry))*$k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
            ($x+$lx)*$k,($h-($y+$ry))*$k,
            ($x+$rx)*$k,($h-($y+$ly))*$k,
            ($x+$rx)*$k,($h-$y)*$k,
            $op));
    }

    function RotatedText($x,$y,$txt,$angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }
    
    function RotatedImage($file,$x,$y,$w,$h,$angle)
    {
        //Image rotated around its upper-left corner
        $this->Rotate($angle,$x,$y);
        $this->Image($file,$x,$y,$w,$h);
        $this->Rotate(0);
    }
    
    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }
    
    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function Polygon($points, $style='D')
    {
        //Draw a polygon
        if($style=='F')
            $op = 'f';
        elseif($style=='FD' || $style=='DF')
            $op = 'b';
        else
            $op = 's';
    
        $h = $this->h;
        $k = $this->k;
    
        $points_string = '';
        for($i=0; $i<count($points); $i+=2){
            $points_string .= sprintf('%.2F %.2F', $points[$i]*$k, ($h-$points[$i+1])*$k);
            if($i==0)
                $points_string .= ' m ';
            else
                $points_string .= ' l ';
        }
        $this->_out($points_string . $op);
    }

    /**
     * Draws text within a box defined by width = w, height = h, and aligns
     * the text vertically within the box ($valign = M/B/T for middle, bottom, or top)
     * Also, aligns the text horizontally ($align = L/C/R/J for left, centered, right or justified)
     * drawTextBox uses drawRows
     *
     * This function is provided by TUFaT.com
     */
    function drawTextBox($strText, $w, $h, $align='L', $valign='T', $border=true)
    {
        $xi=$this->GetX();
        $yi=$this->GetY();
        
        $hrow=$this->FontSize;
        $textrows=$this->drawRows($w,$hrow,$strText,0,$align,0,0,0);
        $maxrows=floor($h/$this->FontSize);
        $rows=min($textrows,$maxrows);
    
        $dy=0;
        if (strtoupper($valign)=='M')
            $dy=($h-$rows*$this->FontSize)/2;
        if (strtoupper($valign)=='B')
            $dy=$h-$rows*$this->FontSize;
    
        $this->SetY($yi+$dy);
        $this->SetX($xi);
    
        $this->drawRows($w,$hrow,$strText,0,$align,false,$rows,1);
    
        if ($border)
            $this->Rect($xi,$yi,$w,$h);
    }
    
    function drawRows($w, $h, $txt, $border=0, $align='J', $fill=false, $maxline=0, $prn=0)
    {
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b=0;
        if($border)
        {
            if($border==1)
            {
                $border='LTRB';
                $b='LRT';
                $b2='LR';
            }
            else
            {
                $b2='';
                if(is_int(strpos($border,'L')))
                    $b2.='L';
                if(is_int(strpos($border,'R')))
                    $b2.='R';
                $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
            }
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $ns=0;
        $nl=1;
        while($i<$nb)
        {
            //Get next character
            $c=$s[$i];
            if($c=="\n")
            {
                //Explicit line break
                if($this->ws>0)
                {
                    $this->ws=0;
                    if ($prn==1) $this->_out('0 Tw');
                }
                if ($prn==1) {
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                }
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if ( $maxline && $nl > $maxline )
                    return substr($s,$i);
                continue;
            }
            if($c==' ')
            {
                $sep=$i;
                $ls=$l;
                $ns++;
            }
            $l+=$cw[$c];
            if($l>$wmax)
            {
                //Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        if ($prn==1) $this->_out('0 Tw');
                    }
                    if ($prn==1) {
                        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                    }
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        if ($prn==1) $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                    }
                    if ($prn==1){
                        $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                    }
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if ( $maxline && $nl > $maxline )
                    return substr($s,$i);
            }
            else
                $i++;
        }
        //Last chunk
        if($this->ws>0)
        {
            $this->ws=0;
            if ($prn==1) $this->_out('0 Tw');
        }
        if($border && is_int(strpos($border,'B')))
            $b.='B';
        if ($prn==1) {
            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
        }
        $this->x=$this->lMargin;
        return $nl;
    }

    function subWrite($h, $txt, $link='', $subFontSize=12, $subOffset=0)
    {
        // resize font
        $subFontSizeold = $this->FontSizePt;
        $this->SetFontSize($subFontSize);
        
        // reposition y
        $subOffset = ((($subFontSize - $subFontSizeold) / $this->k) * 0.3) + ($subOffset / $this->k);
        $subX        = $this->x;
        $subY        = $this->y;
        $this->SetXY($subX, $subY - $subOffset);
    
        //Output text
        $this->Write($h, $txt, $link);
    
        // restore y position
        $subX        = $this->x;
        $subY        = $this->y;
        $this->SetXY($subX,  $subY + $subOffset);
    
        // restore font size
        $this->SetFontSize($subFontSizeold);
    }

    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max(strlen($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
    }

    function WordWrap(&$text, $maxwidth)
    {
        $text = trim($text);
        if ($text==='')
            return 0;
        $space = $this->GetStringWidth(' ');
        $lines = explode("\n", $text);
        $text = '';
        $count = 0;
    
        foreach ($lines as $line)
        {
            $words = preg_split('/ +/', $line);
            $width = 0;
    
            foreach ($words as $word)
            {
                $wordwidth = $this->GetStringWidth($word);
                if ($wordwidth > $maxwidth)
                {
                    // Word is too long, we cut it
                    for($i=0; $i<strlen($word); $i++)
                    {
                        $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                        if($width + $wordwidth <= $maxwidth)
                        {
                            $width += $wordwidth;
                            $text .= substr($word, $i, 1);
                        }
                        else
                        {
                            $width = $wordwidth;
                            $text = rtrim($text)."\n".substr($word, $i, 1);
                            $count++;
                        }
                    }
                }
                elseif($width + $wordwidth <= $maxwidth)
                {
                    $width += $wordwidth + $space;
                    $text .= $word.' ';
                }
                else
                {
                    $width = $wordwidth + $space;
                    $text = rtrim($text)."\n".$word.' ';
                    $count++;
                }
            }
            $text = rtrim($text)."\n";
            $count++;
        }
        $text = rtrim($text);
        return $count;
    }

    function SetDash($black=null, $white=null)
    {
        if($black!==null)
            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }

    function kepala_tabel($x,$y,$h,$text,$col){
        foreach($text as $k => $v){
            $this->SetY($y);
            $this->SetX($x);
            $this->drawTextBox($v, $col[$k], $h, 'C', 'M', true);
            $x+=$col[$k];
        }
        return $y+$h;
    }
    function isi_tabel($x,$y,$h,$text,$col,$pos='L',$border=true){
        foreach($text as $k => $v){
            $this->SetY($y);
            $this->SetX($x);
            if(is_array($pos))$p=$pos[$k];else $p=$pos;
            $this->drawTextBox($v, $col[$k], $h, $p, 'M', $border);
            $x+=$col[$k];
        }
        return $y+$h;
    }
    function title_table($text,$y){
        $this->SetY($y);
        $this->SetX(0);
        $this->drawTextBox($text, $this->GetPageWidth(), 10, 'C', 'M', false);
    }
}
?>