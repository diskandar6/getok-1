<?php
function dir__(){
    $dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
    $dir.='gnss/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
    return $dir;
}
function get_rnx(){
    if(isset($_GET['load_rnx'])){
        $dir=dir__().'RNX/';if(!file_exists($dir))mkdir($dir,0755);
		if(file_exists($dir)){
			$fn=scandir($dir);unset($fn[0]);unset($fn[1]);
			$fn=array_values($fn);
		}else $fn=array();
		echo json_encode($fn);
    }return false;
}

function hapus(){
    if(isset($_GET['hapus'])){
        $dir=dir__();
        $t=date('YmdHis');
        if(!file_exists($dir.'RNX/'))mkdir($dir.'RNX/',0755);
	    if(file_exists($dir.'RNX/')){
            $sd=scandir($dir.'RNX/');
            if(isset($sd[2])){
                $bu=$dir.'/BACKUP';
                if(!file_exists($bu))mkdir($bu,0755);
                rename($dir.'RNX/',$bu.'/RNX-'.$t);
                if(!file_exists($dir.'RNX/'))mkdir($dir.'RNX/',0755);
            }
        }
	    if(file_exists($dir.'OUT/')){
            $sd=scandir($dir.'OUT/');
            if(isset($sd[2])){
                $bu=$dir.'/BACKUP';
                if(!file_exists($bu))mkdir($bu,0755);
                rename($dir.'OUT/',$bu.'/OUT-'.$t);
                if(!file_exists($dir.'OUT/'))mkdir($dir.'OUT/',0755);
            }
        }
        echo 'ok';
        exit;
    }return false;
}
function download(){
    if(isset($_GET['download'])){
		$dir=dir__().'/OUT/GETOK.CRD';
		if(file_exists($dir)){
    		if(file_get_contents($dir)!='')
	    		force_download($dir,'OUTPUT.CRD');
		}else file_put_contents($dir,'');
        exit;
    }return false;
}
function view(){
    if(isset($_GET['lihathasil'])){
        $dir=dir__().'/OUT/GETOK.CRD';
        if(file_exists($dir))
            echo file_get_contents($dir);
        exit;
    }return false;
}
function kalkulasi(){
    if(isset($_GET['stasiun'])){
        $d=dir__();
        $dir=$d.'GNSS_KF.INP';
		$inp ='USER    : '.$_SESSION['FullName'].chr(10);
		$inp.='MODE    : '.$_GET['mode'].chr(10);
		$inp.='DATA    : '.$_GET['data'].chr(10);
		$inp.='STA REF : '.$_GET['stasiun'].chr(10);
		$x=sprintf('%14.4f',(float)$_GET['x']);
		$y=sprintf('%14.4f',(float)$_GET['y']);
		$z=sprintf('%14.4f',(float)$_GET['z']);
		$inp.='STA POS :'.$x.''.$y.''.$z.chr(10);
		$inp.='ELEV    : '.$_GET['elev'].chr(10);
		file_put_contents($dir, $inp);print_r($d.'GNSS_KF');
		echo exec($d.'GNSS_KF');
		exit;
    }return false;
}
/*
    		$fn=$dir.'GNSS_KF.INP';
    		$inp ='USER    : '.$_POST['user'].chr(10);
    		$inp.='MODE    : '.$_POST['mode'].chr(10);
    		$inp.='DATA    : '.$_POST['data'].chr(10);
    		$inp.='STA REF : '.$_POST['stasiun'].chr(10);
    		$x=sprintf('%14.4f',(float)$_POST['x']);
    		$y=sprintf('%14.4f',(float)$_POST['y']);
    		$z=sprintf('%14.4f',(float)$_POST['z']);
    		$inp.='STA POS :'.$x.''.$y.''.$z.chr(10);
    		$inp.='ELEV    : '.$_POST['elev'].chr(10);
    		file_put_contents($fn, $inp);
    		//print_r($dir.'GNSS_KF');
    		//print_r(
    		    shell_exec('cd "'.$dir.'" && ./GNSS_KF')
    		    /*);/* /;//* /
    		return 'ok';

*/

if(!kalkulasi())
if(!view())
if(!download())
if(!hapus())
if(!get_rnx())
{}
?>