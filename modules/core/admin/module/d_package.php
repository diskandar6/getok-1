<?php
if(isset($_GET['bl_package'])){$continue=false;
    if(defined('D_'.$_GET['bl_package'])){
    	$apl=constant('D_'.$_GET['bl_package']);
    	$res=array();
    	$bdl=bundle_list($apl);
    	foreach($bdl as $k => $v)
    		array_push($res,array('text'=>$v,'value'=>$v));
    	echo json_encode($res);
    }else echo '[]';	
}elseif(isset($_GET['uinstall_package'])){$continue=false;
    require D_CORE_PATH.'package.php';
    uninstall_package($_GET['dst_apl'],$_GET['uinstall_package'],(int)$_GET['all_data'],$_GET['bl_pkg']);
    echo 'ok';
}elseif(isset($_GET['install_package'])){$continue=false;
    require D_CORE_PATH.'package.php';
    install_package($_GET['dst_apl'],$_GET['install_package'],$_GET['db_sel_pkg'],$_GET['bl_pkg']);
    echo 'ok';
}elseif(isset($_GET['tb_package'])){$continue=false;
    $db=db_connection($_GET['tb_package']);
    $table=$db->get_results("SHOW TABLES",ARRAY_N);
    $res=array();
    foreach($table as $k => $v)array_push($res,array('text'=>$v[0],'value'=>$v[0]));
    echo json_encode($res);
}elseif(isset($_GET['db_package'])){$continue=false;
    $dbs=database_list(constant('D_'.$_GET['db_package']).'db.php');
    $res=array();
    foreach($dbs as $k => $v)array_push($res,array('text'=>$k,'value'=>$v));
    echo json_encode($res);
}elseif(isset($_GET['modul_package'])){$continue=false;
    $mod=module_list($_GET['modul_package']);
    $res=array();
    foreach($mod as $k => $v)array_push($res,array('text'=>$k,'value'=>$k));
    echo json_encode($res);
}elseif(isset($_GET['package'])){$continue=false;
    $pg=array();
    if(defined('D_'.$_GET['package'])){
        $pkg=constant('D_'.$_GET['package']).'packages.php';
        $pg=array();
        if(file_exists($pkg)){
            $pg=file_get_contents($pkg);
            if($pg!=''){
                $pg=json_decode($pg,true);
                if(is_array($pg)){
                    $pgs=array_keys($pg);
                }
            }
        }
    }
    $package=scandir(D_PACKAGE_PATH);
    $res=array();
    foreach($package as $k => $v)if($v!='.'&&$v!='..'&&$v!='old'){
        $table=array();
        if(file_exists(D_PACKAGE_PATH.$v.'/config.json')){
            $table=file_get_contents(D_PACKAGE_PATH.$v.'/config.json');
            $table=json_decode($table,true);
            $table=array_keys($table);
            $table=implode(',',$table);
        }
        if(in_array($v,$pgs))
            $btn='<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-confirm" onclick="select_package(\''.$v.'\',\''.$pg[$v].'\')">UnInstall</button><br>';
        else
            $btn='<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-select-db-package" onclick="select_package(\''.$v.'\')">Install</button>';
        if(is_dir(D_PACKAGE_PATH.$v))array_push($res,array($v,$table,$btn));
    }
    echo json_encode($res);
}
?>