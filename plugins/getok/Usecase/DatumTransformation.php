<?php

namespace App\Usecase;

//use App\Bursawolfs;
//use App\Ellipsoids;
use App\Engines\Coordinate\Geocentric;
use App\Engines\Coordinate\Geodetic;
use App\Engines\Coordinate\Mercator;
use App\Engines\Coordinate\UTM;
use App\Engines\DatumTransformation\BursaWolf;
use App\Engines\DatumTransformation\MolodenskyBadekas;
use App\Engines\MapProjection;
use App\Engines\ReferenceSystem\Ellipsoid;
//use App\MolodenskyBadekass;
use App\Survey;
use App\SurveyPoint;
//*/

class DatumTransformation {

    public static function ReadDataPoints(int $idSurvey, int $idSys, int $structure, string $delimiter, string $hemi = null, int $zone = null, float $meridianCentral = null): bool {
        $db=$GLOBALS['dbg'];
        
        //$s = Survey::find($idSurvey);
        $s=$db->get_row("SELECT * FROM surveys datums WHERE id_survey=$idSurvey");

        $read = fopen(/*"../storage/app/".*/$s->file, "r");

        //$el1 = Ellipsoids::find($s->oldDatum->id_ellipsoid);
        //$el2 = Ellipsoids::find($s->newDatum->id_ellipsoid);
        $el1=$db->get_row("SELECT b.* FROM datums AS a JOIN ellipsoids AS b ON a.id_ellipsoid=b.id_ellipsoid WHERE a.id_datum=$s->id_old_datum");
        $el2=$db->get_row("SELECT b.* FROM datums AS a JOIN ellipsoids AS b ON a.id_ellipsoid=b.id_ellipsoid WHERE a.id_datum=$s->id_new_datum");

        $ellipsoid1 = Ellipsoid::builder()
                        ->idEllipsoid($el1->id_ellipsoid)
                        ->a($el1->a)
                        ->b($el1->b)
                        ->f($el1->f)
                        ->ellipsoidName($el1->ellipsoid_name)
                        ->year($el1->year)
                        ->build();

        $ellipsoid2 = Ellipsoid::builder()
                        ->idEllipsoid($el2->id_ellipsoid)
                        ->a($el2->a)
                        ->b($el2->b)
                        ->f($el2->f)
                        ->ellipsoidName($el2->ellipsoid_name)
                        ->year($el2->year)
                        ->build();

        $prj1 = new MapProjection($ellipsoid1);
        $prj2 = new MapProjection($ellipsoid2);

        $geocentric1 = []; $geocentric2 = []; $std1 = null; $std2 = null; $counter = 0;
        while (!feof($read)){
            $line = fgets($read);

            if($delimiter == 1){
                $val = preg_split("/\s+/", $line);
            }elseif($delimiter == 2){
                $val = explode(",", preg_split('/\s+/', $line)[0]);
            }else{
                $val = explode(";", preg_split('/\s+/', $line)[0]);
            }

            if(sizeof($val) >= 6) {
                $nulltest = true;
                $c = 0;
                while ($nulltest == true) {
                    if ($val[$c] == null) {
                        $c += 1;
                    } else {
                        $nulltest = false;
                    }
                }
                if(is_numeric($val[$c+1]) && is_numeric($val[$c+2]) && is_numeric($val[$c+3]) &&
                    is_numeric($val[$c+4]) && is_numeric($val[$c+5]) && is_numeric($val[$c+4]) ){
                    switch ($structure){
                        case 1: // geodetic
                            $geocentric1[$counter] = $prj1->gd2gs(new Geodetic($val[$c+1], $val[$c+2], $val[$c+3], $val[$c]));
                            $geocentric2[$counter] = $prj2->gd2gs(new Geodetic($val[$c+4], $val[$c+5], $val[$c+6], $val[$c]));
                            $counter += 1;
                            break;
                        case 2: // geodetic with std
                            $geocentric1[$counter] = $prj1->gd2gs(new Geodetic($val[$c+2], $val[$c+1], $val[$c+3], $val[$c]));
                            $geocentric2[$counter] = $prj2->gd2gs(new Geodetic($val[$c+5], $val[$c+4], $val[$c+6], $val[$c]));
                            $counter += 1;
                            break;
                        case 3: // geocentric
                            $geocentric1[$counter] = new Geocentric($val[$c+1], $val[$c+2], $val[$c+3], $val[$c]);
                            $geocentric2[$counter] = new Geocentric($val[$c+4], $val[$c+5], $val[$c+6], $val[$c]);
                            $counter += 1;
                            break;
                        case 4: // geocentric with std
                            $geocentric1[$counter] = new Geocentric($val[$c+1], $val[$c+3], $val[$c+5], $val[$c]);
                            $std1[$counter] = new Geocentric($val[$c+2], $val[$c+4], $val[$c+6], $val[$c]);
                            $geocentric2[$counter] = new Geocentric($val[$c+7], $val[$c+9], $val[$c+11], $val[$c]);
                            $std2[$counter] = new Geocentric($val[$c+8], $val[$c+10], $val[$c+12], $val[$c]);
                            $counter += 1;
                            break;
                        case 5: // projection
                            if ($idSys == 3){ // UTM
                                $gd1 = $prj1->utm2gd(new UTM($val[$c+1], $val[$c+2], $val[$c+3], $zone, $hemi, $val[$c]));
                                $gd2 = $prj2->utm2gd(new UTM($val[$c+4], $val[$c+5], $val[$c+6], $zone, $hemi, $val[$c]));
                            }else{ // mercator
                                $gd1 = $prj1->utm2gd(new UTM($val[$c+2], $val[$c+1], $val[$c+3], $zone, $hemi, $val[$c]));
                                $gd2 = $prj2->utm2gd(new UTM($val[$c+5], $val[$c+4], $val[$c+6], $zone, $hemi, $val[$c]));
                            }
                            $geocentric1[$counter] = $prj1->gd2gs($gd1);
                            $geocentric2[$counter] = $prj2->gd2gs($gd2);
                            $counter += 1;
                            break;
                        case 6:
                            if ($idSys == 3){ // UTM
                                $gd1 = $prj1->merc2gd(new Mercator($val[$c+1], $val[$c+2], $val[$c+3], $meridianCentral, $val[$c]));
                                $gd2 = $prj2->merc2gd(new Mercator($val[$c+4], $val[$c+5], $val[$c+6], $meridianCentral, $val[$c]));
                            }else{ // mercator
                                $gd1 = $prj1->merc2gd(new Mercator($val[$c+2], $val[$c+1], $val[$c+3], $meridianCentral, $val[$c]));
                                $gd2 = $prj2->merc2gd(new Mercator($val[$c+5], $val[$c+4], $val[$c+6], $meridianCentral, $val[$c]));
                            }
                            $geocentric1[$counter] = $prj1->gd2gs($gd1);
                            $geocentric2[$counter] = $prj2->gd2gs($gd2);
                            $counter += 1;
                            break;
                    }
                }
            }
        }

        if($counter >= 3){
            //SurveyPoint::where(["id_survey" => $idSurvey])->delete();
            $db->delete('survey_points',array('id_survey'=>$idSurvey),array('%d'));
            for ($i=0;$i<$counter;$i++){
                $d = json_decode('{}');//new SurveyPoint();
                $d->id_survey = $idSurvey;
                $d->point_name = $geocentric1[$i]->getId();
                $d->X1 = $geocentric1[$i]->getX();
                $d->Y1 = $geocentric1[$i]->getY();
                $d->Z1 = $geocentric1[$i]->getZ();
                $d->X2 = $geocentric2[$i]->getX();
                $d->Y2 = $geocentric2[$i]->getY();
                $d->Z2 = $geocentric2[$i]->getZ();
                if($structure == 2 || $structure == 4 || $structure == 6){
                    $d->dX1 = $std1[$i]->getX();
                    $d->dY1 = $std1[$i]->getY();
                    $d->dZ1 = $std1[$i]->getZ();
                    $d->dX2 = $std2[$i]->getX();
                    $d->dY2 = $std2[$i]->getY();
                    $d->dZ3 = $std2[$i]->getZ();
                }
                //$d->save();
                $d->created_at=date('Y-m-d H:i:s');
                $d->updated_at=date('Y-m-d H:i:s');

                $db->insert('survey_points',(array)$d);
            }
            return true;
        }else{
            return false;
        }
    }

