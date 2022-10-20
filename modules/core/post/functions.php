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
define('D_POST_PATH',D_HTML.$aplikasi.'/post/');
function get_key_for_web($data){
    $k=array_keys($data);arsort($k);
    return array_values($k);
}
function get_img_for_web($data){
    if(isset($data['url']))
        return $data['url'];
}
function get_url_for_web($data,$k){
    return '/'.($k+1).'/'.$data['title'];
}
function get_title_for_web($data){
    return $data['title'];
}
function get_contents_for_web($data,$k,$max=200){
    $a=str_word_count(strip_tags(get_script($k+1,$data['title'])),1,'0123456789');
    if(count($a)<$max)return implode(' ',$a);else{
        $b=array();
        for($i=0;$i<201;$i++)
            $b[$i]=$a[$i];
        return implode(' ',$b);
    }
}
function get_date_file($data){
    $f=explode('-',$data['file']);
    return date('d F Y',strtotime($f[1].'-'.$f[2].'-'.$f[3]));
}
function set_script($id,$script){
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
        file_put_contents(D_POST_PATH.$data[$id-1]['file'],$script);
    }
}
function get_script($id,$title){
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
            if($data[$id-1]['title']==$title)
                return file_get_contents(D_POST_PATH.$data[$id-1]['file']);
    }else return '';
}
function add_post_meta($title,$keyword,$description){
    $a=0;
    if(!file_exists(D_POST_PATH))mkdir(D_POST_PATH,0755);
    $fn=D_POST_PATH.'metadata.php';
    $filename='post-'.date('Y-m-d-H-i-s').'.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        $ada=false;
        foreach($data as $k => $v)
            $ada=$ada||$v['title']==$title;
        if(!$ada){
            array_push($data,array('title'=>$title,'keyword'=>$keyword,'description'=>$description,'file'=>$filename,'status'=>1));
            file_put_contents(D_POST_PATH.$filename,'');
            $data=json_encode($data);
            file_put_contents($fn,$data);
        }else return $a;
    }else{
        $data=array(array('title'=>$title,'keyword'=>$keyword,'description'=>$description,'file'=>$filename,'status'=>1));
        file_put_contents(D_POST_PATH.$filename,'');
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }
    $a=1;
    return $a;
}
function add_post_url($id,$url){
    $a=0;
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1])){
            $data[$id-1]['url']=$url;
        }
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }
    $a=1;
    return $a;
}
function edit_post_meta($id,$title,$keyword,$description){
    $a=0;
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1])){
            $data[$id-1]['title']=$title;
            $data[$id-1]['keyword']=$keyword;
            $data[$id-1]['description']=$description;
        }
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }
    $a=1;
    return $a;
}
function delete_post_meta($id){
    $a=0;
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        unlink(D_POST_PATH.$data[$id-1]['file']);
        unset($data[$id-1]);
        $data=array_values($data);
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }
    $a=1;
    return $a;
}
function get_post_meta($id=0){
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if($id>0)
            return $data[$id-1];
        else
            return $data;
    }else return array();
}
function change_title_post($id,$title){
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
        $data[$id-1]['title']=$title;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }
}
function change_keyword_post($id,$keyword){
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
        $data[$id-1]['keyword']=$keyword;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }
}
function change_description_post($id,$description){
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
        $data[$id-1]['description']=$description;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }
}
function change_status_post($id,$status){
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
        $data[$id-1]['status']=$status;
        $data=json_encode($data);
        file_put_contents($fn,$data);
    }
}
function check_status_post($id){
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn)){
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1]))
            return $data[$id-1]['status'];
        else
            return 0;
    }
}
function is_post_script($id,$title){
    $r=false;
    $fn=D_POST_PATH.'metadata.php';
    if(file_exists($fn))
        $data=file_get_contents($fn);
        $data=json_decode($data,true);
        if(isset($data[$id-1])){
            if($data[$id-1]['title']==$title){
                if($data[$id-1]['status']){
                    if(file_exists(D_POST_PATH.$data[$id-1]['file'])){
                        $r=true;
        }}}}
    return $r;
}
?>