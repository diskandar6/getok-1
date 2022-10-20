<?php

namespace App\Engines;

//use Illuminate\Support\Facades\DB;
use MathPHP\LinearAlgebra\MatrixFactory;

/**
 * Class GeoClass
 * @package App\Engines
 */
class GeoClass
{
	public static function Bilinear($lat, $lon){
		//$data = DB::select("SELECT * FROM `geoid`WHERE ABS(lat - (?)) <= 0.083333 AND ABS(lon - (?)) <= 0.083333 ORDER BY lat ASC", [$lat, $lon]);
		$data = $GLOBALS['dbg']->get_results("SELECT * FROM `geoid` WHERE ABS(lat - $lat) <= 0.083333 AND ABS(lon - $lon) <= 0.083333 ORDER BY lat ASC");
		
		$c = 0;
		foreach ($data as $d) {
			$arr_lat[$c] = $d->lat;
			$arr_lon[$c] = $d->lon;
			$arr_N[$c] = $d->N;
			$c += 1;
		}

		if($c < 4){
			return "out of range";
		}else{
			/*
				BILINEAR INTERPOLATION
				[0] x1, y1
				[1] x2, y1
				[2] x1, y2
				[3] x2, y2
			*/
			$x = $lon; $y = $lat;
			$x1 = $arr_lon[0];
			$x2 = $arr_lon[1];
			$y1 = $arr_lat[0];
			$y2 = $arr_lat[2];

			// Interpolation in X (lon) direction
			$fxy1 = (($x2 - $x)/($x2 - $x1))*$arr_N[0] + (($x - $x1)/($x2 - $x1))*$arr_N[1];
			$fxy2 = (($x2 - $x)/($x2 - $x1))*$arr_N[2] + (($x - $x1)/($x2 - $x1))*$arr_N[3];

			$bag1 = 1/(($x2-$x1)*($y2-$y1));
			$mat_bag2 = [
				[($x2 - $x), ($x - $x1)],
			];
			$bag2 = MatrixFactory::create($mat_bag2);
			$mat_bag3 = [
				[$arr_N[0], $arr_N[2]],
				[$arr_N[1], $arr_N[3]],
			];
			$bag3 = MatrixFactory::create($mat_bag3);
			$mat_bag4 = [
				[($y2 - $y)],
				[($y - $y1)],
			];
			$bag4 = MatrixFactory::create($mat_bag4);

			$N_ = $bag2->multiply($bag3)->multiply($bag4);
			$N = $bag1*$N_[0][0];

			return number_format($N, 3, '.', '')." m";
		}
	}

	public function BilinearV2($lat, $lon){
		//$data = DB::select("SELECT * FROM `geoid` WHERE ABS(lat - (?)) < 0.085 AND ABS(lon - (?)) < 0.085 ORDER BY lat ASC", [$lat, $lon]);
		$data = $GLOBALS['dbg']->get_results("SELECT * FROM `geoid` WHERE ABS(lat - $lat) < 0.085 AND ABS(lon - $lon) < 0.085 ORDER BY lat ASC");
		
		$c = 0;
		foreach ($data as $d) {
			$arr_lat[$c] = $d->lat;
			$arr_lon[$c] = $d->lon;
			$arr_N[$c] = $d->N;
			$c += 1;
		}

		if($c < 4){
			return "out of range";
		}else{
			/*
				BILINEAR INTERPOLATION
				[0] x1, y1
				[1] x2, y1
				[2] x1, y2
				[3] x2, y2
			*/
			$x1 = $arr_lon[0];
			$x2 = $arr_lon[1];
			$y1 = $arr_lat[0];
			$y2 = $arr_lat[2];

			// Interpolation in X (lon) direction
			$mat_A = [
				[1, $x1, $y1, $x1*$y1],
				[1, $x1, $y2, $x1*$y2],
				[1, $x2, $y1, $x2*$y1],
				[1, $x2, $y2, $x2*$y2],
			];
			$A = MatrixFactory::create($mat_A);

			$mat_B = [
				[$arr_N[0]],
				[$arr_N[2]],
				[$arr_N[1]],
				[$arr_N[3]],
			];
			$B = MatrixFactory::create($mat_B);

			$x = $A->inverse()->multiply($B);

			$N = $x[0][0] + $x[1][0]*$lon + $x[2][0]*$lat + $x[3][0]*$lat*$lon;

			return number_format($N, 3, '.', '')." m";
		}
	}
}

?>
