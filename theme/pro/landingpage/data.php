<script type="text/javascript">
	var debugtable=false;
	$(document).ready(function () {
		load_first("idtable",DT+'?act=idtable',debugtable,true,true,0,true);
		$('#newmodule').hide();
		load();
	});
	function load(){
		load_data("idtable",DT+'?act=idtable&apl='+$('#aplikasi').val(),debugtable);
	}
	function save(){
		var apl=$('#aplikasi').val();
		var data={
			newmodule:apl,
			nama:$('#nama-module').val(),
			grup:$('#nama-grup').val(),
			titel:$('#title').val(),
			menu:$('#menu-title').val(),
			parent:$('#parent-menu').val(),
			theme:$('#nama-theme').val(),
			skin:$('#nama-skin').val(),
			status:$('#status').val(),
			template:$('#template').val(),
			posisi:$('#activity').val(),
		};
		$.post(PT,data,function(data){
			if(data!='ok')alert(data);
			load_module_all();
			$('#modal').modal('hide');
		});
	}
</script>
<main>
	<div class="container">
		<section class="section">
			<div class="row mb-5">
				<!-- Grid column -->
				<div class="col-lg-3 col-md-4 col-sm-5">
					<select class="mdb-select colorful-select dropdown-primary md-form" id="aplikasi" onchange="load_module_all()">
						<option disabled selected>Select</option>
					</select>
					<label class="mdb-main-label">Aplikasi</label>
				</div>
				<div class="col-lg-9 col-md-8 col-sm-7">
					<button class="btn btn-sm btn-success float-right light-green" data-toggle="modal" data-target="#modal">New</button>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<?=add_table('idtable',array('col_1','col_2','col_3','col_4',''),'',false);?>
				</div>
			</div>
		</section>
	</div>
</main>

<div class="modal fade" id="modal-module" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
								<div class="col-6">
									<div class="md-outline md-form">
										<input type="text" class="form-control form-control-sm" id="nama-module" placeholder="Module name">
										<label for="nama-module" class="active">Module Name</label>
									</div>
								</div>
								<div class="col-6">
									<div class="md-outline md-form">
										<input type="text" class="form-control form-control-sm" id="nama-grup" placeholder="Group name">
										<label for="nama-grup" class="active">Group Name</label>
									</div>
								</div>
								<div class="col-6">
									<div class="md-outline md-form">
										<input type="text" class="form-control form-control-sm" id="title" placeholder="Title">
										<label for="title" class="active">Title</label>
									</div>
								</div>
								<div class="col-6">
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
								<div class="col-6">
									<div class="md-outline md-form">
										<select class="form-control" id="status" onchange="">
											<option value="1" selected>Enable</option>
											<option value="0">Disable</option>
										</select>
										<label for="status" class="active">Status</label>
									</div>
								</div>
								<div class="col-6">
									<div class="md-outline md-form">
										<select class="form-control" id="activity" onchange="">
											<option value="0">Before login</option>
											<option value="1">After login</option>
											<option value="2" selected>Neglected</option>
										</select>
										<label for="activity" class="active">Activity</label>
									</div>
								</div>
								<div class="col-6">
									<div class="md-outline md-form">
										<select class="form-control" id="nama-theme" onchange="">
											<option value="pro" selected>Pro MDBootstrap</option>
										</select>
										<label for="nama-theme" class="active">Theme</label>
									</div>
								</div>
								<div class="col-6">
									<div class="md-outline md-form">
										<select class="form-control" id="template" onchange="">
											<option value="admin">Admin</option>
											<option value="landingpage" selected>Landing Page</option>
										</select>
										<label for="template" class="active">Template</label>
									</div>
								</div>
								<div class="col-6">
									<div class="md-form md-outline">
										<input type="text" class="form-control form-control-sm" id="menu-title" placeholder="module">
										<label for="menu-title" class="active">Menu Title</label>
									</div>
								</div>
								<div class="col-6">
									<div class="md-form md-outline">
										<input type="text" class="form-control form-control-sm" id="parent-menu" placeholder="parent">
										<label for="parent-menu" class="active">Parent Menu</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="text-center mt-2">
										<button class="btn btn-info btn-sm" onclick="save_module()">Save <i class="fa fa-save"></i></button>
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
