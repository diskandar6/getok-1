<?php
function search_file($keyword,$fix='',$root=''){
    if($keyword=='')
        return '[]';
    if($_SESSION['id']==0)
        $ff=D_MAIN_PATH;
    else
        $ff=constant('D_'.D_DOMAIN);
    $ff=str_replace('//','/',$ff.$root);
    $fld=substr($ff,0,strlen($ff)-1);
    $act=$keyword;
    $fold=array($fld);
    $j=0;
    $res=array();
    while(count($fold)>0){//$j<1000){//
        $f=$fold[$j];
        $dir=scandir($f);
        for($i=0;$i<count($dir);$i++){
            if($dir[$i]!='.'&&$dir[$i]!='..'){
                if(is_dir($f.'/'.$dir[$i])){
                    array_push($fold,$f.'/'.$dir[$i]);
                    $s=explode($act,$dir[$i]);
                    if(count($s)>1)
                        array_push($res,array(str_replace($ff,'',$f.'/'),$dir[$i],'Folder'));
                }else{
                    $s=explode($act,$dir[$i]);
                    if(count($s)>1){
                        $path=dirname(str_replace('./','',$f.'/'.$dir[$i])).'/';
                        $path=str_replace($ff,'',$path);
                        $edit=$dir[$i];
                        $edit='<span onclick="load_ascii'.$fix.'(\''.$edit.'\',\''.$path.'\')">'.$edit.'</span>';
                        array_push($res,array($path,$edit,'File'));
                    }
                }
            }
        }
        unset($fold[$j]);
        $j++;
    }
    return json_encode($res);
}
function search_text($keyword,$fix='',$root=''){
    if($keyword=='')
        return '[]';
    if($_SESSION['id']==0)
        $ff=D_MAIN_PATH;
    else
        $ff=constant('D_'.D_DOMAIN);
    $ff=str_replace('//','/',$ff.$root);
    $fld=substr($ff,0,strlen($ff)-1);
    $act=$keyword;
    $fild=array();
    $fold=array($fld);
    $fils=array();
    $j=0;
    while(count($fold)>0){//$j<1000){//
        $f=$fold[$j];
        $dir=scandir($f);
        for($i=0;$i<count($dir);$i++){
            if($dir[$i]!='.'&&$dir[$i]!='..'){
                if(is_dir($f.'/'.$dir[$i])){
                    array_push($fold,$f.'/'.$dir[$i]);
                    array_push($fild,$f.'/'.$dir[$i]);
                }else{
                    $g=explode('.',$dir[$i]);
                    $g=end($g);
                    if($g=='php')
                        array_push($fils,$f.'/'.$dir[$i]);
                }
            }
        }
        unset($fold[$j]);
        $j++;
    }
    $res=array();
    foreach ($fils as $key => $value) {
        $c=file_get_contents($value);
        $s=strpos($c,$act);
        $a=explode(chr(10),substr($c,0,$s));
        $fff=str_replace('./','',$value);
        $path=dirname($fff).'/';
        $path=str_replace($ff,'',$path);
        $edit=basename($fff);
        $edit='<span onclick="load_ascii'.$fix.'(\''.$edit.'\',\''.$path.'\')">'.$edit.'</span>';
        if($s!==false)array_push($res,array($path,$edit,count($a)));
    }
    return json_encode($res);
}
function include_($dir,$fn){
    $res='';
    if(file_exists($fn)){
        $file=file_get_contents($fn);
        $include=explode('<?=',$file);
        $res.=$include[0];
        for($i=1;$i<count($include);$i++){
            $f=explode('?>',$include[$i]);
            if(count(explode('.',$f[0]))>1){
                $var=$dir.'variables/'.$f[0];
                if(file_exists($var)) $res.=include_($dir,$var);else $res.='error:{<b>'.$f[0].'</b> not found}';
            }else{
                $cek=explode('D_',$f[0]);
                if($cek[0]==''&&count($cek)>1){
                    if(defined($f[0]))
                        $res.=constant($f[0]);
                    else
                        $res.=$f[0];
                }else{
                    $ff=explode('(',$f[0]);
                    if(function_exists($ff[0]))
                        $res.=$ff[0]();
                    else
                        $res.=$f[0];
                }
            }
            $res.=$f[1];
        }
    }
    return $res;
}

function scan_folders($path){
    $r=array();
    if($_SESSION['id']<0){
        $pt=explode('../',$path);
        if(count($pt)>1)return $r;
    }
    $res=scandir($path);unset($res[0]);unset($res[1]);$res=array_values($res);
    $hdr=json_decode(D_HIDE_DIR,true);
    foreach ($res as $key => $value)
        if(is_dir($path.$value))
            if(!in_array($value,$hdr))
                array_push($r,$value);
    return $r;
}
function scan_folder($path,$fix='',$index=-1){
    if($_SESSION['id']<0){
        $pt=explode('../',$path);
        if(count($pt)>1)return array();
    }
    if($index>=3)return array();
    $index++;
	$res=scandir($path);unset($res[0]);unset($res[1]);$res=array_values($res);
	$folder=array();
	$hdr=json_decode(D_HIDE_DIR,true);
	foreach ($res as $key => $value){
		if(is_dir($path.$value))if(!in_array($value,$hdr)){
			$fold=scan_folder($path.$value.'/',$fix,$index);
			$val=str_replace($_SESSION[$fix.'path_explorer'],'',$path.$value);
			if(count($fold)>0)
				array_push($folder,array('path'=>$val,'nama'=>basename($value),'anak'=>$fold));
			else
				array_push($folder,array('path'=>$val,'nama'=>basename($value),'anak'=>array()));
		}
	}
	return $folder;
}

