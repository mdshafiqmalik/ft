<?php
session_start();
if (!isset($_SERVROOT)) {
  $_SERVROOT = '../../';
}

$GLOBALS['DD'] = $_DOCROOT.'/DIRECTORY_LOCATION.php';
include_once($GLOBALS['DD']);

$GLOBALS['DEV_OPTIONS'] = $_SERVROOT.'htdocs/'.SECRETS.'/DEV_OPTIONS.php';
$GLOBALS['DB'] = $_SERVROOT.'htdocs/'.SECRETS.'/DB_CONNECT.php';
$GLOBALS['AUTH'] = $_SERVROOT.'htdocs/'.SECRETS.'/AUTH.php';
$GLOBALS['BASIC_FUNC'] = $_SERVROOT.'htdocs/'.SECRETS.'/BASIC_FUNC.php';
$GLOBALS['ERROR_HANDLER'] = $_SERVROOT.'htdocs/'.SECRETS.'/ERROR_HANDLER.php';

$GLOBALS['ADMIN_VISIT'] = $_DOCROOT.'/.htHidden/actity/ADMIN_VISIT.php';
$GLOBALS['USER_VISIT'] = $_DOCROOT.'/.htHidden/activity/USER_VISIT.php';
$GLOBALS['GUEST_VISIT'] = $_DOCROOT.'/.htHidden/activity/GUEST_VISIT.php';

// Include Important File
include_once($GLOBALS['DB']);
include_once($GLOBALS['AUTH']);
include_once($GLOBALS['BASIC_FUNC']);
include_once($GLOBALS['DEV_OPTIONS'] );


class CheckVisitorType
{

  private $db_connect;
  private $auth;

  function __construct()
  {
    $db_connect = new Database();
    $db = $db_connect->DBConnection();
    $auth = new Auth();


    if (isset($_COOKIE['UID'])) {
      if (!empty($_COOKIE['UID'])) {
        $userID = $_COOKIE['UID'];
        $encUserID = $auth->encrypt($userID);

        $authUser = $this->checkAuthVisitor($encUserID, "users", "userID");
        if ($authUser) {
          include 'userVisits.php';
        }else {
          echo "GID";
          include 'guestsVisits.php';
          $visited = new GuestsVisits();
        }
      }else {
        // No Cookie value Mean an anonymous user
        setcookie("UID",FALSE,time()-3600);
        include 'guestsVisits.php';
      }
    }elseif (isset($_COOKIE['AID'])) {
      if (!empty($_COOKIE['AID'])) {
        $adminID = $_COOKIE['AID'];
        $encAdminID = $auth->decrypt($adminID);
        $authAdmin = $this->checkAuthVisitor($encAdminID, "admins", "adminID");
        if ($authAdmin) {
          include 'adminVisits.php';
        }else {
          include 'guestsVisits.php';
          $visited = new GuestsVisits();
        }
      }else {
        // No Cookie value Mean an anonymous user
        include 'guestsVisits.php';
        $visited = new GuestsVisits();
      }
    }else {
      // No Cookie Mean an anonymous user
      include 'guestsVisits.php';
      $visited = new GuestsVisits();
    }
  }

  private function checkAuthVisitor($id, $table, $parameter){
    $db = $db_connect->DBConnection();
    $sql = "SELECT $parameter FROM $table WHERE $parameter = '$id'";
    $result = mysqli_query($db, $sql);
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
