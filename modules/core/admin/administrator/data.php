<?php
if(isset($_GET['editadmin'])){$continue=false;
    $db=db_connection();
    $id=(int)$_GET['editadmin'];
    $data=$db->get_row("SELECT username,application FROM administrator WHERE id=$id");
    echo json_encode($data);
}elseif(isset($_GET['adminlist'])){$continue=false;
    $data=admin_list();
    $res=array();
    $status=array('Not Active','Active');
    foreach($data as $k => $v){
        $edit='<span class="badge badge-success" onclick="edit_admin('.$v->id.')"><i class="fa fa-edit"></i></span> ';
        $st='fas fa-user-alt'; if($v->status<1) $st='fas fa-user-alt-slash';
        $edit.='<span class="badge badge-warning" onclick="status_admin('.$v->id.')"><i class="'.$st.'"></i></span> ';
        $edit.='<span class="badge badge-danger" onclick="delete_admin('.$v->id.')"><i class="fa fa-trash"></i></span> ';
        array_push($res,array($v->username,$v->application,$status[$v->status],$edit));
    }
    echo json_encode($res);
}
?>