<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <link rel="stylesheet" href="/login/assets/style.css?v=<?php echo getenv('cssVersion'); ?>">
    <title>Fastreed: Forgotten Password</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="/">FastReed <br> <span>Password Reset</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Enter Username or Email</span>
        <span class="messageAndErrors">to reset your password</span>
      </div>
      <form class="loginElements loginForm" action="otp-auth.php" method="post">
        <input class="fields" type="text" name="username" value="" placeholder="Username/Email/Phone">
        <input id="submit" type="submit" name="Submit" value="Send OTP">
      </form>
      <div class="others">
        <a href="/login">Login Here</a>
        <a id="registerNow" href="/register">Register Now</a>
      </div>
    </div>
  </body>
</html>
