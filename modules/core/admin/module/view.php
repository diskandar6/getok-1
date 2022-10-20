<script>
	$(document).ready(function () {
		debugstatus();
	});
	//  DEBUG
	function debugmode(){
	    $.post(PT,{debug:1},function(data){
			alert_ok(data,'OK');
			debugstatus();
	    });
	}
    function debugstatus(){
        $.get(DT,{debug:1},function(data){
            var data=JSON.parse(data);
            if(data.status=='ok')
                $('#debug').text(data.caption);
        });
	}
</script>

              <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
              	<div class="row">
              		<div class="col-lg-6">
						<select class="mdb-select colorful-select dropdown-<?=$ath?> md-form" id="aplikasi" onchange="load_module_all()" searchable="Search here..">
							<option disabled selected>Select</option>
						</select>
						<label class="mdb-main-label">Application</label>
					</div>
					<div class="col-lg-6 d-flex align-items-start">
						<div class="dropdown">
							<!--Trigger-->
							<button class="btn btn-sm btn-<?=$ath?> dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
							<!--Menu-->
							<div class="dropdown-menu dropdown-<?=$ath?>">
								<a class="dropdown-item" href="#" onclick="debugmode()" id="debug">Debug Mode</a>
								<a class="dropdown-item" href="#" onclick="reset_menu()">Reset Menu</a>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-aplikasi" onclick="new_aplikasi()">New Application</a>
								<a class="dropdown-item" href="#"  style="display: none;" id="rename_app" onclick="rename_aplikasi()">Rename Application</a>
								<a class="dropdown-item" href="#" id="newconfig" style="display: none;" data-toggle="modal" data-target="#modal-config" onclick="new_configuration()">Configuration</a>
								<a class="dropdown-item" href="#" id="newbundle" style="display: none;" data-toggle="modal" data-target="#modal-bundle" onclick="new_bundle()">New Bundle</a>
								<a class="dropdown-item" href="#" id="newmenu" style="display: none;" data-toggle="modal" data-target="#modal-menu" onclick="new_menu()">New Menu</a>
								<a class="dropdown-item" href="#" id="newmodule" style="display: none;" data-toggle="modal" data-target="#modal-module" onclick="new_module()">New Module</a>
							</div>
						</div>
						<button class="btn btn-sm btn-<?=$ath?>" onclick="crt_module()">Module List</button>
						<button class="btn btn-sm btn-<?=$ath?>" onclick="crt_package()">Package List</button>
              		</div>
              	</div>
              	<div class="row">
              		<div class="col-12" id="mdllist">
<?php require __DIR__.'/v_module.php';?>
              		</div>
              		<div class="col-12" id="pcklist" style="display:none">
<?php require __DIR__.'/v_package.php';?>
              		</div>
              	</div>
              </div>

<?php require __DIR__.'/v_aplikasi.php';?>

<?php require __DIR__.'/v_bundle.php';?>

<?php require __DIR__.'/v_config.php';?>

<?php require __DIR__.'/v_menu.php';?>
