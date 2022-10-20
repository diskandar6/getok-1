<?php
if(isset($_GET['aplikasi'])){
    $aplikasi=$_GET['aplikasi'];
    if($aplikasi=='')
        $aplikasi=D_DOMAIN;
}elseif(isset($_POST['aplikasi'])){
    $aplikasi=$_POST['aplikasi'];
    if($aplikasi=='')
        $aplikasi=D_DOMAIN;
}else
    $aplikasi=D_DOMAIN;

define('D_MEDIA_PATH',D_HTML.$aplikasi.'/media/');
function set_media_folder(){
    if(!file_exists(D_MEDIA_PATH))mkdir(D_MEDIA_PATH,0755);
    $_SESSION['uploads']=D_MEDIA_PATH;
    echo 'ok';
}
function set_meta_f($filename){
    $fn=D_MEDIA_PATH.'metadata.php';
    $extention=explode('.',$filename);$extention=end($extention);
    $filename1=str_replace(' ','-',$filename);
    rename(D_MEDIA_PATH.$filename,D_MEDIA_PATH.$filename1);
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        array_push($data,array('title'=>$filename,'keyword'=>'','description'=>'','file'=>$filename1,'status'=>1,'extention'=>$extention,'url'=>''));
    }else{
        $data=array(array('title'=>$filename,'keyword'=>'','description'=>'','file'=>$filename1,'status'=>1,'extention'=>$extention,'url'=>''));
    }
    $data=json_encode($data);
    file_put_contents($fn,$data);
}
function is_media($filename,&$return){
    $fn=D_MEDIA_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $ada=false;$r=0;$url='';$return='';
        foreach($data as $k => $v)
            if($v['file']===$filename||$v['url']===$filename){
                $ada=true;
                $r=$k+1;
                if(isset($v['url']))
                    $url=$v['url'];
                else
                    $url='';
                $return=$v;
            }
        if($ada&&(file_exists(D_MEDIA_PATH.$return['file'])||$url!='')){
            return $r;
        }else{
            return false;
        }
    }else return false;
}
function read_media($filename){
    $id=is_media($filename,$data);
    $id=(int)$id;
    if($id>0){
        if($data['status']&&$data['url']==''){
            if(isset($data['extention'])){
                $d=true;
                switch($data['extention']){
                    case 'jpg':header("Content-Type: image/jpeg");break;
                    case 'jpeg':header("Content-Type: image/jpeg");break;
                    case 'png':header("Content-Type: image/png");break;
                    case 'gif':header("Content-Type: image/gif");break;
                    case 'mp4':header("Content-Type: video/mp4");break;
                    case 'pdf':header('Content-Type: application/pdf');break;
                    default:$d=false;force_download(D_MEDIA_PATH.$filename,$filename);
                    break;
                }
                if($d)
                    readfile(D_MEDIA_PATH.$filename);//*/
            }elseif(isset($data['url']))
                return $data['url'];
            else
                return p404();
        }else
            return p404();
    }else return p404();
}
function add_mediaurl_meta($url){
    if(!file_exists(D_MEDIA_PATH))mkdir(D_MEDIA_PATH,0755);
    $fn=D_MEDIA_PATH.'metadata.php';
    if(!file_exists($fn))file_put_contents($fn,'[]');
    $id=is_media($url,$data);
    if($id==0){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        array_push($data,array('title'=>$url,'keyword'=>'','description'=>'','file'=>'','status'=>1,'extention'=>'','url'=>$url));
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function add_media_meta($filename,$title,$keyword,$description,$extention,$url=''){
    if(!file_exists(D_MEDIA_PATH))mkdir(D_MEDIA_PATH,0755);
    $fn=D_MEDIA_PATH.'metadata.php';
    if(!file_exists($fn))file_put_contents($fn,'[]');
    $id=is_media($filename,$data);
    if($id==0){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        array_push($data,array('title'=>$title,'keyword'=>$keyword,'description'=>$description,'file'=>$filename,'status'=>1,'extention'=>$extention,'url'=>$url));
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function edit_mediaurl_meta($title,$url){
    $id=is_media($url,$data);
    if($id>0){
        $fn=D_MEDIA_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['url']=$url;
        $data[$id-1]['url']=$url;
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function edit_media_meta($filename,$title,$keyword,$description){
    $id=is_media($filename,$data);
    if($id>0){
        $fn=D_MEDIA_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['title']=$title;
        if($data[$id-1]['url']==''){
            $data[$id-1]['keyword']=$keyword;
            $data[$id-1]['description']=$description;
        }else{
            $data[$id-1]['keyword']='';
            $data[$id-1]['description']='';
        }
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function delete_media_meta($filename){
    $id=is_media($filename,$data);
    if($id>0){
        $fn=D_MEDIA_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if($data[$id-1]['url']=='')
        unlink(D_MEDIA_PATH.$filename);
        unset($data[$id-1]);
        $data=array_values($data);
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function get_media_meta($filename=''){
    if($filename==''){
        $fn=D_MEDIA_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        return $data;
    }else{
        $id=is_media($filename,$data);
        if($id>0){
            return $data;
        }else return array();
    }
}
function change_title_media($filename,$title){
    $id=is_media($filename,$data);
    if($id>0){
        $fn=D_MEDIA_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
        $data[$id-1]['title']=$title;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }else return false;
}
function change_keyword_media($filename,$keyword){
    $id=is_media($filename,$data);
    if($id>0){
        $fn=D_MEDIA_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['keyword']=$keyword;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }else return false;
}
function change_description_media($filename,$description){
    $id=is_media($filename,$data);
    if($id>0){
        $fn=D_MEDIA_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['description']=$description;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }else return false;
}
function change_status_media($filename,$status){
    $id=is_media($filename,$data);
    if($id>0){
        $fn=D_MEDIA_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['status']=$status;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }else return false;
}
function check_status_media($filename){
    $id=is_media($filename,$data);
    if($id>0){
        return $data['status'];
    }else   
        return false;
}
?>