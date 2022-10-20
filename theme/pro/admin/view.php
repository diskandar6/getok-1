<script type="text/javascript">
	$(document).ready(function () {
		load_first("emplist",DT,false,true,true,0,true);
	});
	function load_data_pegawai(){
	    load_data("emplist",DT);
	}
	function new_pegawai(){
        $('#username').val('');
        $('#npp').val('');
        $('#nama').val('');
        $('#gender').val('');
        $('#tanggallahir').val('');
        $('#tempatlahir').val('');
        $('#tanggalmasuk').val('');
        $('#hp').val('');
        $('#alamat').val('');
        remove_id();
	}
	function save_pegawai(){
	    var data={
        username:$('#username').val(),
        npp:$('#npp').val(),
        nama:$('#nama').val(),
        gender:$('#gender').val(),
        tanggallahir:$('#tanggallahir').val(),
        tempatlahir:$('#tempatlahir').val(),
        tanggalmasuk:$('#tanggalmasuk').val(),
        hp:$('#hp').val(),
        alamat:$('#alamat').val()
	    }
	    if(check_id())data.id=get_id();
	    $.post(PT,data,function(data){
			if(data!='ok')
				toastr.error(data, '', {positionClass: 'md-toast-bottom-right'});
			else
				toastr.success('SIMPAN DATA PEGAWAI OK', '', {positionClass: 'md-toast-bottom-right'});
			load_data_pegawai();
			$('#modal-pegawai').modal('hide');
	    });
	}
	function edit_pegawai(v){
	    $.get(DT,{id:v},function(data){
	        var data=JSON.parse(data);
            $('#username').val(data.username);
            $('#npp').val(data.npp);
            $('#nama').val(data.nama);
            $('#gender').val(data.gender);
            $('#tanggallahir').val(data.tanggallahir);
            $('#tempatlahir').val(data.tempatlahir);
            $('#tanggalmasuk').val(data.tanggalmasuk);
            $('#hp').val(data.hp);
            $('#alamat').val(data.alamat);
	        set_id(v);
	    });
	}
	function menu_pegawai(v){
        $.get(DT,{menu:v},function(data){
            set_id(v);
            var data=JSON.parse(data);
            $('.form-check-input').each(function(){
                this.checked=data.indexOf(this.id)>=0;
	        });
	    })
	}
    function save_menu(){
        var ch=[];
        $('.form-check-input:checkbox:checked').each(function(){
            ch.push(this.id);
        });
        var ch=JSON.stringify(ch);
        $.post(PT,{savemenu:get_id(),menu:ch},function(data){
			if(data!='ok')
				toastr.error(data, '', {positionClass: 'md-toast-bottom-right'});
			else
				toastr.success('SIMPAN MENU OK', '', {positionClass: 'md-toast-bottom-right'});
			load_data_pegawai();
			$('#modal-menu-admin').modal('hide');
        });
    }
    function status_pegawai(v){
        $.post(PT,{status:v},function(data){
			if(data!='ok')
				toastr.error(data, '', {positionClass: 'md-toast-bottom-right'});
			else
				toastr.success('GANTI STATUS OK', '', {positionClass: 'md-toast-bottom-right'});
			load_data_pegawai();
        });
    }
    function reset_password(v){
        $.post(PT,{resetpassword:v},function(data){
			if(data!='ok')
				toastr.error(data, '', {positionClass: 'md-toast-bottom-right'});
			else
				toastr.success('RESET PASSWORD OK', '', {positionClass: 'md-toast-bottom-right'});
			load_data_pegawai();
        })
    }
</script>
<main>
	<div class="container">
		<section class="section">
            <div class="card ">
              <h5 class="card-header h5 bg-success text-white">Daftar Data Pegawai</h5>
              <div class="card-body">
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-pegawai" onclick="new_pegawai()"><i class="fas fa-plus"></i> Add</button>
                <?=add_table('emplist',array('Bio Data','Alamat','Akun',''),'',false);?>
              </div>
            </div>
		</section>
	</div>
