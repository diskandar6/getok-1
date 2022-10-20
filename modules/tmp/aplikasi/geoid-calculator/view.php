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

<main>
	<div class="container">
		<section class="section">

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-10">
            <br>
            <h1 style="display: inline-block; font-family: nunito, arial"><a href="/" style="text-decoration: none; color: black"><b>GETOK</b></a></h1>
            <span style="display: inline-block;width: 5px;"></span>
            <p style="display: inline-block;">Engines for various geodetic computation.</p>
        </div>
        <div class="col-md-2">
            <div style="text-align: right;">
                <a href="/login" style="color: grey;: none;"><span class="fa fa-user"></span> Login</a>
            </div>
        </div>
    </div>
<style type="text/css">
    #isi{
        position:fixed;
        top:80px;
        bottom:0;
        left:0;
        width:100%;
    }
    #mapid{
        position:absolute;
        padding:0;
        margin:0;

        top:0;
        left:25%;

        width: 80%;
        height: 100%;
        z-index: 99;
    }
    #legend{
        position: absolute;
        padding: 5px 10px 5px 10px;
        margin: 0;

        top: 20px;
        right: 20px;

        width: 250px;
        height: 80px;
        z-index: 999;

        background-color: white;
        border-radius: 5px;
    }
    #konten{
        position: absolute;
        padding: 10px 20px 10px 20px;
        margin: 0;

        top: 0;
        left: 0;

        width: 25%;
        height: 100%;

        background-color: lightgrey;
        overflow-y: auto;
    }
    #grad{
        height: 10px;
        width: 100%;
        background-image: linear-gradient(to right, #234ecf, #29d946, yellow, red);
    }
</style>
<div id="isi">
    <div id="mapid"></div>
    <div id="legend">
        <b>Legenda</b>
        <table style="width: 100%">
            <tr>
                <th style="text-align: left;">-64 m</th>
                <th style="text-align: right;">85 m</th>
            </tr>
        </table>
        <div id="grad"></div>
    </div>
    <div id="konten">
        <br>
        <h1 style="display: inline-block; font-family: nunito, arial"><a href="/" style="text-decoration: none; color: black"><b>GETOK</b></a></h1>
        <p>Engines for Various Geodetic Computation</p>
        <hr>
        <h4><b>Geoid Undulation (N)</b></h4><br>
        <label>Latitude (decimal degrees)</label>
        <input type="number" class="form-control" name="lat" placeholder="latitude" id="lat"><br><br>
        <label>Longitude (decimal degrees)</label>
        <input type="number" class="form-control" name="lon" placeholder="longitude" id="lon"><br><br>
        <label>Geid Value (meters)</label>
        <input type="text" class="form-control" name="N" placeholder="geoid undulation" id="N" disabled><br><br>
        <hr>
        <h4><b>Geoid Calculation using Files</b></h4><br>
        <form action="/geoid-calculator" method="post" enctype="multipart/form-data">
            <label>Format Data</label><br>
            <select name="format" id="format" class="browser-default custom-select" required>
                <option value="1">index lat lon</option>
                <option value="2">index lon lat</option>
                <option value="3">lat lon</option>
                <option value="4">lon lat</option>
            </select><br><br>
            <label>Data Delimiter</label><br>
            <select name="delimiter" id="delimiter" class="browser-default custom-select" required>
                <option value="1">Tab delimiter</option>
                <option value="2">Coma delimiter (,)</option>
                <option value="3">Semicolon delimiter (;)</option>
            </select><br><br>
            <label>Upload File</label><br>
            <input type="file" name="file" id="excelfile"><br><br>
            <input type="hidden" value="" id="lines" name="lines">
            <input type="hidden" name="uclassic" value="1">
            <input type="hidden" name="nextstep" value="proses_data_geoid">
            <button type="submit" class="btn btn-primary">Calculate</button><br>
            <small><i>Akan ditampilkan sampel data Anda hingga 1000 data.</i></small>
        </form><br>
        <hr>
    
    </div>