function is_ASCII_file($filename){
    $finfo = finfo_open(FILEINFO_MIME);
    //check to see if the mime-type starts with 'text'
    return substr(finfo_file($finfo, $filename), 0, 4) == 'text';
}

function defined_from_file($file){
    if(file_exists($file))compile_cons($file);
}

function data_explorer($fix=''){
    if(isset($_GET[$fix.'treeview'])){
        if(function_exists('folderlist'))folderlist();
        else echo json_encode(scan_folders(str_replace('//','/',$_SESSION[$fix.'path_explorer'].$_GET[$fix.'treeview'].'/'),$fix));
    }elseif(isset($_GET[$fix.'upload'])){
        $_SESSION['uploads']=$_SESSION[$fix.'path_explorer'].$_GET[$fix.'upload'];
    }elseif(isset($_GET[$fix.'close_preview'])){
        unset($_SESSION['htmleditor']);
    }elseif(isset($_GET[$fix.'preview'])){
        $_SESSION['htmleditor']=$_GET[$fix.'preview'];
    }elseif(isset($_GET[$fix.'download'])){
        if(isset($_SESSION['forcedownload'])){
            $file=$_SESSION['forcedownload'];
            unset($_SESSION['forcedownload']);
            force_download($file);
        }else{
            if(!isset($_GET[$fix.'path']))$_GET[$fix.'path']='';
            $_SESSION['forcedownload']=$_SESSION[$fix.'path_explorer'].$_GET[$fix.'path'].$_GET[$fix.'download'];
            echo 'ok';
        }
    }elseif(isset($_GET[$fix.'folderlist'])){
        if(function_exists('folderlist'))folderlist();
        else echo json_encode(scan_folder($_SESSION[$fix.'path_explorer'],$fix));
    }elseif(isset($_GET[$fix.'workspace'])){
        echo $_SESSION[$fix.'path_explorer'];
    }elseif(isset($_GET[$fix.'file'])){
        $fn=str_replace('//','/',$_SESSION[$fix.'path_explorer'].$_GET[$fix.'path'].'/'.$_GET[$fix.'file']);
        $ext=explode('.',$_GET[$fix.'file']);
        $ext=end($ext);
        if(isset($_GET[$fix.'force'])){
            if($ext=='pdf'){
                $_SESSION['intpdf']=$fn;
                echo 'ok';
            }else{
            	$fn=file_get_contents($fn);
            	if($ext=='png'||$ext=='gif'||$ext=='jpg'||$ext=='jpeg'){
            	    if($ext=='jpg')$ext='jpeg';
            	    $fn='data:image/' . $ext . ';base64,' . base64_encode($fn);
            	}
            	echo $fn;
            }
        }else{
            if($ext=='png'||$ext=='gif'||$ext=='jpg'||$ext=='jpeg'){
                echo 'image';
            }elseif($ext=='pdf'){
                echo 'pdf';
            }else{//if(!is_binary_file($fn)){
                $D_EXT=json_decode(D_EXT,true);
                $D_VAL=json_decode(D_VAL,true);
                if(in_array(strtolower($ext),$D_EXT)||in_array(strtolower($_GET[$fix.'file']),$D_VAL)||$_GET[$fix.'file']=='error_log')
                    echo 'ascii';
            }
        }
    }elseif(isset($_GET[$fix.'path'])){
        if($_SESSION['id']!=0){
            $pt___=explode('../',$_GET[$fix.'path']);
            if(count($pt___)>1)return array();
        }
    	$res=scandir($_SESSION[$fix.'path_explorer'].$_GET[$fix.'path']);unset($res[0]);unset($res[1]);$res=array_values($res);
    	$hdr=json_decode(D_HIDE_DIR,true);
    	foreach ($res as $key => $value) {
    		$st=stat($_SESSION[$fix.'path_explorer'].$_GET[$fix.'path'].'/'.$value);
    		if(is_dir($_SESSION[$fix.'path_explorer'].$_GET[$fix.'path'].'/'.$value)){
    		    if(!in_array($value,$hdr)){
        			$res[$key]=array($value,1);
        			$res[$key][3]='';
        			$res[$key][4]=0;
        			$res[$key][2]=date("F d Y H:i:s",$st['mtime']);
    		    }else unset($res[$key]);
    		}else{
    			$res[$key]=array($value,0);
    			if($st['size']>1000000){
    				$res[$key][3]=(round($st['size']/1000)/1000).' mb';
    			}elseif($st['size']>1000){
    				$res[$key][3]=($st['size']/1000).' kb';
    			}else
    				$res[$key][3]=$st['size'].' b';
    			$ext=explode('.',$value);$ext=end($ext);
    			if(defined('D_EXT'))$D_EXT=json_decode(D_EXT,true);else $D_EXT=array();
    			if(defined('D_VAL'))$D_VAL=json_decode(D_VAL,true);else $D_VAL=array();
    			if($ext=='zip')$res[$key][4]=2;
                elseif(in_array($ext,$D_EXT)||in_array($value,$D_VAL)
    		     ||in_array('php',$D_EXT)||in_array('define',$D_VAL)
                )
    			    $res[$key][4]=1;
    			else $res[$key][4]=0;
    			$res[$key][2]=date("F d Y H:i:s",$st['atime']);
    		}
    	}
    	if(defined('D_HIDE_FILE'))$def_file1=json_decode(D_HIDE_FILE,true);else $def_file1=array();
    	if(defined('D_HIDE_EXT'))$def_file2=json_decode(D_HIDE_EXT,true);else $def_file2=array();
    	$r=array();
    	foreach($res as $k => $v)
    	    if(!in_array($v['0'],$def_file1)){
    	        $ext=explode('.',$v['0']);
    	        $ext=end($ext);
    	        if(!in_array($ext,$def_file2))
        	        array_push($r,$v);
    	    }
    	echo json_encode($r);
    }
}

