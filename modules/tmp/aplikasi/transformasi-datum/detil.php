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

<div class="container-fluid">
    <div class="container">
                <h3>Datum Transformation</h3><br>
        <h4><b>Survey Details</b></h4><br>
        <div class="row">
            <div class="col-md-6">
                <div id="mapid" style="height: 450px; width: 100%;"></div>
            </div>
            <div class="col-md-6">
<?php $d=get_survey_data($var[1]);?>
                <span style="display: inline-block; width: 150px">Survey name</span>: <b><?=$d->survey_name?></b><br>
                <span style="display: inline-block; width: 150px">Survey date</span>: <?=$d->survey_date?><br>
                <span style="display: inline-block; width: 150px">Old Datum</span>: <?=$d->old_datum?><br>
                <span style="display: inline-block; width: 150px">New Datum</span>: <?=$d->new_datum?><br>
                <span style="display: inline-block; width: 150px">Creator</span>: <?=$d->name?><br>
                <span style="display: inline-block; width: 150px">Description</span>: <?=$d->description?><br>
                <span style="display: inline-block; width: 150px">Date Created</span>: <?=$d->created_at?><br>
                <br>

                <b>Upload Points</b><br>
                    <label>Choose A System Coordinate</label>
                    <select name="coordinate" id="coordinate" class="browser-default custom-select" required>
                        <option value="">~~Choose One~~</option>
<?php $d=coord_list();foreach($d as $k => $v){?>
                        <option value="<?=$v->id_sys?>"><?=$v->sys_name?></option>
<?php }?>
                    </select><br><br>
                    <label>Data Delimiter</label><br>
                    <select name="delimiter" id="delimiter" class="browser-default custom-select" required>
                        <option value="1">Tab delimiter</option>
                        <option value="2">Coma delimiter (,)</option>
                        <option value="3">Semicolon delimiter (;)</option>
                    </select><br><br>
                    <div id="detail"></div>
                    <label>Upload File</label><br>
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#uploads" onclick="pre_upload()">Upload</button><br>
                    <small style="color: #ff0000">NOTE: Re-uploading data will replace the current data points.</small>
                <br>
            </div>
        </div>
        <hr>
        <h4><b>Survey Points</b></h4><br>
            <div style="text-align: center">
                <button type="submit" class="btn btn-primary" onclick="calculate_now()">Calculate NOW</button>
            </div>

            <div id="dataPoints">
                <b>Data In Use</b><br>
                <div>
                    <table class="table">
                        <tr>
                            <th>Point Name</th>
                            <th>X1</th>
                            <th>Y1</th>
                            <th>Z1</th>
                            <th>X2</th>
                            <th>Y2</th>
                            <th>Z2</th>
                            <th></th>
                        </tr>
<?php $points=get_survey_points_($var[1]);foreach($points as $k => $p)if($p->is_used == 1){if($p->bursawolf_passing_status == 0)echo'
                            <tr>'.chr(10);
                            elseif($p->bursawolf_passing_status == 1 && $p->molobas_passing_status == 1)echo '
                        <tr style="background-color: #c2ffce">'.chr(10);else echo '
                            <tr style="background-color: #ffcac7">'.chr(10);?>
                            <td><?=$p->point_name?></td>
                            <td><?=$p->X1?></td>
                            <td><?=$p->Y1?></td>
                            <td><?=$p->Z1?></td>
                            <td><?=$p->X2?></td>
                            <td><?=$p->Y2?></td>
                            <td><?=$p->Z2?></td>
                            <td><button type="button" onclick="setStash('<?=$p->id_point?>')" class="btn btn-sm btn-danger">throw</button></td>
                        </tr>
<?php }?>
                    </table>
                </div>
                <br>
                <b>Data In Stash</b><br>
                <div>
                    <table class="table">
                        <tr>
                            <th>Point Name</th>
                            <th>X1</th>
                            <th>Y1</th>
                            <th>Z1</th>
                            <th>X2</th>
                            <th>Y2</th>
                            <th>Z2</th>
                            <th></th>
                        </tr>
