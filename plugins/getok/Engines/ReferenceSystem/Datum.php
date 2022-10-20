<?php

namespace App\Engines\ReferenceSystem {

    use App\Engines\DatumTransformation\BursaWolf;
    use App\Engines\DatumTransformation\Molodensky;
    use App\Engines\DatumTransformation\MolodenskyBadekas;
    use App\Engines\FreeTransformation\LAUF;

    class Datum {
        private $idDatum, $datumName, $ellipsoid, $bursaWolf, $molobas, $molodensky, $lauf;

        public function __construct(int $idDatum, string $datumName,
                                    Ellipsoid $ellipsoid, BursaWolf $bursaWolf,
                                    MolodenskyBadekas $molobas, Molodensky $molodensky, LAUF $lauf) {
            $this->idDatum = $idDatum;
            $this->datumName = $datumName;
            $this->ellipsoid = $ellipsoid;
            $this->bursaWolf = $bursaWolf;
            $this->molobas = $molobas;
            $this->molodensky = $molodensky;
            $this->lauf = $lauf;
        }

        public static function builder(): DatumBuilder {
            return new DatumBuilder();
        }

        /**
         * @return int
         */
        public function getIdDatum(): int
        {
            return $this->idDatum;
        }

        /**
         * @param int $idDatum
         */
        public function setIdDatum(int $idDatum): void
        {
            $this->idDatum = $idDatum;
        }

        /**
         * @return string
         */
        public function getDatumName(): string
        {
            return $this->datumName;
        }

        /**
         * @param string $datumName
         */
        public function setDatumName(string $datumName): void
        {
            $this->datumName = $datumName;
        }

        /**
         * @return Ellipsoid
         */
        public function getEllipsoid(): Ellipsoid
        {
            return $this->ellipsoid;
        }

        /**
         * @param Ellipsoid $ellipsoid
         */
        public function setEllipsoid(Ellipsoid $ellipsoid): void
        {
            $this->ellipsoid = $ellipsoid;
        }

        /**
         * @return BursaWolf
         */
        public function getBursaWolf(): BursaWolf
        {
            return $this->bursaWolf;
        }

        /**
         * @param BursaWolf $bursaWolf
         */
        public function setBursaWolf(BursaWolf $bursaWolf): void
        {
            $this->bursaWolf = $bursaWolf;
        }

        /**
         * @return MolodenskyBadekas
         */
        public function getMolobas(): MolodenskyBadekas
        {
            return $this->molobas;
        }

        /**
         * @param MolodenskyBadekas $molobas
         */
        public function setMolobas(MolodenskyBadekas $molobas): void
        {
            $this->molobas = $molobas;
        }

        /**
         * @return Molodensky
         */
        public function getMolodensky(): Molodensky
        {
            return $this->molodensky;
        }

        /**
         * @param Molodensky $molodensky
         */
        public function setMolodensky(Molodensky $molodensky): void
        {
            $this->molodensky = $molodensky;
        }

        /**
         * @return LAUF
         */
        public function getLauf(): LAUF
        {
            return $this->lauf;
        }

        /**
         * @param LAUF $lauf
         */
        public function setLauf(LAUF $lauf): void
        {
            $this->lauf = $lauf;
        }

    }

    /**
     * Class DatumBuilder
     * @package App\Engines\ReferenceSystem
     */
    class DatumBuilder {
        private $idDatum, $datumName, $ellipsoid, $bursaWolf, $molobas, $molodensky, $lauf;

        /**
         * @param int $idDatum
         * @return $this
         */
        public function idDatum(int $idDatum): DatumBuilder{
            $this->idDatum = $idDatum;
            return $this;
        }

        /**
         * @param string $datumName
         * @return $this
         */
        public function datumName(string $datumName): DatumBuilder {
            $this->datumName = $datumName;
            return $this;
        }

        /**
         * @param Ellipsoid $ellipsoid
         * @return $this
         */
        public function ellipsoid(Ellipsoid $ellipsoid): DatumBuilder {
            $this->ellipsoid = $ellipsoid;
            return $this;
        }

        /**
         * @param BursaWolf $bursaWolf
         * @return $this
         */
        public function bursaWolf(BursaWolf $bursaWolf): DatumBuilder {
            $this->bursaWolf = $bursaWolf;
            return $this;
        }

        /**
         * @param MolodenskyBadekas $molobas
         * @return $this
         */
        public function molobas(MolodenskyBadekas $molobas): DatumBuilder {
            $this->molobas = $molobas;
            return $this;
        }

        /**
         * @param Molodensky $molodensky
         * @return $this
         */
        public function molodensky(Molodensky $molodensky): DatumBuilder {
            $this->molodensky = $molodensky;
            return $this;
        }

        /**
         * @param LAUF $lauf
         * @return $this
         */
        public function lauf(LAUF $lauf): DatumBuilder {
            $this->lauf = $lauf;
            return $this;
        }

        /**
         * @return Datum
         */
        public function build(): Datum {
            return new Datum($this->idDatum, $this->datumName, $this->ellipsoid, $this->bursaWolf, $this->molobas,
            $this->molodensky, $this->lauf);
        }
    }

}
