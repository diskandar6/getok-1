<?php
namespace App\Engines\DatumTransformation {

    use App\Engines\Coordinate\Geocentric;
    use App\Engines\Exception\DimensionMissedMatchException;
    use App\Usecase\Statistics\StatisticTest;
    use MathPHP\Exception\BadDataException;
    use MathPHP\Exception\BadParameterException;
    use MathPHP\Exception\IncorrectTypeException;
    use MathPHP\Exception\MathException;
    use MathPHP\Exception\MatrixException;
    use MathPHP\Exception\OutOfBoundsException;
    use MathPHP\Exception\VectorException;
    use MathPHP\LinearAlgebra\Matrix;
    use MathPHP\LinearAlgebra\MatrixFactory;
    use App\Engines\Coordinate\Simple3D;
    use App\Engines\Interpolation\Centroid;

    /**
     * Class MolodenskyBadekass
     * @package App\Engines\DatumTransformation
     */
    class MolodenskyBadekas{

        private $dx, $dy, $dz, $εx, $εy, $εz, $ds;
        private $rdx, $rdy, $rdz, $rεx, $rεy, $rεz, $rds;
        private $test, $centroidType, $centroid;

        public function __construct(float $dx, float $dy, float $dz, float $εx, float $εy, float $εz, float $ds,
                                    string $centroidType, Simple3D $centroid = NULL,
                                    float $rdx = NULL, float $rdy = NULL, float $rdz = NULL, float $rεx = NULL,
                                    float $rεy = NULL, float $rεz = NULL, float $rds = NULL,
                                    array $test = NULL){
            $this->dx = $dx;
            $this->dy = $dy;
            $this->dz = $dz;
            $this->εx = $εx;
            $this->εy = $εy;
            $this->εz = $εz;
            $this->ds = $ds;
            $this->centroid = $centroid;
            $this->centroidType = $centroidType;
            $this->rdx = $rdx;
            $this->rdy = $rdy;
            $this->rdz = $rdz;
            $this->rεx = $rεx;
            $this->rεy = $rεy;
            $this->rεz = $rεz;
            $this->rds = $rds;
            $this->test = $test;
        }

        /**
         * @return MolodenskyBadekasBuilder
         */
        public static function builder(): MolodenskyBadekasBuilder {
            return new MolodenskyBadekasBuilder();
        }

        /**
         * @param array $dataSet1
         * @param array $dataset2
         * @param Simple3D $centroid
         * @param string $centroidType
         * @param array|null $std1
         * @param array|null $std2
         * @return DirectMolodenskyBadekas
         */
        public static function Direct(array $dataSet1, array $dataset2, string $centroidType, Simple3D $centroid = NULL,
                                      array $std1 = NULL, array $std2 = NULL): DirectMolodenskyBadekas{
            return new DirectMolodenskyBadekas($dataSet1, $dataset2,  $centroidType, $centroid, $std1, $std2);
        }

        /**
         * @param array $dataSet1
         * @param MolodenskyBadekas $molodenskyBadekas
         * @return InverseMolodenskyBadekas
         */
        public static function Inverse(array $dataSet1, MolodenskyBadekas $molodenskyBadekas): InverseMolodenskyBadekas{
            return new InverseMolodenskyBadekas($dataSet1, $molodenskyBadekas);
        }

        /**
         * @return float
         */
        public function getDx(): float
        {
            return $this->dx;
        }

        /**
         * @param float $dx
         */
        public function setDx(float $dx): void
        {
            $this->dx = $dx;
        }

        /**
         * @return float
         */
        public function getDy(): float
        {
            return $this->dy;
        }

        /**
         * @param float $dy
         */
        public function setDy(float $dy): void
        {
            $this->dy = $dy;
        }

        /**
         * @return float
         */
        public function getDz(): float
        {
            return $this->dz;
        }

        /**
         * @param float $dz
         */
        public function setDz(float $dz): void
        {
            $this->dz = $dz;
        }

        /**
         * @return float
         */
        public function getΕx(): float
        {
            return $this->εx;
        }

