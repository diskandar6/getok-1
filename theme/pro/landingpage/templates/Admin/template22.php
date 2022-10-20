<style>
    body {
      background-color: #eee;
    }
</style>

  <div class="container my-5 py-5">


    <!--Section: Block Content-->
    <section>

      <div class="card">
        <div class="card-body mr-md-1">

          <!--Grid row-->
          <div class="row mb-3">

            <!--Grid column-->
            <div class="col-md-8 mb-4">

              <canvas id="barChart" height="100"></canvas>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-4 mb-1 mb-md-0">

              <h5 class="text-center font-weight-bold mb-4">E-commerce data</h5>

              <div class="d-flex justify-content-between">
                <small class="text-muted">Add products to cart</small>
                <small><span><strong>160</strong></span>/<span></span>200</small>
              </div>
              <div class="progress md-progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 55%" aria-valuenow="55"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>

              <div class="d-flex justify-content-between">
                <small class="text-muted">Complete Purchase</small>
                <small><span><strong>310</strong></span>/<span></span>400</small>
              </div>
              <div class="progress md-progress">
                <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>

              <div class="d-flex justify-content-between">
                <small class="text-muted">Visit Premium Page</small>
                <small><span><strong>480</strong></span>/<span></span>800</small>
              </div>
              <div class="progress md-progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 45%" aria-valuenow="45"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>

              <div class="d-flex justify-content-between">
                <small class="text-muted">Send Inquiries</small>
                <small><span><strong>250</strong></span>/<span></span>500</small>
              </div>
              <div class="progress md-progress">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100"></div>
              </div>

            </div>
            <!--Grid column-->

          </div>
          <!--Grid row-->

          <!--Grid row-->
          <div class="row text-center">

            <!--Grid column-->
            <div class="col-md-4 mb-4 mb-md-0">

              <p class="text-success mb-1"><i class="fas fa-caret-up mr-2"></i>17%</p>
              <p class="font-weight-bold mb-1">$35 210</p>
              <p class="text-uppercase mb-md-0">Sales</p>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-4 mb-4 mb-md-0">

              <p class="text-danger mb-1"><i class="fas fa-caret-down mr-2"></i>17%</p>
              <p class="font-weight-bold mb-1">4 578</p>
              <p class="text-uppercase mb-md-0">Subscriptions</p>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-4 mb-0">

              <p class="text-dark mb-1"><i class="fas fa-caret-left mr-2"></i>0%</p>
              <p class="font-weight-bold mb-1">678 934</p>
              <p class="text-uppercase mb-0">Traffic</p>

            </div>
            <!--Grid column-->

          </div>
          <!--Grid row-->

        </div>
      </div>


    </section>
    <!--Section: Block Content-->


  </div>
  
  <script>
//bar
    var ctxB = document.getElementById("barChart").getContext('2d');
    var myBarChart = new Chart(ctxB, {
      type: 'bar',
      data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  </script>