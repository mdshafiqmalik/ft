<?php
// Could not recognize Device
// Any request made will be checked here
// Request Wih cookie
//     Returned Anonymous Visitor
//     Returend Auth User
//     An Admin with cookie build by him/her
// Request Without Cookie
//     Anonymous Visitor that can be
//        An Auth User
//        Admin
// If a person login
//    Anonymouscookie will be deleted from browser
//    and updated with userCookie
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_DOCROOT)) {
  $_DOCROOT = '../../';
}
date_default_timezone_set("asia/kolkata");
$domain = $_SERVER['DOCUMENT_ROOT'];
$GLOBALS['dbc'] = $_DOCROOT.'htdocs/secrets/db.php';
$GLOBALS['encDec'] =$_DOCROOT.'htdocs/secrets/encDec.php';
$GLOBALS['IDcreator'] = $domain.'/.htHidden/activity/createID.php';
$GLOBALS['IPDEV'] = $domain.'/.htHidden/functions/Ip&Device.php';

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
