<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
require __DIR__.'/variable.php';

if(!post_login_registrasi())
if(cek_token($_POST['token'])){
    $password=$_POST['password'];
    if(count(explode(' ',$_POST['username']))==1)
        $username=$_POST['username'];
    else 
        header("location: /login?e=please try again");

    $var='username';
    if(count(explode('@',$username))>1)
        $var='email';
    $redirect=true;
    if($var=='username') $admin=is_login_developer_($_POST['username'],$_POST['password'],$redirect);
    else
        $admin=false;

    if(!isset($dblogin))header("location: /login?e=the system crashed");
    if(!$admin){
        $data=$dblogin->get_results("SELECT * FROM web_users");

        $ada=false;
        foreach($data as $k => $v)if(strtolower($v->$var)==strtolower($username)&&md5($password)==$v->password&&$v->status){
            $ada=true;
            foreach($v as $k1 =>$v1)$_SESSION[$k1]=$v1;
            $_SESSION['menu_admin']=$v->level;
            $_SESSION['position']=1;
            /*position=0 jika sebelum login, 
              position=1 jika sesudah login, 
              position=2 jika sebelum atau sesudah login
            */
            $_SESSION['FullName']=$v->nama;
            $_SESSION['foto']='/assets/img/Deafult-Profile-sx.png';
            if($_SESSION['image']!='')$_SESSION['foto']=$_SESSION['image'];
    
            set_cookies_login(array('id'=>$v->id,'position'=>1,'pegawai'=>1));
            
            if(isset($_SESSION['ref_login'])){
                $loc=$_SESSION['ref_login'];
                unset($_SESSION['ref_login']);
            }else{
                if(defined('D_REDIRECT_PAGE'))
                	$loc=D_REDIRECT_PAGE;
                else
                	$loc='coordinate-conversion';
            }
            header("location: $loc");
        }
        if(!$ada)header("location: /login?e=data not found");

    }
}else header("location: /login?e=please try again");
?>