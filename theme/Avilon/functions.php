<?php
function header_page($hdr){
	require __DIR__.'/main_header.php';
}
function footer_page($hdr){
	require __DIR__.'/main_footer.php';
}
function menus_avilon($title='Avilon',$menu=''){
    function draw_menu($menu,$id){
        $r='';
        foreach($menu as $k => $v)if($v['status']>0){
            if(is_array($v['link'])){
                $r.='<li class="menu-has-children">';
                $r.='<a href="#">'.$v['caption'].'</a>';
                $r.='<ul>';
                $r.=draw_menu($v['link'],$id.'-'.$k);
                $r.='</ul>';
                $r.='</li>';
            }else{
                $cp='null';
                if($v['caption']!='')$cp=$v['caption'];
                $r.='<li><a href="'.$v['link'].'">'.$cp.'</a></li>';
            }
        }
        return $r;
    }
?>
  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="index.html" class="scrollto"><?=$title?></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt=""></a> -->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
<?=draw_menu($menu,'0');?>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- End Header -->
<?php }
?>