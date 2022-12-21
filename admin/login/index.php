<?php
$_SERVROOT = '../../../../';
include $_SERVER['DOCUMENT_ROOT'].'/.htHidden/activity/VISIT.php';
new VisitorActivity();

include 'assets/authAdmin.php';

//
// $validateAdmin = new validateAdmin();
// if ($validateAdmin->adminLoginStatus()) {
//   header("Location: /admin/index.php");
// }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo CSS_VERSION; ?>">
    <link rel="stylesheet" href="assets/login.css?v=<?php echo CSS_VERSION; ?>">
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
        <?php  ?>
        <?php

        if (isset($_COOKIE['inviteCodeError'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="errors"> <span id="" >'.$_COOKIE['inviteCodeError'].'</span></div>';
        }

        if (isset($_COOKIE['authStatus'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="errors"> <span id="" >'.$_COOKIE['authStatus'].'</span></div>';
        }

        if (DID_DISABLED) {
          if (isset($_COOKIE['inviteIdFound'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="success"> <span id="" >'.$_COOKIE['inviteIdFound'].'</span></div>';
          }
        }

        if (isset($_COOKIE['DID'])) {
          if (isset($GLOBALS['inviteIdFound'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="success"> <span id="" >'.$GLOBALS['inviteIdFound'].'</span></div>';
          }
        }
         ?>
      </div>
      <?php
      $validAdmin = new AuthenticateAdmin();
      $validAdmin->loginAdminAuthenticate();
      if ($validAdmin->VALID_ADMIN) {
        echo <<<GFG
        <form class="loginElements loginForm" action="validate-admin.php" method="post">
          <span id="USB" ></span>
          <input  onkeyup="checkUsername()" id="username" class="fields" type="text" name="usernameOrEMail" value="" placeholder="Username/Email/Phone" required>
          <span id="PSB" ></span>
          <input onkeyup="checkPassword()" id="password"  class="fields" type="password" name="password" value="" placeholder="Password" required>
          <div class="g-recaptcha" data-callback='onSubmit' data-sitekey="6LfHsUkjAAAAAI7vWP697QK0n8EMTwY1OqZSk1wC"></div>
          <br>
          <input id="submit" class="submit"  type="submit" name="Submit" value="Login">
        </form>
       GFG;
      }
       ?>



      <div class="others">
        <a href="/login">User Login</a>
      </div>
    </div>
    <script src="assets/login.js?v=<?php echo CSS_VERSION; ?>" charset="utf-8"></script>
  </body>
</html>
