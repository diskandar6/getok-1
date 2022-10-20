<?php
require __DIR__.'/functions.php';
if(isset($_GET['captcha']))create_captcha();else captcha();
?>