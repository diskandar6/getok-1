<?php
require __DIR__.'/variable.php';
if(!defined('RUN_ENCRYPTION')) require D_PLUGIN_PATH.'encryption/functions.php';

function decrypt_code_forgot($code,&$id,&$email,&$tgl){
    $cd=explode('-',$code);
    $id=(int)$cd[2];
    $email=decr($cd[1]);
    $tgl=decr($cd[0]);
}
function is_expire_code_change_password($tgl,$max=2/*hours*/){
    $tgl=str_replace('a','',$tgl);
    $year=substr($tgl,0,4);
    $mn=substr($tgl,4,2);
    $dy=substr($tgl,6,2);
    $hr=substr($tgl,8,2);
    $mt=substr($tgl,10,2);
    $sc=substr($tgl,12,2);
    $tgl=$year.'-'.$mn.'-'.$dy.' '.$hr.':'.$mt.':'.$sc;
    $tgl=strtotime($tgl);
    $now=strtotime('now');
    return ($tgl+($max*3600)<$now);
}
function valid_code_change_password(){
    global $dbforgotpassword;
    $code=$_GET['change'];
    decrypt_code_forgot($code,$id,$email,$tgl);
    if(!is_expire_code_change_password($tgl)){
        $ada=$dbforgotpassword->get_row("SELECT email FROM web_users WHERE id=$id");
        if(str_replace('@','',str_replace('.','',$ada->email))==$email){
            return true;
        }
    }
    return false;
}
?>