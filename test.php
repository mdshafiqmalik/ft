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
include '../secrets/db.php';
$ID = "GID202212010000001";
$sql = "SELECT * FROM guests WHERE guestID = '$ID'";
$result = mysqli_query($db, $sql);
$row = $result->fetch_assoc()['tdate'];
$withOUTGID = ltrim($ID, 'GID');;
echo $withOUTGID;
 ?>
