  <style type="text/css">
    header,
    .view {
      height: 100%;
    }

    @media (max-width: 740px) {
      header,
      .view {
        height: 1050px;
      }
    }

    @media (min-width: 800px) and (max-width: 850px) {
      header,
      .view {
        height: 700px;
      }
    }
</style>
<?php /*?>
  <!--Carousel Wrapper-->
  <div id="carousel-example-1z" class="carousel slide carousel-fade h-100" data-ride="carousel">

    <!--Indicators-->
    <ol class="carousel-indicators">
<?php for($i=0;$i<carousel_count_();$i++){?>
      <li data-target="#carousel-example-1z" data-slide-to="<?=$i?>"<?php if($i==0)echo' class="active"';?>></li>
<?php }?>
    </ol>
    <!--/.Indicators-->

    <!--Slides-->
    <div class="carousel-inner" role="listbox">
        <?=carousel_()?>
    </div>
    <!--/.Slides-->
    <!--Controls-->
    <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    <!--/.Controls-->
  </div>
  <!--/.Carousel Wrapper-->
<?php //*/?>
    <!-- Full Page Intro -->
    <div class="view full-page-intro">

      <!--Video source-->
      <video class="video-intro" autoplay loop muted>
        <source src="/assets/img/animation-intro.mp4" type="video/mp4" />
      </video>

      <!-- Mask & flexbox options-->
      <div class="mask rgba-blue-light d-flex justify-content-center align-items-center">

        <!-- Content -->
        <div class="container">

          <!--Grid row-->
          <div class="row d-flex h-100 justify-content-center align-items-center wow fadeIn">

            <!--Grid column-->
            <div class="col-md-6 mb-4 white-text text-center text-md-left">

              <h1 class="display-4 font-weight-bold">Learn Bootstrap 4 with MDB</h1>

              <hr class="hr-light">

              <p>
                <strong>Best & free guide of responsive web design</strong>
              </p>

              <p class="mb-4 d-none d-md-block">
                <strong>The most comprehensive tutorial for the Bootstrap 4. Loved by over 500 000 users. Video and
                  written versions
                  available. Create your own, stunning website.</strong>
              </p>

              <a target="_blank" href="https://mdbootstrap.com/education/bootstrap/" class="btn btn-outline-white">Start
                free tutorial
                <i class="fas fa-graduation-cap ml-2"></i>
              </a>
              <a target="_blank" href="https://mdbootstrap.com/docs/jquery/getting-started/download/" class="btn btn-outline-white">Download
                MDB
                <i class="fas fa-download ml-2"></i>
              </a>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-6 col-xl-5 mb-4">

              <img src="/assets/img/admin-new.png" alt="" class="img-fluid">

            </div>
            <!--Grid column-->

          </div>
          <!--Grid row-->

        </div>
        <!-- Content -->

      </div>
      <!-- Mask & flexbox options-->

    </div>
    <!-- Full Page Intro -->
