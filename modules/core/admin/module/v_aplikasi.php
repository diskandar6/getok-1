<script>
	$(document).ready(function () {
		load_aplikasi_list();
	});
	//	APPLICATION
	function load_aplikasi_list(){
		$.get(DT,{aplikasi:1},function(data){
			var data = JSON.parse(data);
			add_option('aplikasi',data,true);
			add_option('apl_db',data,true);
			add_option('adminapl',data,true);
            $('.mdb-select').materialSelect();
		});
	}
	function save_aplikasi(){
		var v=$('#nama-aplikasi').val();
		$.post(PT,{newaplikasi:v},function(data){
			alert_ok(data,'OK');
			location.reload();
			$('#modal-aplikasi').modal('hide');
		});
	}
	function save_raplikasi(){
        $.post(PT,{rename_appl:$('#nama-aplikasi').val(),current_appl:$('#aplikasi').val()},function(data){
			alert_ok(data,'OK');
			location.reload();
			$('#modal-aplikasi').modal('hide');
        });
	}
	function new_aplikasi(){
		$('.appl h5').html('New Application');
		$('.bappl').html('Add <i class="fa fa-plus"></i>').attr('onclick','save_aplikasi()');
		$('#nama-aplikasi').val('');
	}
    function rename_aplikasi(){
        $('.appl h5').html('Rename Application');
        $('#nama-aplikasi').val($('#aplikasi').val());
        $('.bappl').html('Save <i class="fa fa-save"></i>').attr('onclick','save_raplikasi()');
        $('#modal-aplikasi').modal('show');
    }

</script>


        <div class="modal fade" id="modal-aplikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog cascading-modal modal-sm" role="document">
            <!-- Content -->
            <div class="modal-content">

              <!-- Modal cascading tabs -->
              <div class="modal-c-tabs">

                <!-- Tab panels -->
                <div class="tab-content">
                  <!-- Panel 17 -->
                  <div class="tab-pane fade in show active" role="tabpanel">
                    <!-- Body -->
                    <div class="modal-body mb-1 appl">
                    	<h5>New Application</h5>
                      <div class="md-form form-sm">
                        <input type="text" class="form-control form-control-sm" id="nama-aplikasi">
                        <label for="nama-aplikasi">Application Name</label>
                      </div>

                      <div class="text-center mt-2">
                        <button class="btn btn-info btn-sm bappl" onclick="save_aplikasi()">Add <i class="fa fa-plus"></i></button>
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

