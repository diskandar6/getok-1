<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php if(!defined('D_PROFILE'))require __DIR__.'/functions.php';
if(isset($_GET['upload'])){
    $dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
    //$dir.='profile/';if(!file_exists($dir))mkdir($dir,0755);
    //$dir.=(int)$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);

    if(isset($_SESSION['mahasiswa']))$dir.='data_mahasiswa/';else $dir.='data_pegawai/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.=(int)$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
    $dir.='profile/';if(!file_exists($dir))mkdir($dir,0755);

    $_SESSION['uploads']=$dir;
    if(isset($_SESSION['id']))$_SESSION['filename-uploaded']='foto-'.$_SESSION['id'];
}elseif(isset($_GET['image'])){
    $fn=explode('.',$_SESSION['filename']);
    $ext=end($fn);
    array_pop($fn);
    $fn=implode('.',$fn);
    $img='/int/'.D_PAGE.'/database/data_pegawai/';
    $tb="web_users";
    $img.=(int)$_SESSION['id'].'/profile/'.$ext.'/'.$fn;
    $_SESSION['image']=$img;
    $dbprofile->update($tb,array('image'=>$img),array('id'=>(int)$_SESSION['id']),array('%s'),array('%d'));
    echo $img.'?a='.date('YmdHis');
}
?>