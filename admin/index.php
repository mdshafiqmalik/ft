<?php
// last edited 10-11-2022 20:56
session_start();
$visits = $_SERVER['DOCUMENT_ROOT'].'/cookies/visits.php';
include($visits);
if (isset($_SESSION['adminLoginID'])) {
  if ($adminId = checkLogDetails($_SESSION['adminLoginID'])) {
    $adminDetails = getAdminDetails($adminId);
  }else {
    header("Location: login/");
  }
}else {
  header("Location: login/");
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/favicon.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Fastreed - Admin Console</title>
    <style media="screen">
    *{
      margin: 0;
      padding: 0;
    }
      body{
        display: flex;
        justify-content: center;
      }
      .mainCont{
        max-width: 500px;
        width: 100%;
        background-color: #00ced1;
        height: 100%;
        min-height: 100vh;
      }
    </style>
  </head>
  <body>
    <div class="mainCont">
      <a href="logout"> Logout</a>
    </div>
  </body>
</html>



<?php
function checkLogDetails($logID){
  include '../config/db_.php';
  $checkLoginID = "SELECT adminID FROM admin_log_history Where loginID = '$logID' AND status = '1'";
  $userDat = mysqli_query($db, $checkLoginID);
  if (mysqli_num_rows($userDat)) {
      $row = $userDat->fetch_assoc();
      $exist = $row['adminID'];
  }else {
    unset($_SESSION['adminLoginID']);
    $exist = false;
  }
  return $exist;
}

function getAdminDetails($adminId){
  include '../config/db_.php';
  $sql = "SELECT * FROM fast_admin WHERE adminID = '$adminId'";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result)) {
    $row = $result->fetch_assoc();
    $data = $row;
  }else {
    $data = "no user found";
  }
  return $data;
}
 ?>
