<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
if(!set_token())
header('location: /login');
?>