<?php
$_SERVROOT = '../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/VISIT.php';
new VisitorActivity();

if (isset($_SESSION['adminLoginStatus']) && !empty($_SESSION['adminLoginStatus']) && $_SESSION['adminLoginStatus']) {
  include($GLOBALS['encDec']);
  include($GLOBALS['dbc']);
  $dateAndTime = date('Y-m-d h-i-s');

  $decryptID = openssl_decrypt($_COOKIE['DID'], $ciphering,$encryption_key, $options, $encryption_iv);
  $sql = "UPDATE deviceManager SET LogoutDateTime='$dateAndTime' WHERE deviceID='$decryptID'";
  mysqli_query($db, $sql);
  unset($_SESSION['adminLoginStatus']);
  $_SESSION['message'] = "Sucessfully Logged Out...";
  header("Location: /admin/login/index.php");
}else {
  header("Location: /admin/index.php");
  $_SESSION['inviteCodeError'] = "Cannot Logout without Login...";
}

 ?>
