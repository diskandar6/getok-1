<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?=$hdr['browser_title'].' | '.D_TITLE_PAGE?></title>
  <link rel="shortcut icon" href="<?=D_FAVICON?>">
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
    var DT='/data/<?=D_PAGE?>';
    var PT='/<?=D_PAGE?>';
  </script>
<?php if(isset($hdr['resources']))
if(in_array('datatables',$hdr['resources'])){?>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<?php }?>
<?php if(isset($hdr['resources']))if(in_array('teechartjs',$hdr['resources'])){?>
    <!--[if lt IE 9]>
        <script src="../../src/excanvas/excanvas_text.js"></script>
        <script src="../../src/excanvas/canvas.text.js"></script>
    <![endif]-->
    <script src="/plugins/TeeChartJS/src/teechart.js" type="text/javascript"></script>
    <script src="/plugins/TeeChartJS/src/teechart-extras.js" type="text/javascript"></script>
    <script src="/plugins/TeeChartJS/demos/demo.js"></script>
<?php }?>
