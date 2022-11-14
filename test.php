<?php
  error_reporting(E_ALL);
  $GLOBALS['dbc'] = $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
  include($GLOBALS['dbc']);
  $sql2 = "INSERT INTO fast_sessions (sessionID, visitorIP, visitorID, sessionVisits) VALUES ('8687890978654532456754','199.89.45.234','3454352765756476574','{}')";
  mysqli_query($db, $sql2);
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <a href="/"> dsgfdgf</a>
  </body>
</html>
