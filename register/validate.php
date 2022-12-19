<?php
$_SERVROOT = "../../../";
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';

class ValidateSingUp
{
  private $USER_NAME;
  private $EMAIL_ADDR;
  private $PASS_WORD;
  private $GENDER;
  private $INVITE_CODE;
  private $AGE_RANGE;
  private $DB;

  function __construct()
  {

    $DB_CONNECT = new Database();
    $this->DB = $DB_CONNECT->DBConnection;

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
      header("Location: /register/index.php");
    }else if(!$RECAPTCHA_DISABLED && !$this->captchaResponse()) {
      header("Location: /register/index.php");
    }else if(!$this->uernameAvailability()) {
      header("Location: /register/index.php");
    }else if(!$this->emailAvailability()) {
      header("Location: /register/index.php");
    }else if(!$this->passWordCheck()) {
      header("Location: /register/index.php");
    }else {
      $this->USER_NAME = $this->sanitizeData($_POST['username']);
      $this->EMAIL_ADDR = $this->sanitizeData($_POST['emailAddress']);
      $this->PASS_WORD = $this->sanitizeData($_POST['userPassword']);
      $this->GENDER = $_POST['Gender'];
      $this->AGE_RANGE = $_POST['age'];
      if (strlen($_POST['inviteID']) < 8) {
        $this->INVITE_CODE = '';
      }else {
        $this->INVITE_CODE = $this->sanitizeData($_POST['inviteID']);
      }
      $this->dbStoriing();
      $_SESSION['email'] = $Email;
      $_SESSION['OTPPurpose'] = "NR";
      header("Location: /OTP/sent.php");
    }
  }

  public function dbStoriing(){
    $SESSION_ID = $this->getSessionID();
    $sentTime = time();
    $RANOTP = BasicFunctions::generateOTP(6);
    $sql = "SELECT * FROM users_register WHERE sessionID = '$SESSION_ID'";
     mysqli_query($this->DB, $sql);

    $sql2 = "INSERT INTO users_register (sessionID,  userName,userEmail, Gender, ageRange, inviteCode, passWord)  VALUES ('$currentSession','$NewUserName','$this->EMAIL_ADDR','$this->GENDER','$this->AGE_RANGE','$this->INVITE_CODE','$this->PASS_WORD')";
    mysqli_query($this->DB, $sql2);

    $sql3 = "INSERT INTO OTP (sessionID, userEmail, OTP, sentTime, otpPurpose) VALUES ('$SESSION_ID()', '$this->EMAIL_ADDR', '$RANOTP', '$sentTime', 'NR')";
    mysqli_query($this->DB, $sql3);
  }


  public function getSessionID(){
    if (isset($_SESSION['GSI'])) {
      $currentSession = $_SESSION['GSI'];
    }elseif ($_SESSION['ASI']) {
      $currentSession = $_SESSION['ASI'];
    }elseif ($_SESSION['USI']) {
      $currentSession = $_SESSION['USI'];
    }
    return $currentSession;
  }


  function captchaResponse(){
    if (isset($_POST['g-recaptcha-response'])) {
      $g_captcha = $_POST['g-recaptcha-response'];
      if (!empty($g_captcha)) {
        if ((boolean) $this->validateCaptcha($g_captcha, $G_RECAPTCHA)) {
          $captchaRes['valid'] = true;
        }else {
          // WARNING: Potential sapammer
          // G_recaptcha not Authorized
          setcookie("authStatus","Captcha Not Valid", time()+10, '/');
          $captchaRes['valid'] = false;
          header("Location: /register/");
          exit;
        }
      }else {
        setcookie("authStatus","Refill The Captcha", time()+10, '/');
        $captchaRes['valid'] = false;
        header("Location: /register/");
        exit;
      }
    }else {
      setcookie("authStatus","Captcha Not Included In Form", time()+10, '/');
      $captchaRes['valid'] = false;
      header("Location: /register/");
      exit;
    }
    return $captchaRes;
  }

  function validateCaptcha($res, $captchaKey){
    try {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret'   => $captchaKey,
                 'response' => $res,
                 'remoteip' => $_SERVER['REMOTE_ADDR']];
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result)->success;
    }
    catch (Exception $e) {
        return null;
    }
  }


  function uernameAvailability(){
    if (!isset($_POST['username'])) {
      $vUsername = false;
      setcookie("authStatus","Username not found", time()+10, '/');
      // username empty found
    }elseif (!strlen($_POST['username']) >  6) {
      $vUsername = false;
      setcookie("authStatus","Username short", time()+10, '/');
    }else {
      include($GLOBALS['dbc']);
      $Username = $this->sanitizeData($_POST['username']);
      // Checking if username found in users table
      $sql = "SELECT * FROM users WHERE BINARY userName  = '".$Username."'";
      $result = mysqli_query($db, $sql);

      $sql1 = "SELECT * FROM users_register WHERE BINARY userName  = '".$Username."'";
      $result1 = mysqli_query($db, $sql1);
      if (mysqli_num_rows($result)) {
        $vUsername = false;
        setcookie("authStatus","Username Already Exist", time()+10, '/');
      }elseif (mysqli_num_rows($result1)) {
        $OTPexpiredAndDeleted = checkOTPEd($Username, "BINARY userName");
        if ($OTPexpiredAndDeleted) {
          $vUsername = true;
        }else {
          $vUsername = false;
          setcookie("authStatus","Someone is creating account  <br> with this username Try again <br>after 5 mins. to check availability", time()+10, '/');
        }
      }else {
        $vUsername = true;
      }
    }
    return $vUsername;
  }

  function emailAvailability(){
    if (!isset($_POST['emailAddress'])) {
      $vEmail = false;
      setcookie("authStatus","Email not found", time()+10, '/');
    }elseif (!strlen($_POST['emailAddress']) >= 6) {
      $vEmail = false;
      setcookie("authStatus","Invalid Email", time()+10, '/');
    }else {
      $Email = $this->sanitizeData($_POST['emailAddress']);
      include($GLOBALS['dbc']);
      $sql = "SELECT * FROM users WHERE userEmail  = '$Email'";
      $sql1 = "SELECT * FROM users_register WHERE userEmail  = '$Email'";
      $result = mysqli_query($db, $sql);
      $result1 = mysqli_query($db, $sql1);
      if (mysqli_num_rows($result)) {
        $vEmail = false;
        setcookie("authStatus","Email Already Exist", time()+10, '/');
      }elseif (mysqli_num_rows($result1)) {
        $OTPexpiredAndDeleted = BasicFunctions::checkOTPEd($inputValue, "userEmail");
        if ($OTPexpiredAndDeleted) {
          $vEmail = true;
        }else {
          $vEmail = false;
          setcookie("authStatus","Someone is creating <br>account with this email", time()+10, '/');
        }
      }else {
        $vEmail = true;
      }
    }
    return $vEmail;
  }

  function passWordCheck(){
    if (!isset($_POST['userPassword'])) {
      $vPassword = false;
      setcookie("authStatus","No password found", time()+10, '/');
    }elseif (!strlen($_POST['userPassword']) >= 8) {
      $vPassword = false;
      setcookie("authStatus","Password should be 8 chars", time()+10, '/');
    }else {
      $vPassword = true;
    }
    return $vPassword;
  }

  function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

}




 ?>
