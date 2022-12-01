<?php
$_DOCROOT = '../../../';
$domain = $_SERVER['DOCUMENT_ROOT'];
include $domain.'/.htHidden/activity/checkVisitorType.php';

if (isset($_POST['redirect'])) {
 $redirect = $_POST['redirect'];
}else {
 $redirect = '/admin/';
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($c = captchaResponse()['valid']) {
    if (userName()['valid']) {
      $adminID = userName()['AID'];
      if (passWord($adminID)['valid']) {
        if (deviceStatus($adminID)) {
          include $domain. '/.htHidden/functions/activityConverter.php';
          echo "Logged";
        }
      }
    }
  }
}
function userName(){
  if (isset($_POST['usernameOrEMail'])) {
    $uLength = (boolean) strlen($_POST['usernameOrEMail']);
    if ($uLength) {
      if (validateUsername()['valid']) {
        $userNameRes['valid'] = true;
        $userNameRes['AID'] = validateUsername()['AID'];
      }else {
        $userNameRes['valid'] = false;
        $_SESSION['authStatus'] = "Incorrect Username";
        header("Location: /admin/login/index.php?s=1");
      }
    }else {
      $userNameRes['valid'] = false;
      $_SESSION['authStatus'] = "Username Cannot Be Empty";
      header("Location: /admin/login/index.php?s=2");
      exit;
    }
  }else {
    $userNameRes['valid'] = false;
    $_SESSION['authStatus'] = "Username Not Found In Form";
    header("Location: /admin/login/index.php?s=3");
    exit;
  }
  return $userNameRes;
}

function validateUsername(){
  include($GLOBALS['dbc']);
  $x = $_POST['usernameOrEMail'];
  $sanitizeUsername = sanitizeData($x);
  $x = mysqli_real_escape_string($db,$sanitizeUsername);
  $sql = "SELECT * FROM admins WHERE BINARY adminUName = '$x'";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result)) {
    $row = $result->fetch_assoc();
    $validUserName['valid'] = true;
    $validUserName['AID'] = $row['adminID'];
  }else {
    $validUserName['valid'] = false;
  }
  return $validUserName;
}

function passWord($adID){
  if (isset($_POST['password'])) {
    $pLength = (boolean) strlen($_POST['password']);
    if ($pLength) {
      $pWordMatched= validatePassword($_POST['password'], $adID);
      if ($pWordMatched) {
        $passWordRes['valid'] = true;
      }else {
        $_SESSION['authStatus'] = "Incorrect Password";
        $passWordRes['valid'] = false;
        header("Location: /admin/login?s=4");
        exit;
      }
    }else {
      $passWordRes['valid'] = false;
      $_SESSION['authStatus']= "Password Is Empty";
      header("Location: /admin/login?s=5");
      exit;
    }
  }else {
    $passWordRes['valid'] = false;
    $_SESSION['authStatus']= "Password Not Included In Form";
    header("Location: /admin/login?s=6");
    exit;
  }
  return $passWordRes;
}

function validatePassword($pass, $adID){
  include($GLOBALS['dbc']);
  $sql = "SELECT * FROM admins WHERE adminID = '$adID'";
  $result = mysqli_query($db,$sql);
  if (mysqli_num_rows($result)) {
    $row = $result->fetch_assoc();
    $hPassword = $row['adminPassword'];
    $isPasswordCorrect = password_verify($pass, $hPassword);
    if ($isPasswordCorrect) {
      $validPass = true;
    }else {
      $validPass = false;
    }
  }else {
    $validPass = false;
  }
  return $validPass;
}


//
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
        $_SESSION['authStatus'] ="Captcha Not Valid";
        $captchaRes['valid'] = false;
        header("Location: /admin/login?s=7");
        exit;
      }
    }else {
      $_SESSION['authStatus'] ="Refill The Captcha";
      $captchaRes['valid'] = false;
      header("Location: /admin/login?s=8");
      exit;
    }
  }else {
    $_SESSION['authStatus'] ="Captcha Not Included In Form";
    $captchaRes['valid'] = false;
    header("Location: /admin/login?s=9");
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

function sanitizeData($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function deviceStatus($userID){
  if (isset($_COOKIE['DID'])) {
    if (!empty($_COOKIE['DID'])) {
      $deviceID = $_COOKIE['DID'];
      include($GLOBALS['dbc']);
      $sql = "SELECT * FROM deviceManager WHERE userOrAdminID = '$userID' && deviceID = '$deviceID'";
      $result = mysqli_query($db, $sql);
      if ($result) {
        // Checking if not logged out
        $sql2 = "SELECT loggedStatus FROM deviceManager WHERE deviceID = '$deviceID'";
        $result2 = mysqli_query($db, $sql2);
        $row = mysqli_num_rows($result2);
        if ((boolean)$row) {
          $deviceLogged = true;
        }else {
          $_SESSION['authStatus'] = "Device Logged Out";
          $deviceLogged = false;
          header("Location: /admin/login?s=10");
          exit;
        }
      }else {
        $_SESSION['authStatus'] = "Invalid Device ID";
        $deviceLogged = false;
        header("Location: /admin/login?s=11");
        exit;
      }
    }else {
      $_SESSION['authStatus'] ="Device not added(Contact Admin)";
      $deviceLogged = false;
      header("Location: /admin/login?s=12");
      exit;
    }
  }else {
    $_SESSION['authStatus'] = "Device not added(Contact Admin)";
    $deviceLogged = false;
    header("Location: /admin/login?s=13");
    exit;
  }
  return $deviceLogged;
}


?>
