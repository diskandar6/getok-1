<?php if(!defined('D_KEY_PIPE'))exit;

function is_login_users__($id,$pos,$peg){
	$db=db_connection('');
        $id_=(int)$id[1];
        $data=$db->get_row("SELECT * FROM web_users WHERE status=1 AND id=$id_");
        foreach($data as $k1 =>$v1)$_SESSION[$k1]=$v1;
        $_SESSION['menu_admin']=$data->level;
        $_SESSION['position']=1;
        /*position=0 jika sebelum login, 
          position=1 jika sesudah login, 
          position=2 jika sebelum atau sesudah login
        */
        $_SESSION['FullName']=$data->nama;
        $_SESSION['foto']='/assets/img/Deafult-Profile-sx.png';
        if($_SESSION['image']!='')$_SESSION['foto']=$_SESSION['image'];
        set_cookies_login(array('id'=>$id_,'position'=>1,'pegawai'=>1));//*/
}
?>
