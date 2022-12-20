<?php
$_SERVROOT = '../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';


include($_SERVROOT.'htdocs/secrets/DB_CONNECT.php');
include( $_SERVROOT.'htdocs/secrets/BASIC_FUNC.php');
include( $_SERVROOT.'htdocs/secrets/DEV_OPTIONS.php');

class SentOTP
{
  private $EMAIL_ADDR;
  private $DB;
  private $OTP_PURPOSE:
  function __construct()
  {

    $DB_CONNECT = new Database();
    $this->DB = $DB_CONNECT->DBConnection();

    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
      if (!isset($_SESSION['OTPPurpose']) || empty($_SESSION['OTPPurpose'])) {
        $this->EMAIL_ADDR = $_SESSION['email'];
        $this->OTP_PURPOSE = $_SESSION['OTPPurpose'];
        $thia->sendOTP();
      }else {
        setcookie("authStatus","Cannot send OTP", time()+10, '/');
        header("Location: /register");
        $this->DB = array();
        exit();
      }
    }else {
      setcookie("authStatus","Cannot send OTP", time()+10, '/');
      header("Location: /register");
      $this->DB = array();
      exit();
    }
  }

  public function sendOTP(){
    $OTPexist = $this->authOTP();
    $userName = $OTPexist['userName'];
    $SENTOTP = $OTPexist['OTP'];
    if ($OTPexist) {
      if (OTP_EMAIL_DISABLED) {
        $timestamp = date('h:i:s');
        header("Location: /OTP/index.php");
        setcookie("sucessStatus","OTP sent with timestamp ($timestamp)", time()+10, '/');
      }else if ($OTPexist['otpPurpose'] == 'NR') {
        $OTPSENT = $this->sendToNR($this->EMAIL_ADDR, $SENTOTP, $userName);
        if ($timestamp = $OTPSENT) {
          /header("Location: /OTP/index.php");
          setcookie("sucessStatus","OTP sent with timestamp ($timestamp)", time()+10, '/');
        }else {
          header("Location: /register");
          setcookie("authStatus","Cannot send OTP", time()+10, '/');
        }
      }elseif ($OTPexist['otpPurpose'] == 'PR') {
        $this->passWordRecovery();
      }
    }else {
      setcookie("authStatus","Cannot send OTP", time()+10, '/');
      header("Location: /register");
      $this->DB = array();
      exit();
    }
  }

  public function authOTP(){
    $sql = "SELECT * FROM OTP WHERE userEmail = '$this->EMAIL_ADDR' AND otpPurpose = '$this->OTP_PURPOSE'";
    $result = mysqli_query($this->DB, $sql);
    if (mysqli_num_rows($result4)) {
      $row = mysqli_fetch_assoc($result);
      $OTPFOUND = $row;
    }else {
      $OTPFOUND = false;
    }
    return $OTPFOUND;
  }


  private function sendToNR($EMAIL, $OTP_SENT, $USER_NAME){
    if ($timestamp = sendOTP($EMAIL, $OTP_SENT, $USER_NAME)) {
     $OTPSENT = $timestamp;
    }else {
     $OTPSENT = fasle;;
    }
    return $OTPSENT;
  }
  private function passWordRecovery(){
  }
}


 ?>