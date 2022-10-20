<?php
/*/  ================================
THEME HALAMAN ADMIN:
1.  primary
2.  danger
3.  success
4.  info
5.  warning
==================================== //*/
$ath=D_THEME_COLOR;
?>
<script type="text/javascript">
    var edit_icon='';
    var icon_cat=<?php $iconss=icon_categories();echo json_encode($iconss);?>;
<?php
$res=array();
foreach($iconss as $k => $v)
    $res[$v]=icons($v);
echo chr(9).'var iconss='.json_encode($res).';'.chr(10);
?>
	var id_icn='';
	$(document).ready(function () {
		load_first("constantlist",DT+'?constant=-',false,true,true,0,true);
		load_icon_cat();
		$(".page-footer").removeClass('mt-5');
	});
	//	ICON
	function load_icon_cat(){
		var data=[];
		for(var i=0;i<icon_cat.length;i++){
		    data[i]={text:icon_cat[i],value:icon_cat[i]}
		}
		add_option('nama-icon',data);
		add_option('nama-icons',data);
	}
	function load_icon(v,t='icons'){
		var a='';
		var data=iconss[v];
		for(var i=0;i<data.length;i++)
			a+='<span class="p-2 m-1 badge badge-info" onclick="apply_icon(\''+data[i]+'\')"><i class="'+data[i]+' fa-3x" data-clipboard-text="'+data[i]+'"></i><br>'+data[i]+'</span>';
		$('#'+t).html(a);
	}
    function apply_icon(v){
        if(edit_icon=='')
            $('#'+id_icn).val(v);
        else
            $('#edit_module').val(v);
		$('#modal-icon').modal('hide');
		if(edit_icon=='')
            select_copy(id_icn);
        else
            select_copy('#edit_module');
		edit_icon='';
	}

</script>
<main>
<div class="card" style="position:fixed;right:0;width:50px;border:none">
    <span class="badge badge-<?=$ath?> py-2 z-depth-0 m-1" data-toggle="modal" data-target="#fullHeightModalRight" onclick="buka_icon()"><i class="fa fa-icons fa-2x"></i></span>
    <span class="badge badge-info py-2 z-depth-0 m-1" data-toggle="modal" data-target="#fullHeightModalRight" onclick="buka_constant()"><i class="fa fa-book fa-2x"></i></span>
</div>
	<div class="container">
		<section class="section">
			<div class="row mb-3">
          <!-- Grid column -->
          <div class="col-md-12">

            <!-- Nav tabs -->
            <ul class="nav md-tabs nav-justified <?=$ath?>-color">
              <li class="nav-item waves-effect waves-light">
                <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab" onclick="">Modules</a>
              </li>
              <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Explorer</a>
              </li>
              <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-toggle="tab" href="#panel3" role="tab" onclick="">Database</a>
              </li>
              <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-toggle="tab" href="#panel4" role="tab">Master</a>
              </li>
              <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-toggle="tab" href="#panel5" role="tab">NotePad</a>
              </li>
<?php if($_SESSION['id']==0){?>
              <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-toggle="tab" href="#panel6" role="tab">Administrator</a>
              </li>
<?php }?>
            </ul>
            <!-- Tab panels -->
            <div class="tab-content card">
                <?php require __DIR__.'/module/view.php';?>

                <?php require __DIR__.'/explorer/view.php';?>

                <?php require __DIR__.'/database/view.php';?>

                <?php require __DIR__.'/notepad/view.php';?>

                <?php require __DIR__.'/master/view.php';?>

                <?php require __DIR__.'/administrator/view.php';?>
              </div>
           </div>
       </div>
       </section>
	</div>
</main>


        <div class="modal fade" id="modal-icon" tabindex="1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true" style="z-index: 9999999">
          <div class="modal-dialog cascading-modal modal-lg" role="document">
            <!-- Content -->
            <div class="modal-content">
	            <div class="card border-<?=$ath?>">
	              <div class="card-header bg-transparent border-<?=$ath?>">Icon Categories</div>
	              <div class="card-body text-<?=$ath?>">
					<div class="row">
						<div class="col-lg-4 col-md-6" style="margin-top:-30px">
							<div class="md-outline md-form">
								<select class="form-control" id="nama-icon" onchange="load_icon(this.value)"></select>
								<label for="nama-icon" class="active">Category</label>
							</div>
						</div>
						<div class="col-12" style="height:300px;overflow:auto" id="icons"></div>
					</div>
	              </div>
	              <!--div class="card-footer bg-transparent border-<?=$ath?>">Footer</div-->
	            </div>
            </div>
          </div>
        </div>


<!-- Full Height Modal Right -->
<div class="modal fade right" id="fullHeightModalRight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

  <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
  <div class="modal-dialog modal-full-height modal-right" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <div id="buka-icon">
		<div class="md-outline md-form">
		    <select class="form-control" id="nama-icons" onchange="load_icon(this.value,'iconss')"></select>
            <label for="nama-icons" class="active">Category</label>
        </div>
        <div class="col-12" style="height:300px;overflow:auto" id="iconss"></div>
        <div class="md-outline md-form">
            <input type="text" class="form-control form-control-sm" id="menu-icons" placeholder="icon">
            <label for="menu-icons" class="">Icon</label>
        </div>
        <button class="btn btn-sm btn-white" onclick="select_copy('menu-icons')">Copy to clipboard</button>
        </div>
        <div id="buka-konstan">
            <div class="md-outline md-form">
                <input type="text" class="form-control form-control-sm" id="constant" placeholder="D_">
                <label for="constant" class="">Constan</label>
            </div>
            <div class="md-outline md-form">
                <input type="text" class="form-control form-control-sm" id="val-constant" placeholder="-">
                <label for="val-constant" class="">Value</label>
            </div>
            <button class="btn btn-sm btn-white" onclick="add_konstan()"> Add</button>
            <div class="w-100">
                <?=add_table('constantlist',array('Constant','Value'),'',false);?>
                <ul id="list-constant"></ul>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Full Height Modal Right -->

<script type="text/javascript">
    function buka_icon(){
        id_icn='menu-icons';
        $('#buka-icon').show();
        $('#buka-konstan').hide();
    }
    function buka_constant(){
        $('#buka-icon').hide();
        $('#buka-konstan').show();
        load_constant();
    }
    function select_copy(id) {
      var copyText = document.getElementById(id);
      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/
      document.execCommand("copy");
      alert("Copied the text: " + copyText.value);
    }
    function add_konstan(){
        $.post(PT,{constant:$('#constant').val(),value:$('#val-constant').val()},function(data){
            alert_ok(data,'OK');
            load_constant();
        });
    }
    function load_constant(){
        load_data("constantlist",DT+'?constant',false);
        /*$.get(DT,{constant:1},function(data){
            var data=JSON.parse(data);
            var a='';
            for(var i=0; i<data.length;i++)
                a+='<li><b>'+data[i].text+'</b><br>'+data[i].value+'</li>';
            $('#list-constant').html(a);
        });//*/
    }
</script>
