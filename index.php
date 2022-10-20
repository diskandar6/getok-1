<?php

/*//////////////////////////////////////////////////////////////
//		AUTHOR 	:	DADANG ISKANDAR
//		DATE 	: 	10 MARET 2020
//					BANDUNG
//////////////////////////////////////////////////////////////*/

$dir=__DIR__;
define('D_KEY_PIPE',md5(rand(0,1000)));
define('D_MAIN_PATH',__DIR__.'/');

if(file_exists(D_MAIN_PATH.'install.php')){
	require D_MAIN_PATH.'install.php';
	exit;
}

//	konfigurasi database phpmyadmin
require $dir.'/core/config.php';

//	fungsi-fungsi inti
require $dir.'/core/functions.php';

$_SESSION['debug']=true;

if(isset($_SESSION['debug'])){
    ini_set("log_errors", 1);
    ini_set("display_errors",1);
    $dd=$dir.'/modules/'.$_SERVER['SERVER_NAME']."/error.log";
    ini_set("error_log",$dd);
}

//	engine penggerak sistem
require $dir.'/core/engine.php';

?>
