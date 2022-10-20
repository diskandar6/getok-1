<?php
if(isset($_POST['pkg_apl'])){$continue=false;
    require D_CORE_PATH.'package.php';
    compile_package($_POST['pkg_apl'],$_POST['pkg_module']);
    add_table_to_package_($_POST['pkg_module'],$_POST['pkg_db']);
    echo 'ok';
}elseif(isset($_POST['rename_appl'])){$continue=false;
    $from=$_POST['current_appl'];
    $to=$_POST['rename_appl'];
    rename_application($from,$to);
    echo 'ok';
}elseif(isset($_POST['edit_module'])){$continue=false;
    $dir=D_MODULE_PATH.$_POST['edit_module_apl'].'/';
    require $dir.'registry.php';
    $dir=constant('D_'.$_POST['edit_module']).'header.php';
    add_database($dir,$_POST['key_module'],$_POST['value']);
    echo 'ok';
}elseif(isset($_POST['debug'])){$continue=false;
    if(!isset($_SESSION['debug']))
        $_SESSION['debug']=true;
    else
        $_SESSION['debug']=!$_SESSION['debug'];
    echo 'ok';
}elseif(isset($_POST['constant'])){$continue=false;
    $fn=D_MODULE_PATH.'core/constant.php';
    if(file_exists($fn))
        $constant=json_decode(file_get_contents($fn),true);
    else
        $constant=array();
    array_push($constant,array($_POST['constant'],$_POST['value']));
    file_put_contents($fn,json_encode($constant));
    echo 'ok';
}elseif(isset($_POST['newconfig'])){$continue=false;
	add_config($_POST['newconfig'],addslashes($_POST['key']),addslashes($_POST['value']));
	echo 'ok';
}elseif(isset($_POST['newbundle'])){$continue=false;
	add_bundle(constant('D_'.$_POST['newbundle']),$_POST['nama']);
	echo 'ok';
}elseif(isset($_POST['newmenu'])){$continue=false;
	add_menu(constant('D_'.$_POST['newmenu']),$_POST['nama'],$_POST['icon']);
	echo 'ok';
}elseif(isset($_POST['newaplikasi'])){$continue=false;
	add_application($_POST['newaplikasi']);
	echo 'ok';
}elseif(isset($_POST['newmodule'])){$continue=false;
	$reg=constant('D_'.$_POST['newmodule']);
	if(file_exists($reg.'registry.php'))
		require $reg.'registry.php';
	$reg.=$_POST['grup'].'/'.$_POST['nama'];
	add_module($_POST['newmodule'],$_POST['grup'],$_POST['nama']);
	add_header_variable($reg.'/header.php','theme',$_POST['theme']);
	add_header_variable($reg.'/header.php','status',$_POST['status']);
	add_header_variable($reg.'/header.php','skin',$_POST['skin']);
	add_header_variable($reg.'/header.php','subtheme',$_POST['template']);
	add_header_variable($reg.'/header.php','position',$_POST['posisi']);
	add_header_variable($reg.'/header.php','browser_title',$_POST['titel']);
	add_header_variable($reg.'/header.php','menu_title',$_POST['menu']);
	add_header_variable($reg.'/header.php','menu_icon',$_POST['icon']);
	add_header_variable($reg.'/header.php','level',$_POST['level']);
	if(isset($_POST['parent'])){
		if($_POST['parent']!='')
			add_header_variable($reg.'/header.php','parent_menu',$_POST['parent']);
		else
			add_header_variable($reg.'/header.php','parent_menu','-');
	}else
		add_header_variable($reg.'/header.php','parent_menu','-');

	if(!defined('D_'.$_POST['nama'])){
    	if($_POST['nama']=='login'){
    		$pt=D_MODULE_PATH.'core/login/';
    		copy_folder($pt.'css',$reg.'/css');
    	}else
    		$pt=D_THEME_PATH.$_POST['theme'].'/'.$_POST['template'].'/';

        $const='D_'.strtoupper($_POST['nama']);

    	if(!file_exists($reg.'/view.php')){
    	    if(!file_exists($pt.'view.php'))$isi='';else
    		$isi=file_get_contents($pt.'view.php');
    		file_put_contents($reg.'/view.php',$isi);
    	}
    	if(!file_exists($reg.'/data.php')){
    	    if(!file_exists($pt.'data.php'))$isi='';else
    		$isi=file_get_contents($pt.'data.php');
    		file_put_contents($reg.'/data.php',$isi);
    	}
    	if(!file_exists($reg.'/post.php')){
    	    if(!file_exists($pt.'post.php'))$isi='';else
    		$isi=file_get_contents($pt.'post.php');
    		file_put_contents($reg.'/post.php',$isi);
    	}
    	if(!file_exists($reg.'/variable.php')){
    	    $a=str_replace('-','',$_POST['nama']);
    		$isi='<?php'.chr(10).'/*'.chr(10).'["db'.$a.'"]'.chr(10).'*/'.chr(10).'if(isset($uab))$db'.$a.'=$uab;'.chr(10).'?>';
    		file_put_contents($reg.'/variable.php',$isi);
    	}
    	if(!file_exists($reg.'/functions.php')){
    		$isi='<?php'.chr(10).'if(!defined(\''.$const.'\')){define(\''.$const.'\',true);'.chr(10).'require __DIR__.\'/variable.php\';'.chr(10).'}?>';
    		file_put_contents($reg.'/functions.php',$isi);
    	}
	}
	echo 'ok';
}
?>