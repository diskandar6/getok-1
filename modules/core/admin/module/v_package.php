<script>
    var tb_selected=[];
    var pk_selected='';
    var bundle='';
	$(document).ready(function () {
		load_first("packagelist",DT+'?package=1',false,true,true,0,true);
	});
	
    // PACKAGE
    function load_package(){
        load_data("packagelist",DT+'?package='+$('#aplikasi').val(),false);
    }
    function compile_package(){
        $('#db-package').val('');
        $('#tb-package').val('');
        $('#tb-selected').val('').html('');
        $('#module-package').val('');
        tb_selected=[];
        $('#modal-package').modal('show');
    }
    function load_mod_list(){
		$.get(DT,{modul_package:$('#aplikasi').val()},function(data){
			var data = JSON.parse(data);
			add_option('module-package',data);
		});
    }
    function load_db_list(){
        $.get(DT,{db_package:$('#aplikasi').val()},function(data){
            var data=JSON.parse(data);
            add_option('db-package',data);
            add_option('select-db',data);
        })
    }
    function save_package(){
        $.post(PT,{pkg_apl:$('#aplikasi').val(),pkg_module:$('#module-package').val(),pkg_db:tb_selected},function(data){
            alert_ok(data,'OK');
            load_package();
            $('#modal-package').modal('hide');
        })
    }
    function tbl_package(value){
        $.get(DT,{tb_package:value},function(data){
            var data=JSON.parse(data);
            add_option('tb-package',data);
        });
    }
    function tb_select(){
        var value=$('#tb-package').val();
        var b=$('#db-package').val();
        var c=false;
        tb_selected=[];
        for(var j=0;j<value.length;j++){
            var a={};
            a[b]=value[j];
            tb_selected.push(a);
        }
        insert_into_select();
    }
    function insert_into_select(){
        var a=[];
        for(var i=0;i<tb_selected.length;i++){
            var b=Object.keys(tb_selected[i]);
            var c=Object.values(tb_selected[i]);
            var d={text:b+'->'+c,value:''};
            a.push(d);
        }
        add_option('tb-selected',a,true);
    }
    function uninstall_package(v){
        var data={uinstall_package:pk_selected,dst_apl:$('#aplikasi').val(),all_data:v,bl_pkg:bundle}
        $.get(DT,data,function(data){
            alert_ok(data,'OK');
            load_package();
            $('#modal-confirm').modal('hide');
        });
    }
    function install_package(){
        $.get(DT,{install_package:pk_selected,dst_apl:$('#aplikasi').val(),db_sel_pkg:$('#select-db').val(),bl_pkg:$('#bundle-package').val()},function(data){
            alert_ok(data,'OK');
            load_package();
            $('#modal-select-db-package').modal('hide');
        });
    }
    function select_package(v,b=''){
        pk_selected=v;
        if(b==''){
            $.get(DT,{bl_package:$('#aplikasi').val()},function(data){
                var data=JSON.parse(data);
                add_option('bundle-package',data);
            });
        }else
            bundle=b;
    }
</script>
<div class="d-flex flex-row">
    <button class="btn btn-sm btn-success" onclick="compile_package()">Compile Package</button>
</div>
<div class="table-responsive">
              			<?=add_table('packagelist',array('Name','Table',''),'',false);?>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-package" tabindex="-1" role="dialog" aria-labelledby="label-modal-package"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label-modal-package">Packages</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <select class="mdb-select md-form" searchable="Search here.." id="module-package">
                    <option value="" disabled selected>Select Module</option>
                </select>
                <label class="mdb-main-label">Module</label>
            </div>
            <div class="col-lg-6">
                <select class="mdb-select md-form" id="db-package" onchange="tbl_package(this.value)">
                  <option value="" disabled selected>Select Database</option>
                </select>
                <label class="mdb-main-label">Database</label>
            </div>
            <div class="col-lg-6">
                <select class="mdb-select md-form" id="tb-package" onchange="tb_select()" multiple searchable="cari...">
                  <option value="" disabled selected>Select Table</option>
                </select>
                <label class="mdb-main-label">Table</label>
            </div>
            <div class="col-12">
                <select class="custom-select" multiple id="tb-selected" disabled>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="save_package()">Compile</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-select-db-package" tabindex="-1" role="dialog" aria-labelledby="label-modal-package"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label-modal-package">Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <select class="mdb-select md-form" id="select-db">
                  <option value="" disabled selected>Select Database</option>
                </select>
                <label class="mdb-main-label">Database</label>
            </div>
            <div class="col-12">
                <select class="mdb-select md-form" searchable="Search here.." id="bundle-package">
                    <option value="uncategory" selected>Uncategory</option>
                </select>
                <label class="mdb-main-label">Bundle</label>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="install_package()">Install</button>
      </div>
    </div>
  </div>
</div>


<!--Modal: Login / Register Form-->
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Modal cascading tabs-->
      <div class="modal-c-tabs">
            <!--Body-->
            <div class="modal-body">
                <h4>Delete all script and database?</h4>
              <div class="d-flex justify-content-center">
                <button class="btn btn-outline-danger" onclick="uninstall_package(1)">Yes</button>
                <button class="btn btn-outline-warning" onclick="uninstall_package(0)">No</button>
                <button class="btn btn-outline-info" data-dismiss="modal">Cancel</button>
              </div>

            </div>
      </div>
    </div>
  </div>
</div>
