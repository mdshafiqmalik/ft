<?php
if (sessionExist()["bool"]) {
  $sessionID = sessionExist()["id"];
  updateVisits($sessionID);
}else {
  makeSession($encAdminID);
}

function sessionExist(){
  if (isset($_SESSION["ASI"])) {
    $sess = $_SESSION["ASI"];
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
  $sql = "SELECT * FROM admins_sessions WHERE sessionID = '$sess'";
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
function makeSession($adminID){
  include($GLOBALS['dbc']);
  include_once($GLOBALS['IDcreator']);
  include_once($GLOBALS['IPDEV']);
  if (isset($_SESSION['refSession'])) {
    $refByGuestID = $_SESSION['refSession'];
  }else {
    $refByGuestID = "";
  }
  $adminIP = getIp();
  $date = date('Y-m-d');
  $dateTime = time();
  $thisPage = $_SERVER["REQUEST_URI"];
  $sessionID = createNewID("admins_sessions");
  $sessionID = 'ASI'.$sessionID;
  $_SESSION["ASI"] = $sessionID;
  updateVisits($sessionID);
  $sql2 = "INSERT INTO admins_sessions (sessionID,adminID,tdate, adminIP, refID) VALUES ('$sessionID', '$adminID','$date','$adminIP','$refByGuestID')";
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
