  <!-- Footer -->
  <footer class="page-footer pt-0 mt-5">

    <!-- Copyright -->
    <div class="footer-copyright py-3 text-center">
      <div class="container-fluid">
        © 2020 Copyright: <a href="http://<?=$_SERVER['HTTP_HOST']?>" target="_blank"> <?=$_SERVER['HTTP_HOST']?> </a>

      </div>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->

  <!-- SCRIPTS -->
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="/assets/pro/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="/assets/pro/js/bootstrap.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="/assets/pro/js/mdb.min.js"></script>
<?php
  require __DIR__.'/additional_footer.php';
  if(D_PAGE!=='develop'){
?>
  <script type="text/javascript">
  	$(document).ready(function () {
  		$('.mdb-select').materialSelect();
  	});
  </script><?php }?>

  <!-- datatables -->
  <script type="text/javascript" src="/assets/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="/assets/js/dataTables.bootstrap4.min.js"></script>
