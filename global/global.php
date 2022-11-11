<?php
// last edited 10-11-2022 20:56
// generateUniqueID function create a random number i.e. 93479139632491634
// Takes two arguments fields and keyLength
// $keyLength: Lenght of ID i.e. 20
// $fields: It is an array contains ["table"] and ["row"] to check it is unique in a db
// need just random ID then call generateRandomID($keyLength);
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

// Checking in Database
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


// Function to create a randomID
function generateRandomID($keyLen){
   $key = "";
   for ($x = 1; $x <= $keyLen; $x++) {
       $key .= random_int(0, 9);
   }
   return $key;
}
 ?>

<?php
function createOTP($keyLen){
  // Set a blank variable to store the key in
   $key = "";
   for ($x = 1; $x <= $keyLen; $x++) {
       // Set each digit
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
