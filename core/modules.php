<?php
require __DIR__.'/database.php';
require __DIR__.'/zip_operator.php';
$constant=array('UPLOADS_PATH','THEME_PATH','PLUGIN_PATH','MODULE_PATH','CORE_PATH','ASSETS_PATH',
    'MAIN_PATH',// harus terakhir

    'HTML','NOTEPAD','PEGAWAI_PATH',
    'DATAFILE'//harus terakhir
);define('CHECKCONSTAN',json_encode($constant));

function read_registry($path){
	if(file_exists($path)){
		$r=array();
		$t=explode('define(',file_get_contents($path));
		foreach($t as $k => $v)if($k>0){
			$df=explode(');',$v,2);
			$df=explode(',',$df[0],2);
			$df[0]=explode('D_',$df[0]);
			$df[0]=str_replace("'",'',$df[0][1]);
			eval('$e='.substr($df[1],0,strlen($df[1])).';');
			$r[$df[0]]=$e;
		}
		return $r;
	}else return array();
}
function write_registries($path,$reg){
	$res ='<?php'.chr(10);
	$const=json_decode(CHECKCONSTAN,true);
	foreach($reg as $k => $v)
        if($k!=''){
            $ada=false;
            foreach($const as $k1 => $v1){
                $a='D_'.$v1;
                if(defined($a)){
                    $c=constant($a);
                    if(strpos($v,$c)!==false&&$ada==false){
                        $res.='define(\'D_'.$k.'\','.str_replace($c,$a.'.\'',$v).'\');'.chr(10);
                        $ada=true;
                    }
                }
            }
            if(!$ada)
                $res.='define(\'D_'.$k.'\',\''.$v.'\');'.chr(10);
		}
	$res.='?>';
	file_put_contents($path,$res);
}
function write_registry($path,$key,$value){
	$reg=read_registry($path);
	$reg[$key]=$value;
	write_registries($path,$reg);
}
function remove_registry($path,$key){
	$reg=read_registry($path);
	unset($reg[$key]);
	write_registries($path,$reg);
}
function replace_registry($path,$key,$new_key,$new_value){
	$reg=read_registry($path);
	unset($reg[$key]);
	$reg[$new_key]=$new_value;
	write_registries($path,$reg);
}
function rename_application($from,$to){
    if($from!=$to){
        $fn1=D_MODULE_PATH.$from.'/';
        if(file_exists($fn1)){
            $fn2=D_MODULE_PATH.$to.'/';
            if(!file_exists($fn2)){
                rename($fn1,$fn2);
                replace_registry(D_REGISTRYPATH,$from,$to,$fn2);
            	$fn2.='registry.php';
            	if(file_exists($fn2)){
                	$r=file_get_contents($fn2);
                	$r=str_replace('D_MODULE_PATH.\''.$from,'D_MODULE_PATH.\''.$to,$r);
                	file_put_contents($fn2,$r);
                }
            }
        }
    }
}
function add_application($nama){
	$fn=D_MODULE_PATH.$nama.'/';
	if(!file_exists($fn))
		mkdir($fn,0755);
	if(file_exists($fn))
		write_registry(D_REGISTRYPATH,$nama,$fn);
}
function remove_application($nama){
	$reg=application_list();
	delete_and_backup($reg[$nama]);
	remove_registry(D_REGISTRYPATH,$nama);
}
function application_list(){
	return read_registry(D_REGISTRYPATH);
}
function add_config($aplikasi,$key,$nilai){
	write_registry(constant('D_'.$aplikasi).'config.php',$key,$nilai);
}
function remove_config($aplikasi,$key){
	remove_registry(constant('D_'.$aplikasi).'config.php',$key);
}
function config_list($aplikasi){
	return read_registry(constant('D_'.$aplikasi).'config.php');
}
function add_module($aplikasi,$grup,$nama){
	$reg=application_list();
	$reg1=$reg[$aplikasi];
	if(!file_exists($reg1))
		add_application($aplikasi);
	if($grup!=''){
		$reg1.=$grup;
		if(!file_exists($reg1))
			mkdir($reg1,0755);
	}
	$reg1.='/'.$nama.'/';
	if(!file_exists($reg1))
		mkdir($reg1,0755);
	write_registry($reg[$aplikasi].'registry.php',$nama,$reg1);
}
function module_list($aplikasi){
	if(defined('D_'.$aplikasi)){
		return read_registry(constant('D_'.$aplikasi).'registry.php');
	}else{
		$reg=application_list();
		return read_registry($reg[$aplikasi].'registry.php');
	}
}
function remove_module($aplikasi,$grup,$nama){
	$dst=constant('D_'.$aplikasi);
	if(file_exists($dst.$grup.'/'.$nama.'/header.php')){
        require $dst.$grup.'/'.$nama.'/header.php';
    	delete_and_backup($dst.$grup.'/'.$nama);
    	remove_registry($dst.'registry.php',$nama);
        if($var['position']==1) reset_menu();
	}
}
//*
//add_module('dev.d','tes1','module1');/*/
//remove_module('tes1','module1');//*/
function get_registry_application(){
	if(D_PAGE=='media'){
		define('D_APPLICATION_PATH',D_MODULE_PATH.'core/');
		define('D_'.D_PAGE,D_APPLICATION_PATH.'media');
	}elseif(D_PAGE=='post'){
		define('D_APPLICATION_PATH',D_MODULE_PATH.'core/');
		define('D_'.D_PAGE,D_APPLICATION_PATH.'post');
	}elseif(D_PAGE=='develop'){
	    if((int)$_SESSION['id']<=0){
			define('D_APPLICATION_PATH',D_MODULE_PATH.'core/');
			define('D_'.D_PAGE,D_APPLICATION_PATH.'admin');
			//echo D_APPLICATION_PATH;
        }else{
            kesalahan();
            exit;
        }
	}else{
		$isallow=false;
		if(D_PAGE==='login'){
			$reg=module_list(D_DOMAIN);
			if(!isset($reg['login'])){
				define('D_APPLICATION_PATH',D_MODULE_PATH.'core/');
				define('D_'.D_PAGE,D_APPLICATION_PATH.D_PAGE);
				$isallow=true;
			}
		}
		if(!$isallow){
			$reg=application_list();
			define('D_APPLICATION_PATH',$reg[D_DOMAIN]);
			if(D_PAGE==='bukupetunjuk'){
			    define('D_'.D_PAGE,D_APPLICATION_PATH.D_PAGE);
			}else{
    			if(file_exists(D_APPLICATION_PATH.'registry.php'))
	    			require D_APPLICATION_PATH.'registry.php';
			}
		}
	}
}

