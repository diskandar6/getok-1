<?php

namespace App\Engines\Coordinate;

use App\Datum;

/**
 * Class Geodetic
 * @package App\Engines\Coordinate
 */
class Geodetic extends Coordinate
{
	private $id, $lat, $lon, $h;

    /**
     * Geodetic constructor.
     * @param string|null $id
     * @param float $lat
     * @param float $lon
     * @param float $h
     */
	public function __construct(float $lat, float $lon, float $h, string $id = NULL) {
	    $this->id = $id;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->h = $h;
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
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat(float $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * @param float $lon
     */
    public function setLon(float $lon): void
    {
        $this->lon = $lon;
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
     * @return mixed
     */
    public function toJsonObject() {
        $json = array(
            "id" => $this->id,
            "lat" => number_format($this->lat, 7, '.', ''),
            "lon" => number_format($this->lon, 7, '.', ''),
            "h" => number_format($this->h, 3, '.', '')
        );

        return json_decode(json_encode($json), false);
    }
}
