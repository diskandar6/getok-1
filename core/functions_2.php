<?php
function set_pdf_properties($pdf,$subject='',$title='',$keyword=''){
    if(isset($_SESSION['nama']))$pdf->SetAuthor($_SESSION['nama']);
    else $pdf->SetAuthor('Dadang Iskandar');
    $pdf->SetCreator('Dadang Iskandar');
    $pdf->SetSubject($subject);
    $pdf->SetTitle($title);
    $pdf->SetKeywords($keyword);
}
function RP($v){
    if($v==0)return '';
    return number_format($v,0,',','.');
}
function peta_kampus(){
    return '<iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.6457262544236!2d107.62141351449098!3d-6.932878219789046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e87e75fda8e9%3A0x373a596a24c3d3a!2sSTIKes+\'Aisyiyah+Bandung+Kampus+1!5e0!3m2!1sid!2sid!4v1460950023730" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
}
function add_table($id,$title,$class='',$foot=true,$tclass=''){
    $res1 ='    <table id="'.$id.'" class="display table large-header '.$tclass.'" width="100%">';
    $a='<tr>'.chr(10);foreach ($title as $key => $value)$a.='<th>'.$value.'</th>'.chr(10);$a.='</tr>';
    $res1.='<thead class="'.$class.'">'.$a.'</thead>';
    $res1.='<tbody></tbody>';
    if(!isset($color))$color='';
    if($foot)
        $res1.='<tfoot class="'.$color.'">'.$a.'</tfoot>';
    $res1.='</table>';
    return $res1;
}

function plupload2($dir='',$fe='i,z,e,w,r,c,p,t,x,13O',$fun='',$maxsize=100){
	if($dir!='')
		$_SESSION['uploads']=$dir;
	elseif(isset($_SESSION['uploads']))
			unset($_SESSION['uploads']);
	?>

                <!-- Central Modal Large Info-->
                <div class="modal fade" id="uploads" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
                        <!--Content-->
                        <div class="modal-content">
                            <!--Header-->
                            <!--Body-->
                            <div class="modal-body">

								<script type="text/javascript" src="/assets/plupload/js/plupload.full.min.js"></script>
								<div id="container">
								    <button class="btn btn-success" id="pickfiles" >Browse File</button>
								<?php //    <button class="btn btn-success" id="uploadfiles" >Upload</button>?>
								</div>
								<div id="filelist_upload">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
								<pre id="console"></pre>
								<script type="text/javascript">
								// Custom example logic
                                function pre_upload(v=1){
                                    $.get(DT,{upload:v},function(data){<?php //alert(data);?>
                                        new_upload();
                                    })
                                }
								function new_upload(){
									document.getElementById('filelist_upload').innerHTML = '';
								}
								var uploader = new plupload.Uploader({
									runtimes : 'html5,flash,silverlight,html4',
									browse_button : 'pickfiles', <?php // you can pass an id...?>
									container: document.getElementById('container'), <?php // ... or DOM Element itself?>
									url : '/',<?php //'uploads.php',?>
									flash_swf_url : '/assets/plupload/js/Moxie.swf',
									silverlight_xap_url : '/assets/plupload/js/Moxie.xap',
									
									filters : {
										max_file_size : '<?=$maxsize?>mb',
										mime_types: [<?php if($fe!=''){$e=explode(',',$fe);
											if(in_array('i', $e))echo '{title : "Image files", extensions : "jpg,jpeg,gif,png"},';
											if(in_array('z', $e))echo '{title : "Zip files", extensions : "zip"},';
											if(in_array('e', $e))echo '{title : "MS Excel files", extensions : "xls,xlsx,csv"},';
											if(in_array('w', $e))echo '{title : "MS Word files", extensions : "doc,docx,dot"},';
											if(in_array('r', $e))echo '{title : "MS Power Point files", extensions : "ppt,pptx"},';
											if(in_array('c', $e))echo '{title : "CSV files", extensions : "csv"},';
											if(in_array('p', $e))echo '{title : "PDF files", extensions : "pdf"},';
											if(in_array('t', $e))echo '{title : "ASCII files", extensions : "txt"},';
											if(in_array('x', $e))echo '{title : "Application", extensions : "exe"},';
											if(in_array('13O', $e))echo '{title : "RNX", extensions : "13o"},';
											if(in_array('raw', $e))echo '{title : "RAW", extensions : "raw"},';
											if(in_array('gts7', $e))echo '{title : "GTS7", extensions : "gts7"},';
											if(in_array('crd', $e))echo '{title : "CRD", extensions : "crd"},';
											if(in_array('sdr', $e))echo '{title : "SDR", extensions : "sdr"},';
											}?>
										]
									},

									init: {
										PostInit: function() {
											document.getElementById('filelist_upload').innerHTML = '';

											/*document.getElementById('uploadfiles').onclick = function() {
												uploader.start();
												return false;
											};*/
										},

										FilesAdded: function(up, files) {
											plupload.each(files, function(file) {
												document.getElementById('filelist_upload').innerHTML += 
												'<h5>' + file.name + ' <span>(' + plupload.formatSize(file.size) + ')</span><b style="float:right" id="a' + file.id + '">0%</b></h5><div class="progress"> <div id="b' + file.id + '" class="progress-bar bg grey darken-3" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>';
												//'<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
												uploader.start();
											});
										},

                                        FileUploaded: function(up, file, info) {
                                            // Called when file has finished uploading
                                            //console.log('[FileUploaded] File:', file, "Info:", info);
                                            <?=$fun?>
                                        },
        
                                        UploadComplete: function(up, files) {
                                            $('#uploads').modal('hide');
                                        },

										UploadProgress: function(up, file) {
											//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
											$('#a'+file.id).html(file.percent + "%");
											$('#b'+file.id).attr("aria-valuenow",file.percent).css({width:file.percent+'%'});
										},

										Error: function(up, err) {
											document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
										}
									}
								});

								uploader.init();

								</script>

                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
<?php }

