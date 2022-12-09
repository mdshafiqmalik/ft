<?php
$_SERVROOT = '../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';
 ?>
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
        <span class="greetHeading">Check your mail box</span>
        <span class="messageAndErrors">Enter 6 digit OTP sent to you </span>
      </div>
      <form class="loginElements loginForm" action="create-password.php" method="post">
        <input class="fields" type="text" name="username" value="" placeholder="Enter 6 digit OTP">
        <input id="submit" type="submit" name="Submit" value="Verify">
      </form>
      <div class="others">
        <a>Resend OTP</a>
      </div>
    </div>
  </body>
</html>
