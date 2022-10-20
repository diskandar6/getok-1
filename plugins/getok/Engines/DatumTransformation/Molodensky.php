<?php

namespace App\Engines\DatumTransformation;

use App\Engines\Coordinate\Geodetic;
use App\Engines\Coordinate\Simple3D;
use App\Engines\ReferenceSystem\Ellipsoid;
use phpDocumentor\Reflection\Types\Mixed_;

/**
 * Class Molodensky
 * @package App\Engines\DatumTransformation
 */
class Molodensky{

    /**
     * @param Geodetic $gd1
     * @param Simple3D $delta
     * @param Ellipsoid $ll1
     * @param Ellipsoid $ll2
     * @return Geodetic
     */
	public static function Standard(Geodetic $gd1, Simple3D $delta, Ellipsoid $ll1, Ellipsoid $ll2): Geodetic {

		// Delta values
		$da = $ll2->getA() - $ll1->getA();
		$df = $ll2->getF() - $ll1->getF();

		$dlat = rad2deg(
			( 1/($ll1->getM($gd1->getLat())+$gd1->getH()) ) *
			(
				- $delta->getX()*sin(deg2rad($gd1->getLat()))*cos(deg2rad($gd1->getLon()))
				- $delta->getY()*sin(deg2rad($gd1->getLat()))*sin(deg2rad($gd1->getLon()))
				+ $delta->getZ()*cos(deg2rad($gd1->getLat()))
				+ ($ll1->getN($gd1->getLat())*$ll1->getE2()*sin(deg2rad($gd1->getLat()))*cos(deg2rad($gd1->getLat()))*$da)/$ll1->getA()
				+ sin(deg2rad($gd1->getLat()))*cos(deg2rad($gd1->getLat()))*
					(
						$ll1->getM($gd1->getLat())/(1-$ll1->getF())
						+ $ll1->getN($gd1->getLat())*(1-$ll1->getF())
					)*$df
			)
		);

		$dlon = rad2deg(
			1/(($ll1->getN($gd1->getLat()) + $gd1->getH())*cos(deg2rad($gd1->getLat())))*
			($delta->getX()*sin(deg2rad($gd1->getLon())) + $delta->getY()*cos(deg2rad($gd1->getLon())))
			);

		$dh = $delta->getX()*cos(deg2rad($gd1->getLat()))*cos(deg2rad($gd1->getLon()))
			+ $delta->getY()*cos(deg2rad($gd1->getLat()))*sin(deg2rad($gd1->getLon()))
			+ $delta->getZ()*sin(deg2rad($gd1->getLat()))
			- $ll1->getA()*$da/$ll1->getN(deg2rad($gd1->getLat()))
			+ $ll1->getN($gd1->getLat())*(1-$ll1->getF())*pow(sin(deg2rad($gd1->getLat())),2)*$df;

		return new Geodetic($gd1->getLat() + $dlat, $gd1->getLon() + $dlon, $gd1->getH() + $dh, $gd1->getId());
	}

    /**
     * @param Geodetic $gd1
     * @param Simple3D $delta
     * @param Ellipsoid $ll1
     * @param Ellipsoid $ll2
     * @return Geodetic
     */
	public static function Abridge(Geodetic $gd1, Simple3D $delta, Ellipsoid $ll1, Ellipsoid $ll2): Geodetic{

		// Delta values
		$da = $ll2->getA() - $ll1->getA();
		$df = $ll2->getF() - $ll1->getF();

		$dlat = rad2deg(
			1/$ll1->getM($gd1->getLat())*
			(
				- $delta->getX()*sin(deg2rad($gd1->getLat()))*cos(deg2rad($gd1->getLon()))
				- $delta->getY()*sin(deg2rad($gd1->getLat()))*cos(deg2rad($gd1->getLon()))
				+ $delta->getZ()*cos(deg2rad($gd1->getLat()))
				+ ($ll1->getF()*$da + $ll1->getA()*$df)*sin(deg2rad(2*$gd1->getLat()))
			)
		);

		$dlon = rad2deg(
			1/($ll1->getN($gd1->getLat())*cos(deg2rad($gd1->getLat())))*
			(
				- $delta->getX()*sin(deg2rad($gd1->getLon()))
				+ $delta->getY()*cos(deg2rad($gd1->getLon()))
			)
		);

		$dh = $delta->getX()*cos(deg2rad($gd1->getLat()))*cos(deg2rad($gd1->getLon()))
			+ $delta->getY()*cos(deg2rad($gd1->getLat()))*sin(deg2rad($gd1->getLon()))
			+ $delta->getZ()*sin(deg2rad($gd1->getLat()))
			- $da
			+ ($ll1->getF()*$da + $ll1->getA()*$df)*pow(sin(deg2rad($gd1->getLat())),2);

        return new Geodetic($gd1->getLat() + $dlat, $gd1->getLon() + $dlon, $gd1->getH() + $dh, $gd1->getId());
	}
}
