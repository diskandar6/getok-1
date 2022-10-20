<div class="container-fluid mt-3 mb-5">

  <section style="background-image: url('https://mdbootstrap.com/img/Photos/Horizontal/Work/12-col/img%20(1).jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
    
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

    <div class="mask rgba-black-strong py-5">

      <div class="container text-center my-5">

        <h3 class="font-weight-bold text-center white-text pb-2">Watch Video</h3>
        <hr class="w-header hr-light my-4">
        <p class="lead text-center white-text pt-2 mb-5">Explore the best MDB template in the market in a short 1-minute video.</p>

        <a id="play" class="btn-floating btn-cyan btn-lg" data-toggle="modal" data-target="#modal1"><i class="fas fa-play"></i></a>

      </div>

    </div>

  </section>

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