<div class="container my-5 py">


  <!--Section: Block Content-->
  <section>

    <div class="card indigo">
      <div class="card-body">

        <p class="h5 white-text pb-4 mb-3"><i class="fas fa-chart-pie px-2"></i>Sales Chart</p>

        <canvas id="lineChart1" class="mb-4" height="100"></canvas>

      </div>

      <div class="card-body white">

        <!--Grid row-->
        <div class="row text-center text-muted my-2">

            <!--Grid column-->
            <div class="col-md-4 mb-4 mb-md-0">

              <span class="min-chart mt-0 mb-3" id="chart-pageviews" data-percent="86">
                <span class="percent"></span>
              </span>
              <p class="small mb-md-0">Mail-Orders</p>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-4 mb-4 mb-md-0">

          		<span class="min-chart mt-0 mb-3" id="chart-sales" data-percent="54">
                <span class="percent"></span>
              </span>
              <p class="small mb-md-0">Online</p>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-4 mb-0">

            	<span class="min-chart mt-0 mb-3" id="chart-downloads" data-percent="72">
                <span class="percent"></span>
              </span>
              <p class="small mb-0">In-Store</p>

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
//line
var ctxL = document.getElementById("lineChart1").getContext('2d');
var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
    datasets: [{
      pointBackgroundColor: '#fff',
      backgroundColor: 'transparent',
      borderColor: 'rgba(255, 255, 255)',
      data: [2500, 2550, 5000, 3100, 7000, 5500, 4950, 16000, 10500, 8000],
    }]
  },
  options: {
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false,
          color: "transparent",
          zeroLineColor: "transparent"
        },
        ticks: {
          fontColor: "#fff",
        },
      }],
      yAxes: [{
        display: true,
        gridLines: {
          display: true,
          drawBorder: false,
          color: "rgba(255,255,255,.25)",
          zeroLineColor: "rgba(255,255,255,.25)"
        },
        ticks: {
          fontColor: "#fff",
          beginAtZero: true,
          stepSize: 5000
        },
      }],
    }
  }
});

// Minimalist charts
$(function () {
  $('.min-chart#chart-pageviews').easyPieChart({
    barColor: "#3059B0",
    onStep: function (from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });
  $('.min-chart#chart-downloads').easyPieChart({
    barColor: "#3059B0",
    onStep: function (from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });
  $('.min-chart#chart-sales').easyPieChart({
    barColor: "#3059B0",
    onStep: function (from, to, percent) {
      $(this.el).find('.percent').text(Math.round(percent));
    }
  });
});
</script>