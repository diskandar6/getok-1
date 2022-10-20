<?php

namespace App\Engines\FreeTransformation;

use App\Engines\Coordinate\Simple2D;
use App\Engines\Interpolation\Centroid;
use MathPHP\Exception\BadDataException;
use MathPHP\Exception\IncorrectTypeException;
use MathPHP\Exception\MathException;
use MathPHP\Exception\MatrixException;
use MathPHP\LinearAlgebra\MatrixFactory;

/**
 * Class LAUF
 * @package App\Engines\FreeTransformation
 */
class LAUF
{
    /**
     * @param array $dataSet1
     * @param array $dataSet2
     * @param string $centroidType
     * @return array
     */
    public static function Direct(array $dataSet1, array $dataSet2, string $centroidType): array{
        $centroid = findCentroid($dataSet1, $centroidType);

        $A = null; $F = null; $params = null; $rms = null;
        for ($i=0; $i<count($dataSet1); $i++){
            $I1 = new Simple2D($dataSet1[$i]->getX() - $centroid->getX(), $dataSet1[$i]->getY() - $centroid->getY());
            $I2 = new Simple2D($dataSet2[$i]->getX() - $centroid->getX(), $dataSet2[$i]->getY() - $centroid->getY());

            $A[2*$i]   = [$I1->getX(), -$I1->getY(), pow($I1->getX(),2) - pow($I1->getY(),2), -2*$I1->getX()*$I1->getY(), 1, 0];
            $A[2*$i+1] = [$I1->getY(), $I1->getX(), 2*$I1->getX()*$I1->getY(), pow($I1->getX(),2) - pow($I1->getY(),2), 0, 1];

            $F[2*$i]   = $I2->getX();
            $F[2*$i+1] = $I2->getY();
        }

        try {
            $A = MatrixFactory::create($A);
            $F = MatrixFactory::create($F);
            $params = (($A->transpose()->multiply($A))->multiply($A->transpose()->multiply($F->transpose())))->inverse();
            $V = ($A->multiply($params))->subtract($F->transpose());
            $sigma = ($V->transpose()->multiply($V))->scalarDivide(2*count($dataSet1)-6);
            $rms = sqrt($sigma);
        } catch (BadDataException $e) {
            echo "There is a problem with matrix equation: ".$e;
        } catch (IncorrectTypeException $e) {
            echo "There is a problem with matrix equation: ".$e;
        } catch (MatrixException $e) {
            echo "There is a problem with matrix equation: ".$e;
        } catch (MathException $e) {
            echo "There is a problem with matrix equation: ".$e;
        }

        return array(
            "a" => $params[0],
            "b" => $params[1],
            "c" => $params[2],
            "d" => $params[3],
            "translation" => new Simple2D($params[4], $params[5]),
            "centroid" => $centroid,
            "rms" => $rms
        );

        /**
         * @param array $dataSet1
         * @param string $centroidType
         * @return Simple2D
         */
        function findCentroid(array $dataSet1, string $centroidType): Simple2D{
            $ctr = null;
            switch ($centroidType){
                case "ARITHMETIC":
                    $ctr = Centroid::ArithmeticMean($dataSet1);
                    break;

                case "GEOMETRIC":
                    $ctr = Centroid::GeometricMean($dataSet1);
                    break;

                case "HARMONIC":
                    $ctr = Centroid::HarmonicMean($dataSet1);
                    break;

                case "QUADRATIC":
                    $ctr = Centroid::QuadraticMean($dataSet1);
                    break;

                case "MEDIAN":
                    $ctr = Centroid::Median($dataSet1);
                    break;
            }
            return $ctr;
        }
    }

    /**
     * @param array $dataSet1
     * @param float $a
     * @param float $b
     * @param float $c
     * @param float $d
     * @param Simple2D $translation
     * @param Simple2D $centroid
     * @return array
     */
    public static function Inverse(array $dataSet1, float $a, float $b, float $c, float $d, Simple2D $translation, Simple2D $centroid): array{
        $dataSet2 = null;
        for ($i=0; $i<count($dataSet1); $i++){
            $dx = $dataSet1[$i]->getX() - $centroid->getX();
            $dy = $dataSet1[$i]->getY() - $centroid->getY();

            $x = $a*$dx - $b*$dy + $c*(pow($dx,2) - pow($dy,2)) - $d*2*$dx*$dy + $translation->getX() + $centroid->getX();
            $y = $a*$dy + $b*$dx + $d*(pow($dx,2) - pow($dy,2)) + $c*2*$dx*$dy + $translation->getY() + $centroid->getY();

            $dataSet2[$i] = new Simple2D($x, $y);
        }
        return $dataSet2;
    }

}

?>
