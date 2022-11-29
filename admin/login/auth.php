
<?php
$domain = $_SERVER['DOCUMENT_ROOT'];
include $domain.'/.htHidden/activity/checkVisitorType.php';

if (isset($_POST['redirect'])) {
 $redirect = $_POST['redirect'];
}else {
 $redirect = '/admin/';
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $password = $_POST['password'];
  $UsernameOrEMail = $_POST['usernameOrEMail'];
  $ulen = (boolean)strlen($UsernameOrEMail);
  $plen = (boolean)strlen($password);
  $userNameSpace = preg_match('/\s/', $UsernameOrEMail);
  $passwordSpace = preg_match('/\s/', $password);
  $captcha_res = $_POST['g-recaptcha-response'];
  $captchaVerified = validateCaptcha($captcha_res);

  if ($captchaVerified) {
    // code...
  }else {
    // code...
  }

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

function authDeviceLogin($userID)
{
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

    function sanitizeData($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>
