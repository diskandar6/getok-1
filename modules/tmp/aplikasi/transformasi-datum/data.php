<?php
use App\Usecase\DatumTransformation;

if(isset($_GET['idPoint'])){
    $id=(int)$_GET['idPoint'];
    $iu=(int)$_GET['isUsed'];
    $dbg->update("survey_points",array('is_used'=>$iu),array('id_point'=>$id),array('%d'),array('%d'));
    echo 'ok';
}elseif(isset($_GET['upload'])){
    $dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
    $dir.='datumtransformasi/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.='upload/';if(!file_exists($dir))mkdir($dir,0755);
    $_SESSION['uploads']=$dir;
    $_SESSION['filename-uploaded']='raw.data';
}elseif(isset($_GET['calculate'])){
        //$points = Survey::find($request->idSurvey)->surveyPoints;
        $points=$dbg->get_results("SELECT * FROM survey_points WHERE id_survey=".(int)$_GET['calculate']);
        $amount = 0;
        foreach ($points as $p){
            if($p->is_used == 1){
                $amount += 1;
            }
        }

        if($amount < 3){
            //Session::flash("alert-failed", "You need at minimum three points to continue.");
            //return redirect()->back();
            echo "You need at minimum three points to continue.";
            exit;
        }

        DatumTransformation::calculateBursaWolf(/*$request->idSurvey*/(int)$_GET['calculate']);
        DatumTransformation::calculateMolodenskyBadekas(/*$request->idSurvey*/(int)$_GET['calculate']);

        //$setFinish = Survey::find($request->idSurvey);
        //$setFinish->is_calculated = 1;
        //$setFinish->save();
        $dbg->update('surveys',array('is_calculated'=>1),array('id_survey'=>(int)$_GET['calculate']),array('%d'),array('%d'));

        //Session::flash("alert-success", "Datum calculation is completed. See the detail list below the data points.");
        //return redirect()->back();
        echo 'ok';
}elseif(isset($_GET['id_survey'])){
        //$uploadFile = $request->file('file');
        //$path = $uploadFile->store('public/transformasi_datum');

        //$survey = Survey::find($request->idSurvey);
        //$survey->file = $path;
        //$survey->save();
        $dbg->update("surveys",array('file'=>$_SESSION['uploads'].$_SESSION['filename']),array('id_survey'=>(int)$_GET['id_survey']),array('%s'),array('%d'));

        if($_GET['meridianCentral']=='')$_GET['meridianCentral']=null;
        if($_GET['zone']=='')$_GET['zone']=null;
        if($_GET['hemi']=='')$_GET['hemi']=null;
        
        $savePoint = DatumTransformation::ReadDataPoints($_GET['id_survey'], 
                                                        $_GET['coord'], 
                                                        $_GET['structure'],
                                                        $_GET['delimit'],
                                                        $_GET['hemi'],
                                                        $_GET['zone'],
                                                        $_GET['meridianCentral']
                                                        );

        if($savePoint == false){
            //Session::flash('alert-failed', 'Please insert at minimum three points.');
            //return redirect()->back();
            echo 'Please insert at minimum three points.';
        }else echo 'Upload is successfull.';

        //Session::flash('alert-success', 'Upload is successfull.');
        //return redirect()->back();
}
/*
CREATE TABLE `survey_points` (
  `id_point` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_survey` int(10) unsigned NOT NULL,
  `point_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `X1` double NOT NULL,
  `dX1` double DEFAULT NULL,
  `Y1` double NOT NULL,
  `dY1` double DEFAULT NULL,
  `Z1` double NOT NULL,
  `dZ1` double DEFAULT NULL,
  `X2` double NOT NULL,
  `dX2` double DEFAULT NULL,
  `Y2` double NOT NULL,
  `dY2` double DEFAULT NULL,
  `Z2` double NOT NULL,
  `dZ2` double DEFAULT NULL,
  `bursawolf_passing_status` tinyint(1) NOT NULL DEFAULT 0,
  `molobas_passing_status` tinyint(1) NOT NULL DEFAULT 0,
  `is_used` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_point`),
  KEY `id_survey` (`id_survey`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
*/
?>