function add_header_variable($path,$variable,$nilai){
	add_database($path,$variable,$nilai);
}
function remove_header_variable($path,$variable){
	remove_database($path,$variable);
}
function header_variable_list($path){
	return database_list($path);
}

function add_bundle($path,$nama){
	$bundle=bundle_list($path);
	if(!in_array($nama,$bundle)){
		array_push($bundle,$nama);
		$bundle='<?php'.chr(10).'$bundle='.array_to_string($bundle).chr(10).'?>';
		mkdir($path.$nama,0755);
		file_put_contents($path.'bundle.php',$bundle);
    }
}
function bundle_list($path){
	if(file_exists($path.'bundle.php'))
		require $path.'bundle.php';
	else
		$bundle=array();
	return $bundle;
}
function reset_menu(){
	$reg=application_list();
	foreach($reg as $k => $v){
		$res=array();
		$bdl=bundle_list($v);
		if(!in_array('uncategory',$bdl))array_push($bdl,'uncategory');
		$menu=menu_list($v);
		foreach($bdl as $k1 => $v_){
			$v1=$v_;
			if(file_exists($v.$v1)){
    			$mdl=scandir($v.$v1);
    			foreach($mdl as $k2 => $v2)if($v2!='.'&&$v2!='..'){
    				if(is_dir($v.$v1.'/'.$v2)){
    					$hdr=header_variable_list($v.$v1.'/'.$v2.'/header.php');
    					if(isset($hdr['subtheme'])){
        					if($hdr['subtheme']=='admin'){
        						if(strlen($hdr['parent_menu'])>1){
        							$keyp=str_replace(' ','',$hdr['parent_menu']);
        							if(!isset($res[$keyp])){
                                        $mn='';
                                        if(isset($menu[str_replace(' ','',$hdr['parent_menu'])]))
                                            $mn=$menu[str_replace(' ','',$hdr['parent_menu'])][1];
        								$res=array_merge($res,array($keyp=>array('parent_menu'=>$hdr['parent_menu'],'parent_menu_icon'=>$mn)));
        							}
        							if(!isset($res[$keyp]['group']))$res[$keyp]['group']=array();
        							//echo $hdr['menu_title'].' '.$keyp.'<br>';
        							array_push($res[$keyp]['group'],array('menu_title'=>$hdr['menu_title'],'menu_icon'=>$hdr['menu_icon'],'name'=>$v2));
        						}else{
        							array_push($res,array('menu_title'=>$hdr['menu_title'],'menu_icon'=>$hdr['menu_icon'],'name'=>$v2));
        						}
        					}
    					}
    				}
    			}
			}
		}
		$res='<?php'.chr(10).'$menu2='.array_to_string($res).chr(10).'?>';
		file_put_contents($v.'menu2.php',$res);
	}
}
function add_menu($path,$nama,$icon){
	$parentmenu=menu_list($path);
	$parentmenu[str_replace(' ','',$nama)]=array($nama,$icon);
	$parentmenu='<?php'.chr(10).'$parentmenu='.array_to_string($parentmenu).chr(10).'?>';
	file_put_contents($path.'parentmenu.php',$parentmenu);
}
function menu_list($path){
	if(file_exists($path.'parentmenu.php'))
		require $path.'parentmenu.php';
	else
		$parentmenu=array();
	return $parentmenu;
}
?>