        /**
         * @param float $εx
         */
        public function setΕx(float $εx): void
        {
            $this->εx = $εx;
        }

        /**
         * @return float
         */
        public function getΕy(): float
        {
            return $this->εy;
        }

        /**
         * @param float $εy
         */
        public function setΕy(float $εy): void
        {
            $this->εy = $εy;
        }

        /**
         * @return float
         */
        public function getΕz(): float
        {
            return $this->εz;
        }

        /**
         * @param float $εz
         */
        public function setΕz(float $εz): void
        {
            $this->εz = $εz;
        }

        /**
         * @return float
         */
        public function getDs(): float
        {
            return $this->ds;
        }

        /**
         * @param float $ds
         */
        public function setDs(float $ds): void
        {
            $this->ds = $ds;
        }

        /**
         * @return float
         */
        public function getRdx(): float
        {
            return $this->rdx;
        }

        /**
         * @param float $rdx
         */
        public function setRdx(float $rdx): void
        {
            $this->rdx = $rdx;
        }

        /**
         * @return float
         */
        public function getRdy(): float
        {
            return $this->rdy;
        }

        /**
         * @param float $rdy
         */
        public function setRdy(float $rdy): void
        {
            $this->rdy = $rdy;
        }

        /**
         * @return float
         */
        public function getRdz(): float
        {
            return $this->rdz;
        }

        /**
         * @param float $rdz
         */
        public function setRdz(float $rdz): void
        {
            $this->rdz = $rdz;
        }

        /**
         * @return float
         */
        public function getRεx(): float
        {
            return $this->rεx;
        }

        /**
         * @param float $rεx
         */
        public function setRεx(float $rεx): void
        {
            $this->rεx = $rεx;
        }

        /**
         * @return float
         */
        public function getRεy(): float
        {
            return $this->rεy;
        }

        /**
         * @param float $rεy
         */
        public function setRεy(float $rεy): void
        {
            $this->rεy = $rεy;
        }

        /**
         * @return float
         */
        public function getRεz(): float
        {
            return $this->rεz;
        }

        /**
         * @param float $rεz
         */
        public function setRεz(float $rεz): void
        {
            $this->rεz = $rεz;
        }

        /**
         * @return float
         */
        public function getRds(): float
        {
            return $this->rds;
        }

        /**
         * @param float $rds
         */
        public function setRds(float $rds): void
        {
            $this->rds = $rds;
        }

        /**
         * @return array
         */
        public function getTest(): array
        {
            return $this->test;
        }

        /**
         * @param array $test
         */
        public function setTest(array $test): void
        {
            $this->test = $test;
        }

        /**
         * @return string
         */
        public function getCentroidType(): string
        {
            return $this->centroidType;
        }

        /**
         * @param string $centroidType
         */
        public function setCentroidType(string $centroidType): void
        {
            $this->centroidType = $centroidType;
        }

        /**
         * @return Simple3D
         */
        public function getCentroid(): Simple3D
        {
            return $this->centroid;
        }

        /**
         * @param Simple3D $centroid
         */
        public function setCentroid(Simple3D $centroid): void
        {
            $this->centroid = $centroid;
        }

        /**
         * @return mixed
         */
        public function paramsToJsonObject(){
            $json = array(
                "dx" => number_format($this->dx, 3, '.', ''),
                "dy" => number_format($this->dy, 3, '.', ''),
                "dz" => number_format($this->dz, 3, '.', ''),
                "ex" => number_format($this->εx, 7, '.', ''),
                "ey" => number_format($this->εy, 7, '.', ''),
                "ez" => number_format($this->εz, 7, '.', ''),
                "ds" => number_format($this->ds, 7, '.', '')
            );

            return json_decode(json_encode($json), false);
        }

        public function residueToJsonObject(){
            $json = array(
                "rdx" => number_format($this->rdx, 7, '.', ''),
                "rdy" => number_format($this->rdy, 7, '.', ''),
                "rdz" => number_format($this->rdz, 7, '.', ''),
                "rex" => number_format($this->rεx, 7, '.', ''),
                "rey" => number_format($this->rεy, 7, '.', ''),
                "rez" => number_format($this->rεz, 7, '.', ''),
                "rds" => number_format($this->rds, 7, '.', '')
            );

            return json_decode(json_encode($json), false);
        }

    }

