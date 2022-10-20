<main>
	<div class="container">
		<section class="section">

    <script type="text/javascript" src="/js/transformasi.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script>
        var DT='/data/<?=D_PAGE?>';
        var PT='/<?=D_PAGE?>';
    </script>

<div class="container-fluid">
<div class="row">
    <div class="col-md-6">
        <div id="mapid" style="height: 450px; width: 100%;"></div>
    </div>
    <div class="col-md-6">
        <h4>Transformasi Titik</h4>
        
            <form action="/<?=D_PAGE?>" method="post" enctype="multipart/form-data">
            <label>Datum Geodetik</label><br>
            <select name="datum" id="datum" class="browser-default custom-select" required>
<?php $data=$dbg->get_results("SELECT id_datum,datum_name FROM datums ");
foreach($data as $k => $v){?>
                <option value="<?=$v->id_datum?>"><?=$v->datum_name?></option>
<?php }?>
            </select><br><br>
            <div class="row">
                <div class="col-md-6">
                    <label>Sistem Koordinat Awal</label><br>
                    <select name="sys_in" id="sys_in" class="browser-default custom-select" required>
                        <option value="">~~Pilih Sistem Koordinat~~</option>
<?php $data=$dbg->get_results("SELECT id_sys,sys_name,sys_format FROM coordinate_systems");foreach($data as $k => $v){?>
                        <option value="<?=$v->id_sys?>"><?=$v->sys_name?> [<?=$v->sys_format?>]</option>
<?php }?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Sistem Koordinat Baru</label><br>
                    <select name="sys_out" id="sys_out" class="browser-default custom-select" required>
                        <option value="">~~Pilih Sistem Koordinat~~</option>
<?php foreach($data as $k => $v){?>
                        <option value="<?=$v->id_sys?>"><?=$v->sys_name?> [<?=$v->sys_format?>]</option>
<?php }?>
                    </select>
                </div>
            </div><br>
            <div id="lanjutan"></div>
        </form>
        <br>
        <hr>
        <div id="result"></div>
    </div>
</div>
<div id="wait" style="position: fixed; z-index: 9999; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); left: 0; top: 0; padding-top: 15%; display: none;">
    <div style="background-color: #fefefe; margin: auto;padding: 20px;border: 1px solid #888;width: 40%;">
        <img src="/assets/loading.gif" width="50px;"> <span style="display: inline-block;" id="prog">Reading data...</span>
        <div style="width: 100%; background-color: lightgrey; border:none; border-radius: 5px; height: 15px;" id="bar">
            <div style="width: 0%; background-color: #0769B0; border:none; border-radius: 5px; height: 15px;"></div>
        </div>
        <small id="bar_val"><i>0%</i></small><br><br>
        <button type="button" class="button-default" onclick="cancelMe()">Cancel</button>
    </div>
</div>
<?php
if(isset($_SESSION['exekusi_transformasi'])){?>
<script type="text/javascript">
        var prog = "Reading data...";
        var bar = 0;
            $('#prog').html('<?=$_SESSION["prog"]?>');
            $('#bar').html('<div style="width: <?=$_SESSION["bar"]?>%; background-color: #0769B0; border:none; border-radius: 5px; height: 15px;"></div>');
            $('#bar_val').html("<i><?=$_SESSION['bar']?>%</i>");
            $("#wait").css("display", "block");
            var lines = '<?=$_SESSION['lines']?>';
            var i = 1; var awal = 1; var akhir = 50;
            var sysi = '<?=$_SESSION['sys_in']?>';
            while(i < lines){
                awal = i;
                i = i + 50;
                akhir = i;
                if(akhir > lines){
                    akhir = lines;
                }
                if(sysi == 3){
                    $.get(DT,{
                        'sys_in': <?=$_SESSION['sys_in']?>,
                        'sys_out': <?=$_SESSION['sys_out']?>,
                        'structure': <?=$_SESSION['structure']?>,
                        'delimiter': <?=$_SESSION['delimiter']?>,
                        'hemi': "<?=$_SESSION['hemi']?>",
                        'zone': "<?=$_SESSION['zone']?>",
                        'lines': lines,
                        'awal': awal,
                        'akhir': akhir,
                        'lon_init': <?=$_SESSION['lon_init']?>,
                        'id_datum': <?=$_SESSION['id_datum']?>,
                    }, function(data, status){
                        var data=JSON.parse(data);
                        setTimeout(function(){
                            prog = data['prog'];
                            bar = data['bar'];
                            setContent(data['prog'], data['bar']);
                        },10);
                    });
                }else{
                    $.get(DT,{
                        'sys_in': <?=$_SESSION['sys_in']?>,
                        'sys_out': <?=$_SESSION['sys_out']?>,
                        'structure': <?=$_SESSION['structure']?>,
                        'delimiter': <?=$_SESSION['delimiter']?>,
                        'lines': lines,
                        'awal': awal,
                        'akhir': akhir,
                        'lon_init': <?=$_SESSION['lon_init']?>,
                        'id_datum': <?=$_SESSION['id_datum']?>,
                    }, function(data, status){
                        var data=JSON.parse(data);
                        setTimeout(function(){
                            prog = data['prog'];
                            bar = data['bar'];
                            setContent(data['prog'], data['bar']);
                        },10);
                    });
                };
            }

        function setContent(prog, bar){
            $('#prog').html(prog);
            $('#bar').html('<div style="width: '+bar+'%; background-color: #0769B0; border:none; border-radius: 5px; height: 15px;"></div>');
            $('#bar_val').html("<i>"+bar+"%</i>");

            if(bar >= 100){
                setTimeout(function(){
                    $("#wait").css("display", "none");
                    document.location='/data/<?=D_PAGE?>?download=<?=basename($_SESSION['restrf'])?>';
                }, 1000);
            }
        }

        function cancelMe(){
            $("#wait").css("display", "none");
            throw new Error("Execution has been aborted!");
        }
    </script>
<?php   unset($_SESSION['exekusi_transformasi']);
}?>
<script type="text/javascript">
$(document).ready(function(){
    $('#sys_in').change(function(){
        $.get(DT,{
            'sys_in': $(this).val(),
            'sys_out': $('#sys_out').val(),
        }, function(data, status){
            $('#lanjutan').html(data);
        });
    });
    $('#sys_out').change(function(){
        $.get(DT,{
            'sys_in': $('#sys_in').val(),
            'sys_out': $(this).val(),
        }, function(data, status){
            $('#lanjutan').html(data);
        });
    });
});
</script>
<script type="text/javascript">
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

    function addBounds(){
        mymap.fitBounds([
            [min_lat, min_lon],
            [max_lat, max_lon]
        ]);
        min_lat = 100, max_lat = -100, min_lon = 200, max_lon = -200;
    }
</script>

</div>

		</section>
	</div>
</main>

<?php
$dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
$dir.='transformasi/';if(!file_exists($dir))mkdir($dir,0755);
$dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
?>
