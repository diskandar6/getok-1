<?php
if(isset($_POST['statusadmin'])){$continue=false;
    $db=db_connection();
    $id=(int)$_POST['statusadmin'];
    $data=$db->query("UPDATE `administrator` SET `status`=(`status`+1)%2 WHERE id=$id");
    echo 'ok';
}elseif(isset($_POST['deleteadmin'])){$continue=false;
    $db=db_connection();
    $id=(int)$_POST['deleteadmin'];
    $db->delete('administrator',array('id'=>$id),array('%d'));
    echo 'ok';
}elseif(isset($_POST['adminname'])){$continue=false;
    $db=db_connection();
    if(isset($_POST['idadmin'])){
        $id=(int)$_POST['idadmin'];
        $edit=array('username'=>$_POST['adminname'], 'password'=>md5($_POST['adminpass']), 'application'=>$_POST['adminapl']);
        $frm=array('%s','%s','%s');
        if($_POST['adminpass']==''){
            unset($edit['password']);
            $frm=array('%s','%s');
        }
        $data=$db->update('administrator',
            $edit, array('id'=>$id), $frm,array('%d'));
    }else
    $data=$db->insert('administrator',
        array('username'=>$_POST['adminname'],
        'password'=>md5($_POST['adminpass']),
        'application'=>$_POST['adminapl'],'status'=>1),
        array('%s','%s','%s','%d'));
    echo 'ok';
}
?>