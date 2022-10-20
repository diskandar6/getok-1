<script>
	$(document).ready(function () {
		load_first("modulelist",DT+'?apl=-',false,true,true,0,true);
	});
	// MODULE
	function load_module_all(){
		load_data("modulelist",DT+'?apl='+$('#aplikasi').val(),false);
		if($('#aplikasi').val()!=null){
			$('#newmodule').show();
			$('#newbundle').show();
			$('#newmenu').show();
			$('#newconfig').show();
			if('<?=D_DOMAIN?>'==$('#aplikasi').val())
                $('#rename_app').hide();
            else
                $('#rename_app').show();
			load_menu();
		}
		load_mod_list();
		load_db_list();
		load_package();
	}
	function new_module(){
		$('#nama-module').val('');
		$('#nama-grup').val('');
		$('#title').val('');
		$('#menu-title').val('');
		$('#parent-menu').val('');
		$('#nama-theme').val('pro');
		$('#nama-skin').val('white-skin');
		$('#status').val('1');
		$('#template').val('landingpage');
		$('#activity').val('2');
		load_bundle();
		load_menu();
		id_icn='menu-icon';
	}
	function save_module(){
		var apl=$('#aplikasi').val();
		var data={
			newmodule:apl,
			nama:$('#nama-module').val(),
			grup:$('#nama-grup').val(),
			titel:$('#title').val(),
			menu:$('#menu-title').val(),
			icon:$('#menu-icon').val(),
			parent:$('#parent-menu').val(),
			theme:$('#nama-theme').val(),
			skin:$('#nama-skin').val(),
			status:$('#status').val(),
			template:$('#template').val(),
			posisi:$('#activity').val(),
			level:$('#level').val(),
		};
		$.post(PT,data,function(data){
			alert_ok(data,'OK');
			load_module_all();
			$('#modal-module').modal('hide');
		});
	}
</script>
<div class="table-responsive">
              			<?=add_table('modulelist',array('Module','Metadata','Bundle'),'',false);?>
</div>
        <div class="modal fade" id="modal-module" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    	<h5>New Module</h5>
                    	<div class="row">
                    		<div class="col-lg-6 col-md-6">
		                      <div class="md-outline md-form">
		                        <input type="text" class="form-control form-control-sm" id="nama-module">
		                        <label for="nama-module" class="">Module Name</label>
		                      </div>
							</div>
                    		<div class="col-lg-6 col-md-6" id="edit-title">
		                      <div class="md-outline md-form">
		                        <input type="text" class="form-control form-control-sm" id="title">
		                        <label for="title" class="">Browser Title</label>
		                      </div>
							</div>
                    		<div class="col-lg-4 col-md-6" id="edit-nama-grup">
		                      <div class="md-outline md-form">
		                      	<select class="form-control" id="nama-grup">
		                      		<option value="uncategory" selected>Without Category</option>
		                        </select>
		                        <label for="nama-grup" class="active">Bundle Name</label>
		                      </div>
							</div>
                    		<div class="col-lg-4 col-md-6" id="edit-status">
                    			<div class="md-outline md-form">
			                        <select class="form-control" id="status" onchange="">
										<option value="1" selected>Active</option>
										<option value="0">Hidden</option>
									</select>
			                        <label for="status" class="active">Status</label>
			                    </div>
							</div>
                    		<div class="col-lg-4 col-md-6" id="edit-activity">
                    			<div class="md-outline md-form">
			                        <select class="form-control" id="activity" onchange="">
										<option value="0">Before auth</option>
										<option value="1">After auth</option>
										<option value="2" selected>Without auth</option>
									</select>
			                        <label for="activity" class="active">Activity</label>
			                    </div>
							</div>
                    		<div class="col-lg-4 col-md-6" id="edit-nama-theme">
                    			<div class="md-outline md-form">
			                        <select class="form-control" id="nama-theme" onchange="">
										<option value="blank">Blank</option>
										<option value="pro" selected>Pro MDBootstrap</option>
										<option value="pro5" selected>Pro MDBootstrap 5</option>
										<option value="pro5.01" selected>Pro MDBootstrap 5.01</option>
									</select>
			                        <label for="nama-theme" class="active">Theme</label>
			                    </div>
							</div>
                    		<div class="col-lg-4 col-md-6" id="edit-template">
                    			<div class="md-outline md-form">
			                        <select class="form-control" id="template" onchange="">
										<option value="blank" selected>Blank</option>
										<option value="admin">Admin</option>
										<option value="landingpage">Landing Page</option>
									</select>
			                        <label for="template" class="active">Template</label>
			                    </div>
							</div>
                    		<div class="col-lg-4 col-md-6" id="edit-nama-skin">
                    			<div class="md-outline md-form">
			                        <select class="form-control" id="nama-skin">
										<option value="white-skin" selected>White</option>
										<option value="black-skin">Black</option>
										<option value="cyan-skin">Cyan</option>
										<option value="deep-purple-skin">Deep Purple</option>
										<option value="pink-skin">Pink</option>
										<option value="navy-blue-skin">Navy Blue</option>
										<option value="indigo-skin">Indigo</option>
										<option value="light-blue-skin">Light Blue</option>
										<option value="mdb-skin">MDB</option>
									</select>
			                        <label for="nama-skin" class="active">Skin</label>
		                    	</div>
							</div>
                    		<div class="col-lg-6 col-md-6" id="edit-menu-title">
		                      <div class="md-form md-outline">
		                        <input type="text" class="form-control form-control-sm" id="menu-title">
		                        <label for="menu-title" class="">Menu Title</label>
		                      </div>
							</div>
                    		<div class="col-lg-6 col-md-6" id="edit-parent-menu">
		                      <div class="md-outline md-form">
		                      	<select class="form-control" id="parent-menu">
		                      		<option value="" disabled selected>Select</option>
		                        </select>
		                        <label for="parent-menu" class="active">Parent Menu</label>
		                      </div>
							</div>
                    		<div class="col-lg-6 col-md-12" id="edit-menu-icon">
		                      <div class="md-form md-outline">
		                      	<i class="fa fa-icons prefix" data-toggle="modal" data-target="#modal-icon"></i>
		                        <input type="text" class="form-control form-control-sm" id="menu-icon" placeholder="icon">
		                        <label for="menu-icon" class="">Icon</label>
		                      </div>
							</div>
