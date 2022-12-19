<?php

function checkOTPEd($inputValue, $dat){
  include($GLOBALS['dbc']);
  // get session ID
  $getSessionSql = "SELECT sessionID FROM users_register WHERE $dat = '".$inputValue."'";
  $getSessionID = mysqli_query($db, $getSessionSql);
  $row = mysqli_fetch_assoc($getSessionID);
  $sessionID = $row['sessionID'];

  // Check otp is sent or not
  $getOTP = "SELECT * FROM OTP WHERE sessionID = '$sessionID'";
  $getOTPResult = mysqli_query($db, $getOTP);
  if (mysqli_num_rows($getOTPResult)) {
    // Check OTP is expired ot Not
    $row = mysqli_fetch_assoc($getOTPResult);
    $otpTime = $row['sentTime'];
    $expiryTime = $otpTime + 120;//  minutes OTP Expiry
    if ($expiryTime < time()) {
      // DELETE DATA FROM OTP TABLE
      $deleteFromUsersRegisterSql = "DELETE FROM users_register WHERE sessionID = '$sessionID'";
      $deleteFromUsersRegister = mysqli_query($db, $deleteFromUsersRegisterSql);
      if ($deleteFromUsersRegister) {
        // DELETE DATA FROM OTP table
        $deleteFromOTPSql = "DELETE FROM OTP WHERE sessionID = '$sessionID'";
        $deleteFromOTP = mysqli_query($db, $deleteFromOTPSql);
        if ($deleteFromOTP) {
          // OTP expired and sucessfuly deleted
          $OTPed = true;
        }else {
          // OTP not expired
          $OTPed = false;
        }
      }else {
        // OTP not expired
        $OTPed = false;
      }
    }else {
      // OTP not expired
      $OTPed = false;
    }
  }else {
    // DELETE DATA FROM OTP TABLE
    $deleteFromUsersRegisterSql = "DELETE FROM users_register WHERE sessionID = '$sessionID'";
    $deleteFromUsersRegister = mysqli_query($db, $deleteFromUsersRegisterSql);
    if ($deleteFromUsersRegister) {
      // OTP expired and sucessfuly deleted
      $OTPed = true;
    }else {
      // OTP not expired
      $OTPed = false;
    }
  }
  return $OTPed;
}

 ?>
