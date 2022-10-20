<?php
function dir__($s='/'){
    $dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
    $dir.='perataan/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.='bm'.$s;if(!file_exists($dir))mkdir($dir,0755);
    return $dir;
}
function hapus(){
    if(isset($_GET['hapus'])){
        $dir=dir__('');
        rename($dir,$dir.date('-Y-m-d-H-i-s'));
        echo 'ok';
        exit;
    }return false;
}
function getdata(){
    if(isset($_GET['datalist'])){
        $dir=dir__();
        if(file_exists($dir)){
            $sc=scandir($dir);
            $ada=false;
            $m=array();
            $ex='';$i=1;
            $e1='';
            foreach($sc as $k => $v)if($v!='.'&&$v!='..'){
                $ex=explode('.',$v);
                $ex=end($ex);
                $ex=strtolower($ex);
                if($ex=='hout')$e1='Error';
            }
            foreach($sc as $k => $v)if($v!='.'&&$v!='..'){
                $e=$e1;
                $ex=explode('.',$v);
                $ex=end($ex);
                $ex=strtolower($ex);
                if($ex=='csv'){
                    $c=$dir.'/'.$v;
                    $m[]=array($i,$v,'Titik Kontrol','-');
                    $i++;
                }
                if($ex=='raw'){
                    $raw=$dir.'/'.$v;
                    if(file_exists(str_replace($ex,'hout',$raw)))
                    $e='<span class="badge badge-info" data-toggle="modal" data-target="#modal-view" onclick="view_h(\''.$v.'\')">Horizontal Adjustment</span><br>';
                    if(file_exists(str_replace($ex,'vout',$raw)))
                    $e.='<span class="badge badge-info" data-toggle="modal" data-target="#modal-view" onclick="view_v(\''.$v.'\')">Vertical Adjustment</span>';
                    
                    $m[]=array($i,$v,'Data Observasi',$e);
                    $i++;
                }
            }
            echo json_encode($m);
        }else echo '[]';
        exit;
    }return false;
}
function kalkulasi(){
    if(isset($_GET['kalkulasi'])){
        $dir=D_DATABASES_PATH.'perataan/';
        $input=file_get_contents($dir.'input-master.txt');
        $input=explode(chr(10),$input);
        $inp=array();
        $dir1=$dir.$_SESSION['id'].'/bm/';
        $sc=scandir($dir1);
        foreach($sc as $v)if($v!='.'&&$v!='..'&&!is_dir($dir1.$v)){
            $ex=explode('.',$v);
            $ex=end($ex);
            $ex=strtolower($ex);
            if($ex=='csv'){
                $bm=$dir1.$v;
            }
            if($ex=='raw'){
                if(count(explode('5',$v))==1&&count(explode('6',$v))==1)
                $inp[]=$dir1.$v;
            }
        }
        $inp[]='';
        $inp[]=$bm;
        foreach($input as $k => $v)
            if($k>=3&&$k<=49)
            $inp[]=$v;
        $inp[]=$dir1.'poligon.txt';
        $inp[]=$dir1.'titikikat.txt';
        $inp[]=$dir1.'ukuran.txt';
        $inp[]=$dir1.'rep-adjusttment.txt';
        $inp[]=$dir1.'rep-vadjusttment.txt';
        $inp=implode(chr(10),$inp);
        $dir2=$dir1.'input.txt';
        file_put_contents($dir2,$inp);
        echo exec($dir."EToposeis '$dir2'");
        echo 'ok';//*/
    }return false;
}
function viewv(){
    if(isset($_GET['viewv'])){
        $dir=dir__();
        $ex=explode('.',$_GET['viewv']);
        $ex=end($ex);
        $dir.=str_replace($ex,'vout',$_GET['viewv']);
        if(file_exists($dir))
            echo file_get_contents($dir);
        else echo 'The result not found';
        exit;
    }return false;
}
function viewh(){
    if(isset($_GET['viewh'])){
        $dir=dir__();
        $ex=explode('.',$_GET['viewh']);
        $ex=end($ex);
        $dir.=str_replace($ex,'hout',$_GET['viewh']);
        if(file_exists($dir))
            echo file_get_contents($dir);
        else echo 'The result not found';
        exit;
    }return false;
}
function download(){
    if(isset($_GET['download'])){
        $dir=dir__();
        $ex=explode('.',$_GET['download']);
        $ex=end($ex);
        $dir.=str_replace($ex,$_GET['rep'].'out',$_GET['download']);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename('file.txt'));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($dir));
        //header("Content-Disposition: attachment; filename=report.txt");
        readfile($dir);
        exit;
    }return false;
}

if(!download())
if(!viewh())
if(!viewv())
if(!kalkulasi())
if(!getdata())
if(!hapus())
{}
?>