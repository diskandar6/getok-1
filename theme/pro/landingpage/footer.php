<?php
$links=links_web();
$n=floor(count($links)/3);
//print_r($link[0][1]);
?>
    <!-- Footer Links -->
    <div class="container">
      <div class="row">

        <!-- First column -->
        <div class="col-md-5">
            <div class="row">
                <div class="col-4">
            <img class="w-100" src="/assets/img/logo2.png">
            </div>
          <div class="col-8">
              <h5 class="text-uppercase font-weight-bold">STIKES 'AISYIYAH BANDUNG</h5>
            <p class="">Jalan KH. Ahmad Dahlan No. 6 Bandung</p>
          </div>
          </div>
        </div>
        <!-- /.First column -->

        <hr class="w-100 clearfix d-md-none">

        <div class="col-md-7">
            <div class="row">
<?php foreach($links as $k => $link){?>
                <!-- Second column -->
                <div class="col-md-3 ml-auto">
                  <h5 class="text-uppercase font-weight-bold"><?=$link[0]?></h5>
                  <ul class="list-unstyled">
<?php for($i=0;$i<count($link[1]);$i++){?>
                    <li><a href="<?=$link[1][$i][1]?>"><?=$link[1][$i][0]?></a></li>
<?php }?>
                  </ul>
                </div>
                <!-- /.Second column -->
                <hr class="w-100 clearfix d-md-none">
<?php }?>
            </div>
        </div>
      </div>
    </div>

    <hr>

    <div class="container">
      <!-- Grid row -->
      <div class="row mb-3">

        <!-- First column -->
        <div class="col-md-12">

          <ul class="list-unstyled d-flex justify-content-center mb-0 py-4 list-inline">
            <li class="list-inline-item"><a class="p-2 m-2 fa-lg fb-ic"><i class="fab fa-facebook-f white-text fa-lg">
                </i></a></li>
            <li class="list-inline-item"><a class="p-2 m-2 fa-lg tw-ic"><i class="fab fa-twitter white-text fa-lg"> </i></a></li>
            <li class="list-inline-item"><a class="p-2 m-2 fa-lg gplus-ic"><i class="fab fa-google-plus-g white-text fa-lg">
                </i></a></li>
            <li class="list-inline-item"><a class="p-2 m-2 fa-lg li-ic"><i class="fab fa-linkedin-in white-text fa-lg">
                </i></a></li>
            <li class="list-inline-item"><a class="p-2 m-2 fa-lg ins-ic"><i class="fab fa-instagram white-text fa-lg">
                </i></a></li>
            <li class="list-inline-item"><a class="p-2 m-2 fa-lg pin-ic"><i class="fab fa-pinterest white-text fa-lg">
                </i></a></li>
          </ul>

        </div>
        <!-- /First column -->
      </div>
      <!-- /Grid row -->
    </div>
    <!-- /.Footer Links -->