    public static function calculateBursaWolf(int $idSurvey): void{
        //Bursawolfs::where(['id_survey' => $idSurvey])->delete();
        $db=$GLOBALS['dbg'];
        $db->delete('bursawolf',array('id_survey'=>$idSurvey),array('%d'));
        
        $xyz1 = []; $xyz2 = []; $dxyz1 = []; $dxyz2 = []; $c = 0;
        //$points = SurveyPoint::where(['id_survey' => $idSurvey, 'is_used' => 1])->get();
        $points=$db->get_results("SELECT * FROM survey_points WHERE id_survey=$idSurvey AND is_used=1");
        
        //if(SurveyPoint::where(['id_survey'=>$idSurvey])->first()->dX1 == null){
        if($points[0]->dX1 == null){
            foreach ($points as $p) {
                $xyz1[$c] = new Geocentric($p->X1, $p->Y1, $p->Z1, $p->id_point);
                $xyz2[$c] = new Geocentric($p->X2, $p->Y2, $p->Z2, $p->id_point);
                $c += 1;
            }
            $direct = BursaWolf::Direct($xyz1, $xyz2)->combined();

        }else{
            foreach ($points as $p) {
                $xyz1[$c] = new Geocentric($p->X1, $p->Y1, $p->Z1, $p->id_point);
                $xyz2[$c] = new Geocentric($p->X2, $p->Y2, $p->Z2, $p->id_point);
                $dxyz1[$c] = new Geocentric($p->dX1, $p->dY1, $p->dZ1, $p->id_point);
                $dxyz2[$c] = new Geocentric($p->dX2, $p->dY2, $p->dZ2, $p->id_point);
                $c += 1;
            }
            $direct = BursaWolf::Direct($xyz1, $xyz2, $dxyz1, $dxyz2)->combined();
        }

        $order = 0;
        foreach ($points as $p) {
            //$dat = SurveyPoint::find($p->id_point);
            if($direct->getTest()[$order] == 0){
                //$dat->bursawolf_passing_status = 2;
                $db->update('survey_points',array('bursawolf_passing_status'=>2),array('id_point'=>$p->id_point),array('%d'),array('%d'));
            }else{
                //$dat->bursawolf_passing_Status = 1;
                $db->update('survey_points',array('bursawolf_passing_status'=>1),array('id_point'=>$p->id_point),array('%d'),array('%d'));
            }
            //$dat->save();
            $order += 1;
        }

        $b = json_decode('{}');//new Bursawolfs();
        $b->id_survey = $idSurvey;
        $b->dx = $direct->getDx();
        $b->dx_uncertainty = $direct->getRdx();
        $b->dy = $direct->getDy();
        $b->dy_uncertainty = $direct->getRdy();
        $b->dz = $direct->getDz();
        $b->dz_uncertainty = $direct->getRdz();
        $b->ex = $direct->getΕx();
        $b->ex_uncertainty = $direct->getRεx();
        $b->ey = $direct->getΕy();
        $b->ey_uncertainty = $direct->getRεy();
        $b->ez = $direct->getΕz();
        $b->ez_uncertainty = $direct->getRεz();
        $b->ds = $direct->getDs();
        $b->ds_uncertainty = $direct->getRds();
        //$b->save();
        $db->insert('bursawolf',(array)$b);
    }