function download_from_url($url,$filename){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    $fp = fopen($filename, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
}
function post_explorer($fix=''){
    if(isset($_POST[$fix.'pro'])){
        if(!isset($_POST[$fix.'path']))$_POST[$fix.'path']='';
        switch($_POST[$fix.'pro']){
            case 'workspace':if(is_dir($_POST[$fix.'workspace']))$_SESSION[$fix.'path_explorer']=$_POST[$fix.'workspace'];echo 'ok';break;
            case 'createfolder':if(is_dir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'])){mkdir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'].$_POST[$fix.'workspace'],0755);}echo 'ok';break;
            case 'createfile':if(is_dir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'])){file_put_contents($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'].$_POST[$fix.'workspace'],'');}echo 'ok';break;
            case 'downloadfile':if(is_dir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'])){
                $tr=explode('/',$_POST[$fix.'workspace']);
                $tr=end($tr);
                download_from_url($_POST[$fix.'workspace'],$_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'].$tr);
                } echo 'ok'; break;
            case 'delete':
                if(!isset($_POST[$fix.'workspace']))break;
                if($_POST[$fix.'workspace']=='')break;
                $file=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'].$_POST[$fix.'workspace'];
                delete_and_backup($file);
                /*$now=strtotime('now');
                if(is_dir($file)){
                    $fn=D_BACKUP.'delete - '.date('Y-m-d-H-i-s',$now).'.zip';
                    zip_whole_folder($fn,array($file));
                    delete_folder($file);
                }else{
                    $fn=D_BACKUP.'delete - '.date('Y-m-d-H-i-s',$now).'.zip';
                    zip_a_file($fn,array($file));
                    unlink($file);
                }//*/
                echo 'ok';
                break;
            default:
                $a=explode('@',$_POST[$fix.'pro']);
                switch($a[0]){
                    case 'compress':if(is_dir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'])){
                        $path=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'];
                        if(is_dir($path.$a[1]))
                            zip_whole_folder($path.$_POST[$fix.'workspace'],array($path.$a[1]));
                        else
                            zip_a_file($path.$_POST[$fix.'workspace'],array($path.$a[1]));
                        echo 'ok';
                        break;
                    }
                    case 'rename':if(is_dir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'])){
                        $path=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'];
                        rename($path.$a[1],$path.$_POST[$fix.'workspace']);
                        echo 'ok';
                        break;
                    }
                    case 'copy':if(is_dir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'])){
                        $path=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'];
                        $dest=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'workspace'];
                        if(is_dir($path.$a[1]))
                            copy_folder($path.$a[1],$dest);
                        else
                            copy($path.$a[1],$dest);
                        echo 'ok';
                        break;
                    }
                    case 'move':if(is_dir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'])){
                        $path=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'];
                        $dest=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'workspace'];
                        rename($path.$a[1],$dest);
                        echo 'ok';
                        break;
                    }
                    case 'unzip':if(is_dir($_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'])){
                        $path=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'];
                        $dest=$_SESSION[$fix.'path_explorer'].$_POST[$fix.'workspace'];
                        if(!unzip($path.$a[1],$dest))echo 'failed!';else echo 'ok';
                        break;
                    }
                }
                break;
        }
    }elseif(isset($_POST[$fix.'script'])){
        file_put_contents(str_replace('//','/',$_SESSION[$fix.'path_explorer'].$_POST[$fix.'path'].'/'.$_POST[$fix.'file']),$_POST[$fix.'script']);
        echo 'ok';
    }
}

function delete_file_explorer($fix=''){?>
<div class="modal fade" id="deletefile_<?=$fix?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-danger modal-sm" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead text-center">Are you sure you want to delete <span style="font-weight:bold" id="filp"></span> ?</p>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-md btn-danger" onclick="delete_file_<?=$fix?>()">Yes</a>
        <a type="button" class="btn btn-md btn-outline-danger waves-effect" data-dismiss="modal">Cancel</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<?php
}

function work_space_explorer($fix='',$folderparam=''){?>
<div class="modal fade" id="modal-workspace<?=$fix?>" tabindex="-1" role="dialog" aria-labelledby="workspace"
  aria-hidden="true">
	<div class="modal-dialog" role="document">
        <div class="modal-content form-elegant">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="ws" id="lws<?=$fix?>">Work space</label>
                        <input type="text" id="ws<?=$fix?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" onclick="savews<?=$fix?>()">Save</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <script>
                    function savews<?=$fix?>(){
                    	var data={
                    			act:'explorer',
                    			<?=$fix?>path:$('#<?=$fix?>path').val(),
                    			<?=$fix?>workspace:$('#ws<?=$fix?>').val(),
                    			<?=$fix?>pro:$('#ws<?=$fix?>').attr('d')
                    		}
                    	<?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
                        $.post(PT,data,function(data){
                            if(data!='ok')alert(data);
                            else{
                                get_all<?=$fix?>();
                            }
                            $('#modal-workspace<?=$fix?>').modal('hide');
                            add_root(0);
                        });
                    }
                </script>
            </div>
        </div>
    </div>
</div>
    
<?php
}

