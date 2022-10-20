<?php

namespace App\Engines\Coordinate;

/**
 * Class UTM
 * @package App\Engines\Coordinate
 */
class UTM extends Coordinate
{
	private $id, $easting, $northing, $h, $zone, $hemi;

    /**
     * UTM constructor.
     * @param string|null $id
     * @param float $easting
     * @param float $northing
     * @param float $h
     * @param string $zone
     * @param string $hemi
     */
	public function __construct(float $easting, float $northing, float $h, string $zone, string $hemi, string $id = NULL) {
	    $this->id = $id;
        $this->easting = $easting;
        $this->northing = $northing;
        $this->h = $h;
        $this->zone = $zone;
        $this->hemi = $hemi;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
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
     * @return string
     */
    public function getZone(): string
    {
        return $this->zone;
    }

    /**
     * @param string $zone
     */
    public function setZone(string $zone): void
    {
        $this->zone = $zone;
    }

    /**
     * @return string
     */
    public function getHemi(): string
    {
        return $this->hemi;
    }

    /**
     * @param string $hemi
     */
    public function setHemi(string $hemi): void
    {
        $this->hemi = $hemi;
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
            "hemi" => $this->hemi,
            "zone" => $this->zone
        );

        return json_decode(json_encode($json), false);
    }
}
