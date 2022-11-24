<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo getenv('cssVersion'); ?>">
    <title>Fastreed: Admin Login</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="#">FastReed  </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Hello! let's get started</span>
        <span class="messageAndErrors">Sign In to continue</span>
      </div>
      <form class="loginElements loginForm" action="" method="post">
        <input type="text" name="username" value="" placeholder="Username">
        <input type="current-password" name="current-password" value="" placeholder="Password">
        <input class="submit" type="submit" name="Submit" value="Submit">

      </form>
      <div class="loginElements forgotPassword">
        <input type="checkbox" name="" value="">
        <p>Remember this device</p>
      </div>
      <div class="">

      </div>
    </div>
  </body>
</html>
