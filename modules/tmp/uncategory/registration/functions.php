<?php
define('D_REGISTRATION_PMB',true);
require __DIR__.'/variable.php';
if(!defined('RUN_PHPMAILER')) require D_PLUGIN_PATH."phpmailer/functions.php";
if(!defined('RUN_ENCRYPTION')) require D_PLUGIN_PATH."encryption/functions.php";

$level_user=array("profile","coordinate-conversion","geoid-calculator","gnss","perataan","transformasi-datum");

function login_user_pkg($username,$password){
    global $dbregistration;
    $data=$dbregistration->get_results("SELECT * FROM web_users WHERE status>0");
    foreach($data as $k => $v)if($v->username==$username&&$v->password==md5($password)){
        foreach($v as $k1 => $v1)
            $_SESSION[$k1]=$v1;
        return true;
    }
    return false;
}
function insert_user($username,$email,$password,$level,$status,$info,$nama='',$image='',$ref=''){
    global $dbregistration;
    $dbregistration->insert("web_users",array('username'=>$username,'email'=>$email,'password'=>md5($password),'level'=>json_encode($level),'status'=>$status,'info'=>$info,'datetime'=>date('Y-m-d H:i:s'),'nama'=>$nama,'image'=>$image,'ref'=>$ref),array('%s','%s','%s','%s','%d','%s','%s','%s','%s'));
    
    insert_new_register();
    $db=$GLOBALS['dbg'];
    $db->insert("users",array('name'=>$username,'username'=>$username,'email'=>$email,'position'=>'admin','password'=>'','remember_token'=>'','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')),array('%s','%s','%s','%s','%s','%s','%s','%s'));
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

}
function insert_new_register(){
    /*$dbregistration=$GLOBALS['dbregistration'];
    $id=$dbregistration->get_row("SELECT id FROM web_users ORDER BY id DESC");
    $id=(int)$id->id;
    $ta=get_option('tahun akademik');
    $jm=$dbregistration->get_row("SELECT COUNT(*) AS jml FROM pmb_registrasi WHERE tahun_akademik=$ta");
    $jm=$jm->jml+1;
    $dbregistration->insert('pmb_registrasi',array(
        'id_user'=>$id,
        'tahun_akademik'=>$ta,
        'fakultas'=>0,
        'jurusan'=>0,
        'register'=>create_register($ta,$jm),
        'biaya'=>0,
        'jalurpenerimaan'=>1,
        'jadwal'=>0,
    ),array('%d','%d','%d','%d','%s','%f','%d','%d'));//*/
}
function post_login_registrasi(){
    global $level_user;
    if(isset($_POST['signingoogle'])){
        $dbregistration=$GLOBALS['dbregistration'];
        $email=$_POST['signingoogle'];
        if(ada_email($email)===false){
            $nama=$_POST['nama'];
            $image=$_POST['image'];
            $password=date('YmdHis');
            $code='google';
            insert_user($email,$email,$password,$level_user,0,$code,$nama,$image,'google');
        }

        $data=$dbregistration->get_row("SELECT * FROM web_users WHERE email='$email'");
        foreach($data as $k1 =>$v1)$_SESSION[$k1]=$v1;
        $_SESSION['menu_admin']=$data->level;
        $_SESSION['position']=1;
        $_SESSION['FullName']=$data->nama;
        $_SESSION['foto']='/assets/img/Deafult-Profile.png';
        if(!isset($_SESSION['image']))$_SESSION['foto']=$_SESSION['image'];
        elseif($_SESSION['image']!='')$_SESSION['foto']=$_SESSION['image'];
        
        set_cookies_login(array('id'=>$data->id,'position'=>1,'pegawai'=>1));
        //*/
        echo 'ok';
        return true;
    }else return false;
}
function str_len_min($str){
    if(ada_quote_spasi($str))return false;
    $l=strlen($str)>6;
    return $l;
}
function ada_quote_spasi($str){
    $strt=str_replace("'",'',$str);
    $strt=str_replace(" ",'',$strt);
    return $strt!=$str;
}
function ada_username($username){
    global $dbregistration;
    $regd=$dbregistration->get_row("SELECT COUNT(*) AS jml FROM web_users WHERE username='$username'");
    return $regd->jml>0;
}
function ada_email($email){
    global $dbregistration;
    $regd=$dbregistration->get_row("SELECT COUNT(*) AS jml FROM web_users WHERE email='$email'");
    return $regd->jml>0;
}
function err_reg($msg){
    header("location: /registration?e=".$msg);
}
function page_reg($page){
    header("location: /".D_PAGE."?p=".$page);
}
function read_css($k){
    return file_get_contents(__DIR__.'/css/'.$k);
}
function view_page(){
    if(isset($_GET['p'])){
        switch($_GET['p']){
            case 'success':require __DIR__.'/page/success.php';break;
            case 'verify':require __DIR__.'/page/verify.php';break;
            case 'resend':require __DIR__.'/page/resendverif.php';break;
            case 'verified':require __DIR__.'/page/verified.php';break;
        }
    }elseif(isset($_GET['e'])) require __DIR__.'/page/error.php';
    else require __DIR__.'/page/signup.php';
}
function create_mail_content($mail,$replace){
    $content=read_mail_template($mail);
    foreach($replace as $k => $v)
        $content=str_replace($k,$v,$content);
    return $content;
}
function read_mail_template($mailtmp){
    if(file_exists(__DIR__.'/tmp/'.$mailtmp))
    return file_get_contents(__DIR__.'/tmp/'.$mailtmp);
    else return '';
}
function write_mail_template($mailtmp,$data){
    file_put_contents(__DIR__.'/tmp/'.$mailtmp,$data);
}
function resendverifcode($email){
    global $dbregistration;
    if(count(explode('@',$email))>1){
        if(count(explode('.',$email))>1){
            if(count(explode(' ',$email))==1){
                $data=$dbregistration->get_row("SELECT COUNT(*) AS jml FROM web_users WHERE email='$email'");
                if($data->jml>0){
                    $data=$dbregistration->get_row("SELECT * FROM web_users WHERE email='$email'");
                    $from=array('address'=>get_option('SENDER ADDRESS','support@stikes-aisyiyahbandung.ac.id',false),'name'=>get_option('SENDER NAME','Support',false));
                    $replay=array('address'=>get_option('REPLAY ADDRESS','support@stikes-aisyiyahbandung.ac.id',false),'name'=>get_option('REPLAY NAME','Support',false));
                    $recipients=array(array('address'=>$data->email,'name'=>$data->username));
                    $cc=array();
                    $email=encr(str_replace('.','',str_replace('@','',$data->email)));
                    $code=encr($code);
                    $link='//'.D_DOMAIN.'/data/registration?verify='.$code.'-'.$email;
                    $replace=array(
                        '{username}'=>$data->username,
                        '{link}'=>$link,
                        '{domain}'=>D_DOMAIN,
                        '{code}'=>$code.'-'.$email
                        );
                    $subject=create_mail_content('subjectverif.txt',$replace);
                    $content=create_mail_content('contentverif.txt',$replace);
                    /*
                    echo $content;
                    /*/
                    if(send_mail($from,$replay,$recipients,$cc,$subject,$content))
                    	return true;
                    //else echo 'Invalid Data';//*/
                }
            }
        }
    }
    return false;
}
function verify_user($email,$code){
    global $dbregistration;
    $data=$dbregistration->get_results("SELECT * FROM web_users WHERE REPLACE(REPLACE(email,'@',''),'.','')='$email' AND status=0");
    
    foreach($data as $k => $v){
        if($v->info==$code){
            $hist=modify_hist($v->history,-9999999999,'email verification');
            $dbregistration->update('web_users',array('status'=>1,'history'=>$hist),array('id'=>$v->id),array('%d','%s'),array('%d'));
            $from=array('address'=>get_option('SENDER ADDRESS','support@stikes-aisyiyahbandung.ac.id',false),'name'=>get_option('SENDER NAME','Support',false));
            $replay=array('address'=>get_option('REPLAY ADDRESS','support@stikes-aisyiyahbandung.ac.id',false),'name'=>get_option('REPLAY NAME','Support',false));
            $recipients=array(array('address'=>$v->email,'name'=>$v->username));
            $cc=array();
            $replace=array(
                '{username}'=>$v->username,
                '{email}'=>$v->email,
                '{domain}'=>D_DOMAIN,
                );
            $subject=create_mail_content('subjectverified.txt',$replace);
            $content=create_mail_content('verified.txt',$replace);
            /*
            echo $content;
            /*/
            if(send_mail($from,$replay,$recipients,$cc,$subject,$content))
                return true;
            //*/
        }
    }
    return false;
}
function success_reg($code){
    $from=array('address'=>get_option('SENDER ADDRESS','support@stikes-aisyiyahbandung.ac.id',false),'name'=>get_option('SENDER NAME','Support',false));
    $replay=array('address'=>get_option('REPLAY ADDRESS','support@stikes-aisyiyahbandung.ac.id',false),'name'=>get_option('REPLAY NAME','Support',false));
    $recipients=array(array('address'=>$_POST['email'],'name'=>$_POST['username']));
    $cc=array();
    $email=encr(str_replace('.','',str_replace('@','',$_POST['email'])));
    $code=encr($code);
    $link='//'.D_DOMAIN.'/data/registration?verify='.$code.'-'.$email;
    $replace=array(
        '{username}'=>$_POST['username'],
        '{email}'=>$_POST['email'],
        '{pass}'=>$_POST['password'],
        '{link}'=>$link,
        '{domain}'=>D_DOMAIN,
        '{code}'=>$code.'-'.$email
        );
    $subject=create_mail_content('subject.txt',$replace);
    $content=create_mail_content('content.txt',$replace);
    /*
    echo $content;
    /*/
    if(send_mail($from,$replay,$recipients,$cc,$subject,$content))
    	page_reg('success');
    //else echo 'Invalid Data';//*/
}

?>