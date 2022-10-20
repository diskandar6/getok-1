<div class="container my-5">

  <!-- Section: Block Content -->
  <section>

    <style>
      .my-custom-scrollbar {
        position: relative;
        height: 250px;
        overflow: auto;
      }
    </style>

    <div class="card">
      <div class="card-header white">
        <p class="h5-responsive font-weight-bold mb-0"><i class="fas fa-comments pr-2"></i>Chat</p>
      </div>
      <div class="card-body my-custom-scrollbar">
        <div class="media">
          <img class="avatar rounded-circle card-img-64 z-depth-1 d-flex mr-3" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(32).jpg" alt="Generic placeholder image">
          <div class="media-body">
            <h6 class="mt-0 font-weight-bold">Johny Danish<span class="small text-muted float-right pr-2"><i class="far fa-clock pr-1"></i>5:25 AM</span></h6>
            <p class="mb-0 font-weight-light">I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market.</p>

            <div class="media mt-3">
              <div class="media-body grey lighten-2 p-3 rounded">
                <h6 class="mt-0 font-weight-bold">Attachements</h6>
                <small class="font-italic">Theme-thumbnail-image.jpg</small>
                <div class="text-right">
                  <button class="btn btn-primary btn-sm mb-0 mr-0">Open</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="media mt-4">
          <img class="avatar rounded-circle card-img-64 z-depth-1 d-flex mr-3" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(21).jpg" alt="Generic placeholder image">
          <div class="media-body">
            <h6 class="mt-0 font-weight-bold">Mario Sonetti<span class="small text-muted float-right pr-2"><i class="far fa-clock pr-1"></i>7:30 AM</span></h6>
            <p class="mb-2 font-weight-light">I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market.</p>
          </div>
        </div>

        <div class="media mt-4">
          <img class="avatar rounded-circle card-img-64 z-depth-1 d-flex mr-3" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(20).jpg" alt="Generic placeholder image">
          <div class="media-body">
            <h6 class="mt-0 font-weight-bold">Catherine Blake<span class="small text-muted float-right pr-2"><i class="far fa-clock pr-1"></i>10:10 AM</span></h6>
            <p class="mb-0 font-weight-light">I would like to meet you to discuss the latest news about the arrival of the new theme. They say it is going to be one the best themes on the market.</p>
          </div>
        </div>
      </div>
      <div class="card-footer white py-3">
        <div class="form-group mb-0">
          <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="2" placeholder="Type message..."></textarea>
          <div class="text-right pt-2">
            <button class="btn btn-primary btn-sm mb-0 mr-0">Submit</button>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- Section: Block Content -->

</div>

<script>
var myCustomScrollbar = document.querySelector('.my-custom-scrollbar');
var ps = new PerfectScrollbar(myCustomScrollbar);

var scrollbarY = myCustomScrollbar.querySelector('.ps.ps--active-y>.ps__scrollbar-y-rail');

myCustomScrollbar.onscroll = function() {
  scrollbarY.style.cssText = `top: ${this.scrollTop}px!important; height: 400px; right: ${-this.scrollLeft}px`;
}
</script>