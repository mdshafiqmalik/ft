<?php
// Call = createNewID("table_name")
function createNewID($table){
  $dbc = '../secrets/db.php';
  include($dbc);
  $date = date('Y-m-d');
  $year = date('Y');
  $month = date('m');
  $day = date('d');
  $newID = $year.$month.$day;
  $sql = "SELECT * FROM $table WHERE tdate ='$date'";
  $result = mysqli_query($db, $sql);
  $x =  mysqli_num_rows($result);
  $noOfRow = realNum($x);
  if ($noOfRow < 100) {
    $newID .= '00000'.$noOfRow;
  }elseif ($noOfRow < 1000) {
    $newID .= '0000'.$noOfRow;
  }elseif ($noOfRow < 10000) {
    $newID .= '000'.$noOfRow;
  }elseif ($noOfRow < 100000) {
    $newID .= '00'.$noOfRow;
  }elseif ($noOfRow < 1000000) {
    $newID .= '0'.$noOfRow;
  }elseif ($noOfRow < 10000000) {
    $newID .= $noOfRow;
  }
  return $newID;
}

function realNum($x){
  if ($x < 10) {
    $y = '0'.$x;
  }else {
    $y = $x;
  }
  return $y;
}
 ?>
