<?php
header('content-type:application/json');
if (!isset($_SERVROOT)) {
  $_SERVROOT = '../../../../../';
}

$dbc = $_SERVROOT.'htdocs/secrets/db.php';
$cnf = $_SERVROOT.'htdocs/secrets/config.php';
include($dbc);
include($cnf);
if (isset($_SERVER['HTTP_REFERER'])) {
  $thisHttp = $_SERVER['HTTP_REFERER'];
  $url1 = "http://"."$domain"."/register/index.php";
  $url2 = "https://"."$domain"."/register/index.php";
  $url3 = "http://www"."$domain"."/register/index.php";
  $url4 = "https://www"."$domain"."/register/index.php";
  $url5 = "http://testing"."$domain"."/register/index.php";
  $url6 = "https://testing"."$domain"."/register/index.php";
  if ($thisHttp == $url1 || $thisHttp == $url2 || $thisHttp == $url3 || $thisHttp == $url4 || $thisHttp == $url5 || $thisHttp == $url6) {
      if (isset($_GET["username"])) {
        $inputValue = $_GET["username"];
        $userDataSql =  "SELECT * FROM users Where  BINARY userName = '".$inputValue."' ";
          if (mysqli_query($db, $userDataSql)) {
            $result = mysqli_query($db, $userDataSql);
            if (mysqli_num_rows($result)) {
              $found = array("Result"=>true, "Status"=>"Username Already Exist");
              $foundJSON = json_encode($found);
              echo "$foundJSON";
            }else {
              $notFound = array("Result"=>false, "Status"=>"Username Available");
              $notFoundJSON = json_encode($notFound);
              echo "$notFoundJSON";
            }
          }else {
            $cantRead = array("Status"=>"Cannot Access Database", "Result"=>true);
            $cantReadDecode = json_encode($cantRead);
            echo "$cantReadDecode";
          }
      }else if(isset($_GET["email"])) {
          $inputValue = $_GET["email"];
        $userDataSql =  "SELECT * FROM users Where userEmail = '".$inputValue."' ";
          if (mysqli_query($db, $userDataSql)) {
            $result = mysqli_query($db, $userDataSql);
            if (mysqli_num_rows($result)) {
              $found = array("Result"=>true, "Status"=>"Email Already Exist");
              $foundJSON = json_encode($found);
              echo "$foundJSON";
            }else {
              $notFound = array("Result"=>false,"Status"=>"Email Available");
              $notFoundJSON = json_encode($notFound);
              echo "$notFoundJSON";
            }
          }else {
            $cantRead = array("Status"=>"Cannot Access Database", "Result"=>true);
            $cantReadDecode = json_encode($cantRead);
            echo "$cantReadDecode";
          }
      }else {
          $cantRead = array("Status"=>"No arguments used", "Result"=>true);
          $cantReadDecode = json_encode($cantRead);
          echo "$cantReadDecode";
      }
    }else {
          $cantRead = array("Result"=>true, "Status"=>"Other Domain Used");
          $cantReadDecode = json_encode($cantRead);
          echo "$cantReadDecode";
    }
}else {
  $cantRead = array("Result"=>true, "Status"=>"Not a get request");
  $cantReadDecode = json_encode($cantRead);
  echo "$cantReadDecode";
}

 ?>
