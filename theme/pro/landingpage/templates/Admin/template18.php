<div class="container my-5">

  <!-- Section: Block Content -->
  <section>

    <div class="card card-list">
      <div class="card-header white d-flex justify-content-between align-items-center py-3">
        <p class="h5-responsive font-weight-bold mb-0"><i class="fas fa-inbox pr-2"></i>Sales</p>
        <p class="h5-responsive font-weight-bold mb-0"><a><i class="fas fa-times"></i></a></p>
      </div>
      <div class="card-body">
        <canvas id="lineChart"></canvas>
      </div>
    </div>

  </section>
  <!-- Section: Block Content -->

</div>

<script>
//line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
    datasets: [
       {
        label: "My Second dataset",
        data: [28, 38, 55, 45, 55, 80, 65, 54],
        backgroundColor: [
          'rgb(206, 224, 229)',
        ],
        borderColor: [
          'rgb(124, 154, 163)',
        ],
        borderWidth: 2
      },
      {
        label: "My First dataset",
        data: [38, 48, 60, 55, 65, 85, 75, 68],
        backgroundColor: [
          'rgb(30, 134, 219)',
        ],
        borderColor: [
          'rgb(29, 84, 147)',
        ],
        borderWidth: 2
      }
    ]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          color: "transparent",
          zeroLineColor: "transparent"
        },
      }],
      yAxes: [{
        display: true,
        gridLines: {
          display: true,
        },
      }],
    }
  }
});
</script>