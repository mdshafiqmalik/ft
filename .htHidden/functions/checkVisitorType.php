<?php
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
$domain = $_SERVER['DOCUMENT_ROOT'];
$GLOBALS['dbc'] = $domain.'/.htHidden/s_keys/db.php';
$GLOBALS['encDec'] = $domain.'/.htHidden/s_keys/encDec.php';
$GLOBALS['IDcreator'] = $domain.'/.htHidden/functions/IDCreator.php';
$GLOBALS['IPDEV'] = $domain.'/.htHidden/functions/Ip&Device.php';
if (isset($_COOKIE['userID'])) {
  if (!empty($_COOKIE['userID'])) {
    include 'userVisits.php';
  }else {
    // No Cookie value Mean an anonymous user
    include 'guestsVisits.php';
  }
}elseif (isset($_COOKIE['adminID'])) {
  if (!empty($_COOKIE['adminID'])) {
    include 'adminVisits.php';
  }else {
    // No Cookie value Mean an anonymous user
    include 'guestsVisits.php';
  }
}else {
  // No Cookie Mean an anonymous user
  include 'guestsVisits.php';
}
 ?>
