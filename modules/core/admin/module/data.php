<?php
require __DIR__.'/d_package.php';
if($continue){
    if(isset($_GET['debug'])){$continue=false;
        if(isset($_SESSION['debug'])){
            if($_SESSION['debug'])
                echo json_encode(array('status'=>'ok','caption'=>'Debug Mode (on)'));
            else
                echo json_encode(array('status'=>'ok','caption'=>'Debug Mode (off)'));
        }else echo json_encode(array('status'=>'ok','caption'=>'Debug Mode (off)'));
    }elseif(isset($_GET['constant'])){$continue=false;
        $fn=D_MODULE_PATH.'core/constant.php';
        if(file_exists($fn)){
            $res=json_decode(file_get_contents($fn),true);
            foreach($res as $k => $v){
                if($v[1]==''||$v[1]=='-')
                    $res[$k][1]=constant($v[0]);
            }
            echo json_encode($res);
        }else echo '[]';
    }elseif(isset($_GET['config'])){$continue=false;
     	$c=config_list($_GET['config']);
    	$res=array();
    	foreach($c as $k => $v)
    		array_push($res,array('key'=>stripslashes($k),'value'=>stripslashes($v)));
    	echo json_encode($res);
    }elseif(isset($_GET['icon'])){$continue=false;
    	echo json_encode(icons($_GET['icon']));
    }elseif(isset($_GET['iconcat'])){$continue=false;
    	$res=icon_categories();
    	$r=array();
    	foreach($res as $v)
    		array_push($r,array('text'=>$v,'value'=>$v));
    	echo json_encode($r);
    }elseif(isset($_GET['menu'])){$continue=false;
    	if(defined('D_'.$_GET['menu'])){
    		$apl=constant('D_'.$_GET['menu']);
    		$res=array();
    		$bdl=menu_list($apl);
    		foreach($bdl as $k => $v)
    			array_push($res,array('text'=>$v[0],'value'=>$v[0]));
    		echo json_encode($res);
    	}else echo '[]';	
    }elseif(isset($_GET['bundle'])){$continue=false;
    	if(defined('D_'.$_GET['bundle'])){
    		$apl=constant('D_'.$_GET['bundle']);
    		$res=array();
    		$bdl=bundle_list($apl);
    		foreach($bdl as $k => $v)
    			array_push($res,array('text'=>$v,'value'=>$v));
    		echo json_encode($res);
    	}else echo '[]';	
    }elseif(isset($_GET['aplikasi'])){$continue=false;
    	$appl=application_list();
    	if($_SESSION['id']==0){
    		$res=array();
    		foreach($appl as $k => $v)
    		array_push($res,array('text'=>$k,'value'=>$k));
    	}else{
    		$res=array(array('text'=>$_SESSION['applikasi'],'value'=>$_SESSION['applikasi']));
    	}
    	echo json_encode($res);
    }elseif(isset($_GET['edit_module'])){$continue=false;
    	$dir=D_MODULE_PATH.$_GET['edit_module_apl'].'/';
    	require $dir.'registry.php';
    	$dir=constant('D_'.$_GET['edit_module']).'header.php';
    	require $dir;
    	$var=$var[$_GET['key_module']];
    	$res=array($var);
    	echo json_encode($res);
    }elseif(isset($_GET['apl'])){$continue=false;
    	function badge_module($key,$k,$v,$tipe='success'){
    		return $k.' : <span class="badge badge-'.$tipe.'" onclick="edit_module(\''.$key.'\',\''.$k.'\')">'.$v.'</span><br>';
    	}
    	$aplikasi=$_GET['apl'];
    	if(defined('D_'.$aplikasi)){
    		$mod=module_list($aplikasi);
    		$res=array();
    		$posisi=array('Before auth','After auth','Without auth');
    		$status=array('Hidden','Active');
    		foreach ($mod as $key => $value) {
    			$hdr=header_variable_list($value.'header.php');
    			$r='';
    			foreach($hdr as $k => $v){
    				if($k=='menu_icon')
    					$r.=badge_module($key,$k,'<i class="'.$v.' fa-2x"></i> ('.$v.')','warning');
    				elseif($k=='status')
    					$r.=badge_module($key,$k,$status[$v],'danger');
    				elseif($k=='position')
    					$r.=badge_module($key,$k,$posisi[$v],'primary');
    				else
    					$r.=badge_module($key,$k,$v,'success');
    			}
    			//$bundle=explode('/',str_replace(constant('D_'.$aplikasi),'',$value));$bundle=$bundle[count($bundle)-3];
    			$tmp=explode($aplikasi.'/',$value);
    			array_push($res,array($key,$r,implode('/',explode('/',end($tmp)))));
    		}
    		echo json_encode($res);
    	}else echo '[]';
    }elseif(isset($_GET['resetmenu'])){$continue=false;
    	reset_menu();
    	echo 'ok';
    }
}
?>