
  <!-- SCRIPTS -->
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="/assets/pro/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="/assets/pro/js/bootstrap.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="/assets/pro/js/mdb.min.js"></script>
  <!-- MDB core JavaScript -->
  <!--script type="text/javascript" src="/assets/js/compiled.1023.min.js"></script-->
<?php
  require __DIR__.'/additional_footer.php';
  if(D_PAGE!=='develop'){
?>
  <script type="text/javascript">
  	$(document).ready(function () {
  		$('.mdb-select').materialSelect();
  	});
  </script><?php }?>
