<?php
include '../secrets/encDec.php';
include '../secrets/db.php';

// $sql2 = "SELECT loggedStatus FROM deviceManager WHERE deviceID = 'DID202212020000000'";
// $result2 = mysqli_query($db, $sql2);
// $row = $result2->fetch_assoc();

$sql = "SELECT deviceID,linkStatus FROM deviceManager WHERE deviceID = 'DID202212020000000'";
$result = mysqli_query($db, $sql);
$row = $result->fetch_assoc();
echo $row['deviceID'];
var_dump('DID202212020000000' === $row['deviceID'] );
echo "<br>";
echo $row['linkStatus'];
 ?>
