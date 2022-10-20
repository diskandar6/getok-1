<?php
/*
if(isset($_POST['resetpassword'])){
    $id=(int)$_POST['resetpassword'];
    $kepeg->update('data_pegawai',array(
        'password'=>md5('aisyiyah2019'),
    ),array('id'=>$id),array(
        '%s', 
    ),array('%d'));
    echo 'ok';
}elseif(isset($_POST['status'])){
    $id=(int)$_POST['status'];
    $st=$kepeg->get_row("SELECT status FROM data_pegawai WHERE id=$id");
    $kepeg->update('data_pegawai',array(
        'status'=>($st->status+1)%2,
    ),array('id'=>$id),array(
        '%d', 
    ),array('%d'));
    echo 'ok';
}elseif(isset($_POST['savemenu'])){
    $kepeg->update('data_pegawai',array('menu_admin'=>$_POST['menu']),array('id'=>(int)$_POST['savemenu']),array('%s'),array('%d'));
    echo 'ok';
}elseif(isset($_POST['id'])){
    $kepeg->update('data_pegawai',array(
        'username'=>$_POST['username'],
        'npp'=>$_POST['npp'],
        'nama'=>$_POST['nama'],
        'jenis_kelamin'=>$_POST['gender'],
        'tanggal_lahir'=>$_POST['tanggallahir'],
        'tempat_lahir'=>$_POST['tempatlahir'],
        'tanggal_masuk'=>$_POST['tanggalmasuk'],
        'hp'=>$_POST['hp'],
        'alamat'=>$_POST['alamat'],
    ),array('id'=>(int)$_POST['id']),array(
        '%s',   //username
        '%s',   //npp
        '%s',   //nama
        '%s',   //gender
        '%s',   //tl
        '%s',   //ttl
        '%s',   //tm
        '%s',   //hp
        '%s',   //alamat
    ),array('%d'));
    echo 'ok';
}else{
    $ada=$kepeg->get_row("SELECT COUNT(*) AS jml FROM data_pegawai WHERE username='$_POST[username]'");
    if((int)$ada->jml==0){
    $kepeg->insert('data_pegawai',array(
        'username'=>$_POST['username'],
        'npp'=>$_POST['npp'],
        'nama'=>$_POST['nama'],
        'jenis_kelamin'=>$_POST['gender'],
        'tanggal_lahir'=>$_POST['tanggallahir'],
        'tempat_lahir'=>$_POST['tempatlahir'],
        'tanggal_masuk'=>$_POST['tanggalmasuk'],
        'hp'=>$_POST['hp'],
        'alamat'=>$_POST['alamat'],
        'kapabilitas'=>'[]',
        'allow_ip'=>'["*"]',
        'status'=>1,
        'password'=>md5('aisyiyah2019'),
        'menu_admin'=>'["profile","laporan_kerja"]',
    ),array(
        '%s',   //username
        '%s',   //npp
        '%s',   //nama
        '%s',   //gender
        '%s',   //tl
        '%s',   //ttl
        '%s',   //tm
        '%s',   //hp
        '%s',   //alamat
        '%s',   //kapabilitas
        '%s',   //allow_ip
        '%d',   //status
        '%s',   //password
        '%s',   //menu_admin
    ));
    echo 'ok';
    }else echo 'username already exists';
}
//*/?>