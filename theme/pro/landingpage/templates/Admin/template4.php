<div class="container my-5 py-5">


  <!--Section: Block Content-->
  <section>

    <div class="card" style="background-color: #181C30;">
      <div class="card-body">

        <canvas id="lineChart" class="mb-4" height="100"></canvas>

        <!--Grid row-->
        <div class="row text-center text-white">

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

            <p class="text-grey mb-1"><i class="fas fa-caret-left mr-2"></i>0%</p>
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
    var ctxL = document.getElementById("lineChart").getContext('2d');
    var gradientFill = ctxL.createLinearGradient(0, 0, 0, 290);
    gradientFill.addColorStop(0, "rgba(0, 125, 250, 1)");
    gradientFill.addColorStop(1, "rgba(0, 125, 250, 0.1)");
    var myLineChart = new Chart(ctxL, {
      type: 'line',
      data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
          {
            label: "My First dataset",
            data: [0, 65, 45, 65, 35, 65, 0],
            backgroundColor: gradientFill,
            borderColor: [
              '#007DFA',
            ],
            borderWidth: 2,
            pointBorderColor: "#007DFA",
            pointBackgroundColor: "rgba(0, 125, 250, 1)",
          }
        ]
      },
      options: {
        responsive: true
      }
    });
</script>