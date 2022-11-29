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
session_start();
date_default_timezone_set("asia/kolkata");
$domain = $_SERVER['DOCUMENT_ROOT'];
$GLOBALS['dbc'] = $domain.'/.htHidden/s_keys/db.php';
$GLOBALS['encDec'] = $domain.'/.htHidden/s_keys/encDec.php';
$GLOBALS['IDcreator'] = $domain.'/.htHidden/activity/createID.php';
$GLOBALS['IPDEV'] = $domain.'/.htHidden/functions/Ip&Device.php';

if (isset($_COOKIE['UID'])) {
  if (!empty($_COOKIE['UID'])) {
    $userID = $_COOKIE['UID'];
    $authUser = checkAuthVisitor($userID, "users", "userID");
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
    $authAdmin = checkAuthVisitor($adminID, "admins", "adminID");
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
