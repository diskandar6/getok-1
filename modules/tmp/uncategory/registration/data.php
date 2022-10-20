<?php
if(isset($_GET['resend'])){
    if(resendverifcode($_GET['resend']))
        page_reg('resend&e=The code has been sent to '.$_GET['resend']);
    else
        page_reg('resend&e=Invalid data');
}elseif(isset($_GET['verify'])){
    $code=explode('-',$_GET['verify']);
    $email=decr($code[1]);
    $code=decr($code[0]);
    echo $code;
    if( verify_user($email,$code)){
        page_reg('verified');
    }else
        page_reg('verify&e=Invalid data');//*/
}
?>