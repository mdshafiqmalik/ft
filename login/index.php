<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <link rel="stylesheet" href="assets/style.css?v=<?php echo getenv('cssVersion'); ?>">
    <title>Fastreed: User Login</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="/">FastReed <span>login</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Hello! let's get started</span>
        <span class="messageAndErrors">Sign In to continue</span>
      </div>
      <form class="loginElements loginForm" action="" method="post">
        <input class="fields" type="text" name="username" value="" placeholder="Username/Email/Phone">
        <input class="fields" type="current-password" name="current-password" value="" placeholder="Password">
        <div class="loginElements forgotPassword">
          <input type="checkbox" name="" value="">
          <p>Remember this device</p>
        </div>
        <input id="submit" type="submit" name="Submit" value="Login">
      </form>
      <div class="others">
        <a href="/register">Register Now</a>
      </div>
    </div>
  </body>
</html>
