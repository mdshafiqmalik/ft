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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Fastreed: User Regsitration</title>
  </head>
  <body>
    <div class="loginOuterDiv">
      <div class="loginElements brandLogo">
        <a href="/">FastReed <span>register</span> </a>
      </div>
      <div class="loginElements headingsAndErrors">
        <span class="greetHeading">Create a new account</span>
        <span class="messageAndErrors">(*) All fields required</span>
        <?php

        if (isset($_SESSION['authStatus'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="errors"> <span id="" >'.$_SESSION['authStatus'].'</span></div>';
        }
         ?>
      </div>
      <form class="loginElements loginForm" action="validate.php" method="post">
        <span id="USB" ></span>
        <input onkeyup="checkUsername()" id="username" class="fields" type="text" name="username" placeholder="Username* i.e. RAKESH, jhon_doe" required>
        <span id="ESB" ></span>
        <input onkeyup="checkEmail()" id="email" class="fields" type="email" name="emailAddress" value="" placeholder="Email* i.e. name@domain.com" required>
        <span id="PSB" ></span>
        <div class="spPassword" id="spPassword">
          <input id="newPassword" onkeyup="checkPassword()" class="fields" type="password" name="userPassword" value="" placeholder="Password* (Min. 8 Chars)" required>
          <img id="eyeClosed" style="display:block;" onclick="openEye()"  src="/assets/svgs/eye_closed.svg" alt="">
          <img id="eyeOpened" style="display:none;"  onclick="openEye()"  src="/assets/svgs/eye_show.svg" alt="">
        </div>
          <!-- <select id="Gender" class="selection" name="Gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Others">Others</option>
          </select>
        <input onkeyup="" id="inviteID" class="fields" type="text" name="inviteID" placeholder="Invite ID (Optional)"> -->
        <div class="g-recaptcha" data-callback='onSubmit' data-sitekey="6LfHsUkjAAAAAI7vWP697QK0n8EMTwY1OqZSk1wC"></div>
        <br>
        <input id="submit" class="submit" type="submit" name="Submit" value="Register">
        <div class="loginElements additional">
          <p id="acceptTC" >By clicking register, you agree to our <a href="#">Terms of Service</a> and that you read our <a href="#">Privacy Policy</a> </p>
        </div>
      </form>
      <div class="others">
        <a href="/login">Login Here</a>
      </div>
    </div>
      <script src="/assets/js/jquery-3.6.0.js" charset="utf-8"></script>
    <script src="assets/register.js?v=<?php echo getenv('cssVersion');?>" charset="utf-8"></script>

  </body>
</html>