    /**
     * Class MolodensyBadekasBuilder
     * @package App\Engines\DatumTransformation
     */
    class MolodenskyBadekasBuilder {
        private $dx, $dy, $dz, $εx, $εy, $εz, $ds;
        private $rdx, $rdy, $rdz, $rεx, $rεy, $rεz, $rds;
        private $test, $centroidType, $centroid;

        /**
         * @param float $dx
         * @return $this
         */
        public function dx(float $dx): MolodenskyBadekasBuilder {
            $this->dx = $dx;
            return $this;
        }

        /**
         * @param float $dy
         * @return $this
         */
        public function dy(float $dy): MolodenskyBadekasBuilder {
            $this->dy = $dy;
            return $this;
        }

        /**
         * @param float $dz
         * @return $this
         */
        public function dz(float $dz): MolodenskyBadekasBuilder {
            $this->dz = $dz;
            return $this;
        }

        /**
         * @param float $εx
         * @return $this
         */
        public function εx(float $εx): MolodenskyBadekasBuilder {
            $this->εx = $εx;
            return $this;
        }

        /**
         * @param float $εy
         * @return $this
         */
        public function εy(float $εy): MolodenskyBadekasBuilder {
            $this->εy = $εy;
            return $this;
        }

        /**
         * @param float $εz
         * @return $this
         */
        public function εz(float $εz): MolodenskyBadekasBuilder {
            $this->εz = $εz;
            return $this;
        }

        /**
         * @param float $ds
         * @return $this
         */
        public function ds(float $ds): MolodenskyBadekasBuilder {
            $this->ds = $ds;
            return $this;
        }

        /**
         * @param Simple3D $centroid
         * @return $this
         */
        public function centroid(Simple3D $centroid): MolodenskyBadekasBuilder {
            $this->centroid = $centroid;
            return $this;
        }

        /**
         * @param string $centroidType
         * @return $this
         */
        public function centroidType(string $centroidType): MolodenskyBadekasBuilder {
            $this->centroidType = $centroidType;
            return $this;
        }

        public function rdx(float $rdx): MolodenskyBadekasBuilder {
            $this->rdx = $rdx;
            return $this;
        }

        public function rdy(float $rdy): MolodenskyBadekasBuilder {
            $this->rdy = $rdy;
            return $this;
        }

        public function rdz(float $rdz): MolodenskyBadekasBuilder {
            $this->rdz = $rdz;
            return $this;
        }

        public function rεx(float $rεx): MolodenskyBadekasBuilder {
            $this->rεx = $rεx;
            return $this;
        }

        public function rεy(float $rεy): MolodenskyBadekasBuilder {
            $this->rεy = $rεy;
            return $this;
        }

        public function rεz(float $rεz): MolodenskyBadekasBuilder {
            $this->rεz = $rεz;
            return $this;
        }

        public function rds(float $rds): MolodenskyBadekasBuilder {
            $this->rds = $rds;
            return $this;
        }

        public function test(array $test): MolodenskyBadekasBuilder {
            $this->test = $test;
            return $this;
        }

        /**
         * @return MolodenskyBadekas
         */
        public function build(): MolodenskyBadekas {
            return new MolodenskyBadekas($this->dx, $this->dy, $this->dz, $this->εx, $this->εy, $this->εz, $this->ds,
                $this->centroidType, $this->centroid,
                $this->rdx, $this->rdy, $this->rdz, $this->rεx, $this->rεy, $this->rεz, $this->rds,
                $this->test);
        }
    }

    /**
     * Class DirectMolodenskyBadekas
     * @package App\Engines\DatumTransformation
     */
    class DirectMolodenskyBadekas {
        private $dataSet1, $dataSet2, $std1, $std2, $centroid, $centroidType;

