<?php
$_SERVROOT = "../../../";
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo getenv('cssVersion'); ?>">
    <link rel="stylesheet" href="assets/style.css?v=<?php echo getenv('cssVersion'); ?>">
    <title>Fastreed: User Regsitration</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="/">FastReed <span>register</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Create a new account</span>
        <span class="messageAndErrors">All fields required</span>
      </div>
      <form class="loginElements loginForm" action="" method="post">
        <input class="fields" type="text" name="username" value="" placeholder="Username">
        <input class="fields" type="email" name="username" value="" placeholder="Email">
        <div class="spPassword">
          <input id="newPassword" class="fields" type="password" name="password" value="" placeholder="Password">
          <img id="eyeClosed" style="display:block;" onclick="openEye()"  src="/assets/svgs/eye_closed.svg" alt="">
          <img id="eyeOpened" style="display:none;"  onclick="openEye()"  src="/assets/svgs/eye_show.svg" alt="">
        </div>
        <input id="submit" class="submit" type="submit" name="Submit" value="Register">
        <div class="loginElements additional">
          <p id="acceptTC" >By clicking register, you agree to our <a href="#">Terms of Service</a> and that you read our <a href="#">Privacy Policy</a> </p>
        </div>
      </form>
      <div class="others">
        <a href="/login">Login Here</a>
      </div>
    </div>
    <script src="/assets/js/register.js" charset="utf-8"></script>
  </body>
</html>
