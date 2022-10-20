<?php

namespace App\Engines\Interpolation;

use App\Engines\Coordinate\Simple3D;

class Centroid
{

    public static function ArithmeticMean(array $data): Simple3D{

        $x = 0; $y = 0; $z = 0;
        for ($i=0; $i < count($data); $i++) {
            $x = $x + $data[$i]->getX();
            $y = $y + $data[$i]->getY();
            $z = $z + $data[$i]->getZ();
        }
        $centroidX = $x/count($data);
        $centroidY = $y/count($data);
        $centoridZ = $z/count($data);

        return new Simple3D($centroidX, $centroidY, $centoridZ);
    }

    public static function GeometricMean(array $data): Simple3D{

        $multipleX = 1; $multipleY = 1; $multipleZ = 1;
        for ($i=0;$i<count($data);$i++){
            $multipleX = $multipleX*$data[$i]->getX();
            $multipleY = $multipleY*$data[$i]->getY();
            $multipleZ = $multipleZ*$data[$i]->getZ();
        }

        $centroidX = pow($multipleX, 1/count($data));
        $centroidY = pow($multipleY, 1/count($data));
        $centroidZ = pow($multipleZ, 1/count($data));

        return new Simple3D($centroidX, $centroidY, $centroidZ);
    }

    public static function HarmonicMean(array $data): Simple3D{
        $x = 0; $y=0; $z = 0;
        for($i=0;$i<count($data);$i++){
            $x = $x + 1/$data[$i]->getX();
            $y = $y + 1/$data[$i]->getY();
            $z = $z + 1/$data[$i]->getZ();
        }

        $centroidX = count($data)/$x;
        $centroidY = count($data)/$y;
        $centroidZ = count($data)/$z;

        return new Simple3D($centroidX, $centroidY, $centroidZ);
    }

    public static function QuadraticMean(array $data): Simple3D{
        $x = 0; $y = 0; $z = 0;
        for($i=0;$i<count($data);$i++){
            $x = $x + pow($data[$i]->getX(),2);
            $y = $y + pow($data[$i]->getY(),2);
            $z = $z + pow($data[$i]->getZ(),2);
        }

        $centroidX = sqrt($x/count($data));
        $centroidY = sqrt($y/count($data));
        $centroidZ = sqrt($z/count($data));

        return new Simple3D($centroidX, $centroidY, $centroidZ);
    }

    public static function Median(array $data): Simple3D{

        $min = findMin($data);
        $max = findMax($data);

        $centroidX = ($max->getX() - $min->getX())/2;
        $centroidY = ($max->getY() - $min->getY())/2;
        $centroidZ = ($max->getZ() - $min->getZ())/2;

        return new Simple3D($centroidX, $centroidY, $centroidZ);

        function findMin(array $data){
            $xmin = $data[0]->getX();
            $ymin = $data[0]->getY();
            $zmin = $data[0]->getZ();

            for ($i=0; $i < count($data); $i++) {
                if($data[$i]->getX() < $xmin){
                    $xmin = $data[$i]->getX();
                }
                if($data[$i]->getY() < $ymin){
                    $ymin = $data[$i]->getY();
                }
                if($data[$i]->getZ() < $zmin){
                    $zmin = $data[$i]->getZ();
                }
            }

            return new Simple3D($xmin, $ymin, $zmin);
        }

        function findMax(array $data): Simple3D{
            $xmax = $data[0]->getX();
            $ymax = $data[0]->getY();
            $zmax = $data[0]->getZ();

            for ($i=0; $i < count($data); $i++) {
                if($data[$i]->getX() > $xmax){
                    $xmax = $data[$i]->getX();
                }
                if($data[$i]->getY() > $ymax){
                    $ymax = $data[$i]->getY();
                }
                if($data[$i]->getZ() > $zmax){
                    $zmax = $data[$i]->getZ();
                }
            }

            return new Simple3D($xmax, $ymax, $zmax);
        }
    }
}

?>