        /**
         * DirectMolodenskyBadekas constructor.
         * @param array $dataSet1
         * @param array $dataSet2
         * @param Simple3D $centroid
         * @param string $centroidType
         * @param array|null $std1
         * @param array|null $std2
         */
        public function __construct(array $dataSet1, array $dataSet2, string $centroidType, Simple3D $centroid = NULL,
                                    array $std1 = NULL, array $std2 = NULL) {
            $this->dataSet1 = $dataSet1;
            $this->dataSet2 = $dataSet2;
            $this->centroid = $centroid;
            $this->centroidType = $centroidType;
            $this->std1 = $std1;
            $this->std2 = $std2;
        }

        /**
         * @return Matrix
         * @throws DimensionMissedMatchException
         */
        public function createCofactorMatrix(): Matrix{
            if($this->std1 == NULL || $this->std2 == NULL){
                try {
                    return MatrixFactory::identity(sizeof($this->dataSet1)*6);
                } catch (BadDataException $e) {
                } catch (IncorrectTypeException $e) {
                } catch (MatrixException $e) {
                } catch (OutOfBoundsException $e) {
                } catch (MathException $e) {
                }
            }

            if(sizeof($this->std1) != sizeof($this->std2)){
                throw new DimensionMissedMatchException("Dimension of the standard deviation is missed match");
            }

            $i = 0; $c = 0;
            for ($i = 0; $i < sizeof($this->std1); $i++){
                for ($j = 0; $j<sizeof($this->std1)*6; $j++){
                    $Q[$c][$j]   = 0;
                    $Q[$c+1][$j] = 0;
                    $Q[$c+2][$j] = 0;
                    $Q[$c+3][$j] = 0;
                    $Q[$c+4][$j] = 0;
                    $Q[$c+5][$j] = 0;
                }

                $Q[$c][$c]     = $this->std1[$i]->getX()*$this->std1[$i]->getX();
                $Q[$c+1][$c+1] = $this->std1[$i]->getY()*$this->std1[$i]->getY();
                $Q[$c+2][$c+2] = $this->std1[$i]->getZ()*$this->std1[$i]->getZ();
                $Q[$c+3][$c+3] = $this->std2[$i]->getX()*$this->std2[$i]->getX();
                $Q[$c+4][$c+4] = $this->std2[$i]->getY()*$this->std2[$i]->getY();
                $Q[$c+5][$c+5] = $this->std2[$i]->getZ()*$this->std2[$i]->getZ();

                $c += 6;
            }

            try {
                return MatrixFactory::create($Q);
            } catch (BadDataException $e) {
            } catch (IncorrectTypeException $e) {
            } catch (MatrixException $e) {
            } catch (MathException $e) {
            }
        }

        /**
         * @return Simple3D|null
         */
        private function findCentroid(): Simple3D
        {
            $ctr = null;
            switch ($this->centroidType) {
                case "ARITHMETIC":
                    $ctr = Centroid::ArithmeticMean($this->dataSet1);
                    break;

                case "GEOMETRIC":
                    $ctr = Centroid::GeometricMean($this->dataSet1);
                    break;

                case "HARMONIC":
                    $ctr = Centroid::HarmonicMean($this->dataSet1);
                    break;

                case "QUADRATIC":
                    $ctr = Centroid::QuadraticMean($this->dataSet1);
                    break;

                case "MEDIAN":
                    $ctr = Centroid::Median($this->dataSet1);
                    break;
            }
            return $ctr;
        }

