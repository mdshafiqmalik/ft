<?php
include_once($GLOBALS['DB']);
include_once($GLOBALS['BASIC_FUNC']);
include_once($GLOBALS['AUTH']);



class UsersVisits
{
  private $DB_CONNECT;
  private $AUTH;
  private $BASIC_FUNC;
  private $DB;

  function __construct()
  {

    new HandleError("There is problem to capture User Activity");


    $this->DB_CONNECT = new Database();
    $this->AUTH = new Auth();
    $this->BASIC_FUNC = new BasicFunctions();
    $this->DB = $this->DB_CONNECT->DBConnection();
  }

  public function userVisited(){
    if ($this->sessionExist()["bool"]) {
      $sessionID = $this->sessionExist()["id"];
      $this->updateVisits($pagesViews,$sessionID);
    }else {
      $this->makeSession($encUserID);
    }
  }

  public function sessionExist(){
    if (isset($_SESSION["USI"])) {
      $sess = $_SESSION["USI"];
      if ($this->checkSession($sess)["bool"]) {
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

  public function checkSession($sess){
    $sql = "SELECT * FROM users_sessions WHERE sessionID = '$sess'";
    $result = mysqli_query($this->DB, $sql);
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
  public function makeSession($userID){
    $userIP = $this->BASIC_FUNC->getIp();
    $date = date('Y-m-d');
    $dateTime = time();
    $thisPage = $_SERVER["REQUEST_URI"];
    $sessionID = $this->BASIC_FUNC->createNewID("users_sessions",'USI');
    $sessionID = 'USI'.$sessionID;
    $_SESSION["USI"] = $sessionID;
    $this->updateVisits($sessionID);
    $sql2 = "INSERT INTO users_sessions (sessionID,userID,tdate, userIP) VALUES ('$sessionID','$userID','$date','$userIP')";
    mysqli_query($this->DB, $sql2);
  }

  public function updateVisits($sessionID){
    $visitTime = time();
    if (isset($_SERVER['HTTP_REFERER'])) {
      $httpRefe = $_SERVER['HTTP_REFERER'];
      $referedByPage = preg_replace("(^https?://)", "", $httpRefe );
    }else{
      $referedByPage = "";
    }
    if(isset($_GET['ref']) && !empty($_GET['referer'])){
      $referedByPerson = $_GET['referer'];
    }else {
      $referedByPerson = "";
    }
    $visitedPage = $_SERVER["REQUEST_URI"];
    $sql = "INSERT INTO sessionVisits (sessionID, visitTime, visitedPage, referedByPerson,referedByPage) VALUES ('$sessionID','$visitTime','$visitedPage', '$referedByPerson', '$referedByPage')";
    $result = mysqli_query($this->DB, $sql);
  }
}
 ?>
