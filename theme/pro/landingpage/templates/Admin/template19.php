<div class="container my-5">


  <!-- Section: Block Content -->
  <section>

    <div class="card card-list">
      <div class="card-header white d-flex justify-content-between align-items-center py-3">
        <div class="d-flex justify-content-start align-items-center">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(18).jpg" class="z-depth-1 rounded-circle" width="45" alt="avatar image">
          <div class="d-flex flex-column pl-3">
            <a href="#!" class="font-weight-normal mb-0">Amanda Nicolson</a>
            <p class="small text-muted mb-0">Shared publicly - 8:30 PM Today</p>
          </div>
        </div>
        <ul class="list-unstyled d-flex align-items-center text-muted mb-0">
          <li>
            <a>
              <i class="far fa-circle fa-sm pl-3 material-tooltip-main" data-toggle="tooltip"
              title="Mark as read"></i>
            </a>
          </li>
          <li><a><i class="far fa-window-minimize fa-sm pl-3"></i></a></li>
          <li><a><i class="fas fa-times fa-sm pl-3"></i></a></li>
        </ul>
      </div>
      <div class="card-body">
        <img src="https://mdbootstrap.com/img/Photos/Horizontal/Things/12-col/img%20%289%29.jpg" class="img-fluid">
        <p class="my-4">I took this photo this morning. What do you guys think?</p>
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex flex-row">
            <button type="button" class="btn btn-fb btn-sm py-1 px-2 m-0 mr-2"><i class="far fa-thumbs-up pr-1"></i> Like</button>
            <button type="button" class="btn btn-light btn-sm py-1 px-2 m-0 mr-2"><i class="fas fa-share pr-1"></i> Share</button>
          </div>
          <div class="d-flex flex-column pl-3">
            <p class="small text-muted mb-0">135 likes - 7 comments</p>
          </div>
        </div>
      </div>
      <div class="py-4 grey lighten-4">
        <div class="px-3">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(19).jpg" class="z-depth-1 rounded-circle float-left" width="40" alt="avatar image">
          <div class="d-flex flex-column pl-3">
            <div class="">
              <a href="#!" class="font-weight-normal mb-0">Jenny Doe</a>
              <p class="small text-muted float-right mb-0">8:35 PM Today</p>
            </div>
            <p class="font-weight-light dark-grey-text mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit consequuntur, minus tenetur dicta optio sint nobis nesciunt deserunt quisquam eius.</p>
          </div>
        </div>
        <hr class="my-3">
        <div class="px-3">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(20).jpg" class="z-depth-1 rounded-circle float-left" width="40" alt="avatar image">
          <div class="d-flex flex-column pl-3">
            <div class="">
              <a href="#!" class="font-weight-normal mb-0">Rachel Simpson</a>
              <p class="small text-muted float-right mb-0">8:35 PM Today</p>
            </div>
            <p class="font-weight-light dark-grey-text mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit consequuntur, minus tenetur dicta optio sint nobis nesciunt deserunt quisquam eius.</p>
          </div>
        </div>
      </div>
      <div class="card-footer white py-3">
        <div class="form-group mb-0">
          <textarea class="form-control rounded-0" id="exampleFormControlTextarea1" rows="2"
            placeholder="Write a comment"></textarea>
          <div class="text-right pt-1">
            <button class="btn btn-primary btn-sm mb-0 mr-0">Submit</button>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- Section: Block Content -->


</div>
<script>
$(function () {
  $('.material-tooltip-main').tooltip({
    template: '<div class="tooltip md-tooltip"><div class="tooltip-arrow md-arrow"></div><div class="tooltip-inner md-inner"></div></div>'
  });
})
</script>