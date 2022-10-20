<?php
if(!isset($_SESSION['id']))goto a;
//	AUTO BACKUP
$backupscript=dirname(D_BACKUP).'/backups/';
$now=strtotime('now');
if((int)$_SESSION['id']<0){
    $time=strtotime('-1 days',$now);
    $ada=false;
    while($time<$now){
    	$ada=$ada||file_exists($backupscript.'script-'.date('Y-m-d').'.zip');
    	$time=strtotime('+1 days',$time);
    }
    if(!$ada)
    	zip_whole_folder($backupscript.'script-'.date('Y-m-d').'.zip',array(D_MODULE_PATH,D_CORE_PATH,D_PLUGIN_PATH));
}

$fn=$backupscript.'db-'.date('Y-m-d',$now).'.zip';
$dbname=array('kepegawaian');
if(!file_exists($fn)){
	$file=array();$isi=array();
	foreach($dbname as $k => $v){
		$data=$$v->get_results("SHOW TABLES",ARRAY_N);
		$tables=array();
		foreach($data as $k1 => $v1)
			array_push($tables,$v1[0]);
		
		$sql = "CREATE DATABASE IF NOT EXISTS ".$v.";\n\n";
		$sql .= "USE ".$v.";\n\n";
		foreach ($tables as $k1 => $v1) {
			$sql .= "DROP TABLE IF EXISTS ".$v1.";\n\n";
			$str=$$v->get_row("SHOW CREATE TABLE ".$v1,ARRAY_N);
			$sql .= $str[1].";\n\n";
			$cnt=$$v->get_results("SELECT * FROM $v1",ARRAY_N);
			foreach ($cnt as $k2 => $v2) {
				$sql .= "INSERT INTO ".$v1." VALUES(";
				$n=count($v2);
				foreach ($v2 as $k3 => $v3) {
					$sql .= '"'.str_replace("\n","\\n",addslashes($v3)).'"' ;
					if($k3<$n-1)
						$sql.=',';
				}
				$sql.= ");\n";
			}
			$sql.="\n\n\n";
		}
		array_push($file,$v.'.sql');
		array_push($isi,$sql);
	}
	if(count($file)>0)
		saveto_zip($fn,$file,$isi);
}
unset($dbname);
a:
/*
ok
Notice: Undefined variable: kepegawaian in /opt/lampp/htdocs/datacenter/core/autobackup.php on line 21

Fatal error: Call to a member function get_results() on null in /opt/lampp/htdocs/datacenter/core/autobackup.php on line 21
*/
?>