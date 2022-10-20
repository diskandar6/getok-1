<?php

namespace App\Engines\ReferenceSystem {

    class Ellipsoid {
        private $idEllpisoid, $a, $b, $f, $ellipsoidName, $year;

        /**
         * Ellipsoids constructor.
         * @param int $idEllpisoid
         * @param float $a
         * @param float $b
         * @param float $f
         * @param string $ellipsoidName
         * @param int $year
         */
        public function __construct(int $idEllpisoid, float $a, float $b, float $f, string $ellipsoidName, int $year) {
            $this->idEllpisoid = $idEllpisoid;
            $this->a = $a;
            $this->b = $b;
            $this->f = $f;
            $this->ellipsoidName = $ellipsoidName;
            $this->year = $year;
        }

        /**
         * @return EllipsoidBuilder
         */
        public static function builder(): EllipsoidBuilder {
            return new EllipsoidBuilder();
        }

        /**
         * First Eccentricity
         * @return float
         */
        public function getE2(): float{
            return ( pow($this->a,2) - pow($this->b,2) )/ pow($this->a,2);
        }

        /**
         * Second Eccentricity
         * @return float
         */
        public function getE2_(): float{
            return ( pow($this->a,2) - pow($this->b,2) )/ pow($this->b,2);
        }

        /**
         * @param float $lat
         * @return float
         */
        public function getN(float $lat): float{
            return $this->a/sqrt(1 - $this->getE2()*pow(sin(deg2rad($lat)),2) );
        }

        /**
         * @param float $lat
         * @return float
         */
        public function getM(float $lat): float{
            return ($this->a*(1-$this->getE2())) / pow((1-$this->getE2()*pow(sin(deg2rad($lat)),2)),(3/2));
        }

        /**
         * @param float $lat
         * @param float $azimuth
         * @return float
         */
        public function getR(float $lat, float $azimuth): float{
            return ($this->getM($lat)*$this->getN($lat)) / ($this->getM($lat)*pow(sin(deg2rad($azimuth)),2) + $this->getN($lat)*pow(cos(deg2rad($azimuth)),2));
        }

        /**
         * @return int
         */
        public function getIdEllpisoid(): int
        {
            return $this->idEllpisoid;
        }

        /**
         * @param int $idEllpisoid
         */
        public function setIdEllpisoid(int $idEllpisoid): void
        {
            $this->idEllpisoid = $idEllpisoid;
        }

        /**
         * @return float
         */
        public function getA(): float
        {
            return $this->a;
        }

        /**
         * @param float $a
         */
        public function setA(float $a): void
        {
            $this->a = $a;
        }

        /**
         * @return float
         */
        public function getB(): float
        {
            return $this->b;
        }

        /**
         * @param float $b
         */
        public function setB(float $b): void
        {
            $this->b = $b;
        }

        /**
         * @return float
         */
        public function getF(): float
        {
            return $this->f;
        }

        /**
         * @param float $f
         */
        public function setF(float $f): void
        {
            $this->f = $f;
        }

        /**
         * @return string
         */
        public function getEllipsoidName(): string
        {
            return $this->ellipsoidName;
        }

        /**
         * @param string $ellipsoidName
         */
        public function setEllipsoidName(string $ellipsoidName): void
        {
            $this->ellipsoidName = $ellipsoidName;
        }

        /**
         * @return int
         */
        public function getYear(): int
        {
            return $this->year;
        }

        /**
         * @param int $year
         */
        public function setYear(int $year): void
        {
            $this->year = $year;
        }

        /**
         * @return mixed
         */
        public function toJsonObject() {
            $data = array(
                "idEllipsoid" => $this->idEllpisoid,
                "a" => number_format($this->a, 3, '.', ''),
                "b" => number_format($this->b, 3, '.', ''),
                "f" => number_format($this->f, 3, '.', ''),
                "ellisoidName" => $this->ellipsoidName,
                "year" => $this->year
            );

            return json_decode(json_encode($data),false);
        }
    }

    /**
     * Class EllipsoidBuilder
     * @package App\Engines\ReferenceSystem
     */
    class EllipsoidBuilder {
        private $idEllipsoid, $a, $b, $f, $ellipsoidName, $year;

        /**
         * @param int $idEllipsoid
         * @return $this
         */
        public function idEllipsoid(int $idEllipsoid): EllipsoidBuilder {
            $this->idEllipsoid = $idEllipsoid;
            return $this;
        }

        /**
         * @param float $a
         * @return $this
         */
        public function a(float $a): EllipsoidBuilder{
            $this->a = $a;
            return $this;
        }

        /**
         * @param float $b
         * @return $this
         */
        public function b(float $b): EllipsoidBuilder{
            $this->b = $b;
            return $this;
        }

        /**
         * @param float $f
         * @return $this
         */
        public function f(float $f): EllipsoidBuilder{
            $this->f = $f;
            return $this;
        }

        /**
         * @param string $ellipsoidName
         * @return $this
         */
        public function ellipsoidName(string $ellipsoidName): EllipsoidBuilder{
            $this->ellipsoidName = $ellipsoidName;
            return $this;
        }

        /**
         * @param int $year
         * @return $this
         */
        public function year(int $year): EllipsoidBuilder{
            $this->year = $year;
            return $this;
        }

        /**
         * @return Ellipsoid
         */
        public function build(): Ellipsoid{
            return new Ellipsoid($this->idEllipsoid, $this->a, $this->b, $this->f, $this->ellipsoidName, $this->year);
        }
    }

}


