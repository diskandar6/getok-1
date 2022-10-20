<div class="container-fluid mt-3 mb-5">

  <!-- Section -->
  <section class="bg-primary z-depth-1">

    <!-- Modal -->
    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
            <iframe id="player" class="embed-responsive-item" src="https://www.youtube.com/embed/7MUISDJ5ZZ4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>

    <div class="row no-gutters">

      <div class="col-lg-6 order-md-2">
        <div class="view">
          <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Slides/img%20(152).jpg" alt="Video title">
          <div class="mask flex-center rgba-black-light">
            <a id="play" class="btn-floating btn-danger btn-lg" data-toggle="modal" data-target="#modal1"><i class="fas fa-play"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-6 mx-auto d-flex align-items-center text-white">
        <div class="px-4 py-4 py-lg-0">
          <h3 class="font-weight-normal mb-4">Give a Fresh Design to Your MDB</h3>
          <p class="mb-0">Fresh fellow even the whole is work outcome them. They original on mountains, drew the
            support time. The of to graduate. Into to is the to she at return understand every in there transmitting
            you've he the was and in finger.</p>
        </div>
      </div>

    </div>
    
  </section>
  <!-- Section -->

</div>

<script>
$('#play').on('click', function (e) {
  e.preventDefault();
  $("#player")[0].src += "?autoplay=1";
  $('#player').show();
  $('#video-cover').hide();
})
$('#modal1').on('hidden.bs.modal', function (e) {
  $('#modal1 iframe').attr("src", $("#modal1 iframe").attr("src"));
});
</script>