function preview_explorer($fix=''){?>
<div style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:99999;display:none" id="preview_<?=$fix?>">
    <iframe src="" class="" style="width:100%;height:100%;border:none;" id="ipreview_<?=$fix?>"></iframe>
    <div style="position:absolute;top:0;right:0">
        <span class="badge badge-danger badge-pill float-right" onclick="hide_preview<?=$fix?>()" title="Close"><i class="fa fa-times fa-2x" aria-hidden="true"></i></span>
    </div>
</div>
<?php }

function editor_explorer($fix='',$save=true,$preview=true,$close=true){?>
        <div class="row" style="display:none;z-index:10" id="editt<?=$fix?>">
            <div class="col-12" id="code<?=$fix?>" style="position:absolute;top:36px;left:0;bottom:0;font-size:100%;z-index:10"></div>
            <script src="/assets/ace/ace.js" type="text/javascript" charset="utf-8"></script>
            <script>var editor<?=$fix?> = ace.edit("code<?=$fix?>");
	            editor<?=$fix?>.setTheme("ace/theme/monokai");
				editor<?=$fix?>.setOption("wrap", true);
				editor<?=$fix?>.getSession().setMode("ace/mode/php");</script>
			<div class="col-12 blue" style="position:absolute;right:0;top:0;z-index:10;" id="<?=$fix?>titlebar">
			    <?php if($close){?>
				<span class="badge badge-danger badge-pill float-right mt-1" onclick="tutup_editor<?=$fix?>()" title="Close"><i class="fa fa-times fa-2x" aria-hidden="true"></i></span>
				<?php }if($save){?>
				<span class="badge badge-success badge-pill float-right mr-3 mt-1" onclick="simpan_editor<?=$fix?>()" title="Save"><i class="fa fa-save fa-2x" aria-hidden="true"></i></span>
				<?php }if($preview){?>
				<span class="badge badge-success badge-pill float-right mr-3 mt-1" onclick="preview_editor<?=$fix?>()" title="Preview"><i class="fa fa-tv fa-2x" aria-hidden="true"></i></span>
				<input class="float-right mr-3 mt-1" id="url" placeholder="<?=D_PROTOCOL?>://<?=D_DOMAIN?>/" value="<?=D_PROTOCOL?>://<?=D_DOMAIN?>/">
				<?php }?>
				<label class="white-text mt-1" id="filename_<?=$fix?>"></label>
			</div>
        </div>
		<div class="row" style="display:none;z-index:10" id="viewimage<?=$fix?>">
			<div class="col-12" style="position:absolute;right:0;top:-30px;z-index:10">
				<span class="badge badge-danger badge-pill float-right" onclick="tutup_editor<?=$fix?>()" title="Close"><i class="fa fa-times fa-2x" aria-hidden="true"></i></span>
			</div>
            <div class="col-12 text-center" style="position:absolute;top:5px;left:0;bottom:5px;z-index:10">
                <img class="img-thumbnail z-depth-2" title="" src="" id="image<?=$fix?>" style="" onclick="$('#viewimage<?=$fix?>').hide()">
            </div>
        </div>
		<div class="row" style="display:none" id="viewpdf<?=$fix?>">
			<div class="col-12" style="position:absolute;right:0;top:-30px;z-index:10">
				<span class="badge badge-danger badge-pill float-right" onclick="tutup_editor<?=$fix?>()" title="Close"><i class="fa fa-times fa-2x" aria-hidden="true"></i></span>
			</div>
            <div class="col-12" style="position:absolute;top:5px;left:0;bottom:5px;z-index:10">
                <iframe src="/int/<?=D_PAGE?>/" id="pdf<?=$fix?>" style="width:100%;height:100%;border:none"></iframe>
            </div>
        </div>
<?php }

