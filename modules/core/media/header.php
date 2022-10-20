<?php $var=array('theme'=>'pro','status'=>'1','position'=>'2','browser_title'=>'Admin','page_title'=>'Admin','skin'=>'white-skin','subtheme'=>'landingpage',);
$fn=constant('D_'.D_DOMAIN).'uncategory/media/'.basename(__FILE__);
if(file_exists($fn))
    require $fn;
?>