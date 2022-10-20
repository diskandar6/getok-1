<?php
use App\Engines\GeoClass;

function calcGoid(){
    //$db=$GLOBALS['dbg'];
    // Reading data
    $read = fopen($_SESSION['dirname'].$_SESSION['filename'], "r");
    $dir=$_SESSION['resgeoid'];
    if($_GET['awal'] == 1){
        $write = fopen($dir, "w");
        $header =  "=========================================================================================\n";
        $header .= "                                 GEOID UNDULATION VALUES                                 \n";
        $header .= "=========================================================================================\n\n";
        $header .= "Datum\t\t: WGS84\n";
        $header .= "-----------------------------------------------------------------------------------------\n";
        $header .= " ID \t\t lat \t\t lon \t\t\t N (meter)\n";
        $header .= "-----------------------------------------------------------------------------------------\n";
        fwrite($write, $header);
        fclose($write);
    }

        $write = fopen($dir, "a");

        // transformation and create new file;
        $c = 1; $b = 1;

        while($b < $_GET['akhir']) {
            if($b>=$_GET['awal']){
                $line = fgets($read);
                if($_GET['delimiter'] == 1){
                    $val = preg_split("/\s+/", $line);
                }elseif($_GET['delimiter'] == 2){
                    $val = explode(",", preg_split('/\s+/', $line)[0]);
                }else{
                    $val = explode(";", preg_split('/\s+/', $line)[0]);
                }
                if(sizeof($val) >= 3){
                    if(is_numeric($val[0])){
                        if($_GET['format'] == 1){ // id lat lon
                            $N = GeoClass::Bilinear($val[1], $val[2]);
                            fwrite($write, " ".$val[0]."\t\t".$val[1]."\t\t".$val[2]."\t\t".$N."\n");
                        }elseif($_GET['format'] == 2){ // id lon lat
                            $N = GeoClass::Bilinear($val[2], $val[1]);
                            fwrite($write, " ".$val[0]."\t\t".$val[2]."\t\t".$val[1]."\t\t".$N."\n");
                        }elseif($_GET['format'] == 3){ // lat lon
                            $N = GeoClass::Bilinear($val[0], $val[1]);
                            fwrite($write, " ".$c."\t\t".$val[0]."\t\t".$val[1]."\t\t".$N."\n");
                            $c += 1;
                        }else{ // lon lat
                            $N = GeoClass::Bilinear($val[1], $val[0]);
                            fwrite($write, " ".$c."\t\t".$val[1]."\t\t".$val[0]."\t\t".$N."\n");
                            $c += 1;
                        }
                    }
                    $b += 1;
                }else{
                    $b += 1;
                }
            }else{
                fgets($read);
                $b += 1;
            }
        }

        fclose($write);

        fclose($read);
        echo json_encode(array('prog' => "Processing geoid...", 'bar' => (int)((($b)/$_GET['lines'])*100)));
}

if(isset($_GET['download'])){
    download_hasil_geoid();
}elseif(isset($_GET['awal'])){
    calcGoid();
}else{
    $lon=(float)$_GET['lon'];
    if($lon-floor($lon)==0)$_GET['lon']+=1e-9;
    $N = GeoClass::Bilinear($_GET['lat'], $_GET['lon']);
    echo json_encode(array('N'=>$N));
}
?>