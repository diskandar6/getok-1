<script>
    $(document).ready(function () {
		load_first("rese2",DT+'?sfile=',false,true,true,0,true);
		load_first("rese3",DT+'?stext=',false,true,true,0,true);
    });
</script>
              <div class="tab-pane fade" id="panel2" role="tabpanel">
<?php
require D_CORE_PATH.'explorer.php';
$fix='abc';
event_explorer($fix);
?>
<script>
    function crt_module(){
        $('#mdllist').show();
        $('#pcklist').hide();
    }
    function crt_package(){
        $('#mdllist').hide();
        $('#pcklist').show();
    }
    function ex(v){
        switch(v){
        case 1:load_folderlist<?=$fix?>();$('#ex1').show();$('#ex2').hide();$('#ex3').hide();break;
        case 2:$('#ex1').hide();$('#ex2').show();$('#ex3').hide();break;
        case 3:$('#ex1').hide();$('#ex2').hide();$('#ex3').show();break;
        }
    }
    function search_text(){
        load_data("rese3",DT+'?stext='+$('#stext').val()+'&root='+$('#sroots').val(),false);
    }
    function search_file(){
        load_data("rese2",DT+'?sfile='+$('#sfile').val()+'&root='+$('#froots').val(),false);
    }//*/
</script>
                <div class="row">
                    <div class="col-12 d-flex">
                        <button class="btn btn-sm btn-<?=$ath?>" onclick="ex(1)">File Explorer</button>
                        <button class="btn btn-sm btn-<?=$ath?>" onclick="ex(2)">Search File</button>
                        <button class="btn btn-sm btn-<?=$ath?>" onclick="ex(3)">Search Text</button>
                    </div>
                </div>
                <div id="ex1">
    				<div class="row">
    					<div class="col-lg-3 col-md-4 col-sm-6">
    					<?=treeview_explorer1($fix)?>
    					</div>
    					<div class="col-lg-9 col-md-8 col-sm-6">
    					<?=file_list_explorer($fix)?>
    					</div>
    				</div>
				</div>
				<div id="ex2" style="display:none">
			        <div class="row mt-3">
			            <div class="col-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <input type="text" class="input-group-text white-color" id="froots">
                                </div>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="sfile">
                                <div class="input-group-append">
                                    <button class="input-group-text <?=$ath?>-color white-text" id="inputGroup-sizing-sm" onclick="search_file()">Search File</button>
                                </div>
                            </div>
			            </div>
			            <div class="table-responsive">
			                <?=add_table('rese2',array('Path','Filename','Type'),'',false);?>
			            </div>
			        </div>
				</div>
				<div id="ex3" style="display:none">
			        <div class="row mt-3">
			            <div class="col-12">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <input type="text" class="input-group-text white-color" id="sroots">
                                </div>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" id="stext">
                                <div class="input-group-append">
                                    <button class="input-group-text <?=$ath?>-color white-text" id="inputGroup-sizing-sm" onclick="search_text()">Search Text</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <?=add_table('rese3',array('Path','Filename','Row'),'',false);?>
                        </div>
                    </div>
                </div>
                <?php editor_explorer($fix);?>
              </div>

<?php
preview_explorer($fix);
work_space_explorer($fix);
delete_file_explorer($fix);
plupload($fix);
?>

