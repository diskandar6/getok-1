<script>
	$(document).ready(function () {
		load_first("adminlist",DT+'?adminlist=1',false,true,true,0,true);
	});
    function new_admin(){
        $('#adminname').val('');
        $('#adminpass').val('');
        $('#adminapl').val('');
        remove_id();
    }
    function save_admin(){
        var data={adminname:$('#adminname').val(),adminpass:$('#adminpass').val(),adminapl:$('#adminapl').val()}
        if(check_id())data.idadmin=get_id();
        $.post(PT,data,function(data){
			alert_ok(data,'OK');
			load_admin_list();
			$('#modal-new-admin').modal('hide');
        });
    }
    function load_admin_list(){
        load_data("adminlist",DT+'?adminlist=1',false);
    }
    function edit_admin(id){
        $.get(DT,{editadmin:id},function(data){
            var data=JSON.parse(data);
            $('#adminname').val(data.username);
            $('#adminapl').val(data.application);
            $('#adminpass').val('');
            set_id(id);
            $('#modal-new-admin').modal('show');
        });
    }
    function delete_admin(id){
        if(confirm('Are you sure you want to delete it?')){
            $.post(PT,{deleteadmin:id},function(data){
    			alert_ok(data,'OK');
    			load_admin_list();
            });
        }
    }
    function status_admin(id){
        $.post(PT,{statusadmin:id},function(data){
            alert_ok(data,'OK');
            load_admin_list();
        });
    }
</script>
                <div class="tab-pane fade" id="panel6" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-<?=$ath?> btn-sm" data-toggle="modal" data-target="#modal-new-admin" onclick="new_admin()"><i class="fa fa-plus"></i> New</button>
                        </div>
                        <div class="col-12">
                            <?=add_table('adminlist',array('Username','Application','Status',''),'',false);?>
                        </div>
                    </div>
                </div>

        <div class="modal fade" id="modal-new-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-md" role="document">
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
                    	<h5>Administrator</h5>
                    	<div class="row">
                    		<div class="col-lg-6 col-md-6">
		                      <div class="md-outline md-form">
		                        <input type="text" class="form-control form-control-sm" id="adminname">
		                        <label for="adminname" class="">Username</label>
		                      </div>
							</div>
                    		<div class="col-lg-6 col-md-6">
		                      <div class="md-outline md-form">
		                        <input type="text" class="form-control form-control-sm" id="adminpass">
		                        <label for="adminpass" class="">Password</label>
		                      </div>
							</div>
                    		<div class="col-12">
		                      <div class="select-outline md-form">
		                      	<select class="mdb-select md-form" id="adminapl" searchable="Search here..">
		                        </select>
		                        <label for="adminapl" class="active">Application Name</label>
		                      </div>
							</div>
						</div>
                    	<div class="row">
                    		<div class="col-12">
		                      <div class="text-center mt-2">
		                        <button class="btn btn-info btn-sm" onclick="save_admin()">Save <i class="fa fa-save"></i></button>
		                        <button class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
	                    	  </div>
	                    	</div>
	                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Content -->
          </div>
        </div>