    public static function calculateMolodenskyBadekas(int $idSurvey): void{
        //MolodenskyBadekass::where(['id_survey' => $idSurvey]);
        $db=$GLOBALS['dbg'];
        $db->delete('molodensky_badekas',array('id_survey'=>$idSurvey),array('%d'));

        $xyz1 = []; $xyz2 = []; $dxyz1 = []; $dxyz2 = []; $c = 0;
        //$points = SurveyPoint::where(['id_survey' => $idSurvey, 'is_used' => 1])->get();
        $points = $db->get_results("SELECT * FROM survey_points WHERE id_survey=$idSurvey AND is_used=1");
        
        //if(SurveyPoint::where(['id_survey'=>$idSurvey])->first()->dX1 == null){
        if($points[0]->dX1 == null){
            foreach ($points as $p) {
                $xyz1[$c] = new Geocentric($p->X1, $p->Y1, $p->Z1, $p->id_point);
                $xyz2[$c] = new Geocentric($p->X2, $p->Y2, $p->Z2, $p->id_point);
                $c += 1;
            }
            $direct = MolodenskyBadekas::Direct($xyz1, $xyz2, "ARITHMETIC")->combined();

        }else{
            foreach ($points as $p) {
                $xyz1[$c] = new Geocentric($p->X1, $p->Y1, $p->Z1, $p->id_point);
                $xyz2[$c] = new Geocentric($p->X2, $p->Y2, $p->Z2, $p->id_point);
                $dxyz1[$c] = new Geocentric($p->dX1, $p->dY1, $p->dZ1, $p->id_point);
                $dxyz2[$c] = new Geocentric($p->dX2, $p->dY2, $p->dZ2, $p->id_point);
                $c += 1;
            }
            $direct = MolodenskyBadekas::Direct($xyz1, $xyz2, "ARITHMETIC", null, $dxyz1, $dxyz2)->combined();
        }

        $order = 0;
        foreach ($points as $p) {
            //$dat = SurveyPoint::find($p->id_point);
            if($direct->getTest()[$order] == 0){
                //$dat->molobas_passing_status = 2;
                $db->update('survey_points',array('molobas_passing_status'=>2),array('id_point'=>$p->id_point),array('%d'),array('%d'));
            }else{
                //$dat->molobas_passing_Status = 1;
                $db->update('survey_points',array('molobas_passing_status'=>1),array('id_point'=>$p->id_point),array('%d'),array('%d'));
            }
            //$dat->save();
            $order += 1;
        }

        $b = json_decode('{}');//new MolodenskyBadekass();
        $b->id_survey = $idSurvey;
        $b->dx = $direct->getDx();
        $b->dx_uncertainty = $direct->getRdx();
        $b->dy = $direct->getDy();
        $b->dy_uncertainty = $direct->getRdy();
        $b->dz = $direct->getDz();
        $b->dz_uncertainty = $direct->getRdz();
        $b->ex = $direct->getΕx();
        $b->ex_uncertainty = $direct->getRεx();
        $b->ey = $direct->getΕy();
        $b->ey_uncertainty = $direct->getRεy();
        $b->ez = $direct->getΕz();
        $b->ez_uncertainty = $direct->getRεz();
        $b->ds = $direct->getDs();
        $b->ds_uncertainty = $direct->getRds();
        $b->x_centroid = $direct->getCentroid()->getX();
        $b->y_centroid = $direct->getCentroid()->getY();
        $b->z_centroid = $direct->getCentroid()->getZ();
        //$b->save();
        $db->insert('molodensky_badekas',(array)$b);
    }

}
