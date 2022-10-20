<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
//	SET TIME ZONE
date_default_timezone_set('asia/jakarta');

//  REDEFINED COOKIES
session_cookies_();

//	ALLOWED IP
$ip=get_client_ip();

if(defined('D_NOTALLOWEDIP')){
	$ips=json_decode(D_NOTALLOWEDIP,true);
	if(in_array($ip, $ips)){
		kesalahan();
    	exit;
    }
}

initialization();

//	GET PAGE
$VAR=json_decode(D_VARIABLES);
if(isset($VAR[0])){
	if(isset($VAR[1])){
		if($VAR[0]=='data'
		|| $VAR[0]=='pdf'
		|| $VAR[0]=='excel'
		|| $VAR[0]=='int'
		|| $VAR[0]=='plugin'){
			define('D_PAGE',$VAR[1]);
			define('D_ACTION',$VAR[0]);
        }else{
            if((int)$VAR[0]>0){
                define('D_PAGE','post');
            }else
                define('D_PAGE',$VAR[0]);
		}
	}else{
		if($VAR[0]=='logout')
			logout_();
		else{
			define('D_PAGE',$VAR[0]);
		}
	}
}else
	define('D_PAGE','home');
unset($VAR);

get_registry_application();

/*/	SETUP DATABASE
if(file_exists(D_CORE_PATH.'wp-db.php'))
	require D_CORE_PATH.'wp-db.php';
else{
	error_message('DATABASE');
	kesalahan();
   	exit;
}//*/

$db=database_list(D_APPLICATION_PATH.'db.php');
foreach($db as $k => $v)$$k=db_connection($v);

$callfunc=array();

if(D_PAGE!=='develop'){
//$_SESSION['debug']=false;//if(!isset($_SESSION['id']))$_SESSION['debug']=true;
    //$pk=load_packages(D_DOMAIN);
    //foreach($pk as $k => $v){ $fn=$v.'functions.php'; if(file_exists($fn)){ require $fn; } }
    $pk=module_list(D_DOMAIN);//debug_r($pk);
    foreach($pk as $k => $v){
        $fn=$v.'functions.php';//debug_r($fn.chr(10));
        if(file_exists($fn))
            require $fn;
    }
}//else session_cookies_dev();

if(count($callfunc)>0) ksort($callfunc);
foreach($callfunc as $k => $v){
    if(function_exists($v)){
        call_user_func($v);
    }
}
if(defined('D_'.D_PAGE))
	define('D_PAGE_PATH',constant('D_'.D_PAGE));
else{
	kesalahan();
    exit;
}

//if(count($_FILES)>0){file_put_contents(D_DATABASES_PATH.'debug.txt',D_VARIABLES);exit;}

if(defined('D_ACTION')&&D_ACTION=='int')
    if(int_variable()===false){
        kesalahan();
        exit;
    }

if(D_PAGE==='post'||D_PAGE==='media'){
    $fn=constant('D_'.D_DOMAIN).'config.php';
    if(file_exists($fn))
        require $fn;
    $fn=constant('D_'.D_DOMAIN).'functions.php';
    if(file_exists($fn))
        require $fn;
    if(D_PAGE==='post'){
        $var=json_decode(D_VARIABLES);
        define('D_POST_TITLE',$var[1]);
        define('D_POST_NUMBER',(int)$var[0]);
        unset($var);
        $fn=D_MODULE_PATH.'core/post/functions.php';
    }else{
        $var=json_decode(D_VARIABLES);
        define('D_MEDIA_FILE',$var[1]);
        unset($var);
        $fn=D_MODULE_PATH.'core/media/functions.php';
    }
    if(file_exists($fn))
        require $fn;
    if(D_PAGE==='post')
        if(!is_post_script(D_POST_NUMBER,D_POST_TITLE)){
			kesalahan();
    		exit;
        }
}else{
    $fn=D_APPLICATION_PATH.'config.php';
    if(file_exists($fn))
    	require $fn;
    $fn=D_APPLICATION_PATH.'functions.php';
    if(file_exists($fn))
        require $fn;
}