        /**
         * @return MolodenskyBadekas
         * @throws BadDataException
         * @throws BadParameterException
         * @throws IncorrectTypeException
         * @throws MathException
         * @throws MatrixException
         * @throws OutOfBoundsException
         * @throws VectorException
         */
        public function parametric(): MolodenskyBadekas{
            $this->centroid = $this->findCentroid();
            $c = 0; $B = null; $f = null; $x = null;
            for($i = 0; $i<count($this->dataSet1); $i++){

                // set Ires
                $I = new Simple3D($this->dataSet1[$i]->getX() - $this->centroid->getX(), $this->dataSet1[$i]->getY() - $this->centroid->getY(), $this->dataSet1[$i]->getZ() - $this->centroid->getZ());

                $B[$i+$c]   = [1,0,0, 0, -$I->getZ(), $I->getY(), $I->getX()];
                $B[$i+$c+1] = [0,1,0, $I->getZ(), 0, -$I->getX(), $I->getY()];
                $B[$i+$c+2] = [0,0,1, -$I->getY(), $I->getX(), 0, $I->getZ()];

                $f[$i+$c]   = [$this->dataSet2[$i]->getX() - $I->getX()];
                $f[$i+$c+1] = [$this->dataSet2[$i]->getY() - $I->getY()];
                $f[$i+$c+2] = [$this->dataSet2[$i]->getZ() - $I->getZ()];

                $c = $c+2;
            }

            $B = MatrixFactory::create($B);
            $f = MatrixFactory::create($f);
            $t = $B->transpose()->multiply($f);
            $N = $B->transpose()->multiply($B);
            $x = $N->inverse()->multiply($t);
            $v = $f->subtract($B->multiply($x));
            return MolodenskyBadekas::builder()
                ->dx($x[0][0])
                ->dy($x[1][0])
                ->dz($x[2][0])
                ->εx($x[3][0])
                ->εy($x[4][0])
                ->εz($x[5][0])
                ->ds($x[6][0])
                ->centroidType($this->centroidType)
                ->centroid($this->centroid)
                ->build();
        }

