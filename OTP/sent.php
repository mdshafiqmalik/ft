<?php
$_SERVROOT = '../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/VISIT.php';
new VisitorActivity();
new SentOTP();
class SentOTP
{
  private $EMAIL_ADDR;
  private $DB;
  private $OTP_PURPOSE;
  function __construct()
  {
    echo "string";
    $DB_CONNECT = new Database();
    $this->DB = $DB_CONNECT->DBConnection();

    if (isset($_SESSION['email']) || !empty($_SESSION['email'])) {
      if (isset($_SESSION['OTPPurpose']) || !empty($_SESSION['OTPPurpose'])) {
        $this->EMAIL_ADDR = $_SESSION['email'];
        $this->OTP_PURPOSE = $_SESSION['OTPPurpose'];
        $this->sendOTP();
      }else {
        setcookie("authStatus","Cannot send OTP", time()+10, '/');
        header("Location: /register/");
        $this->DB = array();
        exit();
      }
    }else {
      setcookie("authStatus","Cannot send OTP", time()+10, '/');
      header("Location: /register/");
      $this->DB = array();
      exit();
    }
  }

  public function sendOTP(){
    $OTPexist = $this->authOTP();
    if ($OTPexist) {
      $OTP = $OTPexist['OTP'];
      $userName = $OTPexist['userName'];
      if (OTP_EMAIL_DISABLED) {
        $timestamp = date('h:i:s');
        header("Location: /OTP/");
        setcookie("sucessStatus","OTP sent with timestamp ($timestamp)", time()+10, '/');
      }else if ($OTPexist['otpPurpose'] == 'NR') {
        $timestamp = $this->sendToNR($this->EMAIL_ADDR, $OTP, $userName);
        if ($timestamp) {
          header("Location: /OTP/");
          setcookie("sucessStatus","OTP sent with timestamp ($timestamp)", time()+10, '/');
        }else {
          header("Location: /register/");
          setcookie("authStatus","Cannot send OTP", time()+10, '/');
        }
      }elseif ($OTPexist['otpPurpose'] == 'PR') {
        $this->passWordRecovery();
      }
    }else {
      setcookie("authStatus","Cannot send OTP", time()+10, '/');
      header("Location: /register/");
      $this->DB = array();
      exit();
    }
  }

  public function authOTP(){
    $sql = "SELECT userEmail, OTP , sessionID FROM OTP WHERE userEmail = '$this->EMAIL_ADDR' AND otpPurpose = '$this->OTP_PURPOSE'";
    $result = mysqli_query($this->DB, $sql);
    if (mysqli_num_rows($result)) {
      $row = mysqli_fetch_assoc($result);
      $otpSession = $row['sessionID'];
      $userEmail = $row['userEmail'];
      $getUsername = $this->getUsername($otpSession, $userEmail);
      $return= $row;
    }else {
      $return['bool'] = false;
    }
    return $return;
  }

  public function getUsername($otpSession, $userEmail){
    $sql = "SELECT userName FROM users_register WHERE sessionID = '$otpSession' AND userEmail = '$userEmail'";
    $result = mysqli_query($this->DB, $sql);
    if (mysqli_num_rows($result)) {
      $row = mysqli_fetch_assoc($result);
      $return = $row['userName'];
    }else {
      $return = false;
    }
    return $return;
  }

  private function sendToNR($EMAIL, $OTP_SENT, $USER_NAME){

    if ($timestamp = sendOTP($EMAIL, $OTP_SENT, $USER_NAME)) {
     $return = $timestamp;
    }else {
     $return = fasle;;
    }
    return $return;
  }


  private function passWordRecovery(){
  }
}


 ?>
