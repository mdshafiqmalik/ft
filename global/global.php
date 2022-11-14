<?php
function generateUniqueID($fields, $keyLength){
  $randomString = "";
  for ($x = 1; $x <= $keyLength; $x++) {
      $randomString .= random_int(0, 9);
  }
  $checkInDB = checkInDB($fields,$randomString);
  while ($checkInDB == true) {
    for ($x = 1; $x <= $keyLength; $x++) {
        $randomString = "";
        $randomString .= random_int(0, 9);
    }
    $checkInDB = checkInDB($fields,$randomString);
  }
  return $randomString;
}
function checkInDB($fields, $randomString){
$dbc = $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include($dbc);
$sql = "SELECT * FROM $fields[0]";
$result = mysqli_query($db, $sql);
$idExists = false;
while ($row = mysqli_fetch_assoc($result)) {
  if ($row["$fields[1]"] == $randomString) {
    $idExists = true;
    break;
  }else {
    $idExists = false;
  }
}
return $idExists;
}
function createOTP($keyLen){
   $key = "";
   for ($x = 1; $x <= $keyLen; $x++) {
       $key .= random_int(0, 9);
   }
   return $key;
}
function getIp(){
  $ip = $_SERVER['REMOTE_ADDR'];
  filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
  return $ip;
}
function getDeviceInfo(){
  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];
  }
  return $agent;
}
 ?>
