<?php

namespace App\Engines\Coordinate;

/**
 * Class Simple3D
 * @package App\Engines\Coordinate
 */
class Simple3D extends Coordinate
{
	private $id, $x, $y, $z;

    /**
     * Simple3D constructor.
     * @param int|null $id
     * @param float $x
     * @param float $y
     * @param float $z
     */
	public function __construct(float $x, float $y, float $z, string $id = NULL) {
	    $this->id = $id;
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
	}

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @param float $x
     */
    public function setX(float $x): void
    {
        $this->x = $x;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @param float $y
     */
    public function setY(float $y): void
    {
        $this->y = $y;
    }

    /**
     * @return float
     */
    public function getZ(): float
    {
        return $this->z;
    }

    /**
     * @param float $z
     */
    public function setZ(float $z): void
    {
        $this->z = $z;
    }

    /**
     * @return mixed
     */
    public function toJsonObject() {
        $json = array(
            "id" => $this->id,
            "x" => number_format($this->x, 3, '.', ''),
            "y" => number_format($this->y, 3, '.', ''),
            "z" => number_format($this->z, 3, '.', '')
        );

        return json_decode(json_encode($json), false);
    }
}

?>
