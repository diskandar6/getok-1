<style>
  
	.navbar {
    background: linear-gradient(40deg, rgba(0,51,199,.3), rgba(209,149,249,.3));
  }
  .navbar:not(.top-nav-collapse) {
    background: transparent;
  }
  .navbar .navbar-brand img {
    height: 40px;
    margin: 10px;
  }
  .hm-gradient {
    background: linear-gradient(40deg, rgba(0,51,199,.3), rgba(209,149,249,.3));
  }
  .heading {
    margin: 0 6rem;
    font-size: 3.8rem;
    font-weight: 700;
    color: #5d4267;
  }
  .subheading {
    margin: 2.5rem 6rem;
    color: #bcb2c0;
  }
  .btn.btn-margin {
    margin-left: 6rem;
    margin-top: 3rem;
  }
  .btn.btn-lily {
    background: linear-gradient(40deg, rgba(0,51,199,.7), rgba(209,149,249,.7));
    color: #fff;
  }
  .title {
    margin-top: 6rem;
    margin-bottom: 2rem;
    color: #5d4267;
  }
  .subtitle {
    color: #bcb2c0;
    margin-left: 20%;
    margin-right: 20%;
    margin-bottom: 6rem;
  }

</style>

<!-- Main navigation -->
<header>

  <!--Navbar -->
  <nav class="navbar navbar-expand-lg scrolling-navbar navbar-dark z-depth-0 fixed-top">
    <a class="navbar-brand" href="#">
      <img src="https://mdbootstrap.com/img/logo/mdb-transparent.png" alt="mdb logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
      aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fab fa-pinterest-p"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fab fa-dribbble"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fab fa-facebook-f"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fab fa-instagram"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fas fa-user"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
            <a class="dropdown-item" href="#">My account</a>
            <a class="dropdown-item" href="#">Log out</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!--/.Navbar -->

  <!-- Intro -->
  <section class="view">

    <div class="row">

      <div class="col-md-6">

        <div class="d-flex flex-column justify-content-center align-items-center h-100">
          <h1 class="heading">Material Design for Bootstrap</h1>
          <h4 class="subheading font-weight-bold">World's most popular framework for building responsive, mobile-first websites and apps</h4>
          <div class="mr-auto">
            <button type="button" class="btn btn-lily btn-margin btn-rounded">Get started <i class="fas fa-caret-right ml-3"></i></button>
          </div>
        </div>

      </div>

      <div class="col-md-6">

        <div class="view">
          <img src="https://images.pexels.com/photos/325045/pexels-photo-325045.jpeg" class="img-fluid" alt="smaple image">
          <div class="mask flex-center hm-gradient">
          </div>
        </div>

      </div>

    </div>

  </section>
  <!-- Intro -->

</header>
<!-- Main navigation -->

<script>
    new WOW().init();
</script>