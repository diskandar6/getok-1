<?php
if(!defined('D_OPTIONS'))require __DIR__.'/functions.php';
$data=option_list();
$res=array();
$admins=admin_list();
$admin=array('0'=>'Superadmin');
foreach($admins as $k => $v)$admin[$v->id]=$v->username;
foreach($data as $k => $v){
    $his=json_decode($v->history);
    $h='<pre>';
    foreach($his as $k1 => $v1)foreach($v1 as $k2 => $v2){
        $h.=$k2.': ';
        if($v2->user<0)
            $h.=$admin[-$v2->user].' -> '.$v2->date;
        elseif($v2->user==0)
            $h.=$admin[$v2->user].' -> '.$v2->date;
        else
            $h.=$v2->user.' -> '.$v2->date;
        $h.=chr(10);
    }
    $h.='</pre>';
    $vv='<div class="d-flex"><input type="text" class="form-control" id="opt-'.$v->id.'" value="'.$v->value.'"><button class="btn btn-primary btn-sm" onclick="change_option(\''.$v->name.'\',$(\'#opt-'.$v->id.'\').val())">Save</button></div>';
    array_push($res,array($v->id,$v->name,$vv,$h));
}
echo json_encode($res);
?>