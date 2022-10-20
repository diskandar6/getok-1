<script type="text/javascript">
    var rep='';
    var rep_='';
	$(document).ready(function () {
		load_first("emplist",DT+'?datalist=1',false,true,true,0,true);
	});
	function load_data_perataan(){
	    load_data("emplist",DT+'?datalist=1');
	}
	function hapus(){
	    $.get(DT,{hapus:1},function(data){
	        alert_ok(data,'ok');
	        load_data_perataan();
	    })
	}
	function kalkulasi(){
	    $.get(DT,{kalkulasi:1},function(data){
	        alert_ok(data,'ok');
	        load_data_perataan();
	    })
	}
    function view_h(v){
	    $.get(DT,{viewh:v},function(data){
            $('#isi').html(data);
            rep=v;
            rep_='h';
	    });
    }
    function view_v(v){
	    $.get(DT,{viewv:v},function(data){
            $('#isi').html(data);
            rep=v;
            rep_='v';
	    });
    }
    function download(){
        document.location=DT+'?download='+rep+'&rep='+rep_;
    }
</script>
<main>
	<div class="container">
		<section class="section">
            <div class="card ">
              <h5 class="card-header h5 bg-<?=D_THEME_COLOR?> text-white">Adjustment Computation</h5>
              <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <button class="btn btn-<?=D_THEME_COLOR?> btn-md" data-toggle="modal" data-target="#uploads" onclick="pre_upload(1)">Titik Kontrol</button>
                        <button class="btn btn-<?=D_THEME_COLOR?> btn-md" data-toggle="modal" data-target="#uploads" onclick="pre_upload(2)">Data Observasi</button>
                        <button class="btn btn-<?=D_THEME_COLOR?> btn-md" onclick="hapus()">Hapus Data</button>
                    </div>
                    <div class="col-auto border-left">
                        <button class="btn btn-<?=D_THEME_COLOR?> btn-md" onclick="kalkulasi()">Kalkulasi</button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <?=add_table('emplist',array('No.','Nama File','Keterangan','Kalkulasi'),'',false);?>
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
                <button class="btn btn-sm btn-primary float-right" onclick="download()">Download</button>
                <pre id="isi"></pre>
            </div>
        </div>
    </div>
</div>

<?php
$dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
$dir.='perataan/';if(!file_exists($dir))mkdir($dir,0755);
$dir.=$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
$dir.='bm/';if(!file_exists($dir))mkdir($dir,0755);
plupload($dir,'c,raw','load_data_perataan()',5);
?>