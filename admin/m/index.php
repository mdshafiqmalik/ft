<?php
session_start();
$visits = $_SERVER['DOCUMENT_ROOT'].'/cookies/visits.php';
include($visits);
if (isset($_GET['message'])) {
  $m = $_GET['message'];
}else {
  $m= '';
}
if (isset($_SESSION['adminLoginID'])) {
  if ($adminId = checkLogDetails($_SESSION['adminLoginID'])) {
    $adminDetails = getAdminDetails($adminId);
    // var_dump($adminDetails);
  }else {
    header("Location: ../login/?redirect=/m&$m");
  }
}else {
  header("Location: ../login/?redirect=/m&$m");
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="/favicon.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style.css">
    <meta name="robots" content="noindex">
    <title>Fastreed - Admin Console</title>
  </head>
  <body>
    <div class="mainCont">
      <a href="../logout/?redirect=m/&message=Sucessfully Logged Out"> Logout</a>
    </div>
  </body>
</html>



<?php
function checkLogDetails($logID){
  include '../../config/db_.php';
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
  include '../../config/db_.php';
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
