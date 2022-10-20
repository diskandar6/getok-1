<?php
    $fix='abc';
	if(!isset($_SESSION[$fix.'path_explorer'])){
		if($_SESSION['id']==0)
            $_SESSION[$fix.'path_explorer']=D_MAIN_PATH;
        else
            $_SESSION[$fix.'path_explorer']=D_MODULE_PATH.$_SESSION['applikasi'].'/';
	}
	require D_CORE_PATH.'explorer.php';
	load_config_explorer(dirname(__DIR__));
	post_explorer($fix);
?>