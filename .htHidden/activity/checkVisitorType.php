<?php
session_start();
if (!isset($_SERVROOT)) {
  $_SERVROOT = '../../';
}

$GLOBALS['DEV_OPTIONS'] = $_SERVROOT.'htdocs/secrets/DEV_OPTIONS.php';
$GLOBALS['DB'] = $_SERVROOT.'htdocs/secrets/DB_CONNECT.php';
$GLOBALS['AUTH'] = $_SERVROOT.'htdocs/secrets/AUTH.php';
$GLOBALS['BASIC_FUNC'] = $_SERVROOT.'htdocs/secrets/BASIC_FUNC.php';
$GLOBALS['ERROR_HANDLER'] = $_SERVROOT.'htdocs/secrets/ERROR_HANDLER.php';

$GLOBALS['ERROR_HANDLER'] = $_SERV.'htdocs/secrets/ERROR_HANDLER.php';
$GLOBALS['ERROR_HANDLER'] = $_SERVROOT.'htdocs/secrets/ERROR_HANDLER.php';
$GLOBALS['ERROR_HANDLER'] = $_SERVROOT.'htdocs/secrets/ERROR_HANDLER.php';

// Include Important File
include_once($GLOBALS['DB']);
include_once($GLOBALS['AUTH']);
include_once($GLOBALS['BASIC_FUNC']);
include_once($GLOBALS['DEV_OPTIONS'] );
include_once($GLOBALS['ERROR_HANDLER'] );

include_once($GLOBALS['ADMIN_VISIT'] );
include_once($GLOBALS['USER_VISIT'] );
include_once($GLOBALS['GUEST_VISIT'] );


class CheckVisitorType
{

  private $DB_CONNECT;
  private $AUTH;
  private $DB;
  private $GUEST_VISITED;
  private $ADMIN_VISITED;
  private $USER_VISITED;


  function __construct()
  {
    new HandleError("There is problem to Capturing Activity");

    // Creating Instances
    $this->GUEST_VISITED = new GuestsVisits();
    $this->ADMIN_VISITED = new AdminVisits();
    $this->USER_VISITED = new UsersVisits();

    $this->DB_CONNECT = new Database();
    $this->AUTH = new Auth();
    // Get Connection
    $this->DB = $this->DB_CONNECT->DBConnection();

    $this->handleActivity();
  }

  private function handleActivity(){
    if (isset($_COOKIE['UID'])) {
      if (!empty($_COOKIE['UID'])) {
        $userID = $_COOKIE['UID'];
        $encUserID = $this->AUTH->encrypt($userID);
        $authUser = $this->checkAuthVisitor($encUserID, "users", "userID");
        if ($authUser) {
          include 'userVisits.php';
          $this->USER_VISITED->userVisited();
        }else {
          setcookie("UID",FALSE,time()-3600);
          include 'guestsVisits.php';
          $this->GUEST_VISITED->guestsVisited();
        }
      }else {
        // No Cookie value Mean an anonymous user
        setcookie("UID",FALSE,time()-3600);
        include 'guestsVisits.php';
        $this->GUEST_VISITED->guestsVisited();
      }
    }elseif (isset($_COOKIE['AID'])) {
      if (!empty($_COOKIE['AID'])) {
        $adminID = $_COOKIE['AID'];
        $encAdminID = $this->AUTH->decrypt($adminID);
        $authAdmin = $this->checkAuthVisitor($encAdminID, "admins", "adminID");
        if ($authAdmin) {
          include 'adminVisits.php';
          $this->ADMIN_VISITED->adminVisited();
        }else {
          // Wrong Cookie means anonymous User
          setcookie("AID",FALSE,time()-3600);
          include 'guestsVisits.php';
          $this->GUEST_VISITED->guestsVisited();
        }
      }else {
        // Empty Cookie value means anonymous user
        setcookie("AID",FALSE,time()-3600);
        include 'guestsVisits.php';
        $this->GUEST_VISITED->guestsVisited();
      }
    }else {
      // No Cookie means anonymous user
      include 'guestsVisits.php';
      $this->GUEST_VISITED->guestsVisited();
    }
  }
  private function checkAuthVisitor($id, $table, $parameter){
    $sql = "SELECT $parameter FROM $table WHERE $parameter = '$id'";
    $result = mysqli_query($this->DB, $sql);
    $row = mysqli_num_rows($result);
    if ($row) {
      $status = true;
    }else {
      $status = false;
    }
    return $status;
  }
}
 ?>
