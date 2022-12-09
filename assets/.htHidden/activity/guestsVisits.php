<?php
// TOP
guestVisited();
function guestVisited(){
  // Authenticate with Cookie
    $cookie =  checkCookie();
    if ($cookie['bool']) { // if user Exist
      $guestID['id'] = $cookie['id'];
      // check if the session is same or different
      if (sessionExist()["bool"]) {
        $sessionID = sessionExist()["id"];
        updateVisits($sessionID);
      }else {
        makeSession($guestID['id']);
      }
    }else {
      addNewVisitor();
    }
}
function addNewVisitor(){
  include($GLOBALS['dbc']);
  include($GLOBALS['IDcreator']);
  include($GLOBALS['encDec']);
  include($GLOBALS['IPDEV']);
  $ipAddress = getIp();
  $userDevice = get_browser(null, true);
  $browserInfo = serialize($userDevice);
  $deviceType = $userDevice['device_type'];
  $platform= $userDevice['platform'];
  $browser = $userDevice['browser'];
  $dateTime = time();
  $date = date('Y-m-d');
  $guestID =  createNewID("guests");
  $guestID = 'GID'.$guestID;
  $encryptedID = openssl_encrypt($guestID, $ciphering,$encryption_key, $options, $encryption_iv);
  // Set cookie
  $cookieSet = setcookie('GID', $encryptedID, time() + (86400 * 30), "/");
  // Add to visiter data to DB
  $sql = "INSERT INTO guests ( tdate, guestID, guestDevice, guestBrowser, guestPlatform, browserInfo ) VALUES ('$date','$guestID','$deviceType', '$browser', '$platform','$browserInfo')";
  mysqli_query($db, $sql);
  makeSession($guestID);
}
function checkCookie(){
  include($GLOBALS['encDec']);
    if (isset($_COOKIE['GID'])) {
      if (!empty($_COOKIE['GID'])) {
        $guestID  = openssl_decrypt($_COOKIE['GID'], $ciphering, $encryption_key, $options, $encryption_iv);
        $a['bool'] = existInDB($guestID);
        $a['id'] = $guestID;
        $cookieResult = $a;
      }else {
        $a['bool'] = false;
        $a['error'] = "cookie is empty";
        $cookieResult = $a;
      }
    }else {
      $a['bool'] = false;
      $a['error'] = "cookie not exist";
      $cookieResult = $a;
    }
  return $cookieResult;
}
// To check wether visiterID exists in DB
function existInDB($guestID){
  include($GLOBALS['dbc']);
  $sql = "SELECT * FROM guests WHERE guestID = '$guestID'";
  $result = mysqli_query($db, $sql);
  if ($result) {
    $isUser = mysqli_num_rows($result);
    if ($isUser) {
        $userPresent = true;
    }else {
        $userPresent = false;
    }
  }else {
    $userPresent = false;
  }
  return $userPresent;
}
function sessionExist(){
  if (isset($_SESSION["GSI"])) {
    $sess = $_SESSION["GSI"];
    if (checkSession($sess)["bool"]) {
      $sessionPresent["bool"] = true;
      $sessionPresent["id"] = $sess;
    }else {
      $sessionPresent["bool"] = false;
      $sessionPresent["error"] = "New Session detected";
    }
  }else {
    $sessionPresent["bool"] = false;
    $sessionPresent["error"] = "Session not exist";
  }
  return $sessionPresent;
}
function checkSession($sess){
    include($GLOBALS['dbc']);
  $sql = "SELECT * FROM guests_sessions WHERE sessionID = '$sess'";
  $result = mysqli_query($db, $sql);
  if ($result) {
    $isPresent = mysqli_num_rows($result);
    if ($isPresent) {
        $row = mysqli_fetch_assoc($result);
        $sessionPresent["bool"] = true;

    }else {
        $sessionPresent["bool"] = false;
    }
  }else {
    $sessionPresent["bool"] = false;
  }
  return $sessionPresent;
}

function makeSession($guestID){
  include($GLOBALS['dbc']);
  include_once($GLOBALS['IDcreator']);
  include_once($GLOBALS['IPDEV']);
  $thisPage = $_SERVER["REQUEST_URI"];
  $sessionID = createNewID("guests_sessions");
  $sessionID = 'GSI'.$sessionID;
  $_SESSION["GSI"] = $sessionID;
  $guestIP = getIp();
  $date = date('Y-m-d');
  $dateTime = time();
  updateVisits($sessionID);
  $sql2 = "INSERT INTO guests_sessions (tdate, sessionID, guestIP, guestID) VALUES ('$date','$sessionID','$guestIP','$guestID')";
  mysqli_query($db, $sql2);
}

function updateVisits($sessionID){
  $visitTime = time();
  if (isset($_SERVER['HTTP_REFERER'])) {
    $httpRefe = $_SERVER['HTTP_REFERER'];
    $referedByPage = preg_replace("(^https?://)", "", $httpRefe );
  }else{
    $referedByPage = "";
  }
  if(isset($_GET['ref']) && !empty($_GET['ref'])){
    $referedByPerson = $_GET['ref'];
  }else {
    $referedByPerson = "";
  }
  $visitedPage = $_SERVER["REQUEST_URI"];
  include($GLOBALS['dbc']);
  $sql = "INSERT INTO sessionVisits (sessionID, visitTime, visitedPage, referedByPerson,referedByPage) VALUES ('$sessionID','$visitTime','$visitedPage', '$referedByPerson', '$referedByPage')";
  $result = mysqli_query($db, $sql);
}
 ?>
