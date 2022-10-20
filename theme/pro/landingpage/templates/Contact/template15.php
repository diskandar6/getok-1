<div class="container my-5 py-5 z-depth-1">


  <!--Section: Content-->
  <section class="px-md-5 mx-md-5 text-center text-lg-left dark-grey-text">

    <style>
      .map-container {
        height: 200px;
        position: relative;
      }

      .map-container iframe {
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        position: absolute;
      }
    </style>

    <!--Grid row-->
    <div class="row d-flex justify-content-center mb-4">

      <!--Grid column-->
      <div class="col-md-6 text-center">

        <h3 class="font-weight-bold mb-4">Contact Us</h3>

        <!-- Material outline input -->
        <div class="md-form md-outline mt-3">
          <input type="email" id="form-email" class="form-control">
          <label for="form-email">E-mail</label>
        </div>

        <!-- Material outline input -->
        <div class="md-form md-outline">
          <input type="text" id="form-subject" class="form-control">
          <label for="form-subject">Subject</label>
        </div>

        <!--Material textarea-->
        <div class="md-form md-outline mb-3">
          <textarea id="form-message" class="md-textarea form-control" rows="5"></textarea>
          <label for="form-message">How we can help?</label>
        </div>

        <button type="submit" class="btn btn-info btn-sm ml-0">Submit<i class="far fa-paper-plane ml-2"></i></button>

      </div>
      <!--Grid column-->

    </div>
    <!--Grid row-->

    <!--Google map-->
    <div id="map-container-google-1" class="z-depth-1 map-container">
        <iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
          style="border:0" allowfullscreen></iframe>
      </div>
      <!--Google Maps-->


  </section>
  <!--Section: Content-->


</div>