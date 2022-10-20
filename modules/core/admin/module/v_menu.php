<script>
	//	MENU
	function new_menu(){
		$('#nama-menu').val('');
		id_icn='menu-parent-icon';
	}
	function save_menu(){
		var apl=$('#aplikasi').val();
		$.post(PT,{newmenu:apl,nama:$('#nama-menu').val(),icon:$('#menu-parent-icon').val()},function(data){
			alert_ok(data,'OK');
			load_menu();
			$('#modal-menu').modal('hide');
		});
	}
	function load_menu(){
		var v=$('#aplikasi').val();
		$.get(DT,{menu:v},function(data){
			var data = JSON.parse(data);
			add_option('parent-menu',data);
		});
	}
	function reset_menu(){
		$.get(DT,{resetmenu:1},function(data){
		    alert_ok(data,'OK');
		});
	}
	
</script>


        <div class="modal fade" id="modal-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    	<h5>New Menu</h5>
                    	<div class="row">
                    		<div class="col-12">
		                      <div class="md-form form-sm">
		                        <input type="text" class="form-control form-control-sm" id="nama-menu">
		                        <label for="nama-menu">Name</label>
		                      </div>
							</div>
                    		<div class="col-12">
		                      <div class="md-form form-sm">
		                      	<i class="fa fa-icons prefix" data-toggle="modal" data-target="#modal-icon"></i>
		                        <input type="text" class="form-control form-control-sm" id="menu-parent-icon" placeholder="icon">
		                        <label for="menu-parent-icon">Icon</label>
		                      </div>
							</div>
	                  	</div>
                      <div class="text-center mt-2">
                        <button class="btn btn-info btn-sm" onclick="save_menu()">Add <i class="fa fa-plus"></i></button>
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
