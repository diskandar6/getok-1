<?php
/*==============================================================================

                                    SOURCE
                                    
http://pddikti-admin.ristekdikti.go.id/static/media/USER-GUIDE-WEB-SERVICE-VERSI-2.2-%5B01-10-2019%5D.dadfbe16.pdf

===============================================================================*/
if(!defined('D_SOURCEFEEDER'))define('D_SOURCEFEEDER','http://unisa-bandung.profeeder.id:8037/');
if(!defined('D_URLFEEDER'))define('D_URLFEEDER','http://feeder.stikes-aisyiyahbandung.ac.id:8082/ws/live2.php');
if(!defined('D_KODE_PT'))define('D_KODE_PT','043330');
require __DIR__.'/functionlist.php';

function GetGeneral($funcname,$limit=100,$offset=0,$filter=''){
    return Get_($funcname,$filter,$limit,$offset);
}

function Get_($act,$filter='',$limit=100,$offset=0){
    if(!isset($_SESSION['token']))get_token();
    $i=0;
    a:
    $postData = array(
        'act' => $act,
        'token' => $_SESSION['token'],
        'filter' => $filter,
        'limit' => $limit,
        'offset' => $offset
    );
    $response=exec_($postData);
    if($response->error_code!=0){
        get_token();
        $i++;
        if($i<10) goto a;
    }
    return $response;
}
function get_token(){
    $postData = array(
        'act' => 'GetToken',
        'username' => '043330',
        'password' => '1aisyiyah',
    );
    $response=exec_($postData);
    $_SESSION['token']=$response->data->token;
    return $_SESSION['token'];
}
function exec_($postData){
    $context = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => //"Authorization: {$authToken}\r\n".
            "Content-Type: application/json\r\n",
            'content' => json_encode($postData)
        )
    ));
    $response = file_get_contents(D_URLFEEDER, FALSE, $context);
    return json_decode($response);
}

?>