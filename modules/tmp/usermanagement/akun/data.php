<?php
if(isset($_GET['menu'])){
    $id=(int)$_GET['menu'];
    $tb='web_users';
    $data=$dbakun->get_row("SELECT level FROM $tb WHERE id=$id");
    echo $data->level;
}elseif(isset($_GET['id'])){
    $id=(int)$_GET['id'];
    $tb='web_users';
    $data=$dbakun->get_row("SELECT username,email,nama FROM $tb WHERE id=$id");
    echo json_encode($data);
}else{
    $tb='web_users';
    $data=$dbakun->get_results("SELECT * FROM $tb ORDER BY id ASC");
    $res=array();
    foreach($data as $k => $v){
        $im='/assets/img/Deafult-Profile-sx.png';
        if($v->image!='')$im=$v->image;
        $img='<img src="'.$im.'" class="rounded-circle" style="width:150px;float:left">';
        $level=implode('<br>',json_decode($v->level,true));
        $stat='';
        if(!$v->status)$stat='-slash';
        $edit='<span class="badge badge-info" title="Edit" onclick="edit_akun('.$v->id.')"><i class="fa fa-edit"></i></span>';
        $edit.=' <span class="badge badge-warning" title="Menu" onclick="menu_akun('.$v->id.')"><i class="fas fa-bars"></i></span>';
        $edit.=' <span class="badge badge-danger" title="Status" onclick="status_akun('.$v->id.')"><i class="fa fa-eye'.$stat.'"></i></span>';
        $info='<span class="D_R">'.json_encode(array($v->nama,$v->username,$v->email,$v->image)).'</span>';
        array_push($res,array($v->id,$info,$level,$edit));
    }
    echo json_encode($res);
}
?>