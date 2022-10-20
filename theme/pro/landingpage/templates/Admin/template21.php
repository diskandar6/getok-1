<div class="container my-5">

  <!-- Section -->
  <section>
    
    <h6 class="font-weight-bold text-center grey-text text-uppercase small mb-4">Admin</h6>
    <h3 class="font-weight-bold text-center dark-grey-text pb-2">Chart Dataset</h3>
    <hr class="w-header my-4">
    <p class="lead text-center text-muted pt-2 mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit ex facere quas possimus.</p>

    <div class="row">

      <!-- Grid column -->
      <div class="col-12 mb-4">

        <div class="card">
          <div class="card-body p-0">
            <!-- Chart -->
            <div class="view view-cascade gradient-card-header blue-gradient p-4 rounded">

              <canvas id="lineChart" height="175"></canvas>

            </div>
          </div>
        </div>
        
      </div>
      <!-- Grid column -->

    </div>

  </section>
  <!-- Section -->

</div>

<script>
// Main chart
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [{
      label: "My First dataset",
      fillColor: "#fff",
      backgroundColor: 'rgba(255, 255, 255, .3)',
      borderColor: 'rgba(255, 255, 255)',
      data: [0, 10, 5, 2, 20, 30, 45],
    }]
  },
  options: {
    legend: {
      labels: {
        fontColor: "#fff",
      }
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: true,
          color: "rgba(255,255,255,.25)"
        },
        ticks: {
          fontColor: "#fff",
        },
      }],
      yAxes: [{
        display: true,
        gridLines: {
          display: true,
          color: "rgba(255,255,255,.25)"
        },
        ticks: {
          fontColor: "#fff",
        },
      }],
    }
  }
});
</script>