<?php
if (sessionExist()["bool"]) {
  $sessionID = sessionExist()["id"];
  upadteVisits($pagesViews,$sessionID);
}else {
  makeSession($userID);
}

function sessionExist(){
  if (isset($_SESSION["USI"])) {
    $sess = $_SESSION["USI"];
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
  $sql = "SELECT * FROM users_sessions WHERE sessionID = '$sess'";
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
function makeSession($userID){
  include($GLOBALS['dbc']);
  include_once($GLOBALS['IDcreator']);
  include_once($GLOBALS['IPDEV']);
  $userIP = getIp();
  $date = date('Y-m-d');
  $dateTime = time();
  $thisPage = $_SERVER["REQUEST_URI"];
  $sessionID = createNewID("users_sessions");
  $sessionID = 'USI'.$sessionID;
  $_SESSION["USI"] = $sessionID;
  upadteVisits($sessionID);
  $sql2 = "INSERT INTO users_sessions (sessionID,userID,tdate, userIP) VALUES ('$sessionID','$userID','$date','$userIP')";
  mysqli_query($db, $sql2);
}

function upadteVisits($sessionID){
  $visitTime = time();
  if (isset($_SERVER['HTTP_REFERER'])) {
    $httpRefe = $_SERVER['HTTP_REFERER'];
    $referedByPage = preg_replace("(^https?://)", "", $httpRefe );
  }else{
    $referedByPage = "N";
  }
  if(isset($_GET['ref']) && !empty($_GET['referer'])){
    $referedByPerson = $_GET['referer'];
  }else {
    $referedByPerson = "N";
  }
  $visitedPage = $_SERVER["REQUEST_URI"];
  include($GLOBALS['dbc']);
  $sql = "INSERT INTO sessionVisits (sessionID, visitTime, visitedPage, referedByPerson,referedByPage) VALUES ('$sessionID','$visitTime','$visitedPage', '$referedByPerson', '$referedByPage')";
  $result = mysqli_query($db, $sql);
}
 ?>
