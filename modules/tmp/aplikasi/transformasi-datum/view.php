<?php
$var=json_decode(D_VARIABLES,true);
if(isset($var[1]))require __DIR__.'/detil.php';else require __DIR__.'/awal.php';
?>