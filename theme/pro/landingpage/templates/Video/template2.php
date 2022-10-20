<div class="container z-depth-1 my-5 py-5">
  

  <!-- Section: Block Content -->
  <section>

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

    <h6 class="font-weight-bold text-center grey-text text-uppercase small mb-4">video</h6>
    <h3 class="font-weight-bold text-center dark-grey-text pb-2">Explore</h3>
    <hr class="w-header my-4">
    <p class="lead text-center text-muted pt-2 mb-5">Explore the best MDB template in the market in a short 1-minute video.</p>

    <div class="row">
      <div class="col-md-8 mx-auto mb-4">

          <div class="view z-depth-1 rounded">
            <img class="rounded img-fluid" src="https://mdbootstrap.com/img/Photos/Others/img%20(29).jpg" alt="Video title">
            <div class="mask flex-center rgba-white-light">
              <a id="play" class="btn-floating btn-danger btn-lg" data-toggle="modal" data-target="#modal1"><i class="fas fa-play"></i></a>
            </div>
          </div>

      </div>
    </div>

  </section>
  <!-- Section: Block Content -->

  
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