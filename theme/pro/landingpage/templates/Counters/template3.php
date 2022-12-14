<div class="container my-5">


  <!--Section: Content-->
  <section class="p-5 z-depth-1">
    
    <h3 class="text-center font-weight-bold mb-5">Counter</h3>

    <div class="row d-flex justify-content-center">

      <div class="col-md-6 col-lg-3 mb-4 text-center">
        <h4 class="h1 font-weight-normal mb-3">
          <i class="fas fa-file-alt indigo-text"></i>
          <span class="d-inline-block count-up" data-from="0" data-to="100" data-time="2000">100</span>
        </h4>
        <p class="font-weight-normal text-muted">Unique Page</p>
      </div>

      <div class="col-md-6 col-lg-3 mb-4 text-center">
        <h4 class="h1 font-weight-normal mb-3">
          <i class="fas fa-layer-group indigo-text"></i>
          <span class="d-inline-block count1" data-from="0" data-to="250" data-time="2000">250</span>
        </h4>
        <p class="font-weight-normal text-muted">Block Variety</p>
      </div>

      <div class="col-md-6 col-lg-3 mb-4 text-center">
        <h4 class="h1 font-weight-normal mb-3">
          <i class="fas fa-pencil-ruler indigo-text"></i>
          <span class="d-inline-block count2" data-from="0" data-to="330" data-time="2000">330</span>
        </h4>
        <p class="font-weight-normal text-muted">Reusable Component</p>
      </div>
      
      <div class="col-md-6 col-lg-3 mb-4 text-center">
        <h4 class="h1 font-weight-normal mb-3">
          <i class="fab fa-react indigo-text"></i>
          <span class="d-inline-block count3" data-from="0" data-to="430" data-time="2000">430</span>
        </h4>
        <p class="font-weight-normal text-muted">Crafted Element</p>
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
  $('.count3').counter();
  
  new WOW().init();
  
  setTimeout(function () {
    $('.count5').counter();
  }, 3000);
});
</script>