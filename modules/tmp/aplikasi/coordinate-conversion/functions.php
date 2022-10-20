<?php
if(!defined('D_COORDINATE-CONVERSION')){define('D_COORDINATE-CONVERSION',true);
require __DIR__.'/variable.php';

require D_PLUGIN_PATH.'getok/load.php';

/*/
require D_PLUGIN_PATH.'getok/Engines1/ReferenceSystem/Ellipsoid.php';
require D_PLUGIN_PATH.'getok/Engines1/MapProjection.php';
require D_PLUGIN_PATH.'getok/Engines1/Coordinate/Geocentric.php';
require D_PLUGIN_PATH.'getok/Engines1/Coordinate/Geodetic.php';//*/

    function download_hasil_transformasi(){
        force_download($_SESSION['restrf'],'hasil_trasnformasi.txt');
    }
    
function proses_data_transformasi(){
    $_SESSION['exekusi_transformasi']=true;
    $_SESSION['sys_in']=$_POST['sys_in'];
    $_SESSION['sys_out']=$_POST['sys_out'];
    $_SESSION['structure']=$_POST['structure'];
    $_SESSION['delimiter']=$_POST['delimiter'];
    if(isset($_POST['hemi']))
    $_SESSION['hemi']=$_POST['hemi'];else
    $_SESSION['hemi']='';
    if(isset($_POST['zone']))
    $_SESSION['zone']=$_POST['zone'];else
    $_SESSION['zone']='';
    $_SESSION['prog']='Reading data...';
    $_SESSION['bar']=0;
    $_SESSION['lines']=$_POST['lines'];
    $_SESSION['lon_init']=$_POST['lon_init'];
    $_SESSION['id_datum']=$_POST['datum'];
    //print_r($_SESSION);
    $dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
    $dir.='transformasi/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.='res/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=date('YmdHis').'.txt';
    $_SESSION['restrf']=$dir;
    header("location: /".D_PAGE);
}

function get_form_trf_banyaktitik($sys_in,$sys_out){
    $a='';
    if($sys_in == 3){ $a.='
    		<div class="row">
                <div class="col-md-6">
                    <label>Zone</label><br>
                    <select name="zone" id="zone" class="browser-default custom-select">';
                        for($i=1;$i<=60;$i++)
                        $a.='    <option value="'.$i.'">Zone '.$i.'</option>';
                        
                    $a.='</select><br><br>
                </div>
                <div class="col-md-6">
                    <label>Hemisphere</label><br>
                    <select name="hemi" id="hemi" class="browser-default custom-select">
                        <option value="N">(N) North Hemisphere</option>
                        <option value="S">(S) South Hemisphere</option>
                    </select><br><br>
                </div>
            </div>
    	';
    }
    $a.='<div class="row">
        <div class="col-md-6">
            <label>Structure Data</label><br>
            <select name="structure" id="structure" class="browser-default custom-select" required>';
            	switch($sys_in){
                    case 1:$a.='
                    <option value="1">index lat lon height</option>
                    <option value="2">index lon lat height</option>'.chr(10);break;
                    case 2:$a.='
                    <option value="3">index X Y Z</option>
                    <option value="4">index Y X Z</option>'.chr(10);break;
                    case 3:$a.='
                    <option value="5">index easting northing height</option>
                    <option value="6">index northing easting height</option>'.chr(10);break;
                    case 4:$a.='
                    <option value="7">index easting northing height</option>
                    <option value="8">index northing easting height</option>'.chr(10);break;
            	}
    $a.='        </select>
        </div>
        <div class="col-md-6">
            <label>Data Delimiter</label><br>
            <select name="delimiter" id="delimiter" class="browser-default custom-select" required>
                <option value="1">Tab delimiter</option>
                <option value="2">Coma delimiter (,)</option>
                <option value="3">Semicolon delimiter (;)</option>
            </select>
        </div>
    </div><br>
    <input type="hidden" value="" id="lines" name="lines">';
    	if($sys_in == 4 || $sys_out == 4)
    		$a.='<div class="row">
    			<div class="col-md-6">
    				<label>Mercator Meridian Central</label><br>
    				<input type="number" id="lon_init" name="lon_init" step="any" class="input" value="0" placeholder="default: 0" required><br><br>
    			</div>
    		</div>';
    	else
    		$a.= '<input type="hidden" id="lon_init" name="lon_init" value="0">';
    	
    $a.='
    <label>Upload File</label><br>
    <input type="file" name="file" id="excelfile" required>
    <input type="hidden" name="uclassic" value="1">
    <input type="hidden" name="nextstep" value="proses_data_transformasi">
    <button type="submit" class="btn btn-primary">Calculate</button><br>
    <small><i>Akan ditampilkan sampel data Anda hingga 1000 data.</i></small>
    <script type="text/javascript">
    	function eksekusi(){
    	    $.get(DT,{upload:1},function(data){});
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
    		        	var lines = konten.split("\n");
    		        	var tes, c = 0, i;
    		        	document.getElementById("lines").value = lines.length;
    			    	var myobj;
    			    	var delimiter = document.getElementById("delimiter").value;
    			    	var format = document.getElementById("structure").value;
    			    	for(i=0; i<lines.length; i++){
    			    		c = 0;
    			    		if(i <= 1000){
    				    		if(delimiter == 1){
    				    			myobj = lines[i].match(/\S+/g);
    				    			tes = true;
    				    			while(tes == true){
    				    				if(myobj != null){
    				    					if(myobj[c] == null){
    					    					c += 1;
    					    				}else{
    					    					tes = false;
    					    				}
    				    				}else{
    				    					myobj = [0]; // change to array
    				    				}
    				    			}
    				    		}else if(delimiter == 2){
    				    			myobj = lines[i].split(",");
    				    		}else{
    				    			myobj = lines[i].split(";");
    				    		}
    				    		if(myobj.length >= 3){
    					    		if(format == 1){
    					    			plotme(myobj[c+1],myobj[c+2]);
    					    		}else if(format == 2){
    					    			plotme(myobj[c+2],myobj[c+1]);
    					    		}else if(format == 3){
    					    			var xyz = gs2gd(myobj[c+1], myobj[c+2], myobj[c+3]);
    					    			plotme(xyz.lat, xyz.lon);
    					    		}else if(format == 4){
    					    			var xyz = gs2gd(myobj[c+2], myobj[c+1], myobj[c+3]);
    					    			plotme(xyz.lat, xyz.lon);
    					    		}else if(format == 5){
    					    			var utm = utm2gd(myobj[c+1], myobj[c+2], 0, document.getElementById("zone").value, document.getElementById("hemi").value);
    					    			plotme(utm.lat, utm.lon);
    					    		}else if(format == 6){
    					    			var utm = utm2gd(myobj[c+2], myobj[c+1], 0, document.getElementById("zone").value, document.getElementById("hemi").value);
    					    			plotme(utm.lat, utm.lon);
    					    		}else if(format == 7){
                                        var merc = merc2gd(myobj[c+1], myobj[c+2], 0, document.getElementById("lon_init").value);
                                        plotme(merc.lat, merc.lon);
                                    }else if(format == 8){
                                        var merc = merc2gd(myobj[c+2], myobj[c+1], 0, document.getElementById("lon_init").value);
                                        plotme(merc.lat, merc.lon);
                                    }
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
    	$("#delimiter").change(function(){
    		eksekusi();
    	});
        $("#excelfile").change(function () {
            eksekusi();
        });
        $("#structure").change(function(){
        	eksekusi();
        });
        $("#zone").change(function(){
        	eksekusi();
        });
        $("#hemi").change(function(){
        	eksekusi();
        });
    </script>';
    return $a;
}

}?>