<?php
// last edited 10-11-2022 20:56

function checkInDB(){
$dbc = $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
include($dbc);
$sql = "SELECT * FROM fast_visitor";
$result = mysqli_query($db, $sql);
$idExists = false;
while ($row = mysqli_fetch_assoc($result)) {
  if ($row["visitorID"] == "3543645643634") {
    $idExists = true;
    break;
  }else {
    $idExists = false;
  }
}
return $idExists;
}
checkInDB()
$cookieSet = setcookie('visitorID', "ghjh", time() + (86400 * 30), "/");
var_dump($cookieSet);

 ?>
