<?php
adminVisited();
function adminVisited(){
  // Authenticate with Cookie
    $cookie =  checkCookie();
    if ($cookie['bool']) { // if user Exist
      $userID['id'] = $cookie['id'];
      // check if the session is same or different
      if (sessionExist()["bool"]) {
        $pagesViews = sessionExist()["pagesViews"];
        $httpRef = sessionExist()["httpReferer"];
        $visitRef = sessionExist()["visitReferer"];
        $sessionID = sessionExist()["id"];
        updateSessionActivity($pagesViews,$httpRef,$visitRef,$sessionID);
      }else {
        makeSession($userID['id']);
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
  $userID =  generateUniqueID(["admins", "userID"],15);
  $encryptedID = openssl_encrypt($userID, $ciphering,$encryption_key, $options, $encryption_iv);
  // set session as visiterSId === cookie
  $_SESSION["visitorSID"] = $userID;
  // Set cookie
  $cookieSet = setcookie('userID', $encryptedID, time() + (86400 * 30), "/");
  var_dump($cookieSet);
  // Add to visiter data to DB
  $sql = "INSERT INTO admins ( userID, visitorDevice, visitorBrowser, visitorPlatform, browserInfo ) VALUES ('$userID','$deviceType', '$browser', '$platform','$browserInfo')";
  mysqli_query($db, $sql);
  makeSession($userID);
}
function checkCookie(){
  include($GLOBALS['encDec']);
    if (isset($_COOKIE['userID'])) {
      if (!empty($_COOKIE['userID'])) {
        $userID  = openssl_decrypt($_COOKIE['userID'], $ciphering, $encryption_key, $options, $encryption_iv);
        $a['bool'] = existInDB($userID);
        $a['id'] = $userID;
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
function existInDB($userID){
  include($GLOBALS['dbc']);
  $sql = "SELECT * FROM admins WHERE userID = '$userID'";
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
  $sql = "SELECT * FROM admins_sessions WHERE sessionID = '$sess'";
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
  $sql = "UPDATE admins_sessions SET sessionVisits = '$updatedPages', visitReferer = '$vRef', httpReferer = '$hRef' WHERE sessionID = '$sessionID'";
  $result = mysqli_query($db, $sql);
}
function makeSession($userID){
  include($GLOBALS['dbc']);
  include_once($GLOBALS['IDcreator']);
  include_once($GLOBALS['IPDEV']);
  // Add to sessions on user and DB
  $visitorIP = getIp();
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
  $sessionID = generateUniqueID(["admins_sessions", "sessionID"],15);
  $_SESSION["uniqueSession"] = $sessionID;
  $pageInfo = array("$dateTime" => "$thisPage");
  $pageVisits = json_encode($pageInfo);
  $sql2 = "INSERT INTO admins_sessions (sessionID, visitorIP, userID, sessionVisits, visitReferer, httpReferer) VALUES ('$sessionID','$visitorIP','$userID','$pageVisits', '$vRef','$hRef')";
  mysqli_query($db, $sql2);
}
 ?>