function set_upload_path($v){
    if(isset($_GET['upload'])){
        $_SESSION['uploads']=$v;
        return true;
    }else return false;
}
function plupload($dir='',$fe='i,z,r,w,e,c,p,t,x',$finished='',$maxsize=100,$multiple=true){
	if($dir!='')
		$_SESSION['uploads']=$dir;
	elseif(isset($_SESSION['uploads']))
			unset($_SESSION['uploads']);
//*	?>
<div class="container" id="uploads" style="display:none;position:fixed;top:50px;left:0;right:0;bottom:0;z-index:9999999">
    <div class="row justify-content-md-center mt-5">
        <div class="col-lg-6 col-md-8">
            <div class="card">
                <div class="card-header info-color white-text">Upload</div>
                <div class="card-body">
					<script type="text/javascript" src="/assets/plupload/js/plupload.full.min.js"></script>
					<div id="container">
						<button class="btn btn-info" id="pickfiles" >Browse File</button>
						<?php //    <button class="btn btn-success" id="uploadfiles" >Upload</button>?>
					</div>
					<div id="filelist_upload">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
					<pre id="console"></pre>
					<script type="text/javascript">
                        var iscroping=true;
							// Custom example logic
                        function pre_upload(v=1){
                            $.get(DT,{upload:v},function(data){<?php //echo 'alert(data);';?>
                                new_upload();
                            })
                        }
                        function new_upload(){
                            document.getElementById('filelist_upload').innerHTML = '';
                        }
						var uploader = new plupload.Uploader({
							runtimes : 'html5,flash,silverlight,html4',
							browse_button : 'pickfiles', <?php // you can pass an id...?>
							container: document.getElementById('container'), <?php // ... or DOM Element itself?>
							url : '/',<?php //'uploads.php',?>
							flash_swf_url : '/assets/plupload/js/Moxie.swf',
							silverlight_xap_url : '/assets/plupload/js/Moxie.xap',
                            multi_selection :<?php if($multiple)echo 'true';else echo 'false';?>,
							filters : {
								max_file_size : '<?=$maxsize?>mb',
								mime_types: [<?php if($fe!=''){$e=explode(',',$fe);
									if(in_array('i', $e))echo '{title : "Image files", extensions : "jpg,jpeg,gif,png"},';
									if(in_array('z', $e))echo '{title : "Zip files", extensions : "zip"},';
									if(in_array('r', $e))echo '{title : "MS Powerpoint files", extensions : "ppt,pptx"},';
									if(in_array('w', $e))echo '{title : "MS Word files", extensions : "doc,docx"},';
									if(in_array('e', $e))echo '{title : "MS Excel files", extensions : "xls,xlsx,csv"},';
									if(in_array('c', $e))echo '{title : "CSV files", extensions : "csv"},';
									if(in_array('p', $e))echo '{title : "PDF files", extensions : "pdf"},';
									if(in_array('t', $e))echo '{title : "ASCII files", extensions : "txt"},';
									if(in_array('x', $e))echo '{title : "Application", extensions : "exe"},';
									if(in_array('13O', $e)){
									    echo '{title : "RNX", extensions : "o,';
									    for($h=0;$h<100;$h++){
									        if($h<10)$g='0'.$h;
									        else $g=$h;
									        echo $g.'o';
									        if($h<99)
									            echo ',';
									    }
									    echo '"},';
									}
									if(in_array('raw', $e))echo '{title : "RAW", extensions : "raw"},';
									if(in_array('gts7', $e))echo '{title : "GTS7", extensions : "gts7"},';
									if(in_array('crd', $e))echo '{title : "CRD", extensions : "crd"},';
									if(in_array('sdr', $e))echo '{title : "SDR", extensions : "sdr"},';
									}?>
								]
							},

							init: {
								PostInit: function() {
									document.getElementById('filelist_upload').innerHTML = '';

									/*document.getElementById('uploadfiles').onclick = function() {
										uploader.start();
										return false;
									};*/
								},

								FilesAdded: function(up, files) {
									plupload.each(files, function(file) {
										document.getElementById('filelist_upload').innerHTML += 
										'<h5>' + file.name + ' <span>(' + plupload.formatSize(file.size) + ')</span><b style="float:right" id="a' + file.id + '">0%</b></h5><div class="progress"> <div id="b' + file.id + '" class="progress-bar bg grey darken-3" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div>';
										//'<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
										uploader.start();
									});
								},

								UploadProgress: function(up, file) {
									//document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
									$('#a'+file.id).html(file.percent + "%");
									$('#b'+file.id).attr("aria-valuenow",file.percent).css({width:file.percent+'%'});
								},

                                FileUploaded: function(up, file, info) {
                                    // Called when file has finished uploading
                                    //console.log('[FileUploaded] File:', file, "Info:", info);
                                    <?=$finished?>
                                },

                                UploadComplete: function(up, files) {
                                    $('#uploads').modal('hide');
                                },

								Error: function(up, err) {
									document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
								}
							}
						});

						uploader.init();

					</script>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //*/?>

<?php }
function split_query($aa){
    $f=false;
    $r='';
    $e=array();
    for($i=0;$i<strlen($aa);$i++){
        if($aa[$i]==='"')$f=!$f;
        if($aa[$i]===';'){
            if(!$f){
                array_push($e,$r);
                $r='';
            }else $r.=$aa[$i];
        }else $r.=$aa[$i];
    }
    if(strlen($r)>0)array_push($e,$r);
    return $e;
}
function delete_form($fun=''){if($fun!='')$fun.='()';?>
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger modal-sm" role="document">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <p class="heading lead text-center">Are you sure you want to delete this record ?</p>
    
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="white-text">x</span>
            </button>
          </div>
    
          <!--Footer-->
          <div class="modal-footer justify-content-center">
            <a type="button" class="btn btn-md btn-danger waves-effect waves-light" onclick="<?=$fun?>" id="btn-delete">Yes</a>
            <a type="button" class="btn btn-md btn-outline-danger waves-effect" data-dismiss="modal">Cancel</a>
          </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<?php
}

