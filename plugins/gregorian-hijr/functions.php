<?php
if(!defined('D_NAMABULANHIJR')){
define('D_NAMABULANHIJR',json_encode(array('Muharram','Shafar','Rabi\'ul Awal','Rabi\'ul Akhir','Jumadil Awal','Jumadil Akhir','Rajab','Sya\'ban','Ramadhan','Syawal','Zulqaidah','Zulhijjah')));

include __DIR__."/cal_class.php";

/*
        Greg3Hijr(y,m,d)

        Hijr2Greg(y,m,d)
*/

function NamaBulanHijr($m){
    $b=json_decode(D_NAMABULANHIJR,true);
    return $b[$m-1];
}

function Hijr2Greg($y,$m,$d){
    $DateConv=new Hijri_GregorianConvert;
    $format="YYYY/MM/DD";
    $date="$y/$m/$d";
    $result=$DateConv->HijriToGregorian($date,$format);
}

function Greg3Hijr($y,$m,$d){
    $DateConv=new Hijri_GregorianConvert;
    $format="YYYY/MM/DD";
    $date="$y/$m/$d";
    $result=$DateConv->GregorianToHijri($date,$format);
}

}

?>