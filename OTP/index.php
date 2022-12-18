<?php
$_SERVROOT = '../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';

if (isset($_SESSION['sno']) && !empty($_SESSION['sno'])) {
  $sessionSNo = $_SESSION['sno'];
  $OTPPurpose = $_SESSION['OTPPurpose'];
  include($dbc);
  $getUniqueID = "SELECT * FROM OTP WHERE sno = '$sessionSNo' AND otpPurpose = '$OTPPurpose'";
  $result4 = mysqli_query($db, $getUniqueID);
  if (mysqli_num_rows($result4)) {
    if ($OTPPurpose == 'NR') {
      include 'NR-mail.php';
      $row = mysqli_fetch_assoc($result4);
      $sessionID = 
      sendOTP();
    }elseif ($OTPPurpose == 'PR') {
      echo " ";
    }
  }else {
    header("Location: /register");
    setcookie("authStatus","Cannot send OTP", time()+10, '/');
  }
}else {
  header("Location: /register");
  setcookie("authStatus","Cannot send OTP", time()+10, '/');
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/login.css?v=<?php echo $cssVersion; ?>">
    <link rel="stylesheet" href="/login/assets/style.css?v=<?php echo $cssVersion; ?>">
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
