<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
function get_table_list($db){
	$data=$db->get_results("SHOW TABLES",ARRAY_N);
	$tables=array();
	foreach($data as $k1 => $v1)
		array_push($tables,$v1[0]);
	return $tables;
}
function table_to_json($db,$dbname,$table,$full=false){
    $field=$db->get_results("SHOW COLUMNS FROM $table");
    $res=array();
    $res[$table]=array();
    $res[$table]['field']=array();
    foreach($field as $k => $v)
        array_push($res[$table]['field'],$v->Field);
    if($full){
        $data=$db->get_results("SELECT * FROM $table",ARRAY_N);
        $res[$table]['data']=$data;
    }
    return $res;
}
function table_to_sql($dbl,$dbname,$table){
	$str=$dbl->get_row("SHOW CREATE TABLE ".$table,ARRAY_N);
	$sql = $str[1].";\n\n";
	$cnt=$dbl->get_results("SELECT * FROM $table",ARRAY_N);
	foreach ($cnt as $k2 => $v2) {
		$sql .= "INSERT INTO ".$table." VALUES(";
		$n=count($v2);
		foreach ($v2 as $k3 => $v3) {
			$sql .= '"'.str_replace("\n","\\n",addslashes($v3)).'"' ;
			if($k3<$n-1)
				$sql.=',';
		}
		$sql.= ");\n";
	}
	$sql.="\n\n\n";
	return $sql;
}
function database_to_sql($dbl,$dbname){
	$data=$dbl->get_results("SHOW TABLES",ARRAY_N);
	$tables=array();
	foreach($data as $k1 => $v1)
		array_push($tables,$v1[0]);
		
	$sql = "CREATE DATABASE IF NOT EXISTS ".$dbname.";\n\n";
	$sql .= "USE ".$v.";\n\n";
	foreach ($tables as $k1 => $v1) {
		$sql .= "DROP TABLE IF EXISTS ".$v1.";\n\n";
		$sql .= table_to_sql($dbl,$dbname,$v1);
	}
	return $sql;
}
function db_connection($dbname=''){
    if($dbname=='')$dbname=D_DBDATA;
    $db=new wpdb(D_DBUSER, D_DBPASSWORD, $dbname, D_DBHOST);
    return $db;
}
function admin_list(){
    $db=db_connection();
    $data=$db->get_results("SELECT * FROM administrator ORDER BY id ASC");
    return $data;
}
function whois($id){
    $db=db_connection();
    $data=$db->get_row("SELECT * FROM administrator WHERE id=$id");
    return $data;
}
function create_database($path,$variable,$dbname){
	$k=db_connection();
	$res=$k->query("CREATE DATABASE $dbname");
	if($res)
		add_database($path,$variable,$dbname);
}
function is_login_administrator__($id){
	//$fn=dirname(__DIR__).'/modules/core/db.php';
	//require $fn; foreach ($var as $key => $value)$dbn=$value;
	$dbn=D_DBDATA;
	$db=db_connection($dbn);
	$data=$db->get_row("SELECT COUNT(*) AS jml,application FROM administrator WHERE status=1 AND id=$id");
	if((int)$data->jml>0){
		$_SESSION['id']=-$id;
		$_SESSION['position']=1;
		$_SESSION['FullName']='Developer';
		$_SESSION['foto']='/assets/img/Deafult-Profile.png';//logo1.png';//
		$_SESSION['menu_admin']='["*"]';
		$_SESSION['applikasi']=$data->application;
		set_cookies_login(array('id'=>'a'.$id,'position'=>1,'FullName'=>'Developer'));
	}
}
function is_login_administrator_($u,$p,$redirect=false){
	$db=db_connection();
	$data=$db->get_results("SELECT * FROM administrator WHERE status=1 ORDER BY id ASC");
    foreach($data as $k => $v)if(strtolower($u)==strtolower($v->username)&&md5($p)==$v->password){
		$_SESSION['id']=-(int)$v->id;
		$_SESSION['position']=1;
		$_SESSION['FullName']='Administrator';
		$_SESSION['foto']='/assets/img/Deafult-Profile.png';//logo1.png';//
		$_SESSION['menu_admin']='["*"]';
		$_SESSION['applikasi']=$v->application;
		$_SESSION['username']=$v->username;
		if(isset($_SESSION['ref_login'])){
			$loc=$_SESSION['ref_login'];
			unset($_SESSION['ref_login']);
		}else
			//$loc='develop';
			$loc='profile';

        set_cookies_login(array('id'=>'a'.(int)$v->id,'position'=>$_SESSION['position'],'FullName'=>$_SESSION['FullName']));

		if(!$redirect)
            echo json_encode(array('res'=>'ok','location'=>$loc));
        else{
            if(count(explode('login',$loc))>1)
            //header("location: /develop");else
            header("location: /profile");else
            header("location: $loc");
        }
		return true;
	}
	return false;
}
function database_list($path){
	if(file_exists($path))
		require $path;
	if(isset($var))
		$res=$var;
	else
		$res=array();
	return $res;
}
function add_database($path,$variable,$nama){
	$array=database_list($path);
	$array[$variable]=$nama;
	$res ='<?php ';
	$res.='$var=array(';
	foreach($array as $k => $v)
		if($k!=''&&$v!='')
			$res.="'".$k."'=>'".$v."',";
	$res.=');?>';
	file_put_contents($path,$res);
}
function remove_database($path,$variable){
	$array=database_list($path);
	unset($array[$variable]);
	$res ='<?php ';
	$res.='$var=array(';
	foreach($array as $k => $v)
		if($k!=''&&$v!='')
			$res.="'".$k."'=>'".$v."',";
	$res.=');?>';
	file_put_contents($path,$res);
}
function login($success=false){
	if($success)
		$_SESSION['position']=1;
	else
		$_SESSION['position']=0;
}
function create_database_example(){
	return "CREATE DATABASE dbname";
}
function create_table_example(){
	$q="CREATE TABLE table (
    ID int NOT NULL,
    LastName varchar(255) NOT NULL,
    FirstName varchar(255),
    Age int,
    PRIMARY KEY (ID)
); ";
	return $q;
}
function add_column_example(){
	return "ALTER TABLE Customers
ADD Email varchar(255);";
}
function drop_column_example(){
	return "ALTER TABLE Customers
DROP COLUMN Email;";
}
function modify_column_example(){
	return "ALTER TABLE table_name
MODIFY COLUMN column_name datatype; ";
}

function dbfindi($db,$tb,$fl){
    $fn='';$i=0;
    foreach($fl as $k => $v){
        if($i>0)$fn.=' AND ';
        $fn.=$k."=".$v;
    }
    $d=$db->get_row("SELECT * FROM $tb WHERE $fn");
    return $d;
}
function dbfinds($db,$tb,$fl){
    $fn='';$i=0;
    foreach($fl as $k => $v){
        if($i>0)$fn.=' AND ';
        $fn.=$k."='".$v."'";
    }
    $d=$db->get_row("SELECT * FROM $tb WHERE $fn");
    return $d;
}
?>
