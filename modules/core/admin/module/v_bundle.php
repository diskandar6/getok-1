<script>
	//	BUNDLE
	function load_bundle(){
		var v=$('#aplikasi').val();
		$.get(DT,{bundle:v},function(data){
			var data = JSON.parse(data);
			add_option('nama-grup',data);
		});
	}
	function save_bundle(){
		var apl=$('#aplikasi').val();
		$.post(PT,{newbundle:apl,nama:$('#nama-bundle').val()},function(data){
			alert_ok(data,'OK');
			load_bundle();
			$('#modal-bundle').modal('hide');
		});
	}
	function new_bundle(){
		$('#nama-bundle').val('');
	}

</script>

        <div class="modal fade" id="modal-bundle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    <div class="modal-body mb-1">
                    	<h5>New Bundle</h5>
                      <div class="md-form form-sm">
                        <input type="text" class="form-control form-control-sm" id="nama-bundle">
                        <label for="nama-bundle">Bundle Name</label>
                      </div>

                      <div class="text-center mt-2">
                        <button class="btn btn-info btn-sm" onclick="save_bundle()">Add <i class="fa fa-plus"></i></button>
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

