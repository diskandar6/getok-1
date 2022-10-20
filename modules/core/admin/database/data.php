<?php
    if(isset($_GET['exporttb'])){$continue=false;
        $fn=D_TMP_PATH; if(!file_exists($fn)) mkdir($fn,0755);
        $fn.=$_GET['db']; if(!file_exists($fn)) mkdir($fn,0755);
        $fn.='/tb-'.date('Y-m-d.H').'.zip';
        $dbl=db_connection($_GET['db']);
    	$sql=table_to_sql($dbl,$_GET['db'],$_GET['exporttb']);
    	saveto_zip($fn,array($_GET['exporttb'].'.sql'),array($sql));
    	force_download($fn,$_GET['exporttb'].'.sql.zip');
    }elseif(isset($_GET['exportdb'])){$continue=false;
        $fn=D_TMP_PATH; if(!file_exists($fn)) mkdir($fn,0755);
        $fn.=$_GET['exportdb']; if(!file_exists($fn)) mkdir($fn,0755);
        $fn.='/db-'.date('Y-m-d.H').'.zip';
        $dbl=db_connection($_GET['exportdb']);
    	$sql=database_to_sql($dbl,$_GET['exportdb']);
    	saveto_zip($fn,array($_GET['exportdb'].'.sql'),array($sql));
    	force_download($fn,$_GET['exportdb'].'.sql.zip');
    }elseif(isset($_GET['exportdbs'])){$continue=false;
        $dbs=database_list(constant('D_'.$_GET['exportdbs']).'db.php');
        $fn=D_TMP_PATH; if(!file_exists($fn)) mkdir($fn,0755);
        $fn.=$_GET['exportdbs']; if(!file_exists($fn)) mkdir($fn,0755);
        $fn.='/dbs-'.date('Y-m-d.H').'.zip';
    	$file=array();$isi=array();
    	foreach($dbs as $k => $v){
    		array_push($file,$v.'.sql');
    	    $dbl=db_connection($v);
    		$sql=database_to_sql($dbl);
    		array_push($isi,$sql);
    	}
    	if(count($file)>0)
    		saveto_zip($fn,$file,$isi);
    	force_download($fn,$_GET['exportdbs'].'.sql.zip');
    }elseif(isset($_GET['struct'])){$continue=false;
    	$dbl=db_connection($_GET['dbs']);
    	$data=$dbl->get_row("SHOW CREATE TABLE $_GET[struct]",ARRAY_N);
        $res=array();
        if(is_array($data[0])){
            $h=array_keys($data[0]);
            $res['thead']=$h;
            $res['tbody']=array();
            foreach($data as $k => $v)
                array_push($res['tbody'],array_values($v));
        }
    	print_r($data[1]);
    }elseif(isset($_GET['dbl'])){$continue=false;
    	$aplikasi=$_GET['dbl'];
    	if(defined('D_'.$aplikasi)){
    		$dbs=database_list(constant('D_'.$aplikasi).'db.php');
    		$res=array();
    		foreach ($dbs as $key => $value) {
    			$dbl=db_connection($value);
    			$tabel=$dbl->get_results("SHOW TABLES");
    			$tbl='';
    			$n=count($tabel);
    			foreach($tabel as $k1 => $v1){
    				$a='Tables_in_'.$value;
    				$a=$v1->$a;
    				$tbl.='<span class="badge badge-success" data-toggle="modal" data-target="#db_query" onclick="load_db_structure(\''.$value.'\',\''.$a.'\')">'.$a.'</span>';
    				$jml=$dbl->get_row("SELECT COUNT(*) AS jml FROM $a");
    				$tbl.=' '.$jml->jml;
        			if($k1<$n-1)$tbl.='<br>';
        		}
        
    			$example ='$'.$key."->insert('table',array(),array());<br>";
    			$example.='$'.$key."->update('table',array(),array(),array(),array());<br>";
    			$example.='$'.$key."->delete('table',array(),array());<br>";
    			$example.='$'.$key."->get_results('SELECT * FROM table WHERE id=0 LIMIT 0,10');<br>";
    			$example.='$'.$key."->get_row('SELECT * FROM table WHERE id=0');";
    			$download='<span class="badge badge-warning" onclick="dwnload(\''.$value.'\')"><i class="fa fa-download"></i></span> ';
    			$download.='<span class="badge badge-success" data-toggle="modal" data-target="#db_query" onclick="force_query(\''.$value.'\')"><i class="fa fa-terminal"></i></span>';
    			array_push($res,array($value,$key,$tbl,$example,$download));
    		}
    		echo json_encode($res);
    	}else echo '[]';
    }
?>