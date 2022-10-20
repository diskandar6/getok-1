<?php
define('D_OPTIONS',true);
require __DIR__.'/variable.php';

function option_list(){
    global $dboption;
    $data=$dboption->get_results("SELECT * FROM options ORDER by id DESC");
    return $data;
}
function get_option($name,$default='',$all=false){
    $data=option_list();
    foreach($data as $k => $v)
        if($name==$v->name){
            if(!$all)
                return $v->value;
            else
                return $v;
        }
    if($default=='')
        return false;
    else
        return $default;
}
function set_option($name,$value){
    global $dboption;
    $res=get_option($name,'',true);
    if($res!==false){
        $history=modify_hist($res->history,$_SESSION['id'],'Change Option');
        $dboption->update('options',array('value'=>$value,'history'=>$history),array('id'=>$res->id),array('%s','%s'),array('%d'));
    }else{
        $id=0;
        if(isset($_SESSION['id']))$id=$_SESSION['id'];
        $dboption->insert('options',
            array(
                'name'=>$name,
                'value'=>$value,
                'history'=>create_hist($id,'Create Option')),
            array('%s','%s','%s'));
    }
    return true;//*/
}
function change_name_option($oname,$nname){
    global $dboption;
    $res=get_option($oname,'',true);
    if($res!==false){
        $history=json_decode($res->history,true);
        array_push($history,array('change'=>array('date',date('Y-m-d H:i'),'user'=>$_SESSION['id'])));
        $history=json_encode($history);
        $dboption->update('options',array('name'=>$nname,'history'=>$history),array('id'=>$res->id),array('%s','%s'),array('%d'));
    }
}

$gcd=get_option('google Client ID','');
if($gcd=='')set_option('google Client ID','-');
define('D_GOOGLE_SIGN_CODE',$gcd);

$igs=get_option('integrated google sign','');
if($igs=='')set_option('integrated google sign','false');
?>