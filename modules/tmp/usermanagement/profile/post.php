<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
if(!defined('D_PROFILE'))require __DIR__.'/functions.php';

if(isset($_POST['pass1'])){
    $pass1=$_POST['pass1'];
    $pass2=$_POST['pass2'];
    $email=$_POST['email'];
    if((int)$_SESSION['id']>0){
        $e=strpos($email,'@');
        if($e===false){
            echo 'Wrong data';
            exit;
        }
        $e=explode('@',$email);
        $e=explode('.',$e[1]);
        if(count($e)<2){
            echo 'Wrong data';
            exit;
        }
    }
    $tb="web_users";
    if(strlen($pass1)==0&&(int)$_SESSION['id']>0){
        $dbprofile->update($tb,array('email'=>$_POST['email']),array('id'=>(int)$_SESSION['id']),array('%s'),array('%d'));
        $_SESSION['email']=$_POST['email'];
        echo 'ok';
    }elseif($pass1==$pass2){
        if(strlen($pass2)>7){
            if(str_len_min($pass2)){
                if((int)$_SESSION['id']<0)
                    $dbprofile->update('administrator',array('password'=>md5($pass1)),array('id'=>abs((int)$_SESSION['id'])),array('%s'),array('%d'));
                else
                    $dbprofile->update($tb,array('email'=>$_POST['email'],'password'=>md5($pass1)),array('id'=>(int)$_SESSION['id']),array('%s','%s'),array('%d'));
                echo 'ok';
            }else echo 'Please use [a..z],[0..9],[A..Z],special characters without quote and space';
        }else echo 'Password min 8 characters';
    }else echo 'Password not equal';
}
?>