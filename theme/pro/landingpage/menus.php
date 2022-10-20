    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
      <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="/">
            <img src="/assets/img/logo2.png" height="40">
          <strong><?=D_TITLE_PAGE?></strong>
        </a>
        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar links -->
            <ul class="nav navbar-nav nav-flex-icons ml-auto">
    <?php
    $data=menus_web();
    foreach($data as $k => $v){?>
              <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="menu<?=$k?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="clearfix d-none d-sm-inline-block"><?=$v[0]?></span></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="menu<?=$k?>">
    <?php foreach($v[1] as $k1 => $v1){?>
                      <a class="dropdown-item" href="<?=$v1[1]?>"><?=$v1[0]?></a>
    <?php }?>
                    </div>
              </li>
    <?php }?>
            </ul>
            <!-- Navbar links -->
          </div>
      </div>
    </nav>
    <!-- Navbar -->