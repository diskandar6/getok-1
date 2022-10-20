<div class="container my-5">

  
  <!-- Section: Block Content -->
  <section>
    
    <div class="row">
      <div class="col-12">
      	<div class="card card-list">
          <div class="card-header white d-flex justify-content-between align-items-center py-3">
            <p class="h5-responsive font-weight-bold mb-0">Last Orders</p>
            <ul class="list-unstyled d-flex align-items-center mb-0">
              <li><i class="far fa-window-minimize fa-sm pl-3"></i></li>
              <li><i class="fas fa-times fa-sm pl-3"></i></li>
            </ul>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Order ID</th>
                  <th scope="col">Item</th>
                  <th scope="col">Status</th>
                  <th scope="col">Popularity</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row"><a class="text-primary">OR9842</a></th>
                  <td>Call of Duty IV</td>
                  <td><span class="badge badge-success">Shipped</span></td>
                  <td class="pt-2 pb-0"><canvas id="bar" width="40" height="40"></canvas></td>
                </tr>
                <tr>
                  <th scope="row"><a class="text-primary">OR1848</a></th>
                  <td>Samsung Smart TV</td>
                  <td><span class="badge badge-warning">Pending</span></td>
                  <td class="pt-2 pb-0"><canvas id="bar1" width="40" height="40"></canvas></td>
                </tr>
                <tr>
                  <th scope="row"><a class="text-primary">OR7429</a></th>
                  <td>iPhone 6 Plus</td>
                  <td><span class="badge badge-danger">Delivered</span></td>
                  <td class="pt-2 pb-0"><canvas id="bar2" width="40" height="40"></canvas></td>
                </tr>
                <tr>
                  <th scope="row"><a class="text-primary">OR7429</a></th>
                  <td>Samsung Smart TV</td>
                  <td><span class="badge badge-info">Processing</span></td>
                  <td class="pt-2 pb-0"><canvas id="bar3" width="40" height="40"></canvas></td>
                </tr>
                <tr>
                  <th scope="row"><a class="text-primary">OR1848</a></th>
                  <td>Samsung Smart TV</td>
                  <td><span class="badge badge-warning">Pending</span></td>
                  <td class="pt-2 pb-0"><canvas id="bar4" width="40" height="40"></canvas></td>
                </tr>
                <tr>
                  <th scope="row"><a class="text-primary">OR7429</a></th>
                  <td>iPhone 6 Plus</td>
                  <td><span class="badge badge-danger">Delivered</span></td>
                  <td class="pt-2 pb-0"><canvas id="bar5" width="40" height="40"></canvas></td>
                </tr>
                <tr>
                  <th scope="row"><a class="text-primary">OR9842</a></th>
                  <td>Call of Duty IV</td>
                  <td><span class="badge badge-success">Shipped</span></td>
                  <td class="pt-2 pb-0"><canvas id="bar6" width="40" height="40"></canvas></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer white py-3 d-flex justify-content-between">
            <button class="btn btn-primary btn-md px-3 my-0 mr-0">Place New Order</button>
            <button class="btn btn-light btn-md px-3 my-0 ml-0">View All Orders</button>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- Section: Block Content -->

  
</div>

<script>
new Chart(document.getElementById("bar"), {
  "type": "bar",
  "data": {
    "labels": ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey"],
    "datasets": [{
      "label": "My First Dataset",
      "data": [22, 33, 55, 32, 86, 23, 14],
      "fill": false,
      "backgroundColor": "#00c851",
      "borderWidth": 0
    }]
  },
  "options": {
    "responsive": false,
    "legend": {
      "display": false,
    },
    "scales": {
      "xAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
          "beginAtZero": true
        }
      }],
      "yAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
        }
      }],
    }
  }
});

new Chart(document.getElementById("bar1"), {
  "type": "bar",
  "data": {
    "labels": ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey"],
    "datasets": [{
      "label": "My First Dataset",
      "data": [20, 33, 45, 34, 71, 85, 54],
      "fill": false,
      "backgroundColor": "#fb3",
      "borderWidth": 0
    }]
  },
  "options": {
    "responsive": false,
    "legend": {
      "display": false,
    },
    "scales": {
      "xAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
          "beginAtZero": true
        }
      }],
      "yAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
        }
      }],
    }
  }
});

new Chart(document.getElementById("bar2"), {
  "type": "bar",
  "data": {
    "labels": ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey"],
    "datasets": [{
      "label": "My First Dataset",
      "data": [35, 21, 42, 59, 50, 62, 90],
      "fill": false,
      "backgroundColor": "#ff3547",
      "borderWidth": 0
    }]
  },
  "options": {
    "responsive": false,
    "legend": {
      "display": false,
    },
    "scales": {
      "xAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
          "beginAtZero": true
        }
      }],
      "yAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
        }
      }],
    }
  }
});

new Chart(document.getElementById("bar3"), {
  "type": "bar",
  "data": {
    "labels": ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey"],
    "datasets": [{
      "label": "My First Dataset",
      "data": [22, 33, 55, 32, 86, 23, 14],
      "fill": false,
      "backgroundColor": "#33b5e5",
      "borderWidth": 0
    }]
  },
  "options": {
    "responsive": false,
    "legend": {
      "display": false,
    },
    "scales": {
      "xAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
          "beginAtZero": true
        }
      }],
      "yAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
        }
      }],
    }
  }
});

new Chart(document.getElementById("bar4"), {
  "type": "bar",
  "data": {
    "labels": ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey"],
    "datasets": [{
      "label": "My First Dataset",
      "data": [20, 33, 45, 34, 71, 54, 44],
      "fill": false,
      "backgroundColor": "#fb3",
      "borderWidth": 0
    }]
  },
  "options": {
    "responsive": false,
    "legend": {
      "display": false,
    },
    "scales": {
      "xAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
          "beginAtZero": true
        }
      }],
      "yAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
        }
      }],
    }
  }
});

new Chart(document.getElementById("bar5"), {
  "type": "bar",
  "data": {
    "labels": ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey"],
    "datasets": [{
      "label": "My First Dataset",
      "data": [60, 21, 72, 65, 50, 40, 35],
      "fill": false,
      "backgroundColor": "#ff3547",
      "borderWidth": 0
    }]
  },
  "options": {
    "responsive": false,
    "legend": {
      "display": false,
    },
    "scales": {
      "xAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
          "beginAtZero": true
        }
      }],
      "yAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
        }
      }],
    }
  }
});

new Chart(document.getElementById("bar6"), {
  "type": "bar",
  "data": {
    "labels": ["Red", "Orange", "Yellow", "Green", "Blue", "Purple", "Grey"],
    "datasets": [{
      "label": "My First Dataset",
      "data": [21, 59, 90, 35, 50, 42, 62],
      "fill": false,
      "backgroundColor": "#00c851",
      "borderWidth": 0
    }]
  },
  "options": {
    "responsive": false,
    "legend": {
      "display": false,
    },
    "scales": {
      "xAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
          "beginAtZero": true
        }
      }],
      "yAxes": [{
        "gridLines": {
          "display": false,
          "drawBorder": false,
        },
        "ticks": {
          "display": false,
        }
      }],
    }
  }
});
</script>