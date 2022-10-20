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

define('D_GALLERIES_PATH',D_HTML.$aplikasi.'/galleries/');
function set_galleries_folder(){
    if(!file_exists(D_GALLERIES_PATH))mkdir(D_GALLERIES_PATH,0755);
    $_SESSION['uploads']=D_GALLERIES_PATH;
    echo 'ok';
}
function set_meta_f($filename){
    $fn=D_GALLERIES_PATH.'metadata.php';
    $extention=explode('.',$filename);$extention=end($extention);
    $filename1=str_replace(' ','-',$filename);
    rename(D_GALLERIES_PATH.$filename,D_GALLERIES_PATH.$filename1);
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
function is_galleries($filename,&$return){
    $fn=D_GALLERIES_PATH.'metadata.php';
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
        if($ada&&(file_exists(D_GALLERIES_PATH.$return['file'])||$url!='')){
            return $r;
        }else{
            return false;
        }
    }else return false;
}
function read_galleries($filename){
    $id=is_galleries($filename,$data);
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
                    default:$d=false;force_download(D_GALLERIES_PATH.$filename,$filename);
                    break;
                }
                if($d)
                    readfile(D_GALLERIES_PATH.$filename);//*/
            }elseif(isset($data['url']))
                return $data['url'];
            else
                return p404();
        }else
            return p404();
    }else return p404();
}
function add_galleriesurl_meta($url){
    if(!file_exists(D_GALLERIES_PATH))mkdir(D_GALLERIES_PATH,0755);
    $fn=D_GALLERIES_PATH.'metadata.php';
    if(!file_exists($fn))file_put_contents($fn,'[]');
    $id=is_galleries($url,$data);
    if($id==0){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        array_push($data,array('title'=>$url,'keyword'=>'','description'=>'','file'=>'','status'=>1,'extention'=>'','url'=>$url));
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function add_galleries_meta($filename,$title,$keyword,$description,$extention,$url=''){
    if(!file_exists(D_GALLERIES_PATH))mkdir(D_GALLERIES_PATH,0755);
    $fn=D_GALLERIES_PATH.'metadata.php';
    if(!file_exists($fn))file_put_contents($fn,'[]');
    $id=is_galleries($filename,$data);
    if($id==0){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        array_push($data,array('title'=>$title,'keyword'=>$keyword,'description'=>$description,'file'=>$filename,'status'=>1,'extention'=>$extention,'url'=>$url));
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function edit_galleriesurl_meta($title,$url){
    $id=is_galleries($url,$data);
    if($id>0){
        $fn=D_GALLERIES_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['url']=$url;
        $data[$id-1]['url']=$url;
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function edit_galleries_meta($filename,$title,$keyword,$description){
    $id=is_galleries($filename,$data);
    if($id>0){
        $fn=D_GALLERIES_PATH.'metadata.php';
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
function delete_galleries_meta($filename){
    $id=is_galleries($filename,$data);
    if($id>0){
        $fn=D_GALLERIES_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if($data[$id-1]['url']=='')
        unlink(D_GALLERIES_PATH.$filename);
        unset($data[$id-1]);
        $data=array_values($data);
        $data=json_encode($data);
        file_put_contents($fn,$data);
        return true;
    }else return false;
}
function get_galleries_meta($filename=''){
    if($filename==''){
        $fn=D_GALLERIES_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        return $data;
    }else{
        $id=is_galleries($filename,$data);
        if($id>0){
            return $data;
        }else return array();
    }
}
function change_title_galleries($filename,$title){
    $id=is_galleries($filename,$data);
    if($id>0){
        $fn=D_GALLERIES_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
        $data[$id-1]['title']=$title;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }else return false;
}
function change_keyword_galleries($filename,$keyword){
    $id=is_galleries($filename,$data);
    if($id>0){
        $fn=D_GALLERIES_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['keyword']=$keyword;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }else return false;
}
function change_description_galleries($filename,$description){
    $id=is_galleries($filename,$data);
    if($id>0){
        $fn=D_GALLERIES_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['description']=$description;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }else return false;
}
function change_status_galleries($filename,$status){
    $id=is_galleries($filename,$data);
    if($id>0){
        $fn=D_GALLERIES_PATH.'metadata.php';
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $data[$id-1]['status']=$status;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }else return false;
}
function check_status_galleries($filename){
    $id=is_galleries($filename,$data);
    if($id>0){
        return $data['status'];
    }else   
        return false;
}
?>