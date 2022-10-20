<div class="container my-5 pt-5 pb-3 px-md-5 z-depth-1">


  <!--Section: Content-->
  <section class="dark-grey-text">

    <h3 class="text-center font-weight-bold mb-4 pb-2">Counter</h3>
    
    <h3 class="mb-3">Attributes</h3>
    
    <ul class="mb-4">
      <li>data-from : to change starting point</li>
      <li>data-to : to change ending point</li>
      <li>data-time : to change how long transition takes</li>
    </ul>

    <div class="count-up h1 text-center mb-4" data-from="10" data-to="20000" data-time="1000">
    	0
    </div>
    
    <h3 class="mb-3">
    	How long did you develop it? <span class="count1" data-from="0" data-to="5" data-time="2000">0</span> hours
    </h3>

  	<div>
    	Was it worth it? <span class="style"><span class="count2" data-from="0" data-to="100" data-time="1000">0</span> %</span>
    </div>

  	<div>
    	This many ppl trusted I can deliver it in one day <span class="count3 style" data-from="30" data-to="-30" data-time="5000"></span>
    </div>

  	<div class="pb-4">
    	It works with huge numbers too :O <span class="count4 style" data-from="-10000" data-to="10000" data-time="3000"></span>
  	</div>

  	<h3 class="my-4 block text-center">↓ Check this out ↓</h3>

  	<div class="mb-4">
    	You can animate it! <span class="pl-5 style last wow animated bounceIn delay-3s"><span class="count5" data-from="0" data-to="100" data-time="2000">0</span> %</span>
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
  $('.count4').counter();
  
  new WOW().init();
  
  setTimeout(function () {
    $('.count5').counter();
  }, 3000);
});
</script>