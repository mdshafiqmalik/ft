<?php
$GLOBALS['dbc'] =  parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH).'/.htpasswd/db.php';
include($GLOBALS['dbc']);
echo $hostName
// $sql = "INSERT INTO fast_visitor ( visitorID, visitorDevice, visitorBrowser, visitorPlatform, browserInfo ) VALUES ('860658612868992','Android', 'Mozilla', 'Desktop','Chrome')";
// $result = mysqli_query($db, $sql);
// if (!$result) {
//   die('Invalid query: ' . mysql_error());
// }else {
//   echo "data added";
// }
 ?>
