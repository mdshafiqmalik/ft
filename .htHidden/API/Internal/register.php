<?php
header('content-type:application/json');
if (!isset($_SERVROOT)) {
  $_SERVROOT = '../../../../../';
}

$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
$GLOBALS['DD'] = $_DOCROOT.'/.htHidden/functions/DIRECTORY_LOCATION.php';
include_once($GLOBALS['DD']);

include($_SERVROOT.'htdocs/'.SECRETS.'/DB_CONNECT.php');
include($_SERVROOT.'htdocs/'.SECRETS.'/DEV_OPTIONS.php');
include($_SERVROOT.'htdocs/'.SECRETS.'/AUTH.php');

include( $_DOCROOT.'/.htHidden/functions/BASIC_FUNC.php');
include( $_DOCROOT.'/.htHidden/functions/ERROR_HANDLER.php');


$DB_CONNECTION = new Database();
$DB = $DB_CONNECTION->DBConnection();
$BF = new BasicFunctions();

if (isset($_SERVER['HTTP_REFERER'])) {
  $thisHttp = $_SERVER['HTTP_REFERER'];
  $u1Check = (boolean) strpos($thisHttp, "http://".DOMAIN."/register/");
  $u2Check = (boolean) strpos($thisHttp, "https://".DOMAIN."/register/");
  $u3Check = (boolean) strpos($thisHttp, "http://www.".DOMAIN."/register/");
  $u4Check = (boolean) strpos($thisHttp, "https://www.".DOMAIN."/register/");
  $u5Check = (boolean) strpos($thisHttp, "http://testing.".DOMAIN."/register/");
  $u6Check = (boolean) strpos($thisHttp, "https://testing.".DOMAIN."/register/");
  if (!$u1Check || !$u2Check || !$u3Check || !$u4Check || !$u5Check || !$u6Check) {
      if (isset($_GET["username"])) {
        $inputValue = $_GET["username"];
        $inputValue = sanitizeData($inputValue);
        $userDataSql =  "SELECT * FROM users Where  BINARY userName = '".$inputValue."' ";
        $userSql =  "SELECT * FROM users_register Where  BINARY userName = '".$inputValue."' ";
          if (mysqli_query($DB, $userDataSql)) {
            $result = mysqli_query($DB, $userDataSql);
            $result1 = mysqli_query($DB, $userSql);
            if (mysqli_num_rows($result)) {
              $found = array("Result"=>true, "Status"=>"Username Already Exist");
              $foundJSON = json_encode($found);
              echo "$foundJSON";
            }elseif(mysqli_num_rows($result1)) {
              // Delete OTP if expired
              $OTPexpiredAndDeleted = $BF->checkOTPEd($inputValue, "BINARY userName");
              if ($OTPexpiredAndDeleted) {
                $notFound = array("Result"=>false, "Status"=>"Username Alotted");
                $notFoundJSON = json_encode($notFound);
                echo "$notFoundJSON";
              }else {
                $found = array("Result"=>true, "Status"=>"Someone is creating account<br>with this username Try again<br>after 5 mins. to check availability");
                $foundJSON = json_encode($found);
                echo "$foundJSON";
              }
            }else {
              $notFound = array("Result"=>false, "Status"=>"Username Available");
              $notFoundJSON = json_encode($notFound);
              echo "$notFoundJSON";
            }
          }else {
            $cantRead = array("Status"=>"Cannot Access Database", "Result"=>true);
            $cantReadDecode = json_encode($cantRead);
            echo "$cantReadDecode";
          }
      }else if(isset($_GET["email"])) {
          $inputValue = $_GET["email"];
        $userDataSql =  "SELECT * FROM users Where userEmail = '".$inputValue."' ";
        $userSql =  "SELECT * FROM users_register Where userEmail = '".$inputValue."' ";
          if (mysqli_query($DB, $userDataSql)) {
            $result = mysqli_query($DB, $userDataSql);
            $result1 = mysqli_query($DB, $userSql);
            if (mysqli_num_rows($result)) {
              $found = array("Result"=>true, "Status"=>"Email Already Exist");
              $foundJSON = json_encode($found);
              echo "$foundJSON";
            }elseif (mysqli_num_rows($result1)) {
              // Delete OTP if expired
              $OTPexpiredAndDeleted = $BF->checkOTPEd($inputValue, "userEmail");
              if ($OTPexpiredAndDeleted) {
                $notFound = array("Result"=>false, "Status"=>"Email Alotted");
                $notFoundJSON = json_encode($notFound);
                echo "$notFoundJSON";
              }else {
                $found = array("Result"=>true, "Status"=>"Someone is creating <br>account with this email");
                $foundJSON = json_encode($found);
                echo "$foundJSON";
              }
            }else {
              $notFound = array("Result"=>false,"Status"=>"Email Available");
              $notFoundJSON = json_encode($notFound);
              echo "$notFoundJSON";
            }
          }else {
            $cantRead = array("Status"=>"Cannot Access Database", "Result"=>true);
            $cantReadDecode = json_encode($cantRead);
            echo "$cantReadDecode";
          }
      }else if(isset($_GET["inviteID"])) {
          $inputValue = $_GET["inviteID"];
          $userDataSql =  "SELECT * FROM  users_credentials Where BINARY inviteCode = '".$inputValue."' ";
          if (mysqli_query($DB, $userDataSql)) {
            $result = mysqli_query($DB, $userDataSql);
            if (mysqli_num_rows($result)) {
              $found = array("Result"=>false, "Status"=>"Invite ID found");
              $foundJSON = json_encode($found);
              echo "$foundJSON";
            }else {
              $notFound = array("Result"=>true,"Status"=>"Invite ID not found");
              $notFoundJSON = json_encode($notFound);
              echo "$notFoundJSON";
            }
          }else {
            $cantRead = array("Status"=>"Cannot Access Database", "Result"=>true);
            $cantReadDecode = json_encode($cantRead);
            echo "$cantReadDecode";
          }
      }else {
          $cantRead = array("Status"=>"Invalid or No argument found", "Result"=>true);
          $cantReadDecode = json_encode($cantRead);
          echo "$cantReadDecode";
      }
    }else {
          $cantRead = array("Result"=>true, "Status"=>"Other Domain Used");
          $cantReadDecode = json_encode($cantRead);
          echo "$cantReadDecode";
    }
}else {
  $cantRead = array("Result"=>true, "Status"=>"Not a get request");
  $cantReadDecode = json_encode($cantRead);
  echo "$cantReadDecode";
}

function sanitizeData($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
 ?>
