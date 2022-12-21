<?php
$_SERVROOT = '../../../';
include $_SERVER['DOCUMENT_ROOT'].'/.htHidden/activity/VISIT.php';
new VisitorActivity();


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo CSS_VERSION;?>">
    <link rel="stylesheet" href="/login/assets/style.css?v=<?php echo CSS_VERSION; ?>">
    <title>Fastreed: Forgotten Password</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="/">FastReed <br> <span>authentication</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Check your mail box</span>
        <span class="messageAndErrors">Enter 6 digit OTP sent to you </span>
        <?php

        if (isset($_COOKIE['sucessStatus'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="success"> <span id="" >'.$_COOKIE['sucessStatus'].'</span></div>';
        }elseif (isset($_COOKIE['authStatus'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="Error"> <span id="" >'.$_COOKIE['authStatus'].'</span></div>';
        }
         ?>
      </div>
      <form class="loginElements loginForm" action="OTP-AUTH.php" method="post">
        <input class="fields" type="text" name="username" value="" placeholder="Enter 6 digit OTP">
        <input id="submit" type="submit" name="Submit" value="Verify">
      </form>
      <div class="others">
        <a>Resend OTP</a>
      </div>
    </div>
  </body>
</html>
