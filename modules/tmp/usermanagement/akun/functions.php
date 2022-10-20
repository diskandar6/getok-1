<?php
if(!defined('D_AKUN')){define('D_AKUN',true);
require __DIR__.'/variable.php';

addhook(1,'check_notif');

function check_notif(){
    if(!isset($_SESSION['id']))return false;
    if($_SESSION['id']<=0)return false;
    $db=$GLOBALS['dbakun'];
    $id=(int)$_SESSION['id'];
    $tb='web_users';
    $ada=$db->get_row("SELECT COUNT(*) AS jml,id_notif FROM $tb WHERE id=$id AND id_notif IS NOT NULL");
    if((int)$ada->jml>0){
        $data=explode(',',$ada->id_notif);
        if((int)$data[0]==0)return false;
        $func=$db->get_row("SELECT func FROM main_notif WHERE id=".(int)$data[0]);
        $_SESSION['notif']=(int)$data[0];
        if(function_exists($func->func))
            call_user_func($func->func);
    }
    return false;
}
function unset_notif(){
    if(!isset($_SESSION['id']))return false;
    if($_SESSION['id']<=0)return false;
    $db=$GLOBALS['dbakun'];
    $id=(int)$_SESSION['id'];
    if(isset($_SESSION['mahasiswa']))$tb='main_akunmahasiswa';else $tb='web_users';
    $ada=$db->get_row("SELECT COUNT(*) AS jml,id_notif FROM $tb WHERE id=$id AND id_notif IS NOT NULL");
    if($ada->jml>0){
        $idnotif=$_SESSION['notif'];
        $data=explode(',',$ada->id_notif);
        $notif=array();
        foreach($data as $k => $v)if($idnotif!=$v)$notif[]=$v;
        $notif=implode(',',$notif);
        $db->update($tb,array('id_notif'=>$notif),array('id'=>$id),array('%s'),array('%d'));
    }
    return false;
}
function notif_updatemenuadmin(){
    if(!isset($_SESSION['id']))return false;
    if($_SESSION['id']<=0)return false;
    $db=$GLOBALS['dbakun'];
    $id=(int)$_SESSION['id'];
    if(isset($_SESSION['mahasiswa']))$tb='main_akunmahasiswa';else $tb='web_users';
    $data=$db->get_row("SELECT level FROM $tb WHERE id=$id");
    $_SESSION['menu_admin']=$data->level;
    unset_notif();
}
function change_menu_admin($iduser,$tb){
    $db=$GLOBALS['dbakun'];
    $ada=$db->get_row("SELECT COUNT(*) AS jml,id_notif FROM $tb WHERE id=$iduser AND id_notif IS NOT NULL");
    $data=array();
    if($ada->jml>0){
        $data=explode(',',$ada->id_notif);
    }
    if(!in_array('1',$data))$data[]=1;
    foreach($data as $k =>$v)if($data[$k]=='')unset($data[$k]);
    $data=array_values($data);
    $data=implode(',',$data);
    $db->update($tb,array('id_notif'=>$data),array('id'=>$iduser),array('%s'),array('%d'));
}
function user_lists_for_select(){
    $db=$GLOBALS['dbakun'];
    $data=$db->get_results("SELECT id,nama FROM web_users WHERE status>0");
    $res='';
    foreach($data as $k => $v)
        $res.='<option value="'.$v->id.'">'.$v->nama.'</option>';
    return $res;
}
function user_list_array(){
    $db=$GLOBALS['dbakun'];
    $data=$db->get_results("SELECT id,nama FROM web_users WHERE status>0");
    $res=array();
    foreach($data as $k => $v)
        $res[$v->id]=$v->nama;
    return $res;
}
}?>