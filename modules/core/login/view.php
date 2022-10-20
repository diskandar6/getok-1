<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <title>Login Page | <?=D_TITLE_PAGE?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style type="text/css">
    <?=file_get_contents(__DIR__.'/css/style.css')?>
    </style>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        //window.alert = function(){};
        var defaultCSS = document.getElementById('bootstrap-css');
        function changeCSS(css){
            if(css) $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="'+ css +'" type="text/css" />'); 
            else $('head > link').filter(':first').replaceWith(defaultCSS); 
        }
    </script>
</head>
<body>
    <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <img src="/assets/img/Deafult-Profile.png" id="icon" alt="User Icon" />
    </div>
    <?=e_()?>
    <!-- Login Form -->
    <form method="post" action="/<?=D_PAGE?>">
        <?=token()?>
      <input type="text" id="login" class="fadeIn second" name="username" placeholder="Username/Email">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
      <input type="submit" class="fadeIn fourth" value="Log In">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
        <p>Don't have an Account? <a class="underlineHover" href="/registration">Register</a></p>
      <a class="underlineHover" href="/forgot">Forgot Password?</a>
    </div>
  </div>
</div>
</body>
</html>
