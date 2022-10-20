<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="dMC2ZM5eVUnLIMxJUkPyv7c1yeCZuDM30tdsY39h">

    <title>GETOK | Home</title>
    <link rel="shortcut icon" href="/assets/logo/36.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/app.css" type="text/css">
    <script type="text/javascript" src="/js/transformasi.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <link rel="stylesheet" href="//unpkg.com/leaflet-gesture-handling/dist/leaflet-gesture-handling.min.css"
          type="text/css">
    <script src="//unpkg.com/leaflet-gesture-handling"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <?=meta_google_signin()?>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <br>
            <h1 style="display: inline-block; font-family: nunito, arial"><a href="" style="text-decoration: none; color: black"><b>GETOK</b></a></h1>
            <span style="display: inline-block;width: 5px;"></span>
            <p style="display: inline-block;">Engines for various geodetic computation.</p>
        </div>
        <div class="col-md-2">
            <div style="text-align: right;">
<?php $a='login';if(isset($_SESSION['id']))$a='logout';?>
                <a href="/<?=$a?>" style="color: grey;" <?php if($a=='logout')echo 'onclick="signOut()"'?>><span class="fa fa-user"></span> <?=ucfirst($a)?></a>
            </div>
        </div>
    </div>

    <br><br>
<div class="row">
            <div class="col-md-3">
        <div class="card" style="height: 450px;">
            <div style='width: 100%; height: 200px; overflow: hidden;margin-top: 0px; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px;'>
                                    <img class = "card-image" src="img/coordinate.png" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' height='450px;' alt='user'>
                                <div class="overlay">
                    <div class="overlay-text">
                                                     <a href="/coordinate-conversion" style="text-decoration: none;"><button type="button" class="button-default">buka</button></a>
                                            </div>
                </div>
            </div>
            <div class="card-content">
                <h4 style="margin-top: 10px;">Coordinate Conversion</h4>
                <p>Converting coordinate systems</p>
                <br>
                                    <span style="color: #c2c2c2" title="public free access"><span class="fa fa-users"></span> public</span><br>
                                <a href="#">>> about the app</a><br><br>
            </div>
        </div><br><br>
    </div>
        <div class="col-md-3">
        <div class="card" style="height: 450px;">
            <div style='width: 100%; height: 200px; overflow: hidden;margin-top: 0px; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px;'>
                                    <img class = "card-image" src="img/gnss.png" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' height='450px;' alt='user'>
                                <div class="overlay">
                    <div class="overlay-text">
                                                     <a href="/gnss" style="text-decoration: none;"><button type="button" class="button-default">buka</button></a>
                                            </div>
                </div>
            </div>
            <div class="card-content">
                <h4 style="margin-top: 10px;">GNSS Processing</h4>
                <p>Calculating rinnex data from GNSS measurements</p>
                <br>
                                    <span style="color: #c2c2c2" title="limited access"><span class="fa fa-university"></span> limited</span><br>
                                <a href="#">>> about the app</a><br><br>
            </div>
        </div><br><br>
    </div>
        <div class="col-md-3">
        <div class="card" style="height: 450px;">
            <div style='width: 100%; height: 200px; overflow: hidden;margin-top: 0px; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px;'>
                                    <img class = "card-image" src="img/geoid.jpg" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' height='450px;' alt='user'>
                                <div class="overlay">
                    <div class="overlay-text">
                                                     <a href="/geoid-calculator" style="text-decoration: none;"><button type="button" class="button-default">buka</button></a>
                                            </div>
                </div>
            </div>
            <div class="card-content">
                <h4 style="margin-top: 10px;">Geoid Calculator</h4>
                <p>Retrieving geoid values of Indonesian territory</p>
                <br>
                                    <span style="color: #c2c2c2" title="public free access"><span class="fa fa-users"></span> public</span><br>
                                <a href="#">>> about the app</a><br><br>
            </div>
        </div><br><br>
    </div>
        <div class="col-md-3">
        <div class="card" style="height: 450px;">
            <div style='width: 100%; height: 200px; overflow: hidden;margin-top: 0px; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px;'>
                                    <img class = "card-image" src="img/adj.png" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' height='450px;' alt='user'>
                                <div class="overlay">
                    <div class="overlay-text">
                                                     <a href="/perataan" style="text-decoration: none;"><button type="button" class="button-default">buka</button></a>
                                            </div>
                </div>
            </div>
            <div class="card-content">
                <h4 style="margin-top: 10px;">Adjustment Computation</h4>
                <p>Adjustment computation for land surveying</p>
                <br>
                                    <span style="color: #c2c2c2" title="limited access"><span class="fa fa-university"></span> limited</span><br>
                                <a href="#">>> about the app</a><br><br>
            </div>
        </div><br><br>
    </div>
        <div class="col-md-3">
        <div class="card" style="height: 450px;">
            <div style='width: 100%; height: 200px; overflow: hidden;margin-top: 0px; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px;'>
                                    <img class = "card-image" src="img/datum-trans.png" style='position:absolute; left: -100%; right: -100%; top: -100%; bottom: -100%; margin: auto; min-height: 100%; min-width: 100%;' height='450px;' alt='user'>
                                <div class="overlay">
                    <div class="overlay-text">
                                                     <a href="/transformasi-datum" style="text-decoration: none;"><button type="button" class="button-default">buka</button></a>
                                            </div>
                </div>
            </div>
            <div class="card-content">
                <h4 style="margin-top: 10px;">Datum Transformation</h4>
                <p>Transforming datums using local data from local measurements.</p>
                <br>
                                    <span style="color: #c2c2c2" title="limited access"><span class="fa fa-university"></span> limited</span><br>
                                <a href="#">>> about the app</a><br><br>
            </div>
        </div><br><br>
    </div>
    </div>
</div>
<div style="text-align: center;">
    <br>
    <small>Copyright &copy PT Pertamina<br> All rights reserved</small>
</div>
</body>
</html>
