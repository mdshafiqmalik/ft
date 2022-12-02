<?php
// date_default_timezone_set("asia/kolkata");
// $hrs = (int) date('h');
// $min = (int) date('i');
// $day = (int) date('d');
// $key = (int) $hrs*$min*$day;
// echo $key;
// // $ulen = (boolean) preg_match('/\s/', 'dfgfd dkg');
// // var_dump($ulen);
// function getCaptchaKey(){
//   include '.htHidden/s_keys/db.php';
//   $sql = "SELECT credKey FROM secretCredentials WHERE credKey = 'G_RECAPTCHA'";
//   $result = mysqli_query($db, $sql);
// }
include '../secrets/encDec.php';
include '../secrets/db.php';
// include '../secrets/encDec.php';



// i3T7pcU2Ip90pQYYpBsFkJgl ==  DID202212020000000
// i3T7pcU2Ip93pwwYpBsFkJgk == DID202211280000001


$sql = "SELECT deviceID FROM deviceManager WHERE deviceID = 'DI20221128g0001'";
$result = mysqli_query($db, $sql);
if ($result) {
  echo "true";
}else {
echo "false";
}
 ?>
