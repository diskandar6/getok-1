<?php
error_reporting(0);

use setasign\Fpdi\Fpdi;

require_once(D_PLUGIN_PATH.'fpdf/fpdf.php');
require_once(D_PLUGIN_PATH.'fpdi/FPDI-2.3.6/src/autoload.php');

/*

$src=array('src'=>'/mnt/data1/database/ts.pdf','out'=>'Compiled.pdf','nomor'=>0);
$img=array(
        array('src'=>'tes1.png','x'=>100,'y'=>100,'w'=>100),
        array('src'=>'tes2.png','x'=>100,'y'=>200,'w'=>100)
    )
$text=array(
        array('font'=>'Helvetica','r'=>255,'g'=>0,'b'=>0,'x'=>30,'y'=>30,'text'=>'teks 1','size'=>120),
        array('font'=>'Helvetica','r'=>255,'g'=>0,'b'=>0,'x'=>30,'y'=>40,'text'=>'teks 2','size'=>10)
    )

*/
function compile_png_to_pdf($src,$img,$text=array(),$out='I'){
    // initiate FPDI
    $pdf = new Fpdi();
    // add a page
    ///$pdf->AddPage();
    // set the source file
    $n=$pdf->setSourceFile($src['src']);
    for($i=0;$i<$n;$i++){
        // import page 1
        $tplIdx = $pdf->importPage($i+1);
        $size = $pdf->getTemplateSize($tplIdx);
        $pdf->AddPage();//'P',$size['w'], $size['h']);
        $pdf ->useTemplate($tplIdx, 0, 0, $size['w'], $size['h'], true);
        // use the imported page and place it at position 10,10 with a width of 100 mm
        //$pdf->useTemplate($tplIdx, 0, 0, $pdf->GetPageWidth());
        
        if($src['nomor']==$i){
            // now write some text above the imported page
            foreach($text as $k => $v){
                $pdf->SetFont($v['font'],$v['bold']);//'Helvetica');
                $pdf->SetTextColor($v['r'],$v['g'],$v['b']);//255, 0, 0);
                $pdf->SetXY($v['x'],$v['y']);//30, 30);
                $pdf->SetFontSize($v['size']);
                if(isset($v['ratah']))$c=$v['ratah'];else $c='C';
                if(isset($v['ratav']))$m=$v['ratav'];else $m='M';
                if(isset($v['h']))$h=$v['h'];else $h=0;
                $pdf->drawTextBox($v['text'], $v['w'], $h, $c, $m, $v['border']);
            }
            foreach($img as $k => $v)
            $pdf->Image($v['src'],$v['x'],$v['y'],$v['w']);
        }
    }
    $pdf->Output($out, $src['out']);
}
/*
//your variables
$filename = 'tes.pdf';

use setasign\Fpdi\Fpdi;

require_once('../../fpdf/fpdf.php');
require_once('src/autoload.php');

$pdf = new Fpdi();

$pageCount = $pdf->setSourceFile($filename);

$width = $pdf->GetPageWidth() / 2 - 15;
$height = 0;

$_x = $x = 10;
$_y = $y = 10;

$pdf->AddPage();
for ($n = 1; $n <= $pageCount; $n++) {
    $pageId = $pdf->importPage($n);

    $size = $pdf->useImportedPage($pageId, $x, $y, $width);
    $pdf->Rect($x, $y, $size['width'], $size['height']);
    $height = max($height, $size['height']);
    if ($n % 2 == 0) {
        $y += $height + 10;
        $x = $_x;
        $height = 0;
    } else {
        $x += $width + 10;
    }

    if ($n % 4 == 0 && $n != $pageCount) {
        $pdf->AddPage();
        $x = $_x;
        $y = $_y;
    }
}

$pdf->Output('I', 'thumbnails.pdf');
/*
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

require_once('../../fpdf/fpdf.php');
require_once('src/autoload.php');

// initiate FPDI
$pdf = new Fpdi();
// add a page
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
// set the sourcefile
$pdf->setSourceFile('tes.pdf');

$offsetTop = 15;

// import MediaBox from page 1
$box = PdfReader\PageBoundaries::MEDIA_BOX;
$pdf->Cell(60, 4, $box);
$pageId = $pdf->importPage(1, $box);
$size = $pdf->useTemplate($pageId, 10, $offsetTop, 50);
$pdf->Rect(10, $offsetTop, $size['width'], $size['height']);

// re-import page ones CropBox
$box = PdfReader\PageBoundaries::CROP_BOX;
$pdf->Cell(60, 4, $box);
$pageId = $pdf->importPage(1, $box);
$size = $pdf->useTemplate($pageId, 70, $offsetTop, 50);
$pdf->Rect(70, $offsetTop, $size['width'], $size['height']);

// re-import page ones TrimBox
$box = PdfReader\PageBoundaries::TRIM_BOX;
$pdf->Cell(60, 4, $box);
$pageId = $pdf->importPage(1, $box);
$size = $pdf->useTemplate($pageId, 130, $offsetTop, 50);
$pdf->Rect(130, $offsetTop, $size['width'], $size['height']);

$offsetTop = 100;
$pdf->Ln($offsetTop - 15);

// re-import page ones BleedBox
$box = PdfReader\PageBoundaries::BLEED_BOX;
$pdf->Cell(60, 4, $box);
$pageId = $pdf->importPage(1, $box);
$size = $pdf->useTemplate($pageId, 10, $offsetTop, 50);
$pdf->Rect(10, $offsetTop, $size['width'], $size['height']);

// re-import page ones ArtBox
$box = PdfReader\PageBoundaries::ART_BOX;
$pdf->Cell(60, 4, $box);
$pageId = $pdf->importPage(1, $box);
$size = $pdf->useTemplate($pageId, 70, $offsetTop, 50);
$pdf->Rect(70, $offsetTop, $size['width'], $size['height']);

$pdf->Output('I', 'newpdf.pdf');
//*/
?>