<?php
//if(file_exists(D_PLUGIN_captcha)&&!defined('RUN_CAPTCHA'))include D_PLUGIN_captcha;
if(!defined('RUN_ENCRYPTION')){define('RUN_ENCRYPTION',1);

function record_soft(){
    if(isset($_GET['idregomt'])){
        if(file_exists(D_PLUGIN_ip2location))
            include D_PLUGIN_ip2location;
        $dbname=json_decode(D_DATABASE,true);
        foreach($dbname as $k => $v)if($k=='db_oceanoma')$$k=new wpdb(D_DBUSER, D_DBPASSWORD, $v, D_DBHOST);
        $ip=get_client_ip();
        $y=date('Y');
        $m=date('m');
        $d=date('d');
        if(isset($_SERVER['HTTP_REFERER']))
        $ref=$_SERVER['HTTP_REFERER'];
        elseif (isset($_SERVER['SCRIPT_URI']))
        $ref=$_SERVER['SCRIPT_URI'];
        if(strpos($ref,D_DOMAIN)!==false)return false;
        $jml=$db_oceanoma->get_row("SELECT COUNT(*) AS jml FROM aktivitas WHERE ip='$ip' AND year(waktu)=$y AND month(waktu)=$m AND DAY(waktu)=$d");
        if($jml->jml==0){
            $geo=ip2location($ip,D_PLUGIN.'ip2location/database/IP2LOCATION-LITE-DB3.BIN');
            $country=$geo['countryName'];
            $countryid=$geo['countryCode'];
            $region=$geo['regionName'];
            $city=$geo['cityName'];
            $geo='';
            if($city!='-') $geo.=$city.' ';
            if($region!='-') $geo.=$region.' ';
            if($country!='-') $geo.=$country.'/'.$countryid;
    
            $ids=$db_oceanoma->get_row("SELECT id_user,id_produk FROM serialnumber WHERE id=".(int)$_GET['idregomt']);
            $iduser=$ids->id_user;
            $idproduk=$ids->id_produk;
            $db_oceanoma->insert('aktivitas',
                array(
                    'id_user'=>$iduser,
                    'id_produk'=>$idproduk,
                    'id_sn'=>(int)$_GET['idregomt'],
                    'waktu'=>date('Y-m-d'),
                    'ip'=>$ip,
                    'geolocation'=>$geo
                    ),
                array('%d','%d','%d','%s','%s','%s')
                );
        }
    }
}

if(defined('D_PAGE'))
if(D_PAGE=='home'){
    record_soft();
}
function visitor(){
    if(defined('D_COMMAND')||count($_POST)>0)return false;
    if(file_exists(D_PLUGIN_ip2location))
        include D_PLUGIN_ip2location;
    $dbname=json_decode(D_DATABASE,true);
    foreach($dbname as $k => $v)if($k=='db_oceanoma')$$k=new wpdb(D_DBUSER, D_DBPASSWORD, $v, D_DBHOST);
    $ip=get_client_ip();
    $y=date('Y');
    $m=date('m');
    $d=date('d');
    if(isset($_SERVER['HTTP_REFERER']))
        $ref=$_SERVER['HTTP_REFERER'];
    elseif (isset($_SERVER['SCRIPT_URI']))
        $ref=$_SERVER['SCRIPT_URI'];
    else
        $ref='';
    if($ref=='')return false;
    $r=explode('/',$ref);$r=$r[2];
    if(strpos($ref,D_DOMAIN)!==false)return false;
    $jml=$db_oceanoma->get_row("SELECT COUNT(*) AS jml FROM visitor WHERE ip='$ip' AND year(waktu)=$y AND month(waktu)=$m AND DAY(waktu)=$d AND referer LIKE '%$r%'");
    if($jml->jml==0){
        $geo=ip2location($ip,D_PLUGIN.'ip2location/database/IP2LOCATION-LITE-DB3.BIN');
        $country=$geo['countryName'];
        $countryid=$geo['countryCode'];
        $region=$geo['regionName'];
        $city=$geo['cityName'];
        $loc='';
        if($city!='-') $loc.=$city.' ';
        if($region!='-') $loc.=$region.' ';
        if($country!='-') $loc.=$country.'/'.$countryid;
        $db_oceanoma->insert('visitor',array('waktu'=>date('Y-m-d H:i:s'),'ip'=>$ip,'referer'=>$ref,'page'=>$_SERVER['REQUEST_URI'],'geolocation'=>$loc));
    }
}
function check_status_login($meta){
    global $db_oceanoma;
    if(isset($_SESSION['asuser'])){
        switch($_SESSION['asuser']){
        case 0:///  register
            visitor();
            $pages=$db_oceanoma->get_row("SELECT pages FROM registration WHERE id=$_SESSION[id]",ARRAY_N);
            break;
        case 1:///  administrator
            $pages=$db_oceanoma->get_row("SELECT pages FROM users WHERE id=$_SESSION[id]",ARRAY_N);
            break;
        }
        $pages=json_decode($pages[0],true);
        if(!(in_array(D_PAGE, $pages)||in_array('*', $pages))){
            header("location: /".D_BASEPAGE);
            return false;
        }
    }
    return true;
}

function redirect_(){
    header("location: /".D_REDIRECT);
}

function check_modules_($mod){
    if(isset($_SESSION['id']))
        if($_SESSION['id']==0)return true;
    $a=json_decode(file_get_contents($mod.'header.meta'),true);
    if(isset($a['for'])){
        if($a['for']=='all')return true;
        if(!isset($_SESSION['asuser'])){
            if($a['for']=='registrant'||$a['for']=='user')
                return true;
        }else{
            if(($a['for']=='registrant'&&$_SESSION['asuser']==0)||($a['for']=='user'&&$_SESSION['asuser']==1))
                return true;
        }
    }
    //define('D_PAGE_PATH','');
    if(isset($a['redirect']))define('D_REDIRECT',$a['redirect']);
}

function get_char(){
    return implode('',array_merge(range('a','z'),range(0,9),range('A','Z')));
}

function key_($i){
  switch($i){
  case 0 :return '1J7PgfLEnktiRuvSMAZYjdKU9oIBCXe4cqOrW0wsNmGx8QTzhF6lDVapy2bH35';break;
  case 1 :return 'VgAIct8KuCX6PbZMFoiOnjmTfGvU7elLHJEp1DR2SdB4hyzY395QWwNq0arksx';break;
  case 2 :return 'p70L6XQxvuGVRAySToW1MO2n8dDc4hNJfP35IEFYUajwqBZreklgtsKHmib9Cz';break;
  case 3 :return 'geZDLxF2Yi6mzHufcMCAXrvR8yN9bEnhPk3pwUGlQSB7WKdj01sTI5tOoa4JqV';break;
  case 4 :return 'HAhN1OMiYzGuaynjwoKIXtx0UPS5VpQlLBb2ZWRE9gqFeJsr3cfv7mD8kCT46d';break;
  case 5 :return 'wdFnIq3LBAoMNUDVYf1l5v7HkpiXusPO9xcK4ZaCQbE2WT8mRrjG6JSyt0gehz';break;
  case 6 :return 'eG24YBrK6qSO10wuFI8nVazgcRP5UWCDvy9tX73NJAmdQfLsibkTlhjExpoHMZ';break;
  case 7 :return 'z42bHdw1Y9a8rf6qnkAsiJlBpLQjDuR53mFot0M7SIKgeTNVCWvxEyGUcZPOhX';break;
  case 8 :return 'C7sEyJrUvYWBXnHLqc1G5Am0DfewoSPTpZa89jRu3xVbkMNi2dQ64IhOtgKFzl';break;
  case 9 :return 'XOow7e2E5cmbPBLKFiAjxRWu8SdynZ4369hVtUakgpIQTrJ1GNHqvM0CzsfDlY';break;
  case 10:return 'QyLManV2zGD0uepEZKtRobSgFU8kx6XHrjT1vIi53NlJ47qsCcfAOPwBYdm9Wh';break;
  case 11:return 'cVapRr2GSbYPHiz19Omxhwod50gUN364tKL7kAEXjWlyBTvufZe8MIFDJqCsnQ';break;
  case 12:return 'QjvY8ibC6NED0gOtmduRk3MenWF4I9V7l1HJahUwBcfqP2GLrKXoTpz5SsAZxy';break;
  case 13:return 'zXkV8enUtfQhpGCguiDZqLcN3yKBj695dxvbEo7rTOmFWw2HI0al1YSP4RMAJs';break;
  case 14:return 'EmAvcq0TDBiMS1GkF4drxYw6fOK7WhuNpLRVyJHU5b93ojlPgeZtsXICaQz82n';break;
  case 15:return 'e5uXs67KAn3p9ztCFdBHrfiWLJlqSEYgvcDohyRwbMTjkm284UNI1aGZxOVPQ0';break;
  case 16:return '1Oox0k9UW5n6BwtD743ybZXzSiedjCYhpLcguAmJaRIE8rHFlQGTNvVKq2PsMf';break;
  case 17:return 'YNHVMQUsOTwAlapm9Z0FohGK3dce28Wk7SPIEjvy6iDX5CJtgurRLxn41Bzbfq';break;
  case 18:return 'JyNGCoc8jK25pOdvEH0tsAxLSQ7glVmq41neFfIWZ96Xi3zbUDRuwYkPTBrMha';break;
  case 19:return 'gfJmpG40vRBwqdePNCMiFzTxKI1V6YrlUHsjkXDnA5Ech27ZWbo9Lyau8tQ3OS';break;
  case 20:return 'sZblLvJdSh0uX5jMYQEia1WGH7e9K2pAxIC34BFwT6kVmrfqRoNnzPgDcOt8Uy';break;
  case 21:return 'uaPBvk0ZOezTQ2l5VXNqFMhCfRsdiAKtp9mboJ83jY1wIU74ycgEGSrDLW6nHx';break;
  case 22:return 'D9bXcP7TnmspoawxIdRAYW1KjVLMgHfF8UQtJESZrB2kizCyvhG543OuNq60le';break;
  case 23:return '95sEbjmeLrTJMV8W1B7SthHYzngpDK6QyZRCXckwiqf34xavOI2oF0dluNGAPU';break;
  case 24:return '9ksPOLzTV1pcZm7Jrj0qy3KGuoWwiMA2Q4ne5EYCXxhU8vRaSFBt6dgbIDfNHl';break;
  case 25:return 'bhdICgDBU18fMijNzAnorTPLHFVXS4J9Zw0xs6k7WlKRY3ycGmtpE2OvquQe5a';break;
  case 26:return '1qWSZAhmUbPVK2xne4IRgu836T0LiasEQCkYBM9Nlzt7cFdDfXGJpy5OwjvoHr';break;
  case 27:return 'AV25pLHStlXvuhkZPz8j6n9IDEdoQgqfNKs1GaWTUcBybeFYMxOJ4im073CrRw';break;
  case 28:return 'K1gserzpfYRoH3cMSOQabvJ687BnUhWGTA4xdjyEPtVNquLm2lZI95iCwFXkD0';break;
  case 29:return '07lmwAkJG2nWp5aeBCqLd1VyZP6XbQx9rUciTRjgozEDfvKtI8SNuhOHs3MFY4';break;
  case 30:return 'e45Fo9qcOgu6nmDMXLbAfZhIj1TH8aSzNkVw0P7lvdBYtJxpEyR3Wrs2CQKGUi';break;
  case 31:return 'f6t3HUrb9lWhpLnANed7B2yiFaJIYZKDRg4OS5uTEvkswXcVzmMqCPxGj0o81Q';break;
  case 32:return 'P3WKjosYrpUwGQlg9fZk6by1C0MquNzaIvxSDHEXFmB5Ae7VOR48chTLJtdin2';break;
  case 33:return '4lSsj93nKMFqXiBvh1QD5fZRmk2L6uNd7xCcI8gVGpAYbJz0aWEHtorUPyeOTw';break;
  case 34:return 'a4OpBJmdwfEPzMFAg0IV7W3ZbN9rSyLCRnUt8cHh15ejYus2qGv6xkTXDilQoK';break;
  case 35:return 'Cu4itzVQXxLeBS6IrlbYEKoUNRDM80FP29h3jfGOmancTwd7p1gHyWkvsJqZ5A';break;
  case 36:return 'x6rF7KoEf9N0klXQ4ynp1UPGh8Z5HaASMwiTBDjCdeLJcuVs2zvOIRmqgY3Wbt';break;
  case 37:return 'Y7PQSGXyFlUoNew6khCp4J2bWtj98ZsdgRDTu5M1z0ILOq3VifAmvcnEaxKHrB';break;
  case 38:return 'XsGCwuhZOpB4iSU7zDLMldm8yxQYTgn9WRrqIHbkV3J50oE2FePt1Aaf6jKcvN';break;
  case 39:return 'xFJqd8XAGioNjZ3CgOc7nfBvYKhE95RlHy6bT2zaISLrWmVkws0M1PDe4tUQpu';break;
  case 40:return '5QOqYCvDmGVPrnRXLaMcfBy9N32jhg0lwx1eb7dIskATUtoWpzZuKEHJ6SFi48';break;
  case 41:return '4tfqgzQ1sjkFPBRLxD3vhV26mZW5NUerc8KEwMy0oGadIinXpSHOCAbl97uTJY';break;
  case 42:return 'seE5xHMTPbhy86kAGBgtRvzjUdS4opDF2OunqriaC7mKJfN3l9WwLIZVY01QcX';break;
  case 43:return 'w70x4MnpsIugjzPLc6vKyohBCXF5JOmfVAtRdbqYHUEe1rD9l2kTZiGS8aQ3NW';break;
  case 44:return 'aYr0wVZBSztTWRy9D2NUXdk1KcPoAuejQFlH5IpgC6vJxEs83h74OfMibnGLqm';break;
  case 45:return 'LYK8WvfCe0AEIzJDtZ23uM5aRBUpGH6b9cyiQwPS4gNXoTskVj7Fm1xhrlOndq';break;
  case 46:return 'ubFykqltX5HGY0QWIE3KAi7PJj2xMgrBwcZ9T6eOdVp4CDvUhmRL8f1oSNzasn';break;
  case 47:return 'Zahs2SeP7bHwCV4x3AKXWFd8Tzyo0nR6qgQvcY5Nt1Mup9UkBlfJLmirIjODEG';break;
  case 48:return 'lwI8jAfPJauMi2g56HBcbQVUpWhLzOFq3yrNmSY7keKXZCdxERotTn4D109vGs';break;
  case 49:return 'k458m1UcxQ0S9yBJezd3WjfiYh6ba2grLMpwGIoPVtZuFvNHTAnqEl7RDCXsOK';break;
  case 50:return 'sXePvr0NtacElwjRnVzZQCTmULuqKd75Jg1GM8B6YyAIfpo2FhOx4b3HiWk9DS';break;
  case 51:return '628aKn5vGbmScjVgipDRChJ7A4fqHoX1PlTduNFLEIQYtsM39WUkBx0ZOwreyz';break;
  case 52:return 'kpqH6JjLbUaWMug8mt1BiITvxEhe9ncQNSlVY4O2sr5Pw7d3FKZRzDAX0GoyCf';break;
  case 53:return 'Q9eELo7JIt2rpbOya3WHAP10TKFhwRlckSfugn6vjXUdisBYxGq8CzNM5D4ZVm';break;
  case 54:return 'y5SJcbzqI9Cug2WXdYhsMkT0BrvURLDf7F1NtHma4oQxA3GEKnPplijw8OZe6V';break;
  case 55:return 'YaWwgcOfnvFXJBzymM5buVKhsGARPQ26k408jiIZDtlNSULqop9ETrd7ex1C3H';break;
  case 56:return 'fBgkFuOmx8A6c30aXSHWrNyKZGCT7qhtJIlpnbRswe2od9YQv4E5PiDjLMVU1z';break;
  case 57:return 'ndGKjU8IZ2O73F4AtWN0oRLm5B9VbfgvYHXCsQequyPxSMzaJhEclwirpT1kD6';break;
  case 58:return 'SCDPhcIj8OWfamu2q0YT5wtsUlBdikF4y9eNr3QnbZpLXoJgVE1zHRKx6vGM7A';break;
  case 59:return 'd6xGHzfnSOD7U5ksTpXF1IJ4cgKEe9Yrt32qaiQCPmhWywjMNblR80ABoLVvuZ';break;
  case 60:return 'C1MV2jHlzBtOQwa9hsfFUPNuxpJ6rZmen3oRGAYdi58yIK7SLbXvD0gWqc4EkT';break;
  default:return 'eIOqJHwaPD4hcVoUxWEMfi28Yk3tZ9KBluC1FARXsrv57QGpj6STm0ybdLzNgn';break;
  }
}

function ch($v,$k){
  $ada=false;
  $j=0;
  while(!$ada&&$j<62){
    $ada=$v==$k[$j];
    if(!$ada)$j++;
  }
  return $j;
}

function encr($v){
  $res='';
  $p=rand(0,61);
  $l=rand(0,61);
  $k=key_($l);
  for($i=0;$i<strlen($v);$i++){
    $j=ch($v[$i],$k);
    $j=($j+$p+$i)%62;
    $res.=$k[$j];
  }
  $res=$k[$p].$res;
  $k=get_char();
  return $k[$l].$res;
}

function decr($v){
  $k=get_char();
  $j=ch($v[0],$k);
  $k=key_($j);
  $p=ch($v[1],$k);
  $res='';
  for($i=2;$i<strlen($v);$i++){
    $j=ch($v[$i],$k);
    $j=($j-$p-$i+2+62)%62;
    $res.=$k[$j];
  }
  return $res;
}

function serial_number($id,$nama){
      if($id<10)$r='000000000'.$id;
  elseif($id<100)$r='00000000'.$id;
  elseif($id<1000)$r='0000000'.$id;
  elseif($id<10000)$r='000000'.$id;
  elseif($id<100000)$r='00000'.$id;
  elseif($id<1000000)$r='0000'.$id;
  elseif($id<10000000)$r='000'.$id;
  elseif($id<100000000)$r='00'.$id;
  elseif($id<1000000000)$r='0'.$id;
  else $r=$id;
  if(strlen($nama)<4){
    $r.=strlen($nama).$nama;
    for($i=strlen($r);$i<15;$i++)
      $r.='a';
  }else
    $r.='4'.substr($nama,0,4);
  return encr($r);
}
//echo serial_number(3,'dada');eAUPS5VpQlLTYuPy5//*/

function free_page($p404=false,$show=true){
    $dir=D_MODULES.D_DOMAIN.'/pengelola/webtools/';
    $fn=$dir.'pages/'.D_PAGE.'.html';
    if(file_exists($fn)){
        if($show)
            echo include_($dir,$fn);
        return true;
    }else{
        if($p404)
            echo p404();
        return false;
    }
}

}
?>