<div class="container z-depth-1 my-5 pt-5 pb-3 px-5">

  <!-- Section -->
  <section>
    
    <style>
      .fa-play:before {
        margin-left: .3rem;
      }

      /* Steps */
      .step {
        list-style: none;
        margin: 0;
      }

      .step-element {
        display: flex;
        padding: 1rem 0;
      }

      .step-number {
        position: relative;
        width: 7rem;
        flex-shrink: 0;
        text-align: center;
      }

      .step-number .number {
        color: #bfc5ca;
        background-color: #eaeff4;
        font-size: 1.5rem;
      }

      .step-number .number {
        width: 48px;
        height: 48px;
        line-height: 48px;
      }

      .number {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 38px;
        border-radius: 10rem;
      }

      .step-number::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 48px;
        bottom: -2rem;
        margin-left: -1px;
        border-left: 2px dashed #eaeff4;
      }

      .step .step-element:last-child .step-number::before {
        bottom: 1rem;
      }
    </style>

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

    <h3 class="font-weight-bold text-center dark-grey-text pb-2">Three Easy Steps</h3>
    <hr class="w-header my-4">
    <p class="lead text-center text-muted pt-2 mb-5">Explore the best MDB template in the market in a short 1-minute video.</p>

    <div class="row align-items-center">

      <div class="col-lg-6 mb-4">
        <div class="view z-depth-1-half rounded">
          <img class="rounded img-fluid" src="https://mdbootstrap.com/img/Photos/Horizontal/Work/12-col/img%20(6).jpg" alt="Video title">
          <div class="mask flex-center rgba-black-light">
            <a id="play" class="btn-floating btn-primary btn-lg" data-toggle="modal" data-target="#modal1"><i class="fas fa-play"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-6 mb-4">

        <ol class="step pl-0">
          <li class="step-element pb-0">
            <div class="step-number">
              <span class="number">1</span>
            </div>
            <div class="step-excerpt">
              <h6 class="font-weight-bold dark-grey-text mb-3">Write your requirements</h6>
              <p class="text-muted">Think the or organization same proposal to affected heard reclined in be it reassuring.</p>
            </div>
          </li>
          <li class="step-element pb-0">
            <div class="step-number">
              <span class="number">2</span>
            </div>
            <div class="step-excerpt">
              <h6 class="font-weight-bold dark-grey-text mb-3">Sign the contract</h6>
              <p class="text-muted">Think the or organization same proposal to affected heard reclined in be it reassuring.</p>
            </div>
          </li>
          <li class="step-element pb-0">
            <div class="step-number">
              <span class="number">3</span>
            </div>
            <div class="step-excerpt">
              <h6 class="font-weight-bold dark-grey-text mb-3">We start developing</h6>
              <p class="text-muted">Think the or organization same proposal to affected heard reclined in be it reassuring.</p>
            </div>
          </li>
        </ol>

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