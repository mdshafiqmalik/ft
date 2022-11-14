<?php
session_start();
// Admin login page
// Created By MOHD SHAFIQ MALIK
// Dated: 13, August 2022
if (isset($_POST['redirect'])) {
  $redirect = $_POST['redirect'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $password = $_POST['password'];
  $UsernameOrEMail = $_POST['usernameOrEMail'];
  $IDlen = (boolean)strlen($UsernameOrEMail);
  $plen = (boolean)strlen($password);
  $AdminIDSpace = preg_match('/\s/', $UsernameOrEMail);
  $passwordSpace = preg_match('/\s/', $password);
  include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
  // check if Admin ID is Empty
  if ($IDlen) {
    // check Admin ID have spaces
    if (!$AdminIDSpace) {
      $sanitizeUsername = sanitizeData($UsernameOrEMail);
      $usernameOrEMail = mysqli_real_escape_string($db,$sanitizeUsername);
      // check password is empty
      if ($plen) {
        // check password have spaces
        if (!$passwordSpace) {
          // Username Or Email Authentication/User Exist Or Not
          $sanPassword = sanitizeData($password);
          $mypassword = mysqli_real_escape_string($db,$sanPassword);
          $sql = "SELECT * FROM fast_admin WHERE BINARY adminUID = '$usernameOrEMail' OR adminMail = '$usernameOrEMail' OR adminPhone = '$usernameOrEMail'";
          $result = mysqli_query($db,$sql);
          // Check if user exist
          if ((boolean)mysqli_num_rows($result)) {
            // Password Verification
            $row = $result->fetch_assoc();
            $userHashPassword = $row['adminPassword'];
            $isPasswordCorrect = password_verify($sanPassword, $userHashPassword);
            if ($isPasswordCorrect) {
              $adminID = $row['adminID'];
              // create session id
              $sessionID = createLogin($adminID);
              $_SESSION['adminLoginID'] = $sessionID;
              header("Location: /admin$redirect");
            }else {
              header("Location: /admin/login/?message=Password Incorrect&IDfield=$usernameOrEMail");
              // Password is Incorrect (Go to Login)
            }
          }else {
            header("Location: /admin/login/?message=Admin Not Found");
            // User Not Exist with this email or username
            // Go to login
          }
        }else {
          // Password have spaces
          header("Location: /admin/login/?message=Spaces not allowed in password&IDfield=$usernameOrEMail");

        }
      }else {
        // Password is empty
        header("Location: /admin/login/?message=Please Enter Password&IDfield=$usernameOrEMail");

      }
    }else {
      // Admin Have spaces
      header("Location: /admin/login/?message=Spaces not allowed in ID");

    }
  }else {
    // Admin ID is empty
    header("Location: /admin/login/?message=Enter Email, ID or Phone");
  }
}else {
  header("Location: /admin/login/");
  // Post not Mentioned
  // Redirect to login
}

function sanitizeData($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Create login Data
function createLogin($adminID){
  $randLogID = random_str(32);
  $logDate = date('y-m-d H:i:s');
  $getDeviceInfo = $_SERVER['HTTP_USER_AGENT'];
  $getIP = getenv("REMOTE_ADDR");
  include $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
  $sql = "INSERT INTO admin_log_history (`loginID`,`adminID`,`loginDateTime`,`loginDevice`, `loginIP`,`status`) VALUES ('$randLogID','$adminID','$logDate','$getDeviceInfo', '$getIP', '1')";
  $result = mysqli_query($db, $sql);
  if ($result) {
    $loginCreated = $randLogID;
  }else {
    $loginCreated = false;
  }
  return $loginCreated;
}

function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}
 ?>
