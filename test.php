<?php
include '../secrets/encDec.php';
include '../secrets/db.php';

$sql = "SELECT sessionID FROM users_register WHERE BINARY userName = 'MDSHAFIQ'";
$getSessionID = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($getSessionID);
echo $row['sessionID'];
?>
