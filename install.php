<?php if(!isset($_POST['dbn'])){?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Admin | Getok</title>
  <link rel="shortcut icon" href="/assets/logo/36.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/pro/css/all.css">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="/assets/pro/css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="/assets/pro/css/mdb.min.css">
  <!-- Material Design Bootstrap -->
  <!--link rel="stylesheet" href="/assets/css/compiled-4.19.1.min.css"-->
  <!-- JQuery -->
  <script src="/assets/pro/js/jquery-3.4.1.min.js"></script>
  <script>
    var DT='/data/develop';
    var PT='/develop';
  </script>
  <link rel="stylesheet" type="text/css" href="/assets/css/dataTables.bootstrap4.min.css"/>
</head>
<body class="fixed-sn white-skin">
  <div class="container my-5">
    <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text">
      <div class="row d-flex justify-content-center z-depth-1 white">
        <div class="col-md-6 col-lg-10 my-5">
          <form class="" action="/" method="post">
            <p class="h4 mb-4 text-center"><img src="/assets/logo/96.png" class="img-fluid"></p>
            <p class=" text-center">Below you should enter your database connection details.</br>If you're not sure about these, contact your host</p>
            <?php if(isset($_GET['e']))echo '<p class="red-text text-center h2">Error</p>';?>
            <hr>
            <div class="row">
            	<div class="col-6">
				  <div class="form-group">
				    <label for="hst">Database Host</label>
				    <input type="text" class="form-control" name="hst" placeholder="" value="localhost" required="">
				  </div>
            	</div>
            	<div class="col-6">
				  <div class="form-group">
				    <label for="dbn">Database Name</label>
				    <input type="text" class="form-control" name="dbn" placeholder="" value="getok1" required="">
				  </div>
            	</div>
            	<div class="col-6">
				  <div class="form-group">
				    <label for="un">Username</label>
				    <input type="text" class="form-control" name="un" placeholder="" value="root" required="">
				  </div>
            	</div>
            	<div class="col-6">
				  <div class="form-group">
				    <label for="pw">Password</label>
				    <input type="text" class="form-control" name="pw" placeholder="">
				  </div>
            	</div>
            </div>
            <button class="btn btn-info" type="submit">Submit</button>
          </form>
        </div>
      </div>
    </section>
  </div>
</body>
<?php }else{
	if(!isset($_POST['dbn'])||!isset($_POST['hst'])||!isset($_POST['un'])){header("location: /?e=1");exit;}
	if($_POST['dbn']==''||$_POST['hst']==''||$_POST['un']==''){header("location: /?e=1");exit;}

	require D_MAIN_PATH.'core/wp-db.php';

	$fn=D_MAIN_PATH.'core/config.php';
	$data=file_get_contents($fn);
	$data=explode(chr(10),$data);
	foreach ($data as $key => $value) {
		if(strpos($value, "define('D_DBHOST',")!==false)$data[$key]="define('D_DBHOST','".$_POST['hst']."');";
		if(strpos($value, "define('D_DBUSER',")!==false)$data[$key]="define('D_DBUSER','".$_POST['un']."');";
		if(strpos($value, "define('D_DBPASSWORD',")!==false)$data[$key]="define('D_DBPASSWORD','".$_POST['pw']."');";
		if(strpos($value, "define('D_DBDATA',")!==false)$data[$key]="define('D_DBDATA','".$_POST['dbn']."');";
	}
	$data=implode(chr(10),$data);
	file_put_contents($fn,$data);

	$db=new wpdb($_POST['un'], $_POST['pw'], $_POST['dbn'], $_POST['hst']);

	$fn=D_MAIN_PATH.'core/registry.php';
	$data="<?php".chr(10);
	$dm=$_SERVER['HTTP_HOST'];
	$data.=chr(9)."define('D_".$dm."',D_MODULE_PATH.'".$dm."/');".chr(10);
	$data.="?>";
	file_put_contents($fn,$data);

	$fn=D_MAIN_PATH.'modules/';

	if(file_exists($fn.'tmp'))
	rename($fn.'tmp',$fn.$dm);
	
	$fn1=$fn.'core/';
	$data='<?php $var=array(\'uab\'=>\''.$_POST['dbn'].'\',);?>';
	file_put_contents($fn1.'db.php',$data);

	$fn.=$dm.'/';
	$data='<?php $var=array(\'uab\'=>\''.$_POST['dbn'].'\',\'dbg\'=>\''.$_POST['dbn'].'\',);?>';
	file_put_contents($fn.'db.php',$data);

	$data=file_get_contents($fn.'registry.php');
	$data=str_replace("D_MODULE_PATH.'tmp/", "D_MODULE_PATH.'".$dm."/", $data);
	file_put_contents($fn.'registry.php',$data);

	$fn=D_MAIN_PATH.'database/master/';
//*
	$data=file_get_contents($fn.'database.sql');
	$data=explode(';',$data);
	foreach($data as $k => $v)
		if($v!='')$db->query($v);//*/
	$db->insert("administrator",array('username'=>'admin','password'=>md5('admin'),'application'=>$dm,'status'=>1),array('%s','%s','%s','%d'));
	$db->insert("web_users",array('username'=>'admin','password'=>md5('admin'),'application'=>$dm,'status'=>1),array('%s','%s','%s','%d'));

	rename(D_MAIN_PATH.'install.php', D_MAIN_PATH.'install-tmp.php');
	header("location: /");
}
?>