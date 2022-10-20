<?php

namespace App\Engines\Coordinate;

/**
 * Class Simple2D
 * @package App\Engines\Coordinate
 */
class Simple2D extends Coordinate
{
	private $id, $x, $y;

    /**
     * Simple2D constructor.
     * @param int|null $id
     * @param float $x
     * @param float $y
     */
	public function __construct(float $x, float $y, string $id = NULL) {
	    $this->id = $id;
		$this->x = $x;
		$this->y = $y;
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
     * @return mixed
     */
    public function toJsonObject() {
        $json = array(
            "id" => $this->id,
            "x" => number_format($this->x, 3, '.', ''),
            "y" => number_format($this->y, 3, '.', ''),
        );

        return json_decode(json_encode($json), false);
    }
}

?>
