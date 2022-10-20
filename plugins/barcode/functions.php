<?php
function create_qr_to_file($dir,$data){
    require __DIR__.'/barcode.php';
    $generator = new barcode_generator();
    return $generator->output_image('png', 'qr', $data, array('p'=>1),$dir,true);
}
function create_bc_to_file($dir,$data){
    require __DIR__.'/barcode.php';
    $generator = new barcode_generator();
    return $generator->output_image('png', 'code128a', $data, array('p'=>1,'w'=>500,'h'=>100),$dir,true);
}
function create_qr_to_view($data){
    require __DIR__.'/barcode.php';
    $generator = new barcode_generator();
    return $generator->output_image('png', 'qr', $data, array('p'=>1),'',true);
}
?>