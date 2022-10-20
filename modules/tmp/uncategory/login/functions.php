<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
if(!defined('D_LOGIN')){define('D_LOGIN',true);

addhook(0,'ispagecrossuser');
function ispagecrossuser(){
    if(D_PAGE!=='develop'){
        $header=constant('D_'.D_PAGE).'/header.php';
        if(file_exists($header)){
    	    $hdr=header_variable_list($header);
        }
    }
}


}
?>