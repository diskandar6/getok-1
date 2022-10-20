<script>
    $(document).ready(function () {
        load_first("catatanlist",DT+'?catatan=-',false,true,true,0,true);
    });
	function load_notepad_list(){
	    load_data("catatanlist",DT+'?catatan=-');
	}
	function new_notepad(){
	    $('#nama-document').val('');
	    $('#notedoc').val('');
	}
	function save_notepad(){
	    var data={
	        titel:$('#nama-document').val(),
	        catatan:$('#notedoc').val(),
	    }
	    if(check_id())data.id=get_id();
	    $.post(PT,data,function(data){
			alert_ok(data,'OK');
			$('#modal-new-notepad').modal('hide');
	        remove_id();
	        load_notepad_list();
	    });
	}
	function edit_notepad(v){
	    $.get(DT,{catatan:v},function(data){
	        var data=JSON.parse(data);
	        $('#nama-document').val(data[0]);
	        $('#notedoc').val(data[1]);
    	    set_id(v);
	    });
	}
	function view_notepad(v){
	    $.get(DT,{catatan:v},function(data){
	        var data=JSON.parse(data);
	        $('#view-'+v).html(data[1]).show();
	    });
	}
</script>
                <div class="tab-pane fade" id="panel5" role="tabpanel">
                    <div class="row">
    					<div class="col-12">
    						<button class="btn btn-sm btn-<?=$ath?> light-green" data-toggle="modal" data-target="#modal-new-notepad" onclick="new_notepad()">New</button>
    						<button class="btn btn-sm btn-<?=$ath?> light-green" onclick="load_notepad_list()">Reload</button>
                  		</div>
                        <div class="col-12">
                            <?=add_table('catatanlist',array('Title'),'',true);?>
                        </div>
                    </div>
                </div>



        <div class="modal fade" id="modal-new-notepad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog cascading-modal modal-lg" role="document">
            <!-- Content -->
            <div class="modal-content">

              <!-- Modal cascading tabs -->
              <div class="modal-c-tabs">

                <!-- Tab panels -->
                <div class="tab-content">
                  <!-- Panel 17 -->
                  <div class="tab-pane fade in show active" role="tabpanel">
                    <!-- Body -->
                    <div class="modal-body mb-1">
                    	<h5>Notepad</h5>
                      <div class="md-form form-sm">
                        <input type="text" class="form-control form-control-sm" id="nama-document" placeholder="Title">
                        <label for="nama-document">Title</label>
                      </div>
                      <div class="form-group shadow-textarea">
                        <textarea class="form-control form-control-sm z-depth-1" rows="10" id="notedoc"></textarea>
                      </div>
                      <div class="text-center mt-2">
                        <button class="btn btn-info btn-sm" onclick="save_notepad()">Save <i class="fa fa-save"></i></button>
                        <button class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- Content -->
          </div>
        </div>
