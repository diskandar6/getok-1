<?php
include "functions.php";

$from=array('address'=>'simamaung@gmail.com','name'=>'Dadang Iskandar');
$replay=array('address'=>'support@stikes-aisyiyahbandung.ac.id','name'=>'Support');
$recipients=array(array('address'=>'diskandar6@gmail.com','name'=>'Dadang Iskandar'));
$cc=array();
$subject='Tes';
$content='Ini adalah isi dari email<br>OK';
if(send_mail($from,$replay,$recipients,$cc,$subject,$content))
	echo 'ok';
else echo 'no';
?>