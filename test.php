<?php
error_reporting(E_ALL);
$GLOBALS['dbc'] = $_SERVER['DOCUMENT_ROOT'].'/.htpasswd/db.php';
include($GLOBALS['dbc']);

$sql = "INSERT INTO fast_visitor ( visitorID, visitorDevice, visitorBrowser, visitorPlatform, browserInfo ) VALUES ('860658612868992','dfgfdgfd', 'fdgfdgfdg', 'dfgfdg','fdghdfg')";
$result = mysqli_query($db, $sql);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}else {
  echo "data added";
}

 ?>
