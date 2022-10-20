<div class="container my-5">

  <!-- Section: Block Content -->
  <section>

    <div class="card card-list">
      <div class="card-header white d-flex justify-content-between align-items-center py-3">
        <p class="h5-responsive font-weight-bold mb-0"><i class="fas fa-envelope pr-2"></i>Quick Email</p>
        <p class="h5-responsive font-weight-bold mb-0"><a><i class="fas fa-times"></i></a></p>
      </div>
      <div class="card-body">
        <input type="email" id="exampleForm2" placeholder="Email to:" class="form-control rounded-0 mb-3">
        <input type="text" id="exampleForm3" placeholder="Subject" class="form-control rounded-0 mb-4">
        <textarea name="message" id="post_content"></textarea>
      </div>
      <div class="card-footer white py-3">
        <div class="text-right">
          <button class="btn btn-primary btn-md px-3 my-0 mr-0">Send<i class="fas fa-paper-plane pl-2"></i></button>
        </div>
      </div>
    </div>

  </section>
  <!-- Section: Block Content -->

</div>

<script>
// TinyMCE Initialization
tinymce.init({ selector:'#post_content', menubar: false, height : "294" });
</script>