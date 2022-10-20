<?php
if(isset($_POST['newdatabase'])){$continue=false;
	if(defined('D_'.$_POST['newdatabase'])){
		$path=constant('D_'.$_POST['newdatabase']).'db.php';
		$variable=$_POST['variable'];
		$nama=$_POST['nama'];
    	if((int)$_POST['act']==2)
			add_database($path,$variable,$nama);
    	else
    		create_database($path,$variable,$nama);
		echo 'ok';
	}else echo 'no';
}elseif(isset($_POST['query'])){$continue=false;
	$dbl=db_connection($_POST['db']);
    if(strpos(strtoupper($_POST['query']),'SHOW DATABASES')===false||$_SESSION['id']==-1){
    	$q=split_query($_POST['query']);
    	for($i=0;$i<count($q);$i++)if($q[$i]!='')
    	$data=$dbl->get_results($q[$i],ARRAY_A);
    	$r='';
    	if(isset($data[0])){
        	$head=array_keys($data[0]);
        	$r='<table class="table"><thead><tr><th>'.implode('</th><th>',$head).'</th></tr></thead><tbody>';
        	foreach($data as $k => $v){
        		$r.='<tr><td>';
        		$r.=implode('</td><td>',array_values($v));
        		$r.='</td></tr>';
        	}
        	$r.='</tbody></table>';
    	}
    	echo $r;
    }else echo '';
}
?>