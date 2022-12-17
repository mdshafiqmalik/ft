<?php
 function generateOTP($y){
   $randOTP ="";
  for ($x = 1; $x <= $y; $x++) {
      // Set each digit
      $randOTP .= random_int(0, 9);
  }

  $OTP = "";
  include '../../secrets/db.php';
  $sql = "SELECT * FROM OTP WHERE OTP = '$randOTP'";
  $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result)) {
      generateOTP($x);
    }else {
      $OTP = $randOTP;
    }
    return $OTP;
}
 ?>
