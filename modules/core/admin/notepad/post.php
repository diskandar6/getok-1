<?php
if(isset($_POST['catatan'])){$continue=false;
    $db=db_connection();
    if(isset($_POST['id']))
    $data=$db->update("notepad",array('title'=>$_POST['titel'],'content'=>$_POST['catatan']),array('id'=>(int)$_POST['id']),array('%s','%s'),array('%d'));
    else
    $data=$db->insert("notepad",array('title'=>$_POST['titel'],'content'=>$_POST['catatan'],'id_admin'=>$_SESSION['id']),array('%s','%s','%d'));
    echo 'ok';
}
?>