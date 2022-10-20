<div class="container my-5">

  <!--Section: Content-->
  <section>

    <div class="card">
      <div class="card-body px-0 pb-0">

        <h5 class="text-center font-weight-bold mb-4">Browser Usage</h5>

        <hr>

        <!--Grid row-->
        <div class="row mt-3 pt-3">

          <!--Grid column-->
          <div class="col-md-6 mb-4 mb-md-0 mx-auto">

            <canvas id="doughnutChart"></canvas>

          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-12 pt-4 mt-2 mb-4 mb-md-0 mx-auto">

            <div class="list-group">
              <a href="#!" class="list-group-item list-group-item-action rounded-0 border-left-0 border-right-0 d-flex justify-content-between align-items-center">United States of America
                <span class="text-danger"><i class="fas fa-chevron-down"></i> 12%</span>
              </a>
              <a href="#!" class="list-group-item list-group-item-action rounded-0 border-left-0 border-right-0 d-flex justify-content-between align-items-center">India
                <span class="text-success"><i class="fas fa-chevron-up"></i> 4%</span>
              </a>
              <a href="#!" class="list-group-item list-group-item-action border-bottom-0 border-left-0 border-right-0 rounded-bottom-left rounded-bottom-right d-flex justify-content-between align-items-center">China
                <span class="text-warning"><i class="fas fa-chevron-left"></i> 0%</span>
              </a>
            </div>

          </div>
          <!--Grid column-->

        </div>
        <!--Grid row-->

      </div>
    </div>

  </section>
  <!--Section: Content-->

</div>

<script>
// Doughnut
var ctxD = document.getElementById("doughnutChart").getContext('2d');
var myLineChart = new Chart(ctxD, {
  type: 'doughnut',
  data: {
    labels: ["Chrome", "Opera", "Firefox", "Navigator", "Safari"],
    datasets: [{
      data: [300, 50, 100, 40, 120],
      backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
      hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
    }]
  },
  options: {
    responsive: true,
    legend: {
      position: 'right',
      align: 'center',
      labels: {
        padding: 20
      }
    }
  }
});
</script>