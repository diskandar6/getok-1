<?php
if(set_option($_POST['name'],$_POST['value']))echo 'ok';else echo 'error';
?>