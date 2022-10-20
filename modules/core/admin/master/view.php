              <div class="tab-pane fade" id="panel4" role="tabpanel">
                  <div class="row">
                      <div class="col-12">
                      	<button onclick="get_modalmaster('https://mdbootstrap.com/docs/b4/jquery/design-blocks/')" class="btn btn-<?=$ath?> btn-sm">design-blocks <i class="fa fa-stamp"></i></button>
                      	<button onclick="get_modalmaster('https://mdbootstrap.com/docs/b4/jquery/content/icons-list/')" class="btn btn-<?=$ath?> btn-sm">Icons <i class="fa fa-icons"></i></button>
                      	<button onclick="get_modalmaster('https://mdbootstrap.com/docs/b4/jquery/components/demo/')" class="btn btn-<?=$ath?> btn-sm">Components <i class="fa fa-cubes"></i></button>
                      	<button onclick="get_modalmaster('https://mdbootstrap.com/docs/b4/jquery/css/demo/')" class="btn btn-<?=$ath?> btn-sm">CSS <i class="fab fa-css3-alt"></i></button>
                      	<button onclick="get_modalmaster('https://mdbootstrap.com/docs/b4/jquery/javascript/demo/')" class="btn btn-<?=$ath?> btn-sm">JavaScript <i class="fas fa-code"></i></button>
                      	<a href="/assets/pro/html/dashboards/v-1.html" target="_blank" class="btn btn-<?=$ath?> btn-sm">Template <i class="fas fa-file-code"></i></a>
                      </div>
                      <script>
                          function get_modalmaster(v){
                              $('#urlmaster').val(v);
                              $('#modal-urlmaster').modal('show');
                          }
                      </script>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="list-group z-depth-1">
                          <a href="/assets/pro/template/admin/dashboard.html" target="_blank" class="list-group-item">Admin - Dahboard</a>
                          <a href="/assets/pro/template/blog/category-page.html" target="_blank" class="list-group-item">Blog - Category</a>
                          <a href="/assets/pro/template/blog/home-page.html" target="_blank" class="list-group-item">Blog - Home</a>
                          <a href="/assets/pro/template/blog/post-page.html" target="_blank" class="list-group-item">Blog - Post</a>
                          <a href="/assets/pro/template/coming-soon/index.html" target="_blank" class="list-group-item">coming-soon</a>
                          <a href="/assets/pro/template/e-commerce/checkout-page.html" target="_blank" class="list-group-item">e-commerce - checkout-page</a>
                          <a href="/assets/pro/template/e-commerce/home-page.html" target="_blank" class="list-group-item">e-commerce - home-page</a>
                          <a href="/assets/pro/template/e-commerce/product-page.html" target="_blank" class="list-group-item">e-commerce - product-page</a>
                          </div>
                      </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="list-group z-depth-1">
                          <a href="/assets/pro/template/full-page-image/index.html" target="_blank" class="list-group-item">full-page-image</a>
                          <a href="/assets/pro/template/full-page-image-carousel/index.html" target="_blank" class="list-group-item">full-page-image-carousel</a>
                          <a href="/assets/pro/template/full-page-video-carousel/index.html" target="_blank" class="list-group-item">full-page-video-carousel</a>
                          <a href="/assets/pro/template/half-page-image-carousel/index.html" target="_blank" class="list-group-item">half-page-image-carousel</a>
                          <a href="/assets/pro/template/landing-page/buttons.html" target="_blank" class="list-group-item">landing-page - buttons</a>
                          <a href="/assets/pro/template/landing-page/form.html" target="_blank" class="list-group-item">landing-page - form</a>
                          <a href="/assets/pro/template/magazine/category-page.html" target="_blank" class="list-group-item">magazine - category-page</a>
                          <a href="/assets/pro/template/magazine/home-page.html" target="_blank" class="list-group-item">magazine - home-page</a>
                          </div>
                      </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="list-group z-depth-1">
                          <a href="/assets/pro/template/magazine/post-page.html" target="_blank" class="list-group-item">magazine - post-page</a>
                          <a href="/assets/pro/template/one-column-listing/index.html" target="_blank" class="list-group-item">one-column-listing</a>
                          <a href="/assets/pro/template/portfolio/full-page-gallery.html" target="_blank" class="list-group-item">portfolio - full-page-gallery</a>
                          <a href="/assets/pro/template/portfolio/gallery-variations.html" target="_blank" class="list-group-item">portfolio - gallery-variations</a>
                          <a href="/assets/pro/template/two-columns-listing/index.html" target="_blank" class="list-group-item">two-columns-listing</a>
                          <a href="/assets/pro/template/three-columns-listing/index.html" target="_blank" class="list-group-item">three-columns-listing</a>
                          <a href="/assets/pro/template/saas/landing-page.html" target="_blank" class="list-group-item">landing-page</a>
                          <a href="/assets/pro/template/saas/pricing.html" target="_blank" class="list-group-item">pricing</a>
                        </div>
                    </div>
                </div>
            </div>

<div class="modal fade" id="modal-urlmaster" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">URL MASTER</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="md-form">
            <input type="text" id="urlmaster" class="form-control" readonly onclick="copy_urlmaster()">
        </div>
        <script>
            function copy_urlmaster(){
                var copyText = document.getElementById("urlmaster");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
            }
        </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Central Modal Small -->