        /**
         * @return MolodenskyBadekas
         * @throws BadDataException
         * @throws BadParameterException
         * @throws DimensionMissedMatchException
         * @throws IncorrectTypeException
         * @throws MathException
         * @throws MatrixException
         * @throws OutOfBoundsException
         * @throws VectorException
         * @throws \App\Usecase\Exceptions\ConfidenceLevelException
         */
        public function combined(): MolodenskyBadekas{
            // find initial value
            $this->centroid = $this->findCentroid();
            $bf = $this->parametric();
            $ds1 = $this->dataSet1;
            $ds2 = $this->dataSet2;

            // Start looping
            $loop = true;
            $hit = 0;
            while ($loop == true && $hit <= 10) {

                $c = 0; $c2 = 0;
                $A = []; $B = []; $f = []; $l = [];
                for ($i = 0; $i < sizeof($ds1); $i++){
                    $content1 = []; $content2 = []; $content3 = []; $cc = 0;
                    for ($j = 0; $j < sizeof($ds1); $j++){
                        if($i == $j) {
                            $content1[0+$cc] = 1+$bf->getDs();
                            $content1[1+$cc] = $bf->getΕz();
                            $content1[2+$cc] = -$bf->getΕy();
                            $content1[3+$cc] = -1; $content1[4+$cc] = 0; $content1[5+$cc] = 0;

                            $content2[0+$cc] = -$bf->getΕz();
                            $content2[1+$cc] = 1+$bf->getDs();
                            $content2[2+$cc] = $bf->getΕx();
                            $content2[3+$cc] = 0; $content2[4+$cc] = -1; $content2[5+$cc] = 0;

                            $content3[0+$cc] = $bf->getΕy();
                            $content3[1+$cc] = -$bf->getΕx();
                            $content3[2+$cc] = 1+$bf->getDs();
                            $content3[3+$cc] = 0; $content3[4+$cc] = 0; $content3[5+$cc] = -1;
                        }else{
                            $content1[0+$cc] = 0; $content1[1+$cc] = 0; $content1[2+$cc] = 0;
                            $content1[3+$cc] = 0; $content1[4+$cc] = 0; $content1[5+$cc] = 0;

                            $content2[0+$cc] = 0; $content2[1+$cc] = 0; $content2[2+$cc] = 0;
                            $content2[3+$cc] = 0; $content2[4+$cc] = 0; $content2[5+$cc] = 0;

                            $content3[0+$cc] = 0; $content3[1+$cc] = 0; $content3[2+$cc] = 0;
                            $content3[3+$cc] = 0; $content3[4+$cc] = 0; $content3[5+$cc] = 0;
                        }
                        $cc += 6;
                    }

                    $A[$i+$c]   = $content1;
                    $A[$i+$c+1] = $content2;
                    $A[$i+$c+2] = $content3;

                    // set Ires
                    $I = new Simple3D($this->dataSet1[$i]->getX() - $this->centroid->getX(), $this->dataSet1[$i]->getY() - $this->centroid->getY(), $this->dataSet1[$i]->getZ() - $this->centroid->getZ());

                    $B[$i+$c]   = [1, 0, 0, 0, -$I->getZ(), $I->getY(), $I->getX()];
                    $B[$i+$c+1] = [0, 1, 0, $I->getZ(), 0, -$I->getX(), $I->getY()];
                    $B[$i+$c+2] = [0, 0, 1, -$I->getY(), $I->getX(), 0, $I->getZ()];

                    $f[$i+$c]   = [-($bf->getDx() - $I->getZ()*$bf->getΕy() + $I->getY()*$bf->getΕz() + $I->getX()*$bf->getDs() + $I->getX() - $ds2[$i]->getX())];
                    $f[$i+$c+1] = [-($bf->getDy() + $I->getZ()*$bf->getΕx() - $I->getX()*$bf->getΕz() + $I->getY()*$bf->getDs() + $I->getY() - $ds2[$i]->getY())];
                    $f[$i+$c+2] = [-($bf->getDz() - $I->getY()*$bf->getΕx() + $I->getX()*$bf->getΕy() + $I->getZ()*$bf->getDs() + $I->getZ() - $ds2[$i]->getZ())];

                    $l[$i+$c2]   = [$I->getX()];
                    $l[$i+$c2+1] = [$I->getY()];
                    $l[$i+$c2+2] = [$I->getZ()];
                    $l[$i+$c2+3] = [$I->getX()];
                    $l[$i+$c2+4] = [$I->getY()];
                    $l[$i+$c2+5] = [$I->getZ()];

                    $c += 2;
                    $c2 += 5;
                }

                $x_near = [[$bf->getDx()], [$bf->getDy()], [$bf->getDz()],
                    [$bf->getΕx()], [$bf->getΕy()], [$bf->getΕz()],
                    [$bf->getDs()]];
                $x_near = MatrixFactory::create($x_near);

                // quadratic least square
                $A = MatrixFactory::create($A);
                $B = MatrixFactory::create($B);
                $f = MatrixFactory::create($f);
                $l = MatrixFactory::create($l);
                $Q = $this->createCofactorMatrix();

                if($this->std1 != NULL && $this->std2 != NULL){
                    $Qε = $A->multiply($Q)->multiply($A->transpose());
                    $Wε = $Qε;
                }else{
                    $Wε = MatrixFactory::identity(sizeof($ds1)*3);
                }

                $N = $B->transpose()->multiply($Wε)->multiply($B);
                $t = $B->transpose()->multiply($Wε)->multiply($f);
                $𝜹x = $N->inverse()->multiply($t);
                $k = $Wε->multiply($f->subtract($B->multiply($𝜹x)));

                if($this->std1 != NULL && $this->std2 != NULL){
                    $v = $Q->multiply($A->transpose())->multiply($k);
                }else{
                    $v = ($A->transpose())->multiply($k);
                }
                $x = $x_near->add($𝜹x);
                $l = $l->add($v);

                // Refresh new dataset
                $count = 0; $c = 0;
                while ($c < $l->getM()){
                    $ds1[$count] = new Geocentric($l[$c][0], $l[$c+1][0], $l[$c+2][0]);
                    $ds2[$count] = new Geocentric($l[$c+3][0], $l[$c+4][0], $l[$c+5][0]);
                    $count += 1;
                    $c += 6;
                }

                // Refresh new MolodenskyBadekass
                $bf = new MolodenskyBadekas($x[0][0], $x[1][0], $x[2][0], $x[3][0], $x[4][0], $x[5][0], $x[6][0], $this->centroidType);

                // Find the highest value of x parameters
                $high1 = 0; $high2 = 0;
                for ($i = 0; $i < 3; $i++) {
                    if (abs($𝜹x[$i][0]) > $high1) {
                        $high1 = abs($𝜹x[$i][0]);
                    }
                }

                for ($i = 3; $i < 7; $i++){
                    if (abs($𝜹x[$i][0]) > $high2) {
                        $high2 = abs($𝜹x[$i][0]);
                    }
                }

                if ($high1 > pow(10, -3) && $high2 > pow(10, -8)) {
                    $loop = true;
                } else {
                    $loop = false;
                }

                $hit += 1;
            }

            // Outlier detection
            $dof = $v->getM()-7;
            $Wε = ($A->multiply($Q->inverse())->multiply($A->transpose()))->inverse();
            $variance = $v->transpose()->multiply($Q->inverse())->multiply($v)->scalarDivide($dof);
            $Qvv = $Q->multiply($A->transpose())->multiply($Wε)->multiply(MatrixFactory::identity(sizeof($ds1)*3)->subtract($B->multiply($N->inverse())->multiply($B->transpose())->multiply($Wε)))->multiply($A)->multiply($Q);
            $tStudent = StatisticTest::TStudent("0.05", $dof);
            $tau = ($tStudent*sqrt($dof))/(sqrt($dof-1+pow($tStudent,2)));
            for ($i = 0; $i<$v->getM(); $i++){
                $final = $v[$i][0]/$Qvv[$i][$i];

                if(abs($final)/$variance[0][0] > $tau){
                    $result[$i] = 0;
                }else{
                    $result[$i] = 1;
                }
            }

            $hit = 0;
            for ($i=0; $i<sizeof($result)/6; $i++){
                if($result[$hit] == 1 && $result[$hit+1] == 1 && $result[$hit+2] == 1){
                    $resultTest[$i] = 1;
                }else{
                    $resultTest[$i] = 0;
                }
                $hit += 6;
            }

            return MolodenskyBadekas::builder()
                ->dx($x[0][0])
                ->dy($x[1][0])
                ->dz($x[2][0])
                ->εx($x[3][0])
                ->εy($x[4][0])
                ->εz($x[5][0])
                ->ds($x[6][0])
                ->centroidType($this->centroidType)
                ->centroid($this->centroid)
                ->rdx($𝜹x[0][0])
                ->rdy($𝜹x[1][0])
                ->rdz($𝜹x[2][0])
                ->rεx($𝜹x[3][0])
                ->rεy($𝜹x[4][0])
                ->rεz($𝜹x[5][0])
                ->rds($𝜹x[6][0])
                ->test($resultTest)
                ->build();
        }
    }

