<?php

$cssVersion = "2.9.5";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SERVROOT)) {
  $_SERVROOT = '../../';
}
date_default_timezone_set("asia/kolkata");
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
$GLOBALS['dbc'] = $_SERVROOT.'htdocs/secrets/db.php';
$GLOBALS['encDec'] = $_SERVROOT.'htdocs/secrets/encDec.php';
$GLOBALS['IDcreator'] = $_DOCROOT.'/.htHidden/activity/createID.php';
$GLOBALS['IPDEV'] = $_DOCROOT.'/.htHidden/functions/Ip&Device.php';

if (isset($_COOKIE['UID'])) {
  if (!empty($_COOKIE['UID'])) {
    $userID = $_COOKIE['UID'];
    include($GLOBALS['encDec']);
    $encUserID = openssl_decrypt($userID, $ciphering,$encryption_key, $options, $encryption_iv);
    $authUser = checkAuthVisitor($encUserID, "users", "userID");
    if ($authUser) {
      include 'userVisits.php';
    }else {
      include 'guestsVisits.php';
    }
  }else {
    // No Cookie value Mean an anonymous user
    setcookie("UID",FALSE,time()-3600);
    include 'guestsVisits.php';
  }
}elseif (isset($_COOKIE['AID'])) {
  if (!empty($_COOKIE['AID'])) {
    $adminID = $_COOKIE['AID'];
    include($GLOBALS['encDec']);
    $encAdminID = openssl_decrypt($adminID, $ciphering,$encryption_key, $options, $encryption_iv);
    $authAdmin = checkAuthVisitor($encAdminID, "admins", "adminID");
    if ($authAdmin) {
      include 'adminVisits.php';
    }else {
      include 'guestsVisits.php';
    }
  }else {
    // No Cookie value Mean an anonymous user
    include 'guestsVisits.php';
  }
}else {
  // No Cookie Mean an anonymous user
  include 'guestsVisits.php';
}


function checkAuthVisitor($id, $table, $parameter){
  include($GLOBALS['dbc']);
  $sql = "SELECT $parameter FROM $table WHERE $parameter = '$id'";
  $result = mysqli_query($db, $sql);
  $row = mysqli_num_rows($result);
  if ($row) {
    $status = true;
  }else {
    $status = false;
  }
  return $status;
}
 ?>