</main>

        <div class="modal fade" id="modal-pegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    	<h5>Data Pegawai</h5>
                    	<div class="row">
                    		<div class="col-lg-6">
		                      <div class="md-outline md-form">
		                        <input type="text" class="form-control form-control-sm" id="username" placeholder="username">
		                        <label for="username" class="">Nama akun</label>
		                      </div>
							</div>
                    		<div class="col-lg-6">
		                      <div class="md-outline md-form">
		                        <input type="text" class="form-control form-control-sm" id="npp" placeholder="npp">
		                        <label for="npp" class="">NPP</label>
		                      </div>
							</div>
                    		<div class="col-lg-6">
		                      <div class="md-outline md-form">
		                      	<input type="text" class="form-control form-control-sm" id="nama" placeholder="nama lengkap">
		                        <label for="nama">Nama Lengkap</label>
		                      </div>
							</div>
                    		<div class="col-lg-6">
                    			<div class="md-outline md-form">
			                        <select class="form-control" id="gender" onchange="">
										<option value="l" selected>Laki-laki</option>
										<option value="p">Perempuan</option>
									</select>
			                        <label for="gender" class="active">Jenis Kelamin</label>
			                    </div>
							</div>
                    		<div class="col-lg-6">
                    			<div class="md-outline md-form">
			                        <input type="date" class="form-control form-control-sm" id="tanggallahir">
			                        <label for="tanggallahir">Tanggal Lahir</label>
			                    </div>
							</div>
                    		<div class="col-lg-6">
                    			<div class="md-outline md-form">
			                        <input type="text" class="form-control form-control-sm" id="tempatlahir" placeholder="tempat lahir">
			                        <label for="tempatlahir">Tempat Lahir</label>
			                    </div>
							</div>
                    		<div class="col-lg-12">
                    			<div class="md-outline md-form">
			                        <input type="text" class="form-control form-control-sm" id="alamat" placeholder="alamat">
			                        <label for="alamat" class="active">Alamat</label>
			                    </div>
							</div>
                    		<div class="col-lg-6">
                    			<div class="md-outline md-form">
			                        <input type="text" class="form-control form-control-sm" id="hp" placeholder="hp">
			                        <label for="hp" class="active">Nomor Handphone</label>
		                    	</div>
							</div>
                    		<div class="col-lg-6">
		                      <div class="md-form md-outline">
		                        <input type="date" class="form-control form-control-sm" id="tanggalmasuk">
		                        <label for="tanggalmasuk" class="">Tanggal Masuk</label>
		                      </div>
							</div>
						</div>
                    	<div class="row">
                    		<div class="col-12">
		                      <div class="text-center mt-2">
		                        <button class="btn btn-info btn-sm" onclick="save_pegawai()">Simpan <i class="fa fa-save"></i></button>
		                        <button class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
	                    	  </div>
	                    	</div>
	                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modal-menu-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
          <div class="modal-dialog cascading-modal modal-md" role="document">
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
                    	<h5>Menu Admin</h5>
                        <div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">
<?php
require D_MODULE_PATH.D_DOMAIN.'/menu2.php';
$menu2['Uncategory']=array('parent_menu'=> 'Uncategory','parent_menu_icon'=>'','group'=>array());
foreach($menu2 as $k => $v){
    if(!isset($v['parent_menu'])){
        array_push($menu2['Uncategory']['group'],$v);
        unset($menu2[$k]);
    }
}
foreach($menu2 as $k => $v){
?>
                          <!-- Accordion card -->
                          <div class="card">
                            <!-- Card header -->
                            <div class="card-header" role="tab" id="headingTwo<?=$k?>">
                              <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseTwo<?=$k?>"
                                aria-expanded="false" aria-controls="collapseTwo<?=$k?>">
                                <h6 class="mb-0">
                                  <i class="<?=$v['parent_menu_icon']?>"></i> <?=$v['parent_menu']?> <i class="fas fa-angle-down rotate-icon"></i>
                                </h6>
                              </a>
                            </div>
                        
                            <!-- Card body -->
                            <div id="collapseTwo<?=$k?>" class="collapse" role="tabpanel" aria-labelledby="headingTwo<?=$k?>"
                              data-parent="#accordionEx1">
                              <div class="card-body">
<?php foreach($v['group'] as $k1 => $v1){?>
                                <div class="form-check">
                                  <input type="checkbox" class="form-check-input" id="<?=$v1['name']?>">
                                  <label class="form-check-label" for="<?=$v1['name']?>"><i class="<?=$v1['menu_icon']?>"></i> <?=$v1['menu_title']?></label>
                                </div>
<?php }?>
                              </div>
                            </div>
                        
                          </div>
                          <!-- Accordion card -->
<?php }?>
                        </div>
                        <!-- Accordion wrapper -->
                      <div class="text-center mt-2">
                        <button class="btn btn-info btn-sm" onclick="save_menu()">Save <i class="fa fa-plus"></i></button>
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
  <script type="text/javascript">
  	$(document).ready(function () {
  		$('.mdb-select').materialSelect();
  	});
  </script>