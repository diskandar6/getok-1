function a(){
	return 6378137.0;
}

function b(){
	return 6356752.31424518;
}

function f(){
	var f;
	f = ( a() - b() )/a();
	return f;
}

// first exentricity
function e2(){
	var e2;
	e2 = ( Math.pow(a(),2) - Math.pow(b(),2) )/ Math.pow(a(),2);
	return e2;
}

// Second exentricity
function e2_(){
	var e2_;
	e2_ = ( Math.pow(a(),2) - Math.pow(b(),2) )/ Math.pow(b(),2);
	return e2_;
}

function deg2rad(deg){
	var res;
	res = deg * (Math.PI / 180);
	return res;
}

function rad2deg(rad){
	var res; rad = Number(rad);
	res = rad * (180 / Math.PI);
	return res;
}

function N(lat){
	var N; lat = Number(lat);
	N = a()/Math.sqrt(1 - e2()*Math.pow(Math.sin(deg2rad(lat)),2) );
	return N;
}

function gs2gd(X, Y, Z){
	X = Number(X); Y = Number(Y); Z = Number(Z);
	if(isNaN(X) == false && isNaN(Y) == false && isNaN(Z) == false){
		var p, teta, lat, lon, h, sys;
		// Menentukan nilai p
		p = Math.sqrt( Math.pow(X,2) + Math.pow(Y,2) );

		// Menentukan nilai teta
		teta = rad2deg(Math.atan((Z*a())/(p*b())));

		// Menentukan nilai lat
		lat = rad2deg(Math.atan( (Z+e2_()*b()*Math.pow(Math.sin(deg2rad(teta)),3) ) / (p - a()*e2()*Math.pow(Math.cos(deg2rad(teta)),3)) ));

		// Menentukan nilai lon
		lon = rad2deg(Math.atan(Y/X));
		if(Y>=0 && X <0 || Y<0 && X < 0){
			lon = lon + 180;
		}
		if(Y<0 && X >= 0){
			lon = lon + 360;
		}

		// Menentukan nilai h
		h = p/Math.cos(deg2rad(lat)) - N(lat);

		sys = {"lat": lat, "lon": lon, "h": h};

		return sys;
	}else{
		sys = {"lat": "nan", "lon": "nan", "h": "nan"};

		return sys;
	}
}

function utm2gd(easting, northing, h, zone, hemi){
	var x, y, central, M, miu, e, lat_init, D, Rm, T, C, lat, lon, sys;
	easting = Number(easting); northing = Number(northing); h = Number(h); zone = Number(zone);
	// Easting reduction
	x = easting - 500000;
	if(hemi == "S"){
		y = northing - 10000000;
	}else{
		y = northing;
	}

	// Meridian Tengah
	central = deg2rad((zone - 31)*6 + 3);

	M = y/0.9996;
	miu = M/( a() * ( 1 - e2()/4 - (3/64)*Math.pow(e2(),2) - (5/256)*Math.pow(e2(),3) ) );
	e = (1 - Math.sqrt(1 - e2()))/(1 + Math.sqrt(1 - e2()));

	lat_init = miu + ((3/2)*e - (27/32)*Math.pow(e,3))*Math.sin(2*miu) + ((21/16)*Math.pow(e,2) - (55/32)*Math.pow(e,4))*Math.sin(4*miu) + ((151/96)*Math.pow(e,3))*Math.sin(6*miu) + ((1097/512)*Math.pow(e,4))*Math.sin(8*miu);
	D = x/(N(rad2deg(lat_init))*0.9996);
	Rm = (a()*(1 - e2()))/(Math.pow((1 - e2()*Math.pow(Math.sin(lat_init),2)),(3/2)));
	T = Math.pow(Math.tan(lat_init),2);
	C = e2_()*Math.pow(Math.cos(lat_init),2);

	lat = lat_init - ((N(rad2deg(lat_init))*Math.tan(lat_init))/Rm) * (Math.pow(D,2)/2 - (5 + 3*T + 10*C - 4*Math.pow(C,2) - 9*e2_())*(Math.pow(D,4)/24) + (61 + 90*T + 298*C + 45*Math.pow(T,2) - 252*e2_() - 3*Math.pow(C,2))*(Math.pow(D,6)/720));
	lon = central + (D - (1 + 2*T + C)*(Math.pow(D,3)/6) + (5 - 2*C + 28*T - 3*Math.pow(C,2) + 8*e2_() + 24*Math.pow(T,2))*(Math.pow(D,6)/120) )/Math.cos(lat_init);

	sys = {"lat": rad2deg(lat),"lon": rad2deg(lon),"h": h};

	return sys;
}

function merc2gd(easting, northing, h, meridian_central) {

    lat = rad2deg(Math.atan(Math.sinh(northing/a())));
    lon = rad2deg(easting/a()) + meridian_central;

    sys = {"lat": lat,"lon": lon,"h": h};

    return sys;
}
