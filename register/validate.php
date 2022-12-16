<?php
$_SERVROOT = "../../../";
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';
if ($_SERVER["REQUEST_METHOD"] != "POST") {
  header("Location: /register/index.php");
}

if (!captchaResponse()) {
  header("Location: /register/index.php");
}else if(!usernameCheck()) {
  header("Location: /register/index.php");
}else if(!emailCheck()) {
  header("Location: /register/index.php");
}else if(!passWordCheck()) {
  header("Location: /register/index.php");
}else {
  $userName = sanitizeData($_POST['username']);
  $Email = sanitizeData($_POST['emailAddress']);
  $password = sanitizeData($_POST['userPassword']);
  $Gender = $_POST['Gender'];
  $ageRange = $_POST['age'];
  if (strlen($_POST['inviteID']) < 8) {
    $inviteCode = "NULL";
  }else {
    $inviteCode = sanitizeData($_POST['inviteID']);
  }
  include($GLOBALS['IPDEV']);
  $userIP = getIp();
  if (isset($_SESSION['GSI'])) {
    $currentSession = $_SESSION['GSI'];
  }elseif ($_SESSION['ASI']) {
    $currentSession = $_SESSION['ASI'];
  }elseif ($_SESSION['USI']) {
    $currentSession = $_SESSION['USI'];
  }
  include($GLOBALS['dbc']);
  $sql = "SELECT * FROM users_register WHERE sessionID = '$currentSession'";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result)) {
    echo "string";
  }
}

function captchaResponse(){
  if (isset($_POST['g-recaptcha-response'])) {
    $g_captcha = $_POST['g-recaptcha-response'];
    if (!empty($g_captcha)) {
      include($GLOBALS['dbc']);
      if ((boolean) validateCaptcha($g_captcha, $g_recaptcha)) {
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


function usernameCheck(){
  if (!isset($_POST['username'])) {
    $vUsername = false;
    setcookie("authStatus","Username not found", time()+10, '/');
    // username empty found
  }elseif (!strlen($_POST['username']) >= 6) {
    $vUsername = false;
    setcookie("authStatus","Username short", time()+10, '/');
  }else {
    include($GLOBALS['dbc']);
    $Username = sanitizeData($_POST['username']);
    $sql = "SELECT * FROM users WHERE BINARY userName  = '".$Username."'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result)) {
      $vUsername = false;
      setcookie("authStatus","Username Already Exist", time()+10, '/');
    }else {
      $vUsername = true;
    }
  }
  return $vUsername;
}

function emailCheck(){
  if (!isset($_POST['emailAddress'])) {
    $vEmail = false;
    setcookie("authStatus","Email not found", time()+10, '/');
  }elseif (!strlen($_POST['emailAddress']) >= 6) {
    $vEmail = false;
    setcookie("authStatus","Invalid Email", time()+10, '/');
  }else {
    $Email = sanitizeData($_POST['emailAddress']);
    include($GLOBALS['dbc']);
    $sql = "SELECT * FROM users WHERE userName  = '$Email'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result)) {
      $vEmail = false;
      setcookie("authStatus","Email Already Exist", time()+10, '/');
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
 ?>
