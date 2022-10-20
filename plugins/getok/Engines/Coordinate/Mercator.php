<?php

namespace App\Engines\Coordinate;

/**
 * Class Mercator
 * @package App\Engines\Coordinate
 */
class Mercator extends Coordinate
{
    private $id, $easting, $northing, $h, $meridianCentral;

    /**
     * Mercator constructor.
     * @param string $id
     * @param float $easting
     * @param float $northing
     * @param float $h
     * @param float $meridianCentral
     */
    public function __construct(float $easting, float $northing, float $h, float $meridianCentral, string $id = NULL) {
        $this->id = $id;
        $this->easting = $easting;
        $this->northing = $northing;
        $this->h = $h;
        $this->meridianCentral = $meridianCentral;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getEasting(): float
    {
        return $this->easting;
    }

    /**
     * @param float $easting
     */
    public function setEasting(float $easting): void
    {
        $this->easting = $easting;
    }

    /**
     * @return float
     */
    public function getNorthing(): float
    {
        return $this->northing;
    }

    /**
     * @param float $northing
     */
    public function setNorthing(float $northing): void
    {
        $this->northing = $northing;
    }

    /**
     * @return float
     */
    public function getH(): float
    {
        return $this->h;
    }

    /**
     * @param float $h
     */
    public function setH(float $h): void
    {
        $this->h = $h;
    }

    /**
     * @return float
     */
    public function getMeridianCentral(): float
    {
        return $this->meridianCentral;
    }

    /**
     * @param float $meridianCentral
     */
    public function setMeridianCentral(float $meridianCentral): void
    {
        $this->meridianCentral = $meridianCentral;
    }

    /**
     * @return mixed
     */
    public function toJsonObject() {
        $json = array(
            "id" => $this->id,
            "x" => number_format($this->easting, 3, '.', ''),
            "y" => number_format($this->northing, 3, '.', ''),
            "h" => number_format($this->h, 3, '.', ''),
            "meridianCentral" => $this->meridianCentral
        );

        return json_decode(json_encode($json), false);
    }

}

?>
