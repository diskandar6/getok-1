<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
define('D_PROFILE',true);
require __DIR__.'/variable.php';
function str_len_min_($str){
    if(ada_quote_spasi($str))return false;
    $l=strlen($str)>6;
    return $l;
}
function ada_quote_spasi_($str){
    $strt=str_replace("'",'',$str);
    $strt=str_replace(" ",'',$strt);
    return $strt!=$str;
}
?>