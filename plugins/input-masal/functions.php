<?php
define('D_INPUTMASAL',true);

/*
CONTOH penggunaan form input masal

<script>
    var ta='';
</script>

<?php
    form_input_masal(
        "load_data_kode()",
        "kodeakun:itm[0], ketkode:itm[1], kode:ta,",
        "ta=$('#kode').val();",
        2
    );
?>
*/

function form_input_masal($loaddatatable,$format_post,$get_data_init,$max_kolom,$format='Kode,Deskripsi'){?>
<script>
    var masal='';
    var nmasal=0;
    var indexmasal=0;
	function new_masal(){
        $('#progressb').hide();
        $('#inputmasal').val('');
        $('#progresss').attr('aria-valuenow','0').css({'width':'0%'});
	}
    function progressbar(){
        var a=Math.round(indexmasal/nmasal*100);
        $('#progresss').attr('aria-valuenow',a).css({'width':a+'%'});
    }
    function error_masal(){
        var a=$('#inputmasal').val();
        a+=masal[indexmasal]+'\n';
        if(masal[indexmasal]!='')$('#inputmasal').val(a);
        indexmasal++;
        progressbar();
        if(indexmasal<nmasal) save_masal_();
        else{
            <?=$loaddatatable?>;
            alert_ok('ok','OK');
        }
    }
	function save_masal_(){
        if(masal[indexmasal]!=''){
            var itm=masal[indexmasal].split('\t');
            if(itm.length==<?=$max_kolom?>){
                var data={ <?=$format_post?> }
                $.post(PT,data,function(data){
                    if(data=='ok'){
                        indexmasal++;
                        progressbar();
                        if(indexmasal<nmasal) save_masal_();
                        else{
                            $('#btn-input-masal1').show();
                            $('#btn-input-masal2').show();
                            <?=$loaddatatable?>;
                            alert_ok('ok','OK');
                            $('#modal-masal').modal('hide');
                        }
                    }
                });
            }else error_masal();
        }else error_masal();
	}
    function save_masal(){
        <?=$get_data_init?>
        masal=$('#inputmasal').val();
        $('#inputmasal').val('');
        masal=masal.split('\n');
        nmasal=masal.length;
        indexmasal=0;
        var itm=masal[0].split('\t');
        $('#progressb').show();
        save_masal_();
        $('#btn-input-masal1').hide();
        $('#btn-input-masal2').hide();
    }
</script>
        <div class="modal fade" id="modal-masal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog cascading-modal modal-lg" role="document">
            <!-- Content -->
            <div class="modal-content">
                    <div class="modal-body mb-1">
                    	<h5>Input Masal</h5>
                    	<div class="row">
                    	    <div class="col-12">
                    	        <textarea class="form-control" rows="15" id="inputmasal"></textarea>
                    	    </div>
                    	    <div class="col-12" style="display:none" id="progressb">
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progresss"></div>
                                </div>
                    	    </div>
                    	    <div class="col-12 d-flex align-items-start">
                    	        <p>Format: <br><?php 
                    	        $format=explode(',',$format);foreach($format as $k => $v)echo 'kolom '.($k+1).' : <b>'.$v.'</b><br>';?></p><div class="mr-auto"></div><button class="btn btn-info btn-sm" id="btn-input-masal2" onclick="save_masal()"><i class="fa fa-plus"></i> Simpan</button><button class="btn btn-danger btn-sm" id="btn-input-masal1" data-dismiss="modal">Batal</button>
                    	    </div>
                    	</div>
                      <div class="text-center mt-2">
                        
                        
                      </div>
                    </div>
            </div>
            <!-- Content -->
          </div>
        </div>
<?php }?>