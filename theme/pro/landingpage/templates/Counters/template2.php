<div class="container my-5 z-depth-1 px-0 rounded">


  <!--Section: Content-->
  <section class="white-text grey p-5 rounded">
    
    <h3 class="text-center font-weight-bold mb-4 pb-2">Counter</h3>

    <div class="row">

      <div class="col-md-4 mb-4">
        <div class="row">
          <div class="col-6 pr-0">
            <h4 class="display-4 text-right mb-0 count-up" data-from="0" data-to="42" data-time="2000">42</h4>
          </div>

          <div class="col-6">
            <p class="text-uppercase font-weight-normal mb-1">Projects</p>
            <p class="mb-0"><i class="fas fa-briefcase fa-2x mb-0"></i></p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="row">
          <div class="col-6 pr-0">
            <h4 class="display-4 text-right mb-0 count1" data-from="0" data-to="3500" data-time="2000">3,500</h4>
          </div>

          <div class="col-6">
            <p class="text-uppercase font-weight-normal mb-1">Customers</p>
            <p class="mb-0"><i class="fas fa-user fa-2x mb-0"></i></p>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-4">
        <div class="row">
          <div class="col-6 pr-0">
            <h4 class="display-4 text-right"><span class="d-flex justify-content-end"><span class="count2" data-from="0" data-to="100" data-time="2000">0</span> %</span></h4>
          </div>

          <div class="col-6">
            <p class="text-uppercase font-weight-normal mb-1">Satisfaction</p>
            <p class="mb-0"><i class="fas fa-smile fa-2x mb-0"></i></p>
          </div>
        </div>
      </div>

    </div>

  </section>
  <!--Section: Content-->


</div>

<script>
(function ($){
  $.fn.counter = function() {
    const $this = $(this),
    numberFrom = parseInt($this.attr('data-from')),
    numberTo = parseInt($this.attr('data-to')),
    delta = numberTo - numberFrom,
    deltaPositive = delta > 0 ? 1 : 0,
    time = parseInt($this.attr('data-time')),
    changeTime = 10;
    
    let currentNumber = numberFrom,
    value = delta*changeTime/time;
    var interval1;
    const changeNumber = () => {
      currentNumber += value;
      //checks if currentNumber reached numberTo
      (deltaPositive && currentNumber >= numberTo) || (!deltaPositive &&currentNumber<= numberTo) ? currentNumber=numberTo : currentNumber;
      this.text(parseInt(currentNumber));
      currentNumber == numberTo ? clearInterval(interval1) : currentNumber;  
    }

    interval1 = setInterval(changeNumber,changeTime);
  }
}(jQuery));

$(document).ready(function(){

  $('.count-up').counter();
  $('.count1').counter();
  $('.count2').counter();
  
  new WOW().init();
  
  setTimeout(function () {
    $('.count5').counter();
  }, 3000);
});
</script>