</div>
<div id="wait" style="position: fixed; z-index: 9999; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); left: 0; top: 0; padding-top: 15%; display: none;">
    <div id="iffine" style="background-color: #fefefe; margin: auto;padding: 20px;border: 1px solid #888;width: 40%;">
        <img src="/assets/loading.gif" width="50px;"> <span style="display: inline-block;" id="prog">Reading data...</span>
        <div style="width: 100%; background-color: lightgrey; border:none; border-radius: 5px; height: 15px;" id="bar">
            <div style="width: 0%; background-color: #0769B0; border:none; border-radius: 5px; height: 15px;"></div>
        </div>
        <small id="bar_val"><i>0%</i></small><br><br>
        <button type="button" class="button-default" onclick="cancelMe()">Cancel</button>
    </div>
</div>
<?php if(isset($_SESSION['exekusi_geoid'])){?>
    <script type="text/javascript">
        var prog = "Reading data...";
        var bar = 0;
        $('#prog').html('<?=$_SESSION["prog"]?>');
        $('#bar').html('<div style="width: <?=$_SESSION["bar"]?>%; background-color: #0769B0; border:none; border-radius: 5px; height: 15px;"></div>');
        $('#bar_val').html("<i><?=$_SESSION["bar"]?>%</i>");
        $("#wait").css("display", "block");
        var lines = <?=$_SESSION['lines']?>;
        var i = 1; var awal = 1; var akhir = 50;
        while(i < lines){
            awal = i;
            i = i + 50;
            akhir = i;
            if(akhir > lines){
                akhir = lines;
            }
            $.get(DT,{
                'format': <?=$_SESSION['format']?>,
                'delimiter': <?=$_SESSION['delimiter']?>,
                'lines': lines,
                'awal': awal,
                'akhir': akhir,
            }, function(data, status){
                var data=JSON.parse(data);
                setTimeout(function(){
                    prog = data['prog'];
                    bar = data['bar'];
                    setContent(data['prog'], data['bar']);
                },10);
            });
        }

        function setContent(prog, bar){
            $('#prog').html(prog);
            $('#bar').html('<div style="width: '+bar+'%; background-color: #0769B0; border:none; border-radius: 5px; height: 15px;"></div>');
            $('#bar_val').html("<i>"+bar+"%</i>");

            if(bar >= 100){
                setTimeout(function(){
                    $("#wait").css("display", "none");
                    document.location='/data/<?=D_PAGE?>?download=<?=basename($_SESSION['resgeoid'])?>';
                }, 1000);
            }
        }

        function cancelMe(){
            $("#wait").css("display", "none");
            throw new Error("Execution has been aborted!");
        }
    </script>
<?php unset($_SESSION['exekusi_geoid']);
}?>
<script type="text/javascript" src="/js/heatmap.min.js"></script>
<script type="text/javascript" src="/js/leaflet-heatmap.js"></script>
<?php require __DIR__.'/dataundulasi.php';?>
<script type="text/javascript">
    function eksekusi(){
        grup.clearLayers();
        var files = document.getElementById("excelfile").files;
        if (!files.length) {
            setTimeout(function() {
                addBounds();
            }, 10);
        }else{
            var file = files[0];
            var reader = new FileReader();

            // If we use onloadend, we need to check the readyState.
            reader.onloadend = function(evt) {
                if (evt.target.readyState == FileReader.DONE) {
                    var konten = evt.target.result;
                    var lines = konten.split('\n');
                    document.getElementById('lines').value = lines.length;
                    var myobj;
                    var delimiter = document.getElementById("delimiter").value;
                    var format = document.getElementById("format").value;
                    for(i=0; i<lines.length; i++){
                        if(i <= 1000){
                            if(delimiter == 1){
                                myobj = lines[i].split('\t');
                            }else if(delimiter == 2){
                                myobj = lines[i].split(',');
                            }else{
                                myobj = lines[i].split(';');
                            }
                            if(format == 1){
                                plotme(myobj[1],myobj[2]);
                            }else if(format == 3){
                                plotme(myobj[0],myobj[1]);
                            }else if(format == 2){
                                plotme(myobj[2],myobj[1]);
                            }else if(format == 4){
                                plotme(myobj[1],myobj[0]);
                            }
                        }
                    }
                }
            };
            reader.readAsText(file);
            setTimeout(function() {
                addBounds();
            }, 10);
        }
    }
    $('#delimiter').change(function(){
        eksekusi();
    });
    $('#excelfile').change(function () {
        eksekusi();
    });
    $('#format').change(function(){
        eksekusi();
    });
</script>
</div>

		</section>
	</div>
</main>

<?php
$dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
$dir.='geoid/';if(!file_exists($dir))mkdir($dir,0755);
$dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
?>
