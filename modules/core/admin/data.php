<?php
$continue=true;
require __DIR__.'/administrator/data.php';
if($continue){
    require __DIR__.'/database/data.php';
    if($continue){
        require __DIR__.'/notepad/data.php';
        if($continue){
            require __DIR__.'/module/data.php';
            if($continue){
                require __DIR__.'/explorer/data.php';
            }
        }
    }
}
?>