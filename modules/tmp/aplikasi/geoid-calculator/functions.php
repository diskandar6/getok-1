<?php
if(!defined('D_GEOID-CALCULATOR')){define('D_GEOID-CALCULATOR',true);
require __DIR__.'/variable.php';

require D_PLUGIN_PATH.'markrogoyski/load.php';

function download_hasil_geoid(){
    force_download($_SESSION['resgeoid'],'hasil_Geoid.txt');
}

function proses_data_geoid(){
    $_SESSION['exekusi_geoid']=true;
    $_SESSION['prog']='Reading data...';
    $_SESSION['bar']=0;
    $_SESSION['lines']=$_POST['lines'];
    $_SESSION['delimiter']=$_POST['delimiter'];
    $_SESSION['format']=$_POST['format'];

    $dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
    $dir.='geoid/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.='res/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=date('YmdHis').'.txt';
    $_SESSION['resgeoid']=$dir;
    header("location: /".D_PAGE);//*/
}

}?>