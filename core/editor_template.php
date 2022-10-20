<?php
function function_getmethod($modalname){
    $a=1;
    if(isset($_GET['applytmp'.$modalname])){
        $data=file_get_contents(D_THEME_PATH.'pro/landingpage/templates/'.$_GET['applytmp'.$modalname].'/'.$_GET['f'].'.php');
        echo $data;
    }elseif(isset($_GET['templatelist'.$modalname])){
        $data=file_get_contents(D_THEME_PATH.'pro/landingpage/templates/'.$_GET['templatelist'.$modalname].'/info.txt');
        $data=explode(',',$data);
        echo json_encode($data);
    }elseif(isset($_GET['templatepackagelist'.$modalname])){
        $data=file_get_contents(D_THEME_PATH.'pro/landingpage/templates/packages.txt');
        $data=explode(',',$data);
        echo json_encode($data);
    }else $a=0;
    return $a;
}
function modal_template($modalname){
?>
<script>
    var btnin=-1;
    var disid=0;
    var allow_save_via_keyboard<?=$modalname?>=false;
	$(window).keydown(function(event) {
		if(allow_save_via_keyboard<?=$modalname?>){
			if(event.ctrlKey && event.keyCode == 83) {
				save_editor<?=$modalname?>();
				event.preventDefault(); 
			}else if(event.keyCode == 27) {
			    tutup_editor<?=$modalname?>();
			}
		}
	});
    $(document).ready(function () {
        get_template_package<?=$modalname?>();
        $('#modal-<?=$modalname?>').on('hidden.bs.modal', function () {
            allow_save_via_keyboard<?=$modalname?>=false;
        });
    });
	function tutup_editor<?=$modalname?>(){
		allow_save_via_keyboard<?=$modalname?>=false;
	}
    function get_template_package<?=$modalname?>(){
        $.get(DT,{templatepackagelist<?=$modalname?>:1},function(data){
            var a=JSON.parse(data);
            var b='';
            for(var i=0;i<a.length;i++)
                b+='<button type="button" class="btn btn-md btn-outline-info waves-effect" onclick="select_btn<?=$modalname?>('+i+',\''+a[i]+'\')" id="btn<?=$modalname?>'+i+'">'+a[i]+'</button>';
            $('#template<?=$modalname?>').html(b);
        });
    }
    function select_btn<?=$modalname?>(v,t){
        if(v!=btnin){
            $('#btn<?=$modalname?>'+v).removeClass('btn-outline-info').addClass('btn-info');
            $('#btn<?=$modalname?>'+btnin).removeClass('btn-info').addClass('btn-outline-info');
            btnin=v;
            $.get(DT,{templatelist<?=$modalname?>:t},function(data){
                var a=JSON.parse(data);
                var b='';
                for(var i=0;i<a.length;i++)
                    b+='<img src="theme/pro/landingpage/templates/'+t+'/'+a[i]+'.png" class="img-thumbnail col-lg-5 m-2" alt="Responsive image" onclick="apply_<?=$modalname?>(\''+t+'\',\''+a[i]+'\')">';
                $('#templatedet<?=$modalname?>').html(b);
            });
        }
    }
    function apply_<?=$modalname?>(t,a){
        $.get(DT,{applytmp<?=$modalname?>:t,f:a},function(data){
            editor<?=$modalname?>.setValue(data);
            allow_save_via_keyboard<?=$modalname?>=true;

            var b='< ?';
            b=b.replace(' ','');
            var a=data;
            a=replaceAll(a,b,'<!--?');
            a=replaceAll(a,'?>','?-->');
            $('#visualeditor<?=$modalname?>').html(a);
            $('#templates<?=$modalname?>').hide();
            $('#visual<?=$modalname?>').show();
            $('#html<?=$modalname?>').hide();
        });
    }
    function kevisual<?=$modalname?>(){
        disid=1;
        var b='< ?';
        b=b.replace(' ','');
        var a=editor<?=$modalname?>.getValue();
        a=replaceAll(a,b,'<!--?');
        a=replaceAll(a,'?>','?-->');
        $('#visualeditor<?=$modalname?>').html(a);
        $('#templates<?=$modalname?>').hide();
        $('#visual<?=$modalname?>').show();
        $('#html<?=$modalname?>').hide();
        allow_save_via_keyboard<?=$modalname?>=true;
        $('#btnmedia<?=$modalname?>').show();
    }
    function kehtml<?=$modalname?>(){
        disid=0;
        var a=$('#visualeditor<?=$modalname?>').html();
        var b='< ?';
        b=b.replace(' ','');
        a=replaceAll(a,'<!--?',b);
        a=replaceAll(a,'?-->','?>');
        editor<?=$modalname?>.setValue(a);
        $('#templates<?=$modalname?>').hide();
        $('#visual<?=$modalname?>').hide();
        $('#html<?=$modalname?>').show();
        allow_save_via_keyboard<?=$modalname?>=true;
        $('#btnmedia<?=$modalname?>').hide();
    }
    function ketemplate<?=$modalname?>(){
        $('#templates<?=$modalname?>').show();
        $('#visual<?=$modalname?>').hide();
        $('#html<?=$modalname?>').hide();
        allow_save_via_keyboard<?=$modalname?>=false;
    }
    function add_to_editor<?=$modalname?>(filepath,data){
        var a=data;
        var b='< ?';
        editor<?=$modalname?>.setValue(data);
        editor<?=$modalname?>.getSession().setUndoManager(new ace.UndoManager());
        allow_save_via_keyboard<?=$modalname?>=true;
        b=b.replace(' ','');
        a=replaceAll(a,'?>','?-->');
        a=replaceAll(a,b,'<!--?');
        $('#visualeditor<?=$modalname?>').html(a);
        $('#filename<?=$modalname?>').html(filepath);
    }
	function before_save_editor<?=$modalname?>(){
	    if(disid==1){
            var a=$('#visualeditor<?=$modalname?>').html();
            var b='< ?';b=b.replace(' ','');
            a=replaceAll(a,'<!--?',b);
            a=replaceAll(a,'?-->','?>');
	    }else if(disid==0){
	        var a=editor<?=$modalname?>.getValue();
	    }
		var data={
				script<?=$modalname?>:a,
				file<?=$modalname?>:$('#filename<?=$modalname?>').html(),
			}
		return data;
	}
    function media<?=$modalname?>(){
        set_default_btn_media();
    }
</script>
        <div class="modal fade" id="modal-<?=$modalname?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-fluid" role="document">
            <!-- Content -->
            <div class="modal-content">
                    <div class="green darken-2 card" style="margin-top:-5px">
                        <div class="card-body" style="margin:-15px">
                    <span class="text-white my-1" id="filename<?=$modalname?>"></span>
                    <span class="badge badge-danger float-right ml-3 mr-1" onclick="tutup_editor<?=$modalname?>()" title="Close" data-dismiss="modal"><i class="fa fa-times fa-2x" aria-hidden="true"></i></span>
                    <span title="Design Block" class="badge badge-success float-right mx-1" onclick="ketemplate<?=$modalname?>()"><i class="fa fa-boxes fa-2x" aria-hidden="true"></i></span>
                    <span title="Design" class="badge badge-success float-right mx-1" onclick="kevisual<?=$modalname?>()"><i class="fa fa-tv fa-2x" aria-hidden="true"></i></span>
                    <span title="Source Code" class="badge badge-success float-right mx-1" onclick="kehtml<?=$modalname?>()"><i class="fa fa-code fa-2x" aria-hidden="true"></i></span>
                    <span title="Media" class="badge badge-success float-right mx-1" onclick="media<?=$modalname?>()" data-toggle="modal" data-target="#modal-image" id="btnmedia<?=$modalname?>" style="display:none"><i class="fa fa-image fa-2x" aria-hidden="true"></i></span>
                    <span title="Save" class="badge badge-success float-right mx-3" onclick="save_editor<?=$modalname?>()"><i class="fa fa-save fa-2x" aria-hidden="true"></i></span>
                        </div>
                    </div>
              <!-- Modal cascading tabs -->
              <div class="modal-c-tabs">

                      <div class="mt-2" id="html<?=$modalname?>">
                        <div class="w-100" id="code<?=$modalname?>" style="font-size:100%;height:500px"></div>
                        <script src="/assets/ace/ace.js" type="text/javascript" charset="utf-8"></script>
                        <script>var editor<?=$modalname?> = ace.edit("code<?=$modalname?>");
                            editor<?=$modalname?>.setTheme("ace/theme/monokai");
                            editor<?=$modalname?>.setOption("wrap", true);
                            editor<?=$modalname?>.getSession().setMode("ace/mode/php");</script>
                      </div>
                      <!-- Panel 1 -->
                      <!-- Panel 2 -->
                      <div class="mt-2" id="visual<?=$modalname?>" style="display:none">
                          <div class="border border-info ck ck-content ck-editor__editable ck-rounded-corners ck-editor__editable_inline ck-blurred w-100"  style="height:500px;overflow:scroll" id="visualeditor<?=$modalname?>" contenteditable="true">
                          </div>
                      </div>
                      <div class="mt-2" id="templates<?=$modalname?>" style="display:none">
                          <div class="card"><div class="card-body text-center" id="template<?=$modalname?>">
                        </div></div>
                            <hr>
                          <div class="card" style="margin-top:-5px"><div class="card-body text-center" id="templatedet<?=$modalname?>">
                        </div></div>
                      </div>
                      <!-- Panel 3 -->
                </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <!-- Content -->
            <div class="modal-content">
                <div class="modal-body">
                <style>
                    .img-sel{border:5px solid green}
                </style>
                <div class="row">
                    <div class="col-lg-9 col-md-8">
<?php
$fn=D_MODULE_PATH.'core/media/functions.php';
require $fn;
$media=get_media_meta();
$ei=array('jpg','jpeg','gif','png');
foreach($media as $k => $v)if($v['status']&&in_array($v['extention'],$ei)){
?>
                    <img src="http://<?=D_DOMAIN.'/0/'.$v['file']?>" class="imgdblc img-thumbnail" width="100" ondblclick="change_img_src()" onclick="select_img(<?=$k?>,'http://<?=D_DOMAIN.'/0/'.$v['file']?>')" id="img<?=$k?>">
<?php }?>
                        
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label>Link</label>
                        <input readonly class="form-control" id="linkbdg" onclick="copythis(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                    <input type="hidden" id="imgsrc">
                    <span class="badge badge-danger m-2 float-right" data-dismiss="modal" style="font-size:100%"><i class="fas fa-times"></i> Cancel</span>
                    <span class="badge badge-success m-2 float-right" style="font-size:100%" onclick="change_img_src()" id="btn-select"><i class="fas fa-save"></i> Select</span>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>

<script>
    var elm;
    var iimg=-1;
    var TAG;
    $('#visualeditor<?=$modalname?>' ).dblclick(function( event ) {
        TAG=event.target.nodeName;
        elm=event.target;
        switch(TAG){
        case 'IMG':
            set_default_btn_media();
            $('#imgsrc').val(event.target.src);
            $('#modal-image').modal('show');
            break;
        }
    });
    $('#visualeditor<?=$modalname?>' ).click(function( event ) {
        TAG=event.target.nodeName;
        elm=event.target;
    });
    function set_default_btn_media(){
        $('#btn-select').attr('onclick','change_img_src()');
        $('.imgdblc').each(function(){
            $(this).attr('ondblclick','change_img_src()').removeClass('img-sel');
        });
        $('#linkbdg').val('');
    }
    function change_img_src(){
        if(TAG=='IMG'){
            elm.src=$('#imgsrc').val();
        }else{
            var b='<img class="img-fluid" src="'+$('#imgsrc').val()+'">';
            var a=elm.innerHTML;
            elm.innerHTML=a+b;
        }
        $('#modal-image').modal('hide');
    }
    function select_img(id,v){
        $('#imgsrc').val(v);
        if(id!=iimg){
            $('#img'+id).addClass('img-sel');
            if(iimg>=0)$('#img'+iimg).removeClass('img-sel');
            iimg=id;
            $('#linkbdg').val(v);
        }
    }
</script>
<script src="https://cdn.ckeditor.com/4.14.0/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.inline('visualeditor<?=$modalname?>', {
      //extraPlugins: 'image2,uploadimage',
      extraPlugins: 'easyimage',
      toolbar: [{
          name: 'clipboard',
          items: ['Undo', 'Redo']
        },
        {
          name: 'basicstyles',
          items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
        },
        {
          name: 'paragraph',
          items: ['NumberedList', 'BulletedList', '-', /*'Outdent', 'Indent',*/ '-', 'Blockquote']
        },/*
        {
          name: 'styles',
          items: ['Styles', 'Format']
        },
        {
          name: 'links',
          items: ['Link', 'Unlink']
        },
        {
          name: 'insert',
          items: ['Image', 'Table']
        },
        {
          name: 'editing',
          items: ['Scayt']
        },
        {
          name: 'tools',
          items: ['Maximize']
        },//*/
      ],

      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      filebrowserBrowseUrl: '/apps/ckfinder/3.4.5/ckfinder.html',
      filebrowserImageBrowseUrl: '/apps/ckfinder/3.4.5/ckfinder.html?type=Images',
      filebrowserUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Images',

      // Upload dropped or pasted images to the CKFinder connector (note that the response type is set to JSON).
      uploadUrl: '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',

      // Reduce the list of block elements listed in the Format drop-down to the most commonly used.
      format_tags: 'p;h1;h2;h3;pre',
      // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
      removeDialogTabs: 'image:advanced;link:advanced',

      height: 450
    });
