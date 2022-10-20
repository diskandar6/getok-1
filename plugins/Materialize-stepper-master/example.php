<!--Import Google Fonts-->
<link href="https://fonts.googleapis.com/css?family=Material+Icons|Roboto:300,400,500" rel="stylesheet">
<!--Import materialize.css-->
<!--link type="text/css" rel="stylesheet" href="/plugins/Materialize-stepper-master/docs/css/mstepper.min.css" media="screen,projection" /-->
<div class="container">

    <ul class="stepper demos" style="list-style-type: none;">
        <li class="step">
            <div data-step-label="Jurusan yang diambil" class="step-title waves-effect waves-dark">Pilih Jurusan</div>
            <div class="step-content">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="non_linear_email" name="non_linear_email" type="email" class="validate" required>
                        <label for="non_linear_email">Your e-mail</label>
                    </div>
                </div>
                <div class="step-actions">
                    <button class="waves-effect waves-dark btn blue next-step">CONTINUE</button>
                </div>
            </div>
        </li>
        <li class="step">
            <div class="step-title waves-effect waves-dark">Step 2</div>
            <div class="step-content">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="non_linear_password" name="non_linear_password" type="password" class="validate" required>
                        <label for="non_linear_password">Your password</label>
                    </div>
                </div>
                <div class="step-actions">
                    <button class="waves-effect waves-dark btn blue next-step">CONTINUE</button>
                    <button class="waves-effect waves-dark btn-flat previous-step">BACK</button>
                </div>
            </div>
        </li>
        <li class="step">
            <div class="step-title waves-effect waves-dark">Step 3</div>
            <div class="step-content">
                    Finish!
                <div class="step-actions">
                    <button class="waves-effect waves-dark btn blue" type="submit">SUBMIT</button>
                </div>
            </div>
        </li>
    </ul>

</div>


<script src="/plugins/Materialize-stepper-master/docs/js/mstepper.js"></script>
<script>

   var domSteppers = document.querySelectorAll('.stepper.demos');
   for (var i = 0, len = domSteppers.length; i < len; i++) {
      var domStepper = domSteppers[i];
      new MStepper(domStepper);
   }

   function someFunction(destroyFeedback) {
      setTimeout(function () {
         destroyFeedback(true);
      }, 1000);
   }
</script>
   
