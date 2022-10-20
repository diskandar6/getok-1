<style>
body {
  background-color: #eee;
}
</style>
 <div class="container my-5 py-5">


    <!--Section: Block Content-->
    <section>

      <div class="card">
        <div class="card-body">

          <h5 class="text-center font-weight-bold mb-4">Number of browser users</h5>

          <hr>

          <!--Grid row-->
          <div class="row">

            <!--Grid column-->
            <div class="col-md-7 mb-4">

              <canvas id="pieChart" class="mt-4"></canvas>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-5 mb-4">

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Browser</th>
                    <th scope="col">Users</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Chrome</td>
                    <td id="cell-chrome"></td>
                  </tr>
                  <tr>
                    <td>FireFox</td>
                    <td id="cell-firefox"></td>
                  </tr>
                  <tr>
                    <td>Opera</td>
                    <td id="cell-opera"></td>
                  </tr>
                  <tr>
                    <td>Safari</td>
                    <td id="cell-safari"></td>
                  </tr>
                  <tr>
                    <td>Edge</td>
                    <td id="cell-edge"></td>
                  </tr>
                </tbody>
              </table>

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
    // Data
    const usersChrome = 243;
    const usersFirefox = 70;
    const usersOpera = 100;
    const usersSafari = 60;
    const usersEdge = 120;

    //pie
    var ctxP = document.getElementById("pieChart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
      type: 'pie',
      data: {
        labels: ["Chrome", "FireFox", "Opera", "Safari", "Edge"],
        datasets: [{
          data: [usersChrome, usersFirefox, usersOpera, usersSafari, usersEdge],
          backgroundColor: ["#9c27b0", "#ad1457", "#0277bd", "#303f9f ", "#009688"],
          hoverBackgroundColor: ["#a34cb3", "#a85076", "#679bb9", "#6d74a1", "#28a89b"],
          borderWidth: 4,
          borderColor: '#eee'
        }]
      },
      options: {
        responsive: true,
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            boxWidth: 10
          }
        },
        plugins: {
          datalabels: {
            formatter: (value, ctx) => {
              let sum = 0;
              let dataArr = ctx.chart.data.datasets[0].data;
              dataArr.map(data => {
                sum += data;
              });
              let percentage = (value * 100 / sum).toFixed(2) + "%";
              return percentage;
            },
            color: 'white',
            labels: {
              title: {
                font: {
                  size: '10'
                }
              }
            }
          }
        },
        tooltips: {
          callbacks: {
            label: function (tooltipItem, data) {
              return data.labels[tooltipItem.index] + ' users ' + ': ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            }
          }
        }
      }
    });

    // Table
    document.getElementById("cell-chrome").innerHTML = usersChrome;
    document.getElementById("cell-firefox").innerHTML = usersFirefox;
    document.getElementById("cell-opera").innerHTML = usersOpera;
    document.getElementById("cell-safari").innerHTML = usersSafari;
    document.getElementById("cell-edge").innerHTML = usersEdge;

  </script>