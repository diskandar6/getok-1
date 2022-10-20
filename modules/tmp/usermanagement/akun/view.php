<script type="text/javascript">
	$(document).ready(function () {
		load_first("emplist",DT,false,true,true,0,true);
	});
	function load_data_akun(){
	    load_data("emplist",DT,false);
	}
	function new_akun(){
        $('#username').val('');
        $('#email').val('');
        $('#nama').val('');
        $('#pass').val('');
        remove_id();
	}
	function save_akun(){
	    var data={
        username:$('#username').val(),
        email:$('#email').val(),
        nama:$('#nama').val(),
        pass:$('#pass').val(),
	    }
	    if(check_id())data.id=get_id();
	    $.post(PT,data,function(data){
	        alert_ok(data,'OK');
			load_data_akun();
			$('#modal-akun').modal('hide');
	    });
	}
	function edit_akun(v){
	    $.get(DT,{id:v},function(data){
	        var data=JSON.parse(data);
            $('#username').val(data.username);
            $('#email').val(data.email);
            $('#nama').val(data.nama);
            $('#pass').val('');
	        set_id(v);
	        $('#modal-akun').modal('show');
	    });
	}
	function menu_akun(v){
        $.get(DT,{menu:v},function(data){
            set_id(v);
            var data=JSON.parse(data);
            $('.form-check-input').each(function(){
                this.checked=data.indexOf(this.id)>=0;
	        });
	        $('#modal-menu-admin').modal('show');
	    })
	}
    function save_menu(){
        var ch=[];
        $('.form-check-input:checkbox:checked').each(function(){
            ch.push(this.id);
        });
        var ch=JSON.stringify(ch);
        $.post(PT,{savemenu:get_id(),menu:ch},function(data){
			alert_ok(data,'OK');
			load_data_akun();
			$('#modal-menu-admin').modal('hide');
        });
    }
    function status_akun(v){
        $.post(PT,{status:v},function(data){
			alert_ok(data,'OK');
			load_data_akun();
        });
    }
    function reformattable(){
        $('.D_R').each(function(index){
            var data=JSON.parse($(this).html());
            var im='/assets/img/Deafult-Profile-sx.png';
            if(data[3]!='')im=data[3];
            $(this).replaceWith('<img src="'+im+'?w=1&h=1&p=1&nw=175&f=0&t=1" style="float:left" class="rounded-circle z-depth-1"><p style="float:left;padding:20px">Nama: '+data[0]+'<br>Username: '+data[1]+'<br>Email: '+data[2]+'</p>');
        })
    }
</script>
<main>
	<div class="container">
		<section class="section">
            <div class="card ">
              <h5 class="card-header h5 bg-<?=D_THEME_COLOR?> text-white">Daftar Akun</h5>
              <div class="card-body">
                  <div class="row">
                      <div class="col-auto">
                        <button class="btn btn-<?=D_THEME_COLOR?> btn-sm" data-toggle="modal" data-target="#modal-akun" onclick="new_akun()"><i class="fas fa-plus"></i> Tambah Akun</button>
                      </div>
                  </div>
                <div class="table-responsive text-nowrap">
                <?=add_table('emplist',array('ID','Akun','Module',''),'',false);?>
                </div>
              </div>
            </div>
		</section>
	</div>
</main>
        <div class="modal fade" id="modal-akun" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    	<h5>Data Akun</h5>
                    	<div class="row">
                    		<div class="col-lg-6">
		                      <div class="md-outline md-form">
		                        <input type="text" class="form-control form-control-sm" id="nama" placeholder="nama">
		                        <label for="nama" class="">Nama Lengkap</label>
		                      </div>
							</div>
                    		<div class="col-lg-6">
		                      <div class="md-outline md-form">
		                        <input type="text" class="form-control form-control-sm" id="username" placeholder="username">
		                        <label for="username" class="">Nama Akun</label>
		                      </div>
							</div>
                    		<div class="col-lg-6">
		                      <div class="md-outline md-form">
		                        <input type="email" class="form-control form-control-sm" id="email" placeholder="email">
		                        <label for="email" class="">Email</label>
		                      </div>
							</div>
                    		<div class="col-lg-6">
		                      <div class="md-outline md-form">
		                      	<input type="text" class="form-control form-control-sm" id="pass" placeholder="&nbsp;">
		                        <label for="pass">Password</label>
		                      </div>
							</div>
						</div>
                    	<div class="row">
                    		<div class="col-12">
		                      <div class="text-center mt-2">
		                        <button class="btn btn-info btn-sm" onclick="save_akun()">Simpan <i class="fa fa-save"></i></button>
		                        <button class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
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
if(count($menu2['Uncategory']['group'])==0)unset($menu2['Uncategory']);
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
<?php foreach($v['group'] as $k1 => $v1)if($v1['menu_title']!=''){?>
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
