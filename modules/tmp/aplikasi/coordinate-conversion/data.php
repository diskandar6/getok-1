<?php
use App\Engines\ReferenceSystem\Ellipsoid;
use App\Engines\MapProjection;
use App\Engines\Coordinate\Geocentric;
use App\Engines\Coordinate\Geodetic;

    function calcTrans(){
        $db=$GLOBALS['dbg'];
        // Reading data
        $read = fopen($_SESSION['dirname'].$_SESSION['filename'], "r");

        $dir=$_SESSION['restrf'];

        if($_GET['awal'] == 1){

            $write = fopen($dir, "w");
            $header =  "=========================================================================================\n";
            $header .= "                                  TRANFORMASI KOORDINAT                                  \n";
            $header .= "=========================================================================================\n\n";
            $header .= "Datum\t\t: ".dbfindi($db,'datums',array('id_datum'=>1))->datum_name."\n";
            $header .= "Satuan\t\t: Meter\n";
            $header .= "Sistem koordinat awal\t: ";
            if($_GET['sys_in'] == 1){
                $header .= "Geodetik (lat, lon, h)\n";
            }elseif($_GET['sys_in'] == 2){
                $header .= "Geosentrik (X, Y, Z)\n";
            }elseif($_GET['sys_in'] == 3){
                $header .= "UTM (easting, northing)\n";
            }else{
                $header .= "Mercator (easting, northing)\n";
                $header .= "Meridian Central\t: ".$_GET['lon_init']."\n";
            }
            $header .= "Sistem koordinat baru\t: ";
            if($_GET['sys_out'] == 1){
                $header .= "Geodetik (lat, lon, h)\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
                $header .= " ID \t\t lat \t\t lon \t\t\t h\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
            }elseif($_GET['sys_out'] == 2){
                $header .= "Geosentrik (X, Y, Z)\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
                $header .= " ID \t\t\t X \t\t\t Y \t\t\t Z\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
            }elseif($_GET['sys_out'] == 3){
                $header .= "UTM (easting, northing)\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
                $header .= " ID \t\t easting \t\t northing \t\t h \t\t zone\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
            }else{
                $header .= "Mercator (easting, northing)\n";
                $header .= "Meridian Central\t: ".$_GET['lon_init']."\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
                $header .= " ID \t\t easting \t\t northing \t\t h \n";
                $header .= "-----------------------------------------------------------------------------------------\n";
            }
            fwrite($write, $header);
            fclose($write);
        }

        $write = fopen($dir, "a");

        // transformation and create new file;
        $b = 1;

        // Get datum properties
        //$epParams = Datum::find($_GET['id_datum)->ellipsoid;
        $epParams=$db->get_row("SELECT a.* FROM ellipsoids AS a JOIN datums AS b ON a.id_ellipsoid=b.id_ellipsoid WHERE b.id_datum=".$_GET['id_datum']);//dbfind($db,'ellipsoids',array('id_datum'=>$_GET['id_datum']));
        $ellipsoid = new Ellipsoid($epParams->id_ellipsoid, $epParams->a, $epParams->b,
            $epParams->f, $epParams->ellipsoid_name, $epParams->year);
        $prj = new MapProjection($ellipsoid);

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
                    $nulltest = true; $c = 0;
                    while($nulltest == true){
                        if($val[$c] == null){
                            $c += 1;
                        }else{
                            $nulltest = false;
                        }
                    }
                    if(is_numeric($val[$c+1]) && is_numeric($val[$c+2])) {
                        if(isset($val[$c+3])){
                            $val[$c+3] = (is_numeric($val[$c+3])) ? $val[$c+3] : 0;
                        } else {
                            $val[$c+3] = 0;
                        }
                        switch ($_GET['structure']) {
                            case 1: // id lat lon h
                                $gd = new Geodetic($val[$c + 1], $val[$c + 2], $val[$c+3], $val[$c]);
                                break;

                            case 2: // id lon lat h
                                $gd = new Geodetic($val[$c + 2], $val[$c + 1], $val[$c+3], $val[$c]);
                                break;

                            case 3: // id X Y Z
                                $gs = new Geocentric($val[$c + 1], $val[$c + 2], $val[$c + 3], $val[$c]);
                                $gd = $prj->gs2gd($gs);
                                break;

                            case 4: // id Y X Z
                                $gs = new Geocentric($val[$c + 2], $val[$c + 1], $val[$c + 3], $val[$c]);
                                $gd = $prj->gs2gd($gs);
                                break;

                            case 5: // UTM: id easting northing h
                                $utm = new UTM($val[$c + 1], $val[$c + 2], $val[$c + 3], $_GET['zone'], $_GET['hemi'], $val[$c]);
                                $gd = $prj->utm2gd($utm);
                                break;

                            case 6: // UTM: id northing easting h
                                $utm = new UTM($val[$c + 2], $val[$c + 1], $val[$c + 3], $_GET['zone'], $_GET['hemi'], $val[$c]);
                                $gd = $prj->utm2gd($utm);
                                break;

                            case 7: // Mercator: id easting northing
                                $merc = new Mercator($val[$c + 1], $val[$c + 2], $val[$c + 3], $_GET['lon_init'], $val[$c]);
                                $gd = $prj->merc2gd($merc);
                                break;

                            case 8: // Mercator: id northing easting
                                $merc = new Mercator($val[$c + 2], $val[$c + 1], $val[$c + 3], $_GET['lon_init'], $val[$c]);
                                $gd = $prj->merc2gd($merc);
                                break;

                        }
                        switch ($_GET['sys_out']) {
                            case 1: // Geodetik
                                $json = $gd->toJsonObject();
                                $lat = ($json->lat >= 0 ) ? " ".$json->lat : $json->lat;
                                $lon = ($json->lon > 0 ) ? " ".$json->lon : $json->lon;
                                $h = ($json->h > 0 ) ? " ".$json->h : $json->h;
                                fwrite($write, " " . $json->id . "\t\t" . $lat . "\t\t" . $lon . "\t\t" . $h . "\n");
                                $b += 1;
                                break;

                            case 2: // Geosentrik
                                $json = $prj->gd2gs($gd)->toJsonObject();
                                $X = ($json->X > 0 ) ? " ".$json->X : $json->X;
                                $Y = ($json->Y > 0 ) ? " ".$json->Y : $json->Y;
                                $Z = ($json->Z > 0 ) ? " ".$json->Z : $json->Z;
                                fwrite($write, " " . $json->id . "\t\t" . $X . "\t\t" . $Y . "\t\t" . $Z . "\n");
                                $b += 1;
                                break;

                            case 3: // UTM
                                $json = $prj->gd2utm($gd)->toJsonObject();
                                $x = ($json->x > 0 ) ? " ".$json->x : $json->x;
                                $y = ($json->y > 0 ) ? " ".$json->y : $json->y;
                                $z = ($json->h > 0 ) ? " ".$json->h : $json->h;
                                fwrite($write, " " . $json->id . "\t\t" . $x . "\t\t" . $y . "\t\t" . $z . "\t\t" . $json->zone . $json->hemi . "\n");
                                $b += 1;
                                break;

                            case 4: // Mercator
                                $json = $prj->gd2merc($gd, $_GET['lon_init'])->toJsonObject();
                                $x = ($json->x > 0 ) ? " ".$json->x : $json->x;
                                $y = ($json->y > 0 ) ? " ".$json->y : $json->y;
                                $z = ($json->h > 0 ) ? " ".$json->h : $json->h;
                                fwrite($write, " " . $json->id . "\t\t" . $x . "\t\t" . $y . "\t\t" . $z . "\n");
                                break;
                        }
                    }
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
        echo json_encode(array('prog' => "Processing transformation...", 'bar' => (int)((($b)/$_GET['lines'])*100)));
    }

if(isset($_GET['download'])){
    download_hasil_transformasi();
}elseif(isset($_GET['id_datum'])){
    calcTrans();
}elseif(isset($_GET['sys_in'])){
    echo get_form_trf_banyaktitik($_GET['sys_in'],$_GET['sys_out']);
}elseif(isset($_GET['upload'])){
    $dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
    $dir.='transformasi/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
    $_SESSION['uploads']=$dir;
    $_SESSION['filename-uploaded']=date('YmdHis');
    echo 'ok';
}
?>