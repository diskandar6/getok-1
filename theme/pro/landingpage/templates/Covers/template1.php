<style>

  html,
  body,
  header,
  .view {
    height: 100%;
  }

  @media (max-width: 740px) {
    html,
    body,
    header,
    .view {
      height: 100vh;
    }
  }

  .top-nav-collapse {
    background-color: #f8bbd0 !important;
  }

  .navbar:not(.top-nav-collapse) {
    background: transparent !important;
  }

  @media (max-width: 991px) {
   .navbar:not(.top-nav-collapse) {
    background: #f8bbd0 !important;
   }
  }

</style>

<!-- Main navigation -->
<header>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top scrolling-navbar">
    <div class="container">
      <a class="navbar-brand" href="#"><strong>MDB</strong></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-7"
        aria-controls="navbarSupportedContent-7" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent-7">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Profile</a>
          </li>
        </ul>
        <form class="form-inline">
          <div class="md-form my-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          </div>
        </form>
      </div>
    </div>
  </nav>
  <!-- Navbar -->
  <!-- Full Page Intro -->
  <div class="view  jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url('https://mdbootstrap.com/img/Photos/Others/gradient2.png'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
    <!-- Mask & flexbox options-->
    <div class="mask rgba-purple-slight d-flex justify-content-center align-items-center">
      <!-- Content -->
      <div class="container">
        <!--Grid row-->
        <div class="row wow fadeIn">
          <!--Grid column-->
          <div class="col-md-12 text-center">
            <h1 class="display-4 font-weight-bold mb-0 pt-md-5 pt-5 wow fadeInUp">Our New Course is Ready</h1>
            <h5 class="pt-md-5 pt-sm-2 pt-5 pb-md-5 pb-sm-3 pb-5 wow fadeInUp" data-wow-delay="0.2s">It comes
              with a lot of new features, easy to follow videos and images. Check it out now!</h5>
            <div class="wow fadeInUp" data-wow-delay="0.4s">
              <a class="btn btn-purple btn-rounded"><i class="fas fa-user left"></i> Sign up!</a>
              <a class="btn btn-outline-purple btn-rounded"><i class="fas fa-book left"></i> Learn more</a>
            </div>
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
</header>
<!-- Main navigation -->
<script>
    new WOW().init();
</script>