//    initSample();
</script>

<?php }

function modal_editor($modalname){?>
<script>
    var allow_save_via_keyboard<?=$modalname?>=false;
	$(window).keydown(function(event) {
		if(allow_save_via_keyboard<?=$modalname?>){
			if(event.ctrlKey && event.keyCode == 83) {
				save_editor<?=$modalname?>();
				event.preventDefault(); 
			}else if(event.keyCode == 27) {
			    tutup_editor<?=$modalname?>();
			}
		}
	});
    $(document).ready(function () {
        $('#modal-<?=$modalname?>').on('hidden.bs.modal', function () {
            allow_save_via_keyboard<?=$modalname?>=false;
        });
    });
	function tutup_editor<?=$modalname?>(){
		allow_save_via_keyboard<?=$modalname?>=false;
	}
    function add_to_editor<?=$modalname?>(filepath,data){
        editor<?=$modalname?>.setValue(data);
        editor<?=$modalname?>.getSession().setUndoManager(new ace.UndoManager());
        allow_save_via_keyboard<?=$modalname?>=true;
        $('#filename<?=$modalname?>').html(filepath);
    }
	function before_save_editor<?=$modalname?>(){
        var a=editor<?=$modalname?>.getValue();
		var data={
				script<?=$modalname?>:a,
				file<?=$modalname?>:$('#filename<?=$modalname?>').html(),
			}
		return data;
	}
</script>
        <div class="modal fade" id="modal-<?=$modalname?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fluid" role="document">
                <!-- Content -->
                <div class="modal-content">
                          <div class="blue card" style="margin-top:-5px"><div class="card-body" style="margin:-15px"><span class="text-white my-1" id="filename<?=$modalname?>"></span>
                          <span class="badge badge-danger badge-pill float-right mx-1" onclick="tutup_editor<?=$modalname?>()" title="Close" data-dismiss="modal"><i class="fa fa-times fa-2x" aria-hidden="true"></i></span>
                          <span class="badge badge-success badge-pill float-right mx-1" onclick="save_editor<?=$modalname?>()"><i class="fa fa-save fa-2x" aria-hidden="true"></i></span>
                          </div></div>
                        <div class="w-100" id="code<?=$modalname?>" style="font-size:100%;height:500px"></div>
                        <script src="/assets/ace/ace.js" type="text/javascript" charset="utf-8"></script>
                        <script>var editor<?=$modalname?> = ace.edit("code<?=$modalname?>");
                            editor<?=$modalname?>.setTheme("ace/theme/monokai");
                            editor<?=$modalname?>.setOption("wrap", true);
                            editor<?=$modalname?>.getSession().setMode("ace/mode/php");</script>
                </div>
            </div>
        </div>

<?php }
/*
///////////////         VIEW            //////////////////

<?php
require D_CORE_PATH.'editor_template.php';
$f='tmp';
?>
<script type="text/javascript">
    function save_editor<?=$f?>(){
        var data=before_save_editor<?=$f?>();
        data.path='asd';
        $.post(PT,data,function(data){
            alert_ok(data,'berhasilll');
        })
    }
    function load_editor<?=$f?>(){
        $.get(DT,{load:1},function(data){alert(data);
            var path='ghj/hj/sdf/sdf/23/2dr.php';
            add_to_editor<?=$f?>(path,data);
        });
    }
</script>

<main>
	<div class="container">
		<section class="section">
            <div class="card ">
              <h5 class="card-header h5 bg-success text-white">Daftar link</h5>
              <div class="card-body">
                  <div class="row">
                      <div class="col-lg-6 col-md-6">
                        Aplikasi: <button class="btn btn-primary" data-toggle="modal" data-target="#modal-tmp" onclick="load_editor<?=$f?>()">tes</button>
                      </div>
                </div>
              </div>
            </div>
		</section>
	</div>
</main>

<?php modal_template($f);?>





//////////////          DATA            //////////////////////

<?php
require D_CORE_PATH.'editor_template.php';
$f='tmp';
function_getmethod($f);
?>




///////////////////             POST                ///////////////////

if(isset($_POST['script'.$f])){
    file_put_contents(D_HTML.$aplikasi.'/'.$_POST['file'.$f],$_POST['script'.$f]);
    echo 'ok';
}
*/
?>