<?php foreach($points as $k => $p)if($p->is_used == 0){if($p->bursawolf_passing_status == 0)echo'
                            <tr>'.chr(10);
                            elseif($p->bursawolf_passing_status == 1 && $p->molobas_passing_status == 1)echo '
                        <tr style="background-color: #c2ffce">'.chr(10);else echo '
                            <tr style="background-color: #ffcac7">'.chr(10);?>
                            <td><?=$p->point_name?></td>
                            <td><?=$p->X1?></td>
                            <td><?=$p->Y1?></td>
                            <td><?=$p->Z1?></td>
                            <td><?=$p->X2?></td>
                            <td><?=$p->Y2?></td>
                            <td><?=$p->Z2?></td>
                            <td><button type="button" onclick="reuse('<?=$p->id_point?>')" class="btn btn-sm btn-primary">throw</button></td>
                        </tr>
<?php }?>
                    </table>
                </div>
            </div>
                <hr>

        <h4><b>Bursawolf Details</b></h4><br>
<?php $d=get_bursawolf($var[1]);if($d!=null){?>
            <span style="display: inline-block; width: 50px">Tx</span>: <span style="display: inline-block; width: 200px"><?=$d->dx?> m</span> <u>+</u> <?=abs($d->dx_uncertainty)?> m<br>
            <span style="display: inline-block; width: 50px">Ty</span>: <span style="display: inline-block; width: 200px"><?=$d->dy?> m</span> <u>+</u> <?=abs($d->dy_uncertainty)?> m<br>
            <span style="display: inline-block; width: 50px">Tz</span>: <span style="display: inline-block; width: 200px"><?=$d->dz?> m</span> <u>+</u> <?=abs($d->dz_uncertainty)?> m<br>
            <span style="display: inline-block; width: 50px">εx</span>: <span style="display: inline-block; width: 200px"><?=$d->ex?> rad</span> <u>+</u> <?=abs($d->ex_uncertainty)*pow(10,6)?> μrad<br>
            <span style="display: inline-block; width: 50px">εy</span>: <span style="display: inline-block; width: 200px"><?=$d->ey?> rad</span> <u>+</u> <?=abs($d->ey_uncertainty)*pow(10,6)?> μrad<br>
            <span style="display: inline-block; width: 50px">εz</span>: <span style="display: inline-block; width: 200px"><?=$d->ex?> rad</span> <u>+</u> <?=abs($d->ez_uncertainty)*pow(10,6)?> μrad<br>
            <span style="display: inline-block; width: 50px">ds</span>: <span style="display: inline-block; width: 200px"><?=$d->ds?></span> <u>+</u> <?=abs($d->ds_uncertainty)*pow(10,6)?> ppm<br>
<?php }?>
                <hr>
        <h4><b>Molodensky Badekas Details</b></h4><br>
