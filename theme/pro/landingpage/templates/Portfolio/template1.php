<div class="container my-5">

  <!-- Section -->
  <section>
    
    <style>
      .gallery {
        -webkit-column-count: 3;
        -moz-column-count: 3;
        column-count: 3;
        -webkit-column-width: 33%;
        -moz-column-width: 33%;
        column-width: 33%; 
      }
        .gallery .pics {
        -webkit-transition: all 350ms ease;
        transition: all 350ms ease; 
      }
        .gallery .animation {
        -webkit-transform: scale(1);
        -ms-transform: scale(1);
        transform: scale(1); 
      }

      @media (max-width: 450px) {
        .gallery {
          -webkit-column-count: 1;
          -moz-column-count: 1;
          column-count: 1;
          -webkit-column-width: 100%;
          -moz-column-width: 100%;
          column-width: 100%;
        }
      }

      @media (max-width: 400px) {
        .btn.filter {
          padding-left: 1.1rem;
          padding-right: 1.1rem;
        }
      }
      button.close {
        position: absolute;
        right: 0;
        z-index: 2;
        padding-right: 1rem;
        padding-top: .6rem;
      }
    </style>
    
    <!-- Modal -->
		<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body p-0">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						
						<!-- Grid row -->
						<div class="row">
						
							<!-- Grid column -->
							<div class="col-md-6 py-5 pl-5">
								
								<h5 class="font-weight-normal mb-3">Paper cup mockup</h5>

								<p class="text-muted">Key letters, explain which writing we he carpeting or fame, the itch expand medical amped through constructing time. And scarfs, gain, get showed accounts decades.</p>

								<ul class="list-unstyled font-small mt-5">
									<li>
										<p class="text-uppercase mb-2"><strong>Client</strong></p>
										<p class="text-muted mb-4">Envato Inc.</p>
									</li>

									<li>
										<p class="text-uppercase mb-2"><strong>Date</strong></p>
										<p class="text-muted mb-4">June 27, 2019</p>
									</li>

									<li>
										<p class="text-uppercase mb-2"><strong>Skills</strong></p>
										<p class="text-muted mb-4">Design, HTML, CSS, Javascript</p>
									</li>

									<li>
										<p class="text-uppercase mb-2"><strong>Address</strong></p>
										<a href="https://mdbootstrap.com/docs/jquery/design-blocks/">MDBootstrap</a>
									</li>
								</ul>
								
							</div>
							<!-- Grid column -->
						
							<!-- Grid column -->
							<div class="col-md-6">
								
								<div class="view rounded-right">
									<img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Vertical/5.jpg" alt="Sample image">
								</div>
								
							</div>
							<!-- Grid column -->
						
						</div>
						<!-- Grid row -->
						
					</div>
				</div>
			</div>
		</div>

    <h6 class="font-weight-bold text-center grey-text text-uppercase small mb-4">portfolio</h6>
    <h3 class="font-weight-bold text-center dark-grey-text pb-2">Product Designs</h3>
    <hr class="w-header my-4">
    <p class="lead text-center text-muted pt-2 mb-5">You can find several product design by our professional team in this section.</p>

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-md-12 dark-grey-text d-flex justify-content-center mb-5">

        <button type="button" class="btn btn-flat btn-lg m-0 px-3 py-1 filter" data-rel="all">All</button>
        <p class="font-weight-bold mb-0 px-1 py-1">/</p>
        <button type="button" class="btn btn-flat btn-lg m-0 px-3 py-1 filter" data-rel="1">Design</button>
        <p class="font-weight-bold mb-0 px-1 py-1">/</p>
        <button type="button" class="btn btn-flat btn-lg m-0 px-3 py-1 filter" data-rel="2">Mockup</button>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

    <!-- Grid row -->
    <div class="gallery mb-5" id="gallery">

      <!-- Grid column -->
      <div class="mb-3 pics all 2 animation">
        <a data-toggle="modal" data-target="#basicExampleModal">
          <img class="img-fluid z-depth-1 rounded" src="https://mdbootstrap.com/img/Photos/Others/images/58.jpg" alt="Card image cap">
        </a>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="mb-3 pics animation all 1">
        <a data-toggle="modal" data-target="#basicExampleModal">
          <img class="img-fluid z-depth-1 rounded" src="https://mdbootstrap.com/img/Photos/Vertical/7.jpg" alt="Card image cap">
        </a>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="mb-3 pics animation all 1">
        <a data-toggle="modal" data-target="#basicExampleModal">
          <img class="img-fluid z-depth-1 rounded" src="https://mdbootstrap.com/img/Photos/Vertical/4.jpg" alt="Card image cap">
        </a>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="mb-3 pics all 2 animation">
        <a data-toggle="modal" data-target="#basicExampleModal">
          <img class="img-fluid z-depth-1 rounded" src="https://mdbootstrap.com/img/Photos/Others/images/63.jpg" alt="Card image cap">
        </a>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="mb-3 pics all 2 animation">
        <a data-toggle="modal" data-target="#basicExampleModal">
          <img class="img-fluid z-depth-1 rounded" src="https://mdbootstrap.com/img/Photos/Others/images/64.jpg" alt="Card image cap">
        </a>
      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="mb-3 pics animation all 1">
        <a data-toggle="modal" data-target="#basicExampleModal">
          <img class="img-fluid z-depth-1 rounded" src="https://mdbootstrap.com/img/Photos/Vertical/5.jpg" alt="Card image cap">
        </a>
      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </section>
  <!-- Section -->

</div>
<script>
$(function () {
  var selectedClass = "";
  $(".filter").click(function () {
    selectedClass = $(this).attr("data-rel");
    $("#gallery").fadeTo(100, 0.1);
    $("#gallery div").not("." + selectedClass).fadeOut().removeClass('animation');
    setTimeout(function () {
      $("." + selectedClass).fadeIn().addClass('animation');
      $("#gallery").fadeTo(300, 1);
    }, 300);
  });
});
</script>