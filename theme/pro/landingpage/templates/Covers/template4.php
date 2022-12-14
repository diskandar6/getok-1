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
    background-color: #563e91 !important;
  }

  .navbar:not(.top-nav-collapse) {
    background: transparent !important;
  }

  @media (max-width: 991px) {
   .navbar:not(.top-nav-collapse) {
    background: #563e91 !important;
   }
  }
  
  .rgba-gradient {
    background: linear-gradient(45deg, rgba(213, 15, 61, 0.6), rgba(13, 17, 198, 0.69) 100%);
  }

</style>

<!-- Main navigation -->
<header>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">

    <div class="container">

      <a class="navbar-brand" href="#">Navbar</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

        <ul class="navbar-nav mr-auto smooth-scroll">
          <li class="nav-item">
            <a class="nav-link" href="#home">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about" data-offset="90">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#features" data-offset="90">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services" data-offset="90">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#opinions" data-offset="30">Opinions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#team" data-offset="90">Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact" data-offset="90">Contact</a>
          </li>
        </ul>

        <!-- Social Icon  -->
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a class="nav-link">
              <i class="fab fa-facebook-f light-green-text-2"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link">
              <i class="fab fa-twitter light-green-text-2"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link">
              <i class="fab fa-instagram light-green-text-2"></i>
            </a>
          </li>
        </ul>

      </div>

    </div>

  </nav>
  <!-- Navbar -->

  <!-- Full Page Intro -->
  <div id="intro-section" class="view">

    <video class="video-intro" poster="https://mdbootstrap.com/img/Photos/Others/background.jpg" playsinline
      autoplay muted loop>
      <source src="https://mdbootstrap.com/img/video/animation.mp4" type="video/mp4">
    </video>

    <!-- Mask & flexbox options-->
    <div class="mask rgba-gradient d-flex justify-content-center align-items-center">

      <!-- Content -->
      <div class="container px-md-3 px-sm-0">

        <!--Grid row-->
        <div class="row wow fadeIn">

          <!--Grid column-->
          <div class="col-md-12 mb-4 white-text text-center wow fadeIn">

            <h3 class="display-3 font-weight-bold white-text mb-0 pt-md-5 pt-5">Creative Agency</h3>
            <hr class="hr-light my-4 w-75">
            <h4 class="subtext-header mt-2 mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit
              deleniti consequuntur nihil.</h4>
            <a href="#!" class="btn btn-rounded btn-outline-white">
              <i class="fas fa-home"></i> Visit us
            </a>

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