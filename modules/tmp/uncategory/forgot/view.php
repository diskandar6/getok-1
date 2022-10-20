<?php


//require __DIR__.'/functions.php';

if(isset($_GET['change'])){
    $dir= __DIR__.'/page/change.php';
    require $dir;
}else require __DIR__.'/page/page.php';
?>