<div class="container my-5">

  <!-- Section: Block Content -->
  <section>

    <style>
      .my-custom-scrollbar {
        position: relative;
        height: 250px;
        overflow: auto;
      }
      .card-img-35 {
        width: 35px;
      }
      .mt-3p {
        margin-top: 3px;
      }
    </style>

    <div class="card">
      <div class="card-header white d-flex justify-content-between">
        <p class="h5-responsive font-weight-bold mb-0">Direct Chat</p>
        <ul class="list-unstyled d-flex align-items-center mb-0">
          <li><span class="badge badge-pill badge-primary">3</span></li>
          <li><i class="far fa-window-minimize fa-sm pl-3"></i></li>
          <li><i class="fas fa-comments fa-sm pl-3"></i></li>
          <li><i class="fas fa-times fa-sm pl-3"></i></li>
        </ul>
      </div>
      <div class="card-body my-custom-scrollbar">
        <div class="media">
          <img class="avatar rounded-circle card-img-35 z-depth-1 d-flex mr-3" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(32).jpg" alt="Generic placeholder image">
          <div class="media-body">
            <p class="mt-0 font-weight-bold small mb-1">Johny Danish<span class="text-muted float-right small mt-3p">12 Nov 3:00 PM</span></p>
            <p class="mb-0 font-weight-light small grey lighten-2 p-2 rounded">Is this template really for free? That's unbelievable!</p>
          </div>
        </div>

       	<div class="media mt-3">
          <div class="media-body">
            <p class="mt-0 font-weight-bold small mb-1"><span class="text-muted small mt-3p">12 Nov 3:05 PM</span><span class="float-right">Alice Cooper</span></p>
            <p class="mb-0 font-weight-light small primary-color text-white p-2 rounded">You better believe it!</p>
          </div>
          <img class="avatar rounded-circle card-img-35 z-depth-1 d-flex ml-3" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(31).jpg" alt="Generic placeholder image">
        </div>
        
        <div class="media mt-3">
          <img class="avatar rounded-circle card-img-35 z-depth-1 d-flex mr-3" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(32).jpg" alt="Generic placeholder image">
          <div class="media-body">
            <p class="mt-0 font-weight-bold small mb-1">Johny Danish<span class="text-muted float-right small mt-3p">12 Nov 6:17 PM</span></p>
            <p class="mb-0 font-weight-light small grey lighten-2 p-2 rounded">Working with MDB Admin on a great new app! Wanna join?</p>
          </div>
        </div>

       	<div class="media mt-3">
          <div class="media-body">
            <p class="mt-0 font-weight-bold small mb-1"><span class="text-muted small mt-3p">12 Nov 6:23 PM</span><span class="float-right">Alice Cooper</span></p>
            <p class="mb-0 font-weight-light small primary-color text-white p-2 rounded">I would love to.</p>
          </div>
          <img class="avatar rounded-circle card-img-35 z-depth-1 d-flex ml-3" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(31).jpg" alt="Generic placeholder image">
        </div>
      </div>
      <div class="card-footer white py-3">
        <div class="form-group mb-0">
          <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="1" placeholder="Type message..."></textarea>
          <div class="text-right pt-2">
            <button class="btn btn-primary btn-sm mb-0 mr-0">Send</button>
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
  scrollbarY.style.cssText = `top: ${this.scrollTop}px!important; height: 250px; right: ${-this.scrollLeft}px`;
}
</script>