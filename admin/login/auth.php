<?php
$_SERVROOT = '../../../../';
$_DOCROOT = $_SERVER['DOCUMENT_ROOT'];
include $_DOCROOT.'/.htHidden/activity/checkVisitorType.php';

if (isset($_GET['redirect'])) {
 $redirect = $_GET['redirect'];
}else {
 $redirect = '/admin/';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if ($c = captchaResponse()['valid']) {
    if (userName()['valid']) {
      $adminID = userName()['AID'];
      if (passWord($adminID)['valid']) {
        if (deviceStatus($adminID)) {
          // Delete the other Cokkie
          include($GLOBALS['encDec']);
          include($GLOBALS['dbc']);
          if (isset($_COOKIE['UID'])) {
            $refID = openssl_decrypt($_COOKIE['UID'], $ciphering,$encryption_key, $options, $encryption_iv);
            $_SESSION['refSession'] = $refID;

            setcookie("UID", "", time()-3600, '/');
            unset($_SESSION['USI']);


          }elseif (isset($_COOKIE['GID'])) {
            $refID = openssl_decrypt($_COOKIE['GID'], $ciphering,$encryption_key, $options, $encryption_iv);
            $_SESSION['refSession'] = $refID;

            setcookie("GID", "", time()-3600, '/');
            unset($_SESSION['GSI']);
          }
          //--------------//

          // make admin cookie
          $adID = openssl_encrypt($adminID, $ciphering, $encryption_key, $options, $encryption_iv);
          unset($_SESSION['authStatus']);
          setcookie("AID", $adID, time()+3600, '/');

          $deviceID = $_COOKIE['DID'];
          $decryptID = openssl_decrypt($deviceID, $ciphering,$encryption_key, $options, $encryption_iv);
          $dateAndTime = date('Y-m-d h-i-s');
          $sql = "UPDATE deviceManager SET loggedDateTime='$dateAndTime',linkStatus=0  WHERE deviceID='$decryptID'";
          mysqli_query($db, $sql);
          $_SESSION['adminLoginStatus'] = true;
          header("Location: $redirect");

        }
      }
    }
  }
}else {
  header("Location: index.php");
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
        header("Location: /admin/login/index.ph?err=AE01");
      }
    }else {
      $userNameRes['valid'] = false;
      $_SESSION['authStatus'] = "Username Cannot Be Empty";
      header("Location: /admin/login/index.php");
      exit;
    }
  }else {
    $userNameRes['valid'] = false;
    $_SESSION['authStatus'] = "Username Not Found In Form";
    header("Location: /admin/login/index.php");
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
        header("Location: /admin/login");
        exit;
      }
    }else {
      $passWordRes['valid'] = false;
      $_SESSION['authStatus']= "Password Is Empty";
      header("Location: /admin/login");
      exit;
    }
  }else {
    $passWordRes['valid'] = false;
    $_SESSION['authSthttp://localhost/atus']= "Password Not Included In Form";
    header("Location: /admin/login");
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
        header("Location: /admin/login");
        exit;
      }
    }else {
      $_SESSION['authStatus'] ="Refill The Captcha";
      $captchaRes['valid'] = false;
      header("Location: /admin/login");
      exit;
    }
  }else {
    $_SESSION['authStatus'] ="Captcha Not Included In Form";
    $captchaRes['valid'] = false;
    header("Location: /admin/login");
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
      include($GLOBALS['encDec']);
      $decryptID = openssl_decrypt($deviceID, $ciphering,$encryption_key, $options, $encryption_iv);
      include($GLOBALS['dbc']);
      $sql = "SELECT * FROM deviceManager WHERE userOrAdminID = '$userID' && deviceID = '$decryptID'";
      $result = mysqli_query($db, $sql);
      if ($result) {
        $validDevice = true;
      }else {
        $_SESSION['authStatus'] = "Invalid Device ID";
        $validDevice = false;
        header("Location: /admin/login");
        exit;
      }
    }else {
      $_SESSION['authStatus'] ="No admin invitation found";
      $validDevice = false;
      header("Location: /admin/login");
      exit;
    }
  }else {
    $_SESSION['authStatus'] = "No admin invitation found";
    $validDevice = false;
    header("Location: /admin/login");
    exit;
  }
  return $validDevice;
}
?>
