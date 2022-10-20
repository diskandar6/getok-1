<?php
if(!defined('PDF_FUNCTIONS')){define('PDF_FUNCTIONS',true);

require __DIR__.'/fpdf_modif.php';
$pdf=new PDF_Modify;
$pdf->AddPage();
if(!isset($logo))$logo='logo/kop_unisa.png';
$pdf->Image(D_ASSETS_PATH.$logo,10,5,190);
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,48);$pdf->drawTextBox($titel_halaman,200,7,'C','T',false);
define('D_MAXY',265);
function max_y($pdf,&$y){
    if($y>D_MAXY){
        $pdf->AddPage();
        $y=10;
        return true;
    }return false;
}
function set_data($pdf,$data,$lebar,$styleh,$stylev,&$y,$bg=false,$line=false){
    $x=10;
    if($bg){
        if($data[0]%2==0){
            $pdf->SetFillColor(230,250,230);
            $pdf->Rect($x,$y,array_sum($lebar),8,'F');
        }
    }
    foreach($data as $k => $v){
        $pdf->SetXY($x,$y);
        $pdf->drawTextBox($v,$lebar[$k],8,$styleh[$k],$stylev[$k],false);
        $x+=$lebar[$k];
    }
    $y+=8;
    $x=10;
    if($line)
        $pdf->Line($x,$y-0.5,$x+array_sum($lebar),$y-0.5);
}

}
?>