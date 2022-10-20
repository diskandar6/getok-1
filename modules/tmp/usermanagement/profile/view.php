<?php if(!defined('D_KEY_PIPE'))exit;?>
<?php
if(isset($_SESSION['image'])){if($_SESSION['image']!='')$img=$_SESSION['image'];else $img='/assets/img/Deafult-Profile-sx.png';}
else $img='/assets/img/Deafult-Profile-sx.png';
if((int)$_SESSION['id']<0){
  $a___=' style="display:none"';
  $b___='col-12';
  }else{
    $a___='';
    $b___='col-lg-6';
  }
?>
<br>    
  <main>
    <div class="container-fluid">

      <!-- Section: Edit Account -->
      <section class="section">
        <!-- First row -->
        <div class="row">
          <!-- First column -->
          <div class="col-lg-6 mb-4"<?=$a___?>>

            <!-- Card -->
            <div class="card card-cascade narrower">
              <!-- Card image -->
              <div class="view view-cascade gradient-card-header primary-color-dark">
                <h5 class="mb-0 font-weight-bold">Edit Photo</h5>
              </div>
              <!-- Card image -->

              <!-- Card content -->
              <div class="card-body card-body-cascade text-center">
                <img src="<?=$img?>?w=1&h=1&p=1&nw=150&f=1&t=1" style="width:150px" alt="User Photo" class="z-depth-1 mb-3 mx-auto rounded-circle" id="foto"/>
                <p class="text-muted"><small>Profile photo will be changed automatically</small></p>
                <?php if($_SESSION['id']>0){?>
                <div class="row flex-center">
                  <button class="btn btn-info btn-rounded btn-sm" data-target="#uploads" data-toggle="modal" onclick="pre_upload()">Upload New Photo</button>
                </div>
                <?php }?>
              </div>
              <!-- Card content -->

            </div>
            <!-- Card -->

          </div>
          <!-- First column -->

          <!-- Second column -->
          <div class="<?=$b___?> mb-4">

            <!-- Card -->
            <div class="card card-cascade narrower">

              <!-- Card image -->
              <div class="view view-cascade gradient-card-header primary-color-dark">
                <h5 class="mb-0 font-weight-bold">Edit Account</h5>
              </div>
              <!-- Card image -->

              <!-- Card content -->
              <div class="card-body card-body-cascade text-center">

                <!-- Edit Form -->
                
                  <!-- First row -->

                  <div class="row">

                    <!-- First column -->
                    <div class="col-12">
                      <div class="md-form mb-0">
                        <input type="text" id="username" class="form-control validate" value="<?php if(isset($_SESSION['username']))echo $_SESSION['username'];?>" readonly disabled>
                        <label for="username" data-error="wrong" data-success="right">Username</label>
                      </div>
                    </div>
                    <!-- Second column -->
                    <div class="col-12"<?php if((int)$_SESSION['id']<0)echo ' style="display:none"';?>>
                      <div class="md-form mb-0">
                        <input type="email" id="email" class="form-control" value="<?php if(isset($_SESSION['email']))echo $_SESSION['email'];?>">
                        <label for="email" data-error="wrong" data-success="right" readonly disabled>Email</label>
                      </div>
                    </div>
                    <!-- First column -->
                    <div class="col-md-6">
                      <div class="md-form mb-0">
                        <input type="password" id="pass1" class="form-control validate" value="">
                        <label for="pass1" data-error="wrong" data-success="right">Password</label>
                      </div>
                    </div>
                    <!-- Second column -->
                    <div class="col-md-6">
                      <div class="md-form mb-0">
                        <input type="password" id="pass2" class="form-control validate" value="">
                        <label for="pass2" data-error="wrong" data-success="right">Confirm Password</label>
                      </div>
                    </div>
<script>
function ganti_password(){
    $.post(PT,{pass1:$('#pass1').val(),pass2:$('#pass2').val(),email:$('#email').val()},function(data){
        alert_ok(data,'OK');
        $('#pass1').val('');
        $('#pass2').val('');
    })
}
function load_img(file){
    $.get(DT,{image:file.name},function(data){
        $('#foto').attr('src',data+'&w=1&h=1&p=1&nw=150&f=1&t=1');
        $('#foto_atas').attr('src',data+'&w=1&h=1&p=1&nw=50&f=1&t=1');
    });
}
</script>
<?php //if($_SESSION['id']>0){?>
                    <div class="col-12 flex-center">
                        <button class="btn btn-info btn-rounded btn-sm" onclick="ganti_password()">Submit</button>
                    </div>
<?php //}?>
                  </div>
                  <!-- First row -->

                
                <!-- Edit Form -->

              </div>
              <!-- Card content -->

            </div>
            <!-- Card -->

          </div>
          <!-- Second column -->

        </div>
        <!-- First row -->

      </section>
      <!-- Section: Edit Account -->

    </div>

  </main>


<?php
$dir=D_DATABASES_PATH;if(!file_exists($dir))mkdir($dir,0755);
$dir.='data_pegawai/';if(!file_exists($dir))mkdir($dir,0755);
$dir.=(int)$_SESSION['id'].'/';if(!file_exists($dir))mkdir($dir,0755);
$dir.='profile/';if(!file_exists($dir))mkdir($dir,0755);
plupload($dir,'i','load_img(file)',5,false);?>