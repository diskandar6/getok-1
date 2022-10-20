<?php
$opt=dirname(__DIR__).'/options/functions.php';
if(file_exists($opt)){
    global $dboption;
    $dboption=db_connection($db);
    include $opt;
    set_option('SENDER ADDRESS','support@stikes-aisyiyahbandung.ac.id');
    set_option('SENDER NAME','Support');
    set_option('REPLAY ADDRESS','support@stikes-aisyiyahbandung.ac.id');
    set_option('REPLAY NAME','Support');//*/
}
?>