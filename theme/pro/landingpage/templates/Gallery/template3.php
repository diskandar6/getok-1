<div class="container my-5">


  <!--Section: Content-->
  <section class="text-center dark-grey-text">
    
    <style>
      .carousel-multi-item.v-2 .carousel-inner .carousel-item.active,
      .carousel-multi-item.v-2 .carousel-item-next,
      .carousel-multi-item.v-2 .carousel-item-prev {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex; }
      .carousel-multi-item.v-2 .carousel-item-right.active,
      .carousel-multi-item.v-2 .carousel-item-next {
        -webkit-transform: translateX(50%);
        -ms-transform: translateX(50%);
        transform: translateX(50%); }
      .carousel-multi-item.v-2 .carousel-item-left.active,
      .carousel-multi-item.v-2 .carousel-item-prev {
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%); }
      .carousel-multi-item.v-2 .carousel-item-right,
      .carousel-multi-item.v-2 .carousel-item-left {
        -webkit-transform: translateX(0);
        -ms-transform: translateX(0);
        transform: translateX(0); }
    </style>
    
    <h3 class="font-weight-bold pb-4 mb-0 text-center">Gallery</h3>

    <div class="row">
      <div class="col-md-12">

        <div id="carousel-example-multi" class="carousel slide carousel-multi-item v-2" data-ride="carousel">

          <!--Controls-->
          <div class="controls-top">
            <a class="btn-floating bg-transparent z-depth-0 m-0" href="#carousel-example-multi" data-slide="prev"><i class="dark-grey-text fas fa-chevron-left"></i></a>
            <a class="btn-floating bg-transparent z-depth-0 m-0" href="#carousel-example-multi" data-slide="next"><i class="dark-grey-text fas fa-chevron-right"></i></a>
          </div>
          <!--/.Controls-->

          <div class="carousel-inner" role="listbox">

            <div class="carousel-item active">
              <div class="col-12 col-md-6 mb-4 mx-auto">
                <div class="view rounded z-depth-1-half">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(150).jpg" class="img-fluid rounded" alt="Sample image">
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="col-12 col-md-6 mb-4 mx-auto">
                <div class="view rounded z-depth-1-half">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(146).jpg" class="img-fluid rounded" alt="Sample image">
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="col-12 col-md-6 mb-4 mx-auto">
                <div class="view rounded z-depth-1-half">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(138).jpg" class="img-fluid rounded" alt="Sample image">
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="col-12 col-md-6 mx-auto">
                <div class="view rounded z-depth-1-half">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(133).jpg" class="img-fluid rounded" alt="Sample image">
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="col-12 col-md-6 mb-4 mx-auto">
                <div class="view rounded z-depth-1-half">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(148).jpg" class="img-fluid rounded" alt="Sample image">
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="col-12 col-md-6 mb-4 mx-auto">
                <div class="view rounded z-depth-1-half">
                  <img src="https://mdbootstrap.com/img/Photos/Slides/img%20(131).jpg" class="img-fluid rounded" alt="Sample image">
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </div>

  </section>
  <!--Section: Content-->


</div>
<script>
$('.carousel.carousel-multi-item.v-2 .carousel-item').each(function () {
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));

  for (var i = 0; i < 4; i++) {
    next = next.next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));
  }
});
</script>