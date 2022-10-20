<?php
if(!defined('D_PGPN')){
    define('D_PGPN','Perhitungan Gaji Pokok Standar Nasional');
    /*
    tahun acuan berubah sesuai kebijakan instansi
    $tahun_acuan=2017;
    
    golongan:   0 = golongan I
                1 = golongan II
                2 = golongan III
                3 = golongan IV
    $gol=2;
    
    subgolongan 0 = A
                1 = B
                2 = C
                3 = D
                4 = E
    $subgol=2;
    
    $lamakerja=15;
    
    $gapok=gapok($gol,$subgol,$tahun_acuan,$lamakerja);
    
    */
    function gapok($gol,$subgol,$tahun,$lama){
        $gapok_dasar=array(
            array(1323000,1444800,1505900,1569600),        // golongan I
            array(1741100,1871900,1951100,2033600),        // golongan II
            array(2186400,2278900,2375300,2475700),        // golongan III
            array(2580500,2689600,2803400,2922000,3045600) // golongan IV
            );
        // mundur satu tahun
        //$tahun--;
        
        $kenaikantahunan=6/100;
        $kenaikanberkala=3.15/100;
        if($gol==1&&$subgol==0&&$lama==0)
            $gapok=1714100;
        else
            $gapok=$gapok_dasar[$gol][$subgol];
        
        if($gol==0||$gol==1){
            if($subgol>0)$lama-=3;
            if($lama<0)$lama=0;
            elseif($gol==1){
                if($subgol==0&&$lama>0){
                    $lama-=1;
                }
            }
        }
        return $gapok*(pow(1+$kenaikantahunan,$tahun-2013))*(pow(1+$kenaikanberkala,floor(($lama)/2)));
    }
    function kenaikan_golongan($gol,$subgol,$puncak_gol,$puncak_subgol,$lamakerja,$tahun_pertama,$tahun_terakhir='now'){
        $res=array();
        $dt=date('Y',strtotime($tahun_pertama));
        $rentang=date('Y',strtotime($tahun_terakhir))-$dt;
        if(date('m')<9)$rentang+=1;
        for($lama=0;$lama<$rentang;$lama++){
            $boleh=$gol<$puncak_gol;
            if(!$boleh)$boleh=$subgol<$puncak_subgol;
            if($boleh){
                if(($lama)%4==0&&($lama)>0)
                    $subgol+=1;
                if($subgol>3&&$gol<3){
                    $subgol=0;
                    $gol+=1;
                }
                if($gol==3&&$subgol>4)$subgol=4;
            }
            array_push($res,array($lama+$lamakerja,$lama+$dt,$gol,$subgol,index_gol($gol,$subgol),gapok($gol,$subgol,$lama+$dt,$lama+$lamakerja)));
        }
        return $res;
    }
    
    function index_gol($gol,$subgol){
        $res=($gol)*4+$subgol+1;
        return $res;
    }
    function gol_index($index){
        $index-=1;
        if($index<16)
            return array(floor($index/4),$index%4);
        else return array(3,4);
    }
}