<?php
namespace Controllers;

require D_PLUGIN_PATH.'getok/load.php';
require D_PLUGIN_PATH.'markrogoyski/load.php';

//use App\Bursawolfs;
//use App\CoordinateSystem;
//use App\Datum;
//use App\Ellipsoids;
use App\Engines\Coordinate\Coordinate;
use App\Engines\Coordinate\Simple3D;
use App\Engines\DatumTransformation\BursaWolf;
use App\Engines\DatumTransformation\Molodensky;
use App\Engines\DatumTransformation\MolodenskyBadekas;
use App\Engines\ReferenceSystem\Ellipsoid;
//use App\MolodenskyBadekass;
//use App\Survey;
use App\Usecase\CoordinateFactory;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Storage;
//use App\Apps;
//use App\Transaction;
use App\Engines\MapProjection;
//use Session;
use App\Engines\Coordinate\Geodetic;
use App\Engines\Coordinate\Geocentric;
use App\Engines\Coordinate\Mercator;
use App\Engines\Coordinate\UTM;

class transformasiController extends Controller
{
    public function index(){
    	$data = Apps::find(1);
        $system = CoordinateSystem::all();
        $surveys = Survey::where(['is_calculated' => 1])->get();
        $surveyAmount = Survey::where(['is_calculated' => 1])->count();
        $ellipsoids = Ellipsoids::all();
    	return view('apps.transformasi', ['data' => $data, 'system' => $system, 'surveys' => $surveys, 'ellipsoids' => $ellipsoids, 'surveyAmount' => $surveyAmount]);
    }

    public function detailTitik(Request $request){
    	$system = $request->system;
    	return view('apps.ajax.detailTitik', ['system' => $system]);
    }

    public function convert(Request $request){
        $result = new Coordinate();
        $lon_init = ($request->lon_init == "") ? 0 : $request->lon_init;
        $prj = new MapProjection(CoordinateFactory::EllipsoidFactory($request->ellipsoid));
        $prj1 = new MapProjection(CoordinateFactory::EllipsoidFactory(Survey::find($request->survey)->oldDatum->id_ellipsoid));
        $prj2 = new MapProjection(CoordinateFactory::EllipsoidFactory(Survey::find($request->survey)->newDatum->id_ellipsoid));
        $gd = new Coordinate();
        switch ($request->system1) {
            case 1: // Geodetik
                $gd = new Geodetic($request->lat, $request->lon, $request->h, "xxx");
                if($request->config == 1){
                    $result = $this->calculate($request->system2, $gd, $lon_init, $prj, $request->config, $request->survey, $request->transformationMethod);
                }else{
                    $result = $this->calculate($request->system2, $gd, $lon_init, $prj1, $request->config, $request->survey, $request->transformationMethod);
                }

                break;

            case 2: // Geosentrik
                $gs = new Geocentric($request->X, $request->Y, $request->Z, "xxx");
                if($request->config == 1){
                    $gd = $prj->gs2gd($gs);
                    $result = $this->calculate($request->system2, $gd, $lon_init, $prj, $request->config, $request->survey, $request->transformationMethod);
                }else{
                    $gd = $prj1->gs2gd($gs);
                    $result = $this->calculate($request->system2, $gd, $lon_init, $prj1, $request->config, $request->survey, $request->transformationMethod);
                }

                break;

            case 3: // UTM
                $utm = new UTM($request->x, $request->y, $request->h, $request->zone, $request->hemi, "xxx");
                if($request->config == 1){
                    $gd = $prj->utm2gd($utm);
                    $result = $this->calculate($request->system2, $gd, $lon_init, $prj, $request->config, $request->survey, $request->transformationMethod);
                }else{
                    $gd = $prj1->utm2gd($utm);
                    $result = $this->calculate($request->system2, $gd, $lon_init, $prj1, $request->config, $request->survey, $request->transformationMethod);
                }

                break;

            case 4:
                $merc = new Mercator($request->x, $request->y, $request->h, $request->lon_init, "xxx");
                if($request->config == 1){
                    $gd = $prj->merc2gd($merc);
                    $result = $this->calculate($request->system2, $gd, $lon_init, $prj, $request->config, $request->survey, $request->transformationMethod);
                }else{
                    $gd = $prj1->merc2gd($merc);
                    $result = $this->calculate($request->system2, $gd, $lon_init, $prj1, $request->config, $request->survey, $request->transformationMethod);
                }

                break;
        }
        return response()->json(['result' => $result->toJsonObject(), 'gd' => $gd->toJsonObject()]);
    }

