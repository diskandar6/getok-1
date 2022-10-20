<?php

namespace App\Usecase;

use App\Ellipsoids;
use App\Engines\ReferenceSystem\Ellipsoid;

class CoordinateFactory{
    public static function EllipsoidFactory(int $idEllipsoid): Ellipsoid{
        $el = Ellipsoids::find($idEllipsoid);

        return Ellipsoid::builder()
            ->idEllipsoid($idEllipsoid)
            ->a($el->a)
            ->b($el->b)
            ->f($el->f)
            ->year($el->year)
            ->ellipsoidName($el->ellipsoid_name)
            ->build();
    }
}

?>
