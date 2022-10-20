<?php
if(!defined('D_GETOK')){
    define('D_GETOK',true);
    //require __DIR__.'/T_Student.php';
    require __DIR__.'/Engines/ReferenceSystem/Datum.php';
    require __DIR__.'/Engines/ReferenceSystem/Ellipsoid.php';
    require __DIR__.'/Engines/Coordinate/Coordinate.php';
    require __DIR__.'/Engines/Coordinate/Geocentric.php';
    require __DIR__.'/Engines/Coordinate/Geodetic.php';
    require __DIR__.'/Engines/Coordinate/Mercator.php';
    require __DIR__.'/Engines/Coordinate/Simple2D.php';
    require __DIR__.'/Engines/Coordinate/Simple3D.php';
    require __DIR__.'/Engines/Coordinate/UTM.php';
    require __DIR__.'/Engines/DatumTransformation/BursaWolf.php';
    require __DIR__.'/Engines/DatumTransformation/LAUF.php';
    require __DIR__.'/Engines/DatumTransformation/Molodensky.php';
    require __DIR__.'/Engines/DatumTransformation/MolodenskyBadekas.php';
    require __DIR__.'/Engines/Exception/DimensionMissedMatchException.php';
    require __DIR__.'/Engines/GeoClass.php';
    require __DIR__.'/Engines/Interpolation/Centroid.php';
    require __DIR__.'/Engines/MapProjection.php';
    require __DIR__.'/Usecase/CoordinateFactory.php';
    require __DIR__.'/Usecase/DatumTransformation.php';
    require __DIR__.'/Usecase/Exceptions/ConfidenceLevelException.php';
    require __DIR__.'/Usecase/Statistics/StatisticTest.php';
}
/*
$dir=__DIR__.'/';
//require __DIR__.'/';
function scand($dir,&$res){
    $d=scandir($dir);
    foreach($d as $k => $v)if($v!='..'&&$v!='.'){
        if(is_dir($dir.$v)){
            scand($dir.$v.'/',$res);
        }else{
            $res[]=$dir.$v;
        }
    }
}
$res=array();
scand($dir,$res);
foreach($res as $k => $v)
    echo 'require __DIR__.\''.str_replace(__DIR__,'',$v).'\';'.chr(10);//*/
?>