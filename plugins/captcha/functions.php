<?php
function create_captcha(){
    // Set the content-type
    header('Content-Type: image/png');
    
    // Create the image
    $im = imagecreatetruecolor(140, 40);
    
    // Create some colors
    $white = imagecolorallocate($im, 255, 255, 255);
    $grey = imagecolorallocate($im, 128, 128, 128);
    $g1 = imagecolorallocate($im, 100, 100, 100);
    $black = imagecolorallocate($im, 0, 0, 0);
    imagefilledrectangle($im, 0, 0, 140, 40, $white);
    
    for($i=0;$i<10;$i++)
        imageline($im,rand(0,140),0,rand(0,140),40,imagecolorallocate($im, rand(0,100), rand(0,100), rand(0,100)));
    // The text to draw
    $text = 'Testing...';
    // Replace path by your own font path
    $font = D_PLUGIN_PATH.'captcha/CatScratch-Thin-Rev-Italic.ttf';
    $font = D_PLUGIN_PATH.'captcha/Cactus Plain.ttf';
    $font = D_PLUGIN_PATH.'captcha/Cactus Love.ttf';
    
    $a=range('A','Z');
    $m=array(-1,1);
    $e='';
    for($i=0;$i<6;$i++){
        $r=$a[rand(0,count($a)-1)];
        $e.=$r;
        $s=$m[rand(0,1)]*rand(0,30);
        imagettftext($im, 20, $s, 11+$i*20, 31, $grey, $font, $r);
        imagettftext($im, 20, $s, 10+$i*20, 30, imagecolorallocate($im, rand(0,128), rand(0,128), rand(0,128)), $font, $r);
    }
    $_SESSION['captcha']=$e;
    
    // Using imagepng() results in clearer text compared with imagejpeg()
    imagepng($im);
    imagedestroy($im);
}
function is_captcha($code){
    if($_SESSION['captcha']==$code){
        unset($_SESSION['captcha']);
        return true;
    }else return false;
}
function captcha(){?>
<img src="/plugin/<?=D_PAGE?>/captcha?captcha=1" onclick="reload_captcha()" id="captcha">
<script>
    function reload_captcha(){
        var d=new Date();
        d=d.getTime();
        document.getElementById("captcha").src ="/plugin/<?=D_PAGE?>/captcha?captcha="+d;
    }
</script>
<?php }
?>