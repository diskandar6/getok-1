<?php
function carousel_active(){
    $fn=D_HTML.D_DOMAIN.'/'.D_PAGE.'/carousel/metadata.php';
    if(file_exists($fn)){
        $meta=file_get_contents($fn);
        $meta=json_decode($meta,true);
        $n=0;$sa=array();
        foreach($meta as $k => $v)if($v['status']){
            $sa[$k]=$v['order'];
            $n++;
        }
        asort($sa);
        return array_keys($sa);
    }
}
function carousel_(){
    $sa=carousel_active();
    $first=' active';
    $fn=D_HTML.D_DOMAIN.'/'.D_PAGE.'/carousel/metadata.php';
    if(file_exists($fn)){
        $meta=file_get_contents($fn);
        $meta=json_decode($meta,true);
        foreach($sa as $k => $v){
            $section=D_HTML.D_DOMAIN.'/'.D_PAGE.'/carousel/'.$meta[$v]['nama'];
            if(file_exists($section)){
                echo '      <div class="carousel-item'.$first.'">';
                require $section;
                echo '      </div>';
                $first='';
            }
        }
    }
}
function carousel_count_(){
    return count(carousel_active());
}
function menus_web(){
    $fn=D_HTML.D_DOMAIN.'/menus.php';
    $data=array();
    if(file_exists($fn)){
        $s=file_get_contents($fn);
        if($s!='')
            $data=json_decode($s,true);
    }
    return $data;
}
function links_web(){
    $fn=D_HTML.D_DOMAIN.'/links.php';
    $data=array();
    if(file_exists($fn)){
        $s=file_get_contents($fn);
        if($s!='')
            $data=json_decode($s,true);
    }
    return $data;
}
function footer_(){
    $meta=json_decode(file_get_contents(D_HTML.D_DOMAIN.'/'.D_PAGE.'/metadata.php'),true);
    $footer=false;
    foreach($meta as $k=> $v)if($v['status']){
        if($v['nama']=='footer.php')
            $footer=true;
    }
    if($footer){
        $fn=D_HTML.D_DOMAIN.'/'.D_PAGE.'/footer.php';
        if(file_exists($fn))require $fn;
    }
}
function header_(){
    $meta=json_decode(file_get_contents(D_HTML.D_DOMAIN.'/'.D_PAGE.'/metadata.php'),true);
    $menu=false;
    $intro=false;
    foreach($meta as $k=> $v)if($v['status']){
        if($v['nama']=='menus.php')
            $menu=true;
        if($v['nama']=='intro.php')
            $intro=true;
    }
    echo'  <header>';
    if($menu){
        $fn=D_HTML.D_DOMAIN.'/'.D_PAGE.'/menus.php';
        if(file_exists($fn))require $fn;
    }
    if($intro){
        $fn=D_HTML.D_DOMAIN.'/'.D_PAGE.'/intro.php';
        if(file_exists($fn))require $fn;
    }
    echo'  </header>';
}
function section_($title=''){
    $first='mt-5 ';
    $meta=json_decode(file_get_contents(D_HTML.D_DOMAIN.'/'.D_PAGE.'/metadata.php'),true);
    $n=0;$sa=array();
    foreach($meta as $k => $v)if($v['status']){
        $sa[$k]=$v['order'];
        $n++;
    }
    asort($sa);
    $sa=array_keys($sa);
    $title=str_replace(' ','-',implode(' ',str_word_count(str_replace("'",' ',$title),1,'0123456789')));
    foreach($sa as $k => $v)if(
        $meta[$v]['nama']!='footer.php'&&
        $meta[$v]['nama']!='menus.php'&&
        $meta[$v]['nama']!='intro.php'&&
        ($title==''||$title.'.php'==$meta[$v]['nama'])){
        $section=D_HTML.D_DOMAIN.'/'.D_PAGE.'/'.$meta[$v]['nama'];
        if(file_exists($section)){
            echo '      <section class="'.$first.'wow fadeIn">';
            require $section;
            echo '      </section>';
            if($k<$n)echo '<hr class="my-5">';
            $first='';
        }
    }
}
function horiz_scroll(){?>
<style>
    .rotate-scroll{
        position:absolute;
        overflow-y:scroll;
        overflow-x:hidden;
        transform: rotate(270deg) translateX(-100%);
        transform-origin: top left;
        scrollbar-width: none;
        -ms-overflow-style: none;
        ::-webkit-scrollbar {
            width: 0;
        }
    }
    .content-scroll{
        display:inline-block;
        position:relative;
    }
</style>
<script>
    function init_scroll_(width,height,left,top){
        $('.main-scroll').each(function(index){
            $(this).css({'height':height+'px','position':'relative'});
            $(this).children('.rotate-scroll').css({'height':width+'px','width':height+'px','top':top+'px','left':left+'px'});
            $(this).children('.rotate-scroll').each(function(){
                $(this).children('.sub-rotate-scroll').css({'transform': 'rotate(90deg) translateY(-'+height+'px)','transform-origin': 'top left'});
                $(this).children('.sub-rotate-scroll').each(function(){
                    $(this).children('.content-scroll').each(function(i){
                        $(this).css({'width':width+'px','height':height+'px','left':(width*i)+'px','top':(-height*i)+'px'});
                    });
                });
            });
        });
    }
</script>
<?php
}

function horiz_scroll_($begin=true){
if($begin){
?>
<div class="main-scroll">
    <div class="rotate-scroll">
        <div class="sub-rotate-scroll">
<?php }else{?>
        </div>
    </div>
</div>
<?php }
}
?>