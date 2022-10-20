<script>

    //  CONFIGURATION
	function new_configuration(){
		$('#key-config').val('');
		$('#value-config').val('');
		config_list();
	}
	function add_config(){
		var a=$('#aplikasi').val();
		var k=$('#key-config').val();
		var v=$('#value-config').val();
		$.post(PT,{newconfig:a,key:k,value:v},function(data){
			alert_ok(data,'OK');
			config_list();
			$('#modal-config').modal('hide');
		});
	}
	function change_config(k,v){
		var a=$('#aplikasi').val();
		$.post(PT,{newconfig:a,key:k,value:v},function(data){
		    alert_ok(data,'OK');
		});
	}
	function config_list(){
		var v=$('#aplikasi').val();
		$.get(DT,{config:v},function(data){
			var data = JSON.parse(data);
			var a='<div class="row">';
			for(var i=0;i<data.length;i++){
				a+='<div class="col-lg-4 col-md-6">';
				a+='<div class="md-form form-sm">';
				a+='<input type="text" class="form-control form-control-sm" value="'+data[i].value+'" onkeyup="change_config(\''+data[i].key+'\',this.value)" id="key'+i+'">';
				a+='<label for="key'+i+'" class="active">'+data[i].key+'</label>';
				a+='</div>';
				a+='</div>';
			}
			a+='</div>';
			$('#configs').html(a);
		});
	}
</script>

        <div class="modal fade" id="modal-config" tabindex="1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true" style="z-index: 9999999">
          <div class="modal-dialog cascading-modal modal-lg" role="document">
            <!-- Content -->
            <div class="modal-content">
	            <div class="card border-success">
	              <div class="card-header bg-transparent border-success">Configuration</div>
	              <div class="card-body text-success">
					<div class="row">
						<div class="col-lg-4 col-md-6" style="margin-top:-30px">
							<div class="md-form form-sm">
								<input type="text" class="form-control form-control-sm" id="key-config">
								<label for="key-config">Key</label>
							</div>
						</div>
						<div class="col-lg-4 col-md-6" style="margin-top:-30px">
							<div class="md-form form-sm">
								<input type="text" class="form-control form-control-sm" id="value-config">
								<label for="value-config">Value</label>
							</div>
						</div>
						<div class="col-lg-4 col-md-6" style="margin-top:-10px">
							<button class="btn btn-sm btn-success" onclick="add_config()"><i class="fas fa-plus"></i> Add</button>
						</div>
						<div class="col-12" style="height:300px;overflow:auto" id="configs"></div>
					</div>
	              </div>
	              <!--div class="card-footer bg-transparent border-success">Footer</div-->
	            </div>
            </div>
          </div>
        </div>

