<?php
session_start();
if (!isset($_SERVROOT)) {
  $_SERVROOT = '../../../';
}


include_once($GLOBALS['PATH_HELPER']);
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
$GLOBALS['DEV_OPTIONS'] = $_SERVROOT.MY_LOC.'/secrets/DEV_OPTIONS.php';
$GLOBALS['DB'] = $_SERVROOT.MY_LOC.'/secrets/DB_CONNECT.php';
$GLOBALS['AUTH'] = $_SERVROOT.MY_LOC.'/secrets/AUTH.php';

$GLOBALS['BASIC_FUNC'] = $_DOCROOT.'/.htHidden/functions/BASIC_FUNC.php';
$GLOBALS['ERROR_HANDLER'] = $_DOCROOT.'/.htHidden/functions/ERROR_HANDLER.php';
$GLOBALS['ADMIN_VISIT'] = $_DOCROOT.'/.htHidden/activity/ADMIN_VISIT.php';
$GLOBALS['USER_VISIT'] = $_DOCROOT.'/.htHidden/activity/USER_VISIT.php';
$GLOBALS['GUEST_VISIT'] = $_DOCROOT.'/.htHidden/activity/GUEST_VISIT.php';

// Include Important File
include_once($GLOBALS['DB']);
include_once($GLOBALS['AUTH']);
include_once($GLOBALS['BASIC_FUNC']);
include_once($GLOBALS['DEV_OPTIONS']);
include_once($GLOBALS['ERROR_HANDLER']);

include_once($GLOBALS['ADMIN_VISIT']);
include_once($GLOBALS['USER_VISIT']);
include_once($GLOBALS['GUEST_VISIT']);


class VisitorActivity
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
          $this->USER_VISITED->userVisited();
        }else {
          setcookie("UID",FALSE,time()-3600);
          $this->GUEST_VISITED->guestVisited();
        }
      }else {
        // No Cookie value Mean an anonymous user
        setcookie("UID",FALSE,time()-3600);
        $this->GUEST_VISITED->guestVisited();
      }
    }elseif (isset($_COOKIE['AID'])) {
      if (!empty($_COOKIE['AID'])) {
        $adminID = $_COOKIE['AID'];
        $encAdminID = $this->AUTH->decrypt($adminID);
        $authAdmin = $this->checkAuthVisitor($encAdminID, "admins", "adminID");
        if ($authAdmin) {
          $this->ADMIN_VISITED->adminVisited();
        }else {
          // Wrong Cookie means anonymous User
          setcookie("AID",FALSE,time()-3600);
          $this->GUEST_VISITED->guestVisited();
        }
      }else {
        // Empty Cookie value means anonymous user
        setcookie("AID",FALSE,time()-3600);
        $this->GUEST_VISITED->guestVisited();
      }
    }else {
      // No Cookie means anonymous user
      $this->GUEST_VISITED->guestVisited();
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
