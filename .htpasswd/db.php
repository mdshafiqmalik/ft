<?php
// last edited 10-11-2022 20:56
if (($_SERVER["HTTP_HOST"] == "www.fastreed.com")||($_SERVER["HTTP_HOST"] == "fastreed.com")) {
  $hostName = 'db5010832350.hosting-data.io';
  $dbName = 'dbs9163368';
  $userName = 'dbu1298474';
  $passWord = 'Rajedit@5119';
}elseif ($_SERVER["HTTP_HOST"] == "localhost") {
  $hostName = 'localhost';
  $dbName = 'fastreed_db';
  $userName = 'root';
  $passWord = 'Malik@k90';
}elseif ($_SERVER["HTTP_HOST"] == "192.168.43.172"){
  $hostName = 'localhost';
  $dbName = 'fastreed_db';
  $userName = 'root';
  $passWord = '';
}
$db = mysqli_connect("$hostName","$userName","$passWord","$dbName");
?>
