<?php
// last edited 10-11-2022 20:56
if (($_SERVER["HTTP_HOST"] == "www.fastreed.com")||($_SERVER["HTTP_HOST"] == "fastreed.com")) {
  $hostName = 'db5009716888.hosting-data.io';
  $dbName = 'dbs8237639';
  $userName = 'dbu633513';
  $passWord = 'TheLostIllusion@123';
}elseif ($_SERVER["HTTP_HOST"] == "localhost") {
  $hostName = 'localhost';
  $dbName = 'fastreed_db';
  $userName = 'root';
  $passWord = '';
}elseif ($_SERVER["HTTP_HOST"] == "192.168.43.172"){
  $hostName = 'localhost';
  $dbName = 'fastreed_db';
  $userName = 'root';
  $passWord = '';
}
$db = mysqli_connect("$hostName","$userName","$passWord","$dbName");
?>