    /**
     * @param int $system2
     * @param Geodetic $gd
     * @param float $lon_init
     * @param MapProjection $prj
     * @return Coordinate
     */
    private function calculate(int $system2, Geodetic $gd, float $lon_init, MapProjection $prj, int $config, int $idSurvey, int $transformatinMethod): Coordinate{
        $result = new Coordinate();
        $gdTransform = $this->transform($gd, $prj, $idSurvey, $transformatinMethod);
        switch ($system2){
            case 1: // geodetic
                if($config == 1){
                    $result = $gd;
                }else{
                    $result = $gdTransform;
                }
                break;
            case 2: // geocentric
                if($config == 1){
                    $result = $prj->gd2gs($gd);
                }else{
                    $result = $prj->gd2gs($gdTransform);
                }
                break;
            case 3:
                if($config == 1){
                    $result = $prj->gd2utm($gd);
                }else{
                    $result = $prj->gd2utm($gdTransform);
                }
                break;
            case 4:
                if($config == 1){
                    $result = $prj->gd2merc($gd, $lon_init);
                }else{
                    $result = $prj->gd2merc($gdTransform, $lon_init);
                }
                break;
        }
        return $result;
    }

    private function transform(Geodetic $gd, MapProjection $prj,  int $idSurvey, int $transformationMethod): Geodetic{
        $xyz = [$prj->gd2gs($gd)];
        $ll1 = CoordinateFactory::EllipsoidFactory(Survey::find($idSurvey)->oldDatum->id_ellipsoid);
        $ll2 = CoordinateFactory::EllipsoidFactory(Survey::find($idSurvey)->newDatum->id_ellipsoid);
        $bf = Bursawolfs::where(['id_survey' => $idSurvey])->first();
        switch ($transformationMethod){
            case 1: // Bursawolf
                $params = BursaWolf::builder()
                    ->dx($bf->dx)
                    ->dy($bf->dy)
                    ->dz($bf->dz)
                    ->εx($bf->ex)
                    ->εy($bf->ey)
                    ->εz($bf->ez)
                    ->ds($bf->ds)
                    ->build();
                $result = BursaWolf::Inverse($xyz, $params)->get();
                $gdResult = $prj->gs2gd($result[0]);
                break;
            case 2: // Molodensky Badekas
                $molobas = MolodenskyBadekass::where(['id_survey' => $idSurvey])->first();
                $centroid = new Simple3D($molobas->x_centroid, $molobas->y_centroid, $molobas->z_centroid);
                $params = MolodenskyBadekas::builder()
                    ->dx($molobas->dx)
                    ->dy($molobas->dy)
                    ->dz($molobas->dz)
                    ->εx($molobas->ex)
                    ->εy($molobas->ey)
                    ->εz($molobas->ez)
                    ->ds($molobas->ds)
                    ->centroidType("ARITHMETIC")
                    ->centroid($centroid)
                    ->build();
                $result = MolodenskyBadekas::Inverse($xyz, $params)->get();
                $gdResult = $prj->gs2gd($result[0]);
                break;
            case 3: // Standard Molodensky
                $gdResult = Molodensky::Standard($gd, new Simple3D($bf->dx, $bf->dy, $bf->dz), $ll1, $ll2);
                break;
            case 4: // Abridge Molodensky
                $gdResult = Molodensky::Abridge($gd, new Simple3D($bf->dx, $bf->dy, $bf->dz), $ll1, $ll2);
                break;
            case 5: // LAUF
                $gdResult = $gd;
                break;
        }
        return $gdResult;
    }

    public function detailFile(Request $request){
        $sys_in = $request->sys_in;
        $sys_out = $request->sys_out;

        return view('apps.ajax.detailFile', ['sys_in' => $sys_in, 'sys_out' => $sys_out]);
    }

    public function banyakTitik(){
        $data = Apps::find(1);
        $system = CoordinateSystem::all();
        $datum = Datum::all();
        return view('apps.transformasi_banyak_titik', ['data' => $data, 'system' => $system, 'datum' => $datum]);
    }

    public function exeTrans(Request $request){
        // simpan file
        $uploadFile = $request->file('file');
        $path = $uploadFile->store('public/transformasi');

        if(Transaction::max('id_transaction') == NULL){
            $id = 1;
        }else{
            $id = Transaction::max('id_transaction') + 1;
        }
        $d = new Transaction();
        $d->id_transaction = $id;
        $d->id_app = 1;
        $d->is_active = 1;
        $d->file = $path;
        $d->is_finished = 0;
        $d->save();

        // reading lines
        $amount = $request->lines;

        $file = Storage::url(Transaction::find($id)->file);
        Session::flash('sys_in', $request->sys_in);
        Session::flash('sys_out', $request->sys_out);
        Session::flash('structure', $request->structure);
        Session::flash('delimiter', $request->delimiter);
        Session::flash('hemi', $request->hemi);
        Session::flash('zone', $request->zone);
        Session::flash('init', true);
        Session::flash('prog', 'Reading data...');
        Session::flash('bar', 0);
        Session::flash('id_transaction', $id);
        Session::flash('lines', $amount);
        Session::flash('file', $file);
        Session::flash('lon_init', $request->lon_init);
        Session::flash('id_datum', $request->datum);
        return redirect()->back();
    }

