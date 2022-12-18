<?php
$_SERVROOT = '../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';

if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
  $sessionEmail = $_SESSION['email'];
  $OTPPurpose = $_SESSION['OTPPurpose'];
  include($GLOBALS['dbc']);
  $getUniqueID = "SELECT * FROM OTP WHERE userEmail = '$sessionEmail' AND otpPurpose = '$OTPPurpose'";
  $result4 = mysqli_query($db, $getUniqueID);
  if (mysqli_num_rows($result4)) {
    // get OTP
    $row = mysqli_fetch_assoc($result4);
    $OTPSENT = $row['OTP'];
    if ($OTPPurpose == 'NR') {
      // If OTP sent by new registration
      // get user_register details
      $getUserRegisterDetSql = "SELECT * FROM users_register WHERE userEmail = '$sessionEmail'";
      $result = mysqli_query($db, $getUserRegisterDetSql);
      $row = mysqli_fetch_assoc($result);
      $userName = $row['userName'];
      // Sent otp and get timestamp
      include 'NR-mail.php';
      if ($timestamp = sendOTP($sessionEmail, $OTPSENT, $userName)) {
       header("Location: /OTP/index.php");
        setcookie("sucessStatus","OTP sent with timestamp ($timestamp)", time()+10, '/');
      }else {
       header("Location: /register");
        setcookie("authStatus","Cannot send OTP", time()+10, '/');
      }
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