<?php if(defined('D_USER_LEVEL')){$level=explode(',',D_USER_LEVEL);if(count($level)==0)$level=array('admin');?>
                    		<div class="col-lg-6 col-md-6" id="edit-level">
		                      <div class="md-outline md-form">
		                      	<select class="form-control" id="level">
		                      		<option value="" disabled selected>Select</option>
<?php foreach($level as $lv){?>
		                      		<option value="<?=$lv?>"><?=$lv?></option>
<?php }?>
		                        </select>
		                        <label for="level" class="active">Level</label>
		                      </div>
							</div>
<?php }?>
						</div>
                    	<div class="row">
                    		<div class="col-12">
		                      <div class="text-center mt-2">
		                        <button class="btn btn-info btn-sm" onclick="save_module()">Save <i class="fa fa-save"></i></button>
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


 <div class="modal fade" id="edit-module" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-warning modal-sm" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Body-->
       <div class="modal-body edit__mdl">
            <div class="md-outline md-form">
                <input type="text" class="form-control form-control-sm" id="edit_module" value="inisial">
                <label for="edit_module" class="active" id="label_edit_module">Constan</label>
            </div>
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         <a type="button" class="btn btn-primary btn-sm" onclick="edit__module_header()">Save<i class="far fa-save ml-1 text-white"></i></a>
         <a type="button" class="btn btn-outline-primary btn-sm waves-effect" data-dismiss="modal">Cancel<i class="far fa-window-close ml-1 text-danger"></i></a>
       </div>
     </div>
     <!--/.Content-->
   </div>
 </div>

<script>
    var edit_mdl_pg='';
    var edit_mdl_ky='';
    function edit_module(v,k){
        $.get(DT,{edit_module_apl:$('#aplikasi').val(),edit_module:v,key_module:k},function(data){
            var dtmdl=JSON.parse(data);
            if (typeof dtmdl !== 'undefined') {
                edit_mdl_pg=v;
                edit_mdl_ky=k;
                var var_head=k;
                switch(k){
                    case 'theme':var_head='nama-theme';break;
                    case 'position':var_head='activity';break;
                    case 'subtheme':var_head='template';break;
                    case 'browser_title':var_head='title';break;
                    case 'menu_title':var_head='menu-title';break;
                    case 'skin':var_head='nama-skin';break;
                    case 'parent_menu':var_head='parent-menu';break;
                    case 'menu_icon':var_head='menu-icon';edit_icon='1';break;
                }
                var html_mdl=$('#edit-'+var_head).html();
                $('.edit__mdl').html(html_mdl);
                $('.edit__mdl #'+var_head).val(dtmdl[0]).attr('id','edit_module');
                $('.edit__mdl label').attr('for','edit_module');
                $('#edit-module').modal('show');
            }
        });
    }
    function edit__module_header(){
        var data={
            edit_module_apl:$('#aplikasi').val(),
            edit_module:edit_mdl_pg,
            key_module:edit_mdl_ky,
            value:$('#edit_module').val()}
        $.post(PT,data,function(data){
            if(alert_ok(data,'OK')){
                $('#edit-module').modal('hide');
                /*setTimeout(function(){
                    if(edit_mdl_ky=='menu_title')reset_menu();
                    load_module_all();
                },3000);//*/
            }
        });
    }
</script> 