function treeview_explorer1($fix='',$folderparam=''){?>
                <style>#trv{margin-left:-20px;}#trv li{list-style:none;margin-left:-20px;}</style>
                <div class="border">
                    <h6 class="pt-3 pl-3">
                        <span onclick="load_folderlist<?=$fix?>()">Folder</span><?php if($_SESSION['id']==0){?><span class="badge badge-info badge-pill float-right mr-3" data-toggle="modal" data-target="#modal-workspace<?=$fix?>" onclick="work_space<?=$fix?>()"><i class="fa fa-sitemap" aria-hidden="true"></i></span><?php }?>
                    </h6>
                    <hr>
                    <div class="text-nowrap" style="overflow:auto;height:410px;margin-top:-15px">
                        <div id="<?=$fix?>p0" parent="-1" class="ml-2 mt-2"></div>
                    </div>
                </div>
                <script>
                    var idtrv=0;
                    $(document).ready(function(){
                        add_root(0);
                    });
                    function add_root(parent,cpt='',idp=-1){
                        var cc=cpt;
                        while(idp>=0){
                            cc=$('#<?=$fix?>l'+idp).text()+'/'+cc;
                            idp=$('#<?=$fix?>p'+idp).attr('parent');
                        }
                        cc=cc.substring(1)+'/';
                        var data={<?=$fix?>treeview:cc}
                        <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
                        $.get(DT,data,function(data){
                            var data=JSON.parse(data);
                            var a='';
                            if(parent>0)
                            a+='<i class="fa fa-folder yellow-text" data-toggle="collapse" href="#<?=$fix?>c'+
                            parent+'" aria-expanded="true" aria-controls="<?=$fix?>c'+
                            parent+'"></i> <a href="#" id="<?=$fix?>l'+parent+
                            '" onmouseup="open_folder('+parent+')">'+cpt+
                            '</a><div class="collapse ml-4" id="<?=$fix?>c'+parent+'">';
                            a+='<ul id="trv">';
                            for(var i=0;i<data.length;i++){
                                idtrv+=1;
                                a+='<li><i title="Load Folder" class="fa fa-sync green-text" onmousedown="add_root('+idtrv+',\''+data[i]+
                                '\','+parent+')"></i> <span id="<?=$fix?>p'+idtrv+'" parent="'+parent+
                                '"><a href="#" id="<?=$fix?>l'+idtrv+'" onmouseup="open_folder('+idtrv+')">'+data[i]+
                                '</a></span></li>';
                            }
                            a+='</ul>';
                            if(parent>0) a+='</div>';
                            $('#<?=$fix?>p'+parent).html(a);
                        });
                    }
                    function open_folder(idp){
                        var cc='';
                        while(idp>=0){
                            cc=$('#<?=$fix?>l'+idp).text()+'/'+cc;
                            idp=$('#<?=$fix?>p'+idp).attr('parent');
                        }
                        cc=cc.substring(1);
                        path__<?=$fix?>(cc);
                    }
                </script>
<?php }
function treeview_explorer($fix=''){?>
                <div class="treeview-animated border">
                    <h6 class="pt-3 pl-3 col-12">
                        <span onclick="load_folderlist<?=$fix?>()">Folders</span><?php if($_SESSION['id']==0){?><span class="badge badge-info badge-pill float-right" data-toggle="modal" data-target="#modal-workspace<?=$fix?>" onclick="work_space<?=$fix?>()"><i class="fa fa-sitemap" aria-hidden="true"></i></span><?php }?>
                    </h6>
                    <hr>
                    <div class="my-custom-scrollbar my-custom-scrollbar-primary" style="overflow: auto;height:410px">
                        <ul class="treeview-animated-list mb-3" id="folderlist__<?=$fix?>"></ul>
                    </div>
                </div>
<?php }

function file_list_explorer($fix=''){?>
                <div class="row">
                    <div class="col-12">
                        <span class="badge badge-info badge-pill float-right mb-1" title="Create folder" onclick="create_folder<?=$fix?>()"><i class="fa fa-folder-plus" aria-hidden="true"></i></span>
                        <span class="badge badge-info badge-pill mr-1 float-right mb-1 ml-2" title="Create file" onclick="create_file<?=$fix?>()"><i class="fa fa-file-medical" aria-hidden="true"></i></span>
                        <span class="badge badge-info badge-pill mr-1 float-right mb-1 mr-2" title="Download" onclick="download_file<?=$fix?>()"><i class="fa fa-download" aria-hidden="true" data-toggle="modal" data-target="#downloads"></i></span>
                        <span class="badge badge-info badge-pill mr-1 float-right mb-1 ml-2" title="Upload" onclick="upload_file<?=$fix?>()"><i class="fa fa-upload" aria-hidden="true" data-toggle="modal" data-target="#uploads"></i></span>
                        <span class="badge badge-info badge-pill mr-1 float-right mb-1 mr-2" title="Up level" onclick="uplevel<?=$fix?>()"><i class="fa fa-arrow-up" aria-hidden="true"></i></span>
                        <div class="input-group input-group-sm mb-1">
                          <input id="<?=$fix?>path" type="text" class="form-control" aria-label="Sizing input" aria-describedby="label-path"<?php if($_SESSION['id']<0)echo ' readonly="true"';?>>
                          <div class="input-group-append">
                            <span class="input-group-text primary-color white-text" id="label-path" onclick="path__<?=$fix?>($('#<?=$fix?>path').val())" style="border:none"><i class="fa fa-check"></i></span>
                          </div>
                        </div>
                    </div>
                    <div class="col-12 my-custom-scrollbar my-custom-scrollbar-primary" style="overflow: auto;height:450px">
                        <ul class="list-group" id="filelist<?=$fix?>"></ul>
                    </div>
                </div>
<?php }

