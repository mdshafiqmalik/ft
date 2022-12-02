<?php
  $_DOCROOT = '../../../';
$domain = $_SERVER['DOCUMENT_ROOT'];
include $domain.'/.htHidden/activity/checkVisitorType.php';
if (isset($_GET['inviteCode'])) {
  if (!empty($_GET['inviteCode'])) {
    if (validateInviteCOde($_GET['inviteCode'])) {
      setcookie("DID",$_GET["inviteCode"], time()+3600, '/');
      $GLOBALS['message'] = "Admin Invitation Found";
    }
  }else {
    $_SESSION['inviteCodeError'] = "Empty invite code found";
    header("Location: unauthorized.php");
  }
}elseif (isset($_COOKIE['DID'])) {
  if (!empty($_COOKIE['DID'])) {
    if (validateInviteCOde($_COOKIE['DID'])) {
      $GLOBALS['message'] = "Registered Device Found";
    }
  }else {
    $_SESSION['inviteCodeError'] = "Empty device ID found";
    header("Location: unauthorized.php");
  }
}else {
    header("Location: unauthorized.php");
}

function validateInviteCOde($i){
  include($GLOBALS['encDec']);
  include($GLOBALS['dbc']);
  $decryptID = openssl_decrypt($i, $ciphering,$encryption_key, $options, $encryption_iv);
  $sql = "SELECT deviceID FROM deviceManager WHERE deviceID = '$decryptID'";
  $result = mysqli_query($db, $sql);
  if ($result) {
    if ((boolean) mysqli_num_rows($result)) {
      $validCode = true;
    }else {
      $validCode = false;
      $_SESSION['inviteCodeError'] = "Invalid Invite Code or Invalid device ID  ";
    }
  }else {
    $validCode = false;
    $_SESSION['inviteCodeError'] = "There is an error at our end";
  }
  return $validCode;
}
 ?>

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
        <?php

        if (isset($_SESSION['authStatus'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="errors"> <span id="" >'.$_SESSION['authStatus'].'</span></div>';
        }

        if (isset($_COOKIE['DID'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="success"> <span id="" >'.$GLOBALS['message'].'</span></div>';
        }
         ?>
      </div>
      <form class="loginElements loginForm" action="auth.php" method="post">
        <span id="USB" ></span>
        <input  onkeyup="checkUsername()" id="username" class="fields" type="text" name="usernameOrEMail" value="" placeholder="Username/Email/Phone" required>
        <span id="PSB" ></span>
        <input onkeyup="checkPassword()" id="password"  class="fields" type="password" name="password" value="" placeholder="Password" required>
        <div class="g-recaptcha" data-callback='onSubmit' data-sitekey="6LfHsUkjAAAAAI7vWP697QK0n8EMTwY1OqZSk1wC"></div>
        <br>
        <input id="submit" class="submit"  type="submit" name="Submit" value="Login">
      </form>
      <div class="others">
        <a href="/login">User Login</a>
      </div>
    </div>
    <script src="assets/login.js?v=<?php echo getenv('cssVersion'); ?>" charset="utf-8"></script>
  </body>
</html>
