<?php

namespace App\Engines\Coordinate;

/**
 * Class Geocentric
 * @package App\Engines\Coordinate
 */
class Geocentric extends Coordinate
{
	private $id, $X, $Y, $Z;

    /**
     * Geocentric constructor.
     * @param string|null $id
     * @param float $X
     * @param float $Y
     * @param float $Z
     */
	public function __construct(float $X, float $Y, float $Z, string $id = NULL){
		$this->id = $id;
        $this->X = $X;
        $this->Y = $Y;
        $this->Z = $Z;
	}

    /**
     * @return string
     */
    public function getId(): string{
	    return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void{
        $this->id = $id;
    }

    /**
     * @return float
     */
	public function getX(): float{
		return $this->X;
	}

    /**
     * @return float
     */
	public function getY(): float{
		return $this->Y;
	}

    /**
     * @return float
     */
	public function getZ(): float{
		return $this->Z;
	}

    /**
     * @param float $X
     */
	public function setX(float $X): void{
		$this->X = $X;
	}

    /**
     * @param float $Y
     */
	public function setY(float $Y): void{
		$this->Y = $Y;
	}

    /**
     * @param float $Z
     */
	public function setZ(float $Z): void{
		$this->Z = $Z;
	}

    /**
     * @return mixed
     */
    public function toJsonObject() {
        $json = array(
            "id" => $this->id,
            "X" => number_format($this->X, 3, '.', ''),
            "Y" => number_format($this->Y, 3, '.', ''),
            "Z" => number_format($this->Z, 3, '.', '')
        );

        return json_decode(json_encode($json), false);
    }
}
