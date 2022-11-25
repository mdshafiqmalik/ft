<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <link rel="stylesheet" href="assets/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Fastreed: Admin Login</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="/">FastReed <span>admin</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Hello! let's get started</span>
        <span class="messageAndErrors">Sign In to continue</span>
      </div>
      <form class="loginElements loginForm" action="auth.php" method="post">
        <input class="fields" type="text" name="username" value="" placeholder="Username/Email/Phone">
        <input class="fields" type="password" name="password" value="" placeholder="Password">
        <div class="loginElements additional">
          <input type="checkbox" name="" value="">
          <p>Remember this device</p>
        </div>
        <div class="g-recaptcha captcha" data-sitekey="6LcFdOMbAAAAAHQ3kaP4oBuyYnh2KRnYXR6CcrnP"></div>
        <input id="submit" class="submit" type="submit" name="Submit" value="Login">
      </form>
      <div class="others">
        <a href="/login">User Login</a>
      </div>
    </div>
  </body>
</html>