function event_explorer($fix='',$folderparam=''){?>
<script type="text/javascript">
	var allow_save_via_keyboard=false;
	$(document).ready(function() {
		get_all<?=$fix?>();
		$('#uploads').on('hidden.bs.modal', function () {
            path__<?=$fix?>($('#<?=$fix?>path').val());
        });
        load_folderlist<?=$fix?>();
	});
	$(window).keydown(function(event) {
		if(allow_save_via_keyboard){
			if(event.ctrlKey && event.keyCode == 83) {
				simpan_editor<?=$fix?>();
				event.preventDefault(); 
			}else if(event.keyCode == 27) {
			    tutup_editor<?=$fix?>();
			}
		}
	});
	function path__<?=$fix?>(v){
	    var data={act:'explorer',<?=$fix?>path:v}
	    <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
		$.get(DT,data,function(data){
			var data=JSON.parse(data);
			var a='';
			for(i=0;i<data.length;i++)
				a+=list_item<?=$fix?>(data[i]);
			$('#filelist<?=$fix?>').html(a);
		});
		$('#<?=$fix?>path').val(v);
	}
	function list_item<?=$fix?>(val){
		var a='<li class="list-group-item">';
		a+='<div class="md-v-line"></div><i class="mr-4 pr-3 ';
		if(val[1]==1){
			a+='far fa-folder yellow-text"';
	    	a+=' onclick="path__<?=$fix?>(\''+$('#<?=$fix?>path').val()+val[0]+'/\')"></i> ';
		    a+='<span onclick="path__<?=$fix?>(\''+$('#<?=$fix?>path').val()+val[0]+'/\')">';
    		a+=val[0];
		    a+='</span>';
		}else{
			a+='far fa-file blue-text"';
			if(val[4]==1)
				a+=' onclick="load_ascii<?=$fix?>(\''+val[0]+'\')"';
		    a+='></i> ';
		    a+='<span';
			if(val[4]==1)
    		    a+=' onclick="load_ascii<?=$fix?>(\''+val[0]+'\')"';
    		a+='>';
		    a+=val[0];
		    a+='</span>';
		}
		a+='<span class="float-right">';
		a+=val[2]+' ';
		if(val[3]!='')
		    a+='('+val[3]+') ';
		a+='| <i class="far fa-file-archive green-text" aria-hidden="true" onclick="compress_<?=$fix?>(\''+val[0]+'\')"></i> ';
		if(val[4]==2)
		    a+='| <i class="fa fa-briefcase" aria-hidden="true" onclick="unzip_<?=$fix?>(\''+val[0]+'\')"></i> ';
		if(val[1]!=1)
		    a+='| <i class="fa fa-download blue-text" aria-hidden="true" onclick="force_download_<?=$fix?>(\''+val[0]+'\')"></i> ';
		a+='| <i class="fa fa-font black-text" aria-hidden="true" onclick="rename_<?=$fix?>(\''+val[0]+'\')"></i>';
		a+='| <i class="far fa-copy yellow-text" aria-hidden="true" onclick="copy_<?=$fix?>(\''+val[0]+'\')"></i> ';
		a+='| <i class="fa fa-file-export blue-text" aria-hidden="true" onclick="move_<?=$fix?>(\''+val[0]+'\')"></i> ';
		a+='| <i class="fa fa-trash red-text" aria-hidden="true" data-toggle="modal" data-target="#deletefile_<?=$fix?>" onclick="delete_file_p<?=$fix?>(\''+val[0]+'\')"></i>';
		a+='</span>';
		a+='</li>';
		return a;
	}
	function force_download_<?=$fix?>(a){
	    var data={act:'explorer',<?=$fix?>download:a,<?=$fix?>path:$('#<?=$fix?>path').val()}
	    <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
	    $.get(DT,data,function(data){
	        if(alert_ok(data,'ok'))
	            document.location=DT+"?act=explorer&<?=$fix?>download=1<?php if($folderparam!='')echo "&folderparam=$folderparam";?>";
	    });
	}
    function compress_<?=$fix?>(a){
    	$('#ws<?=$fix?>').val(a+'.zip').attr('d','compress@'+a);
    	$('#lws<?=$fix?>').text('Compression');
    	$('#modal-workspace<?=$fix?>').modal('show');
    }
    function rename_<?=$fix?>(a){
    	$('#ws<?=$fix?>').val(a).attr('d','rename@'+a);
    	$('#lws<?=$fix?>').text('Rename');
    	$('#modal-workspace<?=$fix?>').modal('show');
    }
    function copy_<?=$fix?>(a){
    	$('#ws<?=$fix?>').val($('#<?=$fix?>path').val()+a).attr('d','copy@'+a);
    	$('#lws<?=$fix?>').text('Copy to');
    	$('#modal-workspace<?=$fix?>').modal('show');
    }
    function move_<?=$fix?>(a){
    	$('#ws<?=$fix?>').val($('#<?=$fix?>path').val()+a).attr('d','move@'+a);
    	$('#lws<?=$fix?>').text('Move to');
    	$('#modal-workspace<?=$fix?>').modal('show');
    }
    function unzip_<?=$fix?>(a){
    	$('#ws<?=$fix?>').val($('#<?=$fix?>path').val()).attr('d','unzip@'+a);
    	$('#lws<?=$fix?>').text('Unzip to');
    	$('#modal-workspace<?=$fix?>').modal('show');
    }
    function delete_file_p<?=$fix?>(a){
        $('#filp').text(a).attr('d',a);
    }
    function delete_file_<?=$fix?>(){
        var data={
                act:'explorer',
                <?=$fix?>path:$('#<?=$fix?>path').val(),
                <?=$fix?>workspace:$('#filp').attr('d'),
                <?=$fix?>pro:'delete'
        }
        <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
        $.post(DT,data,function(data){
            if(data!='ok')alert(data);
            else{
                get_all<?=$fix?>('1');
                $('#deletefile_<?=$fix?>').modal('hide');
            }
        });
    }
	function load_ascii<?=$fix?>(val,path='-'){
    	if(path=='-')
        	path=$('#<?=$fix?>path').val();
        else
        	$('#<?=$fix?>path').val(path);
		var data={
				<?=$fix?>path:path,
				<?=$fix?>file:val,
				act:'explorer'
			}
		<?php if($folderparam!='')echo "data.folderparam='$folderparam';".chr(10);?>
		$.get(DT,data,function(data){
		    if(data=='ascii'){
        		var data={
        				<?=$fix?>path:path,
        				<?=$fix?>file:val,
        				<?=$fix?>force:data[0],
        				act:'explorer'
        			}
        		<?php if($folderparam!='')echo "data.folderparam='$folderparam';".chr(10);?>
        		$.get(DT,data,function(data){
        			editor<?=$fix?>.setValue(data);
        			editor<?=$fix?>.getSession().setUndoManager(new ace.UndoManager());
        			allow_save_via_keyboard=true;
        			$('#filename_<?=$fix?>').text(path+val);
        			$('#editt<?=$fix?>').show().attr('fn',val);
        		})
		    }else
		    if(data=='image'){
        		var data={
        				<?=$fix?>path:path,
        				<?=$fix?>file:val,
        				<?=$fix?>force:data[0],
        				act:'explorer'
        			}
        		<?php if($folderparam!='')echo "data.folderparam='$folderparam';".chr(10);?>
        		$.get(DT,data,function(data){
    		        $('#image<?=$fix?>').attr('src',data);
    		        $('#viewimage<?=$fix?>').show();
        		})
		    }else
		    if(data=='pdf'){
        		var data={
        				<?=$fix?>path:path,
        				<?=$fix?>file:val,
        				<?=$fix?>force:data[0],
        				act:'explorer'
        			}
        		<?php if($folderparam!='')echo "data.folderparam='$folderparam';".chr(10);?>
        		$.get(DT,data,function(data){
        		    $('#pdf<?=$fix?>').attr('src','/int/<?=D_PAGE?>/');
    		        $('#viewpdf<?=$fix?>').show();
        		})
		    }
		})
	}
	function tutup_editor<?=$fix?>(){
		allow_save_via_keyboard=false;
		$('#editt<?=$fix?>').hide();
		$('#viewimage<?=$fix?>').hide();
		$('#viewpdf<?=$fix?>').hide();
	}
	function simpan_editor<?=$fix?>(){
		var data={
				<?=$fix?>script:editor<?=$fix?>.getValue(),
				act:'explorer',
				<?=$fix?>path:$('#<?=$fix?>path').val(),
				<?=$fix?>file:$('#editt<?=$fix?>').attr('fn'),
			}
		<?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
		$.post(PT,data,function(data){
			alert_ok(data,'Saved!');
		})
	}
	function preview_editor<?=$fix?>(){
	    var u1=$('#url').val();
	    var u2=$('#ipreview_<?=$fix?>').attr('src');
	    var data={act:'explorer',<?=$fix?>preview:u1}
	    <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
	    $.get(DT,data,function(data){
    	    if(u1!=u2)
    	        $('#ipreview_<?=$fix?>').attr('src',u1);
    	    else
    	        document.getElementById('ipreview_<?=$fix?>').contentDocument.location.reload(true);
    	    $('#preview_<?=$fix?>').show();
	    });
	}
    function work_space<?=$fix?>(){
        var data={act:'explorer',<?=$fix?>workspace:1}
        <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
        $.get(DT,data,function(data){
            $('#ws<?=$fix?>').val(data).attr('d','workspace');
        });
    }
    function create_folder<?=$fix?>(){
    	$('#ws<?=$fix?>').val('').attr('d','createfolder');
    	$('#lws<?=$fix?>').text('Create Folder');
    	$('#modal-workspace<?=$fix?>').modal('show');
    }
    function create_file<?=$fix?>(){
    	$('#ws<?=$fix?>').val('').attr('d','createfile');
    	$('#lws<?=$fix?>').text('Create File');
        $('#modal-workspace<?=$fix?>').modal('show');
    }
    function download_file<?=$fix?>(){
    	$('#ws<?=$fix?>').val('').attr('d','downloadfile');
    	$('#lws<?=$fix?>').text('Download URL');
        $('#modal-workspace<?=$fix?>').modal('show');
    }
    function uplevel<?=$fix?>(){
        var a=$('#<?=$fix?>path').val();
        a=a.split('/');
        a.splice(a.length-1);
        a.splice(a.length-1);
        if(a.length>0)
            path__<?=$fix?>(a.join('/')+'/');
        else
            path__<?=$fix?>('');
    }
    function load_folderlist<?=$fix?>(folderparam=''){
        var data={act:'explorer',<?=$fix?>folderlist:1}
        <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
        $.get(DT,data,function(data){
            var data=JSON.parse(data);
            var a=set_list<?=$fix?>(data);
            $('#folderlist__<?=$fix?>').html(a);
            $('.treeview-animated').mdbTreeview();
            add_root(0);
        });
    }
	function set_list<?=$fix?>(data){
		var a='';
		for(var i=0;i<data.length;i++){
			if(data[i].anak.length==0){
				a+='<li>';
				a+='<div class="treeview-animated-element" onmouseup="path__<?=$fix?>(\''+data[i].path+'/\')"><span><i class="far fa-folder ic-w mr-1"></i>';
				a+=data[i].nama;
				a+='</div></li>';
			}else{
				a+='<li class="treeview-animated-items"><a class="closed" onmouseup="path__<?=$fix?>(\''+data[i].path+'/\')">';
				a+='<i class="fas fa-angle-right"></i><span><i class="far fa-folder ic-w mx-1"></i>';
				a+=data[i].nama;
				a+='</span></a>';
				a+='<ul class="nested">';
				a+=set_list<?=$fix?>(data[i].anak);
				a+='</ul></li>';
			}
		}
		return a;
	}
	function upload_file<?=$fix?>(){
	    var data={act:'explorer',<?=$fix?>upload:$('#<?=$fix?>path').val()}
	    <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
	    $.get(DT,data,function(){
	        new_upload();
	    })
	}
	function get_all<?=$fix?>(v=''){
	    if(($('#ws').attr('d')=='workspace')||(($('#ws').attr('d')=='createfolder')&&($('#path').text()=='')))
            load_folderlist<?=$fix?>();
        if($('#<?=$fix?>path').val()==''){
            load_folderlist<?=$fix?>();
            path__<?=$fix?>('');
        }else
            path__<?=$fix?>($('#<?=$fix?>path').val());
	}
	function hide_preview<?=$fix?>(){
	    var data={act:'explorer',<?=$fix?>close_preview:1}
	    <?php if($folderparam!='')echo "data.folderparam='$folderparam';";?>
	    $.get(DT,data,function(data){
	        $('#preview_<?=$fix?>').hide();
	    });
	}
</script>
<style type="text/css">
.md-v-line {
position: absolute;
border-left: 1px solid rgba(0,0,0,.125);
height: 50px;
top:0px;
left:54px;
}
</style>
<?php }