    public function calcTrans(Request $request){
        // Reading data
        $read = fopen("../storage/app/".Transaction::find($request->id_transaction)->file, "r");

        if($request->awal == 1){
            $write = fopen("../storage/app/public/convert_result/id_".$request->id_transaction.".txt", "w");
            $header =  "=========================================================================================\n";
            $header .= "                                  TRANFORMASI KOORDINAT                                  \n";
            $header .= "=========================================================================================\n\n";
            $header .= "Datum\t\t: ".Datum::find($request->id_datum)->datum_name."\n";
            $header .= "Satuan\t\t: Meter\n";
            $header .= "Sistem koordinat awal\t: ";
            if($request->sys_in == 1){
                $header .= "Geodetik (lat, lon, h)\n";
            }elseif($request->sys_in == 2){
                $header .= "Geosentrik (X, Y, Z)\n";
            }elseif($request->sys_in == 3){
                $header .= "UTM (easting, northing)\n";
            }else{
                $header .= "Mercator (easting, northing)\n";
                $header .= "Meridian Central\t: ".$request->lon_init."\n";
            }
            $header .= "Sistem koordinat baru\t: ";
            if($request->sys_out == 1){
                $header .= "Geodetik (lat, lon, h)\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
                $header .= " ID \t\t lat \t\t lon \t\t\t h\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
            }elseif($request->sys_out == 2){
                $header .= "Geosentrik (X, Y, Z)\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
                $header .= " ID \t\t\t X \t\t\t Y \t\t\t Z\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
            }elseif($request->sys_out == 3){
                $header .= "UTM (easting, northing)\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
                $header .= " ID \t\t easting \t\t northing \t\t h \t\t zone\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
            }else{
                $header .= "Mercator (easting, northing)\n";
                $header .= "Meridian Central\t: ".$request->lon_init."\n";
                $header .= "-----------------------------------------------------------------------------------------\n";
                $header .= " ID \t\t easting \t\t northing \t\t h \n";
                $header .= "-----------------------------------------------------------------------------------------\n";
            }
            fwrite($write, $header);
            fclose($write);
        }

        $write = fopen("../storage/app/public/convert_result/id_".$request->id_transaction.".txt", "a");

        // transformation and create new file;
        $b = 1;

        // Get datum properties
        $epParams = Datum::find($request->id_datum)->ellipsoid;
        $ellipsoid = new Ellipsoid($epParams->id_ellipsoid, $epParams->a, $epParams->b,
            $epParams->f, $epParams->ellipsoid_name, $epParams->year);
        $prj = new MapProjection($ellipsoid);

        while($b < $request->akhir) {
            if($b>=$request->awal){
                $line = fgets($read);
                if($request->delimiter == 1){
                    $val = preg_split("/\s+/", $line);
                }elseif($request->delimiter == 2){
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
                        switch ($request->structure) {
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
                                $utm = new UTM($val[$c + 1], $val[$c + 2], $val[$c + 3], $request->zone, $request->hemi, $val[$c]);
                                $gd = $prj->utm2gd($utm);
                                break;

                            case 6: // UTM: id northing easting h
                                $utm = new UTM($val[$c + 2], $val[$c + 1], $val[$c + 3], $request->zone, $request->hemi, $val[$c]);
                                $gd = $prj->utm2gd($utm);
                                break;

                            case 7: // Mercator: id easting northing
                                $merc = new Mercator($val[$c + 1], $val[$c + 2], $val[$c + 3], $request->lon_init, $val[$c]);
                                $gd = $prj->merc2gd($merc);
                                break;

                            case 8: // Mercator: id northing easting
                                $merc = new Mercator($val[$c + 2], $val[$c + 1], $val[$c + 3], $request->lon_init, $val[$c]);
                                $gd = $prj->merc2gd($merc);
                                break;

                        }
                        switch ($request->sys_out) {
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
                                $json = $prj->gd2merc($gd, $request->lon_init)->toJsonObject();
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
        return response()->json(['prog' => "Processing transformation...", 'bar' => (int)((($b)/$request->lines)*100)]);
    }
}
