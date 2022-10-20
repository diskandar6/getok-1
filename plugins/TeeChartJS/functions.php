<?php
function init_teechart($media){
/*
CONTOH:
    $media=array(
        array(
            'id'=>'#canvas1',
            'draw'=>'draw1',
            'rasio'=>0.5
        ),
        array(
            'id'=>'#canvas2',
            'draw'=>'draw2',
            'rasio'=>0.5
        )
    );
    init_teechart($media);
*/
?>
<script type="text/javascript">
<?php foreach($media as $k =>$v){?>
    var lebar<?=$k?>=0;
    var Chart<?=$k?>;
<?php }?>
	$(document).ready(function () {
<?php foreach($media as $k =>$v){?>
	    lebar<?=$k?>=$('#<?=$v['id']?>').width();
	    <?=$v['draw']?>();
<?php }?>
	    resize();
	    $('body').attr("onresize","resize();");
	});

function resize() {
  var body = document.body;
<?php foreach($media as $k =>$v){?>
  var canvas<?=$k?> = Chart<?=$k?>.canvas;
  canvas<?=$k?>.width = $('#<?=$v['id']?>').parent().width();
  canvas<?=$k?>.height = canvas<?=$k?>.width*<?=$v['rasio']?>;// /lebar<?=$k?>*tinggi<?=$k?>;
  Chart<?=$k?>.bounds.width = canvas<?=$k?>.width;
  Chart<?=$k?>.bounds.height = canvas<?=$k?>.height;
  changeTheme(Chart<?=$k?>, "minimal");
  Chart<?=$k?>.draw();
<?php }?>
}

</script>

<?php }

function tee_resources(){?>
    <!--[if lt IE 9]>
        <script src="../../src/excanvas/excanvas_text.js"></script>
        <script src="../../src/excanvas/canvas.text.js"></script>
    <![endif]-->
    <script src="/plugins/TeeChartJS/src/teechart.js" type="text/javascript"></script>
    <script src="/plugins/TeeChartJS/src/teechart-extras.js" type="text/javascript"></script>
    <script src="/plugins/TeeChartJS/demos/demo.js"></script>
<?php }
?>