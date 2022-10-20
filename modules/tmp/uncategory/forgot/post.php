<?php
//require __DIR__.'/functions.php';

if(cek_token($_POST['token'])){
    if(isset($_POST['password1'])){
        $code=$_GET['change'];
        $url='&change='.$code;
        if(valid_code_change_password()){
            if($_POST['password1']==$_POST['password2']){
                $password=$_POST['password1'];
                if(strlen($password)>7){
                    if(str_len_min($password)){
                        decrypt_code_forgot($code,$id,$email,$tgl);
                        $dbforgotpassword->update('web_users',array('password'=>md5($password)),array('id'=>$id),array('%s'),array('%d'));
                        header("location: /login");
                    }else rd_('Please use [a..z],[0..9],[A..Z],special characters without quote and space'.$url);
                }else rd_('Password min 8 characters'.$url);
            }else rd_("Password not match".$url);
        }else rd_("please try again".$url);
    }else{
        $email=$_POST['email'];
        if(count(explode('@',$email))>1&&count(explode('.',$email))>1&&count(explode(' ',$email))==1){
            $data=$dbforgotpassword->get_row("SELECT COUNT(*) AS jml FROM web_users WHERE email='$email'");
            if($data->jml>0){
                $data=$dbforgotpassword->get_row("SELECT * FROM web_users WHERE email='$email'");
                if(!defined('RUN_PHPMAILER')) require D_PLUGIN_PATH."phpmailer/functions.php";
                $from=array('address'=>'support@stikes-aisyiyahbandung.ac.id','name'=>'Support');
                $replay=array('address'=>'support@stikes-aisyiyahbandung.ac.id','name'=>'Support');
                $recipients=array(array('address'=>$email,'name'=>$email));
                $cc=array();
                $email=encr(str_replace('.','',str_replace('@','',$email)));
                $code='a'.date('YmdHis');
                $code=encr($code);
                $link='//'.D_DOMAIN.'/'.D_PAGE.'?change='.$code.'-'.$email.'-'.$data->id;
                $replace=array(
                    '{email}'=>$data->email,
                    '{username}'=>$data->username,
                    '{name}'=>$data->username,
                    '{domain}'=>D_DOMAIN,
                    '{link}'=>$link
                    );
                $subject=create_mail_content('subjectforgot.txt',$replace);
                $content=create_mail_content('forgot.txt',$replace);
                /*
                echo $content;
                /*/
                if(send_mail($from,$replay,$recipients,$cc,$subject,$content))
                	page_reg('success');
                //else echo 'Invalid Data';//*/
            }else rd_("please try again");
        }else rd_("please try again");
    }
}else rd_("please try again");
?>