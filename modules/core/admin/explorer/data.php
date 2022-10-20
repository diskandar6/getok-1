<?php
$fix='abc';
if(isset($_GET['sfile'])){$continue=false;
    require D_CORE_PATH.'explorer.php';
    echo search_file($_GET['sfile'],$fix,$_GET['root']);
}elseif(isset($_GET['stext'])){$continue=false;
    require D_CORE_PATH.'explorer.php';
    echo search_text($_GET['stext'],$fix,$_GET['root']);
}else{$continue=false;
	if(!isset($_SESSION[$fix.'path_explorer'])){
		if($_SESSION['id']==0)
            $_SESSION[$fix.'path_explorer']=D_MAIN_PATH;
        else
            $_SESSION[$fix.'path_explorer']=D_MODULE_PATH.$_SESSION['applikasi'].'/';
	}
	require D_CORE_PATH.'explorer.php';
    
	$dir=dirname(dirname(__FILE__));
	/*set_ext_explorer($dir,array("js","php","html","htm","css","meta","txt","log","csv","svg"));
	set_value_explorer($dir,array());
	set_hide_ext_explorer($dir,array());
	set_hide_file_explorer($dir,array());
	set_hide_dir_explorer($dir,array());//*/
        
	load_config_explorer($dir);
        
	data_explorer($fix);
}
?>