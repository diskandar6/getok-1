<?php /*
function strip_($v){
    return implode(' ',str_word_count(str_replace(chr(10),'',$v),1,
    '0123456789.,<>?:";[]{}!@#$%^&*()_+-=|\/'));
}
if(isset($_GET['menu'])){
    $id=(int)$_GET['menu'];
    $data=$kepeg->get_row("SELECT menu_admin from data_pegawai WHERE id=$id");
    echo $data->menu_admin;
}elseif(isset($_GET['id'])){
    $id=(int)$_GET['id'];
    $data=$kepeg->get_row("SELECT username, npp, nama, jenis_kelamin AS gender, tanggal_lahir AS tanggallahir, tempat_lahir AS tempatlahir, tanggal_masuk AS tanggalmasuk, hp, alamat from data_pegawai WHERE id=$id");
    $data->alamat=strip_($data->alamat);
    echo json_encode($data);
}else{
    $data=$kepeg->get_results("SELECT * FROM data_pegawai");
    $res=array();
    $jk=array('l'=>'Laki-laki','p'=>'Perempuan');
    foreach($data as $k => $v){
        $status='';if($v->status==0)$status='-slash';
        $bio='<image src="data/profile/profile/'.$v->id.'" style="width:100px" class="z-depth-1"><br>'.$v->nama.'<br>'.$jk[$v->jenis_kelamin].'<br>Lahir: '.$v->tempat_lahir.', '.date('d F Y',strtotime($v->tanggal_lahir));
        $alamat='Alamat: '.strip_($v->alamat);
        $alamat.='<br>Telp: '.$v->hp;
        $akun='Username: '.$v->username.'<br>'.implode(', ',json_decode($v->menu_admin,true));
        $edit='<span title="Edit" class="badge badge-primary" onclick="edit_pegawai('.$v->id.')" data-toggle="modal" data-target="#modal-pegawai"><i class="fas fa-user-edit"></i> Edit</span>';
        $edit.=' <span class="badge badge-success" data-toggle="modal" data-target="#modal-menu-admin" onclick="menu_pegawai('.$v->id.')"><i class="fas fa-align-justify"></i> Menu Admin</span>';
        $edit.=' <span class="badge badge-danger" onclick="status_pegawai('.$v->id.')"><i class="fas fa-user-alt'.$status.'"></i> Status</span>';
        $edit.=' <span class="badge badge-info" onclick="reset_password('.$v->id.')"><i class="fas fa-lock'.$status.'"></i> Reset password</span>';
        array_push($res,array($bio,$alamat,$akun,$edit));
    }
    echo json_encode($res);
}
//*/?>