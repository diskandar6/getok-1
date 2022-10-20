<?php
$continue=true;
require __DIR__.'/administrator/post.php';
if($continue){
    require __DIR__.'/database/post.php';
    if($continue){
        require __DIR__.'/notepad/post.php';
        if($continue){
            require __DIR__.'/module/post.php';
            if($continue){
                require __DIR__.'/explorer/post.php';
            }
        }
    }
}
?>