    /**
     * Class InverseMolodenskyBadekas
     * @package App\Engines\DatumTransformation
     */
    class InverseMolodenskyBadekas {
        private $dataSet1, $molobas;

        /**
         * InverseMolodenskyBadekas constructor.
         * @param array $dataSet1
         * @param MolodenskyBadekas $molobas
         */
        public function __construct(array $dataSet1, MolodenskyBadekas $molobas) {
            $this->dataSet1 = $dataSet1;
            $this->molobas = $molobas;
        }

        /**
         * The array contains Simple3D type
         * @return array
         */
        public function get(): array{
            $dataSet2 = [];
            for ($i=0; $i < count($this->dataSet1); $i++) {

                $I = new Simple3D($this->dataSet1[$i]->getX() - $this->molobas->getCentroid()->getX(), $this->dataSet1[$i]->getY() - $this->molobas->getCentroid()->getY(), $this->dataSet1[$i]->getZ() - $this->molobas->getCentroid()->getZ());

                $X = $I->getX() + $I->getY()*$this->molobas->getΕz() - $I->getZ()*$this->molobas->getΕy() + $I->getX()*$this->molobas->getDs() + $this->molobas->getDx();
                $Y = -$I->getX()*$this->molobas->getΕz() + $I->getY() + $I->getZ()*$this->molobas->getΕx() + $I->getY()*$this->molobas->getDs() + $this->molobas->getDy();
                $Z = $I->getX()*$this->molobas->getΕy() - $I->getY()*$this->molobas->getΕx() + $I->getZ() + $I->getZ()*$this->molobas->getDs() + $this->molobas->getDz();
                $dataSet2[$i] = new Geocentric($X, $Y, $Z, $this->dataSet1[$i]->getId());
            }
            return $dataSet2;
        }
    }

}
