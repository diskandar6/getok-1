<?php
require __DIR__.'/variable.php';

if(cek_token($_POST['token'])){
    $password=$_POST['password'];
    $username=$_POST['username'];
    $var='username';
    if(count(explode('@',$username))>1)
        $var='email';
    $redirect=true;
    if($var=='username') $admin=is_login_developer_($_POST['username'],$_POST['password'],$redirect);
    else $admin=false;
    if(!$admin){
        header("location: /login?e=data not found");
    }
}else header("location: /login?e=please try again");
?>