<?php $d=get_molobas($var[1]);if($d!=null){?>
            <span style="display: inline-block; width: 50px">Tx</span>: <span style="display: inline-block; width: 200px"><?=$d->dx?> m</span> <u>+</u> <?=abs($d->dx_uncertainty)?> m<br>
            <span style="display: inline-block; width: 50px">Ty</span>: <span style="display: inline-block; width: 200px"><?=$d->dy?> m</span> <u>+</u> <?=abs($d->dy_uncertainty)?> m<br>
            <span style="display: inline-block; width: 50px">Tz</span>: <span style="display: inline-block; width: 200px"><?=$d->dz?> m</span> <u>+</u> <?=abs($d->dz_uncertainty)?> m<br>
            <span style="display: inline-block; width: 50px">εx</span>: <span style="display: inline-block; width: 200px"><?=$d->ex?> rad</span> <u>+</u> <?=abs($d->ex_uncertainty)*pow(10,6)?> μrad<br>
            <span style="display: inline-block; width: 50px">εy</span>: <span style="display: inline-block; width: 200px"><?=$d->ey?> rad</span> <u>+</u> <?=abs($d->ey_uncertainty)*pow(10,6)?> μrad<br>
            <span style="display: inline-block; width: 50px">εz</span>: <span style="display: inline-block; width: 200px"><?=$d->ex?> rad</span> <u>+</u> <?=abs($d->ez_uncertainty)*pow(10,6)?> μrad<br>
            <span style="display: inline-block; width: 50px">ds</span>: <span style="display: inline-block; width: 200px"><?=$d->ds?></span> <u>+</u> <?=abs($d->ds_uncertainty)*pow(10,6)?> ppm<br>
<?php }?>
                <hr>
    </div>
    <script type="text/javascript">
        function calculate_now(){
            $.get(DT,{calculate:<?=$var[1]?>},function(data){
                if(alert_ok(data,'ok'))
                document.location.reload();
            });
        }
        function load_data_(){
            var data={id_survey:<?=$var[1]?>,coord:$('#coordinate').val(),delimit:$('#delimiter').val(),structure:null,hemi:null,zone:null,meridianCentral:null}
            if($('#structure').length!=0) data.structure=$('#structure').val();
            if($('#hemi').length!=0) data.hemi=$('#hemi').val();
            if($('#zone').length!=0) data.zone=$('#zone').val();
            if($('#meridianCentral').length!=0) data.meridianCentral=$('#meridianCentral').val();
            $.get(DT,data,function(data){
                document.location.reload();
            })
        }
        var grup = L.layerGroup();
        var mymap = L.map('mapid', {
            gestureHandling: true
        }).setView([-1.978455, 114.855697], 5);
        mymap.addLayer(grup);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            accessToken: 'pk.eyJ1IjoiYWNobWFkeW9naSIsImEiOiJja2dkMnR0a2swdGVmMnlxYXA2eXNnbXNxIn0.zRgg5AZXShJtOq-daasDNA'
        }).addTo(mymap);

        var marker;
        function onMapClick(e) {
            var a = e.latlng.toString().split("(");
            var b = a[1].split(")");
            var c = b[0].split(", ");
            var lat = c[0]; var lon = c[1];
            if(marker){
                mymap.removeLayer(marker);
            }
            marker = L.marker([lat, lon]).addTo(mymap);
            marker.bindPopup(lat+", "+lon).openPopup();

            document.getElementById('lat').value = lat;
            document.getElementById('lon').value = lon;

            $('#result').empty();
        }

        mymap.on('click', onMapClick);

        var min_lat = 100, max_lat = -100, min_lon = 200, max_lon = -200;
        var dotting, latlng;
        function plotme(lat, lon){
            if(isNaN(lat) == false && isNaN(lon) == false){
                if(lat > -90 && lat < 90 && lon > -180 && lon < 180){
                    if(lat < min_lat){
                        min_lat = lat;
                    }
                    if(lat > max_lat){
                        max_lat = lat;
                    }
                    if(lon < min_lon){
                        min_lon = lon;
                    }
                    if(lon > max_lon){
                        max_lon = lon;
                    }
                    $('#result').empty();
                    var markerOpt = {
                        radius: 4,
                        fillColor: "#ff7800",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8
                    };

                    latlng = L.latLng(lat, lon);
                    dotting = L.circleMarker(latlng, markerOpt);
                    grup.addLayer(dotting);
                }
            }
        }

        function plotme2(lat, lon){
            if(isNaN(lat) == false && isNaN(lon) == false){
                if(lat > -90 && lat < 90 && lon > -180 && lon < 180){
                    if(lat < min_lat){
                        min_lat = lat;
                    }
                    if(lat > max_lat){
                        max_lat = lat;
                    }
                    if(lon < min_lon){
                        min_lon = lon;
                    }
                    if(lon > max_lon){
                        max_lon = lon;
                    }
                    $('#result').empty();
                    var markerOpt = {
                        radius: 4,
                        fillColor: "#9124b5",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8
                    };

                    latlng = L.latLng(lat, lon);
                    dotting = L.circleMarker(latlng, markerOpt);
                    grup.addLayer(dotting);
                }
            }
        }

        function addBounds(){
            mymap.fitBounds([
                [min_lat, min_lon],
                [max_lat, max_lon]
            ]);
            min_lat = 100, max_lat = -100, min_lon = 200, max_lon = -200;
        }
    </script>
    <script type="text/javascript">
        var coord;
        var gd = "<label>Structure Data</label><br>" +
            "        <select name=\"structure\" id=\"structure\" class=\"browser-default custom-select\" required>" +
            "            <option value=\"1\">index lat1 lon1 h1 lat2 lon2 h2</option>" +
            "            <option value=\"2\">index lat1 dlat1 lon1 dlon1 h1 dh1 lat2 dlat2 lon2 dlon2 h2 dh2</option>" +
            "        </select><br><br>";
        var gs = "<label>Structure Data</label><br>" +
            "        <select name=\"structure\" id=\"structure\" class=\"browser-default custom-select\" required>" +
            "            <option value=\"3\">index X1 Y1 Z1 X2 Y2 Z2</option>" +
            "            <option value=\"4\">index X1 dX1 Y1 dY1 Z1 dZ1</option>" +
            "        </select><br><br>";
        var utm = "<label>Structure Data</label><br>" +
            "        <select name=\"structure\" id=\"structure\" class=\"browser-default custom-select\" required>" +
            "            <option value=\"5\">index x1 y1 h1 x2 y2 h2</option>" +
            "            <option value=\"6\">index x1 dx1 y1 dy1 z1 dz1 x2 dx2 y2 dy2 z2 dz2</option>" +
            "        </select><br><br>" +
            "        <label>Hemisphere</label><br>" +
            "        <select name=\"hemi\" id=\"hemi\" class=\"browser-default custom-select\" required>" +
            "           <option value='N'>N</option>" +
            "           <option value='S'>S</option>" +
            "        </select><br><br>" +
            "        <select name='zone' id=\"zone\" class=\"browser-default custom-select\" required>" +
            "           " +<?php for($i=1;$i<=60;$i++)echo '
            "               <option value=\''.$i.'\'>'.$i.'</option>" +
            "           " +';echo chr(10);?>
            "        </select><br><br>";
        var merc = "<label>Structure Data</label><br>" +
            "        <select name=\"structure\" id=\"structure\" class=\"browser-default custom-select\" required>" +
            "            <option value=\"5\">index x1 y1 h1 x2 y2 h2</option>" +
            "            <option value=\"6\">index x1 dx1 y1 dy1 z1 dz1 x2 dx2 y2 dy2 z2 dz2</option>" +
            "        </select><br><br>" +
            "       <label>Meridian Central</label><br>" +
            "       <input type='number' step='any' id=\"meridianCentral\" name='meridianCentral' class='form-control'><br>";
        $(document).ready(function(){
            $('#coordinate').change(function(){
                coord = $(this).val();
                if (coord == null){
                    $("#detail").empty();
                }else if (coord == 1){
                    $("#detail").empty();
                    $("#detail").html(gd);
                }else if(coord == 2){
                    $("#detail").empty();
                    $("#detail").html(gs);
                }else if (coord == 3){
                    $("#detail").empty();
                    $("#detail").html(utm);
                }else{
                    $("#detail").empty();
                    $("#detail").html(merc);
                }
            });
        });
    </script>
    <script type="text/javascript">
        function reuse(idPoint){
            $.get(DT, {
                'idPoint': idPoint,
                'isUsed': 1,
            }, function (data) {
                location.reload(); 
            });
        }

        function setStash(idPoint){
            $.get(DT, {
                'idPoint': idPoint,
                'isUsed': 0,
            }, function (data) {
                location.reload(); 
            });
        }
    </script>
    <script type="text/javascript">
        <?php
            foreach ($points as $p){
                echo "var gd1 = gs2gd(".$p->X1.",".$p->Y1.",".$p->Z1.");".chr(10);
                echo "plotme(gd1.lat,gd1.lon);".chr(10);
                echo "var gd2 = gs2gd(".$p->X2.",".$p->Y2.",".$p->Z2.");".chr(10);
                echo "plotme2(gd2.lat,gd2.lon);".chr(10);
            }
            echo "addBounds();"
        ?>
        </script>
</div>

<?php
$dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
$dir.='datumtransformasi/';if(!file_exists($dir))mkdir($dir,0755);
$dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
$dir.='upload/';if(!file_exists($dir))mkdir($dir,0755);
plupload($dir,'c','load_data_()',5,false);
?>
