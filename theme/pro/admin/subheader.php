  <link rel="stylesheet" type="text/css" href="/assets/css/dataTables.bootstrap4.min.css"/>
  <?=meta_google_signin()?>
</head>
<body class="fixed-sn <?=$hdr['skin']?>">
  <!-- Main Navigation -->
  <header>

    <!-- Sidebar navigation -->
    <div id="slide-out" class="side-nav sn-bg-4 fixed">
      <ul class="custom-scrollbar">

        <!-- Logo -->
        <li class="logo-sn waves-effect py-3">
          <div class="text-center">
            <a href="/" class="pl-0"><img src="<?=D_MAIN_LOGO?>" style="height:100%"></a>
          </div>
        </li>

        <!-- Search Form -->
        <li>
          <form class="search-form" role="search">
            <div class="md-form mt-0 waves-light">
              <input type="text" class="form-control py-2" placeholder="Search" onkeyup="cari_menu(this.value)">
            </div>
          </form>
        </li>

        <!-- Side navigation links -->
        <li>
          <ul class="collapsible collapsible-accordion" id="menucari" style="display: none">
          </ul>
          <ul class="collapsible collapsible-accordion" id="menumeni">
<?php
if(isset($_SESSION['menu_admin']))
    $menuadmin=json_decode($_SESSION['menu_admin']);
else
    $menuadmin=array('*');
$fn=constant('D_'.D_DOMAIN).'menu2.php';
if(file_exists($fn))
  require $fn;
$cari=array();$key=array();$actv=-1;$actv1=-1;
foreach($menu2 as $k => $v){if(isset($v['name'])){if($v['name']=='dashboard')$dsb=$v;}
    if(isset($v['parent_menu'])){
        $ada=false;
        if(isset($_SESSION['menu_admin'])){//&&$_SESSION['id']>=0){
            foreach($v['group'] as $k1 => $v1)
                $ada=$ada||in_array($v1['name'],$menuadmin)||$menuadmin[0]=='*';
	    }
        if($ada){
?>
            <li>
              <a class="collapsible-header waves-effect arrow-r" id="menu<?=$k?>">
                <i class="w-fa <?=$v['parent_menu_icon']?>"></i> <?=$v['parent_menu']?><i class="fas fa-angle-down rotate-icon"></i>
              </a>
              <div class="collapsible-body" id="menu-<?=$k?>">
                <ul>
<?php
foreach($v['group'] as $k1 => $v1){
    if(!(!(in_array($v1['name'],$menuadmin)||$menuadmin[0]=='*'))){//&&$_SESSION['id']>=0)){
    array_push($cari,array($v1['name'],$v1['menu_icon'],$v1['menu_title']));
    array_push($key,$v1['menu_title']);
    if(D_PAGE===$v1['name']){$actv=$k;$actv1=$k1;}
?>
                  <li>
                    <a href="/<?=$v1['name']?>" class="waves-effect" id="menu-<?=$k?><?=$k1?>"><i class="<?=$v1['menu_icon']?>"></i> <?=$v1['menu_title']?></a>
                  </li>
<?php }}?>
                </ul>
              </div>
            </li>
<?php }}else{
    if(!(!(in_array($v['name'],$menuadmin)||$menuadmin[0]=='*')&&$_SESSION['id']>=0)){
    array_push($cari,array($v['name'],$v['menu_icon'],$v['menu_title']));
    array_push($key,$v['menu_title']);
?>
            <!-- Simple link -->
            <li>
              <a href="/<?=$v['name']?>" class="collapsible-header waves-effect"><i class="w-fa <?=$v['menu_icon']?>"></i> <?=$v['menu_title']?></a>
            </li>
<?php }}
}
$fn=D_MODULE_PATH.D_DOMAIN.'/bukupetunjuk/view.php';
if(file_exists($fn)){
?>
            <!-- Simple link -->
            <li>
              <a href="/bukupetunjuk" class="collapsible-header waves-effect"><i class="w-fa fas fa-book-open"></i> Buku Petunjuk</a>
            </li>
<?php }//*/?>
          </ul>
        </li>
        <!-- Side navigation links -->
      </ul>
      <div class="sidenav-bg mask-strong"></div>
    </div>
    <!-- Sidebar navigation -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#menu<?=$actv?>').addClass('active');
    $('#menu-<?=$actv?><?=$actv1?>').addClass('active');
    $('#menu-<?=$actv?>').show();
  })
  function cari_menu(v){
    if(v==''){
      $('#menucari').hide();
      $('#menumeni').show();
    }else{
      $('#menucari').show();
      $('#menumeni').hide();
      var a='';
      var data=<?=json_encode($cari)?>;
      var key=<?=json_encode($key)?>;
      var res=[];
      for(var i=0;i<key.length;i++){
        if(key[i].toLowerCase().search(v.toLowerCase())>=0)
          res.push(data[i]);
      }
      for(var i=0;i<res.length;i++)
        a+='<li><a href="/'+res[i][0]+'" class="collapsible-header waves-effect"><i class="w-fa fa '+res[i][1]+'"></i> '+res[i][2]+'</a></li>';
      $('#menucari').html(a);
    }
  }