function maintenance($id=-9999){
$res=false;
if(isset($_SESSION['id']))
    $res=(int)$id!=(int)$_SESSION['id'];
if($id==-9999||$res){?>
<!DOCTYPE html>

<html class="gr__mackeycreativelab_com"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width">
<title>UNISA-BANDUNG <?=date('Y')?></title>
<meta name="description" content="Performing maintenance...">
<link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon" />
<style type="text/css">
    /* Reset */
	html, body, div, span, applet, object, iframe,
	h1, h2, h3, h4, h5, h6, p, blockquote, pre,
	a, abbr, acronym, address, big, cite, code,
	del, dfn, em, img, ins, kbd, q, s, samp,
	small, strike, strong, sub, sup, tt, var,
	b, u, i, center,
	dl, dt, dd, ol, ul, li,
	fieldset, form, label, legend,
	table, caption, tbody, tfoot, thead, tr, th, td,
	article, aside, canvas, details, embed, 
	figure, figcaption, footer, header, hgroup, 
	menu, nav, output, ruby, section, summary,
	time, mark, audio, video {
		margin: 0;
		padding: 0;
		border: 0;
		font-size: 100%;
		font: inherit;
		vertical-align: baseline;
	}
	/* HTML5 display-role reset for older browsers */
	article, aside, details, figcaption, figure, 
	footer, header, hgroup, menu, nav, section {
		display: block;
	}
	body {
		line-height: 1;
	}
	ol, ul {
		list-style: none;
	}
	blockquote, q {
		quotes: none;
	}
	blockquote:before, blockquote:after,
	q:before, q:after {
		content: '';
		content: none;
	}
	table {
		border-collapse: collapse;
		border-spacing: 0;
	}
      
      html {font-size: 16px;}
      body { text-align: center; padding: 150px; }
      h1 { font-size: 40px; font-weight: bold; margin-bottom: 1rem;}
      p {font-size: 1.5rem; margin-bottom: 1rem;}
      body { font: 20px Helvetica, sans-serif; color: #333; }
      #article { display: block; text-align: left; width: 650px; margin: 0 auto; }
      a { color: #dc8100; text-decoration: none; }
      a:hover { color: #333; text-decoration: none; }
    </style>
</head>
<body data-gr-c-s-loaded="true">
<div id="article">
<h1>Our site is getting a little tune up and some love.</h1>
<div>
<p>We apologize for the inconvenience, but we're performing some maintenance. You can still contact us at <a href="https://wa.me/6287829633532"><span class="__cf_email__" data-cfemail="a4c1c9c5cdc8e4c0cbc9c5cdca8ac7cbc9">087829633532</span></a>. We'll be back up soon!</p>
<p>— PUSDATIN — Unisa Bandung</p>
</div>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script data-cfasync="false" src="./Performing Maintenance_files/email-decode.min.js"></script>
</body></html>
<?php exit;}}

function search_add(){
/*
//serach_add_call_func(); adalah function yang dieksekusi saat pemilihan data sudah ditentukan

contoh penggunaan:

### view.php

function reformattable_(nRow, aData, iDisplayIndex, iDisplayIndexFull){
    var data=badge_search_add(id,aData[1],'pengelola','Data Pengelola','Cari Pegawai');
    $('td:eq(1)',nRow).html(data);
}

function serach_add_call_func(v){
    switch(v){
        case 'pengelola':
            load_data_('pengguna');
            break;
        case 'kategori':
            load_data_('kategori');
            break;
    }
}


### data.php

function cari_pengelola(){
    if(isset($_GET['search_add_value'])){
        $db=$GLOBALS['dbasetmaster'];
        $ky=$_GET['search_add_value'];
        switch($_GET['search_add_id']){
            case 'pengelola':
                $data=$db->get_results("SELECT id_user AS id,nama FROM main_biodatatendik WHERE status=1 AND nama LIKE '%$ky%'");
            break;
            case 'kategori':
                $data=$db->get_results("SELECT id,nama FROM _aset_pengguna WHERE status=1 AND nama LIKE '%$ky%'");
            break;
        }
        if(count($data)<10)
            echo json_encode($data);
        else echo '[]';
        exit;
    }return false;
}

### post.php
function post_ed_pengelola(){
    if(isset($_POST['search_add_apply'])){
        $db=$GLOBALS['dbasetmaster'];
        $id=(int)$_POST['id_parent'];
        $idp=(int)$_POST['search_add_apply'];
        switch($_POST['search_add_id']){
            case 'pengelola':
                $data=$db->get_row("SELECT pengelola FROM _aset_pengguna WHERE id=$id");
                $data=json_decode($data->pengelola,true);
                if(!in_array($idp,$data)){
                    $data[]=$idp;
                    $res=json_encode($data);
                    $db->update('_aset_pengguna',array('pengelola'=>$res),array('id'=>$id),array('%s'),array('%d'));
                }
                break;
            case 'kategori':
                $data=$db->get_row("SELECT pengguna FROM _aset_kategori WHERE id=$id");
                $data=json_decode($data->pengguna,true);
                if(!in_array($idp,$data)){
                    $data[]=$idp;
                    $res=json_encode($data);
                    $db->update('_aset_kategori',array('pengguna'=>$res),array('id'=>$id),array('%s'),array('%d'));
                }
                break;
        }
        echo 'ok';
        exit;
    }return false;
}

*/
?>
<script>
    var search_add_id='';
    function call_modal_search_add(id,app_id,title,caption){
        search_add_id=app_id;
        set_id(id);
        $('#value-search_add').val('');
        $('#caption-search_add').text(caption);
        $('#modal-search_add-title').text(title);
        $('#modal-search_add').modal('show');
    }
	function search_key(v){
	    $.get(DT,{search_add_id:search_add_id,search_add_value:v},function(data){
	        var data=JSON.parse(data);
	        var b='';
	        for(var i=0;i<data.length;i++)
	            b+='<a class="dropdown-item" href="#" onclick="apply_search_add('+data[i].id+')">'+data[i].nama+'</a>';
	        $('#search_add_selected').html(b);
	    })
	}
    function apply_search_add(v){
	    $.post(PT,{search_add_id:search_add_id,search_add_apply:v,id_parent:get_id()},function(data){
	        alert_ok(data,'ok');
	        serach_add_call_func(search_add_id);
	        remove_id();
	        $('#modal-search_add').modal('hide');
	    })
    }
	function badge_search_add(id,aData,app_id,title,caption){
	    try{
    	    var a=JSON.parse(aData);
    	    var b='';
    	    for(var i=0;i<a.length;i++){
    	        b+='<a class="badge badge-default badge-pill z-depth-0">'+a[i][1]+' <i onclick="hapus_search_add('+id+','+a[i][0]+',\''+app_id+'\')" class="fas fa-times text-dark" aria-hidden="true"></i></a> ';
    	    }
    	    b+='<a class="badge badge-primary badge-pill z-depth-0" onclick="call_modal_search_add('+id+',\''+app_id+'\',\''+title+'\',\''+caption+'\')"><i class="fas fa-plus" aria-hidden="true"></i></a> ';
    	    return b;
	    }catch(e){
	        return false;
	    }
	}
	function hapus_search_add(idp,id,app_id){
	    $.post(PT,{search_add_id:app_id,search_add_rem:idp,id:id},function(data){
	        alert_ok(data,'ok');
	        serach_add_call_func(app_id);
	    });
	}
</script>

<div class="modal fade" id="modal-search_add" tabindex="-1" role="dialog" aria-labelledby="modal-penggunaTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-search_add-title">Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-12">
                <label for="value-search_add" id="caption-search_add">Caption</label>
                <input type="text" id="value-search_add" class="form-control" data-toggle="dropdown" onkeyup="search_key(this.value)" onclick="$('#search_add_selected').html('')">
                <div class="dropdown-menu" id="search_add_selected"></div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php }
?>