<div class="container z-depth-1 p-5 my-5">

  <!-- Section: Block Content -->
  <section>

    <!-- Filter Area -->
    <div class="row align-items-center">
      <div class="col-md-4">
        <!-- Sort by -->
        <select class="mdb-select grey-text md-form" multiple>
          <option value="" disabled selected>Choose your option</option>
          <option value="1">Option 1</option>
          <option value="2">Option 2</option>
          <option value="3">Option 3</option>
        </select>
        <label class="mdb-main-label">Example label</label>
        <button class="btn-save btn btn-primary btn-sm">Save</button>
        <!-- Sort by -->
      </div>
      <div class="col-8 col-md-8 text-right">
        <!-- View Switcher -->
        <a class="btn blue darken-3 btn-sm">
          <i class="fas fa-th mr-2" aria-hidden="true"></i>
          <strong> Grid</strong>
        </a>
        <a class="btn blue darken-3 btn-sm">
          <i class="fas fa-th-list mr-2" aria-hidden="true"></i>
          <strong> List</strong>
        </a>
        <!-- View Switcher -->
      </div>
    </div>
    <!-- Filter Area -->

  </section>
  <!-- Section: Block Content -->

</div>
<script>
    // Material Select Initialization
$(document).ready(function() {
	$('.mdb-select').materialSelect();
});
</script>