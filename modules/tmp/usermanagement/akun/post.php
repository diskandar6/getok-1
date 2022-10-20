<?php
if(isset($_POST['status'])){
    $id=(int)$_POST['status'];
    $tb='web_users';
    $st=$dbakun->query("UPDATE $tb SET status=(status+1)%2 WHERE id=$id");
    echo 'ok';
}elseif(isset($_POST['savemenu'])){
    $tb='web_users';
    $dbakun->update($tb,array('level'=>$_POST['menu']),array('id'=>(int)$_POST['savemenu']),array('%s'),array('%d'));
    change_menu_admin((int)$_POST['savemenu'],$tb);
    echo 'ok';
}elseif(isset($_POST['id'])){
    $id=(int)$_POST['id'];
    if($_POST['pass']!=''){
        $tb='web_users';
        $dbakun->update($tb,array(
            'username'=>$_POST['username'],
            'email'=>$_POST['email'],
            'password'=>md5($_POST['pass']),
            'nama'=>$_POST['nama'],
        ),array('id'=>$id),array(
            '%s',// username
            '%s',// email
            '%s',// password
            '%s',// nama
        ),array('%d'));
    }else{
        $dbakun->update("web_users",array(
            'username'=>$_POST['username'],
            'email'=>$_POST['email'],
            'nama'=>$_POST['nama'],
        ),array('id'=>$id),array(
            '%s',// username
            '%s',// email
            '%s',// nama
        ),array('%d'));
    }
    echo 'ok';
}else{
    $tb='web_users';
    $dbakun->insert($tb,array(
        'username'=>$_POST['username'],
        'email'=>$_POST['email'],
        'password'=>md5($_POST['pass']),
        'level'=>'["profile"]',
        'history'=>'',
        'status'=>1,
        'info'=>'',
        'datetime'=>date('Y-m-d'),
        'ref'=>'',
        'nama'=>$_POST['nama'],
        'image'=>'/assets/img/Deafult-Profile-sx.png'
    ),array(
        '%s',// username
        '%s',// email
        '%s',// password
        '%s',// level
        '%s',// histori
        '%d',// status
        '%s',// info
        '%s',// datetime
        '%s',// ref
        '%s',// nama
        '%s',// image
    ));
    $now=date('Y-m-d H:i:s');
    $dbakun->insert('users',array(
        'name'=>$_POST['nama'],
        'username'=>$_POST['username'],
        'email'=>$_POST['email'],
        'position'=>'admin',
        'password'=>md5($now),
        'remember_token'=>null,
        'created_at'=>$now,
        'updated_at'=>$now
    ),array(
    ));
    echo 'ok';
}
/*
CREATE TABLE `users` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
*/
?>