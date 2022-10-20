<script type="text/javascript">
    $(document).ready(function(){
        get_rnx();
    })
	function hapus(){
	    $.get(DT,{hapus:1},function(data){
	        alert_ok(data,'ok');
	        get_rnx();
	    })
	}
	function kalkulasi(){
        var stasiun=$('#stasiun').val();
        var x=$('#x').val();
        var y=$('#y').val();
        var z=$('#z').val();
        var mode=$('#mode').val();
        var data=$('#data').val();
        var elev=$('#elev').val();
        var lengkap=!((stasiun=='')||(x=='')||(y=='')||(z=='')||(mode=='')||(data=='')||(elev==''))
        if(!lengkap){
            $('.toast').toast('show');
        }else{
            $('#spinner').show();
            $.get(DT,{stasiun:stasiun,x:x,y:y,z:z,mode:mode,data:data,elev:elev},function(data){
                $('#spinner').hide();
            	alert(data);
                if(data=='ok'){
                    view_();
                }else{
                	$('.toast-body').html(data);
                    $('.toast').toast('hide');
                }
            });
        }
	}
    function view_(){
        $.get(DT,{lihathasil:1},function(data){
            if(data!=''){
                $('#spinner').hide();
                $('#isi').html(data);
                $('#modal-view').modal('show');
            }
        });
    }
    function download(){
        document.location=DT+'?download=1';
    }
    function get_rnx(){
        $.get(DT,{load_rnx:1},function(data){
            var data=JSON.parse(data);
            var a='';
            for(var i=0;i<data.length;i++)
                a+='<li class="list-group-item">'+data[i]+'</li>';
            $('#rnx').html(a);
        });
    }
</script>
<main>
	<div class="container">
		<section class="section">
            <div class="card ">
              <h5 class="card-header h5 bg-<?=D_THEME_COLOR?> text-white">GNSS Processing</h5>
              <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <button class="btn btn-<?=D_THEME_COLOR?> btn-md" data-toggle="modal" data-target="#uploads" onclick="pre_upload()">Unggah RNX</button>
                        <button class="btn btn-<?=D_THEME_COLOR?> btn-md" onclick="hapus()">Hapus Data</button>
                    </div>
                    <div class="col-auto border-left">
                        <button class="btn btn-<?=D_THEME_COLOR?> btn-md" onclick="kalkulasi()">Kalkulasi</button>
                    </div>
                </div>
                <hr>
                <div class="row">
    	            <div class="col-12">
    	            	<div id="spinner" style="display:none">
    	                	<div class="d-flex justify-content-center">
    	                    	<div class="spinner-border" role="status">
    	                        	<span class="sr-only">Loading...</span>
    	                        </div>
    	                    </div>
    	                </div>
    	            </div>
    	           	<div class="col-lg-6 col-md-6 border-right">
    	            	<h5>RNX</h5>
    	                <ul class="list-group" id="rnx"></ul>
    				</div>
    	            <div class="col-lg-6 col-md-6">
    	            	<div class="form-group input-group input-group-md my-3">
    						<div class="input-group-prepend" style="width: 150px">
    							<span class="input-group-text" style="width: 150px">Mode</span>
    						</div>
    						<select class="form-control" id="mode">
    							<option value="STATIK" selected>STATIK</option>
    							<option value="KINEMATIK">KINEMATIK</option>
    						</select>
    					</div>
    	                <div class="form-group input-group input-group-md my-3">
    						<div class="input-group-prepend" style="width: 150px">
    							<span class="input-group-text" style="width: 150px">Data</span>
    						</div>
    						<select class="form-control" id="data">
    							<option value="1" selected>1</option>
    							<option value="2">2</option>
    							<option value="3">3</option>
    						</select>
    					</div>
    	                <!-- Ref Stasiun -->
    	                <div class="input-group input-group-md my-3">
    						<div class="input-group-prepend" style="width: 150px">
    							<span class="input-group-text" style="width: 150px">Referens Station</span>
    						</div>
    						<input type="text" class="form-control" id="stasiun" placeholder="Referns Stats" value="">
    					</div>
    	                <!-- X -->
    	                <div class="input-group input-group-md my-3">
    						<div class="input-group-prepend" style="width: 150px">
    							<span class="input-group-text" style="width: 150px">X</span>
    						</div>
    						<input type="text" class="form-control" id="x" placeholder="" value="">
    					</div>
    	                <!-- Y -->
    					<div class="input-group input-group-md my-3">
    						<div class="input-group-prepend" style="width: 150px">
    							<span class="input-group-text" style="width: 150px">Y</span>
    						</div>
    						<input type="text" class="form-control" id="y" placeholder="" value="">
    					</div>
    	                <!-- Z -->
    	                <div class="input-group input-group-md my-3">
    						<div class="input-group-prepend" style="width: 150px">
    							<span class="input-group-text" style="width: 150px">Z</span>
    						</div>
    						<input type="text" class="form-control" id="z" placeholder="" value="">
    					</div>
    	                <!-- ELEV -->
    	                <div class="input-group input-group-md my-3">
    						<div class="input-group-prepend" style="width: 150px">
    							<span class="input-group-text" style="width: 150px">Elevasi</span>
    						</div>
    						<input type="text" class="form-control" id="elev" placeholder="" value="">
    					</div>
    	            </div>
                </div>
              </div>
            </div>
		</section>
	</div>
</main>

<div class="modal fade" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-notify modal-info" role="document">
    	<!--Content-->
        <div class="modal-content">
            <!--Body-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-sm btn-primary float-right my-3" onclick="document.location='{{route("get_rnx")}}?download=1'">Download</button>
                    </div>
                    <div class="col-12">
                        <pre id="isi" class="mb-3"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
$dir.='gnss/';if(!file_exists($dir))mkdir($dir,0755);
$dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
if(!file_exists($dir.'OUT'))mkdir($dir.'OUT',0755);
if(!file_exists($dir.'GNSS_KF'))
    copy(dirname($dir).'/GNSS_KF',$dir.'GNSS_KF');
echo exec('chown root:root "'.$dir.'GNSS_KF"');

if(!file_exists($dir.'ORB')){
    mkdir($dir.'ORB',0755);
    copy_folder(dirname($dir).'/ORB',$dir.'ORB');
}
$dir.='RNX/';if(!file_exists($dir))mkdir($dir,0755);
plupload($dir,'13O','get_rnx()',5);
?>