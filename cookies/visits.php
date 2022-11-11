
<?php
// TOP
// last edited 10-11-2022 20:56
$GLOBALS['dbc'] = $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
$GLOBALS['encDec'] = $_SERVER['DOCUMENT_ROOT'].'/config/encDec.php';
$GLOBALS['global'] = $_SERVER['DOCUMENT_ROOT'].'/global/global.php';


visited();

function visited(){
  // Authenticate with Cookie
    $cookie =  checkCookie();
    if ($cookie['bool']) { // if user Exist
      $visitorID['id'] = $cookie['id'];
      // check if the session is same or different
      if (sessionExist()["bool"]) {
        $pagesViews = sessionExist()["pagesViews"];
        $sessionID = sessionExist()["id"];
        updateSessionActivity($pagesViews,$sessionID);
      }else {
        makeSession($visitorID['id']);
      }
    }else {
      addNewVisitor();
    }
}

function checkCookie(){
  include($GLOBALS['encDec']);
    if (isset($_COOKIE['visitorID'])) {
      if (!empty($_COOKIE['visitorID'])) {
        $visitorID  = openssl_decrypt($_COOKIE['visitorID'], $ciphering, $encryption_key, $options, $encryption_iv);
        $a['bool'] = existInDB($visitorID);
        $a['id'] = $visitorID;
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

function existInDB($visitorID){
  include($GLOBALS['dbc']);
  $sql = "SELECT * FROM fast_visitor WHERE visitorId = '$visitorID'";
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
  $sql = "SELECT * FROM fast_sessions WHERE sessionID = '$sess'";
  $result = mysqli_query($db, $sql);
  if ($result) {
    $isPresent = mysqli_num_rows($result);
    if ($isPresent) {
        $row = mysqli_fetch_assoc($result);
        $sessionPresent['pagesViews'] = $row['sessionVisits'];
        $sessionPresent["bool"] = true;

    }else {
        $sessionPresent["bool"] = false;
    }
  }else {
    $sessionPresent["bool"] = false;
  }
  return $sessionPresent;
}

function updateSessionActivity($pagesViews, $sessionID){
  $lastVisited = json_decode($pagesViews, true);
  $dateTime = time();
  $thisPage = $_SERVER["REQUEST_URI"];
  $newPage = array( "$dateTime "=> "$thisPage");
  $newArray = $lastVisited+$newPage;
  $updatedPages = json_encode($newArray);
  include($GLOBALS['dbc']);
  $sql = "UPDATE fast_sessions SET sessionVisits = '$updatedPages' WHERE sessionID = '$sessionID'";
  $result = mysqli_query($db, $sql);
}

function makeSession($visitorID){
  include($GLOBALS['dbc']);
  include_once($GLOBALS['global']);
  // Add to sessions on user and DB
  $visitorIP = getIp();
  $dateTime = time();
  $thisPage = $_SERVER["REQUEST_URI"];
  $sessionID = generateUniqueID(["fast_sessions", "sessionID"],20);
  $_SESSION["uniqueSession"] = $sessionID;
  $pageInfo = array("$dateTime" => "$thisPage");
  $pageVisits = json_encode($pageInfo);
  $sql2 = "INSERT INTO fast_sessions (sessionID, visitorIP, visitorID, sessionVisits) VALUES ('$sessionID','$visitorIP','$visitorID','$pageVisits')";
  mysqli_query($db, $sql2);
}

function addNewVisitor(){
  include($GLOBALS['dbc']);
  include_once($GLOBALS['global']);
  include($GLOBALS['encDec']);
  // Visitor Data
  $ipAddress = getIp();
  $userDevice = get_browser(null, true);
  $browserInfo = serialize($userDevice);
  $deviceType = $userDevice['device_type'];
  $platform= $userDevice['platform'];
  $browser = $userDevice['browser'];
  $dateTime = time();
  $visitorID =  generateUniqueID(["fast_visitor", "visiterId"],20);
  $encryptedID = openssl_encrypt($visitorID, $ciphering,$encryption_key, $options, $encryption_iv);
  // Clear cookie
  setcookie("clear",false);
  // set session as visiterSId === cookie
  $_SESSION["visitorSID"] = $visitorID;
  // Set cookie
  var_dump(addCookie($encryptedID));
  // Add to visiter DB
  $sql = "INSERT INTO fast_visitor ( visitorId, visitorDevice, visitorBrowser, visitorPlatform, browserInfo ) VALUES ('$visitorID','$deviceType', '$browser', '$platform','$browserInfo')";
  mysqli_query($db, $sql);
  makeSession($visitorID);
}

function addCookie($encryptedID){
  $cookieEnabled = (bool) setcookie('cookieTest', "true", time() + (86400 * 365), "/");
  if ($cookieEnabled) {
    echo "cookie Set";
    $cookieSet = (bool) setcookie('visitorID', $encryptedID, time() + (86400 * 365), "/");
  }else {
    echo "Cookie Not set";
    $cookieSet = false;
  }
  return $cookieSet;
}




 ?>
