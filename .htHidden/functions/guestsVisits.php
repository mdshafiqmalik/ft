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
        $pagesViews = sessionExist()["pagesViews"];
        $httpRef = sessionExist()["httpReferer"];
        $visitRef = sessionExist()["visitReferer"];
        $sessionID = sessionExist()["id"];
        updateSessionActivity($pagesViews,$httpRef,$visitRef,$sessionID);
      }else {
        makeSession($guestID['id']);
      }
    }else {
      addNewVisitor();
    }
}
function addNewVisitor(){
  include($GLOBALS['dbc']);
  include_once($GLOBALS['IDcreator']);
  include($GLOBALS['encDec']);
  include($GLOBALS['IPDEV']);
  $ipAddress = getIp();
  $userDevice = get_browser(null, true);
  $browserInfo = serialize($userDevice);
  $deviceType = $userDevice['device_type'];
  $platform= $userDevice['platform'];
  $browser = $userDevice['browser'];
  $dateTime = time();
  $guestID =  generateUniqueID(["guests", "guestID"],15);
  $encryptedID = openssl_encrypt($guestID, $ciphering,$encryption_key, $options, $encryption_iv);
  // set session as visiterSId === cookie
  $_SESSION["visitorSID"] = $guestID;
  // Set cookie
  $cookieSet = setcookie('guestID', $encryptedID, time() + (86400 * 30), "/");
  // Add to visiter data to DB
  $sql = "INSERT INTO guests ( guestID, guestDevice, guestBrowser, guestPlatform, browserInfo ) VALUES ('$guestID','$deviceType', '$browser', '$platform','$browserInfo')";
  mysqli_query($db, $sql);
  makeSession($guestID);
}
function checkCookie(){
  include($GLOBALS['encDec']);
    if (isset($_COOKIE['guestID'])) {
      if (!empty($_COOKIE['guestID'])) {
        $guestID  = openssl_decrypt($_COOKIE['guestID'], $ciphering, $encryption_key, $options, $encryption_iv);
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
  if (isset($_SESSION["uniqueSession"])) {
    $sess = $_SESSION["uniqueSession"];
    if (checkSession($sess)["bool"]) {
      $sessionPresent["bool"] = true;
      $sessionPresent["id"] = $sess;
      $sessionPresent["pagesViews"] = checkSession($sess)["pagesViews"];
      $sessionPresent["httpReferer"] = checkSession($sess)["httpReferer"];
      $sessionPresent["visitReferer"] = checkSession($sess)["visitReferer"];
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
        $sessionPresent['pagesViews'] = $row['sessionVisits'];
        $sessionPresent['httpReferer'] = $row['httpReferer'];
        $sessionPresent['visitReferer'] = $row['visitReferer'];
        $sessionPresent["bool"] = true;

    }else {
        $sessionPresent["bool"] = false;
    }
  }else {
    $sessionPresent["bool"] = false;
  }
  return $sessionPresent;
}
function updateSessionActivity($pagesViews,$httpRef,$visitRef, $sessionID){
  $lastVisited = json_decode($pagesViews, true);
  $httpRe = json_decode($httpRef, true);
  $visitRe = json_decode($visitRef, true);
  $dateTime = time();
  if (isset($_SERVER['HTTP_REFERER'])) {
    $httpRefe = $_SERVER['HTTP_REFERER'];
    $httpReferer = preg_replace("(^https?://)", "", $httpRefe );
  }else{
    $httpReferer = "NIL";
  }
  $array = array("$dateTime" => "$httpReferer");
  $httpR = $httpRe+$array;
  $hRef = json_encode($httpR);



  if(isset($_GET['referer']) && !empty($_GET['referer'])){
    $visitReferer = $_GET['referer'];
  }else {
    $visitReferer = "NIL";
  }
  $array2 = array("$dateTime" => "$visitReferer");
  $VisitR = $visitRe+$array2;
  $vRef = json_encode($VisitR);

  $thisPage = $_SERVER["REQUEST_URI"];
  $newPage = array( "$dateTime "=> "$thisPage");
  $newArray = $lastVisited+$newPage;
  $updatedPages = json_encode($newArray);
  include($GLOBALS['dbc']);
  $sql = "UPDATE guests_sessions SET sessionVisits = '$updatedPages', visitReferer = '$vRef', httpReferer = '$hRef' WHERE sessionID = '$sessionID'";
  $result = mysqli_query($db, $sql);
}
function makeSession($guestID){
  include($GLOBALS['dbc']);
  include_once($GLOBALS['IDcreator']);
  include_once($GLOBALS['IPDEV']);
  // Add to sessions on user and DB
  $guestIP = getIp();
  $dateTime = time();
  if (isset($_SERVER['HTTP_REFERER'])) {
    $httpRefe = $_SERVER['HTTP_REFERER'];
    $httpReferer = preg_replace("(^https?://)", "", $httpRefe );
  }else{
    $httpReferer = "NIL";
  }
  $array = array("$dateTime" => "$httpReferer");
  $hRef = json_encode($array);

  if(isset($_GET["referer"]) && !empty($_GET["referer"])){
    $visitReferer = $_GET["referer"];
  }else {
    $visitReferer = "NIL";
  }
  $array2 = array("$dateTime" => "$visitReferer");
  $vRef = json_encode($array2);

  $thisPage = $_SERVER["REQUEST_URI"];
  $sessionID = generateUniqueID(["guests_sessions", "sessionID"],15);
  $_SESSION["uniqueSession"] = $sessionID;
  $pageInfo = array("$dateTime" => "$thisPage");
  $pageVisits = json_encode($pageInfo);
  $sql2 = "INSERT INTO guests_sessions (sessionID, guestIP, guestID, sessionVisits, visitReferer, httpReferer) VALUES ('$sessionID','$guestIP','$guestID','$pageVisits', '$vRef','$hRef')";
  mysqli_query($db, $sql2);
}
 ?>
