<?php

namespace App\Engines;

use App\Engines\Coordinate\Geocentric;
use App\Engines\Coordinate\Geodetic;
use App\Engines\Coordinate\Mercator;
use App\Engines\Coordinate\UTM;
use App\Engines\ReferenceSystem\Ellipsoid;

/**
 * Class MapProjection
 * @package App\Engines
 */
class MapProjection
{
    private $ellipsoid;

    public function __construct(Ellipsoid $ellipsoid) {
        $this->ellipsoid = $ellipsoid;
    }

    /*
    |--------------------------------------------------------------------------
    | Geodetic to All
    |--------------------------------------------------------------------------
    */

    /**
     * @param Geodetic $gd
     * @return Geocentric
     */
	public function gd2gs(Geodetic $gd): Geocentric{

        $X = ($this->ellipsoid->getN($gd->getLat()) + $gd->getH())*cos(deg2rad($gd->getLat()))*cos(deg2rad($gd->getLon()));
        $Y = ($this->ellipsoid->getN($gd->getLat()) + $gd->getH())*cos(deg2rad($gd->getLat()))*sin(deg2rad($gd->getLon()));
        $Z = ($this->ellipsoid->getN($gd->getLat())*(1 - $this->ellipsoid->getE2()) + $gd->getH())*sin(deg2rad($gd->getLat()));

        return new Geocentric($X, $Y, $Z, $gd->getId());
	}

    /**
     * @param Geodetic $gd
     * @return UTM
     */
	public function gd2utm(Geodetic $gd): UTM{
        // Menentukan zona
        $mer = (int)($gd->getLon()/6);
        if($mer < 0){
            $zone = 30 + $mer;
        }else{
            $zone = 30 + $mer + 1;
        }

        // Menentukan hemisphere
        if($gd->getLat() < 0){
            $hemi = "S";
        }else{
            $hemi = "N";
        }

        // Menentukan meridian central
        $central = deg2rad(($zone - 31)*6 + 3);

        // Konversi ke radian
        $lat = deg2rad($gd->getLat());
        $lon = deg2rad($gd->getLon());

        $T = pow(tan($lat),2);
        $C = $this->ellipsoid->getE2_()*pow(cos($lat),2);
        $A = ($lon - $central)*cos($lat);

        $M = $this->ellipsoid->getA()*( (1-($this->ellipsoid->getE2()/4)-((3*pow($this->ellipsoid->getE2(),2))/64)-((5*pow($this->ellipsoid->getE2(),3))/256) )*$lat - ( (3*$this->ellipsoid->getE2())/8 + (3*pow($this->ellipsoid->getE2(),2))/32 + (45*pow($this->ellipsoid->getE2(),3))/1024 )*sin(2*$lat) + ( (15*pow($this->ellipsoid->getE2(),2))/256 + (45*pow($this->ellipsoid->getE2(),3))/1024 )*sin(4*$lat) - ( (35*pow($this->ellipsoid->getE2(),3))/3072 )*sin(6*$lat) );

        $x = 0.9996*$this->ellipsoid->getN($gd->getLat())*( $A + (1 - $T + $C ) * ( pow($A,3)/6) + (5 - 18*$T + pow($T,2) + 72*$C - 58*$this->ellipsoid->getE2_())*(pow($A,5)/120) );
        $y = 0.9996*( $M + $this->ellipsoid->getN($gd->getLat())*tan($lat)*( pow($A,2)/2 + (5 - $T + 9*$C + 4*pow($C,2))*(pow($A,4)/24) + ( 61 - 58*$T + pow($T,2) + 600*$C - 330*$this->ellipsoid->getE2_() )*(pow($A,6)/720) ) );

        // Penambahan false easting dan northing
        $x = $x + 500000;
        if($hemi == "S"){
            $y = $y + 10000000;
        }

        return new UTM($x, $y, $gd->getH(), $zone, $hemi, $gd->getId());
	}

    /**
     * @param Geodetic $gd
     * @param float $lon_init
     * @return Mercator
     */
	public function gd2merc(Geodetic $gd, float $lon_init): Mercator{
        $x = $this->ellipsoid->getA()*(deg2rad($gd->getLon()) - deg2rad($lon_init));
        $y = $this->ellipsoid->getA()*atanh(sin(deg2rad($gd->getLat())));

        return new Mercator($x, $y, $gd->getH(), $lon_init, $gd->getId());
	}

	/*
	|--------------------------------------------------------------------------
	| All to Geodetic
	|--------------------------------------------------------------------------
	*/

