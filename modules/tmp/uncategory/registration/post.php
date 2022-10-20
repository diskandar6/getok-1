<?php
if(!defined('D_REGISTRATION_PMB'))require D_registration.'/functions.php';
/*
$_POST={ username, email, password, cpassword }

level default:
    profile, form, tagihan, cara-pembayaran, info, hasilkelulusan

*/
if(!post_login_registrasi())
if(isset($_POST['password'])){
    //$token=$_POST['token'];
    //if($token==$_SESSION['token']){
        if($_POST['password']==$_POST['cpassword']){
            if(strlen($_POST['password'])>7){
                $password=$_POST['password'];
                if(str_len_min($password)){
                    $username=strtolower($_POST['username']);
                    $email=$_POST['email'];
                    $username=$email;
                    if(str_len_min($username)){
                        if(!ada_username($username)){
                            if(!ada_quote_spasi($email)){
                                if(!ada_email($email)){
                                    $code='a'.rand(100000000,999999999);
                                    insert_user($username,$email,$password,$level_user,0,$code,'','','manual');
                                    success_reg($code);
                                    header("location: /login");
                                }else err_reg('email already exist');
                            }else err_reg('please try again');
                        }else err_reg('username already exist');
                    }else err_reg('Please try again');
                }else err_reg('Please use [a..z],[0..9],[A..Z],special characters without quote and space');
            }else err_reg('Password min 8 characters');
        }else err_reg('Password not equal');
    //}else err_reg('Please try again');
    unset($_SESSION['token']);
}
?>