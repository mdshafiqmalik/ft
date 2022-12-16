<?php
  $_SERVROOT = '../../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';

if (isset($_SESSION['adminLoginStatus']) && !empty($_SESSION['adminLoginStatus']) && $_SESSION['adminLoginStatus']) {
      header("Location: /admin/index.php");
}


if (isset($_GET['inviteCode'])) {
  if (!empty($_GET['inviteCode'])) {
    if (validateInviteCode($_GET['inviteCode'])) {
      $GLOBALS['inviteIdFound'] = "Admin Invitation Found";
      setcookie("DID",$_GET["inviteCode"], time()+(86400*365), '/');
      setcookie("inviteCodeError","", time()-3600, '/');
    }else {
      setcookie("inviteCodeError","Invalid ID found", time()+1000, '/');
      unset($GLOBALS['inviteIdFound']);
    }
  }else {
    setcookie("inviteCodeError","Empty invitation ID", time()+1000, '/');
    unset($GLOBALS['inviteIdFound']);
  }
}elseif (isset($_COOKIE['DID'])) {
  if (!empty($_COOKIE['DID'])) {
    if (validateDID($_COOKIE['DID'])) {
      $GLOBALS['inviteIdFound'] = "Registered Device Found";
      setcookie("inviteCodeError","", time()-3600, '/');
    }else {
      setcookie("inviteCodeError","Invalid ID found", time()+1000, '/');
      unset($GLOBALS['inviteIdFound']);
    }
  }else {
    setcookie("inviteCodeError","Empty device ID found", time()+1000, '/');
    unset($GLOBALS['inviteIdFound']);
  }
}else {
    setcookie("inviteCodeError","No Invitation/ID found", time()+1000, '/');
    unset($GLOBALS['inviteIdFound']);
}

function validateInviteCode($i){
  include($GLOBALS['encDec']);
  include($GLOBALS['dbc']);
  $decryptID = openssl_decrypt($i, $ciphering,$encryption_key, $options, $encryption_iv);
  $sql = "SELECT deviceID, linkStatus FROM deviceManager WHERE deviceID = '$decryptID'";
  $result = mysqli_query($db, $sql);
  if ($row = $result->fetch_assoc()) {
    if ($row['deviceID'] = $decryptID) {
      if ((boolean)$row['linkStatus']) {
        $validCode = true;
      }else {
        $validCode = false;
      }
    }else {
      $validCode = false;
      setcookie("inviteCodeError","Invalid Invitation Code or device ID", time()+10, '/');
      unset($GLOBALS['inviteIdFound']);
    }
  }else {
    $validCode = false;
    setcookie("inviteCodeError","Invalid Invitation Code or device ID", time()+10, '/');
    unset($GLOBALS['inviteIdFound']);
  }
  return $validCode;
}

function validateDID($i){
  include($GLOBALS['encDec']);
  include($GLOBALS['dbc']);
  $decryptID = openssl_decrypt($i, $ciphering,$encryption_key, $options, $encryption_iv);
  $sql = "SELECT deviceID, deviceStatus FROM deviceManager WHERE deviceID = '$decryptID'";
  $result = mysqli_query($db, $sql);
  if ($row = $result->fetch_assoc()) {
    if ($row['deviceID'] == $decryptID) {
      if ((boolean)$row['deviceStatus']) {
        $validCode = true;
      }else {
        $validCode = false;
        setcookie("inviteCodeError","Device is blocked/banned", time()+10, '/');
        unset($GLOBALS['inviteIdFound']);
      }
    }else {
      $validCode = false;
      setcookie("inviteCodeError","Invalid Invitation Code or device ID", time()+10, '/');
      unset($GLOBALS['inviteIdFound']);

    }
  }else {
    $validCode = false;
    setcookie("inviteCodeError","Invalid Invitation Code or device ID", time()+10, '/');
    unset($GLOBALS['inviteIdFound']);
  }
  return $validCode;
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo $cssVersion; ?>">
    <link rel="stylesheet" href="assets/login.css?v=<?php echo $cssVersion; ?>">
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

        if (isset($_COOKIE['inviteCodeError'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="errors"> <span id="" >'.$_COOKIE['inviteCodeError'].'</span></div>';
        }

        if (isset($_COOKIE['authStatus'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="errors"> <span id="" >'.$_COOKIE['authStatus'].'</span></div>';
        }

        if (isset($_COOKIE['DID'])) {
          if (isset($GLOBALS['inviteIdFound'])) {
          echo '<div id="adminErros"  onclick="hideError()" class="success"> <span id="" >'.$GLOBALS['inviteIdFound'].'</span></div>';
          }

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
    <script src="assets/login.js?v=<?php echo $cssVersion; ?>" charset="utf-8"></script>
  </body>
</html>