function load_config_explorer($dir){
    require $dir.'/explorer_config.php';
}

function set_ext_explorer($dir,$ext){
    write_registry($dir.'/explorer_config.php','EXT',json_encode($ext));
}
function set_value_explorer($dir,$val){
    write_registry($dir.'/explorer_config.php','VAL',json_encode($val));
}
function set_hide_ext_explorer($dir,$ext){
    write_registry($dir.'/explorer_config.php','HIDE_EXT',json_encode($ext));
}
function set_hide_file_explorer($dir,$file){
    write_registry($dir.'/explorer_config.php','HIDE_FILE',json_encode($file));
}
function set_hide_dir_explorer($dir,$path){
    write_registry($dir.'/explorer_config.php','HIDE_DIR',json_encode($path));
}

//PENGGUNAAN*/
/*//////////////////////////////////////////////////////////////////////////////
                                CONTOH view.php
<?php
$fix='abc';
event_explorer($fix)?>
<main>
    <div class="container-fluid">
        <section class="section">
            <div class=row>
                <div class="col-12">
                    <div class="card mt-4 mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a class="badge badge-primary mb-1" onclick="get_filelist('pages')">Pages</a>
                                    <a class="badge badge-primary" onclick="get_filelist('variables')">Variables</a>
                                    <a class="badge badge-primary" onclick="get_filelist('assets')">Assets</a>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                        <?=treeview_explorer($fix)?>
                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-6">
                                        <?=file_list_explorer($fix)?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php editor_explorer($fix);?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<footer class="page-footer font-small light-blue darken-4">
    <div class="footer-copyright text-center py-3">� 2020 Copyright:
        <a href="https://oceanomatics.com/">oceanomatics.com</a>
    </div>
</footer>
<?php 
preview_explorer($fix);
work_space_explorer($fix);
delete_file_explorer($fix);
plupload($fix);
?>
<script>
$(document).ready(function() {
    get_filelist('assets');
});
	function get_filelist(v){
		$.get(DT,{work_space:v},function(data){
		    get_all<?=$fix?>();
			if(v=='variables'){
			    $('#list-variables-list').addClass('active');
			    $('#list-pages-list').removeClass('active');
			    $('#list-assets-list').removeClass('active');
			}else if(v=='pages'){
			    $('#list-variables-list').removeClass('active');
			    $('#list-pages-list').addClass('active');
			    $('#list-assets-list').removeClass('active');
			}else{
			    $('#list-variables-list').removeClass('active');
			    $('#list-pages-list').removeClass('active');
			    $('#list-assets-list').addClass('active');
			}
		});
	}

</script>

////////////////////////////////////////////////////////////////////////////////
                                CONTOH data.php
<?php
$fix='abc';
defined_from_file(dirname(__FILE__).'/define');
if(isset($_GET['work_space'])){
    switch($_GET['work_space']){
        case 'variables':   $_SESSION[$fix.'path_explorer']=dirname(__FILE__).'/variables/'; break;
        case 'pages':       $_SESSION[$fix.'path_explorer']=dirname(__FILE__).'/pages/'; break;
        case 'assets':      $_SESSION[$fix.'path_explorer']=D_MODULES.D_DOMAIN.'/assets/';
    }
}else{
    $dir=dirname(__FILE__);
    //set_ext_explorer($dir,array("js","php","html","htm","css","meta","txt","log","csv","svg"));
    //set_value_explorer($dir,array());
    //set_hide_ext_explorer($dir,array());
    //set_hide_file_explorer($dir,array());
    //set_hide_dir_explorer($dir,array());

    load_config_explorer($dir);
    data_explorer($fix);
}
?>

////////////////////////////////////////////////////////////////////////////////
                                CONTOH post.php
<?php
load_config_explorer(dirname(__FILE__));
post_explorer('abc');
?>

////////////////////////////////////////////////////////////////////////////////
                                CONTOH define
{"D_EXT":["js","html","htm","css","meta"],"D_VAL":["define","abc"],"D_HIDE_EXT":["php","htaccess"],"D_HIDE_FILE":["define"],"D_HIDE_DIR":[]}

//////////////////////////////////////////////////////////////////////////////*/
?>