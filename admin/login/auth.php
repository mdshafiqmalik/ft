
<?php
$domain = $_SERVER['DOCUMENT_ROOT'];
include $domain.'/.htHidden/activity/checkVisitorType.php';

if (isset($_POST['redirect'])) {
 $redirect = $_POST['redirect'];
}else {
 $redirect = '/admin/';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (captchaResponse()['status']) {
    if (userName()['valid']) {
      $adminID = userName()['AID'];
      if (passWord($adminID)['valid']) {
        if (deviceStatus($adminID)) {
          echo "Logged";
        }else {
          echo "Device not logged or Could not recognize device";
        }
      }else {
        echo "Invalid Password";
      }
    }else {
      echo "Invalid Username";
    }
  }else {
    echo "Invalid Captcha";
  }
}else {
  echo "Post Request Not Found";
}




function userName(){
  if (isset($_POST['usernameOrEMail'])) {
    $uLength = (boolean) strlen($_POST['usernameOrEMail']);
    if ($uLength) {
      if (validateUsername()['valid']) {
        $userNameRes['valid'] = true;
        $userNameRes['AID'] = validateUsername()['AID'];
      }else {
        $userNameRes['status'] = "Incorrect Username";
        $userNameRes['valid'] = false;
      }
    }else {
      $userNameRes['status'] = "Username is empty";
      $userNameRes['valid'] = false;
    }
  }else {
    $userNameRes['status'] = "Username Not Included";
    $userNameRes['valid'] = false;
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
        $passWordRes['status'] = "Incorrect Password";
        $passWordRes['valid'] = false;
      }
    }else {
      $passWordRes['status'] = "Password is empty";
      $passWordRes['valid'] = false;
    }
  }else {
    $passWordRes['status'] = "Password Not Included";
    $passWordRes['valid'] = false;
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
    $g_capEmpty = (boolean) strlen($g_captcha);
    if (!$g_capEmpty) {
      if (validateCaptcha($g_captcha)) {
        $captchaRes = true;
      }else {
        // G_recaptcha not Authorized
        // WARNING: Potential sapammer
        $captchaRes['status'] = "Not Valid";
        $captchaRes['valid'] = false;
      }
    }else {
      $captchaRes['status'] = "Empty Captcha";
      $captchaRes['valid'] = false;
    }
  }else {
    $captchaRes['status'] = "Captcha Not Included";
    $captchaRes['valid'] = false;
  }
  return $captchaRes;
}

function validateCaptcha($res){
  try {
      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $data = ['secret'   => '6LcFdOMbAAAAABVlj4_7eGdQ2Ha_3vHayE2YMoGP',
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
          // Logged device
          $deviceLogged = true;
        }else {
          // Device Logged Out
          $deviceLogged = false;
        }
      }else {
        // Device ID not matched
        $deviceLogged = false;
      }
    }else {
      // Device ID not found
      $deviceLogged = false;
    }
  }else {
    // Device not logged
    $deviceLogged = false;
  }
  return $deviceLogged;
}


?>
