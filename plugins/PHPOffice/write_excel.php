<?php
require __DIR__.'/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$filename='res.xlsx';
$debug=false;

require D_PAGE_PATH.'/'.D_ACTION.'.php';

$writer = new Xlsx($spreadsheet);
force_download_excel($writer,$filename,$spreadsheet,$debug);

function col_width($c,$w){
    $a=$GLOBALS['spreadsheet'];
    $a->getActiveSheet()
    ->getColumnDimension($c)
    ->setWidth($w);
}
function border_cell($c){
    $a=$GLOBALS['spreadsheet'];
    $a->getActiveSheet()
    ->getStyle($c)
    ->getBorders()
    ->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
}
function force_download_excel($writer,$filename,$spreadsheet,$debug=false){
    if(!$debug){
        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment; filename="'.$filename.'"');
    }
    $writer->save('php://output');
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
}
    
function scandir__($dir,$d){
    $res=scandir($dir);
    foreach($res as $k => $v)if($v!='.'&&$v!='..'){
        if(is_dir($dir.$v))scandir__($dir.$v.'/',$d);
        else echo 'require $dir.\''.str_replace($d,'',$dir.$v).'\';<br>';
    }
}


?>