$header=D_PAGE_PATH.'/header.php';
if(file_exists($header)){
	$hdr=header_variable_list($header);
	if(function_exists('filter_page_by_user_level')){
		if(!filter_page_by_user_level($hdr)){
    	    kesalahan();
        	exit;
        }
	}
	if($hdr['status']==1){
        if(isset($_SESSION['menu_admin'])){
            $m=json_decode($_SESSION['menu_admin']);
            if(!(in_array(D_PAGE,$m)||$hdr['position']==2||D_PAGE=='bukupetunjuk'||$m[0]=='*')){
                if(D_PAGE==='login')
                    header('location: /dashboard');
				kesalahan();
    			exit;
            }
        }

		// position=0 jika sebelum login
		// position=1 jika sesudah login
		// position=2 jika sebelum atau sesudah login
		if($hdr['position']<2){
			if(!isset($_SESSION['position'])){
				if($hdr['position']>0){
					define('D_PLEASE_LOGIN',1);
					kesalahan();
			    	exit;
				}
			}elseif($hdr['position']!=$_SESSION['position']){
				if($hdr['position']==1)
					define('D_PLEASE_LOGIN',1);
				else
					define('D_PLEASE_LOGOUT',1);
				kesalahan();
    			exit;
			}
		}

        if(file_exists(D_THEME_PATH.$hdr['theme'].'/functions.php'))
        	require D_THEME_PATH.$hdr['theme'].'/functions.php';

		if(file_exists(D_THEME_PATH.$hdr['theme'].'/'.$hdr['subtheme'].'/functions.php'))
			require D_THEME_PATH.$hdr['theme'].'/'.$hdr['subtheme'].'/functions.php';

		if(count($_FILES)>0){
			if(file_exists(D_CORE_PATH.'/uploads.php')){
				require D_CORE_PATH.'/uploads.php';
			}else
				error_message('UPLOAD');
		}elseif(count($_POST)>0){
			if(file_exists(D_PAGE_PATH.'/post.php'))
				require D_PAGE_PATH.'/post.php';
			else
				error_message('POST');
		}elseif(defined('D_ACTION')){
			if(D_ACTION=='plugin')
				plugin_variable();
			else{
				if(file_exists(D_PAGE_PATH.'/'.D_ACTION.'.php')){

                    if(D_ACTION=='pdf'){
                        if(file_exists(D_PLUGIN_PATH.'fpdf/fpdf.php'))
                            require D_PLUGIN_PATH.'fpdf/fpdf.php';
                        require D_PAGE_PATH.'/'.D_ACTION.'.php';
                    }elseif(D_ACTION=='excel'){
                        $versi=explode('.',phpversion());$versi=(int)$versi[0];
                        if($versi>5){
                            if(file_exists(D_PLUGIN_PATH.'PHPOffice/write_excel.php'))
                                require D_PLUGIN_PATH.'PHPOffice/write_excel.php';
                        }else{
                            if(file_exists(D_PLUGIN_PATH.'PHPEXCEL_php.5.6/write_excel.php'))
                                require D_PLUGIN_PATH.'PHPEXCEL_php.5.6/write_excel.php';
                        }
                    }else
                        require D_PAGE_PATH.'/'.D_ACTION.'.php';

				}else
					error_message(strtoupper(D_ACTION));
			}
		}else{
		    if(function_exists('check_cross_server'))
		        check_cross_server();
			// header page
			if(function_exists('header_page'))
				header_page($hdr);

			// body page
			if(file_exists(D_PAGE_PATH.'/view.php'))
				require D_PAGE_PATH.'/view.php';
			else
				error_message('VIEW');

			// footer page
			if(function_exists('footer_page'))
				footer_page($hdr);
		}
	}else{
		kesalahan();
    	exit;
    }
}else{
	kesalahan();
   	exit;
}
//require __DIR__.'/autobackup.php';//*/
?>
