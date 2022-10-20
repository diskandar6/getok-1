<?php
if(isset($_GET['catatan'])){$continue=false;
    $db=db_connection();
    if($_GET['catatan']=='-'){
        $data=$db->get_results("SELECT id,title FROM notepad WHERE id_admin=$_SESSION[id]");
        $res=array();
        foreach($data as $k => $v){
            $bt='<span class="badge badge-success badge-sm float-right" data-toggle="modal" data-target="#modal-new-notepad" onclick="edit_notepad('.$v->id.')"><i class="fas fa-edit fa-2x"></i></span><hr><pre style="display:none" id="view-'.$v->id.'"></pre>';
            $a='<span onclick="view_notepad('.$v->id.')">'.$v->title.'</span>';
            array_push($res,array($a.$bt));
        }
        echo json_encode($res);
    }else{
        $data=$db->get_row("SELECT title,content FROM notepad WHERE id=$_GET[catatan]",ARRAY_N);
        echo json_encode($data);
    }
}
?>