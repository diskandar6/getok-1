<?php
function compile_package($apl,$mod){
    $dir=D_PACKAGE_PATH;
    if(!file_exists($dir))mkdir($dir,0755);
    $src=module_list($apl);
    $src=$src[$mod];
    if(file_exists($dir.$mod)){
        //rename($dir.$mod,$dir.$mod.date('-YmdHis'));
        if(!file_exists($dir.'old'))mkdir($dir.'old',0755);
        copy_folder($dir.$mod,$dir.'old/'.$mod.date('-YmdHis'));
    }
    copy_folder($src,$dir.$mod);
}
function add_table_to_package_($mod,$dbname,$full=false){
    $res=array();
    $dir=D_PACKAGE_PATH.$mod.'/config.json';
    foreach($dbname as $k => $v){
        foreach($v as $k1 => $v1){
            $db=$GLOBALS[$k1];
            $str=$db->get_row("SHOW CREATE TABLE ".$v1,ARRAY_N);
            $res[$str[0]]['create']=$str[1];
        }
    }
    $res=json_encode($res);
    file_put_contents($dir,$res);
}
function add_table_to_package($mod,$dbname,$table,$full=false){
    $db=db_connection($dbname);
    $str=$db->get_row("SHOW CREATE TABLE ".$table,ARRAY_N);
    //file_put_contents(D_PACKAGE_PATH.$mod.'/'.$table,$str[1]);
    $dir=D_PACKAGE_PATH.$mod.'/config.json';
    if(file_exists($dir)){
        $res=file_get_contents($dir);
    echo '<pre>';print_r($dir);echo '</pre>';
        $res=json_decode($res,true);
    }else //*/
    $res=array();
    $res[$table]['create']=$str[1];
    $res=json_encode($res);
    file_put_contents($dir,$res);
}
function install_package($aplikasi,$module,$db,$bundle='uncategory'){
    //  copy script
    $dst=constant('D_'.$aplikasi).$bundle.'/';
    if(!file_exists($dst))mkdir($dst,0755);
    $dst.=$module.'/';
    if(!file_exists($dst))mkdir($dst,0755);
    $src=D_PACKAGE_PATH.$module;
    copy_folder($src,$dst);

    //  setup variable
    require constant('D_'.$aplikasi).'db.php';
    foreach($var as $k => $v)if($v==$db)$dbl=$k;
    $ffun=$dst.'variable.php';
    $fun=file_get_contents($ffun);
    $fun=explode(chr(10),$fun);
    $var=json_decode(str_replace("'",'"',$fun[2]),true);
    $fun='<?php'.chr(10).'/*'.chr(10).$fun[2].chr(10).'*/'.chr(10);
    if(is_array($var))
    foreach($var as $k => $v)
        $fun.='if(isset($'.$dbl.'))$'.$v.'=$'.$dbl.';'.chr(10);
    $fun.='?>';
    file_put_contents($ffun,$fun);
    
    //  registrasi modul dan menu
    add_module($aplikasi,$bundle,$module);
    if(file_exists($dst.'header.php'))
    require $dst.'header.php';
    if($var['position']==1) reset_menu();
    
    //  install tabel
    $dbase=$dst.'config.json';
    if(file_exists($dbase))
    $dbase=file_get_contents($dbase);
    $dbase=json_decode($dbase);
    $dbl=db_connection($db);
    if(is_array($dbase)||is_object($dbase))
    foreach($dbase as $k => $v){
        $tbl=get_table_list($dbl);
        if(!in_array($k,$tbl)){
            $dbl->query($v->create);
        }
    }
    
    //  registrai package
    $pkg=constant('D_'.$aplikasi).'packages.php';
    if(file_exists($pkg))
        $pg=file_get_contents($pkg);
    else $pg='';
    if($pg=='')$pg=array();else $pg=json_decode($pg,true);
    if(!in_array($module,$pg)){
        $pg[$module]=$bundle;
        file_put_contents($pkg,json_encode($pg));
    }
    
    //  RUN after install
    $fun=$dst.'run_once.php';
    if(file_exists($fun))
        require $fun;//*/
}
function uninstall_package($aplikasi,$module,$delete_all=0,$bundle='uncategory'){
    $dst=constant('D_'.$aplikasi).$bundle.'/';

    //  delete tabel
    if($delete_all>0){
        $tbl=$dst.$module.'/config.json';
        if(file_exists($tbl)){
            $tbl=file_get_contents($tbl);
            $tbl=json_decode($tbl,true);
            $tbl=array_keys($tbl);
        }
        
        $v=$dst.$module.'/variable.php';
        if(file_exists($v)){
            $v=file_get_contents($v);
            $v=explode(chr(10),$v);
            $v=explode('=',$v[4]);
            if(isset($v[1]))
            $v=str_replace(';','',str_replace('$','',$v[1]));
            
            require constant('D_'.$aplikasi).'db.php';
            if(isset($var[$v])){
                $dbl=db_connection($var[$v]);
                foreach($tbl as $k => $v)
                    $dbl->query("DROP TABLE $v;");
            }
        }
    }

    //  delete registrasi package
    $pkg=constant('D_'.$aplikasi).'packages.php';
    $pg=file_get_contents($pkg);
    if($pg=='')$pg=array();else $pg=json_decode($pg,true);
    if(isset($pg[$module])){
        unset($pg[$module]);
        file_put_contents($pkg,json_encode($pg));
    }

    //  delete module & unreg
    remove_module($aplikasi,$bundle,$module);
}
?>