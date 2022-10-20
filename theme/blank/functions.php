<?php
function header_page($hdr){
	require __DIR__.'/main_header.php';
	//require $hdr['subtheme'].'/subheader.php';
}
function footer_page($hdr){
	//require $hdr['subtheme'].'/subfooter.php';
	require __DIR__.'/main_footer.php';
}
/*
function icon_categories(){
	$dir1=dirname(__FILE__).'/icons/';
	$dir=scandir($dir1);
	$res=array();
	foreach ($dir as $key => $value)if(strpos($value,'.txt')!==false){
		$fn=str_replace('.txt','',$value);
		array_push($res,str_replace('icon-','',$fn));
	}
	return $res;
}
function icons($type='all'){
	$dir=dirname(__FILE__).'/icons/icon-'.$type.'.txt';
	if(file_exists($dir)){
		$icons=explode(chr(10),file_get_contents($dir));
		$res=array();
		foreach($icons as $k => $v)if($v!=''){
			$vv=explode(' ',$v);
			$v1=explode(',',$vv[0]);
			foreach($v1 as $k1 => $v2)if($v2!='fa')
				array_push($res,$v2.' '.$vv[1]);
		}
		return $res;
	}
}

function icons_($type='brand'){
	if($type=='All')
		$dir=dirname(__FILE__).'/icons/icons.txt';
	else
		$dir=dirname(__FILE__).'/icons/icon-'.$type.'.txt';
	if(file_exists($dir)){
		$icons=explode(chr(10),file_get_contents($dir));
		$res=array();
		foreach($icons as $k => $v)if($v!=''){
			array_push($res,$v);
		}
		return $res;
		//draw_icons($res,$type);
	}
}
function draw_icons_($icons,$type='brand'){
	$res='';
	$rr='';
	foreach ($icons as $key => $value){
		$re=explode(' ',$value);
		if(count($re)==1){
			$r =($key+1).'<span class="badge badge-info" onclick="_save_icn(\'icon-'.$type.'.txt\','.$key.',\'fa\')"><i class="fa '.$re[0].'"></i></span>';
			$r.='<span class="badge badge-info" onclick="_save_icn(\'icon-'.$type.'.txt\','.$key.',\'fas\')"><i class="fas '.$re[0].'"></i></span>';
			$r.='<span class="badge badge-info" onclick="_save_icn(\'icon-'.$type.'.txt\','.$key.',\'fab\')"><i class="fab '.$re[0].'"></i></span>';
			$r.='<span class="badge badge-info" onclick="_save_icn(\'icon-'.$type.'.txt\','.$key.',\'far\')"><i class="far '.$re[0].'"></i></span><br>';
		}else{
			$rt=array('fa','fas','fab','far');
			$ry=explode(',',$re[0]);
			$r =$key+1;
			foreach($rt as $k => $v){
				if(!in_array($v,$ry)){
					$r.='<span class="badge badge-info" onclick="_save_icn(\'icon-'.$type.'.txt\','.$key.',\''.$v.'\')"><i class="'.$v.' '.$re[1].'"></i></span>';
				}
			}
			$r.='<br>';
		}
		$res.=$r;
	}
	echo $res;
}
function save_icn_($file,$line,$index){echo 'ok';
	$dir=dirname(__FILE__).'/icons/'.$file;
	$icons=explode(chr(10),file_get_contents($dir));
	$icn=explode(' ',$icons[$line]);
	if(count($icn)==1){
		$icons[$line]=$index.' '.$icons[$line];
		file_put_contents($dir,implode(chr(10),$icons));
	}else{
		$ic1=explode(',',$icn[0]);
		if(!in_array($index,$ic1)){
			$icons[$line]=$index.','.$icons[$line];
			file_put_contents($dir,implode(chr(10),$icons));
		}
	}
}

/* /////////////////////////////////////////////////////////
	data.php

if(isset($_GET['file'])){
	//print_r($_GET);
	save_icn_($_GET['file'],$_GET['line'],$_GET['index']);
}

////////////////////////////////////////////////////////////
	view.php
<script>
	function _save_icn(f,l,i){
		$.get(DT,{file:f,line:l,index:i},function(data){
			location.reload();
		})
	}';
</script>

<?php

$icons=icons_('all');
draw_icons_($icons,'all');

?>

//////////////////////////////////////////////////////////*/
?>