    /**
     * @param Geocentric $gs
     * @return Geodetic
     */
	public function gs2gd(Geocentric $gs): Geodetic{

        // Menentukan nilai p
        $p = sqrt( pow($gs->getX(),2) + pow($gs->getY(),2) );

        // Menentukan nilai teta
        $teta = rad2deg(atan(($gs->getZ()*$this->ellipsoid->getA())/($p*$this->ellipsoid->getB())));


        // Menentukan nilai lat
        $lat = rad2deg(atan( ($gs->getZ()+$this->ellipsoid->getE2_()*$this->ellipsoid->getB()*pow(sin(deg2rad($teta)),3) ) / ($p - $this->ellipsoid->getA()*$this->ellipsoid->getE2()*pow(cos(deg2rad($teta)),3)) ));

        // Menentukan nilai lon
        $lon = rad2deg(atan($gs->getY()/$gs->getX()));
        if($gs->getY() >=0 && $gs->getX() <0 || $gs->getY() < 0 && $gs->getX() < 0){
            $lon = $lon + 180;
        }
        if($gs->getY() < 0 && $gs->getX() >= 0){
            $lon = $lon + 360;
        }

        // Menentukan nilai h
        $h = $p/cos(deg2rad($lat)) - $this->ellipsoid->getN($lat);

        return new Geodetic($lat, $lon, $h, $gs->getId());
	}

    /**
     * @param UTM $utm
     * @return Geodetic
     */
	public function utm2gd(UTM $utm): Geodetic{

        // Easting reduction
        $x = $utm->getEasting() - 500000;
        if($utm->getHemi() == "S"){
            $y = $utm->getNorthing() - 10000000;
        }else{
            $y = $utm->getNorthing();
        }

        // Meridian Tengah
        $central = deg2rad(($utm->getZone() - 31)*6 + 3);

        $M = $y/0.9996;
        $miu = $M/( $this->ellipsoid->getA() * ( 1 - $this->ellipsoid->getE2()/4 - (3/64)*pow($this->ellipsoid->getE2(),2) - (5/256)*pow($this->ellipsoid->getE2(),3) ) );
        $e = (1 - sqrt(1 - $this->ellipsoid->getE2()))/(1 + sqrt(1 - $this->ellipsoid->getE2()));

        $lat_init = $miu + ((3/2)*$e - (27/32)*pow($e,3))*sin(2*$miu) + ((21/16)*pow($e,2) - (55/32)*pow($e,4))*sin(4*$miu) + ((151/96)*pow($e,3))*sin(6*$miu) + ((1097/512)*pow($e,4))*sin(8*$miu);
        $D = $x/($this->ellipsoid->getN(rad2deg($lat_init))*0.9996);
        $Rm = ($this->ellipsoid->getA()*(1 - $this->ellipsoid->getE2()))/(pow((1 - $this->ellipsoid->getE2()*pow(sin($lat_init),2)),(3/2)));
        $T = pow(tan($lat_init),2);
        $C = $this->ellipsoid->getE2_()*pow(cos($lat_init),2);

        $lat = $lat_init - (($this->ellipsoid->getN(rad2deg($lat_init))*tan($lat_init))/$Rm) * (pow($D,2)/2 - (5 + 3*$T + 10*$C - 4*pow($C,2) - 9*$this->ellipsoid->getE2_())*(pow($D,4)/24) + (61 + 90*$T + 298*$C + 45*pow($T,2) - 252*$this->ellipsoid->getE2_() - 3*pow($C,2))*(pow($D,6)/720));
        $lon = $central + ($D - (1 + 2*$T + $C)*(pow($D,3)/6) + (5 - 2*$C + 28*$T - 3*pow($C,2) + 8*$this->ellipsoid->getE2_() + 24*pow($T,2))*(pow($D,6)/120) )/cos($lat_init);

        return new Geodetic(rad2deg($lat), rad2deg($lon), $utm->getH(), $utm->getId());

	}

    /**
     * @param Mercator $merc
     * @return Geodetic
     */
	public function merc2gd(Mercator $merc): Geodetic{

        $lat = rad2deg(atan(sinh($merc->getNorthing()/$this->ellipsoid->getA())));
        $lon = rad2deg($merc->getEasting()/$this->ellipsoid->getA()) + $merc->getMeridianCentral();

        return new Geodetic($lat, $lon, $merc->getH(), $merc->getId());
	}
}

?>
