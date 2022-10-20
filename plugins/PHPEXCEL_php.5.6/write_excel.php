<?php
require_once __DIR__.'/PHPExcel.php';

$spreadsheet = new PHPExcel();
$filename='res.xlsx';
$debug=false;

require D_PAGE_PATH.'/'.D_ACTION.'.php';

$writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel2007');
force_download_excel($writer,$filename,$spreadsheet,$debug);

unset($writer);
unset($spreadsheet);

function force_download_excel($writer,$filename,$spreadsheet,$debug=false){
    if(!$debug){
        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment; filename="'.$filename.'"');
    }
    $writer->save('php://output');
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
}
function col_width($c,$w){
    $a=$GLOBALS['spreadsheet'];
    $a->getActiveSheet()
    ->getColumnDimension($c)
    ->setWidth($w);
}
function border_cell($sheet,$c){
    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
    $sheet->getStyle($c)->applyFromArray($styleArray);
}
function scandir__($dir,$d){
    $res=scandir($dir);
    foreach($res as $k => $v)if($v!='.'&&$v!='..'){
        if(is_dir($dir.$v))scandir__($dir.$v.'/',$d);
        else echo 'require $dir.\''.str_replace($d,'',$dir.$v).'\';<br>';
    }
}
function RP_Format($a,$cell){
	$a->getStyle($cell)->applyFromArray(array('alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)));
	$a->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_IDR);
}

function titel($a,$text){
	$a->setTitle($text);
}
function col($a,$b){
	$c=range('A','Z');
	$r=0;
	for($i=0;$i<count($b);$i++){
		$a->getColumnDimension($c[$i])->setWidth($b[$i]/7);
		$r+=$b[$i];
	}
}
function merge($a,$b){
	$a->mergeCells($b);
}
function cell($a,$cell,$text,$style){
	$a->setCellValue($cell,$text)->getStyle($cell)->applyFromArray($style);
}
/*function ttd($objPHPExcel,$objDrawing,$ww=600,$pos='A1',$ttm='',$debug=false){
	function kata($im,$x,$y,$w,$fs,$k,$underline=false,$debug=false){
		$font=dirname(__FILE__).'/images/arial.ttf';
		$black=imagecolorallocate($im,0,0,0);
		$box=imagettfbbox($fs,0,$font,$k);
		$w1=$box[4]-$box[0];$h1=$box[1]-$box[5];
		imagefttext($im,$fs,0,$x+$w/2-$w1/2,$y+$h1,$black,$font,$k);
		if($debug)
			imagerectangle($im,$x,$y,$x+$w,$y+$h1+1,$black);
		if($underline)
			imageline($im,$x+$w/2-$w1/2,$y+$h1+2,$x+$w/2+$w1/2,$y+$h1+2,$black);
		return $h1;
	}
	$width=600;
	$padding=0;
	$height=200;
	$width+=$width;
	$padding+=$padding;
	$height+=$height;
	$im = imagecreatetruecolor($width, $height);
	$white = imagecolorallocate($im, 255, 255, 255);
	$black = imagecolorallocate($im, 0, 0, 0);
	imagecolortransparent($im, $white);
	imagefilledrectangle($im, 0, 0, $width,$height, $white);
	
	$d=($width-2*$padding)/3;

	$fs=16;
	kata($im,$padding,$padding,$d*2,$fs,'Menyetujui,');
	$h=kata($im,$padding+$d*2,$padding,$d,$fs,'Bandung, '.titimangsa($ttm));
	$h+=5;
	kata($im,$padding,		$padding+$h+5,$d,$fs,'Wakil Ketua II');
	kata($im,$padding+$d,	$padding+$h,$d,$fs,'Kabag Keuangan dan Kepegawaian');
	$h=kata($im,$padding+$d*2,	$padding+$h,$d,$fs,'Sub Bagian Keuangan');
	$h+=8*$h;
	kata($im,$padding,		$padding+$h,$d,$fs,'( '.get_option('wakil ketua').' )',1);
	kata($im,$padding+$d,	$padding+$h,$d,$fs,'( '.get_option('kabag keuangan').' )',1);
	$h=kata($im,$padding+$d*2,	$padding+$h,$d,$fs,'( '.get_option('subbag keuangan').' )',1);
	$h+=$h*9+15;
	$h+=kata($im,$padding,	$padding+$h,$d*3,$fs,'Mengetahui,');
	$h+=5;
	$h+=kata($im,$padding,	$padding+$h,$d*3,$fs,'Ketua')*9;
	kata($im,$padding,		$padding+$h,$d*3,$fs,'( '.get_option('ketua').' )',1);

	$fn=dirname(__FILE__).'/images/ttd.png';
	imagepng($im,$fn);
	imagedestroy($im);
	//$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('tanda tangan');
	$objDrawing->setDescription('tanda tangan');
	$objDrawing->setPath($fn);
	//$objDrawing->setHeight($ww);
	$objDrawing->setWidth($ww);
	$objDrawing->setCoordinates($pos);
	$objDrawing->setOffsetX(0);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
}
*/


function DateFormat($a,$cell){
	$a->getStyle($cell)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME);
}

function Style($a,$cell,$style){
	$a->getStyle($cell)->applyFromArray($style);
}

function baris($a,$b,$r,$style,$x=0){
	$c=str_split(_ALPABET_);
	foreach ($b as $key => $value)
		$a->setCellValue($c[$key+$x].$r,$value)->getStyle($c[$key+$x].$r)->applyFromArray($style);
	return $r+1;
}

function setarea($a,$area,$orientasi='portrait'){
	if($orientasi=='portrait')
		$a->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	else
		$a->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$a->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$a->getPageSetup()->setPrintArea($area);
}
/*
$objPHPExcel->getProperties()->setCreator("Dadang Iskandar")
							 ->setLastModifiedBy("Dadang Iskandar")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("Keuangan STIKes `Aisyiyah Bandung")
							 ->setKeywords("office 2007 openxml")
							 ->setCategory("STIKes `Aisyiyah Bandung");//*/
$style=array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 
					//HORIZONTAL_RIGHT, HORIZONTAL_CENTER,  HORIZONTAL_CENTER_CONTINUOUS, HORIZONTAL_JUSTIFY
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM, 
					//VERTICAL_TOP, VERTICAL_CENTER, VERTICAL_JUSTIFY
				),
			'font' => array(
				'bold' => false,
				'underline' => false,
				'italic' => false,
				'size' => 11,
				'name' => 'calibri',
				),
			'borders' => array(
				'outline'=> array('style' => PHPExcel_Style_Border::BORDER_NONE,
					//BORDER_THIN, BORDER_MEDIUM, BORDER_DASHED, BORDER_DOTTED, BORDER_THICK, BORDER_DOUBLE, BORDER_HAIR, BORDER_MEDIUMDASHED, BORDER_DASHDOT, BORDER_MEDIUMDASHDOT, BORDER_DASHDOTDOT, BORDER_MEDIUMDASHDOTDOT, BORDER_SLANTDASHDOT
					'color' => array('argb' => 'FF000000'),
					),
				'inside' => array(
					'style' => PHPExcel_Style_Border::BORDER_NONE,
					'color' => array('argb' => 'FF000000'),
					),

				)
			);
//*/
?>