/*$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})//*/
</script>

    <div class="fixed-top">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg scrolling-navbar double-nav">
      <!-- SideNav slide-out button -->
      <div class="float-left">
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
      </div>
      <!-- Breadcrumb -->
      <div class="breadcrumb-dn mr-auto">
        <p><a href="/"><?=D_TITLE_PAGE?></a></p>
      </div>
      <!-- Navbar links -->
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
<?php if($_SESSION['id']>=0){
    if($actv>=0){
foreach($menu2[$actv]['group'] as $k =>$v){?>
        <li class="nav-item">
          <!--a class="nav-link waves-effect" href="/ticket"><i class="fas fa-envelope"></i></a-->
          <a href="/<?=$v['name']?>" class="mr-1 mt-0 text-decoration-none border-bottom dark-text" data-toggle="tooltip" data-placement="bottom" title="<?=$v['menu_title']?>"><i class="<?=$v['menu_icon']?> p-1 fa-2x"></i></a>
        </li>
<?php }}?>
        <li class="nav-item">
          <!--a class="nav-link waves-effect" href="/ticket"><i class="fas fa-envelope"></i></a-->
          <a href="/<?=$dsb['name']?>" class="mr-1 mt-0 text-decoration-none border-bottom dark-text" data-toggle="tooltip" data-placement="bottom" title="Dashboard"><i class="<?=$dsb['menu_icon']?> p-1 fa-2x"></i></a>
        </li>
<?php }?>
        <li class="nav-item dropdown">
          <img src="<?php if((int)$_SESSION['id']>0){if(isset($_SESSION['image'])){if($_SESSION['image']!='') echo $_SESSION['image'];else echo $_SESSION['foto'];}else echo $_SESSION['foto'];echo '?w=1&h=1&p=1&nw=50&f=0&t=1'; }else echo '/assets/img/Deafult-Profile-sx.png';?>" alt="<?=$_SESSION['FullName']?>" class="avatar rounded-circle mr-0 ml-3 z-depth-1" style="height:38px;" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" id="foto_atas">
<?php /* ?>
          <!--a class="nav-link dropdown-toggle waves-effect" href="#" id="userDropdown" >
            <i class="fas fa-user"></i> <span class="clearfix d-none d-sm-inline-block">Profile</span>
          </a-->
<?php //*/?>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="/logout" onclick="signOut()">Log Out</a>
            <a class="dropdown-item" href="/profile">My account</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link waves-effect"><span class="clearfix d-none d-sm-inline-block"><?=$_SESSION['FullName']?></span></a>
        </li>
      </ul>
      <!-- Navbar links -->
    </nav>
    <!-- Navbar -->

    </div>

  </header>
  <!-- Main Navigation -->
<?php /*if($_SESSION['id']==0){?>
<!--Navbar-->
<br>
<nav class="navbar navbar-expand-lg white mt-5">

  <!-- Navbar brand -->
  <a class="navbar-brand" href="/<?=$dsb['name']?>"><a href="/<?=$dsb['name']?>" class="mr-1 mt-0 text-decoration-none border-bottom dark-text" data-toggle="tooltip" data-placement="bottom" title="Dashboard"><i class="<?=$dsb['menu_icon']?> p-1 fa-2x"></i></a></a>

  <!-- Collapse button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="basicExampleNav">

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>

    </ul>
    <!-- Links -->

  </div>
  <!-- Collapsible content -->

</nav>
<!--/.Navbar-->
<?php }*/?>