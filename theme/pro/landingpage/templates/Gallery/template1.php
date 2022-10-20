<div class="container my-5 px-5 pt-5 pb-4 z-depth-1">
  

  <!--Section: Content-->
  <section class="dark-grey-text">
    
    <style>
      .d-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 100px;
        grid-gap: 7px;
      }

      .item {
        position: relative;
      }

      .item:nth-child(1) {
        grid-column: 1 / 2;
        grid-row: 1 / 4;
      }

      .item:nth-child(2) {
        grid-column: 2;
        grid-row: 0 / 3;
      }

      .item:nth-child(3) {
        grid-column: 2;
        grid-row: 2 / 3;
      }

      .item:nth-child(4) {
        grid-column: 2;
        grid-row: 3 / 3;
      }

      .item a {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        overflow: hidden;
      }

      .item img {
        height: 100%;
        width: 100%;
        object-fit: cover;
      }
    </style>

    <div class="row align-items-center">

      <div class="col-lg-6 mb-4">
        <h2 class="font-weight-normal mb-4">Lovely place to work</h2>
        <p class="lead text-muted">Beautifully designed by best interior designers for the best web designers</p>
        <p class="text-muted">We can combine beautiful, modern designs with clean, functional. And best of all, we
          are super passionate
          about our work. Thought does cognitive into follow and rationale annoyed.</p>
      </div>

      <div class="col-lg-6 mb-4">

        <div id="mdb-lightbox-ui"></div>

        <div class="d-grid mdb-lightbox">
          <figure class="item">
            <a href="https://mdbootstrap.com/img/Photos/Horizontal/Architecture/12-col/img%20(10).jpg"
              class="z-depth-1 rounded" data-size="1600x1067">
              <img src="https://mdbootstrap.com/img/Photos/Horizontal/Architecture/12-col/img%20(10).jpg" />
            </a>
          </figure>
          <figure class="item">
            <a href="https://mdbootstrap.com/img/Photos/Horizontal/Architecture/12-col/img%20(11).jpg"
              class="z-depth-1 rounded" data-size="1600x1067">
              <img src="https://mdbootstrap.com/img/Photos/Horizontal/Architecture/12-col/img%20(11).jpg" />
            </a>
          </figure>
          <figure class="item">
            <a href="https://mdbootstrap.com/img/Photos/Horizontal/Architecture/12-col/img%20(12).jpg"
              class="z-depth-1 rounded" data-size="1600x1067">
              <img src="https://mdbootstrap.com/img/Photos/Horizontal/Architecture/12-col/img%20(12).jpg" />
            </a>
          </figure>
          <figure class="item">
            <a href="https://mdbootstrap.com/img/Photos/Horizontal/Architecture/12-col/img%20(13).jpg"
              class="z-depth-1 rounded" data-size="1600x1067">
              <img src="https://mdbootstrap.com/img/Photos/Horizontal/Architecture/12-col/img%20(13).jpg" />
            </a>
          </figure>
        </div>

      </div>

    </div>

  </section>
  <!--Section: Content-->
  

</div>

<script>
$(function () {
    $("#mdb-lightbox-ui").load("https://mdbootstrap.com/wp-content/themes/mdbootstrap4/mdb-addons/mdb-lightbox-ui.html");
});
</script>