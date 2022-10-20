<div class="container my-5">

  
  <!-- Section: Block Content -->
  <section>

    <style>
      .card-list li.page-item {
        height: 36px;
      }
      .card-list .form-check-input[type="checkbox"] + label:before, .form-check-input[type="checkbox"]:not(.filled-in) + label:after, label.btn input[type="checkbox"] + label:before, label.btn input[type="checkbox"]:not(.filled-in) + label:after {
        margin-top: 0;
      }
      .card-list .form-check-input[type="checkbox"] + label, label.btn input[type="checkbox"] + label {
        height: 15px;
      }
      .card-list .form-check {
        height: 0;
      }
      .card-list .badge {
        height: 18px;
        margin-top: 3px;
      }
    </style>
    
    <div class="row">
      <div class="col-12">
      	<div class="card card-list">
          <div class="card-header white d-flex justify-content-between align-items-center py-3">
            <p class="h5-responsive font-weight-bold mb-0"><i class="fas fa-clipboard-list pr-2"></i>To Do List</p>
            <nav aria-label="Page navigation example">
              <ul class="pagination pg-blue mb-0">
                <li class="page-item">
                  <a class="border page-link" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                <li class="page-item"><a class="border page-link">1</a></li>
                <li class="page-item"><a class="border page-link">2</a></li>
                <li class="page-item"><a class="border page-link">3</a></li>
                <li class="page-item">
                  <a class="border page-link" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mb-0">
              <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="d-inline-flex">
                  <div class="form-check pl-0">
                    <input type="checkbox" class="form-check-input" id="materialChecked2">
                    <label class="form-check-label" for="materialChecked2"></label>
                  </div>
                  <p class="mb-0"><span class="text">Design a nice theme</span></p>
                  <span class="badge badge-danger ml-3"><i class="far fa-clock pr-1"></i>2 mins</span>
                </div>
                <div class="tools">
                  <a><i class="far fa-edit"></i></a>
                  <a><i class="far fa-trash-alt"></i></a>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="d-inline-flex">
                  <div class="form-check pl-0">
                    <input type="checkbox" class="form-check-input" id="materialChecked3">
                    <label class="form-check-label" for="materialChecked3"></label>
                  </div>
                  <p class="mb-0"><span class="text">Make the theme responsive</span></p>
                  <span class="badge badge-info ml-3"><i class="far fa-clock pr-1"></i>4 hours</span>
                </div>
                <div class="tools">
                  <a><i class="far fa-edit"></i></a>
                  <a><i class="far fa-trash-alt"></i></a>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="d-inline-flex">
                  <div class="form-check pl-0">
                    <input type="checkbox" class="form-check-input" id="materialChecked4">
                    <label class="form-check-label" for="materialChecked4"></label>
                  </div>
                  <p class="mb-0"><span class="text">Let theme shine like a star</span></p>
                  <span class="badge badge-warning ml-3"><i class="far fa-clock pr-1"></i>1 day</span>
                </div>
                <div class="tools">
                  <a><i class="far fa-edit"></i></a>
                  <a><i class="far fa-trash-alt"></i></a>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="d-inline-flex">
                  <div class="form-check pl-0">
                    <input type="checkbox" class="form-check-input" id="materialChecked5">
                    <label class="form-check-label" for="materialChecked5"></label>
                  </div>
                  <p class="mb-0"><span class="text">Let theme shine like a star</span></p>
                  <span class="badge badge-success ml-3"><i class="far fa-clock pr-1"></i>1 week</span>
                </div>
                <div class="tools">
                  <a><i class="far fa-edit"></i></a>
                  <a><i class="far fa-trash-alt"></i></a>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="d-inline-flex">
                  <div class="form-check pl-0">
                    <input type="checkbox" class="form-check-input" id="materialChecked6">
                    <label class="form-check-label" for="materialChecked6"></label>
                  </div>
                  <p class="mb-0"><span class="text">Check your messages and notifications</span></p>
                  <span class="badge badge-primary ml-3"><i class="far fa-clock pr-1"></i>1 week</span>
                </div>
                <div class="tools">
                  <a><i class="far fa-edit"></i></a>
                  <a><i class="far fa-trash-alt"></i></a>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-center pt-2 pb-1">
                <div class="d-inline-flex">
                  <div class="form-check pl-0">
                    <input type="checkbox" class="form-check-input" id="materialChecked7">
                    <label class="form-check-label" for="materialChecked7"></label>
                  </div>
                  <p class="mb-0"><span class="text">Let theme shine like a star</span></p>
                  <span class="badge badge-light ml-3"><i class="far fa-clock pr-1"></i>1 month</span>
                </div>
                <div class="tools">
                  <a><i class="far fa-edit"></i></a>
                  <a><i class="far fa-trash-alt"></i></a>
                </div>
              </li>
            </ul>
          </div>
          <div class="card-footer white py-3">
            <div class="text-right">
              <button class="btn btn-primary btn-md px-3 my-0 mr-0">Add item<i class="fas fa-plus pl-2"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- Section: Block Content -->

  
</div>